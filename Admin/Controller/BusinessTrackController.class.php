<?php
namespace Admin\Controller;

use Think\Page;
use Admin\Controller\BaseController;

class BusinessTrackController extends BaseController
{
	/**
	 * 商务数据跟踪控制器
	 */
	public function index(){
		$getVal = I('get.');
		$trackModel = D('DataTrack');
        /**
         * 搜索条件
         */
		if(isset($getVal['search_company']) && !empty($getVal['search_company'])){
			$where['company'] = array('like','%'.$getVal['search_company'].'%');
		}
		if(isset($getVal['search_province']) && !empty($getVal['search_province'])){
			$where['province_id'] = $getVal['search_province'];
		}
		if(isset($getVal['search_city']) && !empty($getVal['search_city'])){
			$where['city_id'] = $getVal['search_city'];
		}
		if(isset($getVal['category_id']) && !empty($getVal['category_id'])){
			$where['category_id'] = $getVal['category_id'];
		}
		if(isset($getVal['search_intention']) && !empty($getVal['search_intention'])){
			$where['intention'] = $getVal['search_intention'];
		}
		if(isset($getVal['search_is_system']) && !empty($getVal['search_is_system'])){
			$where['is_system'] = $getVal['search_is_system'];
		}
        // 判断是不是管理员账户
		if(session('email') != C('ADMIN_EMAIL')){
			$where['flow_man|input_man'] = session('admin_id');
		}
		$count = $trackModel->where($where)->count();
		$page = new Page($count,C('PAGE_SIZE'));
		$show = $page->show();
		$list = $trackModel->where($where)->relation(array('Province','City'))->limit($page->firstRow,$page->listRows)->order('created_time desc')->select();
		$province = $this->getRegionData('level=1','region_id,region_name','',false);
		if(!empty($getVal['search_province'])){
			$city = $this->getRegionData('pid='.$getVal['search_province'],'region_id,region_name','',false);
		}
        
		$this->page = $show;
		$this->email = $this->getBusinessMen();
		$this->getValue = $getVal;
		$this->province = $province;
		$this->city = $city;
		$this->list = $list;
		$this->display();
	}

    /**
     * 检测重复
     */
    public function checkTrackName(){
        $postVal = I('post.');
        $where['company'] = $postVal['company'];
        if(!empty($postVal['id'])){
            $where['id'] = array('neq',$postVal['id']);
        }
        $trackModel = M('DataTrack');
        $info = $trackModel->where($where)->find();
        if($info){
            $result['flag'] = 1;
        }else{
            $result['flag'] = 0;
        }
        echo json_encode($result);
    }

	/**
	 * 添加跟踪信息
	 */
	public function add(){
		if(IS_POST){
			$postVal = I('post.');
			$trackModel = M('DataTrack');
			$postVal['input_time'] = strtotime($postVal['input_time']);
			$postVal['created_time'] = time();
			$postVal['input_man'] = $postVal['flow_man'] = session('admin_id');
			if($trackModel->create($postVal) && $trackModel->add()){
				$this->success('添加成功',U('index'));
			}else{
				$this->error('添加失败');
			}
		}else{
			$this->intention = C('INTENTION_TYPE');
			$province = $this->getRegionData('level=1','region_id,region_name','',false);
			$this->province = $province;
			$this->flow_man = $this->getBusinessMen(false,false);
			$this->display();
		}
	}

	/**
	 * 编辑跟踪信息
	 */
	public function edit(){
		$trackTable = M('DataTrack');
		if(IS_POST){
			$postData = I('post.');
			$postInfo = I('post.info');
			$postData['input_time'] = strtotime($postData['input_time']);
			$postData['updated_time'] = time();
            $postData['input_man'] = $postData['flow_man'] = session('admin_id');
			if($trackTable->create($postData) && $trackTable->save()){
				$this->success('修改成功',U('index',array('p'=>$postInfo['p'],'search_company'=>$postInfo['search_company'],'search_province'=>$postInfo['search_province'],'search_city'=>$postInfo['search_city'])));
			}else{
				$this->error('修改失败');
			}
		}else{
			$getInfo = I('get.');
			if(!empty($getInfo['id'])){
				$data = $trackTable->where('id='.$getInfo['id'])->find();
			}
			$provinceWhere['pid'] = C('CHINA_NUM');
            $provinceWhere['state'] = C('NORMAL_STATUS');
			$province = $this->getRegionData($provinceWhere,'region_id,region_name','',false);
			$cityWhere['pid'] = $data['province_id'];
			$city = $this->getRegionData($cityWhere,'region_id,region_name','',false);
			$this->province = $province;
			$this->city = $city;
			$this->flow_man = $this->getBusinessMen(false,false);
			$this->data = $data;
			$this->display();
		}
	}

	/**
	 * 更改跟踪人
	 */
	public function changeFlowMan(){
        $result = array('flag'=>0,'msg'=>'操作失败');
        if(IS_POST){
    		$postVal = I('post.');
            if($postVal['flow_man'] != 0){
        		$where['id'] = array('in',$postVal['id']);
        		$ret = M('DataTrack')->where($where)->setField('flow_man',$postVal['flow_man']);
        		if($ret){
        			$result = array('flag'=>1,'msg'=>'操作成功');
        		}
            }
        }else{
            $userList = $this->getBusinessMen();
            $result = array('flag'=>1,'data'=>$userList);
        }
		echo json_encode($result);
	}

	/**
     * 通过选择省份改变市ajax获取省份ID
     */
    public function getCityList(){
        if (IS_POST) {
            $province_id = I('post.province_id');
            $data = $this->getRegionData("level=2 and pid=".$province_id,'region_id,region_name','',false);
            $this->ajaxReturn($data, 'JSON');
        }else{
            $this->error('省份ID不存在');
        }
    }

    /**
     * 删除和启用
     */
	public function delete(){
        if(IS_POST){
            $postInfo = I('post.');
            $flowCModel = M('DataTrack');
            $result = array('flag'=>0,'msg'=>'操作失败');
            if($postInfo['act']=='del'){
                $data['id'] = $postInfo['id'];
                $data['status'] = C('DELETE_STATUS');
                if($flowCModel->create($data) && $flowCModel->save()){
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功';
                }
            }else if($postInfo['act']=='enable'){
                $data['id'] = $postInfo['id'];
                $data['status'] = C('NORMAL_STATUS');
                if($flowCModel->create($data) && $flowCModel->save()){
                    $result['flag'] = 1;
                    $result['msg'] = '操作成功';
                }
            }
            echo json_encode($result);
        }
    }

    /**
     * 数据详情
     */
    public function trackMsg(){
        $getInfo = I('get.');
        $trackMsg = M('DataTrackMsg');
        $result = array('flag'=>0,'data'=>'没有数据');
        $where['track_id'] = $getInfo['id'];
        if(session('email') != C('ADMIN_EMAIL')){
            $where['flow_man'] = $getInfo['flow_man'];
        }
        $data = $trackMsg->where($where)->select();
        if(!empty($data)){
            $users = $this->getBusinessMen(false,false);
            $i=0;
            foreach ($data as $key => $val) {
                $data[$i]['created_time'] = date('Y-m-d H:i:s',$val['created_time']);
                $data[$i]['flow_man'] = $users[$val['flow_man']];
                $i++;
            }
            $result = array('flag'=>1,'data'=>$data);
        }
        echo json_encode($result);
    }

    /**
     * 添加详情信息
     */
    public function addMsg(){
        if(IS_POST){
            $trackMsg = M('DataTrackMsg');
            $postData = I('post.');
            $postData['created_time'] = time();
            $postData['flow_man'] = session('admin_id');
            $ret = $trackMsg->data($postData)->add();
            if($ret){
                $result['flag'] = 1;
                $result['msg'] = '操作成功';
            }else{
                $result['flag'] = 0;
                $result['msg'] = '操作失败';
            }
            echo json_encode($result);
        }
    }

    // 删除备注信息
    // public function delMsg(){
    //     if(IS_POST){
    //         $postInfo = I('post.');
    //         $trackMsg = M('DataTrackMsg');
    //         $result = array('flag'=>0,'msg'=>'删除失败');
    //         $info = $trackMsg->where('id='.$postInfo['id'])->delete();
    //         if($info){
    //             $result['flag'] = 1;
    //             $result['msg'] = '删除成功';
    //         }
    //         echo json_encode($result);
    //     }
    // }

    /**
	 * 导入数据
	 */
	public function importFiles(){
        $filePath = C('ROOT_PATH').C('TRACK_EXCEL').'/';
        $upload           = new \Think\Upload();// 实例化上传类
        $upload->maxSize  = 3145728 ;// 设置附件上传大小
        $upload->exts     = array('xls', 'xlsx');// 设置附件上传类型
        $upload->rootPath = $filePath; // 设置附件上传根目录
        $upload->saveName = array('date','YmdHis');
        $upload->autoSub  = false;
        if($_FILES['flow_file']['error'] == 0 && !empty($_FILES['flow_file']['tmp_name'])){
            $info = $upload->uploadOne($_FILES['flow_file']);
        }
        $fileName = $filePath.$info['savename'];
        
        vendor('PHPExcel.PHPExcel');
        vendor('PHPExcel.PHPExcel.IOFactory');
        vendor('PHPExcel.PHPExcel.Reader.Excel5');// Excel5:xls;Excel2007:xlsx;
        vendor('PHPExcel.PHPExcel.Reader.Excel2007');// Excel5:xls;Excel2007:xlsx;
		$objReader     = \PHPExcel_IOFactory::createReader('Excel5');
        if($info['ext'] == 'xlsx'){
            $objReader     = \PHPExcel_IOFactory::createReader('Excel2007');
        }
		$objPHPExcel   = $objReader->load($fileName);
		$sheet         = $objPHPExcel->getSheet(0);
		$highestRow    = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();

        for ($i=2; $i < $highestRow+1; $i++) {
            // 日期
			$datetime         = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
			// 公司
			$company          = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
			// 省市
			$region           = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getValue();
			// 意向类型
            $intention        = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getValue();
			// 决策人
			$decisionMaker    = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getValue();
			// 决策人职务
			$decisionPosition = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getValue();
			// 决策人电话
			$decisionPhone    = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getValue();
			// 决策影响人
			$affectMaker      = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getValue();
			// 决策影响人职务
			$affectPosition   = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getValue();
			// 决策影响人电话
			$affectPhone      = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getValue();
			// 是否有系统
			$isSystem         = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getValue();
			// 陵园/殡仪馆规模
			$scale            = $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getValue();

            // 处理时间格式
			$time      = explode('.', $datetime);
			$stime     = $time[0].'-'.$time[1].'-'.$time[2];
			$inputTime = strtotime($stime);

            // 判断商家类型
            if(strpos($company,'陵园')){
                $type = 37;
            } else if(strpos($company,'殡仪馆')){
                $type = 38;
            }  else if(strpos($company,'殡葬服务')){
                $type = 39;
            } else if(strpos($company,'殡仪用品和供应商')){
                $type = 43;
            }  
            
            // 获取意向类型
            $test = substr($intention,0,1);
            if ($test == A) {
            	$intention = 1;
            }elseif ($test == B) {
            	$intention = 2;
            }elseif ($test == C) {
            	$intention = 3;
            }elseif ($test == D) {
            	$intention = 4;
            }else{
            	$intention = 0;
            }

            // 是否有系统
            $system = substr($isSystem,0,3);
            if($system == "有"){
            	$isSystem = 2;
            }elseif ($system == "无") {
            	$isSystem = 1;
            }elseif ($system == "不") {
            	$isSystem = 3;
            }elseif ($system == null) {
            	$isSystem = "";
            }else{
            	$isSystem = 0;
            }

            // 获取省\市id
			$area     = explode('省',$region);
			$city     = str_replace(array("市","区"," "),"",$area[1]);

            $regionModel = M('region');
            // 市区id
            if(!empty($city)){
            	$cityWhere['region_name'] = array('like','%'.$city.'%');
				$regions  = $regionModel->where($cityWhere)->field('pid,region_id')->find();
				$province_id = $regions['pid'];
				$city_id = $regions['region_id'];
            }else{
            	$province_id = null;
            	$city_id = null;
            }

            // 写入数据表
            $XrModel = M('DataTrack');
            $XrModel->add(array(
				'input_time'        => $inputTime,
				'company'           => $company,
				'province_id'       => $province_id,
				'city_id'           => $city_id,
				'intention'         => $intention,
				'category_id'       => $type,
				'decision_maker'    => $decisionMaker,
				'decision_position' => $decisionPosition,
				'decision_phone'    => $decisionPhone,
				'affect_maker'      => $affectMaker,
				'affect_position'   => $affectPosition,
				'affect_phone'      => $affectPhone,
				'is_system'         => $isSystem,
				'scale'             => $scale,
                'created_time'      => time(),
                'status'            => 1
            ));      
        }

        if($XrModel){
        	$result['flag'] = 1;
        	$result['msg'] = '执行成功';
        }else{
        	$result['flag'] = 0;
        	$result['msg'] = '执行失败';
        }
        echo json_encode($result);
	}

	/**
     * 导出excel
     */
    public function exportFiles($suffix){
        $trackModel = D('DataTrack');

        $trackInfo = $trackModel->Relation(array('Province','City'))->field('company,is_system,province_id,city_id,category_id,intention,decision_maker,decision_position,decision_phone,affect_maker,affect_position,affect_phone,input_time,flow_man')->order('input_time asc')->select();
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
        $phpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(33.29);
        $phpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8.86);
        $phpExcel->getActiveSheet()->getColumnDimension('C')->setWidth(13.14);
        $phpExcel->getActiveSheet()->getColumnDimension('D')->setWidth(8.86);
        $phpExcel->getActiveSheet()->getColumnDimension('E')->setWidth(8.86);
        $phpExcel->getActiveSheet()->getColumnDimension('F')->setWidth(14.71);
        $phpExcel->getActiveSheet()->getColumnDimension('G')->setWidth(27.43);
        $phpExcel->getActiveSheet()->getColumnDimension('H')->setWidth(62.14);
        $phpExcel->getActiveSheet()->getColumnDimension('I')->setWidth(18.43);
        $phpExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15.57);
        $phpExcel->getActiveSheet()->getColumnDimension('K')->setWidth(27.86);
        $phpExcel->getActiveSheet()->getColumnDimension('L')->setWidth(11);
        $phpExcel->getActiveSheet()->getColumnDimension('M')->setWidth(6.86);

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

        $phpExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(10);
        $phpExcel->getActiveSheet()->getStyle('A2:M2')->getFont()->setBold(true);
        $phpExcel->getActiveSheet()->getStyle('A2:M2')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('A1:M2')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);

        // 设置水平居中
        $phpExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('G')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('J')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('I')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('J')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('K')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('L')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $phpExcel->getActiveSheet()->getStyle('M')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // 合并cell
        $phpExcel->getActiveSheet()->mergeCells('A1:M1');

        // 设置表格标题
        $phpExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','跟踪信息')
            ->setCellValue('A2','商家名称')
            ->setCellValue('B2','系统情况')
            ->setCellValue('C2','所在地区')
            ->setCellValue('D2','商家类型')
            ->setCellValue('E2','意向类型')
            ->setCellValue('F2','决策人')
            ->setCellValue('G2','决策人职务')
            ->setCellValue('H2','决策人电话')
            ->setCellValue('I2','决策影响人')
            ->setCellValue('J2','决策影响人职务')
            ->setCellValue('K2','决策影响人电话')
            ->setCellValue('L2','录入时间')
            ->setCellValue('M2','跟踪人');

        $sys = C('IS_SYSTEM');
		$int = C('INTENTION_TYPE');
		$cate = C('BUSINESS_TYPE');
		
        for($i=0;$i<count($trackInfo)-1;$i++){
            $phpExcel->getActiveSheet(0)->setCellValue('A'.($i+3),$trackInfo[$i]['company']);
            $phpExcel->getActiveSheet(0)->setCellValue('B'.($i+3),$sys[$trackInfo[$i]['is_system']]);
            $phpExcel->getActiveSheet(0)->setCellValue('C'.($i+3),$trackInfo[$i]['Province']['region_name'].'/'.$trackInfo[$i]['City']['region_name']);
            $phpExcel->getActiveSheet(0)->setCellValue('D'.($i+3),$cate[$trackInfo[$i]['category_id']]);
            $phpExcel->getActiveSheet(0)->setCellValue('E'.($i+3),$int[$trackInfo[$i]['intention']]);
            $phpExcel->getActiveSheet(0)->setCellValue('F'.($i+3),$trackInfo[$i]['decision_maker']);
            $phpExcel->getActiveSheet(0)->setCellValue('G'.($i+3),$trackInfo[$i]['decision_position']);
            $phpExcel->getActiveSheet(0)->setCellValue('H'.($i+3),$trackInfo[$i]['decision_phone']);
            $phpExcel->getActiveSheet(0)->setCellValue('I'.($i+3),$trackInfo[$i]['affect_maker']);
            $phpExcel->getActiveSheet(0)->setCellValue('J'.($i+3),$trackInfo[$i]['affect_position']);
            $phpExcel->getActiveSheet(0)->setCellValue('K'.($i+3),$trackInfo[$i]['affect_phone']);
            $phpExcel->getActiveSheet(0)->setCellValue('L'.($i+3),date('Y-m-d',$trackInfo[$i]['input_time']));
            $phpExcel->getActiveSheet(0)->setCellValue('M'.($i+3),$trackInfo[$i]['flow_man']);
            $phpExcel->getActiveSheet()->getStyle('A'.($i+3).':M'.($i+3))->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $phpExcel->getActiveSheet()->getStyle('A'.($i+3).':M'.($i+3))->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
            $phpExcel->getActiveSheet()->getRowDimension($i+3)->setRowHeight(16);
        }

        // sheet命名
        $phpExcel->getActiveSheet()->setTitle('跟踪信息表');
        $phpExcel->setActiveSheetIndex(0);

        // excel头参数
        header('Content-Type: application/vnd.ms-excel'); // 生成xls/xlsx文件
        // header('Content-Type: text/csv'); // 生成csv文件
        header('Content-Disposition: attachment;filename="跟踪信息表('.date('Y-m-d H_i_s').').'.$suffix.'"'); // 后缀名:xls/xlsx/csv

        header('Cache-Control: max-age=0');
        if($shffix == 'xls'){
        	$attr = 'Excel5';
        }else{
        	$attr = 'Excel2007';
        }

        $phpWriter = \PHPExcel_IOFactory::createWriter($phpExcel, $attr); // Excel5:xls; Excel2007:xlsx; CSV:csv;
        $phpWriter->save('php://output');
    }
}