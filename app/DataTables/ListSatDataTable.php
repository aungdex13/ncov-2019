<?php
namespace App\DataTables;

use App\InvestList;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use App\Http\Controllers\MasterController;
use App\GlobalCountry;
use Session;
use DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ListSatDataTable extends DataTable
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

	private function caseNation() {
		$query_globalcountry = GlobalCountry::all()->toArray();
		$str = "";
		foreach ($query_globalcountry as $key => $value) {
			$str .= "WHEN nation = \"".$value['country_id']."\" THEN \"".$value['country_name']."\" ";
		}
		return $str;
	}

	public function dataTable($query) {
		$pts = $this->casePtStatus();
		$ns = $this->caseNewsSt();
		$dcs = $this->caseDischSt();
		$nation = $this->caseNation();

		return datatables()
			->eloquent($query)
			->filterColumn('pt_status', function($query, $keyword) use ($pts) {
				$query->whereRaw('(CASE '.$pts.' ELSE "-" END) like ?', ["%{$keyword}%"]);
			})
			->filterColumn('news_st', function($query, $keyword) use ($ns) {
				$query->whereRaw('(CASE '.$ns.' ELSE "-" END) like ?', ["%{$keyword}%"]);
			})
			->filterColumn('disch_st', function($query, $keyword) use ($dcs) {
				$query->whereRaw('(CASE '.$dcs.' ELSE "-" END) like ?', ["%{$keyword}%"]);
			})
			->filterColumn('nation', function($query, $keyword) use ($nation) {
				$query->whereRaw('(CASE '.$nation.' ELSE "-" END) like ?', ["%{$keyword}%"]);
			})
			->filterColumn('full_name', function($query, $keyword) {
				$query->whereRaw("CONCAT(first_name, ' ', last_name) like ?", ["%{$keyword}%"]);
			})
			->filterColumn('ext_name', function($query, $keyword) {
				$query->whereRaw("CONCAT(first_name, ' ', LEFT(last_name, 3), '_') like ?", ["%{$keyword}%"]);
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
				 '<button class="context-nav btn btn-custom-7 btn-sm" data-satid="{{ $sat_id }}" data-id="{{ $id }}">Manage <i class="fas fa-bars"></i></button>')
			->rawColumns(['sat_id', 'pt_status', 'disch_st', 'inv', 'action']);
	}

	public function query(InvestList $model) {
		$pts = $this->casePtStatus();
		$ns = $this->caseNewsSt();
		$dcs = $this->caseDischSt();
		$nation = $this->caseNation();

		$invest = InvestList::select(
			'id',
			'sat_id',
			\DB::raw("CONCAT(first_name, ' ', last_name) as full_name"),
			\DB::raw("CONCAT(first_name, ' ', LEFT(last_name, 3), '_') as ext_name"),
			\DB::raw('(CASE '.$pts.' ELSE "-" END) AS pt_status'),
			\DB::raw('(CASE '.$ns.' ELSE "-" END) AS news_st'),
			\DB::raw('(CASE '.$dcs.' ELSE "-" END) AS disch_st'),
			'sex',
			\DB::raw('(CASE '.$nation.' ELSE "-" END) AS nation'),
			'inv')->whereNull('deleted_at')->orderBy('id');

		return $invest;
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
			Column::make('sat_id')->title('SatID'),
			Column::make('full_name')->visible(false),
			Column::make('ext_name')->title('ชื่อ-สกุล'),
			Column::make('pt_status')->title('สถานะ'),
			Column::make('news_st')->title('แถลงข่าว'),
			Column::make('disch_st')->title('Discharge'),
			Column::make('sex')->title('เพศ'),
			Column::make('nation')->title('สัญชาติ'),
			Column::make('inv')->title('สอบสวนโรค'),
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
