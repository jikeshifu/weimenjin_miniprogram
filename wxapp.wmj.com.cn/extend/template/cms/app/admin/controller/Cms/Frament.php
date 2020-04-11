<?php 
/**
 *碎片管理
*/

namespace app\admin\controller\Cms;

use cms\service\FramentService;
use cms\db\Frament as FramentDb;
use app\admin\controller\Admin;

class Frament extends Admin {


	/*碎片管理*/
	function index(){
		if (!$this->request->isAjax()){
			return $this->display('cms/frament/index');
		}else{
			$limit  = $this->request->post('limit', 0, 'intval');
			$offset = $this->request->post('offset', 0, 'intval');
			$page   = floor($offset / $limit) +1 ;

			$where['title'] = $this->request->param('title', '', 'strip_tags,trim');
			$orderby = '';

			$limit = ($page-1) * $limit.','.$limit;
			try{
				$res = FramentService::pageList(formatWhere($where),$limit,$field,$orderby);
				$list = $res['list'];
			}catch(\Exception $e){
				exit($e->getMessage());
			}

			$data['rows']  = $list;
			$data['total'] = $res['count'];
			return json(htmlOutList($data));
		}
	}

	/*添加*/
	function add(){
		if (!$this->request->isPost()){
			return $this->display('cms/frament/add');
		}else{
			$data = $this->request->post();
			try {
				FramentService::add($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'添加成功']);
		}
	}

	/*修改*/
	function update(){
		if (!$this->request->isPost()){
			$frament_id = $this->request->get('frament_id','','intval');
			if(!$frament_id) $this->error('参数错误');
			$this->view->assign('info',checkData(FramentDb::getInfo($frament_id)));
			return $this->display('cms/frament/update');
		}else{
			$data = $this->request->post();
			try {
				FramentService::update($data);
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			return json(['status'=>'00','msg'=>'修改成功']);
		}
	}

	/*删除*/
	function delete(){
		$idx =  $this->request->post('frament_ids', '', 'strip_tags');
		if(!$idx) $this->error('参数错误');
		try{
			$where['frament_id'] = explode(',',$idx);
			FramentService::delete($where);
		}catch(\Exception $e){
			$this->error($e->getMessage());
		}
		return json(['status'=>'00','msg'=>'操作成功']);
	}



}

