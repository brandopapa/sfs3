<?php
//$Id$
include "config.php";
include_once ('my_functions.php');
//�{��
sfs_check();

//�q�X�����������Y
head("�ɮפ��R");
//�D���]�w
$tool_bar=&make_menu($MODULE_MENU);

//�C�X���
echo $tool_bar;

  mysql_query("SET NAMES 'utf8'");

if ($_POST['act']=='del') {
 foreach($_POST['tag_del'] as $filename) {
	$sql="select a.* from sc_msn_data a,sc_msn_file b where b.filename='".$filename."' and a.idnumber=b.idnumber";
  $res=mysql_query($sql);
  if (mysql_num_rows($res)==0) {
   unlink($download_path.$filename);
  } else {    	 	  //�R������
   	$row=mysql_fetch_array($res,1); 
   	delete_file ($row['idnumber'],$row['to_id']);
   	$query="delete from sc_msn_data where id='".$row['id']."'";
  	mysql_query($query);
  }  
 } // end foreach
 
}

//Ū����Ƨ����Ҧ���ڦs�b���ɮ�
$file_list=glob($download_path."*.*");
$file_check=array();
foreach ($file_list as $filename) {
	$file=explode("/",$filename);
	$f=count($file)-1;
  $file_check[$file[$f]]=0; // filename
}

//���o��Ƨ�
$CONN->Execute("SET NAMES 'utf8'");
$sql="select * from sc_msn_folder order by idnumber";
$res=$CONN->Execute($sql);
$folders=$res->GetRows();

//echo "<pre>";
//print_r($folders);
//exit();

$ALLSIZE=0;


?>
<form method="post" name="myform" action="<?php echo $_SERVER['php_self'];?>">
<input type="hidden" name="act" value="">
<?php
foreach ($folders as $FOLDER) {
  $ALLSIZE_this=0;

	$CONN->Execute("SET NAMES 'utf8'");
	$sql="select a.*,b.filename,filename_r from sc_msn_data a,sc_msn_file b where a.idnumber=b.idnumber and a.folder='".$FOLDER['idnumber']."'";
  $res=$CONN->Execute($sql);
  if ($res->RecordCount()>0) {
	 ?>
 		���ɮק��G<?php echo iconv("UTF-8","big5",$FOLDER['foldername']);?><br>
	 	<table border="1" width="100%" bordercolor="#000000" style="border-collapse:collapse">
  		<tr bgcolor='#FFCCCC'>
   			<td style="font-size:10pt">�ɮ�</td>
   			<td width="100" style="font-size:10pt">�j�p</td>
   			<td width="50" style="font-size:10pt">�W�Ǫ�</td>
   			<td width="100" style="font-size:10pt">���</td>
   			<td width="50" style="font-size:10pt">���O</td>
   			<td width="50" style="font-size:10pt">��H</td>
   			<td style="font-size:10pt">����</td>
   			<td width"50"><input type="button" value="�R��" style="font-size:10pt" onclick="if (confirm('�z�T�w�n:\n�R���Ŀ諸�ɮ�? (�P�ݩ�ۦP�T�������Ҧ��ɮ׷|�@�֧R��)')) { document.myform.act.value='del';document.myform.submit();}"></td>
  		</tr>
		<?php
   		while ($row=$res->fetchRow($res)) {
				mysql_query("SET NAMES 'latin1'");
				$name=get_teacher_name_by_id($row['teach_id']);
				$to_name=get_teacher_name_by_id($row['to_id']);
				$file_check[$row['filename']]=1;
				$ALLSIZE+=filesize($download_path.$row['filename']);
		?>	
  		<tr>
   			<td style="font-size:10pt"><?php echo iconv("UTF-8","big5",$row['filename_r']);?></td>
   			<td style="font-size:10pt"><?php echo ShowBytes(filesize($download_path.$row['filename']));?></td>
   			<td style="font-size:10pt"><?php echo $name;?></td>
   			<td style="font-size:10pt"><?php echo $row['post_date'];?></td>
   			<td style="font-size:10pt"><?php echo $row['data_kind'];?></td>
   			<td style="font-size:10pt"><?php echo $to_name;?></td>
   			<td style="font-size:10pt"><?php echo iconv("UTF-8","big5",$row['data']);?></td>
   			<td><input type="checkbox" name="tag_del[]" value="<?php echo $row['filename'];?>"></td>
  		</tr>
		<?php	
   		} // end while
   		?>
   	</table>
   		<?php
  } // end if

mysql_query("SET NAMES 'utf8'");

} // end foreach folder



//=====================================

//�C�X�򥢵L�k���ު��ɮ�
 foreach($file_list as $filename) {
	//���� $filename
	$file=explode("/",$filename);
	$f=count($file)-1;
	if ($file_check[$file[$f]]==1) continue; 
	?>
	<br>���ɮ׿򥢯��ޡG<input type="checkbox" name="tag_del[]" value="<?php echo $file[$f];?>"><?php echo $file[$f];?> (<?php echo ShowBytes(filesize($filename)); ?>)
	<?php
	$ALLSIZE+=filesize($filename);
	
 }
?>
<br><br>���Ψt���`�e�q : <?php echo ShowBytes($ALLSIZE);?>&nbsp;&nbsp;
<input type="button" value="�R���Ҧ��Ŀ諸�ɮ�" style="font-size:10pt" onclick="if (confirm('�z�T�w�n:\n�R���Ŀ諸�ɮ�? (�P�ݩ�ۦP�T�������Ҧ��ɮ׷|�@�֧R��)')) { document.myform.act.value='del';document.myform.submit();}">
<?php
//�G������
foot();

function ShowBytes($size) {   
   $size=doubleval($size);   
   $sizes= array(   
       " Bytes",   
       " KB",   
       " MB",   
       " GB",   
       " TB"  
   );   
   if($size== 0) {   
       return('n/a');   
   } else{   
       $i= floor( log($size, 1024) );   
       return(round( $size/pow(1024, $i), 2) . $sizes[$i]);   
   }   
}  
?>
