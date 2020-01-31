@extends('layouts.index')
@section('custom-style')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-select-1.13.9/dist/css/bootstrap-select.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/toastr/build/toastr.min.css') }}">
<style>
input:-moz-read-only { /* For Firefox */
	background-color: #fafafa !important;
}
input:read-only {
	background-color: #fafafa !important;
}
</style>
@endsection
@section('contents')
<div class="page-breadcrumb">
	<div class="row">
		<div class="col-12 d-flex no-block align-items-center">
			<h4 class="page-title">WalkIN</h4>
			<div class="ml-auto text-right">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">Form WalkIN</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<div class="card">
				<div class="card-body">

					<div class="d-md-flex align-items-center mb-2">
						<div>
							<h4 class="card-title">แบบสอบสวนของผู้ป่วยโรคปอดอักเสบจากเชื้อไวรัสโคโรนาสายพันธุ์ใหม่ 2019</h4>
							<h5 class="card-subtitle">2019-nCoV</h5>
						</div>
					</div>
					<form action="<?php echo url()->current(); ?>" method="POST" class="form-horizontal">
						{{ csrf_field() }}
						<h3 class="text-primary">ส่วนที่ 1</h3>
						<div class="bd-callout bd-callout-info" style="margin-top:0;position:relative">
							<div class="card">
								<div class="card-body">
									<h1 class="text-info">1. ข้อมูลทั่วไปของผู้ป่วย</h1>
									<div class="form-group row">
                                    <label class="col-md-3">ประเภทผู้ป่วย</label>
                                    <div class="col-md-9">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="customControlValidation1" value="1" name="screen_pt" required="">
                                            <label class="custom-control-label" for="customControlValidation1">คัดกรองที่สนามบิน</label>
                                        </div>
                                         <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="customControlValidation2" value="2" name="screen_pt" required="">
                                            <label class="custom-control-label" for="customControlValidation2">walkin</label>
                                        </div>
                                    </div>
                  </div>
									<div class="form-row">
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3">
											<label for="dowork">WalkIn มาที่ รพ.</label>
											<input type="text" name="walkinplace_hosp" class="form-control" placeholder="ชื่อ รพ.">
										</div>
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3">
											<div class="form-group">
												<label for="informant">มีห้อง Neagtive pressure หรือไม่</label>
												<div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" value="Y" class="custom-control-input" id="customControlValidation1" name="negative_pressure" required="">
														<label class="custom-control-label" for="customControlValidation1">มี</label>
													</div>
													 <div class="custom-control custom-radio custom-control-inline">
															<input type="radio" value="N" class="custom-control-input" id="customControlValidation2" name="negative_pressure" required="">
															<label class="custom-control-label" for="customControlValidation2">ไม่มี</label>
													</div>
												</div>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-4">
											<div class="form-group">
												<label for="informant">มีรถ Refer ผู้ป่วยหรือไม่ หรือไม่</label>
												<div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" value="Y" class="custom-control-input" id="customControlValidation3" name="refer_car" required="">
														<label class="custom-control-label" for="customControlValidation3">มี</label>
													</div>
													 <div class="custom-control custom-radio custom-control-inline">
															<input type="radio" value="N" class="custom-control-input" id="customControlValidation4" name="refer_car" required="">
															<label class="custom-control-label" for="customControlValidation4">ไม่มี</label>
													</div>
												</div>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-4">
											<label for="dowork">ผู้ป่วย Isolated ที่ รพ.</label>
											<input type="text" name="risk2_6HistoryHospitalInput" class="form-control" placeholder="ชื่อ รพ.">
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-4">
											<label for="dowork">จังหวัด</label>
											<input type="text" name="isolated_province" class="form-control" placeholder="จังหวัด">
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-12">
											<h1 class="text-info">2. ข้อมูลการเดินทาง</h1>
											<div class="form-group">
												<label for="informant">เดินทางมาจากอู่ฮั่นหรือไม่ หากเดินทางมาจากอู่ฮั่น</label>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-3">
											<label for="workPhone">วันที่มาถึงไทย</label>
											<input type="text" name="risk2_6ArriveDate" id="datepicker1" class="form-control">
										</div>
										<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-3">
											<label for="workPhone">สายการบิน</label>
											<input type="text" name="risk2_6AirlineInput" class="form-control" placeholder="สายการบิน">
										</div>
										<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-3">
											<label for="workPhone">เที่ยวบิน</label>
											<input type="text" name="risk2_6FlightNoInput" class="form-control" placeholder="เที่ยวบิน">
										</div>
										<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-3">
											<label for="workPhone"><small>จำนวนผู้ร่วมเดินทางในกลุ่มเดียวกัน(คน)</small></label>
											<input type="text" name="total_travel_in_group"  class="form-control" placeholder="จำนวนคน">
										</div>
									</div>
									<div class="form-row">
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 col-xl-2 mb-3">
											<div class="form-group {{ $errors->has('titleNameInput') ? 'has-error' : '' }}">
												<label for="titleName">คำนำหน้าชื่อ</label>
												<select name="title_name" class="form-control selectpicker show-tick select-title-name" data-live-search="true" id="title_name_input">
													<option value="0">-- โปรดเลือก --</option>
													@php
														foreach($titleName as $key=>$val) {
															$htm = "<option value=\"".$val['title_name']."\"";
																if (old('titleNameInput') == $val['id']) {
																	$htm .= " selected=\"selected\"";
																}
															$htm .= ">".$val['title_name']."</option>\n";
															echo $htm;
														}
													@endphp
												</select>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 col-xl-2 mb-3">
											<div class="form-group {{ $errors->has('firstNameInput') ? 'has-error' : '' }}">
												<label for="firstName">ชื่อจริง</label>
												<input type="text" name="first_name" class="form-control" id="first_name_input" placeholder="ชื่อ" required>
											</div>
											<span class="text-danger">{{ $errors->first('firstNameInput') }}</span>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-3">
											<div class="form-group">
												<label for="midName">ชื่อกลาง</label>
												<input type="text" name="mid_name" class="form-control" id="mid_name_input" placeholder="ชื่อกลาง">
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-3">
											<div class="form-group {{ $errors->has('lastNameInput') ? 'has-error' : '' }}">
												<label for="lastName">นามสกุล</label>
												<input type="text" name="last_name" class="form-control" id="last_name_input" placeholder="นามสกุล" required>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 col-xl-2 mb-3">
											<div class="form-group {{ $errors->has('sexInput') ? 'has-error' : '' }}">
												<label for="sex">เพศ</label>
												<select name="sex" class="form-control selectpicker show-tick">
													<option value="">-- โปรดเลือก --</option>
													<option value="ชาย">ชาย</option>
													<option value="หญิง">หญิง</option>
												</select>
											</div>
											<span class="text-danger">{{ $errors->first('sexInput') }}</span>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-3 col-lg-1 col-xl-1 mb-3">
											<div class="form-group">
												<label for="age">อายุ/ปี</label>
												<input type="text" name="age" value="{{ old('ageYearInput') }}" class="form-control" id="age_year_input" required>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 col-xl-2 mb-3">
											<div class="form-group">
												<label for="nationality">สัญชาติ</label>
												<select name="nation" class="form-control selectpicker show-tick" data-live-search="true" id="select_nationality">
													<option value="0">-- โปรดเลือก --</option>
													@php
														foreach($nationality as $key=>$val) {
															$htm = "<option value=\"".$val['name_th']."\"";
																if (old('nationalityInput') == $val['id']) {
																	$htm .= " selected=\"selected\"";
																}
															$htm .= ">".$val['name_th']."</option>\n";
															echo $htm;
														}
													@endphp
												</select>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 col-xl-2 mb-3">
											<div class="form-group">
												<label for="nationality">เชื้อชาติ</label>
												<input type="text" name="race" class="form-control" id="raceInput"  placeholder="เชื้อชาติ" required>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2 mb-2">
											<label for="occupation">อาชีพ</label>
											<select name="occupation" class="form-control selectpicker show-tick select-title-name" data-live-search="true" id="occupation">
												<option value="0">-- โปรดเลือก --</option>
													@foreach($occupation as $key5=>$val5) {
														<option value="{{ $val5['id'] }}">{{ $val5['occu_name_th'] }}</option>
													@endforeach
											</select>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
											<label for="occupation_oth">อาชีพอื่นๆ</label>
											<input type="text" name="occupation_oth"  class="form-control" id="occupation_oth">
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-3">
											<label for="occupation">โรคประจำตัว</label>
										</div>
										<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
											<div class="custom-control custom-checkbox custom-control-inline">
												<input type="checkbox" name="data3_3chk" value="n" class="custom-control-input chk_risk3_3" id="data3_3chkNo">
												<label for="data3_3chkNo" class="custom-control-label normal-label">ไม่มี</label>
											</div>
											<div class="custom-control custom-checkbox custom-control-inline">
												<input type="checkbox" name="data3_3chk" value="y" class="custom-control-input chk_risk3_3" id="data3_3chkYes">
												<label for="data3_3chkYes" class="custom-control-label normal-label">มี (กรุณาทำเครื่องหมายด้านล่าง)</label>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
											<div class="table-responsive">
												<table class="table">
													</thead></thead>
													<tfoot></tfoot>
													<tbody>
														<tr id="risk3_3table_tr1">
															<td>
																<div class="custom-control custom-checkbox">
																	<input type="checkbox" name="data3_3chk_lung" value="y" class="custom-control-input" id="data3_3chk_lung">
																	<label for="data3_3chk_lung" class="custom-control-label normal-label">
																		โรคปอดเรื้อรัง เช่น COPD, chronic bronchitis, chronic bronchiectasis, BPD, หรือหอบ (asthma) ที่กำลังรักษา
																	</label>
																</div>
															</td>
														</tr>
														<tr id="risk3_3table_tr2">
															<td>
																<div class="custom-control custom-checkbox">
																	<input type="checkbox" name="data3_3chk_heart" value="y" class="custom-control-input" id="data3_3chk_heart">
																	<label for="data3_3chk_heart" class="custom-control-label normal-label">
																		โรคหัวใจ เช่น หัวใจพิการแต่กำเนิด, โรคหลอดเลือดหัวใจ หรือ Congestive heart failure
																	</label>
																</div>
															</td>
														</tr>
														<tr id="risk3_3table_tr3">
															<td>
																<div class="custom-control custom-checkbox">
																	<input type="checkbox" name="data3_3chk_cirrhosis" value="y" class="custom-control-input" id="data3_3chk_cirrhosis">
																	<label for="data3_3chk_cirrhosis" class="custom-control-label normal-label">
																		โรคตับเรื้อรัง เช่น ตับแข็ง (Cirrhosis)
																	</label>
																</div>
															</td>
														</tr>
														<tr id="risk3_3table_tr4">
															<td>
																<div class="custom-control custom-checkbox">
																	<input type="checkbox" name="data3_3chk_kidney" value="y" class="custom-control-input" id="data3_3chk_kidney">
																	<label for="data3_3chk_kidney" class="custom-control-label normal-label">
																		โรคไต, ไตวาย
																	</label>
																</div>
															</td>
														</tr>
														<tr id="risk3_3table_tr5">
															<td>
																<div class="custom-control custom-checkbox">
																	<input type="checkbox" name="data3_3chk_diabetes" value="y" class="custom-control-input" id="data3_3chk_diabetes">
																	<label for="data3_3chk_diabetes" class="custom-control-label normal-label">
																		เบาหวาน
																	</label>
																</div>
															</td>
														</tr>
														<tr id="risk3_3table_tr6">
															<td>
																<div class="custom-control custom-checkbox">
																	<input type="checkbox" name="data3_3chk_blood" value="y" class="custom-control-input" id="data3_3chk_blood">
																	<label for="data3_3chk_blood" class="custom-control-label normal-label">
																		ความดันโลหิตสูง
																	</label>
																</div>
															</td>
														</tr>
														<tr id="risk3_3table_tr7">
															<td>
																<div class="custom-control custom-checkbox">
																	<input type="checkbox" name="data3_3chk_immune" value="y" class="custom-control-input" id="data3_3chk_immune">
																	<label for="data3_3chk_immune" class="custom-control-label normal-label">
																		ภูมิคุ้มกันบกพร่อง
																	</label>
																</div>
															</td>
														</tr>
														<tr id="risk3_3table_tr8">
															<td>
																<div class="custom-control custom-checkbox">
																	<input type="checkbox" name="data3_3chk_anaemia" value="y" class="custom-control-input" id="data3_3chk_anaemia">
																	<label for="data3_3chk_anaemia" class="custom-control-label normal-label">
																		โลหิตจาง (ธาลัสซีเมีย, sickle cell anemia)
																	</label>
																</div>
															</td>
														</tr>
														<tr id="risk3_3table_tr9">
															<td>
																<div class="custom-control custom-checkbox">
																	<input type="checkbox" name="data3_3chk_cerebral" value="y" class="custom-control-input" id="data3_3chk_cerebral">
																	<label for="data3_3chk_cerebral" class="custom-control-label normal-label">
																		พิการทางสมอง ช่วยเหลือตัวเองไม่ได้
																	</label>
																</div>
															</td>
														</tr>
														<tr id="risk3_3table_tr10">
															<td>
																<div class="custom-control custom-checkbox">
																	<input type="checkbox" name="data3_3chk_pregnant" value="y" class="custom-control-input" id="data3_3chk_pregnant">
																	<label for="data3_3chk_pregnant" class="custom-control-label normal-label">
																		ตั้งครรภ์
																	</label>
																</div>
															</td>
														</tr>
														<tr id="risk3_3table_tr11">
															<td>
																<div class="custom-control custom-checkbox">
																	<input type="checkbox" name="data3_3chk_fat" value="y" class="custom-control-input" id="data3_3chk_fat">
																	<label for="data3_3chk_fat" class="custom-control-label normal-label">
																		อ้วน
																	</label>
																</div>
															</td>
														</tr>
														<tr id="risk3_3table_tr12">
															<td>
																<div class="custom-control custom-checkbox">
																	<input type="checkbox" name="data3_3chk_cancer" value="y" class="custom-control-input" id="data3_3chk_cancer">
																	<label for="data3_3chk_cancer" class="custom-control-label normal-label">
																		มะเร็ง
																	</label>
																	<div class="row mt-2">
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
																			<div class="form-group">
																				<input type="text" name="data3_3chk_cancer_name" class="form-control" placeholder="ประเภทมะเร็ง">
																			</div>
																		</div>
																	</div>
																</div>
															</td>
														</tr>
														<tr id="risk3_3table_tr13">
															<td>
																<div class="custom-control custom-checkbox">
																	<input type="checkbox" name="data3_3chk_other" value="y" class="custom-control-input" id="data3_3chk_other">
																	<label for="data3_3chk_other" class="custom-control-label normal-label">
																		อื่นๆ
																	</label>
																	<div class="row mt-2">
																		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
																			<div class="form-group">
																				<input type="text" name="data3_3input_other"  class="form-control" placeholder="อื่นๆ โปรดระบุ">
																			</div>
																		</div>
																	</div>
																</div>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
											<div class="alert alert-danger" role="alert">
												<h6 class="alert-heading">คำแนะนำ: "อาชีพ" ระบุลักษณะงานที่ทำและหากเป็นเจ้าหน้าที่ทางการแพทย์หรือสาธารณสุขต้องระบุให้ชัดเจนว่าเป็นบุคลากรทางการแพทย์</h6>
											</div>
										</div>
									</div>
									<div class="form-row">

									</div>

									<div class="form-row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-12">
											<h1 class="text-info">3. ข้อมูลอาการผู้ป่วย</h1>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-3">
											<div class="form-group">
												<label for="houseNo">วันที่เริ่มป่วย</label>
												<input type="text" id="datepicker2" name="risk3_1sickDateInput" class="form-control">
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-1 col-xl-1 mb-3">
											<div class="form-group">
												<label for="villageNo">ไข้(องศา)</label>
												<input type="text" name="fever"  class="form-control">
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 col-xl-2 mb-3">
											<div class="form-group">
												<label for="informant">อาการ</label>
												<div>
													<div class="custom-control custom-checkbox custom-control-inline">
														<input type="checkbox" name="sym_cough" value="y" class="custom-control-input pt-type" id="coughChk">
														<label for="coughChk" class="custom-control-label normal-label">ไอ</label>
													</div>
													<div class="custom-control custom-checkbox custom-control-inline">
														<input type="checkbox" name="sym_snot" value="y" class="custom-control-input pt-type" id="snotChk">
														<label for="snotChk" class="custom-control-label normal-label">น้ำมูก</label>
													</div>
													<div class="custom-control custom-checkbox custom-control-inline">
														<input type="checkbox" name="sym_sore" value="y" class="custom-control-input pt-type" id="soreChk">
														<label for="soreChk" class="custom-control-label normal-label">เจ็บคอ</label>
													</div>
													<div class="custom-control custom-checkbox custom-control-inline">
														<input type="checkbox" name="sym_dyspnea" value="y" class="custom-control-input pt-type" id="dyspneaChk">
														<label for="dyspneaChk" class="custom-control-label normal-label">หายใจเหนื่อย</label>
													</div>
													<div class="custom-control custom-checkbox custom-control-inline">
														<input type="checkbox" name="sym_breathe" value="y" class="custom-control-input pt-type" id="breatheChk">
														<label for="breatheChk" class="custom-control-label normal-label">หายใจลำบาก</label>
													</div>
													<div class="custom-control custom-checkbox custom-control-inline">
														<input type="checkbox" name="sym_stufefy" value="y" class="custom-control-input pt-type" id="stufefyChk">
														<label for="stufefyChk" class="custom-control-label normal-label">ซึม</label>
													</div>
												</div>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-3">
											<div class="form-group">
												<label for="lane">RR(ครั้ง/นาที)</label>
												<input type="text" name="rr_rpm" class="form-control">
											</div>
										</div>


										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-12">
										 <h1 class="text-info">4. ข้อมูลผลทางห้องปฏิบัติการ</h1>
										</div>

										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-6">
											<div class="form-group">
												<label for="district">ผลการฉายรังสี(ถ้ามี)</label>
												<textarea class="form-control" name="xray_result"></textarea>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-12">
											<div class="form-group">
												<label for="lane">ผลการตรวจแล็ปเบื้องต้น</label>
											</div>
										</div>

										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-6">
											<div class="form-group">
												<label for="subDistrict">Rapid Test</label>
												<textarea class="form-control" name="rapid_test_result"></textarea>
											</div>
										</div>

										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-6">
											<div class="form-group">
												<label for="subDistrict">อื่นๆ</label>
												<textarea class="form-control" name="lab_test_result_other"></textarea>
											</div>
										</div>

										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-12">
											<div class="form-group">
												<label for="subDistrict">แพทย์วินิจฉัยเบื้องต้น</label>
												<textarea class="form-control" name="first_diag"></textarea>
											</div>
										</div>

									</div>
								</div><!-- card body#1 -->
							</div><!-- card1 -->
						</div><!-- bd-collout1 -->
						<h3 class="text-primary">ส่วนที่ 2</h3>
						<div class="bd-callout bd-callout-warning" style="margin:0;">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-12">
									<h1 class="text-info">5.การส่งตรวจ Lab</h1>
								</div>
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-4">
										<div class="form-group">
											<label for="houseNo">วันที่เก็บ(NPS+TS1)</label>
											<input type="text" name="nps_ts1_date" class="form-control datepicker">
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-4">
										<div class="form-group">
											<label for="houseNo">ส่งที่(NPS+TS1)</label>
											<select name="nps_ts1_send" class="form-control show-tick select-title-name" data-live-search="true" id="nps_ts1_send">
												<option value="0">-- โปรดเลือก --</option>
													@foreach($laboratorylists as $key1=>$val2) {
														<option value="{{ $val2['id'] }}">{{ $val2['en_initials'] }}</option>
													@endforeach
											</select>
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-4">
										<div class="form-group">
											<label for="houseNo">ผล(NPS+TS1)</label>
											<select name="nps_ts1_result" class="form-control  show-tick select-title-name" data-live-search="true" id="nps_ts1_result">
												<option value="0">-- โปรดเลือก --</option>
													@foreach($pathogenlists as $key3=>$val3) {
														<option value="{{ $val3['id'] }}">{{ $val3['patho_name_en'] }}</option>
													@endforeach
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-4">
										<div class="form-group">
											<label for="houseNo">วันที่เก็บ(NPS+TS2)</label>
											<input type="text" name="nps_ts2_date" class="form-control datepicker">
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-4">
										<div class="form-group">
											<label for="houseNo">ส่งที่(NPS+TS2)</label>
											<select name="nps_ts2_send" class="form-control show-tick select-title-name" data-live-search="true" id="nps_ts2_send">
												<option value="0">-- โปรดเลือก --</option>
													@foreach($laboratorylists as $key1=>$val2) {
														<option value="{{ $val2['id'] }}">{{ $val2['en_initials'] }}</option>
													@endforeach
											</select>
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-4">
										<div class="form-group">
											<label for="houseNo">ผล(NPS+TS2)</label>
											<select name="nps_ts2_result" class="form-control show-tick select-title-name" data-live-search="true" id="nps_ts2_result">
												<option value="0">-- โปรดเลือก --</option>
													@foreach($pathogenlists as $key3=>$val3) {
														<option value="{{ $val3['id'] }}">{{ $val3['patho_name_en'] }}</option>
													@endforeach
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-4">
										<div class="form-group">
											<label for="houseNo">วันที่เก็บ(Clot Blood)</label>
											<input type="text" name="cb_date" class="form-control datepicker">
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-4">
										<div class="form-group">
											<label for="houseNo">ส่งที่(Clot Blood)</label>
											<select name="cb_send" class="form-control show-tick select-title-name" data-live-search="true" id="cb_send">
												<option value="0">-- โปรดเลือก --</option>
													@foreach($laboratorylists as $key1=>$val2) {
														<option value="{{ $val2['id'] }}">{{ $val2['en_initials'] }}</option>
													@endforeach
											</select>
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-4">
										<div class="form-group">
											<label for="cb_result">ผล(Clot Blood)</label>
											<select name="cb_result" class="form-control  show-tick select-title-name" data-live-search="true" id="cb_result">
												<option value="0">-- โปรดเลือก --</option>
													@foreach($pathogenlists as $key3=>$val3) {
														<option value="{{ $val3['id'] }}">{{ $val3['patho_name_en'] }}</option>
													@endforeach
											</select>
										</div>
									</div>
								</div>
						</div>
						<div style="margin-top:20px;">
						</div>
						<h3 class="text-primary">ส่วนที่ 3</h3>
						<div class="bd-callout bd-callout-danger" style="margin:0;">
							<div class="form-row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-12">
									<h1 class="text-info">6.การดำเนินงานเพิ่มเติม สำหรับ Sup Sat./Sat Manager</h1>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-4">
									<div class="form-group">
										<label for="houseNo">PUI Code</label>
										<input type="text" name="sat_id" class="form-control">
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-3">
									<div class="form-group">
										<label for="subDistrict">หน่วยงานที่จะส่งหนังสือ</label>
										<select name="letter_division_code" class="form-control selectpicker show-tick" id="division_code">
											<option value="">-- โปรดเลือก --</option>
											<option value="TRC">TRC</option>
											<option value="NIH">NIH</option>
											<option value="BIDI">BIDI</option>
										</select>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-4">
									<div class="form-group">
										<label for="subDistrict">เลขหนังสือ</label>
										<input type="text" name="letter_code" class="form-control">
									</div>
								</div>

								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-12">
									<div class="form-group">
										<label for="informant">แจ้งศูนย์ Refer บำราศ เพื่อ</label>
									</div>
								</div>

								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-12">
									<div class="form-group">
										<div>
											<div class="custom-control custom-checkbox custom-control-inline">
												<input type="checkbox" name="refer_bidi" value="Y" class="custom-control-input pt-type" id="referChk">
												<label for="referChk" class="custom-control-label normal-label">รับ Refer</label>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-12">
									<div class="form-group">
											<div class="custom-control custom-checkbox custom-control-inline">
												<input type="checkbox" name="refer_lab" value="Y" class="custom-control-input pt-type" id="refer_labChk">
												<label for="refer_labChk" class="custom-control-label normal-label">รับ Lab </label>
											</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 mb-3">
									<div class="form-group">
										<label for="lane">ส่งมาเมื่อ</label>
										<input type="text" name="lab_send_detail" class="form-control">
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 mb-3">
									<div class="form-group">
										<label for="lane">วันที่</label>
										<input type="text" id="datepicker3" name="lab_send_date" class="form-control">
									</div>
								</div>

						</div>
						<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 mb-3">
									<div class="form-group">
										<label for="lane">ไม่แจ้งบำราศ เนื่องจาก</label>
										<textarea class="form-control" name="not_send_bidi"></textarea>
									</div>
								</div>

								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-4">
									<div class="form-group">
										<label for="informant">แจ้งทีม Operation</label>
										<div>
											<div class="custom-control custom-checkbox custom-control-inline">
												<input type="checkbox" value="Y" class="custom-control-input" id="customControlValidation9" name="op_opt" >
												<label class="custom-control-label" for="customControlValidation9">ทีม Operation ลงเอง</label>
											</div>
											 <div class="custom-control custom-checkbox custom-control-inline">
													<input type="checkbox" value="Y" class="custom-control-input" id="customControlValidation10" name="op_dpc">
													<label class="custom-control-label" for="customControlValidation10">ทีม สคร. ลง</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-4">
									<div class="form-group">
										<label for="pt_status">PT Status</label>
										<select name="pt_status" data-live-search="true" class="form-control selectpicker show-tick">
											<option value="1">PUI</option>
											<option value="2">Confirm</option>
											<option value="3">Suspect</option>
											<option value="3">Excluded</option>
										</select>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-4">
									<div class="form-group">
										<label for="news_st">การแถลงข่าว</label>
										<select name="news_st" class="form-control selectpicker show-tick">
											<option value="1">Confirm แถลงข่าว</option>
											<option value="2">Comfirm ยังไม่แถลง</option>
										</select>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-4">
									<div class="form-group">
										<label for="disch_st">สถานะการจำหน่ายผู้ป่วย</label>
										<select name="disch_st" class="form-control selectpicker show-tick">
											<option value="1">Recovery</option>
											<option value="2">Admit</option>
											<option value="3">Death</option>
										</select>
									</div>
								</div>

								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-12">
								 <h1 class="text-info">7. ข้อมูลผู้บันทึกข้อมูล</h1>
								</div>

								<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-3">
									<div class="form-group">
										<label for="subDistrict">เบอร์ติดต่อผู้ประสานงาน</label>
										<input type="text" name="coordinator_tel" class="form-control">
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-3">
									<div class="form-group">
										<label for="subDistrict">ชื่อผู้แจ้งข้อมูล</label>
										<input type="text" name="send_information" class="form-control">
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-3">
									<div class="form-group">
										<label for="subDistrict">หน่วยงาน</label>
										<input type="text" name="send_information_div" class="form-control">
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-3">
									<div class="form-group">
										<label for="subDistrict">ชื่อผู้รับแจ้ง</label>
										<input type="text" name="receive_information" class="form-control">
									</div>
								</div>

							</div>
						</div><!-- bd-collout2 -->
						<div class="border-top">
                  <div class="card-body">
                        <button type="submit" class="btn btn-primary">Save</button>
                  </div>
            </div>
					</form>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('bottom-script')
	<script src="{{ URL::asset('assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
		<script src="{{ URL::asset('assets/libs/bootstrap-select-1.13.9/dist/js/bootstrap-select.min.js') }}"></script>
<script>
$(document).ready(function() {
	/* ajax request */
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
});
$('.selectpicker,#cb_send,#cb_result,#nps_ts1_result,#nps_ts2_send,#nps_ts2_result,#nps_ts1_send').selectpicker();
/* date of birth */
$('#datepicker1,#datepicker2,#datepicker3,.datepicker').datepicker({
	format: 'dd/mm/yyyy',
	todayHighlight: true,
	todayBtn: true,
	autoclose: true
});

$('.chk_risk3_3').click(function() {
	$('.chk_risk3_3').not(this).prop('checked', false);
});

</script>
@endsection
