<?php
//$Id: stud_psy_tran2.php 5974 2010-08-02 05:11:28Z hami $
require "config.php";

sfs_check();
set_time_limit(0);

$change_arr = array ('sse_s1'=>'�߷R�x�����','sse_s3'=>'�S��~��','sse_s4'=>'����','sse_s5'=>'�ͬ��ߺD','sse_s6'=>'�H�����Y','sse_s7'=>'�~�V�欰','sse_s8'=>'���V�欰','sse_s9'=>'�ǲߦ欰','sse_s10'=>'���}�ߺD','sse_s11'=>'�J�{�欰');

$newarr ['sse_s1'] = array(1=>'�y��',2=>'�ƾ�',3=>'�۵M�P�ͬ����',4=>'���|',5=>'���d�P��|',6=>'���N�P�H��',7=>'�ͬ��ҵ{',8=>'��X����',9=>'�m�g�y��');
$newarr ['sse_s3'] = array(1=>'�y��',2=>'�Ю|',3=>'��a', 4=>'�Z�N', 5=>'���N',6=>'�־��t��', 7=>'�q��', 8=>'�u��', 9=>'�a��', 10=>'�t��', 11=>'�g�@', 12=>'�R��', 13=>'���@', 14=>'�Ѫk',15=>'�]��', 16=>'���', 17=>'�^��',18=>'����',19=>'�~�y', 20=>'�q��', 21=>'��L');
$newarr['sse_s4'] = array(1=>'�q���q�v',2=>'�\Ū',3=>'�n�s',4=>'�S��',5=>'�Ȧ步�C',6=>'���N',7=>'�E���a',8=>'����',9=>'��N',10=>'�־��t��',11=>'�q��',12=>'���֪Y��',13=>'�R��',14=>'ø�e',15=>'���l',16=>'���y',17=>'�s´',18=>'�U��',19=>'�i�p�ʪ�',20=>'�@�����',21=>'�q��',24=>'��L');
$newarr['sse_s5'] = array(1=>'���',2=>'�Գ�',3=>'�`��',4=>'�@�����W��',5=>'��ż',6=>'�i�k',7=>'���O',8=>'�@���L�W��',9=>'��L');
$newarr['sse_s6'] = array(1=>'�M��',2=>'�X�s',3=>'����',4=>'�H��L�H',5=>'�n���n',6=>'�ۧڤ���',7=>'�N�z',8=>'�h�õ���',9=>'��L');
$newarr['sse_s7'] = array(1=>'��ɤO�j',2=>'����',3=>'�B�n',4=>'���ߤ���',5=>'�۫V�P��',6=>'�`���ʸ�',7=>'�n�C��',8=>'�R�ۤϽ�',9=>'��L');
$newarr['sse_s8'] = array(1=>'�ԷV',2=>'���R',3=>'�۫H',4=>'����í�w',5=>'���Y',6=>'�L���I�q',7=>'�L���̿�',8=>'�h�T���P',9=>'��L');
$newarr['sse_s9'] = array(1=>'�M��',2=>'�n���V�O',3=>'�����',4=>'�H��n��',5=>'����',6=>'�Q�ʰ���',7=>'�b�~�Ӽo',8=>'���߬Y��',9=>'��L');
$newarr['sse_s10'] = array(1=>'�L',2=>'�o���n',3=>'�f�Y',4=>'�@�˥L�H',5=>'�Y���Y',6=>'�r��',7=>'�I�g���}�ѥZ',8=>'�I�g�q�ʪ���',9=>'�W�ҦY�F��',10=>'����',11=>'�l��',12=>'�l�r',13=>'��L');
$newarr['sse_s11'] = array(1=>'�L',2=>'����i',3=>'�o��',4=>'�ݵh',5=>'���ߤ��w',6=>'���˪F��',7=>'�{�l�h',8=>'�Y�h',9=>'��һ�ê',10=>'��L');

$sel_sse = isset($_POST['sel_sse'])?$_POST['sel_sse']:'sse_s1';

$arr = sfs_text($change_arr[$sel_sse]);
$arr1 = $newarr[$sel_sse];

if ($_POST['act'] == '�T�w���'){
	$c_arr = array();
	$error_arr =array();
	foreach($arr as $id=>$val){
		if ($_POST["c_$id"] ==='')
		$error_arr[] = $id;
		elseif (!is_numeric($_POST["c_$id"])) // ������
		continue;
		$c_arr[$id] = $_POST["c_$id"];

	}
	if (count($error_arr)==0){
		if ($sel_sse == 'sse_s1'){ // �߷R�x�����
			$start = 1; $end=2;
		}else{
			$start = substr($sel_sse,5);
			$end = $start;
		}

		for($si=$start;$si<=$end;$si++){
			$query = "SELECT seme_year_seme,stud_id,sse_s$si FROM stud_seme_eduh ";
			$res = $CONN->Execute($query) or trigger_error($query ,254);
			//echo $query; exit;
			foreach ($res as $row) {
				$ss1 = '';
				$temp_arr = explode(",",$row["sse_s$si"]);
				foreach($temp_arr as $data){
					if ($data<>'' and $c_arr[$data]<>'')
					$ss1 .=','.$c_arr[$data];
				}
				//echo $row["sse_s$si"]."--$ss1, <BR>";
				$seme_year_seme = $row['seme_year_seme'];
				$stud_id = $row['stud_id'];
		//		echo "$ss1  --".$row["sse_s$si"]."<br>";
				if ($ss1<>'' and   chop($row["sse_s$si"]) <> "$ss1,") {
					$query = "UPDATE  stud_seme_eduh  SET sse_s$si='$ss1,'  WHERE seme_year_seme='$seme_year_seme' AND stud_id='$stud_id'";

					$CONN->Execute($query) or die($query);
				}
				//	if ($i++>20) break;
			}
		}
		$t_kind = $change_arr[$sel_sse];
		// ����ª�]�w
		$query = " UPDATE   sfs_text SET g_id=9,t_kind='bak_$t_kind'  WHERE t_kind='$t_kind'";
		$CONN->Execute($query) or die($query);
	//echo $query;
		join_sfs_text(1,$t_kind,   $newarr[$sel_sse]);
		//print_r($newarr[$sel_sse]);
		$arr = sfs_text($t_kind);
	}

}

head('���ɰO�����ഫ');
print_menu($menu_p);

?>

<table border='1' cellpadding='10' cellspacing='0' 	style='border-collapse: collapse' bordercolor='#111111' width='100%'  	id='AutoNumber1'>
<tr bgcolor='#EEEEEE'>
<td colspan="2"><?php  echo $submenu; ?></td>
</tr>
	<tr bgcolor='#FFCCCC'>
		<td align='center'>�� ��</td>
		<td align='center'>�s�ª��ഫ</td>
	</tr>
	<tr>
		<td width='45%' valign="top">

<ul>
  <li>
  <p style='margin-top: 0; margin-bottom: 0'><font color='#FF0000' size='2'>����n�i�����H</font></p>

  <p style='margin-top: 0; margin-bottom: 0'><font size='2'>SFS3�컲�ɰO�����۱Ш|�����y��ƥ洫�з� XML2.0
  �]�p�A96�~���G��3.0�зǻP��2.0���P�C���ŦX�s���G�� XML 3.0 �зǡA�¦��O�������i�����ʧ@�C</font></p>
  </li>
  <li>
  <p style='margin-top: 0; margin-bottom: 0'><font color='#FF0000' size='2'>�@�w�n�i�����H</font></p>
  <p style='margin-top: 0; margin-bottom: 0'><font size='2'>���ɬ���������U,���N�H�s����ưѷӡA�Y�Q�ե��i�����A�|������^�����~�����p�C</font></p>
  </li>
  <li>
  <p style='margin-top: 0; margin-bottom: 0'><font color='#FF0000' size='2'>��˶i�����H</font></p>
  <p style='margin-top: 0; margin-bottom: 0'>
  <font size='2'>�Цb�k�C���,��ܻ��ɰO������,�i��s�ª�����ഫ</font></p>
  <p style='margin-top: 0; margin-bottom: 0'>
  <span style='font-size:large;color:red;background-color: yellow;'>���ԷV�ާ@�ഫ�@�~,�Y�������~,�N�L�k�^�_�³]�w</span></p>
  </li>

</ul>

		</td>
		<td><?php if ($error_arr): ?>
		<h2>���ɥ���! �U�C��쥼��</h2>
		<ul style='background-color: yellow'>
		<?php foreach($error_arr as $val):  ?>
			<li><?php echo $arr[$val] ?></li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<form action="<?php echo $_SERVER['PHP_SELF']?>" name="myform"
			id="myform" method="post">��ܻ��ɰO������ <select name="sel_sse"
			onChange="this.form.submit()">
			<?php foreach($change_arr as $id=>$val):?>
			<option value="<?php echo $id ?>" <?php if ($id==$sel_sse): ?>
				selected <?php endif;?>><?php echo $val?></option>
				<?php endforeach;?>
		</select>
		 <?php if ($arr ===$arr1): ?>
				<input type="submit" name="act" value="�w�����" disabled>
		<?php else: ?>
				<input type="submit" name="act" value="�T�w���">
		<?php endif; ?>
		 <br />
		<table
			style="background-color: #eeffdd; border-collapse: collapse; width: 100%">
			<tr style="background-color: #dfd">
				<td style="text-align: right">�ª�W��</td>
				<td style="text-align: center">=></td>
				<td>�s��W��</td>
			</tr>
			<?php foreach($arr as $id=>$val):?>
			<tr>
				<td align="right"><?php $sel_key = array_search(chop($val),array_values($arr1));$i=0; ?>
				<span style="color: red"><?php echo $val?> </span></td>
				<td style="text-align: center">������</td>
				<td><select name="c_<?php echo $id?>">
					<option value="">--</option>
					<?php foreach($arr1 as $id2=>$val2):?>
					<option value="<?php echo $id2?>" <?php if ( $sel_key===$i++):?>
						selected <?php endif;?>><?php echo $val2  ?></option>
						<?php endforeach;?>
					<option vale="no">**������**</option>
				</select></td>
			</tr>
			<?php endforeach;?>
		</table>
		<input type="hidden" name="sel" value="<?php echo $sel ?>">
		</form>
		</td>
	</tr>
</table>
<?php
foot();
?>