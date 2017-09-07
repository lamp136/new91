<?php
namespace Admin\Controller;

use Think\Controller;
/**
 * 后台控制器基类
 *
 * @author hgy
 */
class BaseController extends Controller
{
    public function __construct() {
        parent::__construct();
        
        //判断是否登陆
        if(!session('?admin_id')){
            $this->redirect('Login/login');
            return false;
        }
        self::operateLog();
        $path = CONTROLLER_NAME.'/'.ACTION_NAME ;

        //获取左侧的菜单
        $privilegeModel = D('privilege');
        $currentpri     = $privilegeModel->field('id,pid,level')->where("name='".$path."'")->find();
        if(!empty($currentpri)){
            if($currentpri['level']==0){
                $currentpriId = $currentpri['id'];
            }else{
                $currentpriId = $privilegeModel->gettopmenu($currentpri['pid']);
            }
            //获取其菜单节点,即level为1；
            if($currentpri['level']<=1){
                $memuId = $currentpri['id'];
            }else{
                $memuId = $privilegeModel->gettopmenu($currentpri['pid'],1);
            }
        }
        //通过顶级id 获取下面的子栏目
        $data = $privilegeModel->where("status=".C('NORMAL_STATUS')." and level<=2")->order('sort desc,id asc')->select();

        //递归将权限重组,将左侧菜单列举出来.
        if(session('email')!=C('ADMIN_EMAIL')){
            $menuData = $privilegeModel->getMenuTree($data,0);
        }else{
            $menuData = $privilegeModel->getTree($data,0);
        }
        //dump($menuData);die;
        $this->assign('menuData',$menuData);
        $this->assign('path',$path);
        $this->assign('currentpriId',$currentpriId);
        $this->assign('memuId',$memuId);
        //权限的判断
        if(in_array($path, C('NO_AUTH_PAHT'))){
            return true;
        }
        $admin_email = C('ADMIN_EMAIL');
        if(session('email')==$admin_email){
            return true;
        }

        //当前访问的控制器和方法，是否在session中
        if(in_array($path, session('privilegeData'))){
            return true;
        }else{
            $this->error('您没有权限访问');die;
        }
    }

    /**
     * 记录操作日志
     */
    public function operateLog(){
        //判断是否记录
        if(C('SAVE_LOG_OPEN')){
            $action = ACTION_NAME;
            if($action == '' || CONTROLLER_NAME =='Index') {
                return false;
            }else {
                $username = session('email');
                $userid   = session('admin_id');

                if(empty($_GET) && empty($_POST)){
                    return false;
                }else{
                    $after  = var_export(array('GET' => $_GET),true);
                    $before = var_export(array('POST' => $_POST),true);
                }

                $log_db = M('logs');
                $log_db->add(array(
                    'controller' => CONTROLLER_NAME,
                    'action'     => ACTION_NAME,
                    'time'       => NOW_TIME,
                    'admin_id'   => $userid,
                    'admin_name' => $username,
                    'get_data'   => $after,
                    'post_data'  => $before,
                    'ip'         => get_client_ip(1)
                ));
            }
        }
    }

    /**
     * 获取省市数据
     * @param  array   $where  条件
     * @param  array   $fields 字段
     * @param  int     $num    条数
     * @param  boolean $bool   获取方式
     * @return array
     */
    public function getRegionData($where=array(), $fields=array(), $num=null, $bool=false){
        $regionModel = M('region');
        if(!$bool){
            if($num == 1){
                $region = $regionModel->where($where)->field($fields)->find();
            }
            if(empty($num)){
                $region = $regionModel->where($where)->field($fields)->select();
            }
        }else{
            $tmp = implode(',',$fields);
            $region = $regionModel->where($where)->getField($tmp);
        }
        return $region;
    }

     /**
     * 获取admin表中部门人员
     * @param array
     * @return array
     */
    public function getMen($datas){
        $where['role_id'] = array('in',$datas);
        $businesses = D('RoleUser')->relation('Admin')->where($where)->select();
        $data = array();
        if(!empty($businesses)){
            foreach ($businesses as $key => $value) {
                if(empty($value['Admin']['nickname'])){
                    continue;
                }
                $data[$value['user_id']] = $value['Admin']['nickname'];
            }
        }
        return $data;
    }

     /**
     * 获取分类数据
     * @param  array   $where  条件
     * @param  array   $fields 字段
     * @param  int     $num    条数
     * @param  boolean $bool   获取方式
     * @return array
     */
    public function getCategoryData($where=array(), $fields=array(), $num=null, $bool=false){
        $categoryModel = M('category');
        if(!$bool){
            if($num == 1){
                $category = $categoryModel->where($where)->field($fields)->find();
            }else if($num != 1 && empty($num)){
                $category = $categoryModel->where($where)->field($fields)->select();
            }
        }else{
            $tmp = implode(',',$fields);
            $category = $categoryModel->where($where)->getField($tmp);
        }
        return $category;
    }
     /*
     * 获取商务人员和全部管理人员
     * @param $where 为商务人员下的条件;
     * @param $bool  true商务人员信息(默认)  false为全部管理员信息;
     * @param $work  true时为在职人员(默认)  false时取全部人员
     * return array;
     */
    public function getBusinessMen($bool=true,$work=true,$where = array()) {
        $menData = array();
        if ($bool) {
            $data = session('BusinessMen');
            if ($data) {//缓存有数据
                if ($work) {//获取在职商务人
                    foreach ($data as $id => $businessMen) {
                        if ($businessMen['status'] == C('NORMAL_STATUS')) {
                            $menData[$id] = $businessMen['nickname'];
                        }
                    }
                } else {//慎用 获取所有的商务人 TODO 如果关系清掉此判断有问题
                    foreach ($data as $id => $businessMen) {
                        $menData[$id] = $businessMen['nickname'];
                    }
                }
            } else {//缓存没有数据
                $where['role_id'] = C('BUSINESS_DEPART');
                $businesses = D('RoleUser')->relation('Admin')->where($where)->select();
                if(!empty($businesses)){
                    foreach ($businesses as $key => $value) {
                        if(empty($value['Admin']['nickname'])){
                            continue;
                        }
                        $status = $value['Admin']['status'];
                        $data[$value['user_id']]['nickname'] =  $value['Admin']['nickname'];
                        $data[$value['user_id']]['status'] = $status;

                        $menData[$value['user_id']] = $value['Admin']['nickname'];
                        if($work && $status  != C('NORMAL_STATUS')) {
                            unset($menData[$value['user_id']]);
                        }
                    }
                    session('BusinessMen',$data);
                }
            }
        } else {
            $data = session('AllMen');
            if(empty($data)){
                $data = M('admin')->getField('id,nickname,status');
                session('AllMen',$data);
                if ($work) {
                    foreach ($data as $id => $val) {
                        if ($val['status'] == C('NORMAL_STATUS')) {
                            $menData[$id] = $val['nickname'];
                        }
                    }
                } else {
                    foreach ($data as $id => $val) {
                        $menData[$id] = $val['nickname'];
                    }
                }
            } else {
                $allMen = D('Admin')->where($where)->getField('id,nickname,status');

                if(!empty($allMen)){
                    foreach ($allMen as $id => $value) {
                        if(empty($value['nickname'])){
                            continue;
                        }
                        $status = $value['status'];
                        $data[$id]['nickname'] = $value['nickname'];
                        $data[$id]['status'] = $status;


                        if($work && $status  == C('NORMAL_STATUS')) {
                            $menData[$id] = $value['nickname'];
                        } else if (!$work) {
                            $menData[$id] = $value['nickname'];
                        }
                    }
                    session('AllMen',$data);
                }
            }
        }

        return $menData;
    }

  

}
