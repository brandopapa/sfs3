<?php
//$Id: mgr_stu5.php 5310 2009-01-10 07:57:56Z hami $
$SQL="select *  from sport_item where mid='$mid' and enterclass like '$class_num_1%' and skind=0 and sportkind=5 order by  kind, enterclass ";
$rs=$CONN->Execute($SQL) or die($SQL);
$arr=$rs->GetArray();//�����ػP���W��

for($i=0; $i<$rs->RecordCount(); $i++) {	//�����ذj��
	$S_Name=$sportclass[$arr[$i][enterclass]].$sportname[$arr[$i][item]].$itemkind[$arr[$i][kind]];
echo "<U>��".$S_Name."</U>&nbsp;&nbsp;<FONT  COLOR='blue'>";
echo "�i���W�G".$arr[$i][kgp]."��;�C�տ�".$arr[$i][kgm]."�H</FONT><BR>\n";
$Button=0;//����s�ܼ�
$W='';
for ($X=1;$X<=$arr[$i][kgp];$X++){	//���էO�j��
	switch(ChkK5($arr[$i][id],$class_num,$X)) {
	case 0:
		if ($Button==1) break;
		if ($X!=1) $W='�]';
		echo "<INPUT TYPE=button  value='���Z".$W."�n�ѥ[��$X ��' onclick=\"if(window.confirm('�T�w�ѥ[�H')){location='$_SERVER[PHP_SELF]?mid=$mid&sclass=$class_num&act=K5&GP=$X&item=".$arr[$i][id]."' ;}\" class=bur>\n";
		$Button=1;//��2�ӥ����W���դ��A�X�{
		break;
	case 1:
		echo "<INPUT TYPE='radio' NAME='item' VALUE='".$arr[$i][id]."_".$arr[$i][sportkind]."_".$X."'>$class_num �Z�N���� $X ��&nbsp;\n
		<INPUT TYPE=button  value='X���ѥ[' onclick=\"if(window.confirm('���ѥ[�F�H')){location='$_SERVER[PHP_SELF]?mid=$mid&sclass=$class_num&act=Del_K5&GP=$X&item=".$arr[$i][id]."' };\" class=bur2>\n";
		echo Show_K5($arr[$i][id],$class_num,$X);//�L�X���դH��
		break;
	default:;
	}
	}//end $X
echo "<BR><BR>";

}

##################�ˬd����ճ��W��###########################
function ChkK5($item,$Class,$GP) {
	global $CONN ;
	$SQL="select * from sport_res where itemid=$item and  idclass like '$Class%' and  sportkind=5 and kmaster=2 and kgp='$GP' ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	return $rs->RecordCount();
}
################## Show����ճ��W�� ###########################
function Show_K5($item,$Class,$GP) {
	global $CONN ;
	$SQL="select * from sport_res where kgp='$GP' and  itemid=$item and  idclass like '$Class%' and  sportkind=5 and  kmaster=0 order by idclass ";
	$rs=$CONN->Execute($SQL) or die($SQL);
	$arr=$rs->GetArray();//�����ػP���W��
	$Str='';
	for($i=0; $i<$rs->RecordCount(); $i++) {
		$Str.= "<INPUT TYPE='checkbox' NAME='del_id[".$arr[$i][id]."_".$item."]' value='".$arr[$i][cname]."' >".substr($arr[$i][idclass],3,2).$arr[$i][cname]." \n";}//�o�� checkbox �ﶵ
	return "<div style='color:#800000;margin-left:5pt;'>$Str</div>";
}

?>