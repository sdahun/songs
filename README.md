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

A gyűjteményben szereplő énekeskönyvek feldolgozottsága és beszerzési lehetőségeinek linkjei:

| Énekeskönyv | Feldolgozottság |
| ----------- | --------------- |
| [Adj zengő éneket!](https://regi.reformatus.hu/mutat/adj-zengo-neket/) | <meter value="150" max="150" optimum="150" low="45" high="105"></meter> 100% (150/150) |
| [Baptista gyülekezeti énekeskönyv](https://www.baptistawebshop.hu/shop--p443) | <meter value="10" max="560" optimum="560" low="168" high="392"></meter> 1% (10/560) |
| [Dicsérem Neved 1](https://yfc.hu/bolt/) | <meter value="19" max="224" optimum="224" low="67" high="156"></meter> 8% (19/224) |
| [Dicsérem Neved 2](https://yfc.hu/bolt/) | <meter value="48" max="230" optimum="230" low="69" high="161"></meter> 20% (48/230) |
| [Dicsérem Neved 3](https://yfc.hu/bolt/) | <meter value="10" max="200" optimum="200" low="60" high="140"></meter> 5% (10/200) |
| [Dicsérem Neved 4](https://yfc.hu/bolt/) | <meter value="5" max="222" optimum="222" low="66" high="155"></meter> 2% (5/222) |
| [Dicsérem Neved 5](https://yfc.hu/bolt/) | <meter value="6" max="225" optimum="225" low="67" high="157"></meter> 2% (6/225) |
| [Dicsérjük Istent](https://zene.adventista.hu/enekeskonyv/dicserjuk-istent-probaenekeskonyv) | <meter value="5" max="145" optimum="145" low="43" high="101"></meter> 3% (5/145) |
| [Dúrkönyv](https://durkonyv.hu/) | <meter value="1" max="191" optimum="191" low="57" high="133"></meter> 0% (1/191) |
| [Erőm és énekem az Úr](http://www.harmat.hu/uzlet/erom-es-enekem-az-ur) | <meter value="72" max="143" optimum="143" low="42" high="100"></meter> 50% (72/143) |
| [Hitünk énekei](https://adventkiado.hu) | <meter value="477" max="477" optimum="477" low="143" high="333"></meter> 100% (477/477) |
| [Hozsánna énekes](https://adventista.hu) | <meter value="219" max="219" optimum="219" low="65" high="153"></meter> 100% (219/219) |
| [Szent András énekfüzet](https://enekfuzet.ujevangelizacio.hu) | <meter value="1" max="340" optimum="340" low="102" high="237"></meter> 0% (1/340) |
| [Szent az Úr](https://adventista.hu) | <meter value="40" max="40" optimum="40" low="12" high="28"></meter> 100% (40/40) |
| [Üdv- és adventi énekek](https://yfc.hu/bolt/) | <meter value="47" max="512" optimum="512" low="153" high="358"></meter> 9% (47/512) |
| [Zuglói énekek](https://github.com/sdahun/songs) | <meter value="70" max="100" optimum="100" low="30" high="70"></meter> 70% (70/100) |

A gyűjteményben jelenleg 1180 darab ének található.

# Támogatott szoftverek
Az énekszöveg átalakító az alábbi szoftverek számára készít importálható fájlformátumokat:
* [OpenLP](https://openlp.org) - ingyenes, nyílt forrású gyülekezeti dicsőítés vetítő szoftver
* [FreeShow](https://freeshow.app) - ingyenes, nyílt forrású gyülekezeti vetítő szoftver
* [Quelea](https://quelea.org/) - ingyenes, nyílt forrású gyülekezeti vetító szoftver
* [EasyWorship](https://www.easyworship.com/) - egy hatékony, mégis egyszerű gyülekezeti vetítő szoftver (nem ingyenes)
* [PowerPoint](https://products.office.com/hu-hu/powerpoint) - diabemutató szofver

# Linkek
* [OpenLyrics](http://openlyrics.org) - egy ingyenes, nyílt XML sztenderd formátum
  keresztény dicsőítő énekekhez
