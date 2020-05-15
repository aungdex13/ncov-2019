<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hospitals;
use App\Provinces;
use App\User;
use Illuminate\Support\Str;

class MasterController extends Controller
{
	public $result;

	public function __construct() {
		$this->result = null;
	}

	public function setStatus() {
		$status = collect([
			'pt_status' => [
				1 => 'PUI (รอผลแลป)',
				2 => 'Confirmed (ผลแลปยืนยัน)',
				3 => 'Probable',
				4 => 'Suspected',
				5 => 'Excluded (ผลแลปเป็นลบ)'
			],
			'news_st' => [
				1 => 'Confirmed publish',
				2 => 'Confirmed not yet released'
			],
			'disch_st' => [
				1 => 'Recovered',
				2 => 'Admitted',
				3 => 'Death',
				4 => 'Self quarantine'
			],
			'pui_type' => [
				1 => 'New PUI',
				2 => 'Contact PUI',
				3 => 'PUO',
				4 => 'Confirmed nCoV-2019'
			],
			'screen_pt' => [
				1 => 'คัดกรองที่สนามบิน',
				2 => 'Walkin มาที่ รพ.',
				3 => 'ผู้สัมผัส',
				4 => 'ผู้ถูกกักกัน',
				5 => 'Active Case Finding',
				6 => 'Sentinel Surveillance',
				7 => 'คัดกรอกก่อนทำหัตถการ',
				8 => 'ไม่ผ่านเกณฑ์ แต่แพทย์สงสัย',
				99 => 'อื่นๆ'
			],
			'arrfollowup_address' => [
				1 => 'บ้าน',
				2 => 'โรงแรม',
				3 => 'โรงพยาบาล',
				4 => 'สถานที่กักกัน',
				5 => 'อื่นๆ'
			],
			'pt_treat_status' => [
				1 => 'หาย',
				2 => 'ยังรักษาอยู่',
				3 => 'เสียชีวิต',
				4 => 'ส่งต่อ',
				5 => 'อื่นๆ'
			]

		]);
		return $status;
	}

	public function getStatus() {
		$status = $this->setStatus();
		return $status;
	}

	protected function selectStatus($status_name='name') {
		$status = $this->setStatus();
		return $status->get($status_name, null);
	}

	private function setDrug() {
		$drug = collect([
			'covid19' => [
				1 => 'Darunavir/Ritonavir (DRV/r)',
				2 => 'Lopinavir/Ritonavir (LPV/r)',
				3 => 'Favipiravir',
				4 => 'Chloroquine',
				5 => 'Hydroxychloroquine',
				6 => 'Oseltamivir',
				7 => 'Other'
			]
		]);
		return $drug;
	}

	public function getDrug($key=null) {
		$drug = $this->setDrug();
		if (!is_null($key)) {
			return $drug[$key];
		} else {
			return $drug;
		}
	}

	public function getHospitalType($hosp_code=0) {
		if (!empty($hosp_code) || $hosp_code != 0 || !is_null($hosp_code)) {
			$hospType = Hospitals::select('hosp_type_code')->where('hospcode', '=', $hosp_code)->first();
			if ($hospType != null) {
				$hospType = $hospType->toArray();
				$hosp_type = (int)$hospType['hosp_type_code'];
				if ($hosp_type <= 18) {
					if ($hosp_type == 15 || $hosp_type == 16) {
						$hospTypeName = 'โรงพยาบาลเอกชน';
					} else {
						$hospTypeName = 'โรงพยาบาลรัฐ';
					}
				} else {
					$hospTypeName = NULL;
				}
			} else {
				$hospTypeName = NULL;
			}
		} else {
			$hospTypeName = NULL;
		}
		return $hospTypeName;
	}

	protected function arrayToString($array=array()) {
		$str = NULL;
		if (count($array) > 0) {
			foreach ($array as $key => $value) {
				if (is_null($str)) {
					$str = "";
				} else {
					$str = $str.",";
				}
				$str = $str.$value;
			}
		}
		return $str;
	}

	protected function getProvCodeByRegion($region=0) {
		$prov_code = Provinces::select('province_id')
			->where('zone_id', '=', $region)
			->get()->keyBy('province_id');
		$prov_code_list = $prov_code->keys()->all();
		return $prov_code_list;
	}

	private function getHospCodeByHospCode() {
		$user_hosp_code = auth()->user()->hospcode;
		$hosp_code = User::select('hospcode')->where('hospcode', '=', $user_hosp_code)->get();
		$hosp_code_arr = $hosp_code->pluck('hospcode')->toArray();
		return $hosp_code_arr;
	}


	private function getPhoUserByProv() {
		$prov_code = auth()->user()->prov_code;
		$users = User::select('id')->where('prov_code', '=', $prov_code)->get()->toArray();
		$user_arr = array();
		foreach ($users as $key => $val) {
			array_push($user_arr, $val['id']);
		}
		return $user_arr;
	}

	private function getUserByHospCode() {
		$hosp_code = auth()->user()->hosp_code;
		$users = User::select('id')->where('hospcode', '=', $hosp_code)->get()->toArray();
		$user_arr = array();
		foreach ($users as $key => $val) {
			array_push($user_arr, $val['id']);
		}
		return $user_arr;
	}

}
