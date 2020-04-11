--
-- Table structure for table `cd_access`
--

DROP TABLE IF EXISTS `cd_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分组ID',
  `purviewval` varchar(128) DEFAULT NULL COMMENT '分组对应权限值',
  `group_id` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2519 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_access`
--

LOCK TABLES `cd_access` WRITE;
/*!40000 ALTER TABLE `cd_access` DISABLE KEYS */;
INSERT INTO `cd_access` VALUES (2324,'/admin/Health/add',3),(2323,'/admin/Health/update',3),(2322,'/admin/Health/delete',3),(2321,'/admin/Health/view',3),(2320,'/admin/Health/dumpData',3),(2319,'/admin/Health/index',3),(2318,'/admin/Health/import',3),(2317,'/admin/Health',3),(2518,'/admin/Regpoint/view',7),(2517,'/admin/Regpoint/delete',7),(2516,'/admin/Regpoint/updateExt',7),(2515,'/admin/Regpoint/index',7),(2514,'/admin/Regpoint',7),(2513,'/admin/Health/add',7),(2512,'/admin/Health/update',7),(2510,'/admin/Health/view',7),(2511,'/admin/Health/delete',7),(2509,'/admin/Health/dumpData',7),(2508,'/admin/Health/index',7),(2507,'/admin/Health',7),(2506,'/admin/',7),(2505,'/admin/LockLog/dumpData',7),(2504,'/admin/LockLog/view',7),(2503,'/admin/LockLog/delete',7),(2502,'/admin/LockLog/update',7),(2501,'/admin/LockLog/add',7),(2500,'/admin/LockLog/updateExt',7),(2499,'/admin/LockLog/index',7),(2498,'/admin/LockLog',7),(2496,'/admin/LockAuth/delete',7),(2497,'/admin/LockAuth/view',7),(2495,'/admin/LockAuth/update',7),(2494,'/admin/LockAuth/add',7),(2493,'/admin/LockAuth/updateExt',7),(2492,'/admin/LockAuth/index',7),(2491,'/admin/LockAuth',7),(2490,'/admin/Locktimes/index',7),(2489,'/admin/Lock/opendoor',7),(2488,'/admin/Lock/dumpData',7),(2487,'/admin/Lock/view',7),(2486,'/admin/Lock/delete',7),(2485,'/admin/Lock/update',7),(2484,'/admin/Lock/add',7),(2483,'/admin/Lock/index',7),(2482,'/admin/Lock/updateExt',7),(2481,'/admin/Lock',7),(2480,'/admin/',7);
/*!40000 ALTER TABLE `cd_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cd_action`
--

DROP TABLE IF EXISTS `cd_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(9) NOT NULL COMMENT '模块ID',
  `name` varchar(255) DEFAULT NULL COMMENT '动作名称',
  `action_name` varchar(128) NOT NULL COMMENT '动作名称',
  `type` tinyint(4) NOT NULL,
  `icon` varchar(32) DEFAULT NULL COMMENT 'icon图标',
  `pagesize` varchar(5) DEFAULT '20' COMMENT '每页显示数据条数',
  `is_view` tinyint(4) DEFAULT '0' COMMENT '是否按钮',
  `button_status` tinyint(4) DEFAULT NULL COMMENT '按钮是否显示列表',
  `sql_query` mediumtext COMMENT 'sql数据源',
  `block_name` varchar(255) DEFAULT NULL COMMENT '注释',
  `remark` varchar(255) DEFAULT NULL COMMENT '打开页面尺寸',
  `fields` text COMMENT '操作的字段',
  `note` varchar(255) DEFAULT NULL COMMENT '备注',
  `lable_color` varchar(12) DEFAULT NULL COMMENT '按钮背景色',
  `relate_table` varchar(32) DEFAULT NULL COMMENT '关联表',
  `relate_field` varchar(32) DEFAULT NULL COMMENT '关联字段',
  `list_field` varchar(255) DEFAULT NULL COMMENT '查询的字段',
  `bs_icon` varchar(32) DEFAULT NULL COMMENT '按钮图标',
  `sortid` mediumint(9) DEFAULT '0' COMMENT '排序',
  `orderby` varchar(250) DEFAULT NULL COMMENT '配置排序',
  `default_orderby` varchar(50) DEFAULT NULL COMMENT '默认排序',
  `tree_config` varchar(50) DEFAULT NULL,
  `jump` varchar(120) DEFAULT NULL COMMENT '按钮跳转地址',
  `is_controller_create` tinyint(4) DEFAULT '1' COMMENT '是否生成控制其方法',
  `is_service_create` tinyint(4) DEFAULT NULL COMMENT '是否生成服务层方法',
  `is_view_create` tinyint(4) DEFAULT NULL COMMENT '视图生成',
  `cache_time` mediumint(9) DEFAULT NULL COMMENT '缓存时间',
  `log_status` tinyint(4) DEFAULT NULL COMMENT '是否生成日志',
  `api_auth` tinyint(4) DEFAULT NULL COMMENT '接口是否鉴权',
  `sms_auth` tinyint(4) DEFAULT NULL COMMENT '短信验证',
  `request_type` varchar(20) DEFAULT NULL COMMENT '请求类型 get 或者 post',
  `captcha_auth` tinyint(4) DEFAULT NULL COMMENT '图片验证码验证',
  `do_condition` varchar(255) DEFAULT NULL COMMENT '操作条件',
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2866 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_action`
--

LOCK TABLES `cd_action` WRITE;
/*!40000 ALTER TABLE `cd_action` DISABLE KEYS */;
INSERT INTO `cd_action` VALUES (78,18,'首页数据列表','index',1,'','',0,0,'','用户管理','','group_id','','primary','group','group_id','a.*,b.name as group_name','',1,'','','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(80,18,'添加','add',3,'','20',1,0,'','添加账户','800px|600px','name,user,pwd,group_id,type,note,status,create_time','','primary','','','','fa fa-plus',3,'','','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(81,18,'修改','update',4,'','',1,1,'','修改账户','800px|550px','name,user,group_id,type,note,status,create_time','','success','','','','fa fa-edit',4,'','','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(82,18,'修改密码','updatePassword',9,'','',1,0,'','修改密码','600px|300px','pwd','','warning','','','','',6,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(85,19,'首页数据列表','index',1,'','',0,0,'','分组管理','600px|250px','','','primary','','','','',1,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(87,19,'添加','add',3,'','',1,0,'','添加分组','800px|400px','name,status,role','','primary','','','','plus',3,'','','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(88,19,'修改','update',4,'','',1,1,'','修改分组','800px|400px','name,status,role','','primary','','','','',4,'','','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(89,19,'禁用','forbidden',6,'','',1,0,'','禁用','0','status','','warning','','','','edit',5,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(90,19,'启用','start',6,'','',1,0,'','启用','10','status','','warning','','','','edit',6,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(91,19,'设置权限','auth',11,'','',1,0,'','弹窗连接','90%|90%','','','info','','','','plus',7,'','','','/Base/auth',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(106,19,'查看用户','viewUser',11,'','',1,1,'','弹窗连接','90%|90%','','','success','','','','plus',8,'','','','/User/index',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(124,52,'首页数据列表','index',1,'','',0,0,'select a.*,b.name as group_name,c.name as nickname from cd_log as a inner join cd_group as b inner join cd_user as c on a.user_id = c.user_id and c.group_id= b.group_id','登录日志管理','','','','primary','','','','',1,'','','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(128,52,'删除','delete',5,'',NULL,1,0,'','删除','','','','danger','','','','trash',4,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(130,41,'修改配置','index',4,'','',1,0,'','修改','600px|300px','','','primary','','','','',127,'','','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1668,18,'删除','delete',5,NULL,'',1,1,'','删除数据','','',NULL,'danger','','','','fa fa-trash',1668,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2076,18,'禁用','forbidden',6,NULL,'',1,0,'','修改状态','0','status',NULL,'success','','','','fa fa-pencil',2076,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2075,18,'启用','start',6,NULL,'',1,0,'','修改状态','1','status',NULL,'success','','','','fa fa-pencil',2075,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2726,793,'首页数据列表','index',1,NULL,'20',0,0,'','会员管理','','',NULL,'primary','','','','',1,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2727,793,'修改排序开关按钮操作','updateExt',16,NULL,'20',0,NULL,NULL,'修改排序、开关按钮操作 如果没有此类操作 可以删除该方法',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2728,793,'添加','add',3,NULL,'20',1,0,'','添加','800px|100%','nickname,headimgurl,openid,mobile,username,password,create_time,sex,status',NULL,'primary','','','','fa fa-plus',2728,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2729,793,'修改','update',4,NULL,'20',1,1,'','修改','800px|600px','nickname,headimgurl,openid,mobile,username,create_time,sex,status',NULL,'success','','','','fa fa-pencil',2729,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2730,793,'删除','delete',5,NULL,'20',1,1,'','删除','800px|600px','nickname,headimgurl,openid,mobile,username,create_time,sex,status',NULL,'danger','','','','fa fa-trash',2730,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2731,793,'查看数据','view',15,NULL,'20',1,0,'','查看数据','800px|600px','nickname,headimgurl,openid,mobile,username,create_time,sex,status',NULL,'info','','','','fa fa-plus',2731,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2770,803,'修改排序开关按钮操作','updateExt',16,NULL,'20',0,NULL,NULL,'修改排序、开关按钮操作 如果没有此类操作 可以删除该方法',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2734,794,'更新用户信息','update',4,NULL,'20',1,1,'','编辑数据','','nickname,headimgurl,openid,mobile,sex',NULL,'success','','','','fa fa-pencil',2746,NULL,'','',NULL,1,1,NULL,0,1,1,0,'post',0,NULL),(2736,794,'查看用户信息','view',15,NULL,'20',1,0,'','查看用户信息','','nickname,headimgurl,openid,mobile,username,password,sex,status,create_time',NULL,'info','','','','fa fa-plus',2747,NULL,'','',NULL,1,1,NULL,0,1,1,0,'post',0,NULL),(2769,803,'首页数据列表','index',1,NULL,'20',0,0,'','门锁管理','','user_id,lock_name,lock_sn,mobile_check,applyauth,applyauth_check,location_check,status,lock_type,location,online,lock_qrcode,create_time,successimg,successadimg',NULL,'primary','','','','',1,NULL,'','','',0,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2747,794,'小程序登录','xcxlogin',28,NULL,'',0,NULL,'','小程序登录','openid','nickname,headimgurl,openid,mobile,username,password,sex,status,create_time',NULL,NULL,'user','member_id','a.*,b.user_id',NULL,2728,NULL,'','',NULL,0,1,NULL,0,1,0,0,'post',0,NULL),(2740,793,'重置密码','resetpassword',9,NULL,'',1,0,'','修改密码','600px|350px','password',NULL,'primary','','','','fa fa-lock',2740,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2741,797,'添加','add',3,NULL,'20',1,0,'','添加','800px|100%','name,mobile,first_address,second_address,position,job,yiqu,register_type,health,manyou,txz,create_time,lat,lng,user_id,openid,regpoint_id',NULL,'primary','','','','fa fa-plus',2741,NULL,'','',NULL,1,1,NULL,0,1,0,0,'post',0,NULL),(2767,802,'数据列表','index',1,NULL,'',1,0,'','','','name,mobile,first_address,second_address,position,job,yiqu,register_type,health,manyou,txz,create_time,lat,lng,user_id,openid,regpoint_id',NULL,'primary','','','','',2767,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2744,797,'查看数据详情页','view',15,NULL,'20',1,0,'','查看数据','','name,mobile,first_address,second_address,position,job,yiqu,register_type,health,manyou,txz,create_time,lat,lng,user_id,openid',NULL,'info','','','','fa fa-plus',2768,NULL,'','',NULL,1,1,NULL,0,1,1,0,'post',0,NULL),(2768,797,'查看数据列表','list',1,NULL,'20',0,NULL,'','','','',NULL,NULL,'','','',NULL,2744,NULL,'health_id desc','',NULL,1,1,NULL,0,1,1,0,'post',0,NULL),(2765,802,'导出','dumpData',12,NULL,'20',1,0,NULL,'导出','','user_id,create_time,lat,lng,txz,manyou,register_type,yiqu,health,job,position,second_address,first_address,name,mobile',NULL,'warning',NULL,NULL,NULL,'fa fa-download',2765,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2764,802,'查看数据','view',15,NULL,'20',1,0,'','查看数据','800px|100%','name,mobile,first_address,second_address,position,job,yiqu,register_type,health,manyou,txz,create_time,lat,lng,user_id,openid',NULL,'info','','','','fa fa-plus',2764,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2763,802,'删除','delete',5,NULL,'20',1,1,NULL,'删除','','user_id,create_time,lat,lng,txz,manyou,register_type,yiqu,health,job,position,second_address,first_address,name,mobile',NULL,'danger',NULL,NULL,NULL,'fa fa-trash',2763,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2762,802,'修改','update',4,NULL,'20',1,1,'','修改','800px|100%','name,mobile,first_address,second_address,position,job,yiqu,register_type,health,manyou,txz,create_time,lat,lng,user_id,openid',NULL,'success','','','','fa fa-pencil',2762,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2761,802,'添加','add',3,NULL,'20',1,0,'','添加','800px|100%','name,mobile,first_address,second_address,position,job,yiqu,register_type,health,manyou,txz,create_time,lat,lng,user_id,openid',NULL,'primary','','','','fa fa-plus',2761,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2771,804,'首页数据列表','index',1,NULL,'20',0,0,'','登记点管理','','',NULL,'primary','','','','',1,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2772,804,'修改排序开关按钮操作','updateExt',16,NULL,'20',0,NULL,NULL,'修改排序、开关按钮操作 如果没有此类操作 可以删除该方法',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2775,804,'删除','delete',5,NULL,'20',1,1,NULL,'删除','','member_id,user_id,regpointname,regpointurl,create_time',NULL,'danger',NULL,NULL,NULL,'fa fa-trash',2775,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2776,804,'查看数据','view',15,NULL,'20',1,0,'','查看数据','800px|450px','member_id,user_id,regpointname,regpointqrcode,create_time',NULL,'info','','','','fa fa-plus',2776,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2794,803,'添加','add',3,NULL,'20',1,0,'','添加','800px|100%','user_id,lock_name,lock_sn,mobile_check,applyauth,applyauth_check,location_check,status,lock_type,location,create_time,successimg,successadimg',NULL,'primary','','','','fa fa-plus',2794,NULL,'','','',0,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2779,805,'修改','update',4,NULL,'20',1,1,'','修改','','member_id,user_id,regpointname,regpointurl,create_time',NULL,'success','','','','fa fa-pencil',2774,NULL,'','',NULL,1,1,NULL,0,1,1,0,'post',0,NULL),(2780,805,'删除','delete',5,NULL,'20',1,1,'','删除','','member_id,user_id,regpointname,regpointurl,create_time',NULL,'danger','','','','fa fa-trash',2775,NULL,'','',NULL,1,1,NULL,0,1,1,0,'post',0,NULL),(2781,805,'查看数据','view',15,NULL,'20',1,0,'','查看数据','','member_id,user_id,regpointname,regpointurl,create_time',NULL,'info','','','','fa fa-plus',2776,NULL,'','',NULL,1,1,NULL,0,1,1,0,'post',0,NULL),(2789,806,'查询管理员','view',15,NULL,'',0,NULL,'','','','',NULL,NULL,'','','',NULL,2789,NULL,'','',NULL,1,1,NULL,0,1,1,0,'post',0,NULL),(2795,803,'修改','update',4,NULL,'20',1,1,'','修改','800px|100%','user_id,lock_name,lock_sn,mobile_check,applyauth,applyauth_check,location_check,status,lock_type,location,lock_qrcode,create_time,successimg,successadimg',NULL,'success','','','','fa fa-pencil',2795,NULL,'','','',0,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2784,806,'修改','update',4,'','',1,1,'','修改账户','','name,user,group_id,type,note,status,member_id,create_time','','success','','','','fa fa-edit',4,'','','','',1,1,1,0,1,1,0,'post',0,NULL),(2785,806,'修改密码','updatePassword',9,'','',1,0,'','修改密码','','pwd','','warning','','','','',6,'','','',NULL,1,1,NULL,0,1,1,0,'post',0,NULL),(2793,794,'查询管理员ID','viewuserid',15,NULL,'',0,NULL,'','查询管理员ID','','',NULL,NULL,'user','member_id','a.member_id,b.*',NULL,2793,NULL,'','',NULL,1,1,NULL,0,1,1,0,'post',0,NULL),(2796,803,'删除','delete',5,NULL,'20',1,1,'','删除','800px|100%','user_id,lock_name,lock_sn,mobile_check,getkey,getkey_check,status,lock_type,location,create_time',NULL,'danger','','','','fa fa-trash',2796,NULL,'','','',0,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2797,803,'查看数据','view',15,NULL,'20',1,0,'','查看数据','800px|100%','user_id,lock_name,lock_sn,mobile_check,applyauth,applyauth_check,status,lock_type,location,location_check,lock_qrcode,create_time,successimg,successadimg',NULL,'info','','','','fa fa-plus',2797,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2798,803,'导出','dumpData',12,NULL,'20',1,0,'','导出','800px|100%','user_id,lock_name,lock_sn,mobile_check,getkey,getkey_check,status,lock_type,location,create_time',NULL,'warning','','','','fa fa-download',2798,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2799,807,'首页数据列表','index',1,NULL,'20',0,NULL,NULL,'门锁类型',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2800,807,'修改排序开关按钮操作','updateExt',16,NULL,'20',0,NULL,NULL,'修改排序、开关按钮操作 如果没有此类操作 可以删除该方法',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2801,807,'添加','add',3,NULL,'20',1,0,NULL,'添加','600px|350px','locktype_name',NULL,'primary',NULL,NULL,NULL,'fa fa-plus',2801,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2802,807,'修改','update',4,NULL,'20',1,1,NULL,'修改','600px|350px','locktype_name',NULL,'success',NULL,NULL,NULL,'fa fa-pencil',2802,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2803,807,'删除','delete',5,NULL,'20',1,1,NULL,'删除','','locktype_name',NULL,'danger',NULL,NULL,NULL,'fa fa-trash',2803,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2804,807,'查看数据','view',15,NULL,'20',1,0,NULL,'查看数据','600px|350px','locktype_name',NULL,'info',NULL,NULL,NULL,'fa fa-plus',2804,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2805,803,'开门','opendoor',4,NULL,'',1,0,'','编辑数据','','',NULL,'primary','','','','fa fa-edit',2805,NULL,'','','',0,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2806,809,'首页列表','index',1,NULL,'20',0,0,'','钥匙管理','','',NULL,'primary','','','','',1,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2807,809,'修改排序开关按钮操作','updateExt',16,NULL,'20',0,NULL,NULL,'修改排序、开关按钮操作 如果没有此类操作 可以删除该方法',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2808,809,'添加','add',3,NULL,'20',0,0,'','添加','800px|100%','lock_id,member_id,auth_member_id,auth_sharelimit,auth_starttime,auth_endtime,auth_shareability,remark,create_time,auth_openlimit,auth_isadmin',NULL,'primary','','','','fa fa-plus',2808,NULL,'','','',0,1,0,NULL,NULL,NULL,NULL,NULL,NULL,''),(2809,809,'修改','update',4,NULL,'20',1,1,'','修改','800px|100%','lock_id,member_id,auth_member_id,auth_sharelimit,auth_starttime,auth_endtime,auth_shareability,remark,create_time,auth_openlimit,auth_isadmin',NULL,'success','','','','fa fa-pencil',2809,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2810,809,'删除','delete',5,NULL,'20',1,1,'','删除','800px|100%','lock_id,member_id,auth_member_id,auth_sharelimit,auth_starttime,auth_endtime,auth_shareability,remark,create_time,auth_openlimit,auth_isadmin',NULL,'danger','','','','fa fa-trash',2810,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2811,809,'查看数据','view',15,NULL,'20',1,0,'','查看数据','800px|100%','lock_id,member_id,auth_member_id,auth_sharelimit,auth_starttime,auth_endtime,auth_shareability,remark,create_time,auth_openlimit,auth_isadmin',NULL,'info','','','','fa fa-plus',2811,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2834,813,'查询锁信息','view',15,NULL,'20',1,0,'','根据lock_id查询锁信息','','user_id,lock_name,lock_sn,mobile_check,location_check,status,lock_type,location,create_time,lock_qrcode,online,successimg,successadimg',NULL,'info','','','','fa fa-plus',2797,NULL,'','','',1,1,1,0,1,1,0,'post',0,''),(2833,813,'删除','delete',5,NULL,'20',1,1,'','删除','','member_id,user_id,lock_name,lock_sn,mobile_check,getkey,getkey_check,status,lock_type,location,create_time,lock_qrcode,online',NULL,'danger','','','','fa fa-trash',2796,NULL,'','','',0,1,1,0,1,1,0,'post',0,''),(2832,813,'修改','update',4,NULL,'20',1,1,'','修改','','member_id,user_id,lock_name,lock_sn,mobile_check,getkey,getkey_check,status,lock_type,location,create_time,lock_qrcode,online',NULL,'success','','','','fa fa-pencil',2795,NULL,'','','',1,1,1,0,1,1,0,'post',0,''),(2831,813,'添加','add',3,NULL,'20',1,0,'','添加','','',NULL,'primary','','','','fa fa-plus',2794,NULL,'','','',0,1,1,0,1,1,0,'post',0,''),(2847,18,'查看数据','view',15,NULL,'20',1,0,NULL,'查看数据','800px|100%','name,user,pwd,group_id,type,note,status,create_time,member_id',NULL,'info',NULL,NULL,NULL,'fa fa-plus',2847,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2840,814,'删除','delete',5,NULL,'20',1,1,'','删除','','lock_id,member_id,auth_member_id,auth_endtime,auth_starttime,auth_shareability,remark,create_time',NULL,'danger','','','','fa fa-trash',2810,NULL,'','',NULL,0,1,NULL,0,1,1,0,'post',0,NULL),(2839,814,'审核钥匙','verifyauth',4,NULL,'20',1,1,'','审核钥匙','','lock_id,member_id,auth_member_id,auth_sharelimit,auth_openlimit,auth_starttime,auth_endtime,auth_isadmin,auth_shareability,remark,create_time,auth_status,user_id',NULL,'success','','','','fa fa-pencil',2809,NULL,'','',NULL,0,1,NULL,0,1,1,0,'post',0,NULL),(2838,814,'申请钥匙','applyauth',3,NULL,'20',1,0,'','申请钥匙','','lock_id,member_id,realname,remark,create_time,auth_status,user_id',NULL,'primary','','','','fa fa-plus',2808,NULL,'','',NULL,0,1,NULL,0,1,1,0,'post',0,NULL),(2836,813,'开门','opendoor',4,NULL,'',1,0,'','编辑数据','','',NULL,'primary','','','','fa fa-edit',2805,NULL,'','','',0,1,1,0,1,1,0,'post',0,''),(2837,814,'根据会员id查询钥匙列表','getauthlistbymemid',1,NULL,'20',0,NULL,'','根据会员id查询钥匙','','lock_id',NULL,NULL,'lock','lock_id','',NULL,1,NULL,'','',NULL,0,1,NULL,0,1,1,0,'post',0,NULL),(2824,812,'首页数据列表','index',1,NULL,'20',0,0,'select a.*,b.headimgurl,b.nickname,b.mobile,c.lock_name from cd_locklog as a inner join cd_member as b inner join cd_lock as c where a.member_id=b.member_id and a.lock_id=c.lock_id','日志管理','','',NULL,'primary','','','','fa fa-bars',1,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2825,812,'修改排序开关按钮操作','updateExt',16,NULL,'20',0,NULL,NULL,'修改排序、开关按钮操作 如果没有此类操作 可以删除该方法',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2826,812,'添加','add',3,NULL,'20',1,0,NULL,'添加','800px|450px','member_id,lock_id,status,type,create_time',NULL,'primary',NULL,NULL,NULL,'fa fa-plus',2826,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2827,812,'修改','update',4,NULL,'20',1,1,NULL,'修改','800px|450px','member_id,lock_id,status,type,create_time',NULL,'success',NULL,NULL,NULL,'fa fa-pencil',2827,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2828,812,'删除','delete',5,NULL,'20',1,1,NULL,'删除','','member_id,lock_id,status,type,create_time',NULL,'danger',NULL,NULL,NULL,'fa fa-trash',2828,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2829,812,'查看数据','view',15,NULL,'20',1,0,NULL,'查看数据','800px|450px','member_id,lock_id,status,type,create_time',NULL,'info',NULL,NULL,NULL,'fa fa-plus',2829,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2841,814,'查看数据','getauthdetailbyid',15,NULL,'20',1,0,'','查看数据','','lock_id,member_id,auth_member_id,auth_endtime,auth_starttime,auth_shareability,remark,create_time',NULL,'info','','','','fa fa-plus',2811,NULL,'','',NULL,0,1,NULL,0,1,1,0,'post',0,NULL),(2842,815,'获取开门日志','getopenlog',1,NULL,'20',0,NULL,'','获取开门日志','','member_id',NULL,NULL,'member','member_id','a.*,b.nickname,b.headimgurl',NULL,1,NULL,'','',NULL,0,1,NULL,0,1,0,0,'post',0,NULL),(2843,815,'添加','add',3,NULL,'20',1,0,NULL,'添加','','member_id,lock_id,status,type,create_time',NULL,'primary',NULL,NULL,NULL,'fa fa-plus',2826,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL),(2844,815,'修改','update',4,NULL,'20',1,1,NULL,'修改','','member_id,lock_id,status,type,create_time',NULL,'success',NULL,NULL,NULL,'fa fa-pencil',2827,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL),(2845,815,'删除','delete',5,NULL,'20',1,1,NULL,'删除','','member_id,lock_id,status,type,create_time',NULL,'danger',NULL,NULL,NULL,'fa fa-trash',2828,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL),(2846,815,'查看数据','view',15,NULL,'20',1,0,NULL,'查看数据','','member_id,lock_id,status,type,create_time',NULL,'info',NULL,NULL,NULL,'fa fa-plus',2829,NULL,NULL,NULL,NULL,0,NULL,NULL,NULL,1,1,NULL,NULL,NULL,NULL),(2848,816,'修改配置','index',4,'','',1,0,'','修改','','','','primary','','','','',127,'','','','',0,1,1,NULL,1,NULL,NULL,NULL,NULL,NULL),(2849,816,'获取配置信息','getconfig',15,NULL,'20',1,0,'','查看数据','','site_title,site_logo,keyword,description,file_size,file_type,domain,copyright,wmjappid,wmjappsecret,wmjaeskey',NULL,'info','','','','fa fa-plus',2849,NULL,'','',NULL,0,1,NULL,0,1,0,0,'post',0,NULL),(2850,812,'导出','dumpData',12,NULL,'20',1,0,'select a.*,b.headimgurl,b.nickname,b.mobile,c.lock_name from cd_locklog as a inner join cd_member as b inner join cd_lock as c where a.member_id=b.member_id and a.lock_id=c.lock_id','导出','','',NULL,'warning','','','','fa fa-download',2850,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2851,803,'可开门时段设置','enopentimesset',11,NULL,'',1,0,'','弹窗连接','90%|90%','',NULL,'primary','','','','fa fa-plus',2851,NULL,'','','/Locktimes/index',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2852,818,'首页数据列表','index',1,NULL,'20',0,NULL,NULL,'开门时段',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2853,818,'修改排序开关按钮操作','updateExt',16,NULL,'20',0,NULL,NULL,'修改排序、开关按钮操作 如果没有此类操作 可以删除该方法',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2854,818,'添加','add',3,NULL,'20',1,0,'','添加','800px|100%','locktimesname,user_id,lock_id,startweek,starthour,startminute,endweek,endhour,endminute,create_time',NULL,'primary','','','','fa fa-plus',2854,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2855,818,'修改','update',4,NULL,'20',1,1,'','修改','800px|100%','locktimesname,user_id,lock_id,startweek,starthour,startminute,endweek,endhour,endminute',NULL,'success','','','','fa fa-pencil',2855,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2856,818,'删除','delete',5,NULL,'20',1,1,NULL,'删除','','user_id,lock_id,startweek,starthour,startminute,endweek,endhour,endminute,create_time',NULL,'danger',NULL,NULL,NULL,'fa fa-trash',2856,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2857,818,'查看数据','view',15,NULL,'20',1,0,'','查看数据','800px|100%','locktimesname,user_id,lock_id,startweek,starthour,startminute,endweek,endhour,endminute,create_time',NULL,'info','','','','fa fa-plus',2857,NULL,'','','',1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,''),(2858,814,'分享钥匙','shareauth',3,NULL,'',0,NULL,'','生成分享前的临时钥匙','','lock_id,auth_member_id,auth_sharelimit,auth_openlimit,auth_starttime,auth_endtime,auth_shareability,auth_opentimes,remark,create_time,auth_status,user_id',NULL,NULL,'','','',NULL,2858,NULL,'','',NULL,0,1,NULL,0,1,1,0,'post',0,NULL),(2859,814,'领取钥匙','getkey',4,NULL,'',0,NULL,'','领取钥匙','','lock_id,member_id',NULL,NULL,'','','',NULL,2859,NULL,'','',NULL,0,1,NULL,0,1,1,0,'post',0,NULL),(2860,819,'查询可开门时段','getopentimes',1,NULL,'20',0,NULL,'','查询可开门时段','','',NULL,NULL,'','','',NULL,1,NULL,'','',NULL,0,1,NULL,0,1,1,0,'post',0,NULL),(2865,794,'支付宝小程序登录','alipaylogin',29,NULL,'',0,NULL,'','','ali_user_id','headimgurl,username,sex',NULL,NULL,'','','',NULL,2865,NULL,'','',NULL,0,1,NULL,0,1,0,0,'post',0,NULL);
/*!40000 ALTER TABLE `cd_action` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cd_application`
--

DROP TABLE IF EXISTS `cd_application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_application` (
  `app_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `app_dir` varchar(250) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `app_type` tinyint(4) DEFAULT NULL,
  `login_table` varchar(250) DEFAULT NULL,
  `login_fields` varchar(250) DEFAULT NULL,
  `domain` varchar(250) DEFAULT NULL,
  `pk` varchar(50) DEFAULT NULL COMMENT '登录表主键',
  PRIMARY KEY (`app_id`)
) ENGINE=MyISAM AUTO_INCREMENT=182 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_application`
--

LOCK TABLES `cd_application` WRITE;
/*!40000 ALTER TABLE `cd_application` DISABLE KEYS */;
INSERT INTO `cd_application` VALUES (1,'后台管理端','admin',1,1,'','','',NULL),(179,'api','api',1,2,'','','https://wxapp.wmj.com.cn/api',''),(181,'minilock','minilock',1,2,'','','','');
/*!40000 ALTER TABLE `cd_application` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cd_config`
--

DROP TABLE IF EXISTS `cd_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_config` (
  `name` varchar(50) NOT NULL,
  `data` varchar(250) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_config`
--

LOCK TABLES `cd_config` WRITE;
/*!40000 ALTER TABLE `cd_config` DISABLE KEYS */;
INSERT INTO `cd_config` VALUES ('copyright','极客师傅 QQ:13886161 &lt;a href=&quot;http://www.beian.miit.gov.cn/&quot;&gt;黔ICP备12003086号-3&lt;/a&gt;'),('default_themes',''),('description','微门禁小程序管理平台'),('domain',''),('file_size','100'),('file_type','gif,png,jpg,jpeg,doc,docx,xls,xlsx,csv,pdf,rar,zip,txt,mp4,flv'),('images_size','10M'),('keyword',''),('site_logo','/uploads/admin/202004/5e90014472f46.jpg'),('site_title','微门禁小程序管理平台'),('wmjaeskey',''),('wmjappid','wmj_2f4AtrJZK4m'),('wmjappsecret','XUgwLG7i8y0T7cUVaXd0Q2k9VkLyKtPA');
/*!40000 ALTER TABLE `cd_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cd_ext_health`
--

DROP TABLE IF EXISTS `cd_ext_health`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_ext_health` (
  `health_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `first_address` varchar(250) NOT NULL DEFAULT '' COMMENT '第一居住地址',
  `second_address` varchar(250) NOT NULL DEFAULT '' COMMENT '第二居住地址',
  `job` varchar(250) NOT NULL DEFAULT '' COMMENT '工作或学习单位',
  `yiqu` tinyint(4) unsigned NOT NULL DEFAULT '2' COMMENT '30日内是否来自疫区:1是,默认2否',
  `register_type` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '登记类型:默认1村居,2乡镇社区,3区县,4交通运输',
  `health` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '健康状况默认1健康,2异常,3其他',
  `manyou` varchar(250) NOT NULL DEFAULT '' COMMENT '漫游地截图',
  `txz` varchar(250) NOT NULL DEFAULT '' COMMENT '通行证截图',
  `ctime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `utime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`health_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_ext_health`
--

LOCK TABLES `cd_ext_health` WRITE;
/*!40000 ALTER TABLE `cd_ext_health` DISABLE KEYS */;
/*!40000 ALTER TABLE `cd_ext_health` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cd_field`
--

DROP TABLE IF EXISTS `cd_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(9) NOT NULL COMMENT '模块ID',
  `name` varchar(64) NOT NULL COMMENT '字段名称',
  `field` varchar(32) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '表单类型1输入框 2下拉框 3单选框 4多选框 5上传图片 6编辑器 7时间',
  `list_show` tinyint(4) DEFAULT NULL COMMENT '列表显示',
  `search_show` tinyint(4) DEFAULT NULL COMMENT '搜索显示',
  `search_type` tinyint(4) DEFAULT NULL COMMENT '1精确匹配 2模糊搜索',
  `config` varchar(255) DEFAULT NULL COMMENT '下拉框或者单选框配置',
  `is_post` tinyint(4) DEFAULT NULL COMMENT '是否前台录入',
  `is_field` tinyint(4) DEFAULT NULL,
  `align` varchar(24) DEFAULT NULL COMMENT '表格显示位置',
  `note` varchar(255) DEFAULT NULL COMMENT '提示信息',
  `message` varchar(255) DEFAULT NULL COMMENT '错误提示',
  `validate` varchar(32) DEFAULT NULL COMMENT '验证方式',
  `rule` mediumtext COMMENT '验证规则',
  `sortid` mediumint(9) DEFAULT '0' COMMENT '排序号',
  `sql` varchar(255) DEFAULT NULL COMMENT '字段配置数据源sql',
  `tab_menu_name` varchar(30) DEFAULT NULL COMMENT '所属选项卡名称',
  `default_value` varchar(255) DEFAULT NULL,
  `datatype` varchar(32) DEFAULT NULL COMMENT '字段数据类型',
  `length` varchar(5) DEFAULT NULL COMMENT '字段长度',
  `indexdata` varchar(20) DEFAULT NULL COMMENT '索引',
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3491 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_field`
--

LOCK TABLES `cd_field` WRITE;
/*!40000 ALTER TABLE `cd_field` DISABLE KEYS */;
INSERT INTO `cd_field` VALUES (134,18,'编号','user_id',1,1,0,0,'',0,0,'center','','','','',1,'','','','varchar','250',''),(135,18,'真实姓名','name',1,1,0,NULL,'',1,0,'center','','用户名不能为空','notEmpty','',2,'','',NULL,NULL,NULL,NULL),(136,18,'用户名','user',1,1,1,1,'',1,0,'center','','用户名不能为空','notEmpty,unique','',3,'','','','','',''),(137,18,'密码','pwd',5,0,0,0,'',1,0,'center','','6-21位数字字母组合','notEmpty','/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,20}$/',4,'','','','','',''),(138,18,'所属分组','group_id',29,0,1,0,'',1,0,'center','','','','',5,'select  group_id,name from pre_group','','','smallint','6',''),(139,18,'类别','type',3,1,1,0,'超级管理员|1|success,普通管理员|2|warning',1,0,'center','','','','',6,'','','','','',''),(140,18,'备注','note',1,1,0,NULL,'',1,0,'center','','','','',7,'','',NULL,NULL,NULL,NULL),(141,18,'状态','status',3,1,1,0,'正常|1|primary,禁用|0|danger',1,0,'center','','','','',7,'','','','','',''),(142,18,'创建时间','create_time',12,1,0,0,'',1,0,'center','','','','',3338,'','','','','',''),(143,18,'所属分组','group_name',1,1,0,NULL,'',0,0,'center','','','','',5,'','',NULL,NULL,NULL,NULL),(144,19,'编号','group_id',1,1,1,NULL,'',0,0,'center','','','','',1,'','',NULL,NULL,NULL,NULL),(145,19,'名称','name',1,1,0,NULL,'',1,0,'center','','名称不能为空','notEmpty','',2,'','',NULL,NULL,NULL,NULL),(146,19,'状态','status',3,1,0,NULL,'正常|10|primary,禁用|0|danger',1,0,'center','','','','',3,'','',NULL,NULL,NULL,NULL),(147,19,'类别','role',3,1,0,NULL,'普通管理员|2|success,超级管理员|1|primary',1,0,'center','','','','',4,'','',NULL,NULL,NULL,NULL),(187,52,'编号','log_id',1,1,0,NULL,'',0,0,'center','','','','',1,'','',NULL,NULL,NULL,NULL),(188,52,'用户名','username',1,1,1,NULL,'',1,1,'center','','','','',188,'','',NULL,NULL,NULL,NULL),(189,52,'操作','event',1,1,0,NULL,'',1,1,'center','','','','',191,'','',NULL,NULL,NULL,NULL),(190,52,'登录IP','ip',1,1,0,NULL,'',1,1,'center','','','','',192,'','',NULL,NULL,NULL,NULL),(191,52,'最后登录时间','time',7,1,0,NULL,'',1,1,'center','','','','',193,'','',NULL,NULL,NULL,NULL),(192,52,'昵称','nickname',1,1,0,NULL,'',0,0,'center','','','','',189,'','',NULL,NULL,NULL,NULL),(193,52,'所属分组','group_name',1,1,0,NULL,'',0,0,'center','','','','',190,'','',NULL,NULL,NULL,NULL),(194,41,'站点名称','site_title',1,0,0,NULL,'',1,0,'center','','','notEmpty','',194,'','基本设置','','','',''),(195,41,'关键词站点','keyword',28,0,0,NULL,'',1,0,'center','','','','',196,'','基本设置','',NULL,NULL,NULL),(196,41,'站点描述','description',6,0,0,NULL,'',1,0,'center','','','','',197,'','基本设置',NULL,NULL,NULL,NULL),(198,41,'站点LOGO','site_logo',8,0,0,NULL,'',1,0,'center','','','','',195,'','基本设置',NULL,NULL,NULL,NULL),(200,41,'上传文件大小','file_size',1,0,0,0,'',1,0,'center','','','','',200,'','上传配置',NULL,NULL,NULL,NULL),(488,41,'文件类型','file_type',6,0,0,0,'',1,0,'center','','','','',488,'','上传配置',NULL,NULL,NULL,NULL),(700,41,'绑定域名','domain',1,0,0,0,'',1,1,'center','上传目录绑定域名访问，请解析域名到 /public/upload目录  前面带上http://  非必填项','','','',700,'','上传配置','','','',''),(1462,41,'站点版权','copyright',1,NULL,0,NULL,'',1,NULL,'center','','','','',1462,NULL,'基本设置','',NULL,NULL,NULL),(3213,793,'编号','member_id',1,1,0,NULL,NULL,0,1,'center',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,'int','11',NULL),(3214,793,'呢称','nickname',1,1,1,0,'',1,1,'center','','','','',3214,'','','','varchar','250',''),(3215,793,'头像','headimgurl',8,1,1,0,'',1,1,'center','','','','',3215,'','','','varchar','250',''),(3216,793,'openid','openid',1,1,1,0,'',1,1,'center','','','','',3216,'','','','varchar','250',''),(3217,793,'手机号','mobile',1,1,1,0,'',1,1,'center','','','','/^1[345678]\\\\d{9}$/',3223,'','','','varchar','250',''),(3218,794,'编号','member_id',1,1,0,NULL,NULL,0,0,'center',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,'int','11',NULL),(3219,794,'呢称','nickname',1,1,1,0,'',1,0,'center','','','','',3214,'','','','varchar','250',''),(3220,794,'头像','headimgurl',8,1,1,0,'',1,0,'center','','','','',3215,'','','','varchar','250',''),(3221,794,'openid','openid',1,1,1,0,'',1,1,'center','','','','',3216,'','','','varchar','250',''),(3222,794,'手机号','mobile',1,1,1,0,'',1,0,'center','','','','/^1[345678]\\\\d{9}$/',3236,'','','','varchar','250',''),(3223,793,'用户名','username',1,1,1,0,'',1,1,'center','','','','',3224,'','','','varchar','250',''),(3224,793,'密码','password',5,0,0,0,'',1,1,'center','','','','',3238,'','','','varchar','250',''),(3225,797,'手机号','mobile',1,1,1,0,'手机号',1,1,'center',NULL,'手机号不正确','','/^1[1-9]\\\\d{9}$/',3226,'',NULL,'','varchar','11',''),(3226,797,'居住地址','first_address',1,1,0,1,'第一居住地址',1,1,'center',NULL,'请输入居住地址','notEmpty','',3227,'',NULL,'','varchar','250',''),(3227,797,'第二居住地址','second_address',1,1,0,1,'第二居住地址',1,1,'center',NULL,'','','',3228,'',NULL,'','varchar','250',''),(3228,797,'工作或学习单位','job',1,1,0,1,'工作或学习单位',1,1,'center',NULL,'','','',3230,'',NULL,'','varchar','250',''),(3229,797,'疫区','yiqu',20,1,0,0,'30日内是否来自疫区,1是,2否',1,1,'center',NULL,'','notEmpty','',3231,'',NULL,'2','tinyint','4',''),(3230,797,'登记类型','register_type',20,1,1,0,'登记类型默认1村居,2乡镇社区,3区县,4交通运输,5校园',1,1,'center',NULL,'登记类型错误','notEmpty','/^[0-9]*$/',3232,'',NULL,'1','int','11',''),(3231,797,'健康状况','health',20,1,1,0,'健康状况默认1健康,2异常,3其他',1,1,'center',NULL,'','notEmpty','/^[0-9]*$/',3233,'',NULL,'1','tinyint','4',''),(3232,797,'漫游地截图','manyou',8,1,0,0,'漫游地截图',1,1,'center',NULL,'','','',3235,'',NULL,'','varchar','250',''),(3233,797,'证明图片','txz',8,1,0,0,'证明图片',1,1,'center',NULL,'','','',3258,'',NULL,'','varchar','250',''),(3315,804,'编号','regpoint_id',1,1,0,NULL,NULL,0,1,'center',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,'int','11',NULL),(3235,797,'创建时间','create_time',12,1,1,0,'',1,1,'center',NULL,'','notEmpty','',3259,'',NULL,'0','int','11',''),(3236,794,'用户名','username',1,1,1,0,'',1,0,'center',NULL,'','','',3237,'',NULL,'','varchar','250',''),(3237,794,'密码','password',5,1,0,0,'',1,0,'center',NULL,'','','',3241,'',NULL,'','varchar','250',''),(3238,793,'注册时间','create_time',7,1,1,0,'',1,1,'center','','','','',3239,'','','','int','11',''),(3239,793,'性别','sex',3,1,1,0,'男|1|success,女|2|warning',1,1,'center','','','','',3240,'','','','smallint','6',''),(3240,793,'状态','status',23,1,1,0,'开启|1,关闭|0',1,1,'center','','','','',3244,'','','','tinyint','4',''),(3241,794,'性别','sex',3,1,1,0,'',1,0,'center',NULL,'','','',3242,'',NULL,'','smallint','6',''),(3242,794,'状态','status',23,1,1,0,'',1,0,'center',NULL,'','','',3243,'',NULL,'','tinyint','4',''),(3243,794,'创建时间','create_time',7,1,1,0,'',1,0,'center',NULL,'','','',3245,'',NULL,'','int','11',''),(3244,793,'所属用户','user_id',15,1,1,0,'',1,1,'center','','','','',3490,'','','','varchar','250',''),(3245,794,'所属用户','user_id',15,1,1,0,'',1,0,'center',NULL,'','','',3489,'',NULL,'','varchar','250',''),(3309,802,'openid','openid',1,0,0,0,'',1,0,'center','','','','',3309,'','','','varchar','250',''),(3307,802,'所属用户','user_id',15,1,1,0,'',1,0,'center','','','','',3262,'','','','varchar','250',''),(3304,802,'登记时间','create_time',12,1,1,0,'',1,0,'center','','','notEmpty','',3259,'','','0','int','11',''),(3305,802,'经度','lat',1,0,0,0,'',1,0,'center',NULL,'','','',3260,'',NULL,'','varchar','250',''),(3306,802,'纬度','lng',1,0,0,0,'',1,0,'center',NULL,'','','',3261,'',NULL,'','varchar','250',''),(3303,802,'通行证截图','txz',8,0,0,0,'通行证截图',1,0,'center','','','','',3258,'','','','varchar','250',''),(3302,802,'漫游地截图','manyou',8,1,0,0,'漫游地截图',1,0,'center',NULL,'','','',3235,'',NULL,'','varchar','250',''),(3300,802,'登记类型','register_type',3,1,1,0,'村居(物业)|1,乡镇社区|2,区县|3,交通运输|4,其他|5',1,1,'center','','登记类型错误','','/^[0-9]*$/',3232,'','','1','smallint','6',''),(3299,802,'是否来自疫区','yiqu',3,1,1,0,'是|1,否|2',1,1,'center','','','','',3231,'','','2','smallint','6',''),(3258,797,'姓名','name',1,1,1,0,'',1,0,'center',NULL,'','notEmpty','',3225,'',NULL,'','varchar','250',''),(3259,797,'当前位置','position',1,1,1,0,'',1,0,'center',NULL,'','notEmpty','',3229,'',NULL,'','varchar','250',''),(3301,802,'健康状况','health',3,1,1,0,'健康|1|primary,发热|2|danger,发热咳嗽|3|danger,头晕乏力|4|warning,腹泻|5|warning,其他|6|warning',1,1,'center','','','notEmpty','/^[0-9]*$/',3233,'','','1','smallint','6',''),(3260,797,'经度','lat',1,0,0,0,'',1,1,'center',NULL,'','','',3260,'',NULL,'','varchar','250',''),(3261,797,'纬度','lng',1,0,0,0,'',1,1,'center',NULL,'','','',3261,'',NULL,'','varchar','250',''),(3262,797,'所属用户','user_id',15,1,0,0,'',1,1,'center',NULL,'','','',3262,'',NULL,'','varchar','250',''),(3310,803,'编号','lock_id',1,1,0,NULL,NULL,0,1,'center',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,'int','11',NULL),(3311,803,'锁名称','lock_name',1,1,1,0,'',1,1,'center','','','notEmpty','',3314,'','','','varchar','250',''),(3312,803,'序列号','lock_sn',1,1,1,0,'',1,1,'center','','','notEmpty,unique','',3344,'','','','varchar','250',''),(3308,797,'openid','openid',1,NULL,1,0,'',1,1,NULL,NULL,'','','',3308,'',NULL,'','varchar','250',''),(3298,802,'工作或学习单位','job',1,1,0,1,'',1,0,'center','','','','',3230,'','','','varchar','250',''),(3297,802,'当前位置','position',1,1,0,0,'',1,0,'center','','','notEmpty','',3229,'','','','varchar','250',''),(3296,802,'第二居住地址','second_address',1,1,0,1,'',1,0,'center','','','','',3228,'','','','varchar','250',''),(3295,802,'家庭地址','first_address',1,1,0,1,'',1,0,'center','','请输入居住地址','notEmpty','',3227,'','','','varchar','250',''),(3293,802,'姓名','name',1,1,1,0,'',1,0,'center','','','notEmpty','',3225,'','','','varchar','250',''),(3294,802,'手机号','mobile',1,1,1,0,'',1,0,'center','','手机号不正确','','/^1[1-9]\\\\d{9}$/',3226,'','','','varchar','11',''),(3347,803,'开关','status',23,1,1,0,'启用|1|success,禁用|0|danger',1,1,'center','','','','',3349,'','','','tinyint','4',''),(3314,803,'用户ID','user_id',15,1,1,0,'',1,1,'center','','','','',3313,'','','','varchar','250',''),(3316,804,'会员ID','member_id',20,1,1,0,'',1,1,'center','','','','',3316,'','','','int','11',''),(3317,804,'用户ID','user_id',15,1,1,0,'',1,1,'center','','','','',3317,'','','','varchar','250',''),(3318,804,'名称','regpointname',1,1,1,0,'',1,1,'center','','','','',3318,'','','','varchar','250',''),(3319,804,'注册点url','regpointurl',1,0,0,0,'',0,1,'center','','','','',3319,'','','','varchar','250',''),(3320,804,'创建时间','create_time',12,1,1,0,'',1,1,'center','','','','',3340,'','','','int','11',''),(3321,805,'编号','regpoint_id',1,1,0,0,'',1,1,'center',NULL,'','','',1,'',NULL,'','int','11',''),(3322,805,'会员ID','member_id',1,1,1,0,'',1,1,'center','','','','',3316,'','','','varchar','250',''),(3323,805,'用户ID','user_id',1,1,1,0,'',1,1,'center','','','','',3317,'','','','varchar','250',''),(3324,805,'名称','regpointname',1,1,1,0,'',1,1,'center','','','','',3318,'','','','varchar','250',''),(3325,805,'注册点url','regpointurl',1,1,1,0,'',1,1,'center','','','','',3319,'','','','varchar','250',''),(3326,805,'创建时间','create_time',12,1,1,0,'',1,1,'center','','','','',3320,'','','','int','11',''),(3327,806,'编号','user_id',1,1,0,0,'',0,0,'center','','','','',1,'','','','varchar','250',''),(3328,806,'真实姓名','name',1,1,0,NULL,'',1,0,'center','','用户名不能为空','notEmpty','',2,'','',NULL,NULL,NULL,NULL),(3329,806,'用户名','user',1,1,1,1,'',1,0,'center','','用户名不能为空','notEmpty,unique','',3,'','','','','',''),(3330,806,'密码','pwd',5,0,0,0,'',1,0,'center','','6-21位数字字母组合','notEmpty','/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,20}$/',4,'','','','','',''),(3331,806,'所属分组','group_id',29,0,1,0,'',1,0,'center','','','notEmpty','',5,'','','','smallint','6',''),(3332,806,'所属分组','group_name',1,1,0,NULL,'',0,0,'center','','','','',5,'','',NULL,NULL,NULL,NULL),(3333,806,'类别','type',3,1,1,0,'超级管理员|1|success,普通管理员|2|warning',1,0,'center','','','','',6,'','','','','',''),(3334,806,'备注','note',1,1,0,NULL,'',1,0,'center','','','','',7,'','',NULL,NULL,NULL,NULL),(3335,806,'状态','status',3,1,1,0,'正常|1|primary,禁用|0|danger',1,0,'center','','','','',7,'','','','','',''),(3336,806,'创建时间','create_time',12,1,0,0,'',1,0,'center','','','','',3337,'','','','','',''),(3337,806,'会员ID','member_id',20,NULL,1,0,'',1,1,NULL,NULL,'','','',8,'',NULL,'0','int','11',''),(3338,18,'会员ID','member_id',20,1,1,0,'',1,0,'center','','','','',8,'','','0','int','11',''),(3339,805,'登记点二维码','regpointqrcode',8,NULL,1,0,'',1,1,NULL,NULL,'','','',3339,'',NULL,'','varchar','250',''),(3340,804,'登记点二维码','regpointqrcode',8,1,1,0,'',1,0,'center','','','','',3320,'','','','varchar','250',''),(3344,803,'绑定手机','mobile_check',23,1,0,0,'是|1|primary,否|0|info',1,1,'center','','mobile_check','','',3345,'','','','tinyint','4',''),(3341,802,'登记点ID','regpoint_id',20,0,0,0,'',1,1,'center','','','','',3341,'','','','int','11',''),(3342,797,'登记点ID','regpoint_id',20,NULL,1,0,'',1,1,NULL,NULL,'','','',3342,'',NULL,'0','int','11',''),(3343,802,'登记点','regpointname',1,1,0,0,'',0,0,'center','','','','',3343,'','','','varchar','250',''),(3345,803,'申请钥匙','applyauth',23,1,0,0,'开启|1,关闭|0',1,0,'center','','','','',3346,'','','0','tinyint','4',''),(3346,803,'申请钥匙审核','applyauth_check',23,1,0,0,'开启|1,关闭|0',1,0,'center','','','','',3347,'','','0','tinyint','4',''),(3348,803,'类型','lock_type',2,1,0,0,'WiFi版|1|success,插卡版(2G)|2|primary,插卡版(4G)|3|primary,网线版|4|info',1,1,'center','','','','',3351,'select locktype_id,locktype_name from cd_locktype','','','smallint','6',''),(3349,803,'位置','location',19,0,0,0,'',1,1,'center','','','notEmpty','',3354,'','','','varchar','250',''),(3354,803,'二维码','lock_qrcode',8,1,0,0,'',1,1,'center','','','','',3452,'','','','varchar','250',''),(3351,803,'添加时间','create_time',12,1,0,0,'',1,1,'center','','','','',3453,'','','','int','11',''),(3352,807,'编号','locktype_id',1,1,0,NULL,NULL,0,1,'center',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,'int','11',NULL),(3353,807,'名称','locktype_name',1,1,1,0,'',1,1,'center','','','','',3353,'','','','varchar','250',''),(3355,41,'微门禁appid','wmjappid',1,NULL,NULL,NULL,'',1,NULL,'center','','','','',3355,'','微门禁配置','',NULL,NULL,NULL),(3356,41,'微门禁appsecret','wmjappsecret',1,NULL,NULL,NULL,'',1,NULL,'center','','','','',3356,'','微门禁配置','',NULL,NULL,NULL),(3357,803,'在线状态','online',3,1,1,0,'在线|1|primary,离线|0|warning',1,1,'center','','','','',3357,'','','','smallint','6',''),(3460,818,'编号','locktimes_id',1,1,0,NULL,NULL,0,1,'center',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,'int','11',NULL),(3358,41,'微门禁aeskey','wmjaeskey',1,NULL,NULL,NULL,'',1,NULL,'center','','','','',3358,'','微门禁配置','',NULL,NULL,NULL),(3359,809,'编号','lockauth_id',1,1,0,NULL,NULL,0,1,'center',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,'int','11',NULL),(3360,809,'锁ID','lock_id',20,1,0,0,'',1,1,'center','','','','',3360,'','','','int','11',''),(3361,809,'会员ID','member_id',20,1,0,0,'',1,1,'center','','','','',3361,'','','','int','11',''),(3362,809,'分享人ID','auth_member_id',20,1,0,0,'',1,1,'center','','','','',3363,'','','','int','11',''),(3363,809,'有效期结束','auth_endtime',7,1,0,0,'',1,0,'center','','','','',3366,'','','','int','11',''),(3364,809,'分享权限','auth_shareability',23,1,1,0,'开启|1,关闭|0',1,1,'center','','','','',3367,'','','','tinyint','4',''),(3365,809,'备注','remark',1,1,0,0,'',1,1,'center','','','','',3431,'','','','varchar','250',''),(3366,809,'创建时间','create_time',12,1,0,0,'',1,1,'center','','','','',3432,'','','','int','11',''),(3367,809,'有效期起始','auth_starttime',7,1,0,0,'',1,0,'center','','','','',3365,'','','','int','11',''),(3475,819,'编号','locktimes_id',1,1,0,NULL,NULL,0,0,'center',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,'int','11',NULL),(3408,813,'二维码','lock_qrcode',8,1,1,0,'',1,0,'center','','','','',3426,'','','','varchar','250',''),(3407,813,'添加时间','create_time',12,1,1,0,'',1,0,'center','','','','',3357,'','','','int','11',''),(3406,813,'位置','location',19,0,0,0,'',1,0,'center','','','','',3354,'','','','varchar','250',''),(3405,813,'类型','lock_type',2,1,1,0,'',1,0,'center','','','','',3351,'select locktype_id,locktype_name from cd_locktype','','','smallint','6',''),(3404,813,'开关','status',23,1,1,0,'启用|1|success,禁用|0|danger',1,0,'center','','','','',3349,'','','','tinyint','4',''),(3403,813,'审核钥匙','applyauth_check',23,1,1,0,'开启|1,关闭|0',1,0,'center','','','','',3347,'','','','tinyint','4',''),(3402,813,'申请钥匙','applyauth',23,1,1,0,'开启|1,关闭|0',1,0,'center','','','','',3346,'','','','tinyint','4',''),(3401,813,'绑定手机','mobile_check',23,1,1,0,'是|1|primary,否|0|info',1,0,'center','','mobile_check','','',3345,'','','','tinyint','4',''),(3397,813,'编号','lock_id',1,1,0,NULL,NULL,0,0,'center',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,'int','11',NULL),(3398,813,'用户ID','user_id',15,1,1,0,'',1,0,'center','','','','',3313,'','','','varchar','250',''),(3399,813,'锁名称','lock_name',1,1,1,0,'',1,0,'center','','','notEmpty','',3314,'','','','varchar','250',''),(3400,813,'序列号','lock_sn',1,1,1,0,'',1,0,'center','','','notEmpty,unique','',3344,'','','','varchar','250',''),(3412,814,'会员ID','member_id',1,1,1,0,'',1,0,'center','','','','',3361,'','','','varchar','250',''),(3411,814,'锁ID','lock_id',20,1,0,0,'',1,0,'center','','','','',3360,'','','','int','11',''),(3410,814,'编号','lockauth_id',1,1,0,NULL,NULL,0,0,'center',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,'int','11',NULL),(3409,813,'状态','online',3,1,1,0,'在线|1|primary,离线|0|warning',1,0,'center','','','','',3454,'','','','smallint','6',''),(3390,812,'编号','locklog_id',1,1,0,NULL,NULL,0,1,'center',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,'int','11',NULL),(3391,812,'会员ID','member_id',20,0,0,0,'',1,1,'center','','','','',3391,'','','','int','11',''),(3392,812,'锁ID','lock_id',20,0,0,0,'',1,1,'center','','','','',3393,'','','','int','11',''),(3393,812,'状态','status',3,1,1,0,'成功|1|primary,失败|0|danger',1,1,'center','','','','',3456,'','','','smallint','6',''),(3394,812,'类型','type',3,1,1,0,'扫码开门|1|primary,点击开门|2|info,后台开门|3|success',1,1,'center','','','','',3457,'','','','smallint','6',''),(3395,812,'开门时间','create_time',12,1,0,0,'',1,1,'center','','','','',3459,'','','','int','11',''),(3396,812,'管理员ID','user_id',15,0,1,0,'',1,1,'center','','','','',3392,'','','','varchar','250',''),(3413,814,'分享人会员ID','auth_member_id',20,1,1,0,'',1,0,'center','','','','',3363,'','','','int','11',''),(3414,814,'有效期结束时间','auth_endtime',7,1,0,0,'',1,1,'center','','','','',3367,'','','','int','11',''),(3415,814,'有效期起始时间','auth_starttime',7,1,0,0,'',1,1,'center','','','','',3366,'','','','int','11',''),(3416,814,'分享权限','auth_shareability',23,1,0,0,'开启|1,关闭|0',1,0,'center','','','','',3428,'','','','tinyint','4',''),(3417,814,'备注','remark',1,1,0,0,'',1,0,'center','','','','',3446,'','','','varchar','250',''),(3418,814,'创建时间','create_time',12,1,0,0,'',1,0,'center','','','','',3449,'','','','int','11',''),(3419,815,'编号','locklog_id',1,1,0,NULL,NULL,0,0,'center',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,'int','11',NULL),(3420,815,'会员ID','member_id',1,1,1,0,'',1,0,'center','','','','',3391,'','','','varchar','250',''),(3421,815,'管理员ID','user_id',15,1,1,0,'',1,0,'center','','','','',3392,'','','','varchar','250',''),(3422,815,'锁ID','lock_id',20,1,1,0,'',1,0,'center','','','','',3393,'','','','int','11',''),(3423,815,'状态','status',3,1,0,0,'成功|1|primary,失败|0|danger',1,0,'center','','','','',3394,'','','','smallint','6',''),(3424,815,'类型','type',3,1,0,0,'扫码开门|1|success,点击开门|2|info',1,0,'center','','','','',3395,'','','','smallint','6',''),(3425,815,'开门时间','create_time',12,1,1,0,'',1,0,'center','','','','',3396,'','','','int','11',''),(3426,813,'会员id','member_id',20,NULL,1,0,'',1,1,NULL,NULL,'','','',3312,'',NULL,'','int','11',''),(3427,814,'可分享钥匙数','auth_sharelimit',20,NULL,1,0,'',1,1,NULL,NULL,'','','',3364,'',NULL,'','int','11',''),(3428,814,'开门限制次数','auth_openlimit',20,NULL,1,0,'',1,1,NULL,NULL,'','','',3365,'',NULL,'','int','11',''),(3429,814,'是否管理员','auth_isadmin',3,NULL,0,0,'',1,1,NULL,NULL,'','','',3427,'',NULL,'','smallint','6',''),(3430,809,'可分享数','auth_sharelimit',20,1,0,0,'',1,0,'center','','','','',3364,'','','','int','11',''),(3431,809,'开门限制数','auth_openlimit',20,1,0,0,'',1,0,'center','','','','',3447,'','','','int','11',''),(3432,809,'是否管理员','auth_isadmin',3,1,1,0,'是|1|success,否|0|info',1,0,'center','','','','',3451,'','','','smallint','6',''),(3433,812,'备注','remark',1,1,0,0,'',1,1,'center','','','','',3458,'','','','varchar','250',''),(3434,815,'备注','remark',1,NULL,0,0,'',1,0,NULL,NULL,'','','',3434,'',NULL,'','varchar','250',''),(3435,816,'站点名称','site_title',1,0,0,NULL,'',1,0,'center','','','notEmpty','',194,'','基本设置','','','',''),(3436,816,'站点LOGO','site_logo',8,0,0,NULL,'',1,0,'center','','','','',195,'','基本设置',NULL,NULL,NULL,NULL),(3437,816,'关键词站点','keyword',28,0,0,NULL,'',1,0,'center','','','','',196,'','基本设置','',NULL,NULL,NULL),(3438,816,'站点描述','description',6,0,0,NULL,'',1,0,'center','','','','',197,'','基本设置',NULL,NULL,NULL,NULL),(3439,816,'上传文件大小','file_size',1,0,0,0,'',1,0,'center','','','','',200,'','上传配置',NULL,NULL,NULL,NULL),(3440,816,'文件类型','file_type',6,0,0,0,'',1,0,'center','','','','',488,'','上传配置',NULL,NULL,NULL,NULL),(3441,816,'绑定域名','domain',1,0,0,0,'',1,0,'center','上传目录绑定域名访问，请解析域名到 /public/upload目录  前面带上http://  非必填项','','','',700,'','上传配置','','','',''),(3442,816,'站点版权','copyright',1,NULL,0,NULL,'',1,0,'center','','','','',1462,NULL,'基本设置','',NULL,NULL,NULL),(3443,816,'微门禁appid','wmjappid',1,NULL,NULL,NULL,'',1,0,'center','','','','',3355,'','微门禁配置','',NULL,NULL,NULL),(3444,816,'微门禁appsecret','wmjappsecret',1,NULL,NULL,NULL,'',1,0,'center','','','','',3356,'','微门禁配置','',NULL,NULL,NULL),(3445,816,'微门禁aeskey','wmjaeskey',1,NULL,NULL,NULL,'',1,0,'center','','','','',3358,'','微门禁配置','',NULL,NULL,NULL),(3446,814,'审核状态','auth_status',3,NULL,1,0,'已审核|1,未审核|0',1,1,NULL,NULL,'','','',3450,'',NULL,'','smallint','6',''),(3447,809,'钥匙状态','auth_status',23,1,1,0,'启用|1|primary,禁用|0|warning',1,0,'center','','','','',3430,'','','','tinyint','4',''),(3448,809,'管理员ID','user_id',15,1,1,0,'',1,1,'center','','','','',3471,'','','','varchar','250',''),(3449,814,'管理员ID','user_id',20,NULL,1,0,'',1,0,NULL,NULL,'','','',3472,'',NULL,'','int','11',''),(3450,814,'姓名','realname',1,NULL,1,0,'',1,1,NULL,NULL,'','','',3362,'',NULL,'','varchar','250',''),(3451,809,'姓名','realname',1,1,1,0,'',1,0,'center','','','','',3362,'','','','varchar','250',''),(3452,803,'成功提示图片','successimg',8,1,0,0,'',1,1,'center','','','','',3486,'','','/uploads/admin/202003/5e758dd0d7d15.png','varchar','250',''),(3453,803,'成功广告','successadimg',8,1,0,0,'',1,1,'center','','','','',3488,'','','','varchar','250',''),(3454,813,'开门成功图片','successimg',8,NULL,1,0,'',1,0,NULL,NULL,'','','',3455,'',NULL,'','varchar','250',''),(3455,813,'成功广告','successadimg',8,NULL,1,0,'',1,0,NULL,NULL,'','','',3487,'',NULL,'','varchar','250',''),(3456,812,'头像','headimgurl',8,1,0,0,'',0,0,'center','','','','',3395,'','','','varchar','250',''),(3457,812,'呢称','nickname',1,1,0,0,'',0,0,'center','','','','',3396,'','','','varchar','250',''),(3458,812,'手机号','mobile',1,1,0,0,'',0,0,'center','','','','',3433,'','','','varchar','250',''),(3459,812,'锁名称','lock_name',1,1,0,0,'',0,0,'center','','','','',3394,'','','','varchar','250',''),(3461,818,'管理员ID','user_id',15,1,0,0,'',1,1,'center','','','','',3462,'','','','varchar','250',''),(3462,818,'锁ID','lock_id',14,1,0,0,'',1,1,'center','','','','',3463,'','','','varchar','250',''),(3463,818,'周开始','startweek',2,1,0,0,'周一|1,周二|2,周三|3,周四|4,周五|5,周六|6,周七|7',1,1,'center','','','','',3464,'','','','smallint','6',''),(3464,818,'小时开始','starthour',2,1,0,0,'0:00|0,1:00|1,2:00|2,3:00|3,4:00|4,5:00|5,6:00|6,7:00|7,8:00|8,9:00|9,10:00|10,11:00|11,12:00|12,13:00|13,14:00|14,15:00|15,16:00|16,17:00|17,18:00|18,19:00|19,20:00|20,21:00|21,22:00|22,23:00|23',1,1,'center','','','','',3465,'','','','smallint','6',''),(3465,818,'分钟开始','startminute',2,1,0,0,'0|0,5|5,10|10,15|15,20|20,25|25,30|30,35|35,40|40,45|45,50|50,55|55,59|59',1,1,'center','','','','',3466,'','','','smallint','6',''),(3466,818,'周结束','endweek',2,1,0,0,'周一|1,周二|2,周三|3,周四|4,周五|5,周六|6,周七|7',1,1,'center','','','','',3467,'','','','smallint','6',''),(3467,818,'小时结束','endhour',2,1,0,0,'0:00|0,1:00|1,2:00|2,3:00|3,4:00|4,5:00|5,6:00|6,7:00|7,8:00|8,9:00|9,10:00|10,11:00|11,12:00|12,13:00|13,14:00|14,15:00|15,16:00|16,17:00|17,18:00|18,19:00|19,20:00|20,21:00|21,22:00|22,23:00|23',1,1,'center','','','','',3468,'','','','smallint','6',''),(3468,818,'分钟结束','endminute',2,1,0,0,'0|0,5|5,10|10,15|15,20|20,25|25,30|30,35|35,40|40,45|45,50|50,55|55,59|59',1,1,'center','','','','',3469,'','','','smallint','6',''),(3469,818,'创建时间','create_time',12,1,0,0,'',1,1,'center','','','','',3470,'','','','int','11',''),(3470,818,'时段名称','locktimesname',1,1,1,0,'',1,1,'center','','','','',3461,'','','','varchar','250',''),(3471,809,'可开时段','auth_opentimes',1,0,0,0,'',1,1,'center','','','','',3448,'','','','varchar','250',''),(3472,814,'可开时段','auth_opentimes',1,NULL,1,0,'',1,0,NULL,NULL,'','','',3429,'',NULL,'','varchar','250',''),(3473,809,'领取标志','auth_tmp',3,0,1,0,'已领取|1|success,未领取|0|warning',1,1,'center','','','','',3473,'','','','smallint','6',''),(3474,814,'领取标志','auth_tmp',3,NULL,1,0,'',1,0,NULL,NULL,'','','',3474,'',NULL,'','smallint','6',''),(3476,819,'时段名称','locktimesname',1,1,1,0,'',1,0,'center','','','','',3461,'','','','varchar','250',''),(3477,819,'管理员ID','user_id',15,1,0,0,'',1,0,'center','','','','',3462,'','','','varchar','250',''),(3478,819,'锁ID','lock_id',14,1,0,0,'',1,0,'center','','','','',3463,'','','','varchar','250',''),(3479,819,'周开始','startweek',2,1,0,0,'周一|1,周二|2,周三|3,周四|4,周五|5,周六|6,周七|7',1,0,'center','','','','',3464,'','','','smallint','6',''),(3480,819,'小时开始','starthour',2,1,0,0,'0:00|0,1:00|1,2:00|2,3:00|3,4:00|4,5:00|5,6:00|6,7:00|7,8:00|8,9:00|9,10:00|10,11:00|11,12:00|12,13:00|13,14:00|14,15:00|15,16:00|16,17:00|17,18:00|18,19:00|19,20:00|20,21:00|21,22:00|22,23:00|23',1,0,'center','','','','',3465,'','','','smallint','6',''),(3481,819,'分钟开始','startminute',2,1,0,0,'0|0,5|5,10|10,15|15,20|20,25|25,30|30,35|35,40|40,45|45,50|50,55|55,59|59',1,0,'center','','','','',3466,'','','','smallint','6',''),(3482,819,'周结束','endweek',2,1,0,0,'周一|1,周二|2,周三|3,周四|4,周五|5,周六|6,周七|7',1,0,'center','','','','',3467,'','','','smallint','6',''),(3483,819,'小时结束','endhour',2,1,0,0,'0:00|0,1:00|1,2:00|2,3:00|3,4:00|4,5:00|5,6:00|6,7:00|7,8:00|8,9:00|9,10:00|10,11:00|11,12:00|12,13:00|13,14:00|14,15:00|15,16:00|16,17:00|17,18:00|18,19:00|19,20:00|20,21:00|21,22:00|22,23:00|23',1,0,'center','','','','',3468,'','','','smallint','6',''),(3484,819,'分钟结束','endminute',2,1,0,0,'0|0,5|5,10|10,15|15,20|20,25|25,30|30,35|35,40|40,45|45,50|50,55|55,59|59',1,0,'center','','','','',3469,'','','','smallint','6',''),(3485,819,'创建时间','create_time',12,1,0,0,'',1,0,'center','','','','',3470,'','','','int','11',''),(3486,803,'开门距离(米)','location_check',20,1,1,0,'无限制|0|primary',1,1,'center','','','','',3348,'','','0','int','11',''),(3487,813,'开门距离','location_check',20,NULL,1,0,'',1,0,NULL,NULL,'','','',3348,'',NULL,'','int','11',''),(3488,803,'会员id','member_id',20,0,0,0,'',1,0,'center','','','','',3312,'','','','int','11',''),(3489,794,'支付宝用户id','ali_user_id',1,NULL,1,0,'',1,1,NULL,NULL,'','','',3217,'',NULL,'','varchar','250',''),(3490,793,'支付宝用户id','ali_user_id',1,1,1,0,'',1,0,'center','','','','',3217,'','','','varchar','250','');
/*!40000 ALTER TABLE `cd_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cd_file`
--

DROP TABLE IF EXISTS `cd_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filepath` varchar(255) DEFAULT NULL COMMENT '图片路径',
  `hash` varchar(32) DEFAULT NULL COMMENT '文件hash值',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_file`
--

LOCK TABLES `cd_file` WRITE;
/*!40000 ALTER TABLE `cd_file` DISABLE KEYS */;
/*!40000 ALTER TABLE `cd_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cd_group`
--

DROP TABLE IF EXISTS `cd_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_group` (
  `group_id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(36) DEFAULT NULL COMMENT '分组名称',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态 10正常 0禁用',
  `role` tinyint(4) DEFAULT NULL COMMENT '角色类别 1超级管理员 2普通管理员',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_group`
--

LOCK TABLES `cd_group` WRITE;
/*!40000 ALTER TABLE `cd_group` DISABLE KEYS */;
INSERT INTO `cd_group` VALUES (1,'超级管理员',10,1),(3,'客服人员',10,2),(7,'用户管理员',10,2);
/*!40000 ALTER TABLE `cd_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cd_health`
--

DROP TABLE IF EXISTS `cd_health`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_health` (
  `health_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `mobile` varchar(11) DEFAULT NULL COMMENT '手机号',
  `first_address` varchar(250) DEFAULT NULL COMMENT '居住地址',
  `second_address` varchar(250) DEFAULT NULL COMMENT '第二居住地址',
  `job` varchar(250) DEFAULT NULL COMMENT '工作或学习单位',
  `yiqu` smallint(6) DEFAULT NULL COMMENT '是否来自疫区',
  `register_type` smallint(6) DEFAULT NULL COMMENT '登记类型',
  `health` smallint(6) DEFAULT NULL COMMENT '健康状况',
  `manyou` varchar(250) NOT NULL DEFAULT '' COMMENT '漫游地截图',
  `txz` varchar(250) DEFAULT NULL COMMENT '证明图片',
  `ctime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `name` varchar(250) DEFAULT NULL COMMENT '姓名',
  `position` varchar(250) DEFAULT NULL COMMENT '定位地址',
  `lat` varchar(250) DEFAULT NULL COMMENT '经度',
  `lng` varchar(250) DEFAULT NULL COMMENT '纬度',
  `user_id` varchar(250) DEFAULT NULL COMMENT '所属用户',
  `openid` varchar(250) DEFAULT NULL COMMENT 'openid',
  `regpoint_id` int(11) DEFAULT NULL COMMENT '登记点ID',
  PRIMARY KEY (`health_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_health`
--

--
-- Table structure for table `cd_lock`
--

DROP TABLE IF EXISTS `cd_lock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_lock` (
  `lock_id` int(11) NOT NULL AUTO_INCREMENT,
  `lock_name` varchar(250) DEFAULT NULL COMMENT '锁名称',
  `lock_sn` varchar(250) DEFAULT NULL COMMENT '序列号',
  `user_id` varchar(250) DEFAULT NULL COMMENT '用户ID',
  `mobile_check` tinyint(4) DEFAULT NULL COMMENT '绑定手机',
  `applyauth` tinyint(4) DEFAULT NULL COMMENT '领取钥匙',
  `applyauth_check` tinyint(4) DEFAULT NULL COMMENT '审核钥匙',
  `status` tinyint(4) DEFAULT NULL COMMENT '开关',
  `lock_type` smallint(6) DEFAULT NULL COMMENT '类型',
  `location` varchar(250) DEFAULT NULL COMMENT '位置',
  `create_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `lock_qrcode` varchar(250) DEFAULT NULL COMMENT '二维码',
  `online` smallint(6) DEFAULT NULL COMMENT '在线状态',
  `member_id` int(11) DEFAULT NULL COMMENT '会员id',
  `successimg` varchar(250) DEFAULT NULL COMMENT '成功提示图片',
  `successadimg` varchar(250) DEFAULT NULL COMMENT '成功广告',
  `location_check` int(11) DEFAULT NULL COMMENT '开门距离(米)',
  PRIMARY KEY (`lock_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_lock`
--

LOCK TABLES `cd_lock` WRITE;
/*!40000 ALTER TABLE `cd_lock` DISABLE KEYS */;
/*!40000 ALTER TABLE `cd_lock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cd_lockauth`
--

DROP TABLE IF EXISTS `cd_lockauth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_lockauth` (
  `lockauth_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `lock_id` int(11) DEFAULT NULL COMMENT '锁ID',
  `member_id` int(11) DEFAULT NULL COMMENT '会员ID',
  `auth_member_id` int(11) DEFAULT NULL COMMENT '分享人ID',
  `auth_endtime` int(11) DEFAULT NULL COMMENT '有效期结束时间',
  `auth_shareability` tinyint(4) DEFAULT NULL COMMENT '分享权限',
  `remark` varchar(250) DEFAULT NULL COMMENT '备注',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `auth_starttime` int(11) DEFAULT NULL COMMENT '有效期起始时间',
  `auth_sharelimit` int(11) DEFAULT NULL COMMENT '可分享钥匙数',
  `auth_openlimit` int(11) DEFAULT NULL COMMENT '开门限制次数',
  `auth_isadmin` smallint(6) DEFAULT NULL COMMENT '是否管理员',
  `auth_status` smallint(6) DEFAULT NULL COMMENT '审核状态',
  `user_id` varchar(250) DEFAULT NULL COMMENT '管理员ID',
  `realname` varchar(250) DEFAULT NULL COMMENT '姓名',
  `auth_opentimes` varchar(250) DEFAULT NULL COMMENT '可开时段',
  `auth_tmp` smallint(6) DEFAULT NULL COMMENT '领取标志',
  PRIMARY KEY (`lockauth_id`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_lockauth`
--

LOCK TABLES `cd_lockauth` WRITE;
/*!40000 ALTER TABLE `cd_lockauth` DISABLE KEYS */;
/*!40000 ALTER TABLE `cd_lockauth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cd_locklog`
--

DROP TABLE IF EXISTS `cd_locklog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_locklog` (
  `locklog_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL COMMENT '会员ID',
  `lock_id` int(11) DEFAULT NULL COMMENT '锁ID',
  `status` smallint(6) DEFAULT NULL COMMENT '状态',
  `type` smallint(6) DEFAULT NULL COMMENT '类型',
  `create_time` int(11) DEFAULT NULL COMMENT '开门时间',
  `user_id` varchar(250) DEFAULT NULL COMMENT '管理员ID',
  `remark` varchar(250) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`locklog_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4314 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cd_locktimes`
--

DROP TABLE IF EXISTS `cd_locktimes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_locktimes` (
  `locktimes_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(250) DEFAULT NULL COMMENT '管理员ID',
  `lock_id` varchar(250) DEFAULT NULL COMMENT '锁ID',
  `startweek` smallint(6) DEFAULT NULL COMMENT '周开始',
  `starthour` smallint(6) DEFAULT NULL COMMENT '小时开始',
  `startminute` smallint(6) DEFAULT NULL COMMENT '分钟开始',
  `endweek` smallint(6) DEFAULT NULL COMMENT '周结束',
  `endhour` smallint(6) DEFAULT NULL COMMENT '小时结束',
  `endminute` smallint(6) DEFAULT NULL COMMENT '分钟结束',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `locktimesname` varchar(250) DEFAULT NULL COMMENT '时段名称',
  PRIMARY KEY (`locktimes_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_locktimes`
--

--
-- Table structure for table `cd_locktype`
--

DROP TABLE IF EXISTS `cd_locktype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_locktype` (
  `locktype_id` int(11) NOT NULL AUTO_INCREMENT,
  `locktype_name` varchar(250) DEFAULT NULL COMMENT '名称',
  PRIMARY KEY (`locktype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_locktype`
--

LOCK TABLES `cd_locktype` WRITE;
/*!40000 ALTER TABLE `cd_locktype` DISABLE KEYS */;
INSERT INTO `cd_locktype` VALUES (1,'WiFi版'),(2,'插卡版(2G)'),(3,'插卡版(4G)'),(4,'网线版');
/*!40000 ALTER TABLE `cd_locktype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cd_log`
--

DROP TABLE IF EXISTS `cd_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_log` (
  `log_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '用户ID',
  `username` varchar(250) DEFAULT NULL,
  `event` varchar(250) DEFAULT NULL,
  `ip` varchar(250) DEFAULT NULL,
  `time` int(10) DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=240 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_log`
--
--
-- Table structure for table `cd_member`
--

DROP TABLE IF EXISTS `cd_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_member` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(250) DEFAULT NULL COMMENT '呢称',
  `headimgurl` varchar(250) DEFAULT NULL COMMENT '头像',
  `openid` varchar(250) DEFAULT NULL COMMENT 'openid',
  `mobile` varchar(250) DEFAULT NULL COMMENT '手机号',
  `username` varchar(250) DEFAULT NULL COMMENT '用户名',
  `password` varchar(250) DEFAULT NULL COMMENT '密码',
  `create_time` int(11) DEFAULT NULL COMMENT '注册时间',
  `sex` smallint(6) DEFAULT NULL COMMENT '性别',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态',
  `user_id` varchar(250) DEFAULT NULL COMMENT '所属用户',
  `ali_user_id` varchar(250) DEFAULT NULL COMMENT '支付宝用户id',
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3562 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_member`
--

LOCK TABLES `cd_member` WRITE;
/*!40000 ALTER TABLE `cd_member` DISABLE KEYS */;
/*!40000 ALTER TABLE `cd_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cd_menu`
--

DROP TABLE IF EXISTS `cd_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` mediumint(9) DEFAULT '0' COMMENT '父级id',
  `controller_name` varchar(32) DEFAULT NULL COMMENT '模块名称',
  `title` varchar(64) DEFAULT NULL COMMENT '模块标题',
  `pk_id` varchar(36) DEFAULT NULL COMMENT '主键名',
  `table_name` varchar(32) DEFAULT NULL COMMENT '模块数据库表',
  `is_create` tinyint(4) DEFAULT NULL COMMENT '是否允许生成模块',
  `status` tinyint(4) DEFAULT NULL COMMENT '0隐藏 10显示',
  `sortid` mediumint(9) DEFAULT '0' COMMENT '排序号',
  `table_status` tinyint(4) DEFAULT NULL COMMENT '是否生成数据库表',
  `is_url` tinyint(4) DEFAULT NULL COMMENT '是否只是url链接',
  `url` varchar(64) DEFAULT NULL,
  `menu_icon` varchar(32) DEFAULT NULL COMMENT 'icon字体图标',
  `tab_menu` varchar(250) DEFAULT NULL COMMENT 'tab选项卡菜单配置',
  `app_id` int(11) DEFAULT NULL COMMENT '所属模块',
  `is_submit` tinyint(4) DEFAULT NULL COMMENT '是否允许投稿',
  PRIMARY KEY (`menu_id`),
  KEY `controller_name` (`controller_name`) USING BTREE,
  KEY `module_id` (`app_id`)
) ENGINE=MyISAM AUTO_INCREMENT=823 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_menu`
--

LOCK TABLES `cd_menu` WRITE;
/*!40000 ALTER TABLE `cd_menu` DISABLE KEYS */;
INSERT INTO `cd_menu` VALUES (12,0,'Sys','系统管理','','',0,1,793,0,0,'','fa fa-gears','',1,NULL),(17,12,'','后台首页','','',0,1,2,0,1,'/admin/Index/main.html','fa fa-home','',1,0),(18,12,'User','用户管理','user_id','user',1,1,4,1,0,'','fa fa-user-secret','',1,0),(19,12,'Group','分组管理','group_id','group',1,1,5,1,0,'','fa fa-user','',1,NULL),(21,12,'','菜单管理','','',0,0,3,0,1,'/admin/Menu/index?app_id=1','','',1,NULL),(41,12,'Config','系统配置','','',1,1,7,0,0,'','glyphicon glyphicon-cog','基本设置|上传配置|微门禁配置',1,0),(52,12,'Log','登录日志','log_id','log',1,1,6,1,0,'','glyphicon glyphicon-log-in','',1,NULL),(80,12,'Application','应用管理','','',0,0,1,0,0,'','','',1,NULL),(524,12,'','修改密码','','',0,1,8,0,NULL,'/admin/Base/password','','',1,0),(525,12,'','数据备份','','',0,1,9,0,NULL,'/admin/Backup/index','','',1,0),(793,0,'Member','会员管理','member_id','member',1,1,793,1,NULL,'','fa fa-users','',1,0),(794,0,'Member','会员管理','member_id','member',1,1,797,0,NULL,'','','',179,0),(797,0,'Health','健康登记','health_id','health',1,NULL,798,1,NULL,NULL,NULL,NULL,179,NULL),(803,808,'Lock','门锁列表','lock_id','lock',1,1,803,1,NULL,'','fa fa-list','',1,0),(802,817,'Health','健康登记','health_id','health',1,1,798,0,NULL,'','fa fa-file-text','',1,0),(804,817,'Regpoint','登记点管理','regpoint_id','regpoint',1,1,804,1,NULL,'','fa fa-dot-circle-o','',1,0),(805,0,'Regpoint','登记点管理','regpoint_id','regpoint',1,1,804,0,NULL,'','','',179,0),(806,0,'User','用户管理','user_id','user',1,1,4,0,0,'','fa fa-user-secret','',179,0),(807,808,'LockType','门锁类型','locktype_id','locktype',1,1,812,1,NULL,'','fa fa-wrench','',1,0),(808,0,'','门锁管理','','',0,1,808,1,NULL,'','fa fa-unlock','',1,0),(809,808,'LockAuth','钥匙管理','lockauth_id','lockauth',1,1,807,1,NULL,'','fa fa-key','',1,0),(813,0,'Lock','门锁列表','lock_id','lock',1,1,803,0,NULL,'','','',179,0),(814,0,'LockAuth','钥匙管理','lockauth_id','lockauth',1,1,807,0,NULL,'','','',179,0),(812,808,'LockLog','开门记录','locklog_id','locklog',1,1,809,1,NULL,'','fa fa-list-alt','',1,0),(815,0,'LockLog','日志管理','locklog_id','locklog',1,1,809,0,NULL,'','','',179,0),(816,0,'Config','系统配置','','',1,1,7,0,0,'','glyphicon glyphicon-cog','基本设置|上传配置|微门禁配置',179,0),(817,0,'','健康登记','','',0,1,817,0,NULL,'','fa fa-heartbeat','',1,0),(818,808,'Locktimes','开门时段','locktimes_id','locktimes',1,0,818,1,NULL,'','','',1,0),(819,0,'Locktimes','开门时段','locktimes_id','locktimes',1,0,818,0,NULL,'','','',179,0);
/*!40000 ALTER TABLE `cd_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cd_regpoint`
--

DROP TABLE IF EXISTS `cd_regpoint`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_regpoint` (
  `regpoint_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `member_id` varchar(250) DEFAULT NULL COMMENT '会员ID',
  `user_id` varchar(250) DEFAULT NULL COMMENT '用户ID',
  `regpointname` varchar(250) DEFAULT NULL COMMENT '名称',
  `regpointurl` varchar(250) DEFAULT NULL COMMENT '注册点url',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `regpointqrcode` varchar(250) DEFAULT NULL COMMENT '登记点二维码',
  PRIMARY KEY (`regpoint_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_regpoint`
--

--
-- Table structure for table `cd_user`
--

DROP TABLE IF EXISTS `cd_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cd_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(24) DEFAULT NULL COMMENT '姓名',
  `user` varchar(24) DEFAULT NULL COMMENT '登录用户名',
  `pwd` varchar(32) DEFAULT NULL COMMENT '登录密码',
  `group_id` tinyint(4) DEFAULT NULL COMMENT '所属分组ID',
  `type` tinyint(4) DEFAULT NULL COMMENT '账户类型 1超级管理员 2普通管理员',
  `note` varchar(128) DEFAULT NULL COMMENT '备注',
  `status` tinyint(4) DEFAULT NULL COMMENT '10正常 0禁用',
  `create_time` int(10) DEFAULT NULL COMMENT '添加时间',
  `member_id` int(11) DEFAULT NULL COMMENT '会员ID',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cd_user`
--

LOCK TABLES `cd_user` WRITE;
/*!40000 ALTER TABLE `cd_user` DISABLE KEYS */;
INSERT INTO `cd_user` VALUES (1,'极客师傅','admin','305afeb46a6aa7bca43880dcb29d634d',1,1,'超级管理员',1,1548558919,35);
/*!40000 ALTER TABLE `cd_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
