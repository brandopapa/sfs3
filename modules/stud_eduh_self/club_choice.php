<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $


if ($_SESSION['session_who'] != "�ǥ�") {
	echo "�ܩ�p�I���\��Ҳլ��ǥͱM�ΡI";
	exit();
}

//�ˬd�O�_�}����μҲ�
if ($m_arr["club_enable"]!="1"){
   echo "�ثe���}����ά��ʼҲաI";
   exit;
}


//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();

//�ثe��w�Ǵ�
$c_curr_seme=sprintf('%03d%1d',$curr_year,$curr_seme);

//���o�ǥ͸��
$STUD=get_student($_SESSION['session_tea_sn'],$c_curr_seme);
$CLASS=substr($STUD['seme_class'],0,1); //�~�ťN�X�A�ΥH��� stud_club_base �� club_class
$CLASS_name=$school_kind_name[$CLASS]; //����A�p�@�~�A�G�~...


//���o�ثe�w�s�Z���G
//�o������ܼ� $CLASS_choiced, $CLASS_not_choiced, $CLASS_arranged, $CLASS_not_arranged;
$c_curr_class=$CLASS;

//���o�Ǵ����γ]�w
$SETUP=get_club_setup($c_curr_seme);
//�i��Үɬq �ɤ�����~ 2012-06-01 12:12:00
$StartSec=date("U",mktime(substr($SETUP['choice_sttime'],11,2),substr($SETUP['choice_sttime'],14,2),0,substr($SETUP['choice_sttime'],5,2),substr($SETUP['choice_sttime'],8,2),substr($SETUP['choice_sttime'],0,4)));
$EndSec=date("U",mktime(substr($SETUP['choice_endtime'],11,2),substr($SETUP['choice_endtime'],14,2),0,substr($SETUP['choice_endtime'],5,2),substr($SETUP['choice_endtime'],8,2),substr($SETUP['choice_endtime'],0,4)));

$nowsec=date("U",mktime(date("H"),date("i"),0,date("n"),date("j"),date("Y")));
//��Үɬq�O�_�w�L
if ($StartSec > $nowsec or $EndSec < $nowsec) {
	echo "�t�ήɶ�".date("Y-m-d H:i:s") ."<br>";
 echo "��p�A�{�b�D��Үɬq�A�L�k�i���ҡI";
 exit();
}

//�����\��צh�Ӫ��ή�
if ($SETUP['multi_join']==0) {
	//�ˬd�ǥͬO�_�w�ѥ[����
	//$my_club=get_student_join_club($STUD['student_sn'],$c_curr_seme);
	if ($my_club=get_student_join_club($STUD['student_sn'],$c_curr_seme)) {
		echo "���Ǵ��A�w�ѥ[�U�C���ΡA���ݰѥ[��ҡI<br>";
		foreach ($my_club as $My) {
	 		echo "<font color=red>�i".$My['club_name']."�j</font><br>";
		}
		exit();
	}
} // end if $SETUP['multi_join']

check_arrange();


if ($StartSec<$nowsec and $EndSec>$nowsec) {
	
	//���o�i��ת�����
	$query="select * from stud_club_base where year_seme='$c_curr_seme' and club_open='1' and (club_class='$CLASS' or club_class='100')"; 
	$res_club=mysql_query($query);
	$club_num=mysql_num_rows($res_club);
	//���Υi�ѿ�ܦW�B
	$club_for_stud_num=club_for_stud_num($CLASS,$c_curr_seme);

	//���o�Ӧ~�ŤH��
	$CLASS_num=class_student_num($CLASS,$c_curr_seme);
	// $CLASS_not_arranged �Ӧ~�ũ|��s�Z�H��
	
 //�ˬd���ζ}���`�����ƬO�_�����Ӧ~�žǥͿ��
  if ($CLASS_not_arranged>$club_for_stud_num) {
  	echo "���Υi�ѿ�פH�Ƥ����I<br>";
  	echo "$CLASS_name �žǥͦ@".$CLASS_num."�H , �|���s�Z���ǥͦ�".$CLASS_not_arranged."�H <br>";
  	echo "���M�ݥ��~�Ū��γѾl�i�ѿ�Ҫ��W�B�� ".$club_for_stud_num. "�H";
  	exit();
  }
	
	//=================================

	if ($_POST['mode']=='insert') {
	  foreach ($_POST['choice'] as $K=>$club_sn) {
	  if ($club_sn!="") {
	  	$CLUB_SET=get_club_base($club_sn);
	  	
	  	$club_student_num=get_club_student_num($c_curr_seme,$row['club_sn']);
			$club_student_number=$club_student_num[0]; //�����Τw�n�����H��
	  	
	  	if (($SETUP['choice_over']==0 and get_club_choice_rank($club_sn,1)>=$CLUB_SET['club_student_num']) or ($club_student_number>=$CLUB_SET['club_student_num'])) {
		   $INFO="���� �i".$CLUB_SET['club_name']."�j�H�Ƥw���I�����x�s!";
		   $query="delete from stud_club_temp where  year_seme='$c_curr_seme' and student_sn='".$STUD['student_sn']."' and choice_rank='$K'";
		   mysql_query($query);
		  } else {
	    $query="select * from stud_club_temp where year_seme='$c_curr_seme' and student_sn='".$STUD['student_sn']."' and choice_rank='$K'";
	    $result=mysql_query($query);
	    if (mysql_num_rows($result)) {
	   			$query="update stud_club_temp set club_sn='$club_sn' where year_seme='$c_curr_seme' and student_sn='".$STUD['student_sn']."' and choice_rank='$K'";
	    	}else{
	   			$query="insert into stud_club_temp (club_sn,year_seme,student_sn,choice_rank) values ('$club_sn','$c_curr_seme','".$STUD['student_sn']."','$K')";
	    } // end if mysql_num_rows
	    
	    if (mysql_query($query)) {
	     $INFO="�w��".date("Y-m-d H:i:s")."�x�s�A�����@!";	    
	    }else{
	     echo "Error! query=$query";
	     exit();
	    }
	   } // end if $SETUP['choice_over']==0 and get_club_choice_rank($club_sn,1)>=$ ....
	  } // end if $club_sn!=""   
	  }	// end foreach
	
	} // end if ($_POST['mode']=='insert')	
	
	//=================================
	
?>	
	<table border="0" width="800">
		 <tr>
		 	<td style="color:#0000FF">����ת��λ����G(�ǥ͡G<?php echo $STUD['stud_name'];?>)</td>
		</tr>
		<tr>
			<td style="color:#000000">
				1.���Ǵ�<font color=red><?php echo $CLASS_name;?>��</font>�P�ǥi�H��ܪ����Φ@��<?php echo $club_num;?>�ӡA�A�i�H�q����<font color=red>�@��</font>���ΰѥ[�C<br>
				2.��Ҵ����� <font color=red><?php echo $SETUP['choice_sttime'];?></font> �� <font color=red><?php echo $SETUP['choice_endtime'];?> </font>��A�����I��e�A�H�ɥi�ק���@�C<br>
				3.��ҮɧA�̦h�i�H��� <font color=red><?php echo $SETUP['choice_num'];?></font> �ӧ��@�A�M���ҺI��ɦA�̧��@���Ǥ�ǽs�Z�C<br>
					(1)���H�Ҧ��P�Ǫ��Ĥ@���@�s�Z�A�Y�Y���Ϊ��Ĥ@���@�H�ƶW�L����W�B�A�h�̶üƨM�w�i�J�諸�P�ǡA��l�P�ǩ����A�H�ĤG���@�s�Z�C<br>
					(2)�i��ĤG���@�s�Z�ɡA�u���Ӫ��Τ����W�B�ɤ~�|�i��ĤG���s�Z�A�Y�ĤG���������諸�P�ǡA�h�o�ǦP�ǥ����i��ĤT���@���s�Z�C<br>
					(3)�̦�����, ����Ҧ����@�����s���C<br>
					(4)��Ҧ����@�s���A���M���諸�P�ǡA�o�ǦP�ǱN�Ѩt�Ψ̶ü��H���۰ʽs�Z�C<br>
					(5)�C�X�Ҧ����Ϊ����@��ܱ��p�ѧA�ѦҡA�V��A�����@�A�H�K<font color=red><?php echo $SETUP['choice_num'];?></font> �ӧ��@������C<br>
					(6)<font color=red>�S�O�����G�d�U���n�Ҧ����@����P�@�Ӫ��ΡA�_�h�Ĥ@���@�S���A�᭱���@�N��������C</font><br><br>
					
				<font color=blue>���s�Z�y�{�|�һ����G</font><br>
				<u>���l</u>���w�����Φ��H�U�T�ӡA��W�B������O���G�x�y��30�H�A���y��20�H�A�S�y��30�H�C<br>
				<u>���l</u>��F�Ĥ@���@�G�x�y���A�ĤG���@���y���A�ĤT���@�S�y���C<br><br>
				<font color=blue>��<u>���l</u>�ѥ[�s�Z���y�{�G</font><br>
					1.�t�βέp���x�y����Ĥ@���@���`�H�Ʀ�40�H�A�ҥH�̶üƩ��ҨM�w30�ӤJ��A��l10�츨��A��n<u>���l</u>����F�A<u>���l</u>�u�൥�ĤG���@�s�Z�C<br>
					2.<u>���l</u>���ĤG���@�O���y���A��Ĥ@���@�s���ɡA���y���|��5�ӦW�B�A���⨬�y����ĤG���@���A�٦�8��b�Ĥ@���@�ɨS�������ΡA�ҥH�A�̶üƩ��ҡA��3��P�Ǹ���A������<u>���l</u>�S����F�A�{�b<u>���l</u>�u��i��ĤT���@�s�Z�F�C<br>
					3.<u>���l</u>���ĤT���@�O�S�y���A�S�y���|��10�ӦW�B�A���S�y�����ĤT���@�B�|���J�諸�P�ǳ�5��A�o5����ƤJ�אּ�S�y���C<br>
					4.�ҥH<u>���l</u>�̫�O�S�y���ǭ��C<br>
			</td>
		</tr>
	</table>
	<table border="1" width="800">
		<tr>
			<!--����C�X���Υؿ��Q������� -->
			<td valign="top" width="550">
				<font color="#0000FF">��<?php echo $CLASS_name;?>�Ū��ΦC��P�ثe��񱡧�</font>
				<?php
				list_class_club_choice_detail($c_curr_seme,$CLASS,0,1); //�C�X�~�Ū��ο�ҩ���
			  ?>
 				<font color="#0000FF">����~�Ū����ΦC��P�ثe��񱡧�</font>
				<?php
				list_class_club_choice_detail($c_curr_seme,'100',0,1); //�C�X�~�Ū��ο�ҩ���
				?>
			</td>
			<!--�k��C�X���@�ѾǥͿ�� -->
			<td valign="top" align="left" width="250">
				<font color="#0000FF">���п�ܧA�����@�G</font><br>
				<form name="myform" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
					<input type="hidden" name="club_menu" value="<?php echo $_POST['club_menu'];?>">
					<input type="hidden" name="mode" value="insert">
				<table border="0" width="100%">
					<?php
					    for ($i=1;$i<=$SETUP['choice_num'];$i++) {
					    	$choice=get_seme_stud_choice_rank($c_curr_seme,$STUD['student_sn'],$i); //�Ǧ^�@club_sn
					    		//���o�i��ת�����
								$query="select * from stud_club_base where year_seme='$c_curr_seme' and club_open='1' and (club_class='$CLASS' or club_class='100') order by club_class,club_name"; 
								$res_club=mysql_query($query);
								?>
					    	 <tr>
					    	 	<td align="left">
										��<?php echo $i;?>���@
										<select size="1" name="choice[<?php echo $i;?>]">
											<option value="" style="color:#FF00FF">�п��...</option>
											<?php
											while ($row=mysql_fetch_array($res_club)) {
												$club_student_num=get_club_student_num($c_curr_seme,$row['club_sn']);
												$club_student_number=$club_student_num[0]; //�����Τw�n�����H��
												if (($SETUP['choice_over']==0 and get_club_choice_rank($row['club_sn'],$i)>=$row['club_student_num']) or ($club_student_number>=$row['club_student_num'])) {
													continue;
												}else{
											 ?>
											 <option value="<?php echo $row['club_sn'];?>"<?php if ($row['club_sn']==$choice) echo " selected";?> style="color:#800000"><?php echo $row['club_name'];?></option>
											 <?php
											 } // end if
											}
											?>			
										</select>
										<br><br>
					    	 	</td>
					    	</tr>
					    	<?php
					    }
					?>
					<tr>
						<td><input type="submit" value="�x�s"></td>
					</tr>
					<tr>
						<td style="color:#FF0000;font-size:9pt"><br><br><?php echo $INFO;?></td>
					</tr>
				</table>
			</form>
			</td>
		</tr>
	</table>
<?php	
} 
?>