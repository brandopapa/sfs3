<?php

//$Id: chc_seme.php 5310 2009-01-10 07:57:56Z hami $

//ini_set('display_errors', '1');
//ini_set('output_buffering', '1');

include "config.php";
include "chc_func_class.php";
include_once "../../include/sfs_case_excel.php";

//�{��
sfs_check();
chk_login('�аȳB');

//�إߪ���
$obj= new chc_seme($CONN,$smarty);

//�P�O�ꤤ6/��p0 �ܼ�
$obj->IS_JHORES=$IS_JHORES;

//��ܤ��e
if(isset($_POST) and count($_POST)>0){
	//$obj->debug_msg("��".__LINE__."�� _POST ", $_POST);
	ob_clean();
	$aa=curr_year();
	$bb=curr_seme();
	//$obj->all();
	if($_POST[basic_excel]=='�ץXEXCEL(��k1)'){
		get_stud_data($aa,'excel');
	}elseif($_POST[basic_excel_2]=='�ץXEXCEL(��k2)'){
		get_stud_data($aa,'excel_2');
	}elseif($_POST[chc_excel]=='�ץXEXCEL(��k1)'){ //���ƿ����
		output_excel($obj,'chc','excel');
	}elseif($_POST[chc_excel_2]=='�ץXEXCEL(��k2)'){  //���ƿ����
		output_excel($obj,'chc','excel_2');
	}elseif($_POST[basic_txt]=='�ץXTXT'){
		get_stud_data($aa,'txt');
//	}elseif($_POST[chc_txt]=='�ץXTXT'){  //���ƿ����
//		get_chc_data($aa);
	}elseif($_POST[chc_excel_103]=='�ץXEXCEL'){  //���ƿ����103�~
		get_chc_data_103year($aa,$obj);
	}
}

function output_excel($obj,$kind, $output_type) {
	global $smarty,$SFS_PATH; 

	$obj->all();

	//$obj->debug_msg("��".__LINE__."�� this->sch ", $this->sch);
	//$obj->debug_msg("��".__LINE__."�� this->stu ", $this->stu);
	//$obj->debug_msg("��".__LINE__."�� kind ", $kind);
	//$obj->debug_msg("��".__LINE__."�� output_type ", $output_type);
	$mem=0;
	if($kind=='chc'){
		foreach($obj->stu as $key=>$val){
			//�~�w�A�Ȥ��Ƴ̰�20��
            $score_morality=$val['score_service']+$val['score_reward']+$val['score_fault'];
			if($score_morality>20){
				$score_morality=20;
			}
			//�Z�u��{���Ƴ̰�16��
            $score_display=$val['score_balance']+$val['score_race']+$val['score_physical'];
			if($score_display>16){
				$score_display=16;
			}
			if($output_type=='excel'){
				$data1[$mem][stud_name]=$val[stud_name];
				$data1[$mem][stud_person_id]=$val[stud_person_id];
				$data1[$mem][birth_year]=intval($val[birth_year]);
				$data1[$mem][birth_month]=intval($val[birth_month]);
				$data1[$mem][birth_day]=intval($val[birth_day]);
				$data1[$mem][income]=$val[income];
				$data1[$mem][score_nearby]=$val[score_nearby];
				$data1[$mem][score_service]=$val[score_service]; //�A�Ⱦǲ�
				$data1[$mem][score_reward]=$val[score_reward];  //���y����
				$data1[$mem][score_fault]=$val[score_fault];   //�ͬ��Ш|
                $data1[$mem][score_morality]=$score_morality;    //�~�w�A��
				$data1[$mem][score_balance]=$val[score_balance];  //���žǲ�
				$data1[$mem][score_race]=$val[score_race];   //�v�ɪ�{
				$data1[$mem][score_physical]=$val[score_physical];   //��A��
                $data1[$mem][score_display]=$score_display;    //�Z�u��{
			}elseif($output_type=='excel_2'){
				//102.10.28�_�ĥ�xls�ץX�覡�A��z��ƶ���
				$data1[$mem][]=$val[stud_name];
				$data1[$mem][]=$val[stud_person_id];
				$data1[$mem][]=intval($val[birth_year]);
				$data1[$mem][]=intval($val[birth_month]);
				$data1[$mem][]=intval($val[birth_day]);
				$data1[$mem][]=$val[income];
				$data1[$mem][]=$val[score_nearby];
				$data1[$mem][]=$val[score_service];
				$data1[$mem][]=$val[score_reward];
				$data1[$mem][]=$val[score_fault];
                $data1[$mem][]=$score_morality;    //�~�w�A��
				$data1[$mem][]=$val[score_balance];
				$data1[$mem][]=$val[score_race];
				$data1[$mem][]=$val[score_physical];
                $data1[$mem][]=$score_display;    //�Z�u��{
			}
			$mem++;
		}

	}elseif($kind=='basic'){
		$filename ="basic_export.xls" ;
	}
	//$obj->debug_msg("��".__LINE__."�� data1 ", $data1);
//die();
	if($output_type=='excel'){
		$filename ="chc_export_1.xls" ;
		ob_clean();
		header("Content-disposition: filename=$filename");
		header("Content-type: application/octetstream");
		header("Pragma: no-cache");
		header("Expires: 0");

	    //�ϥμ˪�
	    $template_dir = $SFS_PATH."/".get_store_path()."/templates";
	    // �ϥ� smarty tag
	    $smarty->left_delimiter="{{";
	    $smarty->right_delimiter="}}";
	    //$smarty->debugging = true;
	    $smarty->assign("data_array",$data1);
	    $smarty->assign("template_dir",$template_dir);
	    if($kind=='chc'){
	    	$smarty->display("$template_dir/chc_excel.htm");
		}
	}elseif($output_type=='excel_2'){
		//102.10.28�_�ĥ�xls�ץX�覡
		$filename ="chc_export_2.xls" ;
		$myhead1=array('�ǥͩm�W','�����ҲΤ@�s��','�X�ͦ~(����~)','�X�ͤ�','�X�ͤ�','�g�ٮz��','�N��J��','�A�Ⱦǲ�','���y����','�ͬ��Ш|','�~�w�A��','���žǲ�','�v�ɪ�{','��A��','�Z�u��{');

		$x=new sfs_xls();
		$x->setUTF8();//$x->setVersion(8);
		$x->setBorderStyle(1);
		$x->filename=$filename;
		$x->setRowText($myhead1);
		$x->addSheet("year".$aa);
		$x->items=$data1;
		$x->writeSheet();
		$x->process();
	}
	exit;


}



//�ǥͰ򥻸��
function get_stud_data($year,$kind){
	global $CONN,$school_sshort_name,$obj,$smarty,$SFS_PATH;

//�d�߱o�h��
	$sql_select="select c.sch_id,a.stud_id,a.curr_class_num,a.stud_name,a.stud_person_id,a.stud_sex,a.stud_birthday, b.graduation,b.kind_id,b.special,b.income,b.unemployed, d.guardian_name,a.stud_tel_2,a.stud_tel_3,a.addr_zip,a.stud_addr_2
               from chc_basic12 b 
               left join stud_base a on a.student_sn = b.student_sn 
               left join stud_domicile d on a.student_sn = d.student_sn,school_base c
               where b.academic_year=".$year." order by a.curr_class_num";
               //echo "<br>".__LINE__."<br>".$sql_select."<br>";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
  //�Ǹ�    
	$i = 0;
	$mem=0;
	while( list($sch_id,$stud_id,$curr_class_num,$stud_name,$stud_person_id,$stud_sex,$stud_birthday,$graduation,$kind_id,$special,$income,$unemployed,$guardian_name,$stud_tel_2,$stud_tel_3,$addr_zip,$stud_addr_2)=$recordSet->FetchRow() ){
	    //1.�a�ϥN�X�A2�X�A���Ƭ�08
	    $area = "08";
	
	    //2.�������A6�X�A�a�k�A����������0
	    $sch_id = sprintf('%06s',$sch_id);
	    
	    //3.�Ǹ��A5�X�A�a�k�A����������0
	    $i++;
	    $sn_excel=$i;
	    $sn = sprintf("%05s",$i);
	    
	    //4.�Ǹ��A8�X�A�a���A�����k���ɥb�Ϊť�
	    $stud_id_excel = $stud_id;
	    $stud_id = sprintf("%-8s",$stud_id);
	    
	    //5.�Z�šA2�X, �a�k�A����������0
	    $class = substr($curr_class_num,1,2);
	    
	    //6.�y���A2�X�A�a�k�A����������0
	    $num = substr($curr_class_num,3,2);
	    
	    //7.�m�W�h�ťաA�b�ΩM����
	    $stud_name = str_replace(" ","",$stud_name);
	    $stud_name = str_replace("�@","",$stud_name);
	    
	    //�m�W�@�n30�X�A�a���A�����ɥb�Ϊť�
	    $stud_name = sprintf("%-30s",$stud_name);
	    
	    //8.�����ҭ��r�n�j�g�A�@�n10�X�A������*
	    $stud_person_id = sprintf("%-'*10s",strtoupper($stud_person_id));
	    
	    //9.�ʧO1�X$stud_sex
	    
	    //�ͤ��~���A10.�~3�X�A11.��2�X�A12.��2�X
	    $birth_date = explode("-",$stud_birthday);
	    $birth_year = sprintf("%03s",$birth_date[0]-1911);
	    $birth_mon = sprintf("%02s",$birth_date[1]);
	    $birth_day = sprintf("%02s",$birth_date[2]);
	    
	    //13.���~�ǮեN�X$sch_id�A6�X�A�P�������P    
	    //14.���~�~��$year�A����~3�X    
	    //15.���w�~��$graduation�A1�X    
	    //16.�ǥͨ�����$kind_id�A1�X    
	    //17.���߻�ê��$special�A1�X
	        
	    //18.�N�ǰϡA2�X�A�d2��b�Ϊť�
	    $stu_area = "  ";
	    
	    //19.�C���J���20.���C���J��U1�X
	    if($income == 0){
	      $low_income = 0;
	      $mlow_income = 0;
	    }elseif($income == 1){
	      $low_income = 0;
	      $mlow_income = 1;
	    }elseif($income ==2){
	      $low_income = 1;
	      $mlow_income = 0;
	    }
    
	    //21.���~�H1�X$unemployed
	    
	    //22.��Ʊ��v�A1�X�A�����n�P�N���v
	    $authorize = "1";
	    
	    //23.�a���m�W�h�ťաA�b�ΩM����
	    $guardian_name = str_replace(" ","",$guardian_name);
	    $guardian_name = str_replace("�@","",$guardian_name);
	    
	    //�a���m�W�@�n30�X�A�����ɥb�ΪťաA�a���A�����ɥb�Ϊť�
	    $guardian_name = sprintf("%-30s",$guardian_name);
	    
	    //24.�Ǥ��q��14�X�A�[�ϽX�A�a���A�����ɪťաH�H
	    //�h�ťթM�A���M�
	    $stud_tel_2 = str_replace(" ","",$stud_tel_2);
	    $stud_tel_2 = str_replace("-","",$stud_tel_2);
	    $stud_tel_2 = str_replace("(","",$stud_tel_2);
	    $stud_tel_2 = str_replace(")","",$stud_tel_2);
	    
	     //�Y�d�Ǥ��q�ܪ�(9�X�H�U�A�]���m�q�ܦ�8�X)�A��04
	    if(strlen($stud_tel_2)<9 and strlen($stud_tel_2)>0){
	      $stud_tel_2 = sprintf("%-14s","04".$stud_tel_2);
	    }else{
	      $stud_tel_2 = sprintf("%-14s",$stud_tel_2);
	    }
	    
	    //25.��ʹq��14�X�A�a���A�����ɪťաH�H
	    $stud_tel_3 = str_replace(" ","",$stud_tel_3);
	    $stud_tel_3 = str_replace("-","",$stud_tel_3);
	    $stud_tel_3 = str_replace("(","",$stud_tel_3);
	    $stud_tel_3 = str_replace(")","",$stud_tel_3);
	    //����ʹq�ܫe10�X�A�]���������Q��W����ʹq��
	    $stud_tel_3 = substr($stud_tel_3,0,10);
	    $stud_tel_3 = sprintf("%-14s",$stud_tel_3);
	    
	    //26.�l���ϸ��A���e3�X�A������W5�X�A�a���A�����ɪťաH�H
	    $addr_zip = substr($addr_zip,0,3);
	    $addr_zip = sprintf("%-3s",$addr_zip);
	    
	    //27.�a�}80�X�A�a���A�����ɪťաH�H�Ʀr�H�b�Ϊ��ԧB�Ʀr��ܡH(�Ȥ��z)    
	    $stud_addr_2 = sprintf("%-80s",$stud_addr_2);
	                                  
	    if($kind=='txt'){
			$all_data.=  $area." ".$sch_id." ".$sn." ".$stud_id." ".$class." ".$num." ".$stud_name." ".$stud_person_id." ".$stud_sex." ".$birth_year." ".$birth_mon." ".$birth_day." ".$sch_id." ".$year." ".$graduation." ".$kind_id." ".$special." ".$stu_area." ".$low_income." ".$mlow_income." ".$unemployed." ".$authorize." ".$guardian_name." ".$stud_tel_2." ".$stud_tel_3." ".$addr_zip." ".$stud_addr_2."\r\n";
    	}elseif($kind=='excel'){
	    	$all_data[$mem]['area']=$area;
	    	$all_data[$mem]['sch_id']=$sch_id;
	    	$all_data[$mem]['sn']=$sn_excel;
	    	$all_data[$mem]['stud_id']=$stud_id_excel;
	    	$all_data[$mem]['class']=$class;
	    	$all_data[$mem]['num']=$num;
	    	$all_data[$mem]['stud_name']=$stud_name;
	    	$all_data[$mem]['stud_person_id']=$stud_person_id;
	    	$all_data[$mem]['stud_sex']=$stud_sex;
	    	$all_data[$mem]['birth_year']=$birth_year;
	    	$all_data[$mem]['birth_mon']=$birth_mon;
	    	$all_data[$mem]['birth_day']=$birth_day;
	    	$all_data[$mem]['sch_id']=$sch_id;
	    	$all_data[$mem]['year']=$year;
	    	$all_data[$mem]['graduation']=$graduation;
	    	$all_data[$mem]['kind_id']=$kind_id;
	    	$all_data[$mem]['special']=$special;
	    	$all_data[$mem]['stu_area']=$stu_area;
	    	$all_data[$mem]['low_income']=$low_income;
	    	$all_data[$mem]['mlow_income']=$mlow_income;
	    	$all_data[$mem]['unemployed']=$unemployed;
	    	$all_data[$mem]['authorize']=$authorize;
	    	$all_data[$mem]['guardian_name']=$guardian_name;
	    	$all_data[$mem]['stud_tel_2']=$stud_tel_2;
	    	$all_data[$mem]['stud_tel_3']=$stud_tel_3;
	    	$all_data[$mem]['addr_zip']=$addr_zip;
	    	$all_data[$mem]['stud_addr_2']=$stud_addr_2;
		}elseif($kind=='excel_2'){
	    	$all_data[$mem][]=$area;
	    	$all_data[$mem][]=$sch_id;
	    	$all_data[$mem][]=$sn_excel;
	    	$all_data[$mem][]=$stud_id_excel;
	    	$all_data[$mem][]=$class;
	    	$all_data[$mem][]=$num;
	    	$all_data[$mem][]=$stud_name;
	    	$all_data[$mem][]=$stud_person_id;
	    	$all_data[$mem][]=$stud_sex;
	    	$all_data[$mem][]=$birth_year;
	    	$all_data[$mem][]=$birth_mon;
	    	$all_data[$mem][]=$birth_day;
	    	$all_data[$mem][]=$sch_id;
	    	$all_data[$mem][]=$year;
	    	$all_data[$mem][]=$graduation;
	    	$all_data[$mem][]=$kind_id;
	    	$all_data[$mem][]=$special;
	    	$all_data[$mem][]=$stu_area;
	    	$all_data[$mem][]=$low_income;
	    	$all_data[$mem][]=$mlow_income;
	    	$all_data[$mem][]=$unemployed;
	    	$all_data[$mem][]=$authorize;
	    	$all_data[$mem][]=$guardian_name;
	    	$all_data[$mem][]=$stud_tel_2;
	    	$all_data[$mem][]=$stud_tel_3;
	    	$all_data[$mem][]=$addr_zip;
	    	$all_data[$mem][]=$stud_addr_2;
		}
			$mem++;
	};
  	//echo "<pre>";
	//print_r($all_data);
	//die();
	if($kind=='txt'){
		$filename=$year."�Ǧ~".$school_sshort_name."�K�դJ�ǾǥͰ򥻸��.txt";
		header("Content-disposition: attachment;filename=$filename");
		header("Content-type: text/txt ; Charset=Big5");
		header("Pragma: no-cache");
		header("Expires: 0");

		echo $all_data;
	}elseif($kind=='excel'){
		$filename ="basic_export_1.xls" ;
		//�ϥμ˪�
	    $template_dir = $SFS_PATH."/".get_store_path()."/templates";

		ob_clean();
		header("Content-disposition: filename=$filename");
		header("Content-type: application/octetstream");
		header("Pragma: no-cache");
		header("Expires: 0");

	    // �ϥ� smarty tag
	    $smarty->left_delimiter="{{";
	    $smarty->right_delimiter="}}";
	    //$smarty->debugging = true;
	    $smarty->assign("data_array",$all_data);
	    $smarty->assign("template_dir",$template_dir);
	    $smarty->display("$template_dir/basic_excel.htm");
	}elseif($kind=='excel_2'){
		$filename ="basic_export_2.xls" ;
		//102.10.28�_�ĥ�xls�ץX�覡
		$myhead=array("�a�ϥN�X","�������N�X","�Ǹ�","�Ǹ�","�Z��","�y��","�ǥͩm�W","������","�ʧO","�X�ͦ~(����~)","�X�ͤ�","�X�ͤ�","���~�ǮեN�X","���~�~(����~)","���w�~","�ǥͨ���","���߻�ê","�N�ǰ�","�C���J��","���C���J��","���~�Ҥu","��Ʊ��v","�a���m�W","�����q��","��ʹq��","�l���ϸ�","�a�}");
		//include_once "../../include/sfs_case_excel.php";
		$x=new sfs_xls();
		$x->setUTF8();//$x->setVersion(8);
		$x->setBorderStyle(1);
		$x->filename=$filename;
		$x->setRowText($myhead);
		$x->addSheet("year".$year);
		$x->items=$all_data;
		$x->writeSheet();

		$x->process();
	}
	exit;
}

//���ƿ�����
function get_chc_data($year){
  global $CONN,$school_sshort_name;
//�d�߱o�h��
  $sql_select="select a.curr_class_num,a.stud_name,a.stud_person_id,a.stud_birthday,b.income,b.score_nearby,b.score_service,b.score_reward,b.score_fault,b.score_balance,b.score_race,b.score_physical 
               from chc_basic12 b left join stud_base a on a.student_sn = b.student_sn where b.academic_year=".$year." order by a.curr_class_num";
               //echo "<br>".__LINE__."<br>".$sql_select."<br>";
  $recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
  while( list($curr_class_num,$stud_name,$stud_person_id,$stud_birthday,$income,$score_nearby,$score_service,$score_reward,$score_fault,$score_balance,$score_race,$score_physical)=$recordSet->FetchRow() ){
    //�|����J��ƪ̡A���ƼȬ�0
    if(empty($score_service)) $score_service = "0";
    if(empty($score_reward)) $score_reward = "0";
    if(empty($score_fault)) $score_fault = "0";
    if(empty($score_balance)) $score_balance = "0";
    if(empty($score_race)) $score_race = "0";
    if(empty($score_physical)) $score_physical = "0";
    
    //1.�m�W�h�ťաA�b�ΩM����
    $stud_name = str_replace(" ","",$stud_name);
    $stud_name = str_replace("�@","",$stud_name);
    
    //�m�W�@�n30�X�A�����ɥb�Ϊť�
    $stud_name = sprintf("%-30s",$stud_name);
    
    //2.�����ҭ��r�n�j�g�A�@�n10�줸�A������*
    $stud_person_id = sprintf("%-'*10s",strtoupper($stud_person_id));
    
    //�ͤ��~���A3.�~3�X�A4.��2�X�A5.��2�X
    $birth_date = explode("-",$stud_birthday);
    $birth_year = sprintf("%03s",$birth_date[0]-1911);
    $birth_mon = sprintf("%02s",$birth_date[1]);
    $birth_day = sprintf("%02s",$birth_date[2]);
    
    //6.�g�ٮz��1�X$income
    //7.�N��J��1�X$score_nearby
    
    //8.�A�Ⱦǲߤp�ƫ�@��A�@3�X�A�Y����ơA��.0
    $score_service = sprintf("%.1f",$score_service);
    
    //9.���y�����p�ƫ�@��A�@3�X�A�Y����ơA��.0
    $score_reward = sprintf("%.1f",$score_reward);
    
    //10.�ͬ��Ш|1�X$score_fault
    //11.���žǲ�1�X$score_balance
    //12.�v�ɪ�{�A�@3�X�A�Y����ơA��.0
    $score_race = sprintf("%.1f",$score_race);
    
    //13.��A��1�X$score_physical
                           //1.�ǥͩm�W        2.������                   3.�X�ͦ~            4.�X�ͤ�           5.�X�ͤ�           6.�g�ٮz��    7.�N��J��              8.�A�Ⱦǲ�                9.���y����             10.�ͬ��Ш|         11.���žǲ�             12.�v�ɪ�{         13.��A��
      $all_data.=  $stud_name." ".$stud_person_id." ".$birth_year." ".$birth_mon." ".$birth_day." ".$income." ".$score_nearby." ".$score_service." ".$score_reward." ".$score_fault." ".$score_balance." ".$score_race." ".$score_physical."\r\n";
  };
//print_r($all_data);
//die();
  $filename=$year."�Ǧ~".$school_sshort_name."�K�դJ�Ǥ�Ǹ��.txt";
  header("Content-disposition: attachment;filename=$filename");
  header("Content-type: text/txt ; Charset=Big5");
  header("Pragma: no-cache");
  header("Expires: 0");

  echo $all_data;
  exit;
}


//103�Ǧ~�׹��ưϰ��Ť����ǮէK�դJ�Ǥ��o�ǥ͸��
function get_chc_data_103year($year, $obj){
	global $CONN,$school_sshort_name;

	//���~�~=�Ǧ~��+1
	$grad_year=sprintf("%03d",$year+1);

//���o�Ĥ@�������(�򥻸��)
	$sql_select="select c.sch_id,a.stud_id,a.curr_class_num,a.stud_name,a.stud_person_id,a.stud_sex,a.stud_birthday, b.graduation,b.kind_id,b.special,b.income,b.unemployed, d.guardian_name,a.stud_tel_1,a.stud_tel_3,a.addr_zip,a.stud_addr_2
               from chc_basic12 b 
               left join stud_base a on a.student_sn = b.student_sn 
               left join stud_domicile d on a.student_sn = d.student_sn,school_base c
               where b.academic_year=".$year." order by a.curr_class_num";
               //echo "<br>".__LINE__."<br>".$sql_select."<br>";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
  //�Ǹ�    
	$i=0;
	while( list($sch_id,$stud_id,$curr_class_num,$stud_name,$stud_person_id,$stud_sex,$stud_birthday,$graduation,$kind_id,$special,$income,$unemployed,$guardian_name,$stud_tel_2,$stud_tel_3,$addr_zip,$stud_addr_2)=$recordSet->FetchRow() ){
	    //1.�a�ϥN�X�A2�X�A���Ƭ�08
	    $area = "08";

	    //2.�������A6�X�A�a�k�A����������0
	    $sch_id = sprintf('%06s',$sch_id);
	    
	    //3.�Ǹ��A5�X�A�a�k�A����������0
	    $i++;
	    $sn_excel=$i;
	    $sn = sprintf("%05s",$i);
	    
	    //4.�Ǹ��A8�X�A�a���A�����k���ɥb�Ϊť�
	    $stud_id_excel = $stud_id;
	    $stud_id = sprintf("%-8s",$stud_id);
	    
	    //5.�Z�šA2�X, �a�k�A����������0
	    $class = substr($curr_class_num,1,2);
	    
	    //6.�y���A2�X�A�a�k�A����������0
	    $num = substr($curr_class_num,3,2);
	    
	    //7.�m�W�h�ťաA�b�ΩM����
	    $stud_name = str_replace(" ","",$stud_name);
	    $stud_name = str_replace("�@","",$stud_name);
	    
	    //�m�W�@�n30�X�A�a���A�����ɥb�Ϊť�
	    $stud_name = sprintf("%-30s",$stud_name);
	    
	    //8.�����ҭ��r�n�j�g�A�@�n10�X�A������*
	    $stud_person_id = sprintf("%-'*10s",strtoupper($stud_person_id));
	    
	    //9.�ʧO1�X$stud_sex
	    
	    //�ͤ��~���A10.�~2�X�A11.��2�X�A12.��2�X
	    $birth_date = explode("-",$stud_birthday);
	    $birth_year = sprintf("%02s",$birth_date[0]-1911);
	    $birth_mon = sprintf("%02s",$birth_date[1]);
	    $birth_day = sprintf("%02s",$birth_date[2]);
	    
	    //13.���~�ǮեN�X$sch_id�A6�X�A�P�������P    
	    //14.���~�~��$grad_year�A����~3�X    
	    //15.���w�~��$graduation�A1�X    
	    //16.�ǥͨ�����$kind_id�A1�X    
	    //17.���߻�ê��$special�A1�X
	        
	    //18.�N�ǰϡA2�X�A�d2��b�Ϊť�
	    $stu_area = "  ";
	    
	    //19.�C���J���20.���C���J��U1�X
	    if($income == 0){
	      $low_income = 0;
	      $mlow_income = 0;
	    }elseif($income == 1){
	      $low_income = 0;
	      $mlow_income = 1;
	    }elseif($income ==2){
	      $low_income = 1;
	      $mlow_income = 0;
	    }
    
	    //21.���~�H1�X$unemployed
	    
	    //22.��Ʊ��v�A1�X�A�����n�P�N���v
	    $authorize = "1";
	    
	    //23.�a���m�W�h�ťաA�b�ΩM����
	    $guardian_name = str_replace(" ","",$guardian_name);
	    $guardian_name = str_replace("�@","",$guardian_name);
	    
	    //�a���m�W�@�n30�X�A�����ɥb�ΪťաA�a���A�����ɥb�Ϊť�
	    $guardian_name = sprintf("%-30s",$guardian_name);
	    
	    //24.�Ǥ��q��14�X�A�[�ϽX�A�a���A�����ɪťաH�H
	    //�h�ťթM�A���M�
	    $stud_tel_2 = str_replace(" ","",$stud_tel_2);
	    $stud_tel_2 = str_replace("-","",$stud_tel_2);
	    $stud_tel_2 = str_replace("(","",$stud_tel_2);
	    $stud_tel_2 = str_replace(")","",$stud_tel_2);
	    
	     //�Y�d�Ǥ��q�ܪ�(9�X�H�U�A�]���m�q�ܦ�8�X)�A��04
	    if(strlen($stud_tel_2)<9 and strlen($stud_tel_2)>0){
	      $stud_tel_2 = sprintf("%-14s","04".$stud_tel_2);
	    }else{
	      $stud_tel_2 = sprintf("%-14s",$stud_tel_2);
	    }
	    
	    //25.��ʹq��14�X�A�a���A�����ɪťաH�H
	    $stud_tel_3 = str_replace(" ","",$stud_tel_3);
	    $stud_tel_3 = str_replace("-","",$stud_tel_3);
	    $stud_tel_3 = str_replace("(","",$stud_tel_3);
	    $stud_tel_3 = str_replace(")","",$stud_tel_3);
	    //����ʹq�ܫe10�X�A�]���������Q��W����ʹq��
	    $stud_tel_3 = substr($stud_tel_3,0,10);
	    $stud_tel_3 = sprintf("%-14s",$stud_tel_3);
	    
	    //26.�l���ϸ��A���e3�X�A������W5�X�A�a���A�����ɪťաH�H
	    $addr_zip = substr($addr_zip,0,3);
	    $addr_zip = sprintf("%-3s",$addr_zip);
	    
	    //27.�a�}80�X�A�a���A�����ɪťաH�H�Ʀr�H�b�Ϊ��ԧB�Ʀr��ܡH(�Ȥ��z)    
	    $stud_addr_2 = sprintf("%-80s",$stud_addr_2);
		$mem=$stud_person_id;                    
    	$all_data[$mem][]=$area;
    	$all_data[$mem][]=$sch_id;
    	$all_data[$mem][]=$sn_excel;
    	$all_data[$mem][]=$stud_id_excel;
    	$all_data[$mem][]=$class;
    	$all_data[$mem][]=$num;
    	$all_data[$mem][]=$stud_name;
    	$all_data[$mem][]=$stud_person_id;
    	$all_data[$mem][]=$stud_sex;
    	$all_data[$mem][]=$birth_year;
    	$all_data[$mem][]=$birth_mon;
    	$all_data[$mem][]=$birth_day;
    	$all_data[$mem][]=$sch_id;
    	$all_data[$mem][]=$grad_year;
    	$all_data[$mem][]=$graduation;
    	$all_data[$mem][]=$kind_id;
    	$all_data[$mem][]=$special;
    	$all_data[$mem][]=$stu_area;
    	$all_data[$mem][]=$low_income;
    	$all_data[$mem][]=$mlow_income;
    	$all_data[$mem][]=$unemployed;
    	$all_data[$mem][]=$authorize;
    	$all_data[$mem][]=$guardian_name;
    	$all_data[$mem][]=$stud_tel_2;
    	$all_data[$mem][]=$stud_tel_3;
    	$all_data[$mem][]=$addr_zip;
    	$all_data[$mem][]=$stud_addr_2;
	};




//���o�ĤG�������(���ƿ��M�ݸ��)
	$obj->all();
	foreach($obj->stu as $key=>$val){
    	//�~�w�A�Ȥ��Ƴ̰�20��
        $score_morality=$val['score_service']+$val['score_reward']+$val['score_fault'];
		if($score_morality>20){
			$score_morality=20;
		}
		//�Z�u��{���Ƴ̰�16��
        $score_display=$val['score_balance']+$val['score_race']+$val['score_physical'];
		if($score_display>16){
			$score_display=16;
		}
		$stud_person_id=$val[stud_person_id];
		$mem=$stud_person_id;
		//$data1[$mem][]=$val[stud_name];
		//$data1[$mem][]=$val[stud_person_id];
		//$data1[$mem][]=intval($val[birth_year]);
		//$data1[$mem][]=intval($val[birth_month]);
		//$data1[$mem][]=intval($val[birth_day]);
		//$result = array_merge((array)$beginning, (array)$end);
		$data1[$mem]=$all_data[$mem];
		$data1[$mem][]='';
		$data1[$mem][]='';
		$data1[$mem][]=$val[income];
		$data1[$mem][]=$val[score_nearby];
		$data1[$mem][]=$val[score_service];
		$data1[$mem][]=$val[score_reward];
		$data1[$mem][]=$val[score_fault];
		$data1[$mem][]=$score_morality;   //�~�w�A�Ȥ���
		$data1[$mem][]=$val[score_balance];
		$data1[$mem][]=$val[score_race];
		$data1[$mem][]=$val[score_physical];
        $data1[$mem][]=$score_display;    //�Z�u��{����
		//$mem++;
	}

	//$obj->debug_msg("��".__LINE__."�� data1 ", $data1);


	$filename ="chc_export_".$grad_year.".xls" ;
	//103.03.21�_�ĥ�
	$myhead=array("�ҰϥN�X","�������N�X","�Ǹ�","�Ǹ�","�Z��","�y��","�ǥͩm�W","�����ҲΤ@�s��","�ʧO","�X�ͦ~(����~)","�X�ͤ�","�X�ͤ�","���~�ǮեN�X","���~�~(����~)","���w�~","�ǥͨ���","���߻�ê","�N�ǰ�","�C���J��","���C���J��","���~�Ҥu�l�k","��Ʊ��v","�a���m�W","�����q��","��ʹq��","�l���ϸ�","�q�T�a�}","�����O�_�t���y�{��","�D���إ��ꨭ���Ҹ�","�g�ٮz��","�N��J��","�A�Ⱦǲ�","���y����","�ͬ��Ш|","�~�w�A��","���žǲ�","�v�ɪ�{","��A��","�Z�u��{");
	//include_once "../../include/sfs_case_excel.php";
	$x=new sfs_xls();
	$x->setUTF8();//$x->setVersion(8);
	$x->setBorderStyle(1);
	$x->filename=$filename;
	$x->setRowText($myhead);
	$x->addSheet("year".$grad_year);
	$x->items=$data1;
	$x->writeSheet();

	$x->process();

}


//�q�X�����������Y
head("�ץX���");
print_menu($menu_p);

//���SFS�s�����(���ϥνЮ��}����)

echo make_menu($school_menu_p);


$obj->display();

//�G������
//foot();





//����class

class chc_seme{

	var $CONN;//adodb����

	var $smarty;//smarty����
	var $stu;//�ǥ͸��
	var $subj;//��ذ}�C
	var $rule;//����

	var $Stu_Seme;//�ǥͪ��Ǵ��}�C

	var $IS_JHORES;//�ꤤ�p

	var $year;//�Ǧ~

	var $seme;//�Ǵ�

	var $YS='year_seme';//�U�Ԧ����Ǵ����ڼƦW��

	var $year_seme;//�U�Ԧ����Z�Ū��ڼƭ�

	var $Sclass='class_id';//�U�Ԧ����Z�Ū��ڼƦW��



	//�غc�禡

	function chc_seme($CONN,$smarty){
		global $IS_JHORES;
		$this->CONN=&$CONN;
		$this->smarty=&$smarty;
		$this->IS_JHORES=$IS_JHORES;
		$aa=curr_year();
		$bb=curr_seme();
		$this->YearSeme=$aa.$bb;
		$this->Year=$aa;
	}

	//��l��

	function init() {}

	//�{��


	//�^�����

	function all(){
		$this->sch=get_school_base();
		$this->stu=$this->get_stu();

	}

	//���

	function display(){

		echo '<table  width="100%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#9EBCDD" style="table-layout: fixed;word-wrap:break-word;font-size:10pt">
<tr style="font-size:11pt" bgcolor="#9EBCDD"><td>
	�����G<br>
	1.�ھ��ɮ׳W��Ѥ��W�d�A���ѡuTXT�v�ΡuEXCEL�v��ظ���ɮ榡���ץX�C<br>
	2.�ȶץX�u�{���Ǧ~�סv������ɡC<br>
	3.�Y�z�ϥΡy�ץXEXCEL(��k1)�z�Ҳ��X���ɮפ��e�|���ýX�{�H�A�Ч�Ρy�ץXEXCEL(��k2)�z�Ӳ��X�ɮסA����̪���Ƥ��e�����ۦP�C<br>
	<hr>
	</td></tr></table>';
	echo '<table  width="100%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#9EBCDD" style="table-layout: fixed;word-wrap:break-word;font-size:10pt">
	<tr style="font-size:11pt" bgcolor="#9EBCDD">
	
	<td>'.$this->select.'</td></tr>';
		echo '<tr style="font-size:11pt" bgcolor="#9EBCDD">
	
	<td>';

//  <input type="submit" name="chc_txt" value="�ץXTXT">�@||�@

		echo '<form name="form1" method="post" action="">
     �ǥͰ򥻸����<br>
  <input type="submit" name="basic_txt" value="�ץXTXT">�@||�@ 
  <input type="submit" name="basic_excel" value="�ץXEXCEL(��k1)">
  <input type="submit" name="basic_excel_2" value="�ץXEXCEL(��k2)">
  </form>
<hr>
<form name="form2" method="post" action="">
  ���ƿ��K�դJ�ǶW�B��Ƕ��ؿn�������<br>
  <input type="submit" name="chc_excel" value="�ץXEXCEL(��k1)">
  <input type="submit" name="chc_excel_2" value="�ץXEXCEL(��k2)">
</form>
<hr>
<form name="form2" method="post" action="">
  ���ưϰ��Ť����ǮէK�դJ�Ǥ��o�ǥ͸����<br>
  <font color=red>�����ާ@�B�J</font><br>
  1.�b����ɤ��A�u�����O�_�t���y�{�ҡv�B�u�D���إ��ꨭ���Ҹ��v�����Цۦ��J�C<br>
  2.�N������ɤ��e��ƶK��u���ưϰ��Ť����Ǯճ��W�K�ըt�Υ��O�v���d���ɤ��C<br>
  �@�@��k�G�}�ҶץX�ɡA�u����v->�u�ƻs�v->�u�K�W�v�]�ХΡu��ܩʶK�W�v->�u�ȡv�^�A<br>
  �@�@�A�פJ��u���ưϰ��Ť����Ǯճ��W�K�ըt�Υ��O�v<br>
  

  <input type="submit" name="chc_excel_103" value="�ץXEXCEL">
</form>';
		echo '</td></tr>';
		echo '</table>';

	}



	//����
	function debug_msg($title, $showarry){
		echo "<pre>";
		echo "<br>$title<br>";
		print_r($showarry);
	}

/* ���ǥͰ}�C,����stud_base��Pstud_seme��*/
	function get_stu(){

		$SQL="select a.*, b.*, c.* from stud_base a, stud_seme b, chc_basic12 c  where c.student_sn=a.student_sn and c.student_sn=b.student_sn and c.academic_year='".$this->Year."' and b.seme_year_seme='".$this->YearSeme."' order by b.seme_year_seme asc, a.curr_class_num asc";
		$rs=&$this->CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
		if ($rs->RecordCount()==0) return"�䤣��ǥ͡I";

	    while ($row = $rs->FetchRow() ) {
	    	$tmp_birth=explode('-',$row[stud_birthday]);
	    	$row[birth_year]=$tmp_birth[0]-1911;
	    	$row[birth_month]=$tmp_birth[1];
	    	$row[birth_day]=$tmp_birth[2];
			$Stu_Seme[]=$row;
		}

		return $Stu_Seme;
	}





}

