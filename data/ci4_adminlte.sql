/*
 Navicat Premium Data Transfer

 Source Server         : 本地数据库
 Source Server Type    : MySQL
 Source Server Version : 80016
 Source Host           : localhost:3306
 Source Schema         : ci_adminlte

 Target Server Type    : MySQL
 Target Server Version : 80016
 File Encoding         : 65001

 Date: 12/06/2020 20:35:43
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT,
  `a_serial` varchar(40) NOT NULL DEFAULT '' COMMENT '管理序号',
  `a_name` varchar(130) NOT NULL DEFAULT '',
  `real_name` varchar(30) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `role_id` int(1) NOT NULL COMMENT '角色id',
  `a_password` varchar(120) NOT NULL DEFAULT '' COMMENT '登录密码',
  `a_mobile` varchar(12) NOT NULL DEFAULT '' COMMENT '手机号',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_lock` tinyint(2) NOT NULL DEFAULT '0' COMMENT '禁止登陆，0-非禁止，1-禁止登陆',
  `encrypt` varchar(50) NOT NULL DEFAULT '' COMMENT '加密秘钥',
  PRIMARY KEY (`a_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4  COMMENT='管理表';

-- ----------------------------
-- Records of admin
-- ----------------------------
BEGIN;
INSERT INTO `admin` VALUES (1, 'e2f0d04c141a529304e8da34bb', 'codeigniter4', 'codeigniter4', 1, '793a7f9c8cec90eec7bd2f3246ff0897', '', 0, 1591965118, 0, 'CcRBLuq9');
COMMIT;

-- ----------------------------
-- Table structure for admin_module_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_module_menu`;
CREATE TABLE `admin_module_menu` (
  `menu_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `menu_name` char(40)  NOT NULL DEFAULT '' COMMENT '菜单名称',
  `parent_id` smallint(6) NOT NULL DEFAULT '0' COMMENT '父id',
  `list_order` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_display` tinyint(1) NOT NULL DEFAULT '1' COMMENT '左侧导航展示',
  `controller` varchar(50)  DEFAULT NULL COMMENT '控制器',
  `folder` varchar(50)  DEFAULT NULL COMMENT '模块',
  `method` varchar(50)  DEFAULT NULL COMMENT '方法',
  `flag_id` varchar(50) NOT NULL DEFAULT '0',
  `is_side_menu` tinyint(1) DEFAULT '0',
  `is_system` tinyint(1) DEFAULT '0',
  `is_works` tinyint(1) DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `css_icon` varchar(50)  NOT NULL COMMENT '图标',
  `arr_parentid` varchar(250) DEFAULT NULL,
  `arr_childid` varchar(250) DEFAULT NULL,
  `is_parent` tinyint(1) DEFAULT '0',
  `show_where` tinyint(1) DEFAULT '1',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`menu_id`) USING BTREE,
  KEY `list_order` (`list_order`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=314 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of admin_module_menu
-- ----------------------------
BEGIN;
INSERT INTO `admin_module_menu` VALUES (1, '后台首页', 0, 1, 1, 'index', 'admin', 'index', '0', 0, 0, 0, 0, 'fa-home', NULL, NULL, 0, 1, 1591877845, 1591878408);
INSERT INTO `admin_module_menu` VALUES (157, '系统设置', 0, 157, 1, 'index', 'admin', 'index', '0', 1, 0, 1, 0, 'fa-desktop', '0', '157,158,164,165,166,172,159,160,161,162,171,167,168,169,170,220,258,269,270,271,272,297,298,299,300', 1, 1, 0, 1591941127);
INSERT INTO `admin_module_menu` VALUES (158, '用户管理', 157, 158, 1, 'staff', 'admin', 'index', '0', 1, 0, 1, 0, 'fa-user', '0,157', '158,164,165,166,172', 1, 1, 0, 1591856010);
INSERT INTO `admin_module_menu` VALUES (159, '角色管理', 157, 159, 1, 'role', 'admin', 'index', '0', 1, 0, 1, 0, 'fa-users', '0,157', '159,160,161,162,171', 1, 1, 0, 1591846403);
INSERT INTO `admin_module_menu` VALUES (160, '添加角色', 159, 160, 0, 'role', 'admin', 'add', '0', 1, 0, 1, 0, 'fa-plus', '0,157,159', '160', 0, 1, 0, 1591846616);
INSERT INTO `admin_module_menu` VALUES (161, '编辑角色', 159, 161, 0, 'role', 'admin', 'edit', '0', 1, 0, 1, 0, 'fa-edit', '0,157,159', '161', 0, 1, 0, 1591846583);
INSERT INTO `admin_module_menu` VALUES (162, '删除角色', 159, 162, 0, 'role', 'admin', 'delete_one', '0', 1, 0, 1, 0, 'fa-trash-o', '0,157,159', '162', 0, 1, 0, 1591846571);
INSERT INTO `admin_module_menu` VALUES (164, '添加用户', 158, 164, 0, 'staff', 'admin', 'add', '0', 1, 0, 1, 0, 'fa-plus', '0,157,158', '164', 0, 1, 0, 1591846730);
INSERT INTO `admin_module_menu` VALUES (165, '编辑用户', 158, 165, 0, 'staff', 'admin', 'edit', '0', 1, 0, 1, 0, 'fa-edit', '0,157,158', '165', 0, 1, 0, 1591846747);
INSERT INTO `admin_module_menu` VALUES (166, '删除用户', 158, 166, 0, 'staff', 'admin', 'index', '0', 1, 0, 1, 0, 'fa-trash-o', '0,157,158', '166', 0, 1, 0, 1591859722);
INSERT INTO `admin_module_menu` VALUES (167, '菜单管理', 157, 167, 1, 'menu', 'admin', 'index', '0', 1, 0, 1, 0, 'fa-align-justify', '0,157', '167,168,169,170', 1, 1, 0, 1591846239);
INSERT INTO `admin_module_menu` VALUES (168, '添加栏目', 167, 168, 0, 'menu', 'admin', 'add', '0', 1, 0, 1, 0, 'fa-plus', '0,157,167', '168', 0, 1, 0, 1591846634);
INSERT INTO `admin_module_menu` VALUES (169, '编辑栏目', 167, 169, 0, 'menu', 'admin', 'edit', '0', 1, 0, 1, 0, 'fa-edit', '0,157,167', '169', 0, 1, 0, 1591846646);
INSERT INTO `admin_module_menu` VALUES (170, '删除栏目', 167, 170, 0, 'menu', 'admin', 'delete', '0', 1, 0, 1, 0, 'fa-trash-o', '0,157,167', '170', 0, 1, 0, 1591846659);
INSERT INTO `admin_module_menu` VALUES (171, '角色授权', 159, 171, 0, 'role', 'admin', 'setting', '0', 1, 0, 1, 0, 'fa-key', '0,157,159', '171', 0, 1, 0, 1591846547);
INSERT INTO `admin_module_menu` VALUES (172, '管理员修改密码', 158, 172, 0, 'staff', 'admin', 'changepwd', '0', 1, 0, 1, 1, '', '0,157,158', '172', 0, 1, 0, 0);
INSERT INTO `admin_module_menu` VALUES (308, '用户状态', 158, 500, 0, 'staff', 'admin', 'status', '0', 0, 0, 0, 0, 'fa-circle', NULL, NULL, 0, 1, 1591855549, 1591855668);
INSERT INTO `admin_module_menu` VALUES (309, '个人资料', 157, 500, 1, 'staff', 'admin', 'profile', '0', 0, 0, 0, 0, 'fa-user', NULL, NULL, 0, 1, 1591856951, 1591856998);
INSERT INTO `admin_module_menu` VALUES (313, '设置中心', 157, 500, 1, 'setting', 'admin', 'index', '0', 0, 0, 0, 0, 'fa-cogs', NULL, NULL, 0, 1, 1591941100, 1591941162);
COMMIT;

-- ----------------------------
-- Table structure for admin_role
-- ----------------------------
DROP TABLE IF EXISTS `admin_role`;
CREATE TABLE `admin_role` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '组ID',
  `role_name` varchar(45) NOT NULL DEFAULT '' COMMENT '组名',
  `listorder` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `desc` varchar(200)  DEFAULT NULL COMMENT '描述',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1-有效 0-禁用',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of admin_role
-- ----------------------------
BEGIN;
INSERT INTO `admin_role` VALUES (1, '超级管理员', 0, '超级管理员1', 0, 0, 1);
COMMIT;

-- ----------------------------
-- Table structure for admin_role_priv
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_priv`;
CREATE TABLE `admin_role_priv` (
  `role_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `folder` varchar(50) NOT NULL DEFAULT '',
  `controller` varchar(50) NOT NULL DEFAULT '',
  `method` varchar(50) NOT NULL DEFAULT '',
  `data` varchar(50) NOT NULL DEFAULT '',
  `priv_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) DEFAULT '0',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`priv_id`),
  KEY `role_id` (`role_id`,`folder`,`controller`,`method`)
) ENGINE=InnoDB AUTO_INCREMENT=1026 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for admin_setting
-- ----------------------------
DROP TABLE IF EXISTS `admin_setting`;
CREATE TABLE `admin_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `description` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '描述',
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '代码',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '设置配置及内容',
  `sort_number` int(10) NOT NULL DEFAULT '1000' COMMENT '排序',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='设置';

-- ----------------------------
-- Records of admin_setting
-- ----------------------------
BEGIN;
INSERT INTO `admin_setting` VALUES (1, '基本设置', '后台的基本信息设置', 'base', '[{\"name\":\"\\u540e\\u53f0\\u540d\\u79f0\",\"field\":\"name\",\"type\":\"text\",\"content\":\"XX\\u540e\\u53f0\\u7cfb\\u7edf\",\"option\":\"\"},{\"name\":\"\\u540e\\u53f0\\u7b80\\u79f0\",\"field\":\"short_name\",\"type\":\"text\",\"content\":\"\\u540e\\u53f0\",\"option\":\"\"},{\"name\":\"\\u540e\\u53f0\\u4f5c\\u8005\",\"field\":\"author\",\"type\":\"text\",\"content\":\"xx\\u79d1\\u6280\",\"option\":\"\"},{\"name\":\"\\u540e\\u53f0\\u7248\\u672c\",\"field\":\"version\",\"type\":\"text\",\"content\":\"0.2\",\"option\":\"\"}]', 1000, 1591802901, 1591802901, 0);
INSERT INTO `admin_setting` VALUES (2, '登录设置', '后台登录相关设置', 'login', '[{\"name\":\"\\u9a8c\\u8bc1\\u7801\",\"field\":\"captcha\",\"type\":\"select\",\"content\":\"1\",\"option\":\"0||\\u4e0d\\u5f00\\u542f\\r\\n1||\\u56fe\\u5f62\\u9a8c\\u8bc1\\u7801\\r\\n\"},{\"name\":\"\\u767b\\u5f55\\u80cc\\u666f\",\"field\":\"background\",\"type\":\"image\",\"content\":\"\\/upload\\/attachment\\/20200612\\/5ee360d10903bc9e.jpeg\",\"option\":\"\"}]', 1000, 1591802901, 1591802901, 0);
INSERT INTO `admin_setting` VALUES (3, '首页设置', '后台首页参数设置', 'index', '[{\"name\":\"\\u9ed8\\u8ba4\\u5bc6\\u7801\\u8b66\\u544a\",\"field\":\"password_warning\",\"type\":\"switch\",\"content\":\"1\",\"option\":\"\"},{\"name\":\"\\u662f\\u5426\\u663e\\u793a\\u63d0\\u793a\\u4fe1\\u606f\",\"field\":\"show_notice\",\"type\":\"switch\",\"content\":\"1\",\"option\":\"\"},{\"name\":\"\\u63d0\\u793a\\u4fe1\\u606f\\u5185\\u5bb9\",\"field\":\"notice_content\",\"type\":\"text\",\"content\":\"\\u6b22\\u8fce\\u6765\\u5230\\u4f7f\\u7528\\u672c\\u7cfb\\u7edf\\uff0c\\u5de6\\u4fa7\\u4e3a\\u83dc\\u5355\\u533a\\u57df\\uff0c\\u53f3\\u4fa7\\u4e3a\\u529f\\u80fd\\u533a\\u3002\",\"option\":\"\"}]', 1000, 1591802901, 1591802901, 0);
COMMIT;

-- ----------------------------
-- Table structure for attachment
-- ----------------------------
DROP TABLE IF EXISTS `attachment`;
CREATE TABLE `attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `a_id` int(11) NOT NULL COMMENT '后台用户ID',
  `user_id` int(11) NOT NULL COMMENT '前台用户ID',
  `save_name` varchar(200) NOT NULL DEFAULT '' COMMENT '保存文件名',
  `save_path` varchar(255) NOT NULL DEFAULT '' COMMENT '系统完整路径',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '系统完整路径',
  `extension` varchar(100) NOT NULL DEFAULT '' COMMENT '后缀',
  `mime` varchar(100) NOT NULL DEFAULT '' COMMENT '类型',
  `size` bigint(20) NOT NULL DEFAULT '0' COMMENT '大小',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `deleted_at` int(11) NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4  COMMENT='附件表';

-- ----------------------------
-- Records of attachment
-- ----------------------------
BEGIN;
INSERT INTO `attachment` VALUES (10, 0, 0, '5ee360d10903bc9e.jpeg', '/Users/codeigniter4-AdminLTE//public/upload/attachment/20200612/', '/upload/attachment/20200612/5ee360d10903bc9e.jpeg', 'jpeg', 'image/jpeg', 22629, 1591959761, 0, 0);
COMMIT;

DROP TABLE IF EXISTS `credit_news`;

CREATE TABLE `credit_news` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '标题',
  `c_image` varchar(255) NOT NULL DEFAULT '' COMMENT '封面',
  `desc` varchar(100) NOT NULL DEFAULT '' COMMENT '简介',
  `content` text NOT NULL,
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='信用新闻';

SET FOREIGN_KEY_CHECKS = 1;
