<?php
// $Id: online_act.php 8763 2016-01-13 13:02:47Z qfon $
// --�t�γ]�w��
include "config.php"; 
session_start();
if($_SESSION[session_log_id]==""){	
	$go_back=1; //�^��ۤw���{�ҵe��  
		include "header.php";
	include $SFS_PATH."/rlogin.php";  
	exit;
}
if($p_sn=='')
	Header ("Location: online_con.php");


	$sqlstr = "select * from test_setup " ;
	$result = mysql_query($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256);
	$row= mysql_fetch_array($result);
	$n_games = $row["n_games"] ;  //�H�h�֨M�w�ӭt
	$content = $row["content"] ;  //�C�j��s���

//���o�̷s���p
$p_sn=intval($p_sn);
$sqlstr = "select * from test_online where  p_sn=$p_sn " ;
$result = mysql_query($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256);
$row= mysql_fetch_array($result);
   	$p_games = $row["p_games"] ;  //�ثe������
     	$pp_name = $row["p_name"] ;  
	$err=$row["err"] ; 
	$h_who=$row["h_who"] ; 
	$h_stud_id=$row["h_stud_id"] ; 
	$h_peo=$row["h_peo"] ; 
	$h_games=$row["h_games"] ; 
	$h_win=$row["h_win"] ; 
	$h_sid=$row["h_sid"] ; 
	$ah_sid[1]=$row["h_sid1"] ; 
	$ah_sid[2]=$row["h_sid2"] ; 
	$ah_sid[3]=$row["h_sid3"] ; 
	$ah_sid[4]=$row["h_sid4"] ; 
	$ah_sid[5]=$row["h_sid5"] ; 
	$h_attack=$row["h_attack"] ; 
	$h_blank=$row["h_blank"] ; 
	$h_bs=$row["h_bs"] ; 
	$h_att=$row["h_att"] ; 
	$h_name=$row["h_name"] ; 

	$g_who=$row["g_who"] ; 
	$g_stud_id=$row["g_stud_id"] ; 
	$g_peo=$row["g_peo"] ; 
	$g_games=$row["g_games"] ; 
	$g_win=$row["g_win"] ; 
	$g_sid=$row["g_sid"] ; 
	$ag_sid[1]=$row["g_sid1"] ; 
	$ag_sid[2]=$row["g_sid2"] ; 
	$ag_sid[3]=$row["g_sid3"] ; 
	$ag_sid[4]=$row["g_sid4"] ; 
	$ag_sid[5]=$row["g_sid5"] ; 
	$g_attack=$row["g_attack"] ; 
	$g_blank=$row["g_blank"] ; 
	$g_bs=$row["g_bs"] ; 
	$g_att=$row["g_att"] ;
	$g_name=$row["g_name"] ; 
	if($_SESSION[session_who]=='�Юv'){
		$h_name=$h_name . "_" .  $h_stud_id; 
		$g_name=$g_name . "_" .  $g_stud_id; 
	}

	if($_SESSION[session_log_id]==$h_stud_id and $_SESSION[session_who]==$h_who){
		$who='h';
		$my_sco=$h_win;
		$he_sco=$g_win;
		$poke=$h_sid;
		$poke_p=$g_sid;
		$peo=$g_peo;
		$my_rou=$h_attack;
		$he_rou=$g_attack;
		$my_games=$h_games;
		$he_games=$g_games;
		$my_sid[1]=$ah_sid[1]; 
		$my_sid[2]=$ah_sid[2]; 
		$my_sid[3]=$ah_sid[3]; 
		$my_sid[4]=$ah_sid[4]; 
		$my_sid[5]=$ah_sid[5]; 
		$he_sid[1]=$ag_sid[1]; 
		$he_sid[2]=$ag_sid[2]; 
		$he_sid[3]=$ag_sid[3]; 
		$he_sid[4]=$ag_sid[4]; 
		$he_sid[5]=$ag_sid[5]; 

		$my_blank=$h_blank;
		$my_bs=$h_bs;
		$he_blank=$g_blank;
		$my_att=$h_att;
		$he_att=$g_att;
		$my_name=$h_name;
		$he_name=$g_name;
		$he_stud_id=$g_stud_id;
		$he_who=$g_who;

		
	}elseif($_SESSION[session_log_id]==$g_stud_id and $_SESSION[session_who]==$g_who){
		$who='g';
		$my_sco=$g_win;
		$he_sco=$h_win;
		$poke=$g_sid;
		$poke_p=$h_sid;
		$peo=$h_peo;
		$my_rou=$g_attack;
		$he_rou=$h_attack;
		$my_games=$g_games;
		$he_games=$h_games;
		$my_sid[1]=$ag_sid[1]; 
		$my_sid[2]=$ag_sid[2]; 
		$my_sid[3]=$ag_sid[3]; 
		$my_sid[4]=$ag_sid[4]; 
		$my_sid[5]=$ag_sid[5]; 
		$he_sid[1]=$ah_sid[1]; 
		$he_sid[2]=$ah_sid[2]; 
		$he_sid[3]=$ah_sid[3]; 
		$he_sid[4]=$ah_sid[4]; 
		$he_sid[5]=$ah_sid[5]; 

		$my_blank=$g_blank;
		$my_bs=$g_bs;
		$he_blank=$h_blank;
		$my_att=$g_att;
		$he_att=$h_att;
		$my_name=$g_name;
		$he_name=$h_name;
		$he_stud_id=$h_stud_id;
		$he_who=$h_who;
	}else{
		Header ("Location: online_con.php");
	}
// ���H���b
	if($h_stud_id=='' or $g_stud_id==''){  
		Header ("Location: online_con.php");
	}


$n_sco=1;                         //�C�ۦ�����
$att_time = mysql_date();  //�ɶ�




//���o���_�_���ؿ����
$sqlstr = "select * from poke_base   " ;
$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
$i=1;
while ($row = $result->FetchRow() ) { 
	$p_name = $row["p_name"] ; 
	$poke_a[$i]['p_name']=$p_name ;
	$poke_a[$i]['1']=$row["p_s1"] ;
	$poke_a[$i]['2']=$row["p_s2"] ; 
	$poke_a[$i]['3']=$row["p_s3"] ; 
	$i++;
}
//���o���ɯ��_�_�����
$my_pokes="";
for ($i= 1 ; $i <= ($n_games*2-1) ;$i++){
	$sqlstr = "select * from test_score where  s_id='$my_sid[$i]'  " ;
	$result = mysql_query($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256);
	$row= mysql_fetch_array($result);
	$s_poke = $row["poke"];
	$poke_type=ceil($poke/50);
	$poke_alt=$s_poke . "_" . $poke_a[$s_poke]['p_name'];
	$my_sid_poke[$i]=$s_poke ;
	if($i==$p_games){
		$my_total = $row["total"];
		$my_exper = $row["exper"];
		$my_act = $row["act"];
		$my_poke_type=ceil($poke/50);
		$my_pokes.="<img src=pokemon/$s_poke" . ".gif  alt=$poke_alt width=32 height=32> ";
	}else{
		$my_pokes.="<img src=pokemon/$s_poke" . ".gif  alt=$poke_alt width=20 height=20> ";
	}
}

//���ɸg��ȷU���A�����U�h
$n_sco=ceil($my_act/3);
if($n_sco==0)
	$n_sco=1;

if($n_sco>6)
	$n_sco=6;

//��⪺���ɸ��
for ($i= 1 ; $i <= ($n_games*2-1) ;$i++){
	$sqlstr = "select * from test_score where  s_id='$he_sid[$i]'  " ;
	$result = mysql_query($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256);
	$row= mysql_fetch_array($result);
	$s_poke = $row["poke"];
	$he_sid_poke[$i]=$s_poke ;
	if($i==$p_games){
		$he_total = $row["total"];
		$he_exper = $row["exper"];
		$he_poke_type=ceil($poke/50);
	}
}
// ��o�x��
if($my_games>=$n_games ){
	$badge=$poke=rand(1,151);
	$msg_c="<img src='images/win.gif'><font color=red face=�з��� size=7>���ߧA��o�x���A�~��V�O�a�I</font>";
	$p_sn=intval($p_sn);
	$sql_update = "update test_online set h_who='', g_who=''  where p_sn='$p_sn' "; 	
	mysql_query($sql_update) or die ($sql_update);	
	$sql_insert = "INSERT INTO test_badge (  stud_id , who , badge , type , a_stud_id , a_who , up_date , teacher_sn ) 
			values ('$_SESSION[session_log_id]','$_SESSION[session_who]','$badge','1','$he_stud_id','$he_who','$att_time','$_SESSION[session_tea_sn]')";
	mysql_query($sql_insert) or die ($sql_insert); 
	Header ("Location: test.php?key=�ڪ�����");
}

// �X�۪��A
if( $key=="�ŤM��" or $key=="���Y��" or $key==" �� ��" or $key==" "){	
	switch ($key){
	case '' :
		$my_rou=0;
		break;

	case '�ŤM��' :
		$my_rou=1;
		break;
	case '���Y��' :
		$my_rou=2;
		break;
	case ' �� ��' :
		$my_rou=3;
		break;
	}
	if($who=='h'){
		$sql_update = "update test_online set h_attack='$my_rou',h_blank='$block_ch' ,h_att='1' ,att_time='$att_time' where p_sn='$p_sn' "; 	
	}else{
		$sql_update = "update test_online set g_attack='$my_rou',g_blank='$block_ch' ,g_att='1' ,att_time='$att_time'  where p_sn='$p_sn' "; 	
	}
	mysql_query($sql_update) or die ($sql_update);	
	Header ("Location: $PHP_SELF?p_sn=$p_sn");
}
$cp_name="<font size=6 face=�з��� color=red>$pp_name �԰���</font>";

$s_unit="<form  method='post' action=$PHP_SELF?p_sn=$p_sn >" ;	

$power_msg="<font size=2>(�C�ۻݮ��� $n_sco ���԰��O)</font>";
//$power_msg="<font size=5  color=blue >(���դ��A���p���Z�I)</font>";

$poke_alt=$poke . "_" . $poke_a[$poke]['p_name'];
$poke_gif="<img src=poke_b/$poke" . ".gif  alt=$poke_alt width=130 height=130>";
$rou_a[1]=$poke_a[$poke]['1'];
$rou_a[2]=$poke_a[$poke]['2'];
$rou_a[3]=$poke_a[$poke]['3'] ;	
$r_a[0]='�H';
$r_a[1]='��' ;
$r_a[2]='��';
$r_a[3]=' ��' ;	
if($_SESSION[session_who]=='�ǥ�'){
	$yearc = substr ($_SESSION[session_log_id], 0, 2);
	$img ="photo/student/". $yearc . "/". $_SESSION[session_log_id];
}elseif($_SESSION[session_who]=='�Юv'){
	$img ="photo/teacher/". $_SESSION[session_tea_sn];
}
$img="<img src=$UPLOAD_URL" .$img ." width=130 height=130 alt=$my_name >";  	
$rough_a[1]="<input type='submit' name='key' value='�ŤM��' style='font-size: 16 pt; color: #0000FF; font-family: �з���' title=$rou_a[1]>";
$rough_a[2]="<input type='submit' name='key' value='���Y��' style='font-size: 16 pt; color: #0000FF; font-family: �з���' title=$rou_a[2]>";
$rough_a[3]="<input type='submit' name='key' value=' �� ��' style='font-size: 16 pt; color: #0000FF; font-family: �з���' title=$rou_a[3]>";

//�P�_�ӭt
if($my_att==1 and $he_att==1 ){ 	
	$he_rough=$poke_a[$poke_p][$he_rou].$r_a[$he_rou];	
	$my_rough=$rou_a[$my_rou].$r_a[$my_rou];
	$judge=0;
     	switch ($my_rou){
	case 0:
		switch ($he_rou){
			case 1:$judge=1;break;
			case 2:$judge=1;break;
			case 3:$judge=1;break;
		}break;

	case 1:
		switch ($he_rou){
			case 2:$judge=1;break;
			case 3:$judge=2;break;
			case 0:$judge=2;break;

		}break;
	case 2:
		switch ($he_rou){
			case 1:$judge=2;break;
			case 3:$judge=1;break;
			case 0:$judge=2;break;

		}break;
	case 3:
		switch ($he_rou){
			case 1:$judge=1;break;
			case 2:$judge=2;break;
			case 0:$judge=2;break;
		}break;
      }

	if($judge==1){
		$he_sco++;
		$he_rough ="<font  size=7 face=�з��� color=red>$he_rough </font>";
		$my_rough="<font size=4 color=blue>$my_rough </font>";
	}
	if($judge==2){
		$my_sco++;
		$my_rough="<font  size=7 face=�з��� color=red>$my_rough </font>";
		$he_rough="<font size=4 color=blue>$he_rough </font>";
	}

	if($who=='h'){
		$sql_update = "update test_online set h_win='$my_sco',h_bs='$my_bs' ,g_win='$he_sco',g_bs='$he_bs',h_att='2',g_att='2' ,att_time='$att_time' where p_sn='$p_sn' "; 	
	}elseif($who=='g'){
		$sql_update = "update test_online set g_win='$my_sco',g_bs='$my_bs',h_win='$he_sco',h_bs='$he_bs',h_att='2' ,g_att='2',att_time='$att_time'  where p_sn='$p_sn' "; 
	
	}
	mysql_query($sql_update) or die ($sql_update);	
	//�C�ۦ� $n_sco ��
	$my_total= $my_total - $n_sco ;  
	$sql_update = "update test_score set total='$my_total' ";
	$sql_update .= " where s_id='$my_sid[$p_games]' " ;
	mysql_query($sql_update) or die ($sql_update);
	$he_total= $he_total -  $n_sco ;  
	$sql_update = "update test_score set total='$he_total' ";
	$sql_update .= " where s_id='$he_sid[$p_games]' " ;
	mysql_query($sql_update) or die ($sql_update);
//	Header ("Location: $PHP_SELF?p_sn=$p_sn");
	$my_att=2;
	$he_att=2;


}
//if($my_att=='0' and  $he_att=='0' ){// ���賣���b
//	$err++;
//	$sql_update = "update test_online set err='$err' ,h_att='0',g_att='0' where p_sn='$p_sn' "; 	
//	mysql_query($sql_update) or die ($sql_update);	
//}


$rough="";
if($my_att=='0'){
	for($i=1;$i<=3;$i++){			
		$rough.=$rough_a[$i]."�@";
	}
}
if($my_att=='1' and  $he_att=='0' ){
	$rough="<font size=5  color=blue face=�з���>�е��Թ��X�ۡI</font>";
	if($who=='h'){
		$sql_update = "update test_online set g_att='1'  where p_sn='$p_sn' "; 	
	}else{
		$sql_update = "update test_online set h_att='1'  where p_sn='$p_sn' "; 	
	}
	mysql_query($sql_update) or die ($sql_update);	
	$my_rough=$rou_a[$my_rou].$r_a[$my_rou];
	$content=$content/1 ;
	$he_rough="";
}
//�s�ɫ�P�_
if($my_att=='2' and  $he_att=='2' ){
	$rough="<font color=#FF00FF face=�з��� size=6>��Ĺ5������ӳ�I</font>";
	$act="�~��next";
	$sql_update = "update test_online set att_time='$att_time' ,h_att='0',g_att='0',err='0' where p_sn='$p_sn' "; 	
	mysql_query($sql_update) or die ($sql_update);	
	if($my_sco>=5){	//�Ӥ@��
		$rough="<img src='images/win.gif'><font color=red face=�з��� size=6>���ߧA��ӤF�I</font>";
		$my_exper++; //�����ҥΫ�
		$my_act++; //�����ҥΫ�

		$sql_update = "update test_score set online_date='$att_time' , exper='$my_exper', act='$my_act' ";
		$sql_update .= " where s_id='$my_sid[$p_games]' " ;
		mysql_query($sql_update) or die ($sql_update);
		$my_games++;
		$p_games++;
		if($who=='h'){		
			$sql_update = "update test_online set p_games='$p_games' ,h_games='$my_games', h_win='0' ,g_win='0' ,att_time='$att_time' ,h_att='0',g_att='0' where p_sn='$p_sn' "; 	
		}elseif($who=='g'){
			$sql_update = "update test_online set p_games='$p_games' ,g_games='$my_games', h_win='0' ,g_win='0',att_time='$att_time' ,h_att='0',g_att='0' where p_sn='$p_sn' "; 	
		}
		mysql_query($sql_update) or die ($sql_update);	
		if($my_games < $n_games ){
			if($who=='h'){
				$sql_update = "update test_online set h_sid='$my_sid_poke[$p_games]' ,g_sid='$he_sid_poke[$p_games]'  where p_sn='$p_sn' "; 	
			}else{
				$sql_update = "update test_online set h_sid='$he_sid_poke[$p_games]' ,g_sid='$my_sid_poke[$p_games]'  where p_sn='$p_sn' ";
			}
			mysql_query($sql_update) or die ($sql_update);	
		}
		
		$act="�~��next";
	}
	if($he_sco>=5) {//�Ѥ@��
		$rough="<img src='images/loss.gif'><font color=bule face=�з��� size=6>�ܿ�ѧA��F�I</font>";
		$sql_update = "update test_score set online_date='$att_time' ";
		$sql_update .= " where s_id='$he_sid[$p_games]' " ;
		mysql_query($sql_update) or die ($sql_update);
		$he_games++;
		$p_games++;
		if($who=='h'){		
			$sql_update = "update test_online set p_games='$p_games' , g_games='$he_games',h_win='0' ,g_win='0' ,att_time='$att_time' ,h_att='0',g_att='0' where p_sn='$p_sn' "; 	
		}elseif($who=='g'){
			$sql_update = "update test_online set p_games='$p_games' ,h_games='$he_games' ,h_win='0' ,g_win='0',att_time='$att_time' ,h_att='0',g_att='0' where p_sn='$p_sn' "; 	
		}
		mysql_query($sql_update) or die ($sql_update);	
		if($he_games < $n_games ){
			if($who=='h'){
				$sql_update = "update test_online set h_sid='$my_sid_poke[$p_games]' ,g_sid='$he_sid_poke[$p_games]'  where p_sn='$p_sn' "; 	
			}else{
				$sql_update = "update test_online set h_sid='$he_sid_poke[$p_games]' ,g_sid='$my_sid_poke[$p_games]'  where p_sn='$p_sn' ";
			}
			mysql_query($sql_update) or die ($sql_update);	
		}
		$act="�~��next";
	}
	$rough.="<input type='submit' name='key' value='$act' style='font-size: 16 pt; color: #0000FF; font-family: �з���'>"; 
	$content=$content/1 ;
}
	
	$my_ima="";
	for($i=0;$i<$my_sco;$i++){
		$my_ima.="<img src=poke_b/ball.gif>�@";
	}

		$block_tal=$poke_type+1-$my_block;
		//$block="�i�����赴��(<font color=red>$block_tal</font>)�G";

		//if($my_block<($poke_type*2)){  //�i�����褣��X�Y�өۦ�
		//	for($i=1;$i<=3;$i++){
		//		$block.="<input type='radio' value=$i  name='block_ch'> $r_a[$i] �@";
		//	}
		//	$block.="<input type='radio' value=0  name='block_ch'> ���� �@";
		//}
	
	$s_unit.="<table align='center' border='0' cellpadding='0' cellspacing='0' width='95%' >
			<tr><td rowspan='3' width=300 >$img $poke_gif </td>
			<td height=30> $my_ima </td></tr>
			<tr><td> $rough </td>
			<tr><td> $block </td></tr></table>";
	$s_unit.="<table align='center' border='1' cellpadding='0' cellspacing='0' width='95%' height=100><tr align='center'>
		<td width='8%'><font size=7 color=red>$my_games</font></td><td width='35%'  bgcolor='66CCFF'> $my_rough </td>
		<td width='14%'><font size=7  >vs</font></td><td width='35%'  bgcolor='FFFF66'> $he_rough </td>
		<td width='8%'><font size=7 color=red>$he_games</font></td></tr></table>";

	$poke_alt=$poke_p . "_" . $poke_a[$poke_p]['p_name'];
	$poke_gif="<img src=poke_b/$poke_p" . ".gif  alt=$poke_alt width=130 height=130>";
		
	
	$img="<img src=poke_b/people" . $peo .".jpg alt='$he_name ' width=130 height=130>";  
	
	$he_ima="";
	for($i=0;$i<$he_sco;$i++){
		$he_ima.="<img src=poke_b/ball.gif  align=center >�@";
	}
	$s_unit.="<table align='center' border='0' cellpadding='0' cellspacing='0' width='95%' >
	<tr><td  align='right'>$he_ima  $poke_gif $img </td></tr>";
	$s_unit.="</table>";
	$s_unit.="<input type='hidden' name='paper' value='$paper'>	
	
	</form>"; 

//�԰���������

// �����}�l
?>
<html>
<head>
<title><?=$pp_name .$who ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=big5" >
<meta HTTP-EQUIV="Refresh" CONTENT="<?=$content ?>">

</head>
<body style="border: 10pt #808080 outset" bgcolor="CCFFCC" background="images-a/b<?=$exper?>.gif"  bgproperties="fixed"  
      ONDRAGSTART="window.event.returnValue=false" ONCONTEXTMENU="window.event.returnValue=false"  onSelectStart="event.returnValue=false">
<script language="JavaScript">
<!--

  //if (history.length==0 ) window.location="";  //�T�����J���}    OnLoad="namosw_init_animation()
  if(name!="poke") window.location="";       //�T�����J���}
 
-->
</script>


<?php

$login= "<font size=5 color='9933ff' face=�з���>�V�m�a�G$_SESSION[session_tea_name]</font>";
$power="�԰��O�G<font size=5 color=red> " . $my_total . " </font>".$power_msg ;   //�Y�ɧ�s���Z�@
?>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="95%" >
  <tr>			
   <td width="20%" ><a href=javascript:close() title='�p�G���}�A���ɱN�~��i��A�e�U�q���԰��I' ><font size=5 face=�з���>���}(EXIT)</font></a></td>
    <td width="50%" align="center"><?= $cp_name ?></td>
         <td width="30%" align="center"><font size=2>�@�����C <?= $content  ?>���s�@��</font></td>
</tr></table> 
<table align="center" border="0" cellpadding="0" cellspacing="0" width="95%" >
<tr> 
<td width="25%" align="right" valign="bottom"><?=$login ?></td>
<td width="45%" align="right" valign="bottom"><?=$power ?></td>
<td width="30%" align="right" valign="bottom"><?=$my_pokes ?></td>
</tr></table>
<?=$s_unit ?>
</body>
</html>



