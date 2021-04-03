DROP DATABASE IF EXISTS `ecommerce`;
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema ecommerce
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema ecommerce
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `ecommerce` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `ecommerce` ;

-- -----------------------------------------------------
-- Table `ecommerce`.`permesso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ecommerce`.`permesso` (
  `CodPermesso` INT NOT NULL,
  `NomePermesso` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`CodPermesso`),
  UNIQUE INDEX `NomePermesso_UNIQUE` (`NomePermesso` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`utente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ecommerce`.`utente` (
  `CodUtente` INT NOT NULL,
  `Nome` VARCHAR(45) NOT NULL,
  `Cognome` VARCHAR(45) NOT NULL,
  `DataNascita` DATE NOT NULL,
  `Password` VARCHAR(45) NOT NULL,
  `Email` VARCHAR(45) NOT NULL,
  `RefPermesso` INT NOT NULL,
  `Domanda` VARCHAR(255) NOT NULL,
  `Risposta` VARCHAR(255) NOT NULL,
  `PasswordCambiata` TINYINT NOT NULL DEFAULT 0,
  PRIMARY KEY (`CodUtente`),
  INDEX `RefPermesso_idx` (`RefPermesso` ASC) VISIBLE,
  CONSTRAINT `RefPermesso`
    FOREIGN KEY (`RefPermesso`)
    REFERENCES `ecommerce`.`permesso` (`CodPermesso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`indirizzoFatturazione`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ecommerce`.`indirizzoFatturazione` (
  `RefUtente` INT NOT NULL,
  `Indirizzo` VARCHAR(45) NOT NULL,
  `Citta` VARCHAR(45) NOT NULL,
  `CAP` VARCHAR(45) NOT NULL,
  `CodFatturazione` INT NOT NULL,
  `Preferito` TINYINT NOT NULL DEFAULT 1,
  PRIMARY KEY (`CodFatturazione`, `RefUtente`),
  CONSTRAINT `RefUtente`
    FOREIGN KEY (`RefUtente`)
    REFERENCES `ecommerce`.`utente` (`CodUtente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`indirizzoSpedizione`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ecommerce`.`indirizzoSpedizione` (
  `RefUtente` INT NOT NULL,
  `Indirizzo` VARCHAR(45) NOT NULL,
  `Citta` VARCHAR(45) NOT NULL,
  `CAP` VARCHAR(45) NOT NULL,
  `CodSpedizione` INT NOT NULL,
  `Preferito` TINYINT NOT NULL DEFAULT 1,
  PRIMARY KEY (`CodSpedizione`, `RefUtente`),
  CONSTRAINT `RefUtente1`
    FOREIGN KEY (`RefUtente`)
    REFERENCES `ecommerce`.`utente` (`CodUtente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`categoriaProdotti`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ecommerce`.`categoriaProdotti` (
  `CodCategoria` INT NOT NULL,
  `NomeCategoria` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`CodCategoria`),
  UNIQUE INDEX `NomeCategoria_UNIQUE` (`NomeCategoria` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`prodotto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ecommerce`.`prodotto` (
  `CodProdotto` INT NOT NULL,
  `NomeProdotto` VARCHAR(45) NOT NULL,
  `RefCategoria` INT NOT NULL,
  `Prezzo` DOUBLE NOT NULL,
  `Quantita` VARCHAR(45) NOT NULL,
  `Descrizione` VARCHAR(2500) NULL,
  `HasImage` TINYINT NOT NULL DEFAULT 0,
  PRIMARY KEY (`CodProdotto`),
  INDEX `RefCategoria_idx` (`RefCategoria` ASC) VISIBLE,
  CONSTRAINT `RefCategoria`
    FOREIGN KEY (`RefCategoria`)
    REFERENCES `ecommerce`.`categoriaProdotti` (`CodCategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`corriere`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ecommerce`.`corriere` (
  `CodCorriere` INT NOT NULL,
  `Nome` VARCHAR(45) NOT NULL,
  `PrezzoSpedizione` DOUBLE NOT NULL,
  PRIMARY KEY (`CodCorriere`),
  UNIQUE INDEX `Nome_UNIQUE` (`Nome` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`tipoCarta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ecommerce`.`tipoCarta` (
  `CodTipo` INT NOT NULL,
  `NomeTipo` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`CodTipo`),
  UNIQUE INDEX `NomeTipo_UNIQUE` (`NomeTipo` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`carta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ecommerce`.`carta` (
  `CodCarta` INT NOT NULL,
  `RefUtente` INT NOT NULL,
  `RefTipo` INT NOT NULL,
  `NumeroCarta` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`CodCarta`, `RefUtente`),
  INDEX `RefUtente3_idx` (`RefUtente` ASC) VISIBLE,
  INDEX `RefTipo_idx` (`RefTipo` ASC) VISIBLE,
  CONSTRAINT `RefUtente3`
    FOREIGN KEY (`RefUtente`)
    REFERENCES `ecommerce`.`utente` (`CodUtente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `RefTipo`
    FOREIGN KEY (`RefTipo`)
    REFERENCES `ecommerce`.`tipoCarta` (`CodTipo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`acquisto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ecommerce`.`acquisto` (
  `CodAcquisto` INT NOT NULL,
  `RefSpedizione` INT NOT NULL,
  `RefFatturazione` INT NOT NULL,
  `RefCorriere` INT NOT NULL,
  `RefCarta` INT NOT NULL,
  `RefUtente` INT NOT NULL,
  `Data` DATE NOT NULL,
  `Sconto` DOUBLE NOT NULL,
  PRIMARY KEY (`CodAcquisto`, `RefUtente`),
  INDEX `RefCorriere_idx` (`RefCorriere` ASC) VISIBLE,
  INDEX `RefCarta_idx` (`RefCarta` ASC, `RefUtente` ASC) VISIBLE,
  INDEX `RefUtente4_idx` (`RefUtente` ASC) VISIBLE,
  INDEX `RefSpedizione_idx` (`RefSpedizione` ASC) VISIBLE,
  INDEX `RefFatturazione_idx` (`RefFatturazione` ASC) VISIBLE,
  CONSTRAINT `RefCorriere`
    FOREIGN KEY (`RefCorriere`)
    REFERENCES `ecommerce`.`corriere` (`CodCorriere`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `RefCarta`
    FOREIGN KEY (`RefCarta` , `RefUtente`)
    REFERENCES `ecommerce`.`carta` (`CodCarta` , `RefUtente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `RefUtente5`
    FOREIGN KEY (`RefUtente`)
    REFERENCES `ecommerce`.`utente` (`CodUtente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `RefSpedizione`
    FOREIGN KEY (`RefSpedizione`)
    REFERENCES `ecommerce`.`indirizzoSpedizione` (`CodSpedizione`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `RefFatturazione`
    FOREIGN KEY (`RefFatturazione`)
    REFERENCES `ecommerce`.`indirizzoFatturazione` (`CodFatturazione`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`infoAcquisto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ecommerce`.`infoAcquisto` (
  `RefUtente` INT NOT NULL,
  `RefAcquisto` INT NOT NULL,
  `RefProdotto` INT NOT NULL,
  `Quantita` INT NOT NULL,
  PRIMARY KEY (`RefAcquisto`, `RefProdotto`, `RefUtente`),
  INDEX `RefProdotto_idx` (`RefProdotto` ASC) VISIBLE,
  INDEX `RefUtente6_idx` (`RefUtente` ASC) VISIBLE,
  CONSTRAINT `RefProdotto`
    FOREIGN KEY (`RefProdotto`)
    REFERENCES `ecommerce`.`prodotto` (`CodProdotto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `RefAcquisto`
    FOREIGN KEY (`RefAcquisto`)
    REFERENCES `ecommerce`.`acquisto` (`CodAcquisto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `RefUtente6`
    FOREIGN KEY (`RefUtente`)
    REFERENCES `ecommerce`.`utente` (`CodUtente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ecommerce`.`carrello`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ecommerce`.`carrello` (
  `RefUtente` INT NOT NULL,
  `RefProdotto` INT NOT NULL,
  `Quantita` INT NOT NULL,
  PRIMARY KEY (`RefUtente`, `RefProdotto`),
  INDEX `RefProdotto2_idx` (`RefProdotto` ASC) VISIBLE,
  CONSTRAINT `RefUtente4`
    FOREIGN KEY (`RefUtente`)
    REFERENCES `ecommerce`.`utente` (`CodUtente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `RefProdotto2`
    FOREIGN KEY (`RefProdotto`)
    REFERENCES `ecommerce`.`prodotto` (`CodProdotto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
