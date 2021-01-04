/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : mhhy

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-12-26 17:39:08
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '管理员名称',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `sex` tinyint(1) DEFAULT '1' COMMENT '性别',
  `description` varchar(255) DEFAULT NULL COMMENT '说明',
  `nickname` varchar(50) DEFAULT NULL COMMENT '昵称',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态(1:启用，0:禁止)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin
-- ----------------------------

-- ----------------------------
-- Table structure for `admin_role`
-- ----------------------------
DROP TABLE IF EXISTS `admin_role`;
CREATE TABLE `admin_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` varchar(20) NOT NULL COMMENT '管理员id',
  `role_id` varchar(50) NOT NULL COMMENT '角色id',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态(1:启用，0:禁止)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_role
-- ----------------------------

-- ----------------------------
-- Table structure for `auth`
-- ----------------------------
DROP TABLE IF EXISTS `auth`;
CREATE TABLE `auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auth_key` varchar(20) NOT NULL COMMENT '权限key',
  `auth_name` varchar(50) NOT NULL DEFAULT '' COMMENT '权限名称',
  `addtime` int(11) unsigned DEFAULT '0' COMMENT '添加时间',
  `updtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '编辑时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态(1:启用，0:禁止)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth
-- ----------------------------

-- ----------------------------
-- Table structure for `role`
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) NOT NULL COMMENT '角色名称',
  `role_explain` varchar(50) NOT NULL DEFAULT '' COMMENT '角色介绍',
  `role_images` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `extend` varchar(255) NOT NULL DEFAULT '' COMMENT '扩展信息',
  `addtime` int(11) unsigned DEFAULT NULL COMMENT '添加时间',
  `updtime` int(11) unsigned DEFAULT NULL COMMENT '修改时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态(1:启用，0:禁止)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of role
-- ----------------------------

-- ----------------------------
-- Table structure for `role_auth`
-- ----------------------------
DROP TABLE IF EXISTS `role_auth`;
CREATE TABLE `role_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` varchar(20) NOT NULL COMMENT '角色ID',
  `auth_id` varchar(50) NOT NULL DEFAULT '' COMMENT '权限ID',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态(1:启用，0:禁止)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of role_auth
-- ----------------------------
