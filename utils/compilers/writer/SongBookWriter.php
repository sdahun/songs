<?php

namespace sdahun\songs\writer;

use \SimpleXmlElement;
use \sdahun\songs\Preferences;
use \PhpOffice\PhpWord\PhpWord;
use \PhpOffice\PhpWord\Shared\Converter;
use \PhpOffice\PhpWord\Element\Footer;
use \sdahun\songs\converter\General;
use \sdahun\songs\converter\Xml2Txt;
use \sdahun\songs\converter\XmlConfigurator;

class SongBookWriter extends AbstractWriter {

    private $doc;
    private $toc_section;
    private $txt_section;
    private $file_counter;

    private $style;

    public function __construct(Preferences $prefs) {
        parent::__construct($prefs);
        $this->file_extension = '.docx';

        $this->style = [
            'font' => [
                'm9' => ['name' => 'Minion Pro', 'size' => 9],
                'm24' => ['name' => 'Minion Pro', 'size' => 24],
                'italic' => ['italic' => true],
            ],
            'align' => [
                'center' => ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER],
                'right' => ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END],
                'justify' => ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH],
            ],
            'border' => [
                'bottom' => ['borderBottomSize' => 4],
            ],
            'indent' => [
                'i04' => ['indentation' => array('firstLine' => Converter::cmToTwip(0.4))]
            ],
            'tab' => [
                'right7' => ['tabs' => [new \PhpOffice\PhpWord\Style\Tab('right', Converter::cmToTwip(7), 'dot'),],],
            ]
        ];
  
        $this->startNewOutput();
    }

    public static function getWriterName() {
        return 'Word énekeskönyvfájl';
    }

    private function startNewOutput() {
        $this->file_counter = 0;

        $this->doc = new PhpWord();

        $this->doc->getSettings()->setThemeFontLang(new \PhpOffice\PhpWord\Style\Language('hu-HU'));
        $this->doc->getSettings()->setEvenAndOddHeaders(true);
        $this->doc->setDefaultFontName('Minion Pro');
        $this->doc->setDefaultFontSize(9);

        $this->toc_section = $this->doc->addSection();

        $this->toc_section->getStyle()
            ->setPageSizeW(Converter::cmToTwip(10))
            ->setPageSizeH(Converter::cmToTwip(17))
            ->setMarginTop(Converter::cmToTwip(1.5))
            ->setMarginLeft(Converter::cmToTwip(1.5))
            ->setMarginRight(Converter::cmToTwip(1.5))
            ->setMarginBottom(Converter::cmToTwip(1.5))
        ;

        $this->toc_section->addTextBreak(8, $this->style['font']['m24']);
        $this->toc_section->addText("Zuglói", $this->style['font']['m24']);
        $this->toc_section->addText("Adventista", $this->style['font']['m24']);
        $this->toc_section->addText("Gyülekezeti", $this->style['font']['m24']);
        $this->toc_section->addText("Énekeskönyv", $this->style['font']['m24']);

        $this->toc_section->addPageBreak();
        $this->toc_section->addText("TARTALOMMUTATÓ", null, $this->style['align']['center']);
        $this->toc_section->addTextBreak(1, null, $this->style['align']['center']);


        $this->txt_section = $this->doc->addSection();
        $this->txt_section->setBreakType("nextPage");
        $oddHeader = $this->txt_section->addHeader(Footer::AUTO);
        $evenHeader = $this->txt_section->addHeader(Footer::EVEN);

        $oddHeader->addText('Zuglói Adventista Gyülekezeti Énekeskönyv', null, array_merge($this->style['align']['right'], $this->style['border']['bottom']));
        $oddHeader->addTextBreak(1, null, $this->style['align']['right']);

        $evenHeader->addText('Zuglói Adventista Gyülekezeti Énekeskönyv', null, $this->style['border']['bottom']);
        $evenHeader->addTextBreak(1);

        $this->txt_section->getStyle()
            ->setPageSizeW(Converter::cmToTwip(10))
            ->setPageSizeH(Converter::cmToTwip(17))
            ->setMarginTop(Converter::cmToTwip(1.5))
            ->setMarginLeft(Converter::cmToTwip(1.5))
            ->setMarginRight(Converter::cmToTwip(1.5))
            ->setMarginBottom(Converter::cmToTwip(1.5))
        ;
    }

    public function close() {
        $this->toc_section->addTextBreak();

        $path = $this->prefs->get('dest_dir');
        $fname = $this->getNextFile();
        $this->doc->save($path . '/' . $fname);

        echo("  Az énekeskönyv a következő fájlba került:\n    /" . basename($path) . '/' . $fname . "\n");
    }

    public function addSongFile($xml_path) {
        if (file_exists($xml_path)) {
            ++$this->file_counter;
            $batch_size = $this->prefs->get('batch_size');
            if ($batch_size > 0)
                if ($this->file_counter > $this->prefs->get('batch_size')) {
                    $this->close();
                    $this->startNewOutput();
                }

            $xml = new SimpleXmlElement(XmlConfigurator::configure (file_get_contents ($xml_path), $this->prefs));

            $title = $xml->properties->titles->title[0]->__toString();
            $bookmark = 'B' . sprintf('%03d', $this->file_counter);

            $this->toc_section->addLink(
                $bookmark,
                $title . " \t " . $this->file_counter,
                null,
                $this->style['tab']['right7'],
                true
            );

            $this->txt_section->addTextBreak();
            $this->txt_section->addBookmark($bookmark);
            $this->txt_section->addText($this->file_counter.".", null, $this->style['align']['center']);


            $verseNumber = 1;
            foreach ($xml->lyrics->verse as $verse) {
                $this->txt_section->addText(
                    $verseNumber . '. '.
                    str_replace('<br/>', "\r\n", General::getInnerXml($verse->lines->asXml())),
                    null,
                    array_merge(
                        $this->style['indent']['i04'],
                        $this->style['align']['justify']
                    )
                );
                $verseNumber++;
            }
    
            if (isset($xml->properties->authors))
            foreach ($xml->properties->authors->author as $authorObj) {
                if ($authorObj['type']->__toString() == 'words')
                    $this->txt_section->addText(
                        $authorObj->__toString(),
                        $this->style['font']['italic'],
                        $this->style['align']['right']
                    );
            }
    
    /*            
            $this->zip->addFromString (
                basename (dirname ($xml_path)) . '/' . basename ($xml_path, '.xml') . '.txt',
                Xml2Txt::convert (XmlConfigurator::configure (file_get_contents ($xml_path), $this->prefs))
            );
*/
        }
    }
}
