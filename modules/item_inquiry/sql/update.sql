DROP TABLE IF EXISTS `0_item_inquiry`;
CREATE TABLE IF NOT EXISTS `0_item_inquiry` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `inquiry_date` TIMESTAMP NOT NULL DEFAULT  current_timestamp(),
    `stock_id` varchar(20) NOT NULL DEFAULT '',
    `description` varchar(200) NOT NULL DEFAULT '',
    `qoh` double NOT NULL DEFAULT '1',
    PRIMARY KEY (`id`),
    KEY `inquiry_date` (`inquiry_date`,`id`)
) ENGINE=InnoDB;
