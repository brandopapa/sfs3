<?php

// $Id $

// ���J�]�w��
include "stud_reg_config.php";
// �{���ˬd
sfs_check();

//�ɯ��ˬd 
require "module-upgrade.php";


//�L�X���Y
head();

if ($stud_id=='')
$stud_id= $_GET[stud_id];
if ($stud_id=='')
$stud_id= $_POST[stud_id];

///���s���r��
$linkstr = "stud_id=$stud_id&c_curr_class=$c_curr_class&c_curr_seme=$c_curr_seme";

//�Ҳտ��
print_menu($menu_p,$linkstr);


//���o���ЯZ�ťN��
$class_num = get_teach_class();
if ($class_num == '') {
	head("�v�����~");
	stud_class_err();
	foot();
	exit;
}
$this_year = sprintf("%03d",curr_year());

//�ثe�Ǧ~�Ǵ�
$this_seme_year_seme = sprintf("%03d%d",curr_year(),curr_seme());

$sel_seme_year_seme = $_POST[sel_seme_year_seme];
if ($sel_seme_year_seme=='')
	$sel_seme_year_seme = $this_seme_year_seme;

$stud_id = $_GET[stud_id];
if ($stud_id == '')
	$stud_id = $_POST[stud_id];


$do_key = $_GET[do_key];
if ($do_key == '')
	$do_key = $_POST[do_key];

switch($do_key) {


	//�R��
	case "delete":
	$query = "delete  from stud_ext_data where mid='$_GET[mid]' and stud_id='$_GET[stud_id]'";
	$CONN->Execute($query);
	break;
	
	//�s�W
	case $newBtn: 
	$n_day = date("Y-m-d") ;
	$sql_insert = "insert into stud_ext_data (stud_id , mid ,ext_data ,teach_id ,ed_date) 
	               values ('$_POST[stud_id]' , '$_POST[mid]' , '$_POST[ext_data]' ,'{$_SESSION['session_tea_sn']}' , '$n_day' )" ; ; 
	
	$CONN->Execute($sql_insert) or die($sql_insert);
	break;

	//�T�w�ק�
	case $editBtn:
	$sql_update = "update stud_ext_data set ext_data='$_POST[ext_data]',teach_id='{$_SESSION['session_tea_sn']}' where mid='$_POST[mid]' and stud_id = '$_POST[stud_id]' ";
	$CONN->Execute($sql_update) or die($sql_update);
	break;

}



if(!$c_curr_seme)
	$c_curr_seme = sprintf ("%03d%d",curr_year(),curr_seme()); //�{�b�Ǧ~�Ǵ�

//�x�s���U�@��
if ($chknext)
	$stud_id = $nav_next;	
	$query = "select a.stud_id,a.stud_name from stud_base a,stud_seme b where a.student_sn=b.student_sn and a.stud_id='$stud_id' and a.stud_study_cond=0  and  b.seme_year_seme='$c_curr_seme' and b.seme_class='$class_num'";	
	$res = $CONN->Execute($query) or die($res->ErrorMsg());
	//���]�w�Χ��ܦb¾���p�ΧR���O���� ��Ĥ@��
	if ($stud_id =="" || $res->RecordCount()==0) {	
		$temp_sql = "select a.stud_id,a.stud_name from stud_base a,stud_seme b where a.student_sn=b.student_sn and  a.stud_study_cond=0 and  b.seme_year_seme='$c_curr_seme' and b.seme_class='$class_num' order by b.seme_num ";
		$res2 = $CONN->Execute($temp_sql) or die($temp_sql);
		$stud_id = $res2->fields[0];
	}
$stud_name = $res->fields[1];



?> 
<script language="JavaScript">

function checkok()
{
	var OK=true;	
	document.myform.nav_next.value = document.gridform.nav_next.value;	
	return OK
}

function setfocus(element) {
	element.focus();
 return;
}
//-->
</script>
<body onload="setfocus(document.myform.sp_memo)">
<table border="0" width="100%" cellspacing="0" cellpadding="0" CLASS="tableBg" >
<tr>
<td valign=top align="right">

<?php
//�إߥ�����   
	
	
	$temparr = class_base();   
	$upstr = $temparr[$class_num]; 
	$grid1 = new ado_grid_menu($_SERVER['PHP_SELF'],$URI,$CONN);  //�إ߿��	   
	$grid1->bgcolor = $gridBgcolor;  // �C��   
	$grid1->row = $gridRow_num ;	     //��ܵ���   
	$grid1->key_item = "stud_id";  // ������W  	
	$grid1->display_item = array("sit_num","stud_name");  // �����W   
	$grid1->display_color = array("1"=>"$gridBoy_color","2"=>"$gridGirl_color"); //�k�k�ͧO
	$grid1->color_index_item ="stud_sex" ; //�C��P�_��
	$grid1->class_ccs = " class=leftmenu";  // �C�����

	$grid1->sql_str = "select a.stud_id,a.stud_name,a.stud_sex,b.seme_num as sit_num from stud_base a,stud_seme b where a.student_sn=b.student_sn and a.stud_study_cond=0 and  b.seme_year_seme='$c_curr_seme' and b.seme_class='$class_num' order by b.seme_num ";   //SQL �R�O   
	$grid1->do_query(); //����R�O   
	
	//$downstr = "<br><font size=2><a href=\"stud_spe_class.php\" target=\"showclass\">��ܥ��Ǵ��O��</font></a>";
	$grid1->print_grid($stud_id,$upstr,$downstr); // ��ܵe��   
  

?>
     </td>
     
    <td width="100%" valign=top bgcolor="#CCCCCC">
    
<?


        //�n�ק諸���ءA�γ̫�@��
        if ($mid) 
           $sql_select = "select * from stud_ext_data_menu  where id='$mid'  ";
        else 
           $sql_select = "select * from stud_ext_data_menu  order by id desc  ";   
        $recordSet = $CONN->Execute($sql_select);
        if ($recordSet) {
            $id = $recordSet->fields["id"];
            $ext_data_name = $recordSet->fields["ext_data_name"];
            $doc = nl2br($recordSet->fields["doc"]); 
        }    
        if ($id) {
           //��mnu���Ƭ�0�� �� form �� disabled	
	   if ($grid1->count_row==0 && !($do_key == $newBtn || $do_key == $postBtn))  
		$edmode= " disabled ";        	
           $top_form = "<form name ='myform' action='".$_SERVER['PHP_SELF']."' method='post' onsubmit='checkok()' $edmode >  
                    <table border='1' cellspacing='0' cellpadding='2' bordercolorlight='#333354' bordercolordark='#FFFFFF'  width='100%' class=main_body >
			<tr>
			 <td class=title_mbody colspan=5 align=center  background='images/tablebg.gif' >
			   <input type='hidden' name='stud_id' value='$stud_id'>" ;
           $top_form .= sprintf("%d�Ǧ~��%d�Ǵ� %s--%s (%s)",substr($c_curr_seme,0,-1),substr($c_curr_seme,-1),$class_list_p[$c_curr_seme],$stud_name,$stud_id);
           

           $form .="   <tr>
    			 <td align='right' CLASS='title_sbody1'>�լd�ƶ�</td> <td CLASS='gendata'>$ext_data_name</td>
                       </tr> 
                       <tr>
    			 <td align='right' CLASS='title_sbody1'>��g����</td> <td CLASS='gendata' >$doc</td>
                       </tr>" ;
           if ($id) 
               $sql_select2 = "select * from stud_ext_data  where stud_id='$stud_id' and mid='$id'  ";
               $recordSet2 = $CONN->Execute($sql_select2);
               if ($recordSet2) {
                   $mid = $recordSe2t->fields["mid"];
                   $ext_data = $recordSet2->fields["ext_data"];
                   //$teach_name =get_teacher_name( $recordSet2->fields["teach_id"]);    
                   $ed_date = $recordSe2t->fields["ed_date"];  	

               }

               $form .="   <tr>
        			 <td align='right' CLASS='title_sbody1'>��g���e</td> 
        			 <td CLASS='gendata'>
        			 �H�r��������Ƥ��j<br>
        			 <textarea name='ext_data' cols=40 rows=5 wrap=virtual>$ext_data</textarea>
        			 </td>
                           </tr>                      " ;             
    	      $form .="</table>
                        <input type='hidden' name=nav_next>
                        </FORM>" ;
               if ($mid)          
    	          $top_form .= "      <input type='submit' name='do_key' value='$editBtn'> <input type='hidden' name='mid' value='$mid'>
    	                 </td>	
                           </tr>" ;                    
               else 
                  $top_form .= "      <input type='submit' name='do_key' value='$newBtn'> <input type='hidden' name='mid' value='$id'>
    	                 </td>	
                           </tr>" ;            
               echo $top_form . $form ;    
           } else {
           	echo "<table border='1' cellspacing='0' cellpadding='2' bordercolorlight='#333354' bordercolordark='#FFFFFF'  width='100%' class=main_body >
           	      <tr><td>�L�լd����</td></tr></table>" ;
           }	    

  //���X���� 
  $sql_select = "select * from stud_ext_data_menu  order by id desc  ";
  $recordSet = $CONN->Execute($sql_select);
  while (!$recordSet->EOF) {

    $id = $recordSet->fields["id"];
    $ext_data_name = $recordSet->fields["ext_data_name"];
    $doc = $recordSet->fields["doc"];  	
    echo "<table border='1' cellspacing='0' cellpadding='2' bordercolorlight='#333354' bordercolordark='#FFFFFF'  width='100%' class=main_body > 
  	<tr><td>�լd�ƶ��G$ext_data_name</td><td>��g��</td><td>" ;
    echo "<a href=\"{$_SERVER['PHP_SELF']}?do_key=edit&stud_id=$stud_id&mid=$id\">�˵� / �ק�</a>&nbsp;|&nbsp;<a href=\"{$_SERVER['PHP_SELF']}?do_key=delete&mid=$id&stud_id=$stud_id\" onClick=\"return confirm('�T�w�R��?');\">�R��</a>	
  	</td></tr>" ;
  	
    $sql_select2 = "select * from stud_ext_data  where stud_id='$stud_id' and mid='$id'   ";
    $recordSet2 = $CONN->Execute($sql_select2);
    if ($recordSet2) {	
      $mid = $recordSet2->fields["mid"];
      $ext_data = nl2br($recordSet2->fields["ext_data"]);
      $teach_id = get_teacher_name($recordSet2->fields["teach_id"]);    
      $ed_date = $recordSet2->fields["ed_date"];  	
      echo "<tr bgcolor='#DDDDDD' ><td>$ext_data</td><td>$teach_id</td><td>$ed_date </td></tr>" ;
    }
    if (!$mid) 
       echo "<tr bgcolor='#DDDDDD' ><td colspan=3>�����L���</td></tr>" ;
    echo "</table><br>" 	 ;
    @$recordSet->MoveNext();	
  	
  }	
  
?>
</TD>
</TR>
</TABLE>
<?php
//�L�X����
foot();
?>
