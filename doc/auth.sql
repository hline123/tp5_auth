/*
Navicat MySQL Data Transfer

Source Server         : huanglin
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : auth

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-11-27 14:00:08
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for blog_admin
-- ----------------------------
DROP TABLE IF EXISTS `blog_admin`;
CREATE TABLE `blog_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_username` varchar(64) NOT NULL COMMENT '管理员名称',
  `admin_password` varchar(64) NOT NULL COMMENT '管理员密码',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='管理员管理表';

-- ----------------------------
-- Records of blog_admin
-- ----------------------------
INSERT INTO `blog_admin` VALUES ('1', 'huanglin', 'TYoJqSPFExvr4IebhdOqzw==');
INSERT INTO `blog_admin` VALUES ('2', 'admin', 'aNIvNQqMPINdKj4T2K86pg==');
INSERT INTO `blog_admin` VALUES ('4', 'test', 'dvShlgXorWhKrDkwLMKASw==');

-- ----------------------------
-- Table structure for blog_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `blog_auth_group`;
CREATE TABLE `blog_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_auth_group
-- ----------------------------
INSERT INTO `blog_auth_group` VALUES ('1', '超级管理员', '1', '1,2,3,4,5,19,11,12,13,14,15,16,17,18,20,21,22');
INSERT INTO `blog_auth_group` VALUES ('2', '数据观察员', '1', '1,2,11,15,20,21,22');

-- ----------------------------
-- Table structure for blog_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `blog_auth_group_access`;
CREATE TABLE `blog_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_auth_group_access
-- ----------------------------
INSERT INTO `blog_auth_group_access` VALUES ('1', '2');
INSERT INTO `blog_auth_group_access` VALUES ('2', '1');
INSERT INTO `blog_auth_group_access` VALUES ('4', '1');
INSERT INTO `blog_auth_group_access` VALUES ('4', '2');

-- ----------------------------
-- Table structure for blog_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `blog_auth_rule`;
CREATE TABLE `blog_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `pid` int(11) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  `nav` varchar(100) NOT NULL DEFAULT '''''',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_auth_rule
-- ----------------------------
INSERT INTO `blog_auth_rule` VALUES ('1', 'admin/Index/index', '欢迎页', '0', '1', '1', '', '首页');
INSERT INTO `blog_auth_rule` VALUES ('2', 'admin/Admin/index', '用户列表', '0', '1', '1', '', '用户管理');
INSERT INTO `blog_auth_rule` VALUES ('3', 'admin/Admin/create', '添加用户', '2', '1', '1', '', '用户管理');
INSERT INTO `blog_auth_rule` VALUES ('4', 'admin/Admin/edit', '编辑用户', '2', '1', '1', '', '用户管理');
INSERT INTO `blog_auth_rule` VALUES ('5', 'admin/Admin/delete', '删除用户', '2', '1', '1', '', '用户管理');
INSERT INTO `blog_auth_rule` VALUES ('11', 'admin/Rules/index', '规则列表', '0', '1', '1', '', '规则管理');
INSERT INTO `blog_auth_rule` VALUES ('12', 'admin/Rules/store', '添加规则', '11', '1', '1', '', '规则管理');
INSERT INTO `blog_auth_rule` VALUES ('13', 'admin/Rules/edit', '编辑规则', '11', '1', '1', '', '规则管理');
INSERT INTO `blog_auth_rule` VALUES ('14', 'admin/Rules/delete', '删除规则', '11', '1', '1', '', '规则管理');
INSERT INTO `blog_auth_rule` VALUES ('15', 'admin/Group/index', '用户组列表', '0', '1', '1', '', '用户组管理');
INSERT INTO `blog_auth_rule` VALUES ('16', 'admin/Group/store', '添加用户组', '15', '1', '1', '', '用户组管理');
INSERT INTO `blog_auth_rule` VALUES ('17', 'admin/Group/edit', '编辑用户组', '15', '1', '1', '', '用户组管理');
INSERT INTO `blog_auth_rule` VALUES ('18', 'admin/Group/delete', '删除用户组', '15', '1', '1', '', '用户组管理');
INSERT INTO `blog_auth_rule` VALUES ('19', 'admin/Admin/setAuth', '权限分配', '15', '1', '1', '', '用户管理');
INSERT INTO `blog_auth_rule` VALUES ('20', 'admin/Index/pass', '修改密码', '22', '1', '1', '', '登录');
INSERT INTO `blog_auth_rule` VALUES ('21', 'admin/Index/logout', '退出登录', '22', '1', '1', '', '登录');
INSERT INTO `blog_auth_rule` VALUES ('22', 'admin/Login/login', '后台登录', '0', '1', '1', '', '登录');
