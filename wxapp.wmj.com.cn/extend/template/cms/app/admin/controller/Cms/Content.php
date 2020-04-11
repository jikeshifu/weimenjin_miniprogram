<?php 
/**
 *内容管理
*/

namespace app\admin\controller\Cms;

use cms\service\ContentService;
use cms\db\Content as ContentDb;
use cms\db\Catagory;
use app\admin\db\Menu;
use xhadmin\db\BaseDb;
use app\admin\db\Field;
use app\admin\controller\Admin;

class Content extends Admin {


	/*内容管理*/
	function index(){
		if (!$this->request->isAjax()){
			$list = json_encode(ContentService::getSubClass('0'));
			$list = str_replace('class_name','name',$list);
			$list = str_replace('class_id','id',$list);
			$this->view->assign('catagoryInfo',$list);
			return $this->display('cms/content/index');
		}else{
			$limit  = $this->request->post('limit', 0, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where['a.title'] = ['like',$this->request->param('title', '', 'strip_tags,trim')];
			$where['a.class_id'] = $this->request->param('class_id', '', 'strip_tags,trim');
			$where['a.status'] = $this->request->param('status', '', 'strip_tags,trim');

			$startTime = $this->request->param('startTime', '', 'strip_tags');
			$endTime = $this->request->param('endTime', '', 'strip_tags');

			$where['a.create_time'] = ['between',[strtotime($startTime),strtotime($endTime)]];

			$limit = ($page-1) * $limit.','.$limit;
			$field = 'a.*,b.class_name';
			try{
				$list = ContentDb::relateQuery($field,'class_id',$relate_table='catagory',$relate_field='class_id',formatWhere($where),$limit,$orderby);
				$res['count'] = ContentDb::relateQueryCount($field,'class_id',$relate_table='catagory',$relate_field='class_id',formatWhere($where));
			}catch(\Exception $e){
				exit($e->getMessage());
			}
			
			foreach($list as $key=>$val){
				if(!empty($val['pic'])){
					$list[$key]['title'] = $val['title'].'&nbsp;<img onmousemove=\'showBigPic("'.$val['pic'].'")\' onmouseout=\'closeimg()\' src="/static/img/pic.gif">&nbsp;';
				}			
				if(!empty($val['position'])){
					$list[$key]['title'] .= '&nbsp;'.ContentService::getPositionName($val['position'],$val['content_id']);
				}
				$list[$key]['create_time'] = date('Y-m-d',$val['create_time']);
			}

			$data['rows']  = $list;
			$data['total'] = $res['count'];
			return json(htmlOutList($data));
		}
	}

	/*修改排序、开关按钮操作 如果没有此类操作 可以删除该方法*/
	function updateExt(){
		$data = $this->request->post();
		if(!$data['content_id']) $this->error('参数错误');
		try{
			ContentDb::edit($data);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*添加*/
	function add(){
		if (!$this->request->isPost()){
			return $this->display('cms/content/info');
		}else{
			$data = $this->request->post();
			try {
				ContentService::add($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'添加成功']);
		}
	}

	/*修改*/
	function update(){
		if (!$this->request->isPost()){
			$content_id = $this->request->get('content_id','','intval');
			if(!$content_id) $this->error('参数错误');
			$this->view->assign('info',checkData(ContentDb::getInfo($content_id)));
			return $this->display('cms/content/info');
		}else{
			$data = $this->request->post();
			try {
				ContentService::update($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}

	/*删除*/
	function delete(){
		$idx =  $this->request->post('content_ids', '', 'strip_tags');
		if(!$idx) $this->error('参数错误');
		try{
			$where['content_id'] = explode(',',$idx);
			ContentService::delete($where);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}
	
	//删除推荐位
	public function delPosition(){
		$content_id = $this->request->post('content_id','','intval');
		$position_id = $this->request->post('position_id','','intval');
		if(empty($content_id) || empty($position_id)){
			return json(['status'=>'01','msg'=>'参数错误']);
		}
		
		try {
			$res = ContentService::delPosition($content_id,$position_id);
		} catch (\Exception $e) {
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}
	
	
	//文章移动到其他栏目
	public function move(){
		$content_ids = $this->request->post('content_ids','','strval');
		$class_id = $this->request->post('class_id','','intval');
		if(empty($content_ids) || empty($class_id)){
			return json(['status'=>'01','msg'=>'参数错误']);
		}
		
		try {
			$where['content_id'] = explode(',',$content_ids);
			$data['class_id'] = $class_id;
			$res = ContentDb::editWhere($where,$data);
		} catch (\Exception $e) {
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}
	
	
	//设置推荐位
	public function setPosition(){
		$content_ids = $this->request->post('content_ids','','strval');
		$position_id = $this->request->post('position_id','','intval');
		if(empty($content_ids) || empty($position_id)){
			return json(['status'=>'01','msg'=>'参数错误']);
		}
		
		try {
			$where = [];
			$idx = explode(',',$content_ids);
			if($idx){
				foreach ($idx as $id) {
					$res = ContentService::setPosition($id,$position_id);
				}
			}
		} catch (\Exception $e) {
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}
	
	/*获取拓展字段信息*/
	function getExtends(){
		$class_id =  $this->request->post('class_id','','intval');
		$content_id = $this->request->post('content_id','','intval');
		$classInfo = Catagory::getInfo($class_id);
		if(!$classInfo['module_id']){
			return json(['status'=>'01']);
		}
		//获取拓展表的内容信息
		if($content_id){
			$extInfo = Menu::getInfo($classInfo['module_id']);
			BaseDb::setTableName($extInfo['table_name']);
			BaseDb::setPk('content_id');
			$extContentInfo = checkData(BaseDb::getInfo($content_id),false);
		}
		
		$htmlstr = '';
		$fieldList = Field::loadList(['menu_id'=>$classInfo['module_id'],'is_post'=>1]);
		if($fieldList){
			foreach($fieldList as $key=>$val){
				if($val['type'] == 17){
					$areaVal = explode('|',$val['field']);
					$val['province'] = $extContentInfo[$areaVal[0]];
					$val['city'] = $extContentInfo[$areaVal[1]];
					$val['district'] = $extContentInfo[$areaVal[2]];
				}else{
					$val['value'] = $extContentInfo[$val['field']];
				}

				if($content_id){
					$val['content_id'] = $content_id;
				}	
				$htmlstr .= \cms\service\ContentService::getFieldData($val);
			}
			$htmlstr = str_replace('col-sm-2','col-sm-1',$htmlstr);
			return json(['status'=>'00','fieldList'=>$fieldList,'data'=>$htmlstr]);
		}else{
			return json(['status'=>'01']);
		}
	}
	
	function getThumbPic(){
		$detail = $this->request->post('detail','','strval');
		preg_match_all('/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/',$detail,$allImg);
		return json(['status'=>'00','imgurl'=>$allImg[1][0]]);
	}

}

