<?php

namespace app\admin\service;

class FieldSetService
{

	//字段属性
	public static function typeField(){
		
		$list=array(
            1=> array(
                'name'=>'文本框',
                'property'=>1,
                ),
            2=> array(
                'name'=>'下拉框(普通)',
                'property'=>3,
                ),
            29=> array(
                'name'=>'下拉框(带搜索)',
                'property'=>3,
                ),
			27=> array(
                'name'=>'下拉框(多选)',
                'property'=>1,
                ),
            3=> array(
                'name'=>'单选框',
                'property'=>3,
                ),
            4=> array(
                'name'=>'多选框',
                'property'=>1,
                ),
			23=> array(
                'name'=>'开关按钮',
                'property'=>6,
                ),
            5=> array(
                'name'=>'密码框',
                'property'=>1,
                ),
            6=> array(
                'name'=>'文本域',
                'property'=>4,
                ),
            7=> array(
                'name'=>'日期框',
                'property'=>2,
                ),
            8=> array(
                'name'=>'单图上传',
                'property'=>1,
                ),
			9=> array(
                'name'=>'多图上传',
                'property'=>4,
                ),
			10=> array(
                'name'=>'文件上传',
                'property'=>4,
                ),
            11=> array(
                'name'=>'编辑器(xheditor)',
                'property'=>4,
                ),
			16=> array(
                'name'=>'编辑器(ueditor)',
                'property'=>4,
                ),
            12=> array(
                'name'=>'创建时间(后端录入)',
                'property'=>2,
                ),
			25=> array(
                'name'=>'修改时间(后端录入)',
                'property'=>2,
                ),
			13=> array(
                'name'=>'货币',
                'property'=>5,
                ),
			20=> array(
                'name'=>'整数',
                'property'=>2,
                ),
			21=> array(
                'name'=>'随机数',
                'property'=>1,
                ),
			22=> array(
                'name'=>'排序',
                'property'=>2,
                ),
			28=> array(
                'name'=>'标签',
                'property'=>1,
				),
			14=> array(
                'name'=>'隐藏域',
                'property'=>1,
                ),
			15=> array(
                'name'=>'session值',
                'property'=>1,
                ),
			17=> array(
                'name'=>'省市区三级联动',
                'property'=>1,
                ),
			18=> array(
                'name'=>'颜色选择器',
                'property'=>1,
                ),
			19=> array(
                'name'=>'地图坐标选择器',
                'property'=>1,
                ),
			24=> array(
                'name'=>'token解码值(用户ID)',
                'property'=>1,
                ),
			26=> array(
                'name'=>'IP',
                'property'=>1,
                ),
			30=> array(
                'name'=>'订单号',
                'property'=>1,
                ),
            
        );
        return $list;
	}
	
	
	
	//字段的sql属性
    public static function propertyField()
    {
        $list=array(
            1=> array(
                'name'=>'varchar',
                'maxlen'=>250,
                'decimal'=>0,
                ),
            2=> array(
                'name'=>'int',
                'maxlen'=>11,
                'decimal'=>0,
                ),
			3=> array(
                'name'=>'smallint',
                'maxlen'=>6,
                'decimal'=>0,
                ),
            4=> array(
                'name'=>'text',
                'maxlen'=>0,
                'decimal'=>0,
                ),
            5 => array(
                'name'=>'decimal',
                'maxlen'=>10,
                'decimal'=>2,
                ),
			6=> array(
                'name'=>'tinyint',
                'maxlen'=>4,
                'decimal'=>0,
                ),
        );
        return $list;
    }
	
	//字段验证规则列表
	public static function ruleList(){
		$list = [
			'邮箱'	=> '/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/',
			'网址'	=> '/^((ht|f)tps?):\/\/([\w\-]+(\.[\w\-]+)*\/)*[\w\-]+(\.[\w\-]+)*\/?(\?([\w\-\.,@?^=%&:\/~\+#]*)+)?/',
			'货币'	=> '/(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/',
			'数字'	=> '/^[0-9]*$/',
			'手机号'=> '/^1[345678]\d{9}$/',
			'身份证'=> '/^[1-9]\d{5}(18|19|20|(3\d))\d{2}((0[1-9])|(1[0-2]))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/',
		];
		return $list;
	}
	
	//日期格式
	public static function dateList(){
		$list = [
			'Y-m-d H:i:s'=>'datetime',
			'Y-m-d'=>'date',
			'Y-m'=>'month',
			'Y'=>'year',
			'H:i:s'=>'time',
		];
		return $list;
	}
	
	
	
	//tab菜单列表
    public static function tabList($menu_id)
    {
        $info = \app\admin\db\Menu::getInfo($menu_id);
		if($info['tab_menu']){
			$list = explode('|',$info['tab_menu']);
		}
		return $list;
    }
	
	
}
