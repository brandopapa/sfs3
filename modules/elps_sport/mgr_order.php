<?php
//$Id: mgr_order.php 8769 2016-01-13 14:16:55Z qfon $
include "config.php";
//�{��
sfs_check();
//if ($_POST){
//	echo "<PRE>";print_r($_POST);print_r($_GET);echo "</PRE>";
//	die();
//	}

#####################   �v���ˬd�P�ɶ�  ###########################
if($_GET[mid] || $_POST[mid] ) {
	($_GET[mid] == '') ? $cmid=$_POST[mid]: $cmid=$_GET[mid];
	if(ch_mid_t($cmid)!=3 ) backe("�D�ާ@�ɶ�");
	}
$ad_array=who_is_root();
if (!is_array($ad_array[$_SESSION[session_tea_sn]])){
if ($_POST[mid] || $_GET[mid] || $_POST[main_id] ) {
	$bb='';
	($_POST[mid]!='' ) ? $bb=$_POST[mid]:$bb;
	($_GET[mid]!='' ) ? $bb=$_GET[mid]:$bb;
	($_POST[main_id]!='' ) ? $bb=$_POST[main_id]:$bb;
if (check_man($_SESSION[session_tea_sn],$bb ,1)!='YES'   ) backe("�z�L�v���ާ@");
	if(ch_mid_t($bb)!=3) backe("�D�ާ@�ɶ�");

}}


#####################  ���ե[�J   #############################
if($_POST[act]=='act_select' ) {
	if($_POST[mid]=='') backe("�ާ@���~!");
	if($_POST[item]=='') backe("�ާ@���~!");
	if($_POST[astu]=='') backe("����ܾǥ�!���U��^�W������!");
	$SQL="select id from sport_res  where itemid ='$_POST[item]' and mid='$_POST[mid]' and results != '' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
if ($rs->RecordCount() > 0 )  backe("�Ӷ��ؤv�}�l��J���Z�F!�T��ơI");
	$all_stu=count($_POST[astu]);
	$LimtA=($_POST[spk]-1)*$_POST[item_limt_man];
	$La=$LimtA+1;
	$Lb=($_POST[spk]*$_POST[item_limt_man]);
	if ($all_stu!= $_POST[item_limt_man])  $Lb=$La+$all_stu-1;
	$rrr=range($La,$Lb);
if ($_POST[act_k]=='1') shuffle($rrr);//��ܶüƤ���
	$i=0;
	foreach ($_POST[astu] as $key => $cname) {
		$kk=split("_",$key);
	$SQL="update sport_res set sportorder='".$rrr[$i]."'  where id='".$kk[0]."' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
//echo $SQL."<BR>";
		$i++;
		}
//	gonow($PHP_SELF."?mid=".$_POST[mid]."&item=".$_POST[item]);exit;
	$url=$PHP_SELF."?mid=".$_POST[mid]."&item=".$_POST[item];header("Location:$url");
}
#####################  ���ե[�J2��խ���   #############################
if($_POST[act]=='act_select2' ) {
	if($_POST[mid]=='') backe("�ާ@���~!");
	if($_POST[item]=='') backe("�ާ@���~!");
	if($_POST[spk]=='') backe("����ܲĴX��!���U��^�W������!");
	if($_POST[item_limt_man]=='') backe("�ާ@���~!�S���ӲդH��!");
	$SQL="select id from sport_res  where itemid ='$_POST[item]' and mid='$_POST[mid]' and results != '' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
if ($rs->RecordCount() > 0 )  backe("�Ӷ��ؤv�}�l��J���Z�F!�T��ơI");
	$LimtA=($_POST[spk]-1)*$_POST[item_limt_man];
	$La=$LimtA+1;
	$Lb=($_POST[spk]*$_POST[item_limt_man]);
	$SQL="select id from sport_res  where itemid ='$_POST[item]' and mid='$_POST[mid]' and sportorder >= '$La' and  sportorder <= '$Lb' order by sportorder ";
//	die($SQL);
	$rs=$CONN->Execute($SQL) or die($SQL);
if ($rs->RecordCount() < $_POST[item_limt_man] ) $Lb=$La+$rs->RecordCount()-1;
	$rrr=range($La,$Lb);
	shuffle($rrr);//��ܶüƤ���
	$arr=$rs->GetArray();
	for($i=0; $i<$rs->RecordCount(); $i++) {
		$SQL1="update sport_res set sportorder='".$rrr[$i]."'  where id = '".$arr[$i][id]."' ";
		$rsa=$CONN->Execute($SQL1) or die($SQL1);
		}
//	gonow($PHP_SELF."?mid=".$_POST[mid]."&item=".$_POST[item]);exit;
	$url=$PHP_SELF."?mid=".$_POST[mid]."&item=".$_POST[item];header("Location:$url");
}

#####################  ���ե[�J   #############################
if($_POST[act]=='del_select' ) {
	if($_POST[mid]=='') backe("�ާ@���~!");
	if($_POST[item]=='') backe("�ާ@���~!");
	if($_POST[dstu]=='') backe("����ܾǥ�!���U��^�W������!");
	$SQL="select id from sport_res  where itemid ='$_POST[item]' and mid='$_POST[mid]' and results != '' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
if ($rs->RecordCount() > 0 )  backe("�Ӷ��ؤv�}�l��J���Z�F!�T��ơI");
	foreach ($_POST[dstu] as $key => $cname) {
		$kk=split("_",$key);
		$SQL="update sport_res set sportorder='0'  where id='".$kk[0]."' ";
		$rs=$CONN->Execute($SQL) or die($SQL);
		}
//	gonow($PHP_SELF."?mid=".$_POST[mid]."&item=".$_POST[item]);exit;
	$url=$PHP_SELF."?mid=".$_POST[mid]."&item=".$_POST[item];header("Location:$url");
}

#####################  �B�z����   #############################
if($_POST[act]=='del_all' ) {
	if($_POST[mid]=='') backe("�ާ@���~!");
	if($_POST[item]=='') backe("�ާ@���~!");
	$SQL="select id from sport_res  where itemid ='$_POST[item]' and mid='$_POST[mid]' and results != '' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
if ($rs->RecordCount() > 0 )  backe("�Ӷ��ؤv�}�l��J���Z�F!�T��ơI");
	$SQL="update sport_res set sportorder=0  where  itemid ='$_POST[item]' and mid='$_POST[mid]'  ";
	$rs=$CONN->Execute($SQL) or die($SQL);
//	gonow($PHP_SELF."?mid=".$_POST[mid]."&item=".$_POST[item]);exit;
	$url=$PHP_SELF."?mid=".$_POST[mid]."&item=".$_POST[item];header("Location:$url");
}

#####################  �B�z�̹B�ʭ��s���s��   #############################
if($_POST[act]=='act_sportnum' ) {
	if($_POST[mid]=='') backe("�ާ@���~!");
	if($_POST[item]=='') backe("�ާ@���~!");
	$SQL="select id from sport_res  where itemid ='$_POST[item]' and mid='$_POST[mid]' and results != '' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
if ($rs->RecordCount() > 0 )  backe("�Ӷ��ؤv�}�l��J���Z�F!�T��ơI");
	$SQL="select id from sport_res  where itemid ='$_POST[item]' and mid='$_POST[mid]'  order by  sportnum ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();
	for($i=0; $i<$rs->RecordCount(); $i++) {
		$y=$i+1;
	$SQL1="update sport_res set sportorder='$y'  where id = '".$arr[$i][id]."' ";
	$rsa=$CONN->Execute($SQL1) or die($SQL1);
	}
//	gonow($PHP_SELF."?mid=".$_POST[mid]."&item=".$_POST[item]);exit;
	$url=$PHP_SELF."?mid=".$_POST[mid]."&item=".$_POST[item];header("Location:$url");

}

#####################  �B�z�̯Z�Ůy���s��   #############################
if($_POST[act]=='act_idclass' ) {
	if($_POST[mid]=='') backe("�ާ@���~!");
	if($_POST[item]=='') backe("�ާ@���~!");
	$SQL="select id from sport_res  where itemid ='$_POST[item]' and mid='$_POST[mid]' and results != '' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
if ($rs->RecordCount() > 0 )  backe("�Ӷ��ؤv�}�l��J���Z�F!�T��ơI");
	$SQL="select id from sport_res  where itemid ='$_POST[item]' and mid='$_POST[mid]'  order by  idclass ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();
	for($i=0; $i<$rs->RecordCount(); $i++) {
		$y=$i+1;
	$SQL1="update sport_res set sportorder='$y'  where id = '".$arr[$i][id]."' ";
	$rsa=$CONN->Execute($SQL1) or die($SQL1);
	}
//	gonow($PHP_SELF."?mid=".$_POST[mid]."&item=".$_POST[item]);exit;
	$url=$PHP_SELF."?mid=".$_POST[mid]."&item=".$_POST[item];header("Location:$url");
}

#####################  �q���üƽs��   #############################
if($_POST[act]=='act_computer' ) {
	if($_POST[mid]=='') backe("�ާ@���~!");
	if($_POST[item]=='') backe("�ާ@���~!");
	$SQL="select id from sport_res  where itemid ='$_POST[item]' and mid='$_POST[mid]' and results != '' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
if ($rs->RecordCount() > 0 )  backe("�Ӷ��ؤv�}�l��J���Z�F!�T��ơI");
	$SQL="select id from sport_res  where itemid ='$_POST[item]' and mid='$_POST[mid]'  order by  idclass ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();
	$rrr=range(1,$rs->RecordCount());
	shuffle($rrr);
	for($i=0; $i<$rs->RecordCount(); $i++) {
	$SQL1="update sport_res set sportorder='".$rrr[$i]."'  where id = '".$arr[$i][id]."' ";
	$rsa=$CONN->Execute($SQL1) or die($SQL1);
//echo $SQL1."<BR>";
	}
//	gonow($PHP_SELF."?mid=".$_POST[mid]."&item=".$_POST[item]);exit;
	$url=$PHP_SELF."?mid=".$_POST[mid]."&item=".$_POST[item];header("Location:$url");
}

#####################  �q���üƽs��--���   #############################
if($_POST[act]=='act_computer2' ) {
	if($_POST[mid]=='') backe("�ާ@���~!");
	if($_POST[item]=='') backe("�ާ@���~!");
	$SQL="select id from sport_res  where itemid ='$_POST[item]' and mid='$_POST[mid]' and results != '' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
if ($rs->RecordCount() > 0 )  backe("�Ӷ��ؤv�}�l��J���Z�F!�T��ơI");
	$SQL="select id from sport_res  where itemid ='$_POST[item]' and mid='$_POST[mid]' order by  idclass ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();
	$rrr=range(1,$rs->RecordCount());
for ($i=1;$i<=$rs->RecordCount();$i++){
	($i%2==0) ? $BBB[]=$i:$i;
	($i%2==1) ? $AAA[]=$i:$i;
	}
	shuffle($AAA);shuffle($BBB);// echo"<PRE>";
	//print_r($AAA); print_r($BBB);

for($i=0; $i<$rs->RecordCount(); $i++) {
if ($i%2==0){
	$SQL1="update sport_res set sportorder='".$AAA[floor($i/2)]."'  where id = '".$arr[$i][id]."' ";
	$rsa=$CONN->Execute($SQL1) or die($SQL1);
	}
if ($i%2==1){
	$SQL1="update sport_res set sportorder='".$BBB[floor($i/2)]."'  where id = '".$arr[$i][id]."' ";
	$rsa=$CONN->Execute($SQL1) or die($SQL1);
	}
	}
	//gonow($PHP_SELF."?mid=".$_POST[mid]."&item=".$_POST[item]);exit;
	$url=$PHP_SELF."?mid=".$_POST[mid]."&item=".$_POST[item];header("Location:$url");
}
#####################  �q���üƽs��--�T��   #############################
if($_POST[act]=='act_computer3' ) {
	if($_POST[mid]=='') backe("�ާ@���~!");
	if($_POST[item]=='') backe("�ާ@���~!");
	$SQL="select id from sport_res  where itemid ='$_POST[item]' and mid='$_POST[mid]' and results != '' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
if ($rs->RecordCount() > 0 )  backe("�Ӷ��ؤv�}�l��J���Z�F!�T��ơI");
	$SQL="select id from sport_res  where itemid ='$_POST[item]' and mid='$_POST[mid]' order by  idclass ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();
for ($i=1;$i<=$rs->RecordCount();$i++){
	($i%3==0) ? $CCC[]=$i:$i;
	($i%3==2) ? $BBB[]=$i:$i;
	($i%3==1) ? $AAA[]=$i:$i;
	}
	shuffle($AAA);shuffle($BBB);shuffle($CCC);
// echo"<PRE>"; print_r($AAA); print_r($BBB); print_r($CCC);
for($i=0; $i<$rs->RecordCount(); $i++) {
if ($i%3==0){
	$SQL1="update sport_res set sportorder='".$AAA[floor($i/3)]."'  where id = '".$arr[$i][id]."' ";
//	echo $SQL1."__".(floor($i/3))."--AAA<BR>";
	$rsa=$CONN->Execute($SQL1) or die($SQL1);
	}
if ($i%3==1){
	$SQL1="update sport_res set sportorder='".$BBB[floor($i/3)]."'  where id = '".$arr[$i][id]."' ";
//	echo $SQL1."__".(floor($i/3))."--BBB<BR>";
	$rsa=$CONN->Execute($SQL1) or die($SQL1);
	}
if ($i%3==2){
	$SQL1="update sport_res set sportorder='".$CCC[floor($i/3)]."'  where id = '".$arr[$i][id]."' ";
//	echo $SQL1."__".(floor($i/3))."--CCC<BR>";
	$rsa=$CONN->Execute($SQL1) or die($SQL1);
		}
	}
//	gonow($PHP_SELF."?mid=".$_POST[mid]."&item=".$_POST[item]);exit;
	$url=$PHP_SELF."?mid=".$_POST[mid]."&item=".$_POST[item];header("Location:$url");
}

#####################  ���ե[�J   #############################
if($_POST[act]=='act_text_me' ) {
	if($_POST[mid]=='') backe("�ާ@���~!");
	if($_POST[item]=='') backe("�ާ@���~!");
	if($_POST[chstu]=='') backe("����ܾǥ�!���U��^�W������!");
	$SQL="select id from sport_res  where itemid ='$_POST[item]' and mid='$_POST[mid]' and results != '' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
if ($rs->RecordCount() > 0 )  backe("�Ӷ��ؤv�}�l��J���Z�F!�T��ơI");
	foreach ($_POST[chstu] as $key => $value) {
		$kk=split("_",$key);
	$SQL="update sport_res set sportorder='$value'  where id='".$kk[0]."' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
//	echo $SQL."<BR>";
		}
//	gonow($PHP_SELF."?mid=".$_POST[mid]."&item=".$_POST[item]);exit;
$url=$PHP_SELF."?mid=".$_POST[mid]."&item=".$_POST[item];header("Location:$url");
}


//�q�X�����������Y
head("�v�ɳ��W");

include_once "menu.php";
include_once "chk.js";

if($_GET[mid]=='') { print_menu($school_menu_p2);}
else {$link2="mid=$_GET[mid]&item=$_GET[item]&sclass=$_GET[sclass]"; print_menu($school_menu_p2,$link2);}

mmid($_GET[mid]);



//echo "<FORM METHOD=POST ACTION='$PHP_SELF' name='f1'>\n<INPUT TYPE='hidden' name='act' value=''>";
if ($_GET[mid]!='') echo item_list($_GET[mid],$_GET[item]);
if ($_GET[item]!='') stud_list($_GET[mid],$_GET[item]);
// if ($class_num!='' && $_GET[mid]!='') stud_list($class_num);
//$color_sex[$arr[$i][stud_sex]]

//echo "</FORM>";









//�G������
foot();

#####################  �C�ܾǥ�   #############################
function stud_list($mid,$item) {
		global $CONN,$sportname,$itemkind,$sportclass;
	$SQL="select * from sport_item where id ='$item' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$item_arr=$rs->GetArray();
	if ($item_arr[0][sportkind]==5) return'';//�D���O�ɵ���
	$limit=$item_arr[0][playera];
	$ITEM_NAME=$sportclass[$item_arr[0][enterclass]].$sportname[$item_arr[0][item]].$itemkind[$item_arr[0][kind]];
	$SQL="select * from sport_res where itemid ='$item' and mid='$mid' and kmaster=0 order by sportorder  ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();
	$all_col=ceil($rs->RecordCount()/$item_arr[0][playera]);

//$color_col=array("#f9f9f9","#F2F2F2");//�C��#e8efe2
//(($i%2)==0) ? $v_color=$color_col[0]:$v_color=$color_col[1];
// stud_sex
$color_sex=array(1=>"blue",2=>"green");//�C��#e8efe2
$img_sex=array(1=>"<img src='images/boy.gif' width=15 >",2=>"<img src='images/girl.gif' width=15>");//�C��#e8efe2
?>
<script>
<!--
function tagall() {
var i =0;
while (i < document.f1.elements.length) {
var obj=document.f1.elements[i];
var objx=document.f1.elements[i].name;
if (obj.type=='checkbox' && objx.substr(0,4)=='astu') {
	if (obj.checked==1 ) {obj.checked=0;}
	else { obj.checked=1;}
	}
i++;}
}

function chk_sel() {

var radio1=0;//��1���O�_���
var spk_value=0;//��1������ܭ�
var radio2=0;//��2���O�_���
var checkbox1=0;//�v��ܼ�
var check_all=<?=$rs->RecordCount()?>;//�����H��
var check_one=<?=$limit?>;//�C�դH��
var check_col=<?=$all_col?>;//���ռ�
var i =0;
while (i < document.f1.elements.length) {
var obj=document.f1.elements[i];
var objx=document.f1.elements[i].name;
if (obj.type=='radio' && objx=='spk') {
	if(obj.checked==1 ) { radio1=1;spk_value=obj.value;}
	}
if (obj.type=='radio' && objx=='act_k') {
	(obj.checked==1 ) ? radio2=1:radio2;
	}
if (obj.type=='checkbox' && objx.substr(0,4)=='astu') {
	(obj.checked==1 ) ? checkbox1++:checkbox1;
	}
	i++;
	}

if (radio1!=1 || radio2!=1 ) {
	alert("���林�A�ˬd�@�U�I�п�ܶüƱƧ�or�̯Z�O");
	return false;
	}
//	if (spk_value!=check_col ){
//	if ( checkbox1!=check_one && checkbox1!=(check_one-1) && checkbox1!=(check_one-2)){
//	alert("�H�Ƥ���I����"+check_one+"�H \n\n �z��F"+checkbox1+"�H�I");//�H�ƹL�֭���
//	return false;}
//	}
//	AA=check_all-(check_one*(check_col-1));
//if (spk_value==check_col ){
//	if (AA!= checkbox1 &&  checkbox1!=(check_one-1) && checkbox1!=(check_one-2)) {
//		alert("�H�Ƥ���I�A��"+AA+"�H�N�n�F \n\n �i�O�z��F"+checkbox1+"�H�I");
//		return false;}
//	}

	var objform=document.f1;
	if (window.confirm("��ܧ����H���{���v���@�H�ƪ��T�w�A�Цۦ�T�w�H�ơI")){
		objform.act.value="act_select";
		objform.submit();
		}
}

function bb2(a,b,c) {
var objform=document.f1;
if (window.confirm(c)){
objform.act.value=a;
//objform.spk.value=b;
objform.submit();}
}

function moveit2(chi,event) {
	var pKey = event.keyCode;//�Q�r�� 38�V�W 40�V�U;37�V��;39�V�k
	if (pKey==40 || pKey==38  ) {
//	if (pKey==40 || pKey==38 || pKey==37 || pKey==39 ) {
	var max=document.f1.elements.length ;//�Ҧ�����ƶq
	var Go=0;//�n���ʦ�m
	TText= new Array ; //��r���}�C
	var Tin=0; //��r���}�C����
	var Tin_now=0; //��r���}�C���ޥثe��m
	for(i=0; i<max; i++) {
	var obj = document.f1.elements[i];
	if (obj.type == 'text')
	{
	TText[Tin]=i; //�O�U���b�Ҧ��������ĴX��
if(obj.name==chi.name ) {Tin_now=Tin;} //�p�G�O�Ƕi�Ӫ����,�N�O�U�����b��r���}�C���ޭ�
	Tin=Tin+1;
	}
	}
if (Tin==1 ) return false;//�Ȥ@�ӴN���n���F
// if (pKey==40 || pKey==39 ) KK=40;
// if (pKey==38 || pKey==37 ) KK=38;
switch (pKey){ //�`�j
	case 40://�V�U
		Tin=Tin-1;//���o���ޭ�
		(Tin_now == Tin ) ? Go=TText[0] : Go=TText[Tin_now+1];
		document.f1.elements[Go].focus();
		return false;
		break;
	case 38://�V�W
		Tin=Tin-1;//���o���ޭ�
		(Tin_now == 0 ) ? Go=TText[Tin] : Go=TText[(Tin_now-1)];
		document.f1.elements[Go].focus();
		return false;
		break;
		default:
	return false;
	}
	}
}
function showtalk() {
	alert("�z�Ϊ��o�ӿﶵ�A�N�����z�s���ůʪ��{�H�I");
}
function showtalk1() {
	alert("�z�Ϊ��o�ӿﶵ�A�s�����ƱN�Ȩ���@���ǥ͡I\n\n�ӹD�����X�{���̱z��g���s���өw�I");
}

//-->
</script>
<TABLE border=0 width=100%><FORM METHOD=POST ACTION='<?=$PHP_SELF?>' name='f1'><TR><TD colspan=2><img src='images/12.gif'><B><?=$ITEM_NAME?>&nbsp;���ɾǥͤ��զC��</B>
</TD></TR>
<TR><TD colspan=2><img src='images/12.gif'><B>���ظ�T</B>
�v���W<?=$rs->RecordCount()?>�H�A�C��<?=$limit?>�H�A��<?=$item_arr[0][passera]?>�W�A
�i����<?=$all_col?>�աC<BR><INPUT TYPE='button' value='�ϥθ��������L�X������' onclick="window.open('mgr_prt.1.php?mid=<?=$mid?>&item=<?=$item?>&Spk=all&kitem=heigh','','scrollbars=yes,resizable=yes,height=500,width=600');" class=bu1>&nbsp;
<INPUT TYPE='button' value='�ϥθ��������L�X������' onclick="window.open('mgr_prt.1.php?mid=<?=$mid?>&item=<?=$item?>&Spk=all&kitem=long','','scrollbars=yes,resizable=yes,height=500,width=600');" class=bu1>

</TD></TR>
<TR><TD style='font-size:10pt;' width=80% valign=top>
<?php
for ($a=1;$a<=$all_col ;$a++){
	$tmp_str='';$y=0;
	$LimtA=($a-1)*$limit;
	$La=$LimtA+1;
	$LimtB=($a*$limit)+1;
	$Lb=$LimtB-1;
	for($i=0; $i<$rs->RecordCount(); $i++) {
	($arr[$i][results]!=0 || $arr[$i][results]!='' ) ? $dd=" disabled":$dd='' ;
	if ( $arr[$i][sportorder] > $LimtA && $arr[$i][sportorder] < $LimtB ) {
		if ($_GET[txt]=='open') {
			$tmp_str.="<INPUT TYPE='text' NAME='chstu[".$arr[$i][id]."_".$item."]' size=3 value='".$arr[$i][sportorder]."' $dd onfocus=\"this.select();return false ;\" onkeydown=\"moveit2(this,event);\" class=bur>".$arr[$i][cname]."(<B style='color:red'>".substr($arr[$i][idclass],1,4)."</B>)\n";
			}
		else {
			$tmp_str.="<INPUT TYPE='checkbox' NAME='dstu[".$arr[$i][id]."_".$item."]' value='".$arr[$i][cname]."' $dd><B style='color:blue'>".$arr[$i][sportorder]."</B>_".$arr[$i][cname]."(<B style='color:red'>".substr($arr[$i][idclass],1,4)."</B>)\n";
			}
		
		($y%4==3 && $y!=0 ) ? $tmp_str.="<BR>": $tmp_str;
		$y++;}
		}
	$echo_STR.= "<INPUT TYPE='radio' NAME='spk' value='$a'><B style='color:blue'>���� $a ��</B>&nbsp;
	($La - $Lb)&nbsp;<INPUT TYPE='button' value='�L�X�� $a ���˿���' onclick=\"window.open('mgr_prt.1.php?mid=$mid&item=$item&Spk=$a&kitem=speed','','scrollbars=yes,resizable=yes,height=500,width=600');\" class=bu1>
	<INPUT TYPE='button' value='�D� $a ��' onclick=\"showtalk();window.open('mgr_prt_new.php?mid=$mid&item=$item&Spk=$a&kitem=speed&ord=na','','scrollbars=yes,resizable=yes,height=500,width=600');\" class=bu1>
	<INPUT TYPE='button' value='�̽s���� $a ��' onclick=\"showtalk1();window.open('mgr_prt_new.php?mid=$mid&item=$item&Spk=$a&kitem=speed&ord=local','','scrollbars=yes,resizable=yes,height=500,width=600');\" class=bu1>
	<div style='margin-left:10pt'>".$tmp_str."</div>";
	}
echo "<table border=0  width=100% style='font-size:11pt;'  cellspacing=0 cellpadding=0 bgcolor=silver>
<tr bgcolor=white><td><fieldset><legend><img src='images/pin_orange.gif'><B>�v���տ��W��</B></legend>".
$echo_STR."</fieldset></td></tr></table>";

($_GET[txt]=='open') ? $txt_tb="<INPUT TYPE=button  value='�̧ڶ�g���s���e�X' onclick=\" bb('�̧ڶ�g���s���e�X�H�u���H','act_text_me');\" class=bu1> <INPUT TYPE=button  value='������^' onclick=\"self.history.back();\" class=bu1>":$txt_tb="<INPUT TYPE=button  value='�ۦ�վ����' onclick=\"location.href='$PHP_SELF?mid=$mid&item=$item&txt=open';\" class=bu1>";

echo "<table border=0  width=100% style='font-size:10pt;'  cellspacing=0 cellpadding=0 bgcolor=silver>
<tr bgcolor=white><td><fieldset><legend><img src='images/win.gif'><B>�ާ@�ﶵ</B></legend>
<INPUT TYPE='hidden' name='mid' value='$mid'>
<INPUT TYPE='hidden' name='item' value='$item'>
<INPUT TYPE='hidden' name='act' value=''>
<INPUT TYPE='hidden' name='item_limt_man' value='$limit'>
<INPUT TYPE='radio' NAME='act_k' value='1'>�üƱƧ�
<INPUT TYPE='radio' NAME='act_k' value='2'>�̯Z�O<BR>

<INPUT TYPE='reset' value='���s���' class=bu1>&nbsp;
<INPUT TYPE=button  value='�Ҧ����ը���' onclick=\" bb('�Ҧ����ը����H�u���H','del_all');\" class=bu1>&nbsp;
 $txt_tb

<BR>
<INPUT TYPE=button  value='�N��ܪ��ա�����' onclick=\" bb('��ܪ��սs���üƭ��ơH�u���H','act_select2');\" class=bu1>&nbsp;
<INPUT TYPE=button  value='�N���_��̥[�J��ܪ����ա�' onclick=\" chk_sel();\" class=bu1>&nbsp;
<INPUT TYPE=button  value='�N���_��̤��ը���' onclick=\" bb('��ܪ��ը����s���H�u���H','del_select');\" class=bu1>&nbsp;
<BR>
<INPUT TYPE=button  value='�����ѹq�����v�t�d����' onclick=\" bb('�ѹq���t�d���աH�����H','act_computer');\" class=bur>&nbsp;
<INPUT TYPE=button  value='�����̯Z�Ŷ��Ǥ���' onclick=\" bb('�����̯Z�Ŷ��Ǥ��աH�����H','act_idclass');\" class=bur>&nbsp;
<INPUT TYPE=button  value='�����̹B�ʭ��s������' onclick=\" bb('�����̹B�ʭ��s�����աH�����H','act_sportnum');\" class=bur>
<BR>
<INPUT TYPE=button  value='�����̹��üƤ覡����' onclick=\" bb('�ѹq���t�d���աH�����H','act_computer2');\" class=bur>&nbsp;
<INPUT TYPE=button  value='�����̤T��üƤ覡����' onclick=\" bb('�����̯Z�Ŷ��Ǥ��աH�����H','act_computer3');\" class=bur>&nbsp;

</fieldset></td></tr></table>";
//bb('�W���B�U���B��������n�F�ܡH','act_select');

################	�����ճB�z		######################
	$tmp_str='';$y=0;
	for($i=0; $i<$rs->RecordCount(); $i++) {
		if ( $arr[$i][sportorder] ==0 ) {
		($arr[$i][results]!=0 || $arr[$i][results]!='' ) ? $dd=" disabled":$dd='' ;
		if ($_GET[txt]=='open') {
			$tmp_str.="<INPUT TYPE='text' NAME='chstu[".$arr[$i][id]."_".$item."]' size=3 value='".$arr[$i][sportorder]."' $dd onfocus=\"this.select();return false ;\" onkeydown=\"moveit2(this,event);\" class=bur>".$arr[$i][cname]."(<B style='color:red'>".substr($arr[$i][idclass],1,4)."</B>)\n";
			}
		else {
			$tmp_str.="<INPUT TYPE='checkbox' NAME='astu[".$arr[$i][id]."_".$item."]' value='".$arr[$i][cname]."'  $dd >".$arr[$i][cname]."(<B style='color:blue'>".substr($arr[$i][idclass],1,4)."</B>)\n";}
		($y%5==4 && $y!=0 ) ? $tmp_str.="<BR>": $tmp_str;
		$y++;
		}
		}
echo "<table border=0  width=100% style='font-size:10pt;' cellspacing=0 cellpadding=0 bgcolor=silver>
<tr bgcolor=white><td><fieldset><legend><img src='images/pin_red.gif'><B>�����տ��W��</B></legend>
<INPUT TYPE='checkbox'  onClick=\"tagall();\" ><B style='color:#800000'>����/����/�ϦV���</B>
<BR>".$tmp_str."</fieldset></td></tr></table>";




//	$stu_num=substr($arr[$i][idclass],1,4);
//	echo "<INPUT TYPE='checkbox' NAME='stu[".$arr[$i][id]."_".$mid."_".$item."]' value='".$arr[$i][cname]."'>".$arr[$i][cname]."(".$arr[$i][sportorder].")\n";
//	if ($i%6==5 && $i!=0) echo "<BR>";
//	}�۰ʤ覡 �ۥѶü� ��� ���ü� �T�� �T��ü� �̯Z�Ŷ���
//��ʤ覡 �v�@���� ��ʶ�J
echo "</TD><TD valign=top align=left style='font-size:10pt;color:#800000'><img src='images/booksm.gif'>����<BR>
+�ާ@�e�D:<div style='margin-left:10pt;color:blue'>�v����J���Z�A�h����ާ@�L�ġC</div>
+��r���:<div style='margin-left:10pt;color:blue'>�i�H�ϥΤ�V��W�U���ʡC</div>
+���W��:<div style='margin-left:10pt;color:blue'>���v���W���ǥͼơC</div>
+�s����:<div style='margin-left:10pt;color:blue'>���v��g�B�ʭ��s�����ǥͼơC</div>
+�˿���:<div style='margin-left:10pt;color:blue'>���v�ƥX�ɶ��ǽs�����ǥͼơC</div>
+���Z��:<div style='margin-left:10pt;color:blue'>���v��J���Z���ǥͼơC</div>
+���s���:<div style='margin-left:10pt;color:blue'>�����Ҧ�����ܰʧ@ �C</div>
+�Ҧ����ը���:<div style='margin-left:10pt;color:blue'>�N�Ҧ����ժ��D���O���k�s�C</div>
+�N�_�諸�ա�����:<div style='margin-left:10pt;color:blue'>�N��ܪ��չD���s���üƭ���</div>
+�N���_��̥[�J��ܪ����ա�:<div style='margin-left:10pt;color:blue'>��W�����էO�ΤU���n�[�J���ǥ͡C</div>
+�N���_��̤��ը���:<div style='margin-left:10pt;color:blue'>�ۥѹ_��n�����D���O�����ǥ�</div>

</TD></TR><TR><TD colspan=2><hr color=#800000 SIZE=1></TD></TR></FORM></TABLE>";
}

#####################  �C�ܶ���   #############################
function item_list($mid,$item=''){
		global $CONN,$sportclass,$sportname,$itemkind;
	$SQL="select *  from sport_item   where  mid='$mid' and  skind=0 and sportkind!=5  order by  kind, enterclass ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();

	$SQL="select itemid ,count(id) as nu from  sport_res   where  mid='$mid' group by itemid ";
	$arr_1=initArray("itemid,nu",$SQL);//�����H��
	$SQL="select itemid ,count(id) as nu from  sport_res   where  mid='$mid' and  sportnum!='' group by itemid ";
	$arr_2=initArray("itemid,nu",$SQL);//�v�˿��H��(�s�ƶ���)
	$SQL="select itemid ,count(id) as nu from  sport_res   where  mid='$mid' and  sportorder!=0 group by itemid ";
	$arr_3=initArray("itemid,nu",$SQL);//�v�˿��H��(�s�ƶ���)
	$SQL="select itemid ,count(id) as nu from  sport_res   where  mid='$mid' and  results!='' and  kmaster=0  group by itemid ";
	$arr_4=initArray("itemid,nu",$SQL);//�����Z�H��

	$ss="<FORM name=p2>��ܶ��ءG<select name='link2' size='1' class='bur' onChange=\"if(document.p2.link2.value!='')change_link(document.p2.link2.value);\">\n<option value='$PHP_SELF?mid=$_GET[mid]&item='>�����</option> ";

for($i=0; $i<$rs->RecordCount(); $i++) {
//	($_GET[item]==$arr[$i][id]) ? $gg='images/arrow.gif':$gg='images/closedb.gif';
//		$Nu_arr=chk4num($arr[$i][id]);////���W,�S���Z,�S�Ƨ�
//	(
		($arr_1[$arr[$i][id]]=='') ? $Nu1=0:$Nu1=$arr_1[$arr[$i][id]];
		($arr_2[$arr[$i][id]]=='') ? $Nu2=0:$Nu2=$arr_2[$arr[$i][id]];
		($arr_3[$arr[$i][id]]=='') ? $Nu3=0:$Nu3=$arr_3[$arr[$i][id]];
		($arr_4[$arr[$i][id]]=='') ? $Nu4=0:$Nu4=$arr_4[$arr[$i][id]];

		($item==$arr[$i][id]) ? $cc=" selected":$cc="";
		$ss.="<option value='$PHP_SELF?mid=$_GET[mid]&item=".$arr[$i][id]."'$cc>".$sportclass[$arr[$i][enterclass]].$sportname[$arr[$i][item]].$itemkind[$arr[$i][kind]].
		"&nbsp;(���W��: $Nu1 �s����: $Nu2 �˿���: $Nu3 ���Z��: $Nu4)</option>\n";
//	echo "<img src='$gg'><A HREF='$PHP_SELF?mid=$_GET[mid]&item=".$arr[$i][id]."'>". $sportclass[$arr[$i][enterclass]].$sportname[$arr[$i][item]].$itemkind[$arr[$i][kind]]."</A>(<B style='color:#c0c0c0' >".$arr[$i][bu]."</B>)";
	}
	$ss.="</select></FORM>";
Return $ss;


}

function link_a($sclass){
	$class_name_arr = class_base() ;
	$ss="<FORM name=p2>��ܯZ�šG<select name='link2' size='1' class='small' onChange=\"if(document.p2.link2.value!='')change_link(document.p2.link2.value);\"> ";
	foreach($class_name_arr as $key=>$val) {
		($sclass==$key) ? $cc=" selected":$cc="";
		$ss.="<option value='$PHP_SELF?mid=$_GET[mid]&sclass=$key'$cc>$val</option>\n";
	}
	$ss.="</select></FORM>";
Return $ss;
}


?>
