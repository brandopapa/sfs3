<?php
// $Id: stage_class_score.php 8232 2014-12-10 08:12:04Z brucelyc $
/* ���o�]�w�� */
include "config.php";
sfs_check();
// ���ݭn register_globals
/*
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}
*/

$year_seme=($_POST[year_seme])?$_POST[year_seme]:$_GET[year_seme];
$class_id=($_POST[class_id])?$_POST[class_id]: $_GET[class_id];
$stage = ($_POST[stage])?$_POST[stage]:$_GET[stage]; //���q
$all = ($_POST[all])?$_POST[all]:$_GET[all];
$ss_id_b = ($_POST[ss_id_b])?$_POST[ss_id_b]:$_GET[ss_id_b];
$act = ($_POST[act])?$_POST[act]: $_GET[act];
$mode = ($_POST[mode])?$_POST[mode]: $_GET[mode]; 

$M_SETUP=get_module_setup('score_stage_chart');

//���Ǵ�
if (empty($year_seme)) {
	$sel_year = curr_year(); //�ثe�Ǧ~
	$sel_seme = curr_seme(); //�ثe�Ǵ�
	$year_seme=sprintf("%03s%1s",$sel_year,$sel_seme);
} else {
	$sel_year=(substr($year_seme,0,1)=="0")?substr($year_seme,1,2):substr($year_seme,0,3);
	$sel_seme=substr($year_seme,3,1);
	$temp_class_ar = explode("_",$class_id);
	$class_id = sprintf("%03s_%s_%02s_%02s",$sel_year,$sel_seme,$temp_class_ar[2],$temp_class_ar[3]);
}
//���Z��ƪ�
$score_semester="score_semester_".$sel_year."_".$sel_seme;

//����ʧ@�P�_
switch ($act){
	case "dlar":	downlod_ar($class_id,$sel_year,$sel_seme,$stage);
			break;

	case "csv":     save_csv($class_id,$sel_year,$sel_seme,$stage);
			break;
}

//�q�X����
head("�w�үZ�Ŧ��Z�`��");
// �z���{���X�Ѧ��}�l
print_menu($menu_p);



//���o�Ǧ~�Ǵ��}�C
$year_seme_arr = get_class_seme();
//�s�W�@�ӤU�Կ����
$ss1 = new drop_select();
//�U�Կ��W��
$ss1->s_name = "year_seme";
//���ܦr��
$ss1->top_option = "��ܾǴ�";
//�U�Կ��w�]��
$ss1->id = $year_seme;
//�U�Կ��}�C
$ss1->arr = $year_seme_arr;
//�۰ʰe�X
$ss1->is_submit = true;
//�Ǧ^�U�Կ��r��
$year_seme_menu = $ss1->get_select();




//�Z�ŤU�Կ��
if($year_seme) $class_year_menu = get_class_select($sel_year,$sel_seme,"","class_id","this.form.submit",$class_id);

//���q���
if($year_seme && $class_id){
	$c=explode("_",$class_id);
	$seme_class=$c[2].$c[3];
	if (substr($seme_class,0,1)=="0") $seme_class=substr($seme_class,1,strlen($seme_class)-1);
	$show_stage = select_stage2($year_seme,$seme_class);
	$ss1->s_name = "stage";
	$ss1->id =$stage;
	$ss1->arr = $show_stage;
	$ss1->top_option = "��ܶ��q";
	$ss1->is_submit = true;
	$stage_menu= $ss1->get_select();
}
echo "<table border=0 cellspacing=1 cellpadding=2 width=100% bgcolor=#cccccc><tr><td bgcolor=#FFFFFF>
 <form name=\"myform\" method=\"post\" action=\"$_SERVER[PHP_SELF]\">
    <table cellspacing=0 cellpadding=0>
        <tr>
            <td>$year_seme_menu</td><td>$class_year_menu</td><td>$stage_menu </td>
        </tr>
    </table>
	<input type=hidden name=ss_id_b value=$ss_id_b>
 </form>\n";
 


//�H�W�����bar

if($year_seme && $class_id && $stage){

	$class=class_id_2_old($class_id);
	$class_num=$class[2];
    
	$subject_str = get_stage_test_subject($class_id,$stage);
	$tmp_str = "<table width=50%><tr><td><a href=\"$_SERVER[PHP_SELF]?act=dlar&all=$all&year_seme=$year_seme&class_id=$class_id&";
	while (list($id,$val) = each($ss_id_b)){
		$tmp_str .= "ss_id_b[".$id."]=".$val."&";
	}	

			
	$tmp_str .= "stage=$stage\">�U��sxw�ɮ�</a></td><td>";
	reset($ss_id_b);
	$tmp_str .= "<a href=\"$_SERVER[PHP_SELF]?act=csv&year_seme=$year_seme&class_id=$class_id&all=$all&stage=$stage&";
	while (list($id,$val) = each($ss_id_b)){
		$tmp_str .= "ss_id_b[".$id."]=".$val."&";
	}		



	$tmp_str .= "mode=all\">�U���P�~�ť����Z��csv�ɮ�</a></td></tr></table></tr></td>";
	
	$tmp_str .= "<table bgcolor=\"#9ebcdd\" cellspacing=\"1\" cellpadding=\"4\" width=\"100%\">";
	
	
	$tmp_str.= "<tr bgcolor=\"white\">\n<form method='post' action=\"$_SERVER[PHP_SELF]\">\n<td colspan=2>��ܬ��</td>";
	
	while (list($id,$val) = each($subject_str)){
		
		$tmp_str.= "<td><input type=\"checkbox\" name=\"ss_id_b[$val[ss_id]]\"  value=\"1\" ";
		if(($all!="no")||($ss_id_b[$val[ss_id]]==1)){
			$tmp_str.= "checked";
			
			$ss_id_b[$val[ss_id]]=1;
		}
		$tmp_str.= "></td>\n";
	}
	$tmp_str.= "<input type=\"hidden\" name=\"all\" value=\"no\">\n";
	$tmp_str.= "<input type=\"hidden\" name=\"year_seme\" value=\"$year_seme\">\n";
	$tmp_str.= "<input type=\"hidden\" name=\"class_id\" value=\"$class_id\">\n";
	$tmp_str.= "<input type=\"hidden\" name=\"stage\" value=\"$stage\">\n";
	$tmp_str.= "<td colspan=3><input type=\"submit\" name=\"submit\" ></td></form></tr>\n";

	$tmp_str.= "<tr bgcolor=\"#c4d9ff\"><td width='20' align='center'>�y��</td><td width='120' align='center'>�m�W</td>";
	reset($subject_str);
	while (list($id,$val) = each($subject_str)){
		$tmp_str.= "<td width='20' align='center'>$val[subject_name]</td>\n";
	}
							
	$tmp_str.= "<td width='30' align='center'>�`��</td><td width='30' align='center'>����</td><td width='30' align='center'>�W��</td></tr>\n";


	


        //��X�ӯZ���Ҧ��ǥ�
        $student_sn= seme_class_id_to_student_sn($class_id);
	
	$tmp_score_ary = cal_ar($student_sn,class_id,$sel_year,$sel_seme,$stage);
        
	reset($subject_str);
        for($m=0;$m<count($student_sn);$m++){
		$tmp_str .= "<tr bgcolor=\"white\"><td>".$tmp_score_ary[$m][site_num]."</td><td>".$tmp_score_ary[$m][stu_name]."</td>";
		reset($subject_str);
		while (list($id,$val) = each($subject_str)){
			$tmp_str.= "<td width='20' align='center'>".$tmp_score_ary[$m][$val[ss_id]]."</td>\n";
		}
		$tmp_str.= "<td align='right'>".$tmp_score_ary[$m][total]."</td><td align='right'>".$tmp_score_ary[$m][avg]."</td><td align='center'>".$tmp_score_ary[$m][how_big]."</td></tr>\n";
	
        } 
		
	$tmp_str .= "</td></tr></table>";	
	echo $tmp_str;
}

//�����D������ܰ�
 echo "</td></tr></table>";

 foot();

// ���o���Z��
function &get_score_value_stage($student_sn,$class_id,$sel_year,$sel_seme,$stage) {
	global $CONN,$class,$year_seme,$ss_id_b,$all;


	// ���o���~�Ū��ҵ{�}�C
	$subject_str = get_stage_test_subject($class_id,$stage);

	// ���o�ǲߦ��N
	$ss_score_arr =get_ss_score($student_sn,$sel_year,$sel_seme,$stage);
        $student_info=student_sn_to_classinfo($student_sn);
        $tmp_score_ary = array();
	$tmp_score_ary[site_num] =  $student_info[2];
	$tmp_score_ary[stu_name] =  $student_info[4];
        $score_str ="<tr bgcolor=\"white\"><td>".$student_info[2]."</td><td>".$student_info[4]."</td>";

	$total=0;
	$i=0;
	$ss_sql_select = "select  subject_id,ss_id  from score_ss where enable='1' and  year='$class[0]' and semester='$class[1]' and class_year='$class[3]'  and  need_exam='1' and enable=1 and print='1' order by sort,sub_sort";
	$ss_recordSet=$CONN->Execute($ss_sql_select) or user_error("Ū�����ѡI<br>$ss_sql_select",256);
	
	while ($SS=$ss_recordSet->FetchRow()) {		
		$ss_id=$SS[ss_id];
		$ss_name= $ss_name_arr[$ss_id];
		
		if(($ss_id_b[$ss_id]==1)||$all!="no"){
			if ($ss_score_arr[$ss_id][�w�����q]=='') $ss_score_arr[$ss_id][�w�����q] = "--";
			$tmp_score_ary[$ss_id] = $ss_score_arr[$ss_id][�w�����q];
			$total += $ss_score_arr[$ss_id][�w�����q];
		
			$i++;
		}
	}
		$tmp_score_ary[total] = $total;
		$avg = sprintf("%.1f",$total/$i);
		$tmp_score_ary[avg] = $avg;

	return $tmp_score_ary;
}

//�U�����Z��
function downlod_ar($class_id="",$sel_year="",$sel_seme="",$stage){
	global $CONN,$UPLOAD_PATH,$UPLOAD_URL,$SFS_PATH_HTML,$line_color,$line_width,
			$draw_img_width,$draw_img_height,$mode,$all,$ss_id_b,$class,$M_SETUP;

	//Openofiice�����|
	$oo_path = "ooo/2";
	
	//�ɦW����
	if($mode=="all"){
		$filename="score.sxw";
	}else{
		$filename="stage_score_".$class_id.".sxw";
	}
	
	//�ഫ�Z�ťN�X
	$class=class_id_2_old($class_id);
	$class_num=$class[2];
	
	//���o�Ǯո��
	$s=get_school_base();
	$subject_str = get_stage_test_subject($class_id,$stage);
	
	//���� tag
	$break ='<text:p text:style-name="P5"/>';

	//��ئW��
	$sub_arr = stage_subject($class_id,$stage,$all,$ss_id_b);

	$subject_name_row="";
	while (list($id,$val) = each($sub_arr)){
		$subject_name_row .= '<table:table-cell table:style-name="table1.A1" table:value-type="string"><text:p text:style-name="P2">'.$val.'</text:p></table:table-cell>';
	}
	
	if ($M_SETUP['hborder']=="") $M_SETUP['hborder'] = 1.27;
	if ($M_SETUP['wborder']=="") $M_SETUP['wborder'] = 1.27;
	if ($draw_img_width=='') $draw_img_width=$M_SETUP['hborder']."cm";
	if ($draw_img_height=='') $draw_img_height=$M_SETUP['wborder']."cm";
	//�ժ�ñ����
	if (is_file($UPLOAD_PATH."school/title_img/title_1")){
// 		$title_img = "http://".$_SERVER["SERVER_ADDR"]."/".$UPLOAD_URL."school/title_img/title_1";
		$title_img = $SFS_PATH_HTML.$UPLOAD_URL."school/title_img/title_1";
		$sign_1 ="<draw:image draw:style-name=\"fr1\" draw:name=\"aaaa1\" text:anchor-type=\"paragraph\" svg:x=\"0.73cm\" svg:y=\"0.161cm\" svg:width=\"$draw_img_width\" svg:height=\"$draw_img_height\" draw:z-index=\"0\" xlink:href=\"$title_img\" xlink:type=\"simple\" xlink:show=\"embed\" xlink:actuate=\"onLoad\"/>";
	}
	//�аȥD��ñ����	
	if (is_file($UPLOAD_PATH."school/title_img/title_2")){
// 			$title_img = "http://".$_SERVER["SERVER_ADDR"]."/"."$UPLOAD_URL"."school/title_img/title_2";
			$title_img = $SFS_PATH_HTML.$UPLOAD_URL."school/title_img/title_2";
			$sign_2 = "<draw:image draw:style-name=\"fr2\" draw:name=\"bbbb1\" text:anchor-type=\"paragraph\" svg:x=\"0.727cm\" svg:y=\"0.344cm\" svg:width=\"$draw_img_width\" svg:height=\"$draw_img_height\" draw:z-index=\"1\" xlink:href=\"$title_img\" xlink:type=\"simple\" xlink:show=\"embed\" xlink:actuate=\"onLoad\"/>";
		}

	
	//�s�W�@�� zipfile ���
	$ttt = new EasyZip;
	$ttt->setPath($oo_path);	
	//Ū�X xml �ɮ�
	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/META-INF/manifest.xml");

	$ttt->addDir("META-INF");
	$ttt->addfile("settings.xml");
	$ttt->addfile("styles.xml");
	$ttt->addfile("meta.xml");

	//���o�Z�Ÿ��,��Z�ΦP�~�ũҦ��Z
	$which_class = array();
	if($mode=="all"){
		$which_class = get_all_classid($sel_year,$sel_seme,$class_id);
	}else{
		$which_class[] = $class_id;
	}
			
     
	for($j=0;$j<count($which_class);$j++){
		
		//��X�ӯZ���Ҧ��ǥ�
        	$student_sn = seme_class_id_to_student_sn($which_class[$j]);
		//var_dump($student_sn);exit;

		$tmp_score_ary = cal_ar($student_sn,$which_class[$j],$sel_year,$sel_seme,$stage);
		
		//Ū�X content.xml 
		$content_body = $ttt->read_file(dirname(__FILE__)."/$oo_path/content_body.xml");
		//�N content.xml �� tag ���N
		$temp_arr["school_name"] = $s[sch_cname];
		$temp_arr["stu_class"] = $class[5];
		$temp_arr["year"] = $sel_year;
		$temp_arr["seme"] = $sel_seme;	
		$temp_arr["stage"] = $stage;
		$temp_arr_score["subject_name_row"] = $subject_name_row;
		//���N�ǥͭӤH���
        	for($m=0;$m<count($student_sn);$m++){
					  
			$stu_score_row .='<table:table-row table:style-name="table1.1"><table:table-cell table:style-name="table1.A2" table:value-type="string">';
			$stu_score_row.='<text:p text:style-name="P2">'.$tmp_score_ary[$m][site_num].'</text:p></table:table-cell><table:table-cell table:style-name="table1.A2" table:value-type="string"><text:p text:style-name="P2">'.$tmp_score_ary[$m][stu_name].'</text:p></table:table-cell>';
			
			reset($subject_str);
        		
			while (list($id,$val) = each($subject_str)){
				if(($all!="no")||($ss_id_b[$val[ss_id]]=="1")) 
					
					  $stu_score_row.='<table:table-cell table:style-name="table1.A2" table:value-type="string"><text:p text:style-name="P3">'.$tmp_score_ary[$m][$val[ss_id]].'</text:p></table:table-cell>';
						
			}
			
			$stu_score_row.='<table:table-cell table:style-name="table1.A2" table:value-type="string"><text:p text:style-name="P3">'.$tmp_score_ary[$m][total].'</text:p></table:table-cell><table:table-cell table:style-name="table1.A2" table:value-type="string"><text:p text:style-name="P3">'.$tmp_score_ary[$m][avg].'</text:p></table:table-cell><table:table-cell table:style-name="table1.P2" table:value-type="string"><text:p text:style-name="P3">'.$tmp_score_ary[$m][how_big].'</text:p></table:table-cell></table:table-row>';
			
		}

		
		$temp_arr_score["stu_score_row"] = $stu_score_row;
	
		$temp_arr_score["SIGN_1"] = $sign_1;
		$temp_arr_score["SIGN_2"] = $sign_2;

		
		//����
		if($mode=="all")	$content_body .= $break;
		
		// change_temp �|�N�}�C���� big5 �ର UTF-8 �� openoffice �i�HŪ�X
		$content_body = $ttt->change_temp($temp_arr_score,$content_body,0);
		$replace_data .= $ttt->change_temp($temp_arr,$content_body,0);
	}

	//echo $replace_data;
	//exit;
	//Ū�X XML ���Y
	$doc_head = $ttt->read_file(dirname(__FILE__)."/$oo_path/content_head.xml");
	if ($line_width<>'') {
		$sign_arr["0.002cm solid #000000"] = "$line_width solid $line_color";
		//�ﴫ��u�e��
		$doc_head = $ttt->change_sigle_temp($sign_arr,$doc_head);
	}
	//Ū�X XML �ɧ�
	$doc_foot = $ttt->read_file(dirname(__FILE__)."/$oo_path/content_foot.xml");

	$replace_data =$doc_head.$replace_data.$doc_foot;
	
	// �[�J content.xml ��zip ��
	$ttt->add_file($replace_data,"content.xml");
	
	//���� zip ��
	$sss = $ttt->file();

	//�H��y�覡�e�X sxw
	header("Content-disposition: attachment; filename=$filename");
	header("Content-type: application/vnd.sun.xml.writer");
	//header("Pragma: no-cache");
					//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");

	header("Expires: 0");

	echo $sss;
	
	exit;
	return;
}
//�U�����Z��
function save_csv($class_id="",$sel_year="",$sel_seme="",$stage){
	global $CONN,$mode,$all,$ss_id_b,$class;
 
   	$filename="stage_score_paper.csv";
    	header("Content-disposition: filename=$filename");
    	header("Content-type: text/x-csv ; Charset=Big5");
    	//header("Pragma: no-cache");
    					//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");

    	header("Expires: 0");


	
	
	//���o�Ǯո��
	$s=get_school_base();
	$subject_str = get_stage_test_subject($class_id,$stage);
	
	//��ئW��
	$sub_arr = stage_subject($class_id,$stage,$all,$ss_id_b);

	$title_str .="�y��,�m�W,";
	while (list($id,$val) = each($sub_arr)){
		$title_str  .= $val.',';
	}
	$title_str .= "�`��,����,�W��";

	//���o�Z�Ÿ��,��Z�ΦP�~�ũҦ��Z
	$which_class = array();
	
	if($mode=="all"){
		$which_class = get_all_classid($sel_year,$sel_seme,$class_id);
	}else{
		$which_class[] = $class_id;
	}
	
   	//var_dump($which_class);
	for($j=0;$j<count($which_class);$j++){
	//�ഫ�Z�ťN�X
		$class=class_id_2_old($which_class[$j]);
			
		//��X�ӯZ���Ҧ��ǥ�
        	$student_sn = seme_class_id_to_student_sn($which_class[$j]);
		//var_dump($student_sn);exit;

		$tmp_score_ary = cal_ar($student_sn,$which_class[$j],$sel_year,$sel_seme,$stage);
		
		$school_name = $s[sch_cname];
		$stu_class = $class[5];
		$year = $sel_year;
		$seme = $sel_seme;	
		$stage = $stage;
		$str = $s[sch_cname]." ".$year."�Ǧ~��  ��".$seme."�Ǵ�  ��".$stage."���q ".$stu_class."�w���Ҭd���Z��\n".$title_str."\n";
		
		//�ǥͭӤH��Ʀ��Z
        	for($m=0;$m<count($student_sn);$m++){
					  
			$str .= $tmp_score_ary[$m][site_num].",".$tmp_score_ary[$m][stu_name].",";
			reset($subject_str);
        		
			while (list($id,$val) = each($subject_str)){
				if(($all!="no")||($ss_id_b[$val[ss_id]]=="1")) 
					  $str .= $tmp_score_ary[$m][$val[ss_id]].",";
						
			}
			$str .= $tmp_score_ary[$m][total].",".$tmp_score_ary[$m][avg].",".$tmp_score_ary[$m][how_big]."\n";
			
		}
		 $str .="\n\n\n\n\n";

		echo $str;
	}

	
	exit;	
}
?>
