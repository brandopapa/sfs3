<?php
// $Id: test_view.php 8705 2015-12-29 03:03:33Z qfon $
// --�t�γ]�w��
include "config.php"; 
session_start();
if($_SESSION[session_log_id]==""){	
	$go_back=1; //�^��ۤw���{�ҵe��  
		include "header.php";
	include $SFS_PATH."/rlogin.php";  
	exit;
}

$con=1;	//�w�]�C���D��
$font_q="<font <font size=7 face=�з���>";   // �D�ئr��
$font_c="<font <font size=6 face=�з���>";   // �ﶵ�r��
if($key=="�T�wok"){  //�ֹﵪ��
	
	for($i=1;$i<=$con;$i++){	
		if($breed==1)
			$ans[$i]=implode("",$ans[$i]);
		elseif($breed==2)
			$ans[$i]=trim($ans[$i]);		
	}
	
}

if($key=="�U�@�D>>"){	
	$qid=$qid+1;
}
if($key=="<<�W�@�D"){	
	$qid=$qid-1;
}
$qid=intval($qid);
$sqlstr = "select * from test_data   where  qid='$qid' " ;
$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
$s_unit="<form  method='post' action=$PHP_SELF >" ;
$s_unit.="�@�@($qid)" ;
$s_unit.="<table border='1' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='95%'  align='center'>";
while ($row = $result->FetchRow() ) {   
	$i=1; 	
//	$qid = $row["qid"] ;	
	$ques = $row["ques"] ;  
	$ch[1] = $row["ch1"] ;  
	$ch[2] = $row["ch2"] ;  
	$ch[3] = $row["ch3"] ;  
	$ch[4] = $row["ch4"] ;  
	$ch[5] = $row["ch5"] ;  
	$ch[6] = $row["ch6"] ;  
	$breed = $row["breed"] ; 
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
	}
	//�@�ﵪ��		
	if($key=="�T�wok"){	
			
	    	if($ans[$i]==$answer){			
			$ans_c="";
			$sc=1;			
			$comment="<img src='images/right.gif' align='left'  alt='+ $sc ��'>";
		}else{ 			
			$ans_c="<br><font color=red size=3 face=�s�ө���>�ѵ��G$answer</font>";
			$sc=0;
			$comment="<img src='images/error.gif' align='left' alt='- $sc ��'>";	
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
					$s_unit.="<tr><td ><font color=blue size=5>$myans[$j]</font>$font_c  $ch[$j]</font></td></tr>";					
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
					$s_unit.="<tr><td ><font color=blue size=7>$myans[$j]</font>$font_c $ch[$j]</font></td></tr>";					
			}
			$s_unit.="</table>";
			break;				
		case 2:
			$s_unit.="$comment<font color=blue size=7 face=�з���>$ans[$i]</font>";
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
	$act="�~��next";

}else{
	$act="�T�wok";
}
$s_unit.="</table><br>"; 

$s_unit.="<input type='hidden' name='qid' value='$qid'>	
<input type='hidden' name='unit' value='$unit'>		
<input type='hidden' name='breed' value='$breed'>		
	<font color=#FF00FF face=�з��� size=6>
	�@$msg_c</font><input type='submit' name='key' value='$act' style='font-size: 16 pt; color: #0000FF; font-family: �з���'>�@
<input type='submit' name='key' value='<<�W�@�D' style='font-size: 12 pt; color: #0000FF; font-family: �з���'>
<input type='submit' name='key' value='�U�@�D>>' style='font-size: 12 pt; color: #0000FF; font-family: �з���'>

	�@$subm
	</form>"; 



//�����������




// �����}�l

if($unit=="")
	$back="test_admin.php";
else
	$back="test_edit.php?unit=$unit";

include "header_u.php";
?>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="95%" >
  <tr>
    <td width="20%" ><a href="<?=$back ?>">�^�W�@��</a></td>
</tr></table>
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

