-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Mar 26, 2016 at 08:45 PM
-- Server version: 5.5.45-cll-lve
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `joshpach_animals`
--
CREATE DATABASE IF NOT EXISTS `joshpach_animals` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `joshpach_animals`;

-- --------------------------------------------------------

--
-- Table structure for table `Animals`
--

DROP TABLE IF EXISTS `Animals`;
CREATE TABLE IF NOT EXISTS `Animals` (
  `ID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `Name` char(30) NOT NULL,
  `PhylumID` tinyint(4) unsigned NOT NULL,
  `ClassID` tinyint(4) unsigned NOT NULL,
  `OrderID` tinyint(4) unsigned NOT NULL,
  `FamilyID` tinyint(4) unsigned NOT NULL,
  `GenusID` tinyint(4) unsigned NOT NULL,
  `SpeciesID` tinyint(4) unsigned NOT NULL,
  `Description` varchar(5000) NOT NULL,
  `Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `IDX_Phylum` (`PhylumID`),
  KEY `IDX_Order` (`OrderID`),
  KEY `IDX_Class` (`ClassID`),
  KEY `IDX_Family` (`FamilyID`),
  KEY `IDX_Genus` (`GenusID`),
  KEY `IDX_Species` (`SpeciesID`),
  KEY `IDX_Name` (`Name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `Animals`
--

INSERT INTO `Animals` (`ID`, `Name`, `PhylumID`, `ClassID`, `OrderID`, `FamilyID`, `GenusID`, `SpeciesID`, `Description`, `Created`, `Modified`) VALUES
(3, 'Dog', 1, 1, 1, 1, 1, 1, 'The domestic dog (Canis lupus familiaris or Canis familiaris)[2] is a domesticated canid which has been selectively bred for millennia for various behaviors, sensory capabilities, and physical attributes.[3]\r\n\r\nAlthough initially thought to have originated as a manmade variant of an extant canid species (variously supposed as being the dhole,[4] golden jackal,[5] or gray wolf[6]), extensive genetic studies undertaken during the 2010s indicate that dogs diverged from an extinct wolf-like canid in Eurasia 40,000 years ago.[7] Being the oldest domesticated animal, their long association with people has allowed dogs to be uniquely attuned to human behavior,[8] as well as thrive on a starch-rich diet which would be inadequate for other canid species.[9]\r\n\r\nDogs perform many roles for people, such as hunting, herding, pulling loads, protection, assisting police and military, companionship and, more recently, aiding handicapped individuals. This impact on human society has given them the nickname "man''s best friend" in the Western world. In China and South Vietnam dogs are a source of meat for humans.[10][11]', '2016-03-26 18:30:36', '2016-03-26 18:30:36'),
(4, 'Cat', 1, 1, 1, 2, 2, 2, 'The domestic cat[1][2] (Latin: Felis catus) or the feral cat[2][4] (Latin: Felis silvestris catus) is a small, typically furry, carnivorous mammal. They are often called house cats when kept as indoor pets or simply cats when there is no need to distinguish them from other felids and felines.[6] Cats are often valued by humans for companionship and for their ability to hunt vermin. There are more than 70 cat breeds; different associations proclaim different numbers according to their standards.\r\n\r\nCats are similar in anatomy to the other felids, with a strong, flexible body, quick reflexes, sharp retractable claws, and teeth adapted to killing small prey. Cat senses fit a crepuscular and predatory ecological niche. Cats can hear sounds too faint or too high in frequency for human ears, such as those made by mice and other small animals. They can see in near darkness. Like most other mammals, cats have poorer color vision and a better sense of smell than humans. Cats, despite being solitary hunters, are a social species and cat communication includes the use of a variety of vocalizations (mewing, purring, trilling, hissing, growling, and grunting), as well as cat pheromones and types of cat-specific body language.[7]\r\n\r\nCats have a high breeding rate. Under controlled breeding, they can be bred and shown as registered pedigree pets, a hobby known as cat fancy. Failure to control the breeding of pet cats by neutering and the abandonment of former household pets has resulted in large numbers of feral cats worldwide, requiring population control.[8] This has contributed, along with habitat destruction and other factors, to the extinction of many bird species. Cats have been known to extirpate a bird species within specific regions and may have contributed to the extinction of isolated island populations.[9] Cats are thought to be primarily, though not solely, responsible for the extinction of 33 species of birds, and the presence of feral and free ranging cats makes some locations unsuitable for attempted species reintroduction in otherwise suitable locations.[10]\r\n\r\nSince cats were venerated in ancient Egypt, they were commonly believed to have been domesticated there,[11] but there may have been instances of domestication as early as the Neolithic from around 9,500 years ago (7,500 BCE).[12] A genetic study in 2007 concluded that domestic cats are descended from Near Eastern wildcats, having diverged around 8,000 BCE in West Asia.[11][13] A 2016 study found that leopard cats were undergoing domestication independently in China around 5,500 BCE, though this line of partially domesticated cats leaves no trace in the domesticated populations of today.[14][15]\r\n\r\nAs of a 2007 study, cats are the second most popular pet in the United States by number of pets owned, behind the first, which is freshwater fish.[16]', '2016-03-26 18:33:54', '2016-03-26 18:33:54'),
(5, 'Cottontail Rabbit', 1, 1, 3, 3, 3, 7, 'Cottontail rabbits are among the 17 lagomorph species in the genus Sylvilagus, found in the Americas.[1]\r\n\r\nIn appearance, most cottontail rabbits closely resemble the wild European rabbit (Oryctolagus cuniculus). Most Sylvilagus species have stub tails with white undersides that show when they retreat, giving them their name: "cottontails". This feature is not present in some cottontails (for example, the underside of the brush rabbit''s tail is gray), nor is it unique to the genus (for example, the European rabbit also has a white scut).\r\n\r\nThe genus is widely distributed across North America, Central America, and northern and central South America, though most species are confined to particular regions. Most (though not all) species live in nests called forms, and all have altricial young.\r\n\r\nCottontail rabbits show a greater resistance to myxomatosis than European rabbits.[2]', '2016-03-26 18:39:45', '2016-03-26 18:39:45'),
(6, 'Palm Cockatoo', 1, 4, 4, 4, 4, 4, 'The palm cockatoo (Probosciger aterrimus), also known as the goliath cockatoo or great black cockatoo, is a large smoky-grey or black parrot of the cockatoo family native to New Guinea and far north Queensland, Australia. It has a very large black beak and prominent red cheek patches.\r\n\r\nThe bird was also called Goliath Aratoo in Wood''s Natural History (1862)[Note 1].', '2016-03-26 18:39:45', '2016-03-26 18:39:45'),
(7, 'Cow', 1, 1, 5, 5, 5, 5, 'Cattle—colloquially cows[note 1]—are the most common type of large domesticated ungulates. They are a prominent modern member of the subfamily Bovinae, are the most widespread species of the genus Bos, and are most commonly classified collectively as Bos taurus. Cattle are raised as livestock for meat (beef and veal), as dairy animals for milk and other dairy products, and as draft animals (oxen or bullocks that pull carts, plows and other implements). Other products include leather and dung for manure or fuel. In some regions, such as parts of India, cattle have significant religious meaning. From as few as 80 progenitors domesticated in southeast Turkey about 10,500 years ago,[1] according to an estimate from 2003, there are 1.3 billion cattle in the world.[2] In 2009, cattle became one of the first livestock animals to have a fully mapped genome.[3] Some consider cattle the oldest form of wealth, and cattle raiding consequently one of the earliest forms of theft.', '2016-03-26 18:48:31', '2016-03-26 18:48:31'),
(8, 'Pig', 1, 1, 6, 6, 6, 6, 'The domestic pig (Sus scrofa domesticus or Sus domesticus), often called swine, hog, or pig when there is no need to distinguish it from other pigs, is a large, even-toed ungulate. It is variously considered a subspecies of the wild boar or a distinct species. Its head-plus-body-length ranges from 0.9 to 1.8 m (35 to 71 in), and the adult can weigh between 50 to 350 kg (110 to 770 lb). Compared to other artiodactyls, its head is relatively long, pointed, and free of warts. Even-toed ungulates are generally herbivorous, but the domestic pig is an omnivore, like its wild relative.\r\n\r\nDomestic pigs are farmed primarily for the consumption of their meat, called pork. The animal''s bones, hide, and bristles are also used in commercial products. Domestic pigs, especially the pot-bellied pig, are sometimes kept as pets.', '2016-03-26 18:48:31', '2016-03-26 18:48:31'),
(9, 'Eastern Bearded Draggon', 1, 5, 7, 14, 7, 7, 'The eastern bearded dragon (Pogona barbata) is an agamid lizard found in wooded parts of Australia.[2] It is one of a group of species known commonly as bearded dragons. Other common names for this species include Jew lizard[1] and frilly lizard, the latter being a confusion between this and another dragon, the frill-necked lizard (Chlamydosaurus kingii). This species was originally described in 1829 by Georges Cuvier, who named it Amphibolurus barbatus.[3]', '2016-03-26 18:48:31', '2016-03-26 18:48:31'),
(10, 'Boa Constrictor', 1, 5, 7, 8, 8, 8, 'The boa constrictor or red-tailed boa (Boa constrictor) is a species of large, heavy-bodied snake. It is a member of the family Boidae found in North, Central, and South America, as well as some islands in the Caribbean. A staple of private collections and public displays, its color pattern is highly variable yet distinctive. Ten subspecies are currently recognized, although some of these are controversial.[2] This article focuses on the species Boa constrictor as a whole, but also specifically on the nominate subspecies B. c. constrictor.', '2016-03-26 18:48:31', '2016-03-26 18:48:31'),
(12, 'Eastern Box Turtle', 1, 5, 9, 10, 10, 10, 'The Eastern box turtle (Terrapene carolina carolina) is a subspecies within a group of hinge-shelled turtles, normally called box turtles. T. c. carolina is native to an eastern part of the United States.\r\n\r\nThe eastern box turtle is a subspecies of one of two species of box turtles found in the United States. It is the only "land turtle" found in North Carolina, where it is the state reptile. Box turtles are slow crawlers, extremely long lived, slow to mature, and have relatively few offspring per year. These characteristics, along with a propensity to get hit by cars and agricultural machinery, make all box turtle species particularly susceptible to anthropogenic, or human-induced, mortality.\r\n\r\nIn 2011, citing "a widespread persistent and ongoing gradual decline of Terrapene carolina that probably exceeds 32% over three generations", the IUCN downgraded its conservation status from Near Threatened to Vulnerable.[1]', '2016-03-26 18:48:31', '2016-03-26 18:48:31'),
(13, 'Goldfish', 1, 4, 6, 11, 6, 13, 'The goldfish (Carassius auratus) is a freshwater fish in the family Cyprinidae of order Cypriniformes. It was one of the earliest fish to be domesticated, and is one of the most commonly kept aquarium fish.\r\n\r\nA relatively small member of the carp family (which also includes the koi carp and the crucian carp), the goldfish is a domesticated version of a less-colourful carp (Carassius auratus) native to east Asia. It was first domesticated in China more than a thousand years ago, and several distinct breeds have since been developed. Goldfish breeds vary greatly in size, body shape, fin configuration and colouration (various combinations of white, yellow, orange, red, brown, and black are known).\r\n\r\nThe mutation that gave rise to the domestic goldfish is also known from other cyprinid species, such as common carp and tench.', '2016-03-26 18:48:31', '2016-03-26 18:48:31'),
(14, 'Decollate Snail', 5, 8, 11, 12, 12, 12, 'The decollate snail, scientific name Rumina decollata, is a medium-sized predatory land snail, a species of terrestrial pulmonate gastropod mollusk in the family Subulinidae. It is a European species that has been introduced in a number of areas worldwide.', '2016-03-26 18:48:31', '2016-03-26 18:48:31'),
(16, 'European Crayfish', 6, 9, 12, 13, 13, 13, 'Astacus astacus, the European crayfish, noble crayfish or broad-fingered crayfish, is the most common species of crayfish in Europe, and a traditional food source. Like other true crayfish, Astacus astacus is restricted to fresh water, living only in unpolluted streams, rivers and lakes. It is found from France throughout Central Europe, to the Balkan peninsula, and north as far as parts of the British Isles, Scandinavia, and Eastern Europe. Males may grow up to 16 cm long, and females up to 12 cm.[2]', '2016-03-26 18:48:31', '2016-03-26 18:48:31'),
(17, 'Garlic Toad', 1, 6, 8, 14, 9, 9, 'Pelobates fuscus is a species of toad in the family Pelobatidae, native to an area extending from Central Europe to Western Asia. It is commonly known as the common spadefoot, garlic toad, the common spadefoot toad and the European common spadefoot.\r\n\r\nThe common spadefoot grows to a length of approximately 6.5 centimetres (2.6 in) for males and 8 centimetres (3.1 in) for females. The skin colouration varies depending upon habitat, gender and region, but is usually light-grey to beige-brown on the dorsal surface. The skin is mottled by darker marks that differ between individuals. The belly is white, sometimes with grey mottling. Albino specimens have been observed.\r\n\r\nTwo subspecies are traditionally recognised: Pelobates fuscus fuscus (from central Europe) and Pelobates fuscus insubricus (from Northern Italy). In reality there is no physical or behavioural character allowing to distinguish these supposed subspecies. A recent study showed that there is no haplotype segregation for the populations of Northern Italy, that, therefore, are not to be ascribed to a different subspecies .[4] Haplotypes from some Northern Italian valleys are very characteristic and support a different conception in terms of conservation: not for a different taxonomic position but, instead, for a peculiar differentiation. Populations from eastern Europe appear sufficiently different that they may warrant a separate species status (Pelobates vespertinus).\r\n\r\nWhen alarmed, it emits a very loud call (alarm call) and it can exude a noxious secretion which smells like garlic, hence the common name "garlic toad".', '2016-03-26 18:48:31', '2016-03-26 18:48:31');

-- --------------------------------------------------------

--
-- Table structure for table `Classes`
--

DROP TABLE IF EXISTS `Classes`;
CREATE TABLE IF NOT EXISTS `Classes` (
  `ClassID` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `Label` tinytext NOT NULL,
  `Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ClassID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `Classes`
--

INSERT INTO `Classes` (`ClassID`, `Label`, `Created`) VALUES
(1, 'Mammalia', '2016-03-26 17:56:08'),
(2, 'Maxillopoda', '2016-03-26 17:56:08'),
(3, 'Sauropsida', '2016-03-26 17:56:08'),
(4, 'Aves', '2016-03-26 18:16:12'),
(5, 'Reptila', '2016-03-26 18:16:12'),
(6, 'Amphibia', '2016-03-26 18:16:12'),
(7, 'Actinopterygii', '2016-03-26 18:16:12'),
(8, 'Gastropoda', '2016-03-26 18:16:12'),
(9, 'Malacostraca', '2016-03-26 18:16:12');

-- --------------------------------------------------------

--
-- Table structure for table `Families`
--

DROP TABLE IF EXISTS `Families`;
CREATE TABLE IF NOT EXISTS `Families` (
  `FamilyID` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `Label` tinytext NOT NULL,
  `Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`FamilyID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `Families`
--

INSERT INTO `Families` (`FamilyID`, `Label`, `Created`) VALUES
(1, 'Canidae', '2016-03-26 18:00:30'),
(2, 'Felidae', '2016-03-26 18:16:12'),
(3, 'Leporidae', '2016-03-26 18:16:12'),
(4, 'Cacatuidae', '2016-03-26 18:16:12'),
(5, 'Bovidae', '2016-03-26 18:16:12'),
(6, 'Suidaeae', '2016-03-26 18:16:12'),
(7, 'Sylvilagus', '2016-03-26 18:16:12'),
(8, 'Boidae', '2016-03-26 18:16:12'),
(9, 'Lacertilia', '2016-03-26 18:16:12'),
(10, 'Emydidae', '2016-03-26 18:16:12'),
(11, 'Cyprinidae', '2016-03-26 18:16:12'),
(12, 'Subulinidae', '2016-03-26 18:16:12'),
(13, 'Astacidae', '2016-03-26 18:16:12'),
(14, 'Pelobatidae', '2016-03-26 18:55:45');

-- --------------------------------------------------------

--
-- Table structure for table `Genuses`
--

DROP TABLE IF EXISTS `Genuses`;
CREATE TABLE IF NOT EXISTS `Genuses` (
  `GenusID` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `Label` tinytext NOT NULL,
  `Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`GenusID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `Genuses`
--

INSERT INTO `Genuses` (`GenusID`, `Label`, `Created`) VALUES
(1, 'Canis', '2016-03-26 18:00:30'),
(2, 'Felis', '2016-03-26 18:16:12'),
(3, 'Sylvilagus', '2016-03-26 18:16:12'),
(4, 'Probosciger', '2016-03-26 18:16:12'),
(5, 'Bos', '2016-03-26 18:16:12'),
(6, 'Sus', '2016-03-26 18:16:12'),
(7, 'Pogona', '2016-03-26 18:16:12'),
(8, 'Boa ', '2016-03-26 18:16:12'),
(9, 'Pelobates', '2016-03-26 18:16:12'),
(10, 'Terrapene ', '2016-03-26 18:16:12'),
(11, 'Carassius ', '2016-03-26 18:16:12'),
(12, 'Rumina ', '2016-03-26 18:16:12'),
(13, 'Astacus ', '2016-03-26 18:16:12');

-- --------------------------------------------------------

--
-- Table structure for table `Orders`
--

DROP TABLE IF EXISTS `Orders`;
CREATE TABLE IF NOT EXISTS `Orders` (
  `OrderID` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `Label` tinytext NOT NULL,
  `Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`OrderID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `Orders`
--

INSERT INTO `Orders` (`OrderID`, `Label`, `Created`) VALUES
(1, 'Carnivora', '2016-03-26 18:00:30'),
(3, 'Lagomorpha', '2016-03-26 18:16:12'),
(4, 'Psittaciformes', '2016-03-26 18:16:12'),
(5, 'Cetartiodactyla', '2016-03-26 18:16:12'),
(6, 'Artiodactyla', '2016-03-26 18:16:12'),
(7, 'Squamata', '2016-03-26 18:16:12'),
(8, 'Anura', '2016-03-26 18:16:12'),
(9, 'Testudines', '2016-03-26 18:16:12'),
(10, 'Cypriniformes', '2016-03-26 18:16:12'),
(11, 'Heterobranchia', '2016-03-26 18:16:12'),
(12, 'Decapoda', '2016-03-26 18:16:12');

-- --------------------------------------------------------

--
-- Table structure for table `Phylums`
--

DROP TABLE IF EXISTS `Phylums`;
CREATE TABLE IF NOT EXISTS `Phylums` (
  `PhylumID` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `Label` tinytext NOT NULL,
  `Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`PhylumID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `Phylums`
--

INSERT INTO `Phylums` (`PhylumID`, `Label`, `Created`) VALUES
(1, 'Chordata', '2016-03-26 17:54:47'),
(2, 'Echinodermata', '2016-03-26 17:54:47'),
(3, 'Hemichordata', '2016-03-26 17:54:47'),
(4, 'Xenacoelomorpha', '2016-03-26 17:54:47'),
(5, 'Mollusca', '2016-03-26 18:16:12'),
(6, 'Arthropoda', '2016-03-26 18:16:12');

-- --------------------------------------------------------

--
-- Table structure for table `Species`
--

DROP TABLE IF EXISTS `Species`;
CREATE TABLE IF NOT EXISTS `Species` (
  `SpeciesID` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
  `Label` tinytext NOT NULL,
  `Created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`SpeciesID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `Species`
--

INSERT INTO `Species` (`SpeciesID`, `Label`, `Created`) VALUES
(1, 'Lupus', '2016-03-26 18:00:30'),
(2, 'Catus', '2016-03-26 18:16:12'),
(3, 'Sylvilagus', '2016-03-26 18:16:12'),
(4, 'Aterrimus', '2016-03-26 18:16:12'),
(5, 'Taurus', '2016-03-26 18:16:12'),
(6, 'Scrofa', '2016-03-26 18:16:12'),
(7, 'Barbata', '2016-03-26 18:16:12'),
(8, 'Constrictor', '2016-03-26 18:16:12'),
(9, 'Fuscus', '2016-03-26 18:16:12'),
(10, 'Carolina', '2016-03-26 18:16:12'),
(11, 'Auratus', '2016-03-26 18:16:12'),
(12, 'Decollata', '2016-03-26 18:16:12'),
(13, 'Astacus', '2016-03-26 18:16:12'),
(14, 'Agamidae', '2016-03-26 18:57:29');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Animals`
--
ALTER TABLE `Animals`
  ADD CONSTRAINT `FK_Species` FOREIGN KEY (`SpeciesID`) REFERENCES `Species` (`SpeciesID`),
  ADD CONSTRAINT `FK_Class` FOREIGN KEY (`ClassID`) REFERENCES `Classes` (`ClassID`),
  ADD CONSTRAINT `FK_Family` FOREIGN KEY (`FamilyID`) REFERENCES `Families` (`FamilyID`),
  ADD CONSTRAINT `FK_Genus` FOREIGN KEY (`GenusID`) REFERENCES `Genuses` (`GenusID`),
  ADD CONSTRAINT `FK_Order` FOREIGN KEY (`OrderID`) REFERENCES `Orders` (`OrderID`),
  ADD CONSTRAINT `FK_Phylum` FOREIGN KEY (`PhylumID`) REFERENCES `Phylums` (`PhylumID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
