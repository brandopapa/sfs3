<?php

// $Id: stud_add1.php 5310 2009-01-10 07:57:56Z hami $

/* �ǰȨt�γ]�w�� */
include "stud_query_config.php";  

// --�{�� session 
sfs_check();

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

//���Y
head("�����O�έp");
//���
print_menu($menu_p);
//�إ� treemenu ���O
$tree1 = new TreeMenu();
$tree1 ->default_p = "0";
//�Z�Ű}�C
$curr_class = class_base();
//����B�z
switch ($key) {
	case c : //�Z�Ť���
		$query = "select sum(stud_base.stud_sex=1) as boy,
			sum(stud_base.stud_sex=2)as girl,			
			count(stud_addr.addr_id) as aa,
			substring(curr_class_num,1,3)as gg
			from stud_addr,stud_base 
			where stud_base.addr_id=stud_addr.addr_id
			and stud_base.stud_study_cond=0 
			and stud_addr.stud_addr_h_b='$h_b'
			and stud_addr.stud_addr_h_c='$h_c'
			group by gg  order by gg  ";
		$result = mysql_query($query) or die($query);		
		$list_con .= "<tr class=title_sbody1 ><td align=center>�Ǹ�</td><td align=center>�Z��</td><td align=right>�H��</td><td align=right>�k</td><td align=right>�k</td></tr>\n";
		while ($row= mysql_fetch_array($result)) {
			$list_con .= sprintf("<tr><td align=center>%d</td><td align=center>%s</td><td align=right>%d</td><td align=right><font color=blue>%d</font></td><td align=right><font color=red>%d</font> </td></tr>\n",++$i,$curr_class[$row[gg]],$row[aa],$row[boy],$row[girl]);
			$boy +=$row[boy];
			$girl +=$row[girl];
			$total +=$row[aa];
		}
		$list_con .= sprintf("<tr><td align=center colspan=2> �X�p %d �Z</td><td align=right>%d</td><td align=right><font color=blue>%d</font></td><td align=right><font color=red>%d</font> </td></tr>\n",$i,$total,$boy,$girl);
		$list_con = "<tr class=title_mbody ><td colspan=5 align=center >$h_b -- $h_c �ǥͤH�Ʋέp��</td></tr>\n".$list_con;
	break;
	case b : //�����O�έp
		$query = "select sum(stud_base.stud_sex=1) as boy,
			sum(stud_base.stud_sex=2)as girl,
			stud_addr.stud_addr_h_b,
			stud_addr.stud_addr_h_c,
			count(stud_addr.stud_addr_h_b) as aa			
			from stud_addr,stud_base 
			where stud_base.addr_id=stud_addr.addr_id
			and stud_base.stud_study_cond=0 
			and stud_addr.stud_addr_h_b='$h_b'
			group by stud_addr.stud_addr_h_c  order by aa desc ,stud_addr.stud_addr_h_c  ";
		
		$result = mysql_query($query) or die($query);		
		$list_con .= "<tr class=title_sbody1 ><td align=center>�Ǹ�</td><td align=center>�����O</td><td align=right>�H��</td><td align=right>�k</td><td align=right>�k</td></tr>\n";
		while ($row= mysql_fetch_array($result)) {
			if ($row[stud_addr_h_c]=="") $row[stud_addr_h_c] ="<font color=red>����J����</font>";
			$list_con .= sprintf("<tr><td align=center>%d</td><td align=center>%s</td><td align=right>%d</td><td align=right><font color=blue>%d</font></td><td align=right><font color=red>%d</font> </td></tr>\n",++$i,$row[stud_addr_h_c],$row[aa],$row[boy],$row[girl]);
			$boy +=$row[boy];
			$girl +=$row[girl];
			$total +=$row[aa];
		}
		$list_con .= sprintf("<tr><td align=center colspan=2> �X�p %d �ӧ���</td><td align=right>%d</td><td align=right><font color=blue>%d</font></td><td align=right><font color=red>%d</font> </td></tr>\n",$i,$total,$boy,$girl);
		$list_con = "<tr class=title_mbody ><td colspan=5 align=center >$h_b �����ǥͤH�Ʋέp��</td></tr>\n".$list_con;
	break;
	default : //�m�O�έp
			$query = "select sum(stud_base.stud_sex=1) as boy,
			sum(stud_base.stud_sex=2)as girl,
			stud_addr.stud_addr_h_b,			
			count(stud_addr.stud_addr_h_b) as aa			
			from stud_addr,stud_base 
			where stud_base.addr_id=stud_addr.addr_id
			and stud_base.stud_study_cond=0 			
			group by stud_addr.stud_addr_h_b  order by aa desc  ";
		$result = mysql_query($query) or die($query);		
		$list_con .= "<tr class=title_sbody1 ><td align=center>�Ǹ�</td><td align=center>�m��O</td><td align=right>�H��</td><td align=right>�k</td><td align=right>�k</td></tr>\n";
		while ($row= mysql_fetch_array($result)) {			
			$list_con .= sprintf("<tr><td align=center>%d</td><td align=center>%s</td><td align=right>%d</td><td align=right><font color=blue>%d</font></td><td align=right><font color=red>%d</font> </td></tr>\n",++$i,$row[stud_addr_h_b],$row[aa],$row[boy],$row[girl]);
			$boy +=$row[boy];
			$girl +=$row[girl];
			$total +=$row[aa];
		}
		$list_con .= sprintf("<tr><td align=center colspan=2> �X�p %d �Ӷm��</td><td align=right>%d</td><td align=right><font color=blue>%d</font></td><td align=right><font color=red>%d</font> </td></tr>\n",$i,$total,$boy,$girl);
		$list_con = "<tr class=title_mbody ><td colspan=5 align=center >$h_b �m��ǥͤH�Ʋέp��</td></tr>\n".$list_con;
	break;
}
$query = "select stud_addr.stud_addr_h_b, stud_addr.stud_addr_h_c, count(stud_addr.stud_addr_h_b)as aa  from stud_addr,stud_base where stud_base.addr_id=stud_addr.addr_id and stud_base.stud_study_cond=0 group by  stud_addr.stud_addr_h_c  order by stud_addr.stud_addr_h_b ,aa desc ";
//echo $query ;
$result = mysql_query($query) or die ($query);
$temp_value="";
$i = 0;
$tol_num = mysql_num_rows($result);
$doexe[] = ".��ܧ��� ($tol_num)";
while ($row = mysql_fetch_array($result)){
	
	if ($row[stud_addr_h_b] <> $temp_value) {							
		if ($temp_count)
			$doexe[$temp_count-1] .=" ($i)^^{$_SERVER['PHP_SELF']}?key=b&h_b=$temp_name";
		
		$doexe[] = "..$row[stud_addr_h_b]";
		$temp_count = count($doexe);
		$temp_name = $row[stud_addr_h_b];
		$i = 0;
	}				
	$doexe[] = "...$row[stud_addr_h_c]($row[aa])^^{$_SERVER['PHP_SELF']}?key=c&h_b=$row[stud_addr_h_b]&h_c=$row[stud_addr_h_c]";
	$temp_value = $row[stud_addr_h_b];
	$i++;			
	
}
if ($temp_count)
	$doexe[$temp_count-1] .=" ($i)^^{$_SERVER['PHP_SELF']}?key=b&h_b=$temp_name";
	

$tree1->doexe= $doexe;
?>	

<table border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr><td valign=top  width=200 nowrap> 
   <?php
   	
   	$tree1->print_tree($p);
   ?>
   </td>
   <td valign=top width=100%>
   <!------ right content --->
    <table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
	
   	<?php echo $list_con ?>
   	
   	</table>
   <!------ end content --->   	
   </td>
   </tr>
</table>
<?php foot(); ?>
