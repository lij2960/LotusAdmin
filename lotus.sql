/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : lotus

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-11-02 17:21:17
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sm_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `sm_admin_user`;
CREATE TABLE `sm_admin_user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '管理员用户名',
  `password` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1 启用 0 禁用',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `last_login_time` datetime DEFAULT NULL COMMENT '最后登录时间',
  `last_login_ip` varchar(20) DEFAULT NULL COMMENT '最后登录IP',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of sm_admin_user
-- ----------------------------
INSERT INTO `sm_admin_user` VALUES ('1', 'admin', '\r\n\r\ne10adc3949ba59abbe56e057f20f883e', '1', '2016-10-18 15:28:37', '2017-04-12 12:45:08', '127.0.0.1');

-- ----------------------------
-- Table structure for sm_api
-- ----------------------------
DROP TABLE IF EXISTS `sm_api`;
CREATE TABLE `sm_api` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `base_url` varchar(255) DEFAULT NULL,
  `hash` varchar(50) DEFAULT NULL,
  `method` varchar(10) DEFAULT NULL,
  `is_token` varchar(255) DEFAULT '0',
  `app_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sm_api
-- ----------------------------
INSERT INTO `sm_api` VALUES ('26', 'sadasd', 'https://b.com', '17RACPHBVSBY249DNQYJQ64NL', 'get', '0', '14924215', '1509592427', '1509592427');
INSERT INTO `sm_api` VALUES ('27', 'sadasdasd', 'https://b.com', 'B2MX95XZHLPYSIGJN4NPFLZDG', 'post', '0', null, '1509610234', '1509610234');
INSERT INTO `sm_api` VALUES ('28', 'sadasdasd', 'https://b.com', 'B2MX95XZHLPYSIGJN4NPFLZDG', 'post', '0', null, '1509610321', '1509610321');
INSERT INTO `sm_api` VALUES ('29', 'sadasd', 'https://b.com', '17RACPHBVSBY249DNQYJQ64NL', 'get', '0', null, '1509610325', '1509610325');
INSERT INTO `sm_api` VALUES ('30', 'sadasd', 'https://b.com', '17RACPHBVSBY249DNQYJQ64NL', 'get', '0', null, '1509610329', '1509610329');
INSERT INTO `sm_api` VALUES ('31', 'sadasd', 'https://b.com', '17RACPHBVSBY249DNQYJQ64NL', 'get', '0', null, '1509610340', '1509610340');
INSERT INTO `sm_api` VALUES ('32', 'sadasdasd', 'https://b.com', 'B2MX95XZHLPYSIGJN4NPFLZDG', 'post', '0', null, '1509610345', '1509610345');
INSERT INTO `sm_api` VALUES ('33', 'sadasd', 'https://b.com', '17RACPHBVSBY249DNQYJQ64NL', 'get', '0', null, '1509610348', '1509612595');
INSERT INTO `sm_api` VALUES ('34', 'sadasdasd', 'https://b.com', 'B2MX95XZHLPYSIGJN4NPFLZDG', 'post', '0', null, '1509610622', '1509612409');

-- ----------------------------
-- Table structure for sm_app
-- ----------------------------
DROP TABLE IF EXISTS `sm_app`;
CREATE TABLE `sm_app` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `app_id` int(11) NOT NULL,
  `secret` varchar(255) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_id` (`app_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sm_app
-- ----------------------------
INSERT INTO `sm_app` VALUES ('15', '农管家', '69948048', 'ZBS2IVTZVAZNKIJDEYERZFDH6', '1509603925', '1509606585');
INSERT INTO `sm_app` VALUES ('16', '新闻', '14924215', '8BTA8ZMXB7ETGEEGFKY7TVI3H', '1509604084', '1509606592');
INSERT INTO `sm_app` VALUES ('20', '天气应用', '47610514', 'J6JICJAYC3FVOEZ8KWMMDDQ2T', '1509608311', '1509608311');

-- ----------------------------
-- Table structure for sm_article
-- ----------------------------
DROP TABLE IF EXISTS `sm_article`;
CREATE TABLE `sm_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `cid` smallint(5) unsigned NOT NULL COMMENT '分类ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `introduction` varchar(255) DEFAULT '' COMMENT '简介',
  `content` longtext COMMENT '内容',
  `author` varchar(20) DEFAULT '' COMMENT '作者',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0 待审核  1 审核',
  `reading` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '阅读量',
  `thumb` varchar(255) DEFAULT '' COMMENT '缩略图',
  `photo` text COMMENT '图集',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶  0 不置顶  1 置顶',
  `is_recommend` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐  0 不推荐  1 推荐',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `publish_time` datetime NOT NULL COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='文章表';

-- ----------------------------
-- Records of sm_article
-- ----------------------------
INSERT INTO `sm_article` VALUES ('1', '1', '测试文章一', '', '<p>测试内容</p>', 'admin', '1', '0', '', null, '0', '0', '0', '2017-04-11 14:10:10', '2017-04-11 14:09:45');

-- ----------------------------
-- Table structure for sm_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `sm_auth_group`;
CREATE TABLE `sm_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` varchar(255) NOT NULL COMMENT '权限规则ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COMMENT='权限组表';

-- ----------------------------
-- Records of sm_auth_group
-- ----------------------------
INSERT INTO `sm_auth_group` VALUES ('1', '超级管理组', '1', '1,2,3,103');
INSERT INTO `sm_auth_group` VALUES ('2', '普通用户', '0', '1,2,3,103,101,102');
INSERT INTO `sm_auth_group` VALUES ('34', 'dasfdsf', '1', '');
INSERT INTO `sm_auth_group` VALUES ('35', 'asfsadf', '1', '');
INSERT INTO `sm_auth_group` VALUES ('36', 'asfasdf', '1', '');
INSERT INTO `sm_auth_group` VALUES ('37', 'asfasd', '1', '');
INSERT INTO `sm_auth_group` VALUES ('38', 'adsf', '1', '');
INSERT INTO `sm_auth_group` VALUES ('39', 'dfgdfg', '1', '');
INSERT INTO `sm_auth_group` VALUES ('40', 'fdtghgfdh', '1', '');
INSERT INTO `sm_auth_group` VALUES ('41', 'fcbvf', '1', '');
INSERT INTO `sm_auth_group` VALUES ('42', 'dfgcvb', '1', '');
INSERT INTO `sm_auth_group` VALUES ('43', 'cvbcvb', '1', '');
INSERT INTO `sm_auth_group` VALUES ('44', 'zvxcv', '1', '');
INSERT INTO `sm_auth_group` VALUES ('45', 'zxczxc', '1', '');
INSERT INTO `sm_auth_group` VALUES ('46', 'xcvxcv', '1', '');
INSERT INTO `sm_auth_group` VALUES ('47', 'xcvxcvasdsadc', '1', '');
INSERT INTO `sm_auth_group` VALUES ('48', 'sadzxc', '1', '');
INSERT INTO `sm_auth_group` VALUES ('49', 'sczxcxzc', '1', '');
INSERT INTO `sm_auth_group` VALUES ('50', 'sadasd', '1', '');

-- ----------------------------
-- Table structure for sm_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `sm_auth_group_access`;
CREATE TABLE `sm_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限组规则表';

-- ----------------------------
-- Records of sm_auth_group_access
-- ----------------------------
INSERT INTO `sm_auth_group_access` VALUES ('1', '1');
INSERT INTO `sm_auth_group_access` VALUES ('27', '2');
INSERT INTO `sm_auth_group_access` VALUES ('28', '2');
INSERT INTO `sm_auth_group_access` VALUES ('29', '50');

-- ----------------------------
-- Table structure for sm_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `sm_auth_rule`;
CREATE TABLE `sm_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL DEFAULT '' COMMENT '规则名称',
  `title` varchar(20) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `pid` smallint(5) unsigned NOT NULL COMMENT '父级ID',
  `icon` varchar(50) DEFAULT '' COMMENT '图标',
  `sort` tinyint(4) unsigned NOT NULL COMMENT '排序',
  `condition` char(100) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=112 DEFAULT CHARSET=utf8 COMMENT='规则表';

-- ----------------------------
-- Records of sm_auth_rule
-- ----------------------------
INSERT INTO `sm_auth_rule` VALUES ('1', 'admin/user/default', '用户管理', '1', '1', '0', '2', '0', '');
INSERT INTO `sm_auth_rule` VALUES ('2', 'admin/user/userlist', '用户列表', '1', '1', '1', '3', '0', '');
INSERT INTO `sm_auth_rule` VALUES ('3', 'admin/auth/index', '权限管理', '1', '1', '1', '4', '0', '');
INSERT INTO `sm_auth_rule` VALUES ('4', 'admin/auth/showRole', '角色列表', '1', '1', '1', '5', '0', '');
INSERT INTO `sm_auth_rule` VALUES ('8', 'admin/api/list', '接口仓库', '1', '1', '7', '', '0', '');
INSERT INTO `sm_auth_rule` VALUES ('5', 'admin/db_manage/default', '数据库', '1', '1', '0', 'fa', '0', '');
INSERT INTO `sm_auth_rule` VALUES ('6', 'admin/db_manage/index', '优化', '1', '1', '5', 'fa', '0', '');
INSERT INTO `sm_auth_rule` VALUES ('7', 'admin/api/default', '接口管理', '1', '1', '0', '', '0', '');

-- ----------------------------
-- Table structure for sm_category
-- ----------------------------
DROP TABLE IF EXISTS `sm_category`;
CREATE TABLE `sm_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `alias` varchar(50) DEFAULT '' COMMENT '导航别名',
  `content` longtext COMMENT '分类内容',
  `thumb` varchar(255) DEFAULT '' COMMENT '缩略图',
  `icon` varchar(20) DEFAULT '' COMMENT '分类图标',
  `list_template` varchar(50) DEFAULT '' COMMENT '分类列表模板',
  `detail_template` varchar(50) DEFAULT '' COMMENT '分类详情模板',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '分类类型  1  列表  2 单页',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `path` varchar(255) DEFAULT '' COMMENT '路径',
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='分类表';

-- ----------------------------
-- Records of sm_category
-- ----------------------------
INSERT INTO `sm_category` VALUES ('1', '分类一', '', '', '', '', '', '', '1', '0', '0', '0,', '2016-12-22 18:22:24');

-- ----------------------------
-- Table structure for sm_link
-- ----------------------------
DROP TABLE IF EXISTS `sm_link`;
CREATE TABLE `sm_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '链接名称',
  `link` varchar(255) DEFAULT '' COMMENT '链接地址',
  `image` varchar(255) DEFAULT '' COMMENT '链接图片',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1 显示  2 隐藏',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='友情链接表';

-- ----------------------------
-- Records of sm_link
-- ----------------------------

-- ----------------------------
-- Table structure for sm_nav
-- ----------------------------
DROP TABLE IF EXISTS `sm_nav`;
CREATE TABLE `sm_nav` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL COMMENT '父ID',
  `name` varchar(20) NOT NULL COMMENT '导航名称',
  `alias` varchar(20) DEFAULT '' COMMENT '导航别称',
  `link` varchar(255) DEFAULT '' COMMENT '导航链接',
  `icon` varchar(255) DEFAULT '' COMMENT '导航图标',
  `target` varchar(10) DEFAULT '' COMMENT '打开方式',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态  0 隐藏  1 显示',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='导航表';

-- ----------------------------
-- Records of sm_nav
-- ----------------------------

-- ----------------------------
-- Table structure for sm_slide
-- ----------------------------
DROP TABLE IF EXISTS `sm_slide`;
CREATE TABLE `sm_slide` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(10) unsigned NOT NULL COMMENT '分类ID',
  `name` varchar(50) NOT NULL COMMENT '轮播图名称',
  `description` varchar(255) DEFAULT '' COMMENT '说明',
  `link` varchar(255) DEFAULT '' COMMENT '链接',
  `target` varchar(10) DEFAULT '' COMMENT '打开方式',
  `image` varchar(255) DEFAULT '' COMMENT '轮播图片',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态  1 显示  0  隐藏',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='轮播图表';

-- ----------------------------
-- Records of sm_slide
-- ----------------------------

-- ----------------------------
-- Table structure for sm_slide_category
-- ----------------------------
DROP TABLE IF EXISTS `sm_slide_category`;
CREATE TABLE `sm_slide_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '轮播图分类',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='轮播图分类表';

-- ----------------------------
-- Records of sm_slide_category
-- ----------------------------
INSERT INTO `sm_slide_category` VALUES ('1', '首页轮播');

-- ----------------------------
-- Table structure for sm_system
-- ----------------------------
DROP TABLE IF EXISTS `sm_system`;
CREATE TABLE `sm_system` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '配置项名称',
  `value` text NOT NULL COMMENT '配置项值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='系统配置表';

-- ----------------------------
-- Records of sm_system
-- ----------------------------
INSERT INTO `sm_system` VALUES ('1', 'site_config', 'a:7:{s:10:\"site_title\";s:30:\"Think Admin 后台管理系统\";s:9:\"seo_title\";s:0:\"\";s:11:\"seo_keyword\";s:0:\"\";s:15:\"seo_description\";s:0:\"\";s:14:\"site_copyright\";s:0:\"\";s:8:\"site_icp\";s:0:\"\";s:11:\"site_tongji\";s:0:\"\";}');

-- ----------------------------
-- Table structure for sm_user
-- ----------------------------
DROP TABLE IF EXISTS `sm_user`;
CREATE TABLE `sm_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `mobile` varchar(11) DEFAULT '' COMMENT '手机',
  `email` varchar(50) DEFAULT '' COMMENT '邮箱',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态  1 正常  2 禁止',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `last_login_time` datetime DEFAULT NULL COMMENT '最后登陆时间',
  `last_login_ip` varchar(50) DEFAULT '' COMMENT '最后登录IP',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of sm_user
-- ----------------------------
INSERT INTO `sm_user` VALUES ('27', 'wenhainande', '121144d6c3114c583415f06860ad3710', '', 'whnde@qc.com', '1', '2017-09-26 05:28:15', null, '0.0.0.0');
INSERT INTO `sm_user` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '', 'whnde@qq.com', '1', '2017-09-20 07:01:19', '2017-11-02 09:29:45', '127.0.0.1');
