<?php
//$Id: mgr_order2.php 8769 2016-01-13 14:16:55Z qfon $
include "config.php";
//�{��
sfs_check();

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
#####################   �ۦ�D��  ###########################
if ($_POST[act]=='act_sel'){
//	echo "<PRE>";print_r($_POST);die();
	if($_POST[mid]=='') backe("�ާ@���~!");
	if($_POST[item]=='') backe("�ާ@���~!");
	if($_POST[sitem]=='') backe("�ާ@���~!");
	if($_POST[stu]=='') backe("����ܾǥ�!���U��^�W������!");
	if($_POST[stu_N]=='') backe("����ܾǥ�!���U��^�W������!");
	$mid=$_POST[mid];$item=$_POST[item];$sitem=$_POST[sitem];
	asort($_POST[stu]);//�O�d���ޭ�,�è̤p�j�ƧǡC�ۤϨ禡��arsort()
for($i=0;$i<count($_POST[stu]);$i++) {
	list($key,$val)=each($_POST[stu]);
	$KK=split("_",$key);////idclass,sportnum,stud_id,sportkind ////���O��idclass,kmaster,kgp,sportkind
	$sql_check1="select id from sport_res  where stud_id='$KK[2]' and mid='$mid' and itemid='$sitem' ";
	$sql_check5="select id from sport_res  where  idclass='$KK[0]' and mid='$mid' and itemid='$sitem' and kmaster=2 and kgp='$KK[2]' ";
	($KK[3]=='5') ? $sql_check=$sql_check5:$sql_check=$sql_check1;//�Ϥ����O��
	$rs = $CONN->Execute($sql_check) or die($sql_check);
	if($rs->RecordCount() > 0 )  backe("�W�歫�ƤF�I�I�I");
	if($rs->RecordCount()==0 ) {
		$SQL1="INSERT INTO sport_res(mid,itemid,idclass,sportnum,stud_id,sportkind,cname,sportorder) VALUES ('$mid','$sitem','$KK[0]','$KK[1]','$KK[2]','$KK[3]','".$_POST[stu_N][$KK[0]]."','$GO_num[$i]')";
		$SQL5="INSERT INTO sport_res(mid,itemid,idclass,kmaster,kgp,sportkind,cname,sportorder) VALUES ('$mid','$sitem','$KK[0]','2','$KK[2]','$KK[3]','$KK[0]','$GO_num[$i]')";
	($KK[3]=='5') ? $SQL=$SQL5:$SQL=$SQL1;
		$SQL2="update sport_item set  res=res+1  where id='$sitem' ";
//	echo $SQL."<BR>".$SQL2."<BR>";
		$rs = $CONN->Execute($SQL) or die($SQL);
		$rs = $CONN->Execute($SQL2) or die($SQL2);
		}
	}
	$url=$PHP_SELF."?mid=$mid&item=$item&sitem=$sitem";header("Location:$url");
//	gonow($PHP_SELF."?mid=$mid&item=$item&sitem=$sitem");exit;
}

#####################   �R��  ###########################
if ($_POST[act]=='act_del'){
//	echo "<PRE>";print_r($_POST);die();
	if($_POST[mid]=='') backe("�ާ@���~!");
	if($_POST[item]=='') backe("�ާ@���~!");
	if($_POST[sitem]=='') backe("�ާ@���~!");
//	if($_POST[stu]!='') backe("�����F�I���U��^�W������!");
	if($_POST[del_stu]=='') backe("����ܾǥ�!���U��^�W������!");
	$mid=$_POST[mid];$item=$_POST[item];$sitem=$_POST[sitem];
for($i=0;$i<count($_POST[del_stu]);$i++) {
	list($key,$val)=each($_POST[del_stu]);
	$SQL="delete from  sport_res where id='$key' ";
	$SQL2="update sport_item set  res=res-1  where id='$sitem' ";
	$rs = $CONN->Execute($SQL) or die($SQL);
	$rs = $CONN->Execute($SQL2) or die($SQL2);
	}
	$url=$PHP_SELF."?mid=$mid&item=$item&sitem=$sitem";header("Location:$url");
//		gonow($PHP_SELF."?mid=$mid&item=$item&sitem=$sitem");
	
}

#####################   ���Z�P����  ###########################
if ($_POST[act]=='act_me'){
//	echo "<PRE>";print_r($_POST);die();
	if($_POST[mid]=='') backe("�ާ@���~!");
	if($_POST[item]=='') backe("�ާ@���~!");
	if($_POST[sitem]=='') backe("�ާ@���~!");
	if($_POST[stusco]=='' && $_POST[stuord]=='') backe("��J���~�I���U��^�W������!");
	$mid=$_POST[mid];$item=$_POST[item];$sitem=$_POST[sitem];
if ($_POST[stusco]!='' && $_POST[stuord]=='' ) {
	$SQL="select * from sport_item where id='$_POST[sitem]' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();
	$Chk=split("\.",$arr[0][sunit]);
	$SK=$arr[0][sportkind];
	foreach($_POST[stusco] as $key => $va) {
		$str='';
		$str=sp_nu($va,$Chk,$SK);//��,�ˬd�榡,���O
		if (strlen($str)==strlen($arr[0][sunit])){//�A�ˬd�@���榡
			$SQL="update sport_res set  results='$str'  where id='$key' ";
			$rs=$CONN->Execute($SQL) or die($SQL);
			}
		}//end foreach
	}//end if
if ($_POST[stuord]!='' && $_POST[stusco]=='' ) {
	foreach($_POST[stuord] as $key=>$val) {
	$SQL="update sport_res set  sportorder='$val'  where id='$key' ";
	$rs = $CONN->Execute($SQL) or die($SQL);
		}//end foreach
	}//end if
	$url=$PHP_SELF."?mid=$mid&item=$item&sitem=$sitem";header("Location:$url");
	}
function sp_nu($Arr,$Brr,$K){//	��,�ˬd�榡,���O
		$SOC=$Arr;
		$Arr=split("\.",trim($Arr));
		$Arr=array_pad($Arr,-count($Brr),'0');
//		echo "<PRE>";print_r($Arr);
		$nu=count($Brr)-1;
	if(strlen($Arr[$nu]) > strlen($Brr[$nu])) return'';
	for($a=0;$a<count($Brr);$a++){
		$i=$nu-$a;//���}�C�̫�@��
		$j=$i-1;
		($K==1 || $K==5) ? $Sp=60:$Sp=100;//��60��100(�ɶ��Ϊ���)
		if ($a==0){$tp1=$Arr[$i];}//�p���I�ᤣ�B�z
		else {
		$tp1=$Arr[$i]% $Sp;$tp2=floor($Arr[$i]/$Sp);//�ˬd�O�_�i��
		if ($tp2 > 0) $Arr[$j]+=$tp2;}//�i��h�[�J
		$Arr[$i]=$tp1;
		}
	$tt=array();
	for($i=0;$i<count($Brr);$i++){
		$x=strlen($Brr[$i]);
		$y=strlen($Arr[$i]);
		$forM="%0".$x."d";
	if ($y > $x ) return '';//die("�榡�t���Ӥj�A�L�k�PŪ�I");
		$tt[$i]=sprintf($forM,$Arr[$i]);
		}
		$tt=join('.',$tt);
	Return $tt;
	}



//�q�X�����������Y
head("�v�ɳ��W");

//print_menu($memu_p,$link2);
include_once "menu.php";
include_once "chk.js";
include_once "chi_text.js";
if($_GET[mid]=='') { print_menu($school_menu_p2);}
else {$link2="mid=$_GET[mid]&item=$_GET[item]&sitem=$_GET[sitem]"; print_menu($school_menu_p2,$link2);}

mmid($_GET[mid]);
if ($_GET[item]!='' && $_GET[sitem]!='' ){
	echo item_list($_GET[mid],$_GET[sitem]);
	stud_list($_GET[mid],$_GET[sitem]);
}
if ($_GET[item]!='' && $_GET[sitem]=='' ){
	$arr=get_next_item($_GET[item]);
	if ($arr=='') {
		echo item_list($_GET[mid]);}
	else {
		echo item_list($_GET[mid],$arr[id]);
		stud_list($_GET[mid],$arr[id]);}
	}
if ($_GET[item]=='' && $_GET[sitem]=='' ) echo item_list($_GET[mid]);


//�G������
foot();

#####################  �C�ܾǥ�   #############################
function stud_list($mid,$item) {
		global $sportname,$itemkind,$sportclass,$k_unit;
	$arr_2=get_item($item);//���o���ɶ���
	$arr_1=get_item($arr_2[skind]);//���o���ɶ���
//if ($arr_2[sportkind]=='5' || $arr_1[sportkind]=='5') return '';
if ($arr_1=='' || $arr_2=='') return '';
($arr_2[sportkind]=='5' || $arr_1[sportkind]=='5') ? $A_nu=chkman_nu($arr_1[id]):$A_nu=chkman4($arr_1[id]);//�p���`�H/����
	$A_one=$arr_1[playera];//�C�դH��
	$A_go=$arr_1[passera];//�����H��
	$A_Name=$sportclass[$arr_1[enterclass]].$sportname[$arr_1[item]].$itemkind[$arr_1[kind]];//�W��
	$B_Name=$sportclass[$arr_2[enterclass]].$sportname[$arr_2[item]].$itemkind[$arr_2[kind]];//�W��
	$A_gp=ceil($A_nu/$A_one);//�p��ռ�
if ($_GET[txt]=='open') include_once 'chi_text.js';

?>
<table border=0 width='100%' style='font-size:11pt;'  cellspacing=1 cellpadding=0 bgcolor=silver>
<FORM METHOD=POST ACTION='<?=$PHP_SELF?>' name='f1'>
<tr bgcolor=white><td width =40% valign=top>
<INPUT TYPE='hidden' name='mid' value='<?=$mid?>'>
<INPUT TYPE='hidden' name='item' value='<?=$arr_1[id]?>'>
<INPUT TYPE='hidden' name='sitem' value='<?=$item?>'>
<INPUT TYPE='hidden' name='act' value=''>
<?php
//echo "<PRE>";print_r($arr_2);
///�������//$arr_1;
echo"<div style='color:#800000;font-size:10pt; '><FONT COLOR='blue'>��".$A_Name."</FONT><BR> �@ <B>$A_nu</B> �W/�� ���� , �C�� <B>$A_one</B> �W , ���� <B>$A_go</B> �W $arr_1[imemo] �i�M�ɡC<BR></div>";
//	($arr_1[s_ord]=='2') ? $ord=' desc':$ord='' ;
echo "�U�C���Ѩ�ع_��覡�i�J�M�ɡA<BR>�Х��Τ@�ءA���n�V�ΡI<HR size=1 color=#800000>";
////         ADD�� 0513 �̤��ƱƧǤ覡
($arr_1[sord]==1) ? $ORD='asc':$ORD='desc';
$Arr_order=get_order2("select * from sport_res where mid='$mid' and itemid='$arr_1[id]' and   abs(results)!=0 order by  results $ORD ");
	$tmp_str="���̦��Z�C��<div style='margin-left:10pt'>";
	for($i=0; $i<count($Arr_order); $i++) {
		( $Arr_order[$i][results]==$arr_1[sunit]) ? $Cor='#696969':$Cor='red';//�S�����Z���Ǧ�
		$G_gp=G_gp($Arr_order[$i][sportorder],$A_one);
		$NN=$i+1;
		if ($arr_1[sportkind]=='5') {
			$tmp_str.="<INPUT TYPE='hidden' NAME='stu_N[".$Arr_order[$i][idclass]."]' value='".$Arr_order[$i][cname]."'>";
			$tmp_str.="<INPUT TYPE='checkbox' NAME='stu[".$Arr_order[$i][idclass]."_".$Arr_order[$i][kmaster]."_";
			$tmp_str.=$Arr_order[$i][kgp]."_".$Arr_order[$i][sportkind]."]' value='".$Arr_order[$i][results]."'>";
			$tmp_str.="($G_gp)�� $NN �W".$Arr_order[$i][sportorder]."_".$Arr_order[$i][cname]."�Z��".$Arr_order[$i][kgp]."��<FONT COLOR='$Cor'>".$Arr_order[$i][results]."</FONT><BR>\n";
			}
		else {
			$tmp_str.="<INPUT TYPE='hidden' NAME='stu_N[".$Arr_order[$i][idclass]."]' value='".$Arr_order[$i][cname]."'>";
			$tmp_str.="<INPUT TYPE='checkbox' NAME='stu[".$Arr_order[$i][idclass]."_".$Arr_order[$i][sportnum]."_";
			$tmp_str.=$Arr_order[$i][stud_id]."_".$Arr_order[$i][sportkind]."]' value='".$Arr_order[$i][results]."'>";
			$tmp_str.="($G_gp)�� $NN �W".$Arr_order[$i][sportorder]."_".$Arr_order[$i][cname]."<FONT COLOR='$Cor'>".$Arr_order[$i][results]."</FONT><BR>\n";
			}

	}
echo $tmp_str."</div>";
////         ADD�� 0513 �̤��ƱƧǤ覡....end

echo "<HR size=1 color=#800000>";
for ($a=1;$a<=$A_gp ;$a++){
($arr_1[sportkind]=='5') ? $Arr=get_order($arr_1[id],'par',"results $ord ,$a,$A_one",5):$Arr=get_order($arr_1[id],'par',"results $ord ,$a,$A_one");
	$tmp_str="���� $a ��<div style='margin-left:10pt'>";
	for($i=0; $i<count($Arr); $i++) {
		( $Arr[$i][results]==$arr_1[sunit]) ? $Cor='#696969':$Cor='red';//�S�����Z���Ǧ�
		if ($arr_1[sportkind]=='5') {
			$tmp_str.="<INPUT TYPE='hidden' NAME='stu_N[".$Arr[$i][idclass]."]' value='".$Arr[$i][cname]."'>";
			$tmp_str.="<INPUT TYPE='checkbox' NAME='stu[".$Arr[$i][idclass]."_".$Arr[$i][kmaster]."_";
			$tmp_str.=$Arr[$i][kgp]."_".$Arr[$i][sportkind]."]' value='".$Arr[$i][results]."'>";
			$tmp_str.=$Arr[$i][sportorder]."_".$Arr[$i][cname]."�Z��".$Arr[$i][kgp]."��<FONT COLOR='$Cor'>".$Arr[$i][results]."</FONT><BR>\n";
			}
		else {
			$tmp_str.="<INPUT TYPE='hidden' NAME='stu_N[".$Arr[$i][idclass]."]' value='".$Arr[$i][cname]."'>";
			$tmp_str.="<INPUT TYPE='checkbox' NAME='stu[".$Arr[$i][idclass]."_".$Arr[$i][sportnum]."_";
			$tmp_str.=$Arr[$i][stud_id]."_".$Arr[$i][sportkind]."]' value='".$Arr[$i][results]."'>";
			$tmp_str.=$Arr[$i][sportorder]."_".$Arr[$i][cname]."<FONT COLOR='$Cor'>".$Arr[$i][results]."</FONT><BR>\n";
			}
	}
////idclass,sportnum,stud_id,sportkind////���O��idclass,kmaster,kgp,sportkind
echo $tmp_str."</div>";
	}


echo "</td><td width=20% valign=top style='color:#800000'>���ާ@�ﶵ�G<BR><BR><BR><CENTER>";

$bu1="<INPUT TYPE=button  value='>>�N�_��̥[�J>>' onclick=\" bb('�o�ǤH�i�M�ɡH','act_sel');\" class=bu1><BR><BR>
<INPUT TYPE=button  value='<<�N�_��̲���<<' onclick=\" bb('�N�_��̲����H','act_del');\" class=bu1><BR><BR>";
$bu2="<INPUT TYPE=button  value='�s��M�ɹD��' onclick=\"location.href='$PHP_SELF?mid=$mid&item=$item&sitem=$arr_2[id]&tb=ord';\"  class=bu1><BR><BR>";
$bu3="<INPUT TYPE=button  value='��J�M�ɦ��Z' onclick=\"location.href='$PHP_SELF?mid=$mid&item=$item&sitem=$arr_2[id]&tb=sco';\"  class=bur2><BR><BR>";

$tmp_str1="<INPUT TYPE=button  value='�̧ڶ�g���e�X' onclick=\" bb('�̧ڶ�g���e�X�H�u���H','act_me');\" class=bur> <BR><BR>";
$bu5="<INPUT TYPE=button  value='������^' onclick=\"self.history.back();\" class=bur><BR><BR>";

($_GET[tb]!='') ? $txt_tb=$tmp_str1.$bu5:$txt_tb=$bu1.$bu2.$bu3;



echo $txt_tb."<INPUT TYPE='reset'  value='�M �� �� ��'  class=bu1>";

echo "</CENTER></td><td width=40% valign=top>";
///////////////�M����ܳB�z ///////////////////////
($arr_2[sportkind]=='5' || $arr_1[sportkind]=='5') ? $B_nu=chkman_nu($arr_2[id]):$B_nu=chkman4($arr_2[id]);//�p���`�H/����
//	$B_nu=chkman4($arr_2[id]);//�`�H��
	$B_one=$arr_2[playera];//�C�դH��
	$B_go=$arr_2[passera];//�����H��
	$B_Name=$sportclass[$arr_2[enterclass]].$sportname[$arr_2[item]].$itemkind[$arr_2[kind]];//�W��
	$B_gp=ceil($B_nu/$B_one);//�p��ռ�

echo"<div style='color:#800000'><FONT  COLOR='blue'>��".$B_Name." �̲էO�C�X</FONT><BR> �@ <B>$B_nu</B> �H�i�M�� , �C�� <B>$B_one</B> �H , ���� <B>$B_go</B> �H�C</div>";

for ($a=1;$a<=$B_gp ;$a++){
($arr_2[sportkind]=='5') ? $Arr=get_order($arr_2[id],'par',"sportorder,$a,$B_one",5):$Arr=get_order($arr_2[id],'par',"sportorder,$a,$B_one");
//	$Arr=get_order($arr_2[id],'par',"sportorder,$a,$B_one");//�ƧǨ�,�ĴX��,�C�դH��
	$tmp_str="���� $a ��&nbsp;<INPUT TYPE='button' value='�L�X�� $a ���˿���' onclick=\"window.open('mgr_prt.1.php?mid=$mid&item=$arr_2[id]&Spk=$a&kitem=speed','','scrollbars=yes,resizable=yes,height=500,width=600');\" class=bur><INPUT TYPE='button' value='�D�$a��' onclick=\"window.open('mgr_prt_new.php?mid=$mid&item=$arr_2[id]&Spk=$a&kitem=speed&ord=na','','scrollbars=yes,resizable=yes,height=500,width=600');\" class=bur><INPUT TYPE='button' value='�w�}��$a��' onclick=\"window.open('mgr_prt_new.php?mid=$mid&item=$arr_2[id]&Spk=$a&kitem=speed&ord=local','','scrollbars=yes,resizable=yes,height=500,width=600');\" class=bur><div style='margin-left:10pt'><div style='margin-left:10pt'>
	";
	for($i=0; $i<count($Arr); $i++) {
		($Arr[$i][results]=='') ? $results='0.0':$results=$Arr[$i][results];
		$INP="<INPUT TYPE='checkbox' NAME='del_stu[".$Arr[$i][id]."]' value='".$Arr[$i][cname]."'>";
		if($_GET[tb]=='ord') { $INP="<INPUT TYPE='text' NAME='stuord[".$Arr[$i][id]."]' value='".$Arr[$i][sportorder]."' size=4  class=ipr onfocus=\"this.select();return false ;\" onkeydown=\"moveit2(this,event);\" >";}
		if ($_GET[tb]=='sco') {
			$INP="<INPUT TYPE='text' NAME='stusco[".$Arr[$i][id]."]' value='".$results."' size=10  class=ipr onfocus=\"this.select();return false ;\" onkeydown=\"moveit2(this,event);\" >";
		}
		$tmp_str.=$INP;
		($arr_2[sportkind]=='5') ? $print_kgp="�Z��".$Arr[$i][kgp]."��":$print_kgp='';
		$tmp_str.=$Arr[$i][sportorder]."_".$Arr[$i][cname]."$print_kgp<FONT COLOR='#696969'>".$Arr[$i][sportnum]." ($results)</FONT><BR>\n";
		}
echo $tmp_str."</div>";
	}
echo "<hr color=#696969 SIZE=1><FONT  COLOR='blue'>��".$B_Name."���˿��W��G</FONT><div style='margin-left:10pt'>";
//	$Arr=get_order(,'all',"sportorder ");//�ƧǨ�,�ĴX��,�C�դH��
	$Arr=get_order2("select * from sport_res where itemid='$arr_2[id]' and sportorder=0 ");
	for($i=0; $i<count($Arr); $i++) {
			($Arr[$i][results]=='') ? $results=$arr_2[sunit]:$results=$Arr[$i][results];
		$tmp_str='';
		$INP="<INPUT TYPE='checkbox' NAME='del_stu[".$Arr[$i][id]."]' value='".$Arr[$i][cname]."'>";
		if($_GET[tb]=='ord') { $INP="<INPUT TYPE='text' NAME='stuord[".$Arr[$i][id]."]' value='".$Arr[$i][sportorder]."' size=4  class=ipr onfocus=\"this.select();return false ;\" onkeydown=\"moveit2(this,event);\" >";}
		if ($_GET[tb]=='sco') {
			$INP="<INPUT TYPE='text' NAME='stusco[".$Arr[$i][id]."]' value='".$results."' size=10  class=ipr onfocus=\"this.select();return false ;\" onkeydown=\"moveit2(this,event);\" >";
		
		}		
		$tmp_str.=$INP;
		$tmp_str.=$Arr[$i][sportorder]."_".$Arr[$i][cname]."<FONT COLOR='#696969'>".$Arr[$i][sportnum]." ($results)</FONT><BR>\n";
		echo $tmp_str;
		}


echo"</div></td></tr></FORM></table><hr color=#800000 SIZE=1>";
}
function Co_GP($lg,$nu){//�նZ,�s��
$a=ceil($nu/$lg);//�p��ռ�
return $a;
}
#####################  �C�ܶ���   #############################
function item_list($mid,$item=''){
		global $CONN,$sportclass,$sportname,$itemkind;
		$class_numa=substr($class_num,0,1);
	$SQL="select *  from sport_item   where  mid='$mid' and  skind!=0  order by  kind, enterclass ";
	$rs=$CONN->Execute($SQL) or die($SQL);// and sportkind!=5
	$arr=$rs->GetArray();
	$SQL="select itemid ,count(id) as nu from  sport_res   where  mid='$mid' group by itemid ";
	$arr_1=initArray("itemid,nu",$SQL);//�����H��
	$SQL="select itemid ,count(id) as nu from  sport_res   where  mid='$mid' and  sportnum!='' group by itemid ";
	$arr_2=initArray("itemid,nu",$SQL);//�v�˿��H��(�s�ƶ���)
	$SQL="select itemid ,count(id) as nu from  sport_res   where  mid='$mid' and  sportorder!=0 group by itemid ";
	$arr_3=initArray("itemid,nu",$SQL);//�v�˿��H��(�s�ƶ���)
	$SQL="select itemid ,count(id) as nu from  sport_res   where  mid='$mid' and results !='' and kmaster=0   group by itemid ";
	$arr_4=initArray("itemid,nu",$SQL);//�����Z�H��

	$SQL="select itemid ,count(id) as nu from  sport_res   where  mid='$mid' and kmaster='2' group by itemid ";
	$Brr_1=initArray("itemid,nu",$SQL);//�����H��
	$SQL="select itemid ,count(id) as nu from  sport_res   where  mid='$mid' and kmaster='2'  and  sportnum!='' group by itemid ";
	$Brr_2=initArray("itemid,nu",$SQL);//�v�˿��H��(�s�ƶ���)
	$SQL="select itemid ,count(id) as nu from  sport_res   where  mid='$mid' and kmaster='2'  and  sportorder!=0 group by itemid ";
	$Brr_3=initArray("itemid,nu",$SQL);//�v�˿��H��(�s�ƶ���)
	$SQL="select itemid ,count(id) as nu from  sport_res   where  mid='$mid' and kmaster='2'  and results !=''  group by itemid ";
	$Brr_4=initArray("itemid,nu",$SQL);//�����Z�H��


	$ss="<FORM name=p2>��ܶ��ءG<select name='link2' size='1' class='bur' onChange=\"if(document.p2.link2.value!='')change_link(document.p2.link2.value);\">\n<option value='$PHP_SELF?mid=$_GET[mid]&item='>�����</option> ";

for($i=0; $i<$rs->RecordCount(); $i++) {
	if ($arr[$i][sportkind]!=5){
		($arr_1[$arr[$i][id]]=='') ? $Nu1=0:$Nu1=$arr_1[$arr[$i][id]];
		($arr_2[$arr[$i][id]]=='') ? $Nu2=0:$Nu2=$arr_2[$arr[$i][id]];
		($arr_3[$arr[$i][id]]=='') ? $Nu3=0:$Nu3=$arr_3[$arr[$i][id]];
		($arr_4[$arr[$i][id]]=='') ? $Nu4=0:$Nu4=$arr_4[$arr[$i][id]];
			}else {
		($Brr_1[$arr[$i][id]]=='') ? $Nu1=0:$Nu1=$Brr_1[$arr[$i][id]];
		($Brr_2[$arr[$i][id]]=='') ? $Nu2=0:$Nu2=$Brr_2[$arr[$i][id]];
		($Brr_3[$arr[$i][id]]=='') ? $Nu3=0:$Nu3=$Brr_3[$arr[$i][id]];
		($Brr_4[$arr[$i][id]]=='') ? $Nu4=0:$Nu4=$Brr_4[$arr[$i][id]];
			}

		($item==$arr[$i][id]) ? $cc=" selected":$cc="";
		$ss.="<option value='$PHP_SELF?mid=$_GET[mid]&item=".$arr[$i][skind]."&sitem=".$arr[$i][id]."'$cc>".$sportclass[$arr[$i][enterclass]].$sportname[$arr[$i][item]].$itemkind[$arr[$i][kind]]."&nbsp;(���W��: $Nu1 �s����: $Nu2 �˿���: $Nu3 ���Z��: $Nu4)</option>\n";
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

function G_gp($order,$li){
//�ǤJ�s��,�C�դH��
$ss=ceil($order / $li);// �D�l��

Return $ss ;//�ǥX�էO
}

?>
