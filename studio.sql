-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 16 juil. 2025 à 13:38
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `studio`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id_article` bigint NOT NULL AUTO_INCREMENT,
  `title_article` varchar(250) NOT NULL,
  `content_article` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `id_user` int NOT NULL,
  `statut` varchar(20) DEFAULT 'brouillon',
  `img_thumbnail` varchar(255) DEFAULT NULL,
  `img_medium` varchar(255) DEFAULT NULL,
  `img_large` varchar(255) DEFAULT NULL,
  `img_small` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `img_alt` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_article`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id_article`, `title_article`, `content_article`, `created_at`, `updated_at`, `id_user`, `statut`, `img_thumbnail`, `img_medium`, `img_large`, `img_small`, `img_alt`) VALUES
(23, 'La puissance des cordes ondulatoires : un entraînement intense pour un corps complet', '<p>Dans le monde du fitness, certains exercices se démarquent par leur efficacité, leur intensité et leur accessibilité. C’est le cas des <strong>cordes ondulatoires</strong>, aussi appelées <em>battle ropes</em>. Cet outil simple, constitué de deux cordes épaisses, permet de mobiliser l’ensemble du corps tout en renforçant l’endurance, la coordination et la force musculaire. De plus en plus populaire dans les box de cross-training et les salles de sport en extérieur, cet exercice s’impose comme un incontournable du conditionnement physique.</p>\r\n<h3><strong>Pourquoi utiliser les cordes ondulatoires ?</strong></h3>\r\n<p>Les cordes ondulatoires ne sollicitent pas un seul groupe musculaire, mais bien tout le corps :</p>\r\n<ul>\r\n<li>\r\n<p>Les <strong>bras</strong>, les <strong>épaules</strong> et le <strong>dos</strong> sont mis à rude épreuve pour créer les vagues régulières.</p>\r\n</li>\r\n<li>\r\n<p>Le <strong>tronc</strong> (abdominaux et lombaires) assure la stabilité du corps et travaille en gainage constant.</p>\r\n</li>\r\n<li>\r\n<p>Les <strong>jambes</strong> sont légèrement fléchies pour maintenir une posture solide et stable, activant les cuisses et les fessiers.</p>\r\n</li>\r\n</ul>\r\n<p>C’est un exercice <strong>cardio-vasculaire et musculaire</strong> à la fois, idéal pour brûler des calories, développer la puissance explosive et améliorer l’endurance.</p>\r\n<h3><strong>Un entraînement accessible mais exigeant</strong></h3>\r\n<p>Ce que l’on apprécie avec les battle ropes, c’est leur <strong>polyvalence</strong> : que l’on soit débutant ou athlète confirmé, il est possible d’adapter l’intensité.</p>\r\n<ul>\r\n<li>\r\n<p>Pour les novices, on commence avec des séries courtes (20 à 30 secondes) en vagues alternées.</p>\r\n</li>\r\n<li>\r\n<p>Pour les plus expérimentés, des circuits à haute intensité (<em>HIIT</em>) peuvent être mis en place, intégrant d\'autres mouvements comme les squats, les fentes ou les burpees.</p>\r\n</li>\r\n</ul>\r\n<p>La clé du succès réside dans la <strong>régularité</strong> et la <strong>technique</strong> : dos droit, genoux fléchis, et un mouvement fluide des bras.</p>\r\n<h3><strong>Le sport en plein air : un cadre stimulant</strong></h3>\r\n<p>Pratiquer ce type d’exercice à l’extérieur — comme dans un parking couvert ou sur un toit — offre un cadre motivant et libérateur. La lumière naturelle, la circulation de l’air et le sentiment d’espace renforcent le bien-être général. C’est aussi un excellent moyen de rompre avec la routine d’une salle fermée.</p>\r\n<p><strong>Conclusion :</strong><br />Les cordes ondulatoires sont un outil simple mais redoutablement efficace. Elles apportent un entraînement complet et motivant, que ce soit en salle ou en extérieur. Si vous cherchez à casser la monotonie de vos séances et à booster votre condition physique, il est temps de prendre la corde... au sérieux !</p>', '2025-07-11 11:38:44', '2025-07-16 08:58:43', 1, 'publie', 'uploads/articles/thumb_1752649122_news2.jpg', 'uploads/articles/medium_1752649122_news2.jpg', 'uploads/articles/large_1752649122_news2.jpg', 'uploads/articles/small_1752649122_news2.jpg', 'Homme faisant un exercice de cordes ondulatoires dans un parking, au coucher du soleil'),
(24, 'Le Wall Ball : l’exercice explosif qui fait travailler tout le corps', '<p><span>Dans l’univers du sport fonctionnel et du CrossFit, peu d’exercices sont aussi complets et dynamiques que le <strong>Wall Ball</strong>. Ce mouvement, qui consiste à lancer une médecine ball contre un mur en réalisant un squat profond, combine force, coordination, endurance et explosivité. Adapté aussi bien aux débutants qu’aux sportifs confirmés, il permet de solliciter de nombreux groupes musculaires tout en apportant un aspect ludique à l’entraînement.</span></p>\r\n<p> </p>\r\n<h3>Pourquoi intégrer le Wall Ball dans votre routine ?</h3>\r\n<p>Le Wall Ball est un mouvement <strong>polyarticulaire</strong>, ce qui signifie qu’il fait intervenir plusieurs articulations et muscles à la fois. Les bienfaits sont nombreux :</p>\r\n<ul>\r\n<li>\r\n<p><strong>Renforcement musculaire complet</strong> : les jambes, les fessiers, les abdominaux, les épaules et les bras sont tous engagés.</p>\r\n</li>\r\n<li>\r\n<p><strong>Développement cardio-respiratoire</strong> : le rythme élevé des répétitions augmente rapidement le souffle.</p>\r\n</li>\r\n<li>\r\n<p><strong>Amélioration de la coordination</strong> : lancer avec précision une balle vers une cible en sortant d’un squat demande un bon contrôle du corps.</p>\r\n</li>\r\n<li>\r\n<p><strong>Accessibilité</strong> : la charge est modulable, selon le poids de la balle choisie.</p>\r\n</li>\r\n</ul>\r\n<p> </p>\r\n<h3>Un mouvement technique mais accessible</h3>\r\n<p>Pour bien exécuter un Wall Ball, voici les étapes clés :</p>\r\n<ol>\r\n<li>\r\n<p>Tenez la médecine ball à hauteur de la poitrine.</p>\r\n</li>\r\n<li>\r\n<p>Descendez en squat profond, en gardant le dos droit et les talons ancrés.</p>\r\n</li>\r\n<li>\r\n<p>En remontant, poussez fort dans les jambes et lancez la balle à une cible située à 2,5 à 3 mètres de hauteur.</p>\r\n</li>\r\n<li>\r\n<p>Récupérez la balle en amortissant avec les bras, et enchaînez les répétitions.</p>\r\n</li>\r\n</ol>\r\n<p>Il est conseillé de commencer avec des séries courtes (10 à 15 répétitions) et de bien maîtriser la posture avant d’augmenter la charge ou l’intensité.</p>\r\n<h3>Conclusion</h3>\r\n<p>Le Wall Ball est un excellent outil pour améliorer sa condition physique générale. Que vous soyez adepte de CrossFit, de renforcement musculaire ou de préparation physique, cet exercice vous offrira des résultats visibles en un temps record. Il suffit d’une balle, d’un mur… et d’un peu de sueur et de courage !</p>\r\n<p> </p>', '2025-07-11 12:49:49', '2025-07-16 13:39:24', 37, 'publie', 'uploads/articles/1752230988_news1.jpg', 'uploads/articles/1752230988_news1.jpg', 'uploads/articles/1752230988_news1.jpg', 'uploads/articles/1752230988_news1.jpg', 'Groupe d’adultes réalisant un exercice de Wall Ball dans une salle de sport, en ligne et en mouvement synchronisé'),
(25, 'Courir au lever du soleil : une routine simple pour un bien-être total', '<p><span>Commencer la journée par un jogging matinal peut transformer non seulement ton corps, mais aussi ton état d’esprit. En plus d’être un excellent exercice cardiovasculaire, la course à pied à l’aube offre une expérience sensorielle apaisante, avec moins de bruit, plus d’espace, et une lumière douce. C’est aussi un moment de clarté mentale, souvent propice à la concentration et à la motivation pour le reste de la journée.<br /><br /></span></p>\r\n<h3>Pourquoi courir le matin ?</h3>\r\n<p><strong>1. Meilleure régularité :</strong><br />Le matin, moins de distractions. Tu fais ta séance avant que les imprévus de la journée ne te rattrapent.</p>\r\n<p><strong>2. Un boost métabolique :</strong><br />Courir à jeun (avec modération) peut améliorer la gestion des graisses et stimuler ton métabolisme.</p>\r\n<p><strong>3. Sérénité et solitude :</strong><br />Moins de circulation, de bruit ou de foule : tu profites du silence et du lever du soleil en pleine nature ou en ville.</p>\r\n<p><strong>4. Hormones du bonheur :</strong><br />L’endorphine générée booste ton humeur pour des heures !<br /><br /></p>\r\n<h3>Le cadre joue un rôle clé</h3>\r\n<p>Courir au bord de l’eau, en ville ou sur une promenade urbaine, c’est aussi renouer avec son environnement. L’air est plus frais, les lumières plus douces, et chaque foulée devient une opportunité d’admirer ce que tu ne remarques pas en journée.</p>\r\n<h3>Petit conseil</h3>\r\n<p>Pas besoin de courir vite ni longtemps : commence par 15-20 minutes, choisis de la bonne musique ou profite simplement du silence. Le plus important, c’est la <strong>régularité</strong>.<br /><br /></p>\r\n<h2>Conclusion</h2>\r\n<p>Faire du sport ne veut pas forcément dire transpirer des heures en salle. Parfois, il suffit d’enfiler ses baskets, d’ouvrir la porte, et de courir vers soi-même. La course matinale, c’est ton moment à toi.</p>\r\n<p><span> </span></p>', '2025-07-11 13:17:17', '2025-07-16 08:58:05', 37, 'publie', 'uploads/articles/thumb_1752649083_news3.jpg', 'uploads/articles/medium_1752649083_news3.jpg', 'uploads/articles/large_1752649083_news3.jpg', 'uploads/articles/small_1752649083_news3.jpg', 'Homme courant sur une promenade urbaine au lever du soleil, avec un pont métallique en arrière-plan.'),
(63, 'Sculpter son corps : La puissance de la discipline en musculation', '<p>Dans une salle de sport, chaque mouvement raconte une histoire. Celle du dépassement de soi, de la persévérance, et de l’envie de se transformer — non seulement physiquement, mais aussi mentalement. Au Studio, nous croyons que la musculation n’est pas qu’une affaire de performance : c’est un engagement profond envers soi-même.</p>\r\n<p>L’image de cet athlète, seul dans la pénombre, concentré sur son curl biceps, capture parfaitement cette ambiance unique que l’on retrouve dans nos espaces d\'entraînement. Une lumière tamisée, une atmosphère de focus total, un moment suspendu entre effort et maîtrise.</p>\r\n<p>Chez nous, chaque adhérent est accompagné dans son parcours, quel que soit son niveau. Des programmes personnalisés, un matériel de qualité, et une communauté bienveillante offrent le cadre idéal pour progresser à son rythme.</p>\r\n<p>Que vous soyez passionné de bodybuilding, amateur de remise en forme ou simplement en quête d’équilibre, notre studio est un lieu d’expression pour votre corps et votre volonté!</p>', '2025-07-15 16:45:15', '2025-07-16 15:23:38', 1, 'publie', 'uploads/articles/1752594883_wp11588672.jpg', 'uploads/articles/1752594883_wp11588672.jpg', 'uploads/articles/1752594883_wp11588672.jpg', 'uploads/articles/1752594883_wp11588672.jpg', 'Homme athlétique réalisant un exercice de musculation en salle, illustrant la concentration et la discipline dans l’univers du sport en studio.'),
(67, 'Ceci est un titre test ', '<p>Voici un contenu texte</p>', '2025-07-16 10:45:26', NULL, 1, 'publie', 'uploads/articles/thumb_1752655524_Pngtreeanoldgymsettingwith_2667256.jpg', 'uploads/articles/medium_1752655524_Pngtreeanoldgymsettingwith_2667256.jpg', 'uploads/articles/large_1752655524_Pngtreeanoldgymsettingwith_2667256.jpg', 'uploads/articles/small_1752655524_Pngtreeanoldgymsettingwith_2667256.jpg', 'une descriptrion'),
(78, 'zertyuiopazertyuiosdfg', '<p>zertyuiosdfghjkvbn</p>', '2025-07-16 14:16:14', NULL, 1, 'publie', 'uploads/articles/thumb_1752668173_AmongTreesScreenshot.png', 'uploads/articles/medium_1752668173_AmongTreesScreenshot.png', 'uploads/articles/large_1752668173_AmongTreesScreenshot.png', 'uploads/articles/small_1752668173_AmongTreesScreenshot.png', '');

-- --------------------------------------------------------

--
-- Structure de la table `coachs`
--

DROP TABLE IF EXISTS `coachs`;
CREATE TABLE IF NOT EXISTS `coachs` (
  `id_coach` int NOT NULL AUTO_INCREMENT,
  `nom_coach` varchar(100) NOT NULL,
  `prenom_coach` varchar(100) NOT NULL,
  `email_coach` varchar(150) NOT NULL,
  `telephone_coach` varchar(20) DEFAULT NULL,
  `adresse_coach` varchar(255) DEFAULT NULL,
  `photo_coach` varchar(255) DEFAULT NULL,
  `description_coach` text,
  `specialite_coach` varchar(100) DEFAULT NULL,
  `actif` enum('oui','non') DEFAULT 'oui',
  `date_recrutement` date DEFAULT NULL,
  PRIMARY KEY (`id_coach`),
  UNIQUE KEY `email_coach` (`email_coach`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `coachs`
--

INSERT INTO `coachs` (`id_coach`, `nom_coach`, `prenom_coach`, `email_coach`, `telephone_coach`, `adresse_coach`, `photo_coach`, `description_coach`, `specialite_coach`, `actif`, `date_recrutement`) VALUES
(1, 'Diaz', 'Antoine', 'antoine.diaz@example.com', '0601020304', '10 rue des coachs, Paris', 'assets/images/bdd/photo_prof.jpg', 'Avec moi, chaque goutte de sueur est un pas de plus vers ta meilleure version.', 'Musculation', 'oui', '2023-09-01');

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id_contact` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `surname_contact` varchar(255) DEFAULT NULL,
  `email_contact` varchar(255) DEFAULT NULL,
  `subject_contact` varchar(255) DEFAULT NULL,
  `creationdate_contact` date DEFAULT NULL,
  `status_contact` enum('nouveau','lu','répondu') DEFAULT NULL,
  `message_contact` text,
  `phone_contact` varchar(20) DEFAULT NULL,
  `reponse_contact` text,
  PRIMARY KEY (`id_contact`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `contacts`
--

INSERT INTO `contacts` (`id_contact`, `name`, `surname_contact`, `email_contact`, `subject_contact`, `creationdate_contact`, `status_contact`, `message_contact`, `phone_contact`, `reponse_contact`) VALUES
(1, 'jean', 'dupont', 'jean.dupont@email.com', 'Demande d\'information produit', '0000-00-00', 'répondu', 'Bonjour,\r\n\r\nJe souhaiterais obtenir plus d\'informations concernant votre nouveau produit lancé récemment. Pourriez-vous me faire parvenir la documentation technique ainsi que les tarifs ?\r\n\r\nCordialement,\r\nJean Dupont', '0601020304', 'voici ma réponse'),
(2, 'Marie', 'Leblanc', 'marie.leblanc@email.com', 'Support Technique', '0000-00-00', 'répondu', 'Bonjour,\r\n\r\nJe souhaiterais obtenir plus d\'informations concernant votre nouveau produit lancé récemment. Pourriez-vous me faire parvenir la documentation technique ainsi que les tarifs ?\r\n\r\nCordialement,\r\nMarie Leblanc', '0612131415', 'voici une réponse pour vous'),
(3, 'Martin', 'Pierre', 'pierre.martin@email.com', 'Réclamation commande', '0000-00-00', 'répondu', 'Bonjour,\r\n\r\nJe souhaiterais obtenir plus d\'informations concernant votre nouveau produit lancé récemment. Pourriez-vous me faire parvenir la documentation technique ainsi que les tarifs ?\r\n\r\nCordialement,\r\nPierre Martin', '0625287954', NULL),
(4, 'sophie', 'bernard', 'sophie.bernard@email.com', 'Partenariat commercial', '0000-00-00', 'répondu', 'Bonjour,\r\n\r\nJe souhaiterais obtenir plus d\'informations concernant votre nouveau produit lancé récemment. Pourriez-vous me faire parvenir la documentation technique ainsi que les tarifs ?\r\n\r\nCordialement,\r\nSophie Bernard', '0654515253', 'salut'),
(5, 'Antoine', 'Legrand', 'antoine.legrand@email.com', 'Question facturation', '0000-00-00', 'répondu', 'Bonjour,\r\n\r\nJe souhaiterais obtenir plus d\'informations concernant votre nouveau produit lancé récemment. Pourriez-vous me faire parvenir la documentation technique ainsi que les tarifs ?\r\n\r\nCordialement,\r\nAntoine Legrand', '064758469', 'voici un message plein d\'amour'),
(16, 'Tata', 'Suzanne', 'tata@suzanne.net', 'Inscription de la sexy Suzanne', '2025-07-04', 'répondu', 'Bonjour les jeunes,\r\n\r\nC’est Tata Suzanne, 78 ans, toujours fringante et bien décidée à botter les fesses du temps qui passe ! Je cherche une salle de sport où je peux m’inscrire et révéler la beauté fatal qui sommeil en moi.\r\nAppelez-moi vite avant que je change d’avis (ou que je me mette au tricot).\r\n\r\nFuture sportive rugissante,\r\n\r\nTata Suzanne', '0102030405', 'Objet : Re: Inscription d’une mamie musclée en devenir (Tata Suzanne)\r\n\r\nBonjour Tata Suzanne,\r\n\r\nVotre message a fait trembler notre boîte mail (et rougir nos coachs !).\r\nOn vous attend de pied ferme à la salle, avec un tapis de sol, un bon café… et des jeunes hommes déjà prévenus de votre arrivée tonitruante .\r\n\r\nPlus sérieusement, ce sera un réel plaisir de vous accueillir. N’hésitez pas à passer quand vous voulez pour une visite ou pour qu’on vous prépare un programme sur mesure — à votre rythme (ou au nôtre si vous décidez de mener la cadence !).\r\n\r\nÀ très vite,\r\nSportivement vôtre,\r\n\r\nL\'équipe du Studio GYMS\r\n 04 00 00 00 00\r\n 427 rue du Mistral, Bédarrides\r\n contact@le-studio-gyms.fr'),
(17, 'Explode', 'Loïc', 'Loic@explode.boum', 'Besoin d’une salle où je peux me défouler sans faire exploser les murs', '2025-07-04', 'répondu', 'Bonjour,\r\n\r\nJ’ai l’habitude de me lever tôt, de pousser fort et de transpirer pour le plaisir. Je cherche une salle qui ne tremble pas quand je fais du squat et où les haltères ne pleurent pas à la première série.\r\n\r\nJe veux un cadre sérieux, une bonne ambiance, et du matériel qui tient la route (et mes charges). Si en bonus, il y a des coachs qui aiment les défis, je signe tout de suite.\r\n\r\nFaut que ça tape, que ça sue, mais toujours avec respect.\r\nDites-moi quand je peux passer pour faire connaissance… et casser un peu de routine !\r\n\r\nSportivement,\r\n\r\nLoïc\r\n(Je promets de ne rien exploser… au moins au premier rendez-vous.)', '0102030405', 'Bonjour Loïc,\r\n\r\nOn a lu votre message en position gainage, par respect.\r\nIci, on aime les gens qui transpirent avec conviction et qui ont du vécu dans les mollets.\r\n\r\nNotre salle est équipée pour encaisser de la fonte, des cris de guerre, et des circuits qui piquent un peu. Pas de machines fragiles ni de miroirs pour faire les beaux – juste du vrai, du solide et de la sueur partagée.\r\n\r\nVous êtes le bienvenu pour une séance découverte quand vous voulez. On vous fera visiter les lieux, vous présenter l’équipe, et tester le matériel (mais merci d’éviter les explosions le premier jour, nos assurances sont encore en cours de digestion ).\r\n\r\nÀ très bientôt dans l’arène,\r\n\r\nL’équipe du Studio GYMS\r\n04 00 00 00 00\r\n427 rue du Mistral, Bédarrides\r\ncontact@le-studio-gyms.fr'),
(18, 'Mushmush', 'Julien', 'juju@mushforever.pasnet', 'Un corps de bambou, une âme de champignon – Besoin de bouger', '2025-07-04', 'répondu', 'Bonjour à vous,\r\n\r\nExplorateur de l’esprit (et ancien danseur de forêt, à ce qu’il paraît). Je n’ai pas mis les pieds dans une salle de sport depuis la dernière éclipse lunaire — mais mon corps, élancé comme un bambou zen, me dit qu’il est temps de réveiller les muscles oubliés.\r\n\r\nJe cherche une salle bienveillante, pas trop militaire (je laisse ça à Loïc), avec des gens qui n’ont pas peur de l’étrange et de l’inattendu. J’aimerais faire du renforcement, de la mobilité, et peut-être, un jour, réussir un squat sans avoir l’air d’un héron blessé.\r\n\r\nJe suis motivé, curieux, et ouvert à toute proposition sportive tant qu’on ne me demande pas de courir un marathon au premier rendez-vous.\r\nAlors… on se voit bientôt dans le dojo de la transpiration ?\r\n\r\nPaix, muscles et bonne humeur,\r\nJulien', '0102030405', 'Bonjour Julien,\r\n\r\nVotre message nous a soufflé un vent de fraîcheur… et peut-être un léger parfum de forêt enchantée \r\nUn corps de bambou et une âme d’explorateur ? C’est exactement ce qu’il nous manquait pour rééquilibrer nos énergies entre les haltères qui hurlent et les squats de Loïc.\r\n\r\nIci, on accueille tous les profils : les costauds, les novices, les yogis de l’espace et même ceux qui ont médité un peu trop longtemps avant de revenir au monde physique.\r\n\r\nOn vous propose de venir découvrir la salle, poser vos questions, sentir l’ambiance (promis, pas d’odeur de champignon), et peut-être, qui sait, réveiller doucement ce corps qui sommeille sans le brusquer.\r\n\r\nAu plaisir de vous rencontrer,\r\nÉquilibrément vôtre,\r\n\r\nL’équipe du Studio GYMS\r\n04 00 00 00 00\r\n427 rue du Mistral, Bédarrides\r\ncontact@le-studio-gyms.fr'),
(19, 'Veilleur', 'Eddy', 'Eddy@lecodeurfou.com', 'Recherche salle de sport en version stable (sans bug, sans déco, sans obsolescence)', '2025-07-04', 'répondu', 'Bonjour,\r\n\r\nJe suis Eddy, 41 ans, passionné de code propre, de documentation à jour et de sport… enfin, disons que le sport était en pause (comme certaines dépendances trop lourdes à mettre à jour).\r\n\r\nAujourd’hui, j’ai décidé de sortir du mode sombre, d’updater mon corps et de reprendre la main sur ma santé. Je cherche une salle de sport à jour, bien structurée, sans éléments dépréciés (oui, je parle aussi des machines grinçantes et des playlists des années 2000).\r\n\r\nJe suis motivé, régulier, un peu obsédé par l’optimisation, mais promis, je ne vais pas auditer votre back-office (sauf si vous le demandez ).\r\n\r\nDites-moi si votre salle est compatible avec mon besoin de rigueur… et d’un peu de sueur.\r\n\r\nÀ bientôt j’espère,\r\nEddy\r\n#NoMoreDeprecatedFunctions', '0102030405', 'dgfjdfgjfgj'),
(20, 'Garcia', 'José', 'jose@garcia.com', 'Demande de formule', '2025-07-14', 'nouveau', 'je voudrais connaître l\'ensemble de vos tarifs', '0601020304', NULL),
(21, 'Garcia', 'José', 'jose@garcia.com', 'Demande de formule', '2025-07-14', 'nouveau', 'je voudrais connaître l\'ensemble de vos tarifs', '0601020304', NULL),
(22, 'Garcia', 'José', 'jose@garcia.com', 'Demande de formule', '2025-07-14', 'nouveau', 'je voudrais connaître l\'ensemble de vos tarifs', '0601020304', NULL),
(23, 'Garcia', 'José', 'jose@garcia.com', 'Demande de formule', '2025-07-14', 'nouveau', 'je voudrais connaître l\'ensemble de vos tarifs', '0601020304', NULL),
(24, 'Garcia', 'José', 'jose@garcia.com', 'Demande de formule', '2025-07-14', 'nouveau', 'je voudrais connaître l\'ensemble de vos tarifs', '0601020304', NULL),
(25, 'Garcia', 'José', 'jose@garcia.com', 'Demande de formule', '2025-07-14', 'nouveau', 'je voudrais connaître l\'ensemble de vos tarifs', '0601020304', NULL),
(26, 'Garcia', 'José', 'jose@garcia.com', 'Demande de formule', '2025-07-14', 'nouveau', 'je voudrais connaître l\'ensemble de vos tarifs', '0601020304', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `name_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `surname_user` varchar(255) DEFAULT NULL,
  `email_user` varchar(255) DEFAULT NULL,
  `password_user` varchar(255) NOT NULL,
  `role_user` enum('Administrateur','Utilisateur','Modérateur') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Utilisateur',
  `subscriptiondate_user` date DEFAULT NULL,
  `status_user` enum('actif','inactif','suspendu') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'actif',
  `profilphoto_user` varchar(255) NOT NULL,
  `subscriptionpackage_user` varchar(50) NOT NULL,
  `subscriptionend_user` date NOT NULL,
  `lastconnexion_user` datetime NOT NULL,
  `coachid_user` int DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  KEY `coach_id` (`coachid_user`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `name_user`, `surname_user`, `email_user`, `password_user`, `role_user`, `subscriptiondate_user`, `status_user`, `profilphoto_user`, `subscriptionpackage_user`, `subscriptionend_user`, `lastconnexion_user`, `coachid_user`) VALUES
(1, 'Admin ', 'Demo', 'admin@admin.com', '$2y$10$1za7ydilmYVwTz8s1sH9OekysMxswahK173.jQ.mkPTCtJOpYyYHi', 'Administrateur', '0000-00-00', 'actif', '', '', '0000-00-00', '2025-07-15 14:02:46', NULL),
(2, 'Maurice', 'Aïden', 'jojolafofolle@gmail.com', '', 'Utilisateur', '0000-00-00', 'inactif', '', '', '0000-00-00', '0000-00-00 00:00:00', NULL),
(6, 'testeur', 'Henry', 'henry.testeur@example.com', '$2y$10$YyYvsT2uKEtSlKJG16Y36Of7Gaswr4VZWBqYSLEYwzpOH3n5jw/iW', 'Utilisateur', '2025-06-28', 'suspendu', 'assets/img/bdd/photo_user_test.jpg', 'Premium', '2025-12-31', '2025-06-28 16:32:28', 1),
(10, 'Gaby', 'Framboise', 'gaby@sfr.fr', '', 'Utilisateur', '2025-07-03', 'actif', '', '', '0000-00-00', '0000-00-00 00:00:00', NULL),
(11, 'Karyna ', 'vodka', 'karyna@vodkaforever.com', '', 'Utilisateur', '2025-07-03', 'actif', '', '', '0000-00-00', '0000-00-00 00:00:00', NULL),
(12, 'Sabrina', 'jenecomprendspas', 'sabforwhy@bbox.fr', '', 'Utilisateur', '2025-07-03', 'inactif', '', '', '0000-00-00', '0000-00-00 00:00:00', NULL),
(13, 'loic', 'pierron', 'loic@gmail.co', '', 'Utilisateur', '2025-07-03', 'inactif', '', '', '0000-00-00', '0000-00-00 00:00:00', NULL),
(14, 'Geoffrey', 'Contat', 'geoffrey.contat22@gmail.com', '$2y$10$sPSs/wjm5Lrc9lENzfEbxuDW5/dqtBstiCGte/ydRCHA.GcB9B24W', 'Modérateur', '2025-07-03', 'actif', '', '', '0000-00-00', '0000-00-00 00:00:00', NULL),
(15, 'Geoffrey', 'Contat', 'geoffrey.contat22@gmail.com', '$2y$10$XMIWYhRRd1kf5lpbpgzZJ.KnqMG.Zy/qB4WNafU.bLE9iph5OauvW', 'Utilisateur', '2025-07-03', 'actif', '', '', '0000-00-00', '0000-00-00 00:00:00', NULL),
(16, 'juju', 'lefoufou', 'jujufolie@hotmail.fr', '$2y$10$wuDzLUk3ecXeShUAHxMPyu9G1EIu5JbcSM0q5UukW22lvK91hToHq', 'Utilisateur', '2025-07-03', 'actif', '', '', '0000-00-00', '0000-00-00 00:00:00', NULL),
(17, 'greg', 'matador', 'greg@gg.fr', 'Gy+eMcDNIc8r', 'Utilisateur', '2025-07-03', 'actif', '', '', '0000-00-00', '0000-00-00 00:00:00', NULL),
(18, 'pierre', 'test', 'ptest@gmail.com', '$2y$10$jX7vYE62NLtC22Vaz/ESbesBA4qQdc5NhRT7eMp3x87xYZ0DvcEPe', 'Utilisateur', '2025-07-03', 'actif', '', '', '0000-00-00', '0000-00-00 00:00:00', NULL),
(21, 'test789', 'test789', 'test789@test.com', '$2y$10$2.ZjDHel0p5tfB5XHrGky.90vkBULz0/n63Hzu/gFiDWnOXxi063O', 'Utilisateur', '2025-07-03', 'actif', '', '', '0000-00-00', '0000-00-00 00:00:00', NULL),
(22, 'joseline', 'chanchiu', 'joseline@test.com', '$2y$10$Ac5wGqkSWz.dG7mmiqFQdubU.hGj5yiW7c4ia92lsntwCpy9Q4LhW', 'Utilisateur', '2025-07-03', 'inactif', '', '', '0000-00-00', '0000-00-00 00:00:00', NULL),
(23, 'momo', 'momo', 'momo@test.com', '$2y$10$P0E1UXkOX5ImxBIWuaWfk.wX91JmiN.WVS.ac3QdCp.OaewO100ja', 'Utilisateur', '2025-07-03', 'actif', '', '', '0000-00-00', '0000-00-00 00:00:00', NULL),
(24, 'johan', 'legrand', 'johan@gg.com', '$2y$10$UbrIwHxkM4sE0DnWRf3rQOgWnh6hDYZebNbaABaHVgROmK6olFpOq', 'Utilisateur', '2025-07-03', 'actif', '', '', '0000-00-00', '0000-00-00 00:00:00', NULL),
(28, 'mohamed', 'momo', 'momo@contact.com', '$2y$10$4VWxn1rqiWYJJsBwUEMNMui2WyvDSXF9ySnfZMsxesWrK4HHQxIYu', 'Modérateur', '2025-07-03', 'actif', '', '', '0000-00-00', '0000-00-00 00:00:00', NULL),
(29, 'tatasuzanne', 'tata', 'tatathebest@testr.gr', '$2y$10$/y/2.7yYuk4EfyKTHGMe2eBWkFb2i8lLIfLnfHlP1Fy/0zFBvaGRS', 'Administrateur', '2025-07-03', 'actif', '', '', '0000-00-00', '0000-00-00 00:00:00', NULL),
(30, 'Alix', 'Tavernier', 'alix@tavernier.com', '$2y$10$SqByDZyElEpSSs8GLW8J0.NTyqIOGOPxu0jjbLbjxGXpRfAZnYJN2', 'Utilisateur', '2025-07-09', 'actif', '', '', '0000-00-00', '0000-00-00 00:00:00', NULL),
(31, 'Alix', 'Tavernier', 'alix@tavernier.com', '$2y$10$LXm1yInkAItiJmU9JsnKbeg4od/8lVZMXZ5goT4OYf2lwbXrdhILW', 'Modérateur', '2025-07-09', 'actif', '', '', '0000-00-00', '0000-00-00 00:00:00', NULL),
(33, 'André', 'Bocelli', 'andre@bocelli.com', '$2y$10$vtjFwZqWf8TGhru33d.aLO26p5Dsj4RkZoSWkRcfQcRs4F8XN7GuS', 'Utilisateur', '2025-07-09', 'actif', '', '', '0000-00-00', '0000-00-00 00:00:00', NULL),
(36, 'keen', 'donre', 'ken@hgt.com', '$2y$10$ayLWn2cYJUEvyjYvvaoyXul9Hi6QwqTM0YArSVDlKKRGE3etGrh96', 'Utilisateur', '2025-07-09', 'actif', '', '', '0000-00-00', '0000-00-00 00:00:00', NULL),
(37, 'modo', 'modo', 'modo@modo.com', '$2y$10$qpB7hDGzcSsuXtrxEHc9RO.zMgyKJLUaiWzdI8.NhNmICqdnBruQ2', 'Modérateur', '2025-07-10', 'actif', '', '', '0000-00-00', '2025-07-15 12:35:19', NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`coachid_user`) REFERENCES `coachs` (`id_coach`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
