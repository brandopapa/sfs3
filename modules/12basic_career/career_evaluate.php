<?php

// $Id:  $

//���o�]�w��
include_once "config.php";
include "../../include/sfs_case_score.php";

sfs_check();

//�q�X����
head("�ͲP�o�i�W����");

//�Ҳտ��
print_menu($menu_p,$linkstr);

$menu=$_POST['menu'];

//�x�s�����B�z
if($_POST['go']=='�x�s����'){
	switch($menu){
		case 1:
			$factor=serialize($_POST['evaluate']);
			$query="update career_course set factor='$factor' where sn={$_POST['sn']}";
			$res=$CONN->Execute($query) or die("SQL���~:$query");	
			break;
		case 3:
			$parent=implode(',',$_POST['parent']);
			$tutor=implode(',',$_POST['tutor']);
			$guidance=implode(',',$_POST['guidance']);
			$query="update career_opinion set parent='$parent',parent_memo='{$_POST['parent_memo']}',tutor='$tutor',tutor_memo='{$_POST['tutor_memo']}',guidance='$guidance',guidance_memo='{$_POST['guidance_memo']}' where sn={$_POST['sn']}";
			$res=$CONN->Execute($query) or die("SQL���~:$query");	
			break;
	}
}


if($student_sn){
	//����ǥ;Ǵ��NŪ�Z��
	$stud_seme_arr=get_student_seme($student_sn);

	//���Ϳ��
	$memu_select="���ڭn�˵��γ]�w�G";
	$menu_arr=array(1=>'���@�ۧڵ���',2=>'�ͲP�ؼ�',3=>'�v����X�N��');
	foreach($menu_arr as $key=>$title){
		$checked=($menu==$key)?'checked':''; 
		$color=($menu==$key)?'#0000ff':'#000000'; 
		$memu_select.="<input type='radio' name='menu' value='$key' $checked onclick='this.form.submit();'><b><font color='$color'>$title</font></b>";
	}
	$act=$menu?"<center><input type='submit' value='�x�s����' name='go' onclick='return confirm(\"�T�w�n\"+this.value+\"?\")' style='border-width:1px; cursor:hand; color:white; background:#5555ff; font-size:20px; height=42'></center>":"";
	switch($menu){
		case 1:
			//����J�����
			$query="select sn,aspiration_order,school,course,factor from career_course where student_sn=$student_sn order by aspiration_order";
			$res=$CONN->Execute($query);
			$evaluate_count=$res->RecordCount()+1;
			while(!$res->EOF){
				$ii=$res->fields['aspiration_order'];
				$evaluate[$ii]['sn']=$res->fields['sn'];
				$evaluate[$ii]['school']=$res->fields['school'];
				$evaluate[$ii]['course']=$res->fields['course'];
				$evaluate[$ii]['factor']=unserialize($res->fields['factor']);
				$res->MoveNext();
			}
			//��������Y
			$evaluate_list="���N�ڷQ��Ū�������ΰ�¾�B���M�Ǯդά�O�A�����U���Ҽ{�]���P�C�ӿﶵ���ŦX�{�סA�ö�J�u0��5�v�����ơA5���N��D�`�ŦX�A0���N��D�`���ŦX�C<input type='hidden' name='edit_order' value=''>
				<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
				<tr align='center' bgcolor='#ffcccc'>
				<td bgcolor='#ddffcf'><p align='right'>�����@�Ǯա�</p><p align='left'>���Ҽ{�]����</p></td>";
			foreach($evaluate as $order=>$evaluate_data){
				$java_script="onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#aaaaff';\" onMouseOut=\"this.style.backgroundColor='#ffcccc';\" ondblclick='document.myform.edit_order.value=$order; document.myform.submit();'";
				$evaluate_list.="<td $java_script>$order<br>{$evaluate_data['school']}<br>{$evaluate_data['course']}</td>";
			}
			$evaluate_list.='</tr>';

			//����Ҽ{�]������
			$factor_items=array('self'=>'�ӤH�]��','env'=>'���Ҧ]��','info'=>'��T�]��');
			foreach($factor_items as $item=>$title){
				$factor=SFS_TEXT($title);
				$evaluate_list.="<tr bgcolor='#ddffdd'><td colspan=$evaluate_count>�� $title</td></tr>";
				foreach($factor as $key=>$data){
					$evaluate_list.="<tr><td>�@ -$data</td>";
					foreach($evaluate as $order=>$evaluate_data){
						$evaluate[$order]['sum']+=$evaluate_data['factor'][$item][$key];
						if($order==$_POST['edit_order']){
							$edit_radio='';
							for($i=1;$i<=5;$i++){
								$checked=($evaluate_data[factor][$item][$key]==$i)?'checked':'';
								$color=($evaluate_data[factor][$item][$key]==$i)?'#ff0000':'#000000';
								$edit_radio.="<input type='radio' name='evaluate[$item][$key]' value=$i $checked><font color='$color'>$i</font>";	
							}					
							$evaluate_list.="<td bgcolor='#fcffcf' align='center'>$edit_radio<input type='hidden' name='sn' value='{$evaluate_data['sn']}'</td>";
						} else { 
							$java_script="onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#aaaaff';\" onMouseOut=\"this.style.backgroundColor='#ffffff';\" ondblclick='document.myform.edit_order.value=$order; document.myform.submit();'";
							$evaluate_list.="<td align='center' $java_script>{$evaluate_data[factor][$item][$key]}</td>"; 
						}
					}
					$evaluate_list.='</tr>';
				}			
			}	
			//�[�J�`�p�C
			$evaluate_list.="<tr></tr><tr bgcolor='#ddffdd' align='center'><td>���@�@�`�@�@�@�p�@�@��</td>";
			foreach($evaluate as $order=>$value){
				$evaluate_list.="<td><b>{$value['sum']}<b></td>"; 
			}		
			$evaluate_list.="</tr>";
			
			$evaluate_list.="</table>";
			$act=$_POST['edit_order']?$act:'';
			$showdata="<br>$evaluate_list";
		
			break;
		case 2:
			$act='';
			$showdata='';
			//���o����J�����
			$psy_result="<br><table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
			<tr align='center'><td colspan=3 bgcolor='#ffffcc'>�����߲z���絲�G</td></tr><tr align='center'>";
		//���o����J�����
		$item_arr=array(1=>'�ʦV����',2=>'�������',3=>'��L����(1)',4=>'��L����(2)');
		foreach($item_arr as $key=>$title){
			$query="select * from career_test where student_sn=$student_sn and id=$key";
			$res=$CONN->Execute($query);
			if($res){
				while(!$res->EOF){
					$sn=$res->fields['sn'];
					$content=unserialize($res->fields['content']);

					$title=$content['title'];
					$test_result=$content['data'];
					$study=$res->fields['study'];
					$job=$res->fields['job'];
					
					$content_list="<td><table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
							<tr bgcolor='#ccffcc' align='center'><td colspan=2><b>$title</b></td></tr><tr></tr>
							<tr bgcolor='#ffcccc' align='center'><td>����</td><td>���e���G</td></tr>";
					if($test_result){
						foreach($test_result as $key2=>$value) $content_list.="<tr><td>$key2</td><td align='center'>$value</td></tr>";
					} else $content_list.="<tr align='center'><td colspan=2 height=100>�S���o�{������������I</td></tr>";
					
					$content_list.="<tr bgcolor='#fcccfc'><td colspan=2>���ھڴ��絲�G�A�b�ɾǤ譱�A�ھA�X�NŪ�G $study<br>���ھڴ��絲�G�A�b�N�~�譱�A�ھA�X�q�ơG $job</td></tr></table></td>";
					
					$psy_result.=$content_list;
	//echo $content_list;				
					$res->MoveNext();
				}
		} else $content_list="<td><center><font size=2 color='#ff0000'>���o�{����{$item_arr[$key]}�����I<br></font></center></td>";	
		}
		$psy_result.="</tr></table><br>";

			$showdata.=$psy_result;
		
			//���o���ǲߦ��Z���
			$fin_score=cal_fin_score(array($student_sn),$stud_seme_arr);
			$link_ss=array("chinese"=>"�y��-���","english"=>"�y��-�^�y","math"=>"�ƾ�","social"=>"���|","nature"=>"�۵M�P�ͬ����","art"=>"���N�P�H��","health"=>"���d�P��|","complex"=>"��X����");
			//��������Y
			$study_list="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
				<tr align='center'><td colspan=10 bgcolor='#ffffcc'>�ǲߪ�{</td></tr>
				<tr align='center' bgcolor='#ccffcc'><td>�~��</td><td>�Ǵ�</td>";
			foreach($link_ss as $key=>$value) $study_list.="<td>$value</td>";
			
			//���e
			foreach($stud_seme_arr as $seme_key=>$year_seme){			
				$bgcolor=($curr_seme_key==$seme_key)?'#ffdfdf':'#cfefef';
				$readonly=($curr_seme_key==$seme_key)?'':'readonly';
				$study_list.="<tr align='center'><td>$seme_key</td><td>$year_seme</td>";
				foreach($link_ss as $key=>$value) $study_list.="<td>{$fin_score[$student_sn][$key][$year_seme]['score']}</td>";
			}
			//�`���Z
			$study_list.="<tr></tr><tr align='center' bgcolor='#ccffcc'><td colspan=2>�Ǵ��������Z</td>";
			foreach($link_ss as $key=>$value) $study_list.="<td><b>{$fin_score[$student_sn][$key]['avg']['score']}</b></td>";
			$study_list.="</tr></table>";
			$showdata.=$study_list;
			
			$showdata.="<hr>���ͲP�ؼ�-�Q��Ū���Ǯ�-�ǵ{�G<font color='#0000ff'>";
			//����J�����
			$query="select aspiration_order,school,course from career_course where student_sn=$student_sn order by aspiration_order";
			$res=$CONN->Execute($query);
			//$evaluate_count=$res->RecordCount()+1;
			while(!$res->EOF){
				$ii++;
				$showdata.="($ii). {$res->fields['school']}-{$res->fields['course']}�@ ";
				$res->MoveNext();
			}
			$showdata.="</font><hr>";
			break;
		case 3:
			if($_POST['go']=='���ڷs�W'){
				$query="insert into career_opinion set student_sn=$student_sn";
				$res=$CONN->Execute($query) or die("SQL���~:$query");
			}
			
			$showdata='';
			//����ͲP��ܤ�V�ѷӪ�
			$direction_items=SFS_TEXT('�ͲP��ܤ�V');
			
			//���o�v����X�N���J�����
			$query="select * from career_opinion where student_sn=$student_sn";
			$res=$CONN->Execute($query);
			if($res){
				while(!$res->EOF){
					$ii++;
					$sn=$res->fields['sn'];				
					$parent=' ,'.$res->fields['parent'].',';	
					$parent_radio='';
			
					foreach($direction_items as $d_key=>$d_value){
						$comp=','.$d_key.',';
						$checked=strpos($parent,$comp)?'checked':'';
						$color=strpos($parent,$comp)?'#ff0000':'#555555';
						$parent_radio.="<input type='checkbox' name='parent[]' value='$d_key' $checked><font color='$color'>$d_value</font>";					
					}
					$parent_memo="<textarea name='parent_memo'  style='border-width:1px; color:brown; width=100%; height=100%;'>{$res->fields['parent_memo']}</textarea>";
					
					$tutor=' ,'.$res->fields['tutor'].',';
					foreach($direction_items as $d_key=>$d_value){
						$comp=','.$d_key.',';
						$checked=strpos($tutor,$comp)?'checked':'';
						$color=strpos($tutor,$comp)?'#00ff00':'#cccccc';
						$tutor_radio.="<input type='checkbox' name='tutor[]' value='$d_key' $checked><font color='$color'>$d_value</font>";	
					}
					$tutor_memo="<textarea name='tutor_memo'  style='border-width:1px; color:brown; width=100%; height=100%;'>{$res->fields['tutor_memo']}</textarea>";
					
					$guidance=' ,'.$res->fields['guidance'].',';
					foreach($direction_items as $d_key=>$d_value){
						$comp=','.$d_key.',';
						$checked=strpos($guidance,$comp)?'checked':'';
						$color=strpos($guidance,$comp)?'#0000ff':'#cccccc';
						$guidance_radio.="<input type='checkbox' name='guidance[]' value='$d_key' $checked><font color='$color'>$d_value</font>";					
					}
					$guidance_memo="<textarea name='guidance_memo'  style='border-width:1px; color:brown; width=100%; height=100%;'>{$res->fields['guidance_memo']}</textarea>";
					
					$content_list.="<input type='hidden' name='sn' value='$sn'><table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
								<tr bgcolor='#ffcccc' align='center'><td>NO.</td><td>��ĳ��</td><td>���ӿ�Ū��ĳ</td><td width=30%>����</td></tr>";
					
					$content_list.="<tr><td rowspan=3 align='center'>$ii</td><td align='center'>�a�@�@��</td><td>�ڧƱ�Ĥl��ܡG<br>$parent_radio</td><td>$parent_memo</td></tr>
									<tr><td align='center'>�ɡ@�@�v</td><td>��ĳ�ǥͿ�Ū�G$tutor_radio</td><td>$tutor_memo</td></tr>
									<tr><td align='center'>���ɱЮv</td><td>��ĳ�ǥͿ�Ū�G$guidance_radio</td><td>$guidance_memo</td></tr>";
					$content_list.="</table><br>";
					
					$res->MoveNext();
				}
			} else { $act=''; $content_list="<br><br><br><center><font size=4 color='#ff0000'>���o�{����{$menu_arr[$menu]}�����I <input type='submit' name='go' value='���ڷs�W'><br></font></center>";	}
			$showdata.=$content_list;

			break;
	}
}

$main="<font size=2><form method='post' action='$_SERVER[SCRIPT_NAME]' name='myform'><table style='border-collapse: collapse; font-size=12px;'><tr><td valign='top'>$class_select<br>$student_select</td><td valign='top'>$memu_select $showdata $act</td></tr></table></form></font>";

echo $main;

foot();

function array_csort() {
	$args = func_get_args(); 
	$marray = array_shift($args); 
	$i=0; 
	$msortline = "return(array_multisort("; 
	foreach ($args as $arg) { 
		if (is_string($arg)) { 
			foreach ($marray as $row) { 
				$sortarr[$i][] = $row[$arg]; 
			} 
		} else { 
			$sortarr[$i] = $arg; 
		} 
		$msortline .= "\$sortarr[".$i."],"; 
		$i++; 
	} 
	$msortline .= "\$marray));"; 
	
	eval($msortline); 
	return $marray; 
} 

?>
