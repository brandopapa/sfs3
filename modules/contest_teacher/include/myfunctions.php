<?php
//�p��ثe����� �ǤJ YYYY-MM-DD HH:ii:ss
function NowAllSec($DateTime) {
  $mon=substr($DateTime,5,2);
  if (substr($mon,0,1)=="0") $mon=substr($mon,1,1);
  $day=substr($DateTime,8,2);
  if (substr($day,0,1)=="0") $day=substr($day,1,1);
  $st=date("U",mktime(substr($DateTime,11,2),substr($DateTime,14,2),substr($DateTime,17,2),$mon,$day,substr($DateTime,0,4)));
  return $st;
}

function big52utf8($big5str) {  
	$blen = strlen($big5str);  
	$utf8str = "";  
		for($i=0; $i<$blen; $i++) {    
			$sbit = ord(substr($big5str, $i, 1));    
			if ($sbit < 129) {      
				$utf8str.=substr($big5str,$i,1);    
			}elseif ($sbit > 128 && $sbit < 255) {     
				$new_word = iconv("big5", "UTF-8", substr($big5str,$i,2));
				$utf8str.=($new_word=="")?" ":$new_word;      
				$i++;    
			} //end if 
		} // end for
	
	return $utf8str;
}

function shownews($NEW) {
	global $UPLOAD_NEWS_URL,$MANAGER;
	?>
	<table border="0" width="100%">
		<tr>
			<td bgcolor="#CCCCFF" style="color:#800000">��<?php echo $NEW['title'];?>&nbsp;<font style="color:#808080;font-size:9pt">/&nbsp;���Ĵ���: <?php echo $NEW['sttime'];?> ~ <?php echo $NEW['endtime'];?></font>
			<?php
			 if ($MANAGER) {
			  ?>
			  <img src="./images/edit.png" border="0" title="�s��" style="cursor:hand" onclick="document.myform.option1.value='<?php echo $NEW['nsn'];?>';document.myform.act.value='update';document.myform.submit();">
			  <img src="./images/del.png" border="0" title="�R��"  style="cursor:hand" onclick="javascript:del_news(<?php echo $NEW['nsn'];?>);">
			  <?php
			 }
			?>	
			</td>
		</tr>
	</table>
	<div align="center">
 	<table border="0" width="97%">
		<tr>
			<td>
				<?php echo shownewhtml($NEW['memo'],$NEW['htmlcode']);?>
			</td>
		</tr>
		
		<?php
		$query="select * from contest_files where nsn='".$NEW['nsn']."'";
 	  $result=mysql_query($query);
 	  if (mysql_num_rows($result)>0) {
      ?>
    <tr><td>
      <table border="1" width="100%" bordercolor="#008080" style="border-collapse:collapse">
      <tr>
      	<td style="font-size:10pt"><font style="color:#FF6600">�C�������t����A�Цb�ɦW�W���ƹ��k���ܡi�t�s�ؼСj�G</font>
      
      <?php 	  	
      while ($row=mysql_fetch_array($result,1)) {
       ?>
       <li><a href="<?php echo $UPLOAD_NEWS_URL;?><?php echo $row['filename'];?>"><?php echo $row['ftext'];?></a>
       <?php
      }
      ?>
     </td></tr>
      </table>
    </td></tr>
      <?php
 	  } // end if
		?>
	</table>
  </div>
  <Script Language="JavaScript">
   //�R������
   function del_news(NSN) {
    Y=confirm("�z�T�{�n�R��������?");
    if (Y) {
     document.myform.option1.value=NSN;
     document.myform.act.value='del';
     document.myform.submit();
    
    } else {
      return false;
    }
    
   }
  </Script>
	<?php
}

function showgroups($tsn,$stid) {
 $query="select stid,name from contest_user where tsn='$tsn' and ifgroup='$stid'";
 $result=mysql_query($query);
 if (mysql_num_rows($result)>0) {
 echo "&nbsp;( �խ�: &nbsp;";
  while ($row=mysql_fetch_array($result,1)) {
   echo $row['stid'].$row['name']."&nbsp;";
  }
  echo ")";
 }
}

//�̷s�����C��
function listnews($target) {
	global $PHP_MENU,$PHP_URL,$PHP_PAGE;
	
	?>
   <table border="1" width="100%" style="border-collapse: collapse" bordercolor="#C0C0C0">
   	<tr bgcolor="#FFFFCC">
   		<td style="font-size:10pt;color:#800000" width="40" align="center">�s��</td>
   		<td style="font-size:10pt;color:#800000" align="center">�����D�D</td>
   		<td style="font-size:10pt;color:#800000" width="120" align="center">�o�G�ɶ�</td>
   		<td style="font-size:10pt;color:#800000" width="120" align="center">�����ɶ�</td>
   		<td style="font-size:10pt;color:#800000" width="50" align="center">����</td>
  		<td style="font-size:10pt;color:#800000" width="50" align="center">�ާ@</td>

   	</tr>	
 <?php
    $row=mysql_fetch_row(mysql_query("select count(*) as num from contest_news"));
   	 list($ALL)=$row; 
   	 $PAGEALL=ceil($ALL/$PHP_PAGE); //�L����i��
   	 $st=($target-1)*$PHP_PAGE;
   	 $query="select * from news limit ".$st.",".$PHP_PAGE;
   	 $result=mysql_query($query);
 	  while ($row=mysql_fetch_row($result)) {
 	  	list($id,$nsn,$title,$sttime,$endtime,$memo)=$row;
 	  $query="select count(*) as num from files where nsn='".$nsn."'";
 	  list($F)=mysql_fetch_row(mysql_query($query));
 	?>
   	<tr>
   		<td style="font-size:10pt" align="center"><?php echo $id;?></td>
  		<td style="font-size:10pt"><?php echo $title;?></td>
  		<td style="font-size:10pt" align="center"><?php echo $sttime;?></td>
  		<td style="font-size:10pt" align="center"><?php echo $endtime;?></td>
  		<td style="font-size:10pt" align="center"><?php echo $F;?>�Ӫ���</td>
  		<td style="font-size:10pt" align="center">
  			<a style="cursor:hand" onclick="document.form2.nsn.value='<?php echo $nsn;?>';document.form2.mode.value='edit';document.form2.submit();"><img src="<?php echo $PHP_URL;?>fig/edit.jpg" border="0"></a>&nbsp;
  			<a style="cursor:hand" onclick="document.form2.mode.value='drop';document.form2.nsn.value='<?php echo $nsn;?>';if (confirmdelete('�R����<?php echo $id;?>�h����')) { document.form2.submit() }"><img src="<?php echo $PHP_URL;?>fig/drop.png"  border="0"></a>
  		</td>
  	</tr>
  <?php
    }
  ?>
  	</table>
  	<table border="0" width="100%" style="border-collapse: collapse" bordercolor="#C0C0C0">
  	<tr>
  	 <td style="font-size:10pt">���� 
  	 <?php
  	 //���X
  	  for($i=1;$i<=$PAGEALL;$i++) {
  	  	if ($i==$target) {
  		  	   echo $i."&nbsp;";
				 }else{
  	   ?>
  	    <a href="<?php echo $_SERVER['PHP_SELF'];?>?target=<?php echo $i;?>"><?php echo $i;?></a>&nbsp;
  	   <?php
  	     } // end if
  	  } //end for
  	 ?>
  	 </td>
  	</tr>
  </table>
 
<?php

} // end function


//�̷s�������
function form_news($NEWS) {
?>
   <table border="1" width="100%" style="border-collapse: collapse" bordercolor="#C0C0C0" cellpadding="2">
  	<tr>
  		<td width="80" align="right" style="color:#800000">�������D</td>
  		<td><input type="text" name="title" size="70" value="<?php echo $NEWS['title'];?>"></td>
  	</tr>
  	<tr>
  		<td width="80" align="right" style="color:#800000">�}�l���</td>
  		<td>
  			<input type="text" id="sday" name="sday" size="10" value="<?php echo substr($NEWS['sttime'],0,10);?>">
			
		<script type="text/javascript">
		new Calendar({
  		    inputField: "sday",
   		    dateFormat: "%Y-%m-%d",
    	    trigger: "sday",
    	    bottomBar: true,
    	    weekNumbers: false,
    	    showTime: 24,
    	    onSelect: function() {this.hide();}
		    });
		</script>

					

  			�ɶ��G<?php SelectTime('stime_hour',substr($NEWS['sttime'],-8,2),24);?>�I <?php SelectTime('stime_min',substr($NEWS['sttime'],-5,2),60);?>��

  		</td>
  	</tr>
  	<tr>
  		<td width="80" align="right" style="color:#800000">�������</td>
  		<td>
  			<input type="text" id="eday" name="eday" size="10" value="<?php echo substr($NEWS['endtime'],0,10);?>">
					<script type="text/javascript">
				    new Calendar({
  		      inputField: "eday",
   		      trigger: "eday",
   		      dateFormat: "%Y-%m-%d",
    		    bottomBar: true,
    		    weekNumbers: false,
    		    showTime: 24,
    		    onSelect: function() {this.hide();}
				    });
					</script>
        �ɶ��G<?php SelectTime('etime_hour',substr($NEWS['endtime'],-8,2),24);?>�I<?php SelectTime('etime_min',substr($NEWS['endtime'],-5,2),60);?>��
  		</td>
  	</tr>

  	<tr>
  		<td width="80" align="right" style="color:#800000">�������e</td>
  		<td><textarea rows="10" name="memo" cols="70"><?php echo $NEWS['memo'];?></textarea></td>
  	</tr>
  	<tr>
  		<td width="80" align="right" style="color:#800000">����榡</td>
  		<td>
  		 <input type="radio" name="htmlcode" value="0" <?php if ($NEWS['htmlcode']==0) { echo "checked"; } ?>>�¤�r
  		 <input type="radio" name="htmlcode" value="1" <?php if ($NEWS['htmlcode']==1) { echo "checked"; } ?>>�tHTML����	
  		</td>
  	</tr>
		<tr>
			<td width="80" align="right" style="font-size: 10pt" bgColor="#ffffcc">���[�ɮ�</td>
			<td align="right" style="color:#800000">
				<?php
				//�ˬd���S�����[�ɮ�
				$query="select * from contest_files where nsn='".$NEWS['nsn']."'";
				$result=mysql_query($query);
				if (mysql_num_rows($result)>0) {
				?>
				<table border="1" width="100%"style=" border-collapse: collapse" bordercolor="#FFCCCC">
					<tr><td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td style="color:#800000;font-size:10pt">���w�s�b����</td>
					</tr>
					<?php 
					  while ($row=mysql_fetch_array($result,1)) {
					 	?>
					 	<tr>
					 		<td><?php echo $row['ftext'];?><img src="./images/del.png" border="0" title="�R��"  style="cursor:hand" onclick="if (confirm('�z�T�w�n\n�R���u<?php echo $row['ftext'];?>�v?')) { document.myform.RETURN.value='<?php echo $_POST['RETURN'];?>';document.myform.option2.value='<?php echo $row['fsn'];?>';document.myform.act.value='del_file';document.myform.submit(); }"></td>
					 	</tr>
					<?php
					  }// end while
					?>
				</table>
			</td></tr>
		</table>
				<?php
				} // end if file num >0
				?>
				<table border="0" width="100%">
					<tr>
						<td><input type="file" class="multi" name="thefile[]"></td>
						<td align="left"><input type="button" value="�[�J����" name="B1"></td>
					</tr>
				</table>		
			</td>
		</tr>
  </table>
<?php
} // end function

//�̷s��������
function news_files($nsn) {
	
	global $UPLOAD_NEWS_PATH;
	
  if (count($_FILES['thefile']['name']>0)) {
   for ($i=0;$i<count($_FILES['thefile']['name']);$i++) {
       $NowFile=$ftext=$_FILES['thefile']['name'][$i]; //�ɦW
     if ($NowFile!="") {
      //������ɦW
      $expand_name=explode(".",$NowFile);
      $nn=count($expand_name)-1;  //���̫�@�ӷ���ɦW
      $ATTR=strtolower($expand_name[$nn]); //��p�g���ɦW
      //�˴��O�_���\�W�Ǧ������ɮ�
      if (check_file_attr($ATTR)) {
      //�s�W , ���ݦb $idnumber �d����
      $filename=$nsn.date("y").date("m").date("d").date("H").date("i").date("s").$i.".".$ATTR;
      copy($_FILES['thefile']['tmp_name'][$i],$UPLOAD_NEWS_PATH.$filename);
      //��file�إ�sn      
       $query="insert into contest_files (nsn,ftext,filename) values ('$nsn','$ftext','$filename')";
       mysql_query($query);
      } // end if check_file_attr
     } 
    }// end for
  } //end if file 	

}

//�˴��ɮ�����
function check_file_attr($ATTR) {
 global $PHP_FILE_ATTR;
 if (strpos(" ".$PHP_FILE_ATTR,$ATTR)) {
  return true;
 } else {
  return false;
 }
}

//�ǥ͵n�J
function stud_login($active,$INFO) {
 global $PHP_CONTEST;
 $query="select * from contest_setup where endtime>'".date('Y-m-d H:i:s')."' and active='".$active."' order by sttime";
 $result=mysql_query($query);
 if (mysql_num_rows($result)==0) {
  echo "�ثe�t�Τ��S�������v��(���O:".$PHP_CONTEST[$active].") ���b�i��ΧY�N�i��!";
  exit();
 }
 $STUD=get_student($_SESSION['session_tea_sn']);
?>
<br>
<SCRIPT TYPE="text/javascript">
	<!--
		function submitenter(myfield,e)	{
			var keycode;
				if (window.event) keycode = window.event.keyCode;
				else if (e) keycode = e.which;
				else return true;
				if (keycode == 13) 	{
					document.myform.act.value='login';
   				document.myform.submit();
   			  return false;
   			} else {
   				return true;
   			}
		} // end function
//-->
</SCRIPT>


<div align="center">
	<table border="0" width="500">
   <tr>
   	  <td>�t�ήɶ��G<?php echo date("Y-m-d H:i:s");?></td>

   </tr>
	 <tr>
	  <td>
	   �ǥ��v�ɵn�J�G<?php echo $STUD['class_name']." ".$STUD['seme_num']."�� ".$STUD['stud_name'];?>
	  </td>
	 </tr>
	 <tr>
	  <td>
	<table border="1" width="500" style="border-collapse: collapse" bordercolor="#800000">
		<tr>
			<td>
			<table border="0" width="500" cellpadding="5">
        <tr>
        	<td width="100" bgcolor="#CCFFCC" style="font-size:10pt" align="center">�п���v�ɶ���</td>
        	<td bgcolor="#CCFFCC" style="font-size:10pt">
        		<select size="1" name="tsn">
        			<?php
        			while ($row=mysql_fetch_array($result)) {
        			?>
        			<option value="<?php echo $row['tsn']?>"><?php echo $row['title'];?>(<?php echo $PHP_CONTEST[$row['active']];?>)</option>
        		 <?php
 							} //end while
        		 ?>
        	</td>
        </tr>
				<tr>
        	<td width="100" bgcolor="#CCFFCC" style="font-size:10pt" align="center">�п�J�v�ɱK�X</td>
        	<td bgcolor="#CCFFCC" style="font-size:10pt"><input type="text" name="password" size="5" onKeyPress="return submitenter(this,event)"></td>
				</tr>        
			</table>
			</td>
		</tr>
	</table>
	  
	  </td>
	 </tr>
	</table>
	
	<br>
  <input type="button" style="color:#FF0000" value="�T�{�L�~�n�J" onclick="document.myform.act.value='login';document.myform.submit();"> 
  <br><br>
  <font color="#FF0000"><?php echo $INFO;?></font>
</div>
 <?php
}


//���o�ǥ͸��
function get_student($student_sn) {
  global $c_curr_seme;
  $query="select a.stud_name,b.seme_class,b.seme_num from stud_base a,stud_seme b where a.student_sn=b.student_sn and a.student_sn='$student_sn' and b.seme_year_seme='$c_curr_seme'";
  $res=mysql_query($query);
  $stud=mysql_fetch_array($res,1);
  //�ഫ����Z�ŦW��
  $C=sprintf('%03d_%d_%02d_%02d',substr($c_curr_seme,0,3),substr($c_curr_seme,-1,1),substr($stud['seme_class'],0,1),substr($stud['seme_class'],1,2));
  $class_base=class_id_2_old($C);
  $stud['class_name']=$class_base[5]; //�Z�W�� �@�~1�Z, �@�~2�Z....
  
  return $stud;
  
}



//�ǥͧ@���O�� (�d���),�ǤJ $TEST array , $student_sn , �Ǧ^ array [0]=1���W�ǡAarray[0]=0 �L�W�ǡAarrray[1]=��ܪ��T��
function get_stud_record1_info($TEST,$student_sn) {
     	 $query="select count(*) as num from contest_record1 where tsn='".$TEST['tsn']."' and student_sn='".$student_sn."'";
    	 list($N)=mysql_fetch_row(mysql_query($query));
    	 $RR[1]="�w�@�� ".$N." �D";
    	 $RR[0]=($N==0)?0:1;   //1���@���A0��L�@��
    	 
    	 
     	 //�ǥͤw�����O��
 	 		 $chk_right=mysql_num_rows(mysql_query("select * from contest_record1 where tsn='".$TEST['tsn']."' and student_sn='".$student_sn."' and chk=1"));
     	 $chk_none=mysql_num_rows(mysql_query("select * from contest_record1 where tsn='".$TEST['tsn']."' and student_sn='".$student_sn."' and chk=0"));
     	 $chk_wrong=mysql_num_rows(mysql_query("select * from contest_record1 where tsn='".$TEST['tsn']."' and student_sn='".$student_sn."' and chk=-1"));
   	 
    	 if ($chk_none==$N) {
    	 	$RR[2]=0;
    	 	$RR[3]="�|������";
    	  }else{
    	  $RR[2]=1;
    	  $RR[3]="���� ".$chk_right." �D�A���� ".$chk_wrong." �D";	
    	 }

       //���o�̫�@���ɶ�
       if ($RR['0']==1) {
        $query="select anstime from contest_record1 where tsn='".$TEST['tsn']."' and student_sn='".$student_sn."' order by anstime desc limit 0,1";
        list($t)=mysql_fetch_row(mysql_query($query));
        $RR[4]=$t;
       } else {
         $RR[4]="�L�@��";
       }
    	 return $RR;
}


//�ǥͧ@���O�� (�@�~�W��),�ǤJ $TEST array , $student_sn , �Ǧ^ array [0]=1���W�ǡAarray[0]=0 �L�W�ǡAarrray[1]=��ܪ��T��
function get_stud_record2_info($TEST,$student_sn) {
  global $UPLOAD_U;
    	 $query="select filename from contest_record2 where tsn='".$TEST['tsn']."' and student_sn='".$student_sn."'";
    	 list($FILE)=mysql_fetch_row(mysql_query($query));
    	 if ($FILE!="") {
    	   $RR[1]="<a href='".$UPLOAD_U[$TEST['active']].$FILE."' target='_blank'>�[��</a>";
    	   $RR[0]=1;
    	   $RR[4]=$FILE;
    	  }else{
    	   $RR[1]="���W��!";
     	   $RR[0]=0;
    	  }   	 
    	  
     	 $query="select count(*) as num,AVG(score) as score from contest_score_record2 where score>0 and tsn='".$TEST['tsn']."' and student_sn='".$student_sn."'";
    	 $result=mysql_query($query);
  	 	 $WORKS=mysql_fetch_array($result,1); //�|�Ψ� score ���
    	 $RR[2]=$WORKS['num'];  //�X�Ӧ��Z ,0������
    	 $RR[3]=round($WORKS['score'],2); 

   return $RR;
}



function showhtml($w) {
 $w=preg_replace("/\n/","<br>\n",$w);
 $regex = "{ ((https?|telnet|gopher|file|wais|ftp):[\\w/\\#~:.?+=&%@!\\-]+?)(?=[.:?\\-]*(?:[^\\w/\\#~:.?+=&%@!\\-]|$)) }x";
 return preg_replace($regex, "<a href=\"$1\" target=\"_blank\" alt=\"$1\" title=\"$1\">$1</a>",$w);
}

function shownewhtml($w,$h) {
	if ($h==0) {
   $w=preg_replace("/\n/","<br>\n",$w);
  }
 $regex = "{ ((https?|telnet|gopher|file|wais|ftp):[\\w/\\#~:.?+=&%@!\\-]+?)(?=[.:?\\-]*(?:[^\\w/\\#~:.?+=&%@!\\-]|$)) }x";
 return preg_replace($regex, "<a href=\"$1\" target=\"_blank\" alt=\"$1\" title=\"$1\">$1</a>",$w);
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

  




//���U�� java function ============================================================
?>
<Script Language="JavaScript">
  function confirmdelete(theSqlQuery)
  {
    var is_confirmed = confirm('�z�T�w�n :\n' + theSqlQuery);
    if (is_confirmed) {
     return true;
    }else{
     return false;
    }
  }
  
  //��ܳѾl�ɶ�
	function checkLeaveTime() 
	{
    var strLeaveMin=Math.floor(inttestsec/60);
    var strLeaveSec=inttestsec-Math.floor(inttestsec/60)*60;
     if (strLeaveSec<10) { strLeaveSec="0"+strLeaveSec; }
     if (strLeaveMin<10) { strLeaveMin="0"+strLeaveMin; }
    showLeaveTime=strLeaveMin+"��"+strLeaveSec+"��";
    document.myform.time.value=showLeaveTime;
    if (inttestsec<=0) {
     document.myform.act.value=ACT;
     document.myform.submit(); //�۰ʰe�X
    }
    inttestsec=inttestsec-1;
    TestTimer=setTimeout("checkLeaveTime()",1000);
  }

  
</Script>
