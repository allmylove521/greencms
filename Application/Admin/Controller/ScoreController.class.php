<?php

/**
 * Created by GreenStudio GCS Dev Team.
 * File: ToolsController.class.php
 * User: Timothy Zhang
 * Date: 14-3-17
 * Time: 下午9:27
 */
namespace Admin\Controller;

use Common\Event\WordpressEvent;
use Common\Util\File;
use Think\Log;
use Think\Upload;

/**
 * Class ToolsController
 *
 * @package Admin\Controller
 */
class ScoreController extends AdminBaseController {
	/**
	 * 'Score/term' => '学年管理',
	 * 'Score/items' => '评分项管理',
	 * 'Score/titles' => '职称评分管理'
	 */
	public function index() {
		$cat_list = D ( "Cats", "Logic" )->relation ( true )->selectWithPostsCount ();
		foreach ( $cat_list as $key => $value ) {
			$cat_list [$key] ["cat_father"] = D ( 'Cats', 'Logic' )->detail ( $value ["cat_father"] );
		}
		
		$this->assign ( 'category', $cat_list );
		$this->display ();
	}
	
	/**
	 * ' '学年管理'
	 */
	public function term() {
		$cat_list = M ( "Terms")->select();
// 		foreach ( $cat_list as $key => $value ) {
// 			$cat_list [$key] ["cat_father"] = D ( 'Terms', 'Logic' )->detail ( $value ["cat_father"] );
// 		}
		
		$this->assign ( 'terms', $cat_list );
		$this->display ();
	}
	
	
	/**
	 * 添加学年
	 */
	public function addTerm()
	{
		$action = '添加';
		$this->assign('action', $action);
		$cat_list = D('Cats', 'Logic')->category();
	
		$this->assign('term', $cat_list);
		$this->display('addterm');
	}
	
	
	/**
	 * 处理添加学年
	 */
	public function addCategoryHandle()
	{
		$this->display ('term');
		$data['cat_name'] = I('post.cat_name');
		$data['cat_slug'] = urlencode(I('post.cat_slug'));
		$data['cat_father'] = I('post.cat_father');
	
		if ($data['cat_slug'] == '') {
			$data['cat_slug'] = $data['cat_name'];
		}
	
		if (D('terms')->data($data)->add()) {
			$this->success('学年添加成功', U('Admin/Score/term'));
		} else {
			$this->error('学年添加失败', U('Admin/Score/term'));
		}
	}
	/**
	 * '评分项管理'
	 */
	public function items() {
		$cat_list = D ( "Cats", "Logic" )->relation ( true )->selectWithPostsCount ();
		foreach ( $cat_list as $key => $value ) {
			$cat_list [$key] ["cat_father"] = D ( 'Cats', 'Logic' )->detail ( $value ["cat_father"] );
		}
		
		$this->assign ( 'category', $cat_list );
		$this->display ('index');
	}
	/**
	 * '职称评分管理'
	 */
	public function titles() {
		$cat_list = D ( "Cats", "Logic" )->relation ( true )->selectWithPostsCount ();
		foreach ( $cat_list as $key => $value ) {
			$cat_list [$key] ["cat_father"] = D ( 'Cats', 'Logic' )->detail ( $value ["cat_father"] );
		}
		
		$this->assign ( 'category', $cat_list );
		$this->display ('index');
	}
}