<?php
// $Id: month_paper3.php 5310 2009-01-10 07:57:56Z hami $

//�[�J�]�t���ɦ��Z�M�[�v���֨�

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
$add_nor=($_POST['add_nor'])?"{$_POST['add_nor']}":"{$_GET['add_nor']}";
$add_wet=($_POST['add_wet'])?"{$_POST['add_wet']}":"{$_GET['add_wet']}";
$class_seme=($_POST['class_seme'])?"{$_POST['class_seme']}":"{$_GET['class_seme']}";
$class_base=($_POST['class_base'])?"{$_POST['class_base']}":"{$_GET['class_base']}";

$curr_year = curr_year();
$curr_seme = curr_seme();


if($act=="dl_pdf" ){//pdf�����X
				if(sizeof($curr_year)<3) $curr_year="0".$curr_year;
				$title.=$school_long_name;
				$class_id=$curr_year."_".$curr_seme."_".sprintf("%02d_%02d",substr($class_num,0,-2),substr($class_num,-2,2));
				$title.=curr_year()."�Ǧ~�ײ�".$curr_seme."�Ǵ�".class_id_to_full_class_name($class_id);
				$title.="��".$test_sort."���w���Ҭd";
				if($add_nor){
					$checked=" checked";
					$ratio=test_ratio($curr_year,$curr_seme);//���Ǵ������Z�]�w
					$R0=($ratio[substr($class_num,0,-2)][$test_sort-1][0])*100/($ratio[substr($class_num,0,-2)][$test_sort-1][0] + $ratio[substr($class_num,0,-2)][$test_sort-1][1]);
					$R1=($ratio[substr($class_num,0,-2)][$test_sort-1][1])*100/($ratio[substr($class_num,0,-2)][$test_sort-1][0] + $ratio[substr($class_num,0,-2)][$test_sort-1][1]);
					//$rowspan=" rowspan='2'";
					//$colspan=" colspan='2'";
				}
				if($add_wet){
					$wchecked=" checked";
				}
				//$nor_form="<form><input type='hidden' name='add_wet' value='$add_wet'><input type='hidden' name='class_num' value='$class_num'><input type='hidden' name='test_sort' value='$test_sort'><input type='checkbox' name='add_nor'$checked value='1' onclick='this.form.submit()'>�]�t���ɦ��Z</form>";
				//$wet_form="<form><input type='hidden' name='add_nor' value='$add_nor'><input type='hidden' name='class_num' value='$class_num'><input type='hidden' name='test_sort' value='$test_sort'><input type='checkbox' name='add_wet'$wchecked value='1' onclick='this.form.submit()'>�]�t�U��[�v</form>";
				//���Ǵ����ЯZ�ťN��
				if(sizeof($curr_year)<3) $curr_year="0".$curr_year;
				$class_id=$curr_year."_".$curr_seme."_".sprintf("%02d_%02d",substr($class_num,0,-2),substr($class_num,-2,2));
				//���
				$SS=class_id2subject($class_id);
				//$t1="<table  cellspacing=1 cellpadding=6 border=0 bgcolor='#A7A7A7' width='100%' >";
				$header=array("�y��","�m�W");
				foreach($SS as $ss_id => $subject_name){
					$wet=subj_wet($ss_id);
					if($add_wet) array_push($header,"$subject_name * $wet");
					else array_push($header,"$subject_name");
				}
				array_push($header,"�`��","����","�W��");
					//�ǥͻP���Z
				//��X�ӯZ�ǥͬy�����}�C
				$st_array=class_id_to_student_sn($class_id);
				$p=0;
				foreach ($st_array as $student_sn){
					$total_wet_b=0;
					foreach($SS as $ss_id => $s_name){
						$wet=subj_wet($ss_id);
						//��Ҧ��Z
						$score_b[$ss_id]=score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="�w�����q",$test_sort);
						if($score_b[$ss_id]==-100) $score_b[$ss_id]="";
						if($score_b[$ss_id]!="") {$count_b[$p]++; $count_stud[$ss_id]++;}
						if($add_wet) $score_b[$ss_id]=$score_b[$ss_id]*$wet;
						$total_score_b[$p]=$total_score_b[$p]+$score_b[$ss_id];
						$calss_score[$ss_id]=$calss_score[$ss_id]+$score_b[$ss_id];
						if($add_nor){
						//���ɦ��Z
							$score_b_nor[$ss_id]=score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="���ɦ��Z",$test_sort);
							if($score_b_nor[$ss_id]==-100) $score_b_nor[$ss_id]="";
							if($score_b_nor[$ss_id]!="") {$count_b_nor[$p]++; $count_stud_nor[$ss_id]++;}
							if($add_wet) $score_b_nor[$ss_id]=$score_b_nor[$ss_id]*$wet;
							$total_score_b_nor[$p]=$total_score_b_nor[$p]+$score_b_nor[$ss_id];
							$calss_score_nor[$ss_id]=$calss_score_nor[$ss_id]+$score_b_nor[$ss_id];
							$an_total_score_b_nor[$p]=(($total_score_b[$p]*$R0)+($total_score_b_nor[$p]*$R1))/($R0+$R1);
						}
						if($score_b[$ss_id] || $score_b_nor[$ss_id]) $total_wet_b=$total_wet_b+$wet;
					}
					if($add_wet){
						if($add_nor) $avg_score_b[$p]=strval($an_total_score_b_nor[$p]/$total_wet_b);
						else $avg_score_b[$p]=strval($total_score_b[$p]/$total_wet_b);
					}else{
						if($add_nor) $avg_score_b[$p]=strval($an_total_score_b_nor[$p]/max($count_b[$p],$count_b_nor[$p]));
						else $avg_score_b[$p]=strval($total_score_b[$p]/$count_b[$p]);

					}
					$p++;
    			}

				$i=0;
				$j=0;
				$k=0;
				foreach ($st_array as $student_sn){
					$data[$k]=array();
					//��X�y���A�m�W�A�Ѿǥͬy����
					$classinfo_array=student_sn_to_classinfo($student_sn);
					array_push($data[$k],$classinfo_array[2],$classinfo_array[4]);
					$total_wet=0;
					foreach($SS as $ss_id => $subject_name){
						$wet=subj_wet($ss_id);
						//��Ҧ��Z
						$score=score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="�w�����q",$test_sort);
						if($score==-100) $score="";
						if($score!="") $count_subj[$j]++;
						//���ɦ��Z
						if($add_nor){
							$score_nor=score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="���ɦ��Z",$test_sort);
							if($score_nor==-100) $score_nor="";
							if($score_nor!="") $count_subj_nor[$j]++;
						}
						if($add_nor) {
							$TT_score=(($score*$R0+$score_nor*$R1)/($R0+$R1));
							array_push($data[$k],"$TT_score");
						}else {
							array_push($data[$k],"$score");
						}
						if($add_wet){
							if($score) $total_score[$i]=($total_score[$i]+($score*$wet));//��ҬY���`��
							if($score_nor) $total_score_nor[$i]=($total_score_nor[$i]+($score_nor*$wet));//���ɦҬY���`��
							if($add_nor && ($score || $score_nor)) {
								$an_total_score[$i]=$an_total_score[$i]+((($score*$wet*$R0)+($score_nor*$wet*$R1))/($R0+$R1));
								$total_wet=$total_wet+$wet;
							}
							elseif($score || $score_nor) $total_wet=$total_wet+$wet;

						}else{
							if($score) $total_score[$i]=$total_score[$i]+$score;//��ҬY���`��
							if($score_nor) $total_score_nor[$i]=$total_score_nor[$i]+$score_nor;//���ɦҬY���`��
							if($add_nor && ($score || $score_nor)) $an_total_score[$i]=$an_total_score[$i]+((($score*$R0)+($score_nor*$R1))/($R0+$R1));
						}
					}
					if($add_wet){
						if($add_nor) {
							$an_avg_score[$i]=strval($an_total_score[$i]/$total_wet);
							if($an_total_score[$i]) $an_avg_score_r[$i]=round($an_avg_score[$i],2);
						}else{
							$avg_score[$i]=strval($total_score[$i]/$total_wet);
							if($total_score[$i]) $avg_score_r[$i]=round($avg_score[$i],2);
						}
					}else{
						if($add_nor) {
							$an_avg_score[$i]=strval($an_total_score[$i]/max($count_subj[$j],$count_subj_nor[$j]));
							if($an_total_score[$i]) $an_avg_score_r[$i]=round($an_avg_score[$i],2);
						}else{
							$avg_score[$i]=strval($total_score[$i]/$count_subj[$j]);
							if($total_score[$i]) $avg_score_r[$i]=round($total_score[$i]/$count_subj[$j],2);
						}
					}
					//�ƦW
					//echo $avg_score[$i].$avg_score_b."<br>";
					if($add_nor){
						if($an_avg_score[$i]) $sort_name[$i]=sort_sort($an_avg_score[$i],$avg_score_b);
					}else{
						if($avg_score[$i]) $sort_name[$i]=sort_sort($avg_score[$i],$avg_score_b);
					}

					if($add_nor) array_push($data[$k],"$an_total_score[$i]","$an_avg_score_r[$i]","$sort_name[$i]");
					else array_push($data[$k],"$total_score[$i]","$avg_score_r[$i]","$sort_name[$i]");
					$i++;
					$j++;
					$k++;
				}
				creat_pdf($title,$header,$data);
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

	if($class_num){
		//���q���
		$option=test_sort_select($curr_year,$curr_seme,$class_num);
		if($test_sort)	$download="<td nowrap  align='left' width='96%'><font style='border: 2px outset #EAF6FF'><a href='{$_SERVER['PHP_SELF']}?act=dl_pdf&test_sort=$test_sort&class_num=$class_num&add_nor=$add_nor&add_wet=$add_wet'>�U��PDF</a></font></td>";
		//$main="<table><tr><td><form action='{$_SERVER['PHP_SELF']}' method='POST'><select name='test_sort' onchange='this.form.submit()'>$option</select></form></td>$download</tr></table>";
		$menu.="<td nowrap  align='left'><form action='{$_SERVER['PHP_SELF']}' method='POST'><select name='test_sort' onchange='this.form.submit()'>$option</select><input type='hidden' name='class_seme' value='$class_seme'><input type='hidden' name='class_base' value='$class_base'></form></td>$download";
		if($test_sort){
			if($add_nor){
				$checked=" checked";
				$ratio=test_ratio($curr_year,$curr_seme);//���Ǵ������Z�]�w
				$R0=($ratio[substr($class_num,0,-2)][$test_sort-1][0])*100/($ratio[substr($class_num,0,-2)][$test_sort-1][0] + $ratio[substr($class_num,0,-2)][$test_sort-1][1]);
				$R1=($ratio[substr($class_num,0,-2)][$test_sort-1][1])*100/($ratio[substr($class_num,0,-2)][$test_sort-1][0] + $ratio[substr($class_num,0,-2)][$test_sort-1][1]);
				$rowspan=" rowspan='2'";
				$colspan=" colspan='2'";
			}
			if($add_wet){
				$wchecked=" checked";


			}
			$nor_form="<form><input type='hidden' name='add_wet' value='$add_wet'><input type='hidden' name='class_num' value='$class_num'><input type='hidden' name='test_sort' value='$test_sort'><input type='hidden' name='class_seme' value='$class_seme'><input type='hidden' name='class_base' value='$class_base'><input type='checkbox' name='add_nor'$checked value='1' onclick='this.form.submit()'>�]�t���ɦ��Z</form>";
			$wet_form="<form><input type='hidden' name='add_nor' value='$add_nor'><input type='hidden' name='class_num' value='$class_num'><input type='hidden' name='test_sort' value='$test_sort'><input type='hidden' name='class_seme' value='$class_seme'><input type='hidden' name='class_base' value='$class_base'><input type='checkbox' name='add_wet'$wchecked value='1' onclick='this.form.submit()'>�]�t�U��[�v</form>";
			//���Ǵ����ЯZ�ťN��
			if(sizeof($curr_year)<3) $curr_year="0".$curr_year;
			$class_id=$curr_year."_".$curr_seme."_".sprintf("%02d_%02d",substr($class_num,0,-2),substr($class_num,-2,2));
			//���
			$SS=class_id2subject($class_id);
			$t1="<table  cellspacing=1 cellpadding=6 border=0 bgcolor='#A7A7A7' width='100%' >";
			$t2="<tr bgcolor='#00C000'><td$rowspan>�y��</td><td$rowspan>�m�W</td>";
			foreach($SS as $ss_id => $subject_name){
				$wet=subj_wet($ss_id);
				if($add_wet) $t2.="<td$colspan>$subject_name * $wet </td>";
				else $t2.="<td$colspan>$subject_name</td>";
			}
			$t2.="<td$rowspan>�`��</td><td$rowspan>����</td><td$rowspan>�W��</td></tr>";
			if($add_nor) {
				$t2.="<tr bgcolor='#B6C9FD'>";
				foreach($SS as $ss_id => $subject_name){
					$t2.="<td>���".round($R0)."%</td><td>����".round($R1)."%</td>";
				}
				$t2.="</tr>";
			}
			//�ǥͻP���Z
			$t3="<tr>";
			//��X�ӯZ�ǥͬy�����}�C
			$st_array=class_id_to_student_sn($class_id);
			$p=0;
			foreach ($st_array as $student_sn){
				$total_wet_b=0;
				foreach($SS as $ss_id => $s_name){
					$wet=subj_wet($ss_id);
					//��Ҧ��Z
					$score_b[$ss_id]=score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="�w�����q",$test_sort);
					if($score_b[$ss_id]==-100) $score_b[$ss_id]="";
					if($score_b[$ss_id]!="") {$count_b[$p]++; $count_stud[$ss_id]++;}
					if($add_wet) $score_b[$ss_id]=$score_b[$ss_id]*$wet;
					$total_score_b[$p]=$total_score_b[$p]+$score_b[$ss_id];
					$calss_score[$ss_id]=$calss_score[$ss_id]+$score_b[$ss_id];
					if($add_nor){
					//���ɦ��Z
						$score_b_nor[$ss_id]=score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="���ɦ��Z",$test_sort);
						if($score_b_nor[$ss_id]==-100) $score_b_nor[$ss_id]="";
						if($score_b_nor[$ss_id]!="") {$count_b_nor[$p]++; $count_stud_nor[$ss_id]++;}
						if($add_wet) $score_b_nor[$ss_id]=$score_b_nor[$ss_id]*$wet;
						$total_score_b_nor[$p]=$total_score_b_nor[$p]+$score_b_nor[$ss_id];
						$calss_score_nor[$ss_id]=$calss_score_nor[$ss_id]+$score_b_nor[$ss_id];
						$an_total_score_b_nor[$p]=(($total_score_b[$p]*$R0)+($total_score_b_nor[$p]*$R1))/($R0+$R1);
					}
					if($score_b[$ss_id] || $score_b_nor[$ss_id]) $total_wet_b=$total_wet_b+$wet;
				}
				if($add_wet){
					if($add_nor) $avg_score_b[$p]=strval($an_total_score_b_nor[$p]/$total_wet_b);
					else $avg_score_b[$p]=strval($total_score_b[$p]/$total_wet_b);
				}else{
					if($add_nor) $avg_score_b[$p]=strval($an_total_score_b_nor[$p]/max($count_b[$p],$count_b_nor[$p]));
					else $avg_score_b[$p]=strval($total_score_b[$p]/$count_b[$p]);

				}
				$p++;
			}

			$i=0;
			$j=0;
			foreach ($st_array as $student_sn){
				//��X�y���A�m�W�A�Ѿǥͬy����
				$classinfo_array=student_sn_to_classinfo($student_sn);
				if($add_nor) $t3.="<tr><td$rowspan bgcolor='#A3C7FD'>$classinfo_array[2]</td><td$rowspan  bgcolor='#84A2CE'>$classinfo_array[4]</td>";
				else $t3.="<tr><td bgcolor='#A3C7FD'>$classinfo_array[2]</td><td  bgcolor='#84A2CE'>$classinfo_array[4]</td>";
				if($add_nor) $t33="<tr>";
				$total_wet=0;
				foreach($SS as $ss_id => $subject_name){
					$wet=subj_wet($ss_id);
					//��Ҧ��Z
					$score=score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="�w�����q",$test_sort);
					if($score==-100) $score="";
					if($score!="") $count_subj[$j]++;
					$bgcolor=($score<60 && $score!="")?"#F8AAAA":"#FFFFFF";
					//���ɦ��Z
					if($add_nor){
						$score_nor=score_base($curr_year,$curr_seme,$student_sn,$ss_id,$test_kind="���ɦ��Z",$test_sort);
						if($score_nor==-100) $score_nor="";
						if($score_nor!="") $count_subj_nor[$j]++;
						$bgcolor_nor=($score_nor<60 && $score_nor!="")?"#F8AAAA":"#FFFFFF";
					}
					if($add_nor) {
						$t3.="<td bgcolor='$bgcolor' >".$score."</td><td bgcolor='$bgcolor_nor' >".$score_nor."</td>";
						if($score || $score_nor) $t33.="<td$colspan  bgcolor='#FFEBA3' align='center'>".number_format((($score*$R0+$score_nor*$R1)/($R0+$R1)),2)."</td>";
						else $t33.="<td$colspan bgcolor='#FFEBA3' align='center'></td>";
					}else {
						$t3.="<td bgcolor='$bgcolor' >".$score."</td>";
					}
					if($add_wet){
						if($score) $total_score[$i]=($total_score[$i]+($score*$wet));//��ҬY���`��
						if($score_nor) $total_score_nor[$i]=($total_score_nor[$i]+($score_nor*$wet));//���ɦҬY���`��
						if($add_nor && ($score || $score_nor)) {
							$an_total_score[$i]=$an_total_score[$i]+((($score*$wet*$R0)+($score_nor*$wet*$R1))/($R0+$R1));
							$total_wet=$total_wet+$wet;
						}
						elseif($score || $score_nor) $total_wet=$total_wet+$wet;

					}else{
						if($score) $total_score[$i]=$total_score[$i]+$score;//��ҬY���`��
						if($score_nor) $total_score_nor[$i]=$total_score_nor[$i]+$score_nor;//���ɦҬY���`��
						if($add_nor && ($score || $score_nor)) $an_total_score[$i]=$an_total_score[$i]+((($score*$R0)+($score_nor*$R1))/($R0+$R1));
					}
				}
				if($add_wet){
					if($add_nor) {
						$an_avg_score[$i]=strval($an_total_score[$i]/$total_wet);
						if($an_total_score[$i]) $an_avg_score_r[$i]=round($an_avg_score[$i],2);
					}else{
						$avg_score[$i]=strval($total_score[$i]/$total_wet);
						if($total_score[$i]) $avg_score_r[$i]=round($avg_score[$i],2);
					}
				}else{
					if($add_nor) {
						$an_avg_score[$i]=strval($an_total_score[$i]/max($count_subj[$j],$count_subj_nor[$j]));
						if($an_total_score[$i]) $an_avg_score_r[$i]=round($an_avg_score[$i],2);
					}else{
						$avg_score[$i]=strval($total_score[$i]/$count_subj[$j]);
						if($total_score[$i]) $avg_score_r[$i]=round($total_score[$i]/$count_subj[$j],2);
					}
				}
				//�ƦW
				//echo $avg_score[$i].$avg_score_b."<br>";
				if($add_nor){
					if($an_avg_score[$i]) $sort_name[$i]=sort_sort($an_avg_score[$i],$avg_score_b);
				}else{
					if($avg_score[$i]) $sort_name[$i]=sort_sort($avg_score[$i],$avg_score_b);
				}


				if($add_nor) $t33.="</tr>";
				if($add_nor) $t3.="<td$rowspan bgcolor='#BED7FD'>$an_total_score[$i]</td><td$rowspan bgcolor='#A3C7FD'>$an_avg_score_r[$i]</td><td$rowspan bgcolor='#84A2CE'>$sort_name[$i]</td></tr>";
				else $t3.="<td$rowspan bgcolor='#BED7FD'>$total_score[$i]</td><td$rowspan bgcolor='#A3C7FD'>$avg_score_r[$i]</td><td$rowspan bgcolor='#84A2CE'>$sort_name[$i]</td></tr>";
				if($add_nor) $t3.=$t33;
				$i++;
				$j++;
			}

			foreach($SS as $ss_id => $subject_name){
				if($add_nor) {
					if($calss_score[$ss_id]) $X[$ss_id]=round($calss_score[$ss_id]/$count_stud[$ss_id],2);
					if($calss_score_nor[$ss_id]) $X_nor[$ss_id]=round($calss_score_nor[$ss_id]/$count_stud_nor[$ss_id],2);
					if($calss_score[$ss_id] || $calss_score_nor[$ss_id]) $XX[$ss_id]=round(((($X[$ss_id]*$R0)+($X_nor[$ss_id]*$R1))/($R0+$R1)),2);
					$X_str.="<td$colspan>".$XX[$ss_id]."</td>";
				}
				else{
					if($calss_score[$ss_id]) $X[$ss_id]=round($calss_score[$ss_id]/$count_stud[$ss_id],2);
					$X_str.="<td$colspan>".$X[$ss_id]."</td>";
				}

			}

			$t4="<tr bgcolor='#DF9D57'><td colspan=2>������</td>$X_str<td></td><td></td><td></td></tr>";
		}
			$main.=$nor_form.$wet_form.$t1.$t2.$t3.$t4."</table>";
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


?>
