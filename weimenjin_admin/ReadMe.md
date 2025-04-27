## 说明
` 适配PHP8.2+版本，基于PHP8.2开发`

### 1.PHP8.2，安装扩展fileinfo、redis;禁用函数中删除putenv。
### 2.数据库Mysql8.0.24和缓存数据库Rides；数据库在db.sql脚本。
### 3.数据库配置文件为.env文件，运行目录为public
### 4.同步门卡和同步人脸用到了进程守护管理器，利用Supervisor守护faceAdd和cardAdd两个指令。


## 实施步骤：
### 1.git clone -b Standard git@e.coding.net:zyxt/weimenjin/wmj_ManagementPlatform.git ./
### 2.配置数据库连接,api等信息