<?php

// $Id: teach_connect.php 5310 2009-01-10 07:57:56Z hami $

// --�t�γ]�w��
include "teach_config.php";
// --�{�� session 
sfs_check();

head();

if ($_POST[key] =="�T�w�ק�") {

  	// ���ˬd�ӱЮv�� teacher_sn�O�_�s�b? �_�h�L�k��s�Юv���������
  	$query="select teacher_sn from teacher_connect where teacher_sn='{$_SESSION['session_tea_sn']}'";
	$rs=&$CONN->Execute($query);
    
	if (!$rs) {
	  	print $CONN->ErrorMsg();
	} else {
	  	if ($rs->fields[teacher_sn]) {
		  	$query = "update teacher_connect set email='$_POST[I_email]', email2='$_POST[I_email2]', email3 ='$_POST[I_email3]', selfweb ='$_POST[I_selfweb]', selfweb2 ='$_POST[I_selfweb2]', classweb ='$_POST[I_classweb]', classweb2='$_POST[I_classweb2]', ICQ='$_POST[I_ICQ]' where teacher_sn='{$_SESSION['session_tea_sn']}'";
		} else {
			$query="insert into teacher_connect (teacher_sn,email,email2,email3,selfweb,selfweb2,classweb,classweb2,ICQ)values('$_SESSION[session_tea_sn]','$_POST[I_email]','$_POST[I_email2]','$_POST[I_email3]','$_POST[I_selfweb]','$_POST[I_selfweb2]','$_POST[I_classweb]','$_POST[I_classweb2]','$_POST[I_ICQ]')";
		}
		$CONN->Execute($query) or die($query);
	}
}


$query =  "select  * from teacher_connect where teacher_sn = '{$_SESSION['session_tea_sn']}'";
$result	= $CONN->Execute($query) or die ($query);

$email = $result->fields["email"];
$email2 = $result->fields["email2"];
$email3 = $result->fields["email3"];
$selfweb = $result->fields["selfweb"];
$selfweb2 = $result->fields["selfweb2"];
$classweb = $result->fields["classweb"];
$classweb2 = $result->fields["classweb2"];
$ICQ = $result->fields["ICQ"];


?>
<?php print_menu($teach_menu_p); ?>
<TABLE BORDER=0 CELLPADDING=10 CELLSPACING=0 CLASS="tableBg" WIDTH="100%" ALIGN="CENTER"> 
<TR>

<td  valign="top" width="100%" >   
<form action="<?echo $PHP_SELF ?>" method="post">

<table border="1" cellspacing="0" cellpadding="2" WIDTH="100%" bordercolorlight="#333354" bordercolordark="#FFFFFF"  class=main_body >

	<tr>
    <td class=title_sbody1 nowrap>�q�l�l��1(���G)</td>
    <td><input type="text"  name="I_email" value="<?php echo $email ?>" size="65"><td>
    </tr>
	<tr>
    <td class=title_sbody1 nowrap>�q�l�l��2</td>
    <td><input type="text"  name="I_email2" value="<?php echo $email2 ?>" size="65"><td>
    </tr>
	<tr>
    <td class=title_sbody1 nowrap>�q�l�l��3</td>
    <td><input type="text"  name="I_email3" value="<?php echo $email3 ?>" size="65"><td>
    </tr>
	<tr>
    <td class=title_sbody1 nowrap>�ӤH����1(���G)</td>
    <td><input type="text"  name="I_selfweb" value="<?php echo $selfweb ?>" size="65"><td>
    </tr>
	<tr>
    <td class=title_sbody1 nowrap>�ӤH����2</td>
    <td><input type="text"  name="I_selfweb2" value="<?php echo $selfweb2 ?>" size="65"><td>
    </tr>
	<tr>
    <td class=title_sbody1 nowrap>�Z�ź���1(���G)</td>
    <td><input type="text"  name="I_classweb" value="<?php echo $classweb ?>" size="65"><td>
    </tr>
	<tr>
    <td class=title_sbody1 nowrap>�Z�ź���2</td>
    <td><input type="text"  name="I_classweb2" value="<?php echo $classweb2 ?>" size="65"><td>
    </tr>
	<tr>
    <td class=title_sbody1 nowrap>ICQ</td><td>
    <input type="text"  name="I_ICQ" value="<?php echo $ICQ ?>" size="65"> <td>
    </tr>

<!--
<tr>
	<td align="center" valign="top">��J�s�K�X:
	<input type="text" size="12" maxlength="12" name="login_pass" ></td>
</tr>
-->
<tr>
	<td  colspan="2" align="center" valign="top"><input type="submit"  name="key" value="�T�w�ק�"></td>
</tr>
</table>
</form>
</td>
</tr>
</table>
<?php
foot();
?>
