-- =============================================================================
-- Diagram Name: instrucao
-- Created on: 26/05/2014 20:25:49
-- Diagram Version: 
-- =============================================================================
DROP DATABASE IF EXISTS `instrucao`;

CREATE DATABASE IF NOT EXISTS `instrucao` 
CHARACTER SET utf8;

USE `instrucao`;

SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE `funcao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(20),
  PRIMARY KEY(`id`)
)
ENGINE=INNODB
CHARACTER SET utf8 ;

CREATE TABLE `usuario` (
  `saram` varchar(7) NOT NULL,
  `trigrama` varchar(3),
  PRIMARY KEY(`saram`)
)
ENGINE=INNODB
CHARACTER SET utf8 ;

CREATE TABLE `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `texto` text,
  PRIMARY KEY(`id`)
)
ENGINE=INNODB
CHARACTER SET utf8 ;

CREATE TABLE `missao` (
  `codigo` varchar(6) NOT NULL,
  `titulo` text,
  PRIMARY KEY(`codigo`)
)
ENGINE=INNODB
CHARACTER SET utf8 ;

CREATE TABLE `privilegio` (
  `texto` varchar(15) NOT NULL,
  `ordem` int(11),
  PRIMARY KEY(`texto`)
)
ENGINE=INNODB
CHARACTER SET utf8 ;

CREATE TABLE `missao_funcao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `missao` varchar(6) NOT NULL,
  `funcao` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY(`id`),
  CONSTRAINT `Ref_03` FOREIGN KEY (`missao`)
    REFERENCES `missao`(`codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `Ref_04` FOREIGN KEY (`funcao`)
    REFERENCES `funcao`(`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)
ENGINE=INNODB;

CREATE TABLE `ficha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `in` varchar(7) NOT NULL,
  `al` varchar(7) NOT NULL,
  `data` datetime,
  `eet` timestamp,
  `grau` int(11),
  `trecho` text,
  `comentario` text,
  `gerop` text,
  `doutrina` text,
  `operacoes` text,
  `status` int(11),
  PRIMARY KEY(`id`),
  CONSTRAINT `Ref_08` FOREIGN KEY (`al`)
    REFERENCES `usuario`(`saram`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `Ref_09` FOREIGN KEY (`in`)
    REFERENCES `usuario`(`saram`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)
ENGINE=INNODB
CHARACTER SET utf8 ;

CREATE TABLE `usuario_funcao` (
  `usuario` varchar(7) NOT NULL,
  `funcao` int(11) NOT NULL DEFAULT '0',
  `privilegio` varchar(15) NOT NULL,
  PRIMARY KEY(`usuario`, `funcao`),
  CONSTRAINT `Ref_10` FOREIGN KEY (`usuario`)
    REFERENCES `usuario`(`saram`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `Ref_11` FOREIGN KEY (`funcao`)
    REFERENCES `funcao`(`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `Ref_12` FOREIGN KEY (`privilegio`)
    REFERENCES `privilegio`(`texto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)
ENGINE=INNODB
CHARACTER SET utf8 ;

CREATE TABLE `item_missao` (
  `item` int(11) NOT NULL DEFAULT '0',
  `missao` int(11) NOT NULL DEFAULT '0',
  `nivel` varchar(2),
  `ordem` int(11),
  PRIMARY KEY(`item`, `missao`),
  CONSTRAINT `Ref_01` FOREIGN KEY (`item`)
    REFERENCES `item`(`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `Ref_05` FOREIGN KEY (`missao`)
    REFERENCES `missao_funcao`(`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)
ENGINE=INNODB
CHARACTER SET utf8 ;

CREATE TABLE `ficha_item` (
  `ficha` int(11) NOT NULL DEFAULT '0',
  `item` int(11) NOT NULL DEFAULT '0',
  `missao` int(11) NOT NULL DEFAULT '0',
  `grau` int(11),
  `comentario` text,
  PRIMARY KEY(`ficha`, `item`, `missao`),
  CONSTRAINT `Ref_06` FOREIGN KEY (`ficha`)
    REFERENCES `ficha`(`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `Ref_07` FOREIGN KEY (`item`, `missao`)
    REFERENCES `item_missao`(`item`, `missao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)
ENGINE=INNODB
CHARACTER SET utf8 ;

SET FOREIGN_KEY_CHECKS=1;
