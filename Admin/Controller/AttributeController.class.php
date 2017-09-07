<?php 
namespace Admin\Controller;

use Admin\Controller\BaseController;
use Think\Page;

class AttributeController extends BaseController
{
	/**
	 * 属性列表页
	 */
	public function index(){
		$attribute = D('Attribute');
		$count = $attribute->count();
		$p = I('p');
		$nowPage = empty($p) ? C('PAGE_DEFAULT') : $p;
		$page = new Page($count,C('PAGE_SIZE'));
		$show = $page->show();
		$list = $attribute->relation('Category')->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();

		$this->assign('list',$list);
		$this->assign('page',$show);
		$this->assign('p',$nowPage);
		$this->display();
	}

	/**
	 * 添加属性
	 */
	public function add(){
		if(IS_POST){
			$data = I('post.');
			
			$category_id = $data['category_id'];
			$attr_name = $data['attr_name'];
			$attributeModel = M('attribute');
			$attrdata = $attributeModel->where('category_id='.$category_id." and attr_name='".$attr_name."'")->find();
			if(!empty($attrdata)){
				$this->error('该属性已经存在');die;
			}
			if($attributeModel->add($data)){
				$this->success('添加属性成功',U('Attribute/index'));
			}else{
				$this->error('添加属性失败');
			}
		}else{
			$where['is_show'] = C('NORMAL_STATUS');
			$where['cid'] = array('in',C('ATTRIBUTE_CATEGORY'));
			$category = M('category')->field('cid,name')->where($where)->select();
			$this->assign('category',$category);
			$this->display();
		}
	}

	/**
	 * 编辑属性
	 */
	public function edit(){
		if(IS_POST){
			$data = I('post.');
			$category_id = $data['category_id'];
			$attr_name = $data['attr_name'];
			$attributeModel = M('attribute');
			$attrdata = $attributeModel->where('category_id='.$category_id." and attr_name='".$attr_name."'")->find();
			if(!empty($attrdata)){
				$this->error('该属性已经存在');die;
			}
			if($attributeModel->create() && $attributeModel->save()){
				$this->success('修改成功',U('Attribute/index',array('p'=>$data['p'])));
			}else{
				$this->error('修改失败');
			}
		}else{
			$id = I('id');
			$p = I('p');
			$where['is_show'] = C('NORMAL_STATUS');
			$where['cid'] = array('in',C('ATTRIBUTE_CATEGORY'));
			$category = M('category')->field('cid,name')->where($where)->select();
			$attr = M('attribute')->where('id='.$id)->find();
			$this->assign('p',$p);
			$this->assign('category',$category);
			$this->assign('attr',$attr);
			$this->display();
		}
	}

	/**
	 * 删除和启用属性
	 */
	public function delete(){
		if(IS_POST){
			$postInfo = I('post.');
			$attributeModel = M('attribute');
			$result = array('flg'=>0,'mgs'=>'操作失败');
			if($postInfo['act']=='del'){
				$data['id'] = $postInfo['id'];
				$data['is_show'] = C('DELETE_STATUS');
				if($attributeModel->create($data) && $attributeModel->save()){
					$result['flag'] = 1;
                    $result['msg'] = '删除成功';
				}
			}else if($postInfo['act']=='enable'){
				$data['id'] = $postInfo['id'];
				$data['is_show'] = C('NORMAL_STATUS');
				if($attributeModel->create($data) && $attributeModel->save()){
					$result['flag'] = 1;
                    $result['msg'] = '启用成功';
				}
			}
			echo json_encode($result);
		}
	}

}