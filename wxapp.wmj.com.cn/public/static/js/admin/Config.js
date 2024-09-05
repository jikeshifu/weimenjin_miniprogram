var CodeInfoDlg = {
    CodeInfoData: {},
    deptZtree: null,
    pNameZtree: null,
    validateFields: {
        site_title: {
            validators: {
                notEmpty: {
                    message: '站点名称不能为空'
                },
            }
        },
    }
}


CodeInfoDlg.clearData = function () {
    this.CodeInfoData = {};
};


CodeInfoDlg.set = function (key, val) {
    this.CodeInfoData[key] = (typeof value == "undefined") ? $("#" + key).val() : value;
    return this;
};


CodeInfoDlg.get = function (key) {
    return $("#" + key).val();
};


CodeInfoDlg.close = function () {
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);
};


CodeInfoDlg.collectData = function () {
    this.set('').set('yjy_appsecret').set('yjy_appid').set('site_title').set('site_logo').set('keyword').set('description').set('file_size').set('file_type').set('domain').set('copyright').set('wmjappid').set('wmjappsecret').set('wmjaeskey').set('sms_appid').set('sms_appsecret').set('adminpw').set('devicecid').set('autodtkey').set('autodtkeylockid').set('gzhappid').set('gzhappsecret').set('gzhminiappid').set('gzhtempleteid1').set('gzhtempleteid2').set('wxpayappid').set('wxpaykey').set('wxpaymchid').set('wxpaycert_path').set('wxpaykey_path').set('sms_lable').set('gzhtempleteid3');
};


CodeInfoDlg.index = function () {
    this.clearData();
    this.collectData();
    if (!this.validate()) {
        return;
    }
    var privacypolicy = UE.getEditor('privacypolicy').getContent();
    var serviceagreement = UE.getEditor('serviceagreement').getContent();
    var tip = '修改';
    var ajax = new $ax(Feng.ctxPath + "/Config/index", function (data) {
        if ('00' === data.status) {
            Feng.success(data.msg);
            CodeInfoDlg.close();
        } else {
            Feng.error(tip + "失败！" + data.msg + "！");
        }
    })
    ajax.set('privacypolicy', privacypolicy);
    ajax.set('serviceagreement', serviceagreement);
    ajax.set(this.CodeInfoData);
    ajax.start();
};


CodeInfoDlg.validate = function () {
    $('#CodeInfoForm').data("bootstrapValidator").resetForm();
    $('#CodeInfoForm').bootstrapValidator('validate');
    return $("#CodeInfoForm").data('bootstrapValidator').isValid();
};


$(function () {
    Feng.initValidator("CodeInfoForm", CodeInfoDlg.validateFields);
});


