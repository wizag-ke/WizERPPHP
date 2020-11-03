DROP TABLE IF EXISTS `0_uom_master`;
DROP TABLE IF EXISTS `0_item_pack_conversion`;
DROP TABLE IF EXISTS `0_uom_stock_link`;
ALTER TABLE `0_stock_master` DROP COLUMN `uom_id`;