<?php

// $Id: letter.php 7691 2013-10-23 07:58:03Z smallduh $

	//�s�W�@�� zipfile ���
	$ttt = new EasyZip;
	$ttt->setPath($oo_path);
	$ttt->addDir('META-INF');
	$ttt->addfile("settings.xml");
	$ttt->addfile("styles.xml");
	$ttt->addfile("meta.xml");

	//Ū�X content.xml 
	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/content_body.xml");

	//�N content.xml �� tag ���N
	$sql="select * from school_base";
	$rs=$CONN->Execute($sql);
	$temp_arr["school_name"] = $rs->fields['sch_cname'];
	$temp_arr["sch_addr"] = $rs->fields['sch_addr'];
	$temp_arr["sch_post_num"] = $rs->fields['sch_post_num'];
	$temp_arr["school_tel"]= $rs->fields['sch_phone'];
	$sql="select * from school_room where room_id='3'";
	$rs=$CONN->Execute($sql);
	$temp_arr["room_name"] = $rs->fields['room_name'];

  //�򥻸�Ƨ�� student_sn ��������o by smallduh 2012.10.05
	$sql="select * from stud_base where student_sn='$student_sn'";
	
	//$sql="select * from stud_base where stud_id='$One'";
	$rs=$CONN->Execute($sql);
	$stud_id=$One;
	if (strlen($stud)<6) $s=" ";
	$temp_arr["stud_id"] = $stud_id.$s;
	$temp_arr["stud_name"] = $rs->fields['stud_name'];
	$curr_class_num = $rs->fields['curr_class_num'];
	$year_name=substr($curr_class_num,0,-4);
	$temp_arr["year_name"]=$class_name_kind_1[$year_name-$IS_JHORES];
	$temp_arr["class_num"]=substr($curr_class_num,-4,-2);
	$temp_arr["site_num"]=substr($curr_class_num,-2);
	$temp_arr["stud_addr"] = $rs->fields['stud_addr_2'];
	
	//�H�U��y���G�h�l, �����ѱ� by smallduh 2012.10.05
	//$sql="select * from stud_base where stud_id='$One'";
	//$rs=$CONN->Execute($sql);
	
	//���@�H���, ���student_sn��������o  by smallduh 2012.10.05
	$sql="select guardian_name from stud_domicile where student_sn='$student_sn'";
	
	//$sql="select guardian_name from stud_domicile where stud_id='$One'";
	$rs=$CONN->Execute($sql);
	$temp_arr["guardian_name"] = $rs->fields['guardian_name'];

	//���o�ӯZ���X�`��
	$sql = "select sections from score_setup where year = '$sel_year' and semester='$sel_seme' and class_year='$year_name'";
	$rs=$CONN->Execute($sql) or trigger_error("SQL�y�k���~�G $sql", E_USER_ERROR);
	$all_sections = $rs->fields['sections'];
	$fday=mktime(0,0,0,$month,$day,$year);
	$dd=getdate($fday);
	$fday-=($dd[wday]-1)*86400;
	for ($j=1;$j<=6;$j++) {
		//���o�Ӿǥ͸��
		$smkt=$fday+($j-1)*86400;
		$syear=date("Y",$smkt);
		$smonth=date("m",$smkt);
		$sday=date("d",$smkt);
		$did=date("Y-m-d",$smkt);
		$aaa=getOneDaydata($One,$syear,$smonth,$sday);
		$temp_arr["d".$j]=($syear-1911).".".$smonth.".".$sday;
		if ($aaa[allday]) {
			$aaa[uf]=$aaa[allday];
			$aaa[df]=$aaa[allday];
			for ($k=1;$k<=$all_sections;$k++) $aaa[$k]=$aaa[allday];
		}
		$temp_arr["a"."_".$j."1"]=empty($aaa[uf])?"---":$aaa[uf];
		$temp_arr["a"."_".$j."9"]=empty($aaa[df])?"---":$aaa[df];
		for ($k=1;$k<=$all_sections;$k++) $temp_arr["a"."_".$j.($k+1)]=empty($aaa[$k])?"---":$aaa[$k];
	}
	$today=date("Y-m-d",mktime (0,0,0,date("m"),date("d"),date("Y")));
	$ldd=explode("-",$today);
	$temp_arr["date"] = ($ldd[0]-1911).".".$ldd[1].".".$ldd[2];

	// change_temp �|�N�}�C���� big5 �ର UTF-8 �� openoffice �i�HŪ�X
	$replace_data = $ttt->read_file(dirname(__FILE__)."/$oo_path/content_head.xml").$ttt->change_temp($temp_arr,$data).$ttt->read_file(dirname(__FILE__)."/$oo_path/content_foot.xml");
	
	// �[�J content.xml ��zip ��
	$ttt->add_file($replace_data,"content.xml");
	
	//���� zip ��
	$sss = & $ttt->file();

	//�H��y�覡�e�X ooo.sxw
	$fl="letter_".$stud_id;
	header("Content-disposition: attachment; filename=$fl.sxw");
	header("Content-type: application/octetstream");
	//header("Pragma: no-cache");
	//�]�� SSL �s�u�ɡAIE 6,7,8 �|�o�ͤU�������D
	header("Cache-Control: max-age=0");
	header("Pragma: public");
	header("Expires: 0");

	echo $sss;
	
	exit;	
?>
