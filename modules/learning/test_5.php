<?php
//��������}�l
if($key=="�T�wok"){  //�ֹﵪ��
	for($i=1;$i<=$con;$i++){	
		if($breed[$i]==1)
			$ans[$i]=implode("",$ans[$i]);
		elseif($breed[$i]==2)
			$ans[$i]=trim($ans[$i]);		
	}

}else{    //�X�D
	// �H�椸���d��
	$sqlstr = "select * from test_score where s_id='$s_id' " ;
	$result = mysql_query($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256);
	$row= mysql_fetch_array($result);
	$righ = $row["righ"];


	$time ++;
	if( $righ!=""){		
		$righ2=substr($righ,0,strlen($righ)-1);  // ���諸�D�ؤ�����,���׬��ťէY���X�{
		$sqlstr= "select * from test_data   where  (u_id='$u_id') and ! ( qid in ($righ2)) and ( answer !='') " ;
	}else{
		$sqlstr = "select * from test_data  where  u_id='$u_id'  and ( answer !='') " ;	
	}
	if($total < $canon){  //���X����D
		$sqlstr.=" and breed=0";
	}
	$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
	$i=1;
	while ($row = $result->FetchRow() ) {    	
		$test[$i]= $row["qid"] ;		
		$i++;
	}
	if($i < $con){   //�L���椸
		$s_unit="<font size=7 color=red>�L���椸���D�w�I</font>";
	}

	if($i<($con+3)){  //�ѤU���D�ؤ����ɡA�����D���k0
		$righ="";
		$sqlstr = "select * from test_data  where  u_id='$u_id'  and ( answer !='') " ;	
		$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
		$i=1;
		while ($row = $result->FetchRow() ) {    	
			$test[$i]= $row["qid"] ;		
			$i++;
		}
	}
	$quesin=array_rand($test,$con);  //�üƥX�D
	$paper="" ;    
	for($i=0;$i<$con;$i++){	
		$paper.=$test[$quesin[$i]].",";		
	}
	$paper=substr($paper,0,strlen($paper)-1);  		
}
if($s_unit ==""){
$sqlstr = "select * from test_data   where  qid in ($paper) " ;
$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
$s_unit="<form  method='post' action=$PHP_SELF >" ;
$s_unit.="<table border='1' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='95%'  align='center'>";
$i=0;
$sco=0;
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
	$ques_up_c="";
	$ques_wav_c="";
	if($ques_up != ''){ 
		//if (substr($ques_up,-3)=='jpg' or substr($ques_up,-3)=='JPG'or substr($ques_up,-3)=='gif' or substr($ques_up,-3)=='png'){		
		$ques_up_c="<img  src='" . $downtest_path  .$qid. "_" .$ques_up . "'>";
	}
	if($ques_wav != ''){
		//if(substr($b_upload,-3)=='wav' or substr($b_upload,-3)=='WAV'or substr($b_upload,-3)=='mp3' or substr($b_upload,-3)=='MP3' or substr($b_upload,-3)=='mid' or substr($b_upload,-3)=='MID'){		
		$talk= $qid. "_" .$ques_wav;
		$ques_wav_c= "<a href=javascript:Play('$talk');><img  border=0 src='images/speak.gif'  width=22 height=18 align=middle ></a>" ;

//		$ques_wav_c= "<a href=javascript:Play('$talk');  OnmouseOver=javascript:window.status='aaa';return true;   OnMouseOut=javascript:window.status='';><img  border=0 src='images/speak.gif'  width=22 height=18 align=middle ></a>" ;
	}
//	$s_unit.="<tr><td width='60%'>$font_q $ques $ques_up_c $ques_wav_c</font></td><td width='40%' valign='top'>";
	//�@�ﵪ��		
	if($key=="�T�wok"){	
	    	if($ans[$i]==$answer){			
			$ans_c="";
			$sc=1;			
			if($bre > 0)
				$sc=2;    //�D����D�[2��
			$comment="<img src='images/right.gif' align='left'  alt='+ $sc ��'>";
			$sco=$sco + $sc ;
			$score++;
			$total_r ++;
			$sql_update = "update test_data set total_r='$total_r' where qid='$qid' ";  //����v	
			mysql_query($sql_update) or die ($sql_update);			
			$righ=$righ . $qid .",";  //�����T�����צr��
		}else{ 			
			$ans_c="<br><font color=red size=3 face=�s�ө���>�ѵ��G$answer</font>";
			if( $total >20 ){ 
				$ans_c.="<input type='submit' name='key' value='���X�ӶD$i'  title='�p���D�ؤε��צ��øq�A�i���X�q���n�D�I' style='font-size: 8 pt'>
					<input type='hidden' name='q_id[$i]' value='$qid'>";
			}
			$sc=0;
			if($poke_type>2){ 
		 		//�ĤG�ťH�W�h���������Ӧ�����
				$sc=1;			
				if($bre > 0)
					$sc=2;    //�D����D�[2��
			}	
			$sco=$sco - $sc ;
			$comment="<img src='images/error.gif' align='left' alt='- $sc ��'>";	
			$total_e ++;
			$err ++;
			$sql_update = "update test_data set total_e='$total_e' where qid='$qid' ";  //����v	
			mysql_query($sql_update) or die ($sql_update);					
		}
		$s_unit.="<tr><td width='60%'>$font_q $ques $ques_up_c $ques_wav_c $ans_c</font></td><td width='40%' >";
	       switch ($bre){
		case 0:
			$s_unit.="$comment <table border='0' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%' align='left'>";
			for($j=1;$j<=6;$j++){
				$myans[$j]="��";
				if($j==$ans[$i])	
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
				if(substr_count($ans[$i],$j)>0)	
					$myans[$j]="��";

				if($ch[$j]!="")	
					$s_unit.="<tr><td ><font color=blue >$myans[$j]</font>$font_c $ch[$j]</font></td></tr>";					
			}
			$s_unit.="</table>";
			break;				
		case 2:
			$s_unit.="$comment<font color=blue size=5 face=�з���>$ans[$i]</font>";
			break;
		}
		
//�X�D
	}else{
		$s_unit.="<tr><td width='60%'>$font_q $ques $ques_up_c $ques_wav_c</font></td><td width='40%' >";
		switch ($bre){
		case 0:
			$s_unit.="<table border='0' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%' >";
			for($j=1;$j<=6;$j++){
				if($ch[$j]!="")	
					$s_unit.="<tr><td ><input type='radio' value=$j  name='ans[$i]'>$font_c $ch[$j]</font></td></tr>";					
			}
			$s_unit.="</table>";
			break;
		case 1:
			$s_unit.="<table border='0' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%' >";
			for($j=1;$j<=6;$j++){
				if($ch[$j]!="")	
					$s_unit.="<tr><td ><input type='checkbox'  value=$j  name='ans[$i][]'>$font_c $ch[$j]</font></td></tr>";					
			}
			$s_unit.="</table>";

			break;				
		case 2:
			$s_unit.="<input type='text' name='ans[$i]'  size='20' style='font-size: 18 pt' >";
			break;
		}
	}
	
	$s_unit.="</td></tr>";
}
if($key=="�T�wok"){	
	//����^��
	$msg_g = array("�Х[�o�I","���z�Q�I","�٥i�H�I","�u�����I","�F�`��I","�ӴΤF�I","�W���g�I"); 
	$sqlstr = "select * from test_score where s_id='$s_id' " ;
	$result = mysql_query($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256);
	$row= mysql_fetch_array($result);
	$type = $row["type"];
	if($type!=1){
		$sco= 0;  
		$msg_c="<font color=red face=�з��� size=7>����������~�I����</font>";
	}else{
		if($sco <0)
			$sco= 0;
		$msg_c=$msg_g[$sco] .  "�o��F " .$sco . " ���I";
	}
	$act="�~��next";
//���諸
	if($sco>0 ){
		if($total>200){
			$msg_c.="�@���԰��O�̰��i�֭p��200����<br>�@�@���𮧤@�U�a�I";
		}else{
			$total= $total + $sco ;
		}
		$sql_update = "update test_score set righ='$righ' ,total='$total' ,type='0' where s_id='$s_id' ";  	
		mysql_query($sql_update) or die ($sql_update);	
	}

}else{
	$sql_update = "update test_score set type='1' ";
	$sql_update .= " where s_id='$s_id' " ;
	mysql_query($sql_update) or die ($sql_update);

	$msg_c="�ХJ���ˬd��A�����I";
	$act="�T�wok";
}
$s_unit.="</table><br>"; 
$subm="<input type='submit' name='key' value='�ڪ����_�_��' >";
$subm.="<input type='submit' name='key' value='�ڪ�����' >";
if($total >= 100){
	$subm.="<input type='submit' name='key' value='�԰�' >";
}
if($exper >= 5  and $top==0){
	$subm.="<input type='submit' name='key' value='�i��' >";
}

if($total>=$pass and $poke==0){  //�Ĥ@���L��
	$poke=rand(1,50);
	$sql_update = "update test_score set poke='$poke',up_date='$up_date' where u_id='$u_id' and teacher_sn='$_SESSION[session_tea_sn]' ";  	
	mysql_query($sql_update) or die ($sql_update);	
		$poke_alt=$poke . "_" . $poke_a[$poke]['p_name'];
		$poke_gif="<img src=poke_b/$poke" . ".gif  alt=$poke_alt >";
		$act="�~��next";
		$msg_c.="<font color=#FF00FF face=�з��� size=6><br>�A�s���A�����_�_���O</font>$poke_gif";
		 $poke_n="���ߧA�s���A�@�����_�_���I" ;

}


$s_unit.="<input type='hidden' name='paper' value='$paper'>			
	<input type='hidden' name='score' value='$score'>
	<input type='hidden' name='righ' value='$righ'>	
	<input type='hidden' name='err' value='$err'>
	<input type='hidden' name='breed' value='$breed'>	
	<input type='hidden' name='unit' value='$unit'>
	<input type='hidden' name='time' value='$time'>	
	<input type='hidden' name='time2' value='$time2'>					
	<font color=#FF00FF face=�з��� size=6>
	�@$msg_c</font><input type='submit' name='key' value='$act' style='font-size: 16 pt; color: #0000FF; font-family: �з���'>
	�@$subm
	</form>"; 
//�קK�òq
if($err>15 and $err>$score){
	$total= $total -10 ;

	if($total<0){
		$total= 0 ;
	}
	$sql_update = "update test_score set total='$total' ,type='0' where s_id='$s_id' ";  	
	mysql_query($sql_update) or die ($sql_update);	

	$s_unit="<font color=#FF00FF face=�з��� size=6>�A���{�׹�b�Ӯt�F�I<br>��ĳ�A����оǸ귽�Ͼǲ߫�A<br>�A�ӬD�ԧa�I</font>";
}

}
//�����������

?> 