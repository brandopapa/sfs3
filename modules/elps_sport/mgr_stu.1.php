<?php
//$Id: mgr_stu.1.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";
//�{��
sfs_check();
#####################   �v���ˬd�P�ɶ�  ###########################
$ad_array=who_is_root();
if (!is_array($ad_array[$_SESSION[session_tea_sn]])){
if ($_POST[mid] || $_GET[mid] || $_POST[main_id] ) {
	$bb='';
	($_POST[mid]!='' ) ? $bb=$_POST[mid]:$bb;
	($_GET[mid]!='' ) ? $bb=$_GET[mid]:$bb;
	($_POST[main_id]!='' ) ? $bb=$_POST[main_id]:$bb;
if (check_man($_SESSION[session_tea_sn],$bb ,1)!='YES'   ) backe("�z�L�v���ާ@");
}}
if($_GET[mid]!='' || $_POST[mid]!='' ) {
	($_GET[mid] != '') ? $cmid=$_GET[mid]: $cmid=$_POST[mid];
	if(ch_mid_t($cmid)!='3') backe("�D�ާ@�ɶ�");
	}

#####################  �B�z�s�W   #############################
if($_POST[act]=='stu_add') {
	if($_POST[main_id]=='') backe("�ާ@���~!");
	if($_POST[stu_id]=='') backe("����ܾǥ�!���U��^�W������!");
	if($_POST[sclass]=='') backe("�L�Z�Ÿ��!���U���^!");
	$sql_check="select id from sport_res  where  sportorder!=0 and mid='$mid' ";
	$rs = $CONN->Execute($sql_check) or die($sql_check);
	if($rs->RecordCount() > 0 )  backe("�˿��L�{�v�g�}�l�A�лP�j�|�H���s��!");
	$mid=$_POST[main_id];$sclass=$_POST[sclass];
		foreach ($_POST[stu_id] as $key => $value) {
			$key=split("_",$key);//�O����y����_�ǥ�id_�m�W $value��sportnum
			$sql_update= "update sport_res set sportnum='$value' where stud_id ='$key[1]' and mid='$mid' ";
			$rs = $CONN->Execute($sql_update)or die($sql_update);
			}
	$url=$PHP_SELF."?mid=$mid&sclass=$sclass";header("Location:$url");
	}
#####################   ��ƳB�z����  ###########################
#####################  �B�z�s�W�Φ�   #############################
if($_POST[act]=='stu_order') {
	if($_POST[main_id]=='') backe("�ާ@���~!");
	if($_POST[Res_id]=='') backe("����ܾǥ�!���U��^�W������!");
	if($_POST[sclass]=='') backe("�L�Z�Ÿ��!���U���^!");
	$mid=$_POST[main_id];$sclass=$_POST[sclass];
/////�ˬd�{��
	$sql_check="select id from sport_res  where   results!='' and mid='$mid' ";
	$rs = $CONN->Execute($sql_check) or die($sql_check);
//	if($rs->RecordCount() > 0 )  backe("�˿��L�{�v�g�}�l�A�лP�j�|�H���s��!");
	foreach ($_POST[Res_id] as $key => $value) {
		$sql_update= "update sport_res set sportorder='$value' where id ='$key' and mid='$mid' and sportkind='5' ";
		$rs = $CONN->Execute($sql_update)or die($sql_update);
		}
	$url=$PHP_SELF."?mid=$mid&sclass=$sclass";header("Location:$url");
	}

#####################  �B�z�s�W   #############################
if($_POST[act]=='stu_add2') {
	if($_POST[main_id]=='') backe("�ާ@���~!");
	if($_POST[stu_id]=='') backe("����ܾǥ�!���U��^�W������!");
	if($_POST[sclass]=='') backe("�L�Z�Ÿ��!���U���^!");
	if (strlen($_POST[sclass])!=3 )  backe("�L�Z�Žs���I");
	$mid=$_POST[main_id];$sclass=$_POST[sclass];

		foreach ($_POST[stu_id] as $key => $value) {
			$key=split("_",$key);
			$res_id=$key[0];$item_id=$key[1];
			$sql_2="select id,mid , sportorder from sport_res  where id='$res_id'  ";
			$rs = $CONN->Execute($sql_2) or die($sql_2);
			$arr=$rs->GetArray();
		if ($arr[0][sportorder]=='0') {
				$sql_update= "update sport_res set sportnum='$value' where id ='$res_id' ";
				$rs = $CONN->Execute($sql_update)or die($sql_update);
				}
			else {
			walert($key[2]." �v�ƤJ�ɵ{,�ާ@���L�I");
			}
		}
	$url=$PHP_SELF."?mid=$mid&sclass=$sclass";header("Location:$url");
	}
#####################  �۰ʶ�J��Z   #############################
if($_POST[act]=='auto_add_class') {
	if($_POST[main_id]=='') backe("�ާ@���~!");
	if($_POST[stu_id]=='') backe("����ܾǥ�!���U��^�W������!");
	if($_POST[sclass]=='') backe("�L�Z�Ÿ��!���U���^!");
	if($_POST[auto_add]=='') backe("����J�s��!���U���^!");
	if (strlen($_POST[sclass])!=3 )  backe("�L�Z�Žs���I");
	$mid=$_POST[main_id];
	$sclass=$_POST[sclass];
	$auto_add=$_POST[auto_add];
	$sql_2="select  id from sport_res  where mid='$mid' and  idclass like '$sclass%' and  sportorder!=0  ";
	$rs = $CONN->Execute($sql_2) or die($sql_2);
//	if ($rs->RecordCount()!=0)  backe("�w�g�}�l�˿��F�T��ާ@!���U���^�I");
	$sql_2="select id,cname,mid , sportorder from sport_res  where mid='$mid' and idclass like '$sclass%' group by idclass order by idclass ";
	$rs = $CONN->Execute($sql_2) or die($sql_2);
	$arr=$rs->GetArray();
	for($i=0; $i<$rs->RecordCount(); $i++) {
		$sql_update= "update sport_res set sportnum='$auto_add' where id ='".$arr[$i][id]."' ";
		$rs1 = $CONN->Execute($sql_update)or die($sql_update);
		$auto_add++;
		}
	//�B�z��H�渹
	$sql_3="select * from sport_res  where mid='$mid' and idclass like '$sclass%' and sportnum!='' ";
	$rs = $CONN->Execute($sql_3) or die($sql_3);//���즳�s����
	$arr=$rs->GetArray();
	for($i=0; $i<$rs->RecordCount(); $i++) {
		$sql_update= "update sport_res set sportnum='".$arr[$i][sportnum]."' where idclass ='".$arr[$i][idclass]."' and mid='$mid' and sportnum='' ";
		$rs1 = $CONN->Execute($sql_update)or die($sql_update);
		}//end for 
	$url=$PHP_SELF."?mid=$mid&sclass=$sclass";header("Location:$url");
	}
#####################  �۰ʶ�J��Ǧ~   #############################
if($_POST[act]=='auto_add_year') {
	if($_POST[main_id]=='') backe("�ާ@���~!");
	if($_POST[stu_id]=='') backe("����ܾǥ�!���U��^�W������!");
	if($_POST[sclass]=='') backe("�L�Z�Ÿ��!���U���^!");
	if($_POST[auto_add]=='') backe("����J�s��!���U���^!");
	if (strlen($_POST[sclass])!=3 )  backe("�L�Z�Žs���I");

	$mid=$_POST[main_id];
	$sclass=substr($_POST[sclass],0,1);
	$auto_add=$_POST[auto_add];
	$sql_2="select  sportorder from sport_res  where mid='$mid' and sportorder!=0 and  idclass like '$sclass%' ";
	$rs = $CONN->Execute($sql_2) or die($sql_2);
	if ($rs->RecordCount() !=0 )  backe("�w�g�}�l�˿��F�T��ާ@!���U���^�I");//�ˬd

	$sql_2="select id,cname,mid , sportorder from sport_res  where mid='$mid' and idclass like '$sclass%' and  kmaster=0 group by idclass order by idclass ";
	$rs = $CONN->Execute($sql_2) or die($sql_2);
	$arr=$rs->GetArray();
	for($i=0; $i<$rs->RecordCount(); $i++) {
				$sql_update= "update sport_res set sportnum='$auto_add' where id ='".$arr[$i][id]."' ";
				$rs1 = $CONN->Execute($sql_update)or die($sql_update);
				$auto_add++;
		}//end for 
	//�B�z��H�渹
	$sql_3="select * from sport_res  where mid='$_POST[main_id]' and idclass like '$sclass%' and sportnum!=''  group by idclass ";
	$rs = $CONN->Execute($sql_3) or die($sql_3);//���즳�s����
	$arr=$rs->GetArray();
	for($i=0; $i<$rs->RecordCount(); $i++) {
		$sql_update= "update sport_res set sportnum='".$arr[$i][sportnum]."' where idclass ='".$arr[$i][idclass]."' and mid='".$_POST[main_id]."' and sportnum='' ";
		$rs1 = $CONN->Execute($sql_update)or die($sql_update);
		}//end for 
		$mid=$_POST[main_id];$sclass=$_POST[sclass];
	$url=$PHP_SELF."?mid=$mid&sclass=$_POST[sclass]";header("Location:$url");
	}
#####################  �۰ʧR����Ǧ~   #############################
if($_POST[act]=='auto_del_year') {
	if($_POST[main_id]=='') backe("�ާ@���~!");
	if($_POST[sclass]=='') backe("�L�Z�Ÿ��!���U���^!");
	$mid=$_POST[main_id];
	$sclass=substr($_POST[sclass],0,1);
	$sql_2="select  sportorder from sport_res  where mid='$mid' and sportorder!=0 and  idclass like '$sclass%' ";
	$rs = $CONN->Execute($sql_2) or die($sql_2);
	if ($rs->RecordCount() !=0 )  backe("�w�g�}�l�˿��F�T��ާ@!���U���^�I");//�ˬd
		$sql_update= "update sport_res set sportnum='' where idclass like '$sclass%' and mid='$mid' ";//and sportnum!='' 
//	 die($sql_2."<BR>".$sql_update);
		$rs1 = $CONN->Execute($sql_update)or die($sql_update);
	$url=$PHP_SELF."?mid=$mid&sclass=$_POST[sclass]";header("Location:$url");
	}
#####################  �۰ʧR����Z   #############################
if($_POST[act]=='auto_del_class') {
	if($_POST[main_id]=='') backe("�ާ@���~!");
	if($_POST[sclass]=='') backe("�L�Z�Ÿ��!���U���^!");
	$mid=$_POST[main_id];
	$sclass=$_POST[sclass];
	$sql_2="select  sportorder from sport_res  where mid='$mid' and sportorder!=0 and  idclass like '$sclass%'  ";
	$rs = $CONN->Execute($sql_2) or die($sql_2);
	if ($rs->RecordCount() !=0 )  backe("�w�g�}�l�˿��F�T��ާ@!���U���^�I");//�ˬd
		$sql_update= "update sport_res set sportnum='' where idclass like '$sclass%' and mid='$mid' ";//and sportnum!='' 
//	 die($sql_2."<BR>".$sql_update);
		$rs1 = $CONN->Execute($sql_update)or die($sql_update);
	$url=$PHP_SELF."?mid=$mid&sclass=$_POST[sclass]";header("Location:$url");
	}
//�q�X�����������Y
head("�v�ɳ��W");
//print_menu($memu_p,$link2);
include_once "menu.php";
include_once "chk.js";
#####################   ���  ###########################
if($_GET[mid]=='') { print_menu($school_menu_p2);}
else {$link2="mid=$_GET[mid]&item=$_GET[item]&sclass=$_GET[sclass]"; print_menu($school_menu_p2,$link2);}


mmid($_GET[mid]);

if($_GET[mid]!='') echo link_a($_GET[mid],$_GET[sclass]);
if ($_GET[mid]!='' && $_GET[sclass]!=''){
?>
<script>
<!--
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

//-->
</script>
<?
echo "<FORM METHOD=POST ACTION='$PHP_SELF' name='f1'>
<INPUT TYPE='hidden' name='main_id' value='$_GET[mid]'>
<INPUT TYPE='hidden' name='act' value=''>
<INPUT TYPE='hidden' name='sclass' value='$_GET[sclass]'>";
 item_list($_GET[mid],$_GET[sclass]);
//if ($class_num!='' && $_GET[mid]!='') stud_list($class_num);
//$color_sex[$arr[$i][stud_sex]]

echo "</FORM>";}


//�G������
foot();
#####################  �C�ܶ���   #############################
function item_list($mid,$sclass){
		global $CONN,$sportclass,$sportname,$itemkind;
		$sclass2=substr($sclass,0,1);
//$SQL="select DISTINCT a.idclass,a.id,a.mid,a.stud_id,a.cname,a.sportnum,a.itemid,b.item,b.enterclass from sport_res a,sport_item b where a.idclass like '$sclass%' and a.kmaster=0 and a.itemid=b.id and a.mid='$mid' and b.skind=0 group by a.idclass order by a.idclass ";
$SQL="select DISTINCT a.stud_id,a.idclass,a.id,a.mid,a.cname,a.sportnum,a.itemid,b.item,b.enterclass from sport_res a,sport_item b where a.idclass like '$sclass%' and a.kmaster=0 and a.itemid=b.id and a.mid='$mid' and b.skind=0 group by a.stud_id order by a.sportnum ,a.idclass ";

$rs=$CONN->Execute($SQL) or die($SQL);
$arr=$rs->GetArray();

//echo"<PRE>";print_r($arr);die();
echo "<TABLE border=0 width=100%><TR><TD>
<img src='images/12.gif'><B>��g�B�ʭ��s��</B></TD></TR><TR><TD style='font-size:10pt;COLOR:#800000;'>\n";


for($i=0; $i<$rs->RecordCount(); $i++) {
$tmp_str=substr($arr[$i][idclass],1,4)."&nbsp;".$arr[$i][cname]."\n<FONT COLOR='#696969'>(";
$tmp_str.=$sportclass[$arr[$i][enterclass]].$sportname[$arr[$i][item]].")</font>\n";
$tmp_str.="<INPUT TYPE='text' NAME='stu_id[".$arr[$i][id]."_".$arr[$i][stud_id]."]' ";//�O����y����_�ǥ�id_�m�W
$tmp_str.="value='".$arr[$i][sportnum]."' size=5 class=ipmei ";
$tmp_str.="onfocus=\"this.select();return false ;\" onkeydown=\"moveit2(this,event);\">&nbsp;\n";
if ($i%3==2 && $i!=0 ) $tmp_str.="<BR>";
echo $tmp_str;

}
echo "</TD></TR><TR>
<TD style='font-size:10pt;COLOR:#800000;'>
<INPUT TYPE='reset' value='���s��g' class=bu1>
<INPUT TYPE='button' value='��n�e�X' onclick=\"bb('�T�w��n�F','stu_add');\" class=bu1><BR>
���G��H���W�h���خɡA�W�z�W��ȷ|�C�X�@���C<BR>
<INPUT TYPE='button' value='���Z�s���R��' onclick=\"bb('�u���ܡH�i�O�ᮬ�I','auto_del_class');\" class=bur>
<INPUT TYPE='button' value='���Ǧ~�s���R��' onclick=\"bb('�u���ܡH�i�O�ᮬ�I','auto_del_year');\" class=bur>
<BR>
��J�s���G<INPUT TYPE='text' NAME='auto_add' value='' size=6 onfocus=\"this.select();return false ;\" onkeydown=\"moveit2(this,event);\" class=ipmei>
<INPUT TYPE='button' value='�ѿ�J�s���}�l�̮y��_�۰ʶ�J��Z' onclick=\"bb('�u���ܡH�i�O�ᮬ�I','auto_add_class');\" class=bur>
<INPUT TYPE='button' value='�ѿ�J�s���}�l�̯Z�O�y��_�۰ʶ�J��Ǧ~' onclick=\"bb('�u���ܡH�i�O�ᮬ�I','auto_add_year');\" class=bur><BR>
<div style='color:#696969;font-size:11pt;'>���۰ʶ�J���\��ȯ���˿��e�ާ@�C<BR>
�����ɶ��إi���h���A���B�ʭ��s���Ȥ@�ӡC<BR>
���۰ʶ�J��Z�|�Ѥw�g���W�y���̶��Ƕ}�l�v�@��J�A�P�@�ӤH���h���ءA�]�ȷ|���@�ӽs���C<BR>
���۰ʶ�J��Ǧ~�|�Ѥw�g���W���Z�Ũ̯Z�ŻP�y���̶��Ƕ}�l�v�@��J�A�P�@�ӤH���h���ءA�]�ȷ|���@�ӽs���C
</div>
</TD></TR></TABLE>";

/////�B�z���O�����Φ�///////////
$SQL="select * from sport_item where sportkind='5' and skind=0 and enterclass like '$sclass2%' and mid='$mid' ";
$rs=$CONN->Execute($SQL) or die($SQL);
if ($rs->RecordCount()==0 || strlen($sclass2)!=1 || strlen($sclass)!=3 ) return '';
echo "<table border=0  width=100% style='font-size:11pt;'  cellspacing=1 cellpadding=0 bgcolor=silver>
<tr bgcolor=white><td><img src='images/12.gif'><B style='color:blue'>��g���O���էO�Φ�</B><BR>
<INPUT TYPE='reset' value='���s��g' class=bu1>
<INPUT TYPE='button' value='��n�e�X' onclick=\"bb('�T�w��n�F','stu_order');\" class=bu1><BR>
";
$arr=$rs->GetArray();
for($i=0; $i<$rs->RecordCount(); $i++) {
echo "��".$sportclass[$arr[$i][enterclass]].$sportname[$arr[$i][item]].$itemkind[$arr[$i][kind]]."<BR>";
$SQL1="select id,itemid,kgp,idclass,cname,sportorder,kgp from sport_res where itemid='".$arr[$i][id]."' and kmaster=0 and sportkind='5' and idclass like '$sclass%' order by kgp,sportorder";
$STU=get_order2($SQL1);
for($y=1; $y<=$arr[$i][kgp]; $y++) {
	$tmp1="<FONT COLOR='#696969'><U>".$sclass."�Z ��".$y."�եN��</U>::</font>";
	$tmp_str='';
	for ($x=0;$x<count($STU);$x++) {
	if ($STU[$x][kgp]==$y){
		$tmp_str.=substr($STU[$x][idclass],1,4).$STU[$x][cname]."\n<INPUT TYPE='text' NAME='Res_id[".$STU[$x][id]."]' VALUE='".$STU[$x][sportorder]."' size=2 CLASS='ipmei' onfocus=\"this.select();return false ;\" onkeydown=\"moveit2(this,event);\">&nbsp;\n";}
	}//end $x
	echo "<div style='color:#800000;margin-left:10pt;'>".$tmp1."&nbsp;".$tmp_str."</div>";

}//end for $y

} //end for $i
echo "<BR><BR><BR></td></tr></table><hr color=#800000 SIZE=1>
";
}


function link_a($mid,$sclass){
	$class_name_arr = class_base() ;
//$sql="select left(idclass,3) as aa,COUNT(DISTINCT idclass) as bb from sport_res where mid='$mid' and idclass like '$key%' group by aa";
//�D�H��
	$sql="select left(idclass,3) as aa,COUNT(id) as bb  from sport_res  where mid='$mid' and idclass like '$key%' group by  aa  ";
	$NUM=initArray("aa,bb",$sql);//�D����

	$ss="<FORM name=p2>��ܯZ�šG<select name='link2' size='1' class='small' onChange=\"if(document.p2.link2.value!='')change_link(document.p2.link2.value);\"> ";
	foreach($class_name_arr as $key=>$val) {
		($sclass==$key) ? $cc=" selected":$cc="";
		$ss.="<option value='$PHP_SELF?mid=$_GET[mid]&sclass=$key'$cc>$val --".$NUM[$key]."��</option>\n";
	}
	$ss.="</select><FONT SIZE='-1' COLOR='blue'>�����G��H�h�����W��p��b���C(���ƭp��)</FONT></FORM>";
Return $ss;
}

?>
