import { domainUrl, apiUrl, softwareDomainUrl, softwareApiUrl } from '@/config/domain.js';

const commonUrl = apiUrl; // 公共路径
const HTTPS = commonUrl;
const imgurl = domainUrl;

import httpRequest from './http/request.js';
import { getToken, removeToken } from '@/libs/auth';
import { login } from '@/api/user';

// 封装的 POST 请求函数
export async function myRequest(url, data, method = "POST") {
  let header = {
    "content-type": "application/json"
  };

  if (!getToken()) {
    await login();
  }
  header.Authorization = getToken();
  url=commonUrl + url;
  let requestRes = await httpRequest(url, data, method, header);

  if (requestRes.code === 101) {
    await login();
    header.Authorization = getToken();
    requestRes = await httpRequest(url, data, method, header);
  }
 //console.log("token:",header.Authorization)
  return requestRes;
}
// 封装的 POST 请求函数
export async function myAdRequest(url, data, method = "POST") {
  let header = {
    "content-type": "application/json"
  };

  if (!getToken()) {
    await login();
  }
  header.Authorization = getToken();
  url=softwareApiUrl + (url.startsWith('/') ? url : `/${url}`);
  let requestRes = await httpRequest(url, data, method, header);

  if (requestRes.code === 101) {
    await login();
    header.Authorization = getToken();
    requestRes = await httpRequest(url, data, method, header);
  }
 //console.log("token:",header.Authorization)
  return requestRes;
}
// 封装的 POST 请求函数
export async function softwareRequest(url, data, method = "POST") {
  let header = {
    "content-type": "application/json"
  };

  if (!getToken()) {
    await login();
  }
  header.Authorization = getToken();
  url=softwareDomainUrl + (url.startsWith('/') ? url : `/${url}`);
  let requestRes = await httpRequest(url, data, method, header);

  if (requestRes.code === 101) {
    await login();
    header.Authorization = getToken();
    requestRes = await httpRequest(url, data, method, header);
  }
 //console.log("token:",header.Authorization)
  return requestRes;
}
// 封装的上传图片函数
export async function uploadImg(url, data) {
  return new Promise((resolve, reject) => {
    let header = {
      "Accept": "application/json",
      "Authorization": getToken()
    };

    uni.uploadFile({
      url: commonUrl + url,
      filePath: data.image,
      name: 'image',
      header: header,
      success: res => {
        res.data = JSON.parse(res.data);
        if (res.statusCode === 200) {
          resolve(res.data);
        } else if (res.statusCode === 101) {
          removeToken('token');
          uni.switchTab({ url: '/pages/index/index' });
          resolve(res);
        } else {
          uni.showToast({
            title: `${res.statusCode}：${res.errMsg || '未知错误'}`,
            duration: 2000,
            icon: 'none'
          });
          resolve(res);
        }
      },
      fail: err => {
        reject(`网络出错: ${err}`);
      }
    });
  });
}

// 直接导出已经声明的变量
export async function uploadFileRequest(url, options = {}) {
  const filePath = String(options.filePath || '').trim();
  const name = String(options.name || 'file').trim() || 'file';
  const formData = options.formData && typeof options.formData === 'object' ? options.formData : {};

  if (!filePath) {
    throw new Error('上传文件路径不能为空');
  }

  if (!getToken()) {
    await login();
  }

  const doUpload = () => new Promise((resolve, reject) => {
    uni.uploadFile({
      url: commonUrl + url,
      filePath,
      name,
      formData,
      header: {
        Accept: 'application/json',
        Authorization: getToken()
      },
      success: (res) => {
        let responseData = res.data;
        try {
          responseData = typeof responseData === 'string' ? JSON.parse(responseData) : responseData;
        } catch (error) {
        }

        if (res.statusCode === 200) {
          resolve(responseData);
          return;
        }

        reject(new Error(`上传失败(${res.statusCode || 'unknown'})`));
      },
      fail: (error) => {
        reject(new Error(`网络异常: ${(error && (error.errMsg || error.message)) || '上传失败'}`));
      }
    });
  });

  let response = await doUpload();
  if (response && Number(response.code) === 101) {
    await login();
    response = await doUpload();
  }
  return response;
}

export { commonUrl, HTTPS, imgurl };
