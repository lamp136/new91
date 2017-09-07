<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;
use Think\Page;
/**
 * 敏感词过滤词库
 * 
 */
class SubtleWordController extends BaseController
{
	/**
	 * 词库列表
	 */
	public function index(){
		$subtleWord = M('SubtleWords');
		$count = $subtleWord->count();
		$page = new Page($count,C('PAGE_SIZE'));
		$show = $page->show();
		$inputMan = $this->getBusinessMen(false,false);
		$list = $subtleWord->limit($page->firstRow,$page->listRows)->order('created_time desc')->select();
		$this->inputMan = $inputMan;
		$this->page = $show;
		$this->list = $list;
		$this->display();
	}

	/**
	 * 添加过滤词
	 */
	public function add(){
		$wordModel = M('SubtleWords');
		$postData = I('post.');
		$postData['created_time'] = time();
		$postData['admin_id'] = session('admin_id');
		if($wordModel->create($postData) && $wordModel->add()){
			$result['flag'] = 1;
			$result['msg'] = '操作成功';
		}
		echo json_encode($result);
	}

	/**
	 * 编辑
	 */
	public function edit(){
        $subtleWord = M('SubtleWords');
        if(IS_POST){
        	$postData = I('post.');
        	$postData['updated_time'] = time();
        	$postData['admin_id'] = session('admin_id');
            if($subtleWord->create($postData) && $subtleWord->save()){
                $result['flag'] = 1;
                $result['msg'] = '操作成功';
            }
        }else if(IS_GET){
        	$getInfo = I('get.');
        	$id = $getInfo['id'];
            $result = array('flag'=>0,'data'=>array());
            if(!empty($id)){
                $data = $subtleWord->find($id);
                if(!empty($data)){
                    $result['flag'] = 1;
                    $result['data'] = $data;
                }
            }
        }
        echo json_encode($result);
    }

    /**
     * 删除
     */
    public function del(){
    	$subtelword = M('SubtleWords');
    	if(IS_POST){
            $postInfo = I('post.');
            $result = array('flag'=>0,'msg'=>'操作失败');
            $data['id'] = $postInfo['id'];
            if($postInfo['act']=='del'){
                // 状态改为-1
                $data['status'] = C('DELETE_STATUS');
            }else if($postInfo['act']=='enable'){
                // 状态改为1
                $data['status'] = C('NORMAL_STATUS');
            }
            if($subtelword->create($data) && $subtelword->save()){
                $result['flag'] = 1;
                $result['msg'] = '操作成功';
            }
            echo json_encode($result);
        }
    }

    /**
     * 导入词库文件
     */
	public function uploadFile(){
		if(IS_POST){
			$path             = './Uploads/files/';
			$files            = I('data.txt_file','','',$_FILES);
			$upload           = new \Think\Upload();// 实例化上传类
			$upload->maxSize  = 3145728 ;// 设置附件上传大小
			$upload->exts     = array('txt');// 设置附件上传类型
			$upload->rootPath = $path; // 设置附件上传根目录
			$upload->saveName = array('date','YmdHis');
			$upload->autoSub  = false;

	        if($files['error'] == 0 && !empty($files['tmp_name'])){
	            $info = $upload->uploadOne($files);
	        }
	        // 判断是否为假
	        if(!$info){
	        	$result['flag'] = 0;
				$result['msg'] = $upload->getError();
	        }else{
	        	// 处理上传文件
				$fileName = $path.$info['savename'];
				$file = file_get_contents($fileName);
				$words = str_replace(array("'","‘","’"), "", $file);
				$keywords = explode("\n",$words);
				// 插入数据表
				$table = M('');
				$sql = 'INSERT INTO __SUBTLE_WORDS__ (keywords,admin_id,created_time,status) VALUES';
				$adminId = session('admin_id');
				$createdTime = time();
				$status = 1;

				$count = count($keywords);
				// 长度最大限制
				$j = 4177;
				for($i=0; $i<$count; $i++)  {  
					$tmpstr = "'". $keywords[$i] ."','". $adminId ."','". $createdTime ."','". $status ."'"; 
					$sql .= "(".$tmpstr."),";
					if($i > $j-1){
						break;
					}
				}

				$sql = substr($sql,0,-1);   //去除最后的逗号
				$ret = $table->execute($sql);
				if($ret){
					$result['flag'] = 1;
					$result['msg'] = '操作成功';
				}else{
					$result['flag'] = 0;
					$result['msg'] = '操作失败';
				}
	        }
			echo json_encode($result);
		}
	}
}