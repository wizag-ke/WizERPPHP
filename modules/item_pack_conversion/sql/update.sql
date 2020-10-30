DROP TABLE IF EXISTS `0_uom_master`;
CREATE TABLE IF NOT EXISTS `0_uom_master` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `uom` varchar(20) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`),
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `0_item_pack_conversion`;
CREATE TABLE IF NOT EXISTS `0_item_pack_conversion` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `from` int(11) NOT NULL DEFAULT '',
    `to` int(11) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`),
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `0_uom_stock_link`;
CREATE TABLE IF NOT EXISTS `0_uom_stock_link` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `stock_code` varchar(20) NOT NULL DEFAULT '',
    `uom_id` int(11) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`),
) ENGINE=InnoDB;


ALTER TABLE `0_stock_master` ADD `uom_id` int(11) NOT NULL DEFAULT '';

