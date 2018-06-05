drop table if exists `ugynokok`;
CREATE TABLE `ugynokok` (
  `id` int(11) NOT NULL,
  `nev` varchar(30) COLLATE utf8_hungarian_ci NOT NULL,
  `szelesseg` int(11) NOT NULL,
  `hosszusag` int(11) NOT NULL,
  `aktiv` tinyint(1) NOT NULL,
  `projekt` varchar(30) COLLATE utf8_hungarian_ci NOT NULL,
  `feladat` varchar(30) COLLATE utf8_hungarian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

INSERT INTO `ugynokok` (`id`, `nev`, `szelesseg`, `hosszusag`, `aktiv`, `projekt`, `feladat`) VALUES
(1, 'James Bond', 100, 100, 1, 'Skyfall', 'M megmentése'),
(2, 'Jason Bourne', 50, 300, 1, 'ultimátum', 'csapda'),
(3, 'Ethan Hunt', 200, 180, 1, 'Mission impossible', 'Szindikátus megtalálása'),
(4, 'Mr Irdatlan', 120, 350, 0, 'szilánk', 'család'),
(5, 'Nyúlányka', 120, 340, 0, 'szilánk', 'család'),
(6, 'Ügynök1', 230, 216, 1, 'Skyfall', 'Q biztosítása'),
(7, 'Ügynök2', 109, 33, 0, 'ultimátum', 'rejtély'),
(8, 'Ügynök3', 227, 50, 0, 'szilánk', 'gyerekvigyázás'),
(9, 'Ügynök4', 148, 195, 0, 'Mission impossible', 'számítógép'),
(10, 'Ügynök5', 217, 412, 1, 'Skyfall', 'kocsivezetés');

ALTER TABLE `ugynokok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;