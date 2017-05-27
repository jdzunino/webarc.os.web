-- -----------------------------------------------------
-- Table `compras`
-- -----------------------------------------------------
CREATE TABLE `compras` (
	`idCompras` BIGINT(20) NOT NULL AUTO_INCREMENT,
	`dataCompra` DATE NULL DEFAULT NULL,
	`valorTotal` VARCHAR(45) NULL DEFAULT NULL COLLATE 'ascii_bin',
	`desconto` VARCHAR(45) NULL DEFAULT NULL COLLATE 'ascii_bin',
	`faturado` TINYINT(1) NULL DEFAULT NULL,
	`fornecedor_id` INT(11) NOT NULL,
	`usuarios_id` INT(11) NULL DEFAULT NULL,
	`lancamentos_id` INT(11) NULL DEFAULT NULL,
	PRIMARY KEY (`idCompras`),
	INDEX `fk_vendas_clientes1` (`fornecedor_id`),
	CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`fornecedor_id`) REFERENCES `clientes` (`idClientes`) ON UPDATE NO ACTION ON DELETE NO ACTION,
	CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`lancamentos_id`) REFERENCES `lancamentos` (`idLancamentos`) ON UPDATE NO ACTION ON DELETE NO ACTION,
	CONSTRAINT `compras_ibfk_3` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`idUsuarios`) ON UPDATE NO ACTION ON DELETE NO ACTION
)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = latin1;

CREATE TABLE `itens_de_compras` (
	`idItens` BIGINT(20) NOT NULL AUTO_INCREMENT,
	`subTotal` VARCHAR(45) NULL DEFAULT NULL COLLATE 'ascii_bin',
	`quantidade` INT(11) NULL DEFAULT NULL,
	`compras_id` BIGINT(20) NOT NULL,
	`produtos_id` INT(11) NOT NULL,
	PRIMARY KEY (`idItens`),
	INDEX `fk_itens_de_vendas_vendas1` (`compras_id`),
	INDEX `fk_itens_de_vendas_produtos1` (`produtos_id`),
	CONSTRAINT `fk_itens_de_compras_compras1` FOREIGN KEY (`compras_id`) REFERENCES `compras` (`idCompras`),
	CONSTRAINT `fk_itens_de_compras_produtos1` FOREIGN KEY (`produtos_id`) REFERENCES `produtos` (`idProdutos`)
)
COLLATE='ascii_bin'
ENGINE=InnoDB
ROW_FORMAT=DYNAMIC
AUTO_INCREMENT=25
;
