<?php

// $Id: teach_connect.php 7454 2013-08-30 01:30:19Z hami $

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

// ���J�]�w��
include "teach_config.php";
//���b¾���A
if ($c_sel != "")
	$sel = $c_sel;
else if ($sel=="")
	$sel = 0 ; //�w�]����b¾���p

// �{���ˬd
sfs_check();

switch ($do_key) {
	case $editBtn :

    	// ���ˬd�ӱЮv�� teacher_sn �O�_�s�b? �_�h�L�k��s�Юv���������
    	$query="select teacher_sn from teacher_connect where teacher_sn='$teacher_sn'";
    	$rs=&$CONN->Execute($query);
    
	if (!$rs) {
	  	print $CONN->ErrorMsg();
	} else {
      		if ($rs->fields[teacher_sn]) {
			$query = "update teacher_connect set email='$email', email2='$email2', email3='$email3', selfweb='$selfweb', selfweb2='$selfweb2', classweb='$classweb', classweb2='$classweb2', ICQ='$icq' where teacher_sn='$teacher_sn'";
      		} else {
			//$query="insert into teacher_connect values('$teacher_sn','$email','$email2','$email3','$selfweb','$selfweb2','$classweb','$classweb2','$icq')";
			$query="insert into teacher_connect (teacher_sn,email,email2,email3,selfweb,selfweb2,classweb,classweb2,icq)values('$teacher_sn','$email','$email2','$email3','$selfweb','$selfweb2','$classweb','$classweb2','$icq')";
      		}
      	
		$CONN->Execute($query) or die($query);
    	}

	break;
	
}


//�L�X���Y
head("�Юv�������");
//����T
$field_data = get_field_info("teacher_connect");

//���s���r��
$linkstr = "teacher_sn=$teacher_sn&sel=$sel";
//�L�X���
print_menu($teach_menu_p,$linkstr);
//�x�s���U�@��
if ($chknext)
	$teacher_sn = $nav_next;	

$query = "select teacher_sn from teacher_base where teacher_sn='$teacher_sn' and teach_condition ='$sel'";
$res = $CONN->Execute($query) or die($query);

//���]�w�Χ��ܦb¾���p�ΧR���O���� ��Ĥ@��
if ($teacher_sn =="" || $teacher_sn != $res->fields[teacher_sn]) {
	$result= $CONN->Execute("select teacher_base.teacher_sn,teacher_base.teach_condition from teacher_base left join teacher_post on teacher_base.teacher_sn=teacher_post.teacher_sn where  teacher_base.teach_condition ='$sel' limit 0,1");
	$teacher_sn = $result->fields[0];	
}	
$sql_select = "select a.name,b.* from teacher_base a left join teacher_connect b on a.teacher_sn=b.teacher_sn where a.teacher_sn='$teacher_sn'";
$recordSet = $CONN->Execute($sql_select) or die ($sql_select);
while (!$recordSet->EOF) {

  	// �H�U�o�@�n�h���A�_�h�@�}�l $teacher_sn �|�Q�ŭȨ��N 
  	//$teacher_sn = $recordSet->fields["teacher_sn"];
	
	$name = $recordSet->fields["name"];
	$email = $recordSet->fields["email"];
	$email2 = $recordSet->fields["email2"];
	$email3 = $recordSet->fields["email3"];
	$selfweb = $recordSet->fields["selfweb"];
	$selfweb2 = $recordSet->fields["selfweb2"];
	$classweb = $recordSet->fields["classweb"];
	$classweb2 = $recordSet->fields["classweb2"];
	$icq = $recordSet->fields["ICQ"];

	$recordSet->MoveNext();
};


?>
<script language="JavaScript">
function checkok()
{
	document.myform.nav_next.value = document.gridform.nav_next.value;
	return true;
}
//-->
</script>

<table border=0 cellpadding=0 cellspacing=0 width=100% bgcolor=#cccccc>
<tr><td valign=top>
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
      <td align="right" valign="top" bgcolor="#CCCCCC">
    <?php    
	//�إߥ����� 
	$remove_p = remove(); //�b¾���p    
	$upstr = "���<select name=\"c_sel\" onchange=\"this.form.submit()\">\n"; 
      	while (list($tid,$tname)=each($remove_p)){
      		if ($sel== $tid)
      			$upstr .= "<option value=\"$tid\" selected>$tname</option>\n";
      		else
      			$upstr .= "<option value=\"$tid\">$tname</option>\n";
      	}
	$upstr .= "</select>"; 
	$downstr = "<hr size=1>"; 

	$grid1 = new sfs_grid_menu;  //�إ߿��	   
	$grid1->bgcolor = $gridBgcolor;  // �C��   
	$grid1->row = $gridRow_num ;	     //��ܵ���   
	$grid1->key_item = "teacher_sn";  // ������W  	
	$grid1->display_item = array("name");  // �����W 
	$grid1->display_color = array("1"=>"$gridBoy_color","2"=>"$gridGirl_color"); //�k�k�ͧO
	$grid1->color_index_item ="sex" ; //�C��P�_��
	$grid1->class_ccs = " class=leftmenu";  // �C�����		
	//$grid1->sql_str = "select teacher_sn,concat('&nbsp;',name,'&nbsp;') as name,sex from teacher_base where teach_condition='$sel' order by sex,name";   //SQL �R�O 
	$grid1->sql_str = "select a.teacher_sn,concat('&nbsp;' ,d.title_name , ' -- ', a.name,'&nbsp;') as name, a.sex from teacher_base a
	LEFT JOIN teacher_post c ON a.teacher_sn=c.teacher_sn LEFT JOIN teacher_title d ON c.teach_title_id=d.teach_title_id
	where teach_condition='$sel' order by d.rank, sex,name";   //SQL �R�O
	$grid1->do_query(); //����R�O 
	if ($key == $newBtn || $key == $postBtn) 
		$grid1->disabled=1; 
	$grid1->print_grid($teacher_sn,$upstr,$downstr); // ��ܵe�� 

?>  
</td></tr></table>  
</td>
<td width="100%" valign="top">
<form name="myform" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
  <table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class="main_body" >


<tr>
	<td colspan=2>
	<B><?php echo "$teacher_sn -- $name" ?></b></td>
</tr>


<tr>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[email][d_field_cname] ?></td>
	<td CLASS="gendata"><input type="text" size="50"  name="email" value="<?php echo $email ?>"></td>
</tr>


<tr>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[email2][d_field_cname] ?></td>
	<td CLASS="gendata"><input type="text" size="50"  name="email2" value="<?php echo $email2 ?>"></td>
</tr>


<tr>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[email3][d_field_cname] ?></td>
	<td CLASS="gendata"><input type="text" size="50"  name="email3" value="<?php echo $email3 ?>"></td>
</tr>


<tr>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[selfweb][d_field_cname] ?></td>
	<td CLASS="gendata"><input type="text" size="50"  name="selfweb" value="<?php echo $selfweb ?>"></td>
</tr>


<tr>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[selfweb2][d_field_cname] ?></td>
	<td CLASS="gendata"><input type="text" size="50"  name="selfweb2" value="<?php echo $selfweb2 ?>"></td>
</tr>


<tr>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[classweb][d_field_cname] ?></td>
	<td CLASS="gendata"><input type="text" size="50"  name="classweb" value="<?php echo $classweb ?>"></td>
</tr>


<tr>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[classweb2][d_field_cname] ?></td>
	<td CLASS="gendata"><input type="text" size="50"  name="classweb2" value="<?php echo $classweb2 ?>"></td>
</tr>


<tr>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[ICQ][d_field_cname] ?></td>
	<td CLASS="gendata"><input type="text" size="20"  name="icq" value="<?php echo $icq ?>"></td>
</tr>

<tr>
	
	<td colspan="4" align=center>
	<input type="hidden" name="update_id" value="<?php echo $_SESSION['session_log_id'] ?>">
	<input type="hidden" name="teacher_sn" value="<?php echo $teacher_sn ?>">
	<?php 
		if ($chknext)
    			echo "<input type=checkbox name=chknext value=1 checked >";			
    		else
    			echo "<input type=checkbox name=chknext value=1 >";
    	
    	?>
    	 �۰ʸ��U�@�� &nbsp;&nbsp<input type=hidden name=nav_next >
	<input type=submit name="do_key" value ="<?php echo $editBtn ?>" onClick="return checkok();">
	</td>
</tr>

</table>
</FORM>
</TD>
</TR>
</TABLE>
<?php 
//�L�X���Y
foot();
?>
