<?php  namespace Config;
/*
 * 如果要增加新的方法和模块，就必须要在这里添加方法和控制器
 * */

use CodeIgniter\Config\BaseConfig;

class Aci extends BaseConfig
{
    public $aci_status = [
        'systemVersion' => '1.2.0',
        'installED' => true,
    ];

    public $aci_module = [
        'dashboard' =>[
            'version' => '1',
            'charset' => 'utf-8',
            'lastUpdate' => '2017-07-28 20:10:10',
            'moduleName' => 'index',
            'modulePath' => 'admin',
            'moduleCaption' => '后台首页',
            'description' => '后台首页',
            'fileList' => NULL,
            'works' => true,
            'moduleUrl' => 'admin/index',
            'system' => true,
            'coder' => 'Arrow',
            'website' => 'http://',
            'moduleDetails' =>[
                [
                    'folder' => 'admin',
                    'controller' => 'index',
                    'method' => 'index',
                    'caption' => '后台首页',
                ],
            ],
        ],
        'staff' =>[
            'version' => '1',
            'charset' => 'utf-8',
            'lastUpdate' => '2017-07-28 20:10:10',
            'moduleName' => 'staff',
            'modulePath' => 'admin',
            'moduleCaption' => '用户管理',
            'description' => '用户管理',
            'fileList' => NULL,
            'works' => true,
            'moduleUrl' => 'admin/staff',
            'system' => true,
            'coder' => 'Arrow',
            'website' => 'http://',
            'moduleDetails' =>
                [
                    [
                        'folder' => 'admin',
                        'controller' => 'staff',
                        'method' => 'index',
                        'caption' => '用户管理',
                    ],
                    [
                        'folder' => 'admin',
                        'controller' => 'staff',
                        'method' => 'add',
                        'caption' => '添加用户',
                    ],
                    [
                        'folder' => 'admin',
                        'controller' => 'staff',
                        'method' => 'edit',
                        'caption' => '编辑用户',
                    ],
                    [
                        'folder' => 'admin',
                        'controller' => 'staff',
                        'method' => 'delete',
                        'caption' => '删除用户',
                    ],
                    [
                        'folder' => 'admin',
                        'controller' => 'staff',
                        'method' => 'staffStatus',
                        'caption' => '用户状态',
                    ],
                    [
                        'folder' => 'admin',
                        'controller' => 'staff',
                        'method' => 'changepwd',
                        'caption' => '修改密码',
                    ],
                    [
                        'folder' => 'admin',
                        'controller' => 'staff',
                        'method' => 'profile',
                        'caption' => '个人资料',
                    ],
                ]
        ],
        'menu' =>[
            'version' => '1',
            'charset' => 'utf-8',
            'lastUpdate' => '2017-07-28 20:10:10',
            'moduleName' => 'menu',
            'modulePath' => 'admin',
            'moduleCaption' => '菜单管理',
            'description' => '菜单管理',
            'fileList' => NULL,
            'works' => true,
            'moduleUrl' => 'admin/menu',
            'system' => true,
            'coder' => 'Arrow',
            'website' => 'http://',
            'moduleDetails' =>[
                [
                    'folder' => 'admin',
                    'controller' => 'menu',
                    'method' => 'index',
                    'caption' => '菜单管理',
                ],
                [
                    'folder' => 'admin',
                    'controller' => 'menu',
                    'method' => 'add',
                    'caption' => '添加菜单',
                ],
                [
                    'folder' => 'admin',
                    'controller' => 'menu',
                    'method' => 'edit',
                    'caption' => '编辑菜单',
                ],
                [
                    'folder' => 'admin',
                    'controller' => 'menu',
                    'method' => 'delete',
                    'caption' => '删除菜单',
                ],
            ],
        ],
        'role' =>[
            'version' => '1',
            'charset' => 'utf-8',
            'lastUpdate' => '2017-07-28 20:10:10',
            'moduleName' => 'role',
            'modulePath' => 'admin',
            'moduleCaption' => '角色管理',
            'description' => '角色管理',
            'fileList' => NULL,
            'works' => true,
            'moduleUrl' => 'admin/role',
            'system' => true,
            'coder' => 'Arrow',
            'website' => 'http://',
            'moduleDetails' =>[
                [
                    'folder' => 'admin',
                    'controller' => 'role',
                    'method' => 'index',
                    'caption' => '角色管理',
                ],
                [
                    'folder' => 'admin',
                    'controller' => 'role',
                    'method' => 'add',
                    'caption' => '添加角色',
                ],
                [
                    'folder' => 'admin',
                    'controller' => 'role',
                    'method' => 'edit',
                    'caption' => '编辑角色',
                ],
                [
                    'folder' => 'admin',
                    'controller' => 'role',
                    'method' => 'delete',
                    'caption' => '删除角色',
                ],
                [
                    'folder' => 'admin',
                    'controller' => 'role',
                    'method' => 'access',
                    'caption' => '权限分配'
                ],
            ],
        ],
        'setting' =>[
            'version' => '1',
            'charset' => 'utf-8',
            'lastUpdate' => '2017-07-28 20:10:10',
            'moduleName' => 'setting',
            'modulePath' => 'admin',
            'moduleCaption' => '设置中心',
            'description' => '设置中心',
            'fileList' => NULL,
            'works' => true,
            'moduleUrl' => 'admin/setting',
            'system' => true,
            'coder' => 'Arrow',
            'website' => 'http://',
            'moduleDetails' =>[
                [
                    'folder' => 'admin',
                    'controller' => 'setting',
                    'method' => 'index',
                    'caption' => '设置中心',
                ],
            ],
        ],

        'utils' =>[
            'version' => '1',
            'charset' => 'utf-8',
            'lastUpdate' => '2017-07-28 20:10:10',
            'moduleName' => 'utils',
            'modulePath' => 'admin',
            'moduleCaption' => '插件中心',
            'description' => '插件中心',
            'fileList' => NULL,
            'works' => true,
            'moduleUrl' => 'admin/utils',
            'system' => true,
            'coder' => 'Arrow',
            'website' => 'http://',
            'moduleDetails' =>[
                [
                    'folder' => 'admin',
                    'controller' => 'utils',
                    'method' => 'imgUpload',
                    'caption' => '图片上传',
                ],
            ],
        ],

        'credit' =>[
            'version' => '1',
            'charset' => 'utf-8',
            'lastUpdate' => '2017-07-28 20:10:10',
            'moduleName' => 'credit',
            'modulePath' => 'admin',
            'moduleCaption' => '新闻中心',
            'description' => '新闻中心',
            'fileList' => NULL,
            'works' => true,
            'moduleUrl' => 'admin/credit',
            'system' => true,
            'coder' => 'Arrow',
            'website' => 'http://',
            'moduleDetails' =>[
                [
                    'folder' => 'admin',
                    'controller' => 'credit',
                    'method' => 'news',
                    'caption' => '新闻资讯',
                ],
                [
                    'folder' => 'admin',
                    'controller' => 'credit',
                    'method' => 'addNews',
                    'caption' => '添加新闻',
                ],
                [
                    'folder' => 'admin',
                    'controller' => 'credit',
                    'method' => 'editNews',
                    'caption' => '编辑新闻',
                ],
                [
                    'folder' => 'admin',
                    'controller' => 'credit',
                    'method' => 'deleteNews',
                    'caption' => '删除新闻',
                ],
            ],
        ],
    ];
}

/* End of file aci.php */
/* Location: ./application/config/aci.php */
