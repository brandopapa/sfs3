<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";

sfs_check();

if ($_SESSION['session_who'] != "�Юv") {
	echo "�ܩ�p�I���\��Ҳլ��Юv�M�ΡI";
	exit();
}

//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();

//�ثe��w�Ǵ�
$c_curr_seme=($_POST['c_curr_seme']=='')?sprintf('%03d%1d',$curr_year,$curr_seme):$_POST['c_curr_seme'];

//�ثe��w���Z��
$c_curr_class=$_POST['c_curr_class'];

//���o��w�~�ת��Ҧ��Z�Ű}�C
$select_class=class_base($c_curr_seme);

//���o�Ǧ~�Ǵ��}�C
$select_seme=get_class_seme();
$select_seme=array_reverse($select_seme,1); //�N�}�C����, �ϸ���~�ױƫe��

//POST ��ƳB�z �R��
if ($_POST['act']=='del') {
 //�}�l�R��
 $i=0;
 foreach ($_POST['sn'] as $sn) {
  $sql="delete from association where sn='$sn'";
  $res=$CONN->Execute($sql) or die ('SQL ���~! query='.$sql);
  $i++;
 } // end foreach
 $INFO="�w���\�R��".$i."�����!";
} // end if del

//POST ��ƳB�z �R��
if ($_POST['act']=='save') {
 //�}�l�R��
 foreach ($_POST['association_name'] as $sn=>$v) {
 	if ($v) {
   	$association_name=$v;
   	$score=$_POST['score'][$sn];
   	$stud_post=$_POST['stud_post'][$sn];
   	$description=$_POST['description'][$sn];
   	
   	$sql="update association set association_name='$association_name',score='$score',stud_post='$stud_post',description='$description' where sn='$sn'";
  	$res=$CONN->Execute($sql) or die ('SQL ���~! query='.$sql);
 	
 	} 	
 } // end foreach
 $INFO="��".date("Y-m-d H:i:s")."�i���x�s!";
} // end if save



//���o�Ǵ����γ]�w
//$SETUP=get_club_setup($c_curr_seme);

//�q�X����
head("���ά��� - ���Z��Ʈw����");
//�C�X���
$tool_bar=&make_menu($school_menu_p);
echo $tool_bar;

//����O�_���޲z�v
$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);
if (!$module_manager) {
  echo "��p! �z�S���޲z�v!";
  exit();
}
?>
<form method="post" name="myform" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<input type="hidden" name="act">
	<!--�Ǧ~�Ǵ���� -->
	<select name="c_curr_seme" size="1" onchange="document.myform.c_curr_class.value='';document.myform.submit()">
		<?php 
		foreach ($select_seme as $k=>$v) {
			?>
			<option value="<?php echo $k;?>"<?php if ($k==$c_curr_seme) echo " selected";?>><?php echo $v;?></option>
			<?php
		}
		?>	
	</select>
	<!--�Z�ſ�� -->
	<select name="c_curr_class" size="1" onchange="document.myform.submit()">
		<option value="" style="color:#FF00FF">�п�ܯZ��</option>
		<?php 
		foreach ($select_class as $k=>$v) {
			?>
			<option value="<?php echo $k;?>"<?php if ($k==$c_curr_class) echo " selected";?>><?php echo $v;?></option>
			<?php
		}
		?>	
	</select>
	<input type="radio" name="list_mode" value="0" <?php if ($_POST['list_mode']==0) echo " checked";?> onclick="document.myform.submit()">�ȧe�{��ʶפJ�����
	<input type="radio" name="list_mode" value="1" <?php if ($_POST['list_mode']==1) echo " checked";?> onclick="document.myform.submit()">�e�{�Ҧ����
	<!--�C�X�Z�Ū��ΦC�� -->
	<?php
	 if ($_POST['c_curr_class']) {
	 	?>
	 	<table border="2" style="border-collapse:collapse" bordercolor="#111111" cellpadding="3">
	 		<tr bgcolor="#CCFFFF">
	 			<td width="10" align="center"><input type="checkbox" value="1" name="check_all" onclick="check_copy('check_all','sn')"></td>
	 			<td width="40" align="center">�y��</td>
	 			<td width="100" align="center">�m�W</td>
	 			<td align="center">�ѥ[����</td>
	 			<td width="40" align="center">���Z</td>
	 			<td align="center">����F��</td>
	 			<td align="center">���ɦѮv���y</td>
	 			<td align="center">��s�ɶ�</td>
	 			<td align="center">����</td>
	 		</tr>
	 	<?php
	 	//���o�ӯZ�ǥͩҦ����
	 	$sql="select a.*,b.seme_num,c.stud_name from association a,stud_seme b,stud_base c where a.seme_year_seme=b.seme_year_seme and a.student_sn=b.student_sn and b.student_sn=c.student_sn and b.seme_class='$c_curr_class' and a.seme_year_seme='$c_curr_seme' order by b.seme_num";
	 	$res=$CONN->Execute($sql) or die('SQL Error! query='.$sql);
	 	while ($row=$res->FetchRow()) {
	 		$row['club_sn']=trim($row['club_sn']);
	 		if ($row['club_sn']) {
	 			if ($_POST['list_mode']) {
			?>
			<tr style="color:#888888">
	 			<td align="center">��</td>
	 			<td align="center"><?php echo $row['seme_num'];?></td>
	 			<td align="center"><?php echo $row['stud_name'];?></td>
	 			<td><?php echo $row['association_name'];?></td>
	 			<td align="center"><?php echo $row['score'];?></td>
	 			<td align="center"><?php echo $row['stud_post'];?></td>
	 			<td><?php echo $row['description'];?></td>
	 			<td style="font-size:10pt"><?php echo $row['update_time'];?></td>
	 			<td style="font-size:10pt;color:#FFAAAA"><i>�դ�����</i></td>
			</tr>
	 		<?php	
	 			}
	 		} else {
			?>
			<tr bgcolor="#FFFFCC">
	 			<td align="center"><input type="checkbox" name="sn[<?php echo $row['sn'];?>]" value="<?php echo $row['sn'];?>"></td>
	 			<td align="center" style="color:#0000FF"><?php echo $row['seme_num'];?></td>
	 			<td align="center" style="color:#0000FF"><b><?php echo $row['stud_name'];?></b></td>
	 			<td><input type="text" name="association_name[<?php echo $row['sn'];?>]" value="<?php echo $row['association_name'];?>"></td>
	 			<td><input type="text" name="score[<?php echo $row['sn'];?>]" value="<?php echo $row['score'];?>" size="5"></td>
	 			<td><input type="text" name="stud_post[<?php echo $row['sn'];?>]" value="<?php echo $row['stud_post'];?>" size="20"></td>
	 			<td><input type="text" name="description[<?php echo $row['sn'];?>]" value="<?php echo $row['description'];?>"></td>
	 			<td align="center" style="color:#0000FF"><?php echo $row['update_time'];?></td>
	 			<td style="font-size:10pt;color:#6666FF"><i>�פJ���</i></td>
			</tr>
	 		<?php	
	 		
	 		} // end if 	
	 	
	 	} // end while
	 	
		?>	 	
	 	</table>
	 	<input type="button" value="�R���Ŀ諸���" onclick="if (confirm('�z�T�w�n:\n�R���Ŀ諸���?')) { document.myform.act.value='del';document.myform.submit(); }">
	 	<input type="button" value="�x�s���" onclick="document.myform.act.value='save';document.myform.submit()">
	 	<font color="red" size=2><i><?php echo $INFO;?></i></font>
	 
	 <?php
	 }// end if ($_POST['c_curr_class']) 
	 
	?>
	

</form>
	 <br>
	 <font color="#800000">
	  �������G<br>
	  1.���{���\��D�n�Ω��˵����~�U�Z�ǥͪ����ά��ʸ�ơA�ðw���ƪ�����ʭק�ΧR���C<br>
	  2.��ܪ����e�Ȥ��ǥͦb�Ǵ�������ơA�Y���~����ǥ͡A��D�b�Ǵ������~�ո�ƵL�k�e�{�A�ЧQ�Ρu��ǥ͸ɵn�L�ո�ơv�\��s��C
	 </font> 
	  

