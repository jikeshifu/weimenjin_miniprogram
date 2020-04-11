<?php 
/**
 *推荐位管理
*/

namespace app\admin\controller\Cms;

use cms\service\PositionService;
use cms\db\Position as PositionDb;
use app\admin\controller\Admin;

class Position extends Admin {


	/*推荐位管理*/
	function index(){
		if (!$this->request->isAjax()){
			return $this->display('cms/position/index');
		}else{
			$limit  = $this->request->post('limit', 0, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where['title'] = $this->request->param('title', '', 'strip_tags,trim');

			$limit = ($page-1) * $limit.','.$limit;
			try{
				$res = PositionService::pageList(formatWhere($where),$limit,$field,$orderby);
				$list = $res['list'];
			}catch(\Exception $e){
				exit($e->getMessage());
			}

			$data['rows']  = $list;
			$data['total'] = $res['count'];
			return json(htmlOutList($data));
		}
	}

	/*修改排序、开关按钮操作 如果没有此类操作 可以删除该方法*/
	function updateExt(){
		$data = $this->request->post();
		if(!$data['position_id']) $this->error('参数错误');
		try{
			PositionDb::edit($data);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}

	/*添加*/
	function add(){
		if (!$this->request->isPost()){
			return $this->display('cms/position/add');
		}else{
			$data = $this->request->post();
			try {
				PositionService::add($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'添加成功']);
		}
	}

	/*修改*/
	function update(){
		if (!$this->request->isPost()){
			$position_id = $this->request->get('position_id','','intval');
			if(!$position_id) $this->error('参数错误');
			$this->view->assign('info',checkData(PositionDb::getInfo($position_id)));
			return $this->display('cms/position/update');
		}else{
			$data = $this->request->post();
			try {
				PositionService::update($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}

	/*删除*/
	function delete(){
		$idx =  $this->request->post('position_ids', '', 'strip_tags');
		if(!$idx) $this->error('参数错误');
		try{
			$where['position_id'] = explode(',',$idx);
			PositionService::delete($where);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}



}

