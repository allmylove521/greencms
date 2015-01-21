<?php
/**
 * Created by GreenStudio GCS Dev Team.
 * File: IndexController.class.php
 * User: Timothy Zhang
 * Date: 14-1-11
 * Time: 下午1:40
 */
namespace Home\Controller;
use Think\Hook;

/**
 * 首页控制器
 * Class IndexController
 * @package Home\Controller
 */

class IndexController extends HomeBaseController {

	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct();
	}

	/**
	 * 显示首页
	 */
	public function index() {

       $this->display('index');
	}

	/**
	 * 显示首页为空时
	 * @param $method
	 * @param $args
	 */
	public function _empty($method, $args) {
		Hook::listen('home_index_empty');

	}

	/**
	 * 测试使用
	 */
	function test() {

        dump(TP_C());

        //echo get_addon_url("Join2011/Join2011/index");
		//        include(Upgrade_PATH . 'init.php');
		//
		//        upgrade_20140620_to_20140625();
	}

}