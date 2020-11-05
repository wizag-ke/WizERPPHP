-- DROP TABLE IF EXISTS `0_uom_master`;
-- CREATE TABLE IF NOT EXISTS `0_uom_master` (
--     `id` int(11) NOT NULL AUTO_INCREMENT,
--     `uom` varchar(20) NOT NULL DEFAULT '',
--     PRIMARY KEY (`id`)
-- ) ENGINE=InnoDB;

DROP TABLE IF EXISTS `0_item_pack_conversion`;
CREATE TABLE IF NOT EXISTS `0_item_pack_conversion` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `stock_code` varchar(20) NOT NULL DEFAULT '',
    `from_uom` varchar(20) NOT NULL DEFAULT '',
    `to_uom` varchar(20) NOT NULL DEFAULT '',  
    `factor` DOUBLE NOT NULL, 
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `0_uom_stock_link`;
CREATE TABLE IF NOT EXISTS `0_uom_stock_link` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `stock_code` varchar(20) NOT NULL DEFAULT '',
    `uom_id` varchar(20) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

