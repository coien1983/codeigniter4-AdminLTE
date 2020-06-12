<?php namespace Config;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var array
	 */
	public $ruleSets = [
		\CodeIgniter\Validation\Rules::class,
		\CodeIgniter\Validation\FormatRules::class,
		\CodeIgniter\Validation\FileRules::class,
		\CodeIgniter\Validation\CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------
    public $rules = [
        //登录验证
        'login'=>[
            'rules'=>[
                'a_name'=>"required",
                'a_password'=>"required"
            ],
            'errors'=>[
                'a_password' => [
                    'required' => '登录密码不能为空'
                ],
                'a_name' => [
                    'required' => '管理员名称不能为空'
                ]
            ]
        ],
        //编辑菜单
        'editMenu'=>[
            'rules'=>[
                'menu_id'=>"required",
                'parent_id'=>"required",
                'menu_name'=>"required",
                'menu_url'=>"required",
                'is_display'=>"required",
                'css_icon'=>"required",
            ],
            'errors'=>[
                'menu_id' => [
                    'required' => '菜单id不能为空'
                ],
                'parent_id' => [
                    'required' => '菜单父id不能为空'
                ],
                'menu_name' => [
                    'required' => '菜单名称不能为空'
                ],
                'menu_url' => [
                    'required' => '菜单地址不能为空'
                ],
                'is_display' => [
                    'required' => '是否导航展示'
                ],
                'css_icon' => [
                    'required' => '图标不能为空'
                ]
            ]
        ],
        'addRole'=>[
            'rules'=>[
                'role_name'=>"required",
                'desc'=>"required",
                'role_id'=>"required",
                'status'=>"required",
            ],
            'errors'=>[
                'role_name' => [
                    'required' => '角色名称不能为空'
                ],
                'desc' => [
                    'required' => '角色描述不能为空'
                ],
                'role_id' => [
                    'required' => '角色id不能为空'
                ],
                'status' => [
                    'required' => '角色状态不能为空'
                ],
            ]
        ],
        'setAccess'=>[
            'rules'=>[
                'pid'=>"required",
                'role_id'=>"required",
            ],
            'errors'=>[
                'pid' => [
                    'required' => '权限数组不能为空'
                ],
                'role_id' => [
                    'required' => '角色id不能为空'
                ],
            ]
        ],
        'addAdmin'=>[
            'rules'=>[
                'role_id'=>"required",
                'a_name'=>"required",
                'real_name'=>"required",
                'status'=>"required",
                'a_id'=>'required',
            ],
            'errors'=>[
                'role_id' => [
                    'required' => '角色id不能为空'
                ],
                'a_name' => [
                    'required' => '登录名不能为空'
                ],
                'real_name' => [
                    'required' => '用户昵称不能为空'
                ],
                'status' => [
                    'required' => '启用状态不能为空'
                ],
                'a_id' => [
                    'required' => '用户id不能为空'
                ],
            ]
        ]
    ];

}
