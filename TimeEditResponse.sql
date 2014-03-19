/*
Navicat MySQL Data Transfer

Source Server         : HiG MySQL
Source Server Version : 50173
Source Host           : mysql.stud.hig.no:3306
Source Database       : s121050

Target Server Type    : MYSQL
Target Server Version : 50173
File Encoding         : 65001

Date: 2014-03-19 14:21:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for TimeEditResponse
-- ----------------------------
DROP TABLE IF EXISTS `TimeEditResponse`;
CREATE TABLE `TimeEditResponse` (
  `url` varchar(767) NOT NULL,
  `requestTime` datetime NOT NULL,
  `response` blob NOT NULL,
  PRIMARY KEY (`url`),
  UNIQUE KEY `url` (`url`),
  KEY `requestTime` (`requestTime`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
