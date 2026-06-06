<?php


namespace app\admin\controller;

class Index extends Admin
{

    public function index(){
		$menu = $this->getSubMenu(0);
		$cmsMenu = include app()->getRootPath().'/app/admin/controller/Cms/config.php';	//cms菜单配置
		if($cmsMenu){
			foreach($cmsMenu[0]['sub'] as $key=>$val){
				$cmsMenu[0]['sub'][$key]['url'] = $this->getUrl($val['url']);
			}
			$menu = array_merge($cmsMenu,$menu);
		}
        if(session('admin.role') == 1){
            $menu[] = [
                'title' => '系统更新',
                'icon' => 'fa fa-cloud-download',
                'url' => $this->getUrl('/admin/SystemUpdate/index'),
                'access_url' => '/admin/SystemUpdate/index',
            ];
        }
		$this->view->assign('menus',$menu);
		return $this->display('index');
    }


	public function main(){
		return $this->display('main');
	}

	public function stats(){
		try{
			$role = session('admin.role');
			$userId = session('admin.userid');

			$lockWhere = [];
			$umemberWhere = [];
			$lockauthWhere = [];
			$locklogWhere = [];
			if($role <> 1){
				$lockWhere['user_id'] = $userId;
				$umemberWhere['user_id'] = $userId;
				$lockauthWhere['user_id'] = $userId;
				$locklogWhere['user_id'] = $userId;
			}

			$deviceCount = db('lock')->where($lockWhere)->whereNull('deleted_at')->count();
			$userCount = db('umember')->where($umemberWhere)->count();
			$keyCount = db('lockauth')->where($lockauthWhere)->whereNull('deleted_at')->count();

			$days = 30;
			$endTs = time();
			$startTs = strtotime(date('Y-m-d 00:00:00', strtotime('-'.($days-1).' day')));
			$query = db('locklog')
				->where($locklogWhere)
				->whereBetween('create_time', [$startTs, $endTs])
				->field("DATE(FROM_UNIXTIME(create_time)) as d, COUNT(*) as c")
				->group("DATE(FROM_UNIXTIME(create_time))")
				->order('d asc')
				->select()
				->toArray();

			$countsByDay = [];
			foreach($query as $row){
				$countsByDay[$row['d']] = (int)$row['c'];
			}

			$dates = [];
			$series = [];
			for($i=$days-1; $i>=0; $i--){
				$day = date('Y-m-d', strtotime('-'.$i.' day'));
				$dates[] = $day;
				$series[] = isset($countsByDay[$day]) ? $countsByDay[$day] : 0;
			}

			$openTypes = [1,2,3,4,7,8,11,12];
			$failedCount = db('locklog')
				->where($locklogWhere)
				->whereBetween('create_time', [$startTs, $endTs])
				->where('status', 0)
				->whereIn('type', $openTypes)
				->count();

			$typeRows = db('locklog')
				->where($locklogWhere)
				->whereBetween('create_time', [$startTs, $endTs])
				->field("DATE(FROM_UNIXTIME(create_time)) as d, type, COUNT(*) as c")
				->group("DATE(FROM_UNIXTIME(create_time)), type")
				->order('d asc')
				->select()
				->toArray();

			$countsByTypeDay = [];
			foreach($typeRows as $r){
				$t = (string)($r['type'] ?? '0');
				if(!isset($countsByTypeDay[$t])){ $countsByTypeDay[$t] = []; }
				$countsByTypeDay[$t][$r['d']] = (int)$r['c'];
			}
			$seriesByType = [];
			foreach($countsByTypeDay as $t => $map){
				$arr = [];
				foreach($dates as $d){ $arr[] = isset($map[$d]) ? $map[$d] : 0; }
				$seriesByType[$t] = $arr;
			}

			$typeNames = [];
			if(class_exists('app\\module\\lockServer\\LockLog')){
				$typeNames = \app\module\lockServer\LockLog::$type;
			}
			if(!empty($typeNames)){
				foreach($typeNames as $tk => $_){
					$key = (string)$tk;
					if(!isset($seriesByType[$key])){
						$seriesByType[$key] = array_fill(0, count($dates), 0);
					}
				}
			}

			return json([
				'status' => '00',
				'data' => [
					'device_count' => (int)$deviceCount,
					'user_count' => (int)$userCount,
					'key_count' => (int)$keyCount,
					'dates' => $dates,
					'series' => $series,
					'series_by_type' => $seriesByType,
					'type_names' => $typeNames,
					'failed_open_30d' => (int)$failedCount,
				]
			]);
		}catch(\Exception $e){
			return json(['status'=>'01','msg'=>$e->getMessage()]);
		}
	}


	//生成左侧菜单栏结构列表 递归的方法
	private function getSubMenu($pid){
		$list = db("menu")->where(['status'=>1,'app_id'=>1,'pid'=>$pid])->order('sortid asc')->select()->toArray();
		if($list){
			$menus = [];
			foreach($list as $key=>$val){
				$sublist = db("menu")->where(['status'=>1,'app_id'=>1,'pid'=>$val['menu_id']])->order('sortid asc')->select()->toArray();
				if($sublist){
					$menus[$key]['sub'] = $this->getSubMenu($val['menu_id']);
				}
				$menus[$key]['title'] = $val['title'];
				$menus[$key]['icon'] = !empty($val['menu_icon']) ? $val['menu_icon'] : 'fa fa-clone';
				$menus[$key]['url'] = !empty($val['url']) ? $this->getUrl($val['url']) : $this->getRootPath().'/'.str_replace('/','.',$val['controller_name']);
				$menus[$key]['access_url'] = !empty($val['url']) ? $val['url'] : '/'.app('http')->getName().'/'.str_replace('/','.',$val['controller_name']);
			}

			return $menus;
		}
	}

	//判断当前应用是否绑定了域名
	private function getRootPath(){
		$domains = config('app.domain_bind');
		if(in_array(app('http')->getName(),$domains)){
			$ctxPathUrl = '';
		}else{
			$ctxPathUrl = '/'.getKeyByVal(config('app.app_map'),app('http')->getName());
		}

		return $ctxPathUrl;
	}

	private function getUrl($url){
		$domains = config('app.domain_bind');
		if(in_array(app('http')->getName(),$domains)){
			return str_replace('/'.app('http')->getName(),'',$url);
		}else{
			return str_replace(app('http')->getName(),getKeyByVal(config('app.app_map'),app('http')->getName()),$url);
		}
	}

}
