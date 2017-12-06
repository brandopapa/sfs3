<?php

// $Id: trans_main.php 8767 2016-01-13 13:15:56Z qfon $
include "../../include/sfs_oo_zip2.php";
	//�s�W�@�� zipfile ���
	$ttt = new EasyZip;
	$ttt->setPath($oo_path);
	$ttt->addDir('META-INF');
	$ttt->addfile("settings.xml");
	$ttt->addfile("meta.xml");

	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/styles.xml");
	$sql="select * from school_base";
	$rs=$CONN->Execute($sql);
	$school_name=$rs->fields['sch_cname'];
	$temp_arr["sch_cname"]=$school_name;
	$today=getdate(mktime(0,0,0,date("m"),date("d"),date("Y")));
	$temp_arr["year"]=$today[year]-1911;
	$temp_arr["month"]=$today[mon];
	$temp_arr["day"]=$today[mday];
	$replace_data = $ttt->change_temp($temp_arr,$data,0);
	$ttt->add_file($replace_data,"styles.xml");

	$data=$ttt->read_file(dirname(__FILE__)."/$oo_path/content.xml");
	//�N content.xml �� tag ���N
	//���o�ǥͰ}�C
	$reward_year_seme=$sel_year.$sel_seme;
	$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
	$all_sn="";
	$query="select * from stud_seme where seme_year_seme='$seme_year_seme' order by seme_class,seme_num";
	$res=$CONN->Execute($query);
	while (!$res->EOF) {
		$stud_id=$res->fields[stud_id];
		$student_sn=$res->fields[student_sn];
		$seme_class[$stud_id]=$res->fields[seme_class];
		$seme_num[$stud_id]=$res->fields[seme_num];
		$all_sn.="'".$student_sn."',";
		$res->MoveNext();
	}
	$all_sn=substr($all_sn,0,-1);
	$query="select stud_id,stud_name from stud_base where student_sn in ($all_sn)";
	$res=$CONN->Execute($query);
	while (!$res->EOF) {
		$stud_id=$res->fields[stud_id];
		$stud_name[$stud_id]=addslashes($res->fields[stud_name]);
		$res->MoveNext();
	}

	//���o�Z�Ű}�C
	$sel_year=intval($sel_year);
	$sel_seme=intval($sel_seme);
	$query="select class_id,c_name from school_class where year='$sel_year' and semester='$sel_seme' order by class_id";
	$res=$CONN->Execute($query);
	while (!$res->EOF) {
		$class_id=$res->fields[class_id];
		$c=explode("_",$class_id);
		$c_year=intval($c[2]);
		$class_name[$c_year.$c[3]]=$class_year[$c_year].$res->fields[c_name];
		$res->MoveNext();
	}

	$sw1=$weeks_array[0];
	$sw2=$sw1+1;
	$last_str=($sw2<count($weeks_array))?"and a.reward_date<'$weeks_array[$sw2]'":"";
	$temp_str="";
	$query="select a.* from reward a left join stud_seme b on a.student_sn=b.student_sn and b.seme_year_seme='$seme_year_seme' where a.reward_year_seme='$reward_year_seme' and a.reward_date>='$weeks_array[$sw1]' $last_str and dep_id<>0 $kd $dt order by b.seme_class,b.seme_num";
	$res=$CONN->Execute($query);
	$i=1;
	$all=$res->RecordCount();
	while(!$res->EOF) {
		$stud_id=$res->fields[stud_id];
		$reward_kind=$res->fields[reward_kind];
		$c=explode("�~",$class_name[$seme_class[$stud_id]]);
		if ($i % 12 ==0 || $i==$all) 
			//$temp_str.="<table:table-row table:style-name=\"chart1.2\"><table:table-cell table:style-name=\"chart1.A3\" table:value-type=\"string\"><text:p text:style-name=\"P5\">".$c[0]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.B3\" table:value-type=\"string\"><text:p text:style-name=\"P5\">".$c[1]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.B3\" table:value-type=\"string\"><text:p text:style-name=\"P5\">".$seme_num[$stud_id]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.D3\" table:value-type=\"string\"><text:p text:style-name=\"P6\">".$stud_name[$stud_id]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.D3\" table:value-type=\"string\"><text:p text:style-name=\"P6\">".$res->fields[reward_reason]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.D3\" table:value-type=\"string\"><text:p text:style-name=\"P6\">".$res->fields[reward_base]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.D3\" table:value-type=\"string\"><text:p text:style-name=\"P6\">".$reward_arr[$reward_kind]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.H3\" table:value-type=\"string\"><text:p text:style-name=\"P6\"/></table:table-cell></table:table-row>";
			$temp_str.="<table:table-row table:style-name=\"chart1.2\"><table:table-cell table:style-name=\"chart1.A2\" table:value-type=\"string\"><text:p text:style-name=\"P5\">".$c[0]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.B2\" table:value-type=\"string\"><text:p text:style-name=\"P5\">".$c[1]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.C2\" table:value-type=\"string\"><text:p text:style-name=\"P5\">".$seme_num[$stud_id]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.D2\" table:value-type=\"string\"><text:p text:style-name=\"P4\">".$stud_name[$stud_id]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.E2\" table:value-type=\"string\"><text:p text:style-name=\"P4\">".$res->fields[reward_date]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.F2\" table:value-type=\"string\"><text:p text:style-name=\"P4\">".$res->fields[reward_reason]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.G2\" table:value-type=\"string\"><text:p text:style-name=\"P4\">".$res->fields[reward_base]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.H2\" table:value-type=\"string\"><text:p text:style-name=\"P4\">".$reward_arr[$reward_kind]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.I2\" table:value-type=\"string\"><text:p text:style-name=\"P4\"/></table:table-cell></table:table-row>";
		else
			//$temp_str.="<table:table-row table:style-name=\"chart1.2\"><table:table-cell table:style-name=\"chart1.A2\" table:value-type=\"string\"><text:p text:style-name=\"P5\">".$c[0]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.B2\" table:value-type=\"string\"><text:p text:style-name=\"P5\">".$c[1]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.B2\" table:value-type=\"string\"><text:p text:style-name=\"P5\">".$seme_num[$stud_id]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.D2\" table:value-type=\"string\"><text:p text:style-name=\"P6\">".$stud_name[$stud_id]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.D2\" table:value-type=\"string\"><text:p text:style-name=\"P6\">".$res->fields[reward_reason]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.D2\" table:value-type=\"string\"><text:p text:style-name=\"P6\">".$res->fields[reward_base]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.D2\" table:value-type=\"string\"><text:p text:style-name=\"P6\">".$reward_arr[$reward_kind]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.H2\" table:value-type=\"string\"><text:p text:style-name=\"P6\"/></table:table-cell></table:table-row>";
			$temp_str.="<table:table-row table:style-name=\"chart1.2\"><table:table-cell table:style-name=\"chart1.A2\" table:value-type=\"string\"><text:p text:style-name=\"P5\">".$c[0]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.B2\" table:value-type=\"string\"><text:p text:style-name=\"P5\">".$c[1]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.C2\" table:value-type=\"string\"><text:p text:style-name=\"P5\">".$seme_num[$stud_id]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.D2\" table:value-type=\"string\"><text:p text:style-name=\"P4\">".$stud_name[$stud_id]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.E2\" table:value-type=\"string\"><text:p text:style-name=\"P4\">".$res->fields[reward_date]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.F2\" table:value-type=\"string\"><text:p text:style-name=\"P4\">".$res->fields[reward_reason]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.G2\" table:value-type=\"string\"><text:p text:style-name=\"P4\">".$res->fields[reward_base]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.H2\" table:value-type=\"string\"><text:p text:style-name=\"P4\">".$reward_arr[$reward_kind]."</text:p></table:table-cell><table:table-cell table:style-name=\"chart1.I2\" table:value-type=\"string\"><text:p text:style-name=\"P4\"/></table:table-cell></table:table-row>";
		$i++;
		$res->MoveNext();
	}


	// change_temp �|�N�}�C���� big5 �ର UTF-8 �� openoffice �i�HŪ�X
	//$data.=iconv("Big5","UTF-8",$temp_str)."</table:table><text:p text:style-name=\"P7\"/></office:body></office:document-content>";

 //2013.06.20 �Q�� function �B�z, �קK iconv �J���ण�X�Ӫ��r�N�d�����D,  by smallduh.
    $data.=big52utf8($temp_str)."</table:table><text:p text:style-name=\"P7\"/></office:body></office:document-content>";
	// �[�J content.xml ��zip ��
	$ttt->add_file($data,"content.xml");

	//���� zip ��
	$sss = & $ttt->file();

	//�H��y�覡�e�X ooo.sxw
	$fl="chart_".$sel_year."_".$sel_seme."_".$week_num;
	header("Content-disposition: attachment; filename=$fl.sxw");
	header("Content-type: application/octetstream");
	//header("Pragma: no-cache");
					//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
header("Expires: 0");

	echo $sss;

	exit;	
	
	
 //2013.06.20 �Q�� function �B�z, �קK iconv �J���ण�X�Ӫ��r�N�d�����D,  by smallduh.
	function big52utf8($big5str) {  
		$blen = strlen($big5str);  
		$utf8str = "";   
		for($i=0; $i<$blen; $i++) {
			     $sbit = ord(substr($big5str, $i, 1));    
			     if ($sbit < 129) {      
			     		$utf8str.=substr($big5str,$i,1);    
			     	}elseif ($sbit > 128 && $sbit < 255) { 
			      	$new_word = iconv("big5", "UTF-8", substr($big5str,$i,2));
			      	$utf8str.=($new_word=="")?"o":$new_word;
			         $i++;
			     }
	  }
 
    return $utf8str;
  } // end function
	
?>
