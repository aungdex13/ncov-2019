<?php
namespace App\DataTables;

use App\ContactList;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use App\Http\Controllers\MasterController;
use App\GlobalCountry;
use App\Provinces;
use App\District;
use App\SubDistrict;
use Session;
use DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ListContactDataTable  extends DataTable
{

	private function status() {
		$master = new MasterController;
		$status = $master->getStatus();
		return $status;
	}

	private function casePtStatus() {
		$status = $this->status();
		$str = "";
		foreach ($status['pt_status'] as $key => $value) {
			$str .= "WHEN pt_status = \"".$key."\" THEN \"".$value."\" ";
		}
		return $str;
	}

	private function caseNewsSt() {
		$status = $this->status();
		$str = "";
		foreach ($status['news_st'] as $key => $value) {
			$str .= "WHEN news_st = \"".$key."\" THEN \"".$value."\" ";
		}
		return $str;
	}

	private function caseDischSt() {
		$status = $this->status();
		$str = "";
		foreach ($status['disch_st'] as $key => $value) {
			$str .= "WHEN disch_st = \"".$key."\" THEN \"".$value."\" ";
		}
		return $str;
	}
	private function caseStatusFollowup() {
		$status = $this->status();
		$str = "";
		foreach ($status['status_followup'] as $key => $value) {
			$str .= "WHEN status_followup = \"".$key."\" THEN \"".$value."\" ";
		}
		return $str;
	}
	private function caserisk_contact() {
		$status = $this->status();
		$str = "";
		foreach ($status['risk_contact'] as $key => $value) {
			$str .= "WHEN risk_contact = \"".$key."\" THEN \"".$value."\" ";
		}
		return $str;
	}
	private function caseNation() {
		$query_globalcountry = GlobalCountry::all()->toArray();
		$str = "";
		foreach ($query_globalcountry as $key => $value) {
			$str .= "WHEN nation = \"".$value['country_id']."\" THEN \"".$value['country_name']."\" ";
		}
		return $str;
	}
	private function caseProvince() {
		$query_province = Provinces::all()->toArray();
		$str = "";
		foreach ($query_province as $key => $value) {
			$str .= "WHEN province = \"".$value['province_id']."\" THEN \"".$value['province_name']."\" ";
		}
		return $str;
	}
	private function caseDistrict() {
		$query_district = District::all()->toArray();
		$str = "";
		foreach ($query_district as $key => $value) {
			$str .= "WHEN district = \"".$value['district_id']."\" THEN \"".$value['district_name']."\" ";
		}
		return $str;
	}
	private function caseSubDistrict() {
		$query_sub_district = SubDistrict::all()->toArray();
		$str = "";
		foreach ($query_sub_district as $key => $value) {
			$str .= "WHEN sub_district = \"".$value['sub_district_id']."\" THEN \"".$value['sub_district_name']."\" ";
		}
		return $str;
	}

	public function dataTable($query) {
		$province = $this->caseProvince();
		$district = $this->caseDistrict();
		$sub_district = $this->caseSubDistrict();
		return datatables()
			->eloquent($query)
			->filterColumn('province', function($query, $keyword) use ($province) {
				$query->whereRaw('(CASE '.$province.' ELSE "-" END) like ?', ["%{$keyword}%"]);
			})
			->filterColumn('district', function($query, $keyword) use ($district) {
				$query->whereRaw('(CASE '.$district.' ELSE "-" END) like ?', ["%{$keyword}%"]);
			})
			->filterColumn('sub_district', function($query, $keyword) use ($sub_district) {
				$query->whereRaw('(CASE '.$sub_district.' ELSE "-" END) like ?', ["%{$keyword}%"]);
			})
			->filterColumn('full_name', function($query, $keyword) {
				$query->whereRaw("CONCAT(name_contact, ' ', lname_contact) like ?", ["%{$keyword}%"]);
			})
			->editColumn('sat_id', function($sid) {
				if (!isset($sid->sat_id) || empty($sid->sat_id)) {
					$sid_rs = "<span class=\"badge badge-light font-0875\">-</span>";
				} else {
					$sid_rs = "<span class=\"badge badge-light font-1\">".$sid->sat_id."</span>";
				}
				return $sid_rs;
			})
			->editColumn('pt_status', function($pts) {
				if (!isset($pts->pt_status) || empty($pts->pt_status)) {
					$pts_rs = "-";
				} else {
					switch (mb_strtolower($pts->pt_status)) {
						case "pui (รอผลแลป)" :
							$pts_rs = "<span class=\"badge badge-light font-1\">".$pts->pt_status."</span>";
							break;
						case "confirmed (ผลแลปยืนยัน)" :
							$pts_rs = "<span class=\"badge badge-danger font-1\">".$pts->pt_status."</span>";
							break;
						case "probable" :
							$pts_rs = "<span class=\"badge badge-warning font-1\">".$pts->pt_status."</span>";
							break;
						case "suspected" :
							$pts_rs = "<span class=\"badge badge-custom-1 font-1\">".$pts->pt_status."</span>";
							break;
						case "excluded (ผลแลปเป็นลบ)" :
							$pts_rs = "<span class=\"badge badge-success font-1\">".$pts->pt_status."</span>";
							break;
						default :
							$pts_rs = $pts->pt_status;
							break;
					}
				}
				return $pts_rs;
			})
			->editColumn('disch_st', function($disc) {
				switch ($disc->disch_st) {
					case "Admitted" :
						$pts_rs = '<span class="badge badge-custom-2 font-1">'.$disc->disch_st.'</span>';
						break;
					case "Recovered" :
						$pts_rs = '<span class="badge badge-success font-1">'.$disc->disch_st.'</span>';
						break;
					case "Death" :
						$pts_rs = '<span class="badge badge-secondary font-1">'.$disc->disch_st.'</span>';
						break;
					case "Self quarantine":
						$pts_rs = '<span class="badge badge-custom-5 font-1">'.$disc->disch_st.'</span>';
						break;
					default:
						$pts_rs = '<span class="badge badge-light font-1">'.$disc->disch_st.'</span>';
						break;
				}
				return $pts_rs;
			})
			->editColumn('inv', function($iv) {
				if (!isset($iv->inv) || empty($iv->inv)) {
					$inv_rs = "<span class=\"badge badge-light\">-</span>";
				} elseif ($iv->inv == 'y') {
					$inv_rs = "<span class=\"badge badge-custom-3\"><i class=\"fa fa-check-circle\"></i> Investigated</span>";
				} else {
					$inv_rs = "-";
				}
				return $inv_rs;
			})
			->addColumn('action',
				/*
				'<a href="http://viral.ddc.moph.go.th/viral/lab/genlab.php?idx={{ $sat_id }}" target="_blank" title="GenLAB" class="btn btn-cyan btn-sm">GenLAB</a>
				<a href="http://viral.ddc.moph.go.th/viral/lab/labfollow.php?idx={{ $sat_id }}" target="_blank" title="LabResult" class="btn btn-primary btn-sm">LabResult</a>
				<button class="btn btn-custom-6 btn-sm chstatus" value="{{ $id }}" id="invest_idx{{ $id }}" title="{{ $id }}">Status</button>
				 <a href="{{ route("screenpui.edit", $id) }}" title="Invest form" class="btn btn-warning btn-sm">Edit</a> */
				 '<button class="context-nav btn btn-custom-7 btn-sm" data-pui_id="{{ $pui_id }}" data-contact_id="{{ $contact_id }}" data-id="{{ $id }}">Manage <i class="fas fa-bars"></i></button>')
			->rawColumns(['sat_id', 'pt_status', 'disch_st', 'inv', 'action']);
	}

	public function query(ContactList $model) {
		$user_role = Session::get('user_role');
		$user_hosp = auth()->user()->hospcode;
		$user_prov = auth()->user()->prov_code;
		$user_region = auth()->user()->region;
		$uid_chosbyregion = DB::table('chospital_new')
												->select('prov_code')
												->where('region', $user_region)
												->groupBy('prov_code')
												->get()->keyBy('prov_code');
		$uid_chosbyregion = $uid_chosbyregion->keys()->toArray();
		// dd($user_prov);
		$pts = $this->casePtStatus();
		$ns = $this->caseNewsSt();
		$dcs = $this->caseDischSt();
		$nation = $this->caseNation();
		$province = $this->caseProvince();
		$district = $this->caseDistrict();
		$sub_district = $this->caseSubDistrict();
		$status_followup = $this->caseStatusFollowup();
		$risk_contact = $this->caserisk_contact();
		switch ($user_role) {
			case 'root':
		$contact = ContactList::select(
			'id',
			'pui_id',
			'sat_id',
			'user_id',
			'contact_id',
			'age_contact',
			'risk_contact',
			'phone_contact',
			// 'status_followup',
			\DB::raw('(CASE '.$status_followup.' ELSE "อยู่ระหว่างการติดตาม" END) AS status_followup'),
			\DB::raw("CONCAT(name_contact, ' ', lname_contact) as full_name"),
			\DB::raw('(CASE '.$province.' ELSE "-" END) AS province'),
			\DB::raw('(CASE '.$district.' ELSE "-" END) AS district'),
			\DB::raw('(CASE '.$sub_district.' ELSE "-" END) AS sub_district'),
			)
			// ->where('pt_status',"!=" , "2")
			// ->where('pt_status','!=',"2")
			->whereNull('deleted_at')
			->orderBy('id');
			break;
			case 'ddc':
				$contact = ContactList::select(
					'id',
					'pui_id',
					'sat_id',
					'contact_id',
					'age_contact',
					\DB::raw('(CASE '.$risk_contact.' ELSE "ไม่ระบุความเสี่ยง" END) AS risk_contact'),
					'phone_contact',
					\DB::raw('(CASE '.$status_followup.' ELSE "อยู่ระหว่างการติดตาม" END) AS status_followup'),
					\DB::raw("CONCAT(name_contact, ' ', lname_contact) as full_name"),
					\DB::raw('(CASE '.$province.' ELSE "-" END) AS province'),
					\DB::raw('(CASE '.$district.' ELSE "-" END) AS district'),
					\DB::raw('(CASE '.$sub_district.' ELSE "-" END) AS sub_district'),
					)
					// ->where('pt_status',"!=" , "2")
					->whereNull('deleted_at')
					->orderBy('id');

					break;
					case 'dpc':
						$contact = ContactList::select(
							'id',
							'pui_id',
							'sat_id',
							'contact_id',
							'age_contact',
							\DB::raw('(CASE '.$risk_contact.' ELSE "ไม่ระบุความเสี่ยง" END) AS risk_contact'),
							'phone_contact',
							\DB::raw('(CASE '.$status_followup.' ELSE "อยู่ระหว่างการติดตาม" END) AS status_followup'),
							\DB::raw("CONCAT(name_contact, ' ', lname_contact) as full_name"),
							\DB::raw('(CASE '.$province.' ELSE "-" END) AS province'),
							\DB::raw('(CASE '.$district.' ELSE "-" END) AS district'),
							\DB::raw('(CASE '.$sub_district.' ELSE "-" END) AS sub_district'),
						)
							// ->where('pt_status',"!=" , "2")
							// ->wherein('province',$uid_chosbyregion)
							->whereNull('deleted_at')
							->orderBy('id');

							break;
							case 'pho':
								$contact = ContactList::select(
									'id',
									'pui_id',
									'sat_id',
									'contact_id',
									'age_contact',
									\DB::raw('(CASE '.$risk_contact.' ELSE "ไม่ระบุความเสี่ยง" END) AS risk_contact'),
									'phone_contact',
									\DB::raw('(CASE '.$status_followup.' ELSE "อยู่ระหว่างการติดตาม" END) AS status_followup'),
									\DB::raw("CONCAT(name_contact, ' ', lname_contact) as full_name"),
									\DB::raw('(CASE '.$province.' ELSE "-" END) AS province'),
									\DB::raw('(CASE '.$district.' ELSE "-" END) AS district'),
									\DB::raw('(CASE '.$sub_district.' ELSE "-" END) AS sub_district'),
									)
									->where('province', $user_prov)
									->whereNull('deleted_at')
									->orderBy('id');

									break;

									
									case 'hos':
										$contact = ContactList::select(
											'id',
											'pui_id',
											'sat_id',
											'contact_id',
											'age_contact',
											'phone_contact',
											\DB::raw('(CASE '.$risk_contact.' ELSE "ไม่ระบุความเสี่ยง" END) AS risk_contact'),
											\DB::raw('(CASE '.$status_followup.' ELSE "อยู่ระหว่างการติดตาม" END) AS status_followup'),
											\DB::raw("CONCAT(name_contact, ' ', lname_contact) as full_name"),
											\DB::raw('(CASE '.$province.' ELSE "-" END) AS province'),
											\DB::raw('(CASE '.$district.' ELSE "-" END) AS district'),
											\DB::raw('(CASE '.$sub_district.' ELSE "-" END) AS sub_district'),
											)
											->where('province', $user_prov)
											->whereNull('deleted_at')
											->orderBy('id');

											break;
			default:
				return redirect()->route('logout');
				break;
		}
		return $contact;
	}

	public function html() {
		return $this->builder()
			->setTableId('list-data-table')
			->columns($this->getColumns())
			->minifiedAjax()
			->dom('Bfrtip')
			->orderBy(0)
			->responsive(true)
			->parameters(
				[ "language"=>[
						"url" => "/assets/libs/datatables-1.10.20/i18n/thai.json"
					]
				]
			)
			->lengthMenu([20]);
			/*
			->buttons(
				Button::make('create'),
				Button::make('export'),
				Button::make('print'),
				Button::make('reset'),
				Button::make('reload')

			); */
	}

	protected function getColumns() {
		return [
			// Column::make('pui_id')->title('ลำดับ SAT-ID'),
			// Column::make('sat_id')->title('SAT-ID'),
			Column::make('id')->title('ลำดับ Contact-ID'),
			Column::make('contact_id')->title('Contact-ID'),
			Column::make('full_name')->title('ชื่อ-สกุล'),
			Column::make('age_contact')->title('อายุ'),
			Column::make('phone_contact')->title('เบอร์โทร'),
			Column::make('province')->title('จังหวัดที่อยู่'),
			Column::make('district')->title('อำเภอที่อยู่'),
			Column::make('sub_district')->title('ตำบลที่อยู่'),
			Column::make('risk_contact')->title('ระดับความเสี่ยง'),
			Column::make('status_followup')->title('สถานะการติดตาม'),
			Column::computed('action')
				->exportable(false)
				->printable(false)
				->addClass('text-left')
				->title('#'),
			];
	}

	protected function filename() {
		return 'DataList_' . date('YmdHis');
	}
}
