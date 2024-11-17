-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2024-06-18 14:31:10
-- 服务器版本： 5.7.26
-- PHP 版本： 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `myblog1`
--

-- --------------------------------------------------------

--
-- 表的结构 `adminuser`
--

CREATE TABLE `adminuser` (
  `regid` int(11) UNSIGNED NOT NULL,
  `regname` varchar(20) NOT NULL,
  `regpwd` varchar(100) NOT NULL,
  `regqq` varchar(20) NOT NULL,
  `regemail` varchar(50) NOT NULL,
  `regsex` varchar(10) NOT NULL,
  `islock` int(11) NOT NULL DEFAULT '0',
  `fig` int(11) NOT NULL DEFAULT '0',
  `avatar` varchar(100) DEFAULT '1.jpg',
  `signature` varchar(100) DEFAULT '这家伙什么都没留下',
  `birthday` date DEFAULT '2024-01-01'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `adminuser`
--

INSERT INTO `adminuser` (`regid`, `regname`, `regpwd`, `regqq`, `regemail`, `regsex`, `islock`, `fig`, `avatar`, `signature`, `birthday`) VALUES
(1, 'admin', '123', '1837304429', '1837304429@qq.com', '女', 0, 1, '1.jpg', '这家伙什么都没留下', '2024-01-01'),
(2, 'zap', '123456', '1837304429', '1837304429@qq.com', '男', 1, 0, '2.jpg', '这是个好家伙', '2024-01-20'),
(9, 'ccc', '111111', '1837304429', '1837304429@qq.com', '女', 1, 0, '1.jpg', '这家伙什么都没留下', '2024-01-01'),
(10, 'ttt', '111', '1837304429', '999999999@qq.com', '男', 0, 0, '5.jpg', '这家伙什么都没留下aaaaaaabbbbbbb', '2023-08-31'),
(11, 'zs', '111', '1837304429', '1837304429@qq.com', '男', 0, 0, '6.jpg', '旅行，是寻找自我，是发现世界。', '2023-11-09');

-- --------------------------------------------------------

--
-- 表的结构 `article`
--

CREATE TABLE `article` (
  `id` int(11) UNSIGNED NOT NULL,
  `type_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(20) NOT NULL,
  `pubtime` datetime NOT NULL,
  `picture` varchar(50) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `article`
--

INSERT INTO `article` (`id`, `type_id`, `title`, `content`, `author`, `pubtime`, `picture`, `is_deleted`) VALUES
(1, 1, '美景、美食相伴，来一场与南沙的约会', '说到南沙天后宫，可谓是无人不知，无人不晓，它可是东南亚最大的妈祖庙。南沙天后宫是参照福建莆田湄洲妈祖祖庙建成的，占地100公顷。其整体建筑是清代宫殿式的建筑风格，庄严肃穆，极具宫廷的气派。整座天后宫四周绿树婆娑，置身其间令人顿生超凡脱俗的感觉。', 'zap', '2024-06-10 19:09:52', '0100112000813r8qwB0B1_W_1024_0_Q90.jpg', 0),
(2, 2, '天津瓷房子', '瓷房子是一座动用了无数私藏古瓷器、汉白玉石雕、水晶、玛瑙、古董装饰而成的法式建筑。房子的墙上密密麻麻贴满了精美的中国古代瓷器，庭院和楼内堆满了古董，铺天盖地的瓷器古董常让初到瓷房子的游客眼花缭乱。\r\n\r\n瓷房子的围墙由数百个民国时期和晚清时期的古瓷瓶垒砌串联而成，名平安墙。房顶用古瓷片拼成的巨龙盘旋出“China”的图案，巨龙后是碎瓷片拼出的2008年奥运主体育场鸟巢。注意看房子外围右侧，有一竖排的瓷猫从顶层延伸到一层墙角，瓷猫周边镶嵌满水晶、玛瑙，如此兴师动众装饰的却是一根下水管道，令人赞叹。\r\n\r\n整幢楼共有五层，地下室不对外开放，一到四层供游客参观。每一层楼内都摆放着许多雕刻细腻的古代木制家具，红色墙壁上用瓷片贴出古今中外的名人字画。一层中间放着一只宋代大瓷缸。二楼和三楼都有阳台可以观景，一定要抬头看阳台的天花板，天花板是由一个个整只的古代瓷器盘子贴出来的，越往中间的盘子越价值不菲。由于每一层中间都是镂空的，从四楼可以一直看到一楼中间的大瓷缸。\r\n\r\n面朝瓷房子，左手边有一间同样覆盖满精美瓷器的小房间是厕所，看一看就好，为了在水晶、玛瑙与瓷器堆中上一回脱俗、唯美的厕所，厕所门前经常排长队。\r\n\r\n瓷房子的右手边就是出口了，别直接走出去了，出口所在的小房间有“镇馆之宝”。在瓷房子庭院中所见古董石像有些没有头部，头都在出口的耳房这，其中较大的一颗佛头就是“镇馆之宝”了，佛眉心间有个原来是放红宝石用的大凹槽。出口的这间房间不允许照相。\r\n\r\n若光看这幢瓷房子还不过瘾，在天津五大道有一幢疙瘩楼（河北路283号），和瓷房子有异曲同工之妙，离得也不远，可以过去看看。', 'zap', '2024-06-10 19:10:41', '0102x120008bhx6mnD653_R_1600_10000.jpg', 1),
(3, 3, '在长白山天池边凝视永恒的纯净', '长白山位于吉林省白山市东南部，整个山脉总面积达1964平方公里，核心区758平方公里，长白山的最高峰将军峰位于朝鲜境内。目前，长白山在国内开放3个景区入口，分别是北坡景区、西坡景区和南坡景区，其中最为成熟的就是北坡和西坡，而北坡的游客接待量最大，景点也最多。', 'zap', '2024-06-10 19:12:08', '100s190000015sgu88530_R_1000_10000_Q90.jpg', 0),
(4, 1, '湘桂黔迷人风景，苗侗壮浓郁风情', '这条线实际上是春节前后的我独自一人的探亲线路，原计划是,去程：蚌埠经武汉-乾州古城-奇梁洞-龙津风雨桥-岩脚侗寨-万佛山--皇都侗文化村-三江程阳八寨-芭莎苗寨-丹寨-青岩古镇-红枫湖-天龙屯堡-曲靖-昆明，返程昆明-百色-巴马水晶宫景区盘阳河景区、三门海生态旅游区-河池-大化七百弄国家地质公园景-桂林-柳州-贺州黄桃古镇-连州地下河-广东大峡谷-丹霞山-龟峰-景德镇-蚌埠。因贵州境内冻雨、湖南境内连续中雨，去程自矮寨后改为一路向南至三江后向西至昆明。返程因河池境内高速上突然昏迷被迫结束行程。', 'ccc', '2024-06-11 14:59:44', '44.jpg', 1),
(5, 1, '西北大环线之青甘大环线之没有甘的自驾之旅', '为什么没有甘？第一，6个人2台车，只有3个人会开车，光青甘一趟要4000公里，太累了；第二，甘肃的两个城市（敦煌和张掖）都是交通方便的地方，高铁和飞机都可，而且回西宁穿祁连也是去年走过的路线，因此今年自己想了条路线把青海好好的深度游玩了一下（主要是海西州），有些地方专门走的国道。其实最好的风景在路上，每天至少5个小时是在路上，如果为了景点而旅游，那就不适合走这条大环线，但是好在越往西天黑越晚，尤其在茫崖差不多9点才黑，因此就算路程元，但不影响游玩体验。先放路线，不走回头路。', 'ccc', '2024-06-11 15:04:19', '55.jpg', 1),
(6, 3, '关忆西北', '梦想和心爱的人一起，踏上一段说走就走的旅程，感受未知的另一片世界，寻找诗和远方。终于在一个猝不及防的下午，两个疯狂的人突然准备行囊，突然就决定要开启西北大环线之旅。相信在很长很长时间之后，当我再次回想起来这段旅行，我仍能称之为“疯狂的”，因为它另一个代名词是——爱。', 'ttt', '2024-06-11 15:08:57', '88.jpg', 0),
(7, 3, '抓住三月尾巴下扬州啊啊', '春风十里扬州路，烟花三月下扬州\r\n    “在扬州住三个月”的想法已经很久了，可惜没有机会实现。今年五一调休凑的假期，媳妇说想去扬州，终于有了去扬州住三天的好机会。 农历的五一，还属于三月呢。   \r\n    李白、杜牧、姜夔等大咖们为扬州做了千年的免费旅游广告。\r\n    “烟花三月下扬州”；\r\n    “二十四桥明月夜，玉人何处教吹箫”；\r\n    “十年一觉扬州梦，赢得青楼薄姓名”；\r\n    “娉娉袅袅十三馀，豆蔻梢头二月初。春风十里扬州路，卷上珠帘总不如”……这样流量满满、让人神往扬州的句子，抄一页也抄不完。\r\n    这广陵、江都、维扬、月亮城等众多的潇洒别称，更显扬州风流。\r\n    还有古人 “腰缠十万贯，骑鹤上扬州”的理想……无不吸引我们虽无万贯，也要追逐杨花去扬州。\r\n    这就是一种神秘的征服的力量，不凭蛮力，不用刀枪，就让我们总是魂牵梦绕，总是念挂在心，到达的道路纵然艰辛，也总是情愿心甘。', 'zs', '2024-06-11 15:24:06', '99.jpg', 1);

-- --------------------------------------------------------

--
-- 表的结构 `article_type`
--

CREATE TABLE `article_type` (
  `type_id` int(11) UNSIGNED NOT NULL,
  `type_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `article_type`
--

INSERT INTO `article_type` (`type_id`, `type_name`) VALUES
(1, '美食'),
(2, '人文'),
(3, '风景'),
(4, '冒险');

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

CREATE TABLE `comment` (
  `id` int(11) UNSIGNED NOT NULL,
  `fileid` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `content` text NOT NULL,
  `comtime` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `comment`
--

INSERT INTO `comment` (`id`, `fileid`, `username`, `content`, `comtime`, `is_deleted`) VALUES
(12, 7, 'zs', '难以忘怀~', '2024-06-11 03:24:49', 1),
(13, 5, 'zap', '真的好美啊，我一定要去！！！', '2024-06-11 05:33:12', 1),
(14, 4, 'ccc', '用脚步丈量世界，用心感受生活。', '2024-06-11 05:33:37', 1),
(15, 2, 'zap', '世界是一本大书，不旅行的人只读了一页。', '2024-06-11 05:34:05', 1),
(16, 6, 'ttt', '感觉很有趣！！！', '2024-06-18 01:07:51', 1);

--
-- 转储表的索引
--

--
-- 表的索引 `adminuser`
--
ALTER TABLE `adminuser`
  ADD PRIMARY KEY (`regid`);

--
-- 表的索引 `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `article_type`
--
ALTER TABLE `article_type`
  ADD PRIMARY KEY (`type_id`);

--
-- 表的索引 `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `adminuser`
--
ALTER TABLE `adminuser`
  MODIFY `regid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 使用表AUTO_INCREMENT `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `article_type`
--
ALTER TABLE `article_type`
  MODIFY `type_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
