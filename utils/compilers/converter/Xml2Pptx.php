<?php

namespace sdahun\songs\converter;

use \Exception;
use \SimpleXmlElement;
use \sdahun\songs\converter\General;
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\DocumentLayout;
use PhpOffice\PhpPresentation\Slide\Background\Color as BackgroundColor;
use PhpOffice\PhpPresentation\Slide\Transition;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Style\Border;
use PhpOffice\PhpPresentation\Style\Color as StyleColor;
use PhpOffice\PhpPresentation\Style\Fill;
use PhpOffice\phpPresentation\Shape\RichText;
use PhpOffice\PhpPresentation\IOFactory;

class Xml2Pptx {
    static public function convert($xmlsrc) {
        $autofitFont =   [  8 => null,  9 => null, 10 => 92.5, 11 => 92.5,
                           12 => 85,   13 => 77.5, 14 => 70,   15 => 62.5, ];

        $autofitSpcRed = [  8 => null,  9 => 10,   10 => 20,   11 => 20,
                           12 => 20,   13 => 20,   14 => 20,   15 => 20,   ];

        $xml = new SimpleXmlElement($xmlsrc);
        $title = $xml->properties->titles->title[0]->__toString();

        $ppt = new PhpPresentation();
        $layout = $ppt->getLayout();

        $ppt->getDocumentProperties()->setCreator('sdahun')
            ->setLastModifiedBy('zuglogyuli')
            ->setTitle($title);
        
        $ppt->getLayout()->setDocumentLayout(DocumentLayout::LAYOUT_SCREEN_16X9);
        
        for ($slideId = 0; $slideId < count($xml->lyrics->verse); $slideId++) {
            $verse = $xml->lyrics->verse[$slideId];
            $verseName = $verse['name']->__toString();
            $verseName = self::getVerseName (substr ($verseName, 0, 1)) . ' ' . substr ($verseName, 1);
            $lyrics = str_replace('<br/>', "\n", General::getInnerXml($verse->lines->asXml()));
            $lines = count(explode("\n", $lyrics));
            if ($lines <  8) $lines = 8;
            if ($lines > 15) $lines = 15;
        
            if ($slideId == 0)
                $slide = $ppt->getActiveSlide();
            else
                $slide = $ppt->createSlide();

            $oBkgColor = new BackgroundColor();
            $oBkgColor->setColor(new StyleColor());
            $slide->setBackground($oBkgColor);
                
            $oTransition = new Transition();
            $oTransition
                ->setTransitionType(Transition::TRANSITION_FADE)
                ->setSpeed(Transition::SPEED_SLOW);
            $slide->setTransition($oTransition);

            $shape = $slide->createRichTextShape()
                ->setOffsetX(0)
                ->setOffsetY(0)
                ->setWidth(960)
                ->setHeight(540)
                ->setAutoFit(RichText::AUTOFIT_NORMAL, $autofitFont[$lines], $autofitSpcRed[$lines]);
        
            $shape->getActiveParagraph()->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER);
        
            $shape->getFill()
                ->setFillType(Fill::FILL_GRADIENT_LINEAR)
                ->setRotation(90)
                ->setStartColor(new StyleColor('FF002060'))
                ->setEndColor(new StyleColor());
        
            $textRun = $shape->createTextRun($lyrics);
            $textRun->setLanguage('hu-HU');
        
            $textRun->getFont()
                ->setName('Tahoma')
                ->setBold(true)
                ->setSize(40)
                ->setColor(new StyleColor(StyleColor::COLOR_WHITE));

            $note = $slide->getNote();
            $shape = $note->createRichTextShape();
            $textRun = $shape->createTextRun ($verseName);
            $textRun->setLanguage('hu-HU');
        }

        // Save file
        $xmlWriter = IOFactory::createWriter($ppt, 'PowerPoint2007');
        $fname = tempnam('', 'ppt');
        $xmlWriter->save($fname);
        $result = file_get_contents($fname);
        unlink($fname);
        
        return $result;
    }

    private static function getVerseName($name) {
        switch ($name) {
            case 'v': return 'Verse';
            case 'c': return 'Chorus';
            case 'p': return 'Pre-Chorus';
            case 'b': return 'Bridge';
            case 'e': return 'End';
            case 'o': return 'Slide';
            case 't': return 'Tag';
            case 'i': return 'Intro';
            default: throw new Exception('Please add more type: "' . $name . '" !');
        }
    }

}
