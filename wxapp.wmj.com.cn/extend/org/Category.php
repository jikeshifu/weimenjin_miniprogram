<?php
/**
 * 无限分类
 * @author 单骑闯天下
 * @version 2010-6-16
*/
namespace org;

class Category 
{	
	//原始的分类数据
	private $rawList=array();
	//格式化后的分类
	private $formatList=array();
	//格式化的字符
	private $icon = array('','├─','├─');
	//字段映射，分类id，上级分类pid,分类名称title,格式化后分类名称fulltitle
	private $field=array();
	/**
     * 构造函数
     * @param array $field 字段映射
     * @param int $id 分类id
     * @param int $pid 上级分类id
     * @param string $title 分类名称
     * @param string $fulltitle 格式化后分类名称
     * @return class
     */	
	public function __construct($field=array())
	{			
		$this->field['id']=isset($field['0'])?$field['0']:'idx';
		$this->field['pid']=isset($field['1'])?$field['1']:'parent';
		$this->field['title']=isset($field['2'])?$field['2']:'name';
		$this->field['fulltitle']=isset($field['3'])?$field['3']:'fulltitle';
	}
	/**
     * 返回给定上级分类
     * @param int $pid 上级分类
     * @param array $data 数据
     * @return array 格式化后数组
     */		
	public function getChild($pid,$data=array())
	{
		$childs=array();
		if(empty($data))
		{
			$data=$this->rawList;
		}
		foreach($data as $Category)
		{
			if($Category[$this->field['pid']]==$pid)
				$childs[]=$Category;
		}
		return $childs;
	}

	/**
     * 递归格式化分类
     * @param array $data 数据
     * @param int $id 起始分类id
     * @return array 格式化后数组
     */	
	public function getTree($data,$id=0)
	{
		//数据为空，则返回
		if(empty($data))
			return false;
			
		$this->rawList=array();
		$this->formatList=array();
		$this->rawList=$data;
		$this->_searchList($id);
		return $this->formatList;
	}
	//获取当前分类的路径
	public function getPath($data,$id){
		$this->rawList=$data;
		while(1){
			$id=$this->_getPid($id);
			if($id==0){
				break;
			}
		}
		return array_reverse($this->formatList);
	}
	/**
     * 递归格式化分类前的字符
     * @return data
     */
	private function _searchList($id=0,$space="")
	{
		//下级分类的数组
		$childs=$this->getChild($id);
		//如果没下级分类，结束递归
		if(!($n=count($childs)))
			return;
		$cnt=1;
		//循环所有的下级分类
		for($i=0;$i<$n;$i++)
		{
			$pre="";
			$pad="";
			if($n==$cnt)
			{
				$pre=$this->icon[2];
			}
			else
			{
				$pre=$this->icon[1];
				$pad=$space?$this->icon[0]:"";
			}
			$childs[$i][$this->field['fulltitle']]=($space?$space.$pre:"").$childs[$i][$this->field['title']];
			$this->formatList[]=$childs[$i];
			//递归下一级分类
			$this->_searchList($childs[$i][$this->field['id']],$space.$pad."&nbsp;&nbsp;");
			$cnt++;
		}
	}
	
	//通过当前id获取pid
	private function _getPid($id)
	{
		foreach($this->rawList as $key=>$value){
		
			if($this->rawList[$key][$this->field['id']]==$id)
			{
				$this->formatList[]=$this->rawList[$key];
				return $this->rawList[$key][$this->field['pid']];
			}
		}
		return 0;
	}

}

?>