<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";

sfs_check();

//�q�X����
head("���������v�� - ���f�u�@");

?>
<link type="text/css" rel="stylesheet" href="./include/my.css">
<script type="text/javascript" src="./include/tr_functions.js"></script>

<?php
$tool_bar=&make_menu($school_menu_p);

//�C�X���
echo $tool_bar;

//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();

//�ثe��w�Ǵ�
$c_curr_seme=sprintf('%03d%1d',$curr_year,$curr_seme);

//�ثe����ɶ�
$Now=date("Y-m-d H:i:s");

//POST �e�X��,�D�{���ާ@�}�l 
//�n�J, �T�{�������v��
if ($_POST['act']=='login') {
 $query="select b.* from contest_judge_user a,contest_setup b where a.tsn=b.tsn and a.teacher_sn='".$_SESSION['session_tea_sn']."' and a.tsn='".$_POST['tsn']."' and b.open_judge=1";
 $result=mysql_query($query);
 $Teacher=get_judge_user($_POST['tsn'],$_SESSION['session_tea_sn']);
 if ($row=mysql_fetch_array($result,1)) {
 	//�n�J���\
  $_POST['act']="Start";
  $_POST['option1']=$_POST['tsn'];  //�v�ɪ� tsn
  //�^�g�n�J�O��
  $L=$Teacher['logintimes']+1;
  $query="update contest_judge_user set lastlogin='".date("Y-m-d H:i:s")."',logintimes='$L' where tsn='".$_POST['tsn']."' and teacher_sn='".$_SESSION['session_tea_sn']."'"; 
  mysql_query($query);
  } else {
    $INFO="�z�å����ܵ����������v��, �Э��s���!";
    $_POST['act']="";
  } 
  
}// end if act=login

//�g�J�Y�ͬd��Ʀ��Z
if (@$_POST['act']=='score_search_write') {
  $query="update contest_record1 set chk=0,teacher_sn='".$_SESSION['session_tea_sn']."' where tsn='".$_POST['option1']."' and student_sn='".$_POST['option2']."'";
  mysql_query($query);
  if (count(@$_POST['chk'])>0) {
     foreach ($_POST['chk'] as $ibsn=>$val) {
      $query="update contest_record1 set chk=$val where tsn='".$_POST['option1']."' and student_sn='".$_POST['option2']."' and ibsn='$ibsn'";
      mysql_query($query);
     }// end foreach
	 }
	 $INFO="�w��".date("Y-m-d H:i:s")."�i���x�s";
	 //�e������, �O�_�۰ʶ}�ҤU�@��
	 if ($_POST['goto_next']) {
	 	 if ($_POST['n_student_sn']!="") {
	 	 	$i=$_POST['n_student_sn'];
	 	 	 //�U�@��ǥ�
			 $sql="select a.*,b.stud_id,b.stud_name,c.seme_class,c.seme_num from contest_user a,stud_base b,stud_seme c,contest_setup d where a.tsn=d.tsn and c.seme_year_seme=d.year_seme and a.tsn='".$_POST['option1']."' and a.ifgroup='' and a.student_sn=b.student_sn and b.student_sn=c.student_sn order by seme_class,seme_num limit $i,1";
   	   $res_next=$CONN->Execute($sql);
   	   if ($res_next->RecordCount()>0) {
   	     $next_stud=$res_next->fields['student_sn'];
	    		$_POST['option2']=$next_stud;
	    		$_POST['act']='score_search';
			 } else {
   	     $next_stud="";
   	     $_POST['act']='score';
   	   }
	   } else { 
	    $_POST['act']='score';
	   }
	 } else {
	  $_POST['act']='score_search';
	 }
}// end if �g�J�Y�ͬd��Ƥ���

//�g�J�W�ǧ@�~���v�ɦ��Z (�R�e,�ʵe,²��)
if ($_POST['act']=='score_upload') {
	$if_write=0;
		foreach ($_POST['score'] as $k=>$score) {
			if ($score>0) {
				$if_write=1;
		    if (mysql_num_rows(mysql_query("select score from contest_score_record2 where tsn='".$_POST['option1']."' and student_sn='$k' and teacher_sn='".$_SESSION['session_tea_sn']."'"))>0) {
		      $query="update contest_score_record2 set score='$score',prize_memo='".$_POST['prize_memo'][$k]."' where tsn='".$_POST['option1']."' and student_sn='$k' and teacher_sn='".$_SESSION['session_tea_sn']."'";
		    }else{
			   	$query="insert into contest_score_record2 (tsn,student_sn,teacher_sn,score,prize_memo) values ('".$_POST['option1']."','$k','".$_SESSION['session_tea_sn']."','".$score."','".$_POST['prize_memo'][$k]."')";
			  }
			  if (!mysql_query($query)) {
			   echo "Error! query=$query";
			   exit();
			  }
			//��$k �g�J�Ӷ����Z
			$K='s'.$k;
			 if (count($_POST[$K])>0) {
			  foreach ($_POST[$K] as $sco_sn=>$sco_num) {
			    if (mysql_num_rows(mysql_query("select sco_num from contest_score_user where sco_sn='$sco_sn' and student_sn='$k' and teacher_sn='".$_SESSION['session_tea_sn']."'"))>0) {
			      $query="update contest_score_user set sco_num='$sco_num' where sco_sn='$sco_sn' and student_sn='$k' and teacher_sn='".$_SESSION['session_tea_sn']."'";
			     }else{
			     	$query="insert into contest_score_user (student_sn,teacher_sn,sco_sn,sco_num) values ('$k','".$_SESSION['session_tea_sn']."','$sco_sn','$sco_num')";
			  	}
			  	mysql_query($query);
			  } // end foreach count($_POST[$K])
			 }// end if count($_POST[$k])>0
		  }//end if ($score!="")
		} // end foreach
		
		$INFO=($if_write==1)?"�@�w��".date("Y-m-d H:i:s")."�g�J��⦨�Z!":"";  

  $_POST['act']='score'; //�^��������A
  
}

//�g�J�o���]�w
if ($_POST['act']=='prize_write') {
		//�ѩ�}�C post , �L��Ƥ��|�o�e, ���M���Ҧ��O��, �H�K�쥻����ơA����M����ƪ̤��|���
		$query="update contest_user set prize_id=null,prize_text=null where tsn='".$_POST['option1']."'";
		mysql_query($query);
		$if_write=0;
		foreach ($_POST['prize_id'] as $k=>$prize_id) {
			if ($prize_id>0) {
				$if_write=1;
				$prize_text=$_POST['prize_text'][$k];
				$prize_memo=$_POST['prize_memo'][$k];
			  $query="update contest_user set prize_id='$prize_id',prize_text='$prize_text' where tsn='".$_POST['option1']."' and student_sn='".$k."'";
			  //echo $query."<br>";
			  mysql_query($query);
			
		  }
		} // end foreach
		
		$INFO=($if_write==1)?"�@�w��".date("Y-m-d H:i:s")."�g�J�o���O��!":"";
		$_POST['act']='prize';
} // end if act='prize_write'


//�ɭ��e�{�}�l, �����]�b <form>�� , act�ʧ@ , option1, option2 �Ѽ�2��
?>
<form method="post" name="myform" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
 <input type="hidden" name="act" value="<?php echo $_POST['act'];?>">
 <input type="hidden" name="option1" value="<?php echo $_POST['option1'];?>">
 <input type="hidden" name="option2" value="<?php echo $_POST['option2'];?>">
 <input type="hidden" name="RETURN" value="<?php echo $_POST['act'];?>">

<?php
//�L����Ѽ�, �ˬd�O�_�����w���f�u�@
if ($_POST['act']=='') {

 judge_login();

}

//�D�e��
if ($_POST['act']=='Start') {
?>
  <table border="0" width="100%">
  	<tr>
  		<td style="color:#0000FF">�D�v�ɵ����u�@</tr>
  </table>
  <?php
  test_main($_POST['option1'],1); //�ĤG�ӰѼƳ]��1, ��������D��, �]��0������D��(�Ω���ɫe���i)
  ?>
    <table border="0" width="100%">
  	<tr>
  		<td>
  			<input type="button" value="�i�����" onclick="document.myform.act.value='score';document.myform.submit();">
  			<input type="button" value="���w�o��" onclick="document.myform.act.value='prize';document.myform.submit();">
  			<input type="button" style="color:#FF00FF" value="�n�X" onclick="document.myform.act.value='';document.myform.submit();">
  		</td>
  	</tr>
  </table>

<?php
} // end if act='Start'

//�}�l����
if ($_POST['act']=='score') {
	?>
	<input type="hidden" name="n_student_sn" value="">
  <table border="0" width="100%">
  	<tr>
  		<td style="color:#0000FF">�D�v�ɵ����u�@ - �i�����</tr>
  </table>
  <?php
 $TEST=get_test_setup($_POST['option1']);
 title_simple($TEST);
  $query_stud="select a.*,b.stud_id,b.stud_name,c.seme_class,c.seme_num from contest_user a,stud_base b,stud_seme c,contest_setup d where a.tsn=d.tsn and c.seme_year_seme=d.year_seme and a.tsn='".$TEST['tsn']."' and a.ifgroup='' and a.student_sn=b.student_sn and b.student_sn=c.student_sn order by seme_class,seme_num";
  $result_stud=mysql_query($query_stud);
  $all_students=mysql_num_rows($result_stud); //�������ǥ�
  //�d��Ƥ���
  if ($TEST['active']==1) {
  	?>
   <br>
   <table border="1" width="840" style="border-collapse: collapse" bordercolor="#C0C0C0" cellpadding="5" cellspacing="0">
   	<tr bgcolor="#FFFFCC">
   		<td style="font-size:10pt;color:#800000" width="50" align="center">�޲z</td>
   		<td style="font-size:10pt;color:#800000" width="40" align="center">�Ǹ�</td>
   		<td style="font-size:10pt;color:#800000" width="80" align="center">�Ǹ�</td>
   		<td style="font-size:10pt;color:#800000" width="60" align="center">�m�W</td>
   		<td style="font-size:10pt;color:#800000" width="80" align="center">�Z�Ůy��</td>
   		<td style="font-size:10pt;color:#800000" width="80" align="center">�n�J����</td>
   		<td style="font-size:10pt;color:#800000" width="130" align="center">�̫�n�J</td>
   		<td style="font-size:10pt;color:#800000" width="100" align="center">�v�ɰO��</td>
   		<td style="font-size:10pt;color:#800000" width="150" align="center">�������Z</td>
   		<td style="font-size:8pt;color:#800000" width="60" align="center">�����Ѯv</td>
   	</tr>	

  	<?php
  //�d��Ƥ���
   $i=0;
   while ($Stud=mysql_fetch_array($result_stud,1)) {
 			$i++;	
    	 //�ǥͤw�d��Ƶ���
    	 $query="select count(*) as num from contest_record1 where tsn='".$TEST['tsn']."' and student_sn='".$Stud['student_sn']."'";
    	 list($N)=mysql_fetch_row(mysql_query($query));
    	 $RR="�w�@�� ".$N." �D";
    	 $Fcolor=($N>0)?"#0000FF":"#C0C0C0";
     	 //�ǥͤw�����O��
     	 $chk_right=mysql_num_rows(mysql_query("select * from contest_record1 where tsn='".$TEST['tsn']."' and student_sn='".$Stud['student_sn']."' and chk=1"));
     	 $chk_none=mysql_num_rows(mysql_query("select * from contest_record1 where tsn='".$TEST['tsn']."' and student_sn='".$Stud['student_sn']."' and chk=0"));
     	 $chk_wrong=mysql_num_rows(mysql_query("select * from contest_record1 where tsn='".$TEST['tsn']."' and student_sn='".$Stud['student_sn']."' and chk=-1"));
				
   	   
    	 if ($chk_none==$N) {
    	 	$CC="�|������";
    	 	$teacher_sn="";
    	  }else{
    	  $CC="<font color=#FF0000>���� ".$chk_right." �D�A���� ".$chk_wrong." �D</font>";
    	  //���o�����Ѯv
    	  $query="select distinct teacher_sn from contest_record1 where  tsn='".$TEST['tsn']."' and student_sn='".$Stud['student_sn']."'";	
    	  list($teacher_sn)=mysql_fetch_row(mysql_query($query));
    	 }
 //       	<tr bgcolor="#FFFFFF" onmouseover="setPointer(this, 'over', '#FFFFFF', '#CCFFCC', '#FFCC99')" onmouseout="setPointer(this, 'out', '#FFFFFF', '#CCFFCC', '#FFCC99')" onmousedown="setPointer(this, 'click', '#FFFFFF', '#CCFFCC', '#FFCC99')" >
    	 
   ?>	
   	<tr class="mytr<?php echo $i%2;?>">
   		<td style="font-size:10pt;color:<?php echo $Fcolor;?>" align="center"><?php if ($N>0) { ?><input type="button" value="����" style="cursor:hand;color:#FF0000;font-size:10pt" onclick="document.myform.n_student_sn.value='<?php echo $i-1;?>';document.myform.option2.value='<?php echo $Stud['student_sn'];?>';document.myform.act.value='score_search';document.myform.submit();"><?php } ?></td>
   		<td style="font-size:10pt;color:#800000" align="center"><?php echo $i;?></td>	
   		<td style="font-size:10pt;color:<?php echo $Fcolor;?>" align="center"><?php echo $Stud['stud_id'];?></td>
   		<td style="font-size:10pt;color:<?php echo $Fcolor;?>" align="center"><?php echo $Stud['stud_name'];?></td>
   		<td style="font-size:10pt;color:<?php echo $Fcolor;?>" align="center"><?php echo $Stud['seme_class'].sprintf('%02d',$Stud['seme_num']);?></td>
   		<td style="font-size:10pt;color:<?php echo $Fcolor;?>" align="center"><?php echo $Stud['logintimes'];?></td>
   		<td style="font-size:10pt;color:<?php echo $Fcolor;?>" align="center"><?php echo $Stud['lastlogin'];?></td>
   		<td style="font-size:10pt;color:<?php echo $Fcolor;?>" align="center"><?php echo $RR;?></td>
   		<td style="font-size:10pt;color:<?php echo $Fcolor;?>" align="center"><?php echo $CC;?></td>
   		<td style="font-size:10pt;color:<?php echo $Fcolor;?>" align="center"><?php echo get_teacher_name($teacher_sn);?></td>
   	</tr>	
   <?php	
   } // end while
   ?>
   </table>
    <table border="0" width="100%">
  		<tr>
  			<td><input type="button" value="�^�W�@��" onclick="document.myform.act.value='Start';document.myform.submit();"></td>
  		</tr>
  	</table>

   <?php
  }else{
  //��Lø�Ϥ���
  //���o�C�ӵ����ӥ����N�X
     $SCORE_SET_NUM=0;
     $query="select * from contest_score_setup where tsn='".$_POST['option1']."'";
     $result=mysql_query($query);
     if (mysql_num_rows($result)) {
      while ($row=mysql_fetch_array($result,1)) {
       $SCORE_SET_NUM++;
       $SCORE_FIELD[$SCORE_SET_NUM]=$row['sco_sn'];
      }	
     }
    if ($TEST['active']==2 or $TEST['active']==3) {
    ?>
     <input type="checkbox" name="show_small_pic" value="1" onclick="document.myform.act.value='score_upload';document.myform.submit()" <?php if ($_POST['show_small_pic']) echo "checked";?>><font color="#FF0000">�@�֧e�{�@�~�Y��</font>
     <input type="checkbox" name="hide_no_post" value="1" onclick="document.myform.act.value='score_upload';document.myform.submit()" <?php if ($_POST['hide_no_post']) echo "checked";?>><font color="#FF0000">���å��W�ǦW��</font>
    <?php
    } else {
     echo "<br>";
    }
  ?>
   
   <table border="1" style="border-collapse: collapse" bordercolor="#C0C0C0" cellpadding="1">
  <?php
   
  //�W�ǧ@�~��
  $t=0; //�H�ƭp��
   while ($Stud=mysql_fetch_array($result_stud,1)) {
    	 //�d�߬O�_�W��
    	 $query="select * from contest_record2 where tsn='".$TEST['tsn']."' and student_sn='".$Stud['student_sn']."'";
    	 $result_file=mysql_query($query);
    	 $N=mysql_num_rows($result_file);
    	 $Fcolor=($N>0)?"#0000FF":"#C0C0C0";
    	 if ($N>0) {
      	 $WORKS=mysql_fetch_array($result_file,1);
    	 }else{
    	 	if ($_POST['hide_no_post']) continue;
    	 	$CC="���W��";
    	 }
		
   	$t++;
   	//�����D
   	if ($t%10==1) table_title_1($TEST['tsn']);

    ?>
   	<tr class="mytr<?php echo $t%2;?>">
   		<td style="font-size:10pt;color:#800000" width="50" align="center"><?php echo $t;?></td>
   		<td style="font-size:10pt;color:<?php echo $Fcolor;?>" align="center"><?php echo $Stud['stud_id'];?></td>
   		<td style="font-size:10pt;color:<?php echo $Fcolor;?>" align="center"><?php echo $Stud['stud_name'];?></td>
   		<td style="font-size:10pt;color:<?php echo $Fcolor;?>" align="center"><?php echo $Stud['seme_class'].sprintf('%02d',$Stud['seme_num']);?></td>
   		<td style="font-size:10pt;color:<?php echo $Fcolor;?>" align="center">
   			<?php 
   			if ($N>0) { 
   			 if ($_POST['show_small_pic']) {
  	   		switch ($TEST['active']) {
  	   		  case '2':
  	   		  $a=explode(".",$WORKS['filename']);
  	   		  $filename_s=$a[0]."_s.".$a[1];
						?>
  	   		    <img src="<?php echo $UPLOAD_U[2].$filename_s; ?>" border="0"><br>
  	   		  <?php
  	   		  break;
  	   		  case '3':
  	   		   ?>
						<embed src="<?php echo $UPLOAD_U[3].$WORKS['filename'];?>" width=240 height=180 type=application/x-shockwave-flash Wmode="transparent"><br>
  	   		   <?php
  	   		  break;
  	   		  default:  	   		
  	   		} // end switch
   			 } // end if show_small_pic
   			?>
   			<a href="<?php echo $UPLOAD_U[$TEST['active']].$WORKS['filename'];?>" target="_blank">�[�ݭ��</a>
   			<?php } else { ?> 
   			   ���W�� 
   		  <?php }?>
   		</td>
   			<?php
   			for ($i=1;$i<=$SCORE_SET_NUM;$i++) {
   				$thisScore=0;
   				$query="select sco_num from contest_score_user where sco_sn='".$SCORE_FIELD[$i]."' and student_sn='".$Stud['student_sn']."' and teacher_sn='".$_SESSION['session_tea_sn']."'";
   				if ($row=mysql_fetch_row(mysql_query($query))) list($thisScore)=$row;
   				?>
   				 <td style="font-size:10pt;color:<?php echo $Fcolor;?>" align="center">
   				<?php
   			  //�ˬd���S���W��, �Y�S��, �h����ܪ��	
   				 if ($N>0) {
   			?>
   			<input type="text" name="s<?php echo $Stud['student_sn'];?>[<?php echo $SCORE_FIELD[$i];?>]" size="3" value="<?php echo $thisScore;?>"  onBlur="score_sum('<?php echo $Stud['student_sn'];?>');">
    		<?php
    		   }else{
         ?>
   			<input type="hidden" name="giveup[<?php echo $Stud['student_sn'].$i;?>]">-
        <?php 
     		   } // end if ($N>0)
   		   ?>
   		    </td>
   		   <?php
   	   } // end for �C�X�Ӷ�����
   	   //�`��
   	   $query="select score,prize_memo from contest_score_record2 where tsn='".$TEST['tsn']."' and student_sn='".$Stud['student_sn']."' and teacher_sn='".$_SESSION['session_tea_sn']."'";
   	    list($score,$prize_memo)=mysql_fetch_row(mysql_query($query));
				if ($N>0) { 
   		?>
   		<td style="font-size:10pt;color:<?php echo $Fcolor;?>" align="center">
   			<input type="text" name="score[<?php echo $Stud['student_sn'];?>]" value='<?php echo sprintf('%d',$score);?>' size="5" <?php if ($SCORE_SET_NUM>0) { echo "onBlur=\"score_sum('".$Stud['student_sn']."')\""; } ?>>
			</td>
   		<td style="font-size:10pt" align="center"><input type="text" name="prize_memo[<?php echo $Stud['student_sn'];?>]" value="<?php echo $prize_memo;?>" size="20"></td>
   			<?php
   			   } else { 
   			?> 
   			<td style="font-size:10pt;color:<?php echo $Fcolor;?>">-</td>
				<td style="font-size:10pt;color:<?php echo $Fcolor;?>" align="center">���v<input type="hidden" name="giveup[<?php echo $Stud['student_sn'];?>]">&nbsp</td>			
   			<?php 
   			} // end if $N>0 ���W�ǧ@�~
   			?>
   	</tr>	
  <?php 
   } // end while  
   ?>
  </table>
   <table border="0" width="100%">
  		<tr>
  			<td>
  			 <input type="button" value="�e�X����" onclick="document.myform.act.value='score_upload';document.myform.submit();" style="color:#FF0000">
         <input type="button" value="�^�W�@��" style="color:#FF00FF" onclick="document.myform.act.value='Start';document.myform.submit();">
  		   <?php echo $INFO;?>  			
  			</td>
  		</tr>
  	</table>

  <Script Language="JavaScript">
		//�����Ӷ����έp���
		function score_sum(STR) {
		var Num=<?php echo $SCORE_SET_NUM;?>;
  	var intSUM=0;
  	var i=0;
  	
  	var STR1='s'+STR;
   //�ǥͲӶ��έp
  	while (i < document.myform.elements.length)  {
    	if (document.myform.elements[i].name.substr(0,STR1.length)==STR1) {
      	intSUM=intSUM+document.myform.elements[i].value*1;
    	}
    	i++;
  	}

    //�`��
   	i =0;
    var STR2='score['+STR+']';
  	while (i < document.myform.elements.length)  {
    	if (document.myform.elements[i].name==STR2) {
      	document.myform.elements[i].value=intSUM;
    	}
    	i++;
  	}
  } // end fnction
	</Script>

   <?php
  } // end if $TEST['active']==1 else

} // end if act=score

//�����Y�ǥͪ��d��Ƥ���, �v��: $_POST['option1'] , �ǥ�: $_POST['option2']
if ($_POST['act']=='score_search') {

 $i=$_POST['n_student_sn'];
//�e�{�v�ɸ��
 $TEST=get_test_setup($_POST['option1']);
 title_simple($TEST);
 $STUD=get_student($_POST['option2']);  //�ǥ͸��

?>
  <input type="hidden" name="n_student_sn" value="">
  <input type="hidden" name="goto_next" value="">
  <table border="0" width="100%">
  	<tr>
  		<td style="colorL#FFCC66">�v�ɾǥ͡G<?php echo $STUD['class_name']." ".$STUD['seme_num']."�� ".$STUD['stud_name'];?> ���@���p�U...</td>
  	</tr>
  </table>
  <table border="1" width="100%" style="border-collapse: collapse" bordercolor="#C0C0C0" cellpadding="2">
	   <tr>
      	<td bgcolor="#FFCCCC" align="center" style="font-size:10pt" width="30">�D��</td>
        <td bgcolor="#FFCCCC" align="center" style="font-size:10pt">�D��</td>
        <td bgcolor="#FFCCCC" align="center" style="font-size:10pt" width="160">�Ѧҵ���</td>
        <td bgcolor="#FFCCCC" align="center" style="font-size:10pt" width="160">�ǥͧ@��</td>
        <td bgcolor="#FFCCCC" align="center" style="font-size:8pt" width="50">�W�s��</td>
        <td bgcolor="#FFCCCC" align="center" style="font-size:8pt" width="80">�@���ɶ�</td>
        <td bgcolor="#FFCCCC" align="center" style="font-size:10pt" width="80">����?</td>
      </tr>
      <?php
      $I=0;
      $query="SELECT a.* , b.question,b.ans,b.ans_url FROM contest_record1 AS a, contest_ibgroup AS b WHERE a.tsn=b.tsn and a.tsn='".$_POST['option1']."' and a.ibsn=b.ibsn and a.student_sn='".$_POST['option2']."' order by b.tsort";
      $result=mysql_query($query);
      while ($ITEM=mysql_fetch_array($result,1)) {
      	$I++;
      	if ($ITEM['ans']=='' or $ITEM['lurl']=='') $ITEM['chk']=-1;
      	?>
      <tr>
      	<td style="font-size:10pt" width="30" align="center" ><?php echo $I;?></td>
        <td style="font-size:10pt"><?php echo $ITEM['question'];?></td>
        <td style="font-size:10pt" width="180"><?php echo $ITEM['ans'];?></td>
        <td style="font-size:10pt" width="180"><?php echo $ITEM['myans'];?></td>
        <td style="font-size:10pt" width="50" align="center" ><?php if ($ITEM['lurl']!="") { ?><a href="<?php echo $ITEM['lurl'];?>" target="_blank">����</a><?php } ?></td>
        <td style="font-size:9pt" width="80" align="center" ><?php echo $ITEM['anstime']; ?></td>
        <td style="font-size:10pt" width="80">
        	<input type="radio" name="chk[<?php echo $ITEM['ibsn'];?>]" value="1" <?php if ($ITEM['chk']==1) { echo "checked"; } ?>>��
        	<input type="radio" name="chk[<?php echo $ITEM['ibsn'];?>]" value="-1" <?php if ($ITEM['chk']==-1) { echo " checked"; } ?>>��
        </td>
      </tr>
      <?php 
      }
      ?>
		</table>
  <table border="0" width="100%">
  		<tr>
  			<td style="color:#FF0000">
  				<input type="button" style="color:#FF0000" value="�Ȧs�������G" onclick="document.myform.n_student_sn.value='<?php echo $i;?>';document.myform.act.value='score_search_write';document.myform.submit()">
  				<input type="button" style="color:#FF0000" value="�x�s�����ø��U�@��" onclick="document.myform.n_student_sn.value='<?php echo $i+1;?>';document.myform.goto_next.value='1';document.myform.act.value='score_search_write';document.myform.submit()">
  				<input type="button" style="color:#FF00FF" value="��^�v�ɾǥͦC��" onclick="document.myform.act.value='score';document.myform.submit();">
  				<?php echo $INFO;?>
  				</td>
  		</tr>
  </table>
  <?php
} // end if act=score_search_write



//���w�o��
if ($_POST['act']=='prize') {
	?>
  <table border="0" width="100%">
  	<tr>
  		<td style="color:#0000FF">�D�v�ɵ����u�@ - ���w�o���ǥ�</tr>
  </table>
  <?php
//�e�{�v�ɸ��
 $TEST=get_test_setup($_POST['option1']);
 title_simple($TEST);

    if ($TEST['active']==2 or $TEST['active']==3) {
    ?>
     <input type="checkbox" name="show_small_pic" value="1" onclick="document.myform.act.value='prize_write';document.myform.submit()" <?php if ($_POST['show_small_pic']) echo "checked";?>><font color="#FF0000">�@�֧e�{�@�~�Y��</font>
     <input type="checkbox" name="hide_no_post" value="1" onclick="document.myform.act.value='score_upload';document.myform.submit()" <?php if ($_POST['hide_no_post']) echo "checked";?>><font color="#FF0000">���å��W�ǦW��</font>
    <?php
    } else {
     echo "<br>";
    }

?>
  <table border="1" style="border-collapse: collapse" bordercolor="#C0C0C0" cellpadding="1">
<?php	
  //���X�ǥ�
  $query="select a.*,b.stud_id,b.stud_name,c.seme_class,c.seme_num from contest_user a,stud_base b,stud_seme c,contest_setup d where a.tsn=d.tsn and c.seme_year_seme=d.year_seme and a.tsn='".$TEST['tsn']."' and a.ifgroup='' and a.student_sn=b.student_sn and b.student_sn=c.student_sn order by seme_class,seme_num";
  $result=mysql_query($query);
  $t=0;
   while ($Stud=mysql_fetch_array($result,1)) {
    	//��active ���}�B�z
    	//�d�����=============================================
    	if ($TEST['active']==1) {
    		
    	 //�ǥͤw�����O��
    	 $REC=get_stud_record1_info($TEST,$Stud['student_sn']);
    	 /***
    	 $query="select count(*) as num from contest_record1 where tsn='".$TEST['tsn']."' and student_sn='".$Stud['student_sn']."'";
    	 list($N)=mysql_fetch_row(mysql_query($query));
    	 $Fcolor=($N>0)?"#0000FF":"#C0C0C0";
     	 //�ǥͤw�����O��
     	 $chk_right=mysql_num_rows(mysql_query("select * from contest_record1 where tsn='".$TEST['tsn']."' and student_sn='".$Stud['student_sn']."' and chk=1"));
     	 $chk_none=mysql_num_rows(mysql_query("select * from contest_record1 where tsn='".$TEST['tsn']."' and student_sn='".$Stud['student_sn']."' and chk=0"));
     	 $chk_wrong=mysql_num_rows(mysql_query("select * from contest_record1 where tsn='".$TEST['tsn']."' and student_sn='".$Stud['student_sn']."' and chk=-1"));
   	 
    	 if ($chk_none==$N) {
    	 	$WORKS['score']="�|������";
    	 	$P=0;
    	  }else{
    	  $WORKS['score']="<font color=#FF0000>����".$chk_right."�D�A����".$chk_wrong."�D</font>";
    	  $P=1;	
    	 }
    	 ***/
    	 $Fcolor=($REC[0]>0)?"#0000FF":"#C0C0C0";
    	 $P=$REC[2]; //�������̤�����w�o��
    	 $WORKS['score']=$REC[3];
       $N=0;   //�D�@�~��, �ҥH�k�s, �קK�v�ɧ@�~��X�{�W�s�� �s���@�~
       $WORKS['prize_memo']=$REC[4];  //�̫�@���ɶ�
    	//�@�~��===============================================
    	}else{
    		/***
    	 $query="select a.*,AVG(b.score) as score from contest_record2 a,contest_score_record2 b where a.tsn=b.tsn and a.tsn='".$TEST['tsn']."' and a.student_sn=b.student_sn and a.student_sn='".$Stud['student_sn']."'";
    	 $result_file=mysql_query($query);
    	 	 $WORKS=mysql_fetch_array($result_file,1); //�|�Ψ� score ���
    	 	 $WORKS['score']=round($WORKS['score'],2);
      	 //���o���y
      	 $WORKS['prize_memo']=get_prize_memo($TEST['tsn'],$Stud['student_sn']); 
				 $P=$N=($WORKS['filename']=='')?0:1;      
				 ***/
    	 //�ǥͤw�����O�� return [0]�O�_�@��0,1 [1]�@�����p [2]�O�_����0�ε����H�� [3]�������Z
    	 $REC=get_stud_record2_info($TEST,$Stud['student_sn']);
    	 $P=$N=$REC[0];
    	 $WORKS['score']=sprintf("%3.2f",$REC[3])." ( ".$REC[2]." �ӵ���)";
			 $WORKS['prize_memo']=get_prize_memo($TEST['tsn'],$Stud['student_sn']); 
				if ($REC[4]=='' and $_POST['hide_no_post']==1) continue; 
      } // end if $TEST['active'] else
   	$t++;
   	//�����D
   	if ($t%10==1) table_title_2();
      ?>
   	<tr class="mytr<?php echo $t%2;?>" >
   		<td style="font-size:10pt;color:#800000" width="50" align="center"><?php echo $t;?></td>
   		<td style="font-size:10pt;color:#800000" align="center"><?php echo $Stud['stud_id'];?></td>
   		<td style="font-size:10pt;color:#800000" align="center"><?php echo $Stud['stud_name'];?></td>
   		<td style="font-size:10pt;color:#800000" align="center"><?php echo $Stud['seme_class'].sprintf('%02d',$Stud['seme_num']);?></td>
   		<td style="font-size:10pt;color:#800000" align="center">
   			<?php
   			 if ($_POST['show_small_pic']) {
  	   		switch ($TEST['active']) {
  	   		  case '2':
  	   		  $a=explode(".",$REC[4]);
  	   		  $filename_s=$a[0]."_s.".$a[1];
						?>
  	   		    <img src="<?php echo $UPLOAD_U[2].$filename_s; ?>" border="0"><br>
  	   		  <?php
  	   		  break;
  	   		  case '3':
  	   		   ?>
						<embed src="<?php echo $UPLOAD_U[3].$REC[4];?>" width=240 height=180 type=application/x-shockwave-flash Wmode="transparent"><br>
  	   		   <?php
  	   		  break;
  	   		  default:  	   		
  	   		} // end switch
   			 } // end if show_small_pic  		
   		
   		
   			echo $REC[1];
   			?>
   		</td>
   		<td style="font-size:10pt;color:#800000" align="center"><?php echo $WORKS['score'];?></td>
   		<td style="font-size:10pt;color:#800000" align="center"><?php if ($REC[2]>0) { ?><input type="text" name="prize_id[<?php echo $Stud['student_sn'];?>]" value="<?php echo $Stud['prize_id'];?>" size="3"><?php } ?></td>
   		<td style="font-size:10pt;color:#800000" align="center"><?php if ($REC[2]>0) { ?><input type="text" name="prize_text[<?php echo $Stud['student_sn'];?>]" value="<?php echo $Stud['prize_text'];?>" size="10"><?php } ?></td>
   		<td style="font-size:10pt;color:#800000"><?php echo $WORKS['prize_memo'];?></td>
   	</tr>	
    <?php
    
   } // end while
   ?>
  </table>
   <table border="0" width="100%">
  		<tr>
  			<td>
  			 <input type="button" value="�e�X�o���]�w" onclick="document.myform.act.value='prize_write';document.myform.submit();" style="color:#FF0000">
         <input type="button" value="��^�W�@��" onclick="document.myform.act.value='Start';document.myform.submit();"  style="color:#FF00FF">
  			 <?php echo $INFO;?>
  			</td>
  		</tr>
  		<tr>
  		 <td style="color:#0000FF">
  		 �������G<br>
  		 �@1.�o���Ǹ�:�Ω��Z���G�ɦW���e�{������, �O�d�ťժ�ܸӥͥ��o��, �N���|�e�{�X��.<br>
  		 �@2.�o���W��:��ڤW�e�{�������W��, �p�u�Ĥ@�W�B�ĤG�W�B�ĤT�W�v�Ρu�S�u�B�u���B�Χ@�v��.
  		 </td>
  		</tr>
  	</table>
<?php

} // end if act='prize'
?>
</form>


<?php
//�������D
function table_title_1($tsn) {
	?>
   	<tr bgcolor="#FFFFCC">
   		<td style="font-size:10pt;color:#800000" width="40" align="center">�Ǹ�</td>
   		<td style="font-size:10pt;color:#800000" width="60" align="center">�Ǹ�</td>
   		<td style="font-size:10pt;color:#800000" width="60" align="center">�m�W</td>
   		<td style="font-size:10pt;color:#800000" width="70" align="center">�Z�Ůy��</td>
   		<td style="font-size:10pt;color:#800000" width="70" align="center">�v�ɧ@�~</td>
     <?php
     $query="select * from contest_score_setup where tsn='".$tsn."'";
     $result=mysql_query($query);
     if (mysql_num_rows($result)) {
      while ($row=mysql_fetch_array($result,1)) {
      ?>
       <td style="font-size:10pt;color:#800000" width="80" align="center"><?php echo $row['sco_text'];?></td>
       <?php
      }	
     }
     
     ?>
   		<td style="font-size:10pt;color:#800000" width="60" align="center">�`���Z</td>
   		<td style="font-size:10pt;color:#800000" width="150" align="center">���y</td>
   	</tr>	
   	<?php
} // end function table_title_1

function table_title_2() {
	global $TEST;
	?>
   	<tr bgcolor="#FFFFCC">
   		<td style="font-size:10pt;color:#800000" width="40" align="center">�Ǹ�</td>
   		<td style="font-size:10pt;color:#800000" width="60" align="center">�Ǹ�</td>
   		<td style="font-size:10pt;color:#800000" width="60" align="center">�m�W</td>
   		<td style="font-size:10pt;color:#800000" width="80" align="center">�Z�Ůy��</td>
   		<td style="font-size:10pt;color:#800000" width="100" align="center">�v�ɧ@�~</td>
   		<td style="font-size:10pt;color:#800000" width="130" align="center">�������Z</td>
   		<td style="font-size:10pt;color:#800000" width="60" align="center">�o���Ǹ�</td>
   		<td style="font-size:10pt;color:#800000" width="100" align="center">�o���W��</td>
   		<?php 
   		 if ($TEST['active']==1) {
   		?>   		
   	    <td style="font-size:8pt;color:#800000" width="200" align="center">�̫�@���ɶ�</td>
   	    <?php
   	  } else {
   	   ?>
   	   <td style="font-size:10pt;color:#800000" width="200" align="center">���y</td>
   	   <?php
   	  }
   	    ?>
   	</tr>	
<?php
} // end function table_title_2
?>
