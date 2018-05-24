-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2017-05-14 16:33:46
-- 服务器版本： 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nmooc`
--
CREATE DATABASE IF NOT EXISTS `nmooc` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `nmooc`;

-- --------------------------------------------------------

--
-- 表的结构 `about`
--

CREATE TABLE `about` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `addtime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `about`
--

INSERT INTO `about` (`id`, `title`, `content`, `addtime`) VALUES
(1, '关于我们', '&lt;p&gt;本慕课平台希望通过在线课程这种基于现代技术的教学模式的引入，为传统的教学模式带来新的活力和可能性，推动教学观念的转变和教学方式的不断自己提升，提高学习质量和效率。学校也将在实践中不断探索此类课程的特性和规律，研究课程的规范和标准，推动课程教学质量的提升。&lt;/p&gt;&lt;p&gt;教师表示，以往花很长时间讲授后，只有一半学生能听懂，课后还得再琢磨。但在这门课上，自己出完题，请了一位同学到黑板前解题，然后和其他同学一起不断提出问题和建议。全部的推导过程，竟然一步又一步地呈现在了黑板上！这是自己上这么多年电路课从没遇到过的，甚至把自己需要讲授的所有话都说出来了。&lt;/p&gt;&lt;p&gt;学生表示，自己多是利用晚上和周末，自己感觉精神比较好的时候，就在线学习一段视频。一方面能够自主地挑选适合的学习时间，学习的效率很高；另一方面也充分地利用了空闲的时间，不用占用课时，还可以去选修其他感兴趣的课程。&lt;/p&gt;&lt;p align=&quot;center&quot; style=&quot;text-align: center;&quot;&gt;&lt;/p&gt;&lt;p&gt;积极推进在线教育工作是学校面向未来的战略部署。相关单位和广大师生要高度关注高等教育发展的新技术、新趋势，共同探索传统课堂教学与在线教育及其它教育教学形式的结合，积极实践，稳步推进，提高质量，引领发展。&lt;/p&gt;&lt;p align=&quot;center&quot; style=&quot;text-align: center;&quot;&gt;&lt;img src=&quot;/nmooc/Public/image/591854fbf2494.jpg&quot; alt=&quot;timg (1)&quot; style=&quot;max-width:100%;&quot; class=&quot;&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', '2017-05-14 21:28:46');

-- --------------------------------------------------------

--
-- 表的结构 `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `courseid` int(11) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cart`
--

INSERT INTO `cart` (`id`, `username`, `courseid`, `time`) VALUES
(423, 'admin', 2, '2017-03-14 22:59:12'),
(424, 'admin', 1, '2017-03-19 12:29:55'),
(425, '00001', 1, '2017-03-19 12:37:15'),
(426, '111', 1, '2017-05-05 13:51:01'),
(427, '111', 21, '2017-05-05 17:49:36'),
(428, 'admin', 3, '2017-05-06 23:09:42'),
(429, 'admin', 25, '2017-05-14 21:13:42');

-- --------------------------------------------------------

--
-- 表的结构 `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `teacherid` char(11) NOT NULL,
  `img` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `introduce` varchar(400) NOT NULL,
  `teachername` varchar(8) NOT NULL,
  `addtime` datetime NOT NULL,
  `number` int(11) NOT NULL,
  `see` int(11) NOT NULL DEFAULT '0',
  `notice` varchar(1000) NOT NULL,
  `status` set('开课中','已结课','','') NOT NULL DEFAULT '开课中'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `course`
--

INSERT INTO `course` (`id`, `teacherid`, `img`, `name`, `type`, `introduce`, `teachername`, `addtime`, `number`, `see`, `notice`, `status`) VALUES
(1, '00000001', '2.jpg', '思想道德修养与法律基础', '数字媒体技术', '《思想道德修养与法律基础》是一门融思想性、政治性、知识性、综合性和实践性为一体的课程。作为大学生的第一门思想政治理论课程，本课程以马克思列宁主义、毛泽东思想和中国特色社会主义理论体系为指导，传承中华优秀传统文化，借鉴人类文明的有益创造成果，围绕当代大学生在成长成才过程中面对的思想、道德、法律等问题，进行马克思主义的世界观、人生观、价值观、道德观和法律观的教育教学，帮助大学生提高思想道德素质和法律素质，成长为德智体美全面发展的社会主义事业的合格建设者和接班人。', '王正涛', '2017-02-17 08:08:12', 10, 9, '散了散了', '开课中'),
(2, '00000002', '1.jpg', '马克思主义原理', '数字媒体艺术', '马克思主义', '田原', '2017-02-15 05:33:19', 10, 3, '还行', '开课中'),
(3, '00000001', '131313.jpg', '电路原理', '影视', '电路原理是电类各专业最重要的一门基础课，后续各课程都建立在这门课的知识体系之上，是电类专业本科生的“看家课”。清华大学电路原理课程为学生提供扎实基础和丰富应用。', '王正涛', '2017-02-17 08:08:12', 6, 4, '好好学', '开课中'),
(4, '00000001', 'course_4.jpg', '马克思主义3', '动画', '社会主义好啊', '王正涛', '2017-02-17 08:08:12', 3, 1, '视觉传达', '已结课'),
(24, '1', 'course_24.jpg', 'C语言', '数字媒体技术', '语言曾开发出UNIX操作系统等经典复杂系统。随着物联网、智能终端等技术发展，也用于开发更多应用程序，还具硬件底层执行能力，且易于使用，因此能持久丰富和发展，成为学习掌握各种编程技术的重要基础。\r\n本课程结合MOOC教学特点，优化提炼了所有内容的知识点，通过案例应用来解析相关的知识要点和程序算法实现方法，以及相关的语义语法基本规范等。', '管理员', '2017-05-14 20:17:53', 0, 5, '', '开课中'),
(25, '00000002', 'course_25.jpg', '视觉传达设计思维与方法', '视觉传达', '注重逻辑思维与逆向思维并重的教学。以设计哲学、研究型设计与跨界设计、格律设计为宏观视点，掌握针对性选择何种设计思维与设计方法展开实践的能力。', '田原', '2017-05-14 21:13:17', 1, 2, '', '开课中');

-- --------------------------------------------------------

--
-- 表的结构 `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `addtime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `addtime`) VALUES
(2, 'NMOOC内测中', '&lt;p&gt;域名和服务器都已准备完毕，线上测试正式开启！&lt;/p&gt;', '2017-04-04 16:42:21'),
(4, 'NMOOC网站正式上线！', '&lt;p&gt;NMOOC网站正式上线啦！喜欢我们的朋友可以经常来看看~&lt;/p&gt;&lt;p align=&quot;center&quot; style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p align=&quot;center&quot; style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;\r\n&lt;div class=&quot;container-fluid mainbgcolor6&quot; id=&quot;part2&quot;&gt;\r\n&lt;div class=&quot;container&quot;&gt;\r\n	&lt;div class=&quot;row clearfix padding14&quot; align=&quot;center&quot;&gt;\r\n		&lt;h1&gt;NEWMOOC&lt;/h1&gt;\r\n		&lt;h5 class=&quot;maincolor1 margin11&quot;&gt;The New Massive Open Online Course&lt;/h5&gt;\r\n		&lt;div class=&quot;index-course-button2&quot;&gt;&lt;h1 style=&quot;font-size:48px;&quot;&gt;扬帆起航&lt;/h1&gt;&lt;h1&gt;&lt;/h1&gt;&lt;/div&gt;\r\n	&lt;/div&gt;\r\n&lt;/div&gt;	\r\n&lt;/div&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', '2017-05-08 10:34:53'),
(5, '毕业季', '&lt;p style=&quot;text-align: center;&quot;&gt;长亭外 古道边&lt;/p&gt;&lt;p style=&quot;text-align: center;&quot;&gt;芳草碧连天&lt;/p&gt;&lt;p style=&quot;text-align: center;&quot;&gt;晚风拂柳笛声残&lt;/p&gt;&lt;p style=&quot;text-align: center;&quot;&gt;夕阳山外山&lt;/p&gt;&lt;p style=&quot;text-align: center;&quot;&gt;天之涯 地之角&lt;/p&gt;&lt;p style=&quot;text-align: center;&quot;&gt;知交半零落&lt;/p&gt;&lt;p style=&quot;text-align: center;&quot;&gt;一瓢浊酒尽余欢&lt;/p&gt;&lt;p style=&quot;text-align: center;&quot;&gt;今宵别梦寒&lt;/p&gt;&lt;p style=&quot;text-align: center;&quot;&gt;&lt;img src=&quot;/nmooc/Public/image/59184e0fc669c.jpg&quot; alt=&quot;Slideshow1&quot; style=&quot;max-width:100%;&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;', '2017-05-14 20:31:12');

-- --------------------------------------------------------

--
-- 表的结构 `recommend`
--

CREATE TABLE `recommend` (
  `id` int(11) NOT NULL,
  `courseid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `recommend`
--

INSERT INTO `recommend` (`id`, `courseid`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- 表的结构 `section`
--

CREATE TABLE `section` (
  `sectionid` int(11) NOT NULL,
  `courseid` int(11) NOT NULL,
  `teacherid` char(11) NOT NULL,
  `sectionname` char(60) NOT NULL,
  `paper` char(60) NOT NULL,
  `resource` char(60) NOT NULL,
  `courseware` char(60) NOT NULL,
  `sectionvideo` char(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `section`
--

INSERT INTO `section` (`sectionid`, `courseid`, `teacherid`, `sectionname`, `paper`, `resource`, `courseware`, `sectionvideo`) VALUES
(1, 1, '00000001', '我的第一节课', '1.pdf', 'pdf.zip', 'a.pdf', '<iframe height=498 width=510 src=''http://player.youku.com/embed/XMjYxMzA1MDczMg=='' frameborder=0 ''allowfullscreen''></iframe>'),
(2, 1, '00000001', '我的第二节课', '2.pdf', 'pdf.zip', 'b.pdf', '<iframe height=498 width=510 src=''http://player.youku.com/embed/XMjYxMzA1MDczMg=='' frameborder=0 ''allowfullscreen''></iframe>'),
(8, 4, '00000001', '3344', '#', '#', '#', '55555'),
(9, 21, '00000001', '打', '9_resource.zip', '9_resource.zip', '9_courseware.pdf', '打单位'),
(10, 24, '1', '1', '#', '#', '#', '&lt;iframe height=498 width=510 src=''http://player.youku.com/embed/XMjc0NjExNDU5Ng=='' frameborder=0 ''allowfullscreen''&gt;&lt;/iframe&gt;');

-- --------------------------------------------------------

--
-- 表的结构 `slideshow`
--

CREATE TABLE `slideshow` (
  `id` int(11) NOT NULL,
  `url` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `slideshow`
--

INSERT INTO `slideshow` (`id`, `url`) VALUES
(1, 'home/news/news?id=5'),
(2, 'home/course'),
(3, 'home/news/news?id=4');

-- --------------------------------------------------------

--
-- 表的结构 `teacher`
--

CREATE TABLE `teacher` (
  `teacherid` char(11) NOT NULL,
  `teachername` varchar(8) NOT NULL,
  `teacherpw` varchar(100) NOT NULL,
  `teacherintroduce` varchar(400) NOT NULL,
  `position` varchar(60) NOT NULL,
  `department` varchar(60) NOT NULL,
  `teacherimg` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `teacher`
--

INSERT INTO `teacher` (`teacherid`, `teachername`, `teacherpw`, `teacherintroduce`, `position`, `department`, `teacherimg`) VALUES
('00000001', '王正涛', '6512bd43d9caa6e02c990b0a82652dca', '博士，副教授。2004年赴美国麻省理工MIT访问学者半年。2011年起任国家级精品课“电子技术基础”课程负责人；主讲《数字电子技术基础》，《自动测试原理》等。 近年来参编已出版的“十五规划”、“十一五规划”等教材教辅8本，其中多本教材获奖：如《数字电子技术基础》（第五版），获得北京市高等教育经典教材、北京市高等教育精品教材奖,清华大学优秀教材特等奖等。 在教学和科研方面曾获得：“宝钢优秀教师奖 ”；“霍英东优秀青年奖”；军内“科技进步一、二、三等奖”各1项； “国防科学技术三等奖”； “清华大学青年教师教学优秀奖”；多次获“清华大学教学成果奖”和 “清华大学实验技术成果奖”；两次获评清华大学“我最喜爱的教师”等。', '副教授', '数字艺术系', 'head_00000001.jpg'),
('00000002', '田原', '6512bd43d9caa6e02c990b0a82652dca', '精通unity', '副教授', '数字艺术系数字媒体艺术', 'head_00000002.jpg'),
('1', '管理员', '6512bd43d9caa6e02c990b0a82652dca', '管理员', '', '', 'head_1.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `rank` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `rank`) VALUES
(23, '1111', '1111', '初级会员'),
(25, '111', '111', '初级会员'),
(27, '111112', '6512bd43d9caa6e02c990b0a82652dca', '初级会员'),
(28, 'admin', '21232f297a57a5a743894a0e4a801fc3', '高级会员');

-- --------------------------------------------------------

--
-- 表的结构 `useradmin`
--

CREATE TABLE `useradmin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `useradmin`
--

INSERT INTO `useradmin` (`id`, `username`, `password`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recommend`
--
ALTER TABLE `recommend`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`sectionid`);

--
-- Indexes for table `slideshow`
--
ALTER TABLE `slideshow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacherid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `useradmin`
--
ALTER TABLE `useradmin`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=430;
--
-- 使用表AUTO_INCREMENT `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- 使用表AUTO_INCREMENT `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `recommend`
--
ALTER TABLE `recommend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `section`
--
ALTER TABLE `section`
  MODIFY `sectionid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- 使用表AUTO_INCREMENT `slideshow`
--
ALTER TABLE `slideshow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- 使用表AUTO_INCREMENT `useradmin`
--
ALTER TABLE `useradmin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
