<?php
//$Id: config_sport.php 8769 2016-01-13 14:16:55Z qfon $
//$sport_GO_num=array(8=>1,7=>1,6=>2,5=>2,4=>3,3=>3,2=>4,1=>4);
//$sport_GO_num6=array(6=>1,5=>1,4=>2,3=>2,2=>3,1=>3);
//�e�����ɤH��
//��̬��]�D��,�N����H�ƥ����ɭn�q���Ӷ]�D�}�l�s�ƹD��
//$GO_num=array(4,5,3,6,2,7,1,8);
//$GO_num6=array(3,4,2,5,1,6);
check_update9311();
$GO_num_data=initArray("kkey,na","select kkey,na from sport_var where gp='road_num' ");//��l�ƶ���
$sport_GO_num=get_num_start($GO_num_data[num]);
$GO_num=get_num_out($GO_num_data[num]);
//print_r($GO_num);
////------�H�U�ͤ�ФŦA���ܧ�--������ҳ]�w����------//////
function check_update9311() {
	global $CONN;
	$SQL="select kkey,na from sport_var where gp='road_num' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
if ($rs->RecordCount()==0){
		$SQL="insert into  sport_var(gp,kkey,na)values('road_num','num','8') ";
		$rs=$CONN->Execute($SQL) or die($SQL);
	}
	return"";
}
////------�H�U�ͤ�ФŦA���ܧ�--������ҳ]�w����------//////
function get_num_out($GO_num) {
	$all= intval($GO_num);
	$nn=array();
for($i=0;$i<$all;$i++){
	switch ($all%2) {
		case 0:
			(($i%2)==0) ? $num=$all/2-$i/2:$num=ceil($all/2+$i/2);break;
		case 1:
			(($i%2)==1) ? $num=$all/2-$i/2:$num=ceil($all/2+$i/2);break;
		default:"";
		}
		$nn[$i]=$num;//4 5 3 6 2 7 1 8echo $num."<BR>";	
	}
	return $nn;
}
////------�H�U�ͤ�ФŦA���ܧ�--������ҳ]�w����------//////
function get_num_start($GO_num) {
	$all= intval($GO_num);
	$nn=array();
for($i=1;$i<=$all;$i++){
	switch ($all%2) {
		case 0:
		(($i%2)==1) ? $num=ceil(($all-$i)/2):$num=ceil(($all-$i)/2)+1;break;
		case 1:
		(($i%2)==0) ? $num=ceil(($all-$i)/2):$num=ceil(($all-$i)/2)+1;break;
		default:"";
	}
//	echo "\$nn[$i]:=".$num."<BR>";
	$nn[$i]=$num;//4 5 3 6 2 7 1 8echo $num."<BR>";	
	}
	return $nn;
}

//�M�ɮɦ��Z��1�W�Ʋ�4�D��2�W�Ʋ�5�D...
/*
$sportname=array(7=>"����",8=>"����",9=>"�βy�Y��",10=>"���r",11=>"�S�y�Y��",
12=>"60����",13=>"80����",14=>"100����",
15=>"200����",16=>"�ǥͽլd",17=>"�j�����O",18=>"���]�y",19=>"�K��",20=>"�кj",
1=>"�@��",2=>"�t��",3=>"�`��",4=>"�d�r��",5=>"�Ѫk",6=>"��Ū");
*/
$sportname=initArray("kkey,na","select kkey,na from sport_var where gp='sportname' ");//��l�ƶ���
////------�H�U�ͤ�ФŦA���ܧ�--������ҳ]�w����------//////
////////////////////////////////////////////////////////////
//$s_unit=array("long"=>"����","heigh"=>"����","speed"=>"�t��","score"=>"����",);//�p�q���
/*$sportclass=array(
"1a"=>"�@�k","1b"=>"�@�k","2a"=>"�G�k","2b"=>"�G�k",
"3a"=>"�T�k","3b"=>"�T�k","4a"=>"�|�k","4b"=>"�|�k",
"5a"=>"���k","5b"=>"���k","6a"=>"���k","6b"=>"���k",
"1c"=>"1�~��","2c"=>"2�~��","3c"=>"3�~��","4c"=>"4�~��",
"5c"=>"5�~��","6c"=>"6�~��");*/
if($IS_JHORES==0) $sportclass=initArray("kkey,na","select kkey,na from sport_var where gp='sportclass' ");//��p
if($IS_JHORES==6) $sportclass=initArray("kkey,na","select kkey,na from sport_var where gp='sportclass7' ");//�ꤤ
$sportkind_name=array(1=>"�v����",5=>"�v��(���O)",2=>"������",3=>"�y����",4=>"��L��");//���s��sport_item.sportkind 
$kind_unit=array(1=>"x.xx.xx.x(��.��.��.x)",2=>"xx.xx.x(����.����.x)");
$k_unit=array('1'=>'0.00.00.0','2'=>'00.00.0');//�p���榡
$itemkind=array("1"=>"����","2"=>"�M��","3"=>"����");//���s��sport_item.kind 

##################�H���ˬdsfs3###########################
function check_man($login,$mid,$pa) {
	global $CONN;
	$SQL="select * from  sport_teach where  teacher_sn='$login' and  tmid='$mid' and pa >='$pa' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$rtn='NO';
if ($rs->RecordCount()==1 ) $rtn='YES';
	return $rtn;
	}
##################����ⶤ �C�Z�Ȥ@�H ###########################
function get_Master($mid,$sclass) {
	global $CONN;
	$SQL="select * from  sport_res where mid='$mid' and idclass like '$sclass%' and kmaster=1 ";
//die($SQL);
	$rs=$CONN->Execute($SQL) or die($SQL);
if ($rs->RecordCount()!=1 ) return "";
	$arr=$rs->GetArray();
	return $arr[0];
	}

##################�ɶ��ˬd###########################
function chk_time_out($begin,$stop,$str) {
	if($str=='a') {
		$pri=array("--���W�w�I��","--�|���}��","--�ާ@���z��..");}
	else {
		$pri=array("--�ާ@�����v�L","--�|���}�l�@�~","--�}��@�~��..");}
	$be=split("[- :]",$begin);//�~0,��1,��2,��3,��4,��5
	$st=split("[- :]",$stop);
	$begin_T=mktime($be[3],$be[4],0,$be[1],$be[2],$be[0]);//�ɤ�����~
	$stop_T=mktime($st[3],$st[4],0,$st[1],$st[2],$st[0]);
	$now=mktime(date("H"),date("i"),0,date("m"),date("d"),date("Y")); 
	if ($now > $stop_T && $now > $begin_T ) $rn=array("1",$pri[0]);
	if ($now < $begin_T && $stop_T > $now) $rn=array("2",$pri[1]);
	if ( $begin_T < $now && $stop_T > $now) $rn=array("3",$pri[2]);
	Return $rn;//�s��,��r
}
#####################   �C�ܥD�n����  ###########################
function mmid($gmid='') {
	global $CONN;
($gmid=='')? $SQL="select * from  sport_main   order by  year ":$SQL="select * from  sport_main  where id='$gmid' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();
for($i=0; $i<$rs->RecordCount(); $i++) {
	$strA= "<img  src='images/21.gif' border=0>";
	$strB="<A HREF='$PHP_SELF?mid=".$arr[$i][id]."'>";
	$strD="</A>";
	$str_time=chk_time_out($arr[$i][work_start],$arr[$i][work_end],b);//�ˬd�ɶ�
		switch($str_time[0]) {
			case '1':echo $img.$strA.$arr[$i][title].$str_time[1];break;
			case '2':echo $img.$strA.$arr[$i][title].$str_time[1];break;
			case '3':echo $img.$strA.$strB.$arr[$i][title].$str_time[1].$strD;break;
			default:}
	echo "&nbsp;(".$arr[$i][year].")<BR>\n";
	}
}
#####################   �C�ܥD�n����  ###########################
function mmid_t($gmid='') {
	global $CONN;
($gmid=='')? $SQL="select * from  sport_main   order by  year ":$SQL="select * from  sport_main  where id='$gmid' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();
for($i=0; $i<$rs->RecordCount(); $i++) {
	$strA= "<img  src='images/21.gif' border=0>";
	$strB="<A HREF='$PHP_SELF?mid=".$arr[$i][id]."'>";
	$strD="</A>";
	$str_time=chk_time_out($arr[$i][signtime],$arr[$i][stoptime],a);//�ˬd�ɶ�
		switch($str_time[0]) {
			case '1':echo $img.$strA.$arr[$i][title].$str_time[1];break;
			case '2':echo $img.$strA.$arr[$i][title].$str_time[1];break;
			case '3':echo $img.$strA.$strB.$arr[$i][title].$str_time[1].$strD;break;
			default:}
	echo "&nbsp;(".$arr[$i][year].")<BR>\n";
	}
}

#####################   �ˬd�}��ɶ��p�G�i�H�ާ@,�h�Ǧ^3   ###########################
function ch_mid_t($gmid) {
	global $CONN;
	$SQL="select * from  sport_main  where id='$gmid' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();
	if($rs->RecordCount()==1 ) {
		$str_time=chk_time_out($arr[0][work_start],$arr[0][work_end],b);//�ˬd�ɶ�
		Return $str_time[0];
		}
}
#####################   �ˬd�}��ɶ��p�G�i�H�ާ@,�h�Ǧ^3   ###########################
function ch_mid($gmid='') {
	global $CONN;
	$SQL="select * from  sport_main  where id='$gmid' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();
	if($rs->RecordCount()==1 ) {
		$str_time=chk_time_out($arr[0][signtime],$arr[0][stoptime],b);//�ˬd�ɶ�
		Return $str_time[0];
		}
}

##################�H���p��###########################
function chkman4($item) {
	global $CONN ;
	$SQL="select * from  sport_res  where itemid='$item' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
return $rs->RecordCount();
}
##################�H���p��###########################
function chkman_nu($item) {
	global $CONN ;
	$SQL="select * from  sport_res  where itemid='$item' and kmaster=2 ";
	$rs=$CONN->Execute($SQL) or die($SQL);
return $rs->RecordCount();
}
##################�p��H�ƨ禡###########################
function chk4num($item) {
	global $CONN ;
$ra=$CONN->Execute("select id from sport_res where itemid=$item ");//�Ӷ��ؤH��
$rb=$CONN->Execute("select id from sport_res where itemid=$item and results=0 ");//�S�����Z
$rc=$CONN->Execute("select id from sport_res where itemid=$item and sportorder=0 ");//�S���ƧǪ�
$a=array($ra->RecordCount(),$rb->RecordCount(),$rc->RecordCount());
unset($ra);
unset($rb);
unset($rc);
return $a;
}
##################���o���ظ�T�禡###########################
function initArray($F1,$SQL){
	global $CONN ;
//	global $db;
// ��|����F �O���� $rs ��������m(EOF�GEnd Of File)�ɡA(�Y�G�٦��O���|�����X��)
	$col=split(",",$F1);
	$rs = $CONN->Execute($SQL) or die($SQL);
	$sch_all = array();
	if (!$rs) {
    Return $CONN->ErrorMsg(); 
	} else {
		while (!$rs->EOF) {
//	print $rs->fields['sch_id'] . " " . $rs->fields['sch_name'];
	if(count($col)==2) {
//		$index=$col[0];$val=$col[1];
//		$index=$rs->fields[0];
//		$sch_all[$rs->fields[$index]]=$rs->fields[$val]; 
		$sch_all[$rs->fields[0]]=$rs->fields[1]; 
//		echo $rs->fields[0]."_".$rs->fields[1]."<BR>";
		}
	if(count($col)==3) {
		$sch_all[$rs->fields[0]]=array($val=>$rs->fields[1],$val2=>$rs->fields[2]);
//		$index=$col[0];$val=$col[1];$val2=$col[2];
//		$sch_all[$rs->fields[$index]]=array($val=>$rs->fields[$val],$val2=>$rs->fields[$val2]);
		}
	$rs->MoveNext(); // ���ܤU�@���O��
	}
	}
	Return $sch_all;
}

##################���o���ظ�T�禡###########################
function get_order($item,$kind,$str='',$KM='') {
	//����,�覡,(�ĴX��,�C�դH��,�ƧǨ�)
	global $CONN ;
	$LL=split(",",$str);//�ƧǨ�,�ĴX��,�C�դH��
//$SQL="SELECT * FROM sport_res WHERE itemid='$item' ";
($KM=='') ? $add_KM='': $add_KM=' and kmaster=2 ';
//echo $add_KM;
if ($LL[1]!='' && $kind!='all'){
	$Q=$LL[0];
	$La=($LL[1]-1)*$LL[2];
	$Lb=$LL[1]*$LL[2];
	$SQL="SELECT * FROM sport_res WHERE itemid='$item' and sportorder>$La and sportorder<= $Lb  $add_KM  order by $Q ";
	}
if ($kind=='all' && $LL[0]!=''){
	$Q=$LL[0];
	$SQL="SELECT * FROM sport_res WHERE itemid='$item'  $add_KM   order by $Q ";}

($SQL=='') ? $SQL="SELECT * FROM sport_res WHERE itemid='$item'  $add_KM   ":$SQL;
$rs=$CONN->Execute($SQL) or die($SQL);
$arr = $rs->GetArray();
return $arr ;
}
##################���o���ظ�T�禡###########################
function get_order2($SQL) {
	//����,�覡,(�ĴX��,�C�դH��,�ƧǨ�)
	global $CONN ;
$rs=$CONN->Execute($SQL) or die($SQL);
$arr = $rs->GetArray();
return $arr ;
}
##################���o�������ظ�T�禡##################
function get_next_item($id) {
	global $CONN ;
	$SQL="select * from sport_item where skind ='$id' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	if($rs->RecordCount()==1 ) {
	$arr=$rs->GetArray();
	return $arr[0];
		}
	}
##################���o�W�@�Ӭ������ظ�T�禡##################
function get_item($id) {
	global $CONN ;
	$SQL="select * from sport_item where id ='$id' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	if($rs->RecordCount()==1 ) {
	$arr=$rs->GetArray();
	return $arr[0];
		}
}
########IP�ˬd�禡--���J#################################
function checkip($rip) {
	global $remote_in;
	$allowIP=$remote_in;
	$rip=split("\.",$rip);
	$login='off';
for ($i=0;$i<count($allowIP);$i++) {
	$AIP=split("\.",$allowIP[$i]);
if ($rip[0]==$AIP[0] && $rip[1]==$AIP[1] &&  $rip[2]==$AIP[2] ) {
	$AIPB=split("-",$AIP[3]);
	for ($j=$AIPB[0];$j<=$AIPB[1];$j++) {
		if ($j==$rip[3]) {$login='on';}
		}
	}//if
	}//for
return $login;
}
##################�^���禡#####################
function walert($st='�w����L������ơI\n\n�L�k����z���ާ@�ʧ@�I') {

echo"
<SCRIPT LANGUAGE=\"JavaScript\">
<!--
alert('$st');
//-->
</SCRIPT>";
}
##################�}�C�C�ܨ禡##########################
function set_sport_select($name,$array_name,$select_t="") {
	//�W��,�_�l��,������,��ܭ�
echo"<select name='$name'>\n";
echo "<option value='�����'>----</option>\n";
for ($i=0;$i<count($array_name);$i++) {

if ($i==$select_t)
	{echo "<option value=".$i." selected>".$array_name[$i]."</option>\n";}
	else {
	echo "<option value=".$i." >".$array_name[$i]."</option>\n";	}
}
echo "</select>";
 }
##################�}�C�C�ܨ禡2##########################
function set_sport_selectb($name,$array_name,$select_t='') {
	//�W��,�_�l��,������,��ܭ�
echo"<select name='$name' >\n";
echo "<option value='�����'>-�����-</option>\n";
foreach($array_name as $key=>$val) {
 ($key==$select_t) ? $bb=' selected':$bb='';
	echo "<option value='$key' $bb>$val</option>\n";
	}

echo "</select>";
 }
##################�}�C�C�ܨ禡2##########################
function chi_sel($name,$array_name,$select_t='') {
	//�W��,�_�l��,������,��ܭ�
$str="<select name='$name' >\n";
$str.="<option value=''>-�����-</option>\n";
foreach($array_name as $key=>$val) {
 ($key==$select_t) ? $bb=' selected':$bb='';
	$str.= "<option value='$key' $bb>$val</option>\n";
	}
$str.="</select>";
return $str;
 }
##################�ɶ��禡######################
function set_time_select($name,$start,$stop,$select_t="") {
	//�W��,�_�l��,������,��ܭ�
echo"<select name='$name' size=1>\n";
echo "<option value='�����'>----</option>\n";
for ($i=$start;$i<$stop;$i++) {

if ($i==$select_t)
	{echo "<option value='$i' selected>$i</option>\n";}
	else {
	echo "<option value='$i' >$i</option>\n";	}
}
echo "</select>";
 }
##################�~�ůZ�Ůy���禡############################
function set_class($name,$start,$stop,$select_t="") {
	//�W��,�_�l��,������,��ܭ�
echo"<select name=".$name." class=b14>\n";
echo "<option value=''>�����</option>\n";
for ($i=$start;$i<$stop;$i++) {

if ($i==$select_t)
	{echo "<option value=\"".sprintf("%02d",$i)."\" selected>".$i."</option>\n";}
	else {
	echo "<option value=\"".sprintf("%02d",$i)."\" >".$i."</option>\n";	}
}
echo "</select>";
 }

##################�^�W���禡1#####################
function backinput($st="����!���U��^�W������!") {
echo"<CENTER><form>
	<input type='button' name='b1' value='$st' onclick=\"history.back()\" style='font-size:12pt;color:red'>
	</form></CENTER>";
	}
##################�^�W���禡1#####################
function backe($st="����!���U��^�W������!") {
echo"<BR><BR><BR><BR><CENTER><form>
	<input type='button' name='b1' value='$st' onclick=\"history.back()\" style='font-size:12pt;color:red'>
	</form></CENTER>";
	exit;
	}
##################�^�W���禡2############################
function backurl($st="����!���U��^�W������!",$url) {
echo"<CENTER><form>
<input type='button' name='b1' value='$st' onclick=\"location='$url'\" style='font-size:12pt;color:red'>
</form></CENTER>";
}

##################�୶�禡#######################################
//�N��ϥ�,�Цۭq
function gonow($afterurl) {
echo"<META HTTP-EQUIV=REFRESH CONTENT=\"0;URL=$afterurl\">";
	exit;}
###############�^�W���禡#####################################
function backhome($url,$st="�^����") {
	echo"<CENTER><form>
	<input type='button' name='b1' value='$st' onclick=\"location.href='$url';\" style='font-size:12pt;color:red'>
	</form></CENTER>";
	exit;}

function btt() {
?><FORM  NAME='ShowText'>
<INPUT TYPE='text' NAME='ifo' value='' size='30' disabled
style=' border-width: 0px; background-color:White; font-size:12pt;color:red;'>
</FORM>
<?php
	}
function btr($img,$word="���s��ܶ�g") {
?><input TYPE='image' align='top' border=0 SRC='<?=$img?>' 
onclick="this.form.reset();return false;" alt='<?=$word?>' 
onmouseover="ShowText.ifo.value='<?=$word?>';" onmouseout="ShowText.ifo.value='';">
<?php
	}
function bt($act,$word,$img) {
?>
<input TYPE='image' align='top' border=0 SRC='<?=$img?>' 
onclick=" if (window.confirm('<?=$word?>�H')){this.form.act.value='<?=$act?>';this.form.sumit();}return false;" alt='<?=$word?>' onmouseover="ShowText.ifo.value='<?=$word?>';" onmouseout="ShowText.ifo.value='';">

<?php
	}

?>
