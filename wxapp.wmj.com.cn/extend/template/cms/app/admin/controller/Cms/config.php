<?php

//Cms菜单配置

return [
	[
		'title' => 'CMS管理',
		'icon' => 'fa fa-clone',
		'url' => '/admin/Cms',
		'access_url' => '/admin/Cms',
		'sub' =>[
			[
                'title' => '栏目管理',
                'icon' => 'fa fa-clone',
                'url' => '/admin/Cms.Catagory',
				'access_url' => '/admin/Cms.Catagory',
				'action'=>[
					[
						'title'	=> '首页数据列表',
						'val'	=> '/admin/Cms.Catagory/index',
					],
					[
						'title'	=> '修改状态排序',
						'val'	=> '/admin/Cms.Catagory/updateExt',
					],
					[
						'title'	=> '添加栏目',
						'val'	=> '/admin/Cms.Catagory/add',
					],
					[
						'title'	=> '修改栏目',
						'val'	=> '/admin/Cms.Catagory/update',
					],
					[
						'title'	=> '删除栏目',
						'val'	=> '/admin/Cms.Catagory/delete',
					],
					[
						'title'	=> '栏目排序',
						'val'	=> '/admin/Cms.Catagory/setSort',
					],
				],
            ],
            [
                'title' => '文章管理',
                'icon' => 'fa fa-clone',
                'url' => '/admin/Cms.Content',
				'access_url' => '/admin/Cms.Content',
				'action'	=> [
					[
						'title'	=> '首页数据列表',
						'val'	=> '/admin/Cms.Content/index',
					],
					[
						'title'	=> '修改状态排序',
						'val'	=> '/admin/Cms.Content/updateExt',
					],
					[
						'title'	=> '添加文章',
						'val'	=> '/admin/Cms.Content/add',
					],
					[
						'title'	=> '修改文章',
						'val'	=> '/admin/Cms.Content/update',
					],
					[
						'title'	=> '删除文章',
						'val'	=> '/admin/Cms.Content/delete',
					],
					[
						'title'	=> '文章排序',
						'val'	=> '/admin/Cms.Content/setSort',
					],
					[
						'title'	=> '设置推荐位',
						'val'	=> '/admin/Cms.Content/setPosition',
					],
					[
						'title'	=> '删除推荐位',
						'val'	=> '/admin/Cms.Content/delPosition',
					],
					[
						'title'	=> '文章移动',
						'val'	=> '/admin/Cms.Content/move',
					],
				],
            ],
			[
                'title' => '碎片管理',
                'icon' => 'fa fa-clone',
                'url' => '/admin/Cms.Frament',
				'access_url' => '/admin/Cms.Frament',
				'action'	=> [
					[
						'title'	=> '首页数据列表',
						'val'	=> '/admin/Cms.Frament/index',
					],
					[
						'title'	=> '修改状态排序',
						'val'	=> '/admin/Cms.Frament/updateExt',
					],
					[
						'title'	=> '添加碎片',
						'val'	=> '/admin/Cms.Frament/add',
					],
					[
						'title'	=> '修改碎片',
						'val'	=> '/admin/Cms.Frament/update',
					],
					[
						'title'	=> '删除碎片',
						'val'	=> '/admin/Cms.Frament/delete',
					]
				],
            ],
			[
                'title' => '推荐位管理',
                'icon' => 'fa fa-clone',
                'url' => '/admin/Cms.Position',
				'access_url' => '/admin/Cms.Position',
				'action'	=> [
					[
						'title'	=> '首页数据列表',
						'val'	=> '/admin/Cms.Position/index',
					],
					[
						'title'	=> '修改状态排序',
						'val'	=> '/admin/Cms.Position/updateExt',
					],
					[
						'title'	=> '添加推荐位',
						'val'	=> '/admin/Cms.Position/add',
					],
					[
						'title'	=> '修改推荐位',
						'val'	=> '/admin/Cms.Position/update',
					],
					[
						'title'	=> '删除推荐位',
						'val'	=> '/admin/Cms.Position/delete',
					]
				],
            ],
		],
	],
];