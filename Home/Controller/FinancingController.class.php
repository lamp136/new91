<?php 
namespace Home\Controller;
use Home\Controller\BaseController;
use Common\Extend\SendMsg;

/**
 * 融资信息控制器
 * 包括首页,列表,详情页
 */
 class FinancingController extends BaseController{
 	/**
 	 * 首页
 	 */
 	public function index(){
 		$finaModel = D('Finance');
 		//最新发布的项目
 		$newFina = $finaModel->where('status=1 and deal_type=2 and recommend=2')->order('updated_time desc')->find();

 		//找项目
 		$findPro = $finaModel->where('status=1 and deal_type=2 and recommend=1')->order('updated_time desc')->limit('4')->select();
 		
 		$this->assign('findPro',$findPro);
 		$this->assign('newFina',$newFina);
 		$this->display();
 	}

 	/**
 	 * 详情页
 	 */
 	public function details(){
 		$id = I('get.id');
 		$finaModel = D('Finance');
 		$finance = $finaModel->relation('Imgs')->where('id='.$id)->find();
        
 		//景观推荐图片
 		$landImg = M('FinanceImage')->where("recommends=1 and type='1' and finance_id='".$id."'")->order('updated_time desc')->find();
 		//资质推荐图片
 		$qualImg = M('FinanceImage')->where("recommends=1 and type='2' and finance_id='".$id."'")->order('updated_time desc')->find();
 		//合同推荐图片
 		$contractImg = M('FinanceImage')->where("recommends=1 and type='0' and finance_id='".$id."'")->order('updated_time desc')->find();


 		//浏览量
 		M('Finance')->where('id='.$id)->setInc('page_view',1);

 		$this->assign('landImg',$landImg);
 		$this->assign('qualImg',$qualImg);
 		$this->assign('contractImg',$contractImg);
 		$this->assign('finance',$finance);
 		$this->display();
 	}

 	/**
 	 * 列表页
 	 */
 	public function lists(){
 		$finance = M('finance');
 		//找项目列表
		$regionId = I('get.regionId');
		$finaType = I('get.finaType');
		$money = I('get.money');
		//获取省
		$province = M('region')->where('level=1')->field('region_name,region_id')->select();
        //获取融资金额
        $financeMoney = M('category')->where("pid='".C('CATEGORY_FINANCE_MONEY')."'")->field('name')->select();
 		
        if(!empty($regionId)){
			$map['province_id'] = array('eq',$regionId);
		}
		if(!empty($finaType)){
			$map['finance_type'] = array('eq',$finaType);
		}
        $map['deal_type'] = array('eq',2);

		//对融资金额拆分数组然后判断
		if(!empty($money)){
            if(strpos($money,'-')){
                $moneyArr = explode('-',$money);
                $map['_string'] = "appraisal>=".$moneyArr['0']." AND appraisal<".$moneyArr['1'];
            }else{
                $map['_string'] = "appraisal>=".$money;
            }
            
		}

		//项目总数量
		$count = $finance->where($map)->count();
		//接收分页的的参数,如果没有默认为1
		$p= I('p');
		$nowPage = empty($p) ? C('PAGE_DEFAULT'):$p;
		$Page = new \Think\Page($count,10);
		$show = $Page->show();

		//分页数据查询
		$list = $finance->where($map)->limit($Page->firstRow.','.$Page->listRows)->select(); 

		$this->assign('list',$list);
		$this->assign('page',$show);
		$this->assign('regionId',$regionId);
        $this->assign('money',$money);
		$this->assign('finaType',$finaType);
		$this->assign('province',$province);
        $this->assign('financeMoney',$financeMoney);
 		$this->display();
 	}

 	/**
 	 * 发送短信获取验证码
 	 */
 	public function sendCode(){
 		if(IS_POST){
 		 	$mobile = I('mobile');
            header("Content-Type:text/html; charset=utf-8");
            if(preg_match('/^1[3|4|5|7|8][0-9]\d{8}$/',$mobile)){
                //判断发送验证码的次数是否超过了每个人每天限制的次数
                $messageCode = D('MsgCode');
                $isMaxSendNum = $messageCode->isMaxSendNum($mobile);
                if($isMaxSendNum){
                    $result = array('flag'=>0, 'msg'=>"请不要恶意点击");
                }else{
                    $mobile_code = rand(100000,999999);
                    $message = "动态验证码 " . $mobile_code . " 工作人员不会向你索要，请勿向任何人泄露。" . date("Y-m-d H:i:s", time()) . "【91乐融】";
                    $sendMsg = new SendMsg();
                    $ret = $sendMsg->sendMsg($mobile,$message);
                    if ($ret) {
                        //将发送的短信写入短信记录中
                        $msglogData['classify'] = C('MSG_LOG_FINACE');
                        $msglogData['mobile'] = $mobile;
                        $msglogData['msg'] = $message;
                        $msglogData['status'] = C('MSG_SEND_STATUS');
                        $msglogData['created_time'] = time();
                        $msglogData['send_time'] = time();
                        $msglogModel = M('MsgLog');
                        $msglogModel->create($msglogData);
                        $msglogModel->add();

                        $msgcodedata['mobile'] = $mobile;
                        $msgcodedata['code'] = $mobile_code;
                        $msgcodedata['type'] = C('MSGCODE_TYPE.FINANCE');
                        $msgcodedata['created_time'] = time();
                        if($messageCode->create($msgcodedata) && $messageCode->add()){
                            $result = array('flag'=>1, 'msg'=>"发送成功");
                        }
                    } else {
                        $result = array('flag'=>0, 'msg'=>"验证码发送失败");
                    }
                }
            } else {
                $result = array('flag'=>0, 'msg'=>"手机格式不正确,请认真填写");
            }
            echo json_encode($result);
        }
 	}

 	/**
 	 * 发送短信到手机
 	 */
 	public function sendMessage(){
 		if(IS_POST){
 			header("Content-Type:text/html; charset=utf-8");
 			$mobile = I('post.mobile');
 			$code = I('post.code');
 			$type = C('MSGCODE_TYPE.FINANCE');
 			$proName = I('post.proName');
 			$tel = I('post.tel');
 			$contracts = I('post.contracts'); 

 			//验证动态码是否有效
 			$MsgCodeModel = D('MsgCode');
 			$res = $MsgCodeModel->checkMessageCode($type,$mobile,$code);
 			if($res){
 				//有效发送信息
                $message = "您所关注的项目是:". $proName ."　项目联系人是:". $contracts ."　联系人电话:". $tel ."【91乐融】";
                $sendMsg = new SendMsg();
                $ret = $sendMsg->sendMsg($mobile,$message);

 				$result['flage'] = '1';
 			}else{
 				$result['flage'] = '0';
 			}
 			echo json_encode($result);
 		}
 	}


}