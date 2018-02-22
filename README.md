# Lyrics of worship songs in Hungarian

# Magyar nyelvű Istent dicsőítő énekek szövegeinek gyűjteménye

Ebben a repoban gyűjtjük össze a gyülekezeteinkben és rendezvényeinken énekelt énekek
szövegeit OpenLyrics xml formátumban. Az eddig összegyűjtött énekszövegek listája a
[Tartalomjegyzékben](https://github.com/sdahun/songs/blob/master/Contents.md) tekinthető meg.

Az OpenLyrics formátumot a legelterjedtebb énekvetítő programok képesek importálni,
de az /utils mappában található átalakító program segítségével az énekszövegek megjelenítése
testre is szabható. Az átalakító program php nyelven íródott, így minden operációs rendszer
alatt futtatható (a php telepítése után).

# Támogatott szoftverek (tervezet)
Az énekek az itt felsorolt szoftverek számára lesznek átalakíthatóak:
* [OpenLP](https://openlp.org) - ingyenes, nyílt forrású gyülekezeti dicsőítés vetítő szoftver
* [Quelea](https://quelea.org) - ingyenes gyülekezeti vetítő szoftver
* [FreeWorship](https://www.freeworship.org.uk/) - ingyenes, hatékony gyülekezeti vetítő szoftver
* [EasyWorship](https://www.easyworship.com/) - egy hatékony, mégis egyszerű gyülekezeti vetítő szoftver (nem ingyenes)
* [PowerPoint](https://products.office.com/hu-hu/powerpoint) - diabemutató szofver

Az átalakítás a következő paranccsal végezhető el:
```
> php utils/compile.php
```
Az átalakítás megkezdése előtt testre kell szabni a végeredményt:
* Legyen-e nyitó dia, amin megjelenik az ének címe/kezdete?
  * A nyitó dián szerepeljen-e az elsődleges énekeskönyv neve?
  * A nyitó dián szerepeljen-e az ének elsődleges énekeskönyvbeli száma?
* Az énekszöveg soronként új sorba kerüljön, vagy sorfolytonosan automatikus tördelésű legyen?
  * Ha a sorok új sorba kerülnek, legyen-e nagybetűsítve minden sor első betűje?
  * Ha sorfolytonos legyen, akkor legyen-e elválasztó perjel (/) a sorok között?
* Az ismétlődő diák csak egyszer, az első előfordulásokkor jelenjenek meg, vagy az összes előforduláskor ismétlődjenek?
* Legyen-e utolsó utáni üres dia?
  * Szerepeljen-e ezen a dián az elsődleges énekeskönyv rövidítése és az ének száma (keresési célból)?
* Az összes énekeskönyvet át kell alakítani, vagy csak a kiválasztott(ak)at?
* A végeredmény egy, vagy több fájlba tördelve kerüjön átalakításra?

A megadott beállítások mentésre kerülnek a /compilations/compile.settings.ini fájlba, így az énekek frissítése esetén a beállítások újra felhasználhatók lesznek egy újabb átalakításhoz.
Az elkészült, átalakított fájlok a /compilations mappába kerülnek.

# Automatikus és kézi ellenőrzések
Új énekszöveg beküldése előtt kérlek futtasd le az automatikus szövegellenőrzőket az alábbi módon:
```
> php utils/validate.php
```
Az automatikus ellenőrzők jelenleg az alábbi feladatokat végzik el:
1. Az énekszöveget tartalmazó xml fájl megfelel-e az OpenLyrics xml formátumnak
2. Szótagszám ellenőrzés az azonos típusú versszakok soraiban
3. Annak ellenőrzése, hogy minden versszak szerepel-e legalább egyszer a versszaksorrendben és a versszaksorrendben szereplő versszakok léteznek-e

# Linkek
* [Adventista technikusok fóruma](http://technika.adventista.hu)
* [OpenLyrics](http://openlyrics.org) - egy ingyenes, nyílt XML sztenderd formátum keresztény dicsőítő énekekhez
