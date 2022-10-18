# 微门禁小程序项目

#### 介绍
微门禁小程序项目,免费开源;
体验二维码

#### 代码说明
目录结构
wxapp.wmj.com.cn为管理后台源码。
wxapp_miniprogram为微信小程序源码。

#### 管理后台安装教程
对于新手，强烈建议使用宝塔面板。
1.  基于ThinkPHP6.0开发，用Nginx，站点伪静态设置为ThinkPHP。
2.  PHP7.2+,
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

详情见：https://doc.wmj.com.cn/1/page/34

### 关键配置
#### 1.管理平台的配置文件
/config/my.php
配置小程序appid，appsecret
![输入图片说明](https://images.gitee.com/uploads/images/2020/0422/231900_9caa1881_1840059.png "屏幕截图.png")

#### 2.微信小程序后台的合法域名配置(开发----开发设置--服务器域名---业务域名等)自己用什么域名就配置什么域名
![输入图片说明](https://images.gitee.com/uploads/images/2020/0422/232630_9f2d2f4c_1840059.png "屏幕截图.png")
#### 3.微信小程序后台普通二维码调起小程序规则配置(开发----开发设置---扫普通链接二维码打开小程序）参考下图
##### 扫码开门的配置

二维码规则填写：域名/minilock?user_id=
小程序功能页面填写：pages/open/open

![输入图片说明](https://images.gitee.com/uploads/images/2020/0422/232346_8d3b461d_1840059.png "屏幕截图.png")
##### 注册的配置

二维码规则填写：域名/adduser
小程序功能页面填写：pages/adduser/adduser

![输入图片说明](https://images.gitee.com/uploads/images/2020/0422/232407_f6c55ac4_1840059.png "屏幕截图.png")

# 小程序代码使用说明

#### 使用说明

1.  修改域名，位于app.js文件
![输入图片说明](https://images.gitee.com/uploads/images/2020/0420/152527_b099489f_1840059.png "屏幕截图.png")
2.  修改小程序appid，位于project.config.json文件
![输入图片说明](https://images.gitee.com/uploads/images/2020/0420/152636_e7be0be4_1840059.png "屏幕截图.png")
3.  修改图片logo这些，这些不用多说了图片里面找。
#将微信号绑定为超级管理员
###小程序能正常登录和绑定手机号后，会员管理里面找到要绑定为超级管理员的会员编号，到系统管理--用户管理--修改信息，填进会员编号
![输入图片说明](https://images.gitee.com/uploads/images/2020/0429/142020_254dbc1c_1840059.png "屏幕截图.png")
![输入图片说明](https://images.gitee.com/uploads/images/2020/0429/142419_a58e3a8e_1840059.png "屏幕截图.png")
![输入图片说明](https://images.gitee.com/uploads/images/2020/0429/142245_39927691_1840059.png "屏幕截图.png")
![输入图片说明](https://images.gitee.com/uploads/images/2020/0429/142309_6dad72e4_1840059.png "屏幕截图.png")