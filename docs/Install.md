# Telepítés

Az énekszöveg átalakító PHP nyelven íródott, így - ha még nincs a gépre telepítve - telepíteni kell a PHP futtatókörnyezetet. A PHP telepítése után telepíteni és engedélyezni kell a PHP szükséges
beépülő moduljait. Ezt követően telepíteni kell azokat a külső programkönyvtárakat, amelyeket az
átalakító program használ és ez után lehet használatba venni az énekszöveg átalakító programot.
A lépések a következők:
[[toc]]

## 1. A PHP telepítése

### A PHP telepítése Windows alatt
A PHP Windows alatt használható verziója a [http://windows.php.net/download/] címről tölthető le.
A weboldalt megnyitva ki kell választani a letöltendő fájlt:
- VC15 x64 Non Thread Safe - Zip: ezt a változatot 64 bites windows esetén kell használni
- VC15 x86 Non Thread Safe - Zip: ez a változat 32 bites windows esetén lesz megfelelő

A zip fájlt a letöltés után ki kell csomagolni egy mappába (Pl.: C:\PHP) és a PHP futtatókörnyezet már
használható is.
Ahhoz, hogy a PHP kényelmesen használható legyen, célszerű beállítani a PATH környezeti változóba
azt a mappát, ahova a PHP-t kicsomagoltuk. (Windows 10 alatt: Keresés: A rendszer környezeti változóinak
módosítása -> Környezeti változók... nyomógomb -> Felhasználói változók -> Path duplaklikk -> Tallózás... -> OK)

### A PHP telepítése Debian Linux alatt
A PHP megtalálható a Debian sztenderd csomagkönyvtáraiban, így a csomagkezelővel egyszerűen telepíthető,
vagy parancssorból az
apt-get install php-cli
paranccsal a gépünkre kerül.

### A PHP telepítése MacOS High Sierra alatt
MacOS alatt nincs telepítési teendő, az operációs rendszerben alapértelmezetten telepítve van a PHP.

## 2. A PHP beépülő modulok telepítése/bekapcsolása
Ahhoz, hogy az énekszöveg átalakító működni tudjon, a PHP néhány extra funkcionalitását biztosító
beépülő modult is elérhetővé kell tenni a PHP számára.

### A PHP beépülő modulok bekapcsolása Windows alatt
Windows alatt az első teendő, hogy a kicsomagolt mappában található php.ini-production fájlt át kell
másolni ugyanabba a mappába php.ini névre.
C:\PHP>copy php.ini-production php.ini

Ezt követően a php.ini fájlt meg kell nyitni szerkesztésre a jegyzettömb alkalmazással, majd
a következő helyekről törölni kell a sor elejéről a pontosvesszőt:
extension_dir = "ext"
extension=mbstring
extension=openssl

### A PHP beépülő modulok telepítése Debian Linux alatt
Debian Linux alatt a beépülő modulok külön csomagként találhatók a Debian csomagkönyvtáraiban,
így azokat elég telepíteni az
apt-get install php-mbstring

### A PHP beépülő modulok MacOS High Sierra alatt
MacOS alatt nincs telepítési/beállítási teendő, a szükséges beépülő modulok be vannak kapcsolva az
alapértelmezett PHP parancsértelmezőben.

## 3. Az énekgyűjtemény letöltése
Az énekgyűjtemény legfrissebb és legaktuálisabb változata az átalakító programmal együtt a [https://github.com/sdahun/songs] oldalon a zöld színű "Clone or download" nyomógomb megnyomása
után a "Download ZIP" linkre kattintva szerezhető be.
A letöltött fájlt ki kell csomagolni egy tetszőleges mappába.

## 4. A kiegészítő programkönyvtárak telepítése
Meg kell nyitni a parancssort (linux, mac alatt: terminal), majd abba a mappába kell lépni,
ahova kicsomagoltuk az énekgyűjteményt:
>cd songs-master

Itt ki kell adnunk a következő parancsot a kiegészítő programkönyvtárak telepítéséhez:
>php utils/composer.phar install

Ha ez a parancs lefutott, készen állunk az énekszöveg átalakító használatára.
