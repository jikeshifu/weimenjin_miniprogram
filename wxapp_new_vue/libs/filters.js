import { imgurl } from '@/api/request.js'


let baseURL = imgurl;
// 金额格式转换
export function formatMoney(num, cent = true) {
  if (cent) num /= 100;
  let neg = num < 0;
  let x;
  let x1;
  let x2;
  let x3;
  let i;
  let len;
  num = Math.abs(num).toFixed(2);
  num += '';
  x = num.split('.');
  x1 = x[0];
  x2 = x.length > 1 ? '.' + x[1] : '';
  x3 = '';
  for (i = 0, len = x1.length; i < len; ++i) {
    if (i !== 0 && i % 3 === 0) {
      x3 = ',' + x3;
    }
    x3 = x1[len - i - 1] + x3;
  }
  x1 = x3;
  // return (neg ? '-' : '') + self.options.prefix + x1 + x2 + self.options.suffix;
  return (neg ? '-' : '') + x1 + x2;
}

// 时间戳转日期
// dateFormat(time,"yyyy-MM-dd hh:mm:ss");
export function formatDate(date, fmt = 'yyyy-MM-dd hh:mm:ss') {
  var crtTime;
  date = date.replace(/-/g,'\/')
  if (typeof date === 'number') {
    if ((date + '').length !== 13) {
      crtTime = new Date(date * 1000);
    } else {
      crtTime = new Date(date);
    }
  } else {
    crtTime = new Date(date);
  }
  var o = {
    'M+': crtTime.getMonth() + 1,
    'd+': crtTime.getDate(),
    'h+': crtTime.getHours(),
    'm+': crtTime.getMinutes(),
    's+': crtTime.getSeconds(),
    'q+': Math.floor((crtTime.getMonth() + 3) / 3),
    S: crtTime.getMilliseconds(),
  };
  if (/(y+)/.test(fmt)) {
    fmt = fmt.replace(
      RegExp.$1,
      (crtTime.getFullYear() + '').substr(4 - RegExp.$1.length),
    );
  }
  for (var k in o) {
    if (new RegExp('(' + k + ')').test(fmt)) {
      fmt = fmt.replace(
        RegExp.$1,
        RegExp.$1.length === 1
          ? o[k]
          : ('00' + o[k]).substr(('' + o[k]).length),
      );
    }
  }
  return fmt;
}

export function imgPath(path) {
  if (path) {
    if (path.indexOf('http') >= 0) {
      return path;
    } else {
      return baseURL + path;
    }
  } else {
    return require('@/static/picture.png');
  }
}
