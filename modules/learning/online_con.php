<?php
// $Id: online_con.php 5310 2009-01-10 07:57:56Z hami $
// --�t�γ]�w��
include "config.php"; 
session_start();
if($_SESSION[session_log_id]==""){
	
	$go_back=1; //�^��ۤw���{�ҵe��  
		include "header.php";
	include $SFS_PATH."/rlogin.php";  
	exit;
}

	$sqlstr = "select * from test_setup " ;
	$result = mysql_query($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256);
	$row= mysql_fetch_array($result);
	$match = $row["mat"] ;    //�v�ɤ�
 	$open = $row["open"] ;  	//�}�񪺹D�]
	$n_games = $row["n_games"] ;  //�H�h�֨M�w�ӭt
	$content = $row["content"] ;  //�C�j��s���
	$unit_m= $row["unit"] ;  //������



$s_title= "�צ椧��"; 
if($match==1){
	$s_title= "�p���j�|����"; 
}
$att_time = mysql_date();
if ($_SESSION[session_log_id] != ""){
	$login= "�w�� $_SESSION[session_tea_name] �n�J! </td>";
}	
$c_title= "<font size=6 face=�з��� color=#800000><b>$s_title</b> </font>";	

if($key=='����'){
	$sql_update = "update test_online set h_who='' ,h_stud_id='',h_sid=0,h_sid1=0,h_sid2=0,h_sid3=0,h_sid4=0,h_sid5=0 ,h_name='',p_games='0'   where p_sn='$p_sn' "; 	
	mysql_query($sql_update) or die ($sql_update);	
	Header ("Location: online_con.php");
	
}

if($key=='���]�D'){
	//�ˬd�O�_���]�D
	$sqlstr = "select * from test_online where p_sn='$p_sn' " ;
	$result = mysql_query($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256);
	$row= mysql_fetch_array($result);
 	$h_who = $row["h_who"] ;  
	if($h_who==''){

	$h_name="�p" . substr($_SESSION[session_tea_name],2,2);
	$h_who=$_SESSION['session_who'] ;
	$h_stud_id=$_SESSION['session_log_id'];
	//�ˬd�O�_�w�n��
	$sqlstr = "select * from test_online where  (h_stud_id='$h_stud_id' and h_who='$h_who')  or  (g_stud_id='$h_stud_id' and g_who='$h_who') " ;
	$result = mysql_query($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256);
	$row= mysql_fetch_array($result);
 	$pp_sn = $row["p_sn"] ;  
	// ���n��
	if($pp_sn ==''){  
	// ���
		$today=date("Y-m-d");	
		$unit_t=stud_ye($h_stud_id)-1;
		$cond=" and online_date !='$today' ";
		if($unit_m!='')
				$cond.=" and  unit_m='$unit_m' ";
		if($unit_t!='')
				$cond.=" and  unit_t>'$unit_t' ";

		$sqlstr = "select a.*,b.unit_m,b.unit_t  from test_score a,unit_u b WHERE  a.u_id=b.u_id and  teacher_sn= '$_SESSION[session_tea_sn]'  and who='$_SESSION[session_who]' and poke>0 and a.total>=100 $cond order by total desc" ;
		//$sqlstr = "select a.*,b.unit_m,b.unit_t  from test_score a,unit_u b WHERE  a.u_id=b.u_id and stud_id= '$stud_id'  and who='$who' and poke>0 and a.total>=100 $cond  order by total desc" ;

		$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
		$i=0;
		while ($row = $result->FetchRow() ) {    	
			$i++;
			if($i==1)
				$sid= $row["poke"];
			$a_sid[$i]= $row["s_id"] ;	
		}
		if($i>=($n_games*2-1)){
			$sql_update = "update test_online set h_who='$h_who' ,h_stud_id='$h_stud_id',h_sid='$sid',h_sid1='$a_sid[1]',h_sid2='$a_sid[2]',h_sid3='$a_sid[3]',h_sid4='$a_sid[4]',h_sid5='$a_sid[5]' ,h_name='$h_name',p_games='1',h_games='0',h_win='0' ,att_time='$att_time',h_attack='1'   where p_sn='$p_sn' "; 	
			mysql_query($sql_update) or die ($sql_update);	
		}else{
			$pk=$n_games*2-1;
			$msg="�A�S�� $pk ���H�W�i�԰������_�_���I(�ثe�u�� $i ��)";
			?>			
			<script language="JavaScript">
				alert("<?=$msg ?>")	
			</script>
			<?
		}	
	}
	}
	Header ("Location: online_con.php");
	
}
if($key=='�D�ԥh'){
	//�ˬd�O�_���]�D
	$sqlstr = "select * from test_online where p_sn='$p_sn'" ;
	$result = mysql_query($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256);
	$row= mysql_fetch_array($result);
 	$h_who = $row["h_who"] ;  
	if($h_who!=''){

	$h_name="�p" . substr($_SESSION[session_tea_name],2,2);
	$h_who=$_SESSION['session_who'] ;
	$h_stud_id=$_SESSION['session_log_id'];

	//�ˬd�O�_�w�n��
	$sqlstr = "select * from test_online where  (h_stud_id='$h_stud_id' and h_who='$h_who')  or  (g_stud_id='$h_stud_id' and g_who='$h_who') " ;
	$result = mysql_query($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256);
	$row= mysql_fetch_array($result);
 	$pp_sn = $row["p_sn"] ;  
	// ���n��
	if($pp_sn ==''){  
	// ���
		$today=date("Y-m-d");	
		$unit_t=stud_ye($h_stud_id)-1;
		$cond=" and online_date !='$today' ";
		if($unit_m!='')
				$cond.=" and  unit_m='$unit_m' ";
		if($unit_t!='')
				$cond.=" and  unit_t>'$unit_t' ";

		$sqlstr = "select a.*,b.unit_m,b.unit_t  from test_score a,unit_u b WHERE  a.u_id=b.u_id and   teacher_sn= '$_SESSION[session_tea_sn]'  and who='$_SESSION[session_who]' and poke>0 and a.total>=100 $cond order by total desc" ;

		$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
		$i=0;
		while ($row = $result->FetchRow() ) {    	
			$i++;
			if($i==1)
				$sid= $row["poke"];
			$a_sid[$i]= $row["s_id"] ;	
		}
		if($i>=($n_games*2-1)){
			$sql_update = "update test_online set g_who='$h_who' ,g_stud_id='$h_stud_id',g_sid='$sid',g_sid1='$a_sid[1]',g_sid2='$a_sid[2]',g_sid3='$a_sid[3]',g_sid4='$a_sid[4]',g_sid5='$a_sid[5]' ,g_name='$h_name',g_games='0' ,g_win='0',att_time='$att_time',g_attack='1'   where p_sn='$p_sn' "; 	
			mysql_query($sql_update) or die ($sql_update);	
		}else{
			$pk=$n_games*2-1;
			$msg="�A�S�� $pk ���H�W�i�԰������_�_���I(�ثe�u�� $i ��)";
			?>			
			<script language="JavaScript">
				alert("<?=$msg ?>")	
			</script>
			<?
		}	
	}
	}
	Header ("Location: online_con.php");

}

//���o���_�_�����
$sqlstr = "select * from poke_base   " ;
$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
$i=1;
while ($row = $result->FetchRow() ) { 
	//$p_sn = $row["p_sn"] ;	
	$p_name = $row["p_name"] ; 
	$poke_a[$i]['p_name']=$p_name ;
	$poke_a[$i]['1']=$row["p_s1"] ;
	$poke_a[$i]['2']=$row["p_s2"] ; 
	$poke_a[$i]['3']=$row["p_s3"] ; 

	$i++;
}
	$r_a[0]='�H' ;
	$r_a[1]='��' ;
	$r_a[2]='��';
	$r_a[3]=' ��' ;	

//���o�U�D�]���
$sqlstr = "select * from test_online where  p_sn <= $open  " ;
$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
$status="";

while ($row = $result->FetchRow() ) {    
	$p_sn = $row["p_sn"] ;   
	$h_who=$row["h_who"] ; 
	$g_who=$row["g_who"] ; 
	$h_stud_id=$row["h_stud_id"] ; 
	$g_stud_id=$row["g_stud_id"] ; 

	if($h_stud_id!='' and $g_stud_id!=''){ 
		if(($_SESSION[session_log_id]==$h_stud_id  and  $_SESSION['session_who']==$h_who) or ($_SESSION[session_log_id]==$g_stud_id  and  $_SESSION['session_who']==$g_who) ){ // ���H
			Header ("Location: online_act.php?p_sn=$p_sn");
		}
	}
	if($_SESSION[session_log_id]==$h_stud_id  and  $_SESSION['session_who']==$h_who and $g_stud_id=='' ){
		$status="�]�D";
	}
}
//���o�U�D�]���
$sqlstr = "select * from test_online where  p_sn <= $open  " ;
$result =$CONN->Execute($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256) ;
$s_unit.="<table align='center'  border='0' cellpadding='3' cellspacing='3' width='100%' >";
$s_unit.="<tr>";
$t=0;	
$now_time = mysql_date();


while ($row = $result->FetchRow() ) {    
	$t++;		
    	$p_sn = $row["p_sn"] ;   
    	$p_name = $row["p_name"] ;  
	$att_time=$row["att_time"] ; 
	$sec=strtotime ($now_time)-strtotime ($att_time);
	if($att_time!='0000-00-00 00:00:00' and $sec>120){
		$sql_update = "update test_online set h_who='' ,h_stud_id='',h_sid=0,h_sid1=0,h_sid2=0,h_sid3=0,h_sid4=0,h_sid5=0 ,h_name='',p_games='0' ,g_who='' ,g_stud_id='',g_sid=0,g_sid1=0,g_sid2=0,g_sid3=0,g_sid4=0,g_sid5=0 ,g_name='',att_time='0000-00-00 00:00:00' ,h_att='0',h_games='0',h_win='0',h_attack='0'   ,g_att='0',g_games='0',g_win='0',g_attack='0' ,err='0' where p_sn='$p_sn' "; 	
		mysql_query($sql_update) or die ($sql_update);	
	}
	$h_peo=$row["h_peo"] ; 
	$h_games=$row["h_games"] ; 
	$h_win=$row["h_win"] ; 
	$h_who=$row["h_who"] ; 
	$h_sid=$row["h_sid"] ; 
	$h_attack=$row["h_attack"] ; 
	$h_name=$row["h_name"] ; 
	$h_stud_id=$row["h_stud_id"] ; 


	$g_peo=$row["g_peo"] ; 
	$g_games=$row["g_games"] ; 
	$g_win=$row["g_win"] ; 
	$g_who=$row["g_who"] ; 
	$g_sid=$row["g_sid"] ; 
	$g_attack=$row["g_attack"] ; 
	$g_name=$row["g_name"] ; 
	$g_stud_id=$row["g_stud_id"] ; 
	if($_SESSION[session_who]=='�Юv'){
		$h_name=$h_name ."_" . $h_stud_id;
		$g_name=$g_name ."_" . $g_stud_id;
	}
 	if($match==0){
		$ch_peo="<a href=$PHP_SELF?key=���]�D&p_sn=$p_sn>���]�D</a>";
	}
	if($status=="�]�D"){
		$ch_peo="";
	}

	$cg_peo="";
	$ch_sid="";
	$cg_sid="";
	$ch_games="";
	$cg_games="";
	$ch_win="";
	$cg_win="";
	$ch_attack="";
	$cg_attack="";
	$bgcolor='99FFcc';
	$cp_name="<font size=5 face=�з��� >$p_name</font>";
	 // ��Ԥ�
	if($h_stud_id!='' and $g_stud_id!=''){ 
		$ch_peo="<img src=poke_b/speople" . $h_peo .".jpg alt='$h_name' width=32 height=32>";
		$cg_peo="<img src=poke_b/speople" . $g_peo .".jpg alt='$g_name' width=32 height=32>";
		$poke_alt=$h_sid . "_" . $poke_a[$h_sid]['p_name'];
		$ch_sid="<img src=pokemon/$h_sid" . ".gif  alt=$poke_alt >" ;
		$poke_alt=$g_sid . "_" . $poke_a[$g_sid]['p_name'];
		$cg_sid="<img src=pokemon/$g_sid" . ".gif  alt=$poke_alt >" ;
		$ch_games="<font size=5  color=blue><b>$h_games</b></font>";
		$cg_games="<font size=5  color=blue><b>$g_games</b></font>";
		for($i=0;$i<$h_win;$i++){
			$ch_win.="<img src=poke_b/ball.gif width=12 height=12> ";
		}
		for($i=0;$i<$g_win;$i++){
			$cg_win.="<img src=poke_b/ball.gif width=12 height=12> ";
		}
		$ch_attack="<font size=5 face=�з��� color=red><b>$r_a[$h_attack]</b></font>";
		$cg_attack="<font size=5 face=�з��� color=red><b>$r_a[$g_attack]</b></font>";
		$bgcolor='FF99ff';
		
	}
	 //���ݬD��
	if($h_stud_id!='' and $g_stud_id=='' and $match==0){
		$ch_peo="<img src=poke_b/speople" . $h_peo .".jpg alt='$h_name' width=32 height=32>";
		$cg_peo="<a href=$PHP_SELF?key=�D�ԥh&p_sn=$p_sn>�D�ԥh</a>";
		if($status=="�]�D")
			$cg_peo="";

		$poke_alt=$h_sid . "_" . $poke_a[$h_sid]['p_name'];
		// $ch_sid="<img src=pokemon/$h_sid" . ".gif  alt=$poke_alt >" ;
		$bgcolor='FFFF66';
		if($_SESSION[session_log_id]==$h_stud_id  and  $_SESSION['session_who']==$h_who  and $match==0){ // ���H
			$ch_peo="�]�D";
			$ch_games="$_SESSION[session_tea_name]";
			$cg_peo="<a href=$PHP_SELF?key=����&p_sn=$p_sn>����</a>";
			$bgcolor='FF5566';
		}
	}
	//�ۤv���
	if($h_who==$g_who and $h_stud_id==$g_stud_id){
		$sql_update = "update test_online set h_who='' ,h_stud_id='',h_sid=0,h_sid1=0,h_sid2=0,h_sid3=0,h_sid4=0,h_sid5=0 ,h_name='',p_games='0' ,g_who='' ,g_stud_id='',g_sid=0,g_sid1=0,g_sid2=0,g_sid3=0,g_sid4=0,g_sid5=0 ,g_name='',att_time='0000-00-00 00:00:00' ,h_att='0',h_games='0',h_win='0',h_attack='0'   ,g_att='0',g_games='0',g_win='0',g_attack='0' ,err='0' where p_sn='$p_sn' "; 	
		mysql_query($sql_update) or die ($sql_update);	
	}


 	
	$s_unit.="<td width='25%'  align='center' valign='top' bgcolor=$bgcolor >
		<table border='1' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='98%' >
  		<tr><td width='100%' height='32'colspan='2' align='center'>$cp_name</td></tr>
  		<tr><td width='50%' height='32'align='center'>$ch_peo</td>
    		<td width='50%' height='32' align='center'>$cg_peo</td></tr>
  		<tr><td width='50%' height='32' align='center'>$ch_games</td>
		<td width='50%' height='32' align='center'>$cg_games</td></tr>
 		<tr><td width='50%' height='32' align='center'>$ch_sid</td>
		<td width='50%' height='32' align='center'>$cg_sid</td></tr>
  		<tr><td width='50%' height='32' align='center'>$ch_win</td>
		<td width='50%' height='32' align='center'>$cg_win</td></tr> 
  		<tr><td width='50%' height='32' align='center'>$ch_attack</td>
		<td width='50%' height='32' align='center'>$cg_attack</td></tr>
		</table></td>";
	if($t==4){
		$s_unit.="</tr><tr>"; 
		$t=0;
	}
}
$s_unit.="</tr></table>"; 


// onSelectStart="event.returnValue=false" �T����

// �����}�l
?>
<html>
<head>
<title><?=$s_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=big5" >
<meta HTTP-EQUIV="Refresh" CONTENT="<?=$content ?>">
</head>
<body style="border: 10pt #808080 outset" bgcolor="CCFFCC"   bgproperties="fixed"  
      ONDRAGSTART="window.event.returnValue=false" ONCONTEXTMENU="window.event.returnValue=false" onSelectStart="event.returnValue=false" >
<script language="JavaScript">
<!--

  //if (history.length==0 ) window.location="";  //�T�����J���}    OnLoad="namosw_init_animation()
  if(name!="poke") window.location="";       //�T�����J���}
 
-->
</script>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="95%" >
  <tr>			
    <td width="35%" ><a href=javascript:close()><font size=5 face=�з���>���}(EXIT)</font></a>�@
	<a href='test.php?key=�ڪ����_�_��' title='���ɯ��_�_������G
1.�ݸӾǦ~�ΤW�@�Ǧ~�ҵ{�Ҧ��A�����_�_���C
2.�԰��O�n�b100�H�W�C
3.Ĺ�L�@����A��ѴN����A�X�ɡC'  >�ڪ����_�_��</a></td>
    <td width="45%" align="center"><?= $c_title ?><font size=2>�@�����C <?= $content  ?> ���s�@��</font></td>
         <td width="20%" align="center"><?= $login ?></td>
</tr></table>
<?=$s_unit ?>
</body>
</html>


</body>
</html>
