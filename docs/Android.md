# Az énekgyűjtemény Androidos telefonra történő telepítése

A Google Play áruházban több olyan (akár magyar nyelvű) énekeskönyv alkalmazás is található, amely nagy segítség lehet olyan helyzetben, amikor énekelni kellene, de fejből nem megy és nincs más szövegforrás.

A [Hitünk Énekei](https://play.google.com/store/apps/details?id=hu.nicetry.android.readerapp) alkalmazás például tartalmazza a teljes Hitünk énekei énekeskönyv egy korábbi, még hibákat tartalmazó szövegét, így adták magukat a kérdések, hogy nem lehetne-e kicserélni az alkalmazásban levő szövegeket a javítottakra? Nem lehetne több énekeskönyv szövegét is betölteni az alkalmazásba? De lehet! A továbbiakban ennek a menete kerül ismertetésre, annak ellenére, hogy ennek az alkalmazásnak az 1.1.1 változata is több hibát is tartalmaz (1. nem mindig működik a kereső; 2. nem mindig lehet váltani az énekeskönyvek között). A hibás működést a felhasználók is tudják (bénán, de) javítani: ha átlapozunk a kedvencekre és az előzményekre, majd vissza az énekekre, vagy a könyvekre, akkor mindkét fenti hiba megjavul... ;P

A szövegek alkalmazásba való töltésének az a menete, hogy be kell szerezni az alkalmazás apk telepítő fájlját, azt ki kell kódolni, ki kell benne cserélni a szövegeket, majd vissza kell kódolni, elektronikusan alá kell írni és már telepíthető is a telefonokra. A lépésenkénti folyamat az alábbi:

# Az eredeti apk fájl beszerzése

A Google Play áruházban nincs apk fájl letöltési lehetőség, de több olyan online szolgáltatás van, amely segítséget nyújt ebben. Konkrét linket nem írnék, mert ezek az apk letöltő oldalak mindig változnak, de ez a lépés nem lehet probléma, a hu.nicetry.android.readerapp azonosítójú alkalmazást kell megszerezni .apk fájlként.

# A legfrissebb JDK (Java Development Kit) telepítése

[Java Standard Edition JDK](http://www.oracle.com/technetwork/java/javase/downloads/index.html)

# A legfrissebb Android SDK telepítése

[Android Studio](https://developer.android.com/studio/index.html)

# A legfrissebb apktool letöltése

[apktool letöltés](https://bitbucket.org/iBotPeaches/apktool/downloads/)
[apktool honlap](https://ibotpeaches.github.io/Apktool/)

# Az apk fájl visszafejtése

```
> java -jar apktool_2.3.1.jar d hu.nicetry.android.readerapp.apk
```

# A betöltendő énekszövegek összeállítása

```
> php utils/compile.php
```

# Az előkészített énekszövegek kicsomagolása

```
> rm -R hu.nicetry.android.readerapp/assets/books/*
> unzip sdahun_songs-eeee.hh.nn_oo.pp.mm.zip -d hu.nicetry.android.readerapp/
```

# Az új apk fájl összeállítása

```
> java -jar apktool_2.3.1.jar b hu.nicetry.android.readerapp
```

# Új saját privát kulcs készítése az apk fájl aláírásához

```
> keytool -genkey -v -keystore my-release-key.jks -keyalg RSA -keysize 2048 -validity 10000 -alias cert
```

# Az új apk fájl eligazítása

```
> ~/Library/Android/sdk/build-tools/27.0.3/zipalign -v -p 4 hu.nicetry.android.readerapp/dist/hu.nicetry.android.readerapp.apk hu.nicetry.android.readerapp/dist/hu.nicetry.android.readerapp.aligned.apk
```

# Az új apk fájl aláírása

```
> ~/Library/Android/sdk/build-tools/27.0.3/apksigner sign -ks my-release-key.jks --out hu.nicetry.android.readerapp/dist/hu.nicetry.android.readerapp.release.apk hu.nicetry.android.readerapp/dist/hu.nicetry.android.readerapp.aligned.apk
```

# Az apk fájl telepítése androidos telefonra

A dist mappában található hu.nicetry.android.readerapp.release.apk fájl fel kell másolni a telefonra és telepíteni.
