<?php
//�Ǵ����ΦC��
function list_club_select($c_curr_seme,$c_curr_class) {
	if ($c_curr_seme==sprintf('%03d%1d',curr_year(),curr_seme())) {
	  $query="select a.*,b.class_num from stud_club_base a, teacher_post b where a.year_seme='$c_curr_seme' and a.club_class='$c_curr_class' and a.club_teacher=b.teacher_sn order by b.teach_title_id,b.class_num,a.club_name";
	} else {
	  $query="select * from stud_club_base where year_seme='$c_curr_seme' and club_class='$c_curr_class' order by club_name";
	}
	$result=mysql_query($query);
	?>
	<select size="20" name="select_club_sn" onchange="document.myform.club_sn.value=document.myform.select_club_sn.value;document.myform.mode.value='list';document.myform.submit();">
		<option value="" style="color:#FF00FF">�п�ܪ���</option>	
	<?php
	while ($row=mysql_fetch_array($result)) {
	  ?>
	  <option value="<?php echo $row['club_sn'];?>"<?php if ($_POST['club_sn']==$row['club_sn']) echo " selected";?>><?php echo get_teacher_name($row['club_teacher'])."-".$row['club_name'];?></option>
	  <?php
	}
	?>
</select>
	<?php
	/*
	?>
  <table border="1" bordercolor="#000000" style="border-collapse:collapse" width="100%">
	 <tr>
	 <td>
	<table border="0" width="100%">
	 	<tr bgcolor="#FFCCFF">
	  		<td width="100" style="font-size:9pt;color:#000">���ΦW��</td>
	  		<td width="60" style="font-size:9pt;color:#000">���ɦѮv</td>
	 	</tr>
	 </table>
	 	<div  style="OVERFLOW: auto; HEIGHT: 400px; " border="1" >
			<table border="0" widtn="140">
				<?php
				while ($row=mysql_fetch_array($result)) {
				?>
				<tr bgcolor="#FFFFFF" style="cursor:hand" onclick="club_list(<?php echo $row['club_sn'];?>);" onmouseover="setPointer(this, 'over', '#FFFFFF', '#CCFFCC', '#FFCC99')" onmouseout="setPointer(this, 'out', '#FFFFFF', '#CCFFCC', '#FFCC99')" onmousedown="setPointer(this, 'click', '#FFFFFF', '#CCFFCC', '#FFCC99')" <?php if ($row['club_sn']==$_POST['club_sn']) echo "style='color:#FF0000'";?>>
		 			<td width="90" style="font-size:9pt;color:#000">
		 				<?php echo $row['club_name'];?>
		 			</td>
					<td width="40" style="font-size:9pt;color:#000">
						<?php echo get_teacher_name($row['club_teacher']);?>
					</td>		
				</tr>
				<?php
				} // en	d while
	?>
			</table>
		</div>
	</td>
    </tr>
	</table>

	<?php
	*/
	
	
} // end function

//�C�X�Z�žǥͨѿ��
function list_students_select ($club_sn) {
	global $SETUP;
	$CLUB=get_club_base($club_sn);
	//���o�~�Ÿ��
	$query= ($CLUB['club_class']<100)
	?"SELECT class_id,c_name FROM `school_class`  WHERE year='".sprintf('%d',substr($CLUB['year_seme'],0,3))."' and semester='".substr($CLUB['year_seme'],-1)."' and c_year='".$CLUB['club_class']."' order by class_id"
	:"SELECT class_id,c_name FROM `school_class`  WHERE year='".sprintf('%d',substr($CLUB['year_seme'],0,3))."' and semester='".substr($CLUB['year_seme'],-1)."'  order by class_id";
	$res_class=mysql_query($query);
	?>
	<Script language="JavaScript">
	   document.myform.mode.value="add_members";
	   document.myform.club_sn.value=<?php echo $_POST['club_sn'];?>
	</Script>
	<table border="0" width="100%">

			<td>
				<select name="class_id" size="1" onchange="document.myform.submit();">
					<option value="" style="color:#FF00FF">�п�ܯZ��...</option>
					<?php				 
				  while ($row_class=mysql_fetch_array($res_class)) {
				  	?>
				  		<option value="<?php echo $row_class['class_id'];?>" <?php if ($row_class['class_id']==$_POST['class_id']) echo "selected";?>><?php echo get_seme_class_2_name(sprintf('%d',substr($row_class['class_id'],6,2)),$row_class['c_name']);?></option>
				  	<?php
				  } // end while
				?>
				</select>
				<?php
				 if (isset($_POST['class_id'])) {
				 ?>
				 <input type='button' name='all_stud' value='����' onClick='javascript:tagall(1);'><input type='button' name='clear_stud'  value='������' onClick='javascript:tagall(0);'>
				 <?php
				 } // end if
				?>
			</td>
		</tr>
	</table> 	
	<?php
	//�Y�����, �h�C�X�ǥͨѤĿ�
	if (isset($_POST['class_id'])) {
		
   	$c_curr_class=$_POST['class_id'];
		$seme_year_seme=substr($c_curr_class,0,3).substr($c_curr_class,4,1);
		$seme_class=sprintf("%d",substr($c_curr_class,6,2).substr($c_curr_class,9,2));
		$query="select a.seme_num,a.student_sn,b.stud_name from stud_seme a,stud_base b where a.seme_year_seme='$seme_year_seme' and a.seme_class='$seme_class' and a.student_sn=b.student_sn and (b.stud_study_cond=0 or b.stud_study_cond=2) order by a.seme_num";
		$result=mysql_query($query)
		?>
    	<table border="1" bordercolor="#800000" style="border-collapse:collapse" width="600">
  		<?php
  		$i=0;
  		while ($row=mysql_fetch_array($result)) {
  			$i++;
  		if ($i%5==1) echo "<tr>";
  		//�ˬd�O�_�w������
  		 if ( chk_if_exist_stud($_POST['club_sn'],$row['student_sn']) or ($SETUP['multi_join']==0 and check_student_joined_club($row['student_sn'],$seme_year_seme))) {
  		 	?>
  			<td width="100" style="font-size:10pt" bgcolor="#FFCCCC">�E<?php echo $row['seme_num'].".".$row['stud_name'];?>	</td>
  		 	<?php
  		 	//�Y�����Q��J������
  		 } else {
  			?>
  			<td width="100" style="font-size:10pt">
  				<input type='checkbox' name='selected_stud[<?php echo $row['student_sn'];?>]' value='<?php echo $row['stud_name'];?>' id='stud_selected'>
  				<?php echo $row['seme_num'].".".$row['stud_name'];?>
  			</td>
    	<?php
      	} // end if check_exist_service_stud
    	if ($i%5==0) echo "</tr>";
   } // end while
    if ($i%5>0) {
     for ($j=$i%5+1;$j<=5;$j++) { echo "<td></td>"; }
     echo "</tr>";
    }
  ?>
  
  </table>
<?php
	
	} // end if isset($_POST['class_id'])
}// end function

//�C�X�Ҧ������`��
function listall_club($year_seme) {

	global $school_kind_name;
	//���o�Ǵ����γ]�w
  $SETUP=get_club_setup($year_seme);

	$school_kind_name[100]="��~";
	$class_year_array=get_class_year_array(sprintf('%d',substr($year_seme,0,3)),sprintf('%d',substr($year_seme,-1)));
	$class_year_array[100]="100";

	?>
	       
        <script src="include/jquery-1.6.2.min.js"></script> 
        <script src="include/jquery.idTabs.min.js"></script> 

    <div> 
        <ul class="idTabs"> 
        	<table border="1" style="border-collapse:collapse" bordercolor="#000">
        		<tr>
			<?php
      foreach ($class_year_array as $K=>$class_year_name) {
			  $query="select * from stud_club_base where year_seme='$year_seme' and club_class='$K' order by club_name";
			  $result=mysql_query($query);
			  if (mysql_num_rows($result)) {
			?>
                <td><a href="#<?php echo "class".$K;?>" style="font-size:10pt"><?php echo $school_kind_name[$K];?>��</a></td>
			<?php
			  } // end if
			} // end foreach
			?>
			</table>
            </ul> 
				<?php
	      foreach ($class_year_array as $K=>$class_year_name) {
	      	list_class_club_choice_detail($year_seme,$K,1,1); //�C�X�~�Ū��ο�ҩ���
      } // end foreach	
    ?>
   </div>
    <?php
}

//�C�X�Y�Ǵ����Z�ǥ��`��==================================================================================================================
function student_club_select($classid,$c_curr_seme) {
	$query="select a.*, b.seme_class,b.seme_num from stud_base a,stud_seme b where b.seme_class='$classid' and b.seme_year_seme='$c_curr_seme' and a.student_sn=b.student_sn order by b.seme_num";
	$result=mysql_query($query);

?>

  <table border="1" bordercolor="#800000" style="border-collapse:collapse" width="800">
  <?php
  $i=0;
  while ($row=mysql_fetch_array($result)) {
  		$i++;
  		if ($i%5==1) echo "<tr>";
  	?>
  		<td><input type="checkbox" name="STUD[<?php echo $row['student_sn'];?>]" value="<?php echo $row['seme_num'];?>" <?php if ($_POST['STUD'][$row['student_sn']]==$row['seme_num']) echo "checked";?>>
  			<?php echo $row['seme_num'];?>.<a href="javascript:check_stud('<?php echo $row['student_sn'];?>')"><?php echo $row['stud_name'];?></a></td>
    <?php
    if ($i%5==5) echo "</tr>";
   } // end foreach
    if ($i%5>0) {
     for ($j=$i%5+1;$j<=5;$j++) { echo "<td></td>"; }
    }
  ?>
  
  </table>
<?php
} // end function




function list_class_club_choice_detail($year_seme,$club_class,$show_link,$show_choice) {
	//���o�Ǵ����γ]�w
	$Y[0]="�_";
	$Y[1]="�O";

  $SETUP=get_club_setup($year_seme);

			  $query="select * from stud_club_base where year_seme='$year_seme' and club_class='$club_class' order by club_name";
			  $result=mysql_query($query);
			  if (mysql_num_rows($result)) {

				?>
			 	<div id="<?php echo "class".$club_class;?>"> 
			 	<table border="1" style="border-collapse:collapse" bordercolor="#800000" cellpadding="3">
			 	  <tr bgcolor="#FFCCFF">
			 	  	<td width="180" style="font-size:10pt;color:#000000">���ΦW��</td>
			 	  	<td width="60" style="font-size:10pt;color:#000000" align="center">���ɦѮv</td>
			 	  	<td width="60" style="font-size:10pt;color:#000000">�W�Ҧa�I</td>
			 	  	<td width="30" style="font-size:10pt;color:#000000" align="center">�W�B</td>
			 	  	<td width="50" style="font-size:9pt;color:#000000" align="center">�w�s�ǭ�</td>
			 	  	<td width="50" style="font-size:10pt;color:#000000" align="center">�i���</td>
				    <?php
				    if ($show_choice==0) {
				    ?>
				    <td style="font-size:10pt;color:#000000" align="center">����²��</td>
				    <?php
				    }
				    if ($show_choice==1) {
				     for ($i=1;$i<=$SETUP['choice_num'];$i++) {
				      echo "<td style=\"font-size:8pt\" align=\"center\">���@".$i."</td>";
				     }
				    } // end if
				    ?>
			 	  </tr>
			 	  <?php
			 	   while ($row=mysql_fetch_array($result)) {
			 	   	$stud_number=get_club_student_num($row['year_seme'],$row['club_sn']);
			 	    ?>
			 	  <tr>
			 	  	<td style="font-size:10pt;color:#0000FF">
			 	  	 <?php
			 	  	  if ($show_link) {
			 	  	 ?>
			 	  		<a style="cursor:hand;color:#0000FF" onclick="club_list(<?php echo $row['club_sn'];?>);"><?php echo $row['club_name'];?></a>
			 	  		<?php
			 	  	}else{
			 	  		 echo $row['club_name'];
			 	  	}
			 	  		?>
			 	  	</td>
			 	  	<td style="font-size:10pt;color:#000000" align="center"><?php echo get_teacher_name($row['club_teacher']);?></td>
			 	  	<td style="font-size:10pt;color:#000000" align="center"><?php echo $row['club_location'];?></td>
			 	  	<td style="font-size:10pt;color:#000000" align="center"><?php echo $row['club_student_num'];?></td>
			 	  	<td style="font-size:10pt;color:#000000" align="center"><?php echo $stud_number[0];?> (<font color="#0000FF"><?php echo $stud_number[1];?></font>,<font color="#FF6633"><?php echo $stud_number[2];?></font>)</td>
			 	  	<td style="font-size:10pt;color:#000000" align="center"><?php echo $Y[$row['club_open']];?></td>
				  	<?php
				  	//����ܤw����@���Ӯ�, �C�X²��
				    if ($show_choice==0) {
				    	$w=preg_replace("/".chr(13).chr(10)."/","<br>".chr(13).chr(10),$row['club_memo']);
				    ?>
				    <td style="font-size:10pt;color:#000000"><?php echo $w;?></td>
				    <?php
				    } // end if show_choice==0
            //��ܤw����@���Ӯ�, ���C�X²��
				    if ($show_choice==1) {
					    for ($i=1;$i<=$SETUP['choice_num'];$i++) {
					     echo "<td align=\"center\" style=\"font-size:10pt\">".get_club_choice_rank($row['club_sn'],$i)."</td>";
					    }
					  } // end if 
					    ?>
			 	  </tr>
			 	    <?php
			 	   } // end while
			 	  ?>
			 	</table>
			</div>
			<?php
			 } // end if mysql_num_rows
}
//�C�L�W��
function print_name_list($year_seme,$club_sn) {
		
		global $school_kind_name;
		$school_kind_name[100]="��~";

	//���o�ǥͦW��
 $query="select a.*,b.seme_class,b.seme_num,c.stud_name from association a,stud_seme b,stud_base c where a.seme_year_seme='$year_seme' and a.club_sn='".$club_sn."' and b.seme_year_seme='$year_seme' and a.student_sn=b.student_sn and a.student_sn=c.student_sn and (c.stud_study_cond=0 or c.stud_study_cond=2) order by seme_class,seme_num";
 $res=mysql_query($query);

$CLUB=get_club_base($club_sn);
?>
<Script language="JavaScript">
 function print_name() {
  flagWindow=window.open('club_print_kind.php?year_seme=<?php echo $year_seme;?>&club_sn=<?php echo $club_sn;?>','club_stud_name','width=380,height=420,resizable=1,toolbar=1,scrollbars=auto');
 }
</Script>
���ɦѮv�G<?php echo get_teacher_name($CLUB['club_teacher']);?><br>
���ΦW�١G�i<?php echo $school_kind_name[$CLUB['club_class']];?>�šj<?php echo $CLUB['club_name'];?><br>
�W�Ҧa�I�G<?php echo $CLUB['club_location'];?><br>
<table border="1" style="border-collapse:collapse" bordercolor="#000000">
 <tr>
  <td align="center" style="color:#000000;font-size:10pt" rowspan="2" width="50">�Ǹ�</td>
 	<td align="center" style="color:#000000" rowspan="2" width="120">�Z��</td>
 	<td align="center" style="color:#000000" rowspan="2" width="60">�y��</td>
 	<td align="center" style="color:#000000" rowspan="2" width="100">�m�W</td>
 	<td align="center" style="color:#000000" colspan="10">����P���Z</td>
</tr>
<tr>
	<?php
	for ($i=1;$i<=10;$i++) {
	 echo "<td width=50>&nbsp;</td>";
	}
	?>
 </tr>
 <?php
 $ii=0;
  while ($row=mysql_fetch_array($res)) {
  	$CLASS_name=$school_kind_name[substr($row['seme_class'],0,1)];
  	$ii++;
  ?>
  <tr>
  	<td align="center" style="font-size:10pt"><?php echo $ii;?></td> 
  	<td align="center"><?php echo $CLASS_name.sprintf('%d',substr($row['seme_class'],1,2))."�Z";?></td> 
  	<td align="center"><?php echo $row['seme_num'];?></td> 
  	<td align="center"><?php echo $row['stud_name'];?></td> 
	<?php
	for ($i=1;$i<=10;$i++) {
	 echo "<td>&nbsp;</td>";
	}
	?>
 </tr>  
  <?php 
  } // end while
 ?>
</table>
<?php
} // end function
//�C�L���Z�W�� 100_2_08_10
function print_class_student($c_curr_seme,$c_curr_class,$show_score,$show_feedback) {
	global $school_kind_name;
  
  if ($_POST['mode']=="") {
   echo "<input type=\"button\" value=\"�͵��C�L\" onclick=\"print_class()\">";
  }
	$club_class=sprintf('%d%02d',substr($c_curr_class,6,2),substr($c_curr_class,9,2));
	echo $school_kind_name[substr($club_class,0,1)].sprintf('%d',substr($club_class,1,2))."�Z";
	$query="select a.stud_name,b.seme_num,b.student_sn from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_class='$club_class' and b.seme_year_seme='$c_curr_seme' and (a.stud_study_cond=0 or a.stud_study_cond=2) order by seme_num";
	
	$result=mysql_query($query);
	
	?>
	<table border="1" style="border-collapse:collapse" bordercolor="#000000" cellpadding="2">
		<tr bgcolor="#CCFFCC">
			<td width="50" align="center">�y��</td>
		  <td width="80" align="center">�m�W</td>
		  <td width="120" align="center">�ѥ[����</td>
		  <?php
		  if ($show_score) {
		  ?>
			<td width="60" align="center">���Z</td>
		  <td width="300" align="center">�ǲߴy�z</td>
		  <?php
		  }
		  ?>
 		  <?php
		  if ($show_feedback) {
		  ?>
		  <td width="300" align="center">�ǥͦۧڬ٫�</td>
		  <?php
		  }
		  ?>

		</tr>
 <?php
	while ($row=mysql_fetch_array($result)) {
		?>
		 <tr>
		 	<td align="center"><?php echo $row['seme_num'];?></td>
		 	<td align="center"><?php echo $row['stud_name'];?></td>
		 	<td>
		 		 <?php
		 		 $i=0;$my_score="";$my_description="";$my_feedback="";
		 		 $my_club=get_student_join_club($row['student_sn'],$c_curr_seme);
		 		  	foreach ($my_club as $my_club_sn=>$My) {
	 					$i++;
	 					echo $My['club_name'];
	 					
	 					$S=get_student_score($row['student_sn'],$my_club_sn);
	 					$my_score[$i]=$S['score'];
	 					$my_feedback[$i]=$S['stud_feedback'];
	 					$my_description[$i]=$S['description'];
	 					if (count($my_club)>1 and $i<count($my_club)) echo "<br>";
					}		 		  
		 		  ?>
		 	</td>
		 	<?php
		  if ($show_score) {
		  ?>
			<td align="center">
				<?php 
				$i=0;
				foreach ($my_score as $score) {
				 $i++;
				 $score=($score==0)?"-":$score;
				 echo $score;
				 if (count($my_score)>1 and $i<count($my_score)) echo "<br>"; 
				}
				?>
				</td>
		  <td style="font-size:10pt">
				<?php 
				$i=0;
				foreach ($my_description as $description) {
				 $i++;
				 echo $description;
				 if (count($my_description)>1 and $i<count($my_description)) echo "<br>"; 
				}
				?>
	  	</td>
		  <?php
		  }
		  
		  if ($show_feedback) {
		  ?>
		  <td style="font-size:10pt">
				<?php 
				$i=0;
				foreach ($my_feedback as $feedback) {
				 $i++;
				 echo $feedback;
				 if (count($my_feedback)>1 and $i<count($my_feedback)) echo "<br>"; 
				}
				?>
	  	</td>
		  <?php
		  }
	}
	?>
	</table>
	<Script Language="JavaScript">
		function print_class() {
		  document.myform.target="_blank";
		  document.myform.mode.value="print";
		  document.myform.submit();
		}
	</Script>
	<?php
}

//�͵�����
function list_class_info($c_curr_seme,$c_curr_class) {
	//���Υi�ѿ�ܤH��
	$club_for_stud_number=club_for_stud_num($c_curr_class,$c_curr_seme);
	$club_for_stud_num=$club_for_stud_number[0];
	//���o�Ӧ~�ŤH��
	$CLASS_num=class_student_num($c_curr_class,$c_curr_seme);

?>
	<table border="1" style="border-collapse:collapse" bordercolor="#800000" cellpadding="3" width="100%">
		<tr bgcolor="#FFFFCC">
			<td style="color:#0000FF">�͵������G���~�Ŧ@�p <?php echo $CLASS_num;?> ��ǥ͡A�������γѾl <?php echo $club_for_stud_num;?> �Ӷ}���צW�B�C</td>
		</tr>
	</table>
<?php
}

//���Ϊ��
function list_club ($club_sn) {
	$Y[0]="�_";
	$Y[1]="�O";
	global $school_kind_name,$SETUP;
	$query="select * from stud_club_base where club_sn='$club_sn'";
	$result=mysql_query($query);
	$CLUB=mysql_fetch_array($result);
	$stud_number=get_club_student_num($CLUB['year_seme'],$CLUB['club_sn']);
	?>
	<table border="1" style="border-collapse:collapse" bgcolor="#D8D8EB" bordercolor="#000000" cellpadding="3" width="100%">
		<tr>
			<td width="150" align="right" >�Ǵ�</td>
			<td><?php echo getYearSeme($CLUB['year_seme']);?></td>
		</tr>
		<tr>
			<td width="150" align="right" >���ΦW��</td>
			<td><?php echo $CLUB['club_name'];?></td>
		</tr>
		<tr>
			<td width="150" align="right" >���Ϋ��ɦѮv</td>
			<td><?php echo get_teacher_name($CLUB['club_teacher']);?></td>
		</tr>
		<tr>
			<td width="150" align="right" >�W�Ҧa�I</td>
			<td><?php echo $CLUB['club_location'];?></td>
		</tr>
		<tr>
			<td width="150" align="right" >���ݦ~��</td>
			<td><?php
			if ($CLUB['club_class']<100) { 
			echo $school_kind_name[$CLUB['club_class']]."��";
			} else {
			 echo "��~��";
			}
			?>
			</td>
		</tr>
		<tr>
			<td width="150" align="right" >�w�p�}�Z�H��</td>
			<td><?php echo $CLUB['club_student_num'];?>�H (�k�͡G<?php echo $CLUB['stud_boy_num'];?>�H�A�k�͡G<?php echo $CLUB['stud_girl_num'];?>�H)
				<?php 
				 if ($CLUB['ignore_sex']) echo "<font color=red size=2>�������Ψk�k�ͳ]�w���C�J�s�Z�Ѧ�!</font>";
				?>
				</td>
		</tr>
		<tr>
			<td width="150" align="right" >�ثe�s�Z�H��</td>
			<td><?php echo $stud_number[0];?> �H (�k��: <?php echo $stud_number[1];?>�H�A�k�͡G<?php echo $stud_number[2];?>�H)</td>
		</tr>
  	<tr>
			<td width="150" align="right" >�q�L����</td>
			<td><?php echo $CLUB['pass_score'];?>�� <font size=2 color=red>(�f�t���Z���X�ϥ�,�F�����Ƥ~�����λ{��)</font></td>
		</tr>

		<tr>
			<td width="150" align="right" >�O�_�}����</td>
			<td><?php echo $Y[$CLUB['club_open']];?></td>
		</tr>
		<tr>
			<td width="150" align="right" style="font-size:10pt">�}���װ_�l�ɶ�</td>
			<td><?php echo $SETUP['choice_sttime'];?>
			</td>
		</tr>
		<tr>
			<td width="150" align="right"  style="font-size:10pt">�}���׵����ɶ�</td>
			<td><?php echo $SETUP['choice_endtime'];?></td>
		</tr>
		<tr>
			<td width="150" align="right" valign="top">����²��</td>
			<td><?php echo $CLUB['club_memo'];?></td>
		</tr>
	</table>	
	<?php
} // end function


//�C�X�ǥͩҦ����ά��ʰO��
function list_club_record($student_sn) {
 global $CONN;
 	$query="select * from association where student_sn='$student_sn'";
  $res=$CONN->Execute($query) or die("SQL���~:$query");
  $i=0;
  $S=array();
  
  if ($res->NumRows()>0) {
  	while($row=$res->FetchRow()){
  		$i++;
  		foreach ($row as $k=>$v) {
  		 $S[$i][$k]=$v;
  		}
			$sql="select a.seme_class,a.seme_num,b.stud_name from stud_seme a,stud_base b where a.student_sn=b.student_sn and a.student_sn='$student_sn' and a.seme_year_seme='".$row['seme_year_seme']."'";
			$res_stud=$CONN->Execute($sql) or die("SQL���~:$sql");
			$S[$i]['seme_class']=$res_stud->fields['seme_class'];
			$S[$i]['seme_num']=$res_stud->fields['seme_num'];
			$S[$i]['stud_name']=$res_stud->fields['stud_name'];
  	} // end while
  	
  	print_student_record($S);
  	
  }

}

//�C��
function print_student_record($student) {
	global $school_long_name;
?>
	<table border="0" width="100%">
	  <tr>
	     <td align="center" style="font-size:16pt;font-family:�з���">
	     	<?php
	     	 	echo $school_long_name."�ǥͪ��ά��ʬ�����";	     	
	     	?>
	    </td>
	</table>
	<table border="1" style="border-collapse:collapse" bordercolor="#800000" width="100%">
	  <tr bgcolor="#EEEEEE">
	    <td align="center">�Ǵ�</td>
	    <td align="center">�Z��</td>
	    <td align="center">�y��</td>
	    <td align="center">�m�W</td>
	    <td align="center">�ѥ[����</td>
	    <?php if ($_POST['score_list']) { ?>
	    <td align="center">���Z</td>
	  	<?php } ?>
	    <td align="center">¾��</td>
	    <td>���ɦѮv���y</td>
	    <td>�ǥͦۧڬ٫�</td>
	  </tr>
	  <?php
		foreach ($student as $v) {
		?>
	  <tr>
	    <td align="center"><?php echo $v['seme_year_seme'];?></td>
	    <td align="center"><?php echo $v['seme_class'];?></td>
	    <td align="center"><?php echo $v['seme_num'];?></td>
	    <td align="center"><?php echo $v['stud_name'];?></td>
	    <td align="center"><?php echo $v['association_name'];?></td>
	    <?php if ($_POST['score_list']) { ?>
	    <td align="center"><?php echo $v['score'];?></td>
	  	<?php } ?>
	    <td align="center"><?php echo $v['stud_post'];?></td>
	    <td><?php echo $v['description'];?></td>
	    <td><?php echo $v['stud_feedback'];?></td>
	  </tr>
		
		<?php
	  }
	  
	  ?>	  
	</table>
	<table border="0" width="100%">
		<tr>
			<td valign="top">
				&nbsp;
			</td>
			<td width="150">
				<table border="1" style="border-collapse:collapse;border-style:dashed" bordercolor="#000000" width="150" height="150">
					<tr>
						<td width="150" height="150" valign="bottom" align="center" style="color:#c0c0c0;font-size:9pt">�ǰȳB�ֳ�</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

<?php
} // end fucntion



//��ܪ��ξǭ��W��
function list_club_members($club_sn) {
	global $CONN;
  $query="select a.student_sn, b.seme_class,b.seme_num,c.stud_name from association a,stud_seme b,stud_base c where a.club_sn='$club_sn' and a.student_sn=b.student_sn and a.student_sn=c.student_sn and a.seme_year_seme=b.seme_year_seme and (c.stud_study_cond=0 or c.stud_study_cond=2) order by seme_class,seme_num";
  $res=$CONN->Execute($query);
  $i=0;
  if ($res->NumRows()>0) {
  ?>
  <table border="0" width="100%">
  	<tr>
  		<td style="color:#0000FF;font-size:10pt">���s�C�b�����Ϊ��ǭ�:<input type='button' name='all_stud' value='����' onClick='javascript:tagall(1);'><input type='button' name='clear_stud'  value='������' onClick='javascript:tagall(0);'>
  			</td>
  	</tr>
  </table>
   <table border="1" width="100%" style="border-collapse:collapse" bordercolor="#CCCCCC">
  <?php
  while(!$res->EOF){

   $seme_class=$res->fields['seme_class'];
   $seme_num=$res->fields['seme_num'];
   $stud_name=$res->fields['stud_name'];
	 $student_sn=$res->fields['student_sn'];
	    
   $i++;
   if ($i%5==1) echo "<tr>";
   ?>
   <td style="font-size:9pt">
   	 <input type="checkbox" name="selected_stud[]" value="<?php echo $student_sn; ?>">
   	 <?php echo $i.".".$stud_name."(".$seme_class.sprintf('%02d',$seme_num).")";?>
   </td>
   <?php
   if ($i%5==0) echo "</tr>";
   $res->MoveNext();
  } // end while
  ?>
	</table>
  <?php
   return true;
  } else{
  	echo "<font color=red>�������Ω|�����ǭ��s�s!</red>";
  	return false;
  }
} // end function
//=====================================================================================
//���δ���]�w
function form_club_setup ($year_seme) {
	$SETUP=get_club_setup($year_seme);
	?>
	<table border="1" style="border-collapse:collapse" bgcolor="#D8D8EB" bordercolor="#000000" cellpadding="3" width="100%">
		<tr>
			<td width="150" align="right" style="font-size:12pt;color:#800000">�Ǵ�</td>
			<td><?php echo getYearSeme($SETUP['year_seme']);?></td>
			<input type="hidden" name="year_seme" value="<?php echo $SETUP['year_seme'];?>">
		</tr>
		<tr>
			<td width="150" align="right" style="font-size:12pt;color:#800000">�}���װ_�l�ɶ�</td>
			<td><input type="text" name="choice_sttime_date" id="choice_sttime_date" size="12" value="<?php echo substr($SETUP['choice_sttime'],0,10);?>">
					<script type="text/javascript">
				    new Calendar({
  		      		inputField: "choice_sttime_date",
   		     		dateFormat: "%Y-%m-%d",
    		   		trigger: "choice_sttime_date",
    		    	bottomBar: true,
    		    	weekNumbers: false,
    		    	showTime: 24,
    		    	onSelect: function() {this.hide();}
				    });
					</script>
	 				 <?php SelectTime('choice_sttime_hour',substr($SETUP['choice_sttime'],11,2),24);?>�I
					 <?php SelectTime('choice_sttime_min',substr($SETUP['choice_sttime'],14,2),60);?>��
			</td>
		</tr>
		<tr>
			<td width="150" align="right" style="font-size:12pt;color:#800000">�}���׵����ɶ�</td>
			<td>
				<input type="text" name="choice_endtime_date" id="choice_endtime_date" size="12"  value="<?php echo substr($SETUP['choice_endtime'],0,10);?>">
					<script type="text/javascript">
				    new Calendar({
  		      		inputField: "choice_endtime_date",
   		     		dateFormat: "%Y-%m-%d",
    		   		trigger: "choice_endtime_date",
    		    	bottomBar: true,
    		    	weekNumbers: false,
    		    	showTime: 24,
    		    	onSelect: function() {this.hide();}
				    });
					</script>
				<?php SelectTime('choice_endtime_hour',substr($SETUP['choice_endtime'],11,2),24);?>�I
				<?php SelectTime('choice_endtime_min',substr($SETUP['choice_endtime'],14,2),60);?>��
			</td>
		</tr>
		<tr>
			<td width="150" align="right"  style="font-size:12pt;color:#800000">�w�]�C���ΤH��</td>
			<td><input type="text" name="student_num" value="<?php echo $SETUP['student_num'];?>" size="3">�H</td>
		</tr>
		<tr>
			<td width="150" align="right"  style="font-size:12pt;color:#800000">�w�]�ǥͥi����@��</td>
			<td>
				 <select size="1" name="choice_num">
				 	<?php
				 	//�̦h�i�]�w20�ӧ��@
				 	for ($i=1;$i<=20;$i++) {
				 	?>
				 	 <option value="<?php echo $i;?>"<?php if ($SETUP['choice_num']==$i) echo " selected";?>><?php echo $i;?></option>
				 	<?php
				 	}
				 	?>
				 </select>�� <font size=2 color=red>(�ФŶW�L�i��ת������`��)</font>
				
				<!-- <input type="text" name="choice_num" value="<?php echo $SETUP['choice_num'];?>" size="3">�� --->
			</td>
		</tr>
		<tr>
			<td width="150" align="right"  style="font-size:12pt;color:#800000">��׮ɤ��\�W��</td>
			<td>
				<input type="radio" name="choice_over" value="0" <?php if ($SETUP['choice_over']==0) echo "checked";?> onclick="check_no_choice_over();">�����\ 
				<input type="radio" name="choice_over" value="1" <?php if ($SETUP['choice_over']==1) echo "checked";?>>���\�W��
				<br>
				<font size="2" color=red>�Ҧp�G�Y�Y���ιw�p�ۦ�30�H�A�O�_���\�W�L30�Ӿǥ͹w��o�Ӫ��ΡA�q�`�]�����\�A�Y�Q�ձĥ��m��Ĺ��h�藍���\�C</font>
			</td>
		</tr>
		<tr>
			<td width="150" align="right"  style="font-size:12pt;color:#800000">����ǥͦ۰ʽs�Z</td>
			<td><input type="radio" name="choice_auto" value="0" <?php if ($SETUP['choice_auto']==0) echo "checked";?>>���۰ʽs�Z <input type="radio" name="choice_auto" value="1" <?php if ($SETUP['choice_auto']==1) echo "checked";?>>����ǥͦ۰ʽs�J�Z��</td>
		</tr>
		<tr>
			<td width="150" align="right"  style="font-size:12pt;color:#800000">���\�@�ӫ��ɦѮv���ɦh�Ӫ���</td>
			<td>
				<input type="radio" name="teacher_double" value="0" <?php if ($SETUP['teacher_double']==0) echo "checked";?>>�����\
				<input type="radio" name="teacher_double" value="1" <?php if ($SETUP['teacher_double']==1) echo "checked";?>>���\
			</td>
		</tr>
		<tr>
			<td width="150" align="right"  style="font-size:12pt;color:#800000">���\�@�ӾǥͰѥ[�h�Ӫ���</td>
			<td>
				<input type="radio" name="multi_join" value="0" <?php if ($SETUP['multi_join']==0) echo "checked";?>>�����\
				<input type="radio" name="multi_join" value="1" <?php if ($SETUP['multi_join']==1) echo "checked";?>>���\
				<br>
				<font size="2" color=red>���B��ܤ����\�ɡA�Y�@�Ӿǥͤw�i���Ҥ~�Q��ʫ��w���ΡA�h���Ҹ�ƱN�۰ʥ��ġA���|�Q�Ω�s�Z�C</font>				
			</td>
		</tr>
		<tr>
			<td width="150" align="right"  style="font-size:12pt;color:#800000">�ɮv�i�d�߯Z�Ŧ��Z</td>
			<td>
				<input type="radio" name="show_score" value="0" <?php if ($SETUP['show_score']==0) echo "checked";?>>���}��
				<input type="radio" name="show_score" value="1" <?php if ($SETUP['show_score']==1) echo "checked";?>>�}��
			</td>
		</tr>
		<tr>
			<td width="150" align="right"  style="font-size:12pt;color:#800000">�ɮv�i�d�߯Z�žǥͦۧڬ٫�</td>
			<td>
				<input type="radio" name="show_feedback" value="0" <?php if ($SETUP['show_feedback']==0) echo "checked";?>>���}��
				<input type="radio" name="show_feedback" value="1" <?php if ($SETUP['show_feedback']==1) echo "checked";?>>�}��
			</td>
		</tr>
		<tr>
			<td width="150" align="right"  style="font-size:12pt;color:#800000">���ɦѮv�i�d�߾ǥͦۧڬ٫�</td>
			<td>
				<input type="radio" name="show_teacher_feedback" value="0" <?php if ($SETUP['show_teacher_feedback']==0) echo "checked";?>>���}��
				<input type="radio" name="show_teacher_feedback" value="1" <?php if ($SETUP['show_teacher_feedback']==1) echo "checked";?>>�}��
			</td>
		</tr>

	</table>
	
	
	<?php
} // end function

//���Ϊ��
function form_club ($CLUB) {
	global $school_kind_name,$SETUP;
	?>
	<table border="1" style="border-collapse:collapse" bgcolor="#D8D8EB" bordercolor="#000000" cellpadding="3" width="100%">
		<tr>
			<td width="150" align="right" >�Ǵ�</td>
			<td><?php echo getYearSeme($CLUB['year_seme']);?></td>
			<input type="hidden" name="year_seme" value="<?php echo $CLUB['year_seme'];?>">
		</tr>
		<tr>
			<td width="150" align="right" >���ΦW��</td>
			<td><input type="text" name="club_name" value="<?php echo $CLUB['club_name'];?>"></td>
		</tr>
		<tr>
			<td width="150" align="right" >���Ϋ��ɦѮv</td>
			<td>
					<select name="club_teacher" size="1">
						<?php 
						 if ($CLUB['club_teacher']=="") {
						 	?>
						 	 <option value="" style="color:#FF00FF">�п��...</option>
						 	<?php
						 }
						  $teacher_array=teacher_base();
						  foreach ($teacher_array as $teacher_sn=>$name) {
						  	  if (chk_if_exist_teacher($CLUB['year_seme'],$teacher_sn) and $teacher_sn!=$CLUB['club_teacher'] and $SETUP['teacher_double']==0) continue;
						  	?>
						  	 <option value="<?php echo $teacher_sn;?>"<?php if ($teacher_sn==$CLUB['club_teacher']) echo " selected";?>><?php echo $name; ?></option>
						  	<?php
						  }
						?>
					</select>
			</td>
		</tr>
		<tr>
			<td width="150" align="right" >���ݦ~��</td>
			<td>
			<?php
			    $class_year_array=get_class_year_array(sprintf('%d',substr($CLUB['year_seme'],0,3)),sprintf('%d',substr($CLUB['year_seme'],-1)));
                foreach ($class_year_array as $K=>$class_year_name) {
                	?>
                	<input type="radio" name="club_class" value="<?php echo $K;?>" <?php if ($CLUB['club_class']==$K) echo "checked";?>><?php echo $school_kind_name[$K];?>�� &nbsp;
                	<?php
                }			 
			?>
			  <input type="radio" name="club_class" value="100" <?php if ($CLUB['club_class']=='100') echo "checked";?>>��~�� 
			</td>
		</tr>
		<tr>
			<td width="150" align="right" >�w�p�}�Z�H��</td>
			<td>
				�k��<input type="text" name="stud_boy_num" value="<?php echo $CLUB['stud_boy_num'];?>" size="3" onblur="chk_stud_num()">�H, 				
				�k��<input type="text" name="stud_girl_num" value="<?php echo $CLUB['stud_girl_num'];?>" size="3"  onblur="chk_stud_num()">�H
				(�`�p<input type="text" style="color:#FF0000" name="club_student_num" value="<?php echo $CLUB['club_student_num'];?>" size="3"  onblur="chk_stud_num()">�H)
			
			</td>
		</tr>
		<tr>
			<td width="150" align="right" >�����ʧO�s�Z</td>
			<td style="color:#FF0000;font-size:10pt"><input type="checkbox" name="ignore_sex" value="1" <?php if ($CLUB['ignore_sex']==1) echo "checked";?>>�t�νs�Z�ɩ����e���k�k�ͤH�Ƴ]�w</td>
		</tr>
		<tr>
			<td width="150" align="right" >�W�Ҧa�I</td>
			<td><input type="text" name="club_location" value="<?php echo $CLUB['club_location'];?>" size="20"></td>
		</tr>
		<tr>
			<td width="150" align="right" >�q�L�з�</td>
			<td><input type="text" name="pass_score" value="<?php echo $CLUB['pass_score'];?>" size="3"><font size=2 color=red>(�ǥͱo�������F���з�,�~����o�����λ{��)</font></td>
		</tr>

		<tr>
			<td width="150" align="right" >�O�_�}����</td>
			<td><input type="radio" name="club_open" value="0" <?php if ($CLUB['club_open']==0) echo "checked";?>>���}���� <input type="radio" name="club_open" value="1" <?php if ($CLUB['club_open']==1) echo "checked";?>>�}����</td>
		</tr>
		<tr>
			<td width="150" align="right" style="font-size:10pt">�}���װ_�l�ɶ�</td>
			<td><?php echo $SETUP['choice_sttime'];?></td>
		</tr>
		<tr>
			<td width="150" align="right"  style="font-size:10pt">�}���׵����ɶ�</td>
			<td><?php echo $SETUP['choice_endtime'];?>
			</td>
		</tr>
		<tr>
			<td width="150" align="right" valign="top">����²��</td>
			<td><textarea name="club_memo" rows="10" cols="64"><?php echo $CLUB['club_memo'];?></textarea></td>
		</tr>
	</table>
	
	
	<?php
} // end function
//========================================================================================
function get_club_setup($year_seme) {
 $query="select * from stud_club_setup where year_seme='$year_seme'";
 $result=mysql_query($query);
 if (mysql_num_rows($result)) {
  $setup=mysql_fetch_array($result);
  $setup['error']=0;
 }else{
 	$setup['year_seme']=$year_seme;
 	$setup['choice_sttime']=date("Y-m-d 08:00:00");
 	$setup['choice_endtime']=date("Y-m-d 16:00:00");
 	$setup['choice_num']=5; //�̦h�i����@��
 	$setup['choice_over']=1; //�w��ɬO�_���\�W������H��
 	$setup['choice_auto']=1; //�Ƨǧ��N�������Ϊ��ǥͦ۰ʱƤJ�|���W�B������
 	$setup['student_num']=32; //�w�]���ΤH��
 	$setup['show_score']=1;
 	$setup['show_feedback']=1;
 	$setup['show_teacher_feedback']=1;
 	$setup['teacher_double']=0;
 	$setup['multi_join']=0;  //2013.09.10 �O�_���\�ѥ[�h�Ӫ���
 	$setup['error']=1;
 }
 return $setup;
}

//========================================================================================
//�� seme_class�ন���� , �p:701�ন�@�~2�Z
function get_seme_class_2_name($c_year,$c_name) {
	global $school_kind_name;
	$NAME=$school_kind_name[$c_year].$c_name."�Z";
	return $NAME;	
}

//���o�Y�Ǵ����μƥ�
function get_seme_club_num($year_seme) {
	$query="select count(*) from stud_club_base where year_seme='$year_seme'";
	$result=mysql_query($query);
	list($num)=mysql_fetch_row($result);
	
	return $num;
	
}

//���o�~�Ū��μƥ�
function get_club_num($year_seme,$club_class) {
	$query="select count(*) from stud_club_base where year_seme='$year_seme' and club_class='$club_class'";
	$result=mysql_query($query);
	list($num)=mysql_fetch_row($result);
	
	return $num;
	
}

//���o���ξǥͤH��
function get_club_student_num($year_seme,$club_sn) {
	$query="select * from association where seme_year_seme='$year_seme' and club_sn='$club_sn'";
  $num[0]=mysql_num_rows(mysql_query($query));
  
  //�k��
	$query="select a.sn from association a,stud_base b where a.seme_year_seme='$year_seme' and a.club_sn='$club_sn' and a.student_sn=b.student_sn and b.stud_sex='1' and (b.stud_study_cond=0 or b.stud_study_cond=2)";
  $num[1]=mysql_num_rows(mysql_query($query));

  //�k��
	$query="select a.sn from association a,stud_base b where a.seme_year_seme='$year_seme' and a.club_sn='$club_sn' and a.student_sn=b.student_sn and b.stud_sex='2' and (b.stud_study_cond=0 or b.stud_study_cond=2)";
  $num[2]=mysql_num_rows(mysql_query($query));

	return $num;
	
}





//���o���ΰ򥻸��
function get_club_base($club_sn) {
	$query="select * from stud_club_base where club_sn='$club_sn'";
	$result=mysql_query($query);
	$row=mysql_fetch_array($result);
	
	return $row;
	
}

//���o���Ω��ݦ~��
function get_club_class($club_sn) {
	$query="select club_class from stud_club_base where club_sn='$club_sn'";
	$result=mysql_query($query);
	$row=mysql_fetch_row($result);
	
	list($club_class)=$row;
	
	return $club_class;
	
}

/***
//�� sn ���o�Ѯv�W�r
function get_teach_Name ($teacher_sn) {
	$query="select name from teacher_base where teacher_sn='$teacher_sn'";
	$result=mysql_query($query);
	$row=mysql_fetch_array($result);
	
	return $row['name'];

}
***/

//�� sn ���o�ǥ͸�� array
function get_student($student_sn,$seme_year_seme) {
  $query="select a.student_sn,a.seme_class,a.seme_num,b.stud_name from stud_seme a,stud_base b where a.student_sn='$student_sn' and a.seme_year_seme='$seme_year_seme' and b.student_sn='$student_sn'";
  $result=mysql_query($query);
  $row=mysql_fetch_array($result);
  
  return $row;

}

//���ǥͩm�W
function get_stud_name($student_sn) {
  $query="select stud_name from stud_base where student_sn='$student_sn'";
  $result=mysql_query($query);
  $row=mysql_fetch_row($result);
   list($stud_name)=$row;
  return $stud_name;

}

//�ˬd�ǥͬO�_�ѥ[����
function check_student_joined_club($student_sn,$seme_year_seme) {
  $query="select * from association where student_sn='$student_sn' and seme_year_seme='$seme_year_seme'";
  $res=mysql_query($query);
  if (mysql_num_rows($res)>0) {
  	return true;
  } else {
  	return false;
  }
}

//���o�ǥͰѥ[������
function get_student_join_club($student_sn,$seme_year_seme="") {
  $query="select a.*,b.club_name from association a,stud_club_base b where a.student_sn='$student_sn' and a.club_sn=b.club_sn";
  if ($seme_year_seme!="") $query.=" and a.seme_year_seme='$seme_year_seme'";
  $query.=" order by seme_year_seme";
  $result=mysql_query($query);
  
  if (mysql_num_rows($result)) {
  	//��z�ӥͪ��C�Ӫ��Ϊ����
   while ($row=mysql_fetch_array($result)) {
    $my_club[$row['club_sn']]['club_sn']=$row['club_sn'];
    $my_club[$row['club_sn']]['club_name']=$row['club_name'];
    $my_club[$row['club_sn']]['seme_year_seme']=$row['seme_year_seme'];
    $my_club[$row['club_sn']]['association_name']=$row['association_name'];
    $my_club[$row['club_sn']]['score']=$row['score'];
    $my_club[$row['club_sn']]['description']=$row['description'];
    $my_club[$row['club_sn']]['stud_post']=$row['stud_post'];
    $my_club[$row['club_sn']]['stud_feedback']=$row['stud_feedback'];
    }
		 
		return $my_club;  
  
  }else{
  	return false;
  }
} // end function

//���o�ǥͪ��Φ��Z
function get_student_score($student_sn,$club_sn) {
  $query="select * from association where student_sn='$student_sn' and club_sn='$club_sn'";
  $result=mysql_query($query);
  
  $row=mysql_fetch_array($result);
  
  return $row;
	
}

//�Y�~�Ū��Υi�ѿ�ܤH��
function club_for_stud_num($club_class,$year_seme) {
	//�����o�`�W�B
	$query="select sum(club_student_num),sum(stud_boy_num),sum(stud_girl_num) from stud_club_base where year_seme='$year_seme' and club_open='1' and club_class='$club_class'"; 
	list($num[0],$num[1],$num[2])=mysql_fetch_row(mysql_query($query));
  
  //�v�@�����C�@�Ӫ��Τw�����W�B
  $query="select club_sn from stud_club_base where year_seme='$year_seme' and club_open='1' and club_class='$club_class'"; 
  $result=mysql_query($query);
  while ($row=mysql_fetch_row($result)) {
   list($club_sn)=$row;
   $stud_number=get_club_student_num($year_seme,$club_sn);
   $num[0]=$num[0]-$stud_number[0]; //�w�ѥ[�Ӫ��Ϊ��ǥͼ�
   $num[1]=$num[1]-$stud_number[1]; //�w�ѥ[�Ӫ��Ψk�ͼ�
   $num[2]=$num[2]-$stud_number[2]; //�w�ѥ[�Ӫ��Τk�ͼ�
  }
  return $num;
}


//���o�Y���Ϊ��Y���@���w����@��
function get_club_choice_rank($club_sn,$choice_rank) {
	$query="select count(*) from stud_club_temp where club_sn='$club_sn' and choice_rank='$choice_rank'";
	$result=mysql_query($query);
	list($num)=mysql_fetch_row($result);
	
	return $num;
	
}

//���o�Y�ǥͬY�Ǵ����Y���@ club_sn
function get_seme_stud_choice_rank($year_seme,$student_sn,$choice_rank) {
 $query="select club_sn from stud_club_temp where year_seme='$year_seme' and student_sn='$student_sn' and choice_rank='$choice_rank'";
 $result=mysql_query($query);
 list($club_sn)=mysql_fetch_row($result);
 
 return $club_sn; 

}


//���o�Ӧ~�ŤH��
function class_student_num($class,$year_seme) {
	$query="select count(*) from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_class like '".$class."%%' and b.seme_year_seme='$year_seme' and (a.stud_study_cond=0 or a.stud_study_cond=2)";
	list($num)=mysql_fetch_row(mysql_query($query));

  return $num;
}


//�� year_seme �ഫ������
function getYearSeme($year_seme) {
	$text=sprintf('%d',substr($year_seme,0,3))."�Ǧ~�ײ�".substr($year_seme,-1)."�Ǵ�";
	return $text;
}
//����O�_���ɮv
function chk_leader_teacher($c_curr_class) {
  $seme_class=sprintf('%d%02d',substr($c_curr_class,6,2),substr($c_curr_class,9,2));
  $query="select teacher_sn from teacher_post where class_num='$seme_class'";
  $result=mysql_query($query);
  list($teacher_sn)=mysql_fetch_row($result);
  
  if ($teacher_sn==$_SESSION['session_tea_sn']) {
  	return true;
  }else{
  	return false;
  }  
}

//����Y�v�O�_�w�����ΦѮv
function chk_if_exist_teacher($year_seme,$teacher_sn) {
	$query="select count(*) from stud_club_base where year_seme='$year_seme' and club_teacher='$teacher_sn'";
	$result=mysql_query($query);
	list ($num)=mysql_fetch_row($result);
	
	return $num;
	
}

//����Y�ͬO�_�w�[�J�Y����
function chk_if_exist_stud($club_sn,$student_sn) {
	$query="select count(*) from association where club_sn='$club_sn' and student_sn='$student_sn'";
	$result=mysql_query($query);
	list ($num)=mysql_fetch_row($result);
	
	return $num;	
	
}

//���X�ɶ��U�Ԧ���� NAME��涵�ئW�� , Time �w�]�ɶ� , Max �̤j��  
function SelectTime($NAME,$Time,$Max) {
?>
<select size="1" name="<?php echo $NAME;?>">
	<?php
	for ($i=0;$i<$Max;$i++){
	?>
	<option value="<?php echo $i;?>"<?php if ($i==$Time) { echo " selected"; } ?>><?php echo $i;?></option>
	<?php
	}
	?>
	</select>
<?php
}

//���o�����
function make_club_post() {
	global $club_sn,$year_seme,$club_name,$club_teacher,$club_class,$club_open,$club_student_num,$club_memo,$club_location,$update_sn,$stud_boy_num,$stud_girl_num,$ignore_sex;
	$update_sn=$_SESSION['session_tea_sn'];
	foreach ($_POST as $K=>$VAR) {
		${$K}=$VAR;
	}
	$club_student_num=$stud_boy_num+$stud_girl_num;
}

function chk_if_exist_table($tbl)
{
	$tables = array();
	$q = @mysql_query("SHOW TABLES");
	while ($r = @mysql_fetch_array($q)) { 
		$tables[] = $r[0]; 
	}

	@mysql_free_result($q);

	if (in_array($tbl, $tables)) { 
  		return TRUE; 
  	} else { 
  	  return FALSE; 
  }
}  // end function

function create_table_association() {
 $query="
 CREATE TABLE IF NOT EXISTS `association` (
  `sn` int(10) unsigned NOT NULL auto_increment,
  `student_sn` varchar(10) NOT NULL,
  `seme_year_seme` varchar(4) NOT NULL,
  `association_name` varchar(40) NOT NULL,
  `score` float NOT NULL,
  `description` text NOT NULL,
  `club_sn` int(10) unsigned NOT NULL,
  `update_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`sn`)
) ;";

	mysql_query($query);

} // end function

//�s�Z�Ϊ� function ========================================================================
//�˴��~�Žs�Z���p
function check_arrange() {
 global $c_curr_class,$c_curr_seme;
 global $club_for_stud_num, $CLASS_num;
 global $CLASS_choiced, $CLASS_not_choiced, $CLASS_arranged, $CLASS_not_arranged; 
 
 global $student_not_choice; //array ���s�Z�W��
 global $student_not_choice_sex; //array ���s�Z�W��

  	  //���Υi�ѿ�ܦW�B , ���������s�Z�~��(�n���k��,�k��) , �w�h���s�Z�������W�B , 
  	  //��h�W�O�_�i�H�s�Z, �H�`�H�ƨӬݧY�i, �]���ʧO����, �i��|�]����ʫ��w�Ӧ��t��
  	  $club_for_stud_number=club_for_stud_num($c_curr_class,$c_curr_seme);
			$club_for_stud_num=$club_for_stud_number[0]; //�`��
			$club_for_stud_boy=$club_for_stud_number[1]; //�k��
			$club_for_stud_girl=$club_for_stud_number[2]; //�k��
						
			//���o�Ӧ~�ŤH��
			$CLASS_num=class_student_num($c_curr_class,$c_curr_seme);
			
			//���o�Ҧ����~�žǥ�, �A�v������ 
			
			$query="select a.student_sn,a.seme_class,a.seme_num,b.stud_sex from stud_seme a,stud_base b where a.seme_year_seme='$c_curr_seme' and a.seme_class like '".$c_curr_class."%%' and a.student_sn=b.student_sn  and (b.stud_study_cond=0 or b.stud_study_cond=2) order by seme_class,seme_num";
			$result=mysql_query($query);
			$CLASS_choiced=0; //
			$CLASS_not_choiced=$CLASS_num; //����ҤH��
			$CLASS_arranged=0; //�w�s�Z�ǥͼ�
			
			$i=0;
			while ($row=mysql_fetch_row($result)) {
			  list($student_sn,$seme_class,$seme_num,$stud_sex)=$row;
			  //�ˬd���S�����
			   $query_choice="select * from stud_club_temp where year_seme='$c_curr_seme' and student_sn='$student_sn'";
			  //�ˬd���S���s�Z
			   $query_arrange="select * from association where seme_year_seme='$c_curr_seme' and student_sn='$student_sn' and club_sn!=''"; 
			   //�w���
			   if (mysql_num_rows(mysql_query($query_choice))) {
			   	 $CLASS_choiced++;
			     $CLASS_not_choiced--;
			   } elseif (mysql_num_rows(mysql_query($query_arrange))) {
			   	  //�����, ���w�s�Z
			      $CLASS_not_choiced--;
			   } else {   
			     $student_not_choice[$seme_class][$seme_num]=$student_sn; //����ҦW��
			     $student_not_choice_sex[$seme_class][$seme_num]=$stud_sex; //����ҦW��
			   }
			   
 			   if (mysql_num_rows(mysql_query($query_arrange))) {
			     $CLASS_arranged++;
			   }
			}  //end while
			
			$CLASS_not_arranged=$CLASS_num-$CLASS_arranged; //���s�Z�H��
}

//�˴��w���, ������ǥ�, �H�����ܼƹB�@
function check_choice_not_arrange() {
 global $c_curr_class,$c_curr_seme;
 global $club_for_stud_num, $CLASS_num;
 global $CLASS_choiced, $CLASS_not_choiced, $CLASS_arranged, $CLASS_not_arranged; 
 
 global $student_choice_not_arrange; //array ���s�Z�W��
 global $student_choice_not_arrange_sex; //array ���s�Z�W��
 
 $query="select a.student_sn,b.seme_class,b.seme_num,c.stud_sex from stud_club_temp a,stud_seme b,stud_base c where a.arranged='0' and a.year_seme='$c_curr_seme' and b.seme_year_seme='$c_curr_seme' and b.seme_class like '".$c_curr_class."%%' and a.student_sn=b.student_sn and a.student_sn=c.student_sn  and (c.stud_study_cond=0 or c.stud_study_cond=2)";
 $result=mysql_query($query);
  while ($row=mysql_fetch_row($result)) {
  	list($student_sn,$seme_class,$seme_num,$stud_sex)=$row;
    $student_choice_not_arrange[$seme_class][$seme_num]=$student_sn;
    $student_choice_not_arrange_sex[$seme_class][$seme_num]=$stud_sex;
  }
}


//�N�Y�ǥͽs�J�Y����
function choice_this_stud($c_curr_seme,$club_sn,$club_name,$student_sn,$arr) {
 //�ˬd�o�Ӫ��άO�_�w���o�Ӿǥ� , �s�Z�H�Ƥ���[1, �Ǧ^ false
  if (chk_if_exist_stud($club_sn,$student_sn)) {
     write_arranged_flag($c_curr_seme,$student_sn);
     return false;
  }
 //�N�ǥͽs�J������
   $query="insert into association (student_sn,seme_year_seme,association_name,club_sn) values ('$student_sn','$c_curr_seme','".addslashes($club_name)."','$club_sn')"; 
   if (mysql_query($query)) {
 //�N���ǥͪ���ҧ��@��Ƭҵ��O��1
   write_arranged_flag($c_curr_seme,$student_sn);
 //�Y�D����j���s�Z�h�N�����@���O��2 $arr�����@��, ��ܬO�ĴX���@����
   if ($arr>0) {
    $query="update stud_club_temp set arranged='2' where year_seme='$c_curr_seme' and student_sn='$student_sn' and club_sn='$club_sn' and choice_rank='$arr'";
    mysql_query($query);
   }
   return true; //�浧�s�Z���\ , �Ǧ^ true
  }else{
   echo "Error! Query=$query";
   exit();
  }
}

//���O�Y�ǥͤw�s�Z
function write_arranged_flag($c_curr_seme,$student_sn) {
  $query="update stud_club_temp set arranged='1' where year_seme='$c_curr_seme' and student_sn='$student_sn'";
	if (!mysql_query($query)) {
	 echo "Error! query=$query";
	 exit();
	}else{
	 return true;
	}
}

//���o�ǥͩҿ諸����
function get_stud_choice($c_curr_seme,$student_sn) {
 $query="select club_sn,choice_rank from stud_club_temp where year_seme='$c_curr_seme' and student_sn='$student_sn' order by choice_rank";
 $result=mysql_query($query);
 while ($row=mysql_fetch_row($result)) {
  list($club_sn,$choice_rank)=$row;
  $C[$choice_rank]=$club_sn;
 }
 
 return $C;
 
}

function readme() {
?>
	   <table border="0" width="100%">
	   	 <tr>
	   	  <td colspan="2" style="color:#0000FF">���ά��ʪ��B�@��ĳ�y�{:</td>
	   	</tr>
	   	<tr>
	   		<td align="center" width="200" style="color:#800000">�m���ά��ʳW���n</td>
	   		<td style="font-size:10pt">�b�i��]�w���e�ƥ��W���n�U�C�n�I: <br>1.���ά��ʭn�Q�Τ���ɶ��i��? �n�}�]�X�Ӫ���? �H���ժ����k�O�C�ӬP���|���Z�|���p�Ҭ��ʮɶ��i��, �M��}�Ҥ覡�O�C�Ӿɮv���n�̦ۤv���M���}�@�Ӫ���, �Ҧp: �Ųy���B�Ʋy����.<br>
	   			2.��Ҧ�ɶ}�l�B��ɵ���, �O�o��ɭn�ƥ����i���ǥ�<br>
	   			3.�o�լd���U�ɮv,�ЦѮv��g�}�]���Ϊ��������, ���i�ѦҨt�Τ����u�s�W���Ǵ������Ρv���]�w���C<br>
	   		</td>
	   	</tr>
	   	<tr>
	   		<td align="center">��</td>
	   		<td>&nbsp;</td>
	   	</tr>
	   	<tr>
	   		<td align="center" style="color:#800000">�m�i����δ���]�w�n</td>
	   		<td style="font-size:10pt">�N�����]�w�]�n, �ר�n�`�N��Үɶ����]�w</td>
	   	</tr>
	   	<tr>
	   		<td align="center">��</td>
	   		<td>&nbsp;</td>
	   	</tr>
	   	<tr>
	   		<td align="center" style="color:#800000">�m�s�W���Ǵ������Ρn</td>
	   		<td style="font-size:10pt">1.�N�۪��Ϋ��ɦѮv���䦬���^�Ӫ����θ��, �@���@����J�C�`�N�~�ŧO�n���T�C<br>
	   			2.�p�G�O���~�Ū�����, ����ĳ�}����, �Ф�ʪ�����ܾǭ�, �_�h�s�Z�ɷ|�������������D�C<br>
	   		  3.�p�G��~�Ū��Τ��n�}����, ��ĳ���k�O�̦~�Ť����h�Ӫ��Ϊ��覡�B�z�C�Ҧp�G�X�۹άO��~�Ū��ΡA�i�ۦ��@�~�ũM�G�~�Ū��ǥ͡A�`�@�n�ۦ�60��A����b�t�γo��s�W���ήɡA�N���O�w��@�~�ũM�G�~�ų��U�}�]�@�ӦX�۹Ϊ��ΡA��Ӫ����`�H�Ƥ�����60�H�Y�i�C
	   		</td>
	   	</tr>
	   	<tr>
	   		<td align="center">��</td>
	   		<td>&nbsp;</td>
	   	</tr>
	   	<tr>
	   		<td align="center" style="color:#800000">�m�i���ҡn</td>
	   		<td style="font-size:10pt">1.�����ǥ͡A��Ҫ��a��b�i�ǥ͸�Ʀ۫ءj�Ҳժ��u���ά��ʡv�ﶵ���C<br>
	   			2.�����ǥ͡A��Үɪ`�N���ΤH�ƭ���P�w��g���@�ƪ����p�C<br>
	   			3.�����ǥ͡A����Υ���Ҫ̡A���|�j��s�Z�C<br>
	   			4.�����ǥ͡A�b��ҵ����e�A�H�ɥi�H���ۤv�����@�ǡC�ҥH�n�H�ɪ`�N�ۤv���w�����Ϊ����@��g���p�A�Y�Ӽ��������ΡA�Q��쪺���v�ӧC�ɡA�̦n�i��վ�A�H�K�̫��������A�Q�s�줣���w�����ΡC<br>
	   			5.�޲z���H�ɥi�q�i���νs�Z�j�\��̡A�d���٦����ǦP�ǩ|����ҡC
	   		</td>
	   	</tr>
	   	<tr>
	   		<td align="center">��</td>
	   		<td>&nbsp;</td>
	   	</tr>
	   	<tr>
	   		<td align="center" style="color:#800000">�m���νs�Z�n</td>
	   		<td style="font-size:10pt">1.�Ш̦~�ŭӧO�i��s�Z�C<br>
	   			2.��h�W�s�Z�{���|�ɥi��̹w�]�]�w�n���ʧO�H�ƶi��s�Z�A��������ŦX�]�w�����G�C�Ҧp�G�Ųy���쥻�w�q�ۦ��k�k�ͦU15�H�A���b�����@�ɡA�Y�Ĥ@���@���N���k��30�H��ܡA�k�ͫo�u��10�H��ܡA�h�s�Z�����G���|���ͨk��20�H�A�k��10�H�����G�C<br>
	   			3.�s�Z�O���|�۰ʫO�d�A���H�ɬd�ߡA�бq�i���κ޲z���s�Z�O���j�i��d�ߡC
	   		</td>
	   	</tr>
	   	<tr>
	   		<td align="center">��</td>
	   		<td>&nbsp;</td>
	   	</tr>
	   	<tr>
	   		<td align="center" style="color:#800000">�m�C�L���ΦW��n</td>
	   		<td style="font-size:10pt">���i�W��A�즹�w�i�}�l���ά��ʪ��i��
	   		</td>
	   	</tr>
	   	<tr>
	   		<td align="center">��</td>
	   		<td>&nbsp;</td>
	   	</tr>
	   	<tr>
	   		<td align="center" style="color:#800000">�m���Φ��Z��J�n</td>
	   		<td style="font-size:10pt">1.�����Ѯv�A�����ɭn���ǥͤ@�Ӧ��Z�A�o�Ӧ��Z�i�H�����ǥͬO�_����o�쥻�Ǵ����ά��ʪ��{�ҡA<font color=red>�Y���F�зǡA�h���������Z�椤�A�ǥͪ����ά��ʰO���N�|�O�ťաC</font><br>
	   			2.�p�G�Q�դ��ݭn�����Z�A�Цb���γ]�w����A�N�q�L�зǳ]��0���C
	   		</td>
	   	</tr>
	   	<tr>
	   		<td align="center">��</td>
	   		<td>&nbsp;</td>
	   	</tr>
	   	<tr>
	   		<td align="center" style="color:#800000">�m�ǥͦۧڬ٫�n</td>
	   		<td style="font-size:10pt">�����ǥ͡A���������e�����n��i�ǥ͸�Ʀ۫ءj�ҲաA��g���ά��ʦۧڬ٫�C
	   		</td>
	   	</tr>
	   </table>
<?php
}


//===<<�H�U�� JAVA Script function >>======================================================
?>
	<Script language="JavaScript">
		function club_list(club_sn) {
			document.myform.club_sn.value=club_sn;
			document.myform.mode.value='list';
			document.myform.submit();
		}
		function club_update(club_sn) {
			document.myform.club_sn.value=club_sn;
			document.myform.mode.value='update';
			document.myform.submit();
		}
		function add_members(club_sn) {
			document.myform.club_sn.value=club_sn;
			document.myform.mode.value='add_members';
			document.myform.submit();
		}
		function del_members(club_sn) {
			document.myform.club_sn.value=club_sn;
			document.myform.mode.value='del_members';
			document.myform.submit();
		}
		
		function del_club(club_sn) {
			document.myform.club_sn.value=club_sn;
			if_confirm=confirm('�z�T�w�n�R���o�Ӫ��ΡH\n�]�`�N�I�����ΩҦ��ǥ͸�ƩM���Z�|�@�֧R���^');
			if (if_confirm) {
			 document.myform.mode.value='del_club';
			 document.myform.submit();
			} else {
			 return false;
			}
		}		
		
		function check_no_choice_over() {
			document.myform.choice_num.value='1';
			alert ('�`�N�I�����\�W��Ҧ����}�ɡA�ǥͥi����@�ƱN�u�����ӡC\n��Y���ο�ҼҦ��|�H�����u���m��Ĺ�v���覡�i��C');
		}
		
	  function tagall(status) {
  		var i =0;
  		while (i < document.myform.elements.length)  {
    		if (document.myform.elements[i].name.substr(0,13)=='selected_stud') {
      		document.myform.elements[i].checked=status;
    		}
    		i++;
  		}
		}
		
	//���S�w�ؼ�, ����Υ�����
	function check_copy(SOURCE,STR) {
	var j=0;
	while (j < document.myform.elements.length)  {
	 if (document.myform.elements[j].name==SOURCE) {
	  if (document.myform.elements[j].checked) {
	   k=1;
	  } else {
	   k=0;
	  }	
	 }
	 	j++;
	}
	
  var i =0;
  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].name.substr(0,STR.length)==STR) {
      document.myform.elements[i].checked=k;
    }
    i++;
  }
 } // end function
		
		//CLUB ��� POST�e�ˬd���
		function check_before_club_post() {
		  var save=1;
		  if (document.myform.club_name.value=='') {
		    alert('�п�J���ΦW��!');
		    save=0;
		    document.myform.club_name.focus();
		    return false;
		  }
		  if (document.myform.club_teacher.value=='') {
		    alert('�п�ܪ��Ϋ��ɦѮv!');
		    save=0;
		    return false;
		  }
		  if (document.myform.club_location.value=='') {
		    alert('�п�J�W�Ҧa�I!');
		    save=0;
		    return false;
		  }
		  if (document.myform.club_memo.value=='') {
		    alert ('��²��y�g����²��!');
		    save=0;
		    document.myform.club_memo.focus();
		    return false;
		  }
		  if (save==1) {
		    document.myform.submit();
		  }
		}		
		
		//�έp�H��
		function chk_stud_num() {
		 var student=document.myform.stud_boy_num.value*1+document.myform.stud_girl_num.value*1;	
		 document.myform.club_student_num.value=student;
		}
		
		
	</Script>		