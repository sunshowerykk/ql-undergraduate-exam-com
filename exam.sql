/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50519
Source Host           : localhost:3306
Source Database       : exam

Target Server Type    : MYSQL
Target Server Version : 50519
File Encoding         : 65001

Date: 2018-12-11 16:54:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sys_exam
-- ----------------------------
DROP TABLE IF EXISTS `sys_exam`;
CREATE TABLE `sys_exam` (
  `examid` int(11) NOT NULL AUTO_INCREMENT,
  `examsubid` int(11) DEFAULT NULL,
  `examsubname` varchar(255) DEFAULT NULL,
  `examcourseid` int(11) DEFAULT NULL,
  `examcoursename` varchar(255) DEFAULT NULL,
  `examcoursesectionid` int(11) DEFAULT NULL,
  `examcoursesectionname` varchar(255) DEFAULT NULL,
  `examname` varchar(255) DEFAULT NULL,
  `examscore` varchar(255) DEFAULT NULL,
  `examquestions` text,
  `examstatus` int(11) DEFAULT '1',
  `examtime` char(255) DEFAULT NULL,
  `examinuser` varchar(255) DEFAULT NULL,
  `examintime` datetime DEFAULT NULL,
  PRIMARY KEY (`examid`),
  KEY `examid` (`examid`,`examsubid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sys_exam
-- ----------------------------

-- ----------------------------
-- Table structure for sys_examhistory
-- ----------------------------
DROP TABLE IF EXISTS `sys_examhistory`;
CREATE TABLE `sys_examhistory` (
  `ehid` int(11) NOT NULL AUTO_INCREMENT,
  `ehexamid` int(11) DEFAULT NULL,
  `ehscorelist` text,
  `errorlist` text,
  `ehanswer` text,
  `ehtime` int(11) DEFAULT NULL,
  `ehscore` varchar(255) DEFAULT '0',
  `ehstarttime` varchar(50) DEFAULT NULL,
  `ehendtime` varchar(50) DEFAULT NULL,
  `ehgrade` int(11) DEFAULT '1' COMMENT '1自评分，2教师评分',
  `ehstatus` int(11) DEFAULT '0' COMMENT '1,已完成答题，2可以继续答题',
  `userid` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `ehgardestatus` int(11) DEFAULT '1' COMMENT '1，未阅卷2，已阅卷,3临时保存',
  `ehcheckuser` int(11) DEFAULT NULL,
  `chcheckusername` varchar(255) DEFAULT NULL,
  `ehcomment` text,
  `ehgardetime` char(40) DEFAULT NULL,
  `ehgardeendtime` char(40) DEFAULT NULL,
  PRIMARY KEY (`ehid`),
  KEY `ehid` (`ehid`,`ehexamid`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sys_examhistory
-- ----------------------------

-- ----------------------------
-- Table structure for sys_file
-- ----------------------------
DROP TABLE IF EXISTS `sys_file`;
CREATE TABLE `sys_file` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `FileId` varchar(50) NOT NULL,
  `FilePath` varchar(50) NOT NULL,
  `FileExtension` varchar(50) NOT NULL,
  `FileSize` int(20) NOT NULL,
  `InUser` varchar(20) NOT NULL,
  `InTime` datetime NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FileId` (`FileId`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sys_file
-- ----------------------------

-- ----------------------------
-- Table structure for sys_question
-- ----------------------------
DROP TABLE IF EXISTS `sys_question`;
CREATE TABLE `sys_question` (
  `questionid` int(11) NOT NULL AUTO_INCREMENT,
  `examid` int(11) DEFAULT NULL,
  `questiontype` int(11) DEFAULT NULL,
  `question` text COMMENT '题干',
  `questionselect` text COMMENT '选项',
  `questionselectnumber` int(11) DEFAULT NULL COMMENT '选选项数量',
  `questionanswer` text COMMENT '答案',
  `questiondescribe` text COMMENT '解析',
  `questionscore` text COMMENT '分值',
  `questionvideo` text,
  `questionstatus` int(11) DEFAULT '1',
  `questionparent` int(11) DEFAULT '0',
  `questioncreatetime` datetime DEFAULT NULL,
  `questionuser` varchar(255) DEFAULT NULL,
  `questioncap` int(11) DEFAULT '0',
  PRIMARY KEY (`questionid`),
  KEY `questionid` (`questionid`,`questiontype`,`questionstatus`,`examid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sys_question
-- ----------------------------

-- ----------------------------
-- Table structure for sys_teachrole
-- ----------------------------
DROP TABLE IF EXISTS `sys_teachrole`;
CREATE TABLE `sys_teachrole` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `sectionid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sys_teachrole
-- ----------------------------

-- ----------------------------
-- Table structure for sys_type
-- ----------------------------
DROP TABLE IF EXISTS `sys_type`;
CREATE TABLE `sys_type` (
  `typeid` int(11) NOT NULL AUTO_INCREMENT,
  `examid` int(11) DEFAULT NULL,
  `typenum` varchar(255) DEFAULT NULL,
  `typename` varchar(255) DEFAULT NULL,
  `typeinfo` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT NULL COMMENT '1,单选，2多选，3填空，4文字',
  `inuser` varchar(255) DEFAULT NULL,
  `intime` datetime DEFAULT NULL,
  PRIMARY KEY (`typeid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sys_type
-- ----------------------------
INSERT INTO `sys_type` VALUES ('1', null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for sys_user
-- ----------------------------
DROP TABLE IF EXISTS `sys_user`;
CREATE TABLE `sys_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(20) NOT NULL DEFAULT '',
  `UserFull` varchar(50) DEFAULT NULL,
  `UserPwd` varchar(100) DEFAULT NULL,
  `UserType` int(10) DEFAULT '3' COMMENT '1是学生,2教师,3其他',
  `RoleID` varchar(5) DEFAULT NULL,
  `UserEmail` varchar(50) DEFAULT NULL COMMENT '公司邮箱',
  `UserStatus` int(10) DEFAULT NULL,
  `LoginIp` varchar(200) DEFAULT NULL,
  `InTime` varchar(30) DEFAULT NULL COMMENT '新增時間',
  `InUserName` varchar(50) DEFAULT NULL,
  `Contact` varchar(30) DEFAULT '' COMMENT '管理教师工号或者学生工号',
  `AuthKey` varchar(255) DEFAULT NULL,
  `AccessToken` varchar(255) DEFAULT NULL,
  `Phone` char(20) DEFAULT NULL,
  `UserInfo` text,
  `CID` char(40) DEFAULT NULL,
  `SubId` varchar(255) DEFAULT NULL,
  `SubName` varchar(255) DEFAULT NULL,
  `CourseId` varchar(255) DEFAULT NULL,
  `CourseName` varchar(255) DEFAULT NULL,
  `SectionId` varchar(255) DEFAULT NULL,
  `SectionName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`UserName`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sys_user
-- ----------------------------
INSERT INTO `sys_user` VALUES ('1', 'admin', '管理员', '21232f297a57a5a743894a0e4a801fc3', '3', '1', '', '1', null, '2015-12-03', 'admin', '', null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sys_user` VALUES ('2', 'student', '学生', '21232f297a57a5a743894a0e4a801fc3', '3', '3', null, '1', null, '2015-12-03', 'admin', '', null, null, null, null, null, null, null, null, null, null, null);
