# 微门禁小程序开源版

微门禁是一套门禁设备管理系统，开源版本包含小程序端和后台服务端，支持设备管理、远程开门、钥匙授权、门禁卡、密码、指纹、人脸、房间绑定、摄像头控制、开门记录等常用功能。本次发布版本由旧开源版本同步升级整理而来。

## 目录结构

- `weimenjin_app`：uni-app 小程序端源码。
- `weimenjin_admin`：PHP 后台服务和管理端源码。
- `weimenjin_admin/public/camweb`：摄像头 Web 控制台，按同域名 `/camweb/` 子目录访问。
- `weimenjin_admin/weimenjin_open.sql`：最终版数据库脚本，新库直接导入。

## 环境要求

- 小程序端：HBuilderX / uni-app。
- 后台服务：PHP 8.2+、MySQL 8+、Redis、fileinfo、ZipArchive、cURL。
- 后台 Web 运行目录：`weimenjin_admin/public`。

## 快速部署

1. 导入 `weimenjin_admin/weimenjin_open.sql`。
2. 配置后台 `.env` 中的数据库连接、站点域名、小程序 AppID/AppSecret 等参数。
3. 将站点运行目录指向 `weimenjin_admin/public`。
4. 在小程序端 `weimenjin_app/config/domain.js` 中配置一次后台域名。
5. 在微信公众平台配置 request 合法域名和 web-view 业务域名。

默认超级管理员：

```text
账号：admin
密码：WmjDemo2026
```

首次登录后请及时修改默认密码。

## 在线更新

后台“系统更新”菜单已内置开源演示平台更新源：

```text
https://demo.wmj.com.cn/updates/manifest.json
```

超级管理员进入页面后会自动检测新版本，检测到更新后点击“立即升级”即可。升级前系统会自动备份代码和数据库，更新包统一放在演示平台 `/updates/` 目录下。

## 2026 更新清单

- 设备列表、设备分组、设备搜索、设备状态、远程开门。
- 钥匙授权、钥匙领取、钥匙分享、开门记录、操作日志。
- 门禁卡、密码、指纹、人脸凭证管理。
- 人脸下发、删除、同步任务和异常处理。
- 区域、楼栋、单元、房号、房间绑定申请。
- 摄像头配置、查询、绑定和 Web 控制台。
- W76F 多路继电器、W71 WiFi 空开、4G 远程开关。
- 云喇叭定时播报、TTS 发音人、播报历史。
- 小程序首页设备卡片、搜索、分组和快捷入口优化。
- 后台首页统计、近 30 天操作记录图表、在线更新。

## 数据库

SQL 文件：

```text
weimenjin_admin/weimenjin_open.sql
```

后续结构调整直接合并到该文件。在线升级如需数据库变更，请随更新包提供增量 SQL。
