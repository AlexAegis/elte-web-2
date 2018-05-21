PHP beadandó – Könyvespolc
==========================

Feladatleírás
-------------

Készíts egy alkalmazást, amelyben nyilván tarthatod az elolvasott és elolvasandó könyveidet! Az adatok tárolása tetszőleges formában (adatbázis, fájl) történhet.

Az alkalmazásnak a következő funkciókat kell tudnia:

1.  **Főoldal** A főoldal megjelenít egy üdvözlő szöveget, és kiírja, hogy jelenleg hány felhasználónak összesen hány könyve van az alkalmazásban.
    
2.  **Hitelesítés** Minden további funkció csak hitelesítés után érhető el. A főoldalon legyen lehetőség bejelentkezni: ehhez email címet és jelszót kérjünk be. Ugyancsak a főoldalon legyen egy link, amin keresztül a regisztrációs oldalra mehetünk. Itt meg kell adni a teljes nevet (kötelező), az email címet (kötelező, email formátum) és a jelszót (kötelező, legalább 6 karakter hosszú). Sikeres regisztráció után újra a főoldalra kerülünk, ahol bejelentkezhetünk. Bejelentkezés után legyen lehetőség kijelentkezni!
    
3.  **Listázó oldal** Sikeres bejelentkezés után a listázó oldalra kerülünk, ahol táblázatos formában megjelennek a bejelentkezett felhasználóhoz tartozó könyvek: szerző, cím, kategória, elolvasva-e.
    
4.  **Új könyv** A listázó oldalról egy link vigyen át egy olyan oldalra, ahol új könyv adatait lehet felvenni. Egy könyvről a következőket kell megadni:
    
    *   szerző (kötelező)
    *   cím (kötelező)
    *   oldalszám (csak egész szám)
    *   kategória (legördülő, szabadon megadható, ld. [datalist](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/datalist))
    *   ISBN szám (10 vagy 13 hosszú számsor)
    *   elolvasva-e (jelölőmező).
    
    Hibás kitöltés esetén a hibákat jelezni kell! Siker esetén irányítsuk át az oldalt a listázó oldalra!
    
5.  **Könyv módosítása** A listázó oldalon minden könyv mellett jelenjen meg egy “Módosít” feliratú link. Erre kattintva egy külön oldalon jelenjen meg az új könyv felviteléhez hasonló űrlap, amelyen keresztül módosítani lehet a kívánt könyvet. Első megjelenéskor az űrlapmezők legyenek kitöltve az adott könyv adataival. Módosítás után ellenőrizzük a bevitt adatokat! Ha hibás, jelezzük az oldalon, ekkor már a felküldött adatokat jelenítve meg az űrlapmezőkben. Sikeres módosítás esetén irányítsuk az oldalt a listázó oldalra!
    
6.  **Könyv törlése** A listázó oldalon minden könyv mellett jelenjen meg egy “Törlés” link is. Erre kattintva az adott könyvet töröljük az adatbázisból, és újra jelenjen meg a listázó oldal.
    
7.  **AJAX lapozás** A táblázatban mindig csak 5 elem jelenjen meg. Ha ennél több van, akkor legyen lapozás funkció, azaz a táblázat alatt legyen egy “Előző”-“Következő” link, amire kattintva az előző 5 vagy következő 5 elem jelenik meg a táblázatban. Ha tovább nem lehet menni, akkor az a link ne jelenjen meg. A megoldást AJAX segítségével készítsd el, azaz a teljes oldal újratöltése nélkül.
    
    A listázó oldal kaphassa meg paraméterként, hogy hányadik oldal töltődik be (pl. `list.php?page=2` – ez a 6-10. sort fogja mutatni)
    
    Technikai segítség:
    
    *   A tábla sorainak megszámolása: `SELECT count(1) FROM table`.
    *   A tábla rendezése: `SELECT * FROM table ORDER BY id`.
    *   A tábla sorai közül valahonnan csak bizonyos mennyiséget lekérdezni: `SELECT * FROM table LIMIT 5 OFFSET 10`.
    *   A megjelenő URL átírása: `history.replaceState(null, null, '?page=10')`
    
    Könyv törlése után a `page` paraméter őrizze meg az értékét!
    

### Pontozás

*   Főoldal: megjelenik (kötelező)
*   Főoldal: számláló (1 pont)
*   Hitelesítés: Regisztráció (1 pont)
*   Hitelesítés: Bejelentkezés (kötelező)
*   Hitelesítés: Kijelentkezés (kötelező)
*   Listázó oldal: könyvlista (kötelező)
*   Új könyv oldal: hibaellenőrzés (1 pont)
*   Új könyv oldal: sikeres mentés (kötelező)
*   Könyv módosítása: űrlap kitöltve (1 pont)
*   Könyv módosítása: hibaellenőrzés, űrlap állapotmegőrzése további küldéseknél (1 pont)
*   Könyv módosítása: sikeres mentés (1 pont)
*   Könyv törlése: sikeres törlés (1 pont)
*   Könyv törlése: megőrzi a `page` paraméter értékét (1 pont)
*   AJAX lapozás (3 pont)
*   1 hét késés (-2 pont)
*   2 hét késés (-4 pont)
*   2 hétnél több késés (nincs elfogadva a beadandó, nincs jegy)

### Értékelés

*   0-4: -0,5
*   5-8: 0
*   9-11: 0,5

### Beadás

Tömörített ZIP állományként kell beadni a [feltöltő felületen](http://webprogramozas.inf.elte.hu/ebr).

Határidő: 2018. május 27. éjfél

Számonkérés
===========