DROP DATABASE IF EXISTS `pointfinal`;

CREATE DATABASE `pointfinal`;

USE `pointfinal`;

CREATE TABLE
    `role` (
        `id` int (10) unsigned NOT NULL AUTO_INCREMENT,
        `nom` varchar(50) NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `nom_UNIQUE` (`nom`)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE
    `utilisateur` (
        `id` int (10) unsigned NOT NULL AUTO_INCREMENT,
        `nom_utilisateur` varchar(50) NOT NULL,
        `prenom` varchar(50) NOT NULL,
        `nom` varchar(50) NOT NULL,
        `bio` varchar(255) NOT NULL,
        `date_creation` date NOT NULL DEFAULT NOW(),
        `role_id` int (10) unsigned NOT NULL,
        `url_avatar` text NOT NULL,
        `hash` varchar(255) NOT NULL,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
        UNIQUE KEY `nom_utilisateur_UNIQUE` (`nom_utilisateur`)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE
    `jeu` (
        `id` int (10) unsigned NOT NULL AUTO_INCREMENT,
        `nom` varchar(50) NOT NULL,
        `url_jeu` text NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `nom_UNIQUE` (`nom`)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE
    `partie` (
        `id` int (10) unsigned NOT NULL AUTO_INCREMENT,
        `date_creation` datetime NOT NULL DEFAULT NOW(),
        `j1_id` int (10) unsigned NOT NULL,
        `j2_id` int (10) unsigned NOT NULL,
        `j1_score` int (10) unsigned NOT NULL,
        `j2_score` int (10) unsigned NOT NULL,
        `jeu_id` int (10) unsigned NOT NULL,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`j1_id`) REFERENCES `utilisateur` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
        FOREIGN KEY (`j2_id`) REFERENCES `utilisateur` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
        FOREIGN KEY (`jeu_id`) REFERENCES `jeu` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;


INSERT INTO `role` VALUES(NULL, 'Administrateur');
INSERT INTO `role` VALUES(NULL, 'Joueur');

-- Le mot de passe a été haché avec password_hash(), il correspond à 'bonjour'
INSERT INTO `utilisateur` VALUES(NULL, 'root', 'Chuck', 'Norris', 'Je ne peux pas jouer, car le site ne supporte pas une infinie de victoires...', '2025-01-01', 1, 'https://hips.hearstapps.com/hmg-prod/images/gettyimages-150327735-copy.jpg', '$2y$10$HYeLAxdInF2N6tGbYKYqBOpAcnXyPX9.hgHMnjb7PJOUnlqUm7Qqu');
INSERT INTO `utilisateur` VALUES(NULL, 'monchampf', 'Frédéric', 'Monchamp', 'Les joysticks de l''arcade ne fonctionnent pas bien!', '2025-01-13', 2, 'https://images.8tracks.com/cover/i/002/169/964/794a9f4756dd2758881b3e8c4268753a-9706.jpg', '$2y$10$R4EJjPN2jGiQYwGGq7X2Pu0F0DKinUtdL90YrKzbLTnNdt/ys/cEi');
INSERT INTO `utilisateur` VALUES(NULL, 'belangermc', 'Marie-Christine', 'Bélanger', 'Je rage tout le temps!', '2025-01-15', 2, 'https://i.imgflip.com/1owdwf.jpg', '$2y$10$R4EJjPN2jGiQYwGGq7X2Pu0F0DKinUtdL90YrKzbLTnNdt/ys/cEi');
INSERT INTO `utilisateur` VALUES(NULL, 'bourren', 'Nicolas', 'Bourre', 'J''ai fait un programme qui joue à ma place!', '2025-01-16', 2, 'https://www.2020mag.com/CMSImagesContent/2014/9/Guy-Nerd-glasses_w.png', '$2y$10$R4EJjPN2jGiQYwGGq7X2Pu0F0DKinUtdL90YrKzbLTnNdt/ys/cEi');
INSERT INTO `utilisateur` VALUES(NULL, 'amyotl', 'Lyne', 'Amyot', 'Je ne joue jamais!', '2025-01-17', 2, 'https://play.nintendo.com/images/profile-mk-peach.7bf2a8f2.aead314d58b63e27.png', '$2y$10$R4EJjPN2jGiQYwGGq7X2Pu0F0DKinUtdL90YrKzbLTnNdt/ys/cEi');
INSERT INTO `utilisateur` VALUES(NULL, 'hoffmanj', 'James', 'Hoffman', 'C''est moi qui a programmé tous les jeux!', '2025-01-18', 2, 'https://cdn2.vectorstock.com/i/1000x1000/93/06/geek-nerd-guy-vector-7669306.jpg', '$2y$10$R4EJjPN2jGiQYwGGq7X2Pu0F0DKinUtdL90YrKzbLTnNdt/ys/cEi');
INSERT INTO `utilisateur` VALUES(NULL, 'styvesm', 'Mathieu', 'St-Yves', 'Si ce n''est pas un jeu en réseau, je ne joue pas!', '2025-01-19', 2, 'https://pbs.twimg.com/profile_images/984802678449561600/P6fIGHuI_400x400.jpg', '$2y$10$R4EJjPN2jGiQYwGGq7X2Pu0F0DKinUtdL90YrKzbLTnNdt/ys/cEi');
INSERT INTO `utilisateur` VALUES(NULL, 'guilmettem', 'Marco', 'Guilmette', 'C''est programmé en assembleur ces jeux-là?', '2025-01-20', 2, 'https://hips.hearstapps.com/hmg-prod/images/gettyimages-168967170.jpg?crop=0.608xw:0.506xh;0.192xw,0.170xh&resize=1200', '$2y$10$R4EJjPN2jGiQYwGGq7X2Pu0F0DKinUtdL90YrKzbLTnNdt/ys/cEi');
INSERT INTO `utilisateur` VALUES(NULL, 'dufresnema', 'Maude-Amélie', 'Dufresne', 'C''est un beau projet!', '2025-01-21', 2, 'https://ik.imagekit.io/yynn3ntzglc/cms/medium_Accroche_focus_shiba_inu_11d3f9ab4f_6E-rgSc0B.jpg', '$2y$10$R4EJjPN2jGiQYwGGq7X2Pu0F0DKinUtdL90YrKzbLTnNdt/ys/cEi');

INSERT INTO `jeu` VALUES(NULL, 'Tetris', 'https://s3.amazonaws.com/tetris-www1/assets/editorial/2022/12/tetris-logo.png');
INSERT INTO `jeu` VALUES(NULL, 'Street Figther', 'https://upload.wikimedia.org/wikipedia/commons/7/71/Street_Fighter_old_logo.png?20161222112755');
INSERT INTO `jeu` VALUES(NULL, 'Mortal Kombat', 'https://upload.wikimedia.org/wikipedia/en/thumb/b/b1/Mortal_Kombat_Logo.svg/1024px-Mortal_Kombat_Logo.svg.png');

INSERT INTO `partie` VALUES(NULL, '2025-01-22 13:01', 2, 3, 3, 2, 1);
INSERT INTO `partie` VALUES(NULL, '2025-01-23 14:11', 3, 4, 0, 3, 1);
INSERT INTO `partie` VALUES(NULL, '2025-01-23 13:41', 2, 5, 2, 3, 1);
INSERT INTO `partie` VALUES(NULL, '2025-02-01 15:22', 4, 6, 2, 3, 2);
INSERT INTO `partie` VALUES(NULL, '2025-02-04 08:30', 7, 8, 2, 1, 2);
INSERT INTO `partie` VALUES(NULL, '2025-02-05 12:32', 8, 9, 1, 1, 3);
INSERT INTO `partie` VALUES(NULL, '2025-02-05 16:24', 4, 3, 20, 0, 3);
INSERT INTO `partie` VALUES(NULL, '2025-02-07 13:45', 7, 9, 1, 1, 2);
INSERT INTO `partie` VALUES(NULL, '2025-02-08 17:08', 7, 2, 1, 1, 1);
INSERT INTO `partie` VALUES(NULL, '2025-02-09 12:12', 7, 5, 2, 1, 1);
INSERT INTO `partie` VALUES(NULL, '2025-02-09 22:44', 2, 6, 2, 2, 2);



