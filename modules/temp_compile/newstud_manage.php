<?php

// $Id: newstud_manage.php 8458 2015-06-26 03:13:46Z brucelyc $

/*�ޤJ�ǰȨt�γ]�w��*/
require "config.php";
if($_REQUEST['offset']) $offset=$_REQUEST['offset'];
else $offset=0;
$rs_limit=$CONN->Execute("SELECT pm_value FROM pro_module WHERE pm_name='temp_compile' AND pm_item='limit'");
$limit=$rs_limit->fields['pm_value'];
$class_year_b=intval($_REQUEST['class_year_b']);
$work=intval($_REQUEST['work']);
$order_name=$_REQUEST['order_name'];
$new_class_year=intval($_REQUEST['new_class_year']);
$sel_temp_class=intval($_REQUEST['sel_temp_class']);
if($work=="1" || $work=="2" || $work=="7") $limit_s="limit $offset,$limit";
$edstud_sn=intval($_GET['edstud_sn']);
$sort_g=$_REQUEST['sort_g'];
if (empty($order_name) || empty($sort_g)) $order_name="temp_site";
$order=$_POST[order];
if ($order=="" && $work==3) $order=1;
if ($order=="" && $work==4) $order=0;

//�ϥΪ̻{��
sfs_check();

$Show_Data=!$_GET['much'] && !$sort_g && !$_POST['Submit4'];

//�{�����Y
if($Show_Data) {
	head("�s�ͽs�Z");
	print_menu($menu_p,"class_year_b=$class_year_b");
}

//�]�w�D������ܰϪ��I���C��
if($Show_Data)
echo "
<table border=0 cellspacing=1 cellpadding=2 width=100% bgcolor=#cccccc>
<tr>
<td bgcolor='#FFFFFF'>";
//�u�@���
$selected[$work]="selected";
$selected_order[$order]="selected";
$menu="
	<form name='form1' method='post' action='{$_SERVER['PHP_SELF']}'>
	<select name='class_year_b'>";
	$chk=($class_year_b)?$class_year_b:$IS_JHORES+1;
	while (list($k,$v)=each($class_year)) {
		$checked=($chk==$k)?"selected":"";
		$menu.="<option value='$k' $checked>$v</option>\n";
	}
$menu.="</select>
	<select name='work' onChange='jumpMenu1()'>
	<option value=''>�п�ܤu�@����</option>\n
	<option value='1' ".$selected[1].">�s�Ͱ򥻸�ƺ޲z</option>\n
	<option value='2' ".$selected[2].">�аO�O�_�NŪ����</option>\n
	<option value='7' ".$selected[7].">�аO�O�_�ѥ[��������</option>\n
	<option value='3' ".$selected[3].">�J�ǤH�Ʋέp</option>\n
	<option value='4' ".$selected[4].">���NŪ�W�U</option>\n
	<option value='5' ".$selected[5].">���Z��J</option>\n
	<option value='6' ".$selected[6].">�վ�s�Z</option>\n
	</select><A HREF='chc_940809.php'>[��X�s��]</A>";
if ($work==3) $menu.="	<select name='order' onChange='this.form.submit()'>
			<option value='1' ".$selected_order[1].">�̤J�ǾǮ�</option>\n
			<option value='2' ".$selected_order[2].">�̯Z��</option>\n
			</select>";
if ($work==4) $menu.="	<select name='order' onChange='this.form.submit()'>
			<option value='0' ".$selected_order[0].">���NŪ�ǥ�</option>\n
			<option value='2' ".$selected_order[2].">�S��Z�ǥ�</option>\n
			</select>";
if($Show_Data)	echo "<table><tr><td>".$menu."</form><td>";

//�������e�иm�󦹳B
if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
$new_sel_year=date("Y")-1911;

//�g�J���
if($_GET['delstud_sn']){
	$_GET['delstud_sn']=intval($_GET['delstud_sn']);
	$del_sql="delete from new_stud where newstud_sn='{$_GET['delstud_sn']}'";
	$CONN->Execute($del_sql) or die($del_sql);
}
if($_GET['act']=="del_all"){
	$del_sql="delete from new_stud ";
	$CONN->Execute($del_sql) or die($del_sql);
}
if($_GET['act']=="add_one"){
	$max_sql="select max(temp_id),max(newstud_sn),count(newstud_sn) from new_stud where class_year='$_GET[class_year_b]' and stud_study_year='$new_sel_year'";
	$res=$CONN->Execute($max_sql) or die($max_sql);
	$maxid=$res->fields[0];
	if ($maxid=="") $maxid="A0000";
	$max_len=strlen($maxid)-1;
	$maxid="A".sprintf("%0".$max_len."d",(intval(substr($maxid,1))+1));
	$edstu_sn=$res->fields[1]+1;
	$offset=floor($res->fields[2]/$limit)*$limit;
	$limit_s="limit $offset,$limit";
}
if($_POST['Submit2']=='�x�s'){
	$chk_sql="select * from new_stud where newstud_sn='{$_POST['updstud_sn']}'";
	$res=$CONN->Execute($chk_sql);
	if ($res->fields['newstud_sn']) {
		$sql="update new_stud set old_class='{$_POST['new_old_class']}',old_school='{$_POST['new_old_school']}',stud_name='{$_POST['new_stud_name']}',stud_person_id='{$_POST['new_stud_person_id']}',stud_sex='{$_POST['new_stud_sex']}',stud_tel_1='{$_POST['new_stud_tel_1']}',stud_birthday='{$_POST['new_stud_birthday']}',guardian_name='{$_POST['new_guardian_name']}',stud_address='{$_POST['new_stud_address']}',addr_zip='{$_POST['new_addr_zip']}' where newstud_sn='{$_POST['updstud_sn']}'";
	} else {
		$sql="insert into new_stud (stud_study_year,old_school,stud_person_id,stud_name,stud_sex,stud_tel_1,stud_birthday,guardian_name,stud_address,sure_study,class_year,temp_id,old_class,addr_zip) values ('$new_sel_year','{$_POST['new_old_school']}','{$_POST['new_stud_person_id']}','{$_POST['new_stud_name']}','{$_POST['new_stud_sex']}','{$_POST['new_stud_tel_1']}','{$_POST['new_stud_birthday']}','{$_POST['new_guardian_name']}','{$_POST['new_stud_address']}','1','{$_POST['class_year_b']}','{$_POST['updstud_id']}','{$_POST['new_old_class']}','{$_POST['new_addr_zip']}')";
	}
	$CONN->Execute($sql) or die($sql);
}
if($_POST['Submit3']=='�x�s'){
	for($i=0;$i<count($_POST['updstud_sn']);$i++){
		if ($work=="2") {
			if($_POST['sure_study'][$i]=="1")
				$upd_sql="update new_stud set sure_study='{$_POST['sure_study'][$i]}',meno='{$_POST['meno'][$i]}' where newstud_sn='{$_POST['updstud_sn'][$i]}'";
			else
				$upd_sql="update new_stud set sure_study='{$_POST['sure_study'][$i]}',meno='{$_POST['meno'][$i]}', stud_id=NULL,  class_sort=NULL, class_site=NULL  where newstud_sn='{$_POST['updstud_sn'][$i]}'";
		} else {
			$upd_sql="update new_stud set sure_oth='{$_POST['sure_oth'][$i]}' where newstud_sn='{$_POST['updstud_sn'][$i]}'";
		}
		$CONN->Execute($upd_sql) or die($upd_sql);
	}
}
if($_POST['Submit4']=='�C�L'){
	$school=get_school_base();
	$spec_str=($order==0)?"�s�ͥ��NŪ�W�U":"�S��Z�s�ͦW�U";
	$spec_col=($order==0)?"���NŪ��]":"�Ƶ�";
	echo '	<HTML><HEAD><TITLE>'.$spec_str.'</TITLE>
		<META http-equiv=Content-Language content=zh-tw>
		<META http-equiv=Content-Type content="text/html; charset=big5">
		<BODY>';
		$i=0;
		$k=0;
		$query="select * from new_stud where stud_study_year='$new_sel_year' and class_year='$class_year_b' and sure_study='$order' order by temp_id";
		$res=$CONN->Execute($query) or die($query);
		$j=$res->RecordCount();
		while (!$res->EOF) {
			if ($i==0)
				echo '	<P align=center><FONT size=4>'.$school[sch_cname].$new_sel_year.'�Ǧ~��'.$spec_str.'</FONT></P>
					<TABLE style="BORDER-COLLAPSE: collapse" borderColor=#111111 cellSpacing=0 cellPadding=0 width=610 align=center border=0>
					<TBODY>
					<tr>
					<td style="border-style:solid; border-width:1.5pt 0.75pt 1.5pt 1.5pt;" align="center" width="80">�{�ɽs��</td>
					<td style="border-style:solid; border-width:1.5pt 0.75pt;" align="center" width="80">�m�W</td>
					<td style="border-style:solid; border-width:1.5pt 0.75pt;" align="center" width="80">�ǮզW��</td>
					<td style="border-style:solid; border-width:1.5pt 0.75pt;" align="center" width="90">�����Ҧr��</td>
					<td style="border-style:solid; border-width:1.5pt 0.75pt;" align="center" width="80">�q��</td>
					<td style="border-style:solid; border-width:1.5pt 1.5pt 1.5pt 0.75pt;" align="center" width="200">'.$spec_col.'</td>
					</tr>';
			if (($i+1) % 5 ==0 || ($i+1+$k*40)==$j)
				echo '	<tr>
					<td style="border-style:solid; border-width:0.75pt 0.75pt 1.5pt 1.5pt;" align="center" width="80"><font face="Dotum">'.$res->fields[temp_id].'</font></td>
					<td style="border-style:solid; border-width:0.75pt 0.75pt 1.5pt 0.75pt;" align="center" width="80">'.$res->fields[stud_name].'</td>
					<td style="border-style:solid; border-width:0.75pt 0.75pt 1.5pt 0.75pt;" align="center" width="80">'.$res->fields[old_school].'</td>
					<td style="border-style:solid; border-width:0.75pt 0.75pt 1.5pt 0.75pt;" align="center" width="90"><font face="Dotum">'.$res->fields[stud_person_id].'</font></td>
					<td style="border-style:solid; border-width:0.75pt 0.75pt 1.5pt 0.75pt;" align="center" width="80"><font face="Dotum">'.$res->fields[stud_tel_1].'</font></td>
					<td style="border-style:solid; border-width:0.75pt 1.5pt 1.5pt 0.75pt;" align="left" width="200">'.$res->fields[meno].'</td>
					</tr>';
			else
				echo '	<tr>
					<td style="border-style:solid; border-width:0.75pt 0.75pt 0.75pt 1.5pt;" align="center" width="80"><font face="Dotum">'.$res->fields[temp_id].'</font></td>
					<td style="border-style:solid; border-width:0.75pt 0.75pt 0.75pt;" align="center" width="80">'.$res->fields[stud_name].'</td>
					<td style="border-style:solid; border-width:0.75pt 0.75pt 0.75pt;" align="center" width="80">'.$res->fields[old_school].'</td>
					<td style="border-style:solid; border-width:0.75pt 0.75pt 0.75pt;" align="center" width="90"><font face="Dotum">'.$res->fields[stud_person_id].'</font></td>
					<td style="border-style:solid; border-width:0.75pt 0.75pt 0.75pt;" align="center" width="80"><font face="Dotum">'.$res->fields[stud_tel_1].'</font></td>
					<td style="border-style:solid; border-width:0.75pt 1.5pt 0.75pt 0.75pt;" align="left" width="200">'.$res->fields[meno].'</td>
					</tr>';
			$i++;
			if ($i==40) {
				$i=0;
				$k++;
				echo '</TBODY></TABLE><br style="page-break-after:always">';
			}
			$res->MoveNext();
		}
		echo '</TBODY></TABLE></BODY></HTML>';
}
if($_POST['Submit5']=='�x�s'){
	while (list($k,$v)=each($_POST['updstud_sn'])) {
		if($_POST['temp_score1'][$k]=="") $_POST['temp_score1'][$k]="-100";
		if($_POST['temp_score2'][$k]=="") $_POST['temp_score2'][$k]="-100";
		if($_POST['temp_score3'][$k]=="") $_POST['temp_score3'][$k]="-100";
		$upd_sql="update new_stud set temp_score1='{$_POST['temp_score1'][$k]}',temp_score2='{$_POST['temp_score2'][$k]}',temp_score3='{$_POST['temp_score3'][$k]}' where newstud_sn='$v'";
		$CONN->Execute($upd_sql) or die($upd_sql);
	}
}

if($_POST['Submit7']=='�x�s'){
	$updstud_sn=$_POST['updstud_sn'];
	$new_temp_class_Y=$_POST['new_temp_class_Y'];
	$new_temp_site_Y=$_POST['new_temp_site_Y'];
	while (list($k,$v)=each($updstud_sn)) {
		if (!empty($new_temp_site_Y[$k])) {
			$upd_sql="update new_stud set temp_class='".intval($new_temp_class_Y[$k])."',temp_site='".intval($new_temp_site_Y[$k])."' where newstud_sn='$v'";
			$CONN->Execute($upd_sql) or die($upd_sql);
		}
	}
}

//�C�X���~�ת��s�ͦW��
($_GET[order_name]=="") ?  $order_name="temp_id" :$order_name=$_GET[order_name] ;
if($new_class_year){
	$class_year=substr($new_class_year,0,-2);
	$class_sort=intval(substr($new_class_year,-2));
	$sql="select * from new_stud where stud_study_year='$new_sel_year' and class_year='$class_year' and class_sort='$class_sort' order by $order_name $limit_s";
} else
	$sql="select * from new_stud where class_year='$class_year_b' and stud_study_year='$new_sel_year' order by $order_name $limit_s";
$rs=$CONN->Execute($sql) or die($sql);
$i=0;
while(!$rs->EOF){
	$newstud_sn[$i]=$rs->fields['newstud_sn'];
	$old_school[$i]=$rs->fields['old_school'];
	$old_class[$i]=$rs->fields['old_class'];
	$stud_person_id[$i]=$rs->fields['stud_person_id'];
	$stud_name[$i]=$rs->fields['stud_name'];
	$stud_sex[$i]=$rs->fields['stud_sex'];
	$stud_tel_1[$i]=$rs->fields['stud_tel_1'];
	$stud_birthday[$i]=$rs->fields['stud_birthday'];
	$guardian_name[$i]=$rs->fields['guardian_name'];
	$stud_address[$i]=$rs->fields['stud_address'];
	$sure_study[$i]=$rs->fields['sure_study'];
	$sure_oth[$i]=$rs->fields['sure_oth'];
	$stud_id[$i]=$rs->fields['stud_id'];
	$addr_zip[$i]=$rs->fields['addr_zip'];
	$class_year[$i]=$rs->fields['class_year'];
	$class_sort[$i]=$rs->fields['class_sort'];
	$class_site[$i]=$rs->fields['class_site'];
	$temp_score1[$i]=$rs->fields['temp_score1'];
	$temp_score2[$i]=$rs->fields['temp_score2'];
	$temp_score3[$i]=$rs->fields['temp_score3'];
	$temp_id[$i]=$rs->fields['temp_id'];
	$temp_class[$i]=$rs->fields['temp_class'];
	$temp_site[$i]=$rs->fields['temp_site'];
	$meno[$i]=$rs->fields['meno'];
	$i++;
	$rs->MoveNext();
}
if ($maxid) {
	$newstud_sn[$i]=$edstud_sn;
	$temp_id[$i]=$maxid;
}

switch($work){
	case 1:
		if(!$offset){$offset=0;}
		$rs_page=$CONN->Execute("select newstud_sn from new_stud where stud_study_year='$new_sel_year' and  class_year='$class_year_b'");
		$w=0;
		while(!$rs_page->EOF){
			$counter[$w]=$rs_page->fields['newstud_sn'];
			$w++;
			$rs_page->MoveNext();
		}
		$numrec=count($counter);
		$numpage=intval($numrec/$limit);
		if($numrec%$limit){$numpage++;}
		if($numpage>1) pagenav();
		echo "</td></tr></table>";
		echo "	<table bgcolor='black' border='0' cellpadding='2' cellspacing='1'>
			<tr bgcolor='#FFEC6E'>
			<td rowspan='2'><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=temp_id'>�{�ɽs��</a></td>
			<td><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=old_school'>�ǮզW��</a></td>
			<td rowspan='2' align='center'><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=stud_name'>�m�W</a></td>
			<td><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=stud_person_id'>�����Ҧr��</a></td>
			<td><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=stud_sex'>�ʧO</a></td>
			<td align='center'><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=stud_birthday'>�ͤ�</a></td>
			<td><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=guardian_name'>�a���m�W</a></td>
			<td align='center'><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=stud_tel_1'>�q��</a></td>
			<td rowspan='2' align='center'><a href='{$_SERVER['PHP_SELF']}?work=$work&act=del_all&class_year_b=$class_year_b' onclick='return confirm(\"�u���n�����R�� $stud_name ?\")'><span class='button'>�����R��</span></a><br>
			<a href='{$_SERVER['PHP_SELF']}?work=$work&act=add_one&class_year_b=$class_year_b'><span class='button'>�W�[�@��</span></a></td>
			</tr>
			<tr bgcolor='#FFEC6E'>
			<td>��p�Z��
			<td align='center'>�l���ϸ�
			<td colspan='4' align='center'><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=stud_address'>��}</a>
			</tr>";
		for($j=0;$j<count($newstud_sn);$j++) {
			if($stud_sex[$j]=="1"){
				$boy_selected[$j]="selected";
				$bgc="#C7CAFD";
				$bgce="#C1B0FF";
			} elseif($stud_sex[$j]=="2") {
				$girl_selected[$j]="selected";
				$bgc="#F9C8FD";
				$bgce="#EF6EFB";
			} else {                
				$bgc="#FFFFFF";
				$bgce="#FFFFFF";
			}

			if($edstud_sn==$newstud_sn[$j]){
				echo "	<tr bgcolor='$bgce'><form name='form2' method='post' action='{$_SERVER['PHP_SELF']}'>
					<input type='hidden' name='work' value='$work'>
					<input type='hidden' name='offset' value='$offset'>
					<input type='hidden' name='class_year_b' value='$class_year_b'>
					<input type='hidden' name='updstud_sn' value='$newstud_sn[$j]'>
					<input type='hidden' name='updstud_id' value='$temp_id[$j]'>
					<td rowspan='2'>$temp_id[$j]</td>
					<td><input type='text' name='new_old_school' size='10' maxlength='20' value='$old_school[$j]'></td>
					<td rowspan='2'><input type='text' name='new_stud_name' size='8' maxlength='12' value='$stud_name[$j]'></td>
					<td><input type='text' name='new_stud_person_id' size='10' maxlength='20' value='$stud_person_id[$j]'></td>
					<td><select name='new_stud_sex'>
						<option value='1' $boy_selected[$j]>�k</option>
						<option value='2' $girl_selected[$j]>�k</option>
					</select></td>
					<td><input type='text' name='new_stud_birthday' size='10' maxlength='20' value='$stud_birthday[$j]'></td>
					<td><input type='text' name='new_guardian_name' size='8' maxlength='12' value='$guardian_name[$j]'></td>
					<td><input type='text' name='new_stud_tel_1' size='10' maxlength='20' value='$stud_tel_1[$j]'></td>
					<td rowspan='2' align='center'><input type='submit' name='Submit2' value='�x�s'></td>
					</tr>
					<tr bgcolor='$bgce'>
					<td><input type='text' name='new_old_class' size='10' maxlength='20' value='$old_class[$j]'></td>
					<td><input type='text' name='new_addr_zip' size='3' maxlength='3' value='$addr_zip[$j]'></td>
					<td colspan='4'><input type='text' name='new_stud_address' size='20' maxlength='200' value='$stud_address[$j]'></td>
					</form></tr>";
			} else {
				if($stud_sex[$j]=="1") 
					$stud_sex_c[$j]="�k";
				elseif($stud_sex[$j]=="2") 
					$stud_sex_c[$j]="�k";
				else 
					$stud_sex_c[$j]="";
				if($sure_study[$j]=="1") 
					$fcolor="";
				else 
					$fcolor="#A1A39D";
				echo "	<tr bgcolor='$bgc'>
					<td rowspan='2'><font color='$fcolor'>$temp_id[$j]</font></td>
					<td><font color='$fcolor'>$old_school[$j]</font></td>
					<td rowspan='2'><font color='$fcolor'>$stud_name[$j]</font></td>
					<td><font color='$fcolor'>$stud_person_id[$j]</font></td>
					<td><font color='$fcolor'>$stud_sex_c[$j]</font></td>
					<td><font color='$fcolor'>$stud_birthday[$j]</font></td>
					<td><font color='$fcolor'>$guardian_name[$j]</font></td>
					<td><font color='$fcolor'>$stud_tel_1[$j]</font></td>
					<td rowspan='2'><a href='{$_SERVER['PHP_SELF']}?work=$work&offset=$offset&class_year_b=$class_year_b&edstud_sn=$newstud_sn[$j]'><span class='button'>�ק�</span></a>
					<a href='{$_SERVER['PHP_SELF']}?work=$work&offset=$offset&class_year_b=$class_year_b&delstud_sn=$newstud_sn[$j]' OnClick='return confirm(\"�T�w�R��?\");'><span class='button'>�R��</span></a></td>
					</tr>
					<tr bgcolor='$bgc'>
					<td><font color='$fcolor'>$old_class[$j]</font></td>
					<td>$addr_zip[$i]</td>
					<td colspan='4'><font color='$fcolor'>$stud_address[$j]</font></td>
					</tr>";
			}
		}
		echo "</table>";
		echo "<br>�U��<a href=\"export.php\">�u�N�Ǩt���ɮסv</a>".$msg1;
		break;

	case 2:
		if(!$offset) $offset=0;
		$rs_page=$CONN->Execute("select newstud_sn from new_stud where stud_study_year='$new_sel_year' and class_year='$class_year_b'");
		$w=0;
		while(!$rs_page->EOF){
			$counter[$w]=$rs_page->fields['newstud_sn'];
			$w++;
			$rs_page->MoveNext();
		}
		$numrec=count($counter);
		$numpage=intval($numrec/$limit);
		if($numrec%$limit) $numpage++;
		if($numpage>1) pagenav();
		echo "<td><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&offset=$offset&edit=1&order_name={$_GET['order_name']}'><span class='button'>�s��</span></a></td>";
		if($_GET['edit']) 
			echo "	<td><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&offset=$offset&sure_all=1&edit=1&order_name={$_GET['order_name']}'><span class='button'>����</span></a></td>
				<form name='form3' method='post' action='{$_SERVER['PHP_SELF']}'>
				<td><input type='submit' name='Submit3' value='�x�s'></td>";
		else 
			echo "</td></tr></table>";
		if($_GET['sure_all']) $checked="checked";
		echo "	<table bgcolor='black' border='0' cellpadding='2' cellspacing='1'>
			<tr bgcolor='#FFEC6E'>
			<td><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=temp_id'>�{�ɽs��</a></td>
			<td><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=old_school'>�ǮզW��</a></td>
			<td><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=stud_name'>�m�W</a></td>
			<td><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=stud_person_id'>�����Ҧr��</a></td>
			<td>�NŪ</td>
			<td>���NŪ</td>
			<td>�S��Z</td>
			<td>���NŪ��]�ίS��Z���O</td>
			</tr>";
		for($j=0;$j<count($newstud_sn);$j++){
			if($stud_sex[$j]=="1") 
				$bgc="#C7CAFD";
			elseif($stud_sex[$j]=="2") 
				$bgc="#F9C8FD";
			else 
				$bgc="#FFFFFF";

			if($_GET['edit']){
				if(($sure_study[$j]=="1") || ($_GET['sure_all']=="1")) 
					$c[$j][1]="checked";
				elseif ($sure_study[$j]=="2")
					$c[$j][2]="checked";
				else
					$c[$j][0]="checked";
				echo "	<tr bgcolor='$bgc'>
					<td>$temp_id[$j]</td>
					<td>$old_school[$j]</td>
					<td>$stud_name[$j]</td>
					<td>$stud_person_id[$j]</td>
					<input type='hidden' name='work' value='$work'>
					<input type='hidden' name='offset' value='$offset'>
					<input type='hidden' name='class_year_b' value='$class_year_b'>
					<input type='hidden' name='order_name' value='{$_GET['order_name']}'>
					<input type='hidden' name='updstud_sn[$j]' value='$newstud_sn[$j]'>
					<td><input type='radio' name='sure_study[$j]' value='1' ".$c[$j][1]."></td>
					<td><input type='radio' name='sure_study[$j]' value='0' ".$c[$j][0]."></td>
					<td><input type='radio' name='sure_study[$j]' value='2' ".$c[$j][2]."></td>
					<td><input type='text' name='meno[$j]' size='50' maxlength='200' value='$meno[$j]'></td>
					</tr>";
			} else {
				if($sure_study[$j]!="")
					$sure_study_p[$j][$sure_study[$j]]="��";
				else
					$sure_study_p[$j][0]="��";
				echo "	<tr bgcolor='$bgc'>
					<td>$temp_id[$j]</td>
					<td>$old_school[$j]</td>
					<td>$stud_name[$j]</td>
					<td>$stud_person_id[$j]</td>
					<td align='center'>".$sure_study_p[$j][1]."</td>
					<td align='center'>".$sure_study_p[$j][0]."</td>
					<td align='center'>".$sure_study_p[$j][2]."</td>
					<td>$meno[$j]</td>
					</tr>";
			}
		}
		echo "</form></table>";
		echo $msg1;
		break;

	case 3:
		echo "</tr></table>";
		$title_str=($order==1)?"�ǮզW��":"�Z��";
		$bgcr=array("0"=>"#FFDDDD","1"=>"#FFFFDD","2"=>"#DDFFDD");
		echo "	<table bgcolor='black' border='0' cellpadding='2' cellspacing='1'>
			<tr bgcolor='#FFEC6E'>
			<td rowspan='2' align='center'>$title_str</td>
			<td colspan='3' align='center'>�k</td>
			<td colspan='3' align='center'>�k</td>
			<td colspan='3' align='center'>�X�p</td>
			<td rowspan='2' align='center'>�Ƶ�</td>
			</tr>
			<tr bgcolor='#FFEC6E'>
			<td>���NŪ</td>
			<td>�N�@Ū</td>
			<td>�S��Z</td>
			<td>���NŪ</td>
			<td>�N�@Ū</td>
			<td>�S��Z</td>
			<td>���NŪ</td>
			<td>�N�@Ū</td>
			<td>�S��Z</td>
			</tr>
			";
		$query="update new_stud set sure_study='0' where stud_study_year='$new_sel_year' and sure_study=''";
		$CONN->Execute($query) or trigger_error("SQL�y�k���~�G$query", E_USER_ERROR);
		if ($order==1) {
			//�̤J�ǾǮղέp
			$query="select distinct old_school from new_stud where stud_study_year='$new_sel_year'";
			$i=0;
		} else {
			//�̯Z�Ųέp
			$query="select * from temp_class where year='$new_sel_year' order by c_sort";
		}
		$res=$CONN->Execute($query) or trigger_error("SQL�y�k���~�G$query", E_USER_ERROR);
		while (!$res->EOF) {
			if ($order==1) {
				$name_arr[$i]=addslashes($res->fields[old_school]);
				$cname_arr[$i]=$name_arr[$i];
				$chk_str="old_school";
			} else {
				$i=$res->fields[c_sort];
				$name_arr[$i]=$res->fields[class_id];
				$cname_arr[$i]=addslashes($res->fields[c_name])."�Z";
				$chk_str="temp_class";
			}
			for ($j=1;$j<=2;$j++) {
				for ($k=0;$k<=2;$k++) {
					$chk=($k==0)?"":$k;
					$query="select count(newstud_sn) from new_stud where stud_study_year='$new_sel_year' and stud_sex='$j' and $chk_str = '$name_arr[$i]' and sure_study='$k'";
					$res_num=$CONN->Execute($query) or trigger_error("SQL�y�k���~�G$query", E_USER_ERROR);
					$num[$name_arr[$i]][$j][$k]=$res_num->fields[0];
				}
			}
			$i++;
			$res->MoveNext();
		}
		$total1=0;
		$total2=0;
		while (list($k,$v)=each($name_arr)) {
			echo "	<tr bgcolor='#ffffff'>
				<td>".stripslashes($cname_arr[$k])."</td>";
			reset($num[$v]);
			while(list($a,$vv)=each($num[$v])) {
				reset($vv);
				while(list($b,$vvv)=each($vv)) {
					echo "<td align='right' bgcolor='".$bgcr[$b]."'>".$num[$v][$a][$b]."</td>";
				}
			}
			echo "	<td align='right' bgcolor='".$bgcr[0]."'>".($num[$v][1][0]+$num[$v][2][0])."<td align='right' bgcolor='".$bgcr[1]."'>".($num[$v][1][1]+$num[$v][2][1])."<td align='right' bgcolor='".$bgcr[2]."'>".($num[$v][1][2]+$num[$v][2][2])."</td>
				<td></td>
				</tr>";
			$total10+=$num[$v][1][0];
			$total11+=$num[$v][1][1];
			$total12+=$num[$v][1][2];
			$total20+=$num[$v][2][0];
			$total21+=$num[$v][2][1];
			$total22+=$num[$v][2][2];
		}
		echo "<tr bgcolor='#ffffff'><td>�`�p<td align='right' bgcolor='".$bgcr[0]."'>$total10<td align='right' bgcolor='".$bgcr[1]."'>$total11<td align='right' bgcolor='".$bgcr[2]."'>$total12<td align='right' bgcolor='".$bgcr[0]."'>$total20<td align='right' bgcolor='".$bgcr[1]."'>$total21<td align='right' bgcolor='".$bgcr[2]."'>$total22<td align='right' bgcolor='".$bgcr[0]."'>".($total10+$total20)."<td align='right' bgcolor='".$bgcr[1]."'>".($total11+$total21)."<td align='right' bgcolor='".$bgcr[2]."'>".($total12+$total22)."<td></tr></table>";
		break;

	case 4:
		$url_str="<a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=";
		echo "	</tr></table>
			<form method='post' action='{$_SERVER['PHP_SELF']}'>
			<table bgcolor='black' border='0' cellpadding='2' cellspacing='1'>
			<tr bgcolor='#FFEC6E'>
			<td>".$url_str."temp_id'>�{�ɽs��</a></td>
			<td>".$url_str."old_school'>�ǮզW��</a></td>
			<td>�m�W</td>
			<td>�����Ҧr��</td>
			<td>���NŪ��]</td>
			<td>�q��</td>
			<td>���@�H�m�W</td>
			</tr>";
		$i=0;
		$query="select * from new_stud where stud_study_year='$new_sel_year' and class_year='$class_year_b' and sure_study='$order' order by $order_name";
		$res=$CONN->Execute($query) or die($query);
		while (!$res->EOF) {
			echo "<tr bgcolor='#ffffff'><td>".$res->fields[temp_id]."<td>".$res->fields[old_school]."<td>".$res->fields[stud_name]."<td>".$res->fields[stud_person_id]."<td>".$res->fields[meno]."<td>".$res->fields[stud_tel_1]."<td>".$res->fields[guardian_name]."</td></tr>";
			$i++;
			$res->MoveNext();
		}
		echo "	</table><input type='submit' name='Submit4' value='�C�L'><input type='hidden' name='class_year_b' value='$class_year_b'><input type='hidden' name='$new_sel_year' value='$new_sel_year'><input type='hidden' name='$order_name' value='$order_name'><input type='hidden' name='order' value='$order'></form>";
		break;

	case 5:
		$col_name="sel_temp_class";
		$id=$sel_temp_class;
		$select_class=full_class_name($id,$col_name,$new_sel_year,$class_year_b);
		$select_class_subject="
			<form name='form4' method='post' action='{$_SERVER['PHP_SELF']}'>
			<input type='hidden' name='work' value='$work'>
			<input type='hidden' name='class_year_b' value='$class_year_b'>
			<select name='$col_name' onChange='jumpMenu4()'>
				$select_class;
			</select>
			</form>";

		echo "</td><td>$select_class_subject</td><td><a href='{$_SERVER['PHP_SELF']}?work=$work&edit=1&sel_temp_class=$sel_temp_class&order_name=$order_name&class_year_b=$class_year_b'><span class='button'>�s��</span></a></td>";
		if($_GET['edit']) 
			echo "	<form name='form5' method='post' action='{$_SERVER['PHP_SELF']}'>
				<td><input type='submit' name='Submit5' value='�x�s'><input type='hidden' name='sel_temp_class' value='$sel_temp_class'><input type='hidden' name='class_year_b' value='$class_year_b'></td>
				</tr></table>";
		else
			echo "</tr></table>";
		echo "	<table bgcolor='black' border='0' cellpadding='2' cellspacing='1'>
			<tr bgcolor='#FFEC6E'>
			<td><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=temp_id&new_class_year=$new_class_year'>�{�ɽs��</a></td>
			<td><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=temp_site&new_class_year=$new_class_year'>�y��</a></td>
			<td><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=stud_name&new_class_year=$new_class_year'>�m�W</a></td>
			<td><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=temp_score1&new_class_year=$new_class_year'>���Z1</a></td>
			<td><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=temp_score2&new_class_year=$new_class_year'>���Z2</a></td>
			<td><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=temp_score3&new_class_year=$new_class_year'>���Z3</a></td>
			<td>����</td></tr>";
		for($j=0;$j<count($newstud_sn);$j++){
			if($temp_class[$j]!=$sel_temp_class) continue;
			$average_count[$j]=3;
			if($temp_score1[$j]=="-100") {$temp_score1[$j]=""; $average_count[$j]--;}
			if($temp_score2[$j]=="-100") {$temp_score2[$j]=""; $average_count[$j]--;}
			if($temp_score3[$j]=="-100") {$temp_score3[$j]=""; $average_count[$j]--;}
			if($average_count[$j]!="0") $temp_average[$j]=number_format(($temp_score1[$j]+$temp_score2[$j]+$temp_score3[$j])/$average_count[$j],2);
			if($stud_sex[$j]=="1") 
				$bgc="#C7CAFD";
			elseif($stud_sex[$j]=="2") 
				$bgc="#F9C8FD";
			else 
				$bgc="#FFFFFF";

			if($_GET['edit']&&$sure_study[$j]=="1"){
				echo "	<tr bgcolor='$bgc'>
					<td>$temp_id[$j]</td>
					<td>$temp_site[$j]</td>
					<td>$stud_name[$j]</td>
					<input type='hidden' name='work' value='$work'>
					<input type='hidden' name='class_year_b' value='$class_year_b'>
					<input type='hidden' name='order_name' value='$order_name'>
					<input type='hidden' name='new_class_year' value='$new_class_year'>
					<input type='hidden' name='updstud_sn[$j]' value='$newstud_sn[$j]'>
					<td align='center'><input type='text' name='temp_score1[$j]' size='3' maxlength='3' value='$temp_score1[$j]'></td>
					<td align='center'><input type='text' name='temp_score2[$j]' size='3' maxlength='3' value='$temp_score2[$j]'></td>
					<td align='center'><input type='text' name='temp_score3[$j]' size='3' maxlength='3' value='$temp_score3[$j]'></td>
					<td>$temp_average[$j]</td>
					</tr>";
			} else {
				echo "	<tr bgcolor='$bgc'>
					<td>$temp_id[$j]</td>
					<td>$temp_site[$j]</td>
					<td>$stud_name[$j]</td>
					<td>$temp_score1[$j]</td>
					<td>$temp_score2[$j]</td>
					<td>$temp_score3[$j]</td>
					<td>$temp_average[$j]</td>
					</tr>";
			}
		}
		echo "</form></table>";
		break;

	case 6:
		if($_GET['much'] && $sort_g){
			$sql_studid="select * from new_stud where stud_study_year='$new_sel_year' and sure_study='1' order by $sort_g";
			$rs_studid=$CONN->Execute($sql_studid);
			$C=1;
			while(!$rs_studid->EOF){
				$newstud_sn_C=$rs_studid->fields['newstud_sn'];
				$stud_id=$new_sel_year.sprintf("%0".$_GET['much']."d",$C);
				$CONN->Execute("update new_stud set stud_id='$stud_id' where newstud_sn='$newstud_sn_C'");
				$C++;
				$rs_studid->MoveNext();
			}
			header("Location: newstud_manage.php?work=4&class_year_b=$class_year_b");
		}
		$col_name="sel_temp_class";
		$id=$sel_temp_class;
		$select_class=full_class_name($id,$col_name,$new_sel_year,$class_year_b);

		$sql="select COUNT(*) from new_stud where stud_study_year='$new_sel_year'";
		$rs_count=$CONN->Execute($sql);
		if (!$rs_count) {
			print $CONN->ErrorMsg();
		} else {
			list($total) = $rs_count->FetchRow();
		}
		$sql="select MAX(stud_id) from new_stud where stud_study_year='$new_sel_year'";
		$rs_count=$CONN->Execute($sql);
		if (!$rs_count) {
			print $CONN->ErrorMsg();
		} else {
			list($max_id) = $rs_count->FetchRow();
		}

		$select_class_subject="
			<form name='form6' method='post' action='{$_SERVER['PHP_SELF']}'>
			<input type='hidden' name='class_year_b' value='$class_year_b'>
			<input type='hidden' name='work' value='$work'>
			<select name='$col_name' onChange='jumpMenu6()'>
				$select_class;
			</select>
			</form>";
		echo "</td><td>$select_class_subject</td>";
		echo "	<form name='form7' method='post' action='{$_SERVER['PHP_SELF']}'>
			<input type='hidden' name='total' value='$total'>
			<td><input type='submit' name='Submit7' value='�x�s'><input type='hidden' name='sel_temp_class' value='$sel_temp_class'><input type='hidden' name='class_year_b' value='$class_year_b'></td>
			</tr></table>";
		echo "	<table bgcolor='black' border='0' cellpadding='2' cellspacing='1'>
			<tr bgcolor='#FFEC6E'>
			<td><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=temp_id&new_class_year=$new_class_year&sel_temp_class=$sel_temp_class'>�{�ɽs��</a></td>
			<td><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=temp_site&new_class_year=$new_class_year&sel_temp_class=$sel_temp_class'>�y��</a></td>
			<td><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=stud_name&new_class_year=$new_class_year&sel_temp_class=$sel_temp_class'>�m�W</a></td>
			<td>�s�Z��</td>
			<td>�s�y��</td>
			</tr>";
		for($j=0;$j<count($newstud_sn);$j++){
			if($temp_class[$j]!=$sel_temp_class) continue;
			$col_name_Y[$j]="new_temp_class_Y[$j]";
			$id_Y[$j]=$new_temp_class_Y[$j];
			if($id_Y[$j]=="") $id_Y[$j]=$temp_class[$j];
			$new_temp_class_Y[$j]=full_class_name($id_Y[$j],$col_name_Y[$j],$new_sel_year,$class_year_b);
			if($stud_sex[$j]=="1") 
				$bgc="#C7CAFD";
			elseif($stud_sex[$j]=="2") 
				$bgc="#F9C8FD";
			else $bgc="#FFFFFF";
			if ($sure_study[$j]) {
				if (!$stud_id[$j]) $stud_id[$j]=++$max_id;
				echo "	<tr bgcolor='$bgc'>
					<td>$temp_id[$j]</td>
					<td>$temp_site[$j]</td>
					<td>$stud_name[$j]</td>
					<input type='hidden' size='6' name='stud_id[$j]' value='$stud_id[$j]'>
					<input type='hidden' name='class_year_b' value='$class_year_b'>
					<input type='hidden' name='order_name' value='$order_name'>
					<input type='hidden' name='work' value='$work'>
					<input type='hidden' name='new_class_year' value='$new_class_year'>
					<input type='hidden' name='updstud_sn[$j]' value='$newstud_sn[$j]'>
					<td><select name='$col_name_Y[$j]'>
						$new_temp_class_Y[$j];
					</select></td>
					<td><input type='text' name='new_temp_site_Y[$j]' size='5' maxlength='3' value=''></td>
					</tr>";
				$countit++;
			}
		}
		echo "</form></table>";
		if ($countit==0) echo "<br>���ϥu�C�X�G�w�аO�n�ӥ��մNŪ���ǥͦW��<br>�Y���X�{�W��A��ܱz�|�����аO�NŪ�P�_���ʧ@!<br>�Хѿ�椤�� '�O�_�NŪ����' �i��аO���ʧ@"; 
		break;

	case 7:
		if(!$offset) $offset=0;
		$rs_page=$CONN->Execute("select newstud_sn from new_stud where stud_study_year='$new_sel_year' and class_year='$class_year_b'");
		$w=0;
		while(!$rs_page->EOF){
			$counter[$w]=$rs_page->fields['newstud_sn'];
			$w++;
			$rs_page->MoveNext();
		}
		$numrec=count($counter);
		$numpage=intval($numrec/$limit);
		if($numrec%$limit) $numpage++;
		if($numpage>1) pagenav();
		echo "<td><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&offset=$offset&edit=1&order_name={$_GET['order_name']}'><span class='button'>�s��</span></a></td>";
		if($_GET['edit']) 
			echo "	<td><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&offset=$offset&sure_all=1&edit=1&order_name={$_GET['order_name']}'><span class='button'>����</span></a></td>
				<form name='form3' method='post' action='{$_SERVER['PHP_SELF']}'>
				<td><input type='submit' name='Submit3' value='�x�s'></td>";
		else 
			echo "</td></tr></table>";
		if($_GET['sure_all']) $checked="checked";
		echo "	<table bgcolor='black' border='0' cellpadding='2' cellspacing='1'>
			<tr bgcolor='#FFEC6E'>
			<td><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=temp_id'>�{�ɽs��</a></td>
			<td><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=old_school'>�ǮզW��</a></td>
			<td><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=stud_name'>�m�W</a></td>
			<td><a href='{$_SERVER['PHP_SELF']}?work=$work&class_year_b=$class_year_b&order_name=stud_person_id'>�����Ҧr��</a></td>
			<td>�ѥ[</td>
			<td>���ѥ[</td>
			</tr>";
		for($j=0;$j<count($newstud_sn);$j++){
			if($stud_sex[$j]=="1") 
				$bgc="#C7CAFD";
			elseif($stud_sex[$j]=="2") 
				$bgc="#F9C8FD";
			else 
				$bgc="#FFFFFF";

			if($_GET['edit']){
				if(($sure_oth[$j]=="1") || ($_GET['sure_all']=="1")) 
					$c[$j][1]="checked";
				else
					$c[$j][0]="checked";
				echo "	<tr bgcolor='$bgc'>
					<td>$temp_id[$j]</td>
					<td>$old_school[$j]</td>
					<td>$stud_name[$j]</td>
					<td>$stud_person_id[$j]</td>
					<input type='hidden' name='work' value='$work'>
					<input type='hidden' name='offset' value='$offset'>
					<input type='hidden' name='class_year_b' value='$class_year_b'>
					<input type='hidden' name='order_name' value='{$_GET['order_name']}'>
					<input type='hidden' name='updstud_sn[$j]' value='$newstud_sn[$j]'>
					<td><input type='radio' name='sure_oth[$j]' value='1' ".$c[$j][1]."></td>
					<td><input type='radio' name='sure_oth[$j]' value='0' ".$c[$j][0]."></td>
					</tr>";
			} else {
				if($sure_oth[$j]!="")
					$sure_study_p[$j][$sure_oth[$j]]="��";
				else
					$sure_study_p[$j][0]="��";
				echo "	<tr bgcolor='$bgc'>
					<td>$temp_id[$j]</td>
					<td>$old_school[$j]</td>
					<td>$stud_name[$j]</td>
					<td>$stud_person_id[$j]</td>
					<td align='center'>".$sure_study_p[$j][1]."</td>
					<td align='center'>".$sure_study_p[$j][0]."</td>
					</tr>";
			}
		}
		echo "</form></table>";
		echo $msg1;
		break;

	default:
		echo "</tr></table>";
}


//�����D������ܰ�
if($Show_Data) echo "</td></tr></table>";

//�{���ɧ�
if($Show_Data) foot();

//�{�ɽs�Z���Z�ſ��
function  full_class_name($id,$col_name,$stud_study_year,$class_year_b){
	global $CONN;

	$sql="select class_id,c_name from temp_class where year='$stud_study_year' and class_id like '$class_year_b%' order by class_id";
	$rs=$CONN->Execute($sql);
	$full_year_class_name="<option value=''>�п�Z��</option>\n";
	while(!$rs->EOF){
		$class_id=$rs->fields['class_id'];
		$selected=($id==$class_id)?"selected":"";
		$full_year_class_name.="<option value='".$class_id."' $selected>".$rs->fields['c_name']."�Z</option>\n";
		$rs->MoveNext();
	}
	return $full_year_class_name;
}

function pagenav()
{
  global $limit,$offset,$numpage,$work,$class_year_b;
  echo"<table width='100%' cellpadding='0' border='0' cellspacing='1' >
       <tr>
         <td align='left'>";
  if($offset>=$limit)
  {
    $newoff=$offset-$limit;
    echo"<font size='2'><a href='{$_SERVER['PHP_SELF']}?offset=$newoff&work=$work&class_year_b=$class_year_b&order_name={$_GET['order_name']}'><<</a></font>";
  }
  else
  {
    echo"<font size='2'><<</font>";
  }

  for($i=1;$i<=$numpage;$i++)
  {
    if((($i-1)*$limit)==$offset)
    {
      print"<font size='2'> [$i]</font> ";
    }
    else
    {
      $newoff=($i-1)*$limit;
      echo"<font size='2'><a href='{$_SERVER['PHP_SELF']}?offset=$newoff&work=$work&class_year_b=$class_year_b&order_name={$_GET['order_name']}'> [$i] </a></font>";
    }

  }

  if($offset!=$limit*($numpage-1))
  {
    $newoff=$offset+$limit;
    echo"<font size='2'><a href='{$_SERVER['PHP_SELF']}?offset=$newoff&work=$work&class_year_b=$class_year_b&order_name={$_GET['order_name']}'>>></a></font></td>";
  }
  else
  {
    echo"<font size='2'></font></td>";
  }
  echo"</tr></table>";
}
?>


<script language="JavaScript1.2">
<!-- Begin

function jumpMenu1(){
	var str, classstr ;
 if (document.form1.work.options[document.form1.work.selectedIndex].value!="") {
	location="<?PHP echo $_SERVER['PHP_SELF'] ?>?work=" + document.form1.work.options[document.form1.work.selectedIndex].value + "&class_year_b=" + document.form1.class_year_b.options[document.form1.class_year_b.selectedIndex].value;
	}
}

function jumpMenu4(){
	var str, classstr ;
    if ((document.form4.work.value!="")) {
	location="<?php echo $_SERVER['PHP_SELF'] ?>?work=" + document.form4.work.value + "&class_year_b=" + document.form4.class_year_b.value + "&sel_temp_class=" + document.form4.sel_temp_class.options[document.form4.sel_temp_class.selectedIndex].value;
    }
}

function jumpMenu6(){
	var str, classstr ;
    if ((document.form6.work.value!="")) {
	location="<?php echo $_SERVER['PHP_SELF'] ?>?work=" + document.form6.work.value + "&class_year_b=" + document.form6.class_year_b.value + "&sel_temp_class=" + document.form6.sel_temp_class.options[document.form6.sel_temp_class.selectedIndex].value;
    }
}
//  End -->
</script>
