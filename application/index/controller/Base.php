<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-3-5
 * Time: 14:20
 */

namespace app\index\controller;


use think\Controller;
use think\facade\Request;

class Base extends Controller
{
    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        if(session('?admin_id') === false){
            $this->error('你还未登录,请先登录','login/index');
        }

        $request = Request::instance();
        $con = $request->controller(); // 获取当前控制器名称
        $action = $request->action();  // 获取当前方法名称
        $rules = $con . '/' . $action;  // 组合:控制器/方法
        $auth = new Auth(); // 实例化auth类
        $notCheck = ['index/index'];  // 都可以访问的页面

        if (session('admin_id') != 1) {  // 不是超级管理员才进行权限判断(超级管理员拥有绝对权限)
            if (!in_array($rules, $notCheck)) {  // 是否在开放权限里面
                if (!$auth->check($rules, session('admin_id'))) {   // 第一个参数  控制/方法   第二个参数：当前登陆会员的id
                    $this->error('没有权限');
                };
            }
        }

    }


}