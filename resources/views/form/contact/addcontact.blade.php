@extends('layouts.index')
@section('contents')
<div class="page-breadcrumb">
	<div class="row">
		<div class="col-12 d-flex no-block align-items-center">
			<h4 class="page-title">แบบสอบสวน CORONAVIRUS 2019</h4>
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
          <div class="card">
            <div class="card-header">
            <h5>แบบสอบสวน CORONAVIRUS 2019</h5>
            </div>
            <br>
            <div class="card-block">
            <h4 class="sub-title">ข้อมูลทั่วไปผู้สัมผัส</h4>
            <form action="{{route('contactinsert')}}" method="post">
              			{{ csrf_field() }}
            <div class="form-group row">
            <div class="col-sm-3">
            <select type="text" name="title_contact" class="form-control" placeholder="คำนำหน้าชื่อ">
                <option value="">คำนำหน้าชื่อ</option>
                  <option value="">- เลือก -</option>
                  <option value="นาย">นาย</option>
                  <option value="นาง">นาง</option>
                  <option value="น.ส">น.ส</option>
                  <option value="ด.ช">ด.ช</option>
                  <option value="ด.ญ">ด.ญ</option>
                  <option value="Mr">Mr</option>
                  <option value="Mrs">Mrs</option>
            </select>
            </div>
            <div class="col-sm-3">
            <input type="text" name="name_contact" class="form-control" placeholder="ชื่อต้นผู้สัมผัส">
            </div>
            <div class="col-sm-3">
            <input type="text" name="mname_contact" class="form-control" placeholder="ชื่อกลางผู้สัมผัส">
            </div>
            <div class="col-sm-3">
            <input type="text" name="lname_contact" class="form-control" placeholder="นามสกุลผู้สัมผัส">
            </div>
            </div>
            <div class="form-group row">
            <div class="col-sm-4">
            <select type="text" name="sex_contact" class="form-control" placeholder="col-sm-2">
                <option value="">เพศ</option>
                  <option value="">- เลือก -</option>
                  <option value="M">ชาย</option>
                <option value="F">หญิง</option>
            </select>
            </div>
            <div class="col-sm-4">
            <input type="text" name="age_contact" class="form-control" placeholder="อายุ">
            </div>
            </div>
            <div class="form-group row">

            <div class="col-sm-3">
            <select type="text" name="national_contact" class="form-control" placeholder="สัญชาติ">
            @foreach ($listcountry as $row)
            <option value="{{$row->id}}">{{$row->national}}</option>
            @endforeach
            </select>
            </div>
            <div class="col-sm-3">
            <input type="text" name="province" id="province" class="form-control" placeholder="จังหวัด">
            </div>
            <div class="col-sm-3">
            <input type="text" name="district" id="district" class="form-control" placeholder="อำเภอ">
            </div>
            <div class="col-sm-3">
            <input type="text" name="sub_district" id="sub_district" class="form-control" placeholder="ตำบล">
            </div>
            </div>
            <div class="form-group row">
            <div class="col-sm-4">
            <textarea rows="3" type="text" class="form-control" placeholder="ที่อยู่"></textarea>
            </div>
            <div class="col-sm-4">
            <input  type="text" class="form-control" placeholder="เบอร์โทร">
            </div>
            <div class="col-sm-4">
            <textarea rows="3" type="text" class="form-control" placeholder="การสัมผัสผู้ป่วย"></textarea>
            </div>
            </div>
            <div class="form-group row">
            <div class="col-sm-3">
            <select type="text" name="risk_contact" class="form-control" placeholder="ระดับความเสี่ยง">
                <option value="">ระดับความเสี่ยง</option>
                  <option value="">- เลือก -</option>
                  <option value="1">เสี่ยงสูง</option>
                  <option value="2">เสี่ยงต่ำ</option>
                  <option value="3">เสี่ยงต่ำมาก</option>
            </select>
            </div>
            <div class="col-sm-3">
            <input type="text" class="form-control" id="" placeholder="วันที่สัมผัส">
            </div>
            <div class="col-sm-3">
            <input type="text" class="form-control" placeholder="ให้ตามถึงวันที่">
            </div>
            <div class="col-sm-3">
            <select type="text" name="type_contact" class="form-control" placeholder="ประเภทผู้สัมผัส">
                <option value="">ประเภทผู้สัมผัส</option>
                  <option value="">- เลือก -</option>
                  <option value="1">บุคลากรทางการแพทย์</option>
                  <option value="2">ผู้สัมผัสร่วมบ้าน</option>
                  <option value="3">ผู้ร่วมเดินทาง</option>
                  <option value="4">พนักงานโรงแรม</option>
                  <option value="5">คนขับแท๊กซี่/ยานพาหนะ</option>
                  <option value="6">พนักงานสนามบิน</option>
                  <option value="8">อื่นๆ</option>
              </select>
            </div>
            </div>
            <div class="form-group row">
            <div class="col-sm-3">
            <select type="text" name="routing_contact" class="form-control" placeholder="การค้นหาผู้สัมผัส">
              <option value="">การค้นหาผู้สัมผัส</option>
                <option value="">- เลือก -</option>
                <option value="1">พบ</option>
                <option value="2">ไม่พบ</option>
            </select>
            </div>
            <div class="col-sm-3">
            <select type="text" name="available_contact" class="form-control" placeholder="การติดตามผู้สัมผัส">
              <option value="">การติดตามผู้สัมผัส</option>
                <option value="">- เลือก -</option>
                <option value="1">อยู่ในประเทศ</option>
                <option value="2">ออกนอกประเทศ</option>
            </select>
            </div>
            </div>
            <div class="form-group row">
            <div class="col-sm-12">
              <table class="table" id="maintable">
                  <thead>
                    <tr>
                      <th>สถานที่ส่งตรวจ PCR of Novel Coronavirus</th>
                      <th>ครั้งที่ตรวจ</th>
                      <th>วันที่ตรวจ</th>
                      <th>ตัวอย่างสิ่งส่งตรวจ</th>
                      <th>สิ่งส่งตรวจอื่นๆ</th>
                      <th>ผล PCR </th>
                      <th>เพิ่ม / ลบ</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="data-contact-person">

                      <td>
                        <select class="form-control" name="dms_pcr_contact[]">
                          <option value="">- เลือก -</option>
                          <option value="1">กรมวิทย์ฯ</option>
                          <option value="2">สถาบันบำราศฯ</option>
                          <option value="3">จุฬาลงกรณ์</option>
                          <option value="4">PCR for Mers ที่อื่นๆ</option>
                        </select>
                      </td>
                      <td>
                        <input type="text" id="dms_time_contact" name="dms_time_contact[]"  class="form-control dms_time_contact01" onkeyup="autocomplet()">
                      </td>
                      <td>
                        <input type="text" id="dms_date_contact" name="dms_date_contact[]"  class="form-control dms_date_contact01" onkeyup="autocomplet()">
                      </td>
                      <td>
                        <select class="form-control" name="dms_specimen_contact[]">
                          <option value="">- เลือก -</option>
      							      <option value="Nasopharyngeal swab">Nasopharyngeal swab</option>
      							      <option value="Throat swab">Throat swab</option>
      							      <option value="Sputum">Sputum</option>
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
                      <td>
                          <button type="button" id="btnAdd" class="btn btn-xs btn-primary classAdd">Add More</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
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
                  '<td><input type="text" id="dms_date_contact' + rowCount + '" name="dms_date_contact[]' + rowCount + '"  class="form-control  dms_date_contact01" onkeyup="autocomplet()" />' +
									'<td><select class="form-control" name="dms_specimen_contact[]' + rowCount + '"">' +
                              '<option value="">- เลือก -</option>'+
                              '<option value="Nasopharyngeal swab">Nasopharyngeal swab</option>'+
                              '<option value="Throat swab">Throat swab</option>'+
                              '<option value="Sputum">Sputum</option>'+
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
			});
			$(document).on("click", ".deleteContact", function () {
				$(this).closest("tr").remove(); // closest used to remove the respective 'tr' in which I have my controls
	});

		});
	</script>

@endsection
