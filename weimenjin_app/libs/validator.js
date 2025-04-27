export default {
  // 正整数
  isNumber(val) {
    let reg = /^[0-9]+.?[0-9]*$/;
    return reg.test(val);
  },

  // 是否是金额
  isMoney(val) {
    let pattern = /(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/;
    if (pattern.test(val) && this.isNumber(val) && Number(val) > 0) {
      return true;
    } else {
      return false;
    }
  },
  checkPhone(phone) {
    const reg = /^(13[0-9]|14[5-9]|15[012356789]|166|17[0-8]|18[0-9]|19[8-9])[0-9]{8}$/;
    return reg.test(phone);
  },
  checkPwd(password) {
    const reg = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,18}$/;
    return reg.test(password);
  },
};
