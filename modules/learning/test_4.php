<?php
//�d�ݺ����}�l
	$s_unit="<form  method='post' action=$PHP_SELF >" ;	
	// �w���A�����_�_��
	$sqlstr = "select a.*,b.unit_t,b.unit_m,b.u_s,b.unit_name from`test_score` a ,unit_u b WHERE a.u_id=b.u_id and   teacher_sn= '$_SESSION[session_tea_sn]'  and who='$_SESSION[session_who]' and poke>0 order by unit_t,unit_m,u_s" ;

	if($key=='�̽s��'){
		$sqlstr = "select a.*,b.unit_t,b.unit_m,b.u_s,b.unit_name  from`test_score` a ,unit_u b WHERE a.u_id=b.u_id and   teacher_sn= '$_SESSION[session_tea_sn]'  and who='$_SESSION[session_who]' and poke>0 order by poke" ;
	}
	if($key=='�̾԰��O'){
		$sqlstr = "select a.*,b.unit_t,b.unit_m,b.u_s,b.unit_name  from`test_score` a ,unit_u b WHERE a.u_id=b.u_id and   teacher_sn= '$_SESSION[session_tea_sn]'  and who='$_SESSION[session_who]' and poke>0 order by a.total desc" ;
	}
	$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
	$s_unit.="<table align='center' border='1' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='95%' ><tr>";
	$t=0;
	$poke_sum=0;
	while ($row = $result->FetchRow() ) {    	
		$poke_p= $row["poke"] ;	
		$p_total= $row["total"] ;
		$p_top= $row["top"] ;
		$up_date= $row["up_date"] ;
		$online_date= $row["online_date"] ;
		$unit_name=$row["unit_name"];
		$unit_t=$row["unit_t"];

		$unit_p=$row["unit_m"] . $row["unit_t"] . $row["u_s"];
		$poke_alt=$poke_p . "_" . $poke_a[$poke_p]['p_name']."�@���԰��O:".$p_total  ;
		if($p_top==1)
			$poke_alt.= "�@���׷��i��";

		$today=date("Y-m-d");
		$s_unit_t=stud_ye($_SESSION[session_log_id])-1;

		if($online_date==$today)
			$poke_alt.= "�@������w��";

		$poke_alt.= "�@$up_date";
		$bgco='';
		if($unit_t >= $s_unit_t and  $online_date!=$today and  $p_total>=100 ){
			$bgco="#ffccff" ;
		}
		
		$poke_gif="<img src=pokemon/$poke_p" . ".gif  alt=$poke_alt  >" ;
		$s_unit.="<td align='center' width='10%' bgcolor='$bgco' >$poke_gif <a href=$PHP_SELF?unit=$unit_p title='$unit_p $unit_name'>�V�m</a> </td>";
		$t++;
		$poke_sum++;
		if($t==10){
			$s_unit.="</tr><tr>";
			$t=0;
		}
	}
	for($j=10;$j>$t;$j--){
		$s_unit.="<td width='10%'><br></td>";
	}
	if($t<10){
		$s_unit.="</tr>";		
	}
	$s_unit.="</table>";	
	$subm.="<input type='submit' name='key' value='�̽ҵ{' >
		<input type='submit' name='key' value='�̽s��' >
		<input type='submit' name='key' value='�̾԰��O' >";
	$subm.="<input type='submit' name='key' value='�ڪ�����' >";

	$msg_c="<font color=#FF00FF face=�з��� size=6>�@���A�F $poke_sum ���I</font>";
	if($total >= 120){
		$subm.="<input type='submit' name='key' value='�԰�' >";
	}
	if($exper >= 5 and $poke_type<5){
		$subm.="<input type='submit' name='key' value='�i��' >";
	}
	
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
