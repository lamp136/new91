<?php
namespace Admin\Controller;
use Admin\Controller\BaseController;
use Think\Page;
use Think\Model;

/**
 * 平台会员类主要是指：客户通过前台，后台，微信，wap站等渠道
 * 注册的会员
 *
 * @author hgy
 */
class MemberController extends BaseController
{
	/**
	 * 会员列表页
	 *
	 * @return void
	 */
	public function index() {
		$where = array();
		$mobile = I('get.mobile');
		if(!empty($mobile)){
			$where['mobile|name'] = array('like','%'.$mobile.'%');
		}
		$count = D('Member')->where($where)->count();
		$page = new Page($count, C('PAGE_SIZE'));
		$pageShow = $page->show();
		$members = D('Member')->relation('MebmerBank')->where($where)->limit($page->firstRow, $page->listRows)->order('id desc')->select();

		$this->assign('pages', $pageShow);
		$this->assign('members', $members);
		$this->display();
	}
	/**
	 * 删除会员，主要是指更改数据状态
	 *
	 * @return Json String
	 */
	public function delete() {
		if(IS_POST){
			$postInfo = I('post.');
			$memberModel = M('member');
			$result = array('flag'=>0,'msg'=>'操作失败');
			if($postInfo['act']=='del'){
				$data['id'] = $postInfo['id'];
				$data['status'] = C('DELETE_STATUS');
				if($memberModel->create($data) && $memberModel->save()){
					$result['flag'] = 1;
					$result['msg'] = '操作成功';
				}
			}else if($postInfo['act']=='enable'){
				$data['id'] = $postInfo['id'];
				$data['status'] = C('NORMAL_STATUS');
				if($memberModel->create($data) && $memberModel->save()){
					$result['flag'] = 1;
					$result['msg'] = '操作成功';
				}
			}
			echo json_encode($result);
		}
	}


	/**
	 * 查看旗下会员
	 * @param  以$c开头的 为客户信息
	 */
	public function lookmember(){
		$id = I('post.member_id');//推广人ID
		$relation = M('OthersMemberRelation');
		$c_info = $relation->where('sender_id='.$id)->select();//查询出客户
		foreach ($c_info as $key => $value) {
			if($value['created_time']){

				$c_info[$key]['created_time'] = date('Y-m-d',$value['created_time']);
			}
		}
		if($c_info){
			$result['data'] = $c_info;
			$result['flag'] = 1;
		}else{
			$result['flag'] = 0;
		}
		echo json_encode($result);

	}


	/**
	 * 结算页面
	 */
	public function clearmoney(){
		$id = I('get.id');

		$relation = M('OthersMemberRelation');
		$where['send_id'] = $id;
		$where['customer_status'] = C('DEFAULT_STATUS');
		$c_info = D('OthersMemberRelation')->relation('Info')->where($where)->select();//查询出客户
		foreach ($c_info as $key => $value) {
			if($value['created_time']){

				$c_info[$key]['created_time'] = date('Y-m-d',$value['created_time']);
			}
			if($c_info){
			    $result = $c_info;
		    }
		}
		$count = D('OthersMemberRelation')->relation('Info')->where($where)->count();
		$page = new Page($count, C('PAGE_SIZE'));
		$pageShow = $page->show();
		$this->assign('info',$result);
		$this->assign('page', $pageShow);
		
		$this->display();
	}

	/**
	 * 未结算页面结算按钮
	 * @return [bool] [返回值为1,结算成功]
	 */
	public function confirmsettle(){
		$arrid = I('post.str');
		$sender_id = I('post.sender_id');
		$where['member_id'] = array('in',$arrid);
		$relation = M('OthersMemberRelation');
		$info['customer_status'] = C('NORMAL_STATUS');
		$relation->create($info);
		$final = $relation->where($where)->save();//将客户结算标识转为已结算

		$count = count(explode(',',$arrid));
		$condition['last_captial_num'] = C('CMONEY_OF_SENDER.COSTOMER')*$count;
		$condition['capital_settlement_time'] = time();
		$condition['capital_settlement_status'] = C('NORMAL_STATUS');
		$condition['updated_time'] = time();
		$relation->create($condition);
		$finally = $relation->where('member_id='.$sender_id)->save();

		if($finally && $final){
			$result['flag'] =1;
		}
		echo json_encode($result);


	}


	/**
	 * 推广人员列表
	 */
	public function senderList(){
		$mobile = I('get.mobile');
		if(!empty($mobile)){
			$where['mobile|name'] = array('like','%'.$mobile.'%');
		}
		$where['member_type'] = C('FROM_TYPE_WORKER');
		$count = D('Member')->where($where)->count();
		$page = new Page($count, C('PAGE_SIZE'));
		$pageShow = $page->show();
		$members = D('Member')->where($where)->relation('Relation')->select();
		foreach ($members as $key => $value) {
			if($value['capital_settlement_time']){

				$members[$key]['capital_settlement_time'] = date('Y-m-d',$value['capital_settlement_time']);
			}
			if($members){
			    $result = $members;
		    }
		}
		$this->members = $result;
		$this->assign('pages', $pageShow);

		$this->display();
	}

	/**
	 * 设置为陵园推广人
	 */
	public function sender(){
		$memberId = I('post.member_id');
		$data['member_type'] = C('FROM_TYPE_WORKER');
		$member = M('Member');
		$member->create($data);
		$info = $member->where('id='.$memberId)->save();
		if($info){
			$result['flag'] = 1;
		}

		echo json_encode($result);
	}

	/**
	 * 取消陵园推广人资格
	 */
	public function delsender(){
		$memberId = I('post.member_id');
		$data['member_type'] = C('NORMAL_STATUS');
		$member = M('Member');
		$member->create($data);
		$info = $member->where('id='.$memberId)->save();
		if($info){
			$result['flag'] = 1;
		}

		echo json_encode($result);
	}

	/**
	 * 用户密码重置
	 * 重置密码是六位数
	 *
	 * @return Json String
	 */
	public function resetpwd(){
		if(IS_POST){
			$result = array('flag'=>0,'msg'=>'操作失败');
			$id = I('post.id');
			if(!empty($id)){
				//查找当前用户的信息
				$memberModel = M('member');
				$member = $memberModel->where('id='.$id)->find();
				if(!empty($member)){
					//$mobile = $member['mobile'];
					$pwd = rand(100000, 999999);
					$encryptpwd= encryptHome($pwd);
					if($memberModel->where('id='.$id)->setField('password',$encryptpwd)!==false){
						$result['flag']=1;
						$result['msg'] = '重置成功,用户密码为：'.$pwd;
					}
				}else{
					$result['msg'] = '没有该数据';
				}
			}
			echo json_encode($result);
		}
	}
	/**
	 * 获取特定用户的所有银行卡信息
	 * 银行卡信息直接删除即可，不存在状态问题
	 *
	 * @return Json String
	 */
	public function memberBankList() {
		if (IS_POST) {
			$memberId = I('post.member_id');
			$result = array(
					'flag' => 0,
					'data' => array()
			);

			if ($memberId) {
				$bankWhere['member_id'] = $memberId;
				$bankInfo = M('member_bank')->where($bankWhere)->select();
				foreach ($bankInfo as $key => $value) {
					$bankInfo[$key]['bank_name'] = C('PAY_TYPE.'.$value['bank']);
				}
				if ($bankInfo) {
					$result['flag'] = 1;
					$result['data'] = $bankInfo;
				}
			}

			echo json_encode($result);
		}
	}
	/**
	 * 新增或者修改客户银行卡信息
	 *
	 * @return Json String
	 */
	public function editMemberBank() {
		if(IS_POST){
			$postData = I('post.');
			$result = array(
				'flag' => 0,
				'msg' => "数据操作失败"
			);
			$postData['admin_id'] = session('admin_id');
			$postData['created_time'] = date('Y-m-d H:i:s', time());
			$postData['ip'] =  ip2long(get_client_ip(0, true));
			if (empty($postData['id'])) {
				unset($postData['id']);
				$ret =  M('member_bank')->add($postData);
			} else {
				$ret =  M('member_bank')->save($postData);
			}
			if ($ret != false) {
				$result['flag'] = 1;
				$result['msg'] = "数据操作成功";
			}

			echo json_encode($result);
		} else {
			echo "zhl";die;
		}
	}
	/**
	 * 删除用户的银行卡信息
	 *
	 * @return Json String
	 */
	public function deleteMemberBank() {
		if (IS_POST) {
			$id = I('post.id');
			$result = array(
					'flag' =>0,
					'msg' => '删除失败'
			);

			if ($id) {
				$ret = M('member_bank')->delete($id);
				if ($ret) {
					$result['flag'] = 1;
					$result['msg'] = '删除成功';
				}
			}

			echo json_encode($result);
		}
	}

	/**
	 * 生成随机不重复的5位数（客户优惠劵码）
	 * @param [int] $[begin] [数字开始]
	 * @param [int] $[end] [数字结束]
	 * @param [int] $[num] [数字位数]
	 * @param [int] $[type] [优惠劵类型--主要标明哪次活动]
	 */
	public function coupon_customer($begin,$end,$num,$type){
		$numbers = range ($begin,$end); 
		//shuffle 将数组顺序随即打乱 
		shuffle ($numbers); 
		//array_slice 取该数组中的某一段 
		$result = array_slice($numbers,$begin,$num); 
		//将数组中的值存入数据表
		foreach ($result as $k => $v) {
			$coupon_num[$k] = $v;
		}


	}


}

