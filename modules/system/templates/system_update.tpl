{{* $Id: system_update.tpl 7191 2013-03-05 03:11:34Z infodaes $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}

<script>
<!--
function chg(a) {
	var b,i;
	for(i=0;i<24;i++) {
		if (a!=i) {
			b="tem"+i;
			document.getElementById(b).checked=false;
		}
	}
}
function copyToClipboard(txt) {
     if(window.clipboardData) {
             window.clipboardData.clearData();
             window.clipboardData.setData("Text", txt);
     } else if(navigator.userAgent.indexOf("Opera") != -1) {
          window.location = txt;
     } else if (window.netscape) {
          try {
               netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
          } catch (e) {
               alert("�Q�s�����ڵ��I\n�Цb�s�����a�}���J'about:config'����UEnter��\n�M��N'signed.applets.codebase_principal_support'�]�m��'true'");
          }
          var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
          if (!clip)
               return;
          var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
          if (!trans)
               return;
          trans.addDataFlavor('text/unicode');
          var str = new Object();
          var len = new Object();
          var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
          var copytext = txt;
          str.data = copytext;
          trans.setTransferData("text/unicode",str,copytext.length*2);
          var clipid = Components.interfaces.nsIClipboard;
          if (!clip)
               return false;
          clip.setData(trans,null,clipid.kGlobalClipboard);
     }
     alert('�w�ƻs����');
}
-->
</script>

<table bgcolor="#DFDFDF" cellspacing="1" cellpadding="1">
<form name="log" method="post" action="{{$smarty.server.SCRIPT_NAME}}">
<tr>
<td bgcolor="#FFFFFF">
<table  cellspacing="0" cellpadding="0"><tr><td style="vertical-align:top;">
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="4" width="100%" class="small">
<tr style="text-align:center;color:blue;background-color:#bedcfd;">
<td>��s�ɶ�</td><td>�`�A��s</td><td>�{�ɧ�s</td><td style="width:1px;"></td><td>��s�ɶ�</td><td>�`�A��s</td><td>�{�ɧ�s</td>
</tr>
{{foreach from=$rowdata item=v key=i}}
<tr bgcolor="white" style="text-align:center;">
<td>{{$v}}:00</td><td><input type="radio" name="upsch" value="{{$v}}" {{if $smarty.post.upsch==$v}}checked{{/if}}></td><td><input type="checkbox" name="tem[{{$v}}]" id="tem{{$i}}" OnClick="chg({{$i}});" {{if $smarty.post.uptemp==$v}}checked{{/if}}></td>
<td></td>
{{assign var=vv value=$v+12}}
<td>{{$vv}}:00</td><td><input type="radio" name="upsch" value="{{$vv}}" {{if $smarty.post.upsch==$vv}}checked{{/if}}></td><td><input type="checkbox" name="tem[{{$vv}}]" id="tem{{$i+12}}" OnClick="chg({{$i+12}});" {{if $smarty.post.uptemp==$vv}}checked{{/if}}></td>
</tr>
{{/foreach}}
</table>
<input type="submit" value="�T�w�x�s">
</td><td style="vertical-align:top;width:50%;">
{{if $crontime}}
<span style="font-size:10pt;color:blue;">���w���Ƶ{�̫����ɶ��G{{$crontime}}</span><br>
{{else}}
&nbsp; <textarea id="sct" style="font-size:8pt;color:grey;" cols="64" rows="10">
#!/usr/bin/php
&lt;?php
//1.1��
echo "#�}�l��s sfs3......\n";

//sfs3 �w�˥ؿ�(�Ш̻ݭn�ק�)
$SFS_INSTALL_PATH="{{$SFS_PATH}}";

//sfs3 �����Ȧs�ؿ�(�Ш̻ݭn�ק�)
$SFS_TEMP_DIR="/tmp/sfs3_stable";

//sfs3 �U�����}(�ŭק�)
$SFS_TAR_URL="http://sfscvs.tc.edu.tw/";

//�O���۰ʱƵ{����ɶ�
$fp=fopen($SFS_INSTALL_PATH."/data/system/cron","w");
fputs($fp,date("Y-m-d H:i:s"));
fclose($fp);

//���o�Ѻ����]�w���ܼƭ�
$v_arr=array();
$v_arr['SCHEDULE']="";
$v_arr['TEMPORARY']="";
if (file_exists($SFS_INSTALL_PATH."/data/system/update")) {
	$fp=fopen($SFS_INSTALL_PATH."/data/system/update","r");
	while(!feof($fp)) {
		$temp_arr=array();
		$temp_arr=explode("=",fgets($fp,1024));
		if (count($temp_arr)==2) $v_arr[$temp_arr[0]]=sprintf("%02d",intval($temp_arr[1]));
	}
	fclose($fp);
}

//�p�G�S���]�w�w����s�ɶ�, �h�w����s�ɶ��]�w�����W���I
if ($v_arr['SCHEDULE']=="") $v_arr['SCHEDULE']="06";

//���o�{�b�ɶ����p�ɧO
$hour=date("H");

//�Y�ŦX��s�ɶ��h�i���s
if ($v_arr['SCHEDULE']==$hour || $v_arr['TEMPORARY']==$hour || $argv[1]=="now") {

	//�P�_PHP�����O
	if ( !function_exists('version_compare') || version_compare( phpversion(), '5', '<' ) )
		$SFS_TAR_FILE="sfs_stable.tar.gz";
	else
		$SFS_TAR_FILE="sfs_stable5.tar.gz";

	//�P�_�Ȧs�ؿ��O�_�w�s�b
	if (is_dir($SFS_TEMP_DIR)) {
		exec("rm -rf ".$SFS_TEMP_DIR);
	}

	//�P�_�¦��{���X�O�_�w�s�b
	if (file_exists("/tmp/".$SFS_TAR_FILE)) {
		exec("rm -f /tmp/".$SFS_TAR_FILE);
	}

	//�P�_sfs3�O�_�w��
	if (!is_dir($SFS_INSTALL_PATH)) {
		echo "Oh! Error! .... Directory *** sfs3 *** not exists!\n";
		echo "Please install sfs3 first!\n";
		exit;
	}

	//�U���B�����P�ƻs�D�{��
	echo "#�U���D�{��......\n";
	exec("wget -q ".$SFS_TAR_URL.$SFS_TAR_FILE." --directory-prefix=/tmp");
	echo "#�D�{�������Y......\n";
	exec("tar zxf /tmp/".$SFS_TAR_FILE." -C /tmp");
	echo "#�ƻs�D�{��......\n";
	exec("cp -a ".$SFS_TEMP_DIR."/* ".$SFS_INSTALL_PATH);

	//��ܧ�s������
	include $SFS_INSTALL_PATH."/sfs-release.php";
	echo "#��s�� ".$SFS_BUILD_DATE."\n";

	//�^�g�]�w��
	$fp=fopen($SFS_INSTALL_PATH."/data/system/update","w");
	fputs($fp,"SCHEDULE=".$v_arr['SCHEDULE']);
	fclose($fp);
}
?&gt;
</textarea>
<input type="button" onclick="copyToClipboard(sct.value);" value="�N Script �ƻs��ŶKï"><br>
{{/if}}
<table class="small">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;">
	<ol>
	<li>���ҲջݻP Cron Table �]�w�f�t��ॿ�`�B�@�C</li>
	<li>��s�ɶ��P���A���ɶ��]�w�����A��ĳ���A�����n�۰ʮծɡC</li>
{{if !$crontime}}
	<li style="color:red;">�бN�W�C�� script �ƻs�����A�� /root �ؿ��U�K�J upsfs.php �ɡC</li>
	<li style="color:red;">�N upsfs.php �v���קאּ�i����C</li>
	<li style="color:red;">�b cron table ���]�w�C�p�ɩw�ɰ��� upsfs.php �C</li>
{{/if}}
	<li>�T����s�ɶ��P crontab �]�w�����u���v�����A��Y crontab ���]�w��15���A�������Ŀ�04:00�A�h��s�ɶ���04:15�C</li>
	<li>���t�ΥD�{���Ѫ���������A���C�T�p�ɲ��ͷs���Y�ɡA�ҥH�t�Ϊ������@�w�|�]��s�ɶ��Ӧ��Ҥ��P�A�Ҧp�G�P�@��00:30�B01:30�B02:30�ҧ�s�쪺�t�Ϊ����|�O�P�@�����C</li>
	<li>��ĳ�u�`�A��s�v���n�ɱ`�󴫧�s�ɶ��A�u�{�ɧ�s�v�h�O�{�ɻݭn��s�����ɤ~�i��]�w�C</li>
	</ol>
</td></tr>
</table>
</td></tr></table>
</td>
</tr>
</form>
</table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}
