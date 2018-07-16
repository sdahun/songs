# Lyrics of worship songs in Hungarian

# Magyar nyelvű, Istent dicsőítő énekek szövegeinek gyűjteménye

Itt gyűjtjük össze a gyülekezeteinkben és rendezvényeinken énekelt énekek
szövegeit OpenLyrics xml formátumban. Az eddig összegyűjtött énekszövegek listája az
[Énekek tartalomjegyzékében](./Contents.md) tekinthető meg, az énekeskönyvek tárgymutatói
pedig a [Tárgymutatóban](./docs/index/README.md) olvashatók.

Azért választottuk ezt a felületet az énekszövegek gyűjtésére, mert a verziókezelésnek
köszönhetően mindenki követni tudja azt, hogy az utolsó frissítése óta milyen új énekszövegek
kerültek a gyűjteménybe és mely énekek szövegében történtek hibajavítások.
A verziókezelés segítségével mindenki naprakészen tarthatja a saját énekgyűjteményét és a
változások az énekszöveg átalakító program segítségével gyorsan átvezethetők az énekvetítő programokba.

Habár a /collections mappában található, énekszövegeket tartalmazó fájlokat a legelterjedtebb
énekvetítő programok képesek közvetlenül importálni (az OpenLyrics xml formátum miatt),
ennek ellenére azt javasoljuk, hogy az /utils mappában található, compile.php nevű énekszöveg
átalakító program segítségével készítsd el a számotokra megfelelő szövegváltozatot.
Az énekszöveg átalakító PHP nyelven íródott, így minden operációs rendszeren futtatható (a PHP telepítése után).

Az énekszöveg átalakító használatához szükséges telepítési lépések a
[Telepítési dokumentációban](./docs/Install.md) találhatók.

Az énekszöveg átalakító használatáról részletesen a [Használati utasításban](./docs/Usage.md) lehet olvasni.

# Énekeskönyvek

A gyűjteményben szereplő énekeskönyvek feldolgozottsága és beszerzési lehetőségeinek linkjei:
* [Adj zengő éneket!](http://www.kalvinkiado.hu/index.php?page=shop.product_details&flypage=flypage.tpl&product_id=988&category_id=43&option=com_virtuemart&Itemid=3&lang=hu) ![Feldolgozottság](http://progressed.io/bar/77) (115/150)
* [Baptista gyülekezeti énekeskönyv](http://www.konyvesbolt.baptist.hu/) ![Feldolgozottság](http://progressed.io/bar/1) (6/559)
* [Dicsérem neved 1.](http://dicseremneved.hu/) ![Feldolgozottság](http://progressed.io/bar/1) (3/224)
* [Dicsérem neved 2.](http://dicseremneved.hu/)
* [Dicsérem neved 3.](http://dicseremneved.hu/)
* [Dicsérem neved 4.](http://dicseremneved.hu/)
* [Dicsérem neved 5.](http://dicseremneved.hu/)
* [Erőm és énekem az Úr](http://www.harmat.hu/uzlet/erom-es-enekem-az-ur/)
* [Hitünk énekei](http://adventkiado.hu/)
* [Hozsánna énekes](http://adventista.hu/)
* [Szent az Úr](http://adventista.hu/)

# Támogatott szoftverek
Az énekszöveg átalakító az alábbi szoftverek számára készít importálható fájlformátumokat:
* [OpenLP](https://openlp.org) - ingyenes, nyílt forrású gyülekezeti dicsőítés vetítő szoftver
* [Quelea](https://quelea.org) - ingyenes gyülekezeti vetítő szoftver
* [EasyWorship](https://www.easyworship.com/) - egy hatékony, mégis egyszerű gyülekezeti vetítő szoftver (nem ingyenes)
* [PowerPoint](https://products.office.com/hu-hu/powerpoint) - diabemutató szofver

Az, hogy egyes szoftvereket miért nem támogatunk, a [nem támogatott szoftverek](./docs/NotSupported.md) oldalon van leírva.

# Közreműködés

Ha szeretnél közreműködni a gyűjtemény bővítésében/javításában, akkor az Adventista technikusok fórumában várjuk a jelentkezésed, valamint a github-on is szívesen fogadjuk a hibajegyeket és a pull request-eket is.
A közreműködők támogtására készült néhány automatikus és manuális ellenőrzést segítő program, amelyről részletesen
a [Közreműködőknek](./docs/Contribute.md) szánt oldalon lehet olvasni.

# Énekszövegek Android telefonra

Az itt található legfrissebb énekszöveg változatok nem egyszerűen, de belevarázsolhatók a Hitünk Énekei nevű Google Play alkalmazásba. Ennek a [lépésenkénti leírása](./docs/Android.md) a linkre kattintva olvasható.

# Linkek
* [Adventista technikusok fóruma](http://technika.adventista.hu)
* [OpenLyrics](http://openlyrics.org) - egy ingyenes, nyílt XML sztenderd formátum keresztény dicsőítő énekekhez
