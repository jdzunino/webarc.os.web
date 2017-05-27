-- -----------------------------------------------------
-- Table `estados`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS  `estados`
(
    `idEstado` INT(11) NOT NULL AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    sigla VARCHAR(2) NOT NULL,
    PRIMARY KEY (`idEstado`)
)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = latin1;

-- -----------------------------------------------------
-- Table `cidades`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cidades`
(
	`idCidade` INT(11) NOT NULL AUTO_INCREMENT,
	`nome` VARCHAR(255) NOT NULL,
	`estado_id` INT(11) NOT NULL,
	`populacao_2010` INT(11) NULL DEFAULT NULL,
	`codigo_ibge` INT(11) NULL DEFAULT NULL COMMENT 'Código IBGE com apenas 6 dígitos',
	`densidade_demo` DOUBLE NULL DEFAULT NULL,
	`gentilico` VARCHAR(50) NULL DEFAULT NULL,
	`area` DOUBLE NULL DEFAULT NULL,
	PRIMARY KEY (`idCidade`),
	INDEX `fk_cidades_estado_id` (`estado_id`),
	CONSTRAINT `fk_cidades_estado_id` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`idEstado`) ON UPDATE NO ACTION ON DELETE NO ACTION
)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = latin1;

-- -----------------------------------------------------
-- Table `clientes` - Inclusão campos cidade_id
-- -----------------------------------------------------

ALTER TABLE `clientes` ADD cidade_id INT(11);

/**Falta ajustar para se já tiver a FOREIGN KEY não dar erro no script*/
ALTER TABLE `clientes` ADD CONSTRAINT  `fk_clientes_cidade_id` FOREIGN KEY (`cidade_id`) REFERENCES `cidades` (`idCidade`) ON DELETE NO ACTION ON UPDATE NO ACTION;