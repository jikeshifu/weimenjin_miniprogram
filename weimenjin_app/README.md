# 微门禁小程序端

本目录为微门禁 uni-app 小程序源码。

## 运行前配置

发布或本地调试前，只需要修改统一域名配置文件：

- `config/domain.js`

将 `APP_DOMAIN` 修改为你的后端域名：

```text
https://your-domain.example
```

接口地址、图片地址、音频地址和软件服务接口都会从该域名自动拼接。

摄像头页面也使用同一个域名，会自动访问 `APP_DOMAIN + /camweb/`。如需启用摄像头实时画面和回放，请将 `weimenjin_camweb` 静态包部署到后台同域名的 `/camweb/` 子目录。

## 开发说明

- `unpackage/`、`node_modules/`、`.hbuilderx/` 等本地构建和开发目录不应进入开源仓库。
- 小程序发布前请在对应平台重新检查合法域名、web-view 业务域名、隐私协议、AppID 和关联域名配置。
