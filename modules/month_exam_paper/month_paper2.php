<?php
// $Id: month_paper2.php 7708 2013-10-23 12:19:00Z smallduh $
// �ޤJ SFS3 ���禡�w
//include "../../include/config.php";

// �ޤJ�z�ۤv�� config.php ��
require "config.php";

// �{��
sfs_check();



//�ഫ�������ܼ�
$act=($_POST['act'])?"{$_POST['act']}":"{$_GET['act']}";
$test_sort=($_POST['test_sort'])?"{$_POST['test_sort']}":"{$_GET['test_sort']}";
$class_num=($_POST['class_num'])?"{$_POST['class_num']}":"{$_GET['class_num']}";
$student_sn=($_POST['student_sn'])?"{$_POST['student_sn']}":"{$_GET['student_sn']}";

if(!$curr_year) $curr_year = curr_year();
if(!$curr_seme) $curr_seme = curr_seme();

if($act=="dl_oo_one"){

	OOO_one($test_sort,$class_num,$student_sn);

}
elseif($act=="dl_oo_class"){

	OOO_class($test_sort,$class_num);

}
elseif($act=="dl_pdf_class"){

	$class_id=sprintf("%03d",$curr_year)."_".$curr_seme."_".sprintf("%02d_%02d",substr($class_num,0,-2),substr($class_num,-2,2));
	$student_sn_arr=class_id_to_seme_student_sn($class_id,$yn='0');
	$class=class_id_to_full_class_name($class_id);
	$title=$school_short_name.curr_year()."�Ǧ~�ײ�".$curr_seme."�Ǵ�"."��".$test_sort."���w���Ҭd\n".$class;

	$header=array("���","���Z");

	$i=0;
	foreach($student_sn_arr as $student_sn){
		$data[$i]=array();
		$st=student_sn_to_id_name_num($student_sn,$curr_year="",$curr_seme="");
		$name=$st[1];
		$num=$st[2];
		$comment1[]="�m�W�G".$name." �y���G".$num;

		//���
		$count[$student_sn]=0;
		$SS=class_id2subject($class_id);
		$j=0;
		foreach($SS as $ss_id => $subject_name){
			$data[$i][$j]=array();
			//���Z
			$score_b[$student_sn][$ss_id]=score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="�w�����q",$test_sort);
			if($score_b[$student_sn][$ss_id]==-100) $score_b[$student_sn][$ss_id]="";
			if($score_b[$student_sn][$ss_id]!="") {$count[$student_sn]++; $total[$student_sn]=$total[$student_sn]+$score_b[$student_sn][$ss_id];}
			array_push($data[$i][$j],"$subject_name","{$score_b[$student_sn][$ss_id]}");
			$j++;
		}
		if($count[$student_sn]>0) $aver[$student_sn]=round($total[$student_sn]/$count[$student_sn],2);
		$data[$i][$j]=array();
		array_push($data[$i][$j],"�`��","$total[$student_sn]");
		$j++;
		$data[$i][$j]=array();
		array_push($data[$i][$j],"����","$aver[$student_sn]");

		$i++;
	}
	$comment2="�ɮv�G{$_SESSION['session_tea_name']} \n�a���G";
	creat_pdf($title,$header,$data,$comment1,$comment2);

}
elseif($act=="dl_pdf_one"){
	$title=$school_short_name.$curr_year."�Ǧ~�ײ�".$curr_seme."�Ǵ���".$test_sort."���w���Ҭd";
	if(sizeof($curr_year)<3) $curr_year="0".$curr_year;
	$class_id=$curr_year."_".$curr_seme."_".sprintf("%02d_%02d",substr($class_num,0,-2),substr($class_num,-2,2));
	$st_arr=student_sn_to_name_num($student_sn);
	$cla_arr=class_id_to_full_class_name($class_id);
	//$title.="\n�Z�šG".$cla_arr."\n�m�W�G".$st_arr[1]." �y���G".$st_arr[2];

	$header=array("���","����");
	$data=array();
	$class_id=$curr_year."_".$curr_seme."_".sprintf("%02d_%02d",substr($class_num,0,-2),substr($class_num,-2,2));
	//���
	$SS=class_id2subject($class_id);
	$j=0;
	foreach($SS as $ss_id => $s_name){
		$data[$j]=array();
		//���Z
		$score_b[$ss_id]=score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="�w�����q",$test_sort);
		if($score_b[$ss_id]==-100) $score_b[$ss_id]="";
		if($score_b[$ss_id]!="") {$i++; $total=$total+$score_b[$ss_id];}
		//echo $s_name.$score_b[$ss_id];
		array_push($data[$j],$s_name,$score_b[$ss_id]);
		$j++;
	}
	$data[$j]=array();
	array_push($data[$j],"�`��","$total");
	if($i>0) $aver=round($total/$i,2);
	$j++;
	$data[$j]=array();
	array_push($data[$j],"����","$aver");


	//print_r($data);
	$comment2="�ɮv�G{$_SESSION['session_tea_name']} \n�a���G";

	creat_pdf($title,$header,$data,$comment1,$comment2);
}
else{
	// �s�� SFS3 �����Y
	head("��Ҧ��Z��");
	
	// �z���{���X�Ѧ��}�l
	print_menu($menu_p);

	//��teacher_sn��X�L�O���@�Z���ɮv
	$class_num=get_teach_class();
	if($class_num){
		//���q���
		$option=test_sort_select($curr_year,$curr_seme,$class_num);
		if($test_sort)	{
			$student_select=logn_stud_sel($curr_year,$curr_seme,$class_num);
			$student_select="<tr><td>
			<form action='{$_SERVER['PHP_SELF']}' method='POST' name='sel_id'>\n
			<select name='student_sn' style='background-color:#DDDDDC;font-size: 13px' size='16' onchange='this.form.submit()'>\n
			$student_select
			</select>
			<input type='hidden' name='class_num' value='$class_num'>
			<input type='hidden' name='test_sort' value='$test_sort'>		
			</form>\n
			</td></tr>";
		}
	}

	if($class_num && $test_sort && $student_sn){
		$download="<tr><td><font style='border: 2px outset #EAF6FF'><a href='{$_SERVER['PHP_SELF']}?act=dl_oo_one&test_sort=$test_sort&class_num=$class_num&student_sn=$student_sn'>�U���ӤHSXW</a></font></td></tr>";
		$download2="<tr><td><font style='border: 2px outset #EAF6FF'><a href='{$_SERVER['PHP_SELF']}?act=dl_oo_class&test_sort=$test_sort&class_num=$class_num'>�U�����ZSXW</a></font></td></tr>";
		$download3="<tr><td><font style='border: 2px outset #EAF6FF'><a href='{$_SERVER['PHP_SELF']}?act=dl_pdf_one&test_sort=$test_sort&class_num=$class_num&student_sn=$student_sn'>�U���ӤHPDF</a></font></td></tr>";
		$download4="<tr><td><font style='border: 2px outset #EAF6FF'><a href='{$_SERVER['PHP_SELF']}?act=dl_pdf_class&test_sort=$test_sort&class_num=$class_num'>�U�����ZPDF</a></font></td></tr>";
		//���Z����D
		$title=$school_short_name."<br>".$curr_year."�Ǧ~�ײ�".$curr_seme."�Ǵ���".$test_sort."���w���Ҭd<br>";
		if(sizeof($curr_year)<3) $curr_year="0".$curr_year;
		$class_id=$curr_year."_".$curr_seme."_".sprintf("%02d_%02d",substr($class_num,0,-2),substr($class_num,-2,2));
		$st_arr=student_sn_to_name_num($student_sn);
		$cla_arr=class_id_to_full_class_name($class_id);
		$title.="�Z�šG".$cla_arr."<br>�m�W�G".$st_arr[1]." �y���G".$st_arr[2];
		$paper="<table  cellspacing=1 cellpadding=6 border=0 bgcolor='#A7A7A7' width='100%' >
		<tr bgcolor='#EFFFFF'>
		<td colspan='2'>".$title."</td></tr>";
		if(sizeof($curr_year)<3) $curr_year="0".$curr_year;
		$class_id=$curr_year."_".$curr_seme."_".sprintf("%02d_%02d",substr($class_num,0,-2),substr($class_num,-2,2));
		//���
		$SS=class_id2subject($class_id);
		$i=0;
		foreach($SS as $ss_id => $s_name){
			//���Z
			$score_b[$ss_id]=score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="�w�����q",$test_sort);
			if($score_b[$ss_id]==-100) $score_b[$ss_id]="";
			if($score_b[$ss_id]!="") {$i++; $total=$total+$score_b[$ss_id];}
			$paper.="<tr bgcolor='#E4EDFF'><td>$s_name</td><td>$score_b[$ss_id]</td></tr>";
		}
		$paper.="<tr bgcolor='#D6D8FD'><td>�`��</td><td>$total</td></tr>";
		if($i>0) $aver=round($total/$i,2);
		$paper.="<tr bgcolor='#B2B9F6'><td>����</td><td>".$aver."</td></tr>";
		$paper.="</table>";

	}
	$list="<table><tr><td><form action='{$_SERVER['PHP_SELF']}' method='POST'><select name='test_sort' onchange='this.form.submit()'>$option</select><input type='hidden' name='student_sn' value='$student_sn'></form></td></tr>$student_select $download $download2 $download3 $download4 </table>";
	$main="<table><tr><td valign='top'>$list</td><td valign='top'>$paper</td></tr></table>";

	//�]�w�D������ܰϪ��I���C��
	$back_ground="
		<table cellspacing=1 cellpadding=2 border=0 bgcolor='#B0C0F8' width='100%'>
			<tr bgcolor='#FFFFFF'>
				<td>
					$main
				</td>
			</tr>
		</table>";
	echo $back_ground;

	// SFS3 ������
	foot();
}


function ooo_one($test_sort,$class_num,$student_sn){
	global $CONN,$school_short_name;

	$oo_path = "ooo_one";

	$filename=$class_num."_".$test_sort."_".$student_sn.".sxw";

    //�s�W�@�� zipfile ���
	$ttt = new zipfile;

	//Ū�X xml �ɮ�
	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/META-INF/manifest.xml");

	//�[�J xml �ɮר� zip ���A�@�������ɮ�
	//�Ĥ@�ӰѼƬ���l�r��A�ĤG�ӰѼƬ� zip �ɮת��ؿ��M�W��
	$ttt->add_file($data,"/META-INF/manifest.xml");

	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/settings.xml");
	$ttt->add_file($data,"settings.xml");

	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/styles.xml");
	$ttt->add_file($data,"styles.xml");
                                   
	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/meta.xml");
	$ttt->add_file($data,"meta.xml");

	//Ū�X content.xml
	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/content.xml");

	//�N content.xml �� tag ���N	
	$curr_year = curr_year();
	$curr_seme = curr_seme();
	if(sizeof($curr_year)<3) $curr_year="0".$curr_year;
	$class_id=$curr_year."_".$curr_seme."_".sprintf("%02d_%02d",substr($class_num,0,-2),substr($class_num,-2,2));	
	$year_seme_sort=curr_year()."�Ǧ~�ײ�".$curr_seme."�Ǵ�"."��".$test_sort."���w���Ҭd";
	$class=class_id_to_full_class_name($class_id);
	$school_name=$school_short_name;
	$st=student_sn_to_id_name_num($student_sn,$curr_year="",$curr_seme="");
	$name=$st[1];
	$num=$st[2];
	//echo $school_name.$year_seme_sort.$class_info.$name.$num;
	

	//���
	$count=0;
	$SS=class_id2subject($class_id);
	foreach($SS as $ss_id => $subject_name){	
		//���Z
		$score_b[$ss_id]=score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="�w�����q",$test_sort);
		if($score_b[$ss_id]==-100) $score_b[$ss_id]="";
		if($score_b[$ss_id]!="") {$count++; $total=$total+$score_b[$ss_id];}
				
		$sj_sc.="
			<table:table-row>
			<table:table-cell table:style-name='table1.A2' table:value-type='string'>
			<text:p text:style-name='P3'>
			$subject_name
			</text:p>
			</table:table-cell>
			<table:table-cell table:style-name='table1.B2' table:value-type='string'>
			<text:p text:style-name='P3'>
			{$score_b[$ss_id]}
			</text:p>
			</table:table-cell>
			</table:table-row>
			";
	}
	if($count>0) $aver=round($total/$count,2);
	$teacher=$_SESSION['session_tea_name'];
		
	//�ܼƴ���
    $temp_arr["school_name"] = $school_name;
	$temp_arr["year_seme_sort"] = $year_seme_sort;
	$temp_arr["class"] = $class;	
	$temp_arr["name"] = $name;	
	$temp_arr["num"] = $num;	
	$temp_arr["sj_sc"] = $sj_sc;
	$temp_arr["total"] = $total;	
	$temp_arr["aver"] = $aver;
	$temp_arr["teacher"] = $teacher;
	
	// change_temp �|�N�}�C���� big5 �ର UTF-8 �� openoffice �i�HŪ�X
	$replace_data = $ttt->change_temp($temp_arr,$data);

	// �[�J content.xml ��zip ��
	$ttt->add_file($replace_data,"content.xml");

	//���� zip ��
	$sss = $ttt->file();

	//�H��y�覡�e�X ooo.sxw
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

function ooo_class($test_sort,$class_num){
	global $CONN,$school_short_name;

	$oo_path = "ooo_class";

	$filename=$class_num."_".$test_sort.".sxw";
	
	//���� tag
	$break ="<text:p text:style-name=\"break_page\"/>";
	    
	//�s�W�@�� zipfile ���
	$ttt = new zipfile;

	//Ū�X xml �ɮ�
	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/META-INF/manifest.xml");

	//�[�J xml �ɮר� zip ���A�@�������ɮ�
	//�Ĥ@�ӰѼƬ���l�r��A�ĤG�ӰѼƬ� zip �ɮת��ؿ��M�W��
	$ttt->add_file($data,"/META-INF/manifest.xml");

	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/settings.xml");
	$ttt->add_file($data,"settings.xml");

	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/styles.xml");
	$ttt->add_file($data,"styles.xml");
                                   
	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/meta.xml");
	$ttt->add_file($data,"meta.xml");
	
	if($curr_year=="") $curr_year = curr_year();
	if($curr_seme=="") $curr_seme = curr_seme();	
	$class_id=sprintf("%03d",$curr_year)."_".$curr_seme."_".sprintf("%02d_%02d",substr($class_num,0,-2),substr($class_num,-2,2));
	$student_sn_arr=class_id_to_seme_student_sn($class_id,$yn='0');

	foreach($student_sn_arr as $student_sn){
		//Ū�X content.xml
		$content_body = $ttt->read_file(dirname(__FILE__)."/$oo_path/content_body.xml");

		//�N content_body.xml �� tag ���N

		$year_seme_sort=curr_year()."�Ǧ~�ײ�".$curr_seme."�Ǵ�"."��".$test_sort."���w���Ҭd";
		$class=class_id_to_full_class_name($class_id);
		$school_name=$school_short_name;
		$st=student_sn_to_id_name_num($student_sn,$curr_year="",$curr_seme="");
		$name=$st[1];
		$num=$st[2];
		//echo $school_name.$year_seme_sort.$class_info.$name.$num;


		//���
		$count[$student_sn]=0;
		$SS=class_id2subject($class_id);
		foreach($SS as $ss_id => $subject_name){
			//���Z
			$score_b[$student_sn][$ss_id]=score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="�w�����q",$test_sort);
			if($score_b[$student_sn][$ss_id]==-100) $score_b[$student_sn][$ss_id]="";
			if($score_b[$student_sn][$ss_id]!="") {$count[$student_sn]++; $total[$student_sn]=$total[$student_sn]+$score_b[$student_sn][$ss_id];}

			$sj_sc[$student_sn].="
				<table:table-row>
				<table:table-cell table:style-name='table1.A2' table:value-type='string'>
				<text:p text:style-name='P3'>
				$subject_name
				</text:p>
				</table:table-cell>
				<table:table-cell table:style-name='table1.B2' table:value-type='string'>
				<text:p text:style-name='P3'>
				{$score_b[$student_sn][$ss_id]}
				</text:p>
				</table:table-cell>
				</table:table-row>
				";
		}
		if($count[$student_sn]>0) $aver[$student_sn]=round($total[$student_sn]/$count[$student_sn],2);
		$teacher=$_SESSION['session_tea_name'];

		//�ܼƴ���
		$temp_arr["school_name"] = $school_name;
		$temp_arr["year_seme_sort"] = $year_seme_sort;
		$temp_arr["class"] = $class;
		$temp_arr["name"] = $name;
		$temp_arr["num"] = $num;
		$temp_arr["sj_sc"] = $sj_sc[$student_sn];
		$temp_arr["total"] = $total[$student_sn];
		$temp_arr["aver"] = $aver[$student_sn];
		$temp_arr["teacher"] = $teacher;

		//����
		$content_body .= $break;

		//change_temp �|�N�}�C���� big5 �ର UTF-8 �� openoffice �i�HŪ�X
		$replace_data.= $ttt->change_temp($temp_arr,$content_body);
	}

	//Ū�X XML ���Y
	$doc_head = $ttt->read_file(dirname(__FILE__)."/$oo_path/content_head.xml");
	//Ū�X XML �ɧ�
	$doc_foot = $ttt->read_file(dirname(__FILE__)."/$oo_path/content_foot.xml");

	$replace_data =$doc_head.$replace_data.$doc_foot;
	// �[�J content.xml ��zip ��
	$ttt->add_file($replace_data,"content.xml");

	//���� zip ��
	$sss = $ttt->file();

	//�H��y�覡�e�X ooo.sxw
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

?>
