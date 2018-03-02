
# Automatikus és kézi ellenőrzések
Új énekszöveg beküldése előtt kérlek futtasd le az automatikus szövegellenőrzőket az alábbi módon:
```
> php utils/validate.php
```
Az automatikus ellenőrzők jelenleg az alábbi feladatokat végzik el:
1. Az énekszöveget tartalmazó xml fájl megfelel-e az OpenLyrics xml formátumnak
2. Szótagszám ellenőrzés az azonos típusú versszakok soraiban
3. Annak ellenőrzése, hogy minden versszak szerepel-e legalább egyszer a versszaksorrendben és a versszaksorrendben szereplő versszakok léteznek-e
