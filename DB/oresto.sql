-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `oresto`;
CREATE DATABASE `oresto` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `oresto`;

DROP TABLE IF EXISTS `auth`;
CREATE TABLE `auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE `auth`;
INSERT INTO `auth` (`id`, `key`, `date_created`) VALUES
(1,	'da39a3ee5e6b4b0d3255bfef95601890afd80709',	'2017-02-02 23:26:24');

DROP TABLE IF EXISTS `restaurants`;
CREATE TABLE `restaurants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `postal_code` int(11) NOT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_register` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE `restaurants`;
INSERT INTO `restaurants` (`id`, `name`, `city`, `postal_code`, `latitude`, `longitude`, `address`, `description`, `image`, `date_register`) VALUES
(1,	'Crêperie Canaeleee',	'maule',	78580,	NULL,	NULL,	'18 Boulevard Paul Barre',	'Le restaurant vous accueille dans un cadre chaleureux où plusieurs petites salles vous permettent de passer un agréable moment tout en dégustant la cuisine au goût du jour d\'Hervé Klein.\r\nSituées sur plusieurs niveaux, les salles peuvent accueillir jusqu\'à 15 couverts',	'galette_complete_3.jpg',	'2017-01-06 01:30:50'),
(78,	'O\'Tacos',	'Paris',	75020,	NULL,	NULL,	'91 Rue des Vignoles',	'Le restaurant vous accueille dans un cadre chaleureux où plusieurs petites salles vous permettent de passer un agréable moment tout en dégustant la cuisine au goût du jour d\'Hervé Klein.\r\nSituées sur plusieurs niveaux, les salles peuvent accueillir jusqu\'à 15 couverts',	'otacos.jpg',	'2017-01-10 10:36:44'),
(79,	'Agapé',	'Paris',	75017,	NULL,	NULL,	'51 rue Jouffroy-d\'Abbans',	'Agapè... En Grèce ancienne, ce mot désignait l\'amour inconditionnel de l\'autre. Un nom qui augure des moments exclusifs, dans un décor chic et tendance, parfaitement adapté. La maison, hissée au rang de valeur sûre, compte une clientèle fidèle et conquise... Le fruit d\'un mariage réussi entre salle et cuisine. L\'accueil et le service se révèlent très professionnels, avec des conseils avisés sur le choix des mets et leur alliance avec les vins (plus de 600 références). La carte elle-même, assez courte, fait profession de transparence en mentionnant la provenance des produits, triés sur le volet. Il ne reste alors qu\'à se laisser bercer, en toute confiance, par une jolie romance : celle de la finesse des saveurs, de la justesse des assaisonnements, de la précision des cuissons... le tout porté au point subtil où l\'harmonie rencontre la surprise. L\'arme de séduction de l\'Agapé !',	'agape.jpg',	'2017-01-13 00:16:52'),
(80,	'Le Vivarais',	'Lyon',	69002,	NULL,	NULL,	'1 place Gailleton',	'Avant 1789, le pays de Vivarais couvrait l\'actuelle Ardèche, au sud de Lyon ; plus de deux cents ans ont passé, mais ce terroir est toujours vivant ! Ici, le patron et sa fille cuisinent à quatre mains, proposant pâté en croûte maison, fond d\'artichaut des mères Lyonnaises au foie gras et quenelle sauce Nantua... Miam !',	'levivarais.jpg',	'2017-01-13 00:19:34'),
(81,	'Loiseau des Vignes',	'Beaune',	21200,	NULL,	NULL,	'31 Rue Jean Francois Maufoux',	'La griffe \"Loiseau\" (sous la houlette de la maison mère de Saulieu), une belle carte des vins - avec un choix rare de 70 vins au verre -, un lieu au cachet sûr (poutres, pierres) et surtout des assiettes pleines de caractère : une multitude d\'atouts pour cette bonne table au coeur de la gastronomie bourguignonne !',	'Loiseudesvignes.jpg',	'2017-01-13 00:21:51'),
(82,	'France',	'Montmarault',	3390,	NULL,	NULL,	'1 rue Marx Dormoy',	'Le restaurant vous accueille dans un cadre chaleureux où plusieurs petites salles vous permettent de passer un agréable moment tout en dégustant la cuisine au goût du jour d\'Hervé Klein.\r\nSituées sur plusieurs niveaux, les salles peuvent accueillir jusqu\'à 15 couverts',	'france.jpg',	'2017-01-13 00:24:00'),
(83,	'L\'Orangerie du Château',	'Blois',	41000,	NULL,	NULL,	'1 Avenue du Docteur Jean Laigret',	'Dans une dépendance du château (15e s.), avec une belle terrasse ouvrant sur le monument... L\'esprit de la Renaissance n\'est sans doute pas étranger à la cuisine, à la fois fine, légère et soignée.',	'blois.jpg',	'2017-01-13 00:26:24'),
(84,	'L\'Assiette Champenoise',	'Tinqueux',	51430,	NULL,	NULL,	'40 av. Paul Vaillant-Couturier',	'À quoi reconnaît-on un grand cuisinier ? Au caractère de ses recettes, à sa capacité à apprivoiser même la simplicité, et bien sûr à révéler les saveurs... Ces qualités, Arnaud Lallement les possède toutes. Sans artifice, ses assiettes, rehaussées notamment de sauces magnifiques, réservent des émotions rares ! Le tout dans un cadre chic et moderne des plus agréables.',	'Champenoise.jpg',	'2017-01-13 00:42:00'),
(85,	'Carré des Feuillants',	'Paris',	75001,	NULL,	NULL,	'14 rue de Castiglione',	'Il est rare qu\'un restaurant marie si parfaitement ambiance et style culinaire. Indéniablement, le Carré des Feuillants réussit cette osmose. Point d\'exubérance ou d\'élans démonstratifs, tout dans la mesure et la maîtrise : c\'est la première impression qui se dégage de cet ancien couvent (bâti sous Henri IV). Conçu par l\'artiste plasticien Alberto Bali, ami d\'Alain Dutournier - pour qui il a également signé les décors de ses Pinxo -, le décor n\'est que lignes épurées, presque minimalistes, et matériaux naturels, dans une veine contemporaine. Un cadre baigné de sérénité, pour un service impeccable et une cuisine à la hauteur. Marquée par la générosité et les racines landaises du chef, elle fait preuve de caractère et d\'inventivité. Composées à la manière d\'un triptyque - \"le basique, son complice végétal et le révélateur\" -, les assiettes ont l\'art de valoriser l\'authenticité du produit tout en sublimant le \"futile\". Quant à la cave, elle recèle de vrais trésors.',	'Feuillants.jpg',	'2017-01-13 00:49:03'),
(86,	'Le Montaigu',	'Missillac',	44780,	NULL,	NULL,	'Domaine de la Bretesche',	'Arrivé en mars 2015, Thierry Karakachian met en valeur son expérience dans de belles tables de la côte d\'Azur - notamment Joël Robuchon et Yoshi à Monaco. Sa cuisine, parsemée de notes asiatiques, met joliment en valeur les nombreux produits du terroir breton. Un havre de gourmandise dans le magnifique domaine de la Bretesche !',	'Montaigu.jpg',	'2017-01-13 00:58:34'),
(87,	'L\'Esprit de la Violette',	'Aix-en-Provence',	13100,	NULL,	NULL,	'10 Avenue de la Violette',	'Sur les hauteurs d\'Aix, l\'ancien Clos de la Violette a fait peau neuve ! Cette grande villa bourgeoise, dont le jardin est planté d\'arbres séculaires, est désormais le \"fief\" du chef Marc de Passorio : il décline ici une cuisine moderne et colorée, créative en diable, qui nous mène de belle surprise en belle surprise...',	'Violette.jpg',	'2017-01-13 01:01:21'),
(88,	'Le Gindreau',	'Saint-Médard',	46150,	NULL,	NULL,	'D5',	'Une ancienne école de village transformée en restaurant. Derrière les fourneaux, Pascal Bardet - ancien d\'Alain Ducasse pendant 18 ans - signe une savoureuse cuisine contemporaine qui met en valeur les produits du terroir, et particulièrement la truffe, dont il est un vrai spécialiste ! Terrasse sous les marronniers.',	'Gindreau.jpg',	'2017-01-13 01:10:54'),
(89,	'La Maison d\'à Côté',	'Montlivault',	41350,	NULL,	NULL,	'17 rue de Chambord',	'Le chef, Christophe Hay, a repris en 2014 cette maison à l\'atmosphère feutrée et contemporaine. Quelle réussite ! Tout y séduit : l\'accueil chaleureux - l\'équipe de cuisine n\'hésite pas à venir en salle pour présenter les plats -, la générosité des assiettes, leur créativité tout en subtilité, la beauté des produits régionaux...',	'Maison.jpg',	'2017-01-13 01:27:27'),
(90,	'Loulou Côte Sauvage',	'Les Sables-d\'Olonne',	85100,	NULL,	NULL,	'19 route bleue',	'Ce Loulou-là a accroché sa jolie maison aux rochers de la côte sauvage, face à la mer : la vue est imprenable ! Ici, les produits iodés - extrafrais - sont évidemment à l\'honneur : homards tirés du vivier, poissons achetés directement à la criée des Sables... pour des plats savoureux et bien tournés.',	'Olonne.jpg',	'2017-01-13 01:29:37'),
(91,	'L\'Almandin',	'Saint-Cyprien',	66750,	NULL,	NULL,	'Boulevard de l\'Almandin',	'Au bord de la Méditerranée, dans un cadre contemporain, cette table joue l\'inédit autour d\'une cuisine qui prend les papilles par surprise avec de beaux mélanges sucré-salé. La sole juste snakée, crème de maïs et charlotte courgettes-ananas, en est un bon exemple... L\'originalité au pouvoir !',	'Almandin.jpg',	'2017-01-13 01:39:33'),
(92,	'La Côte Saint-Jacques',	'Joigny',	89300,	NULL,	NULL,	'14 fg de Paris',	'D\'une petite couturière audacieuse à son petit-fils globe-trotter, la Côte St-Jacques s\'est imposée comme une institution de la gastronomie bourguignonne ! La noblesse des produits, la générosité des assiettes, le caractère intemporel de certaines recettes : une histoire culinaire écrite au fil de l\'Yonne toute proche...',	'Jacques.jpg',	'2017-01-13 01:41:38'),
(93,	'L\'Atelier du Parc',	'Paris',	75015,	NULL,	NULL,	'35 Boulevard Lefebvre',	'Voilà un établissement qui tranche avec les nombreuses brasseries traditionnelles de la porte de Versailles : bar en plexiglas changeant de couleur, teintes sobres et beaux sièges design qui donnent leur version d\'un nouvel Art déco... Ce cadre chic et moderne sied parfaitement à la cuisine inventive et soignée d\'un jeune chef plein d\'allant. Les suggestions du jour sont annoncées de vive voix à la clientèle, et les plats de la carte sont renouvelés régulièrement. Saumon mi-fumé par nos soins, poutargue et sorbet granny smith ; épaule d\'agneau confite 36 heures aux épices ; entremet noix de coco et pistache, sorbet griotte... Tout est fait maison ! Beaucoup de finesse, de la créativité et une belle surprise, juste en face au parc des expositions.',	'Parc.jpg',	'2017-01-13 01:43:37'),
(94,	'Mirazur',	'Menton',	6500,	NULL,	NULL,	'30 avenue Aristide-Briand',	'Un lieu d\'exception ! C\'est d\'abord un bel écrin, perché sur la corniche, grand ouvert sur l\'azur de la Méditerranée et du ciel... C\'est surtout une table excellente, portée par un chef inspiré : l\'Argentin Mauro Colagreco signe un hymne unique aux plantes aromatiques, aux fleurs, aux légumes de son potager, aux agrumes, etc. Les saisons, la région sont illuminées.',	'Mirazur.jpg',	'2017-01-13 01:45:13'),
(95,	'Maison Blanche',	'Paris',	75008,	NULL,	NULL,	'Avenue Montaigne',	'Un cadre grandiose ! Tel un cube posé sur le toit du théâtre des Champs-Élysées - un pont suspendu soutient cette étonnante Maison perchée -, la salle semble toiser la capitale à travers son immense baie vitrée... Quant à la terrasse, elle offre une vue tout simplement époustouflante sur la tour Eiffel. Si bien qu\'on ne sait plus où poser le regard en entrant dans ce loft ultradesign ! Lové dans l\'une des banquettes-alcôves ou installé sur la mezzanine, on ne se lasse pas du spectacle... Côté carte : une cuisine contemporaine bien réalisée, imprégnée d\'influences méditerranéennes, et de l\'âme voyageuse du chef. Avec une belle sélection de vins venus du Languedoc et de la vallée du Rhône... juste là-bas, derrière les toits de Paris.',	'Blanche.jpg',	'2017-01-13 01:46:26');

DROP TABLE IF EXISTS `test`;
CREATE TABLE `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE `test`;
INSERT INTO `test` (`id`, `text`) VALUES
(1,	'greg'),
(2,	'greg');

-- 2017-02-03 00:40:41
