<?
include "config.php";

head("�v�ɺ޲z");
include_once "menu.php";
echo " <CENTER><B>".$SCHOOL_BASE[sch_cname_s]."�v�ɦ��Z�d�\�t��</B></CENTER>";

($_GET[mid]!='') ? mmid2($_GET[mid]):mmid2();

if ($_GET[mid]!='' && $_GET[item]=='') echo item_list($_GET[mid]);
if ($_GET[mid]!='' && $_GET[item]!='') echo item_list($_GET[mid],$_GET[item]);
if ($_GET[mid]!='' && $_GET[item]!='') echo stud_list($_GET[mid],$_GET[item]);


#####################  �C�ܾǥ�   #############################
function stud_list($mid,$item) {
	global $sportname,$itemkind,$sportclass,$k_unit;
	$arr_1=get_item($item);//���o���ɶ���
	$arr_2=get_next_item($item);//���o���ɶ���
//if ($arr_2[sportkind]=='5' || $arr_1[sportkind]=='5') return '';
if ($arr_1=='' && $arr_2=='') return '�|�L��ơI';
($arr_1[sportkind]=='5') ? $A_nu=chkman_nu($arr_1[id]):$A_nu=chkman4($arr_1[id]);//�p���`�H/����
	$A_one=$arr_1[playera];//�C�դH��
	$A_go=$arr_1[passera];//�����H��
	$A_Name=$sportclass[$arr_1[enterclass]].$sportname[$arr_1[item]].$itemkind[$arr_1[kind]];//�W��
	$B_Name=$sportclass[$arr_2[enterclass]].$sportname[$arr_2[item]].$itemkind[$arr_2[kind]];//�W��
	$A_gp=ceil($A_nu/$A_one);//�p��ռ�
?>
<table border=0 width='100%' style='font-size:11pt;'  cellspacing=1 cellpadding=0 bgcolor=silver>
<tr bgcolor=white><td width =50% valign=top>

<?
///�������//$arr_1;
($arr_2=='')? $tmp_word='':$tmp_word="�i�M��";
echo"<div style='color:#800000;'><FONT COLOR='blue'>��".$A_Name."</FONT><BR> �@ <B>$A_nu</B> �W(��)����,�C��<B>$A_one</B>�W,����<B>$A_go</B>�W <B>$arr_1[imemo]</B>$tmp_word�C</div>";
	($arr_1[sord]=='2') ? $ord=' desc':$ord='' ;
echo "<HR size=1 color=#800000><table width=100%>
<TR bgcolor=silver style='color:#800000;font-size:10pt;' align=center><TD>�էO</TD>
<TD>�s��</TD><TD>��(�D��)</TD><TD>�Z�O�y��</TD><TD>�m�W</TD><TD>���Z</TD></TR>";

for ($a=1;$a<=$A_gp ;$a++){
($arr_1[sportkind]=='5') ? $Arr=get_order($arr_1[id],'par',"results $ord ,$a,$A_one",5):$Arr=get_order($arr_1[id],'par',"results $ord ,$a,$A_one");
	$tmp_str="<tr><td colspan=6>���ɦ��G�� $a ��</td></tr>";
	for($i=0; $i<count($Arr); $i++) {
		$tmp_order=$Arr[$i][sportorder]-($a-1)*$A_one;
		( $Arr[$i][results]==$arr_1[sunit]) ? $Cor='#696969':$Cor='red';//�S�����Z���Ǧ�
		if ($arr_1[sportkind]=='5') {
			$alert=get_gp_man($mid,$Arr[$i][itemid],$Arr[$i][cname],1);//�ռƥ���@
			$tmp_str.="<tr align=center bgcolor=#DFDFDF><td>&nbsp;</td><td>&nbsp;</td><td>".$tmp_order."</td><td colspan=2><A HREF='#' onclick=\"alert('$alert');\">".$Arr[$i][cname]." �Z�� ".$Arr[$i][kgp]." ��/��</a></td><td><FONT COLOR='$Cor'>".$Arr[$i][results]."</FONT></td></tr>\n";
			}
		else {
			$tmp_str.="<tr align=center bgcolor=#DFDFDF><td>&nbsp;</td><td>".$Arr[$i][sportnum]."</td><td>".
			$tmp_order."</td><td>".
			$Arr[$i][idclass]."</td><td>".$Arr[$i][cname]."</td><td><FONT COLOR='$Cor'>".$Arr[$i][results]."</td></tr>\n";
			}
	}
echo $tmp_str;
	}
unset($tmp_str);
?>

</TABLE></td><td width =50% valign=top>

<?
///////////////�M����ܳB�z ///////////////////////

if ($arr_2!=''){
($arr_2[sportkind]=='5') ? $B_nu=chkman_nu($arr_2[id]):$B_nu=chkman4($arr_2[id]);//�p���`�H/����
//	$B_nu=chkman4($arr_2[id]);//�`�H��
	$B_one=$arr_2[playera];//�C�դH��
	$B_go=$arr_2[passera];//�����H��
	$B_Name=$sportclass[$arr_2[enterclass]].$sportname[$arr_2[item]].$itemkind[$arr_2[kind]];//�W��
	$B_gp=ceil($B_nu/$B_one);//�p��ռ�



echo"<div style='color:#800000'><FONT  COLOR='blue'>��".$B_Name."</FONT><BR> �@ <B>$B_nu</B> �H�i�M�� , �C�� <B>$B_one</B> �H , ���� <B>$B_go</B> �H�C</div><HR size=1 color=#800000>";
echo "<table width=100%><TR bgcolor=silver style='color:#800000;font-size:10pt;' align=center><TD>�էO</TD>
<TD>�s��</TD>
<TD>��(�D��)</TD>
<TD>�Z�O�y��</TD>
<TD>�m�W</TD>
<TD>���Z</TD>
</TR>";

($arr_2[sord]=='2') ? $ord=' desc':$ord='' ;//�ƧǨ̾�
for ($a=1;$a<=$B_gp ;$a++){
($arr_2[sportkind]=='5') ? $Arr=get_order($arr_2[id],'par',"results $ord ,$a,$A_one",5):$Arr=get_order($arr_2[id],'par',"results $ord ,$a,$A_one");
// �O�_���O��
	$tmp_str="<tr><td colspan=6>���ɦ��G�� $a ��</td></tr>";
	for($i=0; $i<count($Arr); $i++) {

		( $Arr[$i][results]==$arr_1[sunit]) ? $Cor='#696969':$Cor='red';//�S�����Z���Ǧ�
		if ($arr_1[sportkind]=='5') {
			$alert=get_gp_man($mid,$Arr[$i][itemid],$Arr[$i][cname],1);//�ռƥ���@
			$tmp_str.="<tr align=center bgcolor=#DFDFDF><td>&nbsp;</td><td>&nbsp;</td><td>".$Arr[$i][sportorder]."</td><td colspan=2 ><A HREF='#' onclick=\"alert('$alert');\">".$Arr[$i][cname]." �Z�� ".$Arr[$i][kgp]." ��/��</A></td><td><FONT COLOR='$Cor'>".$Arr[$i][results]."</FONT></td></tr>\n";
			}
		else {
			$tmp_str.="<tr align=center bgcolor=#DFDFDF><td>&nbsp;</td><td>".$Arr[$i][sportnum]."</td><td>".
			$Arr[$i][sportorder]."</td><td>".
			$Arr[$i][idclass]."</td><td>".$Arr[$i][cname]."</td><td><FONT COLOR='$Cor'>".$Arr[$i][results]."</td></tr>\n";
			}
	}
echo $tmp_str;
	}

echo"</table>";
}
?>
</td></tr></table>
<?
}
#####################   �C�ܥD�n����  ###########################
function Co_GP($lg,$nu){//�նZ,�s��
$a=ceil($nu/$lg);//�p��ռ�
return $a;
}


#####################   �C�ܥD�n����  ###########################
function mmid2($mid) {
			global $CONN; //left join sport_res c (on b.mid=a.id ) 
	$SQL="select * from sport_main order by year desc ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();
	$SQL1="select mid, count(id) as bnu  from sport_item  group by mid ";
	$rsa=$CONN->Execute($SQL1) or die($SQL1);//�έp�U�����ɶ}�춵�ؼ�
	$arr1=$rsa->GetArray();
	$SQL2="select mid, count(id) as cnu  from sport_res where itemid !='0' group by mid ";
	$rsb=$CONN->Execute($SQL2) or die($SQL2);//�έp�U�����ɰ��ɤH��
	$arr2=$rsb->GetArray();
//print_r($arr1);
//print_r($arr2);
$view_img="<img src=images/arrow.gif>";
echo "<TABLE border=0 width=100% style='font-size:11pt;'  cellspacing=1 cellpadding=0 bgcolor=#9EBCDD><TR align=center bgcolor='#9EBCDD'><TD width=6%>����</TD>
	<TD nowarp>���ɦW��&nbsp;</TD>
	<TD nowarp>���ɤ��</TD>
	<TD nowarp>�}�l���W���</TD>
	<TD nowarp>�I����W���</TD>
	<TD nowarp>���ɶ��ؼ�</TD>
	<TD nowarp>���W�H��</TD>
</TR>";
for($i=0; $i<$rs->RecordCount(); $i++) {
	$nu1=0;$nu2=0;
	for($x=0; $x<$rsa->RecordCount(); $x++) {
		($arr[$i][id]==$arr1[$x][mid]) ? $nu1=$arr1[$x][bnu]: $nu1=$nu1;
		}	//���X�Ӥ��ɶ��ؼ�
	for($x=0; $x<$rsb->RecordCount(); $x++) {
		($arr[$i][id]==$arr2[$x][mid]) ? $nu2=$arr2[$x][cnu]: $nu2=$nu2;
		}	//���X�Ӥ����`�H��

($mid==$arr[$i][id]) ? $now_view=$view_img:$now_view='';
echo "<TR align=center bgcolor='#FFFFFF'><TD>".$arr[$i][id]."</TD>
	<TD align=left  nowarp>$now_view<A HREF='$PHP_SELF?mid=".$arr[$i][id]."'>".$arr[$i][title]."</A></TD>
	<TD>".$arr[$i][year]."</TD>
	<TD>".substr($arr[$i][signtime],0,13)."</TD>
	<TD>".substr($arr[$i][stoptime],0,13)."</TD>
	<TD>".$arr[$i][bnu]."$nu1</TD>
	<TD>".$arr[$i][bnu]."$nu2</TD></TR>";
}
echo "</TABLE>";
}

#####################  �C�ܶ���   #############################
function item_list($mid,$item=''){
		global $CONN,$sportclass,$sportname,$itemkind;
	$SQL="select *  from sport_item   where  mid='$mid' and  skind=0  order by  kind, enterclass ";//and sportkind!=5 
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

	$ss="<FORM name=p2>��ܬd�\���ɶ��ءG<select name='link2' size='1' class='bur' onChange=\"if(document.p2.link2.value!='')change_link(document.p2.link2.value);\">\n<option value='$PHP_SELF?mid=$_GET[mid]&item='>�����</option> ";

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
#####################  ���ե�  #############################
function G_gp($order,$li){
//�ǤJ�s��,�C�դH��
$ss=ceil($order / $li);// �D�l��

Return $ss ;//�ǥX�էO
}

function get_gp_man($mid,$item,$class,$gp){
//�ǤJ�s��,�C�դH��
	global $CONN;
$SQL="select cname from sport_res where mid='$mid' and idclass like '$class%'  and kmaster=0 ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();
	$ss='';
for($i=0; $i<$rs->RecordCount(); $i++) {
$ss.=$arr[$i][cname]."�B";
}

Return $ss ;//�ǥX�էO
}

?>