DROP TABLE IF EXISTS `0_transaction_types`;
CREATE TABLE IF NOT EXISTS `0_transaction_types` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `code` varchar(20) NOT NULL DEFAULT '',
    `description` varchar(200) NOT NULL DEFAULT '',
    `dr_ac` int(10) NOT NULL,
    `cr_ac` int(10) NOT NULL,
    `module` varchar(100) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `0_module_transaction_type`;
CREATE TABLE IF NOT EXISTS `0_module_transaction_type` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `module` varchar(50) NOT NULL DEFAULT '',
    `transaction_id` int(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;