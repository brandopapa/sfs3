<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";

sfs_check();


//�q�X����
head("���ά��� - ���κ޲z");

$tool_bar=&make_menu($school_menu_p);

//�C�X���
echo $tool_bar;

//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();

//���o�Ҧ��Ǵ����, �C�~����ӾǴ�
$class_seme_p = get_class_seme(); //�Ǧ~��	
$class_seme_p=array_reverse($class_seme_p,1);

//�ثe��w�Ǵ�
$c_curr_seme=($_POST['c_curr_seme']!="")?$_POST['c_curr_seme']:sprintf('%03d%1d',$curr_year,$curr_seme);

//�ثe��w�~�šA100�������w
$c_curr_class=($_POST['c_curr_class']!="")?$_POST['c_curr_class']:"100";
$school_kind_name[100]="��~";

//���o�Ǵ����γ]�w
$SETUP=get_club_setup($c_curr_seme);
if ($SETUP['error'] and $_POST['mode']!='setting') $_POST['mode']='setup'; //�|���i�����]�w

//�w�]�����Ǵ�����
if ($CLUB['year_seme']=="") $CLUB['year_seme']=$c_curr_seme;

$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);
if ($module_manager!=1) {
 echo "��p , �z�S���L�޲z�v��!";
 exit();
}
//POST�ᤧ�ʧ@ ================================================================
if ($_POST['mode']=="update_club_name_start") {
	    $N=0;
      $query="select * from association where seme_year_seme='$c_curr_seme' and club_sn!=''";
      $res=mysql_query($query);
      while ($row=mysql_fetch_array($res)) {
      	$query="select club_name from stud_club_base where club_sn='".$row['club_sn']."'";
				$result=mysql_query($query);
				list($club_name)=mysql_fetch_row($result);
				//2013.08.29 �j�� addslashes 
				$query="update association set association_name='".AddSlashes($club_name)."' where sn='".$row['sn']."'";
				//$query="update association set association_name='".SafeAddSlashes($club_name)."' where sn='".$row['sn']."'";
			  //$query="update association set association_name='".$club_name."' where sn='".$row['sn']."'";
				if (mysql_query($query)) {
					$N++;
				} else {
				  echo "���~�o�ͤF�Iquery=$query";
				  exit();
				}	      	
      	
      } // end while
      $INFO="�`�@���s���J(�n��)�F $N ��ǥͪ����Φ��Z�������ΦW�١C<br>�Y�L���n, �����A���s�o�Ӱʧ@�C";
      $_POST['mode']="update_club_name";
}  



//�Ǵ���]�w ********************************************************************
if ($_POST['mode']=="setting") {
	
 $year_seme=$_POST['year_seme'];
 	$choice_sttime=$_POST['choice_sttime_date']." ".$_POST['choice_sttime_hour'].":".$_POST['choice_sttime_min'].":00";
	$choice_endtime=$_POST['choice_endtime_date']." ".$_POST['choice_endtime_hour'].":".$_POST['choice_endtime_min'].":00";
  $choice_num=$_POST['choice_num'];
  $choice_over=$_POST['choice_over'];
  if ($_POST['choice_over']=='0') { $choice_num=1; $_POST['choice_over']=1; }
  $choice_auto=$_POST['choice_auto'];
  $student_num=$_POST['student_num'];
  $show_score=$_POST['show_score'];
  $show_feedback=$_POST['show_feedback'];
  $show_teacher_feedback=$_POST['show_teacher_feedback'];
  $teacher_double=$_POST['teacher_double'];
  $multi_join=$_POST['multi_join'];
  $update_sn=$_SESSION['session_tea_sn'];
  //�ˬd��ƬO�_�w�إ�
  if (mysql_num_rows(mysql_query("select * from stud_club_setup where year_seme='$year_seme'"))==0) {
    mysql_query("insert into stud_club_setup (year_seme) values ('$year_seme')");
  }
  
	   $query="update stud_club_setup set choice_sttime='$choice_sttime',choice_endtime='$choice_endtime',choice_num='$choice_num',choice_over='$choice_over',choice_auto='$choice_auto',student_num='$student_num',show_score='$show_score',show_feedback='$show_feedback',show_teacher_feedback='$show_teacher_feedback',update_sn='$update_sn',teacher_double='$teacher_double',multi_join='$multi_join' where year_seme='$year_seme'";
     if (mysql_query($query)) {
		 
		  $INFO="�b".date("Y-m-d H:i:s")."�w�ק�F�i".getYearSeme($year_seme)."�j������]�w";
			//�N�ʧ@�אּsetup
			$_POST['mode']="setup";
			
	  }else{
	 	
		echo "�n�����εo�Ϳ��~! Query=".$query;
		exit();
   }
}
//�Τ@�]�w���γq�L���� ********************************************************************
if ($_POST['mode']=="setting_pass_score") {
	
 $year_seme=$_POST['c_curr_seme'];
 $pass_score=$_POST['pass_score'];

  //�ˬd��ƬO�_�w�إ�
  if (mysql_num_rows(mysql_query("select * from stud_club_setup where year_seme='$year_seme'"))==0) {
    mysql_query("insert into stud_club_setup (year_seme) values ('$year_seme')");
  }
  
	   $query="update stud_club_base set pass_score='$pass_score',update_sn='$update_sn' where year_seme='$year_seme'";
     if (mysql_query($query)) {
		  
		  $seme_club_num=get_seme_club_num($year_seme);
		 
		  $INFO="�b".date("Y-m-d H:i:s")."�w�ק�F�i".getYearSeme($year_seme)."�j�@�p".$seme_club_num."�Ӫ��Ϊ��q�L����, �����]�w�� ".$pass_score." ��!";
			//�N�ʧ@�אּsetup_pass_score
			$_POST['mode']="setup_pass_score";
			
	  }else{
	 	
		echo "�o�Ϳ��~! Query=".$query;
		exit();
   }
}


//�s�W���� ********************************************************************
if ($_POST['mode']=="inserting") {

	make_club_post(); //�N POST����s���ܼ�
	
	$club_name=$club_name;
	$club_memo=$club_memo;
	   
	   $query="insert into stud_club_base (year_seme,club_name,club_teacher,club_class,club_open,club_student_num,club_memo,club_location,update_sn,stud_boy_num,stud_girl_num,ignore_sex) values ('$year_seme','$club_name','$club_teacher','$club_class','$club_open','$club_student_num','$club_memo','$club_location','$update_sn','$stud_boy_num','$stud_girl_num','$ignore_sex')";
     if (mysql_query($query)) {
     		
     	list($club_sn)=mysql_fetch_row(mysql_query("SELECT LAST_INSERT_ID()"));
		 
		  $INFO="�b".date("Y-m-d H:i:s")."�w�s�W���Ρi".$club_name."�j";
			//�N�ʧ@�אּ��ܦ�����
			$_POST['mode']="list";
			$_POST['club_sn']=$club_sn;
			
	  }else{
	 	
		echo "�n�����εo�Ϳ��~! Query=".$query;
		exit();
		
	  }

}

//�����θ�� �ؼ�: $_SESSION['club_sn'] ,�קK POST�� sn ��ƳQ�ק�*************
if ($_POST['mode']=="updating") {
	
	make_club_post(); //�N POST����s���ܼ�
	
	$club_name=$club_name;
	$club_memo=$club_memo;
	   
	   $query="update stud_club_base set year_seme='$year_seme',club_name='$club_name',club_teacher='$club_teacher',pass_score='$pass_score',club_class='$club_class',club_open='$club_open',club_student_num='$club_student_num',club_memo='$club_memo',club_location='$club_location',update_sn='$update_sn',stud_boy_num='$stud_boy_num',stud_girl_num='$stud_girl_num',ignore_sex='$ignore_sex' where club_sn='".$_SESSION['club_sn']."'";
     if (mysql_query($query)) {
     		
		  $INFO="�b".date("Y-m-d H:i:s")."�s�ת��Ρi".$club_name."�j!";
			//�N�ʧ@�אּ��ܦ�����
			$_POST['mode']="list";
			$_POST['club_sn']=$_SESSION['club_sn'];
			
	  }else{
	 	
		echo "�s�ת��εo�Ϳ��~! Query=".$query;
		exit();
		
	  }

}

//��ʼW�[����******************************************************************
if ($_POST['mode']=="adding_members") {
	/*** 2012/06/22 �����ˬd, �w��b module.sql �w�ˮɧY�ˬd
	//��Ʈw association��ƪ� , ���� $_POST['club_sn']
	if (chk_if_exist_table("association")) {
		//�ˬd��� club_sn �O�_�s�b
		$query="select club_sn from association limit 1";
		if (!mysql_query($query)) {
      mysql_query("ALTER TABLE `association` ADD `update_sn` int(10) unsigned NOT NULL;");
      mysql_query("ALTER TABLE `association` ADD `club_sn` INT(10) UNSIGNED NOT NULL");
      mysql_query("ALTER TABLE `association` ADD `update_time` timestamp NOT NULL default CURRENT_TIMESTAMP");
		}
	}else{
	  create_table_association(); //�۰ʫإ߾ǥͪ����θ�ƪ�
	}
	***/
	 //�}�l�s�J�ǥ�
	$CLUB=get_club_base($_SESSION['club_sn']);
	$seme_year_seme=$CLUB['year_seme'];
  foreach ($_POST['selected_stud'] as $student_sn=>$name) {
  	//�ˬd�O�_�w���o�Ӿǥ�, �Y�L, �h�s�J
  	if (chk_if_exist_stud($CLUB['club_sn'],$student_sn)==0) {
     $query="insert into association (student_sn,seme_year_seme,association_name,score,description,club_sn) values ('$student_sn','".$CLUB['year_seme']."','".SafeAddSlashes($CLUB['club_name'])."','','','".$CLUB['club_sn']."')";
     $CONN->Execute($query) or trigger_error("SQL ���~",E_USER_ERROR);
    }
  } // end foreach
	$_POST['mode']="list";
	$_POST['club_sn']=$_SESSION['club_sn'];
	
}
//�R���Ŀ諸����******************************************************************
if ($_POST['mode']=="del_members") {
	$CLUB=get_club_base($_SESSION['club_sn']);
  foreach ($_POST['selected_stud'] as $student_sn) {
     $query="delete from  association where seme_year_seme='".$CLUB['year_seme']."' and club_sn='".$CLUB['club_sn']."' and student_sn='$student_sn'";
     $CONN->Execute($query) or trigger_error("SQL ���~",E_USER_ERROR);
  } // end foreach
	$_POST['mode']="list";
	$_POST['club_sn']=$_SESSION['club_sn'];
}
//�ƻs�W�Ǵ�������******************************************************************
if ($_POST['mode']=="copying") {
	//�̦U�~�Ū���
	$class_year_array=get_class_year_array(sprintf('%d',substr($last_seme,0,3)),sprintf('%d',substr($last_seme,-1)));
	$class_year_array[100]="100";
	
	foreach ($class_year_array as $club_class=>$VAL) { 
  	$POST_CLUB_KEY="copy_club_".$club_class;
   	$POST_STUD_KEY="copy_stud_".$club_class;

	 //���U��, �a�J $POST[$POST_CLUB_KEY];
  foreach ($_POST[$POST_CLUB_KEY] as $last_club_sn=>$val) {
    //$lsdt_club_sn  �n�ƻs������ club_sn
    $CLUB=get_club_base($last_club_sn);
    //�ഫ�ܼ�
    $year_seme=$c_curr_seme;
    $club_name=SafeAddSlashes($CLUB['club_name']);
    $club_teacher=$CLUB['club_teacher'];
    //�D��~�Ū���, �B�Ӫ��Ϊ��Ǵ��O����2�Ǵ�, �~�ť[1, 3�~�ũ�6�~�Ť����ѽƻs
    $club_class=(substr($CLUB['year_seme'],-1)=='2' and $CLUB['club_class']!='100')?$CLUB['club_class']+1:$CLUB['club_class'];
    $club_open=$CLUB['club_open'];
    $club_student_num=$CLUB['club_student_num'];
    $club_memo=SafeAddSlashes($CLUB['club_memo']);
    $club_location=$CLUB['club_location'];
    $update_sn=$_SESSION['session_tea_sn'];
    $stud_boy_num=$CLUB['stud_boy_num'];
    $stud_girl_num=$CLUB['stud_girl_num'];    

    $query="insert into stud_club_base (year_seme,club_name,club_teacher,club_class,club_open,club_student_num,club_memo,club_location,update_sn,stud_boy_num,stud_girl_num) values ('$year_seme','$club_name','$club_teacher','$club_class','$club_open','$club_student_num','$club_memo','$club_location','$update_sn','$stud_boy_num','$stud_girl_num')";
     if (mysql_query($query)) {
     	list($club_sn)=mysql_fetch_row(mysql_query("SELECT LAST_INSERT_ID()"));
	   } else {
	    echo "�ƻs���Υ���! query=$query";
	    exit();
	   }
    
    if ($_POST[$POST_STUD_KEY][$last_club_sn]==1) {
      //���o���ΩҦ��ǥ�
       $query="select a.student_sn from association a,stud_base b where a.club_sn='$last_club_sn' and a.student_sn=b.student_sn and (b.stud_study_cond=0 or b.stud_study_cond=2)";
       $res=mysql_query($query);
       if (mysql_num_rows($res)>0) {
        while ($row=mysql_fetch_array($res)) {
           if (chk_if_exist_stud($club_sn,$row['student_sn'])==0) {
           $query="insert into association (student_sn,seme_year_seme,association_name,score,description,club_sn) values ('".$row['student_sn']."','".$year_seme."','".$club_name."','','','".$club_sn."')";
           $CONN->Execute($query) or trigger_error("SQL ���~",E_USER_ERROR);
           } // end if         
        } // end while
       } // end if num_rows>0 
    } // end if $_POST['copy_stud'][$last_club_sn]==1 
    
  } // end foreach ($_POST[$POST_CLUB_KEY]
	
	} // end foreach $class_year_array 
	
  $_POST['mode']=='';
  
} // end if �ƻs����

//�R������******************************************************************
if ($_POST['mode']=="del_club") {
	$CLUB=get_club_base($_SESSION['club_sn']);
  //�R���ǥ͸��
  $query="delete from association where seme_year_seme='".$CLUB['year_seme']."' and club_sn='".$CLUB['club_sn']."'";
  $CONN->Execute($query) or trigger_error("SQL ���~",E_USER_ERROR);
  //�R���w����
  $query="delete from stud_club_temp where year_seme='".$CLUB['year_seme']."' and club_sn='".$CLUB['club_sn']."'";
  $CONN->Execute($query) or trigger_error("SQL ���~",E_USER_ERROR);
  //�R�����θ��
  $query="delete from stud_club_base where year_seme='".$CLUB['year_seme']."' and club_sn='".$CLUB['club_sn']."'";
  $CONN->Execute($query) or trigger_error("SQL ���~",E_USER_ERROR);
  $INFO="�w�R����".get_teacher_name($CLUB['club_teacher'])."���ɪ��i".$CLUB['club_name']."�j!";
	$_POST['mode']="";
	$_POST['club_sn']=$_SESSION['club_sn']="";
}
//=============================================================================

//�ˬd�O�_����w����
if ($_POST['club_sn']!="") $c_curr_class=get_club_class($_POST['club_sn']);

?>
<table bgcolor="#CCCCCC">
	<tr>
  <td>
<form name="myform" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<!-- mode �Ѽ� insert , update ,�b submit�e�i�� mode.value �ȭק� -->
	<input type="hidden" name="mode" value="">
	<input type="hidden" name="club_sn" value="">
<table border="0" width="100%">
	<tr>
		<!--�D�\���C(��󥪥k�����), ���� select �����Ǵ��Ψ�L�\�� -->
		<td width="100%">
		<select name="c_curr_seme" onchange="this.form.submit()">
			<?php
			while (list($tid,$tname)=each($class_seme_p)){
    	?>
    		<option value="<?php echo $tid;?>" <?php if ($c_curr_seme==$tid) echo "selected";?>><?php echo $tname;?></option>
   		<?php
    	} // end while
    	?>
    </select> 
		<input type="button" value="���Ǵ�����]�w" onclick="document.myform.mode.value='setup';document.myform.submit()">
		<input type="button" value="�s�W����" onclick="document.myform.mode.value='insert';document.myform.submit()">
		<input type="button" value="�Τ@�]�w�з�" onclick="document.myform.mode.value='setup_pass_score';document.myform.submit()">
		<input type="button" value="�����`��" onclick="document.myform.mode.value='listall';document.myform.submit()">
		<input type="button" value="�󥿦��Z�檺���ΦW��" onclick="document.myform.mode.value='update_club_name';document.myform.submit()">
		<?php
		//�ѩ��קK���~�ǥͦb�����ǭ������D, �u���ثe�Ǵ���ƻs�W�Ǵ�����
		if ($c_curr_seme==sprintf('%03d%1d',$curr_year,$curr_seme)) {
		?>
		<input type="button" value="�ƻs�W�Ǵ�����" onclick="document.myform.mode.value='club_copy';document.myform.submit()">
    <?php
    } //end if
    if ($SETUP['arrange_record']!='') {
    ?>
    <input type="button" value="�s�Z�O��" onclick="document.myform.mode.value='list_record';document.myform.submit()">
		<input type="button" value="�M���s�Z���" style="color:#0000FF" onclick="club_clear()">
    <?php
    }
    ?>
		<!--�Ĥ@�C����, �\����ᴣ�̫ܳ�ʧ@�T�� $INFO -->
	
		</td>
	</tr>
  </table>
	<table border="0" width="800">
	<tr>
	  <!--���C����, �Ǵ����ΦC�� -->
	  <td width="160" valign="top" style="color:#FF00FF;font-size:10pt">
	  	<select name="c_curr_class" onchange="document.myform.club_sn.value='';document.myform.mode.value='';document.myform.submit()">
	  		<optgroup style="color:#FF00FF" label="�п��..">
	  	<?php
			    $class_year_array=get_class_year_array(sprintf('%d',substr($c_curr_seme,0,3)),sprintf('%d',substr($c_curr_seme,-1)));
                foreach ($class_year_array as $K=>$class_year_name) {
                	?>
                	<option value="<?php echo $K;?>" style="color:#FF00FF;font-size:10pt" <?php if ($c_curr_class==$K) echo "selected";?>><?php echo $school_kind_name[$K];?>��(<?php echo get_club_num($c_curr_seme,$K);?>)</option>
                	<?php
                }	
			?>
									<option value="100" style="color:#FF00FF;font-size:10pt" <?php if ($c_curr_class=='100') echo "selected";?>>��~��(<?php echo get_club_num($c_curr_seme,100);?>)</option>
		</select>���ΦC��
			<?php
	  	//�ǤJ�Ѽ� 1001 , 1002 ��, �~�׾Ǵ�
	  	list_club_select($c_curr_seme,$c_curr_class);
	  	?>
	  </td>
	  <!--���C�������� -->
	  <!--�k�C����, �D�e�� -->
		<td valign="top" align="left">
		<?php
		if (isset($INFO)) {
		 echo "<font style='color:#FF0000;font-size:10pt'>$INFO</font><br>";
		}
		//������γ]�w ********************************************************************
		if ($_POST['mode']=="setup") {
	   	//
	   	echo "<font color='#800000'>�п�J�i".getYearSeme($c_curr_seme)."�j���Ϊ�����]�w:</font>";
			form_club_setup($c_curr_seme);
			?>
			<table border="0" width="100%">
	   	<tr>
	   		<td align="right"><input type="button" value="�T�w�ק�]�w" style="color:#FF0000" onclick="document.myform.mode.value='setting';document.myform.submit()"></td>
	   	</tr>
	   </table>

		<?php
		readme();
		}	 // end if setup
		//�Τ@�]�w���γq�L�з� ********************************************************************
		if ($_POST['mode']=="setup_pass_score") {
	   	echo "<font color='#800000'>���Τ@�q�w�i".getYearSeme($c_curr_seme)."�j������Ϊ��q�L�з�:</font>";
			?>
		<table border="0" width="100%">
			 <tr>
			   <td>�@�p<?php echo get_seme_club_num($c_curr_seme);?>�Ӫ��ΡA�п�J�q�L����<input type="text" name="pass_score" value="60" size="3"></td>
			 </tr>
			  <tr>
			   <td>�����G</td>
			  </tr>			  
 			  <tr>
			   <td>1.���\��O�N�Ҧ����ΦP�ɿ�J�Τ@���ơA�z���i�w��ӧO���ζi����ƽվ�C</td>
			  </tr>			  
 			  
 			  <tr>
			   <td>2.�ǥͰѥ[���ά��ʡA�Y�����������F���зǡA�h�L�k�o����λ{�ҡC</td>
			  </tr>			  
 			  <tr>
			   <td>3.�Y�Q�դ��ݻ{�ҡA�h�п�J 0 ���C</td>
			  </tr>
		</table>
			
		<table border="0" width="100%">
	   	<tr>
	   		<td><input type="button" value="�T�w�ק�" style="color:#FF0000" onclick="document.myform.mode.value='setting_pass_score';document.myform.submit()"></td>
	   	</tr>
	   </table>
  
		<?php
		}	 // end if setup		
		
		
		//���s�󥿦��Z�檺���ΦW��**********************************************************88*****
		if ($_POST['mode']=="update_club_name") {
	    $query="select * from association where seme_year_seme='$c_curr_seme' and club_sn!=''";
     	$res=mysql_query($query);
     	$N=mysql_num_rows($res);
     	?>
		 <table border="0" width="100%">
        <tr>
   			 <td>
     			���Ǵ��� <?php echo substr($c_curr_seme,0,3);?>�Ǧ~�ײ� <?php echo substr($c_curr_seme,3,1);?> �Ǵ�<br>
     			���Φ��Z��ƪ�, �@�t�� <?php echo $N;?> ��ǥ͸��, �䦨�Z�O���O�g�� SFS3 ���ά��ʼҲթҫإ�.<br>
     			�z�n���s���J(��)�ǥͰѥ[�����ΦW�ٶ�? <input type="button" value="�O, �Э��s���J" onclick="document.myform.mode.value='update_club_name_start';document.myform.submit();"><br>
     		<br>
     			<font color=blue>���G�p�G�z���g��ʹL���ΦW�١A�o�{�ǥͦ��Z��W�����ΦW�ٻP��ڤ��šA�N�������楻�{���i��󥿡C</font>
     		<br>
    		</td>
  		</tr>
  		<tr>
    		<td style="color:#FF0000"><br>
     		<?php echo $INFO;?>
    		</td>
  		</tr>
 		 </table>
    <?php	 
		} // end if update_club_name		 
		 
	  //��ܩҦ����γ]�w(�����`��) ================================================================
	  if ($_POST['mode']=="listall") {
	    listall_club($c_curr_seme);
	  }
	  //��ܬY���� ================================================================
	  if ($_POST['mode']=="list") {
	  	//�͵�����
			list_class_info($c_curr_seme,$c_curr_class);
				  	
	  	$_SESSION['club_sn']=$_POST['club_sn']; //�s�J SESSION
	  	
	  	list_club($_POST['club_sn']);	
	  	?>
	   <!-- �w���@���Ϊ��\��� -->
	   <table border="0" width="100%">
	   	<tr>
	   		<td >
	   			<input type="button" value="�s�ץ����ΰ򥻸��" style="color:#0000FF" onclick="club_update(<?php echo $_POST['club_sn'];?>)">
	   			<input type="button" value="��ʫ��w���ξǭ�" style="color:#0000FF" onclick="add_members(<?php echo $_POST['club_sn'];?>)">
	   			<input type="button" value="�R�������θ��" style="color:#0000FF" onclick="del_club(<?php echo $_POST['club_sn'];?>)">
	   		</td>
	   	</tr>
	   </table>	  	
	  	<?php  	
	  	//��ܥثe�����W��
	  	if (list_club_members($_POST['club_sn'])) {
	  	?>
	   <table border="0" width="100%">
	   	<tr>
	   		<td align="right">
	   			<input type="button" value="�R���Ŀ諸���ξǭ�" style="color:#FF0000" onclick="del_members(<?php echo $_POST['club_sn'];?>)">
	   		</td>
	   	</tr>
	   </table>	  	
	  	<?php
	    } // end if list_club_members
	  }
		//�s�W���μҦ� ==============================================================
		if ($_POST['mode']=="insert") {	   	
	   	//�C�X���, �ǤJ $CLUB array
	   	echo "<font color='#800000'>�п�J�s�W�i".getYearSeme($CLUB['year_seme'])."�j���Ϊ��򥻸��:</font>";
	   	//�H�U���w�]��
	   	$CLUB['club_class']=$_POST['c_curr_class'];
	   	$CLUB['club_student_num']=$SETUP['student_num'];
	   	$CLUB['stud_boy_num']=round($SETUP['student_num']/2);
	   	$CLUB['stud_girl_num']=$SETUP['student_num']-$CLUB['stud_boy_num'];
	   	$CLUB['club_open']=1;
	   	$CLUB['pass_score']=60;
	   	$CLUB['club_memo']='�����Φ��ߪ��D�n�ت���...�A�w�p�C��P�ǳ̲ׯ�o��...����O�C';
	     form_club($CLUB);
	  ?>
	   <table border="0" width="100%">
	   	<tr>
	   		<td align="right"><input type="button" value="�s�W�@�Ӫ���" style="color:#FF0000" onclick="document.myform.mode.value='inserting';check_before_club_post()"></td>
	   	</tr>
	   	<tr>
	   		<td style="color:#FF0000">���`�N! �p�G�O��~�Ū�����, ��ĳ�ϥΤ�ʤ覡���w�ǭ��C �p�G�}����, �h�b�s�Z�ɥ��i��s�Z���~�ŷ|���u���s�J�����p�C</td>
	   	</tr>
	   </table>
	   <Script language="JavaScript">
	     document.myform.club_name.focus();
	   </Script>
	  <?php
	  } // end if ($_POST['mode']=="insert") =======================================
	  	
	  //�s�ת��μҦ� ==============================================================
		if ($_POST['mode']=="update") {
			$CLUB=get_club_base($_POST['club_sn']);	   	
	   	//�C�X���, �ǤJ $CLUB array
	   	echo "<font color='#800000'>�п�J�s�סi".getYearSeme($CLUB['year_seme'])."�j���Ϊ��򥻸��:</font>";
	     form_club($CLUB);
	  ?>
	   <table border="0" width="100%">
	   	<tr>
	   		<td align="right"><input type="button" value="�T�w�ק糧���θ��" style="color:#FF0000" onclick="document.myform.mode.value='updating';check_before_club_post()"></td>
	   	</tr>
	   </table>
	   <Script language="JavaScript">
	     document.myform.club_name.focus();
	   </Script>
	  <?php
	  } // end if ($_POST['mode']=="insert") =======================================
	  
	 	//�ƻs�W�Ǵ����� =============================================================
	  if ($_POST['mode']=="club_copy") {
	  	$last_seme=($curr_seme==2)?sprintf('%03d%1d',$curr_year,1):sprintf('%03d%1d',$curr_year-1,2);
	   	
	  	?>
 	    �ƻs�i<?php echo getYearSeme($last_seme);?>�j�����θ�Ʀܡi<?php echo getYearSeme($c_curr_seme);?>�j:<br>
	  	<?php
		   if ($curr_seme==1) {
		   ?>
		   <br>
		   <table border="1" style="border-collapse:collapse" bordercolor="#FF0000" width="100%">
		    <tr>
		     <td>
		      ����:<br>
		      �W�Ǵ�����2�Ǵ�, �ƻs��U�~�Ū����η|�۰ʥ[1�Ӧ~��, ���ѩ�̰��~�Ū����ξǥͤw���~, �����ѽƻs�C�Y���ƻs�ǥ͸��, ��X�ǥͤ��|�ƻs�C
		     </td>
		    </tr>
		   </table>
		   <?php
		   }
			
			$class_year_array=get_class_year_array(sprintf('%d',substr($last_seme,0,3)),sprintf('%d',substr($last_seme,-1)));
			$class_year_array[100]="100";
			
			$Y[0]="�_";
	    $Y[1]="�O";

	    foreach ($class_year_array as $club_class=>$class_year_name) {
	    	
	    	$POST_CLUB_KEY="copy_club_".$club_class;
	    	$POST_STUD_KEY="copy_stud_".$club_class;
	    	
	    	//��1�Ǵ���, �̰��~�ťѩ�ǥͤw���~, ���L
	    	if (($club_class=='9' or $club_class=='6') and $curr_seme==1) continue;
	    	$query="select * from stud_club_base where year_seme='$last_seme' and club_class='$club_class' order by club_name";
				$result=mysql_query($query);
			  if (mysql_num_rows($result)) {
			  	
			  	echo "<br>��".$school_kind_name[$club_class]."�Ū���";
			  	
	    	?>
	    	<table border="1" style="border-collapse:collapse" bordercolor="#800000" cellpadding="3" width="100%">
			 	  <tr bgcolor="#FFCCFF">
			 	    <td width="50" style="font-size:10pt;color:#000000" align="center"><input type="checkbox" name="init_<?php echo $POST_CLUB_KEY;?>" value="1" onclick="check_copy('init_<?php echo $POST_CLUB_KEY;?>','<?php echo $POST_CLUB_KEY;?>');">���</td>
			 	    <td width="60" style="font-size:8pt;color:#000000" align="center"><input type="checkbox" name="init_<?php echo $POST_STUD_KEY;?>" value="1" onclick="check_copy('init_<?php echo $POST_STUD_KEY;?>','<?php echo $POST_STUD_KEY;?>');">�t�ǥ�</td>
			 	  	<td width="180" style="font-size:10pt;color:#000000">���ΦW��</td>
			 	  	<td width="60" style="font-size:10pt;color:#000000" align="center">���ɦѮv</td>
			 	  	<td width="60" style="font-size:10pt;color:#000000">�W�Ҧa�I</td>
			 	  	<td width="30" style="font-size:10pt;color:#000000" align="center">�W�B</td>
			 	  	<td width="50" style="font-size:9pt;color:#000000" align="center">�w�s�ǭ�</td>
			 	  	<td width="50" style="font-size:10pt;color:#000000" align="center">�i���</td>
			 	  </tr>		    	
	    	<?php
			  	  while ($row=mysql_fetch_array($result)) {
			 	   	$stud_number=get_club_student_num($row['year_seme'],$row['club_sn']);
			 	   	//�ˬd�O�_���Φb���Ǵ��w����
			 	   	$query="select * from stud_club_base where year_seme='$c_curr_seme' and club_teacher='".$row['club_teacher']."' and club_class='".$row['club_class']."' and club_name='".$row['club_name']."'";
			 	   	$res_double=mysql_query($query);
			 	   	$DOUBLE=(mysql_num_rows($res_double)>0)?1:0;
			 	    ?>
			 	  <tr>
			 	  	<?php
			 	  	 if ($DOUBLE) {
			 	  	?>
						<td style="color:#FF0000;font-size:10pt" align="center">�v�s�b</td>
			 	  	<td align="center">-</td>			 	  	
			 	  	<?php
			 	  	 } else {
			 	  	?>
			 	  	<td align="center"><input type="checkbox" name="<?php echo $POST_CLUB_KEY;?>[<?php echo $row['club_sn'];?>]" value="1"></td>
			 	  	<td align="center"><input type="checkbox" name="<?php echo $POST_STUD_KEY;?>[<?php echo $row['club_sn'];?>]" value="1"></td>
			 	  	<?php
			 	    }
			 	  	?>
			 	  	<td style="font-size:10pt;color:#000000"><?php echo $row['club_name'];?></td>
			 	  	<td style="font-size:10pt;color:#000000" align="center"><?php echo get_teacher_name($row['club_teacher']);?></td>
			 	  	<td style="font-size:10pt;color:#000000" align="center"><?php echo $row['club_location'];?></td>
			 	  	<td style="font-size:10pt;color:#000000" align="center"><?php echo $row['club_student_num'];?></td>
			 	  	<td style="font-size:10pt;color:#000000" align="center"><?php echo $stud_number[0];?> (<font color="#0000FF"><?php echo $stud_number[1];?></font>,<font color="#FF6633"><?php echo $stud_number[2];?></font>)</td>
			 	  	<td style="font-size:10pt;color:#000000" align="center"><?php echo $Y[$row['club_open']];?></td>
				  </tr>
				  	<?php		
				  } // end while	
				  ?>
				</table>
				  <?php
				  				    
			  } // if mysql_num_rows($result)	    	
      } // end foreach	
		 ?>
		 <table border="0" width="100%">
		   <tr>
		     <td><input type="button" value="�}�l�ƻs" onclick="document.myform.mode.value='copying';document.myform.submit();"></td>
		   </tr>
		 </table>
		 <?php
		} //end if club_copy

//
//�M���w�s�Z�W�� ********************************************************************
if ($_POST['mode']=="club_clear") {
	
 $year_seme=$_POST['c_curr_seme'];
 
 /*
		��Ҧ��}���ת��ΦW������M�� 
 */
  echo "�M��".$year_seme."���s�Z���! <br>";
  
 	$query="select * from stud_club_base where year_seme='$year_seme' and club_open=1 order by club_class";
 	$res=$CONN->Execute($query);
 	while ($row=$res->Fetchrow()) {
 	 $club_sn=$row['club_sn'];
 	 $club_name=$row['club_name'];
 	 $club_class=$row['club_class'];
 	 $sql="select * from association where club_sn='$club_sn' and seme_year_seme='$year_seme'";
 	 $res_stud=$CONN->Execute($sql);
 	 $stud_num=$res_stud->RecordCount();  //�H��
 	 $sql="delete from association where club_sn='$club_sn' and seme_year_seme='$year_seme'";
 	 $res_del=$CONN->Execute($sql) or die("�R������!");
	 echo $school_kind_name[$club_class]."�Ū��ΡG".$club_name."�A�w�s".$stud_num."�H =>�M�� <br>";
 	
 	}
  echo "�M���ǥͿ�����@�ǵ��O���!<br>";
  $sql="update stud_club_temp set arranged=0 where year_seme='$year_seme'";
	$res=$CONN->Execute($sql) or die("�M������!");  
  echo "�M���s�Z�O��!<br>";
  $sql="update stud_club_setup set arrange_record='' where year_seme='$year_seme'";
	$res=$CONN->Execute($sql) or die("�M������!");  

}

	 
	  	
	  //��ʫ��w�Y���ξǭ� ================================================================
	  if ($_POST['mode']=="add_members") {
	  	list_club($_POST['club_sn']);	
	  	list_students_select($_POST['club_sn']);
	  	?>
	   <!-- �w���@���Ϊ��\��� -->
	   <table border="0" width="100%">
	   	<tr>
	   		<td align="right"><input type="button" value="�T�w�s�W�Ŀ諸���ξǭ�" style="color:#FF0000" onclick="document.myform.mode.value='adding_members';document.myform.submit()"></td>
	   	</tr>
	   </table>	  	
	  	<?php  	
	  } // end if 
	  //��ܽs�Z�O��
	  if ($_POST['mode']=="list_record") {
	   
	    echo $SETUP['arrange_record'];
	    
	  }
		?>
	  </td>
	  <!--�k�C�������� -->
	</tr>
</table>
</form>
  </td>
	</tr>
</table>
<Script>
		function club_clear() {
			if_confirm=confirm('�z�T�w�n�M���Ҧ��s�Z��ơH\n�]�`�N�I���ʧ@�|�⥻�Ǵ��u�Ҧ��}���Ҫ����Ρv�W����ƲM���I�^');
			if (if_confirm) {
			 document.myform.mode.value='club_clear';
			 document.myform.submit();
			} else {
			 return false;
			}
		}		
</Script>