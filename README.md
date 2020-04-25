# 微门禁小程序项目

#### 介绍
微门禁小程序项目,免费开源;
(申明:源码提供给大家,因时间关系,不免费提供安装配置,不提供小程序编译对接上传等咨询服务。)

#### 代码说明
目录结构
wxapp.wmj.com.cn为管理后台源码。
wxapp_miniprogram为微信小程序源码。

#### 管理后台安装教程

1.  基于ThinkPHP6.0开发，建议使用宝塔面板
2.  PHP7.2+
3.  Mysql5.5+
4.  修改数据库连接在根目录下.env文件,数据库脚本为weimenjin_miniprogram_db.sql
5.  后台超级管理员admin,默认密码wmj123456
6.  运行目录为public

#### 管理端演示
地址：https://mpdemo.wmj.com.cn/
帐号：admin
密码：wmj123456

#### 小程序的api文档

地址：https://wxapp.wmj.com.cn/doc/

#### 使用说明

获取微信绑定手机号需修改
![输入图片说明](https://images.gitee.com/uploads/images/2020/0417/184403_b297f30b_1840059.png "屏幕截图.png")

详情见：http://doc.wmj.com.cn/web/#/1?page_id=34

### 关键配置
####1.管理平台的配置文件
/config/my.php
配置小程序appid，appsecret
![输入图片说明](https://images.gitee.com/uploads/images/2020/0422/231900_9caa1881_1840059.png "屏幕截图.png")

####2.微信小程序后台的合法域名配置(开发----开发设置--服务器域名---业务域名等)自己用什么域名就配置什么域名
![输入图片说明](https://images.gitee.com/uploads/images/2020/0422/232630_9f2d2f4c_1840059.png "屏幕截图.png")
####3.微信小程序后台普通二维码调起小程序规则配置(开发----开发设置---扫普通链接二维码打开小程序）参考下图
扫码开门的配置
![输入图片说明](https://images.gitee.com/uploads/images/2020/0422/232346_8d3b461d_1840059.png "屏幕截图.png")
注册的配置
![输入图片说明](https://images.gitee.com/uploads/images/2020/0422/232407_f6c55ac4_1840059.png "屏幕截图.png")