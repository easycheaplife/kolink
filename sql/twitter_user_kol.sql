-- MariaDB dump 10.19-11.3.2-MariaDB, for osx10.18 (x86_64)
--
-- Host: localhost    Database: kolink
-- ------------------------------------------------------
-- Server version	11.3.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `twitter_user`
--

DROP TABLE IF EXISTS `twitter_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `twitter_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT 0,
  `name` varchar(128) NOT NULL DEFAULT '',
  `screen_name` varchar(128) NOT NULL DEFAULT '',
  `location` varchar(256) NOT NULL DEFAULT '',
  `description` varchar(512) NOT NULL DEFAULT '',
  `url` varchar(512) NOT NULL DEFAULT '',
  `followers_count` int(11) NOT NULL DEFAULT 0,
  `like_count` int(11) NOT NULL DEFAULT 0,
  `friends_count` int(11) NOT NULL DEFAULT 0,
  `listed_count` int(11) NOT NULL DEFAULT 0,
  `favourites_count` int(11) NOT NULL DEFAULT 0,
  `following_count` int(11) NOT NULL DEFAULT 0,
  `description_urls` varchar(512) NOT NULL DEFAULT '',
  `media_count` int(11) NOT NULL DEFAULT 0,
  `utc_offset` int(11) NOT NULL DEFAULT 0,
  `time_zone` varchar(128) NOT NULL DEFAULT '',
  `geo_enabled` int(11) NOT NULL DEFAULT 0,
  `verified` int(11) NOT NULL DEFAULT 0,
  `statuses_count` int(11) NOT NULL DEFAULT 0,
  `lang` varchar(128) NOT NULL DEFAULT '',
  `profile_background_image_url` varchar(256) NOT NULL DEFAULT '',
  `profile_background_image_url_https` varchar(256) NOT NULL DEFAULT '',
  `profile_image_url` varchar(256) NOT NULL DEFAULT '',
  `profile_image_url_https` varchar(256) NOT NULL DEFAULT '',
  `created_at` int(11) NOT NULL DEFAULT 0,
  `updated_at` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `twitter_user_user_id_unique` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `twitter_user`
--

LOCK TABLES `twitter_user` WRITE;
/*!40000 ALTER TABLE `twitter_user` DISABLE KEYS */;
INSERT INTO `twitter_user` VALUES
(1,29043,'Stanley Do','stanley','','designer, tv junkie, coffee snob, fun size','',451,413,103,43,413,0,'',0,0,'',0,0,3490,'','','','https://pbs.twimg.com/profile_images/3110914613/05b8ac4c0869f0feff64588c600d2390.jpeg','',1164761211,1716385585),
(3,1780514896670756865,'kolinksystem','kolinksyst61929','','','',5,0,4,0,0,0,'',0,0,'',0,0,0,'','','','https://abs.twimg.com/sticky/default_profile_images/default_profile.png','',1713342834,0),
(4,1146492710582308864,'0xSun','0xSunNFT','','Founder of 0xSun group - A community for degen\n - 0xSun.eth\n - 进群申请表: https://t.co/qUTmp0nY5Z','',85641,6080,5567,1602,6080,0,'',0,0,'',0,0,3913,'','','','https://pbs.twimg.com/profile_images/1717887110844477440/cIZFSve_.png','',1562180137,0),
(5,1374985535169552388,'LaserCat397.eth','BitCloutCat','','Builder of @TinFunNFT   @LaserCatNft 🐱','',123148,3909,2138,2446,3909,0,'',0,0,'',0,0,6072,'','','','https://pbs.twimg.com/profile_images/1761761094924894208/9jmd5ltf.jpg','',1616657082,0),
(6,1528645377619939330,'3amClub','My3amclub','','One of the best Web3 community.\nTG：https://t.co/up8XstUDe2\nDC：https://t.co/HjsJvaHYae','',35325,73,369,534,73,0,'',0,0,'',0,0,462,'','','','https://pbs.twimg.com/profile_images/1528645622709952513/WUdfwVNU.jpg','',1653292475,0),
(7,1405904249226088455,'撸币养家 | lubiyangjia.eth','lubi366','','所有推文都不是投资理财建议，不要看、不要点、更不要买！#Binance \n\nOKX WEB3.0 钱包支持80+公链使用，跨链Swap交易，价格更优，有NFT 市场、DeFi 挖矿一站式服务、检查钱包授权服务。 WEB 3 入口 一个就够：https://t.co/aPDkJnCmVw','',162378,5649,1820,2273,5649,0,'',0,0,'',0,0,13699,'','','','https://pbs.twimg.com/profile_images/1705223925763080192/3Xarr0jf.jpg','',1624028677,0),
(8,1002945631407702017,'币圈慈善家','cryptocishanjia','','话痨博主，土狗冲击者，傻逼韭菜，不构成投资建议。\n若想有所改变，应真诚面对自己和他人。\n投资核心：玩得早，买的多，拿得住。\nOKX Web3钱包现已支持70+公链 提供钱包多链，web3入口一个就够：https://t.co/hCZ2he8yFl…','',171443,2837,1092,2628,2837,0,'',0,0,'',0,0,9153,'','','','https://pbs.twimg.com/profile_images/1464518155020083204/OW28mCLv.jpg','',1527955847,0),
(9,1195728139898376193,'🔮0xWizard🧙‍♂️','0xcryptowizard','','#Bitcoin #Etherum 🦇🔊 \n|| Ordinals BRC20\n|| Defi Degen\n|| NFT Collector \n|| On-Chain Analysis\n|| Metaverse Natives\n|| NFA\n||未来不会发任何链接；推文中出现链接，请不要点。','',139473,8824,5112,3928,8824,0,'',0,0,'',0,0,15807,'','','','https://pbs.twimg.com/profile_images/1664263829910605827/TfE9xCvv.jpg','',1573918789,0),
(10,1357671168208117760,'Big bottle','bigbottle44','','','',24734,5191,2803,533,5191,0,'',0,0,'',0,0,11687,'','','','https://pbs.twimg.com/profile_images/1674148781095526408/g8Wg51J_.jpg','',1612529014,0),
(11,1403881130802225152,'大宇','BTCdayu','','最高等级省手续费注册顶级大所\n\n 世界第一大所币安\n https://t.co/FxgwgxNIYN\n\n欧易——出入金好用 \nhttps://t.co/F4T60WPbB5\n\n大宇知识宝库  https://t.co/U5cdAPEjl2','',180383,3014,2665,3251,3014,0,'',0,0,'',0,0,13635,'','','','https://pbs.twimg.com/profile_images/1546148012669292545/BdXvKkv9.jpg','',1623546328,0),
(12,1397728776918765568,'比特肥 || Bitfatty 🦇🔊.B137','Bitfatty','','赌狗 Gambler @BNBBZJ 笨比之家反指总监 DM for collab #closedai 2B$ #base 🐟#based','',38700,3368,976,699,3368,0,'',0,0,'',0,0,4321,'','','','https://pbs.twimg.com/profile_images/1525287875876913152/ToCxWImL.jpg','',1622079493,0),
(13,1308398957287149568,'Dahuzi.eth','Dahuzi_eth','','胡子，光头，不借钱，不借钱，不借钱。 介绍看这里 https://t.co/Mf8G1XzZcd   乐于分享，单纯无求','',101941,3744,732,1633,3744,0,'',0,0,'',0,0,6263,'','','','https://pbs.twimg.com/profile_images/1605746149541154816/uWIyC88-.jpg','',1600781603,0),
(14,1031126178994765824,'很大很大的橙子','0xVeryBigOrange','','听说我是币圈著名反指KOL。\n所以我的推特均不构成投资建议，当然你可以反着开。\n\n关于零❌干货铺所有介绍及相关链接：https://t.co/YSWA986tzT','',52630,973,1008,668,973,0,'',0,0,'',0,0,4608,'','','','https://pbs.twimg.com/profile_images/1406527898308136961/jRLnNYIr.jpg','',1534674613,0),
(15,1698323728898392064,'币毒','0xJustdu','','Just 毒 it. \n野生交易员、DoClub主理人\n交易所集合及社群：https://t.co/M2vyQFmsQn\n进这个群：https://t.co/ZnJckQmQyL','',27068,3621,452,40,3621,0,'',0,0,'',0,0,2944,'','','','https://pbs.twimg.com/profile_images/1698994585345908736/CbXBIKuw.jpg','',1693746934,0),
(16,1516941936971554817,'杀破狼 killthewolf.eth','0xKillTheWolf','','信息整理｜数据分析｜币安返佣：https://t.co/IScCh2xEdL｜OKX 钱包支持 80+ 公链，提供铭文、NFT 市场、DeFi 挖矿等一站式服务：https://t.co/n40M3C9H9w','',121121,32924,3619,1829,32924,0,'',0,0,'',0,0,13747,'','','','https://pbs.twimg.com/profile_images/1680938637628944384/2FYk0Ft4.jpg','',1650502122,0),
(17,1537378444199088129,'加密小师妹|Monica','Monica_xiaoM','','hello，我是陪你一起撸空投的加密小师妹Monica\n热爱Web3 | 爱好唱歌 | 对这个世界充满好奇心\n#空投 基础教程 \n币安广场内容创者：加密小师妹Monica\n关注我，陪你一起在加密世界成长。\n欧易OKX，加密交易所的不二之选!\n20%返佣注册: https://t.co/S0TU4WBw9V','',103993,3812,1306,1467,3812,0,'',0,0,'',0,0,4780,'','','','https://pbs.twimg.com/profile_images/1548689003318509568/poQ9RNrl.jpg','',1655374573,0),
(18,1535225423658770434,'CryptoMaid加密女仆お嬢様WELL3','maid_crypto','','买币：https://t.co/ZEj7W95uCZ\n社会工程学分析师，“东方最有影响力的KOL”. Top Ambassador of @OpenBlockWallet 币安广场创作者','',76454,18119,2750,818,18119,0,'',0,0,'',0,0,10580,'','','','https://pbs.twimg.com/profile_images/1657049785290100736/242zqT6z.jpg','',1654861245,0),
(19,1518140519536279554,'Greta008','Greta0086','','galaxy girl ,gal to moon!\n币圈流浪少年收容所，炒币致命，撸毛致富\n跟我一起撸空投看这里\nhttps://t.co/c5G3J6sRZ0','',110930,1770,1332,2110,1770,0,'',0,0,'',0,0,10853,'','','','https://pbs.twimg.com/profile_images/1518157689334939648/PreEWzyi.jpg','',1650787931,0),
(20,1512812495467020288,'jasmy(J先生)','jasmy_BNB','','$BNB #BNB $BTC #BTC $ETH #ETH 所有推文均不作为投资建议 本金第一 利润第二 短线把握好止赢止损 长线把握好入场位置别贱卖 LOVE BINANCE 没有任何收费群 不会私聊任何人 问你要钱私聊你买币的都是骗子 AZRAGAMES','',62295,42702,888,928,42702,0,'',0,0,'',0,0,9352,'','','','https://pbs.twimg.com/profile_images/1629570945244594177/FIS9LU-g.jpg','',1649517592,0),
(21,1507631541303713793,'川沐','xiaomucrypto','','自由 crypto 纯二级韭菜交易员 -所有内容不构成任何投资建议-不会参与接受任何推广和广告-不私聊不碰任何人资金','',89375,3584,363,1593,3584,0,'',0,0,'',0,0,5123,'','','','https://pbs.twimg.com/profile_images/1595742328450211840/oO6w9IYm.jpg','',1648282358,0),
(22,1466957402813652992,'大西瓜','DAXIAGUA1','','#OKX 是全球领先的交易平台，提供 #BTC #ETH多种加密资产的币币和合约、理财服务，具备1:1储备金，方便安全投资数字资产立即注册https://t.co/73pyJwHpjf\n\n#Binance 行情分析|项目挖掘|投资分享| 抽奖福利\n\nDM For Promo商务合作请私信','',71980,1925,6066,67,1925,0,'',0,0,'',0,0,4886,'','','','https://pbs.twimg.com/profile_images/1700395777745649664/jeJbxhDd.jpg','',1638584899,0),
(23,1466288716348293120,'冷风Meta','zyclw','','Gamefi资深玩家   \n一二级项目投研、投资\n\n🏅Co-founder  @Opensky_888\n🏅 Core Members @InFuture_Web3','',62737,743,730,621,743,0,'',0,0,'',0,0,3805,'','','','https://pbs.twimg.com/profile_images/1476510227088707586/AD6l2DSZ.jpg','',1638425455,0),
(24,1460167107203592193,'Vvicky绵绵','vvickym2','','佛系撸空投｜冲狗女战士｜合约小赌狗 ｜NFT新新人 ｜NCC社区founder｜广子不构成投资建议DYOR｜商务合作DM  V和TG:vvickym2｜#OKX 是全球领先的 #Crypto 交易平台，提供多种加密资产投资服务 注册🔗：https://t.co/C6rTKTfAA7','',78475,2460,1618,250,2460,0,'',0,0,'',0,0,24897,'','','','https://pbs.twimg.com/profile_images/1793152711468449792/Eep6GiEc.jpg','',1636965949,0),
(25,1451220892155998209,'信息捕获手','DUANMEI11','','我是一个热点打野战士，千万别跟着我单，我随时杀进杀出，跟随信息涌动，亏钱勿怪dyro\n#bitget','',40460,22542,2006,811,22542,0,'',0,0,'',0,0,7432,'','','','https://pbs.twimg.com/profile_images/1773898307519307776/W_Tu6z6M.jpg','',1634833004,0),
(26,993430580883742720,'雪球💤🎶','xueqiu88','','#BNB #Binance\n@My3amclub联创\n\nOKX Web3钱包支持80+公链，有钱包、多链 Swap、BRC-20铭刻&交易、NFT 市场、DeFi 挖矿一站式服务:https://t.co/KHkRA9XtB2','',83216,5372,1328,768,5372,0,'',0,0,'',0,0,11238,'','','','https://pbs.twimg.com/profile_images/1678785535593299969/wrVU61OX.jpg','',1525687282,0),
(27,1445222248902651906,'王短鸟','wanghebbf','','短鸟资本创始人、董事会主席兼首席执行官，我曾踏足山巅，也曾进入低谷，从1000万到负债，专心撸空投，主打新手向教程，让所有想撸空投的小白都撸到空投 #Bitget #Binance 20%返佣链接：https://t.co/Wv4SZAqH39','',30722,2427,2497,658,2427,0,'',0,0,'',0,0,7800,'','','','https://pbs.twimg.com/profile_images/1763813158219821056/RyTD4_Q0.jpg','',1633402820,0),
(28,1428197508547629068,'小捕手 CHAOS','iamyourchaos','','Ambassador of @axelarnetwork @dappOS_com; CN KOL Manager of @LayerAIorg @MoonAppOfficial⚡金钱只是通往自由的途径','',74749,18517,6885,1179,18517,0,'',0,0,'',0,0,12714,'','','','https://pbs.twimg.com/profile_images/1757757104994086912/f_i2-6DT.jpg','',1629343805,0),
(29,1470385762348638210,'老叶 1999.eth','1999_eth','','丢失193个BTC的男人丨Web3资深科学家丨连续创业者丨Web3空投猎人丨喜欢打破垄断做免费软件，传统大厂恨的牙痒痒的男人。本账号推文信息不做为投资建议。\n\nRunes符文批量铸造工具：https://t.co/KlRE66cw12','',11542,71,1038,235,71,0,'',0,0,'',0,0,457,'','','','https://pbs.twimg.com/profile_images/1637333781643411456/fE2afskX.jpg','',1639402275,0),
(30,1432106572948275200,'阿酒 🍑','91videoeth','','#OKX 是全球领先的 #Crypto 交易平台，提供 #BTC #ETH 等多种加密资产的币币、合约和理财等衍生品交易服务，具备1:1储备金，帮您方便安全投资数字资产，注册链接：https://t.co/t0plIOPLov 合作请私信DM📧 #火币HTX (🔮wiz @avalonfinance_ ）','',41861,5002,1955,29,5002,0,'',0,0,'',0,0,6220,'','','','https://pbs.twimg.com/profile_images/1792804019448221697/k7Ueaqvy.jpg','',1630275817,0),
(31,1517185876039651332,'Oxray.eth','Ray80230','','一个尝试过币圈各种亏法的老韭菜｜现在是个Web3的交互体验师｜资深Web3产品经理｜社恐博主｜不接广告｜发不发推纯看心情｜所有内容非投资建议｜工作室重组中｜合作以及社群入口Wx：XIAO_SHITOU_8023','',22070,186,1806,534,186,0,'',0,0,'',0,0,1335,'','','','https://pbs.twimg.com/profile_images/1633915946908925952/UWMHjWm5.jpg','',1650560285,0),
(32,1507313459364769796,'XiaoYe小耶✌️','XiaoooYeeee','','NFT | 抽奖福利 | 项目线程 | 合作请私信💌','',16018,459,1099,11,459,0,'',0,0,'',0,0,1612,'','','','https://pbs.twimg.com/profile_images/1761025295904014336/8quLHilx.jpg','',1648206517,0),
(33,1498986001707921408,'Crypto小余','jiji_eth','','风险第一，本金第一，盈利第二。\n#okx.com是全球领先的 #Crypto 交易平台，提供 #BTC #ETH #交易，注册链接：https://t.co/2NJxgUrFey','',45300,1364,590,533,1364,0,'',0,0,'',0,0,3074,'','','','https://pbs.twimg.com/profile_images/1656128584715735040/X59hrvHM.jpg','',1646221104,0),
(34,1456122926432862223,'加密大漂亮| GC研习社（老k线号被盗）','giantcutie666','','资深Web3媒体人|GC研习社发起人|历经两轮牛熊|最新项目解读➕投资，热点资讯分享|本轮BTC看到15万美金  财富密码TG：https://t.co/MWphcCTLCk，Web3项目咨询、运营合作联系TG：@Betty2258\n 更多财富密码：https://t.co/DFd3ib3saw','',67463,8807,1091,631,8807,0,'',0,0,'',0,0,9778,'','','','https://pbs.twimg.com/profile_images/1550390972714029056/gf_BBRIS.jpg','',1636001747,0),
(35,1441606324010184707,'币圈福利哥','yyds123888','','#Binance  $ZBIT | OKX Web3钱包已支持80+公链\n提供钱包、多链 Swap、BRC-20铭刻&交易、NFT 市场、DeFi 挖矿一站式服务 #web3入口一个就够https://t.co/locM2kAg6I | https://t.co/AQVGZg0iSl','',124582,10826,3916,140,10826,0,'',0,0,'',0,0,11557,'','','','https://pbs.twimg.com/profile_images/1731300714507591680/IuPwFTx2.jpg','',1632540712,0),
(36,1463749302065381377,'藤蔓vines','luge517','','All in blockchain，#NFT#Gamefi Player收藏家，深耕优质项目早期投资，专注投研！\n一级二级','',53968,611,625,594,611,0,'',0,0,'',0,0,1470,'','','','https://pbs.twimg.com/profile_images/1694438337325740032/UAJTMuzO.jpg','',1637820017,0),
(37,1372545342831403015,'掘金小可（juejinxiaoke.eth）','juejinxiaoke','','meme、铭文alpha掘金者\n挖掘一级市场初始密码，偶尔玩一玩nft','',10895,661,2367,262,661,0,'',0,0,'',0,0,3416,'','','','https://pbs.twimg.com/profile_images/1703980683264491520/r20loRty.jpg','',1616075301,0),
(38,1294022686583054336,'王大有','youyou5202','','FT名片：https://t.co/aQhaVJk0gI\n\nhttps://t.co/JYJAXQxc0O创始人。曾任职Venus亚太负责和Xterio顾问\n\nVX：wangdayou111、wangdayou6\n\n知识星球:大有Labs','',55515,437,1776,730,437,0,'',0,0,'',0,0,4366,'','','','https://pbs.twimg.com/profile_images/1514012338331869185/FW0kAL3e.jpg','',1597354057,0),
(39,64359118,'追风Lab .lens.eth🔊(🌸, 🌿)','ZF_lab','','OKX Web3钱包现已支持80+公链 \n提供钱包、多链 swap、NFT 市场、DeFi 挖矿一站式服务 \n更有OKX Cryptopedia一键埋伏潜力空投 \n#web3 入口一个就够 https://t.co/TDt1hS2uvn…\n\nhttps://t.co/EHIaslqa6w #Binance','',80411,935,926,2411,935,0,'',0,0,'',0,0,5086,'','','','https://pbs.twimg.com/profile_images/1459430107937132545/4yo40gS8.jpg','',1249891789,0),
(40,107528682,'摸金校尉 𝕏 💙 De.Fi Army','0xBclub','','⚡️#okx 20%返傭：https://t.co/fZyGXOzvuJ | #HTX #BTC #BNB #幣安廣場創作者 | #4E 是阿根廷球隊代言的 #Crypto 交易平台 https://t.co/U73iHoHzNg DM for Collab ✉️','',93577,18976,5572,873,18976,0,'',0,0,'',0,0,31270,'','','','https://pbs.twimg.com/profile_images/1678326070993637376/9CLfHxPB.jpg','',1264196607,0),
(41,1460893694890893313,'crypto指南针（南割）','bishengkegs','','一分耕耘一分收获 ！\n交易所：https://t.co/9xB35L7hvh \n金牌主持@AlanSunJet \n必用web3钱包：https://t.co/YQVTD82rPr\n0KX交易所返佣：https://t.co/I4oeEYEPuK… \nTG：https://t.co/61OKZQUep6\n合作DM','',126913,14453,1816,1180,14453,0,'',0,0,'',0,0,18580,'','','','https://pbs.twimg.com/profile_images/1553416417126789120/2tHJsO9O.jpg','',1637139198,0),
(42,1453603581932687368,'比特币老肥.eth','laofeiyyds','','没啥能力，全靠机遇，所有的内容仅是个人观点不构成任何投资建议 仅此一个账号，其余均为假冒谨防受骗！ #defi #nft #btc #eth 合作咨询TG: btclaofei','',149664,5691,777,943,5691,0,'',0,0,'',0,0,8118,'','','','https://pbs.twimg.com/profile_images/1560234949210284032/ocvp4bAg.jpg','',1635401138,0),
(43,1429654676002131968,'Calman.eth卡门 🦇🔊','CalmanBTC','','Web3\'s Enthusiastist\n🚀 Do the next right thing.  \n🎶Co-founder @My3amclub. \n币安广场作者 #GT','',72597,8361,5026,964,8361,0,'',0,0,'',0,0,15071,'','','','https://pbs.twimg.com/profile_images/1754777827315228672/Gf1XgF9Q.jpg','',1629691219,0),
(44,1396010946699698179,'0xzhaozhao','0xzhaozhao','','Web3菜鸟｜ @d8x_cn 品牌大使｜撸毛入门内容合集&交流群链接 https://t.co/NZFKhXIdTv','',44868,30381,1753,1164,30381,0,'',0,0,'',0,0,12757,'','','','https://pbs.twimg.com/profile_images/1554118675497570304/7hXHYZU6.jpg','',1621669933,0),
(45,1561657733035671553,'我们仍未知道那天所看见的花的名字','ordinalsfund','','on-chain transactions','',18632,2180,1207,404,2180,0,'',0,0,'',0,0,2858,'','','','https://pbs.twimg.com/profile_images/1681709244842921984/JABausp_.jpg','',1661163350,0),
(46,1364886230656114692,'链上达人','wenxue600','','全职奶爸，没有大腿，没有奶子，只有价值输出，不造假，不刷量，宁缺毋滥。\nLens：https://t.co/R4RytVYBk0\n社区：https://t.co/LSCdOSRyrp\n#Binance 广场：https://t.co/pEOmzMD3Ym','',83259,3235,5048,1438,3235,0,'',0,0,'',0,0,7399,'','','','https://pbs.twimg.com/profile_images/1755570127796375552/l17vMuwT.png','',1614249217,0),
(47,1456507428208398336,'发财日记|FaCaiDiary','0xfacairiji','','全身上下只有500RMB进圈｜上一轮铭文牛市做到A7｜梦想是滚仓到A8｜DM for Collab','',17532,24922,3021,160,24922,0,'',0,0,'',0,0,13669,'','','','https://pbs.twimg.com/profile_images/1783652244233375744/Zg7lK5gc.jpg','',1636093424,0),
(48,1507011589119299587,'Dove 德芙 ～','0xdoves','','德芙带你享受丝滑的盈利体验｜#Binance 广场创作者｜持续学习分享知识｜Community：https://t.co/ygqWRT3ajE 、https://t.co/ob7Nf1IbQr｜#GameFi、#DeFi、#NFT、#OKX、#Web3 ｜商务合作请私信 DM for promo 📩','',92438,6906,1846,76,6906,0,'',0,0,'',0,0,4808,'','','','https://pbs.twimg.com/profile_images/1769695402318807040/zLKZWTYi.jpg','',1648134546,0),
(49,1361983910259826695,'石昊','cryptoshihao','','Alpha野人，全身上下只有200刀。\n有事直接评论，私信容易看不到。\n没有群，没能力带人赚钱。\n有个人逻辑打法可以一起交流。','',9920,1552,1988,188,1552,0,'',0,0,'',0,0,1547,'','','','https://pbs.twimg.com/profile_images/1637727301428477952/P33ERQFA.jpg','',1613557250,0),
(50,1476739136023597060,'加密狗','JiamigouCn','','万物皆可精讲，Web3专业教程博主 | #Binance 广场作者\n每日分享：airdrop | AI | gamefi \nBD：https://t.co/OcYe6uHwjd ；\nBinance链接：https://t.co/UxZfwUtcyN','',126682,419,3147,1763,419,0,'',0,0,'',0,0,14083,'','','','https://pbs.twimg.com/profile_images/1734152302087503872/1tGJJFAh.jpg','',1640917034,0),
(51,1392362247574286336,'sanyi.eth','sanyi_eth_','','@My3amclub 联合创始人，著名话痨\n没有内部群，都是假抽，不会带人赚钱！\n任何项目分享，都不构成投资建议！\n外网上一切不团结言论均与本人无关！\n请务必屏蔽拉黑我，我推的项目都是广告、大雷！拉黑sanyi就是避雷！','',177144,4504,2562,2524,4504,0,'',0,0,'',0,0,13714,'','','','https://pbs.twimg.com/profile_images/1554293559012241408/3S7VtrLf.jpg','',1620800008,0),
(52,1372876871990272000,'丰密 ∎ 亏Gas','KuiGas','','亏Gas ∎ 亏钱(∎, ∆) 亏密\n\n ∎Gas的消耗决定人生的方向 ∎\n \n大道至简，以慢至快\n\n🦇🔊   @33daoweb3 @kuiclub','',77714,3432,1048,2751,3432,0,'',0,0,'',0,0,4293,'','','','https://pbs.twimg.com/profile_images/1611964135994195974/g7EzFwTh.jpg','',1616154350,0),
(53,1373081719834775554,'潜水观察员','connectfarm1','','简介还在瞎编中   https://t.co/LCcN4T41Tr','',65574,649,1131,1026,649,0,'',0,0,'',0,0,7596,'','','','https://pbs.twimg.com/profile_images/1776582782053208064/EJOm_hx3.jpg','',1616203174,0),
(54,1470361918711889926,'星星菌xingxingjun.eth🐿️','xingxingjun8888','','🐿️@Seaxing777 SEA•星海漫游链游公会会长｜喜欢配音的菜鸟游戏玩家｜周杰伦粉丝 |主持人｜游戏试玩解说｜商务合作DM','',32667,39469,2349,192,39469,0,'',0,0,'',0,0,26963,'','','','https://pbs.twimg.com/profile_images/1642742651052253184/AgGw_cAx.png','',1639396585,0),
(55,1375278711444959237,'加密小魔女｜Crypto 💎','freyabtc','','👉交易经验10年+｜传统培训机构5年｜3年传统vc基金投后管理｜入加密圈6年｜佛系囤币｜#ordi #sats  #btc #eth #moon\n\n｜爱交易📈热爱分享和学习📖｜\n\n｜所有内容📖只是记录📒非投资建议｜\n\n｜TG：@freya1113\n\n|#BTC|#ETH| #BNB|','',17206,1083,707,16,1083,0,'',0,0,'',0,0,1563,'','','','https://pbs.twimg.com/profile_images/1732599877438185472/InJSBzTh.jpg','',1616726982,0),
(56,1493605098265931777,'尤可欣Isadora','isadora288881','','U founder｜web3 investor｜#OKX web3入口 OKX Web3钱包一个就够 https://t.co/1CGmihVuIR｜ #BNB https://t.co/bpmP8S2Ml7','',76508,1782,1451,153,1782,0,'',0,0,'',0,0,7442,'','','','https://pbs.twimg.com/profile_images/1592146162294788098/1PDaA2UM.jpg','',1644938192,0),
(57,1521739515337007104,'Web3圣手','qklss1','','合作私信📩 | web3从业者 | 币圈老韭菜 | 趋势投资 | 行情分析| 项目分享 | 空投分享 | \n\nOKXWeb3钱包现已支持80+公链提供钱包、多链 Swap、BRC-20铭刻&交易、NFT市场、DeFi挖矿一站式服务 #web3 入口一个就够\nhttps://t.co/kHV0dHNalX','',36003,86,584,13,86,0,'',0,0,'',0,0,725,'','','','https://pbs.twimg.com/profile_images/1728372479557861376/xYzOPvnY.jpg','',1651645961,0),
(58,965571999396397057,'bigplayer.eth🦇🔊','wsdxbz1','','Pepe   Patron  Saint of   @BIPLAYER_DAO  33! @33daoweb3','',74990,2546,8275,1960,2546,0,'',0,0,'',0,0,3417,'','','','https://pbs.twimg.com/profile_images/1591141311561670656/zxdc0cFC.jpg','',1519045278,0),
(59,1499656309565657089,'余烬','EmberCN','','分享链上数据\n数据搬运工+非客观分析\n偶尔发广告\n所有言论都没有投资建议\n#Binance 返佣注册 https://t.co/TOJpJGewf8','',86483,2482,551,1969,2482,0,'',0,0,'',0,0,5309,'','','','https://pbs.twimg.com/profile_images/1538063339917430784/-XWBxDFr.jpg','',1646380911,0),
(60,1444528832606662664,'路遥 | LuYaoTrader','LuYao_Trader','','路遥，全职奶爸、家庭煮夫，励志成为旅行美食博主！\n\n同时为B圈段子手兼全职在家蹲喝西北风交易猿\n反指达人，亏钱小能手，佛系躺平ing...\n\n思考交易，体悟人生。\n\n箴言：\n交易本身就是概率游戏，在胜率以及盈亏比有优势的情况下利用资金管理去扩大你的利润，不要去追求短期的暴利！\n永远记住：盈亏同源。','',62805,584,322,975,584,0,'',0,0,'',0,0,12388,'','','','https://pbs.twimg.com/profile_images/1513045297530019848/b8BpCgsh.jpg','',1633237510,0),
(61,1380082548378722307,'若梦','guilang8','','空投 #Airdrop | #freemint | 优质项目WL | #coin #火币HTX\n\n💛币安广场创作者 #binance\n\n#OKX：https://t.co/WciscBzPRf\n\nDM for Collab ✉️\n\n❗所有推文均不构成投资建议 DYOR','',81188,2395,1663,144,2395,0,'',0,0,'',0,0,3395,'','','','https://pbs.twimg.com/profile_images/1476002424342999043/Wum_3Cac.jpg','',1617872309,0),
(62,112694900,'zlexdl | 空投教程总汇 ♣️','zlexdl','','空投交互教程: https://t.co/CyQgBr1B8D\n\n#OKXWeb3 钱包现已支持90+公链，提供多链 swap/BRC20铭刻&交易/NFT 市场/DeFi 挖矿一站式服务 https://t.co/2AkbGc36DB','',71529,3848,5288,2124,3848,0,'',0,0,'',0,0,6509,'','','','https://pbs.twimg.com/profile_images/1568076333019955200/2zz0e7ST.jpg','',1265716040,0),
(63,1382276514905935873,'茶哥','R5Z5G','','交易员.周期投资者\n\nOKXWeb3钱包现已支持80+公链提供钱包、多链 Swap、BRC-20铭刻&交易、NFT市场、DeFi挖矿一站式服务 #web3 入口一个就够。注册链接https://t.co/fwgYoBduw0','',58882,8254,1256,46,8254,0,'',0,0,'',0,0,4182,'','','','https://pbs.twimg.com/profile_images/1670103545419546626/cHE0nIPQ.jpg','',1618395393,0),
(64,1536393744810909697,'梭哈比特币.eth','AllinBTC_eth','','Altcoins Trader｜ $WELSH 237x, $ORDI 121x, $bitmap 112x…｜\n2017入圈， 从负债到买房 ｜ 币安涨幅榜狙击手｜ VIP频道私聊｜\n个人电报: https://t.co/ltdvV7n8bB\n币安注册: https://t.co/neEc1Y2LlT','',15234,2262,1166,56,2262,0,'',0,0,'',0,0,4474,'','','','https://pbs.twimg.com/profile_images/1641083173202444289/aoF3wsEA.jpg','',1655139801,0),
(65,1454865898938900480,'小元','Btcxiaoyuan','','推文非投资建议 | 从不主动私信 | 盈亏全靠天意 | 不喜可直接取关','',40019,6621,808,463,6621,0,'',0,0,'',0,0,3894,'','','','https://pbs.twimg.com/profile_images/1782766542398320640/HW8qGU0_.jpg','',1635702066,0),
(66,1369089513473990658,'飞凡','feifan7686','','持续输出价值 | 微信投研群：feifan7686｜星辰阁投研社区｜GGD链游公会｜Web3叙事大师｜专注加密金融领域投研｜价值空投挖掘｜认知觉醒 | 合作DM私信｜电报群：https://t.co/tU8XW8mq37','',49034,1287,7752,132,1287,0,'',0,0,'',0,0,3245,'','','','https://pbs.twimg.com/profile_images/1582367675954892801/ebQKm__v.jpg','',1615251358,0),
(67,1139477160882663424,'领哥LingGe🙏','shangdu2005','','领哥策略：熊市撸空攒币，牛市炒币变现 ! \n@BoredApeYC BAYC#4795  #Bitget $BNB OKX Web3提供钱包、多链 swap、NFT 市场、DeFi 挖矿一站式服务 #web3入口 一个就够https://t.co/k2jVorzBsp  合作DM💌','',51757,1895,1999,773,1895,0,'',0,0,'',0,0,4656,'','','','https://pbs.twimg.com/profile_images/1621740905458958337/uUN_tIRj.png','',1560507500,0),
(68,200759534,'奶牛叔 UncleCow','WWTLitee','','监控百位撸毛大佬教程更新 第一时间发布撸毛资讯 所有内容非投资建议 币安广场创作者：奶牛叔 #SOL #RATS #ARB #BNB 商务合作请私信 DM for Collab Telegram：https://t.co/7VG8yQSuDg','',73839,5444,2762,665,5444,0,'',0,0,'',0,0,6586,'','','','https://pbs.twimg.com/profile_images/1654760796000518145/8QaUrPLP.jpg','',1286686637,0),
(69,2666508841,'老张🤟万物有光','zhang_bj_','','觉者，感受着空气的流动，水的滋润，阳光照耀，感知着你的心，感悟着世间沧桑，妄念自己为“哆囉夜多”，能照亮众生的心灵，让人们摆脱痛苦，得到真正的幸福。','',47354,52777,1482,438,52777,0,'',0,0,'',0,0,14613,'','','','https://pbs.twimg.com/profile_images/1636998250354843648/BDj2gX3H.jpg','',1405961736,0),
(70,4927225006,'青禾','HUADA999','','#ETH #BTC #web3 #NFT 穿越牛熊市.8年数字货币投资经验 擅长短线和长线操作，早期项目 #meme币 #NFT #铭文 挖掘者/专注于一级市场/所有文章仅供参考 无任何投资建议🎏（商务合作https://t.co/XhCbvGIFfH请DM）#bitget 注册链接：https://t.co/3vQ4buoRCE','',62132,1967,1435,32,1967,0,'',0,0,'',0,0,1912,'','','','https://pbs.twimg.com/profile_images/1657665668500836353/k8YHVNn5.jpg','',1455787309,0),
(71,1453155415961726980,'Web3｜龙猫','liaoblove520','','早期项目挖掘丨项目推广丨抽奖福利丨\n合作请DM： TG:liaoblove   入驻币安广场\nTEAM/BD｜@ImfiDAO\nDC社区：https://t.co/9ISSSNrxBI\n#BRC | #gamefi | #NFT','',92867,1823,2036,32,1823,0,'',0,0,'',0,0,5774,'','','','https://pbs.twimg.com/profile_images/1698707317980852225/c8cr3mF6.jpg','',1635294261,0),
(72,1525413531641909249,'币圈熊大🐻 Duffy Bear 🐻 UST DAO投研社区 🐻','UST_DAO','','#ALPHA #TRADER \n\nUST DAO投研社区链接：https://t.co/Zqm7DEaYSg   \n社区  Channel: https://t.co/Eepp9XTosh\nYoutube：https://t.co/Tv71CiKTMb\n\nDM  for promos/商务合作✉️','',67750,4717,2165,279,4717,0,'',0,0,'',0,0,4346,'','','','https://pbs.twimg.com/profile_images/1552300317873668096/2B0MxKSy.jpg','',1652521935,0),
(73,1462433809303883778,'加密Krystal','Krystal_Eth','','Web3行业分析｜Web3 社区 | 项目早期投研｜Cofounder | @DeluvLabs . CM |@Debox_Social, @LuckyGo_io #火币HTX：https://t.co/GGuTWhs9Fe。微博https://t.co/fidPYvF30w。TG帐号：@Krystal_Eth','',47793,11276,5164,139,11276,0,'',0,0,'',0,0,8183,'','','','https://pbs.twimg.com/profile_images/1745119026119090176/iGOpUREf.jpg','',1637506375,0),
(74,92839361,'蜡币小鑫','zhuanfgghjnb','','币圈资深老韭菜，涉及币圈多个领域！长期持有 #BTC #ETH #BNB #Binance \n\n撸毛｜挖矿｜打新｜Gamefi｜DeFi｜NFT｜与人为善｜与己为善\n\n#OKX Web3钱包一个就够，现已支持80+公链\n\n#OKX 40%返佣链接：https://t.co/LJIYv2o2c2\n\nTG：@LBXX8','',119330,10481,2642,53,10481,0,'',0,0,'',0,0,11174,'','','','https://pbs.twimg.com/profile_images/1607593522701701122/zv1J_K2-.jpg','',1259271046,0),
(75,1688916563657928704,'Web3第一深情','Web3shenqing','','✉️DM商务合作请私信  长期混迹Web3选手 #web3 投研输出丨 #BNB #Binance 丨白名单分享丨投研丨NFT丨撸毛丨与人为善丨 #OKX 是全球领先的 #Crypto 交易平台，提供多种加密资产衍生品交易服务，立即注册：https://t.co/qf3wBQaitJ','',78325,4691,990,6,4691,0,'',0,0,'',0,0,2690,'','','','https://pbs.twimg.com/profile_images/1733749658915409920/EFnWuebF.jpg','',1691504068,0),
(76,1439621145532137478,'傻X也会撸','lamss001','','请熟读置顶文章,愿后来的人少走弯路。傻人有傻福/可改密码ip全自动购买https://t.co/QWELUKU1RE','',16872,422,805,351,422,0,'',0,0,'',0,0,4123,'','','','https://pbs.twimg.com/profile_images/1756787988200304640/FjCiaTzD.jpg','',1632067412,0),
(77,766292409110130688,'蓝衣侯-已埋伏山寨','lanyihou','','链上交互推荐  #OKXWeb3  钱包，接入60+主流公链，聚合DEX/挖矿/NFT市场等功能的一站式平台\n\n注意：此帐户中提到的任何内容都不是投资建议\n\n仅限个人经历记录！\n\n30万仓位投资笔记，NFT收藏家！！！','',88827,411,3121,1428,411,0,'',0,0,'',0,0,8978,'','','','https://pbs.twimg.com/profile_images/1722532908429369344/MdNyidW_.jpg','',1471533322,0),
(78,1305062626272055296,'BitZQ','BTC521','','内容仅代表个人观点，非投资建议，别盲目跟风，对自己负责！ 纯分享 瞎扯淡 别听 别信 别跟风！！！','',162109,8029,898,1870,8029,0,'',0,0,'',0,0,12477,'','','','https://pbs.twimg.com/profile_images/1788876995377459200/lhdPdFof.jpg','',1599986168,0),
(79,1134052146800922625,'CryptoBullet','CryptoBullet1','','Trader • Market Analyst\n\nDeepcoin : https://t.co/NM0RW9wrrE  🚀 $100K in Bonuses \nBybit : https://t.co/Ba5wJCA1jH  🔥 $30K Welcome Bonus','',118032,12773,109,1667,12773,0,'',0,0,'',0,0,16385,'','','','https://pbs.twimg.com/profile_images/1134053173654675457/12He55jt.jpg','',1559214076,0),
(80,1375373968673099778,'Vivian Gems','VivianGems','','Based in Europe🇪🇺Let\'s grow your business together! #ETH #zkSync #BTC #BSC #MATIC #DYOR','',625357,1180,4795,593,1180,0,'',0,0,'',0,0,2212,'','','','https://pbs.twimg.com/profile_images/1740900981196328960/ieUFIbPr.jpg','',1616749698,0),
(81,1536812312769617920,'Pastel Alpha','PastelAlpha','','Private group focused on sharing comprehensive info for serious investors. We aim to provide an environment that caters to advanced traders and investors.','',14441,369,9,110,369,0,'',0,0,'',0,0,780,'','','','https://pbs.twimg.com/profile_images/1609272591184965632/m_rBSpYX.jpg','',1655239589,0),
(82,1491022181198962692,'Rypto','Rypto__','','Crypto Reviews | Spaces🎙️| Content Creator 🎥 | $VRA','',26827,14345,169,61,14345,0,'',0,0,'',0,0,7341,'','','','https://pbs.twimg.com/profile_images/1777286822382432257/Y7kdMPc2.jpg','',1644322370,0),
(83,993112885,'The Crypto Monster 🍪🍪','MonstersCoins','','Gem Finder 💎💎and #giveaways🐍 \nTrying to make you millionaire \n💰🤑  #NFA #BNB #SOL #ETH #BASE   #TON  #Altcoin #meme #BTC\n\n💸DM for BUSINESS 💸','',125682,8485,150,345,8485,0,'',0,0,'',0,0,36967,'','','','https://pbs.twimg.com/profile_images/1526587746176974849/xaaoBEzw.jpg','',1354801571,0),
(84,190390941,'Mr Barry Crypto','MrBarryCrypto','','Crypto enthusiast and family guy.\nAll my tweets are Non Financial Advice.\nDm for business.','',151967,6574,123,1036,6574,0,'',0,0,'',0,0,12889,'','','','https://pbs.twimg.com/profile_images/1685679005045858304/AkYDq9GO.jpg','',1284411216,0),
(85,1437877103396065285,'Smart crypto games','smartgamesapp','','The new innovation of AI play 2 earn ,Get FREE tokes & WIN cash, join telegram https://t.co/trgf0Y7W1Y ، https://t.co/pRlc84GaYI\n#MASA #smartgamesapp','',29013,26,1523,35,26,0,'',0,0,'',0,0,78,'','','','https://pbs.twimg.com/profile_images/1656064515581042688/bU51L4JF.jpg','',1631651607,0),
(86,1533480052708737024,'Crypto Ninja','CryptoNinja4444','','Crypto Trader | NFA DYOR | I Will Never Dm You First | I Will Never Ask You For Money | Backup Account @CryptoNinja_444','',15946,29245,357,162,29245,0,'',0,0,'',0,0,8297,'','','','https://pbs.twimg.com/profile_images/1533480350919557120/nD6V7-3B.jpg','',1654445134,0),
(87,1383092403758845958,'Crypto Stalkers','StalkersCrypto','','Boost your crypto presence with us🚀Binance Affiliate & Leading crypto Marketing Agency || Managing 400+ KOLs || #Spaceshost #AMA || #BNB #BTC DYOR','',52351,5271,534,26,5271,0,'',0,0,'',0,0,4726,'','','','https://pbs.twimg.com/profile_images/1706721675105255427/ZGb31QC_.jpg','',1618589922,0),
(88,910899153772916736,'Shelby','CryptoNewton','','BitGet partner: https://t.co/SmpDXuetfz\n\nBloFin partner: https://t.co/75dnRwmMhW','',265745,33857,2812,3710,33857,0,'',0,0,'',0,0,30221,'','','','https://pbs.twimg.com/profile_images/1585198113794494470/BklvuxQy.jpg','',1506010256,0),
(89,1371883902265069569,'Mister Crypto','misterrcrypto','','Bitcoin & Altcoin trader and investor. Hunting opportunities in Crypto.','',111094,21693,396,356,21693,0,'',0,0,'',0,0,16142,'','','','https://pbs.twimg.com/profile_images/1644209709128249344/4IW9wcrF.jpg','',1615917591,0),
(90,1480297433020215297,'Edgy - The DeFi Edge 🗡️','thedefiedge','','DeFi Systems Thinking - Sharing the best DeFi strategies, insights, & analysis to help you become more profitable. DMs open for angel / seed opportunities.','',276265,1800,94,7334,1800,0,'',0,0,'',0,0,10404,'','','','https://pbs.twimg.com/profile_images/1607925641965621248/bsB1jenz.jpg','',1641765432,0),
(91,1415997802321256453,'CryptoJack','cryptojack','','🎥 YouTuber (250k SUBS) | Crypto Advisor \n🟢 Founder of @marketspotter 📈\n🤝 Partners @phemex_Official & @primexbt','',315642,1073,780,692,1073,0,'',0,0,'',0,0,13128,'','','','https://pbs.twimg.com/profile_images/1612067746539347969/atnT65Tv.jpg','',1626435167,0),
(92,734755294757027841,'Falleraaa 🌼','Falleraaa','','Crypto and NFT Enthusiast | Giveaway Host | Comunity Growth | Partner @Bybit_official @XTexchange @MEXC_Official | #FalleraTesti | $JTT $SQT 🚀 | 500+ KOL ✨️','',133747,11609,1503,595,11609,0,'',0,0,'',0,0,13415,'','','','https://pbs.twimg.com/profile_images/1684550697231212544/4S7R-2ZR.jpg','',1464014288,0),
(93,124612547,'VR • 9 💥💫','VR10088','','🇲🇨🇬🇧CRYPTO & NFT Influencer - Pianist - Skilled Worker • TG : https://t.co/VRvcK9dC7o • Winners #VRpaid • #DYOR • 🪗@A100888 🎼 Gcash : @AP8Claims🇵🇭','',125170,7023,261,1009,7023,0,'',0,0,'',0,0,25787,'','','','https://pbs.twimg.com/profile_images/1660076934859194369/msrBvPfC.jpg','',1269044786,0),
(94,1386646731450949633,'MR WIZARD','WlZARDNFT','','MR WIZARD - I Make Magic Happen𝓦\n---\n🧙‍♂️ #Web3 Promoter\n🧙‍♂️ Giveaways\n🧙‍♂️ NFTs \n🧙‍♂️ AI \n---\nAll posts are opinions DYOR 𝓦 #MrWizard','',148788,6416,33,1022,6416,0,'',0,0,'',0,0,11471,'','','','https://pbs.twimg.com/profile_images/1750209801764667392/AZHiqMQt.jpg','',1619437328,0),
(95,2549855215,'Gêňíûß🔸Crypto','Genius_Crypto_','','#Bitcoin & #BNB 💎 Holder 🙌 #Binance 𝙺𝙾𝙻||\n 𝐓𝐰𝐞𝐞𝐭 or 𝐑𝐓  𝐀𝐥𝐥 𝐚𝐫𝐞 𝐍𝐅𝐀 | DM 4 Promo 📩Always #DYOR','',91018,24379,629,112,24379,0,'',0,0,'',0,0,6765,'','','','https://pbs.twimg.com/profile_images/1669606901800386561/-jb48dqz.jpg','',1402055142,0),
(96,1497179940260761609,'Eli💫','Ellinette_SocM','','Crypto & Social Media Promoter | Business helper |  DM for promotion 📥 | Vouch #EliiWins','',293023,1098,679,434,1098,0,'',0,0,'',0,0,1688,'','','','https://pbs.twimg.com/profile_images/1694380851696680960/_hGrs7PP.jpg','',1645790497,0);
/*!40000 ALTER TABLE `twitter_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-22 22:22:40
