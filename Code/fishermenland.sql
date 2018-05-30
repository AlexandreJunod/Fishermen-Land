-- Author : Junod Alexandre
-- Date of creation : 16.05.2018
-- Summary : Database for the game Fishermen Land

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


DROP SCHEMA IF EXISTS fishermenland;
CREATE SCHEMA fishermenland;

-- -----------------------------------------------------
-- Table fishermenland.type
-- Contains the different types of games
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS fishermenland.type (
  idType INT(11) NOT NULL AUTO_INCREMENT,
  DescriptionType VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (idType),
  UNIQUE INDEX idType_UNIQUE (idType ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table fishermenland.game
-- Contains the differents games
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS fishermenland.game (
  idGame INT(11) NOT NULL AUTO_INCREMENT,
  LakeFishesGame  INT(11) NOT NULL,
  LakeReproductionGame  INT(11) NOT NULL,
  PondReproductionGame  INT(11) NOT NULL,
  EatFishesGame INT(11) NOT NULL, 
  FirstPlayerGame VARCHAR(45) NULL DEFAULT NULL,
  TourGame INT(11) NULL DEFAULT NULL,
  SeasonTourGame INT(11) NOT NULL,
  MaxPlayersGame INT(11) NOT NULL,
  MaxReleaseGame INT(11) NULL DEFAULT NULL,
  fkTypeGame INT(11) NOT NULL,
  PRIMARY KEY (idGame),
  UNIQUE INDEX idGame_UNIQUE (idGame ASC),
  INDEX fk_Game_Type1_idx (fkTypeGame ASC),
  CONSTRAINT fk_Game_Type1
    FOREIGN KEY (fkTypeGame)
    REFERENCES fishermenland.type (idType)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table fishermenland.player
-- Contains the datas of the players
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS fishermenland.player (
  idPlayer INT(11) NOT NULL AUTO_INCREMENT,
  PseudoPlayer VARCHAR(45) NOT NULL,
  PasswordPlayer VARCHAR(45) NOT NULL,
  RankingPlayer VARCHAR(45) NULL DEFAULT NULL,
  AdminPlayer BOOLEAN DEFAULT 0,
  PRIMARY KEY (idPlayer),
  UNIQUE INDEX idPlayer_UNIQUE (idPlayer ASC),
  UNIQUE INDEX PseudoPlayer_UNIQUE (PseudoPlayer ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table fishermenland.history
-- Containe the history of the games of all players
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS fishermenland.history (
  idHistory INT NOT NULL AUTO_INCREMENT,
  ScoreHistory VARCHAR(45) NOT NULL,
  fkPlayerHistory INT(11) NOT NULL,
  PRIMARY KEY (idHistory),
  UNIQUE INDEX idHistory_UNIQUE (idHistory ASC),
  INDEX fk_history_player1_idx (fkPlayerHistory ASC),
  CONSTRAINT fk_history_player1
    FOREIGN KEY (fkPlayerHistory)
    REFERENCES fishermenland.player (idPlayer)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table fishermenland.status
-- Contains the assignable status to the players
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS fishermenland.status (
  idStatus INT(11) NOT NULL AUTO_INCREMENT,
  DescriptionStatus VARCHAR(45) NOT NULL,
  PRIMARY KEY (idStatus),
  UNIQUE INDEX idStatus_UNIQUE (idStatus ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table fishermenland.place
-- Contains the places used by the players to join a game
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS fishermenland.place (
  idPlace INT(11) NOT NULL AUTO_INCREMENT,
  PondFishesPlace VARCHAR(45) NOT NULL,
  FishedFishesPlace VARCHAR(45) NOT NULL,
  ReleasedFishesPlace VARCHAR(45) NOT NULL,
  OrderPlace INT(11) NOT NULL,
  fkPlayerPlace INT(11) NOT NULL,
  fkStatusPlace INT(11) NOT NULL,
  fkGamePlace INT(11) NOT NULL,
  PRIMARY KEY (idPlace),
  UNIQUE INDEX idPlace_UNIQUE (idPlace ASC),
  UNIQUE INDEX fkPlayerPlace_UNIQUE (fkPlayerPlace ASC),
  INDEX fk_Place_Player_idx (fkPlayerPlace ASC),
  INDEX fk_Place_Status1_idx (fkStatusPlace ASC),
  INDEX fk_Place_Game1_idx (fkGamePlace ASC),
  CONSTRAINT fk_Place_Game1
    FOREIGN KEY (fkGamePlace)
    REFERENCES fishermenland.game (idGame)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_Place_Player
    FOREIGN KEY (fkPlayerPlace)
    REFERENCES fishermenland.player (idPlayer)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_Place_Status1
    FOREIGN KEY (fkStatusPlace)
    REFERENCES fishermenland.status (idStatus)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table fishermenland.settings
-- Contains the different setting who could be changed on the settings page
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS fishermenland.settings (
  idSettings INT(11) NOT NULL AUTO_INCREMENT,
  NameSettings VARCHAR(45) NULL DEFAULT NULL,
  ValueInt INT(11) NULL DEFAULT NULL,
  ValueDate DATETIME NULL DEFAULT NULL,
  ValueChar VARCHAR(45) NULL DEFAULT NULL,
  DescriptionSettings VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (idSettings),
  UNIQUE INDEX idSettings_UNIQUE (idSettings ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- Add 40 player, used for test
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer, AdminPlayer) VALUES ('Alexandre', MD5('Alexandre'), '1');
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Mikel1', MD5('Mikel1'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Stuart', MD5('Stuart'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer, AdminPlayer) VALUES ('Jeremy', MD5('Jeremy'), '1');
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Jarod1', MD5('Jarod1'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Kevin1', MD5('Kevin1'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Senistan', MD5('Senistan'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer, AdminPlayer) VALUES ('Michel', MD5('Michel'), '1');
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Vincent', MD5('Vincent'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Antonio', MD5('Antonio'));

INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest1', MD5('Guest1'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest2', MD5('Guest2'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest3', MD5('Guest3'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest4', MD5('Guest4'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest5', MD5('Guest5'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest6', MD5('Guest6'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest7', MD5('Guest7'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest8', MD5('Guest8'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest9', MD5('Guest9'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest10', MD5('Guest10'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest11', MD5('Guest11'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest12', MD5('Guest12'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest13', MD5('Guest13'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest14', MD5('Guest14'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest15', MD5('Guest15'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest16', MD5('Guest16'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest17', MD5('Guest17'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest18', MD5('Guest18'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest19', MD5('Guest19'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest20', MD5('Guest20'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest21', MD5('Guest21'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest22', MD5('Guest22'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest23', MD5('Guest23'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest24', MD5('Guest24'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest25', MD5('Guest25'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest26', MD5('Guest26'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest27', MD5('Guest27'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest28', MD5('Guest28'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest29', MD5('Guest29'));
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer) VALUES ('Guest30', MD5('Guest30'));

-- Add the different types of game
INSERT INTO fishermenland.type (DescriptionType) VALUES ('Coopératif');
INSERT INTO fishermenland.type (DescriptionType) VALUES ('Imposition');
INSERT INTO fishermenland.type (DescriptionType) VALUES ('Imposition avec forfait');

-- Add the settings
INSERT INTO fishermenland.settings (NameSettings, ValueInt, DescriptionSettings) VALUES ('MaxPlayers', '6', 'Nombre de joueurs max dans une partie');
INSERT INTO fishermenland.settings (NameSettings, ValueInt, DescriptionSettings) VALUES ('DefaultLakeFishes', '60', 'Nombre de poissons dans le lac');
INSERT INTO fishermenland.settings (NameSettings, ValueInt, DescriptionSettings) VALUES ('DefaulPondFishes', '3', 'Nombre de poissons par défault dans l\'étang');
INSERT INTO fishermenland.settings (NameSettings, ValueInt, DescriptionSettings) VALUES ('ReleaseMax', '3', 'Nombre max de poissons relâchés en mode imposition avec forfait');
INSERT INTO fishermenland.settings (NameSettings, ValueInt, DescriptionSettings) VALUES ('SeasonTour', '3', 'Nombre de tours dans une saison de pêche');
INSERT INTO fishermenland.settings (NameSettings, ValueInt, DescriptionSettings) VALUES ('LakeReproduction', '3', 'Reproduction dans le lac, 2 poissons en feront :');
INSERT INTO fishermenland.settings (NameSettings, ValueInt, DescriptionSettings) VALUES ('PondReproduction', '1', 'Reproduction dans l\'étang, 2 poissons en feront :');
INSERT INTO fishermenland.settings (NameSettings, ValueInt, DescriptionSettings) VALUES ('EatenFishes', '2', 'Nombre de poissons mangés par tour afin de survivre');
INSERT INTO fishermenland.settings (NameSettings, ValueInt, DescriptionSettings) VALUES ('NeededGameToRank', '3', 'Nombre de partie nécessaires pour être classé');

-- Add the status
INSERT INTO fishermenland.status (DescriptionStatus) VALUES ('En attente');
INSERT INTO fishermenland.status (DescriptionStatus) VALUES ('Joue');
INSERT INTO fishermenland.status (DescriptionStatus) VALUES ('Relâche des poissons');
INSERT INTO fishermenland.status (DescriptionStatus) VALUES ('Eliminé');

-- Create 6 games and put players in the game. Used for test
INSERT INTO fishermenland.game (LakeFishesGame, LakeReproductionGame, PondReproductionGame, EatFishesGame, FirstPlayerGame, TourGame, SeasonTourGame, MaxPlayersGame, MaxReleaseGame, fkTypeGame) VALUES ('450', '2', '2', '4', NULL, NULL, '18', '6', '25', '1');
INSERT INTO fishermenland.game (LakeFishesGame, LakeReproductionGame, PondReproductionGame, EatFishesGame, FirstPlayerGame, TourGame, SeasonTourGame, MaxPlayersGame, MaxReleaseGame, fkTypeGame) VALUES ('846', '4', '0', '8', 'Jarod1', '21', '30', '12', NULL, '2');
INSERT INTO fishermenland.game (LakeFishesGame, LakeReproductionGame, PondReproductionGame, EatFishesGame, FirstPlayerGame, TourGame, SeasonTourGame, MaxPlayersGame, MaxReleaseGame, fkTypeGame) VALUES ('211', '3', '1', '3', 'Jeremy', '1', '18', '8', NULL, '1');
INSERT INTO fishermenland.game (LakeFishesGame, LakeReproductionGame, PondReproductionGame, EatFishesGame, FirstPlayerGame, TourGame, SeasonTourGame, MaxPlayersGame, MaxReleaseGame, fkTypeGame) VALUES ('60', '3', '1', '2', 'Alexandre', NULL, '18', '6', NULL, '1'); 
INSERT INTO fishermenland.game (LakeFishesGame, LakeReproductionGame, PondReproductionGame, EatFishesGame, FirstPlayerGame, TourGame, SeasonTourGame, MaxPlayersGame, MaxReleaseGame, fkTypeGame) VALUES ('60', '3', '1', '2', 'Mikel1', NULL, '18', '6', NULL, '2');
INSERT INTO fishermenland.game (LakeFishesGame, LakeReproductionGame, PondReproductionGame, EatFishesGame, FirstPlayerGame, TourGame, SeasonTourGame, MaxPlayersGame, MaxReleaseGame, fkTypeGame) VALUES ('60', '3', '1', '2', 'Stuart', NULL, '18', '6', '10', '3'); 
INSERT INTO fishermenland.game (LakeFishesGame, LakeReproductionGame, PondReproductionGame, EatFishesGame, FirstPlayerGame, TourGame, SeasonTourGame, MaxPlayersGame, MaxReleaseGame, fkTypeGame) VALUES ('60', '3', '1', '2', 'Alexandre', NULL, '18', '6', '10', '2'); 

INSERT INTO fishermenland.place (PondFishesPlace, FishedFishesPlace, ReleasedFishesPlace, OrderPlace, fkPlayerPlace, fkStatusPlace, fkGamePlace) VALUES ('3', '0', '0', '0', '39', '1', '1');
INSERT INTO fishermenland.place (PondFishesPlace, FishedFishesPlace, ReleasedFishesPlace, OrderPlace, fkPlayerPlace, fkStatusPlace, fkGamePlace) VALUES ('3', '0', '0', '1', '38', '1', '1');
INSERT INTO fishermenland.place (PondFishesPlace, FishedFishesPlace, ReleasedFishesPlace, OrderPlace, fkPlayerPlace, fkStatusPlace, fkGamePlace) VALUES ('3', '0', '0', '2', '37', '1', '1');
INSERT INTO fishermenland.place (PondFishesPlace, FishedFishesPlace, ReleasedFishesPlace, OrderPlace, fkPlayerPlace, fkStatusPlace, fkGamePlace) VALUES ('3', '0', '0', '3', '36', '1', '1');
INSERT INTO fishermenland.place (PondFishesPlace, FishedFishesPlace, ReleasedFishesPlace, OrderPlace, fkPlayerPlace, fkStatusPlace, fkGamePlace) VALUES ('3', '0', '0', '4', '35', '1', '1');
INSERT INTO fishermenland.place (PondFishesPlace, FishedFishesPlace, ReleasedFishesPlace, OrderPlace, fkPlayerPlace, fkStatusPlace, fkGamePlace) VALUES ('87', '564', '0', '0', '34', '1', '2');
INSERT INTO fishermenland.place (PondFishesPlace, FishedFishesPlace, ReleasedFishesPlace, OrderPlace, fkPlayerPlace, fkStatusPlace, fkGamePlace) VALUES ('41', '234', '0', '1', '33', '1', '2');
INSERT INTO fishermenland.place (PondFishesPlace, FishedFishesPlace, ReleasedFishesPlace, OrderPlace, fkPlayerPlace, fkStatusPlace, fkGamePlace) VALUES ('341', '452', '0', '2', '32', '1', '2');
INSERT INTO fishermenland.place (PondFishesPlace, FishedFishesPlace, ReleasedFishesPlace, OrderPlace, fkPlayerPlace, fkStatusPlace, fkGamePlace) VALUES ('87', '564', '0', '0', '31', '1', '3');
INSERT INTO fishermenland.place (PondFishesPlace, FishedFishesPlace, ReleasedFishesPlace, OrderPlace, fkPlayerPlace, fkStatusPlace, fkGamePlace) VALUES ('41', '234', '0', '1', '30', '1', '3');
INSERT INTO fishermenland.place (PondFishesPlace, FishedFishesPlace, ReleasedFishesPlace, OrderPlace, fkPlayerPlace, fkStatusPlace, fkGamePlace) VALUES ('3', '0', '0', '0', '17', '1', '4');
INSERT INTO fishermenland.place (PondFishesPlace, FishedFishesPlace, ReleasedFishesPlace, OrderPlace, fkPlayerPlace, fkStatusPlace, fkGamePlace) VALUES ('3', '0', '0', '0', '14', '1', '5');
INSERT INTO fishermenland.place (PondFishesPlace, FishedFishesPlace, ReleasedFishesPlace, OrderPlace, fkPlayerPlace, fkStatusPlace, fkGamePlace) VALUES ('3', '0', '0', '1', '15', '1', '5');
INSERT INTO fishermenland.place (PondFishesPlace, FishedFishesPlace, ReleasedFishesPlace, OrderPlace, fkPlayerPlace, fkStatusPlace, fkGamePlace) VALUES ('3', '0', '0', '2', '12', '1', '6');
INSERT INTO fishermenland.place (PondFishesPlace, FishedFishesPlace, ReleasedFishesPlace, OrderPlace, fkPlayerPlace, fkStatusPlace, fkGamePlace) VALUES ('3', '0', '0', '0', '11', '1', '6');
INSERT INTO fishermenland.place (PondFishesPlace, FishedFishesPlace, ReleasedFishesPlace, OrderPlace, fkPlayerPlace, fkStatusPlace, fkGamePlace) VALUES ('3', '0', '0', '1', '13', '1', '6');


