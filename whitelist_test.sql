SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `whitelist_test`
-- ----------------------------
DROP TABLE IF EXISTS `whitelist_test`;
CREATE TABLE `whitelist_test` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `guid` varchar(32) NOT NULL DEFAULT '' COMMENT 'BattlEye GUID or IP',
  `is_whitelisted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `permission` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of whitelist_test
-- ----------------------------
