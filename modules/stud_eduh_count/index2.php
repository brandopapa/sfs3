<?php

// $Id: index2.php 7711 2013-10-23 13:07:37Z smallduh $

include "config.php";
require "../../include/sfs_oo_zip2.php";
include_once "../../include/sfs_case_dataarray.php";
//�{���ˬd
sfs_check();

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

//�Z�Ű}�C
$class_arr = class_base();
$postBtn = "�T�w";
$postBtn_xls_online = "�u�W���";

if ($_REQUEST['do_key'] <> $postBtn)
	head("94���ɸ�ƪ�");
//����iconv �ഫ�}�C
$no_iconv_arr = array();

$ttt = new EasyZip;
$ttt->setPath('ooo2');

if (count ($sel_stud) >0 )
switch($do_key) {
	case $postBtn:
	$break ="<text:p text:style-name=\"P14\"/>";
	$doc_head = $ttt->read_file (dirname(__FILE__)."/ooo2/con_head");
	$doc_foot = $ttt->read_file(dirname(__FILE__)."/ooo2/con_foot");
	$doc_main = $ttt->read_file(dirname(__FILE__)."/ooo2/con_main");
	$doc_brother_sister = $ttt->read_file(dirname(__FILE__)."/ooo2/brother_sister");
	$doc_sss_data = $ttt->read_file (dirname(__FILE__)."/ooo2/sss_data");
	$doc_sse_list_memo = $ttt->read_file (dirname(__FILE__)."/ooo2/sse_list_memo");
	$doc_sse_list_spe = $ttt->read_file (dirname(__FILE__)."/ooo2/sse_list_spe");


	$ttt->adddir("META-INF");
	$ttt->addfile("settings.xml");
	$ttt->addfile("styles.xml");
	$ttt->addfile("meta.xml");

	//�嫬
	$blood_arr = blood();
	//�X�ͦa
	$birth_state_arr = birth_state();
	//�ʧO
	$sex_arr = array("1"=>"�k","2"=>"�k");
	//�s�\
	$is_live_arr = is_live();
	//�P���@�H���Y
	$guardian_relation_arr = guardian_relation();
	//�Ǿ�
	$edu_kind_arr  = edu_kind();
	//�ǥͨ����O
	$stud_kind_arr = stud_kind();
	//�P���@�H���Y
	$guardian_relation_arr = guardian_relation();
	//�ٿ�
	$bs_calling_kind_arr = bs_calling_kind();
	//�������Y
	$sse_relation_arr = sfs_text("�������Y");
	while(list($id,$val)= each($sse_relation_arr))
		$sse_relation_str .= "$id-$val,";
	//�a�x����
	$sse_family_kind_arr = sfs_text("�a�x����");
	while(list($id,$val)= each($sse_family_kind_arr))
		$sse_family_kind_str .= "$id-$val,";
	//�a�x��^
	$sse_family_air_arr = sfs_text("�a�x��^");
	while(list($id,$val)= each($sse_family_air_arr))
		$sse_family_air_str .= "$id-$val,";
	//�ޱФ覡
	$sse_farther_arr = sfs_text("�ޱФ覡");
	while(list($id,$val)= each($sse_farther_arr))
		$sse_farther_str .= "$id-$val,";

	//�~����
	$sse_live_state_arr = sfs_text("�~����");
	while(list($id,$val)= each($sse_live_state_arr))
		$sse_live_state_str .= "$id-$val,";
	//�g�٪��p
	$sse_rich_state_arr = sfs_text("�g�٪��p");
	while(list($id,$val)= each($sse_rich_state_arr))
		$sse_rich_state_str .= "$id-$val,";

	$sse_arr= array("1"=>"�߷R�x�����","2"=>"�߷R�x�����","3"=>"�S��~��","4"=>"����","5"=>"�ͬ��ߺD","6"=>"�H�����Y","7"=>"�~�V�欰","8"=>"���V�欰","9"=>"�ǲߦ欰","10"=>"���}�ߺD","11"=>"�J�{�欰");

	while(list($id,$val)= each($sse_arr)){
		$temp_sse_arr = sfs_text("$val");
		${"sse_arr_$id"} = $temp_sse_arr;
		$temp_str ='';
		while(list($idd,$vall)= each($temp_sse_arr))
			$temp_str .= "$idd-$vall,";
		${"sse_str_$id"} = $temp_str;
	}

	//�C�L�ɶ�
	$print_time = $now;


	$temp_arr["sch_cname"]= $sch_cname;

	$sql_select = "select a.*,b.fath_name,b.fath_birthyear,b.fath_alive,b.fath_education,b.fath_occupation,b.fath_unit,b.fath_phone,b.fath_work_name,b.fath_hand_phone,b.moth_name,b.moth_birthyear,moth_work_name,b.moth_alive,b.moth_education,b.moth_occupation,b.moth_unit,b.moth_phone,b.moth_hand_phone,b.guardian_name,b.guardian_relation,b.guardian_unit,b.guardian_hand_phone,b.guardian_phone,b.guardian_address,b.grandfath_name,b.grandfath_alive,b.grandmoth_name,b.grandmoth_alive  from stud_base a left join stud_domicile b on a.student_sn=b.student_sn ";
	for ($ss=0;$ss < count ($sel_stud);$ss++)
		$temp_sel .= "'".$sel_stud[$ss]."',";
	$sql_select .= "where a.stud_id in (".substr($temp_sel,0,-1).") ";

	$sql_select .= " order by a.curr_class_num ";
	$recordSet = $CONN->Execute($sql_select)or die ($sql_select);
	$i =0;
	$data = '';

	while (!$recordSet->EOF) {
		$stud_id = $recordSet->fields["stud_id"];
		$student_sn = $recordSet->fields["student_sn"];
		$stud_name = $recordSet->fields["stud_name"];
		$stud_sex = $recordSet->fields["stud_sex"];
		$stud_birthday = $recordSet->fields["stud_birthday"];
		$stud_blood_type = $recordSet->fields["stud_blood_type"];
		$stud_birth_place = $recordSet->fields["stud_birth_place"];
		$stud_kind = $recordSet->fields["stud_kind"];
		$stud_country = $recordSet->fields["stud_country"];
		$stud_country_kind = $recordSet->fields["stud_country_kind"];
		$stud_person_id = $recordSet->fields["stud_person_id"];
		$stud_country_name = $recordSet->fields["stud_country_name"];
		$stud_addr_1= $recordSet->fields["stud_addr_1"];
		$stud_addr_2 = $recordSet->fields["stud_addr_2"];
		$stud_tel_1 = $recordSet->fields["stud_tel_1"];
		$stud_tel_2 = $recordSet->fields["stud_tel_2"];
		$stud_tel_3 = $recordSet->fields["stud_tel_3"];
		$stud_mail = $recordSet->fields["stud_mail"];
		$stud_class_kind = $recordSet->fields["stud_class_kind"];
		$stud_spe_kind = $recordSet->fields["stud_spe_kind"];
		$stud_spe_class_kind = $recordSet->fields["stud_spe_class_kind"];
		$stud_spe_class_id = $recordSet->fields["stud_spe_class_id"];
		$stud_preschool_status = $recordSet->fields["stud_preschool_status"];
		$stud_preschool_id = $recordSet->fields["stud_preschool_id"];
		$stud_preschool_name = $recordSet->fields["stud_preschool_name"];
		$stud_mschool_status = $recordSet->fields["stud_mschool_status"];
		$stud_mschool_id = $recordSet->fields["stud_mschool_id"];
		$stud_mschool_name = $recordSet->fields["stud_mschool_name"];
		$stud_study_year = $recordSet->fields["stud_study_year"];
		$curr_class_num = $recordSet->fields["curr_class_num"];
		$fath_name = $recordSet->fields["fath_name"];
		$fath_birthyear = $recordSet->fields["fath_birthyear"];
		$fath_alive = $recordSet->fields["fath_alive"];
		$fath_education = $recordSet->fields["fath_education"];
		$fath_occupation = $recordSet->fields["fath_occupation"];
		$fath_work_name = $recordSet->fields["fath_work_name"];
		$fath_unit = $recordSet->fields["fath_unit"];
		$fath_phone = $recordSet->fields["fath_phone"];
		$fath_hand_phone = $recordSet->fields["fath_hand_phone"];
		$moth_name = $recordSet->fields["moth_name"];
		$moth_birthyear = $recordSet->fields["moth_birthyear"];
		$moth_alive = $recordSet->fields["moth_alive"];
		$moth_relation = $recordSet->fields["moth_relation"];
		$moth_education = $recordSet->fields["moth_education"];
		$moth_occupation = $recordSet->fields["moth_occupation"];
		$moth_work_name = $recordSet->fields["moth_work_name"];
		$moth_unit = $recordSet->fields["moth_unit"];
		$moth_work_name = $recordSet->fields["moth_work_name"];
		$moth_phone = $recordSet->fields["moth_phone"];
		$moth_hand_phone = $recordSet->fields["moth_hand_phone"];
		$guardian_name = $recordSet->fields["guardian_name"];
		$guardian_phone = $recordSet->fields["guardian_phone"];
		$guardian_relation = $recordSet->fields["guardian_relation"];
		$guardian_unit = $recordSet->fields["guardian_unit"];
		$guardian_work_name = $recordSet->fields["guardian_work_name"];
		$guardian_hand_phone = $recordSet->fields["guardian_hand_phone"];
		$guardian_guardian_address = $recordSet->fields["guardian_address"];
		$grandfath_name = $recordSet->fields["grandfath_name"];
		$grandfath_alive = $recordSet->fields["grandfath_alive"];
		$grandmoth_name = $recordSet->fields["grandmoth_name"];
		$grandmoth_alive = $recordSet->fields["grandmoth_alive"];

		//�ǥͨ����O
		$stud_kind_temp='';
		$stud_kind_temp_arr = explode(",",$stud_kind);
		for ($iii=0;$iii<count($stud_kind_temp_arr);$iii++) {
			if ($stud_kind_temp_arr[$iii]<>'')
				$stud_kind_temp .= $stud_kind_arr[$stud_kind_temp_arr[$iii]].",";
		}

		$temp_arr["stud_kind"]= substr($stud_kind_temp,0,-1);


		//�ǥͰ򥻸��
		$bir_temp_arr = explode("-",DtoCh($stud_birthday));
		$temp_arr["stud_birthday"]=sprintf("����%d�~%d��%d��",$bir_temp_arr[0],$bir_temp_arr[1],$bir_temp_arr[2]);
		$temp_arr["stud_blood_type"]=$blood_arr[$stud_blood_type];
		$temp_arr["stud_sex"]=$sex_arr[$stud_sex];
		$temp_arr["stud_name"]=$stud_name;
		$temp_arr["stud_id"]=$stud_id;
		$temp_arr["study_begin_date"]=$study_begin_date;
		$temp_arr["stud_person_id"]=$stud_person_id;
		$temp_arr["stud_birth_place"]=$birth_state_arr[sprintf("%02d",$stud_birth_place)];
		$temp_arr["curr_year"]= Num2CNum(substr($curr_class_num,0,1));
		$temp_arr["curr_class"] = $class_name[substr($curr_class_num,1,2)];
		$temp_arr["curr_num"] = intval(substr($curr_class_num,-2))."��";
		$temp_arr["sch_cname"] = $SCHOOL_BASE[sch_cname];
		$temp_arr["stud_addr_1"] = $stud_addr_1;
		$temp_arr["stud_addr_2"] = $stud_addr_2;
		$temp_arr["stud_tel_1"] = $stud_tel_1;
		$temp_arr["stud_tel_2"] = $stud_tel_2;

		//���t���
		$temp_arr[stud_parent] = "��: $fath_name($is_live_arr[$fath_alive])($fath_birthyear ��), ��:$moth_name($is_live_arr[$moth_alive])($moth_birthyear ��), ����:$grandfath_name($is_live_arr[$grandfath_alive]), ����:$grandmoth_name($is_live_arr[$grandmoth_alive])";

		//�����Ш|�{��
		$temp_arr[stud_parent_edu]= "�� :$edu_kind_arr[$moth_education] ,��: $edu_kind_arr[$moth_education]";

		//���@�H
		$temp_arr["aaaa"]= $guardian_name;
		$temp_arr["bbbb"]= $guardian_relation_arr[$guardian_relation];
		$temp_arr["cccc"]= $guardian_address;
		$temp_arr["dddd"]= "$guardian_phone $guardian_hand_phone";

		//�a��
		$temp_arr[f_1]=$fath_name;
		$temp_arr[f_2]=$fath_occupation;
		$temp_arr[f_3]=$fath_work_name;
		$temp_arr[f_4]=$fath_unit;
		$temp_arr[f_5]=$fath_phone;
		$temp_arr[m_1]=$moth_name;
		$temp_arr[m_2]=$moth_occupation;
		$temp_arr[m_3]=$moth_work_name;
		$temp_arr[m_4]=$moth_unit;
		$temp_arr[m_5]=$moth_phone;

		$temp_arr[stud_study_year] = $stud_study_year;
		//�S�̩j�f
		$query = "select * from stud_brother_sister where student_sn='$student_sn' order by bs_birthyear";
		$bs_res = $CONN->Execute($query);

		$bs_data = '';
		$bs_arr = array();
		if($bs_res->EOF) {
			$bs_arr[b_1] = "-";
			$bs_arr[b_2] = "-";
			$bs_arr[b_3] = "-";
			$bs_arr[b_4] = "-";
			$bs_data .= change_temp($bs_arr,array(),$doc_brother_sister);

		}
		else {
			while(!$bs_res->EOF){
				$bs_arr[b_1] = $bs_calling_kind_arr[$bs_res->fields[bs_calling]];
				$bs_arr[b_2] = $bs_res->fields[bs_name];
				$bs_arr[b_3] = $bs_res->fields[bs_gradu];
				$bs_arr[b_4] = $bs_res->fields[bs_birthyear];
				$bs_data .= change_temp($bs_arr,array(),$doc_brother_sister);
				$bs_res->MoveNext();
			}
		}
		$temp_arr[brother_sister] = $bs_data;

		//���o�ǥͻ��ɸ��
		$stud_seme_arr = array();
		$sql_select = "select seme_year_seme,stud_id,sse_relation,sse_family_kind,sse_family_air,sse_farther,sse_mother,sse_live_state,sse_rich_state,sse_s1,sse_s2,sse_s3,sse_s4,sse_s5,sse_s6,sse_s7,sse_s8,sse_s9,sse_s10,sse_s11 from stud_seme_eduh where stud_id='$stud_id' order by seme_year_seme";
		$res_seme = $CONN->Execute($sql_select);
		while(!$res_seme->EOF){
			$temp_seme = $res_seme->fields[seme_year_seme];
			$stud_seme_arr[$temp_seme][sse_relation] = $res_seme->fields[sse_relation];
			$stud_seme_arr[$temp_seme][sse_family_kind] = $res_seme->fields[sse_family_kind];
			$stud_seme_arr[$temp_seme][sse_family_air] = $res_seme->fields[sse_family_air];
			$stud_seme_arr[$temp_seme][sse_farther] = $res_seme->fields[sse_farther];
			$stud_seme_arr[$temp_seme][sse_mother] = $res_seme->fields[sse_mother];
			$stud_seme_arr[$temp_seme][sse_live_state] = $res_seme->fields[sse_live_state];
			$stud_seme_arr[$temp_seme][sse_rich_state] = $res_seme->fields[sse_rich_state];
			$stud_seme_arr[$temp_seme][sse_s1] = $res_seme->fields[sse_s1];
			$stud_seme_arr[$temp_seme][sse_s2] = $res_seme->fields[sse_s2];
			$stud_seme_arr[$temp_seme][sse_s3] = $res_seme->fields[sse_s3];
			$stud_seme_arr[$temp_seme][sse_s4] = $res_seme->fields[sse_s4];
			$stud_seme_arr[$temp_seme][sse_s5] = $res_seme->fields[sse_s5];
			$stud_seme_arr[$temp_seme][sse_s6] = $res_seme->fields[sse_s6];
			$stud_seme_arr[$temp_seme][sse_s7] = $res_seme->fields[sse_s7];
			$stud_seme_arr[$temp_seme][sse_s8] = $res_seme->fields[sse_s8];
			$stud_seme_arr[$temp_seme][sse_s9] = $res_seme->fields[sse_s9];
			$stud_seme_arr[$temp_seme][sse_s10] = $res_seme->fields[sse_s10];
			$stud_seme_arr[$temp_seme][sse_s11] = $res_seme->fields[sse_s11];
			$res_seme->MoveNext();
		}


		//�������Y
		$bs_data ='';
		$bs_arr = array();
		$sssss ='';
		$no_iconv_arr[sse_list]=1;
		$no_iconv_arr[sss_data] =1; //�����ഫ
		$no_iconv_arr[sse_memo_list] =1; //�����ഫ
		$no_iconv_arr[sse_list_spe] =1; //�����ഫ
		$no_iconv_arr[brother_sister] =1; //�����ഫ

		reset($stud_seme_arr);
		$sssss ='<text:p text:style-name="P8">';
		while(list($vid,$vval) = each($stud_seme_arr)){
			$this_year = (substr($vid,0,-1)-$stud_study_year)+1;
			$semester = substr($vid,-1);
			$seme_name = ($semester==1)?"�W":"�U";
			$seme_name = Num2CNum($this_year).$seme_name;
			$temp_ss = $seme_name.'(<text:span text:style-name="T6">'. $sse_relation_arr[$vval[sse_relation]]."</text:span>)";
			$sssss .= iconv("Big5","UTF-8//IGNORE",$temp_ss).", ";
		}
		$sssss .='</text:p>';

		$bs_arr[sse_kind] = "�������Y";
		$bs_arr[sse_detail] = $sse_relation_str;
		$bs_arr[sse_list] = $sssss;
		$bs_data = change_temp($bs_arr,$no_iconv_arr,$doc_sss_data);

		//=================================
		reset($stud_seme_arr);
		$sssss ='<text:p text:style-name="P8">';
		while(list($vid,$vval) = each($stud_seme_arr)){
			$this_year = (substr($vid,0,-1)-$stud_study_year)+1;
			$semester = substr($vid,-1);
			$seme_name = ($semester==1)?"�W":"�U";
			$seme_name = Num2CNum($this_year).$seme_name;
			$temp_ss = $seme_name.'(<text:span text:style-name="T6">'. $sse_family_kind_arr[$vval[sse_family_kind]]."</text:span>)";
			$sssss .= iconv("Big5","UTF-8//IGNORE",$temp_ss).", ";
		}
		$sssss .='</text:p>';

		$bs_arr[sse_kind] = "�a�x����";
		$bs_arr[sse_detail] = $sse_family_kind_str;
		$bs_arr[sse_list] = $sssss;
		$bs_data .= change_temp($bs_arr,$no_iconv_arr,$doc_sss_data);

		//=================================
		reset($stud_seme_arr);
		$sssss ='<text:p text:style-name="P8">';
		while(list($vid,$vval) = each($stud_seme_arr)){
			$this_year = (substr($vid,0,-1)-$stud_study_year)+1;
			$semester = substr($vid,-1);
			$seme_name = ($semester==1)?"�W":"�U";
			$seme_name = Num2CNum($this_year).$seme_name;
			$temp_ss = $seme_name.'(<text:span text:style-name="T6">'. $sse_family_air_arr[$vval[sse_family_kind]]."</text:span>)";
			$sssss .= iconv("Big5","UTF-8//IGNORE",$temp_ss).", ";
		}
		$sssss .='</text:p>';

		$bs_arr[sse_kind] = "�a�x��^";
		$bs_arr[sse_detail] = $sse_family_air_str;
		$bs_arr[sse_list] = $sssss;
		$bs_data .= change_temp($bs_arr,$no_iconv_arr,$doc_sss_data);

		//=================================
		reset($stud_seme_arr);
		$sssss ='<text:p text:style-name="P8">';
		while(list($vid,$vval) = each($stud_seme_arr)){
			$this_year = (substr($vid,0,-1)-$stud_study_year)+1;
			$semester = substr($vid,-1);
			$seme_name = ($semester==1)?"�W":"�U";
			$seme_name = Num2CNum($this_year).$seme_name;
			$temp_ss = $seme_name.'(<text:span text:style-name="T6">'. $sse_farther_arr[$vval[sse_farther]]."</text:span>)";
			$sssss .= iconv("Big5","UTF-8//IGNORE",$temp_ss).", ";
		}
		$sssss .='</text:p>';

		$bs_arr[sse_kind] = "���ޱФ覡";
		$bs_arr[sse_detail] = $sse_farther_str;
		$bs_arr[sse_list] = $sssss;
		$bs_data .= change_temp($bs_arr,$no_iconv_arr,$doc_sss_data);

		//=================================
		reset($stud_seme_arr);
		$sssss ='<text:p text:style-name="P8">';
		while(list($vid,$vval) = each($stud_seme_arr)){
			$this_year = (substr($vid,0,-1)-$stud_study_year)+1;
			$semester = substr($vid,-1);
			$seme_name = ($semester==1)?"�W":"�U";
			$seme_name = Num2CNum($this_year).$seme_name;
			$temp_ss = $seme_name.'(<text:span text:style-name="T6">'. $sse_farther_arr[$vval[sse_mother]]."</text:span>)";
			$sssss .= iconv("Big5","UTF-8//IGNORE",$temp_ss).", ";
		}
		$sssss .='</text:p>';

		$bs_arr[sse_kind] = "���ޱФ覡";
		$bs_arr[sse_detail] = $sse_farther_str;
		$bs_arr[sse_list] = $sssss;
		$bs_data .= change_temp($bs_arr,$no_iconv_arr,$doc_sss_data);

                //by misser �ק�1 (�R��) ,�]�M�W������
                //=================================
                /*
		reset($stud_seme_arr);
		$sssss ='<text:p text:style-name="P8">';
		while(list($vid,$vval) = each($stud_seme_arr)){
			$this_year = (substr($vid,0,-1)-$stud_study_year)+1;
			$semester = substr($vid,-1);
			$seme_name = ($semester==1)?"�W":"�U";
			$seme_name = Num2CNum($this_year).$seme_name;
			$temp_ss = $seme_name.'(<text:span text:style-name="T6">'. $sse_farther_arr[$vval[sse_mother]]."</text:span>)";
			$sssss .= iconv("Big5","UTF-8",$temp_ss).", ";
		}
		$sssss .='</text:p>';

		$bs_arr[sse_kind] = "���ޱФ覡";
		$bs_arr[sse_detail] = $sse_farther_str;
		$bs_arr[sse_list] = $sssss;
		$bs_data .= change_temp($bs_arr,$no_iconv_arr,$doc_sss_data);
                //by misser �ק�1 ����
                */

		//=================================
		reset($stud_seme_arr);
		$sssss ='<text:p text:style-name="P8">';
		while(list($vid,$vval) = each($stud_seme_arr)){
			$this_year = (substr($vid,0,-1)-$stud_study_year)+1;
			$semester = substr($vid,-1);
			$seme_name = ($semester==1)?"�W":"�U";
			$seme_name = Num2CNum($this_year).$seme_name;
			$temp_ss = $seme_name.'(<text:span text:style-name="T6">'. $sse_live_state_arr[$vval[sse_live_state]]."</text:span>)";
			$sssss .= iconv("Big5","UTF-8//IGNORE",$temp_ss).", ";
		}
		$sssss .='</text:p>';

		$bs_arr[sse_kind] = "�~����";
		$bs_arr[sse_detail] = $sse_live_state_str;
		$bs_arr[sse_list] = $sssss;
		$bs_data .= change_temp($bs_arr,$no_iconv_arr,$doc_sss_data);


		//=================================
		reset($stud_seme_arr);
		$sssss ='<text:p text:style-name="P8">';
		while(list($vid,$vval) = each($stud_seme_arr)){
			$this_year = (substr($vid,0,-1)-$stud_study_year)+1;
			$semester = substr($vid,-1);
			$seme_name = ($semester==1)?"�W":"�U";
			$seme_name = Num2CNum($this_year).$seme_name;
			$temp_ss = $seme_name.'(<text:span text:style-name="T6">'. $sse_rich_state_arr[$vval[sse_rich_state]]."</text:span>)";
			$sssss .= iconv("Big5","UTF-8//IGNORE",$temp_ss).", ";
		}
		$sssss .='</text:p>';

		$bs_arr[sse_kind] = "�g�٪��p";
		$bs_arr[sse_detail] = $sse_rich_state_str;
		$bs_arr[sse_list] = $sssss;
		$bs_data .= change_temp($bs_arr,$no_iconv_arr,$doc_sss_data);

		$temp_arr[sss_data] = $bs_data;

		//=================================
		$bs_data = '';
		for($si=1;$si<=11;$si++){

			reset($stud_seme_arr);
			$sssss ='<text:p text:style-name="P8">';
			while(list($vid,$vval) = each($stud_seme_arr)){
				$temp_sse_arr = ${"sse_arr_$si"};
				$temp_str = ${"sse_str_$si"};
				$temp_id  = "sse_s$si";
				$this_year = (substr($vid,0,-1)-$stud_study_year)+1;
				$semester = substr($vid,-1);
				$seme_name = ($semester==1)?"�W":"�U";
				$seme_name = Num2CNum($this_year).$seme_name;
				$tt_arr = explode(",",$vval[$temp_id]);
				$temp_ss='';
				foreach ($tt_arr as $VAL){
					if ($VAL<>'')
						$temp_ss .= $temp_sse_arr[$VAL].",";
				}
				if($temp_ss<>'')
					$temp_ss = substr($temp_ss,0,-1);
				$temp_ss = $seme_name.'(<text:span text:style-name="T6">'.$temp_ss.'</text:span>)';
				$sssss .= iconv("Big5","UTF-8//IGNORE",$temp_ss).", ";
			}
			$sssss .='</text:p>';
			if($si==1)
				$bs_arr[sse_kind] = "�̳߷R���";
			else if($si==2)
				$bs_arr[sse_kind] = "�̧x�����";
			else
				$bs_arr[sse_kind] = $sse_arr[$si];
			$bs_arr[sse_detail] = $temp_str;
			$bs_arr[sse_list] = $sssss;
			$bs_data .= change_temp($bs_arr,$no_iconv_arr,$doc_sss_data);
		}
                $temp_arr[sss_data] .= $bs_data; //by misser,�ק�2 ,�쥻�� .�A�y���W�����(�a�x���p��)�����

                //�H�U by misser,�ק�3(�s�W) ,���o�X�ʮu���� ,��L
                //=================================
                if ($IS_JHORES==6){//�ꤤ�A6�Ǵ�
                   $stud_seme_new_arr=array("$stud_study_year"."1","$stud_study_year"."2","$stud_study_year"+"1"."1","$stud_study_year"+"1"."2","$stud_study_year"+"2"."1","$stud_study_year"+"2"."2");
                }
                else{//���ӬO�p�ǡA�ҥH��12�Ǵ�
                   $stud_seme_new_arr=array("$stud_study_year"."1","$stud_study_year"."2","$stud_study_year"+"1"."1","$stud_study_year"+"1"."2","$stud_study_year"+"2"."1","$stud_study_year"+"2"."2","$stud_study_year"+"3"."1","$stud_study_year"+"3"."2","$stud_study_year"+"4"."1","$stud_study_year"+"4"."2","$stud_study_year"+"5"."1","$stud_study_year"+"5"."2");
                }
                $bs_data = '';
		//reset($stud_seme_arr); ����$stud_seme_arr�A�]���Y�Y�Ǵ��|���ػ��ɬ����A�h
		//$stud_seme_arr�N�|�֤F�Y�Ǵ�����ơA�]�N�L�k��X�ӾǴ������m�ҡC
		//�ҥH�� �W���� $stud_seme_new_arr �N���C
		//�H�U���g��P

                //���o���O
                $asb_arr=sfs_text("���m�����O");
        	while(list($id,$val)= each($asb_arr))
        		$asb_str .= "$id-$val,";

		//���oabsent��ƪ��X�ʮu����
		$sssss ='<text:p text:style-name="P8">';
		$temp_ss='';
                //�U��$vval��$vid ��m�M����O��ժ�
                while(list($vval,$vid) = each($stud_seme_new_arr)){//�̾Ǵ��O
                        $year=(substr($vid,0,1)=='0')?substr($vid,1,-1):substr($vid,0,-1);
                        $this_year = (substr($vid,0,-1)-$stud_study_year)+1;
			$semester = substr($vid,-1);
			$seme_name = ($semester==1)?"�W":"�U";
			$seme_name = Num2CNum($this_year).$seme_name;
			$temp_ss .= $seme_name.'(<text:span text:style-name="T6">';
			foreach ($asb_arr as $temp_kind){//�A�̰��O�M�䦸��
       		            $sql_select = "select * from stud_absent where stud_id='$stud_id' and absent_kind='$temp_kind' and year='$year' and semester='$semester' order by year,semester";
                            $record=$CONN->Execute($sql_select) or die($sql_select);
                            $num=$record->RecordCount();
                            if ($num>0){;//�p�G���A�h�Ǧ^���O����
                                $temp_ss.=$temp_kind.":".$num."�`�C ";
                            }
                        }
                        $temp_ss.='</text:span>)';

		}
		$sssss .= iconv("Big5","UTF-8//IGNORE",$temp_ss).", ";
		$sssss .='</text:p>';
		$bs_arr[sse_kind] = "���m�Ҭ���";
		$bs_arr[sse_detail] = $asb_str;
		$bs_arr[sse_list] = $sssss;
		$bs_data .= change_temp($bs_arr,$no_iconv_arr,$doc_sss_data);
                $temp_arr[sss_data] .= $bs_data;
                // by misser �ק�3(�s�W) ����

                //�H�U by misser,�ק�4(�s�W) ,���o���g���� ,��L
                //=================================
                if ($IS_JHORES==6){//���ꤤ�A��p���μ��g
  		   $bs_data = '';
		   reset($stud_seme_new_arr);
		   //���o���g���O ,���� reward �Ҳժ�config.php
            	$reward_arr=array("1"=>"�ż��@��","2"=>"�ż��G��","3"=>"�p�\�@��","4"=>"�p�\�G��","5"=>"�j�\�@��","6"=>"�j�\�G��","7"=>"�j�\�T��","-1"=>"ĵ�i�@��","-2"=>"ĵ�i�G��","-3"=>"�p�L�@��","-4"=>"�p�L�G��","-5"=>"�j�L�@��","-6"=>"�j�L�G��","-7"=>"�j�L�T��");
                   while(list($id,$val)= each($reward_arr))
        		$reward_str .= "$id-$val,";

		   //���oreward��ƪ����g����
		   $sssss ='<text:p text:style-name="P8">';
		   $temp_ss='';

		   while(list($vval,$vid) = each($stud_seme_new_arr)){
		        $year=(substr($vid,0,1)=='0')?substr($vid,1,-1):substr($vid,0,-1);
                        $this_year = (substr($vid,0,-1)-$stud_study_year)+1;
			$semester = substr($vid,-1);
			$seme_name = ($semester==1)?"�W":"�U";
			$seme_name = Num2CNum($this_year).$seme_name;
			$temp_ss .= $seme_name.'(<text:span text:style-name="T6">';

                        $sql_select = "select * from reward where stud_id='$stud_id' and reward_year_seme='$year$semester' order by reward_date";
                        $re_record=$CONN->Execute($sql_select) or die($sql_select);

                        while(!$re_record->EOF){
                                $temp_ss.= $reward_arr[$re_record->fields[reward_kind]];
                                $temp_ss.=":";
                                $temp.=$re_record->fields[reward_reason];
                                if ($re_record->fields[reward_cancel_date]!="" and $re_record->fields[reward_cancel_date]!="0000-00-00")
                                   $temp_ss.="**�w�P�L**";

                                $temp_ss.="�@,";
                                $re_record->MoveNext();
                        }

                        $temp_ss.="</text:span>)";
		   }
		   $sssss .= iconv("Big5","UTF-8//IGNORE",$temp_ss).", ";
		   $sssss .='</text:p>';
		   $bs_arr[sse_kind] = "���g����";
		   $bs_arr[sse_detail] = $reward_str;
		   $bs_arr[sse_list] = $sssss;
		   $bs_data .= change_temp($bs_arr,$no_iconv_arr,$doc_sss_data);
                   $temp_arr[sss_data] .= $bs_data;
		}
                   // by misser �ק�4(�s�W) ����


		$bs_data = '';
		//���ɳX�ͰO��
		$query = "select seme_year_seme,sst_date,sst_name,sst_main,sst_memo,teach_id from stud_seme_talk where stud_id='$stud_id' order by seme_year_seme";
		$res_talk = $CONN->Execute($query) or die($query);
		$memo_arr = array();
		while(!$res_talk->EOF){
			$memo_arr[w_2]= $res_talk->fields[sst_date];
			$memo_arr[w_3]= $res_talk->fields[sst_name];
			$memo_arr[w_4]= $res_talk->fields[sst_main].":".$res_talk->fields[sst_memo];
			$memo_arr[w_5]= get_teacher_name($res_talk->fields[teach_id]);
			$this_year = (substr($res_talk->fields[seme_year_seme],0,-1)-$stud_study_year)+1;
			$semester = substr($res_talk->fields[seme_year_seme],-1);
			$seme_name = ($semester==1)?"�W":"�U";
			$memo_arr[w_1] = Num2CNum($this_year).$seme_name;
			$bs_data .= change_temp($memo_arr,array(),$doc_sse_list_memo);
			$res_talk->MoveNext();
		}

		$temp_arr[sse_memo_list] = $bs_data;

		$bs_data = '';
		//�S���{�O��
		$query = "select seme_year_seme,sp_date,sp_memo,teach_id from stud_seme_spe where stud_id='$stud_id' order by seme_year_seme";
		$res_talk = $CONN->Execute($query) or die($query);
		$memo_arr = array();
		while(!$res_talk->EOF){
			$memo_arr[s_2]= $res_talk->fields[sp_date];
			$memo_arr[s_3]= $res_talk->fields[sp_memo];
			$memo_arr[s_4]= get_teacher_name($res_talk->fields[teach_id]);
			$this_year = (substr($res_talk->fields[seme_year_seme],0,-1)-$stud_study_year)+1;
			$semester = substr($res_talk->fields[seme_year_seme],-1);
			$seme_name = ($semester==1)?"�W":"�U";
			$memo_arr[s_1] = Num2CNum($this_year).$seme_name;
			$bs_data .= change_temp($memo_arr,array(),$doc_sse_list_spe);
			$res_talk->MoveNext();
		}


		$temp_arr[sse_list_spe] = $bs_data;

		//�J�ǾǮ� (�|���P�_�ꤤ�p)
		$temp_arr["stud_mschool_name"]="";
		//���~��� (�|���P�_)
		$temp_arr["stud_grade_date"]="";
		//�C�L�ɶ�
		$temp_arr["print_time"]="�C�L�ɶ�: $now";
		$temp_arr["test_1"]="misser����";
		//���N�򥻸��
		$data .= change_temp($temp_arr,$no_iconv_arr,$doc_main);

		$recordSet->MoveNext();
		//����
		if (!$recordSet->EOF)
			$data .= $break;
	}
	$sss = $doc_head.$data.$doc_foot;
	$ttt->add_file($sss,"content.xml");

	$sss = & $ttt->file();

	header("Content-disposition: attachment; filename=ooo2.sxw");
	header("Content-type: application/vnd.sun.xml.writer");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");

	echo $sss;

	exit;
	break;


	case $postBtn_xls_online:
	$break ="<text:p text:style-name=\"P14\"/>";
	$doc_head = $ttt->read_file (dirname(__FILE__)."/ooo2/con_head");
	$doc_foot = $ttt->read_file(dirname(__FILE__)."/ooo2/con_foot");
	$doc_main = $ttt->read_file(dirname(__FILE__)."/ooo2/con_main");
	$doc_brother_sister = $ttt->read_file(dirname(__FILE__)."/ooo2/brother_sister");
	$doc_sss_data = $ttt->read_file (dirname(__FILE__)."/ooo2/sss_data");
	$doc_sse_list_memo = $ttt->read_file (dirname(__FILE__)."/ooo2/sse_list_memo");
	$doc_sse_list_spe = $ttt->read_file (dirname(__FILE__)."/ooo2/sse_list_spe");


	//�嫬
	$blood_arr = blood();
	//�X�ͦa
	$birth_state_arr = birth_state();
	//�ʧO
	$sex_arr = array("1"=>"�k","2"=>"�k");
	//�s�\
	$is_live_arr = is_live();
	//�P���@�H���Y
	$guardian_relation_arr = guardian_relation();
	//�Ǿ�
	$edu_kind_arr  = edu_kind();
	//�ǥͨ����O
	$stud_kind_arr = stud_kind();
	//�P���@�H���Y
	$guardian_relation_arr = guardian_relation();
	//�ٿ�
	$bs_calling_kind_arr = bs_calling_kind();
	//�������Y
	$sse_relation_arr = sfs_text("�������Y");
	while(list($id,$val)= each($sse_relation_arr))
		$sse_relation_str .= "$id-$val,";
	//�a�x����
	$sse_family_kind_arr = sfs_text("�a�x����");
	while(list($id,$val)= each($sse_family_kind_arr))
		$sse_family_kind_str .= "$id-$val,";
	//�a�x��^
	$sse_family_air_arr = sfs_text("�a�x��^");
	while(list($id,$val)= each($sse_family_air_arr))
		$sse_family_air_str .= "$id-$val,";
	//�ޱФ覡
	$sse_farther_arr = sfs_text("�ޱФ覡");
	while(list($id,$val)= each($sse_farther_arr))
		$sse_farther_str .= "$id-$val,";

	//�~����
	$sse_live_state_arr = sfs_text("�~����");
	while(list($id,$val)= each($sse_live_state_arr))
		$sse_live_state_str .= "$id-$val,";
	//�g�٪��p
	$sse_rich_state_arr = sfs_text("�g�٪��p");
	while(list($id,$val)= each($sse_rich_state_arr))
		$sse_rich_state_str .= "$id-$val,";

	$sse_arr= array("1"=>"�߷R�x�����","2"=>"�߷R�x�����","3"=>"�S��~��","4"=>"����","5"=>"�ͬ��ߺD","6"=>"�H�����Y","7"=>"�~�V�欰","8"=>"���V�欰","9"=>"�ǲߦ欰","10"=>"���}�ߺD","11"=>"�J�{�欰");

	while(list($id,$val)= each($sse_arr)){
		$temp_sse_arr = sfs_text("$val");
		${"sse_arr_$id"} = $temp_sse_arr;
		$temp_str ='';
		while(list($idd,$vall)= each($temp_sse_arr))
			$temp_str .= "$idd-$vall,";
		${"sse_str_$id"} = $temp_str;
	}

	//�C�L�ɶ�
	$print_time = $now;


	$temp_arr["sch_cname"]= $sch_cname;

	$sql_select = "select a.*,b.fath_name,b.fath_birthyear,b.fath_alive,b.fath_education,b.fath_occupation,b.fath_unit,b.fath_phone,b.fath_work_name,b.fath_hand_phone,b.moth_name,b.moth_birthyear,moth_work_name,b.moth_alive,b.moth_education,b.moth_occupation,b.moth_unit,b.moth_phone,b.moth_hand_phone,b.guardian_name,b.guardian_relation,b.guardian_unit,b.guardian_hand_phone,b.guardian_phone,b.guardian_address,b.grandfath_name,b.grandfath_alive,b.grandmoth_name,b.grandmoth_alive  from stud_base a left join stud_domicile b on a.student_sn=b.student_sn ";
	for ($ss=0;$ss < count ($sel_stud);$ss++)
		$temp_sel .= "'".$sel_stud[$ss]."',";
	$sql_select .= "where a.stud_id in (".substr($temp_sel,0,-1).") ";

	$sql_select .= " order by a.curr_class_num ";
	$recordSet = $CONN->Execute($sql_select)or die ($sql_select);
	$i =0;
	$data = '';

	while (!$recordSet->EOF) {
		$stud_id = $recordSet->fields["stud_id"];
		$student_sn = $recordSet->fields["student_sn"];
		$stud_name = $recordSet->fields["stud_name"];
		$stud_sex = $recordSet->fields["stud_sex"];
		$stud_birthday = $recordSet->fields["stud_birthday"];
		$stud_blood_type = $recordSet->fields["stud_blood_type"];
		$stud_birth_place = $recordSet->fields["stud_birth_place"];
		$stud_kind = $recordSet->fields["stud_kind"];
		$stud_country = $recordSet->fields["stud_country"];
		$stud_country_kind = $recordSet->fields["stud_country_kind"];
		$stud_person_id = $recordSet->fields["stud_person_id"];
		$stud_country_name = $recordSet->fields["stud_country_name"];
		$stud_addr_1= $recordSet->fields["stud_addr_1"];
		$stud_addr_2 = $recordSet->fields["stud_addr_2"];
		$stud_tel_1 = $recordSet->fields["stud_tel_1"];
		$stud_tel_2 = $recordSet->fields["stud_tel_2"];
		$stud_tel_3 = $recordSet->fields["stud_tel_3"];
		$stud_mail = $recordSet->fields["stud_mail"];
		$stud_class_kind = $recordSet->fields["stud_class_kind"];
		$stud_spe_kind = $recordSet->fields["stud_spe_kind"];
		$stud_spe_class_kind = $recordSet->fields["stud_spe_class_kind"];
		$stud_spe_class_id = $recordSet->fields["stud_spe_class_id"];
		$stud_preschool_status = $recordSet->fields["stud_preschool_status"];
		$stud_preschool_id = $recordSet->fields["stud_preschool_id"];
		$stud_preschool_name = $recordSet->fields["stud_preschool_name"];
		$stud_mschool_status = $recordSet->fields["stud_mschool_status"];
		$stud_mschool_id = $recordSet->fields["stud_mschool_id"];
		$stud_mschool_name = $recordSet->fields["stud_mschool_name"];
		$stud_study_year = $recordSet->fields["stud_study_year"];
		$curr_class_num = $recordSet->fields["curr_class_num"];
		$fath_name = $recordSet->fields["fath_name"];
		$fath_birthyear = $recordSet->fields["fath_birthyear"];
		$fath_alive = $recordSet->fields["fath_alive"];
		$fath_education = $recordSet->fields["fath_education"];
		$fath_occupation = $recordSet->fields["fath_occupation"];
		$fath_work_name = $recordSet->fields["fath_work_name"];
		$fath_unit = $recordSet->fields["fath_unit"];
		$fath_phone = $recordSet->fields["fath_phone"];
		$fath_hand_phone = $recordSet->fields["fath_hand_phone"];
		$moth_name = $recordSet->fields["moth_name"];
		$moth_birthyear = $recordSet->fields["moth_birthyear"];
		$moth_alive = $recordSet->fields["moth_alive"];
		$moth_relation = $recordSet->fields["moth_relation"];
		$moth_education = $recordSet->fields["moth_education"];
		$moth_occupation = $recordSet->fields["moth_occupation"];
		$moth_work_name = $recordSet->fields["moth_work_name"];
		$moth_unit = $recordSet->fields["moth_unit"];
		$moth_work_name = $recordSet->fields["moth_work_name"];
		$moth_phone = $recordSet->fields["moth_phone"];
		$moth_hand_phone = $recordSet->fields["moth_hand_phone"];
		$guardian_name = $recordSet->fields["guardian_name"];
		$guardian_phone = $recordSet->fields["guardian_phone"];
		$guardian_relation = $recordSet->fields["guardian_relation"];
		$guardian_unit = $recordSet->fields["guardian_unit"];
		$guardian_work_name = $recordSet->fields["guardian_work_name"];
		$guardian_hand_phone = $recordSet->fields["guardian_hand_phone"];
		$guardian_guardian_address = $recordSet->fields["guardian_address"];
		$grandfath_name = $recordSet->fields["grandfath_name"];
		$grandfath_alive = $recordSet->fields["grandfath_alive"];
		$grandmoth_name = $recordSet->fields["grandmoth_name"];
		$grandmoth_alive = $recordSet->fields["grandmoth_alive"];

		//�ǥͨ����O
		$stud_kind_temp='';
		$stud_kind_temp_arr = explode(",",$stud_kind);
		for ($iii=0;$iii<count($stud_kind_temp_arr);$iii++) {
			if ($stud_kind_temp_arr[$iii]<>'')
				$stud_kind_temp .= $stud_kind_arr[$stud_kind_temp_arr[$iii]].",";
		}

		$temp_arr["stud_kind"]= substr($stud_kind_temp,0,-1);


		//�ǥͰ򥻸��
		$bir_temp_arr = explode("-",DtoCh($stud_birthday));
		$temp_arr["stud_birthday"]=sprintf("����%d�~%d��%d��",$bir_temp_arr[0],$bir_temp_arr[1],$bir_temp_arr[2]);
		$temp_arr["stud_blood_type"]=$blood_arr[$stud_blood_type];
		$temp_arr["stud_sex"]=$sex_arr[$stud_sex];
		$temp_arr["stud_name"]=$stud_name;
		$temp_arr["stud_id"]=$stud_id;
		$temp_arr["study_begin_date"]=$study_begin_date;
		$temp_arr["stud_person_id"]=$stud_person_id;
		$temp_arr["stud_birth_place"]=$birth_state_arr[sprintf("%02d",$stud_birth_place)];
		$temp_arr["curr_year"]= Num2CNum(substr($curr_class_num,0,1));
		$temp_arr["curr_class"] = $class_name[substr($curr_class_num,1,2)];
		$temp_arr["curr_num"] = intval(substr($curr_class_num,-2))."��";
		$temp_arr["sch_cname"] = $SCHOOL_BASE[sch_cname];
		$temp_arr["stud_addr_1"] = $stud_addr_1;
		$temp_arr["stud_addr_2"] = $stud_addr_2;
		$temp_arr["stud_tel_1"] = $stud_tel_1;
		$temp_arr["stud_tel_2"] = $stud_tel_2;
                $temp_arr["stud_mschool_name"]=$stud_mschool_name;
                $temp_arr["stud_grade_date"]=$stud_grade_date;

		//���t���
		$temp_arr[stud_parent] = "��: $fath_name($is_live_arr[$fath_alive])($fath_birthyear ��), ��:$moth_name($is_live_arr[$moth_alive])($moth_birthyear ��), ����:$grandfath_name($is_live_arr[$grandfath_alive]), ����:$grandmoth_name($is_live_arr[$grandmoth_alive])";

		//�����Ш|�{��
		$temp_arr[stud_parent_edu]= "�� :$edu_kind_arr[$moth_education] ,��: $edu_kind_arr[$moth_education]";

		//���@�H
		$temp_arr["aaaa"]= $guardian_name;
		$temp_arr["bbbb"]= $guardian_relation_arr[$guardian_relation];
		$temp_arr["cccc"]= $guardian_address;
		$temp_arr["dddd"]= "$guardian_phone $guardian_hand_phone";

		//�a��
		$temp_arr[f_1]=$fath_name;
		$temp_arr[f_2]=$fath_occupation;
		$temp_arr[f_3]=$fath_work_name;
		$temp_arr[f_4]=$fath_unit;
		$temp_arr[f_5]=$fath_phone;
		$temp_arr[m_1]=$moth_name;
		$temp_arr[m_2]=$moth_occupation;
		$temp_arr[m_3]=$moth_work_name;
		$temp_arr[m_4]=$moth_unit;
		$temp_arr[m_5]=$moth_phone;

		$temp_arr[stud_study_year] = $stud_study_year;

		//���o�ǥͻ��ɸ��
		$stud_seme_arr = array();
		$sql_select = "select seme_year_seme,stud_id,sse_relation,sse_family_kind,sse_family_air,sse_farther,sse_mother,sse_live_state,sse_rich_state,sse_s1,sse_s2,sse_s3,sse_s4,sse_s5,sse_s6,sse_s7,sse_s8,sse_s9,sse_s10,sse_s11 from stud_seme_eduh where stud_id='$stud_id' order by seme_year_seme";
		$res_seme = $CONN->Execute($sql_select);
		while(!$res_seme->EOF){
			$temp_seme = $res_seme->fields[seme_year_seme];
			$stud_seme_arr[$temp_seme][sse_relation] = $res_seme->fields[sse_relation];
			$stud_seme_arr[$temp_seme][sse_family_kind] = $res_seme->fields[sse_family_kind];
			$stud_seme_arr[$temp_seme][sse_family_air] = $res_seme->fields[sse_family_air];
			$stud_seme_arr[$temp_seme][sse_farther] = $res_seme->fields[sse_farther];
			$stud_seme_arr[$temp_seme][sse_mother] = $res_seme->fields[sse_mother];
			$stud_seme_arr[$temp_seme][sse_live_state] = $res_seme->fields[sse_live_state];
			$stud_seme_arr[$temp_seme][sse_rich_state] = $res_seme->fields[sse_rich_state];
			$stud_seme_arr[$temp_seme][sse_s1] = $res_seme->fields[sse_s1];
			$stud_seme_arr[$temp_seme][sse_s2] = $res_seme->fields[sse_s2];
			$stud_seme_arr[$temp_seme][sse_s3] = $res_seme->fields[sse_s3];
			$stud_seme_arr[$temp_seme][sse_s4] = $res_seme->fields[sse_s4];
			$stud_seme_arr[$temp_seme][sse_s5] = $res_seme->fields[sse_s5];
			$stud_seme_arr[$temp_seme][sse_s6] = $res_seme->fields[sse_s6];
			$stud_seme_arr[$temp_seme][sse_s7] = $res_seme->fields[sse_s7];
			$stud_seme_arr[$temp_seme][sse_s8] = $res_seme->fields[sse_s8];
			$stud_seme_arr[$temp_seme][sse_s9] = $res_seme->fields[sse_s9];
			$stud_seme_arr[$temp_seme][sse_s10] = $res_seme->fields[sse_s10];
			$stud_seme_arr[$temp_seme][sse_s11] = $res_seme->fields[sse_s11];
			$res_seme->MoveNext();
		}

		//�J�ǾǮ� (�|���P�_�ꤤ�p)
		//$temp_arr["stud_mschool_name"]="";
		//���~��� (�|���P�_)

		//$temp_arr["stud_grade_date"]="";
		//�C�L�ɶ�
		$temp_arr["print_time"]="�C�L�ɶ�: $now";
		$temp_arr["test_1"]="misser����";
		//���N�򥻸��
		$data .= change_temp($temp_arr,$no_iconv_arr,$doc_main);

		$recordSet->MoveNext();
		//����
		if (!$recordSet->EOF)
			$data .= $break;
                //echo $data ;
        	//��ƶ}�l��X

        	$data_index="<font size='3'>";
        	$data_word="<font size='4' color='blue' face='�з���'>";

                echo "<table border='1' cellpadding='2' cellspacing='0'  bordercolorlight='#333354' bordercolordark='#FFFFFF' width='100%'>";
                echo "<tr><td colspan='11' align='center'><font color='green' size='4'>"."�ǥͻ��ɬ�����</font></td></tr>";
                echo "<td colspan='2'>".$data_index."�m�W</font></td>";
                echo "<td colspan='2'>".$data_word.$temp_arr[stud_name]."</font></td>";
                echo "<td>".$data_index."�ʧO</font></td>";
                echo "<td colspan='2'>".$data_word.$temp_arr[stud_sex]."</font></td>";
                echo "<td rowspan='4'>".$data_index."���ʬ���</font></td>";
                echo "<td colspan='3' rowspan='4'>".$data_word.$temp_arr[stud_kind]."</font></td>";
                echo "</tr><tr>";
                echo "<td colspan='2'>".$data_index."�J�Ǧ~</font></td>";
                echo "<td colspan='2'>".$data_word.$temp_arr[stud_study_year]."</font></td>";
                echo "<td>".$data_index."�Ǹ�</font></td>";
                echo "<td colspan='2'>".$data_word.$temp_arr[stud_id]."</font></td>";
                echo "</tr><tr>";
                echo "<td colspan='2'>".$data_index."�J�ǮɾǮ�</font></td>";
                echo "<td colspan='5'>".$data_word.$temp_arr[stud_mschool_name]."</font></td>";
                echo "</tr><tr>";
                echo "<td colspan='2'>".$data_index."���~�~��</font></td>";
                echo "<td colspan='5'>".$data_word.$temp_arr[stud_grade_date]."</font></td>";
                echo "</tr><tr><td colspan='11' align='center'><font size='4'>"."�@�B���H���p</font></td></tr>";
                echo "</tr><tr>";
                echo "<td colspan='2'>".$data_index."�����ҽs��</font></td>";
                echo "<td colspan='9'>".$data_word.$temp_arr[stud_person_id]."</font></td>";
                echo "</tr><tr>";
                echo "<td colspan='2'>".$data_index."�X��</font></td>";
                echo "<td>".$data_index."�X�ͦa</font></td>";
                echo "<td colspan='4'>".$data_word.$temp_arr[stud_birth_place]."</font></td>";
                echo "<td>".$data_index."�ͤ�</font></td>";
                echo "<td colspan='3'>".$data_word.$temp_arr[stud_birthday]."</font></td>";
                echo "</tr><tr>";
                echo "<td colspan='2'>".$data_index."�嫬</font></td>";
                echo "<td colspan='9'>".$data_word.$temp_arr[stud_blood_type]."</font></td>";
                echo "</tr><tr>";
                echo "<td colspan='2'>".$data_index."���y�a�}</font></td>";
                echo "<td colspan='6'>".$data_word.$temp_arr[stud_addr_1]."</font></td>";
                echo "<td>".$data_index."�q��</font></td>";
                echo "<td colspan='2'>".$data_word.$temp_arr[stud_tel_1]."</font></td>";
                echo "</tr><tr>";
                echo "<td colspan='2'>".$data_index."�p���a�}</font></td>";
                echo "<td colspan='6'>".$data_word.$temp_arr[stud_addr_2]."</font></td>";
                echo "<td>".$data_index."�q��</font></td>";
                echo "<td colspan='2'>".$data_word.$temp_arr[stud_tel_2]."</font></td>";
                echo "</tr><tr><td colspan='11' align='center'><font size='4'>"."�G�B�a�x���p</font></td></tr>";
                echo "</tr><tr>";
                echo "<td colspan='2'>".$data_index."���t���</font></td>";
                echo "<td colspan='9'>".$data_word.$temp_arr[stud_parent]."</font></td>";
                echo "</tr><tr>";
                echo "<td colspan='2'>".$data_index."�����Ш|�{��</font></td>";
                echo "<td colspan='9'>".$data_word.$temp_arr[stud_parent_edu]."</font></td>";
                echo "</tr><tr>";
                echo "<td colspan='2' rowspan='3'>".$data_index."�a��</font></td>";
                echo "<td>".$data_index."�ٿ�</font></td>";
                echo "<td>".$data_index."�m�W</font></td>";
                echo "<td colspan='2'>".$data_index."¾�~</font></td>";
                echo "<td colspan='2'>".$data_index."�u�@���c</font></td>";
                echo "<td>".$data_index."¾��</font></td>";
                echo "<td>".$data_index."�q��</font></td>";
                echo "<td>".$data_index."�Ƶ�</font></td>";
                echo "</tr><tr>";
                echo "<td>".$data_index."��</font></td>";
                echo "<td>".$data_word.$temp_arr[f_1]."</font></td>";
                echo "<td colspan='2'>".$data_word.$temp_arr[f_2]."</font></td>";
                echo "<td colspan='2'>".$data_word.$temp_arr[f_3]."</font></td>";
                echo "<td>".$data_word.$temp_arr[f_4]."</font></td>";
                echo "<td>".$data_word.$temp_arr[f_5]."</font></td>";
                echo "</tr><tr>";
                echo "<td>".$data_index."��</font></td>";
                echo "<td>".$data_word.$temp_arr[m_1]."</font></td>";
                echo "<td colspan='2'>".$data_word.$temp_arr[m_2]."</font></td>";
                echo "<td colspan='2'>".$data_word.$temp_arr[m_3]."</font></td>";
                echo "<td>".$data_word.$temp_arr[m_4]."</font></td>";
                echo "<td>".$data_word.$temp_arr[m_5]."</font></td>";
                echo "</tr><tr>";
                echo "<td colspan='2'>".$data_index."���@�H</font></td>";
                echo "<td colspan='9'>";
                echo $data_index."�m�W�G"."</font>".$data_word.$temp_arr[aaaa]."</font>";
                echo $data_index."���Y�G"."</font>".$data_word.$temp_arr[bbbb]."</font>";
                echo $data_index."�q�T�B�G"."</font>".$data_word.$temp_arr[cccc]."</font>";
                echo $data_index."�q�ܡG"."</font>".$data_word.$temp_arr[dddd]."</font></td>";
                echo "</tr><tr>";
        	//�S�̩j�f
        	$query = "select * from stud_brother_sister where student_sn='$student_sn' order by bs_birthyear";
        	$bs_res = $CONN->Execute($query);
        	$temp=$bs_res->RecordCount();
        	$temp+=1;
                echo "<td colspan='2' rowspan='".$temp."'>".$data_index."�S�̩n�f</font></td>";
                echo "<td>".$data_index."�ٿ�</font></td>";
                echo "<td colspan='2'>".$data_index."�m�W</font></td>";
                echo "<td colspan='4'>".$data_index."��(�w)�~�]��</font></td>";
                echo "<td colspan='2'>".$data_index."�X�ͦ~��</font></td></tr>";
                while(!$bs_res->EOF){
        		$bs_arr[b_1] = $bs_calling_kind_arr[$bs_res->fields[bs_calling]];
        		$bs_arr[b_2] = $bs_res->fields[bs_name];
        		$bs_arr[b_3] = $bs_res->fields[bs_gradu];
        		$bs_arr[b_4] = $bs_res->fields[bs_birthyear];
                        echo "<td>".$data_word.$bs_arr[b_1]."</font></td>";
                        echo "<td colspan='2'>".$data_word.$bs_arr[b_2]."</font></td>";
                        echo "<td colspan='4'>".$data_word.$bs_arr[b_3]."</font></td>";
                        echo "<td colspan='2'>".$data_word.$bs_arr[b_4]."</font></td>";

                        echo "</tr><tr>";
                       	$bs_res->MoveNext();
        	}
                echo "</tr><tr>";
        	//�������Y
        	$sssss ='';
        	reset($stud_seme_arr);
        	while(list($vid,$vval) = each($stud_seme_arr)){
        		$this_year = (substr($vid,0,-1)-$stud_study_year)+1;
        		$semester = substr($vid,-1);
        		$seme_name = ($semester==1)?"�W":"�U";
        		$seme_name = Num2CNum($this_year).$seme_name;
        		$temp_ss = $seme_name.'('. $sse_relation_arr[$vval[sse_relation]].")";
        		$sssss .= $temp_ss.", ";
        	}
                echo "</tr><tr>";
                echo "<td colspan='2' rowspan='2'>".$data_index."�������Y</font></td>";
                echo "<td colspan='9'>".$data_index.$sse_relation_str."</font></td>";
                echo "</tr><tr>";
                echo "<td colspan='9'>".$data_word.$sssss."</font></td>";
                //�a�x����
        	reset($stud_seme_arr);
        	$sssss ='';
        	while(list($vid,$vval) = each($stud_seme_arr)){
        		$this_year = (substr($vid,0,-1)-$stud_study_year)+1;
        		$semester = substr($vid,-1);
        		$seme_name = ($semester==1)?"�W":"�U";
        		$seme_name = Num2CNum($this_year).$seme_name;
        		$temp_ss = $seme_name.'('. $sse_family_kind_arr[$vval[sse_family_kind]].")";
        		$sssss .= $temp_ss.", ";
        	}
                echo "</tr><tr>";
                echo "<td colspan='2' rowspan='2'>".$data_index."�a�x����</font></td>";
                echo "<td colspan='9'>".$data_index.$sse_family_kind_str."</font></td>";
                echo "</tr><tr>";
                echo "<td colspan='9'>".$data_word.$sssss."</font></td>";
                //�a�x��^
        	reset($stud_seme_arr);
        	$sssss ='';
        	while(list($vid,$vval) = each($stud_seme_arr)){
        		$this_year = (substr($vid,0,-1)-$stud_study_year)+1;
        		$semester = substr($vid,-1);
        		$seme_name = ($semester==1)?"�W":"�U";
        		$seme_name = Num2CNum($this_year).$seme_name;
        		$temp_ss = $seme_name.'('. $sse_family_air_arr[$vval[sse_family_kind]].")";
        		$sssss .= $temp_ss.", ";
        	}
                echo "</tr><tr>";
                echo "<td colspan='2' rowspan='2'>".$data_index."�a�x��^</font></td>";
                echo "<td colspan='9'>".$data_index.$sse_family_air_str."</font></td>";
                echo "</tr><tr>";
                echo "<td colspan='9'>".$data_word.$sssss."</font></td>";
                //���ޱФ覡
        	reset($stud_seme_arr);
        	$sssss ='';
        	while(list($vid,$vval) = each($stud_seme_arr)){
        		$this_year = (substr($vid,0,-1)-$stud_study_year)+1;
        		$semester = substr($vid,-1);
        		$seme_name = ($semester==1)?"�W":"�U";
        		$seme_name = Num2CNum($this_year).$seme_name;
        		$temp_ss = $seme_name.'('. $sse_farther_arr[$vval[sse_farther]].")";
        		$sssss .= $temp_ss.", ";
        	}
                echo "</tr><tr>";
                echo "<td colspan='2' rowspan='2'>".$data_index."���ޱФ覡</font></td>";
                echo "<td colspan='9'>".$data_index.$sse_farther_str."</font></td>";
                echo "</tr><tr>";
                echo "<td colspan='9'>".$data_word.$sssss."</font></td>";
                //���ޱФ覡
        	reset($stud_seme_arr);
        	$sssss ='';
        	while(list($vid,$vval) = each($stud_seme_arr)){
        		$this_year = (substr($vid,0,-1)-$stud_study_year)+1;
        		$semester = substr($vid,-1);
        		$seme_name = ($semester==1)?"�W":"�U";
        		$seme_name = Num2CNum($this_year).$seme_name;
        		$temp_ss = $seme_name.'('. $sse_farther_arr[$vval[sse_mother]].")";
        		$sssss .= $temp_ss.", ";
        	}
                echo "</tr><tr>";
                echo "<td colspan='2' rowspan='2'>".$data_index."���ޱФ覡</font></td>";
                echo "<td colspan='9'>".$data_index.$sse_farther_str."</font></td>";
                echo "</tr><tr>";
                echo "<td colspan='9'>".$data_word.$sssss."</font></td>";
                //�~����
        	reset($stud_seme_arr);
        	$sssss ='';
        	while(list($vid,$vval) = each($stud_seme_arr)){
        		$this_year = (substr($vid,0,-1)-$stud_study_year)+1;
        		$semester = substr($vid,-1);
        		$seme_name = ($semester==1)?"�W":"�U";
        		$seme_name = Num2CNum($this_year).$seme_name;
        		$temp_ss = $seme_name.'('. $sse_live_state_arr[$vval[sse_live_state]].")";
        		$sssss .= $temp_ss.", ";
        	}
                echo "</tr><tr>";
                echo "<td colspan='2' rowspan='2'>".$data_index."�~����</font></td>";
                echo "<td colspan='9'>".$data_index.$sse_live_state_str."</font></td>";
                echo "</tr><tr>";
                echo "<td colspan='9'>".$data_word.$sssss."</font></td>";
                //�g�٪��p
        	reset($stud_seme_arr);
        	$sssss ='';
        	while(list($vid,$vval) = each($stud_seme_arr)){
        		$this_year = (substr($vid,0,-1)-$stud_study_year)+1;
        		$semester = substr($vid,-1);
        		$seme_name = ($semester==1)?"�W":"�U";
        		$seme_name = Num2CNum($this_year).$seme_name;
        		$temp_ss = $seme_name.'('. $sse_rich_state_arr[$vval[sse_rich_state]].")";
        		$sssss .= $temp_ss.", ";
        	}
                echo "</tr><tr>";
                echo "<td colspan='2' rowspan='2'>".$data_index."�g�٪��p</font></td>";
                echo "<td colspan='9'>".$data_index.$sse_rich_state_str."</font></td>";
                echo "</tr><tr>";
                echo "<td colspan='9'>".$data_word.$sssss."</font></td>";

        	$bs_data = '';
        	for($si=1;$si<=11;$si++){
        		reset($stud_seme_arr);
        		$sssss ='';
        		while(list($vid,$vval) = each($stud_seme_arr)){
        			$temp_sse_arr = ${"sse_arr_$si"};
        			$temp_str = ${"sse_str_$si"};
        			$temp_id  = "sse_s$si";
        			$this_year = (substr($vid,0,-1)-$stud_study_year)+1;
        			$semester = substr($vid,-1);
        			$seme_name = ($semester==1)?"�W":"�U";
        			$seme_name = Num2CNum($this_year).$seme_name;
        			$tt_arr = explode(",",$vval[$temp_id]);
        			$temp_ss='';
        			foreach ($tt_arr as $VAL){
        				if ($VAL<>'')
        					$temp_ss .= $temp_sse_arr[$VAL].",";
        			}
        			if($temp_ss<>'')
        				$temp_ss = substr($temp_ss,0,-1);
        			$temp_ss = $seme_name.'('.$temp_ss.')';
        			$sssss .= $temp_ss.", ";
        		}
        		if($si==1)
        			$bs_arr[sse_kind] = "�̳߷R���";
        		else if($si==2)
        			$bs_arr[sse_kind] = "�̧x�����";
        		else
        			$bs_arr[sse_kind] = $sse_arr[$si];

                        echo "</tr><tr>";
                        echo "<td colspan='2' rowspan='2'>".$data_index.$bs_arr[sse_kind]."</font></td>";
                        echo "<td colspan='9'>".$data_index.$temp_str."</font></td>";
                        echo "</tr><tr>";
                        echo "<td colspan='9'>".$data_word.$sssss."</font></td>";
        	}
                //�H�U by misser,�ק�3(�s�W) ,���o�X�ʮu���� ,��L
                //=================================
                if ($IS_JHORES==6){//�ꤤ�A6�Ǵ�
                   $stud_seme_new_arr=array("$stud_study_year"."1","$stud_study_year"."2","$stud_study_year"+"1"."1","$stud_study_year"+"1"."2","$stud_study_year"+"2"."1","$stud_study_year"+"2"."2");
                }
                else{//���ӬO�p�ǡA�ҥH��12�Ǵ�
                   $stud_seme_new_arr=array("$stud_study_year"."1","$stud_study_year"."2","$stud_study_year"+"1"."1","$stud_study_year"+"1"."2","$stud_study_year"+"2"."1","$stud_study_year"+"2"."2","$stud_study_year"+"3"."1","$stud_study_year"+"3"."2","$stud_study_year"+"4"."1","$stud_study_year"+"4"."2","$stud_study_year"+"5"."1","$stud_study_year"+"5"."2");
                }
                $bs_data = '';
        	//reset($stud_seme_arr); ����$stud_seme_arr�A�]���Y�Y�Ǵ��|���ػ��ɬ����A�h
        	//$stud_seme_arr�N�|�֤F�Y�Ǵ�����ơA�]�N�L�k��X�ӾǴ������m�ҡC
        	//�ҥH�� �W���� $stud_seme_new_arr �N���C
        	//�H�U���g��P

                //���o���O
                $asb_arr=sfs_text("���m�����O");
        	while(list($id,$val)= each($asb_arr))
        		$asb_str .= "$id-$val,";

        	//���oabsent��ƪ��X�ʮu����
        	$sssss ='<text:p text:style-name="P8">';
        	$temp_ss='';
                //�U��$vval��$vid ��m�M����O��ժ�
                while(list($vval,$vid) = each($stud_seme_new_arr)){//�̾Ǵ��O
                        $year=(substr($vid,0,1)=='0')?substr($vid,1,-1):substr($vid,0,-1);
                        $this_year = (substr($vid,0,-1)-$stud_study_year)+1;
        		$semester = substr($vid,-1);
        		$seme_name = ($semester==1)?"�W":"�U";
        		$seme_name = Num2CNum($this_year).$seme_name;
        		$temp_ss .= $seme_name.'(';
        		foreach ($asb_arr as $temp_kind){//�A�̰��O�M�䦸��
        	            $sql_select = "select * from stud_absent where stud_id='$stud_id' and absent_kind='$temp_kind' and year='$year' and semester='$semester' order by year,semester";
                            $record=$CONN->Execute($sql_select) or die($sql_select);
                            $num=$record->RecordCount();
                            if ($num>0){;//�p�G���A�h�Ǧ^���O����
                                $temp_ss.=$temp_kind.":".$num."�`�C ";
                            }
                        }
                        $temp_ss.=')';

        	}
        	$sssss .= $temp_ss.", ";
                echo "</tr><tr>";
                echo "<td colspan='2' rowspan='2'>".$data_index."���m�Ҭ���</font></td>";
                echo "<td colspan='9'>".$data_index.$asb_str."</font></td>";
                echo "</tr><tr>";
                echo "<td colspan='9'>".$data_word.$sssss."</font></td>";

                //�H�U by misser,�ק�4(�s�W) ,���o���g���� ,��L
                //=================================
                if ($IS_JHORES==6){//���ꤤ�A��p���μ��g
          	   $bs_data = '';
         	   reset($stud_seme_new_arr);
        	   //���o���g���O ,���� reward �Ҳժ�config.php
            	   $reward_arr=array("1"=>"�ż��@��","2"=>"�ż��G��","3"=>"�p�\�@��","4"=>"�p�\�G��","5"=>"�j�\�@��","6"=>"�j�\�G��","7"=>"�j�\�T��","-1"=>"ĵ�i�@��","-2"=>"ĵ�i�G��","-3"=>"�p�L�@��","-4"=>"�p�L�G��","-5"=>"�j�L�@��","-6"=>"�j�L�G��","-7"=>"�j�L�T��");
                   while(list($id,$val)= each($reward_arr))
        	  	$reward_str .= "$id-$val,";

        	    //���oreward��ƪ����g����
        	    $sssss ='<text:p text:style-name="P8">';
        	    $temp_ss='';

        	    while(list($vval,$vid) = each($stud_seme_new_arr)){
        	        $year=(substr($vid,0,1)=='0')?substr($vid,1,-1):substr($vid,0,-1);
                        $this_year = (substr($vid,0,-1)-$stud_study_year)+1;
        		$semester = substr($vid,-1);
        		$seme_name = ($semester==1)?"�W":"�U";
        		$seme_name = Num2CNum($this_year).$seme_name;
        		$temp_ss .= $seme_name.'(';

                        $sql_select = "select * from reward where stud_id='$stud_id' and reward_year_seme='$year$semester' order by reward_date";
                        $re_record=$CONN->Execute($sql_select) or die($sql_select);

                        while(!$re_record->EOF){
                                $temp_ss.= $reward_arr[$re_record->fields[reward_kind]];
                                $temp_ss.=":";
                                $temp.=$re_record->fields[reward_reason];
                                if ($re_record->fields[reward_cancel_date]!="" and $re_record->fields[reward_cancel_date]!="0000-00-00")
                                   $temp_ss.="**�w�P�L**";

                                $temp_ss.="�@,";
                                $re_record->MoveNext();
                       }

                           $temp_ss.=")";
        	     }
        	     $sssss .= $temp_ss.", ";
                     echo "</tr><tr>";
                     echo "<td colspan='2' rowspan='2'>".$data_index."���g����</font></td>";
                     echo "<td colspan='9'>".$data_index.$reward_str."</font></td>";
                     echo "</tr><tr>";
                     echo "<td colspan='9'>".$data_word.$sssss."</font></td>";
		}
                // by misser �ק�4(�s�W) ����

		//�������
                echo "</tr><tr>";
                echo "<td colspan='2' rowspan='2'>".$data_index."�������</font></td>";
                echo "<td><font size='1'>����W��</font></td>";
                echo "<td><font size='1'>������</font></td>";
                echo "<td><font size='1'>��l����</font></td>";
                echo "<td><font size='1'>�`�Ҽ˥�</font></td>";
                echo "<td><font size='1'>����</font></td>";
                echo "<td><font size='1'>�зǤ���</font></td>";
                echo "<td><font size='1'>�ʤ�����</font></td>";
                echo "<td colspan='2'><font size='1'>����</font></td>";
                echo "</tr><tr>";
                echo "<td><font size='1'>&nbsp;</font></td>";
                echo "<td><font size='1'>&nbsp;</font></td>";
                echo "<td><font size='1'>&nbsp;</font></td>";
                echo "<td><font size='1'>&nbsp;</font></td>";
                echo "<td><font size='1'>&nbsp;</font></td>";
                echo "<td><font size='1'>&nbsp;</font></td>";
                echo "<td><font size='1'>&nbsp;</font></td>";
                echo "<td colspan='2'><font size='1'>&nbsp;</font></td>";
        	//���ɳX�ͰO��
                echo "</tr><tr>";
                echo "<td colspan='11' align='center'>".$data_index."���n���ɬ���</font></td>";
                echo "</tr><tr>";
                echo "<td>".$data_index."�Ǵ�</font></td>";
                echo "<td>".$data_index."���</font></td>";
                echo "<td>".$data_index."��H</font></td>";
                echo "<td colspan='7'>".$data_index."���ɤ��e�n�I</font></td>";
                echo "<td>".$data_index."������</font></td>";

        	$query = "select seme_year_seme,sst_date,sst_name,sst_main,sst_memo,teach_id from stud_seme_talk where stud_id='$stud_id' order by seme_year_seme";
        	$res_talk = $CONN->Execute($query) or die($query);
        	$memo_arr = array();
        	while(!$res_talk->EOF){
        		$memo_arr[w_2]= $res_talk->fields[sst_date];
        		$memo_arr[w_3]= $res_talk->fields[sst_name];
        		$memo_arr[w_4]= $res_talk->fields[sst_main].":".$res_talk->fields[sst_memo];
        		$memo_arr[w_5]= get_teacher_name($res_talk->fields[teach_id]);
        		$this_year = (substr($res_talk->fields[seme_year_seme],0,-1)-$stud_study_year)+1;
        		$semester = substr($res_talk->fields[seme_year_seme],-1);
        		$seme_name = ($semester==1)?"�W":"�U";
        		$memo_arr[w_1] = Num2CNum($this_year).$seme_name;
                        echo "</tr><tr>";
                        echo "<td>".$data_word.$memo_arr[w_1]."</font></td>";
                        echo "<td>".$data_word.$memo_arr[w_2]."</font></td>";
                        echo "<td>".$data_word.$memo_arr[w_3]."</font></td>";
                        echo "<td colspan='7'>".$data_word.$memo_arr[w_4]."</font></td>";
                        echo "<td>".$data_word.$memo_arr[w_5]."</font></td>";
        		$res_talk->MoveNext();
        	}
        	//�S���{�O��
                echo "</tr><tr>";
                echo "<td colspan='11' align='center'>".$data_index."�S���{����</font></td>";
                echo "</tr><tr>";
                echo "<td>".$data_index."�Ǵ�</font></td>";
                echo "<td>".$data_index."�������</font></td>";
                echo "<td colspan='8'>".$data_index."�u�}��{�Ʃy</font></td>";
                echo "<td>".$data_index."������</font></td>";

        	$query = "select seme_year_seme,sp_date,sp_memo,teach_id from stud_seme_spe where stud_id='$stud_id' order by seme_year_seme";
        	$res_talk = $CONN->Execute($query) or die($query);
        	$memo_arr = array();
        	while(!$res_talk->EOF){
        		$memo_arr[s_2]= $res_talk->fields[sp_date];
        		$memo_arr[s_3]= $res_talk->fields[sp_memo];
        		$memo_arr[s_4]= get_teacher_name($res_talk->fields[teach_id]);
        		$this_year = (substr($res_talk->fields[seme_year_seme],0,-1)-$stud_study_year)+1;
        		$semester = substr($res_talk->fields[seme_year_seme],-1);
        		$seme_name = ($semester==1)?"�W":"�U";
        		$memo_arr[s_1] = Num2CNum($this_year).$seme_name;
                        echo "</tr><tr>";
                        echo "<td>".$data_word.$memo_arr[s_1]."</font></td>";
                        echo "<td>".$data_word.$memo_arr[s_2]."</font></td>";
                        echo "<td colspan='8'>".$data_word.$memo_arr[s_3]."</font></td>";
                        echo "<td>".$data_word.$memo_arr[s_4]."</font></td>";

        		$res_talk->MoveNext();
        	}

                echo "</tr></table><p>";
	}

        exit;

	break;

}







//��ܯZ��

head();

print_menu($menu_p);
echo <<<HERE
<script>
function tagall(status) {
  var i =0;

  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].name=='sel_stud[]') {
      document.myform.elements[i].checked=status;
    }
    i++;
  }
}
</script>
HERE;

	$help_text="
	��������t�W�u�W��ܡA�l�\��P��L���ɬ�����[�p�G���վǥͻ��ɬ�����������]�ۦP�A�е��ݭn�ϥΡC";
	$help=&help($help_text);

echo $help;
echo "<form action=\"{$_SERVER['PHP_SELF']}\" method=\"post\" name=\"myform\">";

$sel1 = new drop_select();
$sel1->top_option =  "��ܯZ��";
$sel1->s_name = "class_id";
$sel1->id = $class_id;
$sel1->is_submit = true;
$sel1->arr = $class_arr;
$sel1->do_select();

if($class_id<>'') {
	$query = "select stud_id,stud_name,curr_class_num,stud_study_cond from stud_base where stud_study_cond <> 5 and curr_class_num like '$class_id%' order by curr_class_num";
	$result = $CONN->Execute($query) or die ($query);
	if (!$result->EOF) {

 		echo '&nbsp;<input type="button" value="����" onClick="javascript:tagall(1);">&nbsp;';
 		echo '<input type="button" value="��������" onClick="javascript:tagall(0);">';
		echo "<table border=1>";
		$ii=0;
		while (!$result->EOF) {
			$stud_id = $result->fields[stud_id];
			$stud_name = $result->fields[stud_name];
			$curr_class_num = substr($result->fields[curr_class_num],-2);
			$stud_study_cond = $result->fields[stud_study_cond];
			$move_kind ='';
			if ($stud_study_cond >0){//�W�[ { �O�� by misser 93.10.20
                                $move_kind_arr=study_cond();//����s�W by misser 93.10.20
				$move_kind= "<font color=red>(".$move_kind_arr[$stud_study_cond].")</font>";
                        }//�W�[ } �O�� by misser 93.10.20
			if ($ii %2 ==0)
				$tr_class = "class=title_sbody1";
			else
				$tr_class = "class=title_sbody2";

			if ($ii % 5 == 0)
				echo "<tr $tr_class >";
			echo "<td ><input id=\"c_$stud_id\" type=\"checkbox\" name=\"sel_stud[]\" value=\"$stud_id\"><label for=\"c_$stud_id\">$curr_class_num. $stud_name $move_kind</label></td>\n";

			if ($ii % 5 == 4)
				echo "</tr>";
			$ii++;
			$result->MoveNext();
		}
		echo"</table>";

		echo "  sxw �榡(openoffice �ɮ�) ��X ";
		echo "<input type=\"submit\" name=\"do_key\" value=\"$postBtn\"><p>";
		echo "  �u�W��X ";
		echo "<input type=\"submit\" name=\"do_key\" value=\"$postBtn_xls_online\">";
		echo "<input type=\"hidden\" name=\"filename\" value=\"reg2_class{$class_id}.sxw\">";

	}

}



foot();


function change_temp($arr,$no_iconv_arr,$source) {
	//$temp_str = $source;
	while(list($id,$val) = each($arr)){
		if (!$no_iconv_arr[$id])
			$val =iconv("Big5","UTF-8//IGNORE",$val);
		$temp_str.= $id. "->".$val."<br>";
	}
	return $temp_str;
}


function change_temp_old($arr,$no_iconv_arr,$source) {
	$temp_str = $source;
	while(list($id,$val) = each($arr)){
		if (!$no_iconv_arr[$id])
			$val =iconv("Big5","UTF-8//IGNORE",$val);
		$temp_str = str_replace("{".$id."}", $val,$temp_str);
	}
	return $temp_str;
}
?>


