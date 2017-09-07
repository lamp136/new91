<?php 
namespace Admin\Controller;
use Admin\Controller\BaseController;

/**
 * 融资信息
 * Class FinancingController
 * @package Admin\Controller
 */

class FinancingController extends BaseController
{
	/**
     * 通过选择省份改变市ajax获取省份ID
     */
    public function getCityList(){
        if (IS_POST) {
            $province_id = I('province_id');
            $regionObj = M("region");
            $data = $regionObj->where("level=2 and pid=" . $province_id)->select();
            $this->ajaxReturn($data, 'JSON');
        }else{
            $this->error('省份ID不存在');
        }
    }

    /**
     * 检测项目是否已存在
     */
    public function checkName(){
    	if(IS_POST){
    		$pro_name = I('name');
    		$fina = M('finance');
    		if($fina->where("pro_name='".$pro_name."'")->find()){
    			echo '1';
    		}else{
    			echo '0';
    		}
    	}
    }

	/**
	 * 融资信息添加页面
	 */
	public function addFina(){
		$province = M('region')->field('region_id,region_name,level,pid')->where('level=1')->select();
		$this->assign('province',$province);
		$this->assign('type',C('FINANCE_TYPE'));
		$this->assign('businessActuality',C('FINANCE_BUSINESS_ACTUALITY'));
		$this->display();
	}

	/**
	 * 保存融资信息
	 */
	public function insertFina(){
		if(IS_POST){
			$fina = M('finance');
			$info = I('post.info');
			//判断项目是否存在
			$pro_name = $fina->where("pro_name='".$info['pro_name']."'")->find();
			if($pro_name){
				$this->error('该项目已经存在');die;
			}

			//大图和列表页图
			if($_FILES['url']['error']==0 && !empty($_FILES['url']['tmp_name'])){
				//上传图片
				$thumb = array(array('478','478',1),array('340','340',1));
				$ret = uploadOne('url',C('FINANCE_IMAGE'),$thumb);
				if($ret['ok']==0){
					$this->error = $ret['error'];
					return false;
				}else{
					$info['url'] = C('IMG_HOST').$ret['images'][1];
					$info['thumb_340_image'] = C('IMG_HOST').$ret['images'][2];
					
				}
			}

			//项目创建时间和修改时间
			$info['created_time'] = time();
			$info['updated_time'] = time();
			
			//录入人的ID
			$info['admin_id'] = session('admin_id');

			//发布时间
			$info['published_time'] = time();

			$res = $fina->add($info);
			if($res){
				$this->success('添加项目成功',U('Financing/listFina'));
			}else{
				$this->error('添加项目失败');
			}
			
		}
	}

	/**
	 * 融资信息列表页
	 */
	public function listFina(){
		
		$fina = D('Finance');
		
		//获取省信息
		$province = M('region')->field('region_id,region_name,level,pid')->where('level=1')->select();
		
		//接收搜索表单传过来的省市ID和项目名称
		$info = I('get.');
		$pro_name = empty($info['pro_name']) ? '' : $info['pro_name'];
		$province_id = empty($info['province_id']) ? '' : $info['province_id'];
		$city_id = empty($info['city_id']) ? '' : $info['city_id'];

		//构造查询条件
		if(!empty($pro_name)){
			$map['pro_name'] = array('like','%'.$pro_name.'%');
		}
		if(!empty($province_id)){
			$map['province_id'] = array('eq',$province_id);
		}
		if(!empty($city_id)){
			$map['city_id'] = array('eq',$city_id);
		}
		
		//项目总数量
		$count = $fina->where($map)->count();
		
		//接收分页的的参数,如果没有默认为1
		$p= I('p');
		$nowPage = empty($p) ? C('PAGE_DEFAULT'):$p;
		$Page = new \Think\Page($count,C('PAGE_SIZE'));
		$show = $Page->show();
		
		//分页数据查询
		$list = $fina->where($map)->relation(array('Province','City'))->order('created_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();

		//前台短信发送数量
		foreach($list as $key=>$value){
			$msgCount = M('msg_log')->where("classify=9 AND order_id=".$value['id'])->count();
			$list[$key]['msgCount'] = $msgCount;
		}

		$citys = array();
		if(!empty($province_id)){
			$citys = M('region')->where('pid='.$province_id)->select();
		}

		$this->assign('msgLog',$msgLog);
		$this->assign('list',$list);
		$this->assign('page',$show);
		$this->assign('pro_name',$pro_name);
		$this->assign('province_id',$province_id);
		$this->assign('city_id',$city_id);
		$this->assign('province',$province);
		$this->assign('city',$citys);
		$this->assign('nowPage',$nowPage);
		$this->display();
	}

	/**
	 * 通过项目ID获取发送短信的手机号
	 */
	public function msgMobile(){
		$financeId = I('id');
		$msgLog = M('msg_log')->where("classify=9 AND order_id=".$financeId)->field('mobile,created_time')->select();
		$i=0;
		foreach($msgLog as $key=>$value){
		 	$msgLog[$i]['created_time'] = date('Y-m-d',$value['created_time']);
		 	$i++;
		}
		echo json_encode($msgLog);
	}

	/**
	 * 修改融资信息页面
	 */
	public function editFina(){
		$nowPage = I('get.p');
		$finaID = I('get.id');
		$finance = M('finance')->where("id=".$finaID)->find();
		
		$province = M('region')->field('region_id,region_name,level,pid')->where('level=1')->select();

		$city = array();
		if(!empty($finance['province_id'])){
			$city = M('region')->where("pid=".$finance['province_id'])->select();
		}

		$this->assign('finance',$finance);
		$this->assign('province',$province);
		$this->assign('city',$city);
		$this->assign('type',C('FINANCE_TYPE'));
		$this->assign('nowPage',$nowPage);
		$this->display();
	}

	/**
	 * 保存修改后的融资信息
	 */
	public function updateFina(){
		if(IS_POST){
			$fina = M('finance');
			$nowPage = I('post.nowPage');
			$id = I('post.id');
			$info = I('post.info');
			
			if($_FILES['url']['error']==0 && !empty($_FILES['url']['tmp_name'])){
				//上传图片
				$thumb = array(array('478','478',1),array('340','340',1));
				$ret = uploadOne('url',C('FINANCE_IMAGE'),$thumb);
				if($ret['ok']==0){
					$this->error = $ret['error'];
					return false;
				}else{
					$info['url'] = C('IMG_HOST').$ret['images'][1];
					$info['thumb_340_image'] = C('IMG_HOST').$ret['images'][2];
				}
			}

			//项目修改时间
			$info['updated_time'] = time();
			// var_dump($info);die;
			$res = $fina->where('id='.$id)->save($info);
			if($res){
				$this->success('修改项目成功',U('Financing/listFina',array('p'=>$nowPage)));
			}else{
				$this->error('修改项目失败');
			}
			
		}
	}

	/**
	 * 删除融资信息
	 */
	public function delFina(){
		$fina = M('finance');
		$id = I('id');
		$data['status'] = C('DELETE_STATUS');
		$this->_deleteStart($id,$data,$fina);
	}

	/**
	 * 开启融资信息
	 */
	public function startFina(){
		$id = I('id');
		$fina = M('finance');
		$data['status'] = C('FINANCE_STATUS.AUDIT');
		$this->_deleteStart($id,$data,$fina);
	}

	/**
	 * 一键完成融资信息
	 */
	public function finishFina(){
		$id = I('id');
		$fina = M('finance');
		$data['status'] = C('FINANCE_STATUS.FINISH');
		$this->_deleteStart($id,$data,$fina);
	}

	/**
	 * 融资相册列表页
	 */
	public function listImgFina(){
		$fid = I('fid'); //项目ID
		$fname = I('fname');

		$imgfina = M('FinanceImage');
		$where['finance_id'] = $fid;
		$count = $imgfina->where($where)->count();

		$p = I('p');
		$nowPage = empty($p) ? C('PAGE_DEFAULT'):$p;
		$page = new \Think\Page($count,C('PAGE_SIZE'));
		$show = $page->show();
		$list = $imgfina->where($where)->limit($page->firstRow.','.$page->listRows)->select();

		$this->assign('list',$list);
		$this->assign('page',$show);
		$this->assign('fid',$fid);
		$this->assign('fname',$fname);
		$this->assign('nowPage',$nowPage);
		$this->display();
	}


	/**
	 * 添加融资相册页
	 */
	public function addImgFina(){
		$fid = I('fid');
		$fname = I('fname');
		$this->assign('fname',$fname);
		$this->assign('fid',$fid);
		$this->display();
	}

	/**
	 * 保存融资相册信息
	 */
	public function insertImgFina(){
		if(IS_POST){
			$data = I('post.info');
			$fname = I('post.fname');

			$thumb = array(array('340','340',1));
			$images = upload('url',C('FINANCE_IMAGE'),$thumb);
			if(!$images){
				$this->error($images['error']);
			}else{
				//插入数据表
				$imgfina = M('FinanceImage');
				foreach($images['thumb'] as $k=>$v){
					$imagesdata[$k] = $data;
					$imagesdata[$k]['url'] = C('IMG_HOST').$v['0'];
					
					//添加时间和修改是时间
					$imagesdata[$k]['created_time'] = time();
					$imagesdata[$k]['updated_time'] = time();
				}
				
				$res = $imgfina->addAll($imagesdata);
				if($res){
					$this->success('添加成功',U('Financing/listImgFina',array('fid'=>$data['finance_id'],'fname'=>$fname)));
				}else{
					$this->success('添加失败',U('Financing/listImgFina',array('fid'=>$data['finance_id'],'fname'=>$fname)));
				}
			}	
		}else{
			$this->error('提交的数据不合法');
		}	
	}

	/**
	 * 修改融资相册页
	 */
	public function editImgFina(){
		$imgfina = M('FinanceImage');
		$info = I('get.');
		$imginfo = $imgfina->where('id='.$info['id'])->find();

		$this->assign('fid',$info['fid']);
		$this->assign('fname',$info['fname']);
		$this->assign('imginfo',$imginfo);
		$this->assign('nowPage',$info['p']);
		$this->display();
	}

	/**
	 * 保存修改后的融资相册
	 */
	public function updateImgFina(){
		if(IS_POST){
			$imgfina = M('FinanceImage');
			$id = I('id');//图片ID
			$fname = I('fname');
			$nowPage = I('nowPage');
			$data = I('post.info');

			if($_FILES['url']['error']==0 && !empty($_FILES['url']['tmp_name'])){
				//上传图片
				$thumb = array(array('340','340',1));
				$ret = uploadOne('url',C('FINANCE_IMAGE'),$thumb);
				
				if($ret['ok']==0){
					$this->error = $ret['error'];
					return false;
				}else{
					$data['url'] = C('IMG_HOST').$ret['images'][1];
					//获取图片修改前的url地址
					$url = $imgfina->where('id='.$id)->getField('url');
					//删除原图
					unlink('.'.$url);
				}
			}

			//更新修改时间
			$data['updated_time'] = time();

			$res = $imgfina->where('id='.$id)->save($data);
			if($res){	
				$this->success('修改成功',U('Financing/listImgFina',array('fid'=>$data['fid'],'fname'=>$fname,'p'=>$nowPage)));
			}else{
				$this->success('修改失败',U('Financing/listImgFina',array('fid'=>$data['fid'],'fname'=>$fname,'p'=>$nowPage)));
			}
		}else{
			$this->error('提交的数据不合法');
		}
	}

	/**
	 * 删除融资相册
	 */
	public function delImgFina(){
		$imgfina = M('FinanceImage');
		$this->_deleteImage($imgfina);
	}
	
	/**
	 * 洽谈列表
	 */
	public function listChatFina(){
		$chat = M('financeChat');
		$info = I('get.');
		//接收搜索表单传过来名称
		$name = empty($info['name']) ? '' : $info['name'];

		//构造查询条件
		if(!empty($name)){
			$map['name'] = array('like','%'.$name.'%');
		}
		$map['finance_id'] = array('eq',$info['fid']);

		//洽谈总数量
		$count = $chat->where($map)->count();
		//接收分页的的参数,如果没有默认为1
		$p= I('p');
		$nowPage = empty($p) ? C('PAGE_DEFAULT'):$p;
		$Page = new \Think\Page($count,C('PAGE_SIZE'));
		$show = $Page->show();

		$list = $chat->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
		
		$this->assign('list',$list);
		$this->assign('page',$show);
		$this->assign('nowPage',$nowPage);
		$this->assign('name',$name);
		$this->assign('fname',$info['fname']);
		$this->assign('fid',$info['fid']);
		$this->display();
	}

	/**
	 * 添加洽谈信息
	 */
	public function addChatFina(){
		$info = I('get.');
		$this->assign('info',$info);
		$this->display();
	}

	/**
	 * 保存洽谈信息
	 */
	public function saveChatFina(){
		$data = I('info');
		$fname = I('fname');
		$chat = M('financeChat');

		//预约时间洽谈时间转为时间戳
		if(!empty($data['appointment'])){
			$data['appointment'] = strtotime($data['appointment']);
		}else{
			$data['appointment'] = time();
		}
		if(!empty($data['chat_time'])){
			$data['chat_time'] = strtotime($data['chat_time']);
		}else{
			$data['chat_time'] = time();
		}

		//创建时间
		$data['created_time'] = time();
		
		if($chat->add($data)){
			$this->success('添加成功',U('Financing/listChatFina',array('fid'=>$data['finance_id'],'fname'=>$fname)));
		}else{
			$this->error('添加失败',U('Financing/listChatFina',array('fid'=>$data['finance_id'],'fname'=>$fname)));
		}
	}

	/**
	 * 修改洽谈信息
	 */
	public function editChatFina(){
		$info = I('get.');
		$chat = M('financeChat')->where('id='.$info['chatId'])->find();
		$this->assign('info',$info);
		$this->assign('chat',$chat);
		$this->display();
	}

	/**
	 * 保存修改洽谈信息
	 */
	public function updateChatFina(){
		$chat = M('financeChat');
		$data = I('info');
		$nowPage = I('p');
		$fname = I('fname');
		$chatId = I('chatId');

		//预约时间洽谈时间转为时间戳
		if(!empty($data['appointment'])){
			$data['appointment'] = strtotime($data['appointment']);
		}
		if(!empty($data['chat_time'])){
			$data['chat_time'] = strtotime($data['chat_time']);
		}

		if($chat->where('id='.$chatId)->save($data)){
			$this->success('修改成功',U('Financing/listChatFina',array('fid'=>$data['finance_id'],'fname'=>$fname)));
		}else{
			$this->error('修改失败',U('Financing/listChatFina',array('fid'=>$data['finance_id'],'fname'=>$fname)));
		}
	}

	/**
	 * 删除洽谈信息
	 */
	public function deleteChatFina(){
		$financeChat = M('financeChat');
		$data['status'] = C('DELETE_STATUS');
		$id = I('id');
		$this->_deleteStart($id,$data,$financeChat);
	}

  

	/**
	 * 开启洽谈信息
	 */
	public function startChatFina(){
		$id = I('id');
		$financeChat = M('financeChat');
		$data['status'] = C('NORMAL_STATUS');
		$this->_deleteStart($id,$data,$financeChat);
	}

		/**
	 * 删除和启用的公共方法
	 */
	public function _deleteStart($id,$data,$project){
		if($project->where('id='.$id)->save($data)){
			$result['fina'] = 1;
		}else{
			$result['fina'] = 0;
		}
		echo json_encode($result);
	}

	/**
	 * 洽谈相册列表
	 */
	public function listChatImage(){
		$chatImage = M('financeChatImage');
		$info = I('get.');
		
		$count = $chatImage->where('chat_id='.$info['chatId'])->count();
		$p = I('p');
		$nowPage = empty($p) ? C('PAGE_DEFAULT'):$p;
		$page = new \Think\Page($count,C('PAGE_SIZE'));
		$show = $page->show();
		$chatImageList = $chatImage->where('chat_id='.$info['chatId'])->limit($page->firstRow.','.$page->listRows)->select();
		
		$this->assign('chatImageList',$chatImageList);
		$this->assign('page',$show);
		$this->assign('info',$info);
		$this->display();
	}

	/**
	 * 添加洽谈图片
	 */
	public function saveChatImage(){
		if(IS_POST){
			$fid = I('fid');
			$fname = I('fname');
			$name = I('name');
			$data = I('post.info');

			//上传图片
			$images = upload('url',C('FINANCE_IMAGE'));	
			
			if(!$images){
				$this->error($images['error']);
			}else{
				//插入数据表
				$chatImage = M('financeChatImage');
				foreach($images['images'] as $k=>$v){
					$imagesdata[$k] = $data;
					$imagesdata[$k]['url'] = C('IMG_HOST').$v;
				}

				$res = $chatImage->addAll($imagesdata);
				if($res){
					$this->success('添加成功',U('Financing/listChatImage',array('fid'=>$fid,'fname'=>$fname,'name'=>$name,'chatId'=>$data['chat_id'])));
				}else{
					$this->success('添加失败',U('Financing/listChatImage',array('fid'=>$fid,'fname'=>$fname,'name'=>$name,'chatId'=>$data['chat_id'])));
				}
			}	
		}else{
			$this->error('提交的数据不合法');
		}	
	}

	/**
	 * 删除洽谈图片
	 */
	public function deleteChatImage(){
		$chatImage = M('financeChatImage');
		$this->_deleteImage($chatImage);
	}

	/**
	 * 删除相册的公共方法
	 */
	public function _deleteImage($project){
		$id = I('id');
	    $url = I('url');
		$where['id'] = array('in',$id);
		if($project->where($where)->delete()){
			//删除图片
			if(!empty($url)){
				if(strpos($url,',')){
					$arr = explode(',',$url);
					foreach($arr as $k=>$v){
						unlink($v);
					}
				}else{
					unlink($url);
				}
			}
			$result['img'] = 1;
		}else{
			$result['img'] = 0;
		}
		echo json_encode($result);
	}
         /*
         * 91乐融留言列表
         * return void();
         */
        public function messageList(){
            $mobile = I('mobile');
            $status = I('status');
            if(!empty($mobile)){
                $where['mobile'] = array('like',"%".$mobile."%");
            }
            if(!empty($status)){
                $where['status'] = I('status');
            }
            
            $finanMessageModel = M('FinanceMessage');
            $count = $finanMessageModel->where($where)->count();
            $page = new \Think\Page($count,C('PAGE_SIZE'));
            $show = $page->show();
            $list = $finanMessageModel->order('id DESC')->where($where)->limit($page->firstRow.','.$page->listRows)->select();
            $num = count($list);
            for($i=0;$i<$num;$i++){
                $list[$i]['ip'] = long2ip($list[$i]['ip']);
            }
            $this->assign('flow_man', $this->getBusinessMen());//商务跟踪人
            $this->assign('page',$show);
            $this->assign('list',$list);
            
            $this->display();
        }
        /*
         * 编辑乐融留言部分信息
         * return string(json);
         */
        public function messageEdit(){
            $result = array('flag'=>0,'msg'=>'操作失败！');
            $id = I('post.id');
            $act = I('post.act');
            if(!empty($id)){
                $financeMessageModel = M('FinanceMessage');
                if($act == 'get'){
                    $data = $financeMessageModel->field('id,name,status,remark,flow_man')->where('id ='.$id)->find();
                    if(!empty($data['flow_man'])){
                        $flow_man = M('Admin')->field('id,nickname')->where('id ='.$data['flow_man'])->find();
                        $data['flow_man'] = $flow_man;
                    }
                    if(!empty($data)){
                        $result = array('flag'=>1,'data'=>$data);
                    }
                }else if($act == 'post'){
                    $data = I('post.');
                    //$res = $financeMessageModel->save($data);
                    if($financeMessageModel->save($data)){
                        $result = array('flag'=>1,'msg'=>'操作成功！');
                    }
                }
            }
            echo json_encode($result);
        }
        /*
         * 编辑留言状态
         * return string(json);
         */
        public function messageEditStatus(){
            $result = array('flag'=>0,'msg'=>'操作失败');
            $data = I('post.');
            if(!empty($data)){
                if(M('FinanceMessage')->save($data)){
                   $result = array('flag'=>1,'msg'=>'操作成功！'); 
                }
            }
            echo json_encode($result);
        }


}


