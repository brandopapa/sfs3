<?php

// $Id:  $

//���o�]�w��
include_once "config.php";

sfs_check();

//�q�X����
head("�ͲP���ɳ���έp");

//�Ҳտ��
print_menu($menu_p,$linkstr);

if(checkid($_SERVER['SCRIPT_FILENAME'],1)) {
	$sort_rank=$sort_rank?$sort_rank:10;
	
	//����Ǧ~�Ǵ�
	$year_seme=$_POST['year_seme']?$_POST['year_seme']:'';
	$semester_select=get_recent_semester_select('year_seme',$year_seme);
	
	//������Ǵ�
	$garde_select=$_POST['year_seme']?get_semester_grade('grade',$curr_year,$curr_seme,$_POST['grade']):'';
	
	if($_POST['grade']){
		
		//���Ϳ��
		$menu=$_POST['menu'];
		$memu_select="<br>�m�έp���ءn<br>";
		$menu_arr=array(1=>'�ۧڻ{��',2=>'¾�~�P��',3=>'�ʦV����',4=>'�������',5=>'��L����',6=>'�Ш|�|��',7=>'��ܤ�V',8=>'��Ū���@',9=>'���ɿԸ�',10=>'�ͲP�ձ�');
		foreach($menu_arr as $key=>$title){
			$checked=($menu==$key)?'checked':''; 
			$memu_select.="<input type='radio' name='menu' onclick='this.form.submit()' $checked value='$key'>$title<br>";
		}
		
		//����ǥͦC��
		$student_sn_list=get_student_sn_list($year_seme,$_POST['grade']);
		$stud_total=count(explode(',',$student_sn_list));

		switch($menu){
			case 1:
				//����өʡB�U�����ʰѷӪ�
				$personality_items=SFS_TEXT('�ө�(�H��S��)');
				$activity_items=SFS_TEXT('�U������');

				//���o�ڪ������G�ƬJ�����
				$query="select student_sn,personality,interest,specialty from career_mystory where student_sn in ($student_sn_list)";
				$res=$CONN->Execute($query) or die("SQL���~:$query");
				$record_count=$res->RecordCount();
				while(!$res->EOF){
					//����ۧڻ{�ѦU�Ӷ��ت����e
					$personality_array=unserialize($res->fields['personality']);
					$personality_array=$personality_array[$_POST['grade']];  //�u��ثe�~�Ū�  �i��έp
					foreach($personality_array as $item=>$value) $personality_sum[$item]++;
					
					$interest_array=unserialize($res->fields['interest']);
					$interest_array=$interest_array[$_POST['grade']];  //�u��ثe�~�Ū�  �i��έp
					foreach($interest_array as $item=>$value) $interest_sum[$item]++;
					
					$specialty_array=unserialize($res->fields['specialty']);
					$specialty_array=$specialty_array[$_POST['grade']];  //�u��ثe�~�Ū�  �i��έp
					foreach($specialty_array as $item=>$value) $specialty_sum[$item]++;

					$res->MoveNext();
				}
				
				//�Ƨ�
				arsort($personality_sum);
				arsort($interest_sum);
				arsort($specialty_sum);
				
				//�έp�W���C��
				$i=0;
				$personality_rank="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
					<tr bgcolor='#ccccff' align='center'><td>�Ƨ�</td><td>���@�@�@��</td><td>�έp��</td><td>�ʤ���</td></tr>";
				foreach($personality_sum as $key=>$value){
					$i++;
					$percent=sprintf("%3.2f",$value/$stud_total*100).'%';
					if($i<=$sort_rank) $personality_rank.="<tr align='center'><td>$i</td><td align='left'>($key) {$personality_items[$key]}</td><td>$value</td><td>$percent</td></tr>";					
				}
				$personality_rank.="</table>";
				
				$i=0;
				$interest_rank="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
					<tr bgcolor='#ccccff' align='center'><td>�Ƨ�</td><td>���@�@�@��</td><td>�έp��</td><td>�ʤ���</td></tr>";
				foreach($interest_sum as $key=>$value){
					$i++;
					$percent=sprintf("%3.2f",$value/$stud_total*100).'%';
					if($i<=$sort_rank) $interest_rank.="<tr align='center'><td>$i</td><td align='left'>($key) {$activity_items[$key]}</td><td>$value</td><td>$percent</td></tr>";					
				}
				$interest_rank.="</table>";
				
				$i=0;
				$specialty_rank="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
					<tr bgcolor='#ccccff' align='center'><td>�Ƨ�</td><td>���@�@�@��</td><td>�έp��</td><td>�ʤ���</td></tr>";
				foreach($specialty_sum as $key=>$value){
					$i++;
					$percent=sprintf("%3.2f",$value/$stud_total*100).'%';
					if($i<=$sort_rank) $specialty_rank.="<tr align='center'><td>$i</td><td align='left'>($key) {$activity_items[$key]}</td><td>$value</td><td>$percent</td></tr>";					
				}
				$specialty_rank.="</table>";
				
				
				
				//�C��
				$personality_view="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
					<tr bgcolor='#ccffcc' align='center'><td>Id</td><td>���@�@�@��</td><td>�έp��</td><td>�ʤ���</td></tr>";
				foreach($personality_items as $key=>$value){
					$percent=sprintf("%3.2f",$personality_sum[$key]/$stud_total*100).'%';
					$personality_view.="<tr><td align='center'>$key</td><td>$value</td><td align='center'>{$personality_sum[$key]}</td><td align='center'>$percent</td></tr>";
				}
				$personality_view.="</table>";
				
				$interest_view="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
					<tr bgcolor='#ccffcc' align='center'><td>Id</td><td>���@�@�@��</td><td>�έp��</td><td>�ʤ���</td></tr>";
				foreach($activity_items as $key=>$value){
					$percent=sprintf("%3.2f",$interest_sum[$key]/$stud_total*100).'%';
					$interest_view.="<tr><td align='center'>$key</td><td>$value</td><td align='center'>{$interest_sum[$key]}</td><td align='center'>$percent</td></tr>";
				}
				$interest_view.="</table>";
				
				$specialty_view="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
					<tr bgcolor='#ccffcc' align='center'><td>Id</td><td>���@�@�@��</td><td>�έp��</td><td>�ʤ���</td></tr>";
				foreach($activity_items as $key=>$value){
					$percent=sprintf("%3.2f",$specialty_sum[$key]/$stud_total*100).'%';
					$specialty_view.="<tr><td align='center'>$key</td><td>$value</td><td align='center'>{$specialty_sum[$key]}</td><td align='center'>$percent</td></tr>";
				}
				$specialty_view.="</table>";
				
				$showdata.="���έp���ǥͼơG $record_count / $stud_total<table width=100% style='border-collapse: collapse; font-size=12px;'><tr align='center'><td>�m�ө�(�H��S��)�n</td><td>�m�𶢿���n</td><td>�m�M���n</td></tr>
				<tr valign='top'><td>$personality_rank<br>$personality_view</td><td>$interest_rank<br>$interest_view</td><td>$specialty_rank<br>$specialty_view</td></tr></table>";

				break;
			case 2:	
				//������¾�~�ɭ���������ѷӪ�
				$weight_items=SFS_TEXT('���¾�~�ɭ���������');
				
				//��������
				$query="select student_sn,occupation_suggestion,occupation_myown,occupation_others,occupation_weight from career_mystory where student_sn in ($student_sn_list)";
				$res=$CONN->Execute($query) or die("SQL���~:$query");
				$record_count=$res->RecordCount();
				while(!$res->EOF){
					//����ۧڻ{�ѦU�Ӷ��ت����e
					$weight_array=unserialize($res->fields['occupation_weight']);
					$weight_array=$weight_array[$_POST['grade']];  //�u��ثe�~�Ū��i��έp
					foreach($weight_array as $item=>$value) $weight_sum[$item]++;
					$res->MoveNext();
				}
				
				//�Ƨ�
				arsort($weight_sum);
	
				//�έp�W���C��
				$i=0;
				$weight_rank="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
					<tr bgcolor='#ccccff' align='center'><td>�Ƨ�</td><td>���@�@�@��</td><td>�έp��</td><td>�ʤ���</td></tr>";
				foreach($weight_sum as $key=>$value){
					$i++;
					$percent=sprintf("%3.2f",$value/$stud_total*100).'%';
					if($i<=$sort_rank) $weight_rank.="<tr align='center'><td>$i</td><td align='left'>($key) {$weight_items[$key]}</td><td>$value</td><td align='center'>$percent</td></tr>";					
				}
				$weight_rank.="</table>";

				$weight_view="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
					<tr bgcolor='#ccffcc' align='center'><td>Id</td><td>���@�@�@��</td><td>�έp��</td><td>�ʤ���</td></tr>";
				foreach($weight_items as $key=>$value){
					$percent=sprintf("%3.2f",$weight_sum[$key]/$stud_total*100).'%';
					$weight_view.="<tr><td align='center'>$key</td><td>$value</td><td align='center'>{$weight_sum[$key]}</td><td align='center'>$percent</td></tr>";
				}
				$weight_view.="</table>";
				
				$showdata="���έp���ǥͼơG $record_count / $stud_total<table width=100% style='border-collapse: collapse; font-size=12px;'><tr align='center'><td>�m���¾�~�ɭ���������n</td></tr><tr valign='top'><td>$weight_rank<br>$weight_view</td></tr></table>";
			
				break;
			case 3;
			case 4;
			case 5:
				//���o�ʦV����J�����
				$target_id=$menu-2;
				$query="select study,job from career_test where id=$target_id and student_sn in ($student_sn_list)";
				$res=$CONN->Execute($query) or die("SQL���~:$query");
				$record_count=$res->RecordCount();
				while(!$res->EOF){
					$item=$res->fields['study'];
					if($item) $study_sum[$item]++;

					$item=$res->fields['job'];
					if($item) $job_sum[$item]++;
					$res->MoveNext();
				}
				$showdata="���έp���ǥͼơG $record_count / $stud_total
				<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
				<tr bgcolor='#ffcccc' align='center'><td rowspan=2>NO.</td><td colspan=3>�ɾǾA�X�NŪ..</td><td colspan=3>�N�~�A�X�q��..</td></tr>
				<tr bgcolor='#ffcccc' align='center'><td>����</td><td>�έp��</td><td>�ʤ���</td><td>����</td><td>�έp��</td><td>�ʤ���</td></tr>";
				
				arsort($study_sum);
				$i=0;
				foreach($study_sum as $key=>$value) {
					$i++; $study_rank[$i]['key']=$key;
					$study_rank[$i]['value']=$value;
					$study_rank[$i]['percent']=sprintf("%3.2f",$value/$stud_total*100).'%';
				}
				
				arsort($job_sum);
				$i=0;
				foreach($job_sum as $key=>$value) {
					$i++;
					$job_rank[$i]['key']=$key;
					$job_rank[$i]['value']=$value;
					$job_rank[$i]['percent']=sprintf("%3.2f",$value/$stud_total*100).'%';
				}
				
				$max=max(count($study_rank),count($job_rank));
				for($i=1;$i<=$max;$i++) $showdata.="<tr align='center'><td>$i</td><td>{$study_rank[$i]['key']}</td><td>{$study_rank[$i]['value']}</td><td>{$study_rank[$i]['percent']}</td><td>{$job_rank[$i]['key']}</td><td>{$job_rank[$i]['value']}</td><td>{$job_rank[$i]['percent']}</td></tr>";
			
				$showdata.="</table>";
				break;
			case 6:
				//���o�Ш|�|�Ҧ��Z���
				$subject_arr=array('c'=>'���','e'=>'�^�y','m'=>'�ƾ�','n'=>'�۵M','s'=>'���|','w'=>'�g�@����');
				$max_score=-1; $min_score=9999;
				$query="select * from career_exam where student_sn in ($student_sn_list)";
				$res=$CONN->Execute($query) or die("SQL���~:$query");
				$record_count=$res->RecordCount();
				if($record_count){
					while(!$res->EOF){
						foreach($subject_arr as $key=>$value){
							$score=$res->fields[$key];
							$exam_sum[$key][$score]++;
							$max_score=max($max_score,$score); $min_score=min($min_score,$score);
						}
						$res->MoveNext();
					}
				
					foreach($subject_arr as $key=>$value) $subject_title.="<td>$value</td>";				
					$showdata="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
					<tr bgcolor='#c4d9ff' align='center'><td>�o��</td>$subject_title</tr>";
					for($i=$max;$i>=min;$i--){
						$subject_score='';
						foreach($subject_arr as $key=>$value) $subject_score.="<td>{$exam_sum[$key][$i]}</td>";
						$showdata.="<tr align='center'><td>$i</td>$subject_score</tr>";
					}
					$showdata.="</table>";
				} else $showdata="<center><font size=5 color='#ff0000'><br><br>���o�{�Ш|�|�Ҧ��Z��ơI<br><br></font></center>";
				break;
			case 7:
				//�N �ǥʹ���P �a������B�Юv��ĳ �i��P�貧����R
				//����ͲP��ܤ�V�ѷӪ�
				$direction_items=SFS_TEXT('�ͲP��ܤ�V');
				//���o�J�����
				$query="select direction from career_view where student_sn in ($student_sn_list)";
				$res=$CONN->Execute($query) or die("SQL���~:$query");
				$record_count=$res->RecordCount();
				if($record_count){
					$direction_initial=array(1=>'self',2=>'parent',3=>'teacher');
					$direction_title=array(1=>'�ۤv���Q�k',2=>'�a��������',3=>'�ǮձЮv����ĳ');
					while(!$res->EOF){
						$direction_array=unserialize($res->fields['direction']);
						for($i=1;$i<=3;$i++){
							//�έp
							foreach($direction_initial as $key=>$value){
								$target_id=$direction_array[$value][$i];
								$direction_sum[$i][$value][$target_id]++;								
							}
							//���P�έp
							if($direction_array[$direction_initial[1]][$i]==$direction_array[$direction_initial[2]][$i]) $compare[$i][$direction_initial[2]]['same']++; else $compare[$i][$direction_initial[2]]['diff']++;
							if($direction_array[$direction_initial[1]][$i]==$direction_array[$direction_initial[3]][$i]) $compare[$i][$direction_initial[3]]['same']++; else $compare[$i][$direction_initial[3]]['diff']++;
						}
						$res->MoveNext();
					}
					
					//�}�l��X
					for($i=1;$i<=3;$i++){
						$item_title='';
						foreach($direction_title as $key=>$title) $item_title.="<td>$title</td>";
						$showdata.="�m �� $i ��� �n<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111'>
							<tr bgcolor='#c4d9ff' align='center'><td>��ܤ�V</td>$item_title</tr>";
						foreach($direction_items as $key=>$item){
							$showdata.="<tr align='right'><td>$item</td>";
							foreach($direction_initial as $id=>$aa) $showdata.="<td align='center'>{$direction_sum[$i][$aa][$key]}</td>";
							$showdata.="</tr>";							
						}
						//���P��T
						$showdata.="<tr></tr><tr bgcolor='#ffcccc' align='center'><td>�ǥͷQ�k�P�a��������</td><td colspan=3>�P�G{$compare[$i]['parent']['same']} �@�@ ���G{$compare[$i]['parent']['diff']}</td></tr>
								<tr bgcolor='#ccffcc' align='center'><td>�ǥͷQ�k�P�Юv��ĳ���</td><td colspan=3>�P�G{$compare[$i]['teacher']['same']} �@�@ ���G{$compare[$i]['teacher']['diff']}</td></tr>
								</table><br>";
						
					}
				} else $showdata="<center><font size=5 color='#ff0000'><br><br>���o�{�ͲP��ܤ�V��ơI<br><br></font></center>";
				break;
			case 8:
				$ordered=$_POST['order'];
				$rank_radio="���n���R�����@�ǡG";
				for($i=1;$i<=$sort_rank;$i++){
					$checked=$ordered[$i]?'checked':'';
					$color=$ordered[$i]?'#ff0000':'#aaaaaa';
					if($ordered[$i]) $ordered_list.="$i,";
					$rank_radio.="<input type='checkbox' name='order[$i]' value=$i $checked onclick='this.form.submit()'><font color='$color'>$i<font>";
				}
				$ordered_list=substr($ordered_list,0,-1);
				if($ordered_list){
					//�N �ǥͧ��@�Ƕi��ǮաB�Ǭ�έp�C��
					//���o�J�����
					$query="select school,course from career_course where student_sn in ($student_sn_list) and aspiration_order in ($ordered_list)";
					$res=$CONN->Execute($query) or die("SQL���~:$query");
					$record_count=$res->RecordCount();
					if($record_count){
						while(!$res->EOF){
							$school=$res->fields['school'];
							$school_order[$school]++;
							$course=$res->fields['course'];
							$course_order[$course]++;
							$sc=$school.'-'.$course;
							$sc_order[$sc]++;
							
							$res->MoveNext();
						}
						
						//�Ƨ�
						arsort($school_order);
						arsort($course_order);
						arsort($sc_order);
						
						//�}�l��X
						$school_list="�m�Ǯէ��@�Ƨǡn<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
							<tr bgcolor='#ffcccc' align='center'><td>NO.</td><td>�ǮզW��</td><td>���H��</td></tr>";
						foreach($school_order as $key=>$value){
							$ss++;
							$school_list.="<tr><td align='center'>$ss</td><td>$key</td><td align='center'>$value</td></tr>";
						}
						$school_list.="</table>";
						
						$course_list="�m�Ǭ���@�Ƨǡn<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
							<tr bgcolor='#fcfccc' align='center'><td>NO.</td><td>�ǵ{��O</td><td>���H��</td></tr>";
						foreach($course_order as $key=>$value){
							$cc++;
							$course_list.="<tr><td align='center'>$cc</td><td>$key</td><td align='center'>$value</td></tr>";
						}
						$course_list.="</table>";
						
						
						$sc_list="�m�Ǯ�-�Ǭ���@�Ƨǡn<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
						<tr bgcolor='#cfcafa' align='center'><td>NO.</td><td>�Ǯ�-�ǵ{��O</td><td>���H��</td></tr>";
						foreach($sc_order as $key=>$value){
							$sscc++;
							$sc_list.="<tr><td align='center'>$sscc</td><td>$key</td><td align='center'>$value</td></tr>";
						}
						$sc_list.="</table>";


						$showdata="<table width='100%' style='border-collapse: collapse; font-size=12px;'><tr><td valign='top'>$school_list</td><td valign='top'>$course_list</td><td valign='top'>$sc_list</td></tr></table>";
					} else $showdata="<center><font size=5 color='#ff0000'><br><br>���o�{�ǥͧ��@�Ǹ�ơI<br><br></font></center>";
				} 
				$showdata=$rank_radio.$showdata;
				break;
			case 9:
				//�N ���ɿԸ߫�ĳ �έp�ǥͬ�����
				//�����;ǥͬ����ư}�C
				$zero=$stud_total;				
				$query="select student_sn,count(*) as counter from career_guidance where student_sn in ($student_sn_list)";
				$res=$CONN->Execute($query) or die("SQL���~:$query");
				while(!$res->EOF){
					$counter=$res->fields['counter'];
					$guidance_sum[$counter]++;	
					$zero--;
					$res->MoveNext();
				}
				$guidance_sum[0]=$zero;
				
				$zero=$stud_total;
				$query="select student_sn,count(*) as counter from career_consultation where student_sn in ($student_sn_list)";
				$res=$CONN->Execute($query) or die("SQL���~:$query");
				while(!$res->EOF){
					$counter=$res->fields['counter'];
					$consultation_sum[$counter]++;	
					$zero--;					
					$res->MoveNext();
				}
				$consultation_sum[0]=$zero;
			
				$zero=$stud_total;
				$query="select student_sn,count(*) as counter from career_parent where student_sn in ($student_sn_list)";
				$res=$CONN->Execute($query) or die("SQL���~:$query");
				while(!$res->EOF){
					$counter=$res->fields['counter'];
					$parent_sum[$counter]++;
					$zero--;
					$res->MoveNext();
				}
				$parent_sum[0]=$zero;
				
				//�Ƨ�
				arsort($guidance_sum);
				$guidance_list="�m�ͲP���ɬ����n<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
				<tr bgcolor='#cfcafa' align='center'><td>NO.</td><td>�O����</td><td>�H��</td></tr>";
				foreach($guidance_sum as $key=>$value){
					$gg++;
					$guidance_list.="<tr align='center'><td>$gg</td><td>$key</td><td>$value</td></tr>";
				}
				$guidance_list.="</table>";				
				
				arsort($consultation_sum);
				$consultation_list="�m�ͲP�Ը߬����n<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
				<tr bgcolor='#facfca' align='center'><td>NO.</td><td>�O����</td><td>�H��</td></tr>";
				foreach($consultation_sum as $key=>$value){
					$cc++;
					$consultation_list.="<tr align='center'><td>$cc</td><td>$key</td><td>$value</td></tr>";
				}
				$consultation_list.="</table>";
				
				arsort($parent_sum);
				$parent_list="�m�a�����ܡn<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
				<tr bgcolor='#cffaca' align='center'><td>NO.</td><td>�O����</td><td>�H��</td></tr>";
				foreach($parent_sum as $key=>$value){
					$pp++;
					$parent_list.="<tr align='center'><td>$pp</td><td>$key</td><td>$value</td></tr>";
				}
				$parent_list.="</table>";
				
				//��X
				$showdata="<table width='100%' style='border-collapse: collapse; font-size=12px;'><tr><td valign='top'>$guidance_list</td><td valign='top'>$consultation_list</td><td valign='top'>$parent_list</td></tr></table>";
				
				break;	
			case 10:
				//����өʡB�U�����ʰѷӪ�
				$course_array=SFS_TEXT('�ͲP�ձ��ǵ{�θs��');
				$activity_array=SFS_TEXT('�ͲP�ձ����ʤ覡');
				
				//�ˬd�O�_���Ū������ӧR��
				$query="select a.student_sn,b.curr_class_num,b.stud_name,b.stud_sex,b.stud_study_cond from career_explore a inner join stud_base b on a.student_sn=b.student_sn where isnull(degree) or isnull(course_id) order by b.curr_class_num";
				$res=$CONN->Execute($query) or die("SQL���~:$query");
				$null_count=$res->RecordCount();
				while(!$res->EOF){
					$color=($res->fields['stud_sex']==1)?'#0000ff':'#ff0000';
					$color=($res->fields['stud_study_cond']==0 or $res->fields['stud_study_cond']==15)?$color:'#cccccc';
					$err_stud_list.="<font color='$color'>( {$res->fields['curr_class_num']} ){$res->fields['stud_name']};</font> ";
					$res->MoveNext();
				}
				if($err_stud_list) $err_stud_list="<font color='red'>���t�εo�{�� $null_count ��ǥͪ��ͲP�ձ����ʬ�����g������G$err_stud_list</font>";
				
				//�����;ǥͬ����ư}�C
				$zero=$stud_total;				
				$query="select student_sn,count(*) as counter from career_explore where student_sn in ($student_sn_list) group by student_sn";
				$res=$CONN->Execute($query) or die("SQL���~:$query");
				while(!$res->EOF){
					$counter=$res->fields['counter'];
					$explore_sum[$counter]++;	
					$zero--;
					$res->MoveNext();
				}
				$explore_sum[0]=$zero;				
				//�Ƨ�
				arsort($explore_sum);
				$explore_list="�m�ӤH�ѻP�����ơn<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
				<tr bgcolor='#cfcafa' align='center'><td>�ѻP������</td><td>�H��</td></tr>";
				foreach($explore_sum as $key=>$value){
					$explore_list.="<tr align='center'><td>$key</td><td>$value</td></tr>";
				}
				$explore_list.="</table>";	
				
				//�ѻP��P����έp
				$query="select student_sn,degree from career_explore where student_sn in ($student_sn_list) order by degree";
//echo $query.'<br><br>';				
				$res=$CONN->Execute($query) or die("SQL���~:$query");
				while(!$res->EOF){
					$degree=$res->fields['degree'];
					$degree_sum[$degree]++;
					$res->MoveNext();
				}
				$explore_list.="<br><table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
					<tr align='center' bgcolor='#ffcccc'><td>�m�ѻP��P���쪺�{�סn</td><td>�m�H�ơn</td></tr>";
				foreach($degree_sum as $key=>$value){
					$explore_list.="<tr align='center'><td>$key</td><td>$value</td></tr>";
				}
				$explore_list.="</table>";
				

				$query="select course_id,degree,count(*) as counter from career_explore where student_sn in ($student_sn_list) group by course_id,degree";
				$res=$CONN->Execute($query) or die("SQL���~:$query");
				while(!$res->EOF){
					$course_id=$res->fields['course_id'];
					$degree=$res->fields['degree'];
					$course_sum[$course_id][$degree]+=$res->fields['counter'];					
					$res->MoveNext();
				}				
				$course_list="�m��z���ʾǵ{�θs��ơn<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
				<tr bgcolor='#cfcafa' align='center'><td>���ʾǵ{�θs��</td><td>�ѻP�H��</td><td>�P���쪺�{��</td></tr>";
				foreach($course_sum as $key=>$value){
					$stud_sum=0;
					$degree_list='';
					foreach($value as $degree=>$counter){
						$degree_list.="<b>$degree</b> �� $counter �H<br>";
						$stud_sum+=$counter;
					}
					$course_list.="<tr align='center'><td align='left'>($key) {$course_array[$key]}</td><td>$stud_sum</td><td>$degree_list</td></tr>";
				}
				$course_list.="</table>";	


				$query="select activity_id,degree,count(*) as counter from career_explore where student_sn in ($student_sn_list) group by activity_id,degree";
				$res=$CONN->Execute($query) or die("SQL���~:$query");
				while(!$res->EOF){
					$activity_id=$res->fields['activity_id'];
					$degree=$res->fields['degree'];
					$activity_sum[$activity_id][$degree]+=$res->fields['counter'];		
					$res->MoveNext();
				}				
				$activity_list="�m��z���ʤ覡�ơn<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
				<tr bgcolor='#cfcafa' align='center'><td>���ʤ覡</td><td>�ѥ[�H��</td><td>�P���쪺�{��</td></tr>";
				foreach($activity_sum as $key=>$value){
					$stud_sum=0;
					$degree_list='';
					foreach($value as $degree=>$counter){
						$degree_list.="<b>$degree</b> �� $counter �H<br>";
						$stud_sum+=$counter;
					}
					$activity_list.="<tr align='center'><td align='left'>($key) {$activity_array[$key]}</td><td>$stud_sum</td><td>$degree_list</td></tr>";
				}
				$activity_list.="</table>";

				//�Ǵ���z��
				$query="select seme_key,degree,count(*) as counter from career_explore where student_sn in ($student_sn_list) group by seme_key,degree";
				$res=$CONN->Execute($query) or die("SQL���~:$query");
				while(!$res->EOF){
					$seme_key=$res->fields['seme_key'];
					$degree=$res->fields['degree'];
					$seme_sum[$seme_key][$degree]+=$res->fields['counter'];		
					$res->MoveNext();
				}				
				$seme_list="�m�ѥ[���~��-�Ǵ��n<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='100%'>
				<tr bgcolor='#cfcafa' align='center'><td>�~��-�Ǵ�</td><td>�ѥ[�H��</td><td>�P���쪺�{��</td></tr>";
				foreach($seme_sum as $key=>$value){
					$stud_sum=0;
					$degree_list='';
					foreach($value as $degree=>$counter){
						$degree_list.="<b>$degree</b> �� $counter �H<br>";
						$stud_sum+=$counter;
					}
					$seme_list.="<tr align='center'><td>$key</td><td>$stud_sum</td><td>$degree_list</td></tr>";
				}
				$seme_list.="</table>";	
				
				
				//��X
				$showdata="<table width='100%' style='border-collapse: collapse; font-size=12px;'>
					<tr><td valign='top'>$explore_list</td><td valign='top'>$seme_list</td></tr>
					<tr><td valign='top'><br>$course_list</td><td valign='top'><br>$activity_list</td></tr>
					</table>";
				
				break;		
		}
	}
	$main="<font size=2><form method='post' action='$_SERVER[SCRIPT_NAME]' name='myform'>
		<table width='100%' cellspacing=6  cellpadding=5 style='border-collapse: collapse; font-size=12px;'>
			<tr>
				<td valign='top' width=100 bgcolor='#fccfcf'>$semester_select<br>$garde_select<br>$memu_select</td>
				<td valign='top'>$showdata<br><br>$err_stud_list</td>
			</tr></table></form></font>";
	echo $main;
	
} else echo "<center><font size=5 color='#ff0000'><br><br>�z���㦳�Ҳպ޲z�v�A�t�θT��z�ϥΡI<br><br></font></center>";

foot();

?>
