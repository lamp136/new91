<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Model;
/**
 * 主要用来手动的处理数据
 *
 * @author hgy
 *
 */
class HandleDataController extends Controller
{
	/**
	 * 合同数据信息导入到新的数据表中
	 */
	public function handleStoreProfiles() {
		$where['status'] = array('gt', 0);
		$count = M('profiles')->field('id')->where($where)->count();
		$perPage = 10;
		if ($count > 0) {
			$totalPages = ceil($count / $perPage);
			for($i = 0; $i<$totalPages; $i++) {
				//分页获取原始表的数据
				$oldDatas = M('profiles')->where($where)->page($i+1, $perPage)->select();
				$tmpCount = count($oldDatas[0]);
				$mainData = array();
				$detailData =array();
				$j = 0;
				if ($tmpCount > 0)  {
					foreach ($oldDatas as $oldData) {
						if (empty($oldData['s_name'])) {
							continue;
						}//dump($oldData);die;
						$tmpMainData = array();
						$tmpDetailData = array();

						$tmpMainData['id'] = (int)$oldData['id'];
						$tmpMainData['show_store_name'] = $oldData['s_name'];
						$tmpMainData['province_id'] = $oldData['province_id'];
						$tmpMainData['city_id'] = $oldData['city_id'];
						$tmpMainData['address'] = $oldData['address'];
						$tmpMainData['admin_id'] = 1;
						$tmpMainData['created_time'] = $oldData['created_time'];
						//$id = M('store_profiles')->add($tmpMainData);
						$tmpDetailData['profiles_id'] = $oldData['id'];
						$tmpDetailData['profile_name'] = $oldData['store_name'];
						$tmpDetailData['category_id'] = $oldData['category_id'];
						$tmpDetailData['category_pid'] = $oldData['category_pid'];
						$tmpDetailData['contact_man'] = $oldData['contact_man'];
						$tmpDetailData['telephone'] = $oldData['telephone'];
						$tmpDetailData['mobile'] = $oldData['mobile'];
						$tmpDetailData['fax'] = $oldData['fax'];
						$tmpDetailData['member_status'] = $oldData['member_status'];
						$tmpDetailData['start_time'] = $oldData['start_time'];
						$tmpDetailData['end_time'] = $oldData['end_time'];
						$tmpDetailData['principal_id'] =1;
						$tmpDetailData['principal'] = '管理员';
						$tmpDetailData['status'] = $oldData['status'];
						$tmpDetailData['return_amount'] = $oldData['return_pesent_amount'];
						$tmpDetailData['settlement_time'] = $oldData['settlement_time'];
						$tmpDetailData['remarks'] = $oldData['remarks'];
						$tmpDetailData['commitment'] = '';
						$tmpDetailData['updated_time'] = $oldData['updated_time'];
						$mainData[$j] = $tmpMainData;
						$detailData[$j] = $tmpDetailData;

						$j++;
					}//end foreach

					$model = M('store_profiles');
					$model->startTrans();
					$ret = $model->addAll($mainData);
					if ($ret) {
						$result = M('store_profiles_detail')->addAll($detailData);
						if ($result) {
							$model->commit();
						} else {
							$model->rollback();
							echo "第".$i."次详细信息插入失败";
						}
					} else {
						$model->rollback();
						echo "第".$i."次主要信息插入失败";
					}

				}
				echo "我是第".$i."次循环<br />";
			}
		}
	}
	/**
	 * 处理商家数据
	 */
	public function handStore() {
		//首先从SP数据表获取数据
		$profileDatas = array();
		$model = M();
		$fields = 'dsp.profiles_id, dsp.member_status, sp.store_id';
		$profileDetailDatas = $model->table('hgy91_store_profiles_detail dsp, hgy91_sp sp')->field($fields)->where('dsp.profiles_id = sp.store_profiles_id')->select();
		//dump($profileDetailDatas);die;
		$tmpData = array();
		if ($profileDetailDatas) {
			foreach ($profileDetailDatas as $profileDetailData) {
		 		/* $tmpStoreData[] = array(
						'store_id'=>$profileDetailData['store_id'],
						'store_profiles_id' => $profileDetailData['store_profiles_id'],
						'member_status' => $profileDetailData['member_status']

				); */
				//var_dump($profileDetailData);
				$tmpData['store_profiles_id'][$profileDetailData['store_id']] = $profileDetailData['profiles_id'];
				$tmpData['member_status'][$profileDetailData['store_id']] = $profileDetailData['member_status'];
			}
			//dump($tmpStoreData);
			$ret = saveAllData($tmpData, 'stores', 'store_id');
			//$ret = M('stores')->addAll($tmpData);
			if ($ret) {
				echo "更新成功";
			} else {
				echo "更新失败";
			}
		}



	}
}