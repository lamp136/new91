<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;
use Think\Page;
/**
 * Description of LogsController
 *
 * @author Wang qiang <wangqiang@huigeyuan.com>
 * @version 1.0
 */
class LogsController extends BaseController
{

	/**
	 * 操作记录
	 */
	public function index(){
		$logsModel = M('logs');
		$this->_list($logsModel);
		$this->display();
	}

	/**
	 * 登录记录
	 */
	public function loginLog(){
		$loginLogsModel = M('LoginLogs');
		$this->_list($loginLogsModel);
		$this->display();
	}

	/**
	 * 公共列表方法
	 * @param  array $where 日志类型
	 * @return void
	 */
	private function _list($table){
		$totalRows = $table->count();
		$page = new Page($totalRows,C('PAGE_SIZE'));
		$pageshow = $page->show();
		$logslist = $table->limit($page->firstRow, $page->listRows)->order('id desc')->select();
		// dump($logslist);exit;
		$this->assign('page',$pageshow);
		$this->assign('logs',$logslist);
	}

	public function delLogs(){
		$logs = M('logs');
		$this->_del($logs);
	}

	public function delLoginlogs(){
		$loginLogs = M('LoginLogs');
		$this->_del($loginLogs);
	}

	/**
	 * 删除\清空方法
	 * @param  int    $res 删除条件
	 * @param  string $act 方式是清空还是删除 delAll\del
	 */
	private function _del($table){
		$postInfo = I('post.');
		if($postInfo['act'] == 'delAll'){
			$where['id'] = array('neq',0);
			$success = '清空成功';
			$error = '清空失败';
		}else if($postInfo['act'] == 'del'){
			$where['id'] = $postInfo['id'];
			$success = '删除成功';
			$error = '删除失败';
		}
		$info = $table->where($where)->delete();
		if($info){
            $result['flag'] = 1;
            $result['msg'] = $success; 
        }else{
            $result['flag'] = 0;
            $result['msg'] = $error;
        }
        echo json_encode($result);
	}
}