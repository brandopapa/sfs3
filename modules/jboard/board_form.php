<font color=blue><b>�峹����</b></font>�G<select name="bk_id" size="1">
<?php
	$query = "select bk_id,bk_order,board_name,position from jboard_kind order by bk_order,bk_id ";
	$result= $CONN->Execute($query) or die ($query);
	while( $row = $result->fetchRow()){
		$P=($row['position']>0)?"".str_repeat("|--",$row['position']):"";
		if (board_checkid($row["bk_id"]) or checkid($_SERVER[SCRIPT_FILENAME],1)) {
			if ($row["bk_id"] == $bk_id  ){
			echo sprintf(" <option style='color:%s;font-weight:bold;font-size:13pt' value=\"%s\" selected>[%05d] %s%s(%s)</option>",$position_color[$row['position']],$row["bk_id"],$row['bk_order'],$P,$row["board_name"],$row["bk_id"]);
		  } else {
		  	if ($row['position']==0) {
					echo sprintf(" <option style='color:%s;font-weight:bold;font-size:13pt' value=\"%s\">[%05d] %s%s(%s)</option>",$position_color[$row['position']],$row["bk_id"],$row['bk_order'],$P,$row["board_name"],$row["bk_id"]);
	  		} else {
					echo sprintf(" <option style='color:%s' value=\"%s\">[%05d] %s%s(%s)</option>",$position_color[$row['position']],$row["bk_id"],$row['bk_order'],$P,$row["board_name"],$row["bk_id"]);
		  	}
			}
		}	
		
		/*
		$P=($row['position']>0)?str_repeat("--",$row['position']):"";
		if (board_checkid($row["bk_id"]) or checkid($_SERVER[SCRIPT_FILENAME],1)) {
			if ($row["bk_id"] == $bk_id  ){
				echo sprintf(" <option style='color:%s' value='%s' selected>%s%s</option>",$position_color[$row['position']],$row["bk_id"],$P,$row["board_name"]);
			}	else {
				echo sprintf(" <option style='color:%s' value='%s' >%s%s</option>",$position_color[$row['position']],$row["bk_id"],$P,$row["board_name"]);
	  	}
		}
		*/
	} // end while
	echo "</select>";
	
?>
<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bgcolor="#FFFFEE" bordercolor='#111111' width="100%">
<tr>
	<td align="right" valign="top" width="60">�o�G���</td>
	<td>
		<input type="text" size="12" maxlength="12" name="b_open_date" value="<?php echo $b_open_date;?>">
	  �����G<select name="b_days">

<?php
reset($days);
	while (list ($key, $val) = each ($days)){
		if ($b_days == $key )
			echo "<option value=\"$key\" selected >$val";
		else
			echo "<option value=\"$key\" >$val";
	}
?>
</select></td>
</tr>

<tr>
	<td align="right" valign="top">��L�]�w</td>
	<td>
		<input type="checkbox"  name="b_is_intranet" value="1" <?php if ($b_is_intranet=='1') echo "checked"; ?> > ���T���u�糧�դ���		
		<input type="checkbox"  name="b_is_marquee" value="1" <?php if ($b_is_marquee=='1') echo "checked"; ?>> �N�����i�m��]���O
		<?php
			if ($enable_is_sign == '1') {
		?>		
		<input type="checkbox"  name="b_is_sign" value="1" <?php if ($b_is_sign=='1') echo "checked"; ?> > ���ձ�¾����ñ�����i
		<?php
			}
		?>
	</td>
</tr>

<tr>
	<td align="right" valign="top">�峹���D</td>
	<td ><input type="text" size="80" maxlength="100" name="b_sub" value="<?php echo $b_sub ?>"></td>
</tr>


<tr>
<td align="right" valign="top" nowrap="true">�峹���e</td>
		<td colspan="3"><textarea name="b_con" id="b_con" class="ckeditor" cols="80" rows="15"><?php echo $b_con ?></textarea></td>
</tr>
<tr>
	<td align="right" valign="top">�������}</td>
	<td ><input type="text" name="b_url" size=70 value="<?php echo $b_url ?>"></td>
</tr>
<tr>
	<td vAlign="top" align="right">����<br/>
      <a href="javascript:addElementToForm('fileFields','file','resourceFile','')" class='b1'>�W�[����</a>
	  
	</td>
	<td >
	<div class="field" id="fileFields">
		<input type="file" id="resourceFile_1" name="resourceFile_1" />(��@�ɮפj�p����:<?php echo $Max_upload;?>MB , �L�j���ɮױN�۰ʱ˱�)
		<br />
		 <div id="marker" style="clear:none;"></div>
	</div>
	<?php
		if ($fArr = board_getFileArray($b_id)){
			echo "<ul>";
			foreach ($fArr as $id => $fName){
				$Org=($fName['org_filename']!="")?"(���ɦW�G".$fName['org_filename'].")":"";
				echo "<li id='f_$id'><input type='button' value='�R��' class='b1' onClick=\"del_file('f_$id','$id')\"> ".$fName['new_filename'].$Org."</li>";
			}
			echo "</ul>";
		}
	?>
		<input type='hidden' name='file_name'>
		</td>
</tr>
	<?php
	if ($b_signs<>''){
	?>
	<tr>
		<td colspan=2 align=center><input type='checkbox' name='del_sign' value='1'> �����s�^ñ���i </td>
	</tr>
	<?php
	}
	?>
</table>
