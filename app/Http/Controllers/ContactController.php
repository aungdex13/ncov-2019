<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
class ContactController extends MasterController
{
  // allcontact table
	public function allcasecontacttable(Request $req)

{
  if(auth()->user()->id==Auth::user()->id){
		$contact_data=
									DB::table('tbl_contact')
												->join('users','tbl_contact.user_id','=','users.id')
												->select('tbl_contact.*',
																  DB::raw('tbl_contact.id as conid'),
																  'users.id',
																	'users.prefix_sat_id')
												->where('users.prefix_sat_id',Auth::user()->prefix_sat_id)
												->get();
		$nation_list = $this->arrnation();
		$arr_occu = $this->arroccu();
		$arrprov = $this->arrprov();
		$arrdistrict = $this->arrdistrict();
		$arr_sub_district = $this->arr_sub_district();
		$arr_division_follow_contact = $this->arr_division_follow_contact();
    return view('form.contact.allcasecontacttable',compact(
			'contact_data',
			'nation_list',
			'arr_occu',
			'arrprov',
			'arrdistrict',
			'arr_division_follow_contact',
			'arr_sub_district'
    ));
  }
}
	// allcontact table
	public function editstatus(Request $req)
	{
		$sat_id=$req->sat_id;
		// $poe_id=$req->poe_id;
		$contact_id=$req->contact_id;
		// dd($poe_id);
		$contact_data=DB::table('tbl_contact')->select('*')->get();
		return view('form.contact.editstatus',compact(
			'contact_data'
		));
	}


  // indexcontact table
  public function contacttable(Request $req)
  {
		// $sat_id=$req->sat_id;
		$id=$req->id;
		$nation_list = $this->arrnation();
		$arr_occu = $this->arroccu();
		$arrprov = $this->arrprov();
		$arrdistrict = $this->arrdistrict();
		$arr_sub_district = $this->arr_sub_district();
		$arr_pts = $this->arr_pts();
		$count_data = $this->arr_pts();
		$arr_status_followup = $this->arr_status_followup();
		$arr_risk_contact=$this->arr_risk_contact();
		$count_con=DB::table('patient_relation')
															->select(DB::raw('count(*) as count_cont'))
															->where('pui_id', $id)
															->get();
		$count_hrisk=DB::table('tbl_contact')
															->select(DB::raw('count(*) as count_hrisk'))
															->where('pui_id', $id)
															->where('risk_contact', '=','1')
															->get();
		$count_lrisk=DB::table('tbl_contact')
															->select(DB::raw('count(*) as count_lrisk'))
															->where('pui_id', $id)
															->where('risk_contact', '=','2')
															->get();
		$count_labcont=DB::table('tbl_contact_hsc')
															->select(DB::raw('count(*) as count_labcont'))
															->where('pui_id', $id)
															->where('dms_pcr_contact', '>=','1')
															->get();
		 // dd($arr_status_followup);
		$ref_pt_status=DB::table('ref_pt_status')->select('pts_id','pts_name_en')->get();
		$patian_data=DB::table('invest_pt')->select('*')->where('id', [$req->id] )->get();
		$contact_data=DB::table('patient_relation')
										->join('tbl_contact', 'patient_relation.contact_id', '=', 'tbl_contact.contact_id')
										->select('patient_relation.id',
															'patient_relation.pui_id',
															'patient_relation.sat_id',
															'patient_relation.contact_rid',
															'patient_relation.contact_id',
															'patient_relation.create_date',
															'patient_relation.dalete_date',
															'tbl_contact.age_contact',
															'tbl_contact.sex_contact',
															'tbl_contact.phone_contact',
															'tbl_contact.national_contact',
															'tbl_contact.province',
															'tbl_contact.district',
															'tbl_contact.sub_district',
															'tbl_contact.pt_status',
															'tbl_contact.risk_contact',
															'tbl_contact.name_contact',
															'tbl_contact.lname_contact',
															'tbl_contact.status_followup')
										->where('patient_relation.pui_id', $id)
										->get();


    return view('form.contact.contacttable',compact(
			'contact_data',
			'id',
			'patian_data',
			'nation_list',
			'arr_occu',
			'arrprov',
			'arrdistrict',
			'arr_sub_district',
			'ref_pt_status',
			'arr_pts',
			'arr_status_followup',
			'arr_risk_contact',
			'count_con',
			'count_hrisk',
			'count_lrisk',
			'count_labcont'
    ));
  }


  public function followuptablespui(Request $req)
  {
		$arr = parent::getStatus();
		$sat_id=$req->sat_id;
		$patian_date=DB::table('tbl_followup')->where('patianid')->get();
		$patian_data=DB::table('invest_pt')->select('*')->where('sat_id', [$req->sat_id] )->get();
		$contact_data=DB::table('tbl_contact')->select('*')->where('sat_id', $sat_id)->get();
		$fucontact_data=DB::table('tbl_followup')->select('*')->where('patianid', $req->id)->get();
		$id=$req->id;
		$typid=$req->typid;
		$followup_times=$req->followup_times;
		$arr_division_follow_contact = $this->arr_division_follow_contact();
    return view('form.contact.followuptablespui',compact(
			'sat_id',
			// 'poe_id',
			'followup_times',
			'id',
			'typid',
			'fucontact_data',
			'contact_data',
			'patian_date',
			'patian_data',
			'arr_division_follow_contact',
			'arr'
    ));
  }

	public function followuptablescon(Request $req)
  {
		$arr = parent::getStatus();
		$sat_id=$req->sat_id;
		$patian_date=DB::table('tbl_followup')->where('patianid')->get();
		$patian_data=DB::table('invest_pt')->select('*')->where('sat_id', [$req->sat_id] )->get();
		$contact_data=DB::table('tbl_contact')->select('*')->where('sat_id', $sat_id)->get();
		$fucontact_data=DB::table('tbl_followup')->select('*')->where('patianid', $req->id)->get();
		$id=$req->id;
		$typid=$req->typid;
		$followup_times=$req->followup_times;
		$arr_division_follow_contact = $this->arr_division_follow_contact();
    return view('form.contact.followuptablescon',compact(
			'sat_id',
			// 'poe_id',
			'followup_times',
			'id',
			'typid',
			'fucontact_data',
			'contact_data',
			'patian_date',
			'patian_data',
			'arr_division_follow_contact',
			'arr',
    ));
  }

	public function puifollowtable(Request $req)

{
  if(auth()->user()->id==Auth::user()->id){
		$pui_data=
									DB::table('invest_pt')
												->join('users','invest_pt.entry_user','=','users.id')
												->select('invest_pt.sat_id',
																 'users.id',
																 'invest_pt.sex',
																 'invest_pt.age',
																 'invest_pt.nation',
																 'invest_pt.race',
																 DB::raw('invest_pt.id as puiid'),
																 'users.prefix_sat_id')
												->where('users.prefix_sat_id',Auth::user()->prefix_sat_id)
												->get();
		$nation_list = $this->arrnation();
		$arr_occu = $this->arroccu();
		$arrprov = $this->arrprov();
		$arrdistrict = $this->arrdistrict();
		$arr_sub_district = $this->arr_sub_district();
		$ref_pt_status=DB::table('ref_pt_status')->select('pts_id','pts_name_en')->get();
		$arr_division_follow_contact = $this->arr_division_follow_contact();
    return view('form.contact.puifollowtable',compact(
			'pui_data',
			'nation_list',
			'arr_occu',
			'arrprov',
			'arrdistrict',
			'arr_division_follow_contact',
			'arr_sub_district',
			'ref_pt_status'
    ));
  }
}

public function contactfollowtable(Request $req)

{
if(auth()->user()->id==Auth::user()->id){
	$contact_data=
	DB::table('tbl_contact')
				->join('users','tbl_contact.user_id','=','users.id')
				->select('tbl_contact.*', DB::raw('tbl_contact.id as conid'),
				'users.id',
				'users.prefix_sat_id')
				->where('users.prefix_sat_id',Auth::user()->prefix_sat_id)
				->get();
	$nation_list = $this->arrnation();
	$arr_occu = $this->arroccu();
	$arrprov = $this->arrprov();
	$arrdistrict = $this->arrdistrict();
	$arr_sub_district = $this->arr_sub_district();
	$arr_division_follow_contact = $this->arr_division_follow_contact();
	$arr_pts = $this->arr_pts();
	$ref_pt_status=DB::table('ref_pt_status')->select('pts_id','pts_name_en')->get();
	return view('form.contact.contactfollowtable',compact(
		'contact_data',
		'nation_list',
		'arr_occu',
		'arrprov',
		'arrdistrict',
		'arr_division_follow_contact',
		'arr_sub_district',
		'arr_pts',
		'ref_pt_status'
	));
}
}

	// form contact add
	public function detailcontact(Request $req)
	{
		$contact_id=$req->contact_id;
		$sat_id=$req->sat_id;
		$ref_title_name=DB::table('ref_title_name')->select('*')->get();
		$nation_list = $this->arrnation();
		$arr_occu = $this->arroccu();
		$arrprov = $this->arrprov();
		$arrsymptoms = $this->arrsymptoms();
		$arrspecimen = $this->arrspecimen();
		$ref_specimen=DB::table('ref_specimen')->select('*')->get();
		$ref_detail_contact=DB::table('tbl_contact')
												->select('name_contact',
																 'mname_contact',
																 'lname_contact',
																 'passport_contact',
																 'sex_contact',
																 'age_contact',
																 'passport_contact',
																 'national_contact',
																 'address_contact',
																 'phone_contact',
																 'patient_contact',
																 'datecontact',
																 'type_contact')
												->where('contact_id',$req->contact_id)
												->get();
		$ref_detail_pt=DB::table('invest_pt')
														->select('first_name',
																			'mid_name',
																			'last_name',
																			'sex',
																			'age',
																			'nation',
																			'occupation',
																			'isolated_province')
														  ->where('id',$req->pui_id)
															->get();
		$ref_detail_follow=DB::table('tbl_followup')
            					->select('*')
											->where('contact_id',$req->contact_id)
            					->get();
		$ref_global_country=DB::table('ref_global_country')->select('country_id','country_name')->get();
		$sat_id=$req->sat_id;
		return view('form.contact.detailcontact',compact(
			'ref_title_name',
			'ref_specimen',
			'ref_global_country',
			'ref_detail_contact',
			'ref_detail_pt',
			'ref_detail_follow',
			'sat_id',
			'nation_list',
			'arr_occu',
			'arrprov',
			'arrsymptoms',
			'arrspecimen'
		));
	}


  // form contact add
  public function addcontact(Request $req)
	{
		$contact_id = $req ->input ('contact_id');
		$pui_id=$req->id;
		$ref_title_name=DB::table('ref_title_name')->select('*')->get();
		$ref_specimen=DB::table('ref_specimen')->select('*')->get();
		$ref_global_country=DB::table('ref_global_country')->select('country_id','country_name')->get();
		$ref_lab=DB::table('laboratory')->select('id','th_name')->get();
		$sat_id=DB::table('invest_pt')->select('sat_id','id')->where('id', $pui_id )->get();
		$sat_id_confirm=DB::table('invest_pt')
										->select('id','sat_id','first_name','last_name','nation')
										->where('pt_status' ,"=" ,"2" )
										->get();
		$sat_id_relation=DB::table('patient_relation')
												->select('id','sat_id','contact_id')
												->where('pui_id' , $pui_id )
												->where('contact_id' , $contact_id )
												->get();
		$arr_province=$this->arr_province();
		$arr_hos=$this->arr_hos();
		$arr_followup_address=$this->arr_followup_address();
    $listprovince=$this->province();
		$nation_list = $this->arrnation();
    $listcountry=$this->arrnation();
		$arr_laboratory=$this->arr_laboratory();
		$entry_user = Auth::user()->id;
		$prefix_sat_id = Auth::user()->prefix_sat_id;
		return view('form.contact.addcontact',compact(
      'listprovince',
      'listcountry',
			'ref_title_name',
			'ref_specimen',
			'ref_global_country',
			'sat_id',
			'prefix_sat_id',
			'entry_user',
			'pui_id',
			'sat_id_confirm',
			'nation_list',
			'sat_id_relation',
			'arr_province',
			'arr_hos',
			'arr_followup_address',
			'arr_laboratory',
			'ref_lab'
    ));
	}


	public function editcontact(Request $req)
	{
		$contact_id=$req->contact_id;
		$sat_id_confirm=DB::table('invest_pt')
										->select('id','sat_id','first_name','last_name','nation')
										->where('pt_status' ,"=" ,"2" )
										->get();
		$getdata_contact=DB::table('tbl_contact')->select('*')->where('contact_id',$contact_id)->get();
		$getdata_hsc_contact=DB::table('tbl_contact_hsc')
														->select('*')
														->where('contact_id',$contact_id)->get();
		$getdata_fucontact=DB::table('tbl_followup')
													->select('*')
													->where('patianid',$contact_id)
													->where('followup_times','=',"0")
													->get();

			// dd($getdata_fucontact);
		$ref_title_name=DB::table('ref_title_name')->select('*')->get();
		$arr_followup_address=$this->arr_followup_address();
		$ref_specimen=DB::table('ref_specimen')->select('*')->get();
		$ref_global_country=DB::table('ref_global_country')->select('country_id','country_name')->get();
		$arrtitlename=$this->arrtitlename();
		$arr_type_contact = $this->arr_type_contact();
		$arr_division_follow_contact = $this->arr_division_follow_contact();
		$arr_hos = $this->arr_hos();
		$arr_status_followup = $this->arr_status_followup();
		$arr_available_contact = $this->arr_available_contact();
		$arr_follow_results = $this->arr_follow_results();
		// $arrtitlename = $this->arrtitlename();
		// $sat_id=$req->sat_id;
		$arrspecimen= $this->arrspecimen();
				$arr_laboratory=$this->arr_laboratory();
						$ref_lab=DB::table('laboratory')->select('id','th_name')->get();
		$arr_dms_pcr_contact= $this->arr_dms_pcr_contact();
		$arr_other_pcr_result_contact= $this->arr_other_pcr_result_contact();
		$contact_id=$req->contact_id;
		$nation_list = $this->arrnation();
    $listprovince=$this->province();
		$arr_province=$this->arr_province();
		$arrdistrict=$this->arrdistrict();
		$arr_risk_contact=$this->arr_risk_contact();
		$arr_sub_district=$this->arr_sub_district();
    $listcountry=$this->arrnation();
		$entry_user = Auth::user()->id;
		$prefix_sat_id = Auth::user()->prefix_sat_id;
		return view('form.contact.editcontact',compact(
			'arrspecimen',
			'arr_dms_pcr_contact',
			'arr_other_pcr_result_contact',
      'listprovince',
      'listcountry',
			'ref_title_name',
			'ref_specimen',
			'ref_global_country',
			'contact_id',
			'prefix_sat_id',
			'entry_user',
			'getdata_contact',
			'arrtitlename',
			'arr_province',
			'nation_list',
			'arrdistrict',
			'sat_id_confirm',
			'arr_sub_district',
			'arr_risk_contact',
			'arr_type_contact',
			'arr_division_follow_contact',
			'arr_hos',
			'arr_status_followup',
			'arr_available_contact',
			'arr_follow_results',
			'getdata_fucontact',
			'arr_followup_address',
			'getdata_hsc_contact',
			'arr_laboratory',
			'ref_lab'
    ));
	}


  public function followup(Request $req)
  {
		$ref_title_name=DB::table('ref_title_name')->select('*')->get();
		$ref_specimen=DB::table('ref_specimen')->select('*')->get();
		$followup_date=DB::table('tbl_followup')->select('*')->get();
		$ref_global_country=DB::table('ref_global_country')->select('country_id','country_name')->get();
		$sat_id=DB::table('tbl_contact')->select('pui_id','sat_id')->where('contact_id', $req->contact_id )->get();
		$id=$req->id;
		$typid=$req->typid;
		$contact_id_day=$req->contact_id_day;
		$listprovince=$this->province();
		$entry_user = Auth::user()->id;
		$prefix_sat_id = Auth::user()->prefix_sat_id;
    return view('form.contact.followup',compact(
			'listprovince',
			'ref_title_name',
			'ref_specimen',
			'ref_global_country',
			'sat_id',
			'followup_date',
			'prefix_sat_id',
			'contact_id_day',
			'id',
			'typid',
			'entry_user'
    ));
  }





	  public function addfollowuppui(Request $req)
	  {
			$arr = parent::getStatus();
			$ref_title_name=DB::table('ref_title_name')->select('*')->get();
			$ref_specimen=DB::table('ref_specimen')->select('*')->get();
			$followup_date=DB::table('tbl_followup')->select('*')->get();
			$ref_global_country=DB::table('ref_global_country')->select('country_id','country_name')->get();
			$sat_id=DB::table('tbl_contact')->select('pui_id','sat_id')->where('contact_id', $req->contact_id )->get();
			$id=$req->id;
			$typid=$req->typid;
			$position_follow=DB::table('tbl_followup')->select('followup_address','province_follow_contact','hospcode','division_follow_contact','division_follow_contact_other')
																			 ->where('patianid', $id)
																			 ->where('followup_times', '=', '0')
																			 ->get();
			$arr_followup_address=$this->arr_followup_address();
			$contact_id_day=$req->contact_id_day;
			$listprovince=$this->province();
			$arr_province=$this->arr_province();
			$arr_hos=$this->arr_hos();
			$arr_followup_address=$this->arr_followup_address();
			$entry_user = Auth::user()->id;
			$prefix_sat_id = Auth::user()->prefix_sat_id;
	    return view('form.contact.addfollowuppui',compact(
				'listprovince',
				'ref_title_name',
				'ref_specimen',
				'ref_global_country',
				'sat_id',
				'followup_date',
				'prefix_sat_id',
				'contact_id_day',
				'id',
				'typid',
				'entry_user',
				'arr',
				'position_follow',
				'arr_province',
				'arr_hos',
				'arr_followup_address'
	    ));
	  }

		public function addfollowupcon(Request $req)
	  {
			$arr = parent::getStatus();
			$id=$req->id;
			$typid=$req->typid;
			$ref_title_name=DB::table('ref_title_name')->select('*')->get();
			$ref_specimen=DB::table('ref_specimen')->select('*')->get();
			$followup_date=DB::table('tbl_followup')->select('*')->get();
			$ref_global_country=DB::table('ref_global_country')->select('country_id','country_name')->get();
			$sat_id=DB::table('tbl_contact')->select('pui_id','sat_id')->where('contact_id', $req->contact_id )->get();
			$position_follow=DB::table('tbl_followup')
			->select('followup_address','province_follow_contact','hospcode','division_follow_contact','division_follow_contact_other')
																			 ->where('patianid', $id)
																			 ->where('followup_times', '=', '0')
																			 ->get();
			// dd($position_follow);
			$contact_id_day=$req->contact_id_day;
			$listprovince=$this->province();
			$entry_user = Auth::user()->id;
			$arr_province=$this->arr_province();
			$arr_hos=$this->arr_hos();
			$arr_followup_address=$this->arr_followup_address();
			$prefix_sat_id = Auth::user()->prefix_sat_id;
	    return view('form.contact.addfollowupcon',compact(
				'listprovince',
				'ref_title_name',
				'ref_specimen',
				'ref_global_country',
				'sat_id',
				'followup_date',
				'prefix_sat_id',
				'contact_id_day',
				'id',
				'typid',
				'entry_user',
				'arr',
				'position_follow',
				'arr_province',
				'arr_hos',
				'arr_followup_address'
	    ));
	  }




  public function contactinsert(Request $req) {
	 $contact_id = $req ->input ('contact_id');
	 $contact_id_temp = $req ->input ('contact_id_temp');
	 if ($contact_id == $contact_id_temp) {
		 $contact_id_temp = $req ->input ('contact_id_temp');
	 } else {
		 $contact_id_temp = "";
	 }

	$update_pt = DB::table('invest_pt')
							->where('id', $req ->input ('pui_id'))
							->update(['cont' => "y"]);
	// if ($update_pt)
	{
	// $contactid=uniqid();
  // $poe_id = $req ->input ('poe_id');
	$sat_id = $req ->input ('sat_id');
	$pui_id = $req ->input ('pui_id');
	// dd($pui_id);
  // $contact_id = $poe_id.'_'.$contactid;	// dd($order);
	$user_id = $req ->input ('user_id');
	$title_contact = $req ->input ('title_contact');
  $name_contact = $req ->input ('name_contact');
  $mname_contact = $req ->input ('mname_contact');
  $lname_contact = $req ->input ('lname_contact');
  $sex_contact = $req ->input ('sex_contact');
  $age_contact = $req ->input ('age_contact');
	$passport_contact = $req ->input ('passport_contact');
  $national_contact = $req ->input ('national_contact');
  $province = $req ->input ('province');
  $district = $req ->input ('district');
  $sub_district = $req ->input ('sub_district');
  $address_contact = $req ->input ('address_contact');
  $phone_contact = $req ->input ('phone_contact');
  $patient_contact = $req ->input ('patient_contact');
  $risk_contact = $req ->input ('risk_contact');
  $datecontact = $this->convertDatefollowToMySQL($req ->input ('datecontact'));
  $datefollow = $this->convertDatefollowToMySQL($req ->input ('datefollow'));
	$date_followup = $this->convertDateToMySQL($req ->input ('date_followup'));
  $type_contact = $req ->input ('type_contact');
  $date_entry = date('Y-m-d') ;
  $data = array(
    // 'poe_id'=>$poe_id,
		'sat_id'=>$sat_id,
		'pui_id'=>$pui_id,
    'contact_id'=>$contact_id,
		'contact_id_temp'=>$contact_id_temp,
		'title_contact'=>$title_contact,
    'name_contact'=>$name_contact,
    'mname_contact'=>$mname_contact,
    'lname_contact'=>$lname_contact,
    'sex_contact'=>$sex_contact,
    'age_contact'=>$age_contact,
		'passport_contact'=>$passport_contact,
    'national_contact'=>$national_contact,
    'province'=>$province,
    'district'=>$district,
    'sub_district'=>$sub_district,
    'address_contact'=>$address_contact,
    'phone_contact'=>$phone_contact,
    'patient_contact'=>$patient_contact,
    'risk_contact'=>$risk_contact,
    'datecontact'=>$datecontact,
    'datefollow'=>$datefollow,
		'date_followup'=>$date_followup,
    'type_contact'=>$type_contact,
		'user_id'=>$user_id,
    'date_entry'=>$date_entry
  );
      // dd($data);
  $res1	= DB::table('tbl_contact')->insert($data);

	$last_res1_insert_id = DB::getPdo()->lastInsertId();
	// dd($last_res1_insert_id);
  if ($res1)
	$sat_id = $req ->input ('sat_id');
	$pui_id = $req ->input ('pui_id');
	$patianid = $req ->input ('patianid');
	$typid = "2";
	$contact_id = $req ->input ('contact_id');
	$followup_times= "0";
	$date_no = date('Y-m-d') ;
	$clinical = $req ->input ('clinical');
	$fever = $req ->input ('fever');
	$cough = $req ->input ('cough');
	$sore_throat = $req ->input ('sore_throat');
	$mucous = $req ->input ('mucous');
	$sputum = $req ->input ('sputum');
	$breath_labored = $req ->input ('breath_labored');
	$suffocate = $req ->input ('suffocate');
	$muscle_aches = $req ->input ('muscle_aches');
	$headache = $req ->input ('headache');
	$diarrhea = $req ->input ('diarrhea');
	$other_symtom = $req ->input ('other_symtom');
	$status_followup = $req ->input ('status_followup');
	$available_contact = $req ->input ('available_contact');
	$follow_results = $req ->input ('follow_results');
	$user_id = $req ->input ('user_id');
	$followup_address = $req ->input ('followup_address');
	$sat_id_class = $req ->input ('sat_id_class');
	$province_follow_contact = $req ->input ('province_follow_contact');
	$division_follow_contact = $req ->input ('division_follow_contact');
	$division_follow_contact_other = $req ->input ('division_follow_contact_other');
	$datesymtom = $this->convertDatefollowToMySQL($req ->input ('datesymtom'));
	$date_entry = date('Y-m-d') ;
	$hospcode = $req ->input ('hospcode');
	$follow_address_other = $req ->input ('follow_address_other');
	$data = array(
		// 'poe_id'=>$poe_id,
		'sat_id'=>$sat_id,
		'pui_id'=>$pui_id,
		'contact_id'=>$contact_id,
		'patianid'=>$contact_id,
		'typid'=>$typid,
		'followup_times'=>$followup_times,
		'followup_address'=>$followup_address,
		'date_no'=>$date_no,
		'clinical'=>$clinical,
		'fever'=>$fever,
		'cough'=>$cough,
		'sore_throat'=>$sore_throat,
		'mucous'=>$mucous,
		'sputum'=>$sputum,
		'breath_labored'=>$breath_labored,
		'suffocate'=>$suffocate,
		'muscle_aches'=>$muscle_aches,
		'headache'=>$headache,
		'diarrhea'=>$diarrhea,
		'other_symtom'=>$other_symtom,
		'status_followup'=>$status_followup,
		'available_contact'=>$available_contact,
		'follow_results'=>$follow_results,
		'user_id'=>$user_id,
		'province_follow_contact'=>$province_follow_contact,
		'division_follow_contact'=>$division_follow_contact,
		'division_follow_contact_other'=>$division_follow_contact_other,
		'sat_id_class'=>$sat_id_class,
		'datesymtom'=>$datesymtom,
		'date_entry'=>$date_entry,
				'follow_address_other'=>$follow_address_other,
		'hospcode'=>$hospcode
	);
	 // dd($data);
	$res2	= DB::table('tbl_followup')->insert($data);
	if ($res2) {
		$sat_id_relation = $req->input('sat_id_relation');
		$pui_id_r= $req->input('pui_id_r');
		$contact_id_code =$req->input('contact_code');
		$contact_rid =$last_res1_insert_id;
		// dd($contact_rid);
		$contact_id =$req->input('contact_id');
		// $sat_id_relation = $req->input('sat_id_relation');
		//dd($sat_id_relation);
		$create_date=date('Y-m-d') ;
		$x=0;
			for ($i=0; $i < count($sat_id_relation); $i++) {
				$exp = explode('|', $sat_id_relation[$i]);
				$sat_id_relation_arr[$i] = $exp;
				$data_pt[]  = [
							'contact_rid'=>$contact_rid,
							'contact_id'=>$contact_id,
							'pui_id'=>$sat_id_relation_arr[$i][1],
							'sat_id'=>$sat_id_relation_arr[$i][0],
							'create_date' => $create_date
										];
			}
			// dd($data_pt);
			$x++;
			$res3	= DB::table('patient_relation')->insert($data_pt);
			if ($res3)
			{
				$no_lab = $req->input('no_lab');
				$pui_id = $req->input('pui_id');
				$dms_pcr_contact = $req->input('dms_pcr_contact');
				$dms_time_contact = $req->input('dms_time_contact');
				$dms_date_contact =$req->input('dms_date_contact');
				$dms_specimen_contact =$req->input('dms_specimen_contact');
				$chkspec_other_contact =$req->input('chkspec_other_contact');
				$other_pcr_result_contact =$req->input('other_pcr_result_contact');
				$date_entry=date('Y-m-d') ;
				$x=0;
					for ($i=0; $i < count($dms_time_contact); $i++) {
						$data_hsc[]  = [
								'contact_id'=>$contact_id,
								'pui_id'=>$pui_id,
								'no_lab'=>$no_lab[$i],
									'dms_pcr_contact'=>$dms_pcr_contact[$i],
									'dms_time_contact'=>$dms_time_contact[$i],
									'dms_date_contact'=>$dms_date_contact[$i],
									'dms_specimen_contact'=>$dms_specimen_contact[$i],
									'chkspec_other_contact'=>$chkspec_other_contact[$i],
									'other_pcr_result_contact'=>$other_pcr_result_contact[$i],
									'date_entry' => $date_entry
												];
					$x++;
										}
										 // dd($data_hsc);
					$res4	= DB::table('tbl_contact_hsc')->insert($data_hsc);
				return redirect()->route('contacttable',[$pui_id])->with('alert', 'เพิ่มข้อมูลสำเร็จ');
			} else {
				return redirect()->route('contacttable',[$pui_id])->with('alert', 'นำเข้าข้อมูลไม่สำเร็จ');
			}
	}
}
}

public function contactstupdate(Request $request) {
	$id = $request ->input ('id');
	$pui_id = $request ->input ('pui_id');
	$contact_id = $request ->input ('contact_id');
	$status_followup = $request ->input ('status_followup');
  $pt_status = $request ->input ('pt_status');
  $date_change_st = $this->convertDateToMySQL($request ->input ('date_change_st'));
	// $date_change_st =date('Y-m-d');
	$res1=DB::table('tbl_contact')
			->where('id',$id)
			->where('contact_id',$contact_id)
	    ->update(
	        ['pt_status' => $pt_status,
					 'status_followup' => $status_followup,
					 'date_change_st' => $date_change_st
				 ]
	    );
	if ($res1) {
		return redirect()->route('contacttable',[$pui_id]);
		exit;
	}
}

public function fustupdate(Request $request) {
	$id = $request ->input ('id');
	$pui_id = $request ->input ('pui_id');
	$contact_id = $request ->input ('contact_id');
	$status_followup = $request ->input ('status_followup');
  $pt_status = $request ->input ('pt_status');
  $date_change_st = $this->convertDateToMySQL($request ->input ('date_change_st'));
	// $date_change_st =date('Y-m-d');
	$res1=DB::table('tbl_contact')
			->where('id',$id)
			->where('contact_id',$contact_id)
	    ->update(
	        ['pt_status' => $pt_status,
					 'status_followup' => $status_followup,
					 'date_change_st' => $date_change_st
				 ]
	    );
	if ($res1) {
		return redirect()->route('contacttable',[$pui_id]);
		exit;
	}
}

public function followupinsert(Request $req)
{

// $poe_id = $req ->input ('poe_id');
$sat_id = $req ->input ('sat_id');
$pui_id = $req ->input ('pui_id');
$patianid = $req ->input ('patianid');
$typid = $req ->input ('typid');
$contact_id = $req ->input ('contact_id');
$followup_times= $req ->input ('followup_times');
$date_no = $this->convertDateToMySQL($req ->input ('date_no'));
$clinical = $req ->input ('clinical');
$fever = $req ->input ('fever');
$cough = $req ->input ('cough');
$sore_throat = $req ->input ('sore_throat');
$mucous = $req ->input ('mucous');
$sputum = $req ->input ('sputum');
$breath_labored = $req ->input ('breath_labored');
$suffocate = $req ->input ('suffocate');
$muscle_aches = $req ->input ('muscle_aches');
$headache = $req ->input ('headache');
$diarrhea = $req ->input ('diarrhea');
$other_symtom = $req ->input ('other_symtom');
$status_followup = $req ->input ('status_followup');
$available_contact = $req ->input ('available_contact');
$follow_results = $req ->input ('follow_results');
$user_id = $req ->input ('user_id');
$province_follow_contact = $req ->input ('province_follow_contact');
$followup_address = $req ->input ('followup_address');
$division_follow_contact = $req ->input ('division_follow_contact');
$division_follow_contact_other = $req ->input ('division_follow_contact_other');
$sat_id_class = $req ->input ('sat_id_class');
$disch_st = $req ->input ('disch_st');
$follow_address_other = $req ->input ('follow_address_other');
$date_entry = date('Y-m-d') ;
$data = array(
	// 'poe_id'=>$poe_id,
	'sat_id'=>$sat_id,
	'pui_id'=>$pui_id,
	'patianid'=>$patianid,
	'typid'=>$typid,
	'contact_id'=>$contact_id,
	'followup_times'=>$followup_times,
	'followup_address'=>$followup_address,
	'date_no'=>$date_no,
	'clinical'=>$clinical,
	'fever'=>$fever,
	'cough'=>$cough,
	'sore_throat'=>$sore_throat,
	'mucous'=>$mucous,
	'sputum'=>$sputum,
	'breath_labored'=>$breath_labored,
	'suffocate'=>$suffocate,
	'muscle_aches'=>$muscle_aches,
	'headache'=>$headache,
	'diarrhea'=>$diarrhea,
	'other_symtom'=>$other_symtom,
	'status_followup'=>$status_followup,
	'available_contact'=>$available_contact,
	'follow_results'=>$follow_results,
	'user_id'=>$user_id,
	'province_follow_contact'=>$province_follow_contact,
	'division_follow_contact'=>$division_follow_contact,
	'division_follow_contact_other'=>$division_follow_contact_other,
	'sat_id_class'=>$sat_id_class,
	'disch_st'=>$disch_st,
	'follow_address_other'=>$follow_address_other,
	'date_entry'=>$date_entry
);
    // dd($data);
$res1	= DB::table('tbl_followup')->insert($data);

if ($res1){
	if ($typid = 1) {
		return redirect()->route('followuptablespui',[$typid,$patianid])->with('alert', 'เพิ่มข้อมูลสำเร็จ');
	}
	if ($typid = 2) {
			return redirect()->route('followuptablescon',[$typid,$patianid])->with('alert', 'เพิ่มเข้าข้อมูลสำเร็จ');
	}
}
}


public function contactedit(Request $req){
	// dd($req->contact_id);
$delete1 = DB::table('tbl_contact')->where('contact_id','=', $req->contact_id)->delete();
// dd($delete1);
if ($delete1)
{
	$contact_id = $req ->input ('contact_id');
	$contact_id_temp = $req ->input ('contact_id_temp');
	if ($contact_id == $contact_id_temp) {
		$contact_id_temp = $req ->input ('contact_id_temp');
	}else {
		$contact_id_temp = "";
	}
	$sat_id = $req ->input ('sat_id');
 	$pui_id = $req ->input ('pui_id');
   // $contact_id = $poe_id.'_'.$contactid;	// dd($order);
 	$user_id = $req ->input ('user_id');
 	$title_contact = $req ->input ('title_contact');
   $name_contact = $req ->input ('name_contact');
   $mname_contact = $req ->input ('mname_contact');
   $lname_contact = $req ->input ('lname_contact');
   $sex_contact = $req ->input ('sex_contact');
   $age_contact = $req ->input ('age_contact');
 	 $passport_contact = $req ->input ('passport_contact');
   $national_contact = $req ->input ('national_contact');
   $province = $req ->input ('province');
   $district = $req ->input ('district');
   $sub_district = $req ->input ('sub_district');
   $address_contact = $req ->input ('address_contact');
   $phone_contact = $req ->input ('phone_contact');
   $patient_contact = $req ->input ('patient_contact');
   $risk_contact = $req ->input ('risk_contact');
   $datecontact = $this->convertDatefollowToMySQL($req ->input ('datecontact'));
   $datefollow = $this->convertDatefollowToMySQL($req ->input ('datefollow'));
 	 $date_followup = $this->convertDatefollowToMySQL($req ->input ('date_followup'));
   $type_contact = $req ->input ('type_contact');
   $date_entry = date('Y-m-d') ;
   $data = array(
     // 'poe_id'=>$poe_id,
 		'sat_id'=>$sat_id,
 		'pui_id'=>$pui_id,
     'contact_id'=>$contact_id,
 		'contact_id_temp'=>$contact_id_temp,
 		'title_contact'=>$title_contact,
     'name_contact'=>$name_contact,
     'mname_contact'=>$mname_contact,
     'lname_contact'=>$lname_contact,
     'sex_contact'=>$sex_contact,
     'age_contact'=>$age_contact,
 		'passport_contact'=>$passport_contact,
     'national_contact'=>$national_contact,
     'province'=>$province,
     'district'=>$district,
     'sub_district'=>$sub_district,
     'address_contact'=>$address_contact,
     'phone_contact'=>$phone_contact,
     'patient_contact'=>$patient_contact,
     'risk_contact'=>$risk_contact,
     'datecontact'=>$datecontact,
     'datefollow'=>$datefollow,
 		'date_followup'=>$date_followup,
     'type_contact'=>$type_contact,
 		'user_id'=>$user_id,
     'date_entry'=>$date_entry
   );
			// dd($data);
 $res1	= DB::table('tbl_contact')->insert($data);
  if ($res1){
		$delete2 = DB::table('tbl_followup')
								->where('contact_id','=', $req->contact_id)
								->where('followup_times','=', '0')
								->delete();
	}
 $last_res1_insert_id = DB::getPdo()->lastInsertId();
 // dd($last_res1_insert_id);
 if ($delete2)
 $sat_id = $req ->input ('sat_id');
 $pui_id = $req ->input ('pui_id');
 $patianid = $req ->input ('patianid');
 $typid = "2";
 $contact_id = $req ->input ('contact_id');
 $followup_times= "0";
 $date_no = date('Y-m-d') ;
 $clinical = $req ->input ('clinical');
 $fever = $req ->input ('fever');
 $cough = $req ->input ('cough');
 $sore_throat = $req ->input ('sore_throat');
 $mucous = $req ->input ('mucous');
 $sputum = $req ->input ('sputum');
 $breath_labored = $req ->input ('breath_labored');
 $suffocate = $req ->input ('suffocate');
 $muscle_aches = $req ->input ('muscle_aches');
 $headache = $req ->input ('headache');
 $diarrhea = $req ->input ('diarrhea');
 $other_symtom = $req ->input ('other_symtom');
 $status_followup = $req ->input ('status_followup');
 $available_contact = $req ->input ('available_contact');
 $follow_results = $req ->input ('follow_results');
 $user_id = $req ->input ('user_id');
 $followup_address = $req ->input ('followup_address');
 $sat_id_class = $req ->input ('sat_id_class');
 $province_follow_contact = $req ->input ('province_follow_contact');
 $division_follow_contact = $req ->input ('division_follow_contact');
 $division_follow_contact_other = $req ->input ('division_follow_contact_other');
 $datesymtom = $this->convertDatefollowToMySQL($req ->input ('datesymtom'));
 $date_entry = date('Y-m-d') ;
 $hospcode = $req ->input ('hospcode');
 $follow_address_other = $req ->input ('follow_address_other');
 $data = array(
	 // 'poe_id'=>$poe_id,
	 'sat_id'=>$sat_id,
	 'pui_id'=>$pui_id,
	 'contact_id'=>$contact_id,
	 'patianid'=>$contact_id,
	 'typid'=>$typid,
	 'followup_times'=>$followup_times,
	 'followup_address'=>$followup_address,
	 'date_no'=>$date_no,
	 'clinical'=>$clinical,
	 'fever'=>$fever,
	 'cough'=>$cough,
	 'sore_throat'=>$sore_throat,
	 'mucous'=>$mucous,
	 'sputum'=>$sputum,
	 'breath_labored'=>$breath_labored,
	 'suffocate'=>$suffocate,
	 'muscle_aches'=>$muscle_aches,
	 'headache'=>$headache,
	 'diarrhea'=>$diarrhea,
	 'other_symtom'=>$other_symtom,
	 'status_followup'=>$status_followup,
	 'available_contact'=>$available_contact,
	 'follow_results'=>$follow_results,
	 'user_id'=>$user_id,
	 'province_follow_contact'=>$province_follow_contact,
	 'division_follow_contact'=>$division_follow_contact,
	 'division_follow_contact_other'=>$division_follow_contact_other,
	 'sat_id_class'=>$sat_id_class,
	 'datesymtom'=>$datesymtom,
	 'date_entry'=>$date_entry,
			 'follow_address_other'=>$follow_address_other,
	 'hospcode'=>$hospcode
 );
 $res3	= DB::table('tbl_followup')->insert($data);
 if ($res3)
 {
	 $delete3= DB::table('tbl_contact_hsc')
							 ->where('contact_id','=', $req->contact_id)
							 ->delete();
 }
 {
	 $no_lab = $req->input('no_lab');
	 $pui_id = $req->input('pui_id');
	 $dms_pcr_contact = $req->input('dms_pcr_contact');
	 $dms_time_contact = $req->input('dms_time_contact');
	 $dms_date_contact =$req->input('dms_date_contact');
	 $dms_specimen_contact =$req->input('dms_specimen_contact');
	 $chkspec_other_contact =$req->input('chkspec_other_contact');
	 $other_pcr_result_contact =$req->input('other_pcr_result_contact');
	 $date_entry=date('Y-m-d') ;
	 $x=0;
		 for ($i=0; $i < count($dms_time_contact); $i++) {
			 $data_hsc[]  = [
					 'contact_id'=>$contact_id,
					 'pui_id'=>$pui_id,
					 'no_lab'=>$no_lab[$i],
						 'dms_pcr_contact'=>$dms_pcr_contact[$i],
						 'dms_time_contact'=>$dms_time_contact[$i],
						 'dms_date_contact'=>$dms_date_contact[$i],
						 'dms_specimen_contact'=>$dms_specimen_contact[$i],
						 'chkspec_other_contact'=>$chkspec_other_contact[$i],
						 'other_pcr_result_contact'=>$other_pcr_result_contact[$i],
						 'date_entry' => $date_entry
									 ];
		 $x++;
							 }
								// dd($data_hsc);
		 $res4	= DB::table('tbl_contact_hsc')->insert($data_hsc);
 if ($res4){

	 return redirect()->route('contacttable',[$pui_id])->with('alert', 'เพิ่มข้อมูลสำเร็จ');
	}else{
	 return redirect()->route('contacttable',[$pui_id])->with('alert', 'นำเข้าข้อมูลไม่สำเร็จ');
	 }
}
}
}

public function fetch(Request $request){
$id=$request->get('select');
$result=array();
$query=DB::table('ref_province')
->join('ref_district','ref_province.province_id','=','ref_district.province_id')
->select('ref_district.district_name','ref_district.district_id','ref_district.district_id')
->where('ref_province.province_id',$id)
->get();
$output='<option value="%">   อำเภอ   </option>';
	foreach ($query as $row) {
		$output.='<option value="'.$row->district_id.'">'.$row->district_name.'</option>';
	}
	echo $output;
}
public function fetchD(Request $request){
$idD = $request->select;
// dd($idD);
$resultD=array();
$queryD=DB::table('ref_sub_district')
->select('ref_sub_district.sub_district_name','ref_sub_district.sub_district_id','ref_sub_district.sub_district_id')
->where(DB::raw('left(ref_sub_district.sub_district_id, 4)'),'=',$idD)
->get();

$outputD='<option value="%">   ตำบล   </option>';
foreach ($queryD as $rowD) {
	$outputD.='<option value="'.$rowD->sub_district_id.'">'.$rowD->sub_district_name.'</option>';
}
echo $outputD;

}
  public function province(){
    $listprovince=DB::table('ref_province')
    ->orderBy('province_name', 'ASC')
    ->get();
     // return view('AEFI.Apps.form1')->with('list',$list);
     return $listprovince;
  }
	protected function arr_province(){
		$arr_province = DB::table('ref_province')->select('province_id','province_name')->get();
		foreach ($arr_province as  $value) {
			$arr_province[$value->province_id] =trim($value->province_name);
		}
		// dd($province_arr);
		return $arr_province;
	}
	protected function arrdistrict(){
		$arrdistrict = DB::table('ref_district')->select('district_id','district_name')->get();
		foreach ($arrdistrict as  $value) {
			$arrdistrict[$value->district_id] =trim($value->district_name);
		}
		// dd($province_arr);
		return $arrdistrict;
	}
	protected function arr_sub_district(){
		$arr_sub_district = DB::table('ref_sub_district')->select('sub_district_id','sub_district_name')->get();
		foreach ($arr_sub_district as  $value) {
			$arr_sub_district[$value->sub_district_id] =trim($value->sub_district_name);
		}
		// dd($province_arr);
		return $arr_sub_district;
	}
	protected function arr_hos(){
		$arr_hos = DB::table('chospital_new')->select('hospcode','hosp_name')->get();
		foreach ($arr_hos as  $value) {
			$arr_hos[$value->hospcode] =trim($value->hosp_name);
		}
		// dd($province_arr);
		return $arr_hos;
	}
	protected function arr_pts(){
		$arr_pts = DB::table('ref_pt_status')->select('pts_id','pts_name_en')->get();
		foreach ($arr_pts as  $value) {
			$arr_pts[$value->pts_id] =trim($value->pts_name_en);
		}
		// dd($province_arr);
		return $arr_pts;
	}
	protected function arr_laboratory(){
		$arr_laboratory = DB::table('laboratory')->select('id','th_name')->get();
		foreach ($arr_laboratory as  $value) {
			$arr_laboratory[$value->id] =trim($value->th_name);
		}
		 // dd($arr_laboratory);
		return $arr_laboratory;
	}

	// public function ref_title_name(){
	// 	$ref_title_name=DB::table('ref_title_name')
	// 	->orderBy('id', 'ASC')
	// 	->get();
	// 	 // return view('AEFI.Apps.form1')->with('list',$list);
	// 	 return $ref_title_name;
	// }
	protected function arrnation(){
		$arrnation = DB::table('ref_global_country')->select('country_id','country_name')->get();
		foreach ($arrnation as  $value) {
			$arrnation[$value->country_id] =trim($value->country_name);
		}
		// dd($province_arr);
		return $arrnation;
	}
	protected function arroccu(){
		$arroccu = DB::table('ref_occupation')->select('id','occu_name_th')->get();
		foreach ($arroccu as  $value) {
			$arroccu[$value->id] =trim($value->occu_name_th);
		}
		// dd($province_arr);
		return $arroccu;
	}

	protected function arrsymptoms(){
		$arrsymptoms = DB::table('ref_symptoms')->select('id','symptom_name_en')->get();
		foreach ($arrsymptoms as  $value) {
			$arrsymptoms[$value->id] =trim($value->symptom_name_en);
		}
		// dd($province_arr);
		return $arrsymptoms;
	}
	protected function arrprov(){
		$arrprov = DB::table('ref_province')->select('province_id','province_name')->get();
		foreach ($arrprov as  $value) {
			$arrprov[$value->province_id] =trim($value->province_name);
		}
		// dd($province_arr);
		return $arrprov;
	}

	protected function arrspecimen(){
		$arrspecimen = DB::table('ref_specimen')->select('id','name_en')->get();
		foreach ($arrspecimen as  $value) {
			$arrspecimen[$value->id] =trim($value->name_en);
		}
		// dd($province_arr);
		return $arrspecimen;
	}
	// protected function arrtitlename(){
	// 	$arrtitlename = DB::table('ref_title_name')->select('id','title_name')->get();
	// 	foreach ($arrtitlename as  $value) {
	// 		$arrtitlename[$value->id] =trim($arrtitlename->title_name);
	// 	}
	// 	// dd($province_arr);
	// 	return $arrtitlename;
	// }
	protected function arrfollowup_address(){
		$arrfollowup_address = DB::table('ref_specimen')->select('id','name_en')->get();
		foreach ($arrfollowup_address as  $value) {
			$arrfollowup_address[$value->id] =trim($value->name_en);
		}
		// dd($province_arr);
		return $arrspecimen;
	}
	protected function arr_division_follow_contact(){
		$arr_division_follow_contact = array(
			'99'=>'ส่วนกลาง',
			'13'=>'สปคม.',
			'1'=>'สคร.1',
			'2'=>'สคร.2',
			'3'=>'สคร.3',
			'4'=>'สคร.4',
			'5'=>'สคร.5',
			'6'=>'สคร.6',
			'7'=>'สคร.7',
			'8'=>'สคร.8',
			'9'=>'สคร.9',
			'10'=>'สคร.10',
			'11'=>'สคร.11',
			'12'=>'สคร.12',
			'999'=>'อื่นๆ',
			''=>''
			);
		// dd($list_sym_cough);
		return $arr_division_follow_contact;
	}
	protected function arr_risk_contact(){
		$arr_risk_contact = array(
			'1'=>'เสี่ยงสูง',
			'2'=>'เสี่ยงต่ำ',
			'0'=>'',
			''=>''
			);
		// dd($list_sym_cough);
		return $arr_risk_contact;
	}
	protected function arr_followup_address(){
		$arr_followup_address = array(
			'1'=>'บ้าน',
			'2'=>'โรงแรม',
			'3'=>'โรงพยาบาล',
			'4'=>'สถานที่กักกัน' ,
			'5'=>'อื่นๆ'
			);
		// dd($list_sym_cough);
		return $arr_followup_address;
	}
	protected function arr_dms_pcr_contact(){
		$arr_dms_pcr_contact = array(
			'1'=>'กรมวิทย์ฯ',
			'2'=>'สถาบันบำราศฯ',
			'3'=>'จุฬาลงกรณ์',
			'4'=>'PCR for Mers ที่อื่นๆ' ,
			''=>'ยังไม่มีการระบุข้อมูล'
			);
		// dd($list_sym_cough);
		return $arr_dms_pcr_contact;
	}
	protected function arr_other_pcr_result_contact(){
		$arr_other_pcr_result_contact = array(
			'1'=>'รอผล',
			'2'=>'Negative',
			'3'=>'Positive',
			''=>'ยังไม่มีการระบุข้อมูล'
			);
		// dd($list_sym_cough);
		return $arr_other_pcr_result_contact;
	}
	protected function arr_type_contact(){
		$arr_type_contact = array(
			'1'=>'บุคลากรทางการแพทย์',
			'2'=>'ผู้สัมผัสร่วมบ้าน',
			'3'=>'ผู้ร่วมเดินทาง',
			'4'=>'พนักงานโรงแรม',
			'5'=>'คนขับแท๊กซี่/ยานพาหนะ',
			'6'=>'พนักงานสนามบิน',
			'8'=>'บุคคลร่วมที่ทำงาน',
			'9'=>'บุคคลร่วมโรงเรียน',
			'10'=>'ผู้ป่วยในโรงพยาบาล',
			'7'=>'อื่นๆ',
			''=>''
			);
		// dd($list_sym_cough);
		return $arr_type_contact;
	}
	protected function arr_status_followup(){
		$arr_status_followup = array(
			'1'=>'จบการติดตาม',
			'2'=>'ยังต้องติดตาม',
			''=>''
			);
		// dd($list_sym_cough);
		return $arr_status_followup;
	}
	protected function arr_available_contact(){
		$arr_available_contact= array(
			'1'=>'ติดตามได้',
			'2'=>'ติดตามไม่ได้',
			''=>''
			);
		// dd($list_sym_cough);
		return $arr_available_contact;
	}
	protected function arr_follow_results(){
		$arr_follow_results= array(
			'1'=>'ไม่มี',
			'2'=>'เล็กน้อย',
			'3'=>'หนัก',
			'4'=>'วิกฤต',
			''=>''
			);
		// dd($list_sym_cough);
		return $arr_follow_results;
	}
	protected function arr_disch_st(){
		$arr_disch_st= array(
			'1'=>'ไม่มี',
			'2'=>'เล็กน้อย',
			'3'=>'หนัก',
			'4'=>'วิกฤต',
			''=>''
			);
		// dd($list_sym_cough);
		return $arr_disch_st;
	}
	protected function arrtitlename(){
			$arrtitlename = DB::table('ref_title_name')->select('id','title_name')->get();
			foreach ($arrtitlename as  $value) {
				$arrtitlename[$value->id] = trim($value->title_name);
			}
			 // dd($disease_arr_eventbase);
			return $arrtitlename;
		}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
		protected function convertDateToMySQL($date='00/00/0000') {
			if (!is_null($date) || !empty($date)) {
				$ep = explode("/", $date);
				$string = $ep[2]."-".$ep[1]."-".$ep[0];
			} else {
				$string = NULL;
			}
			return $string;
		}
		protected function convertDatefollowToMySQL($date='00/00/0000') {
			if (!is_null($date) || !empty($date)) {
				$ep = explode("/", $date);
				$string = $ep[2]."-".$ep[0]."-".$ep[1];
			} else {
				$string = NULL;
			}
			return $string;
		}
		protected function convertDatearrayToMySQL($date='00/00/0000') {
			if (!is_null($date) || !empty($date)) {
				$ep = explode("/", $date);
				$string = $ep[2]."-".$ep[1]."-".$ep[0];
			} else {
				$string = NULL;
			}
			return $string;
		}
		public static function Convert_Date_To_Picker($strDate){
      if(empty($strDate)) return "";
      $strDate_arr = explode("-",$strDate);
      $year = $strDate_arr['0'];
      $month = $strDate_arr['1'];
      $day = $strDate_arr['2'];
      // $strFullThaiDate = $day.'/'.$month.'/'.$year;
      $strFullThaiDate = $day.'/'.$month.'/'.$year;
      return $strFullThaiDate;
    }
		public static function Convert_Date_To_Picker_range($strDate){
      if(empty($strDate)) return "";
      $strDate_arr = explode("-",$strDate);
      $year = $strDate_arr['0'];
      $month = $strDate_arr['1'];
      $day = $strDate_arr['2'];
      // $strFullThaiDate = $day.'/'.$month.'/'.$year;
      $strFullThaiDate = $month.'/'.$day.'/'.$year;
      return $strFullThaiDate;
    }
		public function fetchos(Request $request){
		$id=$request->get('select');
		$result=array();
		$query=DB::table('ref_province')
		->join('chospital_new','ref_province.province_id','=','chospital_new.prov_code')
		->select('chospital_new.hospcode','chospital_new.hosp_name','chospital_new.prov_code')
		->where('ref_province.province_id',$id)
		->where('chospital_new.status_code','=',1)
		->get();
		$output='<option value="%">   โรงพยาบาล   </option>';
			foreach ($query as $row) {
				$output.='<option value="'.$row->hospcode.'">'.$row->hosp_name.'</option>';
			}
			echo $output;
		}

}
