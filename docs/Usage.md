# Az énekszöveg átalakító használata

Az énekszöveg átalakító parancssorból indítható, a letöltött és kicsomagolt mappában állva a következő paranccsal:

`> php utils/compile.php`

Az átalakító a válaszoktól függően 5-10 kérdést tesz fel azzal kapcsolatban, hogy milyen legyen a végleges szöveg.
A kérdések egy része magára a szöveg formázására vonatkozik, más része a végeredmény formátumára.
A kérdések a következők:
* **Legyen-e nyitó dia, amin megjelenik az ének címe/kezdete?**

  A gyűjtemény szándékosan úgy lett elkészítve, hogy nem tartalmaz nyitó diát. Ennek az az oka, hogy ha szükség van a nyitó diára, akkor azt egyszerűbb legenerálni és beszúrni az összes elé, mint egy meglevő nyitó dia tartalmát módosítani/törölni. Mivel jelenleg egyetlen éneknek sincs nyitó diája, az erre a kérdésre adott igen válasszal az énekeknek lesz nyitó diája:
  ![Képernyőfotó a nyitó diáról](./images/01.title_slide.png)

  * **A nyitó dián szerepeljen-e az elsődleges énekeskönyv neve?**

    Ha az első kérdés alapján lesz nyitó dia, akkor annak tartalma kiegészíthető az elsődleges énekeskönyv nevével.
    Egy ének több énekeskönyvben is szerepelhet, ilyenkor mindegyik előfordulás felsorolásra kerül az ének szövegében,
    de a nyitódiára csak az elsődleges énekeskönyv neve kerül feltüntetésre, ha erre a kérdésre is igen a válasz:
    ![Képernyőfotó az elsődleges énekeskönyv nevéről](./images/02.title_with_songbook.png) 

  * **A nyitó dián szerepeljen-e az ének elsődleges énekeskönyvbeli száma?**

    Ha a nyitó dián szerepel az énekeskönyv neve, akkor feltüntethető az elsődleges énekeskönyvbeli sorszám is az
    erre a kérdésre adott igen válasszal:
    ![Képernyőfotó a teljes nyitó diáról](./images/03.full_title_slide.png)

* **Az énekszöveg soronként új sorba kerüljön, vagy sorfolytonosan automatikus tördelésű legyen?**


  * Ha a sorok új sorba kerülnek, legyen-e nagybetűsítve minden sor első betűje?
  * Ha sorfolytonos legyen, akkor legyen-e elválasztó perjel (/) a sorok között?
* Az ismétlődő diák csak egyszer, az első előfordulásokkor jelenjenek meg, vagy az összes előforduláskor ismétlődjenek?
* Legyen-e utolsó utáni üres dia?
  * Szerepeljen-e ezen a dián az elsődleges énekeskönyv rövidítése és az ének száma (keresési célból)?
* Az összes énekeskönyvet át kell alakítani, vagy csak a kiválasztott(ak)at?
* A végeredmény egy, vagy több fájlba tördelve kerüjön átalakításra?

A megadott beállítások mentésre kerülnek a /compilations/compile.settings.ini fájlba, így az énekek frissítése esetén a beállítások újra felhasználhatók lesznek egy újabb átalakításhoz.
Az elkészült, átalakított fájlok a /compilations mappába kerülnek.
