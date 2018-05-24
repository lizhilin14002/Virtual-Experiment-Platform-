SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `vrcenter` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `vrcenter`;

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET latin1 NOT NULL COMMENT '名称',
  `pass` varchar(50) CHARACTER SET latin1 NOT NULL COMMENT '密码',
  `avatar` varchar(50) CHARACTER SET latin1 NOT NULL COMMENT '头像',
  `majorid` int(11) NOT NULL COMMENT '专业ID',
  `type` varchar(50) CHARACTER SET latin1 NOT NULL COMMENT '类型',
  `lead` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '简述',
  `addtime` datetime NOT NULL COMMENT '添加时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='管理员';

INSERT INTO `admin` (`id`, `name`, `pass`, `avatar`, `majorid`, `type`, `lead`, `addtime`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'upload/users/User_1.jpg', 5, 'admin', '我们的征途是星辰大海！', '2017-02-28 08:27:35');

CREATE TABLE `downloads` (
  `did` int(11) NOT NULL,
  `dtitle` varchar(50) NOT NULL COMMENT '标题',
  `ddescription` text NOT NULL COMMENT '描述',
  `dattachment` varchar(100) NOT NULL COMMENT '附件链接',
  `daddtime` datetime NOT NULL COMMENT '添加时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `downloads` (`did`, `dtitle`, `ddescription`, `dattachment`, `daddtime`) VALUES
(1, '下载测试数据1', '下载测试数据1的简介', 'downloads_21/downloads_21.zip', '2017-09-08 00:00:00'),
(2, '下载测试数据2', '下载测试数据2的简介', 'downloads_22/downloads_22.7z', '2017-09-08 00:00:00');

CREATE TABLE `news` (
  `newsid` int(11) NOT NULL,
  `newstitle` varchar(50) NOT NULL COMMENT '标题',
  `newsimg` varchar(100) NOT NULL,
  `newscontent` text NOT NULL COMMENT '内容',
  `type1id` int(11) NOT NULL COMMENT '分类ID',
  `type2id` int(11) DEFAULT NULL,
  `newsaddtime` datetime NOT NULL COMMENT '添加时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='新闻信息表';

INSERT INTO `news` (`newsid`, `newstitle`, `newsimg`, `newscontent`, `type1id`, `type2id`, `newsaddtime`) VALUES
(1, '中心概况中心介绍', '', '中心概况中心介绍测试数据1', 2, 1, '2017-09-07 00:00:00'),
(2, '中心概况师资队伍1', '', '中心概况师资队伍数据1', 2, 2, '2017-09-09 00:00:00'),
(3, '中心概况师资队伍2', '', '中心概况师资队伍数据2', 2, 2, '2017-09-09 00:00:00'),
(4, '中心概况师资队伍3', '', '中心概况师资队伍数据3', 2, 2, '2017-09-09 00:00:00'),
(5, '新闻动态1', '', '新闻动态测试数据1', 3, 0, '2017-09-09 00:00:00'),
(6, '新闻动态2', '', '新闻动态测试数据2', 3, 0, '2017-09-09 00:00:00'),
(7, '新闻动态3', '', '新闻动态测试数据3', 3, 0, '2017-09-09 00:00:00'),
(8, '新闻动态4新闻动态4新闻动态4新闻动态4新闻动态4新闻动态4新闻动态4新闻动态4新闻动态4', '', '新闻动态测试数据4', 3, 0, '2017-09-09 00:00:00'),
(9, '规章制度1', '', '规章制度测试数据1', 4, 0, '2017-09-09 00:00:00'),
(10, '规章制度2', '', '规章制度测试数据2', 4, 0, '2017-09-09 00:00:00'),
(11, '成果展示教师获奖1', 'course_24.jpg', '成果展示教师获奖测试数据1', 6, 3, '2017-09-09 00:00:00'),
(12, '成果展示教师获奖2', 'course_22.jpg', '成果展示教师获奖测试数据2', 6, 3, '2017-09-09 00:00:00'),
(13, '成果展示学生获奖1', 'course_13.jpg', '成果展示学生获奖测试数据1', 6, 4, '2018-05-02 01:54:30'),
(14, '成果展示作品展示1', 'course_22.jpg', '成果展示作品展示数据1', 6, 5, '2017-09-09 00:00:00'),
(15, '成果展示作品展示2', 'course_24.jpg', '成果展示作品展示数据2', 6, 5, '2017-09-09 00:00:00'),
(16, '成果展示作品展示3', 'course_22.jpg', '成果展示作品展示数据3', 6, 5, '2017-09-09 00:00:00'),
(17, '成果展示作品展示4', 'course_22.jpg', '成果展示作品展示数据4', 6, 5, '2017-09-09 00:00:00'),
(18, '中心概况师资队伍4', '', '中心概况师资队伍数据4', 2, 2, '2017-09-09 00:00:00'),
(19, '新闻动态5', '', '新闻动态测试数据5', 3, 0, '2017-09-09 00:00:00'),
(20, '新闻动态6', '', '&lt;p&gt;新闻动态6&lt;/p&gt;&lt;p&gt;新闻动态6&lt;/p&gt;&lt;p&gt;新闻动态6&lt;/p&gt;&lt;p&gt;新闻动态6&lt;/p&gt;&lt;p&gt;新闻动态6&lt;/p&gt;&lt;p&gt;&lt;b&gt;&lt;/b&gt;&lt;i&gt;&lt;/i&gt;&lt;u&gt;&lt;/u&gt;&lt;sub&gt;&lt;/sub&gt;&lt;sup&gt;&lt;/sup&gt;&lt;strike&gt;&lt;/strike&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;b&gt;&lt;/b&gt;&lt;i&gt;&lt;/i&gt;&lt;u&gt;&lt;/u&gt;&lt;sub&gt;&lt;/sub&gt;&lt;sup&gt;&lt;/sup&gt;&lt;strike&gt;&lt;/strike&gt;&lt;b&gt;&lt;/b&gt;&lt;i&gt;&lt;/i&gt;&lt;u&gt;&lt;/u&gt;&lt;sub&gt;&lt;/sub&gt;&lt;sup&gt;&lt;/sup&gt;&lt;strike&gt;&lt;/strike&gt;&lt;b&gt;&lt;/b&gt;&lt;i&gt;&lt;/i&gt;&lt;u&gt;&lt;/u&gt;&lt;sub&gt;&lt;/sub&gt;&lt;sup&gt;&lt;/sup&gt;&lt;strike&gt;&lt;/strike&gt;&lt;b&gt;&lt;/b&gt;&lt;i&gt;&lt;/i&gt;&lt;u&gt;&lt;/u&gt;&lt;sub&gt;&lt;/sub&gt;&lt;sup&gt;&lt;/sup&gt;&lt;strike&gt;&lt;/strike&gt;&lt;b&gt;&lt;/b&gt;&lt;i&gt;&lt;/i&gt;&lt;u&gt;&lt;/u&gt;&lt;sub&gt;&lt;/sub&gt;&lt;sup&gt;&lt;/sup&gt;&lt;strike&gt;&lt;/strike&gt;&lt;b&gt;&lt;/b&gt;&lt;i&gt;&lt;/i&gt;&lt;u&gt;&lt;/u&gt;&lt;sub&gt;&lt;/sub&gt;&lt;sup&gt;&lt;/sup&gt;&lt;strike&gt;&lt;/strike&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;b&gt;&lt;/b&gt;&lt;i&gt;&lt;/i&gt;&lt;u&gt;&lt;/u&gt;&lt;sub&gt;&lt;/sub&gt;&lt;sup&gt;&lt;/sup&gt;&lt;strike&gt;&lt;/strike&gt;&lt;b&gt;&lt;/b&gt;&lt;i&gt;&lt;/i&gt;&lt;u&gt;&lt;/u&gt;&lt;sub&gt;&lt;/sub&gt;&lt;sup&gt;&lt;/sup&gt;&lt;strike&gt;&lt;/strike&gt;&lt;b&gt;&lt;/b&gt;&lt;i&gt;&lt;/i&gt;&lt;u&gt;&lt;/u&gt;&lt;sub&gt;&lt;/sub&gt;&lt;sup&gt;&lt;/sup&gt;&lt;strike&gt;&lt;/strike&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', 3, 0, '0000-00-00 00:00:00');

CREATE TABLE `resources` (
  `rid` int(11) NOT NULL,
  `rtitle` varchar(50) NOT NULL COMMENT '标题',
  `rtopimg` varchar(100) NOT NULL COMMENT '首图',
  `rcontent` text NOT NULL COMMENT '详述',
  `rattachtype` varchar(50) NOT NULL COMMENT '附件类型',
  `rattachment` varchar(100) NOT NULL COMMENT '附件URL',
  `uattachment` varchar(100) NOT NULL COMMENT 'Unity资源包',
  `raddtime` datetime NOT NULL COMMENT '添加时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='教学资源表';

INSERT INTO `resources` (`rid`, `rtitle`, `rtopimg`, `rcontent`, `rattachtype`, `rattachment`, `uattachment`, `raddtime`) VALUES
(1, 'flash1', 'course_21/f1.jpg', 'flash1的介绍', '1', 'course_21/f1.swf', '', '2017-09-07 00:00:00'),
(2, '视频测试1', 'course_24/f2.jpg', '视频测试1的简介', '2', 'course_24/m1.mp4', '', '2017-09-14 00:00:00'),
(3, 'unity测试1unity测试1unity测试1unity测试1unity测试1', 'course_3/course_3.jpg', 'unity测试1的简介', '3', 'course_25/index.html', '', '2017-09-14 00:00:00'),
(4, 'cvbgbfbfbfb', '', '&lt;p&gt;gbfgbgbfgb&lt;/p&gt;', '', '', '', '0000-00-00 00:00:00'),
(5, 'cvbgbfbfbfb', 'course_5/course_5.jpg', '&lt;p&gt;gbfgbgbfgb&lt;/p&gt;', '', '', '', '0000-00-00 00:00:00');

CREATE TABLE `type1` (
  `type1id` int(11) NOT NULL,
  `type1name` varchar(50) NOT NULL COMMENT '名称',
  `type1url` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分类信息';

INSERT INTO `type1` (`type1id`, `type1name`, `type1url`) VALUES
(1, '首页', 'index/index'),
(2, '中心概况', 'news/index?type1=2&&type2=1'),
(3, '新闻动态', 'news/index?type1=3&&type2='),
(4, '规章制度', 'news/index?type1=4&&type2='),
(5, '教学资源', 'course/index'),
(6, '成果展示', 'news/index?type1=6&&type2=3'),
(7, '资源共享', 'download/index');

CREATE TABLE `type2` (
  `type2id` int(11) NOT NULL,
  `type1id` int(11) NOT NULL,
  `type2name` varchar(50) NOT NULL COMMENT '名称',
  `mtype` varchar(50) DEFAULT '0' COMMENT '模块类型',
  `alonenewsid` int(11) NOT NULL,
  `islocked` tinyint(1) DEFAULT '0' COMMENT '锁定标识'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分类信息';

INSERT INTO `type2` (`type2id`, `type1id`, `type2name`, `mtype`, `alonenewsid`, `islocked`) VALUES
(1, 2, '中心介绍', '1', 1, 0),
(2, 2, '师资队伍', '0', 0, 0),
(3, 6, '教师获奖', '0', 0, 0),
(4, 6, '学生获奖', '0', 0, 0),
(5, 6, '作品展示', '0', 0, 0);

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL COMMENT '用户名',
  `password` varchar(100) NOT NULL COMMENT '密码',
  `addtime` int(11) NOT NULL COMMENT '加入时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户信息表';

INSERT INTO `user` (`id`, `username`, `password`, `addtime`) VALUES
(1, '99', '0', 1505026274),
(2, '77', '2a38a4a9316c49e5a833517c45d31070', 1505026524),
(3, '666', 'fae0b27c451c728867a567e8c1bb4e53', 1525173727);


ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `downloads`
  ADD PRIMARY KEY (`did`);

ALTER TABLE `news`
  ADD PRIMARY KEY (`newsid`);

ALTER TABLE `resources`
  ADD PRIMARY KEY (`rid`);

ALTER TABLE `type1`
  ADD PRIMARY KEY (`type1id`);

ALTER TABLE `type2`
  ADD PRIMARY KEY (`type2id`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `downloads`
  MODIFY `did` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `news`
  MODIFY `newsid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

ALTER TABLE `resources`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `type1`
  MODIFY `type1id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `type2`
  MODIFY `type2id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
