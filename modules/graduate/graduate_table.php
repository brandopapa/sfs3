<?php

// $Id: graduate_table.php 7707 2013-10-23 12:13:23Z smallduh $

/*�ޤJ�ǰȨt�γ]�w��*/
require "config.php";

if($_GET['class_year_b']) $class_year_b=$_GET['class_year_b'];
else $class_year_b=$_POST['class_year_b'];
if($_GET['select_seme_year']) $select_seme_year=$_GET['select_seme_year'];
else $select_seme_year=$_POST['select_seme_year'];
if($_GET['order_name']) $order_name=$_GET['order_name'];
else $order_name=$_POST['order_name'];
if($_GET['class_id']) $class_id=$_GET['class_id'];
else $class_id=$_POST['class_id'];
if($_GET['dfile']) $dfile=$_GET['dfile'];
else $dfile=$_POST['dfile'];

//�ϥΪ̻{��
sfs_check();

if($dfile=="csv"){
	$filename="grad".$select_seme_year.$class_id.".csv";
	header("Content-disposition: filename=$filename");
	header("Content-type: application/octetstream ; Charset=Big5");
	//header("Pragma: no-cache");
					//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");

    header("Expires: 0");
	if($class_id) {
		$class_id_arr=explode("_",$class_id);
		$class_year=intval($class_id_arr[2]);
		$class_sort=intval($class_id_arr[3]);
		$where=" where gs.stud_grad_year='$select_seme_year' and class_year='$class_year' and class_sort='$class_sort' and gs.stud_id=sb.stud_id and sb.stud_id=sd.stud_id";
	}
	else $where=" where gs.stud_grad_year='$select_seme_year' and gs.stud_id=sb.stud_id and sb.stud_id=sd.stud_id";
	$sql_csv="select gs.* ,sb.stud_person_id,sb.stud_name,sb.stud_sex,sb.stud_tel_1,sb.stud_birthday,sb.stud_addr_1,sd.guardian_name from grad_stud as gs, stud_base as sb ,stud_domicile as sd $where";
	$rs_csv=$CONN->Execute($sql_csv);
	$i=0;
	echo "�J�Ǧ~�A�®զW�A�����Ҧr���A�m�W�A�ʧO�A�q�ܡA�ͤ�]�褸�^�A�a���m�W�A��}";
	while(!$rs_csv->EOF){
		$stud_study_year[$i]=$rs_csv->fields['stud_grad_year']+1;
		$old_school[$i]=$school_short_name;
		$stud_person_id[$i]=$rs_csv->fields['stud_person_id'];
		$stud_name[$i]=$rs_csv->fields['stud_name'];
		$stud_sex[$i]=$rs_csv->fields['stud_sex'];
		$stud_tel_1[$i]=$rs_csv->fields['stud_tel_1'];
		$stud_birthday[$i]=$rs_csv->fields['stud_birthday'];
		$guardian_name[$i]=$rs_csv->fields['guardian_name'];
		$stud_addr_1[$i]=$rs_csv->fields['stud_addr_1'];
		echo "\n$stud_study_year[$i],$old_school[$i],$stud_person_id[$i],$stud_name[$i],$stud_sex[$i],$stud_tel_1[$i],$stud_birthday[$i],$guardian_name[$i],$stud_addr_1[$i]";
		$rs_csv->MoveNext();
		$i++;
	}
}

elseif($dfile=="sxw"){
	echo ooo();
}

else{
	//�{�����Y
	head("���~�ͧ@�~");

	$menu_p = array("graduate_out.php"=>"���~��X","graduate_table.php"=>"���~�ͦW�U", "graduate_score.php"=>"���~���Z");
	print_menu($menu_p);
	//�]�w�D������ܰϪ��I���C��
	echo "
	<table border=0 cellspacing=1 cellpadding=2 width=100% bgcolor=#cccccc>
	<tr>
	<td bgcolor='#FFFFFF'>";
	//�������e�иm�󦹳B
	if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
	if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
	$new_sel_year=date("Y")-1911;//�ثe����~

	//���~�U�Կ��stud_seme 
	if($select_seme_year) {
		if($class_id) {
			$class_id_arr=explode("_",$class_id);
			$class_year=intval($class_id_arr[2]);
			$class_sort=intval($class_id_arr[3]);
			$where=" where gs.stud_grad_year='$select_seme_year' and class_year='$class_year' and class_sort='$class_sort' and gs.stud_id=sb.stud_id and sb.stud_id=sd.stud_id";
		}
		else $where=" where gs.stud_grad_year='$select_seme_year' and gs.stud_id=sb.stud_id and sb.stud_id=sd.stud_id";
	}
	else $where=" where gs.stud_id=sb.stud_id and sb.stud_id=sd.stud_id";
	if($order_name) $sql="select gs.*,sb.stud_person_id,sb.stud_name,sb.stud_sex,sb.stud_tel_1,sb.stud_birthday,sb.stud_addr_1,sd.guardian_name from grad_stud as gs, stud_base as sb ,stud_domicile as sd $where order by $order_name";
	else $sql="select gs.* ,sb.stud_person_id,sb.stud_name,sb.stud_sex,sb.stud_tel_1,sb.stud_birthday,sb.stud_addr_1,sd.guardian_name from grad_stud as gs, stud_base as sb ,stud_domicile as sd $where";
	$rs=$CONN->Execute($sql);
	$i=0;
	while(!$rs->EOF){
		$stud_grad_year[$i]=$rs->fields['stud_grad_year'];
		$stud_id[$i]=$rs->fields['stud_id'];
		$rs->MoveNext();
		$i++;
	}
	$seme_year = array_unique ($stud_grad_year);
	$col_name="select_seme_year";
	$id=$select_seme_year;
	$menu="<option value=''>��ܾǦ~��</option>\n";
	while(list($key , $val) = each($seme_year)) {
		$selected=($id==$val)?"selected":"";
		$menu.="<option value='$val' $selected>".$val."�Ǧ~��</option>\n";

	}
	$seme_year_menu="
		<form name='form1' method='post' action='{$_SERVER['PHP_SELF']}'>
			<select name='$col_name' onChange='jumpMenu1()'>
				$menu
			</select>
		</form>";


	if($select_seme_year){
	//��ܯZ��
	$class_select_menu=&get_class_select($select_seme_year,2,$Cyear,$col_name="class_id",$jump_fn="jumpMenu2",$class_id,$mode="��");
	$class_select_obj="
		<form name='form2' method='post' action='{$_SERVER['PHP_SELF']}'>
		$class_select_menu
		<input type='hidden' name='select_seme_year' value='$select_seme_year'>
		</form>
	";
	}
	echo "<table border='0'><tr><td>".$seme_year_menu."</td><td>".$class_select_obj."</td><td><a href='{$_SERVER['PHP_SELF']}?select_seme_year=$select_seme_year&class_id=$class_id&dfile=csv'><span class='button'>�U��csv��</span></a></td><td><a href='{$_SERVER['PHP_SELF']}?select_seme_year=$select_seme_year&class_id=$class_id&dfile=sxw'><span class='button'>�U��sxw��</span></a></td></tr>";

	//�C�X�W��
	if($select_seme_year){
		echo "<tr><td colspan='4'><table bgcolor='black' border='0' cellpadding='2' cellspacing='1'>
					<tr bgcolor='#FFEC6E'>
						<td colspan='7'>".$school_long_name." ".$select_seme_year."�Ǧ~�ײ��~�ͦW�U</td>
					</tr>
					<tr bgcolor='#FFEC6E'>
						<td><a href='{$_SERVER['PHP_SELF']}?select_seme_year=$select_seme_year&class_id=$class_id&order_name=sb.stud_person_id'>�m�W</a></td>
						<td><a href='{$_SERVER['PHP_SELF']}?select_seme_year=$select_seme_year&class_id=$class_id&order_name=sb.stud_person_id'>�����Ҧr��</a></td>
						<td><a href='{$_SERVER['PHP_SELF']}?select_seme_year=$select_seme_year&class_id=$class_id&order_name=sb.stud_sex'>�ʧO</a></td>
						<td><a href='{$_SERVER['PHP_SELF']}?select_seme_year=$select_seme_year&class_id=$class_id&order_name=sb.stud_tel_1'>�q��</a></td>
						<td><a href='{$_SERVER['PHP_SELF']}?select_seme_year=$select_seme_year&class_id=$class_id&order_name=sb.stud_birthday'>�ͤ�</a></td>
						<td><a href='{$_SERVER['PHP_SELF']}?select_seme_year=$select_seme_year&class_id=$class_id&order_name=sd.guardian_name'>�a���m�W</a></td>
						<td><a href='{$_SERVER['PHP_SELF']}?select_seme_year=$select_seme_year&class_id=$class_id&order_name=sb.stud_addr_1'>��}</a></td>

					</tr>";
		$clear_stud_id = array_unique ($stud_id);
		if($order_name) $orderby=" order by $order_name";
		while(list($key1 , $stud_val) = each($clear_stud_id)) {
			$sql_base="select sb.stud_person_id,sb.stud_name,sb.stud_sex,sb.stud_tel_1,sb.stud_birthday,sb.stud_addr_1,sd.guardian_name from stud_base as sb,stud_domicile as sd where sb.stud_id='$stud_val' and sd.stud_id='$stud_val'";
			$rs_base=$CONN->Execute($sql_base);
			$stud_person_id=$rs_base->fields['stud_person_id'];
			$stud_name=$rs_base->fields['stud_name'];
			$stud_sex=$rs_base->fields['stud_sex'];
			$stud_tel_1=$rs_base->fields['stud_tel_1'];
			$stud_birthday=$rs_base->fields['stud_birthday'];
			if($stud_birthday!="" || $stud_birthday!="0000-00-00") $stud_birthday=DtoCh($stud_birthday);
			else $stud_birthday="";
			$guardian_name=$rs_base->fields['guardian_name'];
			$stud_address=$rs_base->fields['stud_addr_1'];
			if($stud_sex=="1"){
					$bgc="#C7CAFD";
					$stud_sex_ch="�k";
			}
			elseif($stud_sex=="2"){
					$bgc="#F9C8FD";
					$stud_sex_ch="�k";
			}
			echo "<tr bgcolor='$bgc'>
				<td><font color='$fcolor'>$stud_name</font></td>
				<td><font color='$fcolor'>$stud_person_id</font></td>
				<td><font color='$fcolor'>$stud_sex_ch</font></td>
				<td><font color='$fcolor'>$stud_tel_1</font></td>
				<td><font color='$fcolor'>$stud_birthday</font></td>
				<td><font color='$fcolor'>$guardian_name</font></td>
				<td><font color='$fcolor'>$stud_address</font></td>
				</tr>";
		}
		echo "</table></td></tr></table>";
	}
	else echo "</table>";

	//�����D������ܰ�
	echo "</td>";
	echo "</tr>";
	echo "</table>";

	//�{���ɧ�
	foot();

?>

<script language="JavaScript1.2">
<!-- Begin

function jumpMenu1(){
	var str, classstr ;
 if (document.form1.select_seme_year.options[document.form1.select_seme_year.selectedIndex].value!="") {
	location="<?PHP echo $_SERVER['PHP_SELF'] ?>?select_seme_year=" + document.form1.select_seme_year.options[document.form1.select_seme_year.selectedIndex].value;
	}
}

function jumpMenu2(){
	var str, classstr ;
    if (document.form2.class_id.options[document.form2.class_id.selectedIndex].value!="") {
	location="<?PHP echo $_SERVER['PHP_SELF'] ?>?select_seme_year=" + document.form2.select_seme_year.value + "&class_id=" + document.form2.class_id.options[document.form2.class_id.selectedIndex].value;
	}
}
//  End -->
</script>

<?php
}

		function ooo(){
			global $CONN,$school_long_name,$class_id,$select_seme_year;

			$oo_path = "ooo_grad";

			$filename="grad".$select_seme_year.$class_id.".sxw";

			//�s�W�@�� zipfile ���
			$ttt = new EasyZip;
			$ttt->setPath($oo_path);
			$ttt->addDir('META-INF');
			$ttt->addfile("settings.xml");
			$ttt->addfile("styles.xml");
			$ttt->addfile("meta.xml");

			//Ū�X content.xml
			$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/content.xml");

			//�Ѹ�Ʈw���X�������
			if($class_id) {
				$class_id_arr=explode("_",$class_id);
				$class_year=intval($class_id_arr[2]);
				$class_sort=intval($class_id_arr[3]);
				$where=" where gs.stud_grad_year='$select_seme_year' and class_year='$class_year' and class_sort='$class_sort' and gs.stud_id=sb.stud_id and sb.stud_id=sd.stud_id";
			}
			else $where=" where gs.stud_grad_year='$select_seme_year' and gs.stud_id=sb.stud_id and sb.stud_id=sd.stud_id";
			$sql_sxw="select gs.* ,sb.stud_person_id,sb.stud_name,sb.stud_sex,sb.stud_tel_1,sb.stud_birthday,sb.stud_addr_1,sd.guardian_name from grad_stud as gs, stud_base as sb ,stud_domicile as sd $where";
			$rs_sxw=$CONN->Execute($sql_sxw);
			$i=0;
			while(!$rs_sxw->EOF){
				$stud_id[$i]=$rs_sxw->fields['stud_id'];
				$stud_study_year[$i]=$rs_sxw->fields['stud_grad_year']+1;
				$old_school[$i]=$school_short_name;
				$stud_person_id[$i]=$rs_sxw->fields['stud_person_id'];
				$stud_name[$i]=$rs_sxw->fields['stud_name'];
				$stud_sex[$i]=$rs_sxw->fields['stud_sex'];
				if($stud_sex[$i]=="1")	$stud_sex_ch[$i]="�k";
				elseif($stud_sex[$i]=="2")	$stud_sex_ch[$i]="�k";
				else	$stud_sex_ch[$i]="";
				$stud_tel_1[$i]=$rs_sxw->fields['stud_tel_1'];
				$stud_birthday[$i]=$rs_sxw->fields['stud_birthday'];
				if($stud_birthday[$i]!="" || $stud_birthday[$i]!="0000-00-00") $stud_birthday[$i]=DtoCh($stud_birthday[$i]);
				else $stud_birthday[$i]="";
				$guardian_name[$i]=$rs_sxw->fields['guardian_name'];
				$stud_addr_1[$i]=$rs_sxw->fields['stud_addr_1'];
				$rs_sxw->MoveNext();
				$i++;
			}
			//�N content.xml �� tag ���N
			$temp_arr["school_name"] = $school_long_name;
			$temp_arr["seme_year"] = $select_seme_year."�Ǧ~�ײ��~�ͦW�U";
			$temp_arr["title"]="
				<table:table-row>
					<table:table-cell table:style-name='course_tbl.A2' table:value-type='string'>
						<text:p text:style-name='P3'>�m�W</text:p>
					</table:table-cell>
					<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
						<text:p text:style-name='P3'>�����Ҹ�</text:p>
					</table:table-cell>
					<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
						<text:p text:style-name='P3'>�ʧO</text:p>
					</table:table-cell>
					<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
						<text:p text:style-name='P3'>�p���q��</text:p>
					</table:table-cell>
					<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
						<text:p text:style-name='P3'>�X�ͤ��</text:p>
					</table:table-cell>
					<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
						<text:p text:style-name='P3'>�a���m�W</text:p>
					</table:table-cell>
					<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
						<text:p text:style-name='P3'>��}</text:p>
					</table:table-cell>
					<table:table-cell table:style-name='course_tbl.H2' table:value-type='string'>
						<text:p text:style-name='P3'>�Ʀ�</text:p>
					</table:table-cell>
				</table:table-row>";
			for($i=0;$i<count($stud_id);$i++){
				$cont.="
				<table:table-row>
					<table:table-cell table:style-name='course_tbl.A2' table:value-type='string'>
						<text:p text:style-name='P3'>$stud_name[$i]</text:p>
					</table:table-cell>
					<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
						<text:p text:style-name='P3'>$stud_person_id[$i]</text:p>
					</table:table-cell>
					<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
						<text:p text:style-name='P3'>$stud_sex_ch[$i]</text:p>
					</table:table-cell>
					<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
						<text:p text:style-name='P3'>$stud_tel_1[$i]</text:p>
					</table:table-cell>
					<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
						<text:p text:style-name='P3'>$stud_birthday[$i]</text:p>
					</table:table-cell>
					<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
						<text:p text:style-name='P3'>$guardian_name[$i]</text:p>
					</table:table-cell>
					<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
						<text:p text:style-name='P3'>$stud_addr_1[$i]</text:p>
					</table:table-cell>
					<table:table-cell table:style-name='course_tbl.H2' table:value-type='string'>
						<text:p text:style-name='P3'/>
					</table:table-cell>
				</table:table-row>";
			}
			$temp_arr["cont"] = $cont;
			// change_temp �|�N�}�C���� big5 �ର UTF-8 �� openoffice �i�HŪ�X
			$replace_data = $ttt->change_temp($temp_arr,$data);

			// �[�J content.xml ��zip ��
			$ttt->add_file($replace_data,"content.xml");

			//���� zip ��
			$sss = & $ttt->file();

			//�H��y�覡�e�X ooo.sxw
			header("Content-disposition: attachment; filename=$filename");
			header("Content-type: application/vnd.sun.xml.writer");
			//header("Pragma: no-cache");
							//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");

			header("Expires: 0");

			echo $sss;

			exit;
			return;
		}
?>
