<?php
// $Id: test_score.php 8705 2015-12-29 03:03:33Z qfon $
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


//�����Ʀ�]
if($key=='b_group'){

if ($topage !="")
	$page = $topage; 
$page_count=20;
if($order=='')
	$order="sco desc";

$sql_select = "select count(badge) as sco ,a.*   ,c.stud_name,c.curr_class_num,c.stud_study_cond from test_badge a,stud_base c  where  ";
$sql_select .= "  badge >0 and who='�ǥ�' and c.stud_study_cond='0'   and a.teacher_sn = c.student_sn ";   
if($class!='')
    {
	 $class=intval($class);	
	 $sql_select .= " and c.curr_class_num like '$class%' ";
	}
if($e_date!='')
    {
	 
	 $sql_select .= " and a.up_date >'$e_date' ";
	}
	 
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
$s_unit.="�@<input type='text' name='class' size=10 value='$class'><input type='submit' value='�Z�ŦW��' name='B1'>�@<input type='text' name='e_date' size=10 value='$e_date'><input type='submit' value='�_����' name='B1'>";
$s_unit.="<table border='1' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='95%'  align='center'>";
$s_unit.="<tr <tr  align='center'><td><a href='$PHP_SELF?key=b_group&order=curr_class_num&class=$class&e_date=$e_date'>�~�Z�y��</a>�@</td><td>�m�W</td><td><a href='$PHP_SELF?key=b_group&class=$class&e_date=$e_date'>�����ƥ�</a></td></tr>";
while ($row = mysql_fetch_array($result)){
	$stud_id = $row["stud_id"];
	$stud_name = $row["stud_name"];
	$curr_class_num=$row["curr_class_num"];
	$dabge = $row["badge"];
	$sco=$row["sco"];
	if($group='curr_class_num'){
		$s_unit.="<tr  align='center'><td><a href='$PHP_SELF?key=badge&stud_id=$stud_id'>$curr_class_num </a></td><td> $stud_name </td><td> $sco </td></tr>";
	}
}
$s_unit.="</table>
<input type='hidden' name='key' value='$key'>
<input type='hidden' name='order' value='$order'>
</form>";
}

//�̷s����
if($key=='badge'){

if ($topage !="")
	$page = $topage; 
$page_count=20;

if($order=='')
	$order="up_date desc";

if($stud_clnu!=''){
	$stud_clnu=intval($stud_clnu);
	$query = "select stud_id from stud_base where curr_class_num ='$stud_clnu' and  stud_study_cond='0'";
	$result	= mysql_query($query);
	$row = mysql_fetch_array($result);
	$stud_id=$row["stud_id"];
	
}

$sql_select = "select  a.* ,c.stud_name,c.curr_class_num,c.stud_study_cond from test_badge a,stud_base c where ";
$sql_select .= "  badge >0 and who='�ǥ�' and c.stud_study_cond='0' and a.teacher_sn = c.student_sn  ";   

if($stud_id!='')
{
	$stud_id=substr($stud_id,0,7);
	$sql_select .= " and a.stud_id = '$stud_id' ";
}

$sql_select .= "  order by $order"; 

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
$s_unit.="�@�~�Z�y���G<input type='text' name='stud_clnu' size=10 value='$stud_clnu'>�@�Ǹ��G<input type='text' name='stud_id' size=10 value='$stud_id'><input type='submit' value='�d��' name='B1'>";
$s_unit.="<table border='1' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='95%'  align='center'>";
$s_unit.="<tr  align='center'><td><a href='$PHP_SELF?key=badge&order=curr_class_num'>�~�Z�y��</a></td><td>�m�W</td><td>����</td><td><a href='$PHP_SELF?key=badge&order=a_stud_id&stud_id=$stud_id'>���</a></td><td><a href='$PHP_SELF?key=badge&stud_id=$stud_id'>�ɶ�</a></td></tr>";

while ($row = mysql_fetch_array($result)){
	$stud_id = $row["stud_id"];
	$stud_name = $row["stud_name"];
	$curr_class_num=$row["curr_class_num"];
	$badge = $row["badge"];
	$a_stud_id = $row["a_stud_id"];
	$up_date = $row["up_date"];
	$s_unit.="<tr  align='center'><td><a href='$PHP_SELF?key=badge&stud_id=$stud_id'>$curr_class_num </a></td><td> $stud_name </td><td > $badge </td><td> $a_stud_id </td><td>$up_date </td></tr>";
}
$s_unit.="</table>
<input type='hidden' name='key' value='$key'>
<input type='hidden' name='order' value='$order'>
</form>";
}



//�̷R�Ʀ�]
if($key=='poke'){

if ($topage !="")
	$page = $topage; 
$page_count=20;
if($order=='')
	$order="sco desc";

$sql_select = "select count(s_id) as sco ,a.*  ,b.* ,c.stud_name,c.curr_class_num,c.stud_study_cond from test_score a,poke_base b,stud_base c   ";
$sql_select .= "where poke >0 and who='�ǥ�' and c.stud_study_cond='0' and a.poke=b.p_id and a.teacher_sn = c.student_sn   ";
$sql_select .= "group by poke order by $order  ";
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
$s_unit.="<tr <tr  align='center'><td><a href='$PHP_SELF?key=poke&order=p_sn'>���_�_���s��</a>�@</td><td>���_�_���W��</td><td><a href='$PHP_SELF?key=poke'>���ƶq</a></td></tr>";
while ($row = mysql_fetch_array($result)){
	$poke = $row["poke"];
	$sco=$row["sco"];
	$exper = $row["exper"];
	$total = $row["total"];
	$up_date = $row["up_date"];
	$p_name= $row["p_name"];
	$poke_type=ceil($poke/50);
	$s_unit.="<tr  align='center'><td>$poke</td><td> $p_name </td><td> $sco </td></tr>";

}
$s_unit.="</table>
<input type='hidden' name='key' value='$key'>
<input type='hidden' name='order' value='$order'>
</form>";
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
if($class!='')
 {	 
 $class=intval($class);
 $sql_select .= " and c.curr_class_num like '$class%' ";
 }
if($e_date=='' and $e_date1!='')
	$e_date=$e_date1;

if($e_date!='')
	 $sql_select .= " and a.up_date >'$e_date' ";

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
$s_unit.="�@<input type='text' name='class' size=10 value='$class'><input type='submit' value='�Z�ŦW��' name='B1'>�@<input type='text' name='e_date' size=10 value='$e_date'><input type='submit' value='�_����' name='B1'>";
$s_unit.="<table border='1' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='95%'  align='center'>";
$s_unit.="<tr align='center'><td><a href='$PHP_SELF?key=group&order=curr_class_num&class=$class&e_date=$e_date'>�~�Z�y��</a>�@</td><td>�m�W</td><td><a href='$PHP_SELF?key=group&class=$class&e_date=$e_date'>���_�_���ƥ�</a></td></tr>";
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
		$s_unit.="<tr  align='center'><td><a href='$PHP_SELF?key=stud&stud_id=$stud_id'>$curr_class_num </a></td><td> $stud_name </td><td> $sco </td></tr>";
	}
}
$s_unit.="</table>
<input type='hidden' name='key' value='$key'>
<input type='hidden' name='order' value='$order'>
</form>";
}

//�V�m�a
if($key=='stud'){

if ($topage !="")
	$page = $topage; 
$page_count=20;

if($order=='')
	$order="up_date desc";

if($stud_clnu!=''){
	$stud_clnu=intval($stud_clnu);
	$query = "select stud_id from stud_base where curr_class_num ='$stud_clnu' and  stud_study_cond='0'";
	$result	= mysql_query($query);
	$row = mysql_fetch_array($result);
	$stud_id=$row["stud_id"];
	
}


$sql_select = "select  a.* ,b.unit_m,b.unit_t,b.u_s,b.unit_name ,c.stud_name,c.curr_class_num,c.stud_study_cond from test_score a,unit_u b,stud_base c where ";
$sql_select .= "  poke >0 and who='�ǥ�' and c.stud_study_cond='0'  ";   

if($stud_id!='')
    {
	 $stud_id=substr($stud_id,0,7);
	 $sql_select .= " and a.stud_id = '$stud_id' ";
	}
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
$s_unit.="�@�~�Z�y���G<input type='text' name='stud_clnu' size=10  value='$stud_clnu'>�@�Ǹ��G<input type='text' name='stud_id' size=10  value='$stud_id'><input type='submit' value='�d��' name='B1'>";
$s_unit.="<table border='1' cellpadding='0' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='95%'  align='center'>";
$s_unit.="<tr  align='center'><td><a href='$PHP_SELF?key=stud&order=curr_class_num'>�~�Z�y��</a></td><td>�m�W</td><td><a href='$PHP_SELF?key=stud&stud_id=$stud_id&order=unit_t desc,unit_m,u_s'>�ҵ{</a>�@<a href='$PHP_SELF?key=stud&stud_id=$stud_id&order=unit_m,unit_t desc ,u_s'>���</a></td><td>���_�_������(<a href='$PHP_SELF?key=stud&stud_id=$stud_id&order=poke'>�s��</a>)</td><td>�g���</td><td><a href='$PHP_SELF?key=stud&stud_id=$stud_id&order=total desc'>�԰��O</a></td><td><a href='$PHP_SELF?key=stud&stud_id=$stud_id'>�̷s�V�m�ɶ�</a></td></tr>";

while ($row = mysql_fetch_array($result)){
	$stud_idd = $row["stud_id"];
	$stud_name = $row["stud_name"];
	$curr_class_num=$row["curr_class_num"];
	$poke = $row["poke"];
	$top = $row["top"];
	$exper = $row["exper"];
	$total = $row["total"];
	$up_date = $row["up_date"];
	$unit= $row["unit_m"]. $row["unit_t"]. $row["u_s"];
	$poke_type=ceil($poke/50);
	if($top==1)
		$poke_type=6;

	$s_unit.="<tr  align='center'><td><a href='$PHP_SELF?key=stud&stud_id=$stud_idd'>$curr_class_num </a></td><td> $stud_name </td><td > $unit </td><td> $poke_type ($poke) </td><td>$exper </td><td>$total </td><td>$up_date </td></tr>";
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
$s_unit.="<tr  align='center'><td><a href='$PHP_SELF?key=unit&order=unit_t,unit_m,u_s'>�ҵ{�s��</a></td><td>�W��</td><td><a href='$PHP_SELF?key=unit'>�q�L�H��</a></td></tr>";
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
$s_unit.="<tr  align='center'><td><a href='$PHP_SELF?key=u_id&order=curr_class_num&u_id=$u_id'>�~�Z�y��</a></td><td>�m�W</td><td>�ҵ{</td><td>���_�_������(�s��)</td><td>�g���</td><td>�԰��O</td><td><a href='$PHP_SELF?key=u_id&u_id=$u_id'>�̷s�V�m�ɶ�</a></td></tr>";

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
	$s_unit.="<tr  align='center'><td><a href='$PHP_SELF?key=stud&stud_id=$stud_id'>$curr_class_num </a> </td><td> $stud_name </td><td > $unit </td><td> $poke_type ($poke) </td><td>$exper </td><td>$total </td><td>$up_date </td></tr>";
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
		<a href="<?=$PHP_SELF?>?key=unit">�ҵ{�Ʀ�</a>�@
		<a href="<?=$PHP_SELF?>?key=badge">�����o�D</a>�@
		<a href="<?=$PHP_SELF?>?key=b_group">�����Ʀ�</a>�@
		<a href="<?=$PHP_SELF?>?key=poke">�̷R�Ʀ�</a>
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

