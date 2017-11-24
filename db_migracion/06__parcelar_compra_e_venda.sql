ALTER TABLE `lancamentos` ADD COLUMN `compra_id` BIGINT NULL AFTER `clientes_id`;

ALTER TABLE `lancamentos` 
	ADD INDEX `fk_lancamentos_compra` (`compra_id`),
	ADD CONSTRAINT `fk_lancamentos_compra` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`idCompras`);
	
ALTER TABLE `lancamentos` ADD COLUMN `venda_id` BIGINT(20) NULL DEFAULT NULL AFTER `compra_id`;

ALTER TABLE `lancamentos` 	
	ADD INDEX `fk_lancamentos_venda` (`venda_id`),
	ADD CONSTRAINT `fk_lancamentos_venda` FOREIGN KEY (`venda_id`) REFERENCES `vendas` (`idVendas`);
