
# Automatikus és kézi ellenőrzések
Új énekszöveg beküldése előtt kérlek futtasd le az automatikus szövegellenőrzőket az alábbi módon:
```
> php utils/validate.php
```
Az automatikus ellenőrzők jelenleg az alábbi feladatokat végzik el:
1. Az énekszöveget tartalmazó xml fájl megfelel-e az OpenLyrics xml formátumnak
2. Szótagszám ellenőrzés az azonos típusú versszakok soraiban
3. Annak ellenőrzése, hogy minden versszak szerepel-e legalább egyszer a versszaksorrendben és a versszaksorrendben szereplő versszakok léteznek-e, valamint hogy nincs két egyforma azonosítójú versszak egy énekben
4. Kiemeli az összes ének összes előforduló szavát, kisbetűsíti, majd elhelyezi a /compilations/wordlist.txt fájlba

# Szóellenőrzés
A negyedik ellenőrző a helytelenül írt szavak kézi ellenőrzéséhez nyújt segítséget azzal, hogy az összes előforduló
szót kiemeli és azt kisbetűsítve leteszi egyetlen fájlba, soronként egy szót. Ha ezt a fájlt megnyitjuk egy szövegszerkesztő programban (Microsoft Word, LibreOffice Writer, OpenOffice Writer, Pages), akkor a beépített helyesírásellenőrző aláhúzza az ismeretlen szavakat. A hibásnak jelölt szavak ellenőrzésével kiszűrhetők az elütéshibák, a helytelen ő és ű betűk, stb.

A wordlist.txt fájlba a szavak utf-8 kódolásban szerepelnek, így a fájl megnyitásakor is ezt a kódolást kell megadni!

Microsoft Word-höz további segítség lehet a következő VBA makró (a [word.tips.net](https://word.tips.net/T001465_Pulling_Out_Spelling_Errors.html) oldalról), amivel a hibás szavak kigyűjthetők egy új dokumentumba:
```
Sub GetSpellingErrors()
    Dim DocThis As Document
    Dim iErrorCnt As Integer
    Dim J As Integer

    Set DocThis = ActiveDocument
    Documents.Add

    iErrorCnt = DocThis.SpellingErrors.Count
    For J = 1 To iErrorCnt
        Selection.TypeText Text:=DocThis.SpellingErrors(J)
        Selection.TypeParagraph
    Next J
End Sub
```
# Részleges ellenőrzés
Az énekgyűjtemény teljes újraellenőrzésén kívül lehetőség van a legutóbb módosított/létrehozott fájlok
ellenőrzésére is. Feltételei:
- a gépen legyen telepítve és PATH környezeti változóban elérhetővé téve a git parancs
- a gyűjtemény git repository-ként legyen le-clone-olva

Ebben az esetben a következő paranccsal csak a módosított/új fájlok kerülnek ellenőrzésre:
```
> php utils/validate.php diff
```
