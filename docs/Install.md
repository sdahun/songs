# Telepítés

Az énekszöveg átalakító PHP nyelven íródott, így - ha még nincs a gépre telepítve - telepíteni kell a PHP futtatókörnyezetet. A PHP telepítése után telepíteni és engedélyezni kell a PHP szükséges
beépülő moduljait. Ezt követően telepíteni kell azokat a külső programkönyvtárakat, amelyeket az
átalakító program használ és ez után lehet használatba venni az énekszöveg átalakító programot.
A lépések a következők:
1. A PHP és moduljainak telepítése, beállítása
2. Az énekgyűjtemény letöltése
3. A kiegészítő programkönyvtárak telepítése

## 1. A PHP és moduljainak telepítése, beállítása
Mivel a PHP futtatókörnyezetet minden operációs rendszer alatt másképp kell telepíteni, beállítani,
ezért ez a lépés rendszerenként külön-külön kerül ismertetésre.

### 1.1 A PHP telepítése Windows alatt
A PHP Windows alatt használható verziója a http://windows.php.net/download/ címről tölthető le.
A weboldalt megnyitva ki kell választani a letöltendő fájlt:
- VC15 x64 Non Thread Safe - Zip: ezt a változatot 64 bites windows esetén kell használni
- VC15 x86 Non Thread Safe - Zip: ez a változat 32 bites windows esetén lesz megfelelő

A zip fájl tartalmát letöltés után ki kell csomagolni egy mappába (Pl.: C:\PHP).

Ahhoz, hogy a PHP kényelmesen használható legyen, célszerű beállítani a PATH környezeti változóba
azt a mappát, ahova a PHP-t kicsomagoltuk. (Windows 10 alatt: Keresés: A rendszer környezeti változóinak
módosítása -> Környezeti változók... nyomógomb -> Felhasználói változók -> Path duplaklikk -> Tallózás... -> OK)

A következő teendő, hogy a kicsomagolt mappában található php.ini-production fájlt át kell
másolni ugyanabba a mappába, php.ini névre.
`C:\PHP>copy php.ini-production php.ini`

Ezt követően a php.ini fájlt meg kell nyitni szerkesztésre a jegyzettömb alkalmazással, majd
a következő sorok elejéről törölni kell a pontosvesszőt és úgy elmenteni:
```
extension_dir = "ext"
extension=mbstring
extension=openssl
```

### 1.2 A PHP telepítése Debian Linux alatt
A PHP megtalálható a Debian csomagkönyvtáraiban, így a csomagkezelővel egyszerűen telepíthető.
Terminálból az alábbi paranccsal végezethő el a telepítés:
`apt-get install php-cli php-mbstring`

### 1.3 A PHP telepítése MacOS High Sierra alatt
MacOS alatt nincs telepítési teendő, az operációs rendszerben alapértelmezetten telepítve van a PHP.

## 2. Az énekgyűjtemény letöltése
Az énekgyűjtemény legfrissebb és legaktuálisabb változata az átalakító programmal együtt a
https://github.com/sdahun/songs oldalon a zöld színű "Clone or download" nyomógomb megnyomása
után a "Download ZIP" linkre kattintva tölthető le.
A letöltött fájlt ki kell csomagolni egy tetszőleges mappába.

## 3. A kiegészítő programkönyvtárak telepítése
Meg kell nyitni a parancssort (linux, mac alatt: terminal), majd abba a mappába kell lépni,
ahova kicsomagoltuk az énekgyűjteményt:
`>cd songs-master`

Itt ki kell adnunk a következő parancsot a kiegészítő programkönyvtárak telepítéséhez:
`>php utils/composer.phar install`

Ha ez a parancs lefutott, készen állunk az énekszöveg átalakító használatára.
