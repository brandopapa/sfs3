<?php

// $Id: stud_ext_data.php 6892 2012-09-15 03:37:24Z hami $

// ���J�]�w��
include "stud_reg_config.php";
// �{���ˬd
sfs_check();

//�ɯ��ˬd 
require "module-upgrade.php";

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}



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


//�L�X���Y
head();



///���s���r��
$linkstr = "stud_id=$stud_id&c_curr_class=$c_curr_class&c_curr_seme=$c_curr_seme";

//�Ҳտ��
print_menu($menu_p,$linkstr);

//���Z��
if ($c_curr_class=="")
	// �Q�� $IS_JHORES �� �Ϲj �ꤤ�B��p�B���� ���w�]��
	$c_curr_class = sprintf("%03s_%s_%02s_%02s",curr_year(),curr_seme(),$default_begin_class + round($IS_JHORES/2),1);
else {
	$temp_curr_class_arr = explode("_",$c_curr_class); //091_1_02_03
	$c_curr_class = sprintf("%03s_%s_%02s_%02s",substr($c_curr_seme,0,3),substr($c_curr_seme,-1),$temp_curr_class_arr[2],$temp_curr_class_arr[3]);
}
	
if($c_curr_seme =='')
	$c_curr_seme = sprintf ("%03s%s",curr_year(),curr_seme()); //�{�b�Ǧ~�Ǵ�

//���Ǵ�
if ($c_curr_seme != "")
	$curr_seme = $c_curr_seme;

	$c_curr_class_arr = explode("_",$c_curr_class);
	$seme_class = intval($c_curr_class_arr[2]).$c_curr_class_arr[3];

	//�x�s���U�@��
if ($chknext)
	$stud_id = $nav_next;	
	$query = "select a.stud_id,a.stud_name from stud_base a,stud_seme b where a.student_sn=b.student_sn and a.stud_id='$stud_id' and (a.stud_study_cond=0 or a.stud_study_cond=5)  and  b.seme_year_seme='$c_curr_seme' and b.seme_class='$seme_class'";
	$res = $CONN->Execute($query) or die($res->ErrorMsg());
	//���]�w�Χ��ܦb¾���p�ΧR���O���� ��Ĥ@��
	if ($stud_id =="" || $res->RecordCount()==0) {	
		$temp_sql = "select a.stud_id,a.stud_name from stud_base a,stud_seme b where a.student_sn=b.student_sn and  (a.stud_study_cond=0 or a.stud_study_cond=5) and  b.seme_year_seme='$c_curr_seme' and b.seme_class='$seme_class' order by b.seme_num ";
		$res = $CONN->Execute($temp_sql) or die($temp_sql);
	}

		$stud_id = $res->fields[0];
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
//��ܾǴ�
$class_seme_p = get_class_seme(); //�Ǧ~��	
$upstr = "<select name=\"c_curr_seme\" onchange=\"this.form.submit()\">\n";
while (list($tid,$tname)=each($class_seme_p)){
	if ($curr_seme== $tid)
      		$upstr .= "<option value=\"$tid\" selected>$tname</option>\n";
      	else
      		$upstr .= "<option value=\"$tid\">$tname</option>\n";
}
$upstr .= "</select><br>"; 
	
$s_y = substr($c_curr_seme,0,3);
$s_s = substr($c_curr_seme,-1);

//��ܯZ��
	$tmp=&get_class_select($s_y,$s_s,"","c_curr_class","this.form.submit",$c_curr_class);
	$upstr .= $tmp;

	$grid1 = new ado_grid_menu($_SERVER['PHP_SELF'],$URI,$CONN);  //�إ߿��	   
	$grid1->bgcolor = $gridBgcolor;  // �C��   
	$grid1->row = $gridRow_num ;	     //��ܵ���   
	$grid1->key_item = "stud_id";  // ������W  	
	$grid1->display_item = array("sit_num","stud_name");  // �����W   
	$grid1->display_color = array("1"=>"$gridBoy_color","2"=>"$gridGirl_color"); //�k�k�ͧO
	$grid1->color_index_item ="stud_sex" ; //�C��P�_��
	$grid1->class_ccs = " class=leftmenu";  // �C�����
	$grid1->sql_str = "select a.stud_id,a.stud_name,a.stud_sex,b.seme_num as sit_num from stud_base a,stud_seme b where a.student_sn=b.student_sn  and (a.stud_study_cond=0 or a.stud_study_cond=5) and  b.seme_year_seme='$c_curr_seme' and b.seme_class='$seme_class' order by b.seme_num ";   //SQL �R�O   
	//echo $grid1->sql_str;	
	$grid1->do_query(); //����R�O   
	
	$grid1->print_grid($stud_id,$upstr,$downstr); // ��ܵe��   



?>
     </td>
     
    <td width="100%" valign=top bgcolor="#CCCCCC">
    
<?php


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
                   $mid = $recordSet2->fields["mid"];
                   $ext_data = $recordSet2->fields["ext_data"];
                   //$teach_name = get_teacher_name($recordSet2->fields["teach_id"]);    
                   $ed_date = $recordSet2->fields["ed_date"];  	

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
	   if ($modify_flag) {
	           if ($mid)          
		      $top_form .= "      <input type='submit' name='do_key' value='$editBtn'>" ;
	           else 
        	      $top_form .= "      <input type='submit' name='do_key' value='$newBtn'>" ;
                              
            $top_form .=" <input type='hidden' name='mid' value='$id'> 
                          <input type='hidden' name='c_curr_class' value='$c_curr_class'> 
                          <input type='hidden' name='c_curr_seme' value='$c_curr_seme'>"; 
		}
	$top_form .=" <a href='show_ext_data.php'>�d�ݲέp</a> 
	                 </td>	
                       </tr>" ;                                  
           echo $top_form . $form ;            
           }else {
           	echo "<table border='1' cellspacing='0' cellpadding='2' bordercolorlight='#333354' bordercolordark='#FFFFFF'  width='100%' class=main_body >
           	      <tr><td>�L�լd���ءA�� <a href='show_ext_data.php'>�ɥR��ƺ޲z</a>���s�W�C </td></tr></table>" ;
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
    echo "<a href=\"{$_SERVER['PHP_SELF']}?do_key=edit&stud_id=$stud_id&mid=$id&c_curr_class=$c_curr_class&c_curr_seme=$c_curr_seme\">�˵� / �ק�</a>&nbsp;|&nbsp;<a href=\"{$_SERVER['PHP_SELF']}?do_key=delete&mid=$id&stud_id=$stud_id&c_curr_class=$c_curr_class&c_curr_seme=$c_curr_seme\" onClick=\"return confirm('�T�w�R��?');\">�R��</a>	
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
    $recordSet->MoveNext();	
  	
  }	
  
?>
</TD>
</TR>
</TABLE>
<?php
//�L�X����
foot();
?>
