<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;
use Think\Model;
use Think\Page;
/**
 * 推广控制器
 */
class OpexController extends BaseController
{
	/**
	 * 资金注入记录
	 */
	public function inject(){
        $injectModel = M('inject');
        $count = $injectModel->count();
        $page = new Page($count,C('PAGE_SIZE'));
        $show = $page->show();

        $list = $injectModel->limit($page->firstRow,$page->listRows)->order('id desc')->select();

        //获取审批人
        $this->assign('approver',$this->getBusinessMen());
        //资金用途分类
        $this->assign('moneyUser',$this->getCategoryData(array('pid'=>C('MONEY_USER_CATEGORY_ID')),array('cid,name'),'',true));
        $this->page = $show;
        $this->list = $list;
        $this->display();
	}

	/**
	 * 添加资金注入记录
	 */
	public function addInject(){
        if(IS_POST){
            $addModel = M('inject');
            $postInfo = I('post.');

            $model = new Model();
            $model->startTrans();
            $postInfo['investment_time'] = strtotime($postInfo['investment_time']);
            $postInfo['apply_time'] = strtotime($postInfo['apply_time']);
            $postInfo['created_time'] = time();
            $postInfo['proposer_id'] = session('admin_id');
            $adminWhere['id'] = array('in',array($postInfo['proposer_id'],$postInfo['approver_id']));
            $adminName = M('admin')->where($adminWhere)->getField('id,nickname');
            $postInfo['proposer'] = $adminName[$postInfo['proposer_id']];
            $postInfo['approver'] = $adminName[$postInfo['approver_id']];

           
            //修改上一条数据的status
            if($postInfo['lastId']){
                $data['status'] = C('DELETE_STATUS');
                $injectObj = $addModel->add($postInfo);
                $beforeInject = $addModel->where('category_id='.$postInfo['category_id'].' and status=1 and id='.$postInfo['lastId'])->save($data);
                if($injectObj && $beforeInject){
                    $model->commit();
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功';
                }else{
                    $model->rollback();
                    $result['flag'] = 0;
                    $result['msg'] = '操作失败';
                }
            }else{
                $injectObj = $addModel->add($postInfo);
                if($injectObj){
                    $model->commit();
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功';
                }else{
                    $model->rollback();
                    $result['flag'] = 0;
                    $result['msg'] = '操作失败';
                }
            }
            echo json_encode($result);
        }
	}

    /**
     * 通过用途分类获取上期余额
     */
    public function oldMoney(){
        $category_id = I('category_id');
        
        //查询最后一次注入的记录
        $injectObj = M('inject')->where('category_id='.$category_id.' and status=1')->order('id desc')->field('category_id,id,total_amount')->find();
        if($injectObj){
            //计算总支出
            $countCost = M('disburse')->where('inject_id='.$injectObj['id'].' and status=1 and category_id='.$injectObj['category_id'])->sum('consume');

            //上期结余
            $result['oldBance'] = round($injectObj['total_amount']-$countCost,2);
            $result['lastId'] = $injectObj['id'];
        }else{
            $result['oldBance'] = '0';
        }
        echo json_encode($result);
    }

	/**
	 * 添加支出记录
	 */
	public function addDisburse(){
		$addModel = M('disburse');
		$postInfo = I('post.');
		$postInfo['start_time'] = strtotime($postInfo['start_time']);
		$postInfo['end_time'] = strtotime($postInfo['end_time']);
		$postInfo['admin_id'] = session('admin_id');

        $injectId = M('inject')->where('status=1 and category_id='.$postInfo['category_id'])->order('id desc')->field('id')->find();
        $postInfo['inject_id'] = $injectId['id'];
		$this->_add($addModel,$postInfo);
	}

	private function _add($table,$data){
            $result = array('flag'=>0,'msg'=>'操作失败！');
		if($table->create($data) && $table->add()){
			$result['flag'] = 1;
			$result['msg'] = '操作成功';
		}
		echo json_encode($result);
	}

    /**
     * 编辑注入记录
     */
	public function editInject(){
        $injectModel = M('inject');
        if(IS_POST){
            $postData = I('post.');
            $nickName = M('admin')->where('id = '.$postData['approver_id'])->field('nickname')->find();
            $postData['approver'] = $nickName['nickname']; 
            $postData['investment_time'] = strtotime($postData['investment_time']);
            $postData['apply_time'] = strtotime($postData['apply_time']);
            $postData['update_time'] = time();
            $result = array('flag'=>0,'msg'=>'操作失败');
            if($injectModel->create($postData) && $injectModel->save()){
                $result['flag'] = 1;
                $result['msg'] = '操作成功';
            }
            echo json_encode($result);
        }else if(IS_GET){
            $getInfo = I('get.');
            $id = $getInfo['id'];
            $result = array('flag'=>0,'data'=>array());
            if(!empty($id)){
                $data = $injectModel->find($id);
                $data['investment_time'] = date('Y-m-d',$data['investment_time']);
                $data['apply_time'] =  date('Y-m-d',$data['apply_time']);
                if(!empty($data)){
                    $result['flag'] = 1;
                    $result['data'] = $data;
                }
            }
            echo json_encode($result);
        }
    }

	/**
	 * 编辑支出记录
	 */
	public function editDisbures(){
        $disburse = M('disburse');
        if(IS_POST){
        	$postData = I('post.');
        	$postData['start_time'] = strtotime($postData['start_time']);
        	$postData['end_time'] = strtotime($postData['end_time']);
        	$postData['admin_id'] = session('admin_id');
            $result = array('flag'=>0,'msg'=>'操作失败');
            if($disburse->create($postData) && $disburse->save()){
                $result['flag'] = 1;
                $result['msg'] = '操作成功';
            }
            echo json_encode($result);
        }else if(IS_GET){
        	$getInfo = I('get.');
        	$id = $getInfo['id'];
            $result = array('flag'=>0,'data'=>array());
            if(!empty($id)){
                $data = $disburse->find($id);
                $data['start_time'] = date('Y-m-d',$data['start_time']);
                $data['end_time'] =  date('Y-m-d',$data['end_time']);
                if(!empty($data)){
                    $result['flag'] = 1;
                    $result['data'] = $data;
                }
            }
            echo json_encode($result);
        }
    }

	/**
	 * 推广支出
	 */
	public function disburse(){
		$disburse = M('disburse');
		$fields = 'id,start_time,end_time,province_id,keyword,consume,status,hit,show,click_rate,average_click_price,category_id,reservation,cost,deal';
		$regionWhere['level'] = 1;
		$region = $this->getRegionData($regionWhere,array('region_id,region_name'),'',true);
        $this->assign('moneyUser',$this->getCategoryData(array('pid'=>C('MONEY_USER_CATEGORY_ID')),array('cid,name'),'',true));
		$this->region = $region;
		$this->_list($disburse,$fields);
	}



	private function _list($table,$fields){
        //时间段过滤
        $where = array();
        $start_time = I('get.start_time');
        $end_time = I('get.end_time');
        $province_id = I('get.province_id');
        //排序规则
        $type = I('get.type');
        $info =I('get.order'); 
        if($type &&  $info){
            $order = $type.' '.$info;
        }else{
            $order = 'start_time desc';
        }

        if(!empty($start_time) && empty($end_time)){
            $where['start_time'] = array('egt',strtotime($start_time));
        }
        if(!empty($end_time) && empty($start_time)){
            $where['end_time'] = array('elt',strtotime($end_time.' 23:59:59'));
        }
        if(!empty($start_time) && !empty($end_time)){
            $where['start_time'] = array('egt',strtotime($start_time));
            $where['end_time'] = array('elt',strtotime($end_time.' 23:59:59'));
        }
        if(!empty($province_id)){
            $where['province_id'] = $province_id;
        }

		$count = $table->where($where)->count();
		$page = new Page($count,C('PAGE_SIZE'));
		$show = $page->show();
		$list = $table->field($fields)->where($where)->limit($page->firstRow,$page->listRows)->order($order)->select();
        //把点击率转换百分比
        foreach ($list as $key => $value) {
            $list[$key]['click_rate'] = ($value['click_rate'] * 100).'%';
        }
		$this->page = $show;
		$this->list = $list;
		$this->display();
	}


    /**
     * 删除推广支出
     */
    public function delDisburse(){
		$disburseModel = M('disburse');
		$this->_delete($disburseModel);
    }

    private function _delete($table){
    	if(IS_POST){
            $postInfo = I('post.');
            $result = array('flag'=>0,'msg'=>'操作失败');
            if($postInfo['act']=='del'){
                $data['id'] = $postInfo['id'];
                $data['status'] = C('DELETE_STATUS');
                // 状态改为-1
                if($table->create($data) && $table->save()){
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功';
                }
            }else if($postInfo['act']=='enable'){
                $data['id'] = $postInfo['id'];
                $data['status'] = C('NORMAL_STATUS');
                // 状态改为1
                if($table->create($data) && $table->save()){
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功';
                }
            }else if($postInfo['act'] == 'delAll'){
            	if($table->where('1=1')->delete()){
            		$result['flag'] = 1;
            		$result['msg'] = '操作成功';
            	}
            }
            echo json_encode($result);
        }
    }

    /**
     * 获取订单预约量和成交量
     */
    public function getOrderNum(){
        $start_time = I('start_time');
        $end_time = I('end_time');
        $region = I('region');
        $arr = $this->_getNumber($start_time,$end_time,$region);
        $result['success'] = $arr['success'];
        $result['default'] = $arr['default'];
        echo json_encode($result);
    }

    /**
     * 获取订单预约量和成交量的公共方法
     */
    public function _getNumber($start_time,$end_time,$province_id){
        if(!empty($start_time) && !empty($end_time)){
            $where['created_time'] = array('BETWEEN',array(strtotime($start_time),strtotime($end_time.' 23:59:59')));
        }
        if(!empty($province_id)){
            $where['province_id'] = array('eq',$province_id);
        }
        $status = array(C('ORDER_STATUS.DEFAULT'),C('ORDER_STATUS.SUCCESS'));
        $where['status'] = array('in',$status);
       
        $order = M('orderGrave');
        $data = $order->where($where)->field('province_id,status')->select();

        $success = 0;
        $default = 0;
        if($data){
            foreach ($data as $key => $value) {
                if($value['status']==10){
                    $success += 1;
                }else if($value['status']==0){
                    $default += 1;
                }
            }
        }
        return array('success'=>$success,'default'=>$default);
    }

	/**
	 * 导入数据
	 */
	public function importDisburse(){
		$imgPath = C('ROOT_PATH').C('OPEX_EXCEL').'/'; // 设置附件上传根目录
        $upload           = new \Think\Upload();// 实例化上传类
        $upload->maxSize  = 3145728 ;// 设置附件上传大小
        $upload->exts     = array('xls', 'xlsx');// 设置附件上传类型
        $upload->rootPath =  $imgPath;
        $upload->saveName = array('date','YmdHis');
        $upload->autoSub  = true;
        if($_FILES['excel_file']['error'] == 0 && !empty($_FILES['excel_file']['tmp_name'])){
            $info   =   $upload->uploadOne($_FILES['excel_file']);
        }
        if(!$info){
            $result['flag'] = 0;
            $result['msg'] = '请上传正确的文件';
            echo json_encode($result);die;
        }
        $fileName = $imgPath.$info['savepath'].$info['savename'];

        vendor('PHPExcel.PHPExcel');
        vendor('PHPExcel.PHPExcel.IOFactory');
        vendor('PHPExcel.PHPExcel.Reader.Excel5');// Excel5:xls;Excel2007:xlsx;
        vendor('PHPExcel.PHPExcel.Reader.Excel2007');
        if($info['ext']=='xls'){
            $objReader     = \PHPExcel_IOFactory::createReader('Excel5');
        }elseif($info['ext']=='xlsx'){
            $objReader     = \PHPExcel_IOFactory::createReader('Excel2007');
        }
		$objPHPExcel   = $objReader->load($fileName);
		$sheet         = $objPHPExcel->getSheet(0);
		$highestRow    = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();

        for ($i=9; $i < $highestRow+1; $i++) {
			// 时间
			$time                = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
			// 省
			$province              = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
			// 消费
			$consume             = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getValue();
			// 展现
			$show                = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getValue();
			// 点击
			$hit                 = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getValue();
			// 点击率
			$click_rate          = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getValue();
			// 平均点击价格
			$average_click_price = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getValue();
			// 转换时间
			$cutime = explode('至', $time);
			$start_time = strtotime($cutime[0]);
			$end_time = strtotime($cutime[1]);
			// 获取省份
			$where['region_name'] = array('in',"$province");
			$region = M('region')->where($where)->field('region_id')->find();
			$province_id = $region['region_id'];
            //获取用途分类
            $category_id = I('category_id');
            //获取资金注入id
            $injectId = M('inject')->where('status=1 and category_id='.$category_id)->order('id desc')->field('id')->find();
            //获取预约量和成交量
            $arr = $this->_getNumber($cutime[0],$cutime[1],$province_id);
            //计算平均成本
            if($consume==0 || $arr['default']==0){
                $cost = 0;
            }else{
                $cost = round($consume / $arr['default'],2);
            }
	        $disburseTable = M('disburse');
	        $disburseTable->add(
	        	array(
                    'cost'                => $cost,
                    'reservation'         => $arr['default'],
                    'deal'                => $arr['success'],
                    'inject_id'           => $injectId['id'],
                    'category_id'         => $category_id,
					'start_time'          => $start_time,
					'end_time'            => $end_time,
					'province_id'         => $province_id,
					'consume'             => $consume,
					'hit'                 => $hit,
					'show'              => $show,
					'click_rate'          => $click_rate,
					'average_click_price' => $average_click_price
	        	)
	        );
        }

        if($disburseTable){
        	$result['flag'] = 1;
            $result['msg'] = '执行成功';
        }else{
            $result['flag'] = 0;
            $result['msg'] = '执行失败';
        }
        echo json_encode($result);
	}
    
    /**
     * 导出数据
     */
    public function exportExcel(){
        $disburseInfo = M('disburse')->field('category_id,province_id,start_time,end_time,consume,hit,reservation,cost,show,click_rate,average_click_price,deal')->order('start_time asc')->select();
        // 引入PHPExcel
        vendor('PHPExcel.PHPExcel');

        $phpExcel = new \PHPExcel();

        $phpExcel->getProperties()->setCreator('hgy')
            ->setLastModifiedBy('hgy')
            ->setTitle('Office 2007 XLSX Test Document')
            ->setSubject('Office 2007 XLSX Test Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Test result file');

        // 设置行宽度
        $phpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5.43);
        $phpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(23.43);
        $phpExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7.29);
        $phpExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10.14);
        $phpExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7.71);
        $phpExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15.29);
        $phpExcel->getActiveSheet()->getColumnDimension('G')->setWidth(7.71);
        $phpExcel->getActiveSheet()->getColumnDimension('H')->setWidth(7.71);
        $phpExcel->getActiveSheet()->getColumnDimension('I')->setWidth(7.71);
        $phpExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10.14);
        $phpExcel->getActiveSheet()->getColumnDimension('K')->setWidth(7.71);

        // 设置行高度
        $phpExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(22);
        $phpExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);

        // 设置字体
        $styleArray = array(
            'font' => array(
                'bold' => true,
                // 'color' => array('rgb' => 'FF0000'),
                'size' => 15,
                'name' => 'Microsoft YaHei'
            )
        );

        $phpExcel->getActiveSheet()->getCell('A1')->setValue('Some text');
        $phpExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);

        $phpExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(11);
        $phpExcel->getActiveSheet()->getStyle('A2:K2')->getFont()->setBold(true);
        $phpExcel->getActiveSheet()->getStyle('A2:K2')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('A1:K2')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);

        // 设置水平居中
        $phpExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('G')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('H')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('I')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('J')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('K')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // 合并cell
        $phpExcel->getActiveSheet()->mergeCells('A1:K1');

        // 设置表格标题
        $phpExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','运营推广')
            ->setCellValue('A2','用途')
            ->setCellValue('B2','时间')
            ->setCellValue('C2','省份')
            ->setCellValue('D2','花费总额')
            ->setCellValue('E2','展现量')
            ->setCellValue('F2','平均点击价格')
            ->setCellValue('G2','点击量')
            ->setCellValue('H2','点击率')
            ->setCellValue('I2','预约量')
            ->setCellValue('J2','平均成本')
            ->setCellValue('K2','成交量');

        //获取全国地区
        $regionData = $this->getRegionData('',array('region_id,region_name'),'',true);
        //获取用途分类
        $category = $this->getCategoryData(array('pid'=>C('MONEY_USER_CATEGORY_ID')),array('cid,name'),'',true);
       
        for($i=0;$i<count($disburseInfo)-1;$i++){
            $phpExcel->getActiveSheet(0)->setCellValue('A'.($i+3),$category[$disburseInfo[$i]['category_id']]);
            $phpExcel->getActiveSheet(0)->setCellValue('B'.($i+3),date('Y-m-d',$disburseInfo[$i]['start_time']).'至'.date('Y-m-d',$disburseInfo[$i]['end_time']));
            $phpExcel->getActiveSheet(0)->setCellValue('C'.($i+3),$regionData[$disburseInfo[$i]['province_id']]);
            $phpExcel->getActiveSheet(0)->setCellValue('D'.($i+3),$disburseInfo[$i]['consume']);
            $phpExcel->getActiveSheet(0)->setCellValue('E'.($i+3),$disburseInfo[$i]['show']);
            $phpExcel->getActiveSheet(0)->setCellValue('F'.($i+3),$disburseInfo[$i]['hit']);
            $phpExcel->getActiveSheet(0)->setCellValue('G'.($i+3),$disburseInfo[$i]['click_rate']);
            $phpExcel->getActiveSheet(0)->setCellValue('H'.($i+3),$disburseInfo[$i]['average_click_price']);
            $phpExcel->getActiveSheet(0)->setCellValue('I'.($i+3),$disburseInfo[$i]['reservation']);
            $phpExcel->getActiveSheet(0)->setCellValue('J'.($i+3),$disburseInfo[$i]['cost']);
            $phpExcel->getActiveSheet(0)->setCellValue('K'.($i+3),$disburseInfo[$i]['deal']);
            $phpExcel->getActiveSheet()->getStyle('A'.($i+3).':K'.($i+3))->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $phpExcel->getActiveSheet()->getStyle('A'.($i+3).':K'.($i+3))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $phpExcel->getActiveSheet()->getRowDimension($i+3)->setRowHeight(16);
        }

        // sheet命名
        $phpExcel->getActiveSheet()->setTitle('运营推广');
        $phpExcel->setActiveSheetIndex(0);
        
        // excel头参数
        header('Content-Type: application/vnd.ms-excel'); // 生成xls/xlsx文件
        // header('Content-Type: text/csv'); // 生成csv文件

        header('Content-Disposition: attachment;filename="运营推广('.date('Y-m-d H_i_s').').xls"'); // 后缀名:xls/xlsx/csv

        header('Cache-Control: max-age=0');
        $phpWriter = \PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5'); // Excel5:xls; Excel2007:xlsx; CSV:csv;
        $phpWriter->save('php://output');
    }

    /**
     * 关键词转化跟踪
     */
    public function conversion(){
        $keywordsInfo = M('keywordsConversion');
        //时间段多虑
        $where = array();
        $start_time = I('get.start_time');
        $end_time = I('get.end_time');
        
        if(!empty($start_time) && empty($end_time)){
            $where['time'] = array('egt',strtotime($start_time));
        }
        if(!empty($end_time) && empty($start_time)){
            $where['time'] = array('elt',strtotime($end_time.' 23:59:59'));
        }
        if(!empty($start_time) && !empty($end_time)){
            $where['time'] = array('BETWEEN',array(strtotime($start_time),strtotime($end_time.' 23:59:59')));
        }
        $count = $keywordsInfo->where($where)->count();
        $page = new Page($count,C('PAGE_SIZE'));
        $show = $page->show();
        $list = $keywordsInfo->where($where)->limit($page->firstRow,$page->listRows)->select();

        //$regionWhere['level'] = 1;
        $region = $this->getRegionData(array(),array('region_id,region_name'),'',true);
        $weeks = array('星期天','星期一','星期二','星期三','星期四','星期五','星期六');
        foreach ($list as $key => $value) {
            $list[$key]['week'] = $weeks[date('w',$value['time'])];
            $list[$key]['user_region'] = $region[$value['user_region']];
        }
        $this->assign('weeks',$weeks);
        $this->assign('region',$region);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }

    /**
     * 添加关键词转化跟踪信息
     */
    public function addConversion(){
        $data = I('post.');
        $result = array('flag'=>0,'msg'=>'操作失败');
        $data['time'] = strtotime($data['time']);
        $res = M('keywordsConversion')->add($data);
        if($res){
            $result['flag'] = 1;
            $result['msg'] = '操作成功';
        }

        echo json_encode($result);
    }

    /**
     * 修改关键词转化跟踪信息
     */
    public function editConversion(){
        $conversion = M('keywordsConversion');
        if(IS_GET){
            $id = I('id');
            $result = array('flag'=>0,'msg'=>array());
            $data = $conversion->find($id);
            $data['time'] = date('Y-m-d',$data['time']); 
            if($data){
                $result = array('flag'=>1,'msg'=>$data);
            }
        }else if(IS_POST){
            $postInfo = I('post.');
            $postInfo['time'] = strtotime($postInfo['time']);
            $result = array('flag'=>0,'msg'=>'更新失败');
            $res = $conversion->where('id='.$postInfo['id'])->save($postInfo);
            if($res){
                $result['flag'] = 1;
                $result['msg'] = '更新成功';
            }elseif($res==0){
                $result['flag'] = 0;
                $result['msg'] = '数据没有修改';
            };
        }
        echo json_encode($result);
    }

    /**
     * 删除和启用关键词转化跟踪
     */
    public function delConversion(){
        $conversion = M('keywordsConversion');
        $this->_delete($conversion);
    }

    /**
     * 导入关键词转化跟踪数据
     */
    public function importConversion(){
        $imgPath = C('ROOT_PATH').C('OPEX_EXCEL').'/'; // 设置附件上传根目录
        $upload           = new \Think\Upload();// 实例化上传类
        $upload->maxSize  = 3145728 ;// 设置附件上传大小
        $upload->exts     = array('xls','xlsx');// 设置附件上传类型
        $upload->rootPath = $imgPath; // 设置附件上传根目录
        $upload->saveName = array('date','YmdHis');
        $upload->autoSub  = true;
        if($_FILES['excel_file']['error'] == 0 && !empty($_FILES['excel_file']['tmp_name'])){
            $info   =   $upload->uploadOne($_FILES['excel_file']);
        }
        if(!$info){
            $result['flag'] = 0;
            $result['msg'] = '请上传正确的文件';
            echo json_encode($result);die;
        }
        $fileName = $imgPath.$info['savepath'].$info['savename'];
        
        vendor('PHPExcel.PHPExcel');
        vendor('PHPExcel.PHPExcel.IOFactory');
        vendor('PHPExcel.PHPExcel.Reader.Excel5');// Excel5:xls;Excel2007:xlsx;
        vendor('PHPExcel.PHPExcel.Reader.Excel2007');
        if($info['ext']=='xls'){
            $objReader     = \PHPExcel_IOFactory::createReader('Excel5');
        }elseif($info['ext']=='xlsx'){
            $objReader     = \PHPExcel_IOFactory::createReader('Excel2007');
        }  
        $objPHPExcel   = $objReader->load($fileName);
        $sheet         = $objPHPExcel->getSheet(0);
        $highestRow    = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        for ($i=2; $i < $highestRow+1; $i++) {
            //时间
            $time                = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
            //预约陵园名称
            $cemetery_name       = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
            //来源类型
            $type                = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getValue();
            //搜素引擎
            $search_engine       = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getValue();
            //来源
            $source              = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getValue();
            //搜索词
            $search_term         = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getValue();
            //关键词
            $keywords            = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getValue();
            //地区是否相同
            $user_region_same    = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getValue();
            //用户地区
            $user_region         = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getValue();

            // 转换时间
            if($time){
                $time = ($time-25569)*24*60*60;
            }else{
                $time = 0;
            }
            
            // 获取省份
            if($user_region){
                $where['region_name'] = array('in',$user_region);
                $region = M('region')->where($where)->field('region_id')->find();
                $user_region = $region['region_id'];
            }else{
                $user_region = 0;
            }
            
            //来源类型
            foreach (C('SOURCE_TYPE') as $key => $value) {
                if(strpos($value,$type) !== false){
                    $type = $key;
                }
            }
            //是否相同地区
            if($user_region_same=='是'){
                $user_region_same=1;
            }else if($user_region_same=='否'){
                $user_region_same=2;
            }
            $disburseTable = M('keywordsConversion');
            $disburseTable->add(
                array(
                    'cemetery_name'       => $cemetery_name,
                    'type'                => $type,
                    'search_engine'       => $search_engine,
                    'source'              => $source,
                    'search_term'         => $search_term,
                    'keywords'            => $keywords,
                    'user_region_same'    => $user_region_same,
                    'user_region'         => $user_region,
                    'consume'             => $consume,
                    'time'                => $time,
                )
            );
        }

        if($disburseTable){
            $result['flag'] = 1;
            $result['msg'] = '执行成功';
        }else{
            $result['flag'] = 0;
            $result['msg'] = '执行失败';
        }
        echo json_encode($result);
    }
    
    /**
     * 导出关键词转化跟踪数据
     */
    public function exportConversion(){
        $conversionInfo = M('keywordsConversion')->field('cemetery_name,type,search_engine,source,search_term,keywords,user_region_same,user_region,time')->order('time desc')->select();
        // 引入PHPExcel
        vendor('PHPExcel.PHPExcel');

        $phpExcel = new \PHPExcel();

        $phpExcel->getProperties()->setCreator('hgy')
            ->setLastModifiedBy('hgy')
            ->setTitle('Office 2007 XLSX Test Document')
            ->setSubject('Office 2007 XLSX Test Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Test result file');

        // 设置行宽度
        $phpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10.43);
        $phpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(38.43);
        $phpExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10.14);
        $phpExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10.14);
        $phpExcel->getActiveSheet()->getColumnDimension('E')->setWidth(31);
        $phpExcel->getActiveSheet()->getColumnDimension('F')->setWidth(21.14);
        $phpExcel->getActiveSheet()->getColumnDimension('G')->setWidth(33.57);
        $phpExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12.71);
        $phpExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10.14);

        // 设置行高度
        $phpExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(22);
        $phpExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);

        // 设置字体
        $styleArray = array(
            'font' => array(
                'bold' => true,
                // 'color' => array('rgb' => 'FF0000'),
                'size' => 15,
                'name' => 'Microsoft YaHei'
            )
        );

        $phpExcel->getActiveSheet()->getCell('A1')->setValue('Some text');
        $phpExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);

        $phpExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(11);
        $phpExcel->getActiveSheet()->getStyle('A2:I2')->getFont()->setBold(true);
        $phpExcel->getActiveSheet()->getStyle('A2:I2')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('A1:I2')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);

        // 设置水平居中
        $phpExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('G')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('H')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('I')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // 合并cell
        $phpExcel->getActiveSheet()->mergeCells('A1:I1');

        // 设置表格标题
        $phpExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','关键词转化跟踪')
            ->setCellValue('A2','时间')
            ->setCellValue('B2','预约陵园')
            ->setCellValue('C2','来源类型')
            ->setCellValue('D2','搜索引擎')
            ->setCellValue('E2','来源')
            ->setCellValue('F2','搜索词')
            ->setCellValue('G2','关键词')
            ->setCellValue('H2','是否同地区')
            ->setCellValue('I2','用户地区');

        //获取全国地区
        $regionData = $this->getRegionData('',array('region_id,region_name'),'',true);
        foreach ($conversionInfo as $key => $value) {
               if($value['user_region_same']==1){
                    $conversionInfo[$key]['user_region_same'] = '是';
               }elseif($value['user_region_same']==2){
                    $conversionInfo[$key]['user_region_same'] = '否';
               }
               $conversionInfo[$key]['type'] = C("SOURCE_TYPE.".$value['type']);
           } 
       
        for($i=0;$i<count($conversionInfo);$i++){
            $phpExcel->getActiveSheet(0)->setCellValue('A'.($i+3),date('Y-m-d',$conversionInfo[$i]['time']));
            $phpExcel->getActiveSheet(0)->setCellValue('B'.($i+3),$conversionInfo[$i]['cemetery_name']);
            $phpExcel->getActiveSheet(0)->setCellValue('C'.($i+3),$conversionInfo[$i]['type']);
            $phpExcel->getActiveSheet(0)->setCellValue('D'.($i+3),$conversionInfo[$i]['search_engine']);
            $phpExcel->getActiveSheet(0)->setCellValue('E'.($i+3),$conversionInfo[$i]['source']);
            $phpExcel->getActiveSheet(0)->setCellValue('F'.($i+3),$conversionInfo[$i]['search_term']);
            $phpExcel->getActiveSheet(0)->setCellValue('G'.($i+3),$conversionInfo[$i]['keywords']);
            $phpExcel->getActiveSheet(0)->setCellValue('H'.($i+3),$conversionInfo[$i]['user_region_same']);
            $phpExcel->getActiveSheet(0)->setCellValue('I'.($i+3),$regionData[$conversionInfo[$i]['user_region']]);
            $phpExcel->getActiveSheet()->getStyle('A'.($i+3).':I'.($i+3))->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $phpExcel->getActiveSheet()->getStyle('A'.($i+3).':I'.($i+3))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $phpExcel->getActiveSheet()->getRowDimension($i+3)->setRowHeight(16);
        }

        // sheet命名
        $phpExcel->getActiveSheet()->setTitle('关键字转化跟踪');
        $phpExcel->setActiveSheetIndex(0);
        
        // excel头参数
        header('Content-Type: application/vnd.ms-excel'); // 生成xls/xlsx文件
        // header('Content-Type: text/csv'); // 生成csv文件

        header('Content-Disposition: attachment;filename="关键字转化跟踪('.date('Y-m-d H_i_s').').xls"'); // 后缀名:xls/xlsx/csv

        header('Cache-Control: max-age=0');
        $phpWriter = \PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5'); // Excel5:xls; Excel2007:xlsx; CSV:csv;
        $phpWriter->save('php://output');
    }
    
    /**
     * 陵园SEO列表
     *
     * @return void
     */
    public function cemetorySeo() {
        $where['type'] = array('in',array(C('SEO_TYPE.CEMETERY_HOME'),C('SEO_TYPE.CEMETERY_LIST')));
        $province_id =I('get.province_id');
        if(!empty($province_id)){
            $where['province_id'] = $province_id;
        }
        $regionWhere['level']=array('in',array('0','1'));
        $regionWhere['state']= C('NORMAL_STATUS');
        $region = $this->getRegionData($regionWhere,array('region_id','region_name'));
        $this->assign('region',$region);
        $this->_seo($where);
        $this->display();
    }
    /*
     * 添加SEO
     * return void
     */
    public function add() {
        if(IS_POST){
            $act = I('post.act');
            $SeoModel = D('Seo');
            $result = array('flag'=>0,'msg'=>'操作失败');
            if($act=='cemeteryseo'){
                //判断该地区和类型  数据是否存在
                $data = $SeoModel->where('province_id='.I('post.province_id').' and type='.I('post.type'))->find();
                if(!empty($data)){
                    $result['flag'] =0;
                    $result['msg'] ='该数据已经存在';
                }else{
                   if($SeoModel->create() && $SeoModel->add()){
                        $result['flag'] =1;
                        $result['msg'] ='操作成功';
                    }
                }
            }else if($act=='funeralseo'){
                //判断数据是否存在
                $data = $SeoModel->where('province_id='.I('post.province_id').' and type='.I('post.type'))->find();
                if(!empty($data)){
                    $result['flag'] =0;
                    $result['msg'] ='该数据已经存在';
                }else{
                   if($SeoModel->create() && $SeoModel->add()){
                        $result['flag'] =1;
                        $result['msg'] ='操作成功';
                    }
                }
            }else if($act=='newsSeo'){
                //判断数据是否存在
                $type = I('post.type');
                if ($type == 4) {
                    $data = $SeoModel->where('type='.$type.' and status = 1')->field('id')->find();
                } else {
                    $data = $SeoModel->where('type='.$type.' and  status = 1 and category_id='.I('post.category_id'))->field('id')->find();
                }
                if(!empty($data)){
                    $result['flag'] =0;
                    $result['msg'] ='该数据已经存在';
                }else{
                   if($SeoModel->create() && $SeoModel->add()){
                        $result['flag'] =1;
                        $result['msg'] ='操作成功';
                    }
                }
            }else if($act == 'financeseo'){
                //判断数据是否存在
                $data = $SeoModel->where('type='.I('type'))->find();
                if(!empty($data)){
                    $result['flag'] =0;
                    $result['msg'] ='该数据已经存在';
                }else{
                   if($SeoModel->create() && $SeoModel->add()){
                        $result['flag'] =1;
                        $result['msg'] ='操作成功';
                    }
                }
            }
            echo json_encode($result);
        }
    }
    /**
     * 编辑修改
     */
    public function edit(){
        if(IS_POST){
            $seoModel = D('Seo');
            if($seoModel->create() && $seoModel->save()){
                $result['flag'] = 1;
                $result['msg'] = '修改成功';
            }else{
                $result['flag'] = 0;
                $result['msg'] = '修改失败！';
            }
        }elseif(IS_GET){
            $id = I('get.id');
            $result = array('flag'=>0,'data'=>array());
            if(!empty($id)){
                $data = M('Seo')->find($id);
                if(!empty($data)){
                    $result['flag'] = 1;
                    $result['data'] = $data;
                }
            }
        }
        echo json_encode($result);
    }
     /**
     * 删除和开启
     */
    public function button(){
        if(IS_POST){
            $result = array('flag'=>0,'msg'=>'操作失败!');
            $data['id'] = I('post.id');
            $data['status'] = I('post.status');
            if(!empty($data['id'])){
                $seoModel = M('Seo');
                if($seoModel->create($data) && $seoModel->save()){
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功!';
                }
            }
            echo json_encode($result);
        }
    }
    
    
     /**
     * 殡仪馆SEO列表
     * @return void
     */
    public function funeralSeo() {
        $where['type'] = C('SEO_TYPE.FUNERAL_LIST');
        $province_id =I('get.province_id');
        if(!empty($province_id)){
            $where['province_id'] = $province_id;
        }
        $this->_seo($where);
        $regionWhere['level']=array('in',array('0','1'));
        $regionWhere['state']= C('NORMAL_STATUS');
        $region = $this->getRegionData($regionWhere,array('region_id','region_name'));
        $this->assign('region',$region);
        $this->display();
    }
    /**
     * 新闻SEO列表
     * @return void
     */
    public function newsSeo() {
        $where['type'] = array('in',array(C('SEO_TYPE.NEWS_HOME'),C('SEO_TYPE.NEWS_CLASS')));
        $category_id = I('get.category_id');
        if(!empty($category_id)){
            $where['category_id'] =$category_id;
        }
        $this->_seo($where,TRUE);
        //取出新闻的分类
        $categoryModel = D('Category');
        $category = $categoryModel->where('is_show='.C('NORMAL_STATUS'))->select();
        $newsCategory = $categoryModel->categoryTree($category,C('NEWS_CATEGORY_ID'));
        $this->assign('newsCategory',$newsCategory);
        $this->display();
    }
    /*
     * 91乐融SEO
     * return void();
     */
    public function financeSeo(){
        $type = I('type');
        if(empty($type)){
            $tmp = array();
            foreach( C('FINANCE_SEO') as $key=>$val){
                $tmp[] = $key; 
            }
            $where['type'] = array('in',$tmp);
        }else{
            $where['type'] = $type;
        }
        $this->_seo($where);
        $this->type=C('FINANCE_SEO');
        $this->display();
    }
    
     /**
     * 首页、列表部分的SEO数据  核心方法
     * @return void
     */
    private function _seo($where,$isNewsSEO = false) {
        $SeoModel = D('Seo');
        $totalRows = $SeoModel->where($where)->count();
        $page = new Page($totalRows,C('PAGE_SIZE'));
        $pageshow = $page->show();
        if($isNewsSEO){
            $seoList = $SeoModel->relation('Category')->where($where)->limit($page->firstRow,$page->listRows)->order('created_time desc')->select();
        }else{
            $seoList = $SeoModel->relation('Province')->where($where)->limit($page->firstRow,$page->listRows)->order('created_time desc')->select();
        }
        $this->assign('list',$seoList);
        $this->assign('page',$pageshow);
        $this->assign('seoType',C('SEO_TYPE'));
    }
    
    
    
    /*
     * 运营推广账号管理列表
     */
    public function webAccountList(){
        $name = I('name');
        if(!empty($name)){
            $where['web_name'] = array('like','%'.$name.'%');
        }
        $webAccountManageModel = M('WebAccountManage');
        $webcount = $webAccountManageModel->where($where)->count();
        $page = new Page($webcount,C('PAGE_SIZE'));
        $pageshow = $page->show();
        $list = $webAccountManageModel->where($where)->order('id desc')->select();
        $listNum = count($list);
        for($i=0;$i<$listNum;$i++ ){
            $list[$i]['password'] = _decode($list[$i]['password']);
        }
        $this->assign('list',$list);
        $this->assign('page',$pageshow);
        $this->display();
    }
   /*
    * 添加运营推广账号
    */ 
    public function webAccountAdd(){
        if(IS_POST){
            $result = array('flag'=>0,'msg'=>'添加失败！');
            $data = I('post.');
            $data['password'] = _encode($data['password']);
            $data['update_time'] = date('y-m-d h:i:s',time());
            $data['created_time'] = date('y-m-d h:i:s',time());
            $data['operation_id'] = session('admin_id');
            if(M('WebAccountManage')->add($data)){
                $result['flag'] = 1;
                $result['msg'] = '添加成功！';
            }
        }
        echo json_encode($result);
    }
    /*
    * 编辑运营推广账号
    */ 
    public function webAccountEdit(){
        $result = array('flag'=>0,'msg'=>'操作失败！');
        if(IS_POST){
            $data = I('post.');
            if(!empty($data['id'])){
                $data['password'] = _encode($data['password']);
                if(M('WebAccountManage')->save($data)){
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功！';
                }
            }
        }else if(IS_GET){
            $id = I('get.id');
            if(!empty($id)){
                $data = M('WebAccountManage')->field('id,web_name,url,account,password,mobile,email,remark')->where('id ='.$id)->find();
                $data['password'] = _decode($data['password']);
                $result['data'] = $data;
                $result['flag'] = 1;
            }
        }
        echo json_encode($result);
    }
    /*
     * 修改密码
     */
    public function webAccountPassword(){
        if(IS_POST){
            $result = array('flag'=>0,'msg'=>'操作失败！');
            $data['id'] = I('post.id');
            $data['password'] = _encode(I('post.newpassword'));
            if(!empty( $data['id'])){
                if(M('WebAccountManage')->save($data)){
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功!';
                }
            }
            echo json_encode($result);
        }else if(IS_GET){
            $id = I('get.id');
            $data = M('WebAccountManage')->field('id,password')->where('id ='.$id)->find();
            $data['password'] = _decode($data['password']);
            echo json_encode($data);
        }
    }
    
    /*
     * 添加陵园SEO判断提示信息
     * return string(json);
     */
    public function checkSEO(){
        $result = array('flag'=>0,'msg'=>'操作失败！');
        $data = M('Seo')->where('province_id='.I('post.provinceId').' and type='.I('post.type'))->find();
        if(!empty($data)){
            $result['flag'] =1;
            $result['msg'] ='该数据已经存在';
        }
        echo json_encode($result);
    }
}