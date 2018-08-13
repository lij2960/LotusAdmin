/*
SQLyog Ultimate v11.24 (32 bit)
MySQL - 5.5.53 : Database - lotus
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`lotus` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `lotus`;

/*Table structure for table `sm_auth_group` */

DROP TABLE IF EXISTS `sm_auth_group`;

CREATE TABLE `sm_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` varchar(255) NOT NULL COMMENT '权限规则ID',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除，0否，1是',
  `pid` int(2) NOT NULL DEFAULT '0' COMMENT '父级角色',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COMMENT='权限组表';

/*Data for the table `sm_auth_group` */

insert  into `sm_auth_group`(`id`,`title`,`status`,`rules`,`is_delete`,`pid`) values (1,'超级管理组',1,'1,2,3,103',0,0),(2,'普通用户',1,'1,2,112,119,3,120,4,121,123',0,0),(51,'adsfa',1,'',0,2),(52,'asfdasfd',1,'',0,1);

/*Table structure for table `sm_auth_group_access` */

DROP TABLE IF EXISTS `sm_auth_group_access`;

CREATE TABLE `sm_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限组规则表';

/*Data for the table `sm_auth_group_access` */

insert  into `sm_auth_group_access`(`uid`,`group_id`) values (1,1),(27,2);

/*Table structure for table `sm_auth_rule` */

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
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除，0否，1是',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=126 DEFAULT CHARSET=utf8 COMMENT='规则表';

/*Data for the table `sm_auth_rule` */

insert  into `sm_auth_rule`(`id`,`name`,`title`,`type`,`status`,`pid`,`icon`,`sort`,`condition`,`is_delete`) values (1,'admin/user/default','系统管理',1,1,0,'2',0,'',0),(2,'admin/user/userlist2','用户管理',1,1,1,'3',0,'',0),(3,'admin/auth/index1','权限管理',1,1,1,'4',0,'',0),(4,'admin/auth/showRole1','角色管理',1,1,1,'5',0,'',0),(117,'admin/auth/delete','删除权限',1,0,3,'',0,'',0),(116,'admin/auth/showEdit','编辑权限',1,0,3,'',0,'',0),(115,'admin/auth/showAdd','添加权限',1,0,3,'',0,'',0),(112,'admin/user/edit','编辑用户',1,0,2,'',0,'',0),(113,'admin/user/deleteUser','删除用户',1,0,2,'',0,'',0),(114,'admin/user/showAdd','添加用户',1,0,2,'',0,'',0),(119,'admin/user/userlist','用户列表',1,1,2,'',0,'',0),(120,'admin/auth/index','权限列表',1,1,3,'',0,'',0),(121,'admin/auth/showRole','角色列表',1,1,4,'',0,'',0),(122,'admin/auth/addRole','添加角色',1,0,4,'',0,'',0),(123,'admin/auth/showAuth','角色赋权',1,0,4,'',0,'',0),(124,'admin/auth/showRoleEdit','编辑角色',1,0,4,'',0,'',0),(125,'admin/auth/delRole','删除角色',1,0,4,'',0,'',0);

/*Table structure for table `sm_user` */

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
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除，0否，1是',
  `salt` varchar(4) DEFAULT NULL COMMENT '用户密码salt字符串',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='用户表';

/*Data for the table `sm_user` */

insert  into `sm_user`(`id`,`username`,`password`,`mobile`,`email`,`status`,`create_time`,`last_login_time`,`last_login_ip`,`is_delete`,`salt`) values (27,'test123','71e132a0736f5599d5c2609bec663ce0','','whnde@qc.com',1,'2017-09-26 05:28:15','2017-11-26 04:26:05','127.0.0.1',0,'glkq'),(1,'admin','ee55193ad6eb0646c47bd90473affadc','','whnde@qq.com',1,'2017-09-20 07:01:19','2017-11-26 04:26:39','127.0.0.1',0,'7hpn');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
