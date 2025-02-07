-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2024. Dec 29. 14:11
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `16szemelyiseg`
--
CREATE DATABASE IF NOT EXISTS `16szemelyiseg` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci;
USE `16szemelyiseg`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalok`
--

CREATE TABLE `felhasznalok` (
  `user_email` varchar(255) NOT NULL,
  `mbti_type` varchar(50) NOT NULL,
  `test_count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalok_adatai`
--

CREATE TABLE `felhasznalok_adatai` (
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kerdesek`
--

CREATE TABLE `kerdesek` (
  `question_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `dimension` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `kerdesek`
--

INSERT INTO `kerdesek` (`question_id`, `question_text`, `dimension`) VALUES
(1, 'Rendszeresen szerzel új barátokat.', 'Mind'),
(2, 'Az összetett és új ötletek jobban izgatnak, mint az egyszerű és egyértelműek.', 'Energy'),
(3, 'Általában inkább az érzelmileg rezonáló dolgok győznek meg, mint a tények.', 'Nature'),
(4, 'Az élettered és munkahelyed tiszta és rendezett.', 'Tactics'),
(5, 'Általában nyugodt maradsz, még nagy nyomás alatt is.', 'Identity'),
(6, 'Nagyon ijesztőnek találod a hálózatépítést vagy önmagad népszerűsítését idegenek között.', 'Mind'),
(7, 'Előre megtervezed és hatékonyan végzed el a feladataidat, gyakran jóval a határidő előtt.', 'Tactics'),
(8, 'Az emberek történetei és érzelmei többet mondanak neked, mint a számok vagy adatok.', 'Nature'),
(9, 'Szeretsz szervező eszközöket, például időbeosztásokat és listákat használni.', 'Tactics'),
(10, 'Még egy kis hiba is megkérdőjelezteti veled az összképességeidet és tudásodat.', 'Identity'),
(11, 'Kényelmesen érzed magad, ha odalépsz valakihez, akit érdekesnek találsz, és beszélgetést kezdesz.', 'Mind'),
(12, 'Nem nagyon érdekelnek a kreatív művek különböző értelmezéseiről szóló viták.', 'Energy'),
(13, 'Amikor cselekvési irányt határozol meg, előnyben részesíted a tényeket az emberek érzéseivel szemben.', 'Nature'),
(14, 'Gyakran hagyod, hogy a nap mindenfajta időbeosztás nélkül alakuljon.', 'Tactics'),
(15, 'Ritkán aggódsz amiatt, hogy jó benyomást keltesz-e az emberekben, akikkel találkozol.', 'Identity'),
(16, 'Szeretsz csapat-alapú tevékenységekben részt venni.', 'Mind'),
(17, 'Szeretsz kísérletezni új és kipróbálatlan megközelítésekkel.', 'Energy'),
(18, 'Fontosabbnak tartod az érzékenységet, mint a teljes őszinteséget.', 'Nature'),
(19, 'Aktívan keresed az új élményeket és tudásterületeket, amelyeket felfedezhetsz.', 'Energy'),
(20, 'Hajlamos vagy aggódni amiatt, hogy a dolgok rosszra fordulnak.', 'Identity'),
(21, 'Jobban élvezed az egyéni hobbijokat vagy tevékenységeket, mint a csoportosakat.', 'Mind'),
(22, 'Nem tudod elképzelni, hogy megélhetésként kitalált történeteket írj.', 'Energy'),
(23, 'A döntésekben előnyben részesíted a hatékonyságot, még ha ez az érzelmi szempontok figyelmen kívül hagyásával is jár.', 'Nature'),
(24, 'Előbb elvégzed a házimunkát, mielőtt megengednéd magadnak a pihenést.', 'Tactics'),
(25, 'Vitatkozáskor fontosabbnak tartod az igazad bizonyítását, mint mások érzéseinek megőrzését.', 'Nature'),
(26, 'Társasági összejöveteleken általában megvárod, hogy mások mutatkozzanak be először.', 'Mind'),
(27, 'A hangulatod nagyon gyorsan változhat.', 'Identity'),
(28, 'Nem hagyod magad könnyen befolyásolni érzelmi érvekkel.', 'Nature'),
(29, 'Gyakran az utolsó pillanatban végzed el a dolgokat.', 'Tactics'),
(30, 'Szeretsz etikai dilemmákról vitatkozni.', 'Energy'),
(31, 'Általában szívesebben vagy mások társaságában, mint egyedül.', 'Mind'),
(32, 'Unalmassá válik számodra, vagy elveszted az érdeklődésedet, amikor a beszélgetés túlságosan elméleti irányba megy.', 'Energy'),
(33, 'Amikor a tények és az érzések ütköznek, általában a szívedre hallgatsz.', 'Nature'),
(34, 'Nehézséget okoz számodra egy következetes munkarend vagy tanulási időbeosztás fenntartása.', 'Tactics'),
(35, 'Ritkán kérdőjelezed meg a meghozott döntéseidet.', 'Identity'),
(36, 'A barátaid élénknek és társaságkedvelőnek írnának le.', 'Mind'),
(37, 'Vonzanak a különböző kreatív önkifejezési formák, például az írás.', 'Energy'),
(38, 'Általában objektív tényekre alapozod a döntéseidet, nem érzelmi benyomásokra.', 'Nature'),
(39, 'Szeretsz napi teendőlistát készíteni.', 'Tactics'),
(40, 'Ritkán érzed bizonytalannak magad.', 'Identity'),
(41, 'Kerülöd a telefonhívásokat.', 'Mind'),
(42, 'Élvezed, ha ismeretlen ötleteket és nézőpontokat fedezhetsz fel.', 'Energy'),
(43, 'Könnyen kapcsolatot teremtesz olyan emberekkel, akikkel éppen most találkoztál.', 'Mind'),
(44, 'Ha a terveid megszakadnak, a legfontosabb számodra, hogy minél hamarabb visszatérj az eredeti útra.', 'Tactics'),
(45, 'Még mindig zavarnak a régóta elkövetett hibáid.', 'Identity'),
(46, 'Nem igazán érdekelnek az elméletek arról, hogy milyen lehet a világ a jövőben.', 'Energy'),
(47, 'Az érzelmeid jobban irányítanak téged, mint te őket.', 'Identity'),
(48, 'Döntéshozáskor inkább arra koncentrálsz, hogy az érintett emberek mit érezhetnek, nem pedig arra, mi a leglogikusabb vagy leghatékonyabb.', 'Nature'),
(49, 'A személyes munkastílusod közelebb áll a spontán energiakitörésekhez, mint a szervezett és következetes erőfeszítésekhez.', 'Tactics'),
(50, 'Amikor valaki nagyra tart téged, azon tűnődsz, meddig tart, míg csalódni fognak benned.', 'Identity');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `mbti`
--

CREATE TABLE `mbti` (
  `mbti_type` varchar(50) NOT NULL,
  `group` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `mbti`
--

INSERT INTO `mbti` (`mbti_type`, `group`, `role`, `description`) VALUES
('INTJ-A', 'Analysts', 'Architect', 'Imaginative and strategic thinkers, with a plan for everything.'),
('INTJ-T', 'Analysts', 'Architect', 'Imaginative and strategic thinkers, with a plan for everything.'),
('INTP-A', 'Analysts', 'Logician', 'Innovative inventors with an unquenchable thirst for knowledge.'),
('INTP-T', 'Analysts', 'Logician', 'Innovative inventors with an unquenchable thirst for knowledge.'),
('ENTJ-A', 'Analysts', 'Commander', 'Bold, imaginative and strong-willed leaders, always finding a way – or making one.'),
('ENTJ-T', 'Analysts', 'Commander', 'Bold, imaginative and strong-willed leaders, always finding a way – or making one.'),
('ENTP-A', 'Analysts', 'Debater', 'Smart and curious thinkers who cannot resist an intellectual challenge.'),
('ENTP-T', 'Analysts', 'Debater', 'Smart and curious thinkers who cannot resist an intellectual challenge.'),
('INFJ-A', 'Diplomats', 'Advocate', 'Quiet and mystical, yet very inspiring and tireless idealists.'),
('INFJ-T', 'Diplomats', 'Advocate', 'Quiet and mystical, yet very inspiring and tireless idealists.'),
('INFP-A', 'Diplomats', 'Mediator', 'Poetic, kind and altruistic people, always eager to help a good cause.'),
('INFP-T', 'Diplomats', 'Mediator', 'Poetic, kind and altruistic people, always eager to help a good cause.'),
('ENFJ-A', 'Diplomats', 'Protagonist', 'Charismatic and inspiring leaders, able to mesmerize their listeners.'),
('ENFJ-T', 'Diplomats', 'Protagonist', 'Charismatic and inspiring leaders, able to mesmerize their listeners.'),
('ENFP-A', 'Diplomats', 'Campaigner', 'Enthusiastic, creative and sociable free spirits, who can always find a reason to smile.'),
('ENFP-T', 'Diplomats', 'Campaigner', 'Enthusiastic, creative and sociable free spirits, who can always find a reason to smile.'),
('ISTJ-A', 'Sentinels', 'Logistician', 'Practical and fact-minded individuals, whose reliability cannot be doubted.'),
('ISTJ-T', 'Sentinels', 'Logistician', 'Practical and fact-minded individuals, whose reliability cannot be doubted.'),
('ISFJ-A', 'Sentinels', 'Defender', 'Very dedicated and warm protectors, always ready to defend their loved ones.'),
('ISFJ-T', 'Sentinels', 'Defender', 'Very dedicated and warm protectors, always ready to defend their loved ones.'),
('ESTJ-A', 'Sentinels', 'Executive', 'Excellent administrators, unsurpassed at managing things – or people.'),
('ESTJ-T', 'Sentinels', 'Executive', 'Excellent administrators, unsurpassed at managing things – or people.'),
('ESFJ-A', 'Sentinels', 'Consul', 'Extraordinarily caring, social and popular people, always eager to help.'),
('ESFJ-T', 'Sentinels', 'Consul', 'Extraordinarily caring, social and popular people, always eager to help.'),
('ISTP-A', 'Explorers', 'Virtuoso', 'Bold and practical experimenters, masters of all kinds of tools.'),
('ISTP-T', 'Explorers', 'Virtuoso', 'Bold and practical experimenters, masters of all kinds of tools.'),
('ISFP-A', 'Explorers', 'Adventurer', 'Flexible and charming artists, always ready to explore and experience something new.'),
('ISFP-T', 'Explorers', 'Adventurer', 'Flexible and charming artists, always ready to explore and experience something new.'),
('ESTP-A', 'Explorers', 'Entrepreneur', 'Smart, energetic and very perceptive people, who truly enjoy living on the edge.'),
('ESTP-T', 'Explorers', 'Entrepreneur', 'Smart, energetic and very perceptive people, who truly enjoy living on the edge.'),
('ESFP-A', 'Explorers', 'Entertainer', 'Spontaneous, energetic and enthusiastic people – life is never boring around them.'),
('ESFP-T', 'Explorers', 'Entertainer', 'Spontaneous, energetic and enthusiastic people – life is never boring around them.');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `kerdesek`
--
ALTER TABLE `kerdesek`
  ADD PRIMARY KEY (`question_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `kerdesek`
--
ALTER TABLE `kerdesek`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
