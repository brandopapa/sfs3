<?php
// $Id: test_admin.php 5310 2009-01-10 07:57:56Z hami $
// --�t�γ]�w��
include "config.php"; 
session_start();
sfs_check();
$att_time = mysql_date();
if($key == "�ק�]�w"){
	$sql_update ="UPDATE `test_setup` SET `mat`  ='$match',`open` = '$open' ,`unit` = '$unit',`n_games` ='$n_games',`content` = '$content' ";
	mysql_query($sql_update) or die ($sql_update);	
	$key='setup';	
}


if ($key == "�ק�"){
	$sqlstr = "select * from test_data   where  qid='$qid' " ;	
	$result = mysql_query($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256);
	$row = mysql_fetch_array($result);
	$ques = $row["ques"] ;  
	$ch[1] = $row["ch1"] ;  
	$ch[2] = $row["ch2"] ;  
	$ch[3] = $row["ch3"] ;  
	$ch[4] = $row["ch4"] ;  
	$ch[5] = $row["ch5"] ;  
	$ch[6] = $row["ch6"] ;  
	$breed= $row["breed"] ; 
	$answer= $row["answer"] ; 
	$ques_wav= $row["ques_wav"] ; 
	$ques_up= $row["ques_up"] ; 
	if($ques_up != ''){ 
		$ques_up_c="<img  src='" . $downtest_path  .$qid. "_" .$ques_up . "'>"; 
	}
	if($ques_wav != ''){
		$talk= $qid. "_" .$ques_wav;
		$ques_wav_c= "<a href=javascript:Play('$talk');><img  border=0 src='images/speak.gif'  width=22 height=18 align=middle ></a>" ;
	}


	$note= $row["note"] ; 
	$beef= $row["beef"] ; 
	$e_unit="<form action ='{$_SERVER['PHP_SELF']}' enctype='multipart/form-data' method=post>";
	$e_unit.="<table border='1' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='95%'  align='center'>";
	$e_unit.="<tr><td width='60%' valign='top'>�D��$qid �G<textarea name='ques' cols=50 rows=5 wrap=virtual>$ques</textarea> <br>";
	$e_unit.="�ѵ��G<input type='text' size='15' maxlength='40' name=answer  value=$answer >�@�@�D���G<input type='text' size='3' maxlength='3' name=breed  value=$breed > 0:���,1:�ƿ�,2:��R<br>";
	$e_unit.="�Ϥ��ɡG$ques_up_c <input type='file' size='30' maxlength='50' name='ques_up' >�@<font size=2><input type=checkbox name='del_img' value='1'> �R���Ϥ�</font><br>";
	$e_unit.="�y���ɡG$ques_wav_c  <input type='file' size='30' maxlength='50' name='ques_wav' >�@<font size=2><input type=checkbox name='del_wav' value='1'> �R���y��</font>";
	$e_unit.="</td><td width='40%' valign='top'>";
	$e_unit.="<table border='0' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%' align='left'>";
		for($j=1;$j<=6;$j++){	
			$e_unit.="<tr><td >�ﶵ$j �G <input type='text' size='30' maxlength='60' name=ch[$j]  value=". $ch[$j]."></td></tr>";
			//$e_unit.="<tr><td >�ﶵ$j �G <input type='text' size='30' maxlength='60' name=ch[$j]  value=". $ch[$j] ." ></td></tr>";					
		}
	$e_unit.="</table></td></tr>
		<tr><td colspan=2>�Ƶ��G<textarea name='note' cols=50 rows=5 wrap=virtual>$note </textarea> 
	$beef �ӶD�� <input type='submit' name='key' value='�[��'>
	<input type='submit' name='key' value='�L��'>
	</td></tr></table>";
	$e_unit.="�@�@<input type='submit' name='key' value='�T�w�ק�'>
		<input type='submit' name='key' value='����'>�@	
		<input type='hidden' name='unit' value='$unit'>
		<input type='hidden' name='qid' value='$qid'>
		<input type='hidden' name='old_up' value='$ques_up'>
		<input type='hidden' name='beef' value='$beef'>
		<input type='hidden' name='old_wav' value='$ques_wav'>";
	$e_unit.="</form>";

}
if($key == "�T�w�ק�"){
	$b_edit_time = mysql_date();
	$sql_update = "update test_data set ques='$ques',ch1='$ch[1]',ch2='$ch[2]',ch3='$ch[3]',ch4='$ch[4]',ch5='$ch[5]',ch6='$ch[6]',up_date='$b_edit_time',answer='$answer',note='$note',breed='$breed',teacher_sn='$_SESSION[session_tea_sn]'";
	$b_store = $qid."_".$_FILES[ques_up][name];
	$b_old_store = $b_id."_".$old_up;
	if($del_img==1){
		$sql_update .= ", ques_up=''";
		if(file_exists($TES_DESTINATION.$b_old_store))
			unlink($TES_DESTINATION.$b_old_store);
	}elseif (is_file($_FILES[ques_up][tmp_name])){
		$sql_update .= ", ques_up='".$_FILES[ques_up][name]."' ";
		if(file_exists($TES_DESTINATION.$b_old_store))
			unlink($TES_DESTINATION.$b_old_store);
		//�ˬd�O�_�W�� php �{����
		if  (check_is_php_file($_FILES[ques_up][name]))
			$error_flag = true;
		else{	
			copy($_FILES[ques_up][tmp_name] , ($TES_DESTINATION.$b_store));
		}
	}
	$b_store = $qid."_".$_FILES[ques_wav][name];
	$b_old_store = $b_id."_".$old_up;
	if($del_wav==1){
		$sql_update .= ", ques_wav=''";
		if(file_exists($TES_DESTINATION.$b_old_store))
			unlink($TES_DESTINATION.$b_old_store);
	}elseif (is_file($_FILES[ques_wav][tmp_name])){
		$sql_update .= ", ques_wav='".$_FILES[ques_wav][name]."' ";
		if(file_exists($TES_DESTINATION.$b_old_store))
			unlink($TES_DESTINATION.$b_old_store);
		//�ˬd�O�_�W�� php �{����
		if  (check_is_php_file($_FILES[ques_wav][name]))
			$error_flag = true;
		else{	
			copy($_FILES[ques_wav][tmp_name] , ($TES_DESTINATION.$b_store));
		}
	}
	$sql_update .= " where qid='$qid' " ;
	mysql_query($sql_update) or die ($sql_update);

}
if($key=='�[��'){
	$sqlstr = "select * from test_score   where  s_id='$beef'";
	$result = mysql_query($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256);
	$row = mysql_fetch_array($result);
	$exper = $row["exper"]+3 ;  
	$sql_update = "update test_score set exper='$exper'  where  s_id='$beef' " ;	
	mysql_query($sql_update) or die ($sql_update);
	$sql_update = "update test_data set ques='$ques',ch1='$ch[1]',ch2='$ch[2]',ch3='$ch[3]',ch4='$ch[4]',ch5='$ch[5]',ch6='$ch[6]',up_date='$b_edit_time',answer='$answer',note='$note',breed='$breed',teacher_sn='$_SESSION[session_tea_sn]',beef='0' where  qid='$qid'";
	mysql_query($sql_update) or die ($sql_update);
}
if($key=='�L��'){
	$sql_update = "update test_data set ques='$ques',ch1='$ch[1]',ch2='$ch[2]',ch3='$ch[3]',ch4='$ch[4]',ch5='$ch[5]',ch6='$ch[6]',up_date='$b_edit_time',answer='$answer',note='$note',breed='$breed',teacher_sn='$_SESSION[session_tea_sn]',beef='0' where  qid='$qid'";
	mysql_query($sql_update) or die ($sql_update);
}


//�B�z�ӶD

	$sqlstr = "select * from test_data   where  beef >0 " ;
$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
$s_unit="<table border='1' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='95%'  align='center'>";
$s_unit.="<tr><td width='50%'>�D��</td><td width='40%'>�ﶵ</td><td width='10%' align='center'>��/��<br>����v</td></tr>";

$i=0;
while ($row = $result->FetchRow() ) {    	
	$i=$i+1;
	$qid = $row["qid"] ;	
	$ques = $row["ques"] ;  
	$ch[1] = $row["ch1"] ;  
	$ch[2] = $row["ch2"] ;  
	$ch[3] = $row["ch3"] ;  
	$ch[4] = $row["ch4"] ;  
	$ch[5] = $row["ch5"] ;  
	$ch[6] = $row["ch6"] ;  
	$breed[$i] = $row["breed"] ; 
	$bre = $row["breed"] ; 
	$answer= $row["answer"] ; 
	$ques_wav= $row["ques_wav"] ; 
	$ques_up= $row["ques_up"] ; 
	$total_r= $row["total_r"] ; 
	$total_e= $row["total_e"] ; 
	$teacher_sn= $row["teacher_sn"] ; 
	$up_date= $row["up_date"] ; 
	$unit= $row["unit_m"] .  $row["unit_t"] .  $row["u_s"]  ; 

	$note= $row["note"] ; 
	$avg_r=round($total_r/($total_r+$total_e),2)*100;
	$ques_up_c="";
	$ques_wav_c="";
	if($teacher_sn>0){ 
		$edit_c="<font size=1> $teacher_sn - $up_date </font>"; 
	}

	if($ques_up != ''){ 
		$ques_up_c="<img  src='" . $downtest_path  .$qid. "_" .$ques_up . "'>"; 
	}
	if($ques_wav != ''){
		$talk= $qid. "_" .$ques_wav;
		$ques_wav_c= "<a href=javascript:Play('$talk');><img  border=0 src='images/speak.gif'  width=22 height=18 align=middle ></a>" ;
	}

		$ans_c="<br><font color=red size=3 face=�s�ө���>�ѵ��G$answer</font>�@<a href=$PHP_SELF?key=�ק�&qid=$qid&i=$i>�ק�</a>�@<a href=test_view.php?qid=$qid>�i��</a>";
	
		$s_unit.="<tr><td valign='top'>�D��: $qid ($unit) $edit_c  <br> $ques $ques_up_c $ques_wav_c $ans_c</font></td><td  valign='top'>";
	       switch ($bre){
		case 0:
			$s_unit.="$comment <table border='0' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%' align='left'>";
			for($j=1;$j<=6;$j++){
				$myans[$j]="��";
				if($ch[$j]!="")
					$s_unit.="<tr><td ><font color=blue>$myans[$j]</font>$font_c  $ch[$j]</font></td></tr>";					
			}
			$s_unit.="</table>";
			break;
		case 1:
			$s_unit.="$comment<table border='0' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%' align='left' >";
			for($j=1;$j<=6;$j++){
				$myans[$j]="��";				
				if($ch[$j]!="")	
					$s_unit.="<tr><td ><font color=blue >$myans[$j]</font>$font_c $ch[$j]</font></td></tr>";					
			}
			$s_unit.="</table>";
			break;				
		case 2:
			$s_unit.="$comment<font color=blue size=5 face=�з���></font>";
			break;
		}
		$bgcolor="";
	
		if($avg_r<90)
			$bgcolor="yellow";
		if($avg_r<50)
			$bgcolor="red";
	$s_unit.="</td ><td align='center' valign='top' bgcolor='$bgcolor' >$total_r / $total_e <br>$avg_r �H</td></tr>";
		$s_unit.="<tr><td colspan=3 bgcolor=CCCCFF>$note </td></tr>";

}
$s_unit.="</table>"; 


if($key=='�����M��'){
	$sql_update = "update test_online set h_who='' ,h_stud_id='',h_sid=0,h_sid1=0,h_sid2=0,h_sid3=0,h_sid4=0,h_sid5=0 ,h_name='',h_games='0' , g_who='' ,g_stud_id='',g_sid=0,g_sid1=0,g_sid2=0,g_sid3=0,g_sid4=0,g_sid5=0 ,g_name='',g_games='0' ,p_games='0' "; 	
	mysql_query($sql_update) or die ($sql_update);	
	$key='setup';	
}
if($key=='��Գ]�w'){
	$sqlstr = "select * from test_setup " ;
	$result = mysql_query($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256);
	$row= mysql_fetch_array($result);
	$match = $row["mat"] ;    //�v�ɤ�
 	$open = $row["open"] ;  	//�}�񪺹D�]
	$n_games = $row["n_games"] ;  //�H�h�֨M�w�ӭt
	$content = $row["content"] ;  //�C�j��s���
	$unit_m = $row["unit"] ;  //������
      $who='�ǥ�';
      for($p=1;$p<=16;$p++){
	if($stud_h[$p]!=''){
		$stud_id=$stud_h[$p];
		//��⪺���_�_��
		$today=date("Y-m-d");	
		$unit_t=stud_ye($stud_id)-1;
		$cond=" and online_date !='$today' ";
		if($unit_m!='')
				$cond.=" and  unit_m='$unit_m' ";
		if($unit_t!='')
				$cond.=" and  unit_t>'$unit_t' ";

		$sqlstr = "select a.*,b.unit_m,b.unit_t  from test_score a,unit_u b WHERE  a.u_id=b.u_id and stud_id= '$stud_id'  and who='$who' and poke>0 and a.total>=100 $cond order by total desc" ;
		$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
		$i=0;
		while ($row = $result->FetchRow() ) {    	
			$i++;
			if($i==1){
				$sid= $row["poke"];
				$h_name="�p" . substr($row["stud_name"],2,2);
			}
			$a_sid[$i]= $row["s_id"] ;
		}
		if($i>=($n_games*2-1)){
			$sql_update = "update test_online set h_who='$who' ,h_stud_id='$stud_id',h_sid='$sid',h_sid1='$a_sid[1]',h_sid2='$a_sid[2]',h_sid3='$a_sid[3]',h_sid4='$a_sid[4]',h_sid5='$a_sid[5]' ,h_name='$h_name',h_games='0' ,h_win='0',att_time='$att_time',h_attack='1',p_games='1'   where p_sn='$p' "; 	
			mysql_query($sql_update) or die ($sql_update);	
		}else{
			$pk=$n_games*2-1;
			$msg="$stud_id �S�� $pk ���H�W�i�԰������_�_���I(�ثe�u�� $i ��)";
			?>			
			<script language="JavaScript">
				alert("<?=$msg ?>")	
			</script>
			<?
		}	
	}
	if($stud_g[$p]!=''){
		$stud_id=$stud_g[$p];
		//��⪺���_�_��
		$today=date("Y-m-d");	
		$unit_t=stud_ye($stud_id)-1;
		$cond=" and online_date !='$today' ";
		if($unit_m!='')
				$cond.=" and  unit_m='$unit_m' ";
		if($unit_t!='')
				$cond.=" and  unit_t>'$unit_t' ";

		$sqlstr = "select a.*,b.unit_m,b.unit_t  from test_score a,unit_u b WHERE  a.u_id=b.u_id and stud_id= '$stud_id'  and who='$who' and poke>0 and a.total>=100 $cond  order by total desc" ;
		$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
		$i=0;
		while ($row = $result->FetchRow() ) {    	
			$i++;
			if($i==1){
				$sid= $row["poke"];
				$h_name="�p" . substr($row["stud_name"],2,2);
			}
			$a_sid[$i]= $row["s_id"] ;
		}
		if($i>=($n_games*2-1)){
			$sql_update = "update test_online set g_who='$who' ,g_stud_id='$stud_id',g_sid='$sid',g_sid1='$a_sid[1]',g_sid2='$a_sid[2]',g_sid3='$a_sid[3]',g_sid4='$a_sid[4]',g_sid5='$a_sid[5]' ,g_name='$h_name',g_games='0' ,g_win='0',att_time='$att_time',g_attack='1',p_games='1'   where p_sn='$p' "; 	
			mysql_query($sql_update) or die ($sql_update);	
		}else{
			$pk=$n_games*2-1;
			$msg="$stud_id �S�� $pk ���H�W�i�԰������_�_���I(�ثe�u�� $i ��)";
			?>			
			<script language="JavaScript">
				alert("<?=$msg ?>")	
			</script>
			<?
		}	
	}

      }
	$key='setup';	
	
}
if ($key == "setup"){
	$sqlstr = "select * from test_setup " ;
	$result = mysql_query($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256);
	$row= mysql_fetch_array($result);
	$match = $row["mat"] ;    //�v�ɤ�
 	$open = $row["open"] ;  	//�}�񪺹D�]
	$n_games = $row["n_games"] ;  //�H�h�֨M�w�ӭt
	$content = $row["content"] ;  //�C�j��s���
	$unit = $row["unit"] ;  //������
	$e_unit="<form action ='{$_SERVER['PHP_SELF']}' enctype='multipart/form-data' method=post>";
	$e_unit.="<table border='1' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='95%'  align='center'><tr><td>";
	$e_unit.="��ԧΦ��G<input type='text' size='2' maxlength='2' name=match  value=$match > 0:�צ椤,1:�v�ɤ��@�@�}�񪺹D�]�ơG<input type='text' size='3' maxlength='3' name=open  value=$open > �w�]8�ӡA�̦h16�ӡC<br>";
	$e_unit.="�M�ӳ��ơG<input type='text' size='2' maxlength='2' name=n_games   value=$n_games  > ���� $n_games ����Ĺ�@�@��s�W�v�G<input type='text' size='3' maxlength='3' name=content value=$content > ��ĳ�C10���s
�@�@�ǲ߻��(�N��)�G<input type='text' size='3' maxlength='3' name=unit value=$unit > �w�]������<br>";
	$e_unit.="</td></tr></table>";
	$e_unit.="�@�@<input type='submit' name='key' value='�ק�]�w'>
		<input type='submit' name='key' value='����'>";	
	$e_unit.="</form>";


	//���o�U�D�]���
	$sqlstr = "select * from test_online where  p_sn <= $open  " ;
	$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
	$s_unit="<font size=5 color=red>�@�@�]�w���ɿ��(�Ф��O��J�U�D�]���ɿ�⪺�Ǹ�)</font>";
	$s_unit.="<table align='center'  border='0' cellpadding='3' cellspacing='3' width='100%' >";
	$s_unit.="<form action= $PHP_SELF method=post name=bform>";
	$s_unit.="<tr>";
	$t=0;	
	$now_time = mysql_date();
	while ($row = $result->FetchRow() ) {    
		$t++;		
    		$p_sn = $row["p_sn"] ;   
	    	$p_name = $row["p_name"] ;  
		$h_name=$row["h_name"] ; 
		$h_stud_id=$row["h_stud_id"] ; 
		$g_name=$row["g_name"] ; 
		$g_stud_id=$row["g_stud_id"] ; 


		$cp_name="<font size=5 face=�з��� >$p_name</font>";
 	
		$s_unit.="<td width='25%'  align='center' valign='top'  >
		<table border='1' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='98%' >
  		<tr><td width='100%' height='32'colspan='2' align='center'>$cp_name</td></tr>
  		<tr><td width='50%' height='32'align='center'>�]�D</td>
    		<td width='50%' height='32' align='center'>�D�Ԫ�</td></tr>
  		<tr><td width='50%' height='32' align='center'><input type='text' name='stud_h[$p_sn]' size=10 ></td>
		<td width='50%' height='32' align='center'><input type='text'  name='stud_g[$p_sn]' size=10 ></td></tr>
 		<tr><td width='50%' height='32' align='center'>$h_name</td>
		<td width='50%' height='32' align='center'>$g_name</td></tr>
  		<tr><td width='50%' height='32' align='center'>$h_stud_id</td>
		<td width='50%' height='32' align='center'>$g_stud_id</td></tr> 
  	
		</table></td>";
		if($t==4){
			$s_unit.="</tr><tr>"; 
			$t=0;
		}
	}
	$s_unit.="</tr></font></table><input type='submit' value='��Գ]�w' name='key'>�@<input type='submit' value='�����M��' name='key'>"; 

}


// �����}�l
include "header_u.php";
?>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="95%" >
  <tr>
    <td  ><a href="index.php?m=<?=$m ?>&t=<?=$t ?>">�^�ؿ�</a>�@
		<a href="<?=$PHP_SELF?>">�B�z�ӶD</a>�@
		<a href="<?=$PHP_SELF?>?key=setup">�s�u��Ժ޲z</a>�@
		<a href="test_score.php?key=stud">�V�m�a�W��</a>�@
 </td>
</tr></table>
<?=$e_unit ?>
<?=$s_unit ?>
</body>
</html>



<script language="JavaScript">
<!--
function fullwin(curl){
window.open(curl,'alone','fullscreen=yes,scrollbars=yes');
}
	
// -->
</script>
<script language="JavaScript">
function Play(mp){ 
mp="<?=$SFS_PATH_HTML?>data/test/" + mp ;
Player.URL = mp;
}	

</script>

