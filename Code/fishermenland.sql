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
  RecordType VARCHAR(45) NULL DEFAULT NULL,
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
  FirstPlayerGame VARCHAR(45) NOT NULL,
  TourGame INT(11) NULL DEFAULT NULL,
  SeasonTourGame INT(11) NOT NULL,
  MaxPlayersGame INT(11) NOT NULL,
  MaxReleaseGame INT(11) NULL DEFAULT NULL,
  fkTypeGame INT(11) NOT NULL,
  PRIMARY KEY (idGame),
  UNIQUE INDEX idGame_UNIQUE (idGame ASC),
  UNIQUE INDEX FirstPlayer_UNIQUE (FirstPlayerGame ASC),
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

-- Add 1 player, used for test
INSERT INTO fishermenland.Player (PseudoPlayer, PasswordPlayer, AdminPlayer) VALUES ('Alexandre', MD5('Alexandre'), '1');

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

