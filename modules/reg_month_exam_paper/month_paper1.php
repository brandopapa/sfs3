<?php
// $Id: month_paper1.php 7709 2013-10-23 12:24:27Z smallduh $

// �ޤJ SFS3 ���禡�w
include "../../include/config.php";

// �ޤJ�z�ۤv�� config.php ��
require "config.php";

// �{��
sfs_check();

	//�ഫ�������ܼ�
$act=($_POST['act'])?"{$_POST['act']}":"{$_GET['act']}";
$test_sort=($_POST['test_sort'])?"{$_POST['test_sort']}":"{$_GET['test_sort']}";
$class_num=($_POST['class_num'])?"{$_POST['class_num']}":"{$_GET['class_num']}";
$class_seme=($_POST['class_seme'])?"{$_POST['class_seme']}":"{$_GET['class_seme']}";
$class_base=($_POST['class_base'])?"{$_POST['class_base']}":"{$_GET['class_base']}";

if($act=="dl_oo"){

	OOO($test_sort,$class_num,$class_seme);

}
else{

	// �s�� SFS3 �����Y
	head("��Ҧ��Z��");

	// �z���{���X�Ѧ��}�l
	print_menu($menu_p);
	
	//�Ǧ~�Ǵ��Z�ſ��
	$class_seme_array=get_class_seme();
	$class_seme_select.="<form action='{$_SERVER['PHP_SELF']}' method='POST' name='form1'>\n<select  name='class_seme' onchange='this.form.submit()'>\n";
	$i=0;
	foreach($class_seme_array as $k => $v){
		if(!$class_seme) $class_seme=sprintf("%03d%d",curr_year(),curr_seme());
		$selected[$i]=($class_seme==$k)?" selected":" ";	
		$class_seme_select.="<option value='$k'$selected[$i] >$v</option> \n";
		$i++;
	}
	$class_seme_select.="</select></form>\n";

	$class_base_array=class_base($class_seme);
	$class_base_select.="<form action='{$_SERVER['PHP_SELF']}' method='POST' name='form2'>\n<select  name='class_base' onchange='this.form.submit()'>\n";
	$j=0;
	foreach($class_base_array as $k2 => $v2){
		if(!$class_base) $class_base=$k2;
		$selected2[$j]=($class_base==$k2)?" selected":" ";	
		$class_base_select.="<option value='$k2'$selected2[$j] >$v2</option> \n";
		$j++;
	}
	$class_base_select.="</select><input type='hidden' name='class_seme' value='$class_seme'></form>\n";
	$menu="<td nowrap width='1%' align='left'> $class_seme_select </td><td nowrap width='1%' align='left'> $class_base_select </td>";
	$class_num=$class_base;
	$curr_year = substr($class_seme,0,-1);
	$curr_seme =  substr($class_seme,-1);
	
	if($class_num){
		//���q���
		$option=test_sort_select($curr_year,$curr_seme,$class_num);
		if($test_sort)	$download="<td nowrap  align='left' width='96%'><font style='border: 2px outset #EAF6FF'><a href='{$_SERVER['PHP_SELF']}?act=dl_oo&test_sort=$test_sort&class_num=$class_num&class_seme=$class_seme'>�U�����Z�`��</a></font></td>";
		$menu.="<td nowrap  align='left'><form action='{$_SERVER['PHP_SELF']}' method='POST'><select name='test_sort' onchange='this.form.submit()'>$option</select><input type='hidden' name='class_seme' value='$class_seme'><input type='hidden' name='class_base' value='$class_base'></form></td>$download";		
		if($test_sort){		
			//���Ǵ����ЯZ�ťN��
			if(sizeof($curr_year)<3) $curr_year="0".$curr_year;
			$class_id=$curr_year."_".$curr_seme."_".sprintf("%02d_%02d",substr($class_num,0,-2),substr($class_num,-2,2));		
			//���
			$SS=class_id2subject($class_id);
			$t1="<table  cellspacing=1 cellpadding=6 border=0 bgcolor='#A7A7A7' width='100%' >";
			$t2="<tr bgcolor='#00C000'><td>�y��</td><td>�m�W</td>";
			foreach($SS as $ss_id => $subject_name){
				$t2.="<td>$subject_name</td>";
			}
			$t2.="<td>�`��</td><td>����</td><td>�W��</td></tr>";
			//�ǥͻP���Z
			$t3="<tr>";
			//��X�ӯZ�ǥͬy�����}�C
			$st_array=class_id_to_student_sn($class_id);

			$p=0;		
			foreach ($st_array as $student_sn){			
				foreach($SS as $ss_id => $s_name){				
					//���Z
					$score_b[$ss_id]=score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="�w�����q",$test_sort);
					if($score_b[$ss_id]==-100) $score_b[$ss_id]="";
					if($score_b[$ss_id]!="") {$count_b[$p]++; $count_stud[$ss_id]++;}
					$total_score_b[$p]=$total_score_b[$p]+$score_b[$ss_id];
					$calss_score[$ss_id]=$calss_score[$ss_id]+$score_b[$ss_id];

				}			
				$avg_score_b[$p]=$total_score_b[$p]/$count_b[$p];
				//echo $avg_score_b[$p]."<br>";
				$p++;		
			}

			$i=0;
			$j=0;
			foreach ($st_array as $student_sn){
				//��X�y���A�m�W�A�Ѿǥͬy����
				$classinfo_array=student_sn_to_classinfo($student_sn);
				$t3.="<td bgcolor='#A3C7FD'>$classinfo_array[2]</td><td  bgcolor='#84A2CE'>$classinfo_array[4]</td>";
				foreach($SS as $ss_id => $subject_name){
					//���Z
					$score=score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="�w�����q",$test_sort);
					if($score==-100) $score="";
					if($score!="") $count_subj[$j]++;
					$bgcolor=($score<60 && $score!="")?"#F8AAAA":"#FFFFFF";
					$t3.="<td bgcolor='$bgcolor' >".$score."</td>";
					if($score) $total_score[$i]=$total_score[$i]+$score;
				}
				$avg_score[$i]=$total_score[$i]/$count_subj[$j];
				if($total_score[$i]) $avg_score_r[$i]=round($total_score[$i]/$count_subj[$j],2);
				//�ƦW
				//echo $avg_score[$i].$avg_score_b."<br>";
				if($avg_score[$i]) $sort_name[$i]=sort_sort($avg_score[$i],$avg_score_b);
				$t3.="<td bgcolor='#BED7FD'>$total_score[$i]</td><td bgcolor='#A3C7FD'>$avg_score_r[$i]</td><td bgcolor='#84A2CE'>$sort_name[$i]</td></tr>";	
				$i++;
				$j++;	
			}

			foreach($SS as $ss_id => $subject_name){
				if($calss_score[$ss_id]) $X[$ss_id]=round($calss_score[$ss_id]/$count_stud[$ss_id],2);
				$X_str.="<td>".$X[$ss_id]."</td>";

			}							

			$t4="<tr bgcolor='#DF9D57'><td colspan=2>������</td>$X_str<td></td><td></td><td></td></tr>";		
		}
			$main.=$t1.$t2.$t3.$t4."</table>";
	}
	else{
		$main="<table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> ĵ�i</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'>".$_SESSION['session_tea_name']."�z����ɮv�����I �L�k�i��ާ@�I<br>�Y���ðݽ��ˬd�y�Юv�޲z�z����¾��ơC</td></tr></table>";
	}

	//�]�w�D������ܰϪ��I���C��
	/*
	$back_ground="
		<table cellspacing=1 cellpadding=6 border=0 bgcolor='#B0C0F8' width='100%'>
			<tr bgcolor='#FFFFFF'>
				<td>
					$main
				</td>
			</tr>
		</table>";
	echo $back_ground;
	*/
	$back_ground="
		<table cellspacing=1 cellpadding=0 border=0  bgcolor='#BBBBBB' width='100%'>
			<tr>
				<td>
					<table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFFFFF' width='100%'>
						<tr>
							$menu
						</tr>
					</table>
					<table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFFFFF' width='100%'>
						<tr>
							<td colspan='2'>
								$main
							</td>
						</tr>		
					</table>
				</td>
			</tr>
		</table>";
	echo $back_ground;
	// SFS3 ������
	foot();
}

function ooo($test_sort,$class_num,$class_seme){
	global $CONN,$school_long_name;

	$oo_path = "ooo_total";

	$filename=$class_num."_".$test_sort.".sxw";

    //�s�W�@�� zipfile ���
	$ttt = new EasyZip;
	$ttt->setPath($oo_path);
	$ttt->addDir('META-INF');
	$ttt->addfile('settings.xml');
	$ttt->addfile('styles.xml');
	$ttt->addfile('meta.xml');
	//Ū�X content.xml
	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/content.xml");

	//�N content.xml �� tag ���N	
	$curr_year = substr($class_seme,0,-1);
	$curr_seme =  substr($class_seme,-1);
	if(sizeof($curr_year)<3) $curr_year="0".$curr_year;
	$class_id=$curr_year."_".$curr_seme."_".sprintf("%02d_%02d",substr($class_num,0,-2),substr($class_num,-2,2));	
	$class_info=curr_year()."�Ǧ~�ײ�".$curr_seme."�Ǵ�".class_id_to_full_class_name($class_id);
	$school_name=$school_long_name;	
	$test_info="��".$test_sort."���w���Ҭd";

	//���
	$SS=class_id2subject($class_id);
	foreach($SS as $ss_id => $subject_name){
		$subj_str.="<table:table-cell table:style-name='tablec1.A1' table:value-type='string'><text:p text:style-name='Table Contents'>$subject_name</text:p></table:table-cell>";
	}
	
	
	//��X�ӯZ�ǥͬy�����}�C
	$st_array=class_id_to_student_sn($class_id);
	$p=0;		
	foreach ($st_array as $student_sn){			
		foreach($SS as $ss_id => $s_name){				
			//���Z
			$score_b[$ss_id]=score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="�w�����q",$test_sort);
			if($score_b[$ss_id]==-100) $score_b[$ss_id]="";
			if($score_b[$ss_id]!="") {$count_b[$p]++; $count_stud[$ss_id]++;}
			$total_score_b[$p]=$total_score_b[$p]+$score_b[$ss_id];
			$calss_score[$ss_id]=$calss_score[$ss_id]+$score_b[$ss_id];
		}
		$avg_score_b[$p]=$total_score_b[$p]/$count_b[$p];
		$p++;		
	}

	$i=0;
	$j=0;
	foreach ($st_array as $student_sn){
		//��X�y���A�m�W�A�Ѿǥͬy����
		$classinfo_array=student_sn_to_classinfo($student_sn);
		$one_student.="
			<table:table-row>
			<table:table-cell table:style-name='tablec1.A2' table:value-type='string'>
			<text:p text:style-name='P3'>$classinfo_array[2]
			</text:p>
			</table:table-cell>
			<table:table-cell table:style-name='tablec1.A2' table:value-type='string'>
			<text:p text:style-name='P3'>$classinfo_array[4]
			</text:p>
			</table:table-cell>";
		foreach($SS as $ss_id => $subject_name){
			//���Z
			$score=score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="�w�����q",$test_sort);
			if($score==-100) $score="";
			if($score!="") $count_subj[$j]++;
			$bgcolor=($score<60 && $score!="")?"#F8AAAA":"#FFFFFF";
			$one_student.="
			<table:table-cell table:style-name='tablec1.A2' table:value-type='string'>
			<text:p text:style-name='P3'>$score
			</text:p>
			</table:table-cell>";
			if($score) $total_score[$i]=$total_score[$i]+$score;
		}
		$avg_score[$i]=$total_score[$i]/$count_subj[$j];
		if($total_score[$i]) $avg_score_r[$i]=round($total_score[$i]/$count_subj[$j],2);
		//�ƦW
		//echo $avg_score[$i].$avg_score_b."<br>";
		if($avg_score[$i]) $sort_name[$i]=sort_sort($avg_score[$i],$avg_score_b);
		//$t3.="<td bgcolor='#BED7FD'>$total_score[$i]</td><td bgcolor='#A3C7FD'>$avg_score_r[$i]</td><td bgcolor='#84A2CE'>$sort_name[$i]</td></tr>";	
		$one_student.="
		<table:table-cell table:style-name='tablec1.A2' table:value-type='string'>
		<text:p text:style-name='P3'>$total_score[$i]
		</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='tablec1.A2' table:value-type='string'>
		<text:p text:style-name='P3'>$avg_score_r[$i]</text:p></table:table-cell>
		<table:table-cell table:style-name='tablec1.G2' table:value-type='string'>
		<text:p text:style-name='P3'>$sort_name[$i]
		</text:p>
		</table:table-cell>
		</table:table-row>
		";
		$i++;
		$j++;	
	}

	foreach($SS as $ss_id => $subject_name){
		if($calss_score[$ss_id]) $X[$ss_id]=round($calss_score[$ss_id]/$count_stud[$ss_id],2);
		//$X_str.="<td>".$X[$ss_id]."</td>";
		$X_str.="
		<table:covered-table-cell/>
		<table:table-cell table:style-name='tablec1.A2' table:value-type='string'>
		<text:p text:style-name='P3'>$X[$ss_id]
		</text:p>
		</table:table-cell>";
	}
		
	
    $temp_arr["school_name"] = $school_name;
	$temp_arr["class_info"] = $class_info;
	$temp_arr["test_info"] = $test_info;
	$temp_arr["subj"] = $subj_str;	
	$temp_arr["colum"] = count($SS)+5;
	$temp_arr["one_student"] = $one_student;
	$temp_arr["X_str"] = $X_str;
	
	// change_temp �|�N�}�C���� big5 �ର UTF-8 �� openoffice �i�HŪ�X
	$replace_data = $ttt->change_temp($temp_arr,$data);

	// �[�J content.xml ��zip ��
	$ttt->add_file($replace_data,"content.xml");

	//���� zip ��
	$sss = & $ttt->file();

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
