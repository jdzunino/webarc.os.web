ALTER TABLE `clientes`
ADD COLUMN `tipoPessoa` INT(2) NULL AFTER `cidade_id`;

update clientes 
set tipoPessoa = 1;