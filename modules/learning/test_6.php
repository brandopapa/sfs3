<?php
//�d�ݺ����}�l

	$s_unit="<form  method='post' action=$PHP_SELF >" ;	
	// �w����������
	$sqlstr = "select * from`test_badge`  WHERE   teacher_sn= '$_SESSION[session_tea_sn]'  and who='$_SESSION[session_who]'  order by up_date desc " ;

	if($key=='�̧Ǹ�'){
	$sqlstr = "select * from`test_badge`  WHERE    teacher_sn= '$_SESSION[session_tea_sn]'  and who='$_SESSION[session_who]'  order by badge " ;
	}
	$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
	$s_unit.="<table align='center' border='1' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='95%' ><tr>";
	$t=0;
	$poke_sum=0;
	while ($row = $result->FetchRow() ) {  
		$up_date= $row["up_date"] ;	
		$badge= $row["badge"] ;	
		$poke_alt=$badge . "_" . $poke_a[$badge]['p_name']  ;
		$poke_alt.= "�@$up_date";
		$poke_gif="<img src=badge/$badge" . ".gif  alt=$poke_alt >" ;
		$s_unit.="<td align='center' width='20%'>$poke_gif </td>";
		$t++;
		$poke_sum++;
		if($t==5){
			$s_unit.="</tr><tr>";
			$t=0;
		}
	}
	for($j=5;$j>$t;$j--){
		$s_unit.="<td width='20%'><br></td>";
	}
	if($t<5){
		$s_unit.="</tr>";		
	}
	$s_unit.="</table>";	
	$subm.="<input type='submit' name='key' value='�̧Ǹ�' >
	<input type='submit' name='key' value='�̤��' >
	<input type='submit' name='key' value='�ڪ����_�_��' >


";
	$msg_c="<font color=#FF00FF face=�з��� size=6>�@�����F $poke_sum �ӡI</font>";
	
$s_unit.="<input type='hidden' name='paper' value='$paper'>			
	<input type='hidden' name='score' value='$score'>
	<input type='hidden' name='breed' value='$breed'>	
	<input type='hidden' name='unit' value='$unit'>
	<input type='hidden' name='righ' value='$righ'>				
	<font color=#FF00FF face=�з��� size=6>
	�@$msg_c</font><input type='submit' name='key' value='�~��next' style='font-size: 16 pt; color: #0000FF; font-family: �з���'>
	$subm
	</form>"; 
//�d�ݺ�������
?> 
