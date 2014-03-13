/*
Navicat MySQL Data Transfer

Source Server         : HiG MySQL
Source Server Version : 50173
Source Host           : mysql.stud.hig.no:3306
Source Database       : s121050

Target Server Type    : MYSQL
Target Server Version : 50173
File Encoding         : 65001

Date: 2014-03-13 20:43:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ActivationToken
-- ----------------------------
DROP TABLE IF EXISTS `ActivationToken`;
CREATE TABLE `ActivationToken` (
  `tokenID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(10) unsigned NOT NULL,
  `hash` varchar(255) NOT NULL,
  `type` enum('email','password') NOT NULL,
  PRIMARY KEY (`tokenID`,`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ExludedTimeObject
-- ----------------------------
DROP TABLE IF EXISTS `ExludedTimeObject`;
CREATE TABLE `ExludedTimeObject` (
  `userID` int(10) unsigned NOT NULL,
  `content` varchar(255) NOT NULL,
  `type` tinyint(4) unsigned NOT NULL,
  PRIMARY KEY (`userID`,`content`,`type`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for IncludedTimeObject
-- ----------------------------
DROP TABLE IF EXISTS `IncludedTimeObject`;
CREATE TABLE `IncludedTimeObject` (
  `objectID` int(10) unsigned NOT NULL,
  `userID` int(10) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`objectID`,`userID`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for Note
-- ----------------------------
DROP TABLE IF EXISTS `Note`;
CREATE TABLE `Note` (
  `noteID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ownerID` int(10) unsigned NOT NULL,
  `content` text NOT NULL,
  `isPublic` tinyint(1) NOT NULL,
  `timePublished` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category` varchar(255) DEFAULT NULL,
  `points` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`noteID`,`ownerID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for NoteAttachment
-- ----------------------------
DROP TABLE IF EXISTS `NoteAttachment`;
CREATE TABLE `NoteAttachment` (
  `attachmentID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `noteID` int(11) NOT NULL,
  `attachment` mediumblob NOT NULL,
  `attachmentName` text NOT NULL,
  PRIMARY KEY (`attachmentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for NoteReply
-- ----------------------------
DROP TABLE IF EXISTS `NoteReply`;
CREATE TABLE `NoteReply` (
  `parentNoteID` int(11) NOT NULL,
  `childNoteID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for NoteVote
-- ----------------------------
DROP TABLE IF EXISTS `NoteVote`;
CREATE TABLE `NoteVote` (
  `noteID` int(10) unsigned NOT NULL,
  `userID` int(10) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`noteID`,`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ReportedNote
-- ----------------------------
DROP TABLE IF EXISTS `ReportedNote`;
CREATE TABLE `ReportedNote` (
  `noteID` int(10) unsigned NOT NULL,
  `userID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`noteID`,`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for User
-- ----------------------------
DROP TABLE IF EXISTS `User`;
CREATE TABLE `User` (
  `userID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `emailActivated` tinyint(1) NOT NULL,
  `publicTimeSchedule` tinyint(1) unsigned zerofill DEFAULT NULL,
  `profilePicture` mediumblob,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for UserRank
-- ----------------------------
DROP TABLE IF EXISTS `UserRank`;
CREATE TABLE `UserRank` (
  `userID` int(10) unsigned NOT NULL,
  `rank` int(11) DEFAULT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for UserToken
-- ----------------------------
DROP TABLE IF EXISTS `UserToken`;
CREATE TABLE `UserToken` (
  `userID` int(10) unsigned NOT NULL,
  `chainKey` varchar(255) NOT NULL,
  PRIMARY KEY (`userID`,`chainKey`),
  UNIQUE KEY `userID` (`userID`,`chainKey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Procedure structure for downvote
-- ----------------------------
DROP PROCEDURE IF EXISTS `downvote`;
DELIMITER ;;
CREATE DEFINER=`s121050`@`%` PROCEDURE `downvote`(`noteID` int, `userID` int)
BEGIN

	DECLARE currentVote INT DEFAULT NULL;
	
	SELECT type INTO currentVote FROM NoteVote WHERE NoteVote.noteID = `noteID` AND NoteVote.userID = `userID`;

	IF currentVote IS NULL THEN -- Vote doesn't exist
			INSERT INTO NoteVote (noteID, userID, type) VALUES (`noteID`, `userID`, 0);
			UPDATE Note SET Note.points = points - 1 WHERE Note.noteID = `noteID`;
			SELECT 1;
	ELSEIF currentVote = 0 THEN -- There is already a downvote, remove it
			DELETE FROM NoteVote WHERE NoteVote.noteID = `noteID` AND NoteVote.userID = `userID`;
			UPDATE Note SET Note.points = Note.points + 1 WHERE Note.noteID = `noteID`;
			SELECT 2;
	ELSE   -- There is a downvote, make it an upvote
			UPDATE NoteVote SET NoteVote.type = 0 WHERE NoteVote.noteID = `noteID` AND NoteVote.userID = `userID`;
			UPDATE Note SET Note.points = Note.points - 2 WHERE Note.noteID = `noteID`;
			SELECT 3;
	END IF;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for upvote
-- ----------------------------
DROP PROCEDURE IF EXISTS `upvote`;
DELIMITER ;;
CREATE DEFINER=`s121050`@`%` PROCEDURE `upvote`(`noteID` int, `userID` int)
BEGIN

	DECLARE currentVote INT DEFAULT NULL;
	
	SELECT type INTO currentVote FROM NoteVote WHERE NoteVote.noteID = `noteID` AND NoteVote.userID = `userID`;
	
	IF currentVote IS NULL THEN -- Vote doesn't exist
			INSERT INTO NoteVote (noteID, userID, type) VALUES (`noteID`, `userID`, 1);
			UPDATE Note SET Note.points = Note.points + 1 WHERE Note.noteID = `noteID`;
			SELECT 1;
	ELSEIF currentVote = 1 THEN -- There is already an upvote, remove it
			DELETE FROM NoteVote WHERE NoteVote.noteID = `noteID` AND NoteVote.userID = `userID`;
			UPDATE Note SET Note.points = Note.points - 1 WHERE Note.noteID = `noteID`;
			SELECT 2;
	ELSE   -- There is a downvote, make it an upvote
			UPDATE NoteVote SET NoteVote.type = 1 WHERE NoteVote.noteID = `noteID` AND NoteVote.userID = `userID`;
			UPDATE Note SET Note.points = Note.points + 2 WHERE Note.noteID = `noteID`;
			SELECT 3;
	END IF;
	
END
;;
DELIMITER ;
