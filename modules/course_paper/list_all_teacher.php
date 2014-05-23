<?php

// $Id: list_all_teacher.php 7776 2013-11-19 02:35:57Z infodaes $

/* ���o�򥻳]�w�� */
include "config.php";
include "../../include/sfs_oo_zip2.php";

sfs_check();

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

$year_seme=$_GET['year_seme'];

//�Y����ܾǦ~�Ǵ��A�i����Ψ��o�Ǧ~�ξǴ�
if(!empty($year_seme)){
	$ys=explode("-",$year_seme);
	$sel_year=$ys[0];
	$sel_seme=$ys[1];
}

if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�





	

	$sql_select = "select max(sections) as ms  from score_setup where year=$sel_year and semester=$sel_seme  ";

	$recordSet=$CONN->Execute($sql_select) or trigger_error("���~�T���G $sql_select", E_USER_ERROR);
	while (!$recordSet->EOF) {
		$sections= $recordSet->fields["ms"];
        $recordSet->MoveNext();
	}	
	    
	
	if ( $sections>7){ 
	  //$oo_path = "ooo_all_class8";
	  $sections = 8 ;
	}else{    
      //$oo_path = "ooo_all_class";
      $sections = 7 ;
    }  

  $oo_path = "ooo_self";
	$filename="teacher_all_".$sel_year.$sel_seme.".sxw";


	//�s�W�@�� zipfile ���
	$ttt = new EasyZip;
	$ttt->setPath($oo_path);
	$ttt->addDir('META-INF');	
	$ttt->addfile("settings.xml");
	$ttt->addfile("styles.xml");
	$ttt->addfile("meta.xml");



	//Ū�X XML ���Y

	$doc_head = $ttt->read_file(dirname(__FILE__)."/$oo_path/content-h.xml");
	//$doc_head =iconv("Big5","UTF-8",$doc_head);
	//Ū�X XML �ɧ�
	
	$doc_foot = $ttt->read_file(dirname(__FILE__)."/$oo_path/content-e.xml");
	//$doc_foot =iconv("Big5","UTF-8",$doc_foot);
	
	//Ū�X content.xml
	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/content-c.xml");
	//$data =iconv("Big5","UTF-8",$data);
	
	$sql_select = "select teacher_sn  ,year ,semester   from score_course 
	   where year=$sel_year and semester=$sel_seme and teacher_sn <> 0
	   group by teacher_sn   order by teacher_sn  ";
	
	$recordSet=$CONN->Execute($sql_select) or trigger_error("���~�T���G $sql_select", E_USER_ERROR);
	while (list($teacher_sn ,$year ,$semester)= $recordSet->FetchRow()) {	
	     $replace_data .= get_class_sect($teacher_sn  ,$year ,$semester ,$data ) ;
	     //�[�J����
		   $replace_data .="<text:p text:style-name=\"break_page\"/>" ;
	     
	}     
	//�N content.xml �� tag ���N



	// change_temp �|�N�}�C���� big5 �ର UTF-8 �� openoffice �i�HŪ�X
	//$replace_data = $ttt->change_temp($tmp_arr,$data);
	
	//���X�Y��
    $replace_data = $doc_head . $replace_data . $doc_foot;
        
	// �[�J content.xml ��zip ��
	$ttt->add_file($replace_data,"content.xml");
	
	//���� zip ��
	$sss = & $ttt->file();

	//�H��y�覡�e�X ooo.sxw
	header("Content-disposition: attachment; filename=$filename");
	//header("Content-type: application/octetstream");
	header("Content-type: application/vnd.sun.xml.writer");
	//header("Pragma: no-cache");
					//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");

	header("Expires: 0");

	echo $sss;

  exit ;


function get_class_sect($teacher_sn  , $sel_year="",$sel_seme="" ,$data="" ){
	global $CONN,$weekN ,$sections,$midnoon;
    

	//�C�g�����
	$dayn=sizeof($weekN)+1;
    
  $global_classname = get_global_class_name($sel_year,$sel_seme,"�u") ;
	
	$sql_select = "select c.course_id,c.teacher_sn,c.day,c.sector,c.ss_id,c.room ,c.class_id , t.name
	      from score_course c , teacher_base t where c.teacher_sn = t.teacher_sn
          and c.year='$sel_year' and c.semester = '$sel_seme'  and c.teacher_sn  = '$teacher_sn' order by day,sector";
    //echo $sql_select . "<br> " ;
	$recordSet=$CONN->Execute($sql_select) or trigger_error("���~�T���G $sql_select", E_USER_ERROR);
	while (list($course_id,$teacher_sn,$day,$sector,$ss_id,$room ,$class_id , $t_name)= $recordSet->FetchRow()) {
		$k=$day."_".$sector;
		$a[$k]=$ss_id;
		$c[$k] = $global_classname[$class_id] ;
		$r[$k]=$room;
		$teach_name=$t_name ;
	}
	/*
		while (list($course_id,$teacher_sn,$day,$sector,$ss_id,$room)= $recordSet->FetchRow()) {
		$k=$day."_".$sector;
		$a[$k]=$ss_id;
		$b[$k]=$teacher_sn;
		$r[$k]=$room;
	}
	*/
	/*
	for ($w = 1; $w<= $dayn ; $w++) {
	    for ($s=1 ; $s<=$sections ; $s++) {
	        $k=$w ."_". $s;
	    	$tk=$w.$s;
	    	//���M�šA�A���
	    	$temp_arr[$tk]="" ;
	    	$temp_arr[$tk] = substr(get_ss_name("","","�u",$a[$k]),0,4) . "\n" .$c[$k] ;
	    }
	}     	
	*/
  //echo $teach_name ;
	if(!empty($teach_name)){
		//���o�`���ɶ�
		$section_table=section_table($sel_year,$sel_seme);
		//���o�Ҫ�
		for ($j=1;$j<=$sections;$j++){
			//�Y�O�̫�@�C�n�Τ��P���˦�
			$ooo_style=($j==$sections)?"4":"2";
			
			if ($j==$midnoon){
				//�w�]���ȥ�OpenOffice.org���{���X
				$all_class.= "<table:table-row table:style-name=\"course_tbl.3\"><table:table-cell table:style-name=\"course_tbl.A3\" table:number-columns-spanned=\"6\" table:value-type=\"string\"><text:p text:style-name=\"P12\">�ȶ���</text:p></table:table-cell><table:covered-table-cell/><table:covered-table-cell/><table:covered-table-cell/><table:covered-table-cell/><table:covered-table-cell/></table:table-row>";
			}
			
			$all_class.="<table:table-row table:style-name=\"course_tbl.1\"><table:table-cell table:style-name=\"course_tbl.A".$ooo_style."\" table:value-type=\"string\"><text:p text:style-name=\"P8\">�� $j �`</text:p><text:p text:style-name=\"P15\">{$section_table[$j][0]}~{$section_table[$j][1]}</text:p></table:table-cell>";
			//�C�L�X�U�`
			$wn=count($weekN);
			for ($i=1;$i<=$wn;$i++) {
				//�Y�O�̫�@��n�Τ��P���˦�
				$ooo_style2=($i==$wn)?"F":"B";
			
				$k2=$i."_".$j;
				
				$teacher_search_mode=(!empty($tsn) and $tsn==$b[$k2])?true:false;
				//���
				$subject_sel=&get_ss_name("","","�u",$a[$k2]);
				
				//�Z��
				$class_sel=$c[$k2];
				//�C�@��
 		    $all_class.="<table:table-cell table:style-name=\"course_tbl.".$ooo_style2.$ooo_style."\" table:value-type=\"string\"><text:p text:style-name=\"P9\">$subject_sel</text:p><text:p text:style-name=\"P10\">$class_sel</text:p></table:table-cell>";
			}
			$all_class.="</table:table-row>";
		}
		
	}else{
		$all_class="";
	}	

 // echo $all_class ;
	$temp_arr["city_name"] = "";  //$s[sch_sheng];
	$temp_arr["school_name"] = $s[sch_cname];
	//$temp_arr["Cyear"] = $stu[stud_name];
	//$temp_arr["stu_class"] = $class[5];
	$temp_arr["stu_class"] = $teach_name;
	$temp_arr["teacher_name"] = $class_man;
	$temp_arr["year"] = $sel_year;
	$temp_arr["seme"] = $sel_seme;
	$temp_arr["all_course"] = $all_class;
	
	
	//�Z�ŦW
	//$temp_arr["class"] = $teach_name ;
	
    $ttt = new EasyZip;

    $class_data = $ttt->change_temp($temp_arr,$data,0);

	return  $class_data  ;
}	
	

?>
