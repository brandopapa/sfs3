<?php

// $Id: del_module.php 7030 2012-12-05 07:08:45Z hami $

//�]�w�ɸ��J�ˬd
require "config.php";
// �{���ˬd
sfs_check();


//����ʧ@�P�_
if($_POST[act]=="delme"){
	$n=del_prob();
	header("Location: $_SERVER[PHP_SELF]?msn=$_POST[msn]&mode=vew_log&n=$n");
}else{
	$main=&main_form();
}


//�q�X����
head("�ǰȵ{���]�w--�����Ҳ�");
echo $main;
foot();

//�D�n���
function &main_form(){
	global $CONN,$school_menu_p;
	$tool_bar=&make_menu($school_menu_p);
	//�C�X�D�n���j�Ҳ�
	$prob_list=list_parent_prob($_REQUEST[msn]);

	if($_REQUEST[mode]=="del"){
		$del_form=&del_form($_GET[set_msn]);
	}elseif($_REQUEST[mode]=="vew_log"){
		$del_form=&view_log("",$_GET[n],0);
	}

	$main="
	<script>
	<!--
	function sel_all() {
		var i =0;

		while (i < document.dbform.elements.length)  {
			a=document.dbform.elements[i].id.substr(0,1);
			if (a=='d') {
				document.dbform.elements[i].checked=true;
			}
			i++;
		}
	}
	-->
	</script>
	$tool_bar
	<table cellspacing='0' cellpadding='0'>
	<tr><td valign='top'>$prob_list</td></tr>
	<tr><td height=5></td></tr>
	<tr><td valign='top'>$del_form</td></tr>
	</table>";
	return $main;
}


//�C�X�D�n���j�Ҳ�
function list_parent_prob($curr_msn=0){
	global $CONN,$SFS_PATH,$MODULE_DIR;

	$sql_select="select * from sfs_module where of_group='$curr_msn' order by sort";

	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while ($data=$recordSet->FetchRow()) {
		$all[]=$data;
	}

	//���o�Y�Ҳթ��U�Ҳժ��s��
	$data="";
	foreach($all as $m){
		$mmsn=$m[msn];
				
		$checked=($m[islive]=='1')?"checked":"";

		//���o�ӼҲզb��Ʈw�����U���Ҳհ}�C
		$child_prob_num=sizeof(get_parent_prob($mmsn));
		
		

		if($m[islive]=='0'){
			$color="#989898";
		}elseif($child_prob_num>0){
			$color="#8000ff";
		}else{
			$color="#000000";
		}
		
		$tool=($m[kind]=="����" and $child_prob_num > 0)?"":"<a href='$_SERVER[PHP_SELF]?set_msn=$mmsn&msn=$curr_msn&mode=del'>����</a>";

		$real_dir_name=($m[kind]=="�Ҳ�")?"�q".$m[dirname]."�r":"";
		
		$url=($child_prob_num>0)?"<a href='$_SERVER[PHP_SELF]?msn=$mmsn'><font color='$color'>".$m[showname].$real_dir_name."</font></a>":"<font color='$color'>".$m[showname].$real_dir_name."</font>";


		$color=($mmsn==$_REQUEST[set_msn])?"#FFFB8A":"#FFFFFF";
		$data.="
		<tr bgcolor='$color' class='small'>
		<td nowrap>
			<font color='darkGreen'>[".$m[kind]."]</font>
			$url
			<input type='hidden' name='prob_data[$mmsn][showname]' value='$m[showname]' $checked>
		</td>
		<td align='center'  nowrap>
			$tool
		</td>
		</tr>";
	}

	
	//�W�@�h���s
	$up_link=get_up_path($curr_msn);
	$up_link="<a href='$up_link'><img src='images/up.gif' alt='' border='0'></a>";
	$up=get_module_location($curr_msn,"����",1);

	$main="
	<table cellspacing='1' cellpadding='4' bgcolor='blue'>
	<tr bgcolor='red'><td>
		<table width='100%' cellspacing='0' cellpadding='4' class='small'>
		<tr bgcolor='#FFFFFF'><td>$up</td><td>$up_link</td></tr>
		<tr bgcolor='#E7E7E7'>
		<td align='center' nowrap>�ҲզW��</td>
		<td align='center' nowrap>�Ҳպ޲z</td>
		</tr>
		$data
		</table>
	</td></tr>
	</table>
	";
	return $main;
}

//�R�����T�{���
function &del_form($set_msn=""){
	global $MODULE_DIR,$CONN;
	//���o�Ҳո��
	$m=get_main_prob($set_msn);
	$of_group=get_module_path($m[msn],"����",0);
	$in_use=($m[islive]=='1')?"�ϥΤ�":"���Τ�";

	
	
	if($m[kind]=="����"){
		$stand_txt="<font color='blue'>�Ҳդ���</font>";
		//���o�ӼҲզb��Ʈw�����U���Ҳհ}�C
		$child_prob_num=sizeof(get_parent_prob($m[msn]));
		$disabled=($child_prob_num > 0)?"disabled":"";
		$disabled_text=($child_prob_num > 0)?"���U�|���Ҳդ��i����":"��������";
	
	}else{
		$is_stand_module=is_stand_module($MODULE_DIR,$m[dirname]);

		$stand_txt=($is_stand_module)?"<font color='#358E1F'>�зǼҲ�</font>":"<font color='red'>�D�зǼҲ�</font>";
	
		if($is_stand_module){
			include_once $MODULE_DIR.$m[dirname]."/module-cfg.php";
			if(sizeof($MODULE_TABLE_NAME)>=1){
				foreach($MODULE_TABLE_NAME as $dbname){
					if(empty($dbname))continue;
					$sql_select="select count(*) from $dbname";
					//$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
					$recordSet=$CONN->Execute($sql_select);
					$i=0;
					if($recordSet){
						list($datan)=$recordSet->FetchRow();
						$view=(empty($datan))?"":"<a href='$_SERVER[PHP_SELF]?set_msn=$_GET[set_msn]&msn=$_GET[msn]&mode=$_GET[mode]&vDBname=$dbname'>�[�ݸ��</a>";
						$view=(!empty($_GET[vDBname]) and $dbname==$_GET[vDBname])?"<a href='$_SERVER[PHP_SELF]?set_msn=$_GET[set_msn]&msn=$_GET[msn]&mode=$_GET[mode]'>����</a>":$view;
						$DBlist.="<tr bgcolor='white'><td bgcolor='#EAEAEA'>
					<input type='checkbox' name='delDB[]' id='d$i' value='$dbname'>���� $dbname
					</td><td>$datan $view</td></tr>";
						$i++;
					}else{
						$DBlist.="<tr bgcolor='white'><td colspan=2><font color='red'>$dbname  ���s�b�A�i��w�Q�����C</font></td></tr>";
					}
					
				}
			}
		}else{
			$DBlist.="<tr bgcolor='white'><td colspan=2>".$stand_txt."�A�L�k�����I</td></tr>";
		}

		if(!empty($_GET[vDBname])){
			$sql_select="select * from $_GET[vDBname]";
			$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
			while($datan=$recordSet->FetchRow()){
			$DBdata="";
				foreach($datan as $k=>$v){
					if(is_int($k))continue;
					$DBdata.="$v ";
				}
				$allDB.="$DBdata\n";
			}
			$DBall="<td valign='top'><textarea cols='30' rows='10' class='small'>$allDB</textarea></td>";
		}
		
		$disabled=($SYS_MODULE || $m[dirname]=='sfs_man2')?"disabled":"";
		$disabled_text=($SYS_MODULE || $m[dirname]=='sfs_man2')?"�t�μҲդ��i����":"���U����";
	}
	

	

	$main="
	<table cellspacing='0' cellpadding='4' ><tr><td valign='top'>
	<form action='$_SERVER[PHP_SELF]' method='POST' name='dbform'>

		<table cellspacing='1' cellpadding='4' bgcolor='#E0E0E0' class='small'>
		<tr bgcolor='#FBBFAE'><td colspan=2>�z�ҭn�������Ҳո�Ʀp�U�G</td></tr>
		<tr bgcolor='white'><td bgcolor='#EAEAEA'>�ҲզW��</td><td>$of_group</td></tr>
		<tr bgcolor='white'><td bgcolor='#EAEAEA'>��ڥؿ�</td><td> $m[dirname] ($stand_txt) $in_use</td></tr>
		<tr bgcolor='#FBBFAE'><td colspan=2>�M $m[dirname] ��������Ʈw</td></tr>
		$DBlist
		</table>
	</td>
	$DBall
	<td valign='top'>

	<input type='hidden' name='set_msn' value='$_GET[set_msn]'>
	<input type='hidden' name='msn' value='$m[of_group]'>
	<input type='hidden' name='dirname' value='$m[dirname]'>
	<input type='hidden' name='act' value='delme'>
	<input type='submit' value='$disabled_text' $disabled><br>
	<input type='button' value='����Ҧ���ƪ�' $disabled OnClick='sel_all();'>
	</td></tr></table>
	</form>
	";
	return $main;
}


//���U����
function del_prob(){
	global $CONN,$MODULE_DIR, $UPLOAD_PATH;
	//��X�M�ӼҲզ������Ҳ�
	$str="select msn from sfs_module where of_group='$_POST[set_msn]'";
	$recordSet=$CONN->Execute($str) or user_error($str, 256);
	
	while(list($msn)=$recordSet->FetchRow()){
		//��s��s�ճ]�w
		$str="update sfs_module set of_group='0' where msn='$msn'";
		$CONN->Execute($str) or user_error($str, 256);
		$msg.="<li>��s $msn �Ҳժ��s�լ� 0�C</li>";
	}

	$str="select * from sfs_module where msn='$_POST[set_msn]'";
	$res = $CONN->Execute($str) or user_error($str, 256);
	
	// �R���ɯ���
	$path =  $UPLOAD_PATH.'upgrade/modules/'.$res->fields['dirname'];	
	if (is_dir($path)) {
		if ($dh2 = opendir($path."/".$file)) { 
				while (($file2 = readdir($dh2)) !== false) { 
					if($file2=="." or $file2=="..")
						continue;
					else {
						unlink($path."/".$file2);
					}					
				}
		} 
		closedir($dh2);
	}
	
	//�R���Ҳե����]�w����
	$str="delete from sfs_module where msn='$_POST[set_msn]'";
	$CONN->Execute($str) or user_error($str, 256);
	$msg.="<li>�R�� $_POST[dirname] �Ҳզbsfs_module�����]�w�C</li>";

	//�R���Ҳ��v���]�w����
	$str="delete from pro_check_new where pro_kind_id='$_POST[set_msn]'";
	$CONN->Execute($str) or user_error($str, 256);
	$msg.="<li>�R�� $_POST[dirname] �Ҳզbpro_check_new�����v���]�w�C</li>";

	// ���� pro_module �O��
	$sql = "DELETE FROM pro_module where pm_name='$_POST[dirname]'";
	$CONN->Execute($sql) or user_error($str, 256);
	$msg.="<li>�R�� $_POST[dirname] �Ҳզbpro_module�����ܼƳ]�w�C</li>";


	//�P�_�O�_���зǼҲ�
	$is_stand_module=is_stand_module($MODULE_DIR,$_POST[dirname]);

	if($is_stand_module){
		include_once $MODULE_DIR.$_POST[dirname]."/module-cfg.php";

		$msg.="<li>$_POST[dirname] �O�зǼҲաA�}�l�i��ﶵ�θ�ƪ��ʡC</li>";

		// ���� sfs_text �O��($SFS_TEXT_SETUP�]�O�bmodule-cfg���]�w)
		if(isset($SFS_TEXT_SETUP) and is_array($SFS_TEXT_SETUP)){
			for ($i=1; $i<=count($SFS_TEXT_SETUP); $i++) {
				$arr=$SFS_TEXT_SETUP[$i-1];
				$pm_g_id = trim($arr['g_id']);
				$pm_item = trim($arr['var']);
				$pm_arr = trim($arr['arr']);
				$sql = "DELETE FROM sfs_text WHERE t_kind='$pm_item' AND g_id=$pm_g_id";
				$CONN->Execute($sql);
			}
		}else{
			$msg.="<li>$_POST[dirname] �S�� \$SFS_TEXT_SETUP ���]�w�C</li>";
		}

		//�N��ƪ��W
		$delDB=$_POST['delDB'];
		if(sizeof($delDB)>0){
			//���o�ɶ��W�O
			$timestamp=time();
			foreach($delDB as $dbname){
				if(in_array($dbname,$MODULE_TABLE_NAME)){
					$new_dbname="garbage_".$timestamp."_".$dbname;
					chang_dbname($dbname,$new_dbname);
					$msg.="<li>�� $dbname ��W�� $new_dbname �C</li>";
				}else{
					$msg.="<li>�ҿ諸 $dbname ���b�]�w���A�G����W�C</li>";
				}
			}
		}else{
			$msg.="<li>�L�R������ƪ�C</li>";
		}
	}else{
		$msg.="<li>$_POST[dirname] �D�зǼҲաA������ƪ�οﶵ��ʡC</li>";
	}

	//���]�ϥΪ̪��A
	reset_user_state();
	
	$msg="<ol>$msg</ol>";
	$n=add_log($msg,"del_module");
	return $n;
}
?>
