<?php
//Ū���v�ɪ̸�� return array
function get_contest_user($tsn,$student_sn) {
$query="select a.*,b.stud_id,b.stud_name,b.email_pass,c.seme_class,c.seme_num from contest_user a,stud_base b,stud_seme c,contest_setup d where a.student_sn=b.student_sn and a.student_sn=c.student_sn and a.tsn=d.tsn and d.year_seme=c.seme_year_seme and a.tsn='".$tsn."' and a.student_sn='".$student_sn."'";
 $result=mysql_query($query);
 $STID=mysql_fetch_array($result,1);
 return $STID;
}

//Ū���v�ɸ�� return array
function get_test_setup($tsn) {
 $query="select * from contest_setup where tsn='$tsn'";
 $result=mysql_query($query);
 $TEST=mysql_fetch_array($result,1);
 //���o�w���W�H��
 $query="select count(*) as num from contest_user where tsn='$tsn'";
 $result=mysql_query($query);
 list($N)=mysql_fetch_row($result);
 $TEST['testuser_num']=$N;
 //�����d��Ƥ����D���D��
 $query="select count(*) from contest_ibgroup where tsn='".$TEST['tsn']."'";
 list($N)=mysql_fetch_row(mysql_query($query));
 $TEST['search_ibgroup']=$N;
 //����d��Ƥ����D�w�`��
 $query="select count(*) from contest_itembank";
 list($N)=mysql_fetch_row(mysql_query($query));
 $TEST['search_itembank']=$N;
 return $TEST;
}

//���C�v��
function test_list($query) {
	global $PHP_CONTEST;
	$TEST=mysql_query($query);
?>
   <table border="1" width="100%" style="border-collapse: collapse" bordercolor="#C0C0C0">
   	<tr bgcolor="#FFFFCC">
   		<td style="font-size:10pt;color:#800000" width="40" align="center">�޲z</td>
   		<td style="font-size:10pt;color:#800000" align="center">�v�ɼ��D</td>
   		<td style="font-size:10pt;color:#800000" width="100" align="center">�v�����O</td>
   		<td style="font-size:10pt;color:#800000" width="50" align="center">�K�X</td>
   		<td style="font-size:10pt;color:#800000" width="80" align="center">���W�H��</td>
   		<td style="font-size:10pt;color:#800000" width="120" align="center">�}�l�ɶ�</td>
   		<td style="font-size:10pt;color:#800000" width="120" align="center">�����ɶ�</td>
   	</tr>	
 <?php
    while ($row=mysql_fetch_array($TEST,1)) {
    	$query="select count(*) as num from contest_user where tsn='".$row['tsn']."'";
			list($N)=mysql_fetch_row(mysql_query($query));
  	?>
   	<tr>
   		<td style="font-size:10pt" align="center"><img src="images/edit.png" border="0" style="cursor:hand" onclick="document.myform.option1.value='<?php echo $row['tsn'];?>';document.myform.act.value='listone';document.myform.submit();"></td>
  		<td style="font-size:10pt"><?php echo $row['title'];?></td>
  		<td style="font-size:10pt" align="center"><?php echo $PHP_CONTEST[$row['active']];?></td>
  		<td style="font-size:10pt" align="center"><?php echo $row['password'];?></td>
  		<td style="font-size:10pt" align="center"><?php echo $N;?></td>
  		<td style="font-size:10pt" align="center"><?php echo $row['sttime'];?></td>
  		<td style="font-size:10pt" align="center"><?php echo $row['endtime'];?></td>
  	</tr>
    	<?php
    }
 ?>
   </table>
<?php
} // end function


//ñ�n���Y�ӥ�
function title_simple($TEST) {
	global $PHP_CONTEST;
?>
  <table border="1" width="100%" style="border-collapse: collapse" bordercolor="#C0C0C0" cellpadding="5">
  	<tr>
  		<td width="80" align="center" style="font-size:10pt;color:#800000">�v�ɼ��D</td>
  		<td style="font-size:10pt"><?php echo $TEST['title'];?></td>
  	</tr>
  	<tr>
  		<td width="80" align="center" style="font-size:10pt;color:#800000">�v���D��</td>
  		<td style="font-size:10pt"><?php echo $TEST['qtext'];?></td>
  	</tr>
  	<tr>
  		<td width="80" align="center" style="font-size:10pt;color:#800000">�v�����O</td>
  		<td style="font-size:10pt"><?php echo $PHP_CONTEST[$TEST['active']];?></td>
  	</tr>
  </table>

<?php
}


//�v�ɲӥ�
function test_main($tsn,$admin) {
	global $PHP_CONTEST,$MANAGER;
  $query="select * from contest_setup where tsn='".$tsn."'";
  $TEST=mysql_fetch_array(mysql_query($query),1);

?>
   <table border="1" width="100%" style="border-collapse: collapse" bordercolor="#C0C0C0" cellpadding="5">
  	<tr>
  		<td width="80" align="center" style="font-size:10pt;color:#800000">�v�ɼ��D</td>
  		<td style="font-size:10pt"><?php echo $TEST['title'];?></td>
  	</tr>
  	<tr>
  		<td width="80" align="center" style="font-size:10pt;color:#800000">�v���D��</td>
  		<td style="font-size:10pt"><?php if ($admin==1) { echo "<font color='#FF0000'>".$TEST['qtext']."</font>"; } else { echo "�v�ɶ}�l�~���G!"; }?></td>
  	</tr>
  	<tr>
  		<td width="80" align="center" style="font-size:10pt;color:#800000">�v�����O</td>
  		<td style="font-size:10pt"><?php echo $PHP_CONTEST[$TEST['active']];?></td>
  	</tr>
		<?php
		 if ($MANAGER) {
		?>
  	<tr>
  		<td width="80" align="center" style="font-size:10pt;color:#800000">�v�ɱK�X</td>
  		<td style="font-size:10pt;font-color:#0000FF"><?php echo $TEST['password'];?></td>
  	</tr>
  	<?php
  	}
  	?>
   	<tr>
  		<td width="80" align="center" style="font-size:10pt;color:#800000">�}�l���</td>
  		<td style="font-size:10pt"><?php echo $TEST['sttime'];?></td>
  	</tr>
  	<tr>
  		<td width="80" align="center" style="font-size:10pt;color:#800000">�������</td>
  		<td style="font-size:10pt"><?php echo $TEST['endtime'];?></td>
  	</tr>
  	<?php
  	
  	?>
  	<tr>
  		<td width="80" align="center" valign="top" style="font-size:10pt;color:#800000">�v�ɻ���</td>
  		<td style="font-size:10pt"><?php echo showhtml($TEST['memo']);?></td>
  	</tr>
  	<?php
  	if ($TEST['active']>1) {
  	?>
  	<tr>
  		<td width="80" align="center" valign="top" style="font-size:10pt;color:#800000">�����ӥ�</td>
  		<td style="font-size:10pt">
  			<?php
       $query="select * from contest_score_setup where tsn='".$TEST['tsn']."'";
       $result=mysql_query($query);
       if (mysql_num_rows($result)) {
        while ($row=mysql_fetch_array($result,1)) {
         echo $row['sco_text']."&nbsp;&nbsp;";
        }
 			 } else {
 			  echo "�ȵ��`��100%";
 			 }
  			 ?>
  			</td>
  	</tr>
  	
  	<?php
  	}
  	?>
   </table>
<?php
} // end function

//���_�v��
function form_contest($TEST) {
	global $PHP_CONTEST,$PHP_MEMO;
?>
   <table border="0" width="100%" style="border-collapse: collapse" bordercolor="#C0C0C0" cellpadding="5">
  	<tr>
  		<td width="80" align="right" style="color:#800000">�v�ɼ��D</td>
  		<td><input type="text" name="title" size="70" value="<?php echo $TEST['title'];?>"></td>
  	</tr>
  	<tr>
  		<td width="80" align="right" style="color:#800000">�v���D��<br><font size=2>(�i�[�Jhtml����)</font></td>
  		<td><textarea name="qtext" cols="70" rows="6"><?php echo $TEST['qtext'];?></textarea></td>
  	</tr>
  	<tr>
  		<td width="80" align="right" style="color:#800000">�v�����O</td>
  		<td>
  			<?php
  			 if ($_POST['act']=='update') {
  			 	echo $PHP_CONTEST[$TEST['active']];
  			 	?>
  			 	<input type="hidden" name="active" value="<?php echo $TEST['active'];?>">
  			 	<?php
  			 } else {
  			?>
  	    <select size="1" name="active" onchange="automemo()">
  	    	<option value="0"<?php if ($TEST['active']==0) { echo " selected"; } ?> style="color:#FF0000">--�п�����O--</option>
	        <option value="1"<?php if ($TEST['active']==1) { echo " selected"; } ?>><?php echo $PHP_CONTEST[1];?></option>
					<option value="2"<?php if ($TEST['active']==2) { echo " selected"; } ?>><?php echo $PHP_CONTEST[2];?></option>
					<option value="3"<?php if ($TEST['active']==3) { echo " selected"; } ?>><?php echo $PHP_CONTEST[3];?></option>
					<option value="4"<?php if ($TEST['active']==4) { echo " selected"; } ?>><?php echo $PHP_CONTEST[4];?></option>
				</select>
				<?php
				}
				?>		
  		</td>
  	</tr>
   	<tr>
  		<td width="80" align="right" style="color:#800000">�v�ɱK�X</td>
  		<td><input type="text" name="password" size="4" value="<?php echo $TEST['password'];?>"><font size=2 color=red>(�̦h�|�Ӧr��, �O�d�ťիh�ѥ[���v�ɤ��ݱK�X)</font></td>
  	</tr>	
   	<tr>
  		<td width="80" align="right" style="color:#800000">�}�l���</td>
  		<td>
  			<input type="text" name="sday" id="sday" size="10" value="<?php echo substr($TEST['sttime'],0,10);?>">
  			<button id="start_date">...</button>
					<script type="text/javascript">
				    new Calendar({
  		      inputField: "sday",
   		      dateFormat: "%Y-%m-%d",
    		    trigger: "start_date",
    		    bottomBar: true,
    		    weekNumbers: false,
    		    showTime: 24,
    		    onSelect: function() {this.hide();}
				    });
					</script>

  			�ɶ��G<?php SelectTime('stime_hour',substr($TEST['sttime'],-8,2),24);?>�I<?php SelectTime('stime_min',substr($TEST['sttime'],-5,2),60);?>��
  			</td>
  	</tr>
  	<tr>
  		<td width="80" align="right" style="color:#800000">�������</td>
  		<td>
  			<input type="text" name="eday" id="eday" size="10" value="<?php echo substr($TEST['endtime'],0,10);?>">
  			<button id="end_date">...</button>
					<script type="text/javascript">
				    new Calendar({
  		      inputField: "eday",
   		      dateFormat: "%Y-%m-%d",
    		    trigger: "end_date",
    		    bottomBar: true,
    		    weekNumbers: false,
    		    showTime: 24,
    		    onSelect: function() {this.hide();}
				    });
					</script>

  			�ɶ��G<?php SelectTime('etime_hour',substr($TEST['endtime'],-8,2),24);?>�I<?php SelectTime('etime_min',substr($TEST['endtime'],-5,2),60);?>��
  		</td>
  	</tr>
  	<tr>
  		<td width="80" align="right" valign="top" style="color:#800000">�v�ɻ���</td>
  		<td><textarea rows="10" name="memo" cols="70"><?php echo $TEST['memo'];?></textarea></td>
  	</tr>
  	<tr>
  		<td width="80" align="right" valign="top" style="color:#800000">�}�����</td>
  		<td> 
  			<input type="radio" name="open_judge" value="0"<?php if (@$TEST['open_judge']==0) { echo " checked"; }?>>����
  			<input type="radio" name="open_judge" value="1"<?php if (@$TEST['open_judge']==1) { echo " checked"; }?>>�}��
  			<font style="color:#FF0000;font-size:10pt">(���нT�{�v�ɤw����, �A�Q���v�ɺ޲z�\��N���ﶵ���}�C)</font>
  		</td>
  	</tr>
  	<tr>
  		<td width="80" align="right" valign="top" style="color:#800000">���G���Z</td>
  		<td>
  			<input type="radio" name="open_review" value="0"<?php if (@$TEST['open_review']==0) { echo " checked"; }?>>����
  			<input type="radio" name="open_review" value="1"<?php if (@$TEST['open_review']==1) { echo " checked"; }?>>�}��
  			<font style="color:#FF0000;font-size:10pt">(���нT�{���f�w��������, �ë��w�o���@�~, �A�Q���v�ɺ޲z�\��N���ﶵ���}�C)</font>
  		</td>
  	</tr>
  	<tr>
  		<td width="80" align="right" valign="top" style="color:#800000">���\�R��</td>
  		<td>
  			<input type="radio" name="delete_enable" value="0"<?php if (@$TEST['delete_enable']==0) { echo " checked"; }?>>����
  			<input type="radio" name="delete_enable" value="1"<?php if (@$TEST['delete_enable']==1) { echo " checked"; }?>>�}��
  			<font style="color:#FF0000;font-size:10pt">(���Y�}��, �N���ܡu�R���v�ɡv�\��ﶵ�C)</font>
  		</td>
  	</tr>

  	<?php
  	//�Y���s�W�Ҧ�, �O�_�ĥιw�]�����Ӷ�
    if ($_POST['act']=="insert") {
    ?>
  	<tr>
  		<td width="80" align="right" valign="top" style="color:#800000">�����Ӷ�</td>
  		<td><input type="checkbox" name="init_score_setup" value="1" checked>�ҥιw�]�Ӷ� <font style="color:#FF0000;font-size:10pt">(���Y�S���Ķ�, �v�ɳ]�w�̱N�w�]�u���u�`���v�o�Ӷ��ءC)</font></td>
  	</tr>
    <?php
    } elseif ($TEST['active']>1) {
    ?>
 		<tr>
  		<td width="80" align="right" valign="top" style="color:#800000">�����Ӷ�</td>
  		<td>
    <?php
    //���X���v�ɪ������Ӷ�, �|�Ψ� act, sco
      $query="select * from contest_score_setup where tsn='".$TEST['tsn']."'";
      $result=mysql_query($query);
      if (mysql_num_rows($result)) {
    	?>  	
  			<table border="0" cellspacing="2">
  		   <tr>
  		   	<?php
  		   	 while ($row=mysql_fetch_array($result,1)) {
  		   	  ?>
  		   	  <td>
  		   	  	<table border="1"  bgcolor="#FFFF99" bordercolor="#FF9900" style="border-collapse: collapse">
  		   	    <tr><td style="color:#0066FF;font-size:10pt"><?php echo $row['sco_text'];?><a style="cursor:hand" onclick="if (confirm('�z�T�w�n\n�R��<?php echo $row['sco_text'];?>?')) { document.myform.option2.value='<?php echo $row['sco_sn'];?>';check_test_form('del_score_setup'); }"> <img src="./images/del.png"  border="0"></a></td></tr>
  		   	    </table>	
  		   	  </td>
  		   	  <?php
  		   	 }
  		   	?>
  		   </tr>
  		  </table>
  		  <?php
  		   }
  		  ?>
  		  <!---�s�W�����ӥت���� --->
  		  <table border="0" width="100%">
  		   <tr>
  		   	<td><input type="text" name="sco_text" value="" size="20"><input type="button" value="�s�W�ӥ�" onclick="if (document.myform.sco_text.value!='') { check_test_form('add_score_setup'); }"></td>
  		  </tr>
  		  </table>
  		</td>
  	</tr>
    	<?php
      
    } //end if $mode
  	?>
  </table>

<?php
} // end function


//�C�X�v�ɳ��W�W��
function list_user($tsn,$act) {
	global $UPLOAD_U;
	$C[0]="#FFE8FF";
	$C[1]="#E8FFE8";
	//���X�v�ɳ]�w
  $TEST=get_test_setup($tsn);
  //���X�W��
	$query="select a.*,b.stud_id,b.stud_name,b.email_pass,c.seme_class,c.seme_num from contest_user a,stud_base b,stud_seme c,contest_setup d where a.student_sn=b.student_sn and a.student_sn=c.student_sn and a.tsn=d.tsn and d.year_seme=c.seme_year_seme and a.tsn='".$tsn."' and ifgroup='' order by seme_class,seme_num";
	$result=mysql_query($query);
	
?>
   <table border="1" width="700" style="border-collapse: collapse" bordercolor="#C0C0C0" cellpadding="1">
   	<tr bgcolor="#FFFFCC">
   		<td style="font-size:10pt;color:#800000" width="50" align="center">�޲z</td>
   		<td style="font-size:10pt;color:#800000" width="80" align="center">�b��(�Ǹ�)</td>
   		<td style="font-size:10pt;color:#800000" width="60" align="center">�m�W</td>
   		<td style="font-size:10pt;color:#800000" width="80" align="center">�Z��</td>
   		<td style="font-size:10pt;color:#800000" width="40" align="center">�y��</td>
   		<td style="font-size:10pt;color:#800000" width="80" align="center">�n�J�K�X</td>
   		<td style="font-size:10pt;color:#800000" width="80" align="center">�n�J����</td>
   		<td style="font-size:10pt;color:#800000" width="130" align="center">�̫�n�J</td>
   		<td style="font-size:10pt;color:#800000" width="100" align="center">�v�ɰO��</td>
   	</tr>	
 <?php
    $j=0;
    while ($row=mysql_fetch_array($result,1)) {
    	$j++;
    	$j=$j%2;
    	//�խ����
    	//$query="select * from contest_user where tsn='".$tsn."' and ifgroup='".$row['stid']."' order by class_num";
    	$query="select a.*,b.stud_id,b.stud_name,b.email_pass,c.seme_class,c.seme_num from contest_user a,stud_base b,stud_seme c,contest_setup d where a.student_sn=b.student_sn and a.student_sn=c.student_sn and a.tsn=d.tsn and d.year_seme=c.seme_year_seme and a.tsn='".$tsn."' and ifgroup='".$row['student_sn']."' order by seme_class,seme_num";
    	$GROUPS=mysql_query($query);
    	//�@���O��
    	
    	if ($TEST['active']==1) {
    	 //�d���
    	 $REC=get_stud_record1_info($TEST,$row['student_sn']);
    	}else{
    	 //�W�ǧ@�~
    	 $REC=get_stud_record2_info($TEST,$row['student_sn']);
    	}
     	//�Z���त��
    	$class_id=sprintf('%03d_%d_%02d_%02d',substr($TEST['year_seme'],0,3),substr($TEST['year_seme'],3,1),substr($row['seme_class'],0,1),substr($row['seme_class'],1,2));
  	  $class_data=class_id_2_old($class_id);
  	?>
   	<tr bgcolor="<?php echo $C[$j];?>">
   		<td style="font-size:10pt;color:#000000" align="center">
   			<?php
   			if ($REC[0]==0) {
   				if (mysql_num_rows($GROUPS)==0) {
   				?>
   				<a style="cursor:hand" title="�R��" onclick="if (confirm('�z�T�w�n\n�R���u<?php echo $row['stud_id'].$row['stud_name'];?>�v?')) { document.myform.act.value='deleteuser';document.myform.option2.value='<?php echo $row['student_sn'];?>';document.myform.submit(); }"><img src="./images/del.png"  border="0"></a>
   					<?php
   				}
   					?>
   				<a style="cursor:hand" title="�����ͳ]�w�խ�" onclick="document.myform.act.value='editgroup';document.myform.option2.value='<?php echo $row['student_sn'];?>';document.myform.submit();"><img src="images/group.jpg" border="0" width="17" height="16"></a>
				  <?php
   			}else{
   				?>
   				**
   				<?php
   			}
   			?>
   			</td>
   		<td style="font-size:10pt;color:#000000" align="center" width="80"><?php echo @$row['stud_id'];?></td>
   		<td style="font-size:10pt;color:#000000" align="center" width="60"><?php echo @$row['stud_name'];?></td>
   		<td style="font-size:10pt;color:#000000" align="center" width="80"><?php echo $class_data[5];?></td>
   		<td style="font-size:10pt;color:#000000" align="center" width="40"><?php echo @$row['seme_num'];?></td>
   		<td style="font-size:10pt;color:#000000" align="center" width="80"><?php echo @$row['email_pass'];?></td>
   		<td style="font-size:10pt;color:#000000" align="center" width="80"><?php echo @$row['logintimes'];?></td>
   		<td style="font-size:8pt;color:#000000" align="center" width="130"><?php echo @$row['lastlogin'];?></td>
   		<td style="font-size:10pt;color:#000000" align="center"><?php echo $REC[1];?></td>
  	</tr>
    	<?php
    	if (mysql_num_rows($GROUPS)>0) {
    		?>
    		 <tr>
   				<td style="font-size:8pt;color:#000000" align="right"  bgcolor="#FFFFFF">
   				�խ�=>
   				</td>
   				<td colspan="8">
   				<table border="0" style="border-collapse: collapse" bordercolor="#C0C0C0" cellpadding="1">

    		<?php
    	while ($row=mysql_fetch_array($GROUPS,1)) {
    		  //�Z���त��
    			$class_id=sprintf('%03d_%d_%02d_%02d',substr($TEST['year_seme'],0,3),substr($TEST['year_seme'],3,1),substr($row['seme_class'],0,1),substr($row['seme_class'],1,2));
  	  		$class_data=class_id_2_old($class_id);
    		?>
    		<tr bgcolor="<?php echo $C[$j];?>">
   				<td style="font-size:10pt;color:#000000" align="center" width="80">
   					<a style="cursor:hand" title="�R��" onclick="if (confirm('�z�T�w�n\n�R��<?php echo $row['stud_id'];?>?')) { document.myform.act.value='deleteuser';document.myform.option2.value='<?php echo $row['student_sn'];?>';document.myform.submit(); }"><img src="./images/del.png"  border="0"></a>
   						<?php echo @$row['stud_id'];?>
   					</td>
   				<td style="font-size:10pt;color:#000000" align="center" width="60"><?php echo @$row['stud_name'];?></td>
   				<td style="font-size:10pt;color:#000000" align="center" width="80"><?php echo $class_data[5];?></td>
   				<td style="font-size:10pt;color:#000000" align="center" width="40"><?php echo @$row['seme_num'];?></td>
   				<td style="font-size:10pt;color:#000000" align="center" width="80"><?php echo @$row['email_pass'];?></td>
   				<td style="font-size:10pt;color:#000000" align="center" width="80"><?php echo @$row['logintimes'];?></td>
   				<td style="font-size:8pt;color:#000000" align="center" width="130"><?php echo @$row['lastlogin'];?></td>
   				<td style="font-size:10pt;color:#000000" align="center" width="100">&nbsp;</td>
  		</tr>
    		<?php
    	 } // end while GROUPS
    	?>
     </table>
    	</td>
    	
    </tr>
    	<?php
    	 } // end if 
    } // end while
 ?>
   </table>
<?php
} // end function

//�C�X�v�ɳ��W�W��
function list_user_print($tsn,$act) {
	global $PHP_CONTEST;

	$C[0]="#FFE8FF";
	$C[1]="#E8FFE8";
	//���X�v�ɳ]�w
  $TEST=get_test_setup($tsn);
   
  //���X�W��
	$query="select a.*,b.stud_id,b.stud_name,b.email_pass,c.seme_class,c.seme_num from contest_user a,stud_base b,stud_seme c,contest_setup d where a.student_sn=b.student_sn and a.student_sn=c.student_sn and a.tsn=d.tsn and d.year_seme=c.seme_year_seme and a.tsn='".$tsn."' and ifgroup='' order by seme_class,seme_num";
	$result=mysql_query($query);
	

	$Table_Fieles=count($_POST['print_chk']);  //�n�L������
   
   //�L�X�����Y
   print_contest_title($TEST);
   print_title();	

    $j=0;$t=-1;
    while ($row=mysql_fetch_array($result,1)) {
    	$j++; $t++;
    	//��1������
      if ($_POST['table_page_break']>0 and $j%$_POST['table_page_break']==1 and $j>1) {
         echo "</table><P STYLE='page-break-before: always;'>&nbsp;</P>";
         if ($_POST['table_page_title']) {  //���L���D
         	 print_contest_title($TEST);
         } 
         print_title(); 
      }

    	//�խ����
    	//$query="select * from contest_user where tsn='".$tsn."' and ifgroup='".$row['stid']."' order by class_num";
    	$query="select a.*,b.stud_id,b.stud_name,b.email_pass,c.seme_class,c.seme_num from contest_user a,stud_base b,stud_seme c,contest_setup d where a.student_sn=b.student_sn and a.student_sn=c.student_sn and a.tsn=d.tsn and d.year_seme=c.seme_year_seme and a.tsn='".$tsn."' and ifgroup='".$row['student_sn']."' order by seme_class,seme_num";
    	$GROUPS=mysql_query($query);
    	$GROUPS_num=mysql_num_rows($GROUPS);

    	//�έp�@���O��
    	if ($TEST['active']==1) {
    	 //�d���
     	 $REC=get_stud_record1_info($TEST,$row['student_sn']);
    	 $row['record']=$REC[1];
       $row['score']=$REC[3];   	 
    	 
    	}else{
    	 //�W�ǧ@�~
     	 $REC=get_stud_record2_info($TEST,$row['student_sn']);
    	 $row['record']=($REC[0]==1)?"�w�W��":"���W��!";
    	 $row['score']=($REC[2]==0)?"������":$REC[3]; 
    	 
     	 //���o���y
     	 $row['prize_memo']=get_prize_memo($TEST['tsn'],$row['student_sn']); 
    	     	 
    	}
    	
  	?>
   	<tr class="mytr<?php echo $t%2;?>">
   		<td align="center"><?php echo $j;?></td>
 			<?php
 			 $rowspan_num=$GROUPS_num+1;
 			 foreach ($_POST['print_chk'] as $K=>$VAL) {
 			   $Key=$RR[$K];   //stud_name ,seme_class , seme_num...... etc.
 			   if ($VAL=='seme_class') {
 			    //�Z���त��
    			$class_id=sprintf('%03d_%d_%02d_%02d',substr($TEST['year_seme'],0,3),substr($TEST['year_seme'],3,1),substr($row['seme_class'],0,1),substr($row['seme_class'],1,2));
  	  		$class_data=class_id_2_old($class_id);
					$row['seme_class']=$class_data[5];
 			   }
 			 ?>
 			   <td width="<?php $WW[$K];?>" align="center"<?php if ($K>3 and $GROUPS_num>0) echo " rowspan='$rowspan_num'";?>><?php echo $row[$VAL];?></td>
 			 <?php
 			 }
 			?>
 	  </tr>
    	<?php
    	if ($GROUPS_num > 0) {
    		?>
 
    		<?php
    	while ($row=mysql_fetch_array($GROUPS,1)) {
    		$j++;
    		?>
   			<tr class="mytr<?php echo $t%2;?>">
   				<td align="center"><?php echo $j;?></td>
     		<?php
    		foreach($_POST['print_chk'] as $K=>$VAL) {
			   if ($VAL=='seme_class') {
 			    //�Z���त��
    			$class_id=sprintf('%03d_%d_%02d_%02d',substr($TEST['year_seme'],0,3),substr($TEST['year_seme'],3,1),substr($row['seme_class'],0,1),substr($row['seme_class'],1,2));
  	  		$class_data=class_id_2_old($class_id);
					$row['seme_class']=$class_data[5];
 			   }

    		  if ($K<4) {
    		  ?>
 			   <td width="<?php $WW[$K];?>" align="center"<?php if ($K>3 and $GROUPS_num>0) echo " rowspan='$rowspan_num'";?>><?php echo $row[$VAL];?></td>
    		  <?php
    		  }
    		}
    		?>
    		</tr>
    	<?php
    	 } // end while $GROUPS
      } // end if 
   } // end while 
 ?>
   </table>
<?php
} // end function

//�C�L�v�ɩ��Y
function print_contest_title($TEST) {
	global $PHP_CONTEST;
    ?>
    <table border="1" width="100%" style="border-collapse: collapse" bordercolor="#000000" cellpadding="3">
  	<tr>
  		<td width="80" align="center" style="font-size:14pt;color:#800000">�v�ɼ��D</td>
  		<td style="font-size:14pt"><?php echo $TEST['title'];?></td>
  	</tr>
  	<tr>
  		<td width="80" align="center" style="font-size:14pt;color:#800000">�v���D��</td>
  		<td style="font-size:14pt"><?php if ($_POST['show_question']==1) echo $TEST['qtext'];?></td>
  	</tr>
  	<tr>
  		<td width="80" align="center" style="font-size:14pt;color:#800000">�v�����O</td>
  		<td style="font-size:14pt"><?php echo $PHP_CONTEST[$TEST['active']];?></td>
  	</tr>
  	<tr>
  		<td width="80" align="center" style="font-size:14pt;color:#800000">�v�ɤ��</td>
  		<td style="font-size:14pt"><?php echo $TEST['sttime']."��".$TEST['endtime'];?></td>
  	</tr>

  </table>
  <table border="0" width="100%"><tr><td>&nbsp;</td></tr></table>
  <?php
}

//�C�L�����Y
function print_title() {
	//��e	
	$WW=array(0=>70,1=>80,2=>70,3=>40,4=>80,5=>80,6=>140,7=>120,8=>100,9=>100,10=>150,11=>120,12=>60,13=>80,14=>$_POST['mytitle_width']);
	//���D
	$PP[0]="�Ǹ�";					
	$PP[1]="�m�W";						
	$PP[2]="�Z��";
	$PP[3]="�y��";
	$PP[4]="�n�J�K�X";
	$PP[5]="�n�J����";
	$PP[6]="�̫�n�J";
	$PP[7]="�v�ɰO��";
	$PP[8]="�v�ɦ��Z";
	$PP[9]="�o���W��";
	$PP[10]="���f���y";
	$PP[11]="ñ�W��";
	$PP[12]="�I�W��";
	$PP[13]="�Ƶ���";
	$PP[14]=$_POST['mytitle_text'];
	?>
     <table border="1" style="border-collapse: collapse" bordercolor="#000000" cellpadding="<?php echo $_POST['table_padding'];?>">
   	<tr bgcolor="#FFFFCC">
   		<td width="40" align="center" style="font-family:�з���;font-size:14pt">�Ǹ�</td>
   		<?php

   		foreach ($_POST['print_chk'] as $K=>$VAL) {
   			
   		  ?>
   		   <td width="<?php echo $WW[$K];?>" align="center" style="font-family:�з���;font-size:14pt"><?php echo $PP[$K];?></td>
   		  <?php
   		}
        ?>
    	</tr>	
    	<?php
}


//�ǥͳ��W
function contest_add_user($tsn,$STUDENT) {
 	$query="select * from contest_user where tsn='$tsn' and student_sn='".$STUDENT['student_sn']."'";
 	 if (mysql_num_rows(mysql_query($query))>0) {
    $INFO=$STUDENT['seme_class'].sprintf('%02d',$STUDENT['seme_num']).$STUDENT['stud_name']."�w���г��W, ���s�J!!!";	
 	 } else {
 	  $query="insert into contest_user (tsn,student_sn) values ('".$_POST['option1']."','".$STUDENT['student_sn']."')";
    if (mysql_query($query)) {
    	$INFO="���W���\�G".$STUDENT['seme_class'].sprintf('%02d',$STUDENT['seme_num']).$STUDENT['stud_name'];
    } else {
     echo "Error! query=".$query;
     exit();
    }   
   } // end if mysql_num_rows

   return $INFO;
   
} // end function contest_add_user


//���D�w�ɨ�100�D�@���D��
function get100($tsn,$ToNum) {
	//�d���D�ت��O�_�w���D��********************************************* 
	$TEST=get_test_setup($tsn);

  $query="select ibsn from contest_ibgroup where tsn='".$tsn."'";
  $result=mysql_query($query);
  $N=mysql_num_rows($result);
  $start=1;
	if ($N>$ToNum) {
	 $INFO="���~! �ثe�D�w�`�D�Ƥp���D���ؼ��D��!!";
	 $start=0;
	}

	if ($TEST['search_ibgroup']>=$ToNum) {
	 $INFO="���~! �ثe�D�������D�Ƥw�j��ε���]�w���D���ؼ��D��!!";
	 $start=0;
	}

	if ($start) {
	
	
	list($IB)=mysql_fetch_row(mysql_query('select count(*) as num from contest_itembank'));
	$IB-=1;

 //�üƨ��C�@�D��ibsn	
 while (mysql_num_rows(mysql_query("select ibsn from contest_ibgroup where tsn='$tsn'"))<$ToNum) {
 	//����O�_����
  do {
   $D=0;
   $IN=rand(0,$IB);
   list($ibsn)=mysql_fetch_row(mysql_query("select ibsn from contest_itembank limit ".$IN.",1"));
   $query="select count(*) as num from contest_ibgroup where tsn='$tsn' and ibsn='$ibsn'";
	 $result=mysql_query($query);
	 $row=mysql_fetch_row($result);
	 list($D)=$row;
  } while ($D>0);
  //�g�J�D�إN�X
  $query="select * from contest_itembank where ibsn='$ibsn'";
  $res=mysql_query($query);
  $row=mysql_fetch_array($res);
  $query="insert into contest_ibgroup (tsn,ibsn,question,ans,ans_url) values ('$tsn','$ibsn','".SafeAddSlashes($row['question'])."','".SafeAddSlashes($row['ans'])."','".$row['ans_url']."')";
  mysql_query($query);
 } // end while
 //�g�J�X�D��
 $query="select ibsn from contest_ibgroup where tsn='$tsn'";
 $result=mysql_query($query);
 $tsort=0;
 while ($row=mysql_fetch_row($result)) {
  list($ibsn)=$row;
  $tsort++;
  mysql_query("update contest_ibgroup set tsort='$tsort' where tsn='$tsn' and ibsn='$ibsn'");
 } //end while
 } // end if start==1
 
 return $INFO;
 
} // end function

//�M��100�D��
function clear100($tsn) {
   $query="delete from contest_ibgroup where tsn='$tsn'";
   if (mysql_query($query)) {
    //��sid �s�X
  	mysql_query("optimize table contest_ibgroup");
  	mysql_query("alter table contest_ibgroup drop id");
  	mysql_query("alter table contest_ibgroup add id int(5) auto_increment not null primary key first");
   }else{
    echo "Error! Query=$query";
    exit();
   }
}

//�C�X�D�w�ѤĿ�s���D��
function list_itembank_for_choice($tsn) {
	//�d���D�ت��O�_�w���D��********************************************* 
	global $CONN;
	$TEST=get_test_setup($tsn);
	?>
   <table border="1" width="100%" style="border-collapse: collapse" bordercolor="#C0C0C0">
  	<tr>
  		<td bgcolor="#CCFFCC" style="font-size:10pt;color:#000000" width="10" align="center">&nbsp;</td>
  		<td bgcolor="#CCFFCC" style="font-size:10pt;color:#000000" width="40" align="center">�s��</td>
  		<td bgcolor="#CCFFCC" style="font-size:10pt;color:#000000" align="center">�D�@�ء@���@�e</td>
  		<td bgcolor="#CCFFCC" style="font-size:10pt;color:#000000" width="20%" align="center">�ѦҸѵ�</td>
  		<td bgcolor="#CCFFCC" style="font-size:10pt;color:#000000" width="10%" align="center">�ѦҺ��}</td>
  	</tr>

	<?php
	//���X�D�w�Ҧ��D��
	$query="select * from contest_itembank";
	$res=$CONN->Execute($query);
	$i=0;
	while ($row=$res->fetchRow()) {
		$i++;
	 //���祻�D�O�_�w�s�b�D����
	 $query="select count(*) as num from contest_ibgroup where tsn='$tsn' and ibsn='".$row['ibsn']."'";
	 $result=mysql_query($query);
	 $row_double=mysql_fetch_row($result);
	 list($D)=$row_double;
	 if ($D>0) { $DIS="disabled"; $BG="bgcolor='#CCCCCC'"; } else { $DIS=""; $BG=""; }
   	?>
  	<tr <?php echo $BG;?>>
      <td style="font-size:10pt;color:#000000" width="10" align="center"><input type="checkbox" name="select_ibgroup[]" value="<?php echo $row['ibsn'];?>" <?php echo $DIS;?>></td>
  		<td style="font-size:10pt;color:#000000" width="40" align="center"><?php echo $i;?></td>
  		<td style="font-size:10pt;color:#000000" ><?php echo $row['question'];?></td>
  		<td style="font-size:10pt;color:#000000" width="20%"><?php echo $row['ans'];?></td>
  		<td style="font-size:10pt;color:#000000" width="10%" align="center"><?php echo $ans_url;?></td>
  	</tr>
  	<?php
	} // end while
  	?>
  	</table>
	<?php
} // end function


//�C�X�D��

function list_test_ibgroup($tsn) {
	
	?>
   <table border="1" width="100%" style="border-collapse: collapse" bordercolor="#C0C0C0">
  	<tr>
  		<td bgcolor="#CCFFCC" style="font-size:10pt;color:#000000" width="10" align="center">&nbsp;</td>
  		<td bgcolor="#CCFFCC" style="font-size:10pt;color:#000000" width="40" align="center">�s��</td>
  		<td bgcolor="#CCFFCC" style="font-size:10pt;color:#000000" align="center">�D�@�ء@���@�e</td>
  		<td bgcolor="#CCFFCC" style="font-size:10pt;color:#000000" width="20%" align="center">�ѦҸѵ�</td>
  		<td bgcolor="#CCFFCC" style="font-size:10pt;color:#000000" width="10%" align="center">�ѦҺ��}</td>
  		<td bgcolor="#CCFFCC" style="font-size:10pt;color:#000000" width="50" align="center">�ާ@</td>
  	</tr>

   	<?php
   	$query="select * from contest_ibgroup where tsn='$tsn' order by tsort";
   	$result=mysql_query($query);
   	while ($row=mysql_fetch_array($result)) {
   		   	 	$ans_url=($row['ans_url']=='')?"�L":"<a href='".$row['ans_url']."' target='_blank'>".�s��."</a>";

   	?>
  	<tr>
      <td style="font-size:10pt;color:#000000" width="10" align="center"><input type="checkbox" name="select_ibgroup[]" value="<?php echo $row['ibsn'];?>"></td>
  		<td style="font-size:10pt;color:#000000" width="40" align="center"><?php echo $row['tsort'];?></td>
  		<td style="font-size:10pt;color:#000000" ><?php echo $row['question'];?></td>
  		<td style="font-size:10pt;color:#000000" width="20%"><?php echo $row['ans'];?></td>
  		<td style="font-size:10pt;color:#000000" width="10%" align="center"><?php echo $ans_url;?></td>
  		<td style="font-size:10pt;color:#000000" width="10" align="center">
  					<img src="images/del.png" border="0" style="cursor:hand" onclick="if (confirm('�z�T�w�n:\n�R����<?php echo $row['tsort'];?>�D?')) { document.myform.act.value='search_delete_one';document.myform.option2.value='<?php echo $row['ibsn'];?>';document.myform.submit(); }">
  		</td>
  	</tr>
  	<?php
  	} 
  	?>
  	</table>
    <input type="button" value="�R���Ŀ諸�D��" onclick="document.myform.act.value='search_delete_select';document.myform.submit();">
<?php
}

function chk_ifgroup($TEST,$student_sn) {
    	//�έp�@���O�� , �Y���@���O��, ���o�Q���w���խ�
    	$DEL=0;
    	if ($TEST['active']==1) {
    	 //�d���
    	 $query="select count(*) as num from contest_record1 where tsn='".$TEST['tsn']."' and student_sn='".$student_sn."'";
    	 list($N)=mysql_fetch_row(mysql_query($query));
    	 if ($N==0) { $DEL=1; }
    	}else{
    	 //�W�ǧ@�~
    	 //�d���
    	 $query="select filename from contest_record2 where tsn='".$TEST['tsn']."' and student_sn='".$student_sn."'";
    	 list($FILE)=mysql_fetch_row(mysql_query($query));
    	 if ($FILE=="") {
     	   $DEL=1;
    	  } 
    	}
    	//���禹�ͬO�_���O�ղժ�
    	if ($DEL==1) {
    	$query="select id from contest_user where tsn='".$TEST['tsn']."' and ifgroup='".$student_sn."'";
    	  if (mysql_num_rows(mysql_query($query))>0) {
    	   $DEL=0;
    	  }
      }
      return $DEL;
}

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

//���U�� java function =================================================================================
?>

