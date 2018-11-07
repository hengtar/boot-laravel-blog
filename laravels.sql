/*
 Navicat Premium Data Transfer

 Source Server         : 本地
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : laravels

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 06/11/2018 18:17:42
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for article_category
-- ----------------------------
DROP TABLE IF EXISTS `article_category`;
CREATE TABLE `article_category`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `p_id` int(11) NOT NULL DEFAULT 0 COMMENT '父类',
  `category` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '分类名称',
  `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '分类状态',
  `deleted_at` int(1) NOT NULL DEFAULT 0 COMMENT '软删除',
  `created_at` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of article_category
-- ----------------------------
INSERT INTO `article_category` VALUES (1, 0, '分类1', 1, 0, 0, 0, 0);
INSERT INTO `article_category` VALUES (2, 0, '分类2', 1, 1, 0, 0, 0);
INSERT INTO `article_category` VALUES (3, 0, '分类3', 1, 1, 0, 0, 0);
INSERT INTO `article_category` VALUES (4, 0, '分类4', 1, 1, 0, 0, 0);

-- ----------------------------
-- Table structure for articles
-- ----------------------------
DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL DEFAULT 0 COMMENT '文章分类Id',
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '文章状态  1开启 0 关闭',
  `title` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文章标题',
  `keywords` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文章关键词',
  `summary` varchar(1500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文章简介描述',
  `content` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文章内容',
  `tips` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文章标签',
  `views` int(11) NOT NULL DEFAULT 0 COMMENT '文章浏览量',
  `author` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文章作者',
  `photo` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文章图片',
  `recommend` int(11) NOT NULL DEFAULT 0 COMMENT '文章推荐位置',
  `deleted_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '软删除字段',
  `created_at` datetime NOT NULL COMMENT '发布时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  `sort` int(11) NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 24 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of articles
-- ----------------------------
INSERT INTO `articles` VALUES (15, 1, 1, 'PythonT今日上线了！！！！', 'PythonT今日上线了！！！！', 'PythonT今日上线了！！！！', 'PythonT今日上线了！！！！发送到', 'aslkdjflsakdjfk', 195, 'PythonT今日上线了！！！！', '/storage/20181106/rAiC0RRhZbbM0eoRwWqFqm74n36DYnKdszCovIxt.jpeg', 0, '0000-00-00 00:00:00', '2018-11-06 07:20:30', '2018-11-06 08:00:59', 50);
INSERT INTO `articles` VALUES (16, 1, 1, '1234', '1234', '214124', '21341234', 'aslkdjflsakdjfk', 159, '124', '/storage/20181106/lIfFHJlt0zTicCk1kNMkCz9mwDYPre5QfgZv45Cc.png', 0, '0000-00-00 00:00:00', '2018-11-06 08:01:13', '2018-11-06 08:06:13', 50);
INSERT INTO `articles` VALUES (17, 1, 1, '2134', '2134', '12412', '21341234', 'aslkdjflsakdjfk', 253, '124', '/storage/20181106/OPfPrkTWBth8aF4XLnEQyx11BEsPiqbk8IJXpRJi.png', 0, '0000-00-00 00:00:00', '2018-11-06 08:03:28', '2018-11-06 08:05:52', 50);
INSERT INTO `articles` VALUES (18, 1, 1, '1', '1', '1', '1', 'aslkdjflsakdjfk', 366, '1', '/static/boot/img/no_img.jpg', 0, '0000-00-00 00:00:00', '2018-11-06 08:03:40', '2018-11-06 08:05:57', 1);
INSERT INTO `articles` VALUES (19, 1, 1, '1', '1', '1', '1', 'aslkdjflsakdjfk', 1, '1', '/static/boot/img/no_img.jpg', 0, '0000-00-00 00:00:00', '2018-11-06 08:05:14', '2018-11-06 08:05:55', 50);
INSERT INTO `articles` VALUES (20, 1, 1, '3453', '245', '52354', '23452345', 'aslkdjflsakdjfk', 127, '324', '/static/boot/img/no_img.jpg', 0, '0000-00-00 00:00:00', '2018-11-06 08:16:25', '2018-11-06 08:16:25', 1);
INSERT INTO `articles` VALUES (21, 1, 1, '3453', '245', '52354', '23452345', 'aslkdjflsakdjfk', 358, '324', '/static/boot/img/no_img.jpg', 0, '2018-11-06 08:16:37', '2018-11-06 08:16:33', '2018-11-06 08:16:37', 1);
INSERT INTO `articles` VALUES (22, 1, 1, '444', '4', '44', '44', 'aslkdjflsakdjfk', 402, '44', '/static/boot/img/no_img.jpg', 0, '0000-00-00 00:00:00', '2018-11-06 08:16:45', '2018-11-06 08:16:45', 50);
INSERT INTO `articles` VALUES (23, 1, 1, '555', '5', '5', '555', 'aslkdjflsakdjfk', 222, '55', '/static/boot/img/no_img.jpg', 0, '0000-00-00 00:00:00', '2018-11-06 08:16:58', '2018-11-06 08:16:58', 5);

SET FOREIGN_KEY_CHECKS = 1;
