<?php

//�ھگZ�Ũ��o���үZ���Ҧ��Ǵ�
function get_class_seme_select($class_num) {
	global $IS_JHORES;	
	$data_arr=array();	
	$I=substr($class_num,0,1)-$IS_JHORES-1;	
	
	for ($i=0;$i<=$I;$i++) {
	  $now_year=curr_year()-$i;
 	  if ($i>0 or curr_seme()==2) {
	  	$k=sprintf("%03d",$now_year)."2";
	  	$v=$now_year."�Ǧ~�ײ�2�Ǵ�";
	    $data_arr[$k]=$v;
	  } //end if

	  $k=sprintf("%03d",$now_year)."1";
	  $v=$now_year."�Ǧ~�ײ�1�Ǵ�";
	  $data_arr[$k]=$v;
	  
	}	// end for
	
	return $data_arr; 

} //end function

//���o�Ҧ����Z�� array
function get_report($mode,$the_seme,$seme_class="",$page="") {
 global $CONN,$PAGES;
 global $school_kind_name;
 switch ($_SESSION['session_who']) {
 	case '�Юv':
 	 $sql="select * from class_report_setup where seme_year_seme='$the_seme' and teacher_sn='{$_SESSION['session_tea_sn']}'";
 	 if ($seme_class) {
 	 $sql.=" and seme_class='$seme_class'";
 	 }
 	 $sql.=" order by title";
   if ($page>0) {
   	$st=($page-1)*$PAGES;
    $sql.=" limit ".$st.",".$PAGES;
   }
 	break;
 	case '�ǥ�': 
 		switch ($mode) {
			case 'list': //�������}���s��
 	 			$sql="select * from class_report_setup where seme_year_seme='$the_seme' and seme_class='$seme_class' and open_read=1 order by title";
			break;
			case 'input': //�������}���J�B���p�Ѯv
 	 			$sql="select * from class_report_setup where seme_year_seme='$the_seme' and seme_class='$seme_class' and open_input=1 and student_sn='{$_SESSION['session_tea_sn']}' order by title";
			break;
 		}	
 	break;
 }
	 $res=$CONN->Execute($sql);
	 $rec=$res->GetRows();
	 
	 foreach ($rec as $k=>$v) {
	 	$rec[$k]['seme_class_cname']=$school_kind_name[substr($v['seme_class'],0,1)].sprintf('%d',substr($v['seme_class'],1,2))."�Z";
		//�w�]�t�����Z����
		$sql="select count(*) from class_report_test where report_sn='{$rec[$k]['sn']}'";
		$res=$CONN->Execute($sql);
		$test_num=$res->fields[0];
		$rec[$k]['test_num']=$test_num; //���Z��
	 }
	 
	 return $rec;
}

//���o���Z��]�w
function get_report_setup($the_report) {
	global $CONN,$school_kind_name;
	$sql="select * from class_report_setup where sn='$the_report'";
	$res=$CONN->Execute($sql) or die("SQL���~:".$sql);
	if ($res) {
		$report=$res->FetchRow();
		$report['seme_class_cname']=$school_kind_name[substr($report['seme_class'],0,1)].sprintf('%d',substr($report['seme_class'],1,2))."�Z";

		return $report;
	}else{
	 echo "�ǰe�Ѽƿ��~!";
	 exit();
	}
}

//���Z�檺���
function form_report($REP) {
	
	global $CONN,$M_SETUP;
	
 //���o�ثe�Ҧ��Z��
 $class_array=class_base();
 $class_num=get_teach_class();
 
 //�Y�L�N�J��, �h�۰ʫ��w���ЯZ��
 $REP['seme_class']=($REP['seme_class']=='')?$class_num:$REP['seme_class'];
 
 //�Y���Z��, ���o�ǥ�
 if ($REP['seme_class']!="") {
  $select_students=get_seme_class_students($REP['seme_year_seme'],$REP['seme_class']);
 }
 
?>
	<input type="hidden" name="seme_year_seme" value="<?php echo $REP['seme_year_seme'];?>">
	<table border="0" width="600"  bgcolor="#FFFFCC">
		<tr>
			<td width="100">���Z��W��</td>
			<td><input type="text" name="title" value="<?php echo $REP['title'];?>" size="50"></td>
		</tr>	
		<tr>
			<td>
				�Z��
			</td>
			<td>
				<select size="1" name="seme_class" onchange="document.myform.change_class.value=1;document.myform.submit()">
					<option value="">---</option>
					<?php
					 foreach ($class_array as $k=>$v) {
					 ?>
					 <option value="<?php echo $k;?>" <?php if ($k==$REP['seme_class']) echo "selected";?>><?php echo $v;?></option>
					 <?php
					 }
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				���Z��p�Ѯv
			</td>
			<td>
				<select size="1" name="student_sn">
					<option value="">---</option>
					<?php
					 foreach ($select_students as $k=>$v) {
					 ?>
					 <option value="<?php echo $v['student_sn'];?>" <?php if ($v['student_sn']==$REP['student_sn']) echo "selected";?>><?php echo $v['seme_num'].$v['stud_name'];?></option>
					 <?php
					 }
					?>
				</select>
			</td>
		</tr>
		
		<tr>
			<td>�}��p�Ѯv�n�����Z</td>
			<td>
					<input type="radio" name="open_input" value="0"<?php if ($REP['open_input']==0) echo " checked";?>>����
					<input type="radio" name="open_input" value="1"<?php if ($REP['open_input']==1) echo " checked";?>>�ҥ�
			</td>
		</tr>
		<tr>
			<td>�}��ǥͬd��</td>
			<td>
					<input type="radio" name="open_read" value="0"<?php if ($REP['open_read']==0) echo " checked";?>>����
					<input type="radio" name="open_read" value="1"<?php if ($REP['open_read']==1) echo " checked";?><?php if ($M_SETUP['limit_open']==0) echo " disabled";?>>�ҥ�
					<?php if ($M_SETUP['limit_open']==0) echo "<font size=2 color=red><i>�t�ιw�]�L�k�վ�</i></font>"; ?>
			</td>
		</tr>
		<tr>
			<td>���Z��˦�</td>
			<td>
					<input type="radio" name="rep_classmates" value="0"<?php if ($REP['rep_classmates']==0) echo " checked";?>>�ӤH
					<input type="radio" name="rep_classmates" value="1"<?php if ($REP['rep_classmates']==1) echo " checked";?><?php if ($M_SETUP['limit_classmates']==0) echo " disabled";?>>���Z
					<?php if ($M_SETUP['limit_classmates']==0) echo "<font size=2 color=red><i>�t�ιw�]�L�k�վ�</i></font>"; ?>
			</td>
		</tr>
		<tr>
			<td>���Z�洣���`��</td>
			<td>
					<input type="radio" name="rep_sum" value="0"<?php if ($REP['rep_sum']==0) echo " checked";?>>����
					<input type="radio" name="rep_sum" value="1"<?php if ($REP['rep_sum']==1) echo " checked";?>>�}��
			</td>
		</tr>
		<tr>
			<td>���Z�洣�ܥ���</td>
			<td>
					<input type="radio" name="rep_avg" value="0"<?php if ($REP['rep_avg']==0) echo " checked";?>>����
					<input type="radio" name="rep_avg" value="1"<?php if ($REP['rep_avg']==1) echo " checked";?>>�}��
			</td>
		</tr>
		<tr>
			<td>���Z�洣�ܱƦW</td>
			<td>
					<input type="radio" name="rep_rank" value="0"<?php if ($REP['rep_rank']==0) echo " checked";?>>����
					<input type="radio" name="rep_rank" value="1"<?php if ($REP['rep_rank']==1) echo " checked";?><?php if ($M_SETUP['limit_rank']==0) echo " disabled";?>>�}��
					<?php if ($M_SETUP['limit_rank']==0) echo "<font size=2 color=red><i>�t�ιw�]�L�k�վ�</i></font>"; ?>
			</td>
		</tr>	
	</table>
<?php
} //end form_report($REP)

//�Z�Ŧ��Z���
function form_class_score($REP_SETUP,$TEST_SETUP,$SCORE) {
		//���o�Ҧ���ئW��
		$subject_arr=&get_subject_name_arr();
		//���o�ǥ�
	  $STUD=get_seme_class_students($REP_SETUP['seme_year_seme'],$REP_SETUP['seme_class']);
	  //�Ҹդ������ (���Ǵ����Ĥ@�Ѧܤ���)
	  $minday=(substr($REP_SETUP['seme_year_seme'],3,1)=='1')?(substr($REP_SETUP['seme_year_seme'],0,3)+1911).'0801':(substr($REP_SETUP['seme_year_seme'],0,3)+1912).'0201';
		$maxday=(substr($REP_SETUP['seme_year_seme'],3,1)=='1')?(substr($REP_SETUP['seme_year_seme'],0,3)+1912).'0131':(substr($REP_SETUP['seme_year_seme'],0,3)+1912).'0731';
		$maxday=($maxday>date('Ymd'))?date('Ymd'):$maxday;
	  ?>
<table border="0">
	<tr>
		<td valign="top">
		<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse;' bordercolor='#111111'>
	  	<tr>
	  		<td align="center" bgcolor="#FFCCFF">-</td>
	  		<td align="center" bgcolor="#CCFFCC">���</td>
	  		<td align="center" bgcolor="#CCFFCC">
 			    	<input type="text" name="test_date" id="test_date" onkeydown="moveit2(this,event);" size="10" value="<?php echo $TEST_SETUP['test_date'];?>">
	  				<script type="text/javascript">
							new Calendar({
  		    		inputField: "test_date",
   		    		dateFormat: "%Y-%m-%d",
    	    		trigger: "test_date",
 	        		min: <?php echo $minday;?>,
    					max: <?php echo $maxday;?>,
    	    		bottomBar: true,
    	    		weekNumbers: false,
    	    		showTime: 24,
    	    		onSelect: function() {this.hide();}
		    			});
						</script>	  			
	  		</td>
			</tr>
	  		<td align="center" bgcolor="#FFCCFF">-</td>
	  		<td align="center" bgcolor="#CCFFCC">���</td>
	  		<td align="center" bgcolor="#CCFFCC"><input type="text" id="SS_1" onfocus="set_ower(this,1)" onBlur="unset_ower(this)" Name="subject" size="10" onkeydown="moveit2(this,event);" value="<?php echo $TEST_SETUP['subject'];?>"></td>
	  	</tr>	
	  	<tr>
	  		<td align="center" bgcolor="#FFCCFF">-</td>
	  		<td align="center" bgcolor="#CCFFCC">�d��</td>
	  		<td align="center" bgcolor="#CCFFCC"><input type="text" id="SS_2" onfocus="set_ower(this,2)" onBlur="unset_ower(this)" name="memo" size="10" onkeydown="moveit2(this,event);" value="<?php echo $TEST_SETUP['memo'];?>"></td>
	  	</tr>	
	  	<tr>
	  		<td align="center" bgcolor="#FFCCFF">�y��</td>
	  		<td align="center" bgcolor="#CCFFCC">�[�v</td>
	  		<td align="left" bgcolor="#CCFFCC"><input type="text" id="SS_3" onfocus="set_ower(this,3)" onBlur="unset_ower(this)" name="rate" size="5" onkeydown="moveit2(this,event);" value="<?php echo $TEST_SETUP['rate'];?>"></td>
	  	</tr>	

			<?php
			$i=3;
			foreach ($STUD as $V) {
				$i++;
			?>
	  	<tr>
	  		<td><?php echo $V['seme_num'];?></td>
	  		<td><?php echo $V['stud_name'];?></td>
	  		<td><input type="text" id="SS_<?php echo $i;?>" onfocus="set_ower(this,<?php echo $i;?>)" onBlur="unset_ower(this)" name="score[<?php echo $V['student_sn'];?>]" value="<?php echo $SCORE[$V['student_sn']];?>" onkeydown="moveit2(this,event);" size=5></td>
	  	</tr>			
			<?php
			} //end foreach
			$SS=$i;
			?>	  
	  </table>
		</td>			  	
		<!-- �C�X�ѦҬ�بѿ�� -->
		<td valign="top" style="color:#0000FF">
		��ئW�ٰѦ�:(�����ηƹ����, �Φۦ��ʿ�J)
		<table border="1" style="border-collapse:collapse" bordercolor="#CCCCCC">
			<?php
			 $i=0;
			 foreach ($subject_arr as $k=>$v) {
			  $i++;
			  if ($i%5==1) echo "<tr>";
			  ?>
			  	<td width="90" class="bg_0" id="td_<?php echo $i;?>" onMouseOver="OverLine('td_<?php echo $i;?>')" onMouseOut="OutLine('td_<?php echo $i;?>')" onclick="document.myform.subject.value='<?php echo $v['subject_name'];?>'"><?php echo $v['subject_name'];?></td>
			  <?php
			  if ($i%5==0) echo "</tr>";
			 }
			?>
		
		</table>
		
		</td>	  	
 	</tr>
</table>
	  	
	  <?php
	  
	  return $SS;
	
} // end function

//�C�X���Z�� list_class_score(�]�w��,�n���n��ܾާ@�C,�`��,����,�ƦW,�O�_�u�έp�Ŀ�Ҹ�,�O�_�X�{�Ŀ�ҸզC���)
function list_class_score($REP_SETUP,$CON,$SUM="",$AVG="",$RANK="",$REAL_SUM=0,$EDIT_REAL_SUM=0) {
	global $CONN;
		//���o�ǥ�
	  $STUD=get_seme_class_students($REP_SETUP['seme_year_seme'],$REP_SETUP['seme_class']);
	  //���o�Ҧ��Ҹ�
	  $TESTS=get_report_test_all($REP_SETUP['sn']);	  
	  //���o�Ҧ����Z
	  $SCORES=get_report_score_all($REP_SETUP['sn'],$REAL_SUM);	  
	  
	  //���C�J�έp�ɪ��C��
	  $CC[0]="#888888";
	  $CC[1]="#000000";	
	  $W_COLOR=array();  

	  
	  //�έp�O�_�n�`���B�����B�ƦW��, �H�K�h�L���
	  $II=0;
	  if ($SUM==1) $II++;
	  if ($AVG==1) $II++;
	  if ($RANK==1) $II++;
	  
	  $B=($_POST['act']=='output')?0:2;
	  
	  ?>
<table border="0">
	<tr>
		<td valign="top">
		<table border='<?php echo $B;?>' cellpadding='3' cellspacing='0' style='border-collapse: collapse;' bordercolor='#111111'>
			<?php
				//�X�{�i�Ŀ�O�_�C�J�έp���
				if ($EDIT_REAL_SUM==1) {
					?>
					<tr>
	  				<td align="center" colspan="2" bgcolor="#FFFFCC">�C�J�έp�_?</td>
	  				<?php
						foreach ($TESTS as $test_setup) {
	  		 		?>
 	  				<td align="center" bgcolor="#FFFFCC">
							<input type="checkbox" name="real_sum[<?php echo $test_setup['sn'];?>]" value="1"<?php if ($test_setup['real_sum']==1) echo " checked";?><?php if ($REP_SETUP['locked']==1) echo " disabled";?>>
	  				</td>
	  		 		<?php 
	  				} // end foreach
	  				?>
						<td colspan="3" align="center">
							<input type="button" value="���]�C�J�έp�����Z" style="color:#FF0000" onclick="document.myform.act.value='check_real_sum';document.myform.submit()"<?php if ($REP_SETUP['locked']==1) echo " disabled";?>>
						</td>
					</tr>
					<?php
				} // end if ($EDIT_REAL_SUM==1)

			if ($CON) {
			?>
	  	<tr>
	  		<td align="center" bgcolor="#FFCCFF">-</td>
	  		<td align="center" bgcolor="#FFFFCC">�ާ@</td>
	  		<?php
				foreach ($TESTS as $test_setup) {
	  		 ?>
 	  		<td align="center" bgcolor="#FFFFCC">
 	  			<?php
 	  			if ($REP_SETUP['locked']==0) {
 	  			?>
 	  				<img src="images/edit.png" style="cursor:hand" title="�s��" onclick="document.myform.act.value='edit';document.myform.option1.value='<?php echo $test_setup['sn'];?>';document.myform.submit();">
  					<img src="images/del.png"  style="cursor:hand" title="�R��" onclick="if (confirm('�z�T�w�n�R���u<?php echo $test_setup['test_date'].$test_setup['subject'];?>�v��?')) { document.myform.act.value='DeleteOne'; document.myform.option1.value='<?php echo $test_setup['sn'];?>'; document.myform.submit(); } ">
	  			<?php
	  			}
	  			?>
	  		</td>
	  		 <?php 
	  		} // end foreach
	  		//�h�L���
	  		if ($II)	for ($i=1;$i<=$II;$i++) { echo "<td bgcolor=\"#FFCCCC\">&nbsp;</td>"; }
	  		?>
			
			</tr>				
			<?php
			} // end if ($CON)
			?>
	  	<tr>
	  		<td align="center" bgcolor="#FFCCFF">-</td>
	  		<td align="center" bgcolor="#CCFFCC">���</td>
	  		<?php
				foreach ($TESTS as $test_setup) {
					$W_COLOR[$test_setup['sn']]=($REAL_SUM==0)?$CC[1]:$CC[$test_setup['real_sum']];
	  		 ?>
 	  		<td align="center" bgcolor="#CCFFCC" style="color:<?php echo $W_COLOR[$test_setup['sn']];?>"><?php echo $test_setup['test_date'];?></td>
	  		 <?php 
	  		} // end foreach
	  		//��ܩ����
				if ($SUM) { echo "<td rowspan=\"4\" bgcolor=\"#FFCCCC\" align=center>�`��</td>";	}
				if ($AVG) { echo "<td rowspan=\"4\" bgcolor=\"#FFCCCC\" align=center>����</td>";	}
				if ($RANK) { echo "<td rowspan=\"4\" bgcolor=\"#FFCCCC\" align=center>�W��</td>";	}
	  		?>
			</tr>
	  		<td align="center" bgcolor="#FFCCFF">-</td>
	  		<td align="center" bgcolor="#CCFFCC">���</td>
	  		<?php
				foreach ($TESTS as $test_setup) {
  		 ?>
 	  		<td align="center" bgcolor="#CCFFCC" style="color:<?php echo $W_COLOR[$test_setup['sn']];?>"><?php echo $test_setup['subject'];?></td>
	  		 <?php 
	  		} // end foreach
	  		?>
	  	</tr>	
	  	<tr>
	  		<td align="center" bgcolor="#FFCCFF">-</td>
	  		<td align="center" bgcolor="#CCFFCC">�d��</td>
	  		<?php
				foreach ($TESTS as $test_setup) {
  		 ?>
 	 	  		<td align="center" bgcolor="#CCFFCC" style="color:<?php echo $W_COLOR[$test_setup['sn']];?>"><?php echo $test_setup['memo'];?></td>
	  		 <?php 
	  		} // end foreach
	  		?>
			</tr>
	  	<tr>
	  		<td align="center" bgcolor="#FFCCFF">�y��</td>
	  		<td align="center" bgcolor="#CCFFCC">�[�v</td>
	  		<?php
				foreach ($TESTS as $test_setup) {
  		 ?>
 	 	  		<td align="center" bgcolor="#CCFFCC" style="color:<?php echo $W_COLOR[$test_setup['sn']];?>"><?php echo $test_setup['rate'];?></td>
	  		 <?php 
	  		} // end foreach
	  		?>
			</tr>

				<?php
			foreach ($STUD as $V) {
			?>
	  	<tr>
	  		<td><?php echo $V['seme_num'];?></td>
	  		<td><?php echo $V['stud_name'];?></td>
	  		<?php	  		
				foreach ($TESTS as $test_setup) {
  		 ?> 		  		 
 	  		<td align="center" style="color:<?php echo $W_COLOR[$test_setup['sn']];?>"><?php echo $SCORES[$V['student_sn']][$test_setup['sn']];?></td>
	  		 <?php 
	  		}
				if ($SUM) { echo "<td align=\"center\">".$SCORES[$V['student_sn']]['sum']."</td>";	}
				if ($AVG) { echo "<td align=\"center\">".number_format($SCORES[$V['student_sn']]['avg'],2)."</td>";	}
				if ($RANK) { echo "<td align=\"center\">".$SCORES[$V['student_sn']]['rank']."</td>";	}
	  		?>
	  	</tr>			
			<?php
			} //end foreach
			?>	  
	  </table>
		</td>	  	
 	</tr>
</table>	  	
	  <?php
	
} // end function

//�C�X���Z�� list_class_score(�]�w��,�n���n��ܾާ@�C,�`��,����,�ƦW)
function list_class_score_personal($REP_SETUP,$CON,$SUM="",$AVG="",$RANK="",$REAL_SUM=0) {
	global $CONN;
	  $TESTS=get_report_test_all($REP_SETUP['sn']);	  
	  //���o�Ҧ����Z
	  $SCORES=get_report_score_all($REP_SETUP['sn'],$REAL_SUM);
	  $CC[0]="#888888";
	  $CC[1]="#000000";	
	  $W_COLOR=array();  
?>
		<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse;' bordercolor='#111111'>
	<tr bgcolor="#FFCCFF">
		<td align="center">���</td>
		<td align="center">���</td>
		<td align="center">�d��</td>
		<td align="center">���Z</td>
	</tr>
	<?php
	foreach ($TESTS as $test_setup) {
		$W_COLOR[$test_setup['sn']]=($REAL_SUM==0)?$CC[1]:$CC[$test_setup['real_sum']];
 	?> 
	<tr style="color:<?php echo $W_COLOR[$test_setup['sn']];?>">
		<td><?php echo $test_setup['test_date'];?></td>
		<td align="center"><?php echo $test_setup['subject'];?></td>
		<td><?php echo $test_setup['memo'];?></td>
		<td align="center"><?php echo $SCORES[$_SESSION['session_tea_sn']][$test_setup['sn']];?></td>
	</tr>
  <?php	
  } // end foreach
  //�έp��T
  	if ($SUM) {
  	?>
		<tr bgcolor="#FFCCCCCC">
			<td colspan="3" align="right">�`��</td>
			<td align="center"><?php echo $SCORES[$_SESSION['session_tea_sn']]['sum'];?></td>
		</tr>
  	<?php
  	} // end if
  	if ($AVG) {
  	?>
		<tr bgcolor="#FFCCCCCC">
			<td colspan="3" align="right">����</td>
			<td align="center"><?php echo number_format($SCORES[$_SESSION['session_tea_sn']]['avg'],2);?></td>
		</tr>
  	<?php
  	} // end if
  	if ($RANK) {
  	?>
		<tr bgcolor="#FFCCCCCC">
			<td colspan="3" align="right">�W��</td>
			<td align="center"><?php echo $SCORES[$_SESSION['session_tea_sn']]['rank'];?></td>
		</tr>
  	<?php
  	} // end if  
	?>
</table>

<?php
} // end function

//���o���Z�椤���Y���Ҹճ]�w
function get_report_test($sn) {
  global $CONN;
  $sql="select * from class_report_test where sn='$sn'";
  $res=$CONN->Execute($sql) or die("SQL���~:".$sql);
  
  $test_setup=$res->FetchRow();
  
  return $test_setup;
  
}

//���o���Z�椤���Ҧ��Ҹճ]�w�̤���ƦC
function get_report_test_all($report_sn) {
	global $CONN;
	$sql="select * from class_report_test where report_sn='$report_sn' order by test_date";
	$res=$CONN->Execute($sql);
	$T=$res->GetRows();
	
	return $T;

}

//���o���Z�椤���Ҧ����Z �Ǧ^ $SCORE[student_sn][test_sn]=score ,$REAL_SUM=1 ��, �Ȳέp real_sum=1�����, �`�N, �M list function �f�t�ϥ�
function get_report_score_all($report_sn,$REAL_SUM=0) {
  global $CONN;
  //���o�Ҧ����Ҹ�
  $TESTS=get_report_test_all($report_sn);
  //�̨C���Ҹ�, �̧Ǩ��X�Ҧ� student_sn �����Z
  foreach ($TESTS as $test_setup) {
  	//�������լO�_�C�J�p��
  	$real_sum[$test_setup['sn']]=$test_setup['real_sum'];
  	//��������Ҧ��[�v
  	$rate[$test_setup['sn']]=$test_setup['rate'];
   	//���o�Ӧ��Ҹզ��Z, �Ǧ^ $S['student_sn']=score
   	$S=get_report_score($test_setup['sn']);
   		foreach ($S as $student_sn=>$score) {
   			$SCORE[$student_sn][$test_setup['sn']]=$score;
   		}// end foreach  
  } // end foreach
  
	//�p���`��,����
	$RANK=array();
	foreach ($SCORE as $student_sn=>$SS) {
	  $sum=0;
	  $rate_sum=0;
	  $all_tests=0;
	  foreach ($SS as $test_sn=>$v) {
	  	if ($REAL_SUM==1) {   //�u�έp���Ŀ諸���Z
	  		if ($real_sum[$test_sn]==1) {
	  			//$all_tests++;
	  		  $sum+=$v;  //����`��
	  		  //�[�v�p��
	  		  $all_tests+=$rate[$test_sn];    //�`�[�v�B
	  		  $rate_sum+=$v*$rate[$test_sn];  //���ƭ��W�[�v
				}  	
	  	}else{
	  		  $sum+=$v;  //����`��
	  		  //�[�v�p��
	  		  $all_tests+=$rate[$test_sn];    //�`�[�v�B
	  		  $rate_sum+=$v*$rate[$test_sn];  //���ƭ��W�[�v
	  	}	   
	  }
		$SCORE[$student_sn]['sum']=$sum;
		$SCORE[$student_sn]['avg']=round($rate_sum/$all_tests,2);
		$RANK[$student_sn]=$rate_sum/$all_tests; //�⥭���ȰO�b RANK array  ��
		
	}
	//�D�ƦW
  arsort($RANK);
  $i=0; //�ثe�W��
  $j=0;
  $l_score=0;
  foreach ($RANK as $student_sn=>$v) {
		$j++; 
  	if ($v!=$l_score) {
  		$i=$j;  		
  	} // end if
  	$SCORE[$student_sn]['rank']=$i;
  	$l_score=$v;  	
  } // end foreach

  return $SCORE;
  
}

 
//���o�Y���Ҹժ��Ҧ����Z �Ǧ^ $SCORE['student_sn']=$score
function get_report_score($test_sn) {
  global $CONN;
  $sql="select * from class_report_score where test_sn='$test_sn'";
  $res=$CONN->Execute($sql) or die("SQL���~:".$sql);
  
  $S=$res->GetRows();
  
  $SCORE=array();
  
  foreach ($S as $V) { 
   		$SCORE[$V['student_sn']]=$V['score'];  
  } // end foreach
  
  return $SCORE;
  
} // end function


//���Z��C����
function select_pages($the_page) {
	//$_POST['option2']�O����w��page
	global $CONN,$PAGES,$the_seme;  //�C���X��
	$sql="select count(*) as pages  from class_report_setup where seme_year_seme='$the_seme' and teacher_sn='{$_SESSION['session_tea_sn']}'";
	$res=$CONN->Execute($sql);
	
	$ALL=$res->fields['pages'];
	
	$all_pages=ceil($ALL/$PAGES);
  
	for ($i=1;$i<=$all_pages;$i++) {
		
	 
	 if ($i==$the_page) {
	   echo "[".$i."]";
	 } else {
	  ?>
	   <a onclick="document.myform.option2.value='<?php echo $i;?>';document.myform.submit()" style="cursor:hand;color:#0000FF" title="��<?php echo $i;?>��"><?php echo $i;?></a>
	  <?php
	 } // end if
	 
	} // end for
	
} // end function

//���o�Y�Z�žǥͪ��Ҧ��W�� 2���}�C
function get_seme_class_students($the_seme,$seme_class) {
	
	global $CONN;
	
	$query="select a.student_sn,a.seme_num,b.stud_name from stud_seme a,stud_base b where a.seme_year_seme='$the_seme' and a.seme_class='$seme_class' and a.student_sn=b.student_sn order by seme_num";
	$res_stud_list=$CONN->Execute($query) or die("SQL���~:".$query);
	$select_students=$res_stud_list->GetRows();
	
	return $select_students;
	
}
