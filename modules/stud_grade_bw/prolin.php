<?php
// $Id: prolin.php 6865 2012-08-27 17:18:16Z hsiao $

//���J�]�w��
require("config.php") ;

// �{���ˬd
sfs_check();

($IS_JHORES==0) ? $UP_YEAR=6:$UP_YEAR=9;//�P�_�ꤤ�p
$y[] = $UP_YEAR ;
$class_year_p =  class_base("",$y); //�Z��  
//�ǮզW�ٰ}�C
$temp_grade = get_grade_school_table();
head("�W�U�C�L") ;
print_menu($menu_p);

//�Ǧ~��
$curr_year =  curr_year() ;
//javascript
js();

/////----------------�ɾǾǮզW�U------////
/* �¦��t�����榡
$main =  "<table width=100%  bgcolor='#CCCCCC' >
  		<tr><td align='center'>	 
	<H2>$curr_year �Ǧ~�ײ��~�ͦW�U�C�L</H2>
	<form action='' method='post' name='p1'> 
	<table width=50%  cellspacing='0' cellpadding='2' bordercolorlight='#333354' bordercolordark='#FFFFFF' border='1' bgcolor='#99CCCC' > 
<tr><td colspan=2 align=center>�����ɾǾǮ�<br>
<input type='button' name='bb' value='�����̾ǮնץX' onclick=\"bb1('��������','�̾ǮնץX')\">
<input type='button' name='bb' value='��̾ǮնץX' onclick=\"bb2('�����','�̾ǮնץX')\"><br>
<input type='button' name='bb' value='�����̯Z�ŶץX' onclick=\"bb1('��������','�̯Z�ŶץX')\">
<input type='button' name='bb' value='��̯Z�ŶץX' onclick=\"bb2('�����','�̯Z�ŶץX')\">

<input type='hidden' name='key' value=''>

</td></tr>
	<tr ><td align=right>�ɾǾǮ�</td><td><select name='curr_grade_school'>
	<option value= 'all' selected >�����Ǯ�</option> \n";
*/
//�s�h�������榡
$main =  "<table width=100%  bgcolor='#CCCCCC' >
  		<tr><td align='center'>	 
	<H2>$curr_year �Ǧ~�ײ��~�ͦW�U�C�L(���ɤJ�ꤤ)</H2>
	<form action='' method='post' name='p1'> 
	<table width=50%  cellspacing='0' cellpadding='2' bordercolorlight='#333354' bordercolordark='#FFFFFF' border='1' bgcolor='#99CCCC' > 
<tr><td colspan=2 align=center>�����ɾǾǮ�<br>
<input type='button' name='bb' value='��̾ǮնץX' onclick=\"bb2('�����','�̾ǮնץX')\">
<input type='button' name='bb' value='��̯Z�ŶץX' onclick=\"bb2('�����','�̯Z�ŶץX')\">

<input type='hidden' name='key' value=''>

</td></tr>
	<tr ><td align=right>�ɾǾǮ�</td><td><select name='curr_grade_school'>
	<option value= 'all' selected >�����Ǯ�</option> \n";
//	$temp_grade =  get_grade_school_table(); 
	
	foreach( $temp_grade as $tkey => $tvalue) {
		if ($tvalue == $curr_grade_school)
			$main .=   sprintf ("<option value='%s' selected>%s</option>\n",$tvalue,$tvalue);
		else
			$main .=  sprintf ("<option value='%s'>%s</option>\n",$tvalue,$tvalue);
	}

	$main .= "</select></td></tr> \n
	     <tr ><td align=right>��ܯZ��</td><td><select name='curr_class_name'>
	     <option value='$UP_YEAR'>���Ǧ~</option> ";
	     $class_temp='';
        foreach ( $class_year_p as $tkey => $tvalue) {
			 $class_temp .=   sprintf ("<option value='%02d'>%s</option>\n",$tkey,$tvalue);
	}             	 
          
$main .=  $class_temp ;
/*�¦�����
	$main .= " </select></td></tr>
<tr><td colspan=2 align=center>
<input type='button' name='bb' value='�����ץX sxw' onclick=\"bb1('��������','�ץX sxw')\">
<input type='button' name='bb' value='��ץX sxw' onclick=\"bb2('�����','�ץX sxw')\">
</td></tr>
<tr><td colspan=2 align=center>
<input type='button' name='bb' value='���~�ǥͦW�U�ʭ�' onclick=\"bb6('�C�L���~�ǥͦW�U�ʭ�','grad_cover')\">
<input type='button' name='bb' value='�׷~�ǥͦW�U�ʭ�' onclick=\"bb6('�C�L�׷~�ǥͦW�U�ʭ�','disgrad_cover')\"><br>
<input type='button' name='bb' value='���~�ǥͦW�U' onclick=\"bb7('�C�L���~�ǥͦW�U','grade')\">
<input type='button' name='bb' value='�׷~�ǥͦW�U' onclick=\"bb7('�C�L�׷~�ǥͦW�U','disgrade')\"><br>
<input type='button' name='bb' value='���~�ǥͦW�U�ʩ�����' onclick=\"bb6('�C�L���~�ǥͦW�U�ʩ�����','grad_bottom')\">
<input type='button' name='bb' value='�׷~�ǥͦW�U�ʩ�����' onclick=\"bb6('�C�L�׷~�ǥͦW�U�ʩ�����','disgrad_bottom')\">
</td></tr>
	         </table></form>
	         </td></tr></table>" ;
*/
//�s�h������
	$main .= " </select></td></tr>
<tr><td colspan=2 align=center>
<input type='button' name='bb' value='��ץX sxw' onclick=\"bb2('�����','�ץX sxw')\">
</td></tr>
<tr><td colspan=2 align=center>
<input type='button' name='bb' value='���~�ǥͦW�U�ʭ�' onclick=\"bb6('�C�L���~�ǥͦW�U�ʭ�','grad_cover')\">
<input type='button' name='bb' value='�׷~�ǥͦW�U�ʭ�' onclick=\"bb6('�C�L�׷~�ǥͦW�U�ʭ�','disgrad_cover')\"><br>
<input type='button' name='bb' value='���~�ǥͦW�U' onclick=\"bb7('�C�L���~�ǥͦW�U','grade')\">
<input type='button' name='bb' value='�׷~�ǥͦW�U' onclick=\"bb7('�C�L�׷~�ǥͦW�U','disgrade')\"><br>
<input type='button' name='bb' value='���~�ǥͦW�U�ʩ�����' onclick=\"bb6('�C�L���~�ǥͦW�U�ʩ�����','grad_bottom')\">
<input type='button' name='bb' value='�׷~�ǥͦW�U�ʩ�����' onclick=\"bb6('�C�L�׷~�ǥͦW�U�ʩ�����','disgrad_bottom')\">
</td></tr>
	         </table></form>
	         </td></tr></table>" ;
echo  $main ;

/////----------------���~�ͤ@����C�L------////
$main =  "<table width=100% bgcolor='#CCCCCC' >
<tr><td align='center'>	
<center><H2>���~�ͤ@����C�L(���Ш|��)</H2><form method='post' action='' name='p2'>

<table  width=50% cellspacing='0'  cellpadding='2' bordercolorlight='#333354' bordercolordark='#FFFFFF' border='1' bgcolor='#99CCCC' >
<tr><td align=right>��ܯZ��</td><td><select name='curr_class_name'>
<option value='$UP_YEAR'>���Ǧ~</option>\n";
	$main .=  $class_temp ;
	/*�§t����
	$main .= " </select></td></tr>
<tr><td colspan=2 align=center><input type='hidden' name='key' value=''>
<input type='button' name='aa' value='�����ץX SXW' onclick=\"bb3('��������','�ץX SXW')\">
<input type='button' name='aa' value='��ץX SXW' onclick=\"bb4('�����','�ץX SXW')\" >
<input type='button' name='aa' value='��ץX SXW(�t�����Ҧr��)' onclick=\"bb42('�����(�t�����Ҧr��)','�ץX SXW')\" >
</td></tr></table></form></center>
</td></tr></table>" ;		
*/
//�s�h������
$main .= " </select></td></tr>
<tr><td colspan=2 align=center><input type='hidden' name='key' value=''>
<input type='button' name='aa' value='��ץX SXW' onclick=\"bb4('�����','�ץX SXW')\" >
<input type='button' name='aa' value='��ץX SXW(�t�����Ҧr��)' onclick=\"bb42('�����(�t�����Ҧr��)','�ץX SXW')\" >
</td></tr></table></form></center>
</td></tr></table>" ;	    
echo $main ;


/////----------------���~�͸�ƶץX------////
$main = "<table width=100% bgcolor='#CCCCCC' >
  		<tr><td align='center'>	 
  		<H2><br>���~�͸�ƶץX(���~�ҮѦL�s)</H2>
  		<form action='' method='post' name='p3'> 
	        <table width=50%  cellspacing='0' cellpadding='2' bordercolorlight='#333354' bordercolordark='#FFFFFF' border='1' bgcolor='#99CCCC'>
	           <tr><td align=right>��ܯZ��</td>
	             <td><select name='curr_class_name'>
	             <option value='$UP_YEAR'>���Ǧ~</option>
	             $class_temp 
	             </select></td>
	           </tr>
	           <tr><td colspan=2 align=center>
	           <input type='hidden' name='key' value=''>
	          <input type='button' name='aa' value='�ץX CSV' onclick=\"bb5('�ץX CSV?','�ץX CSV')\" >
	           </td></tr>
	         </table>
	         </form>
	        </td></tr></table>" ;       
echo $main ;


foot() ;

function js(){
	global $CONN;

//�έp�P�B�ƤH��
$query = "SELECT COUNT(*) AS cc FROM grad_stud WHERE stud_grad_year='".curr_year()."'";
$res = $CONN->Execute($query) or die($query);
$cc = $res->fields['cc'];

//�έp���׷~�H��
$g=array();
$query = "SELECT grad_kind, COUNT(*) AS g FROM grad_stud WHERE stud_grad_year='".curr_year()."' group by grad_kind";
$res = $CONN->Execute($query) or die($query);
while(!$res->EOF) {
	$g[$res->fields['grad_kind']]=$res->fields['g'];
	$res->MoveNext();
}
$gg = intval($g[1]);
$ng = intval($g[2]);

echo "
<script>
<!--

function bb1(a,b) {";
if ($cc==0) echo "alert('���Ǧ~���~�͸�Ʃ|���i��P�B��, �Х��i��P�B�ưʧ@�C');}";
else echo "
var objform=document.p1;
if (window.confirm(a)){
objform.action='grad_print2.php';
objform.key.value=b;
objform.submit();}
}";
echo "
function bb2(a,b) {";
if ($cc==0) echo "alert('���Ǧ~���~�͸�Ʃ|���i��P�B��, �Х��i��P�B�ưʧ@�C');}";
else echo "
var objform=document.p1;
if (window.confirm(a)){
objform.action='grad_print_v.php';
objform.key.value=b;
objform.submit();}
}";
echo "
function bb3(a,b) {";
if ($cc==0) echo "alert('���Ǧ~���~�͸�Ʃ|���i��P�B��, �Х��i��P�B�ưʧ@�C');}";
else echo "
var objform=document.p2;
if (window.confirm(a)){
objform.action='grad_list_print.php';
objform.key.value=b;
objform.submit();}
}";
echo "
function bb4(a,b) {";
if ($cc==0) echo "alert('���Ǧ~���~�͸�Ʃ|���i��P�B��, �Х��i��P�B�ưʧ@�C');}";
else echo "
var objform=document.p2;
if (window.confirm(a)){
objform.action='grad_list_print_v.php';
objform.key.value=b;
objform.submit();}
}";
echo "
function bb42(a,b) {";
if ($cc==0) echo "alert('���Ǧ~���~�͸�Ʃ|���i��P�B��, �Х��i��P�B�ưʧ@�C');}";
else echo "
var objform=document.p2;
if (window.confirm(a)){
objform.action='grad_list_print_v2.php';
objform.key.value=b;
objform.submit();}
}";
echo "
function bb5(a,b) {";
if ($cc==0) echo "alert('���Ǧ~���~�͸�Ʃ|���i��P�B��, �Х��i��P�B�ưʧ@�C');}";
else echo "
var objform=document.p3;
if (window.confirm(a)){
objform.action='grade_data.php';
objform.key.value=b;
objform.submit();}
}";
echo "
function bb6(a,b) {
var objform=document.p1;
if (window.confirm(a)){
objform.action='cover.php';
objform.key.value=b;
objform.submit();}
}
function bb7(a,b) {";
if ($cc==0) echo "alert('���Ǧ~���~�͸�Ʃ|���i��P�B��, �Х��i��P�B�ưʧ@�C');}";
else echo "
var gg=$gg;
var ng=$ng;
var objform=document.p1;
if (b=='grade' && gg==0) {
	alert('���Ǧ~���~�͸�Ƥ��аO�����~���H�Ƭ�0, �Х������u���~�r���v�������׷~���O�C');
} else if (b=='disgrade' && ng==0) {
	alert('���Ǧ~���~�͸�Ƥ��аO���׷~���H�Ƭ�0, �����i��C�L�C');
} else {
	if (window.confirm(a)){
	objform.action='grad_list.php';
	objform.key.value=b;
	objform.submit();}
}
}";
echo "

//-->
</script>
";
}
?>
