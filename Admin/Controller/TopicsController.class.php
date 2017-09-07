<?php
namespace Admin\Controller;

use Admin\Controller\BaseController;
use Think\Page;
/**
 * 专题控制器
 * 
 * @author  Wang Qiang <[<wangqiang@huigeyuan.com>]>
 */

class TopicsController extends BaseController
{
	/**
	 * 陵园专题
	 */
	public function cemetery(){
		$name = I('get.name');
		if(!empty($name)){
			$where['name'] = array('like','%'.$name.'%');
		}
		$where['type'] = C('TOPICS_TYPE.CEMETERY');
		$this->_list($where);
		$this->display();
	}

	/**
	 * 节日专题
	 */
	public function festival(){
		$name = I('get.name');
		if(!empty($name)){
			$where['name'] = array('like','%'.$name.'%');
		}
		$where['type'] = C('TOPICS_TYPE.FESTIVAL');
		$this->_list($where);
		$this->display();
	}

	/**
	 * 专题横幅
	 */
	public function carousel(){
		$name = I('get.name');
		if(!empty($name)){
			$where['name'] = array('like','%'.$name.'%');
		}
		$where['type'] = C('TOPICS_TYPE.CAROUSEL');
		$this->_list($where);
		$this->display();
	}

	/**
	 * 公共列表方法
	 * @param  array $where 查询条件
	 */
	private function _list($where){
		$topicsModel = M('topics');
		$count = $topicsModel->where($where)->count();
		$page = new Page($count,C('PAGE_SIZE'));
		$pageShow = $page->show();
        $fields = 'id,name,summary,type,tag_name,image,thumb_image,start_time,end_time,status,sort';
		$list = $topicsModel->where($where)->field($fields)->order('id desc')->limit($page->firstRow,$page->listRows)->select();
		$this->page = $pageShow;
		$this->list = $list;
	}

    /**
     * 添加陵园专题
     */
    public function addCemeteryTopics(){
        $type = C('TOPICS_TYPE.CEMETERY');
        $this->_add($type);
    }

    /**
     * 添加节日主题
     */
    public function addFestivalTopics(){
        $type = C('TOPICS_TYPE.FESTIVAL');
        $this->_add($type);
    }

    /**
     * 添加专题横幅
     */
    public function addCarouselTopics(){
        $type = C('TOPICS_TYPE.CAROUSEL');
        $this->_add($type);
    }

    /**
     * 公共添加方法
     * @param int $type 类别id
     */
	private function _add($type){
        if(IS_POST){
            $result = array('flag'=>0,'msg'=>'添加失败');
    		$data = I('post.');
            $data['type'] = $type;
            $data['admin_id'] = session('admin_id');
            $data['created_time'] = date('Y-m-d H:i:s',time());
            $data['start_time'] = strtotime($data['start_time']);
            $data['end_time'] = strtotime($data['end_time']);
            // 判断添加的是不是节日专题，对summary进行处理
            if($type == C('TOPICS_TYPE.FESTIVAL')){
                $data['summary'] = $this->_handleSummary($data['summary']);
            }
            // 上传图片
    		$Img = $this->_uploadImg($type);
    		$data['image'] = $Img['image'];
    		$data['thumb_image'] = $Img['thumb_image'];

            $topicsModel = M('topics');
            if($topicsModel->data($data)->add()){
                $result = array('flag'=>1,'msg'=>'添加成功');
            }
        }
        echo json_encode($result);
	}

    /**
     * 编辑陵园专题
     */
    public function editCemeteryTopics(){
        $type = C('TOPICS_TYPE.CEMETERY');
        $this->_edit($type);
    }

    /**
     * 编辑节日专题
     */
    public function editFestivalTopics(){
        $type = C('TOPICS_TYPE.FESTIVAL');
        $this->_edit($type);
    }

    /**
     * 编辑专题横幅
     */
    public function editCarouselTopics(){
        $type = C('TOPICS_TYPE.CAROUSEL');
        $this->_edit($type);
    }

	/**
	 * 公共编辑方法
	 * @param  int    $type 专题类型
	 */
	private function _edit($type){
		$topicsModel = M('topics');
		if (IS_POST) {
            $result = array('flag'=>0,'msg'=>'修改失败');
            $info = I('post.');
            $info['created_time'] = date('Y-m-d H:i:s',time());
            $name = $info['name'];
            // 判断时间是否为空
            if(!empty($info['start_time']) && !empty($info['end_time'])){
	            $info['start_time'] = strtotime(I('start_time'));
	            $info['end_time'] = strtotime(I('end_time'));
            }
            // 判断添加的是不是节日专题，对summary进行处理
            if($type == C('TOPICS_TYPE.FESTIVAL')){
				$info['summary'] = $this->_handleSummary($info['summary']);
			}
            // 上传图片
            $Img = $this->_uploadImg($type,$info['id']);
            if(!empty($Img)){
                $info['image'] = $Img['image'];
                $info['thumb_image'] = $Img['thumb_image'];
            }

            if($topicsModel->data($info)->save()){
                $result = array('flag'=>1,'msg'=>'修改成功');
            }
        }else{
            $id = I('get.id');
            $fields = 'id,name,summary,type,tag_name,image,thumb_image,start_time,end_time,status,sort';
            $data = $topicsModel->field($fields)->where('id='.$id)->find();
            if(!empty($data['start_time']) && !empty($data['end_time'])){
                $data['start_time'] = date('Y-m-d',$data['start_time']);
                $data['end_time'] = date('Y-m-d',$data['end_time']);
            }
            $result['flag'] = 1;
            $result['data'] = $data;
        }
        echo json_encode($result);
	}

    /**
     * 公共上传图片方法
     * @param  int    $type  类别
     * @param  array  $id    用于查询旧图片的id
     * @return array
     */
	private function _uploadImg($type,$id=null){
		if ($_FILES['image']['error'] == 0 && !empty($_FILES['image']['tmp_name'])) {
            //判断$type类型，上传图片
            $ret = uploadOne('image', C('TOPICS_IMAGE'),C('TOPICS_THUMB'));
            if($type == C('TOPICS_TYPE.CAROUSEL')){
                $ret = uploadOne('image', C('TOPICS_IMAGE'),C('CAROUSEL_THUMB'));
            }
            // 根据id查出旧图片
            if(!empty($id)){
                $delImg = M('topics')->where("id=".$id)->field('image,thumb_image')->find();
                // 删除图片
                if(!empty($delImg)){
                	unlink('.'.$delImg['image']);
                	unlink('.'.$delImg['thumb_image']);
                }
            }
            if ($ret['ok'] == 0) {
                $this->error = $ret['error'];
                return FALSE;
            } else {
                $info['image'] = C('IMG_HOST') . $ret['images'][0];
                $info['thumb_image'] = C('IMG_HOST') . $ret['images'][1];
            }
            return $info;
        }
	}

	/**
     * 删除
     */
    public function del(){
        if(IS_POST){
            $postInfo = I('post.');
            $topicsModel = M('Topics');
            $result = array('flag'=>0,'msg'=>'操作失败');
            $data['id'] = $postInfo['id'];
            $data['status'] = $postInfo['act'];
            // 改变状态
            if($topicsModel->data($data)->save()){
                $result['flag'] = 1;
                $result['msg'] = '操作成功';
            }
            echo json_encode($result);
        }
    }

    /**
     * 把节日简介处理为A标签(用于前台跳转)
     * @param  array $summary 节日简介
     * @return array
     */
    private function _handleSummary($summary){
        $result = array();
        if(!empty($summary)){
            foreach ($summary as $key => $val) {
                $arr[$key] = '<a target="_blank" data-id="'.$key.'" title="'.$val.'" href="/news/detail/'.$key.'">'.$val.'</a>';
            }
            $result = implode('<br/>',$arr);
        }

        return $result;
    }

    /**
     * 检查数据重复
     */
    public function checkRepeat(){
        if(IS_POST){
            $topicsData = M('topics');
            // 接收条件
            $postInfo = I('post.');
            $result = array('flag'=>0,'msg'=>'');
            $info['type'] = $postInfo['type'];
            $info['name'] = $postInfo['name'];
            if(!empty($postInfo['id'])){
                // 查找不等于当前id的数据
                $info['id'] = array('neq',$postInfo['id']);
            }
            $data = $topicsData->where($info)->count();
            if(!empty($data)){
                $result = array('flag'=>1,'msg'=>'x 名称已存在');
            }
            echo json_encode($result);
        }
    }

    /**
     * 获取节日新闻
     * @param  string $name 用于模糊查询的节日名称
     * @return json
     */
    public function getNewsList(){
        if(IS_POST){
            $name = I('post.name');
            $newsModel = M('news');
            $data = array();
            // 接收条件
            $like = array(
                'category_id' => C('CATEGORY_TRADITIONAL_FESTIVAL'),
                'title' => array('like','%'.$name.'%'),
            );
            // 模糊查询新闻
            $newsTitle = $newsModel->where($like)->getField('id,title');
            if(!empty($newsTitle)){
                $data = $newsTitle;
            }
            $this->ajaxReturn($data,'JSON');
        }
    }
}
