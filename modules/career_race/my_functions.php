<?php

//��g�v�ɰO�����
function form_race_record($race_record) {
	global $level_array,$squid_array,$R_select,$N_select;
?>
<table border="0" width="700" bgcolor="#FFFFCC">
	<tr bgcolor="#CCFFCC">
	 <td>*�~��</td>
	 <td colspan="3"><input type="text" name="year" value="<?php echo $race_record['year'];?>" size="3"></td></td>
	</tr>
	<tr bgcolor="#CCFFCC">
	 <td>*���O</td>
	 
	 <td><select name="nature"><option value=""></option>
	 	   <?php
	 	    foreach ($N_select as $k=>$v) {
	 	     ?>
	 	     <option value="<?php echo $v;?>"<?php if ($race_record['nature']==$v) echo " selected";?>><?php echo $v;?></option>
	 	     <?php
	 	    }
	 	   ?>	 		
	 </select></td>	 
	</tr>
	
	<tr>
	 <td width="75">�v�ɽd��</td>
	 <td width="250">
	 		<select size="1" name="level">
	 	   <?php
	 	    foreach ($level_array as $k=>$v) {
	 	     ?>
	 	     <option value="<?php echo $k;?>"<?php if ($race_record['level']==$k) echo " selected";?>><?php echo $v;?></option>
	 	     <?php
	 	    }
	 	   ?>	 		
	 		</select>	   
	 	
	 	</td>
		<td width="75">�v�ɩʽ�</td>
	 	<td width="250">
	     <input type="radio" name="squad" value="1"<?php if ($race_record['squad']==1) echo " checked"; ?>>�ӤH��
	     <input type="radio" name="squad" value="2"<?php if ($race_record['squad']==2) echo " checked"; ?>>������

	 	</td>
	</tr>	
	<tr>
	 <td>�v�ɦW��</td>
	 <td colspan='3'><input type="text" name="r_name" value="<?php echo $race_record['name'];?>" size="60"></td></tr>
	 <tr>
	 <td>�ҮѦr��</td>
	 <td colspan=3>
	 <input type="text" name="word" value="<?php echo $race_record['word'];?>" size="20">
	 &nbsp;�o���W��
	 			<select size="1" name="rank">
	 				<option value=''>---</option>
	 				<?php
	 				foreach ($R_select as $R) {
	 					?>
	 					<option value="<?php echo $R;?>"<?php if ($R==$race_record['rank']) echo " selected";?>><?php echo $R;?></option>
	 					<?php	 				
	 				}	 				
	 				?>
	 			</select>
	 
	 &nbsp;�����K���v�� <input type="text" name="weight" value="<?php echo $race_record['weight'];?>" size="6">
	 &nbsp;���M�K���v�� <input type="text" name="weight_tech" value="<?php echo $race_record['weight_tech'];?>" size="6">
	 </td>
	</tr>	
	<tr>
	 <td>�D����</td>
	 <td><input type="text" name="sponsor" value="<?php echo $race_record['sponsor'];?>" size="30"></td>
	 <td>�ҮѤ��</td>
	 <td><input type="text" name="certificate_date" value="<?php echo $race_record['certificate_date'];?>" size="12"></td>
	</tr>	
	<tr>
	</tr>	
	<tr>
	 <td>�Ƶ�</td>
	 <td colspan="3"><input type="text" name="memo" value="<?php echo $race_record['memo'];?>" size="60"></td>
	</tr>
</table>

<?php
}


//Ū���v�ɰO�� �G���}�C �ǤJ����, �O�_���Ǵ�,�Юv, �ǥ�, �S���ǤJ�h�������X
function get_race_record($c_curr_seme='',$teacher_sn='',$student_sn='') {
	
 global $CONN;
 
 $students=array();
 $sql_limit=array();

//�O�_����� 
 if ($c_curr_seme!="") {
  //�p��ӾǴ�������϶�
 $year=sprintf("%d",substr($c_curr_seme,0,3));
 $seme=substr($c_curr_seme,-1);
//�_�l��
 $sql="select day from school_day where year='$year' and seme='$seme' and day_kind='start'";
 /* ��l php �� MySQL �禡 
 $res=mysql_query($sql);
 list($st_date)=mysql_fetch_row($res);
 */
 /* ADODB �g�k */
 $res=$CONN->Execute($sql) or die("SQL���~:$sql");
 $st_date=$res->fields[0];
 
 //������
 $sql="select day from school_day where year='$year' and seme='$seme' and day_kind='end'";
 /* ��l php �� MySQL �禡 
 $res=mysql_query($sql);
 list($end_date)=mysql_fetch_row($res);
 */
  /* ADODB �g�k */
 $res=$CONN->Execute($sql) or die("SQL���~:$sql");
 $end_date=$res->fields[0];
 
 $sql_limit[]="certificate_date>='$st_date' and certificate_date<='$end_date'";

}
//�O�_���Ѯv
if ($teacher_sn!="") {
  $sql_limit[]="update_sn='$teacher_sn'";
}

//�O�_���ǥ�
if ($student_sn!="") {
  $sql_limit[]="student_sn='$student_sn'";
}

 //�զX sql ���O 
 $query="select * from `career_race`";
 $i=0;
 //�� sql ����[�W�h
 foreach ($sql_limit as $v) {
  $i++;
  $query.=($i==1)?" where ".$v:" and ".$v;
 }
 $query.=" order by certificate_date";
 
 /* php ��MySQL�禡�g�k 
 $res=mysql_query($query);
 while ($row=mysql_fetch_array($res,1)) {
*/
 /* ADODB ���g�k */
 $res=$CONN->Execute($query) or die("SQL���~:$query");;
 while ($row=$res->FetchRow()) {			//Ū���@��, �é�J�}�C $row �� 

   $student_sn=$row['student_sn'];
   $sn=$row['sn'];
   
   //Ū�J�v�ɸ��
   foreach($row as $k=>$v) {
     $students[$sn][$k]=$v;
   }
   
   //Ū�J�ǥͥثe�Z�Ÿ��
   $sql="select stud_name,curr_class_num from stud_base where student_sn='$student_sn'";
   /* php �� MySQL �禡�g�k  
   $res_stud=mysql_query($sql);
   $row_stud=mysql_fetch_array($res_stud,1);
   $students[$sn]['stud_name']=$row_stud['stud_name'];
	 $students[$sn]['seme_class']=substr($row_stud['curr_class_num'],0,3);	   
	 $students[$sn]['seme_num']=substr($row_stud['curr_class_num'],3,2);	 
  */
   
   /* ADODB ���g�k */
   $res_stud=$CONN->Execute($sql) or die("SQL���~:$sql");
   $students[$sn]['stud_name']=$res_stud->Fields('stud_name');
	 $students[$sn]['seme_class']=substr($res_stud->Fields('curr_class_num'),0,3);	   
	 $students[$sn]['seme_num']=substr($res_stud->Fields('curr_class_num'),3,2);	
	 
	   
 } // end while
 
 return $students;

} // end function 

//�C�X�v�ɰO��
function list_race_record($race_record,$del_box=0,$update_url=0,$post_action="") {
	global $level_array,$squad_array,$school_kind_name;
	global $module_manager;
 ?>
 	<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse;' bordercolor='#111111'>
  	<tr align='center' bgcolor='#ffcccc'>
  		<?php
  		if ($del_box) {
  		?>
  		<td width="5"><input type="checkbox" name="check_all" value="1" onclick="check_select('check_all','check_it');"></td>
		  <?php 
		  } 
  		if ($update_url) {
  		?>
  		<td width="30" style="font-size:10pt">�ާ@</td>
		  <?php } ?>

			<td width="15">NO.</td>
			<td width="60">�Z��</td>
			<td width="30" style="font-size:10pt">�y��</td>
			<td width="80">�m�W</td>
			<td bgcolor="#ccffcc">�Ǧ~��</td><td bgcolor="#ccffcc">�v�����O</td>
			<td width="120" colspan="2">�d��ʽ�</td><td>�v�ɦW��</td><td>�o���W��</td><td>�ҮѤ��</td><td>�D����</td>
			<td>�r��</td><td bgcolor="#ccffcc">�����K���v��</td><td bgcolor="#ccffcc">���M�K���v��</td><td>�Ƶ�</td>
		</tr>
			<?php
			$i=0;
			foreach ($race_record as $sn=>$race) {
	    $i++;
	    ?>
	    <tr<?php if ($_POST['act']=='edit' and $_POST['option1']==$sn) echo " bgcolor='#FFFF00'";?>>
		  		<?php
		  		if ($del_box) {
  				?>
  				<td align="center"><input type="checkbox" name="check_it[]" value="<?php echo $race['sn'];?>"></td>
				  <?php 
				  }			
  				if ($update_url) {
  				?>
  				<td>
  					<img src="images/edit.png" style="cursor:hand" onclick="<?php if ($post_action!="") { echo "document.myform.action='$post_action';";} ?>document.myform.act.value='edit';document.myform.option1.value='<?php echo $race['sn'];?>';document.myform.submit();">
  					<img src="images/del.png"  style="cursor:hand" onclick="if (confirm('�z�T�w�n�R����?')) { document.myform.act.value='DeleteOne'; document.myform.option1.value='<?php echo $race['sn'];?>'; document.myform.submit(); } ">
  				</td>
		  		<?php } ?>
					<td><?php echo $i;?></td>
					<td><?php echo $school_kind_name[substr($race['seme_class'],0,1)].sprintf('%d',substr($race['seme_class'],1,2))."�Z";?></td>
					<td><?php echo $race['seme_num'];?></td>
					<td><?php echo $race['stud_name'];?></td>
					<td><?php echo $race['year'];?></td>
					<td align='left'><?php echo $race['nature'];?></td>
					<td><?php echo $level_array[$race['level']];?></td>
					<td><?php echo $squad_array[$race['squad']];?></td>
					<td align='left'><?php echo $race['name'];?></td>
					<td><?php echo $race['rank'];?></td>
					<td><?php echo $race['certificate_date'];?></td>
					<td align='left'><?php echo $race['sponsor'];?></td>
					<td align='left'><?php echo $race['word'];?></td>
					<td align='center'><?php echo $race['weight'];?></td>
					<td align='center'><?php echo $race['weight_tech'];?></td>
					<td align='left'><?php echo $race['memo'];?></td>
			</tr>	    
	    <?php
			}
	?>
	
	</table>
	<?php
} // end functions

?>
<Script Language="JavaScript">
 function check_select(SOURCE,STR) {
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
</Script>