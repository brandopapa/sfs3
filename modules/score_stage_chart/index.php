<?php
// $Id: index.php 7686 2013-10-22 05:17:44Z smallduh $
/* ���o�]�w�� */
include "config.php";

sfs_check();

$year_seme=($_POST[year_seme])?$_POST[year_seme]:$_GET[year_seme];
$class_id=($_POST[class_id])?$_POST[class_id]: $_GET[class_id];
$student_sn=($_POST[student_sn])?$_POST[student_sn]:$_GET[student_sn];
$act=($_POST[act])?$_POST[act]:$_GET[act];
$stu_num=($_POST[stu_num])?$_POST[stu_num]:$_GET[stu_num];
$stage = ($_POST[stage])?$_POST[stage]:$_GET[stage]; //���q
$yorn = findyorn();  //�O�_�����ɦ��Z
$start_date=($_POST[start_date])?$_POST[start_date]: $_GET[start_date];
$end_date=($_POST[end_date])?$_POST[end_date]: $_GET[end_date];
$avg=$_REQUEST['avg'];
if ($stage=="") $stage=1;

//�Y����X�ɮת��A, ��X���T�Ǵ�
if (($class_id)&&($act)) {
	$c=explode("_",$class_id);
	$year_seme=$c[0].$c[1];
}

//���Ǵ�
if (empty($year_seme)) {
	$sel_year = curr_year(); //�ثe�Ǧ~
	$sel_seme = curr_seme(); //�ثe�Ǵ�
	$year_seme=sprintf("%03s%1s",$sel_year,$sel_seme);
	if ($class_id=="") {
		$sql="select seme_class,student_sn from stud_seme where seme_year_seme='$year_seme'";
		$rs=$CONN->Execute($sql);
		$class_num=$rs->fields['seme_class'];
		$student_sn=$rs->fields['student_sn'];
		$class_id=sprintf("%03d_%d_%02d_%02d",$sel_year,$sel_seme,substr($class_num,0,-2),substr($class_num,-2,2));
	}
} else {
	$sel_year=(substr($year_seme,0,1)=="0")?substr($year_seme,1,2):substr($year_seme,0,3);
	$sel_seme=substr($year_seme,3,1);
	$temp_class_ar = explode("_",$class_id);
	$class_id = sprintf("%03s_%s_%02s_%02s",$sel_year,$sel_seme,$temp_class_ar[2],$temp_class_ar[3]);
}

//���o�Ҹռ˪O�s��
$exam_setup=&get_all_setup("",$sel_year,$sel_seme,$class_all[year]);
$interface_sn=$exam_setup[interface_sn];

//����ʧ@�P�_
if($act=="dlar"){
	//echo $stage.$start_date.$end_date;exit;
	downlod_ar($student_sn,$class_id,$interface_sn,$stu_num,$sel_year,$sel_seme,"",$stage,$start_date,$end_date,$avg);
	header("location: {$_SERVER['SCRIPT_NAME']}?stud_id=$stud_id");
}elseif($act=="dlar_all"){
	downlod_ar("",$class_id,$interface_sn,"",$sel_year,$sel_seme,"all",$stage,$start_date,$end_date,$avg);
	header("location: {$_SERVER['SCRIPT_NAME']}?stud_id=$stud_id");
}else{
	echo " ";
	$main=&main_form($interface_sn,$sel_year,$sel_seme,$class_id,$student_sn,$stage);
}

//�q�X����
head("�w���Ҭd�q����");
// �z���{���X�Ѧ��}�l
print_menu($menu_p);
echo $main;
foot();

//�[�ݼҪO
function &main_form($interface_sn="",$sel_year="",$sel_seme="",$class_id="",$student_sn="",$stage){

	global $CONN,$input_kind,$school_menu_p,$cq,$comm,$chknext,$nav_next,$edit_mode,$submit,$stage,$start_date,$end_date,$year_seme;

	$year_seme=sprintf("%03s%1s",$sel_year,$sel_seme);
	$c=explode("_",$class_id);
	$seme_class=$c[2].$c[3];
	if (substr($seme_class,0,1)=="0") $seme_class=substr($seme_class,1,strlen($seme_class)-1);
	
	//�ഫ�Z�ťN�X
	$class=class_id_2_old($class_id);
	
	//���p�S�����w�ǥ͡A���o�Ĥ@��ǥ�
	if(empty($student_sn)) {
		$sql="select student_sn from stud_seme where seme_year_seme='$year_seme' and seme_class='$seme_class' order by seme_num";
		$rs=$CONN->Execute($sql);
		$student_sn=$rs->fields['student_sn'];
	}

	//��`�ͬ���{�έp�ɶ�
	$db_date=curr_year_seme_day($sel_year,$sel_seme);
    	if(!$start_date) $start_date=$db_date[start];	
	if(!$end_date) $end_date=date("Y-m-d");
	if($end_date>$db_date[end]) $end_date=$db_date[end];
		
	//�D�o�ǥ�ID	
	$stud_id=student_sn2stud_id($student_sn);

	//���o�ǥͯʮu���p
	$abs_data=get_abs_value($stud_id,$sel_year,$sel_seme,"����",$start_date,$end_date);

	//�ǥͼ��g���p
	$reward_data = getOneM_good_bad_data($stud_id,$sel_year,$sel_seme,$start_date,$end_date);

	//���o�ǥͦ��Z��
	$score_data = &get_score_value($stud_id,$student_sn,$class_id,"",$sel_year,$sel_seme,$stage);

	//���o�ԲӸ��
	$html=&html2code2_stage($class,$sel_year,$sel_seme,$abs_data,$reward_data,$score_data,$student_sn);
	
	$gridBgcolor="#DDDDDC";
	//�w�s�@����C��
	$over_color = "#FF6633";
	//�����k������C��
	$non_color = "blue";

	//�Ǧ~���
	$class_seme_p = get_class_seme(); //�Ǧ~��
	
	$upstr = " <select name=\"year_seme\" onchange=\"this.form.submit()\">\n";
	while (list($tid,$tname)=each($class_seme_p)){
		if ($year_seme== $tid)
	      		$upstr .= "<option value=\"$tid\" selected>$tname</option>\n";
	      	else
	      		$upstr .= "<option value=\"$tid\">$tname</option>\n";
	}
	$upstr .= "</select><br>\n<input type='hidden' name='start_date' value='$start_date'>\n<input type='hidden' name='end_date' value='$end_date'>\n"; 
			
	$upstr .= "<input type='hidden' name='stage' value='$stage'>\n";
	//�Z�ſ��
	$tmp=&get_class_select($sel_year,$sel_seme,"","class_id","this.form.submit",$class_id);
	
	$upstr .= $tmp;

	$grid1 = new ado_grid_menu($_SERVER['SCRIPT_NAME'],$URI,$CONN);  //�إ߿��	   	
	$grid1->key_item = "student_sn";  // ������W  	
	$grid1->display_item = array("sit_num","stud_name");  // �����W 

	$grid1->bgcolor = $gridBgcolor;
	$grid1->display_color = array("2"=>"$over_color","1"=>"$non_color");
	$grid1->color_index_item ="stud_sex" ; //�C��P�_��

	$grid1->class_ccs = " class=leftmenu";  // �C�����
	$grid1->sql_str = "select a.stud_id,a.student_sn,a.stud_name,a.stud_sex,b.seme_num as sit_num $stud_id_temp from stud_base a,stud_seme b where a.student_sn=b.student_sn and (a.stud_study_cond=0 or a.stud_study_cond=5 or a.stud_study_cond=8) and  b.seme_year_seme='$year_seme' and b.seme_class='$seme_class' order by b.seme_num ";   //SQL �R�O
	$grid1->do_query(); //����R�O 

	$stud_select = $grid1->get_grid_str($student_sn,$upstr,$downstr); // ��ܵe��

	//���o���w�ǥ͸��
	$stu=get_stud_base($student_sn);

	//���q���
	$stagestr .= "";
	$stagestr .= "<select name=\"stage\" onchange=\"this.form.submit()\";>\n";
        $show_stage = select_stage2($year_seme,$seme_class);
	$stagestr .= "<option value=\"\" >��ܶ��q</option>\n";
	while (list($tid,$tname)=each($show_stage)){
		if ($stage== $tid)
	      		$stagestr .= "<option value=\"$tid\" selected>$tname</option>\n";
	      	else
	      		$stagestr .= "<option value=\"$tid\">$tname</option>\n";
	}
        $stagestr .= "</select>";


	//�y��
	$sql="select seme_num from stud_seme where seme_year_seme='$year_seme' and student_sn='$student_sn'";
	$rs=$CONN->Execute($sql);
	$stu_class_num=$rs->fields['seme_num'];


	//���o�Ǯո��
	$s=get_school_base();

	 if($grid1->count_row!=0)
		 $dlstr ="<hr><p align='center'>�����[�v������</p>
			<p><a href='{$_SERVER['SCRIPT_NAME']}?act=dlar&student_sn=$student_sn&stu_num=$stu_class_num&class_id=$class_id&stage=$stage&start_date=$start_date&end_date=$end_date&avg=1'>�U��".$stu[stud_name]."�����Z��</a></p>
			<p><a href='{$_SERVER['SCRIPT_NAME']}?act=dlar_all&class_id=$class_id&stage=$stage&start_date=$start_date&end_date=$end_date&avg=1'>�U�����Z�����Z��</a></p>
			<hr><p align='center'>���L�[�v������</p>
			<p><a href='{$_SERVER['SCRIPT_NAME']}?act=dlar&student_sn=$student_sn&stu_num=$stu_class_num&class_id=$class_id&stage=$stage&start_date=$start_date&end_date=$end_date&avg=0'>�U��".$stu[stud_name]."�����Z��</a></p>
			<p><a href='{$_SERVER['SCRIPT_NAME']}?act=dlar_all&class_id=$class_id&stage=$stage&start_date=$start_date&end_date=$end_date&avg=0'>�U�����Z�����Z��</a></p>";

	

	$main="
	$tool_bar
	<table bgcolor='#DFDFDF' cellspacing=1 cellpadding=4>
	<tr class='small'><td valign='top'>$stud_select $dlstr

	
	</td><td bgcolor='#FFFFFF' valign='top'>
	<p align='center'>
	<form name=\"myform\" method=post >
	<font size=3>".$s[sch_cname]." ".$sel_year."�Ǧ~�ײ�".$sel_seme."�Ǵ�".$stagestr."�w�����q���Z.</p>
	<table align=center cellspacing=4>
	<tr><td colspan=3>��`�ͬ���{�έp�ɶ��G
		<input type=text name=\"start_date\" value=\"$start_date\" size='8'>
		~<input type=text name=\"end_date\" value=\"$end_date\" size='8'>
		<input type=hidden name=\"class_id\" value=\"$class_id\">
		
		<input type=hidden name=\"year_seme\" value=\"$year_seme\">
		<input type=submit value=\"�ק�ɶ�\"></td></tr>
	<tr>
	
	<td>�Z�šG<font color='blue'>$class[5]</font></td>
	<td>�y���G<font color='green'>$stu_class_num</font></td>
	<td>�m�W�G<font color='red'>$stu[stud_name]</font></td>
	</tr></table></font>
	$html
	</td></tr></form></table>
	";

	return $main;
}

// ���o���Z��XML
function &get_score_xml_value($stud_id,$student_sn,$class_id,$sel_year,$sel_seme,$stage,$avg) {
	global $CONN;
	$class=class_id_2_old($class_id);
	// ���o���~�Ū��ҵ{�}�C
	$ss_name_arr = &get_ss_name_arr($class);
	// ���o�ҵ{�C�g�ɼ�
	$ss_num_arr = get_ss_num_arr($class_id);
	// ���o�ǲߦ��N

	$ss_score_arr =get_ss_score($student_sn,$sel_year,$sel_seme,$stage);
	
	//�p�⥭��
$sectors=0;
foreach($ss_score_arr as $key=>$value){
	$ss_score_sum['�w�����q']+=$value['�w�����q']*$ss_num_arr[$key];
	$ss_score_sum['���ɦ��Z']+=$value['���ɦ��Z']*$ss_num_arr[$key];
	$sectors+=$ss_num_arr[$key];	
}
$ss_score_sum['�w�����q']=sprintf("%3.2f",$ss_score_sum['�w�����q']/$sectors);
$ss_score_sum['���ɦ��Z']=sprintf("%3.2f",$ss_score_sum['���ɦ��Z']/$sectors);

$ss_score_avg['����']['�w�����q']=$ss_score_sum['�w�����q'];
$ss_score_avg['����']['���ɦ��Z']=$ss_score_sum['���ɦ��Z'];

	$ss_sql_select = "select ss_id from score_ss where class_id='".sprintf("%03s_%s_%02s_%02s",$class[0],$class[1],$class[3],$class[4])."'and need_exam='1' and enable='1' and print='1' order by sort,sub_sort";
	$ss_recordSet=$CONN->Execute($ss_sql_select) or user_error("Ū�����ѡI<br>$ss_sql_select",256);
	if ($ss_recordSet->RecordCount() ==0){
		$ss_sql_select = "select ss_id from score_ss where year='$class[0]' and semester='$class[1]' and class_year='$class[3]' and class_id='' and need_exam='1' and enable='1' and print='1' order by sort,sub_sort";
		$ss_recordSet=$CONN->Execute($ss_sql_select) or user_error("Ū�����ѡI<br>$ss_sql_select",256);
	}
	$res_str = "";
	while ($SS=$ss_recordSet->FetchRow()) {		
		$ss_id=$SS[ss_id];
		$ss_name= $ss_name_arr[$ss_id];
		if ($ss_score_arr[$ss_id][�w�����q]=='') $ss_score_arr[$ss_id][�w�����q]="--";
		if ($ss_score_arr[$ss_id][���ɦ��Z]=="") $ss_score_arr[$ss_id][���ɦ��Z]="--";
		$res_str.='<table:table-row><table:table-cell table:style-name="table2.A2" table:value-type="string"><text:p text:style-name="P6">'.$ss_name.'</text:p></table:table-cell><table:table-cell table:style-name="table2.B2" table:value-type="string"><text:p text:style-name="P7">'.$ss_num_arr[$ss_id].'</text:p></table:table-cell><table:table-cell table:style-name="table2.A2" table:value-type="string"><text:p text:style-name="P7">'.round($ss_score_arr[$ss_id][�w�����q],0).'</text:p></table:table-cell><table:table-cell table:style-name="table2.D3" table:value-type="string"><text:p text:style-name="P7">'.round($ss_score_arr[$ss_id][���ɦ��Z],0).'</text:p></table:table-cell></table:table-row>';
	}
	if($avg)
	$res_str.='<table:table-row><table:table-cell table:style-name="table2.B2" table:number-columns-spanned="2" table:value-type="string"><text:p text:style-name="P7">�[�v����</text:p></table:table-cell><table:table-cell table:style-name="table2.A2" table:value-type="string"><text:p text:style-name="P7">'.round($ss_score_avg['����']['�w�����q'],0).'</text:p></table:table-cell><table:table-cell table:style-name="table2.D3" table:value-type="string"><text:p text:style-name="P7">'.round($ss_score_avg['����']['���ɦ��Z'],0).'</text:p></table:table-cell></table:table-row>';

	return $res_str;
}



// $abs_data -- ���m�ҰO��
// $reward_data -- �N�g�O��
// $score_data -- ���Z�O��
function &html2code2_stage($class,$sel_year,$sel_seme,$abs_data,$reward_data,$score_data,$student_sn) {
	global $SFS_PATH_HTML,$CONN,$REWARD_KIND,$year_seme,$IS_JHORES;

	//���O
	$abs_kind_arr = stud_abs_kind();

	//���g
	$rep_kind_arr = stud_rep_kind();


	$temp_str ="
	<table cellspacing=\"0\" cellpadding=\"0\">
	<tr>
	<td>
	<table bgcolor=\"#9ebcdd\" cellspacing=\"1\" cellpadding=\"4\" width=\"100%\">
	<tr bgcolor=\"white\">

	<td colspan=\"13\" nowrap>��`�ͬ���{���q</td>
	</tr>

	<tr bgcolor=\"white\">
	<td nowrap>�ǥͯʮu���p<br>
	</td>";
	while(list($id,$val)=each($abs_kind_arr)){
		$ttt = "�`��";
		if ($id==4)
			$ttt= "����";
		$temp_str .="<td nowrap>$val<br>$ttt</td>\n<td width=\"30\" align=\"center\">$abs_data[$id]</td>\n";
	}
	
	$temp_str.= "</tr>
	<tr bgcolor=\"white\">
	<td nowrap>���g<br>
	</td>";
	//�C�X���g
	foreach($REWARD_KIND as $key=>$gbkind)
		$temp_str .= "<td nowrap>$gbkind<br>����</td>\n<td width=\"30\" align=\"center\">$reward_data[$key]</td>\n";

	$temp_str .= "</tr>";
	
	$col_num=count($REWARD_KIND)*2;
	
	
	if ($IS_JHORES>0) {
  	$ALL_SERV=getService_allmin($student_sn,$year_seme);
		$service = round($ALL_SERV/60,2);
  	$temp_str .= "	
  	 <tr bgcolor=\"white\"><td nowrap>�A�Ⱦǲ�</td><td colspan=\"$col_num\" nowrap>���Ǵ������w�A�� $service �p��</td></tr>   
  	";	
  } // end if �O�_���ꤤ
	$temp_str .= "</table>
	</td></tr>
	<tr><td>
	$score_data
	</td></tr>
	</table>
	</td>
	</tr>
	</table>";
	return $temp_str;
}


//�U�����Z��
function downlod_ar($student_sn="",$class_id="",$interface_sn="",$stu_num="",$sel_year="",$sel_seme="",$mode="",$stage,$start_date,$end_date,$avg){
	global $CONN,$UPLOAD_PATH,$UPLOAD_URL,$SFS_PATH_HTML,$line_color,$line_width,$draw_img_width,$draw_img_height,$REWARD_KIND,$year_seme;
  
  global $IS_JHORES;

	//Openofiice�����|
	$oo_path = "ooo/1";
	
	//�ɦW����
	if($mode=="all"){
		$filename="score_".$class_id.".sxw";
	}else{
		$filename="score_".$class_id."_".$stu_num.".sxw";
	}
	
	//�ഫ�Z�ťN�X
	$class=class_id_2_old($class_id);
	$class_num=$class[2];
	$year_seme=sprintf("%03s%1s",$class[0],$class[1]);
	
	//���o�Ǯո��
	$s=get_school_base();
	
	
	//���� tag
	$break ='<text:p text:style-name="P10"/>';


	if ($draw_img_width=='') $draw_img_width="1.27cm";
	if ($draw_img_height=='') $draw_img_height="1.27cm";
	//�ժ�ñ����
	if (is_file($UPLOAD_PATH."school/title_img/title_1")){
 		$title_img = "http://".$_SERVER["SERVER_ADDR"].$UPLOAD_URL."school/title_img/title_1";
		//$title_img = $SFS_PATH_HTML."data/school/title_img/title_1";
		//$title_img = $SFS_PATH_HTML.$UPLOAD_URL."school/title_img/title_1";
		$sign_1 ="<draw:image draw:style-name=\"fr1\" draw:name=\"aaaa1\" text:anchor-type=\"paragraph\" svg:x=\"0.73cm\" svg:y=\"0.161cm\" svg:width=\"$draw_img_width\" svg:height=\"$draw_img_height\" draw:z-index=\"0\" xlink:href=\"$title_img\" xlink:type=\"simple\" xlink:show=\"embed\" xlink:actuate=\"onLoad\"/>";
	}
	//�аȥD��ñ����	
	if (is_file($UPLOAD_PATH."school/title_img/title_2")){
 			$title_img = "http://".$_SERVER["SERVER_ADDR"].$UPLOAD_URL."school/title_img/title_2";
			//$title_img = $SFS_PATH_HTML."data/school/title_img/title_2";
			//$title_img = $SFS_PATH_HTML.$UPLOAD_URL."school/title_img/title_2";
			$sign_2 = "<draw:image draw:style-name=\"fr2\" draw:name=\"bbbb1\" text:anchor-type=\"paragraph\" svg:x=\"0.727cm\" svg:y=\"0.344cm\" svg:width=\"$draw_img_width\" svg:height=\"$draw_img_height\" draw:z-index=\"1\" xlink:href=\"$title_img\" xlink:type=\"simple\" xlink:show=\"embed\" xlink:actuate=\"onLoad\"/>";
		}

	//���O
	$abs_kind_arr = stud_abs_kind();

	//���g
	$rep_kind_arr = stud_rep_kind();

	
	//�s�W�@�� zipfile ���
	$ttt = new EasyZip;
	$ttt->setPath($oo_path);	
	//Ū�X xml �ɮ�
	//$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/META-INF/manifest.xml");

	$ttt->addDir("META-INF");
	$ttt->addfile("settings.xml");
	$ttt->addfile("styles.xml");
	$ttt->addfile("meta.xml");



        //��X�ӯZ���Ҧ��ǥ�
	$sn_arr=array();
	if($mode=="all") {
		if ($sel_year==curr_year() && $sel_seme==curr_seme())
			$sn_arr=class_id_to_student_sn($class_id);
		else {
			$query="select student_sn from stud_seme where seme_year_seme='".sprintf("%03d%d",$sel_year,$sel_seme)."' and seme_class='".$class[2]."' order by seme_num";
			$res=$CONN->Execute($query);
			$i=0;
			while(!$res->EOF) {
				$sn_arr[$i]=$res->fields[0];
				$i++;
				$res->MoveNext();
			}
		}
	} else
		$sn_arr[]=$student_sn;

        for($m=0;$m<count($sn_arr);$m++){		
		//Ū�X content.xml 
		$content_body = $ttt->read_file(dirname(__FILE__)."/$oo_path/content_body.xml");


		//$stu_num= intval (substr($stu_num,-2));

		$student_info=student_sn_to_classinfo($sn_arr[$m],$sel_year,$sel_seme);
		//�N content.xml �� tag ���N

		$temp_arr["school_name"] = $s[sch_cname];
		$temp_arr["stu_class"] = $class[5];
		$temp_arr["year"] = $sel_year;
		$temp_arr["seme"] = $sel_seme;

		$temp_arr["stage"] = $stage;
		$temp_arr["stu_name"] = $student_info[4];
		$temp_arr["stu_num"] = $student_info[2];
		$temp_arr["start_date"] = $start_date;
		$temp_arr["end_date"] = $end_date;		
		$temp_arr["avg"] = $avg;	
		$stud_id = student_sn2stud_id($sn_arr[$m]);

		//���o�ǥͯʮu���p
		$abs_data=get_abs_value($stud_id,$sel_year,$sel_seme,"����",$start_date,$end_date);
		reset($abs_kind_arr);
		$i=1;	
		while(list($id,$val)=each($abs_kind_arr)){
			$temp_arr["$i"]=$abs_data[$id];
			$i++;
		}

	
		//�ǥͼ��g���p
		$reward_data = getOneM_good_bad_data($stud_id,$sel_year,$sel_seme,$start_date,$end_date);
		$i=7;
		foreach($REWARD_KIND as $key=>$gbkind){
			$temp_i=$reward_data[$key];
			$temp_arr["$i"] = $temp_i;
			$i++;			
		}

		//���o�ǥͦ��Z��{ss_table}
		$temp_arr_score["ss_table"] = &get_score_xml_value($stud_id,$sn_arr[$m],$class_id,$sel_year,$sel_seme,$stage,$avg);
		$temp_arr_score["SIGN_1"] = $sign_1;
		$temp_arr_score["SIGN_2"] = $sign_2;
		
		if ($IS_JHORES>0) {
		 $ALL_SERV=getService_allmin($sn_arr[$m],$year_seme);
		 $SERV = round($ALL_SERV/60,2);
		
		 $temp_arr_score["SERVICE"]="<table:table-row><table:table-cell table:style-name=\"table1.A2\" table:value-type=\"string\"><text:p text:style-name=\"P4\">�A�Ⱦǲ�</text:p>";
		 $temp_arr_score["SERVICE"].="</table:table-cell><table:table-cell table:style-name=\"table1.B4\" table:number-columns-spanned=\"12\" table:value-type=\"string\"><text:p text:style-name=\"P4\">";
		 $temp_arr_score["SERVICE"].="���Ǵ������w�A�� ".$SERV." �p��</text:p></table:table-cell><table:covered-table-cell/><table:covered-table-cell/><table:covered-table-cell/><table:covered-table-cell/><table:covered-table-cell/><table:covered-table-cell/><table:covered-table-cell/><table:covered-table-cell/><table:covered-table-cell/><table:covered-table-cell/><table:covered-table-cell/></table:table-row>";
	  } else {
	    $temp_arr_score["SERVICE"]="";
	  } //�P�_�ꤤ�ΰ�p, �O�_���A�Ⱦǲ�
		
		$content_body = $ttt->change_temp($temp_arr_score,$content_body,0);
		
	
		
		//����
		if($mode=="all") $content_body .= $break;
		
		// change_temp �|�N�}�C���� big5 �ର UTF-8 �� openoffice �i�HŪ�X
		$replace_data .= $ttt->change_temp($temp_arr,$content_body,0);
	}

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
	$sss = & $ttt->file();

	//�H��y�覡�e�X sxw
	header("Content-disposition: attachment; filename=$filename");
	header("Content-type: application/vnd.sun.xml.writer");

  //header("Pragma: no-cache");
  //�]�� IE 6,7,8 �b SSL �Ҧ��U�L�k�U���A���� no-cache �אּ�H�U
	header("Cache-Control: max-age=0");
	header("Pragma: public");
	header("Expires: 0");

	echo $sss;
	
	exit;
	return;
}

//�W�[�A�Ⱦǲ߸�� 2013/06/05 by smallduh
function getService_allmin($student_sn,$year_seme) {
 $query="select sum(minutes) from stud_service_detail a,stud_service b where a.student_sn='$student_sn' and b.year_seme='$year_seme' and a.item_sn=b.sn and b.confirm=1";
 $result=mysql_query($query);
 list($min)=mysql_fetch_row($result);
 return $min;
}

?>
