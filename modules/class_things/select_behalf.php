<?php

// $Id: select_behalf.php 7706 2013-10-23 08:59:03Z smallduh $

/*�ޤJ�ǰȨt�γ]�w��*/
include "config.php";

//�ϥΪ̻{��
sfs_check();
if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
$teacher_sn=$_SESSION['session_tea_sn'];//���o�n�J�Ѯv��id
//��X���ЯZ��
$class_name=teacher_sn_to_class_name($teacher_sn);
 //���o�Z�Ůa���ξǥͩm�W
	$rs_name=$CONN->Execute("select sb.stud_id, sd.guardian_name from stud_base as sb, stud_domicile as sd where sb.student_sn=sd.student_sn and sb.curr_class_num like '$class_name[0]%' and sb.stud_study_cond =0");
	while(!$rs_name->EOF){
		$rs_name_arr[$rs_name->fields[stud_id]] = $rs_name->fields[guardian_name];
		$rs_name->MoveNext();	
	}


if($_POST['Submit1']=="�U���Z�N�����") {
  if ($_POST['print_key'] == "sxw")   
     echo ooo();
  else 
     print_key($sel_year,$sel_seme,$print_key,$many_col) ;
}else{
	//�q�X����
	head("�Z�Ũư�");

	if ($_GET['act']=="") print_menu($menu_p);
	//�]�w�D������ܰϪ��I���C��
	$menu="
		<table cellspacing=2 cellpadding=2>
			<tr>
				<td>
					<form name='form1' method='post' action='{$_SERVER['SCRIPT_NAME']}'>
					$import_option<input type='submit' name='Submit1' value='�U���Z�N�����'>
					</form>
				</td>
			</tr>
		</table>";
	echo $menu;
    $seme_year_seme=sprintf("%03d",curr_year()).curr_seme();
       $sql="select a.stud_id,a.seme_num,b.stud_name from stud_seme a, stud_base b where a.student_sn=b.student_sn and a.seme_class='$class_name[0]' and a.seme_year_seme='$seme_year_seme' and b.stud_study_cond =0 order by a.seme_num";
    $rs=$CONN->Execute($sql);
    //   echo $sql ;
    $m=0;
    echo "<table bgcolor='#000000' border=0 cellspacing=1 cellpadding=2>
			<tr bgcolor='#FAF799'>
				<td>���B</td>
				<td>�a���m�W</td>
				<td>�ǥͩm�W</td>
				<td></td>
				<td>���B</td>
				<td>�a���m�W</td>
				<td>�ǥͩm�W</td>
			</tr>";
	
	while(!$rs->EOF){
		$stud_id[$m] = $rs->fields["stud_id"];
		$site_num[$m] = $rs->fields["seme_num"];
		$stud_name[$m] = $rs->fields["stud_name"];
		$guardian_name[$m] = $rs_name_arr[$rs->fields["stud_id"]];
        	if($m%2=="0") echo "<tr bgcolor='#FFFFFF'>";
		echo "<td></td>
			  <td>$guardian_name[$m]</td>
			  <td>$stud_name[$m]</td>";
		if($m%2=="0") echo "<td>&nbsp;</td>";
		if($m%2=="1") echo "</tr>";
		$m++;
        	$rs->MoveNext();
	}

	if($m%2=="1")echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"; 
	echo "</table>";
	//�����D������ܰ�
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	//�{���ɧ�
	foot();
}

//�C�L���
function print_key($sel_year="",$sel_seme="",$print_key="",$cols=0){
	global $CONN, $class_name ,$rs_name_arr;
	
	
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
       $sql="select a.stud_id,a.seme_num,b.stud_name from stud_seme a, stud_base b where a.student_sn=b.student_sn and a.seme_class='$class_name[0]' and  a.seme_year_seme='$seme_year_seme' and b.stud_study_cond =0 order by a.seme_num";
    $rs=$CONN->Execute($sql);
    //   echo $sql ;
    $m=0;
    echo "<table  border=1 cellspacing=1 cellpadding=2 widht = 95%>
			<tr >
				<td>���B</td>
				<td>�a���m�W</td>
				<td>�ǥͩm�W</td>
				<td></td>
				<td>���B</td>
				<td>�a���m�W</td>
				<td>�ǥͩm�W</td>
			</tr>";
	
	while(!$rs->EOF){
		$stud_id[$m] = $rs->fields["stud_id"];
		$site_num[$m] = $rs->fields["seme_num"];
		$stud_name[$m] = $rs->fields["stud_name"];
		$guardian_name[$m] = $rs_name_arr[$rs->fields["stud_id"]];
        	if($m%2=="0") echo "<tr >";
		echo "<td></td>
			  <td>$guardian_name[$m]</td>
			  <td>$stud_name[$m]</td>";
		if($m%2=="0") echo "<td>&nbsp;</td>";
		if($m%2=="1") echo "</tr>";
		$m++;
        	$rs->MoveNext();
	}

	if($m%2=="1")echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>"; 
	echo "</table>";

	exit;
}

function ooo(){
	global $CONN,$class_name,$rs_name_arr;

	$oo_path = "ooo_behalf";

	$filename="behalf".$class_name[0].".sxw";

    //�s�W�@�� zipfile ���
	$ttt = new zipfile;

	//Ū�X xml �ɮ�
	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/META-INF/manifest.xml");

	//�[�J xml �ɮר� zip ���A�@�������ɮ�
	//�Ĥ@�ӰѼƬ���l�r��A�ĤG�ӰѼƬ� zip �ɮת��ؿ��M�W��
	$ttt->add_file($data,"/META-INF/manifest.xml");

	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/settings.xml");
	$ttt->add_file($data,"settings.xml");

	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/styles.xml");
	$ttt->add_file($data,"styles.xml");

	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/meta.xml");
	$ttt->add_file($data,"meta.xml");

	//Ū�X content.xml
	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/content.xml");

	//�N content.xml �� tag ���N
    //$class_name=teacher_sn_to_class_name($_SESSION['session_tea_sn']);
    $seme_year_seme=sprintf("%03d",curr_year()).curr_seme();
    $sql="select a.stud_id,a.seme_num,b.stud_name from stud_seme a, stud_base b where a.student_sn=b.student_sn and a.seme_class='$class_name[0]' and a.seme_year_seme='$seme_year_seme' and b.stud_study_cond =0 order by a.seme_num";
 
    $rs=$CONN->Execute($sql);
    $m=0;
	while(!$rs->EOF){
	        $stud_id[$m] = $rs->fields["stud_id"];
		$site_num[$m] = $rs->fields["seme_num"];
		$stud_name[$m] = $rs->fields["stud_name"];
		$guardian_name[$m] = $rs_name_arr[$rs->fields["stud_id"]];
		$m++;
		$rs->MoveNext();
    }
	$title=" ".$class_name[1]." �Z�N�����";
	$head="
		<table:table-header-rows>
		<table:table-row>
		<table:table-cell table:style-name='course_tbl.A1' table:value-type='string'>
		<text:p text:style-name='P2'>���B
		</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.B1' table:value-type='string'>
		<text:p text:style-name='P2'>�a���m�W
		</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.B1' table:value-type='string'>
		<text:p text:style-name='P2'>�ǥͩm�W
		</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.D1' table:value-type='string'>
		<text:p text:style-name='P2'/>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.B1' table:value-type='string'>
		<text:p text:style-name='P2'>���B
		</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.B1' table:value-type='string'>
		<text:p text:style-name='P2'>�a���m�W
		</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.G1' table:value-type='string'>
		<text:p text:style-name='P2'>�ǥͩm�W
		</text:p>
		</table:table-cell>
		</table:table-row>
		</table:table-header-rows>";


    for($i=0;$i<count($stud_id);$i++){
        if($i%2=="0"){
		$cont.="<table:table-row>
		<table:table-cell table:style-name='course_tbl.A2' table:value-type='string'>
		<text:p text:style-name='P3'/>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
		<text:p text:style-name='P3'>$guardian_name[$i]
		</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
		<text:p text:style-name='P3'>$stud_name[$i]
		</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.D2' table:value-type='string'>
		<text:p text:style-name='P3'/>
		</table:table-cell>";
		$is_not_end = TRUE ;
		}

		if($i%2=="1") {
		$cont.="
		<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
		<text:p text:style-name='P3'/>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
		<text:p text:style-name='P3'>$guardian_name[$i]
		</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.G2' table:value-type='string'>
		<text:p text:style-name='P3'>$stud_name[$i]
		</text:p>
		</table:table-cell>
		</table:table-row>";
		$is_not_end = FALSE ;
		}
    }
    if($is_not_end){
		$cont.="
		<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
		<text:p text:style-name='P3'/>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.B2' table:value-type='string'>
		<text:p text:style-name='P3'>
		</text:p>
		</table:table-cell>
		<table:table-cell table:style-name='course_tbl.G2' table:value-type='string'>
		<text:p text:style-name='P3'>
		</text:p>
		</table:table-cell>
		</table:table-row>";}
    
	$temp_arr["title"] = $title;
    $temp_arr["head"] = $head;
	$temp_arr["cont"] = $cont;
	// change_temp �|�N�}�C���� big5 �ର UTF-8 �� openoffice �i�HŪ�X
	$replace_data = $ttt->change_temp($temp_arr,$data,0);

	// �[�J content.xml ��zip ��
	$ttt->add_file($replace_data,"content.xml");

	//���� zip ��
	$sss = $ttt->file();

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
