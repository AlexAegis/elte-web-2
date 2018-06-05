CREATE TABLE `alakzatok` (
  `id` int(11) NOT NULL,
  `nev` varchar(30) COLLATE utf8_hungarian_ci NOT NULL,
  `szelesseg` int(11) NOT NULL,
  `magassag` int(11) NOT NULL,
  `kedvenc` tinyint(1) NOT NULL,
  `alakzat` text COLLATE utf8_hungarian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

INSERT INTO `alakzatok` (`id`, `nev`, `szelesseg`, `magassag`, `alakzat`, `kedvenc`) VALUES
(1, 'alma', 2, 2, '[[1,3],[0,2]]', 1),
(2, 'korte', 3, 3, '[[1,2,1],[0,0,3],[4,0,1]]', 0),
(200000000, 'szilva', 3, 2, '[[2,1,1],[2,0,0]]', 0);

ALTER TABLE `alakzatok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200000001;
