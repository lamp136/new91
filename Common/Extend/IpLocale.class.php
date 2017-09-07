<?php
namespace Common\Extend;
/**
 * 根据登录人的ip获取所在的地区
 *
 * @author hgy
 *
 */
class IpLocale
{
	/**
	 * 获取省市的ID
	 *
	 * @return array
	 */
	public function getProvinceCityId($ip) {
		$allCountry = array('name'=>'全国', 'provid'=>2);
		if (empty($ip)) {
			return $allCountry;
		}
		$sessionkey = md5('91'.$ip.'sm');
		//判断session 中是否存在直接获取否则需要计算
		$sessionVal = Session($sessionkey);

		if ($sessionVal) {
			return json_decode(Session($sessionkey), true);
		} else {

			$Ip = new \Org\Net\IpLocation('UTFWry.dat'); // 实例化类
			$location = $Ip->getlocation($ip); // 获取某个IP地址所在的位置
			$prct = include ("place_pc.php");  //导入拆分的文件
			$prov_id = 0;
			$city_id = 0;
			$provinceCity = isset($location['country']) && !empty($location['country']) ? $location['country'] : '';
			//中国带有省的地区
			if (strpos($provinceCity, '省')){
				$provinceCityArr = explode('省', $provinceCity);
				$shortName = substr(trim($provinceCityArr[0]), 0, 6);
				$provname = $provinceCityArr[0];
				$cityname = $provinceCityArr[1];
				$prov_id =  $prct[$provname];
			}
			//中国直辖市
			if (!$prov_id && strpos($provinceCity, '市') ) {
				$provinceCityArr = explode('市', $provinceCity);
				$shortName = substr(trim($provinceCityArr[0]), 0, 6);
				$provname = $provinceCityArr[0];
				$cityname = $provinceCityArr[1];
				$prov_id =  $prct[$provname];
			}
			//特殊地区 获取前两个字
			//(内蒙  广西  宁夏  新疆  西藏 香港  澳门)
			if(!$prov_id){
				$shortName = substr(trim($provinceCity), 0, 6);
				if(isset($prct[$shortName]) ){
					$prov_id = $prct[$shortName];
				}
			}
			if (empty($prov_id)) {
				$valArr = $allCountry;
			} else {
				$valArr = array('name'=>$shortName, 'provid'=>$prov_id);
			}
			Session($sessionkey, json_encode($valArr));//写入session

			return $valArr;
		}
	}

}