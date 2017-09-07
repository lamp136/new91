<?php
namespace Home\Controller;
use Home\Controller\BaseController;

/**
 * 帮助中心
 * @author  He qingyu
 * @date：2016年1月7日
 * @version 1.0
 */
class HelpController extends BaseController{
    /**
     * 购墓指南
     *
     * @return void
     */
    public function guide(){
        $tpl = I('get.tpl');
        $this->assign('menu_flag', 'guide');
        $this->display('Help:'.$tpl);
    }
    /**
     * 订单保障
     *
     * @return void
     */
    public function security() {
        $tpl = I('get.tpl');
        $this->assign('menu_flag', 'security');
        $this->display('Help:'.$tpl);
    }
   /**
     * 常见问题
     *
     * @return void
     */
    public function issue(){
        $tpl = I('get.tpl');
        $this->assign('menu_flag', 'issue');
        $this->display('Help:'.$tpl);
    }
    /**
     *  殡葬常识
     *
     * @return void
     */
    public function common(){
        $tpl = I('get.tpl');
        $this->assign('menu_flag', 'common');
        $this->display('Help:'.$tpl);
    }

}