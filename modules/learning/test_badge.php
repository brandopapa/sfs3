<?php
// $Id: test_badge.php 5310 2009-01-10 07:57:56Z hami $
// --�t�γ]�w��
include "config.php"; 
session_start();

//���Юv�i�J
if($_SESSION['session_who']!='�Юv'){
	exit();
}
if (checkid($_SERVER[SCRIPT_FILENAME],1)){
$testadmin="�@<a href=test_admin.php>�B�z�ӶD</a>";
}


//�Ʀ�]
if($key=='group'){

if ($topage !="")
	$page = $topage; 
$page_count=20;
if($order=='')
	$order="sco desc";

$sql_select = "select count(poke) as sco ,a.*  ,b.* ,c.stud_name,c.curr_class_num,c.stud_study_cond from test_score a,unit_u b,stud_base c   ";
$sql_select .= "where poke >0 and who='�ǥ�' and c.stud_study_cond='0' and a.u_id=b.u_id and a.teacher_sn = c.student_sn   ";
if($class=='' and $class1!='')
	$class=$class1;
if($class!='')
	 $sql_select .= " and c.curr_class_num like '$class%' ";
$sql_select .= "group by curr_class_num order by $order  ";

$result = mysql_query ($sql_select,$conID)or die ($sql_select);
$tol_num= mysql_num_rows($result);

if ($tol_num % $page_count > 0 )
	$tolpage = intval($tol_num / $page_count)+1;
else
	$tolpage = intval($tol_num / $page_count);

$s_unit="<form action= $PHP_SELF method=get name=bform>";
$s_unit.="�@�@�@�� <select name=topage  onchange=document.bform.submit()>";
	for ($i= 0 ; $i < $tolpage ;$i++){
		$j=$i+1;
		if ($page == $i){
			$s_unit.=" <option value=$i  selected>$j</option>";
		}else{
			$s_unit.=" <option value=$i >$j</option>";
		}
	}
	$s_unit.="</select>�� /�@ $tolpage ��";
$sql_select .= " limit ".($page * $page_count).", $page_count";
$result = mysql_query ($sql_select,$conID)or die ($sql_select);
$s_unit.="�@<input type='text' name='class' size=10 ><input type='submit' value='�Z�ŦW��' name='B1'>";
$s_unit.="<table border='1' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='95%'  align='center'>";
$s_unit.="<tr <tr  align='center'><td><a href='$PHP_SELF?key=group&order=curr_class_num&class=$class'>�~�Z�y��</a>�@</td><td>�m�W</td><td><a href='$PHP_SELF?key=group&class=$class'>���_�_���ƥ�</a></td></tr>";
while ($row = mysql_fetch_array($result)){
	$stud_id = $row["stud_id"];
	$stud_name = $row["stud_name"];
	$curr_class_num=$row["curr_class_num"];
	$poke = $row["poke"];
	$sco=$row["sco"];
	$exper = $row["exper"];
	$total = $row["total"];
	$up_date = $row["up_date"];
	$unit= $row["unit_m"]. $row["unit_t"]. $row["u_s"];
//	$unit_name= $row["unit_name"];
	$poke_type=ceil($poke/50);
	if($group='curr_class_num'){
		$s_unit.="<tr  align='center'><td><a href='$PHP_SELF?key=view&stud_id=$stud_id'>$curr_class_num </a></td><td> $stud_name </td><td> $sco </td></tr>";
	}
}
$s_unit.="</table>
<input type='hidden' name='key' value='$key'>
<input type='hidden' name='order' value='$order'>
<input type='hidden' name='class1' value='$class'>
</form>";
}

//�V�m�a
if($key=='stud'){

if ($topage !="")
	$page = $topage; 
$page_count=20;

if($order=='')
	$order="up_date desc";

$sql_select = "select  a.* ,b.unit_m,b.unit_t,b.u_s,b.unit_name ,c.stud_name,c.curr_class_num,c.stud_study_cond from test_score a,unit_u b,stud_base c where ";
$sql_select .= "  poke >0 and who='�ǥ�' and c.stud_study_cond='0'  ";   
$sql_select .= " and a.u_id=b.u_id and a.teacher_sn = c.student_sn order by $order"; 

$result = mysql_query ($sql_select,$conID)or die ($sql_select);
$tol_num= mysql_num_rows($result);

if ($tol_num % $page_count > 0 )
	$tolpage = intval($tol_num / $page_count)+1;
else
	$tolpage = intval($tol_num / $page_count);

$s_unit="<form action= $PHP_SELF method=get name=bform>";
$s_unit.="�@�@�@�� <select name=topage  onchange=document.bform.submit()>";
	for ($i= 0 ; $i < $tolpage ;$i++){
		$j=$i+1;
		if ($page == $i){
			$s_unit.=" <option value=$i  selected>$j</option>";
		}else{
			$s_unit.=" <option value=$i >$j</option>";
		}
	}
		$s_unit.="</select>�� /�@ $tolpage ��";
	
$sql_select .= " limit ".($page * $page_count).", $page_count";
$result = mysql_query ($sql_select,$conID)or die ($sql_select);
$s_unit.="<table border='1' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='95%'  align='center'>";
$s_unit.="<tr <tr  align='center'><td><a href='$PHP_SELF?key=stud&order=curr_class_num'>�~�Z�y��</a></td><td>�m�W</td><td>�ҵ{</td><td>���_�_������(�s��)</td><td>�g���</td><td>�԰��O</td><td><a href='$PHP_SELF?key=stud'>�̷s�V�m�ɶ�</a></td></tr>";

while ($row = mysql_fetch_array($result)){
	$stud_id = $row["stud_id"];
	$stud_name = $row["stud_name"];
	$curr_class_num=$row["curr_class_num"];
	$poke = $row["poke"];
	$exper = $row["exper"];
	$total = $row["total"];
	$up_date = $row["up_date"];
	$unit= $row["unit_m"]. $row["unit_t"]. $row["u_s"];
	$poke_type=ceil($poke/50);
	$s_unit.="<tr  align='center'><td><a href='$PHP_SELF?key=view&stud_id=$stud_id'>$curr_class_num </a></td><td> $stud_name </td><td > $unit </td><td> $poke_type ($poke) </td><td>$exper </td><td>$total </td><td>$up_date </td></tr>";
}
$s_unit.="</table>
<input type='hidden' name='key' value='$key'>
<input type='hidden' name='order' value='$order'>
</form>";
}

//�ҵ{
if($key=='unit'){

if ($topage !="")
	$page = $topage; 
$page_count=20;
if($order=='')
	$order="sco desc";

$sql_select = "select count(poke) as sco ,a.*  ,b.* ,c.stud_name,c.curr_class_num,c.stud_study_cond from test_score a,unit_u b,stud_base c   ";
$sql_select .= "where poke >0 and who='�ǥ�' and c.stud_study_cond='0' and a.u_id=b.u_id and a.teacher_sn = c.student_sn   ";
$sql_select .= "group by a.u_id order by $order  ";

$result = mysql_query ($sql_select,$conID)or die ($sql_select);
$tol_num= mysql_num_rows($result);

if ($tol_num % $page_count > 0 )
	$tolpage = intval($tol_num / $page_count)+1;
else
	$tolpage = intval($tol_num / $page_count);

$s_unit="<form action= $PHP_SELF method=get name=bform>";
$s_unit.="�@�@�@�� <select name=topage  onchange=document.bform.submit()>";
	for ($i= 0 ; $i < $tolpage ;$i++){
		$j=$i+1;
		if ($page == $i){
			$s_unit.=" <option value=$i  selected>$j</option>";
		}else{
			$s_unit.=" <option value=$i >$j</option>";
		}
	}
	$s_unit.="</select>�� /�@ $tolpage ��";
$sql_select .= " limit ".($page * $page_count).", $page_count";
$result = mysql_query ($sql_select,$conID)or die ($sql_select);
$s_unit.="<table border='1' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='95%'  align='center'>";
$s_unit.="<tr <tr  align='center'><td><a href='$PHP_SELF?key=unit&order=unit_t,unit_m,u_s'>�ҵ{�s��</a></td><td>�W��</td><td><a href='$PHP_SELF?key=unit'>�q�L�H��</a></td></tr>";
while ($row = mysql_fetch_array($result)){
	$stud_name = $row["stud_name"];
	$u_id = $row["u_id"];
	$curr_class_num=$row["curr_class_num"];
	$poke = $row["poke"];
	$sco=$row["sco"];
	$exper = $row["exper"];
	$total = $row["total"];
	$up_date = $row["up_date"];
	$unit= $row["unit_m"]. $row["unit_t"]. $row["u_s"];
	$unit_name= $row["unit_name"];
	$poke_type=ceil($poke/50);
	if($group='curr_class_num'){
		$s_unit.="<tr  align='center'><td><a href='$PHP_SELF?key=u_id&u_id=$u_id'>$unit </a></td><td align='left'> $unit_name </td><td> $sco </td></tr>";
	}
}
$s_unit.="</table>
<input type='hidden' name='key' value='$key'>
<input type='hidden' name='order' value='$order'>
</form>";
}

//�V�m�a�ӤH���Z
if($key=='view'){
if ($topage !="")
	$page = $topage; 
$page_count=20;
if($stud_clnu!=''){
	$query = "select stud_id from stud_base where curr_class_num ='$stud_clnu' and  stud_study_cond='0'";
	$result	= mysql_query($query);
	$row = mysql_fetch_array($result);
	$stud_id=$row["stud_id"];
	
}
if($stud_ch!=''){
	$stud_id=$stud_ch;
}

if($order=='')
	$order="up_date desc";
if($stud_id==''){
	$stud_id='12345';
}


$sql_select = "select  a.* ,b.unit_m,b.unit_t,b.u_s,b.unit_name ,c.stud_name,c.curr_class_num,c.stud_study_cond from test_score a,unit_u b,stud_base c where ";
$sql_select .= "  poke >0 and who='�ǥ�' and c.stud_study_cond='0'  and a.stud_id=$stud_id ";   
$sql_select .= " and a.u_id=b.u_id and a.teacher_sn = c.student_sn order by $order"; 
$result = mysql_query ($sql_select,$conID)or die ($sql_select);
$tol_num= mysql_num_rows($result);

if ($tol_num % $page_count > 0 )
	$tolpage = intval($tol_num / $page_count)+1;
else
	$tolpage = intval($tol_num / $page_count);

$s_unit="<form action= $PHP_SELF method=get name=bform>";
$s_unit.="�@�@�@�� <select name=topage  onchange=document.bform.submit()>";
	for ($i= 0 ; $i < $tolpage ;$i++){
		$j=$i+1;
		if ($page == $i){
			$s_unit.=" <option value=$i  selected>$j</option>";
		}else{
			$s_unit.=" <option value=$i >$j</option>";
		}
	}
		$s_unit.="</select>�� /�@ $tolpage ��";
	$s_unit.="�@�~�Z�y���G<input type='text' name='stud_clnu' size=10 >�@�Ǹ��G<input type='text' name='stud_ch' size=10 ><input type='submit' value='�d��' name='B1'>";

$sql_select .= " limit ".($page * $page_count).", $page_count";
$result = mysql_query ($sql_select,$conID)or die ($sql_select);
$s_unit.="<table border='1' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='95%'  align='center'>";
$s_unit.="<tr <tr  align='center'><td>�~�Z�y��</td><td>�m�W</td><td><a href='$PHP_SELF?key=view&order=unit_t,unit_m,u_s&stud_id=$stud_id'>�ҵ{</a></td><td>���_�_������(�s��)</td><td>�g���</td><td>�԰��O</td><td><a href='$PHP_SELF?key=view&stud_id=$stud_id'>�̷s�V�m�ɶ�</a></td></tr>";

while ($row = mysql_fetch_array($result)){
	$stud_name = $row["stud_name"];
	$u_id = $row["u_id"];
	$curr_class_num=$row["curr_class_num"];
	$poke = $row["poke"];
	$exper = $row["exper"];
	$total = $row["total"];
	$up_date = $row["up_date"];
	$unit= $row["unit_m"]. $row["unit_t"]. $row["u_s"];
	$poke_type=ceil($poke/50);
	$s_unit.="<tr  align='center'><td>$curr_class_num </td><td> $stud_name </td><td ><a href='$PHP_SELF?key=u_id&u_id=$u_id'>$unit </a></td><td> $poke_type ($poke) </td><td>$exper </td><td>$total </td><td>$up_date </td></tr>";
}
$s_unit.="</table>
<input type='hidden' name='stud_id' value='$stud_id'>
<input type='hidden' name='key' value='$key'>
<input type='hidden' name='order' value='$order'>
</form>";
}
//�ҵ{�ӤH���Z
if($key=='u_id'){

if ($topage !="")
	$page = $topage; 
$page_count=20;

if($order=='')
	$order="up_date desc";

$sql_select = "select  a.* ,b.unit_m,b.unit_t,b.u_s,b.unit_name ,c.stud_name,c.curr_class_num,c.stud_study_cond from test_score a,unit_u b,stud_base c where ";
$sql_select .= "  poke >0 and who='�ǥ�' and c.stud_study_cond='0'  and a.u_id=$u_id ";   
$sql_select .= " and a.u_id=b.u_id and a.teacher_sn = c.student_sn order by $order"; 
$result = mysql_query ($sql_select,$conID)or die ($sql_select);
$tol_num= mysql_num_rows($result);

if ($tol_num % $page_count > 0 )
	$tolpage = intval($tol_num / $page_count)+1;
else
	$tolpage = intval($tol_num / $page_count);

$s_unit="<form action= $PHP_SELF method=get name=bform>";
$s_unit.="�@�@�@�� <select name=topage  onchange=document.bform.submit()>";
	for ($i= 0 ; $i < $tolpage ;$i++){
		$j=$i+1;
		if ($page == $i){
			$s_unit.=" <option value=$i  selected>$j</option>";
		}else{
			$s_unit.=" <option value=$i >$j</option>";
		}
	}
		$s_unit.="</select>�� /�@ $tolpage ��";
	
$sql_select .= " limit ".($page * $page_count).", $page_count";
$result = mysql_query ($sql_select,$conID)or die ($sql_select);
$s_unit.="<table border='1' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='95%'  align='center'>";
$s_unit.="<tr <tr  align='center'><td><a href='$PHP_SELF?key=u_id&order=curr_class_num&u_id=$u_id'>�~�Z�y��</a></td><td>�m�W</td><td>�ҵ{</td><td>���_�_������(�s��)</td><td>�g���</td><td>�԰��O</td><td><a href='$PHP_SELF?key=u_id&u_id=$u_id'>�̷s�V�m�ɶ�</a></td></tr>";

while ($row = mysql_fetch_array($result)){
	$stud_name = $row["stud_name"];
	$stud_id = $row["stud_id"];
	$curr_class_num=$row["curr_class_num"];
	$poke = $row["poke"];
	$exper = $row["exper"];
	$total = $row["total"];
	$up_date = $row["up_date"];
	$unit= $row["unit_m"]. $row["unit_t"]. $row["u_s"];
	$poke_type=ceil($poke/50);
	$s_unit.="<tr  align='center'><td><a href='$PHP_SELF?key=view&stud_id=$stud_id'>$curr_class_num </a> </td><td> $stud_name </td><td > $unit </td><td> $poke_type ($poke) </td><td>$exper </td><td>$total </td><td>$up_date </td></tr>";
}
$s_unit.="</table>
<input type='hidden' name='u_id' value='$u_id'>
<input type='hidden' name='key' value='$key'>
<input type='hidden' name='order' value='$order'>
</form>";
}

// �����}�l
include "header_u.php";
?>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="95%" >
  <tr>
    <td  ><a href="index.php?m=<?=$m ?>&t=<?=$t ?>">�^�ؿ�</a>�@
		<a href="<?=$PHP_SELF?>?key=stud">�V�m�a�W��</a>�@
		<a href="<?=$PHP_SELF?>?key=group">�V�m�a�Ʀ�</a>�@
		<a href="<?=$PHP_SELF?>?key=unit">�ҵ{�Ʀ�</a>
		<?=$testadmin?>�@
 </td>
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

