ALTER TABLE `clifor`
	CHANGE COLUMN `ENDCLF` `rua` VARCHAR(255) NULL DEFAULT NULL AFTER `CODREG`,
	CHANGE COLUMN `NROCLF` `numero` VARCHAR(15) NULL DEFAULT NULL AFTER `rua`,
	CHANGE COLUMN `EMACLF` `email` VARCHAR(255) NULL DEFAULT NULL AFTER `NUMFAX`,
	CHANGE COLUMN `CODREG` `documento` VARCHAR(20) NOT NULL,
	CHANGE COLUMN `BRRCLF` `bairro` VARCHAR(45) NULL DEFAULT NULL,
	CHANGE COLUMN `CODCEp` `cep` VARCHAR(20) NULL DEFAULT NULL;

ALTER TABLE `clifor` ALTER `CODCLF` DROP DEFAULT;
ALTER TABLE `clifor` CHANGE COLUMN `NUMTEL` `telefone` VARCHAR(255) NULL DEFAULT NULL AFTER `CODCEP`;
ALTER TABLE `clifor` CHANGE COLUMN `CODCLF` `idClientes` INT(11) NOT NULL FIRST;
ALTER TABLE `clifor` ADD COLUMN `tipoPessoa` INT(2) NULL DEFAULT NULL;
ALTER TABLE `clifor` ADD COLUMN `celular` VARCHAR(20) NULL DEFAULT NULL;
ALTER TABLE `clifor` ADD COLUMN `cidade_id` INT(11) NULL DEFAULT NULL;

update clifor set tipoPessoa = 1 where tipclf = 'F'
update clifor set tipoPessoa = 2 where tipclf = 'J'
update clifor set cidade_id = (select idCidade from cidades where nome = clientes.MUNCLF)

RENAME TABLE `clientes` TO `clientes_antiga`;
RENAME TABLE `clifor` TO `clientes`;
