<?php

// $Id: address_book.php 7706 2013-10-23 08:59:03Z smallduh $

/*�ޤJ�ǰȨt�γ]�w��*/
include "config.php";

$button["Excel"]="MS Office Excel ��";
$button["Word"]="MS Office Word ��";
$button["sxw"]="OpenOffice.org Writer ��";

//�ϥΪ̻{��
sfs_check();
if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
$teacher_sn=$_SESSION['session_tea_sn'];//���o�n�J�Ѯv��id
//��X���ЯZ��
$class_name=teacher_sn_to_class_name($teacher_sn);

//�Ӹ�O��
//�u�n�i�J�N�O��
$class_description=implode(",",$class_name);
$test=pipa_log("�Z�ųq�T��\r\n�Ǧ~�G$sel_year\r\n�Ǵ��G$sel_seme\r\n�Z�šG$class_description\r\n");		

if($_POST['Submit1']=="�U���Z�ųq�T��"){
  if ($_POST['print_key'] == "sxw")   
     echo ooo();
  else 
     print_key($sel_year,$sel_seme,$_POST['print_key'],$many_col) ;
}else{
	//�q�X����
	head("�Z�Ũư�");

	if ($_GET['act']=="") print_menu($menu_p);
	//�]�w�D������ܰϪ��I���C��
	$menu="
		<table cellspacing=2 cellpadding=2>
			<tr>
				<td>
					<form name='form1' method='post' action='{$_SERVER['PHP_SELF']}'>
					$import_option<input type='submit' name='Submit1' value='�U���Z�ųq�T��'>
					</form>
				</td>
			</tr>
		</table>";
	echo $menu;
    $seme_year_seme=sprintf("%03d",curr_year()).curr_seme();
    $sql="select stud_id,seme_num from stud_seme where seme_class='$class_name[0]' and  seme_year_seme='$seme_year_seme' order by  seme_num";
    $rs=$CONN->Execute($sql);
    $m=0;
    echo "<table bgcolor='#000000' border=0 cellspacing=1 cellpadding=2>
			<tr bgcolor='#FAF799'>
				<td colspan='2'>$class_name[1]</td>
				<td colspan='1'>�q��1</td>
				<td colspan='1'>�q��2</td>
				<td colspan='1'>�q��3</td>
				<td colspan='1'>��}1</td>
				<td colspan='1'>��}2</td>
			</tr>";
	while(!$rs->EOF){
        $stud_id[$m] = $rs->fields["stud_id"];
        $site_num[$m] = $rs->fields["seme_num"];
        $rs_name=$CONN->Execute("select stud_name,stud_tel_1,stud_tel_2,stud_tel_3,stud_addr_1,stud_addr_2 from stud_base where stud_id='$stud_id[$m]' and stud_study_cond =0 ");
        if ($rs_name->fields["stud_name"]) {
          $stud_name[$m] = $rs_name->fields["stud_name"];
		$stud_addr_1[$m] = $rs_name->fields["stud_addr_1"];
		$stud_addr_2[$m] = $rs_name->fields["stud_addr_2"];
		$stud_tel_1[$m] = $rs_name->fields["stud_tel_1"];
		$stud_tel_2[$m] = $rs_name->fields["stud_tel_2"];
		$stud_tel_3[$m] = $rs_name->fields["stud_tel_3"];
          echo "<tr bgcolor='#FFFFFF'>
				<td>$site_num[$m]</td>
				<td>$stud_name[$m]</td>
				<td>$stud_tel_1[$m]</td>
				<td>$stud_tel_2[$m]</td>
				<td>$stud_tel_3[$m]</td>
				<td>$stud_addr_1[$m]</td>
				<td>$stud_addr_2[$m]</td>
			  </tr>";
		$m++;
	}	
        $rs->MoveNext();
    }
	echo "</table>";
	//�����D������ܰ�
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	//�{���ɧ�
	foot();
}

//�C�L���
function print_key($sel_year="",$sel_seme="",$print_key="",$cols=""){
	global $CONN, $class_name;
	
	
	//��X��excel�Bword	
	if ($print_key=="Excel")
		$filename =  "name.xls"; 	
	else if ($print_key=="Word")
		$filename =  "name.doc";
	header("Content-disposition: filename=$filename");
	header("Content-type: application/octetstream");
	//header("Pragma: no-cache");
					//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");

	header("Expires: 0");
	
    $seme_year_seme=sprintf("%03d",curr_year()).curr_seme();
    $sql="select stud_id,seme_num from stud_seme where seme_class='$class_name[0]' and  seme_year_seme='$seme_year_seme' order by  seme_num";
    $rs=$CONN->Execute($sql);
    $m=0;
    echo "<table  border=1 cellspacing=1 cellpadding=2 width=95%>
			<tr  >
				<td colspan='2'>$class_name[1]</td>
				<td colspan='1'>�q��1</td>
				<td colspan='1'>�q��2</td>
				<td colspan='1'>�q��3</td>
				<td colspan='1'>��}1</td>
				<td colspan='1'>��}2</td>
			</tr>";
	while(!$rs->EOF){
        $stud_id[$m] = $rs->fields["stud_id"];
        $site_num[$m] = $rs->fields["seme_num"];
        $rs_name=$CONN->Execute("select stud_name,stud_tel_1,stud_tel_2,stud_tel_3,stud_addr_1,stud_addr_2 from stud_base where stud_id='$stud_id[$m]' and stud_study_cond =0 ");
        if ($rs_name->fields["stud_name"]) {
          $stud_name[$m] = $rs_name->fields["stud_name"];
		$stud_addr_1[$m] = $rs_name->fields["stud_addr_1"];
		$stud_addr_2[$m] = $rs_name->fields["stud_addr_2"];
		$stud_tel_1[$m] = $rs_name->fields["stud_tel_1"];
		$stud_tel_2[$m] = $rs_name->fields["stud_tel_2"];
		$stud_tel_3[$m] = $rs_name->fields["stud_tel_3"];
          echo "<tr >
				<td>$site_num[$m]</td>
				<td>$stud_name[$m]</td>
				<td>$stud_tel_1[$m]</td>
				<td>$stud_tel_2[$m]</td>
				<td>$stud_tel_3[$m]</td>
				<td>$stud_addr_1[$m]</td>
				<td>$stud_addr_2[$m]</td>
			  </tr>";
		$m++;
	}	
        $rs->MoveNext();
    }
	echo "</table>";

	exit;
}

function ooo(){
	global $CONN,$class_name;

	$oo_path = "ooo_addressbook";

	$filename="addressbook".$class_name[0].".sxw";

    //�s�W�@�� zipfile ���
	$ttt = new EasyZip;
	$ttt->setPath($oo_path);
	$ttt->addDir('META-INF');
	$ttt->addfile("settings.xml");
	$ttt->addfile("styles.xml");
	$ttt->addfile("meta.xml");

	//Ū�X content.xml
	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/content.xml");

	//�N content.xml �� tag ���N
    //$class_name=teacher_sn_to_class_name($_SESSION['session_tea_sn']);
    $seme_year_seme=sprintf("%03d",curr_year()).curr_seme();
    $sql="select stud_id,seme_num from stud_seme where seme_class='$class_name[0]' and  seme_year_seme='$seme_year_seme' order by seme_num";
    $rs=$CONN->Execute($sql);
    $m=0;
    while(!$rs->EOF){
        $stud_id[$m] = $rs->fields["stud_id"];
        $site_num[$m] = $rs->fields["seme_num"];
        $rs_name=$CONN->Execute("select stud_name,stud_tel_1,stud_tel_2,stud_tel_3,stud_addr_1,stud_addr_2 from stud_base where stud_id='$stud_id[$m]' and stud_study_cond =0  ");
        if ($rs_name->fields["stud_name"]) {
          $stud_name[$m] = $rs_name->fields["stud_name"];
		$stud_addr_1[$m] = $rs_name->fields["stud_addr_1"];
		$stud_addr_2[$m] = $rs_name->fields["stud_addr_2"];
		$stud_tel_1[$m] = $rs_name->fields["stud_tel_1"];
		$stud_tel_2[$m] = $rs_name->fields["stud_tel_2"];
		$stud_tel_3[$m] = $rs_name->fields["stud_tel_3"];
          $m++;
        }  
        $rs->MoveNext();
    }
	$head="
		<table:table-header-rows>
		<table:table-row>
		<table:table-cell table:style-name='course_tbl.A1' table:number-columns-spanned='2' table:value-type='string'>
		<text:p text:style-name='P1'>$class_name[1]
		</text:p>
		</table:table-cell>
		<table:covered-table-cell/>
		<table:table-cell table:style-name='course_tbl.C1' table:value-type='string'>
		<text:p text:style-name='P1'>�q��1
		</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.C1' table:value-type='string'>
		<text:p text:style-name='P1'>�q��2
		</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.C1' table:value-type='string'>
		<text:p text:style-name='P1'>�q��3
		</text:p></table:table-cell>
		<table:table-cell table:style-name='course_tbl.C1' table:value-type='string'>
		<text:p text:style-name='P1'>��}1
		</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.G1' table:value-type='string'>
		<text:p text:style-name='P1'>��}2
		</text:p>
		</table:table-cell>
		</table:table-row>
		</table:table-header-rows>";


    for($i=0;$i<count($stud_id);$i++){
        $cont.="
		<table:table-row>
		<table:table-cell table:style-name='course_tbl.A2' table:value-type='string'>
		<text:p text:style-name='P2'>$site_num[$i]
		</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
		<text:p text:style-name='P2'>$stud_name[$i]
		</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
		<text:p text:style-name='P2'>$stud_tel_1[$i]
		</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
		<text:p text:style-name='P2'>$stud_tel_2[$i]
		</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
		<text:p text:style-name='P2'>$stud_tel_3[$i]
		</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
		<text:p text:style-name='P2'>$stud_addr_1[$i]
		</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.G2' table:value-type='string'>
		<text:p text:style-name='P2'>$stud_addr_2[$i]
		</text:p>
		</table:table-cell>
		</table:table-row>";
    }

    $temp_arr["head"] = $head;
	$temp_arr["cont"] = $cont;
	// change_temp �|�N�}�C���� big5 �ର UTF-8 �� openoffice �i�HŪ�X
	$replace_data = $ttt->change_temp($temp_arr,$data,0);

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
