import { imgurl } from '@/api/request.js';

const baseURL = imgurl;

// 金额格式转换
export const formatMoney = (num, cent = true) => {
  if (cent) num /= 100;
  const neg = num < 0;
  let x;
  let x1;
  let x2;
  let x3 = '';
  let i;
  const len = Math.abs(num).toFixed(2).toString().length;

  num = Math.abs(num).toFixed(2);
  num += '';
  x = num.split('.');
  x1 = x[0];
  x2 = x.length > 1 ? '.' + x[1] : '';

  for (i = 0; i < len; ++i) {
    if (i !== 0 && i % 3 === 0) {
      x3 = ',' + x3;
    }
    x3 = x1[len - i - 1] + x3;
  }

  return (neg ? '-' : '') + x3 + x2;
};

// 时间戳转日期
export const formatDate = (date, fmt = 'yyyy-MM-dd hh:mm:ss') => {
  let crtTime;
  date = date.replace(/-/g, '/');
  
  if (typeof date === 'number') {
    crtTime = (date + '').length !== 13 ? new Date(date * 1000) : new Date(date);
  } else {
    crtTime = new Date(date);
  }

  const o = {
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

  for (const k in o) {
    if (new RegExp(`(${k})`).test(fmt)) {
      fmt = fmt.replace(
        RegExp.$1,
        RegExp.$1.length === 1 ? o[k] : (`00${o[k]}`).substr(`${o[k]}`.length),
      );
    }
  }
  
  return fmt;
};

export const imgPath = (path) => {
  if (path) {
    return path.indexOf('http') >= 0 ? path : `${baseURL}${path}`;
  } else {
    return "/static/moren.png";
  }
};
