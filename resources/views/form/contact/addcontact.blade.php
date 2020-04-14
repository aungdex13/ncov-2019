@extends('layouts.index')
<?php
$config = [
    'table' => 'tbl_contact',
    'length' => 11,
		'field' => 'contact_id_temp',
    'prefix' => $prefix_sat_id."B".date('d').date('m'),
];
$contact_id = Haruncpi\LaravelIdGenerator\IdGenerator::generate($config);
?>
@section('contents')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/contact/dualbox/bootstrap-duallistbox.css') }}">
{{-- <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-select-1.13.9/dist/css/bootstrap-select.min.css') }}"> --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
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
                    <div class="card-header">
                        <h5>แบบบันทึกข้อมูลของผู้สัมผัสโรคไวรัสโคโรนา 19</h5>
                    </div>
                    <br>
                    {{-- <h3 class="text-primary">ส่วนที่ 1</h3> --}}
                    <div class="bd-callout bd-callout-info" style="margin-top:0;position:relative">
                        <div style="position:absolute;top:10px;right:10px;z-index:1">
                            {{-- <a type="button" href="http://ncov2019.local/sat/list" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back To Lists SAT</a> --}}
                            <!-- <a type="button" href="http://ncov2019.local/screen-pui" class="btn btn-info"><i class="fas fa-user-plus"></i> New patient</a> -->
                        </div>
                        <div class="card-block">
                            <h4 class="sub-title">ข้อมูลทั่วไปผู้สัมผัส </h4>
                            <form action="{{route('contactinsert')}}" method="post">
                                {{ csrf_field() }}

                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-3">
                                        <input type="hidden" name="pui_id" value="{{$pui_id}}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="bd-callout bd-callout-danger" style="margin-top:0;position:relative">
                                    <div style="position:absolute;top:10px;right:10px;z-index:1">
                                        {{-- <a type="button" href="http://ncov2019.local/sat/list" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back To Lists SAT</a> --}}
                                        <!-- <a type="button" href="http://ncov2019.local/screen-pui" class="btn btn-info"><i class="fas fa-user-plus"></i> New patient</a> -->
                                    </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-6">
                                        <input type="hidden" name="sat_id" value="{{$sat_id[0]->sat_id}}" class="form-control" readonly>
                                          <h5 class="sub-title">รหัสผู้สัมผัส : </h5>
                                        <div class="col-sm-12 col-md-6">
                                              {{-- <h5 class="card-title"><input type="checkbox" id="cuscontactid" name="cuscontactid" /> :  กรณีกรอกรหัสผู้สัมผัสด้วยตนเอง  </h5>
                                            <input type="text" id="inputcontact" name="contact_id" value="{{$contact_id}}" class="form-control" placeholder="รหัสผู้สัมผัส" readonly> --}}
                                            {{-- <h5 class="card-title"><input type="checkbox" id="cuscontactid" name="cuscontactid" /> :  กรณีกรอกรหัสผู้สัมผัสด้วยตนเอง  </h5> --}}
                                          <input type="text" id="inputcontact" name="contact_id" class="form-control" placeholder="รหัสผู้สัมผัส" >
                                        </div>
                                        </div>
                                    </div>
                                  </div>
                                  <div>
                                    <h5 class="card-title">ผู้สัมผัสของผู้ป่วยรหัส : {{$sat_id[0]->sat_id}}</h5>
                                    {{-- <h4 class="card-title">และ รหัส:<br>
                                    @foreach ($sat_id_relation as $row)
                                    {{$row->sat_id}}<br>
                                    @endforeach
                                  </h4> --}}
                                  </div>
                                <h5 class="sub-title">เพิ่มผู้ป่วยของผู้สัมผัส กรณีเป็นผู้สัมผัสของผู้ป่วยหลายราย</h5>
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <input type="radio" name="pa1" value="n" onclick="show21();" checked> ไม่มี
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="radio" name="pa1" value="y" onclick="show22();"> มี
                                    </div>

                                </div>
                                <div id="div2" class="hide">
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-6">
                                        <select multiple="multiple" size="10" name="sat_id_relation[]">
                                          @foreach ($sat_id_confirm as $row)
                                          <option value="{{$row->sat_id.'|'.$row->id}}">{{ (isset($row->sat_id)) ? $row->sat_id : "" }} [{{ (isset($row->first_name)) ? $row->first_name : "" }} {{ (isset($row->last_name)) ? $row->last_name : "" }}/{{ (isset($nation_list[$row->nation])) ? $nation_list[$row->nation] : "" }}]
                                          </option>
                                          @endforeach
                                          <option value="{{$sat_id[0]->sat_id.'|'.$sat_id[0]->id}}" selected>รหัสตั้งต้นผู้ป่วยหลัก {{$sat_id[0]->sat_id}}</option>
                                        </select>
                                        <br>
                                    </div>
                                </div>
                              </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-3">
                                        <input type="hidden" id="contact_id_temp" name="contact_id_temp" value="{{$contact_id}}" class="form-control" placeholder="รหัสผู้สัมผัส" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-3">
                                        <input type="hidden" name="user_id" value="{{$entry_user}}" class="form-control" placeholder="รหัสผู้สัมผัส" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-3">
                                        <label for="name_contact">คำนำหน้าชื่อ</label>
                                        <select type="text" name="title_contact" class="form-control js-select-basic-single" placeholder="คำนำหน้าชื่อ">
                                            <option value="">เลือกคำนำหน้าชื่อ</option>
                                            @foreach ($ref_title_name as $row)
                                            <option value="{{$row->id}}">{{$row->title_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <label for="name_contact">ชื่อต้นผู้สัมผัส</label>
                                        <input type="text" name="name_contact" class="form-control" placeholder="ชื่อต้นผู้สัมผัส">
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <label for="mname_contact">ชื่อกลางผู้สัมผัส</label>
                                        <input type="text" name="mname_contact" class="form-control" placeholder="ชื่อกลางผู้สัมผัส">
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <label for="lname_contact">นามสกุลผู้สัมผัส</label>
                                        <input type="text" name="lname_contact" class="form-control" placeholder="นามสกุลผู้สัมผัส">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <label for="sex_contact">เพศ</label>
                                        <select type="text" name="sex_contact" class="form-control" placeholder="col-sm-2">
                                            <option value="">เพศ</option>
                                            <option value="ชาย">ชาย</option>
                                            <option value="หญิง">หญิง</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="age_contact">อายุ</label>
                                        <input type="text" name="age_contact" class="form-control" placeholder="อายุ">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="contact_cid">เลขบัตรประชาชน</label>
                                        <input type="text" name="contact_cid" class="form-control" placeholder="เลขบัตรประชาชน">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="passport_contact">Passport ID</label>
                                        <input type="text" name="passport_contact" class="form-control" placeholder="Passport ID">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <label for="occupation">อาชีพ</label>
                                        <select type="text" name="occupation" class="form-control js-select-basic-single" placeholder="สัญชาติ">
                                            <option value="">เลือกอาชีพ</option>
                                            @foreach ($listoccupation as $row)
                                            <option value="{{$row->id}}">{{$row->occu_name_th}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="occupation_other">อาชีพอื่นๆ</label>
                                        <input type="text" name="occupation_other" class="form-control" placeholder="อาชีพอื่นๆ">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <div class="col-sm-12 col-md-3">
                                        <label for="national_contact">สัญชาติผู้สัมผัส</label>
                                        <select type="text" name="national_contact" class="form-control js-select-basic-single" placeholder="สัญชาติ">
                                            <option value="">เลือกสัญชาติ</option>
                                            @foreach ($ref_global_country as $row)
                                            <option value="{{$row->country_id}}">{{$row->country_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <label for="province">จังหวัดที่อยู่ในประเทศไทย</label>
                                        <select type="text" name="province" id="province" class="form-control province js-select-basic-single" placeholder="จังหวัด">
                                            <option value="">เลือกจังหวัดที่อยู่ในประเทศไทย</option>
                                            @foreach ($listprovince as $row)
                                            <option value="{{$row->province_id}}">{{$row->province_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <label for="district">อำเภอ/เขตที่อยู่ในประเทศไทย</label>
                                        <select name="district" id="district" class="form-control district js-select-basic-single" placeholder="อำเภอ">
                                            <option value="">เลือกอำเภอ/เขตที่อยู่ในประเทศไทย</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <label for="subdistrict">ตำบลที่อยู่ในประเทศไทย</label>
                                        <select name="sub_district" id="subdistrict" class="form-control subdistrict js-select-basic-single" placeholder="ตำบล">
                                            <option value="">เลือกตำบลที่อยู่ในประเทศไทย</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label for="address_contact">บ้านเลขที่</label>
                                        <input name="sick_house_no" type="text" class="form-control" placeholder="บ้านเลขที่">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="address_contact">ที่อยู่</label>
                                        <input name="sick_village_no" type="text" class="form-control" placeholder="ที่อยู่">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="address_contact">หมู่บ้าน</label>
                                        <input name="sick_village" type="text" class="form-control" placeholder="หมู่บ้าน">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="address_contact">ซอย</label>
                                        <input name="sick_lane" type="text" class="form-control" placeholder="ซอย">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="address_contact">ถนน</label>
                                        <input name="sick_road" type="text" class="form-control" placeholder="ถนน">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="phone_contact">เบอร์โทร</label>
                                        <input type="text" name="phone_contact" class="form-control" placeholder="เบอร์โทร">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="patient_contact">การสัมผัสผู้ป่วย</label>
                                        <textarea rows="3" type="text" name="patient_contact" class="form-control" placeholder="การสัมผัสผู้ป่วย"></textarea>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="bd-callout bd-callout-custom-2" style="margin-top:0;position:relative">
                        <div style="position:absolute;top:10px;right:10px;z-index:1">
                            {{-- <a type="button" href="http://ncov2019.local/sat/list" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back To Lists SAT</a> --}}
                            <!-- <a type="button" href="http://ncov2019.local/screen-pui" class="btn btn-info"><i class="fas fa-user-plus"></i> New patient</a> -->
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="type_contact">ประเภทผู้สัมผัส</label>
                                <select type="text" name="type_contact" class="form-control js-select-basic-single" placeholder="ประเภทผู้สัมผัส">
                                    <option value="">ประเภทผู้สัมผัส</option>
                                    @foreach ($contact_type as $row)
                                    <option value="{{$row->Index}}">{{$row->type}}</option>
                                    @endforeach
                                    {{-- <option value="">- เลือก -</option>
                                    <option value="40">บุคลากรทางการแพทย์</option>
                                    <option value="10">ผู้สัมผัสร่วมบ้าน</option>
                                    <option value="20">ผู้ร่วมเดินทาง/ร่วมยานพาหนะ</option>
                                    <option value="52">พนักงานโรงแรม</option>
                                    <option value="23">คนขับแท๊กซี่/ยานพาหนะ</option>
                                    <option value="31">พนักงานสนามบิน</option>
                                    <option value="32">บุคคลร่วมที่ทำงาน</option>
                                    <option value="33">บุคคลร่วมโรงเรียน</option>
                                    <option value="45">ผู้ป่วยในโรงพยาบาล</option>
                                    <option value="99">อื่นๆ</option> --}}
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="phone_contact">วันที่สัมผัสผู้ป่วยวันสุดท้าย</label>
                                <input type="text" class="form-control" name="datecontact" data-provide="datepicker" id="ArrivalDate" placeholder="วันที่สัมผัสผู้ป่วยวันสุดท้าย" autocomplete="off">
                            </div>
                            <div class="col-sm-4">
                                <label for="patient_contact">วันสิ้นสุดการติดตาม</label>
                                <input type="text" class="form-control" name="datefollow" id="DepartDate" placeholder="วันสิ้นสุดการติดตาม" autocomplete="off" readonly>
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="risk_contact">ระดับความเสี่ยง</label>
                                <select type="text" name="risk_contact" class="form-control js-select-basic-single" placeholder="ระดับความเสี่ยง" required="true">
                                    <option value="">ระดับความเสี่ยง</option>
                                    <option value="1">เสี่ยงสูง</option>
                                    <option value="2">เสี่ยงต่ำ</option>
                                </select>
                            </div>
                        </div>
                        <h5 class="sub-title">อาการปัจจุบันของผู้สัมผัส</h5>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <input type="radio" name="clinical" value="n" onclick="show1();" checked> ไม่มีอาการ
                            </div>
                            <div class="col-sm-3">
                                <input type="radio" name="clinical" value="y" onclick="show2();"> มีอาการ
                            </div>
                        </div>
                        <div id="div1" class="hide">
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="patient_contact">วันที่เริ่มป่วย</label>
                                    <input type="text" class="form-control" name="date_symtom" data-provide="datepicker" id="datesymtom" placeholder="วันที่เริ่มป่วย" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <input type="checkbox" name="fever" value="1"> ไข้
                                </div>
                                <div class="col-sm-3">
                                    <input type="checkbox" name="cough" value="2"> ไอ
                                </div>
                                <div class="col-sm-3">
                                    <input type="checkbox" name="sore_throat" value="3"> เจ็บคอ
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <input type="checkbox" name="mucous" value="4"> มีน้ำมูก
                                </div>
                                <div class="col-sm-3">
                                    <input type="checkbox" name="sputum" value="5"> มีเสมหะ
                                </div>
                                <div class="col-sm-3">
                                    <input type="checkbox" name="breath_labored" value=""> หายใจลำบาก
                                </div>
                                <div class="col-sm-3">
                                    <input type="checkbox" name="suffocate" value="9"> หอบเหนื่อย
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <input type="checkbox" name="muscle_aches" value="7"> ปวดกล้ามเนื้อ
                                </div>
                                <div class="col-sm-3">
                                    <input type="checkbox" name="headache" value="6"> ปวดศีรษะ
                                </div>
                                <div class="col-sm-3">
                                    <input type="checkbox" name="diarrhea" value="14"> ถ่ายเหลว
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bd-callout bd-callout-warning" style="margin-top:0;position:relative">
                        {{-- <div style="position:absolute;top:10px;right:10px;z-index:1"> --}}
                            {{-- <a type="button" href="http://ncov2019.local/sat/list" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back To Lists SAT</a> --}}
                            <!-- <a type="button" href="http://ncov2019.local/screen-pui" class="btn btn-info"><i class="fas fa-user-plus"></i> New patient</a> -->
                        {{-- </div> --}}
                        {{-- <h6 class="sub-title">เป็นผู้ป่วยติดเชื้อโคโรนาสายพันธ์ใหม่ 2019 (มีอาการเข้าได้กับนิยามและมีผลยืนยันทางห้องปฏิบัติการณ์)</h6>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <div class="col-sm-6">
                                    <input type="radio" name="sat_id_class" value="Q" checked> ไม่ใช่
                                </div>
                                <div class="col-sm-6">
                                    <input type="radio" name="sat_id_class" value="A"> ใช่
                                </div>
                            </div>
                        </div>
                        <h6 class="sub-title">หมายเหตุ นิยาม: เป็นผู้สัมผัสที่มี มีประวัติไข้ หรือ วัดอุณหภูมิได้ตั้งแต่ 37.5 องศาขึ้นไป <br>
                            ร่วมกับ มีอาการระบบทางเดินหายใจอย่างใดอย่างหนึ่ง (ไอ น้ำมูก เจ็บคอ หายใจเร็ว หายใจเหนื่อย หรือ หายใจลำบาก)</h6> --}}

                            {{-- <div class="form-group row">
                            <div class="col-sm-3">
                            <button type="button" id="close" class="btn btn-s btn-danger">ไม่มีตัวอย่างและสิ่งส่งตรวจ</button>
                            </div>
                            <div class="col-sm-3">
                            <button type="button" id="open" class="btn btn-s btn-success">มีตัวอย่างและสิ่งส่งตรวจ</button>
                            </div>
                            </div> --}}
                            {{-- <div class="form-group row" id="lab"> --}}
                            <div class="form-group row">
                            <div class="col-sm-12">
                              <div class="table-responsive">
                              <table class="table" id="maintable">
                                  <thead>
                                    <tr>
                                      <th>#</th>
                                      <th>สถานที่ส่งตรวจ PCR of Novel Coronavirus</th>
                                      <th>ครั้งที่ตรวจ</th>
                                      <th>วันที่ตรวจ</th>
                                      <th>ตัวอย่างสิ่งส่งตรวจ</th>
                                      <th>สิ่งส่งตรวจอื่นๆ</th>
                                      <th>ผล PCR </th>
                                      {{-- <th>เพิ่ม / ลบ</th> --}}
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr class="data-contact-person">
                                      <td>
                                        <input type="text"  name="no_lab[]" value="1"  class="form-control " readonly>
                                      </td>
                                      <td>
                                        <select class="form-control" name="dms_pcr_contact[]">
                                          <option value="">- เลือก -</option>
                                          @foreach ($ref_lab as $row)
                                          <option value="{{$row->id}}">{{$row->th_name}}</option>
                                          @endforeach
                                        </select>
                                      </td>
                                      <td>
                                        <input type="text" id="dms_time_contact" name="dms_time_contact[]"  class="form-control dms_time_contact01" onkeyup="autocomplet()">
                                      </td>
                                      <td>
                                        <input type="text" id="date_dms_date_contact" name="dms_date_contact[]"  class="form-control dms_date_contact01" onkeyup="autocomplet()">
                                      </td>
                                      <td>
                                        <select class="form-control" name="dms_specimen_contact[]">
                                          <option value="">- เลือก -</option>
                                          @foreach ($ref_specimen as $row)
                                          <option value="{{$row->id}}">{{$row->name_en}}</option>
                                          @endforeach
                                        </select>
                                      </td>
                                      <td>
                                        <input type="text" id="chkspec_other_contact" name="chkspec_other_contact[]"  class="form-control chkspec_other_contact01" onkeyup="autocomplet()">
                                      </td>
                                      <td>
                                        <select class="form-control" name="other_pcr_result_contact[]">
                                          <option value="">- เลือก -</option>
                                        <option value="รอผล">รอผล</option>
                                        <option value="Negative">Negative</option>
                                        <option value="Positive">Positive</option>
                                      </select>
                                      {{-- <td>
                                          <button type="button" id="btnAdd" class="btn btn-xs btn-primary classAdd">Add More</button>
                                      </td> --}}
                                    </tr>
                                    <tr class="data-contact-person">
                                      <td>
                                        <input type="text"  name="no_lab[]" value="2"  class="form-control" readonly>
                                      </td>
                                      <td>
                                        <select class="form-control" name="dms_pcr_contact[]">
                                      <option value="">- เลือก -</option>
                                          @foreach ($ref_lab as $row)
                                          <option value="{{$row->id}}">{{$row->th_name}}</option>
                                          @endforeach
                                        </select>
                                      </td>
                                      <td>
                                        <input type="text" id="dms_time_contact" name="dms_time_contact[]"  class="form-control dms_time_contact01" onkeyup="autocomplet()">
                                      </td>
                                      <td>
                                        <input type="text" id="date_dms_date_contact2" name="dms_date_contact[]"  class="form-control dms_date_contact01" onkeyup="autocomplet()">
                                      </td>
                                      <td>
                                        <select class="form-control" name="dms_specimen_contact[]">
                                          <option value="">- เลือก -</option>
                                          @foreach ($ref_specimen as $row)
                                          <option value="{{$row->id}}">{{$row->name_en}}</option>
                                          @endforeach
                                        </select>
                                      </td>
                                      <td>
                                        <input type="text" id="chkspec_other_contact" name="chkspec_other_contact[]"  class="form-control chkspec_other_contact01" onkeyup="autocomplet()">
                                      </td>
                                      <td>
                                        <select class="form-control" name="other_pcr_result_contact[]">
                                          <option value="">- เลือก -</option>
                                        <option value="รอผล">รอผล</option>
                                        <option value="Negative">Negative</option>
                                        <option value="Positive">Positive</option>
                                      </select>
                                      {{-- <td>
                                          <button type="button" id="btnAdd" class="btn btn-xs btn-primary classAdd">Add More</button>
                                      </td> --}}
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            </div>
                    </div>
                    <div class="bd-callout bd-callout-danger" style="margin-top:0;position:relative">
                        <div style="position:absolute;top:10px;right:10px;z-index:1">
                            {{-- <a type="button" href="http://ncov2019.local/sat/list" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back To Lists SAT</a> --}}
                            <!-- <a type="button" href="http://ncov2019.local/screen-pui" class="btn btn-info"><i class="fas fa-user-plus"></i> New patient</a> -->
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label for="status_followup">สถานะการติดตาม</label>
                                <select type="text" name="status_followup" class="form-control js-select-basic-single" placeholder="การค้นหาผู้สัมผัส">
                                    <option value="">สถานะการติดตาม</option>
                                    <option value="1">จบการติดตาม</option>
                                    <option value="2">ยังต้องติดตาม</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                          <div class="col-sm-3">
                         <label for="followup_address">สถานที่ที่ติดตามผู้ป่วย</label>
                          <select type="text"  name="followup_address" id="hosdivshow" class="form-control js-select-basic-single" placeholder="พื้นที่จังหวัดที่ติดตามผู้ป่วย">
                          <option value="">สถานที่ที่ติดตามผู้ป่วย</option>
                          <option value="1">บ้าน</option>
                          <option value="2">โรงแรม</option>
                          <option value="3">โรงพยาบาล</option>
                          <option value="4">สถานที่กักกัน</option>
                          <option value="5">อื่นๆ</option>
                          </select>
                          </div>

                      </div>
                      <div id="follow_address_other" class="form-group row">
                      <div class="col-sm-3">
                        <label>ชื่อสถานที่ติดตามผู้ป่วย</label>
                        <input type="text" name="follow_address_other"  class="form-control"placeholder="ชื่อสถานที่ติดตามผู้ป่วย" >
                      </div>
                    </div>
                    	<div id="hosdiv" class="form-group row">
                            <div class="col-sm-3">
                                <label for="province_follow_contact">จังหวัดที่ติดตามผู้สัมผัส</label>
                                <select type="text" name="province_follow_contact" id="provincehos" class="form-control provincehos js-select-basic-single" placeholder="พื้นที่จังหวัดที่ติดตามผู้ป่วย">
                                    <option value="">พื้นที่จังหวัดที่ติดตามผู้สัมผัส</option>
                                    @foreach ($listprovince as $row)
                                    <option value="{{$row->province_id}}">{{$row->province_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label for="hospcode">โรงพยาบาลที่รักษาตัว</label>
                                <select name="hospcode" id="chospital_new" class="form-control chospital_new js-select-basic-single" placeholder="อำเภอ">
                                    <option value="">เลือกโรงพยาบาลที่รักษาตัว</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label for="division_follow_contact">หน่วยงานที่ติดตามผู้สัมผัส</label>
                                <select type="text" name="division_follow_contact" id="division_follow_contact" class="form-control js-select-basic-single" placeholder="พื้นที่จังหวัดที่ติดตามผู้ป่วย">
                                    <option value="">หน่วยงานที่ติดตามผู้สัมผัส</option>
                                    <option value="99">ส่วนกลาง</option>
                                    <option value="13">สปคม.</option>
                                    <option value="1">สคร.1</option>
                                    <option value="2">สคร.2</option>
                                    <option value="3">สคร.3</option>
                                    <option value="4">สคร.4</option>
                                    <option value="5">สคร.5</option>
                                    <option value="6">สคร.6</option>
                                    <option value="7">สคร.7</option>
                                    <option value="8">สคร.8</option>
                                    <option value="9">สคร.9</option>
                                    <option value="10">สคร.10</option>
                                    <option value="11">สคร.11</option>
                                    <option value="12">สคร.12</option>
                                    <option value="999">อื่นๆ</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label for="name_contact">หน่วยงานอื่นๆ</label>
                                <input type="text" class="form-control" name="division_follow_contact_other" placeholder="หน่วยงานอื่นๆ" autocomplete="off">
                            </div>
                        </div>
                    </div>
        <div class="col-sm-12">
            <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
        </div>
        </form>
    </div>
</div>
</div>
</div>
</div>
</div>
@endsection
@section('bottom-script')
  <script type="text/javascript">
  				$(document).ready(function () {
  					$(document).on("click", ".classAdd", function () { //
  						var rowCount = $('.data-contact-person').length + 1;
  						var contactdiv = '<tr class="data-contact-person">' +
              '<td><select class="form-control" name="dms_pcr_contact[]' + rowCount + '"">' +
                        '<option value="">- เลือก -</option>' +
                        '<option value="1">กรมวิทย์ฯ</option>' +
                        '<option value="2">สถาบันบำราศฯ</option>' +
                        '<option value="3">จุฬาลงกรณ์</option>' +
                        '<option value="4">PCR for Mers ที่อื่นๆ</option>' +
                        '</select></td>'+
  									'<td><input type="text" id="dms_time_contact' + rowCount + '" name="dms_time_contact[]' + rowCount + '"  class="form-control  dms_time_contact01" onkeyup="autocomplet()" />' +
                    '<td><input type="text" id="date_dms_date_contact' + rowCount + '" name="dms_date_contact[]' + rowCount + '"  class="form-control  dms_date_contact01" onkeyup="autocomplet()" />' +
  									'<td><select class="form-control" name="dms_specimen_contact[]' + rowCount + '"">' +
                                '<option value="">- เลือก -</option>'+
  															@foreach ($ref_specimen as $row)
  															'<option value="{{$row->id}}">{{$row->name_en}}</option>'+
  															@endforeach
  														'</select></td>'+
                              '<td><input type="text" id="chkspec_other_contact' + rowCount + '" name="chkspec_other_contact[]' + rowCount + '"  class="form-control  chkspec_other_contact01" onkeyup="autocomplet()" />' +
                              '<td><select class="form-control" name="other_pcr_result_contact[]' + rowCount + '"  title="ตำแหน่งในทีม" >' +
                                '<option value="">- เลือก -</option>'+
                                '<option value="รอผล">รอผล</option>'+
                                '<option value="Negative">Negative</option>'+
                                '<option value="Positive">Positive</option>'+
  															'</select></td>' +
  									'<td><button type="button" id="btnAdd" class="btn btn-xs btn-primary classAdd">Add More</button>' +
  										'<button type="button" id="btnDelete" class="deleteContact btn btn btn-danger btn-xs">Remove</button></td>' +
  								'</tr>';
  					$('#maintable').append(contactdiv); // Adding these controls to Main table class
  					$('#date_dms_date_contact' + rowCount + '').datepicker({
  						format: 'yyyy-mm-dd',
  						todayHighlight: true,
  						todayBtn: true,
  						autoclose: true
  					});
  			});
  			$(document).on("click", ".deleteContact", function () {
  				$(this).closest("tr").remove(); // closest used to remove the respective 'tr' in which I have my controls
  	});

  		});
  	</script>

<script type="text/javascript">
    $('.province').change(function() {
        if ($(this).val() != '') {
            var select = $(this).val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{route('dropdown.fetch')}}",
                method: "POST",
                data: {
                    select: select,
                    _token: _token
                },
                success: function(result) {
                    $('.district').html(result);
                }
            })
        }
    });
</script>
<script type="text/javascript">
    $('.district').change(function() {
        var selectD = $(this).val();
        if ($(this).val() != '') {
            console.log(selectD);
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{route('dropdown.fetchD')}}",
                method: "POST",
                data: {
                    select: selectD,
                    _token: _token
                },
                success: function(result) {
                    $('.subdistrict').html(result);
                }
            })
        }
    });
</script>


<script type="text/javascript">
    $('.provincehos').change(function() {
        if ($(this).val() != '') {
            var select = $(this).val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{route('dropdown.fetchos')}}",
                method: "POST",
                data: {
                    select: select,
                    _token: _token
                },
                success: function(result) {
                    $('.chospital_new').html(result);
                }
            })
        }
    });
</script>
{{-- <script src="{{ URL::asset('assets/libs/bootstrap-select-1.13.9/dist/js/bootstrap-select.min.js') }}"></script> --}}

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src="{{ URL::asset('assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.1/moment.min.js'></script>
<script src="{{ URL::asset('assets/contact/dualbox/jquery.bootstrap-duallistbox.js') }}"></script>
{{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> --}}

{{-- <script>
    $(function() {
        $('#lab').hide();
        $('#close').on('click', function() {
            $('#lab').hide();
        });
        $('#open').on('click', function() {
            $('#lab').show();
        });
    });
    // $('.selectpicker,#cb_send,#cb_result,#nps_ts1_result,#nps_ts2_send,#nps_ts3_send,#nps_ts2_result,#nps_ts1_send,#nps_ts1_result2,#nps_ts1_result3,#nps_ts2_result2,#nps_ts2_result3,#nps_ts3_result,#nps_ts3_result2,#nps_ts3_result3').selectpicker();
</script> --}}
<script>
    $('.input-daterange')
        .datepicker({
            orientation: "auto",
            todayHighlight: true,
            autoclose: true,
            format: "dd/mm/yyyy",
            startView: "days",
            minViewDate: 0,
            maxViewDate: 0,
            weekStart: 1
        });

    $('#ArrivalDate').each(function() {
        $(this).on('changeDate', function(e) {
            CheckIn = $(this).datepicker('getDate');
            CheckOut = moment(CheckIn).add(13, 'day').toDate();
            $('#DepartDate').datepicker('update', CheckOut).focus();
        });
    });
</script>
<script>
    /* date of birth */
    $('#datesymtom').datepicker({
        format: 'dd/mm/yyyy',
        todayHighlight: true,
        todayBtn: true,
        autoclose: true
    });
    $('#date_followup').datepicker({
        format: 'dd/mm/yyyy',
        todayHighlight: true,
        todayBtn: true,
        autoclose: true
    });
</script>
<script>
    /* date of birth */
    $('#date_dms_date_contact').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        todayBtn: true,
        autoclose: true
    });
    /* date of birth */
    $('#date_dms_date_contact2').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        todayBtn: true,
        autoclose: true
    });
</script>
<script>
    function show1() {
        document.getElementById('div1').style.display = 'none';
    }

    function show2() {
        document.getElementById('div1').style.display = 'block';
    }
</script>
<script>
    function show21() {
        document.getElementById('div2').style.display = 'none';
    }

    function show22() {
        document.getElementById('div2').style.display = 'block';
    }
</script>
<script>
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.js-select-basic-single').select2();
    });
</script>
<script>
    $('#cuscontactid').change(function() {
        $("#inputcontact").prop("readonly", !$(this).is(':checked'));
    });
    $('#followup_address').change(function() {
        $("#followup_address_hos").prop("readonly", !$(this).is(':checked'));
    });
</script>
<script>
    var msg = '{{Session::get('
    alert ')}}';
    var exist = '{{Session::has('
    alert ')}}';
    if (exist) {
        alert(msg);
    }
</script>
<script>
var demo1 = $('select[name="sat_id_relation[]"]').bootstrapDualListbox();
$("#demoform").submit(function() {
  alert($('[name="sat_id_relation[]"]').val());
  return false;
});
</script>
<script>
$(document).ready(function(){
  $("#hosdiv").hide();
  $("#follow_address_other").hide();
    $('#hosdivshow').on('change', function() {
      if ( this.value == '1')
      {
        $("#follow_address_other").show();
        $("#hosdiv").hide();
      }
      if ( this.value == '2')
      {
        $("#follow_address_other").show();
        $("#hosdiv").hide();
      }
      if ( this.value == '4')
      {
        $("#follow_address_other").show();
        $("#hosdiv").hide();
      }
      if ( this.value == '3')
      {
        $("#hosdiv").show();
        $("#follow_address_other").hide();
      }
    });
});
</script>
@endsection
