@extends('layouts.index')
@section('custom-style')
	<link rel='stylesheet' href="{{ URL::asset('assets/libs/datatables-1.10.20/datatables.min.css') }}">
	<link rel='stylesheet' href="{{ URL::asset('assets/libs/datatables-1.10.20/Buttons-1.6.1/css/buttons.bootstrap4.min.css') }}">
	<link rel='stylesheet' href="{{ URL::asset('assets/libs/datatables-1.10.20/Responsive-2.2.3/css/responsive.bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('assets/libs/select2/dist/css/select2.min.css') }}">
	<link rel='stylesheet' href="{{ URL::asset('assets/libs/bootstrap-select-1.13.9/dist/css/bootstrap-select.min.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('assets/libs/toastr/build/toastr.min.css') }}">
@endsection
@section('internal-style')
<style>
@media
	only screen
	and (max-width: 760px), (min-device-width: 768px)
	and (max-device-width: 1024px)  {
	/* Force table to not be like tables anymore */
	table, thead, tbody, th, td, tr {
		display: block !important;
	}
	/* Hide table headers (but not display: none;, for accessibility) */
	thead tr {
		position: absolute !important;
		top: -9999px !important;
		left: -9999px !important;
	}
	tr {
		margin: 0 0 1rem 0 !important;
	}
	tr:nth-child(odd) {
		background: #eee;
	}
	td {
		/* Behave like a "row" */
		/* border: none; */
		border-bottom: 1px solid #eee;
		position: relative !important;
		padding-left: 50% !important;
	}
	td:before {
		/* Now like a table header */
		position: absolute !important;
		/* Top/left values mimic padding */
		top: 0 !important;
		left: 6px !important;
		width: 45% !important;
		padding-right: 10px !important;
		white-space: nowrap !important;
	}
	/* Label the data */
	td:nth-of-type(1):before { content: "ID";margin-top:10px;font-weight:600;}
	td:nth-of-type(2):before { content: "SAT_ID";margin-top:10px;font-weight:600;}
	td:nth-of-type(3):before { content: "Patient";margin-top:10px;font-weight:600;}
	td:nth-of-type(4):before { content: "News";margin-top:10px;font-weight:600;}
	td:nth-of-type(5):before { content: "Discharge";margin-top:10px;font-weight:600;}
	td:nth-of-type(6):before { content: "Sex";margin-top:10px;font-weight:600;}
	td:nth-of-type(7):before { content: "Nationality";margin-top:10px;text-align:left!important;font-weight:600;}
	td:nth-of-type(8):before { content: "#";margin-top:10px;text-align:left!important;font-weight:600;}
}
/* end media */

.error{
	display: none;
	margin-left: 10px;
}

.error_show{
	color: red;
	margin-left: 10px;
}
input.invalid, textarea.invalid{
	border: 2px solid red;
}

input.valid, textarea.valid{
	border: 2px solid green;
}
.dataTables_wrapper {
	font-family: tahoma !important;
}
</style>
@endsection
@section('contents')
<div class="page-breadcrumb">
	<div class="row">
		<div class="col-12 d-flex no-block align-items-center">
			<div class="ml-auto text-right">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">indexcase</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="d-md-flex align-items-center mb-2">
						<div>
							<h4 class="card-title">แบบติดตามผู้สัมผัสโรคปอดอักเสบจากเชื้อไวรัสโคโรนาสายพันธุ์ใหม่ 2019</h4>
							<h5 class="card-subtitle">COVID-19</h5>
						</div>
					</div>
					<br>
					<div class="col-md-12">
						<a class="btn btn-warning" href="{{ route('contactfollowtable') }}" class="sidebar-link"><i class="mdi mdi-account-multiple"></i><span class="hide-menu"> FollowUp Contact</span></a>
					<a class="btn btn-success" href="{{ route('puifollowtable') }}" class="sidebar-link"><i class="fas fa-diagnoses"></i><span class="hide-menu"> FollowUp PUI</span></a>
					</div>
					<br>
				<br>
					<div class="table-responsive">
          <table id="example" class="table display mb-4" role="table">
        <thead>
            <tr>
							<th>ID</th>
                <th>Contact ID</th>
								<th>เพศ</th>
								<th>อายุ</th>
                <th>ที่อยู่ในประเทศไทย</th>
                <th>สัญชาติ</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
					<?php foreach($contact_data as $value) : ?>
            <tr>
								<td>{{ $value->conid }}</td>
                <td>{{ $value->contact_id }}</td>
								<td>{{ $value->sex_contact }}</td>
                <td>{{ $value->age_contact }}</td>
								<td>{{ (isset($arrprov[$value->province])) ? $arrprov[$value->province] : "" }}
										{{ (isset($arrdistrict[$value->district])) ? $arrdistrict[$value->district] : "" }}
										{{ (isset( $arr_sub_district[$value->sub_district])) ? $arr_sub_district[$value->sub_district] : "" }}
								</td>
								<td>{{ (isset($nation_list[$value->national_contact])) ? $nation_list[$value->national_contact] : "" }}</td>
								<td>
									{{-- <button type="button" class="btn btn-success btn-sm margin-5 text-white chstatusfu" data-toggle="modal" title="Change status" data-target="#chstatusfu">ST</button> --}}
									{{-- <a class="btn btn-danger btn-sm" href="{{ route('contactfollowtable',$value->contact_id)}}"> --}}
										<a class="btn btn-success btn-sm" data-toggle="tooltip" title="Follow up table" data-placement="top" target="_blank" href="/ncov-2019/{{ 'followuptablescon'}}/typid/2/id/{{ $value->contact_id }}">
											FU
									</a>
									{{-- <a class="btn btn-info btn-sm" href="{{ route('detailcontact',$value->contact_id)}}"> --}}
										<a class="btn btn-info btn-sm" data-toggle="tooltip" title="Info" data-placement="top" href="{{ 'detailcontact'}}/contact_id/{{ $value->contact_id }}">
										Info
								</a>
								{{-- <a class="btn btn-warning btn-sm" href="{{'editcontact'}}/contact_id/{{ $value->contact_id }}"> --}}
									{{-- <a class="btn btn-warning btn-sm" data-toggle="tooltip" title="Edit" data-placement="top" href="#"> --}}
										{{-- Edit --}}
								</a>
								</td>
            </tr>
						<?php endforeach;?>
        </tbody>
    </table>
	</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
@section('bottom-script')
	<script src="{{ URL::asset('assets/libs/datatables-1.10.20/datatables.min.js') }}"></script>
	<script src="{{ URL::asset('assets/libs/datatables-1.10.20/Buttons-1.6.1/js/buttons.bootstrap4.min.js') }}"></script>
	<script src="{{ URL::asset('assets/libs/datatables-1.10.20/Responsive-2.2.3/js/responsive.bootstrap.min.js') }}"></script>
	<script src="{{ URL::asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
	<script src="{{ URL::asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
	<script src="{{ URL::asset('assets/libs/bootstrap-select-1.13.9/dist/js/bootstrap-select.min.js') }}"></script>
<script>
$(document).ready(function() {
    $('#example').DataTable();
			} );
</script>
{{-- <script>

document.getElementById("btnPrint").onclick = function () {
    printElement(document.getElementById("printThis"));
}

function printElement(elem) {
    var domClone = elem.cloneNode(true);

    var $printSection = document.getElementById("printSection");

    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }

    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
}
</script> --}}
<script>
$('#date_change_st').datepicker({
	format: 'dd/mm/yyyy',
	todayHighlight: true,
	todayBtn: true,
	autoclose: true
});

</script>
@endsection
