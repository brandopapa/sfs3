<?php

//���o�����ϳ]�w
function get_setup($kind_id) {
	global $CONN;
   	$sql="select * from jshow_setup where kind_id='$kind_id'";
   	$res=$CONN->Execute($sql) or die ("SQL Error! query=".$sql);
   	if ($res->RecordCount()==1) {
     	$row=$res->FetchRow();     	
     	
			//�έp���������X�i��
			$sql="select count(*) from jshow_pic where kind_id='$kind_id'";
   		$res=$CONN->Execute($sql) or die ("SQL Error! query=".$sql);
			$row['Number_pic']=$res->fields[0];
    }
    return $row;
}

//���o�@�i��
function get_one_pic($id) {
  global $CONN;
  $sql="select * from jshow_pic where id='$id'";
  $res=$CONN->Execute($sql);
  $row=$res->FetchRow();
  return $row;

}

//���, �]�w���ǹϭn�i��
function show_setup_all($kind_id) {
	global $CONN,$USR_DESTINATION,$USR_DESTINATION_URL;
	global $DISPLAY_M;

	//���o�]�w
	$S=get_setup($kind_id);
	//��C�i�ϦC�X
	$sql="select * from jshow_pic where kind_id='$kind_id' order by sort,upload_day desc";
	$res=$CONN->Execute($sql) or die('SQL='.$sql);
	?>
	<table border="2"  cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
		<tr bgcolor="#FF6600">
		 <td width="30" style="font-size:10pt" align="center">�s��</td>
		 <td align="center">�ϥ�</td>
		 <td width="80" align="center">�Ϥ���T</td>
		 <td align="center">�D�D</td>
		 <td align="center">����</td>
		 <td align="center">�Ǹ�</td>
		 <td width="180" align="center">�i�ܳ]�w</td>
		</tr>
	<?php
	while ($row=$res->Fetchrow()) {
 		  $a=explode(".",$row['filename']);
 		  $filename_s=$a[0]."_s.".$a[1];
 		  $bgcolor=($row['b_id']==$_POST['b_id'])?"#FFDDDDDD":"#FFFFFF";
 		  //���o�Ϥ���T
 		  $id=$row['id'];
 		  $img_info = getimagesize($USR_DESTINATION.$row['filename']);
      $width    = $img_info['0'];
      $height   = $img_info['1'];
      $imgtype  = $img_info['2'];
      $mime     = $img_info['mime'];
      $display=$row['display'];
      $display_sub=$row['display_sub'];
      $display_memo=$row['display_memo'];
		?>
 	  <tr bgcolor="<?php echo $bgcolor;?>">
		 <td><?php echo $row['id'];?></td>
		 <td><img src="<?php echo $USR_DESTINATION_URL.$filename_s; ?>" border="0"></td>
		 <td align="center"><?php echo $width."x".$height." (".$mime.")";?></td>
		 <td><?php echo $row['sub'];?></td>
		 <td style="font-size:10pt"><?php echo $row['memo'];?></td>
		 <td><input type="text" name="pic_set[<?php echo $id;?>][sort]" value="<?php echo $row['sort'];?>" size="3"></td>
		 <td align="left">
		 	�Ϥ��G<input type="radio" name="pic_set[<?php echo $id;?>][display]" value="1"<?php if ($display=='1') echo " checked";?>>�i�� <input type="radio" name="pic_set[<?php echo $id;?>][display]" value="0"<?php if ($display=='0') echo " checked";?>>���i��<br>
		 	�D�D�G<input type="radio" name="pic_set[<?php echo $id;?>][display_sub]" value="1"<?php if ($display_sub=='1') echo " checked";?>>�i�� <input type="radio" name="pic_set[<?php echo $id;?>][display_sub]" value="0"<?php if ($display_sub=='0') echo " checked";?>>���i��<br>
		 	�����G<input type="radio" name="pic_set[<?php echo $id;?>][display_memo]" value="1"<?php if ($display_memo=='1') echo " checked";?>>�i�� <input type="radio" name="pic_set[<?php echo $id;?>][display_memo]" value="0"<?php if ($display_memo=='0') echo " checked";?>>���i��
		 </td>
		</tr>
	  <?php
	}
	?>	
	</table>
	<?php
}
//���, �]�w���Ǥ���n�i�ܨ��ǹ�
function show_setup_day($kind_id) {
	global $CONN,$MON;
	
	$S=get_setup($kind_id);
	//���o�Ҧ��Ϥ�
	$sql="select * from jshow_pic where kind_id='".$kind_id."'";
	$res=$CONN->Execute($sql);
	$PIC_Number=$res->RecordCount();
	$PIC=array();
	while ($row=$res->fetchRow()) {
	  $ID=$row['id'];
	  foreach ($row as $k=>$v) {
	   $PIC[$ID][$k]=$v;
	  }	  
	}	
	
	$day_pic_array=unserialize($S['day_pic_set']);
	
	
	//��w�w�]��
	?>
	<br>�w�]�Ϥ��G
	<select size="1" name="init_pic_set" class="SELECT_pic_id" id="init_pic_set">
		<?php
	  	foreach ($PIC as $k=>$v) {
	  	?>
	  			<option value="<?php echo $k;?>"<?php if ($k==$S['init_pic_set']) echo " selected";?>><?php echo $v['sub'];?></option>
	   	<?php
	  	}
 		?>
	</select>	  
	<?php
	if ($PIC_Number<1) echo "<font color=red size=2>���ϩ|���W�ǹϤ�!!</font>";
	?>
	<br>
	<?php
	//�̤���C�X�ѿ��
	$DAY_SET=array();
	for($m=1;$m<13;$m++) {
		//echo $m."���<br>";
		$DAY_SET[$m]="<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111'>\n";
		$DAY_SET[$m].=" <tr>\n";
		
	 for ($d=1;$d<=$MON[$m];$d++) {
	  if ($d%5==1) $DAY_SET[$m].="</tr><tr>\n";
	  $KEY=sprintf("%02d",$m)."-".sprintf("%02d",$d);	 
	  $DAY_SET[$m].=" 
	  	<td>
	  		<table border=\"0\">
	  		 <tr>
	  		  <td bgcolor=\"#CCFFCC\" align=\"center\">$KEY</td>
	  		 </tr>
	  		 <tr>
	  		 	<td>
	  		 		<select size=\"1\" name=\"DayPic[$KEY]\" class=\"SELECT_pic_id\">
	  	  			<option value=\"0\">�w�]�Ϥ�</option>";
	  	  				
	  	  				foreach ($PIC as $k=>$v) {
	  	  	  		 if ($k==$day_pic_array[$KEY]) {
	  	  	  		 	$DAY_SET[$m].="<option value=\"$k\" selected>".$v['sub']."</option>";
	  	  	  		 } else {
	  	  	  		 	$DAY_SET[$m].="<option value=\"$k\">".$v['sub']."</option>";
	  	  	  		 }
	  	  	  		} // end foreach	  	  				
	  	  		$DAY_SET[$m].="</select>
	  		 	</td>
	  		 </tr>
	  		</table>
	  	</td>";
	  
	 } // end for $d	
	 $DAY_SET[$m].="</tr>
	</table>";
	 
	} // end for $m
	
	return $DAY_SET;
	
} // end function



//�W�Ǫ��
function form_upload($arr="",$readme) {
	global $download_path;
  ?>
  <table border="0">
  	<tr>
  	<td>
	<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
  	<tr>
  		<td>���ɽs��</td>
  		<td><?php echo $arr['id'];?></td>
  	</tr>

  	<tr>
  		<td>�D�D</td>
  		<td><input type="text" name="sub" size="30" value="<?php echo $arr['sub'];?>"></td>
  	</tr>
  	<tr>
  		<td>����</td>
  		<td>
  			<textarea cols="50" rows="5" name="memo"><?php echo $arr['memo'];?></textarea>
  	</tr>
  	<tr>
  		<td>�Ƨ�</td>
  		<td>
  		<input type="text" name="sort" size="5" value="<?php echo $arr['sort'];?>"></td>
  	</tr>
  	<tr>
  		<td>�W�s�����}</td>
  		<td>
  		<input type="text" name="url" size="30" value="<?php echo $arr['url'];?>"></td>
  	</tr>

  	<tr>
  		<td>����</td>
  		<td>
  			<input type="file" name="thefile" value="" size="30">
  			<?php
  			  if ($arr['filename']!='') {
  			   echo "<br>";
  			   ?>
  			   <img src="<?php echo $download_path.$arr['filename'];?>">
  			   <?php
  			  }
  		  ?>
  		</td>
  	</tr>  
  </table>   		
  		
  	</td>
  	<td valign="top" align="left">
  	<font color="blue">�����ϻ���:</font><br>
  	<?php echo str_replace("\n","<br>",$readme);?>
  	</td>
  	</tr>
  </table>
 <?php
} // end function


//��ܹϤ��C��
function show_upload($kind_id) {
	global $CONN,$USR_DESTINATION,$USR_DESTINATION_URL;
	//$P=($page-1)*10;
	
	$sql="select * from jshow_pic where kind_id='$kind_id' order by sort";
	$res=$CONN->Execute($sql);
	?>
	<table border="2"  cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111'>
		<tr bgcolor="#FF6600">
		 <td width="30" style="font-size:10pt">�Ƨ�</td>
		 <td width="30">id</td>
		 <td width="150">�ϥ�</td>
		 <td width="80">�Ϥ���T</td>
		 <td width="100">�D�D</td>
		 <td>����</td>
		 <td width="80">�W�Ǥ��</td>
		 <td width="60">�W�Ǫ�</td>
		 <td width="60">�ާ@</td>
		</tr>
	<?php
	while ($row=$res->Fetchrow()) {
 		  $a=explode(".",$row['filename']);
 		  $filename_s=$a[0]."_s.".$a[1];
 		  $bgcolor=($row['b_id']==$_POST['b_id'])?"#FFCCCC":"#FFFFFF";
 		  //���o�Ϥ���T
 		  $img_info = getimagesize($USR_DESTINATION.$row['filename']);
      $width    = $img_info['0'];
      $height   = $img_info['1'];
      $imgtype  = $img_info['2'];
      $mime     = $img_info['mime'];           
		?>
 	  <tr bgcolor="<?php echo $bgcolor;?>"  style="font-size:10pt">
 	   <td><?php echo $row['sort'];?></td>
		 <td><?php echo $row['id'];?></td>
		 <td><img src="<?php echo $USR_DESTINATION_URL.$filename_s; ?>" border="0"></td>
		 <td align='center'><?php echo $width."x".$height."<br>(".$mime.")";?></td>
		 <td><?php echo $row['sub'];?></td>
		 <td><?php echo $row['memo'];?></td>
		 <td><?php echo $row['upload_day'];?></td>
		 <td><?php echo get_teacher_name($row['teacher_sn']);?></td>
		 <td>
		 	<a href="#" onclick="confirm_delete(<?php echo $row['id'];?>,'<?php echo $row['sub'];?>')">�R��</a><br>
		 	<a href="#" onclick="document.myform.act.value='edit';document.myform.opt1.value='<?php echo $row['id'];?>';document.myform.submit()">�ק�</a>
		 </td>
		</tr>
	  <?php
	}
	?>	
	</table>
	<?php
}

//�W�ǹϤ��B�z
function process_upload_file ($kind_id) {
	
	global $USR_DESTINATION,$CONN;
	
	    //���o�����ϳ]�w
  		$row=get_setup($kind_id);
			if (count($row)>0) {
		  	foreach ($row as $k=>$v) { ${$k}=$v; }
			}	
		  //������ɦW
      $expand_name=explode(".",$_FILES['thefile']['name']);
      $nn=count($expand_name)-1;
      $ATTR=strtolower($expand_name[$nn]); //��p�g���ɦW
      $filename="";
      if ($ATTR=="jpg" or $ATTR=="jpeg" or $ATTR=="png" or $ATTR=="gif") {
          //�s�ɦW 
      		$filename_1="jshow_".time().floor(rand(1000,9999)); //�᭱�[�|�X�ü�, �קK�M���ɭ���, �ɭP���Ǯɤ��|�ݨ��¹�,cache���D
          $filename=$filename_1.".".$ATTR;   		//�ؼ��ɮ�  , �̭���j�p���s 
          $filename_a=$filename_1."_a.".$ATTR;  //��l�ɮ�
          $filename_s=$filename_1."_s.".$ATTR;  //�Y����      
          //�ƻs�ɮ�
          if (copy($_FILES['thefile']['tmp_name'],$USR_DESTINATION.$filename_a)) {
          
          //�p�G�O gif��, ���n���s
          if ($ATTR!="gif") {
          //�s�y�ŦX�W�w�j�p�����
       	  	if (!ImageResize($USR_DESTINATION.$filename_a, $USR_DESTINATION.$filename, $max_width, $max_height, 100)) {
       	   		$filename="";
       	   		$INFO="ErroR! �L�k�s�y���!!";       	   		
       	  	}       	  
          } else {
          	//gif��, �����s, �קK�ʵe�ĪG����
            copy($_FILES['thefile']['tmp_name'],$USR_DESTINATION.$filename);
          }
          
          //�s�y�Y����       	  
       	  	if (!ImageResize($USR_DESTINATION.$filename_a, $USR_DESTINATION.$filename_s, 400, 150, 100)) {
       	   		$filename="";
       	   		unlink($USR_DESTINATION.$filename);  //�R���s�n����
       	   		$INFO="ErroR! �L�k�s�y�Y��!!";  	   		
       	  	}   
       	  
       	  //���ϧR��
						unlink($USR_DESTINATION.$filename_a);
					
					} else {
						$filename="";
      			$INFO="�W���ɮץ���! �L�k�ƻs�W�Ǫ�����!";    
          } // end if          
      } else {
      	$INFO="�W���ɮץ���! �Ȥ��\�W�� jpg/gif/png �ɮ�!";
      } // end if
      
      $FILENAME[0]=$filename;
      $FILENAME[1]=$INFO;
      
			return $FILENAME;  //�^�ǰT��

}



//�Y�ϵ{��
/**
 The MIT License

 Copyright (c) 2007 <Tsung-Hao>

 Permission is hereby granted, free of charge, to any person obtaining a copy
 of this software and associated documentation files (the "Software"), to deal
 in the Software without restriction, including without limitation the rights
 to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the Software is
 furnished to do so, subject to the following conditions:

 The above copyright notice and this permission notice shall be included in
 all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 THE SOFTWARE.
 *
 * ����n�Y�Ϫ����, �U�z�u�B�z jpeg
 * $from_filename : �ӷ����|, �ɦW, ex: /tmp/xxx.jpg
 * $save_filename : �Y�ϧ��n�s�����|, �ɦW, ex: /tmp/ooo.jpg
 * $in_width : �Y�Ϲw�w�e��
 * $in_height: �Y�Ϲw�w����
 * $quality  : �Y�ϫ~��(1~100)
 *
 * Usage:
 *   ImageResize('ram/xxx.jpg', 'ram/ooo.jpg');
 */
 
function ImageResize($from_filename, $save_filename, $in_width=400, $in_height=300, $quality=100)
{
    $allow_format = array('jpeg', 'png', 'gif');
    $sub_name = $t = '';

    // Get new dimensions
    $img_info = getimagesize($from_filename);
    $width    = $img_info['0'];
    $height   = $img_info['1'];
    $imgtype  = $img_info['2'];
    $imgtag   = $img_info['3'];
    $bits     = $img_info['bits'];
    $channels = $img_info['channels'];
    $mime     = $img_info['mime'];

    list($t, $sub_name) = split('/', $mime);
    if ($sub_name == 'jpg') {
        $sub_name = 'jpeg';
    }

    if (!in_array($sub_name, $allow_format)) {
        return false;
    }

    
    // ���o�Y�b���d�򤺪����
    $percent = getResizePercent($width, $height, $in_width, $in_height);
    $new_width  = $width * $percent;
    $new_height = $height * $percent;

    // Resample
    $image_new = imagecreatetruecolor($new_width, $new_height);

    // $function_name: set function name
    //   => imagecreatefromjpeg, imagecreatefrompng, imagecreatefromgif
    /*
    // $sub_name = jpeg, png, gif
    $function_name = 'imagecreatefrom' . $sub_name;

    if ($sub_name=='png')
        return $function_name($image_new, $save_filename, intval($quality / 10 - 1));

    $image = $function_name($filename); //$image = imagecreatefromjpeg($filename);
    */
    
    
    //$image = imagecreatefromjpeg($from_filename);
    
    $function_name = 'imagecreatefrom'.$sub_name;
    $image = $function_name($from_filename);

    imagecopyresampled($image_new, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    return imagejpeg($image_new, $save_filename, $quality);
    
   
     
    
}

/**
 * ����n�Y�Ϫ����
 * $source_w : �ӷ��Ϥ��e��
 * $source_h : �ӷ��Ϥ�����
 * $inside_w : �Y�Ϲw�w�e��
 * $inside_h : �Y�Ϲw�w����
 *
 * Test:
 *   $v = (getResizePercent(1024, 768, 400, 300));
 *   echo 1024 * $v . "\n";
 *   echo  768 * $v . "\n";
 */
function getResizePercent($source_w, $source_h, $inside_w, $inside_h)
{
    if ($source_w < $inside_w && $source_h < $inside_h) {
        return 1; // Percent = 1, �p�G����w�p�Y�Ϫ��p�N�����Y
    }

    $w_percent = $inside_w / $source_w;
    $h_percent = $inside_h / $source_h;

    return ($w_percent > $h_percent) ? $h_percent : $w_percent;
}

//���o�g���v���Ҧ�������
function get_jshow_checked_id() {
	global $CONN;
	$sql="select * from jshow_setup";
	$res=$CONN->Execute($sql);
	$P=array();
	$i=0;
	while ($row=$res->FetchRow()) {
  	$kind_id=$row['kind_id'];
  	//�Q�� function jshow_checkid($kind_id) �ˬd�������ϥثe�� $_SESSION[session_tea_sn] �O�_���ϥ��v
  	if (jshow_checkid($kind_id)) {
    	$i+=1;
    	$P[$i]['kind_id']=$kind_id;
    	$P[$i]['id_name']=$row['id_name'];
    	$P[$i]['memo']=$row['memo'];
    	$P[$i]['max_width']=$row['max_width'];  
  		$P[$i]['max_height']=$row['max_height'];
  		$P[$i]['init_pic_set']=$row['init_pic_set'];
  		$P[$i]['day_pic_set']=$row['day_pic_set'];
  		$P[$i]['update_time']=$row['update_time'];
  	} // end if
	} // end while
  
  return $P;

} // end function  
  
//�ˬd�ϥ��v $chk = $kind_id
function jshow_checkid($chk){
	global $CONN,$session_log_id ,$session_tea_sn;
	$post_office = -1;
	$teach_title_id = -1;
	$teach_id = -1 ;
	$dbquery = " select a.teacher_sn,a.login_pass,a.name,b.post_office,b.teach_title_id ";
	$dbquery .="from teacher_base a ,teacher_post b  ";
	$dbquery .="where a.teacher_sn = b.teacher_sn and a.teacher_sn='$_SESSION[session_tea_sn]'";
	$result= $CONN->Execute($dbquery)or ("<br>��Ƴs�����~<br>\n $dbquery");

	if ($result->RecordCount() > 0){
		$row = $result->FetchRow();
		$post_office = $row["post_office"];
		$teach_title_id	= $row["teach_title_id"];
		$teacher_sn =	$row["teacher_sn"];

		$dbquery = "select kind_id from jshow_check where kind_id ='$chk' and (post_office='$post_office' or post_office='99' or teach_title_id='$teach_title_id' or teacher_sn='$teacher_sn')";

		$res= $CONN->Execute($dbquery)or die("<br>��Ʈw�s�����~<br>\n $dbquery");
		if ($res->RecordCount()>0)	{
			return true;
		}
		else
			return false;
	}
	else
		return false;
} // end function