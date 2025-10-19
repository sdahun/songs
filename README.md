# Lyrics of worship songs in Hungarian language

# Magyar nyelvű dicsőítő énekek szöveggyűjteménye énekvetítéshez

Itt gyűjtjük össze a gyülekezeteinkben és rendezvényeinken énekelt énekek
szövegeit OpenLyrics xml formátumban. Az eddig összegyűjtött énekszövegek
listája az [Énekek tartalomjegyzékében](./Contents.md) tekinthető meg, az
énekeskönyvek tárgymutatói pedig a [Tárgymutatóban](./docs/index/README.md)
olvashatók.

Azért választottuk ezt a felületet az énekszövegek gyűjtésére, mert a
verziókezelésnek köszönhetően mindenki követni tudja azt, hogy az utolsó
frissítése óta milyen új énekszövegek kerültek a gyűjteménybe és mely énekek
szövegében történtek hibajavítások.
A verziókezelés segítségével mindenki naprakészen tarthatja a saját
énekgyűjteményét és a változások az énekszöveg átalakító program segítségével
gyorsan átvezethetők az énekvetítő programokba.

Habár az /src/main/resources mappában található, énekszövegeket tartalmazó
fájlokat a legelterjedtebb énekvetítő programok képesek közvetlenül importálni
(az OpenLyrics xml formátum miatt), ennek ellenére azt javasoljuk, hogy a
transform.jar énekszöveg átalakító program segítségével készítsd el a számotokra
megfelelő szövegváltozatot. Az énekszöveg átalakító java nyelven íródott,
így minden operációs rendszeren futtatható.

Az énekszöveg átalakító transform.jar fájlja a [Releases](http://github.com/sdahun/songs/releases)
linkről tölthető le.

Az énekszöveg átalakító használatáról részletesen a [Használati utasításban](./docs/Usage.md)
lehet olvasni.

# Énekeskönyvek

A gyűjteményben szereplő énekeskönyvek feldolgozottsága és beszerzési lehetőségeinek
linkjei:

| Énekeskönyv | Feldolgozottság |
| ----------- | --------------- |
| [Adj zengő éneket!](http://www.kalvinkiado.hu/index.php?page=shop.product_details&flypage=flypage.tpl&product_id=988&category_id=43&option=com_virtuemart&Itemid=3&lang=hu) | ![Feldolgozottság](https://progress-bar.xyz/100) (150/150) |
| [Baptista gyülekezeti énekeskönyv](http://www.konyvesbolt.baptist.hu) | ![Feldolgozottság](https://progress-bar.xyz/2) (9/560) |
| [Dicsérem Neved 1.](http://dicseremneved.hu) | ![Feldolgozottság](https://progress-bar.xyz/4) (8/224) |
| [Dicsérem Neved 2.](http://dicseremneved.hu) | ![Feldolgozottság](https://progress-bar.xyz/18) (41/230) |
| [Dicsérem Neved 3.](http://dicseremneved.hu) | ![Feldolgozottság](https://progress-bar.xyz/1) (2/200) |
| [Dicsérem Neved 4.](http://dicseremneved.hu) | ![Feldolgozottság](https://progress-bar.xyz/1) (2/222) |
| [Dicsérem Neved 5.](http://dicseremneved.hu) | ![Feldolgozottság](https://progress-bar.xyz/2) (5/225) |
| [Erőm és énekem az Úr](http://www.harmat.hu/uzlet/erom-es-enekem-az-ur) | ![Feldolgozottság](https://progress-bar.xyz/50) (72/143) |
| [Hitünk énekei](http://adventkiado.hu) | ![Feldolgozottság](https://progress-bar.xyz/100) (477/477) |
| [Hozsánna énekes](http://adventista.hu) | ![Feldolgozottság](https://progress-bar.xyz/100) (219/219) |
| [Szent az Úr](http://adventista.hu) | ![Feldolgozottság](https://progress-bar.xyz/100) (40/40) |
| [Üdv- és Adventi Énekek](https://www.antikvarium.hu/konyv/udv-es-adventi-enekek-473997) | ![Feldolgozottság](https://progress-bar.xyz/9) (45/512) |
| [Zuglói Adventista Gyülekezeti Énekeskönyv](https://zuglo.adventista.hu/) | ![Feldolgozottság](https://progress-bar.xyz/13) (25/199) |

A gyűjteményben jelenleg 1095 darab ének található.

# Támogatott szoftverek
Az énekszöveg átalakító az alábbi szoftverek számára készít importálható fájlformátumokat:
* [OpenLP](https://openlp.org) - ingyenes, nyílt forrású gyülekezeti dicsőítés vetítő szoftver
* [FreeShow](https://freeshow.app) - ingyenes, nyílt forrású gyülekezeti vetítő szoftver
* [EasyWorship](https://www.easyworship.com/) - egy hatékony, mégis egyszerű gyülekezeti vetítő szoftver (nem ingyenes)
* [PowerPoint](https://products.office.com/hu-hu/powerpoint) - diabemutató szofver

# Linkek
* [OpenLyrics](http://openlyrics.org) - egy ingyenes, nyílt XML sztenderd formátum
  keresztény dicsőítő énekekhez
