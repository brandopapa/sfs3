<?php

// $Id: address_book2.php 7704 2013-10-23 08:51:29Z smallduh $

/*�ޤJ�ǰȨt�γ]�w��*/
include "../../include/config.php";
include "../../include/sfs_oo_zip2.php";
include_once "../../include/sfs_case_PLlib.php";

//�ޤJ���
//include "./my_fun.php";
require_once "./module-cfg.php";

//�ϥΪ̻{��
sfs_check();


if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�

$sel_year = $_POST['sel_year'] ;
$allyear = $_POST['allyear'] ;
if ($allyear) $chk_allyear = "checked" ;

if ($sel_year=="") $sel_year ="101" ;


$class_name_arr = class_base() ;
$class_name[0]= $sel_year ;
$class_name[1]= $class_name_arr[$sel_year] ;


$oo_path = "oooo";
$sex_arr= array(1=>"�k" ,2 =>"�k") ;
$print_key = $_POST[print_key];

if($_POST['Submit1']=="�U���Z�ųq�T��"){
  if ($print_key == "sxw")
     echo ooo($sel_year,$sel_seme);
  else
     print_key($sel_year,$sel_seme,$print_key,$allyear) ;
}else{
	//�q�X����
	head("���կZ�ŦW�U");

	if ($_GET['act']=="") print_menu($menu_p);
	//�]�w�D������ܰϪ��I���C��


		$sel1 = new drop_select(); //������O
		$sel1->s_name = "sel_year"; //���W��
		$sel1->id = $sel_year;
		$sel1->has_empty = false;
		$sel1->arr = $class_name_arr ; //���e�}�C(���ӾǦ~)
		$sel1->is_submit = true;
		$sel1->bgcolor = "#DDFFEE";
		$sel1->font_style ="font-size: 15px;font-weight: bold";
    $class_select =  $sel1->get_select();

    $data_array = get_class_data($sel_year,$sel_seme) ;



    //�ϥμ˪�
    $template_dir = $SFS_PATH."/".get_store_path()."/templates";
    // �ϥ� smarty tag
    $smarty->left_delimiter="{{";
    $smarty->right_delimiter="}}";
    //$smarty->debugging = true;

    $smarty->assign("class_select",$class_select);
    $smarty->assign("import_option",$import_option);
    $smarty->assign("data_array",$data_array);


    $smarty->assign("template_dir",$template_dir);

    $smarty->display("$template_dir/address.htm");


	foot();
}

//���o��ư}�C
function get_class_data($sel_year="",$sel_seme="",$print_key="" ,$allyear=0){
    global $CONN, $class_name ,$sex_arr , $class_name_arr;

    $classid_search =  " = '$sel_year' ";

    //���Ǧ~
    if ($allyear)
       	$classid_search =  " like '" . substr($sel_year,0,1) ."%'";


    $seme_year_seme=sprintf("%03d",curr_year()).curr_seme();
    $sql="select s.stud_id,s.seme_num ,seme_class from stud_seme s , stud_base b where s.stud_id=b.stud_id and  b.stud_study_cond =0 and s.seme_class $classid_search and  s.seme_year_seme='$seme_year_seme' order by  s.seme_class ,s.seme_num";
    $rs=$CONN->Execute($sql);


    while(!$rs->EOF){

	      $row_data[classname] = $class_name_arr[$rs->fields["seme_class"]] ;
        $row_data[stud_id] = $rs->fields["stud_id"];
        $row_data[site_num] = $rs->fields["seme_num"];
        $rs_name=$CONN->Execute("select b.* , d.*  from stud_base b  LEFT JOIN stud_domicile d  ON b.student_sn=d.student_sn
         where b.stud_id='$row_data[stud_id]'  and b.stud_study_cond =0 ");
        $row_data[stud_name] = $rs_name->fields["stud_name"];
		$row_data[stud_name_eng] = $rs_name->fields["stud_name_eng"];
		    $row_data[stud_addr_1] = $rs_name->fields["stud_addr_1"];
		    $row_data[stud_addr_2] = $rs_name->fields["stud_addr_2"];
		    $row_data[stud_tel_1] = $rs_name->fields["stud_tel_1"];
		    $row_data[stud_tel_2] = $rs_name->fields["stud_tel_2"];
		    $row_data[stud_tel_3] = $rs_name->fields["stud_tel_3"];
		    $row_data[stud_person_id] = $rs_name->fields["stud_person_id"];
		    $row_data[stud_sex] = $sex_arr[$rs_name->fields["stud_sex"]];
		    if ($print_key == "Excel")
		       $row_data[stud_birthday] = $rs_name->fields["stud_birthday"];
		    else
		       $row_data[stud_birthday] = DtoCh($rs_name->fields["stud_birthday"]);

        $row_data[d_guardian_name] =$rs_name->fields["guardian_name"]  ;
        $row_data[guardian_unit] =$rs_name->fields["guardian_unit"]  ;
        $row_data[guardian_work_name] =$rs_name->fields["guardian_work_name"]  ;

        $data[] = $row_data ;
        $rs->MoveNext();
    }
	//echo "<PRE>";
	//print_r($data);
	//echo "</PRE>";

  return $data ;

}


//�C�L���
function print_key($sel_year="",$sel_seme="",$print_key="" ,$allyear=0){
	global $CONN, $class_name ,$sex_arr , $SFS_PATH ,$smarty ;


	//��X��excel�Bword
	if ($print_key=="Excel")
		$filename =  "name.xls";
	else if ($print_key=="Word")
		$filename =  "name.doc";

	header("Content-disposition: filename=$filename");
	header("Content-type: application/octetstream ; Charset=Big5");
	//header("Pragma: no-cache");
					//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");

	header("Expires: 0");

    $data_array = get_class_data($sel_year,$sel_seme,$print_key ,$allyear) ;



    //�ϥμ˪�
    $template_dir = $SFS_PATH."/".get_store_path()."/templates";

    // �ϥ� smarty tag
    $smarty->left_delimiter="{{";
    $smarty->right_delimiter="}}";
    //$smarty->debugging = true;


    $smarty->assign("data_array",$data_array);


    $smarty->assign("template_dir",$template_dir);

    $smarty->display("$template_dir/address_exec.htm");

	exit;
}

function ooo($sel_year,$sel_seme){
	global $CONN, $class_name , $allyear  ,$oo_path;



	$filename="addressbook".$class_name[0].".sxw";
	$break ="<text:p text:style-name=\"break_page\"/>";
	$ttt = new EasyZip;
	$ttt->setpath($oo_path);
	$ttt->addDir('META-INF');
	$ttt->addfile('settings.xml');
	$ttt->addfile('styles.xml');
	$ttt->addfile('meta.xml');


	//Ū�X content.xml
	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/content_doc.xml");


        set_time_limit(180) ;


        if ( $allyear ) {
            $seme_year_seme=sprintf("%03d",curr_year()).curr_seme();
            $sql="select seme_class from stud_seme where seme_class like '$sel_year[0]%' and  seme_year_seme ='$seme_year_seme' group by  seme_class ";

            $rs=$CONN->Execute($sql);
            $m=0;

            while(!$rs->EOF){
               $class_id = $rs->fields["seme_class"];

               $cont .= all_ooo($class_id , $sel_seme ) . $break ;

               $m++;
               $rs->MoveNext();
            }
        }
        else  $cont = all_ooo($sel_year , $sel_seme ) ;


	$temp_arr["cont"] = $cont;
	// change_temp �|�N�}�C���� big5 �ର UTF-8 �� openoffice �i�HŪ�X
	$replace_data = $ttt->change_temp2($temp_arr,$data);

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



function all_ooo($class_id , $sel_seme ) {
	global $CONN,$class_name ,$oo_path ,$sex_arr;

        //�s�W�@�� zipfile ���
    $ttt = new EasyZip;

    $addr_head = $ttt->read_file(dirname(__FILE__)."/$oo_path/content_head.xml");
    $addr_line = $ttt->read_file(dirname(__FILE__)."/$oo_path/content_row.xml");
    $cont = $addr_head;

    unset($data_array) ;
    $data_array = get_class_data($class_id,$sel_seme) ;


    foreach (	$data_array as $k => $row_data) {

        $temp_arr["class"] = $row_data[classname] ;
        $temp_arr["cid"] = $row_data[stud_id] ;
        $temp_arr["num"] = $row_data[site_num] ;
        $temp_arr["sex"] = $row_data[stud_sex] ;
        $temp_arr["name"] = $row_data[stud_name] ;
		$temp_arr["name_eng"] = $row_data[stud_name_eng] ;
        $temp_arr["pid"] = $row_data[stud_person_id] ;
        $temp_arr["birth"] = $row_data[stud_birthday] ;
        $temp_arr["addr"] = $row_data[stud_addr_1]  ;
        $temp_arr["tel1"] = $row_data[stud_tel_1] ;
        $temp_arr["parent"] = $row_data[d_guardian_name] ;
        $temp_arr["work"] = $row_data[guardian_unit] ;
        $temp_arr["worker"] = $row_data[guardian_work_name] ;
        $temp_arr["tel2"] = $row_data[stud_tel_2i] ;

        $replace_data = $ttt->change_temp($temp_arr,$addr_line);

        $cont.= $replace_data ;
    }
    $cont.= '</table:table>' ;
    return  $cont ;

}
?>
