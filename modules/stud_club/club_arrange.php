<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";

sfs_check();


//�q�X����
head("���ά��� - ���νs�Z");

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
$c_curr_class=$_POST['c_curr_class'];
$CLASS_name=$school_kind_name[$c_curr_class]; //����A�p�@�~�A�G�~...

//���o�Ǵ����γ]�w
$SETUP=get_club_setup($c_curr_seme);


//�w�]�����Ǵ�����
if ($CLUB['year_seme']=="") $CLUB['year_seme']=$c_curr_seme;

$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);
if ($module_manager!=1) {
 echo "��p , �z�S���L�޲z�v��!";
 exit();
}
//POST�ᤧ�ʧ@ ================================================================
if ($_POST['mode']=='arrange') {

//�}�l�s�Z
  $c_curr_class=$_POST['c_curr_class']; //�~��
  //2013.09.10 ====[�Y�����\�P�ɰѥ[�h�Ӫ���, �w�Q��ʫ��w����, �o�]����Ϊ��ǥ�, ����ѻP�s�Z]============== 
  if ($SETUP['multi_join']==0) {
  	//���o���~�Ū��Ҧ��ǥ�
  	$query="select student_sn from stud_seme where seme_year_seme='$c_curr_seme' and seme_class like '".$c_curr_class."%%'";
  	$res=mysql_query($query);
  	while ($row=mysql_fetch_array($res,1)) {
  		$sql="select student_sn from association where seme_year_seme='$c_curr_seme' and student_sn='".$row['student_sn']."'";
  		$res_stud=mysql_query($sql);
  		//�Y�����
  		if (mysql_num_rows($res_stud)) {
  			//�v�@��� association �̬O�_�w���o�Ӿǥ�, �Y��, �N ��ҼȦs��Ƶ��O���w�s�Z , ������� arranged ��� , ���D�|���s�Z
  			$query="update stud_club_temp set arranged='1' where year_seme='$c_curr_seme' and student_sn='".$row['student_sn']."' and arranged='0'";  //
  			mysql_query($query);
  		}
  	} // end while  
  } // end if ($SETUP['multi_join']==0)
  //=========================================================================================================
  $RECORD="\n".date("Y-m-d H:i:s")."�i��".$school_kind_name[$c_curr_class]."�Žs�Z <br>"; //�s�Z�O��
  
  //���X�Ҧ����Ǵ��A���~�ťB�}���Ҫ�����
  $query="select * from stud_club_base where year_seme='$c_curr_seme' and (club_class='$c_curr_class' or club_class='100') and club_open='1' order by club_class,club_name";
  $result=mysql_query($query);
  //�H�}�C�O�����θ��
  $club_all=0; //�p��
  $club_for_this_class=0; //�i���ѵ����~�ſ�Ҫ����μ�,�Ω�̫Ḩ��̽s�Ƴ����A�u��s�J�Ӧ~�Ū����ΡA����s�J��~�Ū���
  while ($row=mysql_fetch_array($result)) {
  	$club_all++;
  	if ($row['club_class']==$c_curr_class) $club_for_this_class++;
    $club_sn[$club_all]=$row['club_sn'];
  	$club_name[$club_all]=$row['club_name'];
  	$club_student_num[$club_all]=$row['club_student_num']; //��$club_all���νs�Z�ݨD�`�W�B
  	$stud_boy_num[$club_all]=$row['stud_boy_num']; //��$club_all���νs�Z�ݨD�k�ͦW�B
  	$stud_girl_num[$club_all]=$row['stud_girl_num']; //��$club_all���νs�Z�ݨD�k�ͦW�B
  	$ignore_sex[$club_all]=$row['ignore_sex'];
  	//�w�s�Z���ǥͼ�
  	$stud_number=get_club_student_num($c_curr_seme,$row['club_sn']);
  	$club_arranged_stud_num[$club_all]=$stud_number[0]; //��$club_all���Υثe�`��
  	$club_arranged_boy_num[$club_all]=$stud_number[1]; //��$club_all���Υثe�k�ͼ�
  	$club_arranged_girl_num[$club_all]=$stud_number[2]; //��$club_all���Υثe�k�ͼ�
  }
  //�H���@�Ƕ]���νs�Z�A��Ӱj��
  //���@�j��
  for ($arr=1;$arr<=$SETUP['choice_num'];$arr++) {
    $RECORD.="<font color=red>��".$arr."���@�s�Z</font><br>";
    //���ΰj��
    for ($the_club=1;$the_club<=$club_all;$the_club++) {
    	$RECORD.="<font color=blue>����".$the_club."�G".$club_name[$the_club].", �v�s�W�B".$club_arranged_stud_num[$the_club]."/".$club_student_num[$the_club]."</font><br>";
    	if ($club_arranged_stud_num[$the_club]>=$club_student_num[$the_club]) {
    	  $RECORD.="�s�Z�W�B�w��<br>";
    	  continue;
    	} else {
    		
    	  //�}�l�w�惡���νs�Z
    	  if ($ignore_sex[$the_club]==0) {
    	  
    	  //1.�s�k�͡A�ˬd�b�����@��ܥ����Ϊ��k�ͼơA���S���j��ݨD�A��->�ζüƨ����A�S��->���J��
    	  if ($stud_boy_num[$the_club]>$club_arranged_boy_num[$the_club]) { //�k�ͤ����W�B, ���W�B�����p���`�Ѿl�W�B
    	    $query="select a.*,c.stud_sex from stud_club_temp a,stud_seme b,stud_base c where a.year_seme='$c_curr_seme' and b.seme_year_seme='$c_curr_seme' and a.club_sn='".$club_sn[$the_club]."' and a.choice_rank='$arr' and a.arranged='0' and a.student_sn=b.student_sn and b.seme_class like '".$c_curr_class."%%' and a.student_sn=c.student_sn and c.stud_sex=1";
    	    $need=(($stud_boy_num[$the_club]-$club_arranged_boy_num[$the_club])<=($club_student_num[$the_club]-$club_arranged_stud_num[$the_club]))?$stud_boy_num[$the_club]-$club_arranged_boy_num[$the_club]:$club_student_num[$the_club]-$club_arranged_stud_num[$the_club];
    	    arrange_run($the_club,$query,$need,"�k��");
    	  } // end if �k�ͤ����W�B
    	  //2.�s�k�͡A�ˬd�b�����@��ܥ����Ϊ��k�ͼơA���S���j��ݨD�A��->�ζüƨ����A�S��->���J��
				if ($stud_girl_num[$the_club]>$club_arranged_girl_num[$the_club]) { //�k�ͤ����W�B
    	    $query="select a.*,c.stud_sex from stud_club_temp a,stud_seme b,stud_base c where a.year_seme='$c_curr_seme' and b.seme_year_seme='$c_curr_seme' and a.club_sn='".$club_sn[$the_club]."' and a.choice_rank='$arr' and a.arranged='0' and a.student_sn=b.student_sn and b.seme_class like '".$c_curr_class."%%' and a.student_sn=c.student_sn and c.stud_sex=2";
    	    $need=(($stud_girl_num[$the_club]-$club_arranged_girl_num[$the_club])<=($club_student_num[$the_club]-$club_arranged_stud_num[$the_club]))?$stud_girl_num[$the_club]-$club_arranged_girl_num[$the_club]:$club_student_num[$the_club]-$club_arranged_stud_num[$the_club];
    	    arrange_run($the_club,$query,$need,"�k��");
    	  }
    	  
    	  } // end if ($ignore_sex==0) //�Y�����ʧO�]�w�� 0
    	  
    	  //3.�ˬd���Ǵ��A�����ΡA�����@�A�B�Ӧ~�� arranged=0 ���ǥͦ����ǤH,�����k�k, �ɨ��캡
				if ($club_student_num[$the_club]>$club_arranged_stud_num[$the_club]) { //�����W�B
    	    $query="select a.*,c.stud_sex from stud_club_temp a,stud_seme b,stud_base c where a.year_seme='$c_curr_seme' and b.seme_year_seme='$c_curr_seme' and a.club_sn='".$club_sn[$the_club]."' and a.choice_rank='$arr' and a.arranged='0' and a.student_sn=b.student_sn and b.seme_class like '".$c_curr_class."%%' and a.student_sn=c.student_sn";
    	    $need=$club_student_num[$the_club]-$club_arranged_stud_num[$the_club];
    	    arrange_run($the_club,$query,$need,"�����k�k");
    	  }
    	  /***
    	  $result=mysql_query($query);
    	  $the_choice_stud_num=mysql_num_rows($result); //�����@,�惡���ΤH��
    	  if ($the_choice_stud_num==0) {
    	    continue;
    	  }else{
    	  	//�H�}�C�O�U�ǥ� student_sn ,�ܼ� array=> the_choice_stud[]
    	  	$i=0; $arr_assign=0; //�����@�s�J�H��
    	    while ($row=mysql_fetch_array($result)) {
    	     $i++;
    	     $the_choice_stud[$i]=$row['student_sn'];   //���o���~�ť����@�惡���Ϊ��ǥ�
    	    } //end while
    	    
    	    if ($the_choice_stud_num<=$club_student_num[$the_club]-$club_arranged_stud_num[$the_club]) {
    	    	//�H�Ƥp��Ѿl�W�B�A���ƤJ��A�_�h���ü�
    	       for ($i=1;$i<=$the_choice_stud_num;$i++) {
    	            if (choice_this_stud($c_curr_seme,$club_sn[$the_club],$club_name[$the_club],$the_choice_stud[$i],$arr)) {
     	               $club_arranged_stud_num[$the_club]++; //���\�s�Z, �H�ƥ[1  ,��ǥ͹w��Ҧ����@�� arranged =1 ,�U�@���~���|�Q�s�Z
     	               echo get_stud_name($the_choice_stud[$i])." ";
     	               $arr_assign++;
    	            }    	           
    	       } // end for
    	    }else{
    	    	//�H�üƨM�w
    	    	for ($i=1;$i<=$the_choice_stud_num;$i++) {
    	    	  $stud_choiced[$i]=0; //�O�_�w�Q�諸����
    	    	}
    	    	$target_num=$club_student_num[$the_club]-$club_arranged_stud_num[$the_club];//�ؼФH��
    	    	$count_num=0; //�p�Ƥw��쪺�H��
    	    	do {
    	    	  //���ü�
    	    	  $R=rand(1,$the_choice_stud_num);
    	    	  if ($stud_choiced[$R]==0) {
    	    	  	$stud_choiced[$R]=1;
    	    	  	$count_num++;
    	    	  	if (choice_this_stud($c_curr_seme,$club_sn[$the_club],$club_name[$the_club],$the_choice_stud[$R],$arr)) {
    	    	  	  $club_arranged_stud_num[$the_club]++; //���\�s�Z, �H�ƥ[1  
    	    	  	  echo get_stud_name($the_choice_stud[$R])." ";
    	    	  	  $arr_assign++;
    	    	  	}  // function ���@�T�{�J��
    	    	  } //end if    	    	  
    	    	} while ($count_num<$target_num); //end while
    	    	
    	    } // end if $the_choice_stud_num<=$club_student_num[$the_club]-$club_arranged_stud_num[$the_club]
    	    echo "<font color=red>==>�����k�k, �s�J".$arr_assign."�H</font>";
    	  } // end if $the_choice_stud_num==0 �O�_���ǥͿ�o�Ӫ��� 3.�����k�k
    	  ***/
    	} // enf if �s�Z�H�Ƥw��
    	$RECORD.="<br>";
   } // end for the_club
  } // end for ���@��
  
  //�C�X�ثe�w�s���� **debug��******************************************
  //for ($the_club=1;$the_club<=$club_all;$the_club++) {
  // echo $club_name[$the_club]." �ݨD: �`".$club_student_num[$the_club]."�k".$stud_boy_num[$the_club]." �k".$stud_girl_num[$the_club]." ; �w�s:�`".$club_arranged_stud_num[$the_club]." �k".$club_arranged_boy_num[$the_club]." �k".$club_arranged_girl_num[$the_club]."<br>";
  //}
  //********************************************************************
  //�ˬd����Υ���Ҫ̬O�_�۰ʽs�Z
  if ($_POST['choice_auto']==1) {
  $RECORD.="<br>�ˬd����W��<br>";
  check_choice_not_arrange(); //�o������ܼ� $student_not_choice[$seme_class][$seme_num]
   foreach ($student_choice_not_arrange as $class=>$STUDENT) {
		 	  $RECORD.="<br><font color='#0000FF'>��".$CLASS_name.sprintf('%d',substr($class,1,2))."�Z ���Ƹ���W��G<br>";
		 	  $RECORD.="<table border=0>";
		 	  	 foreach ($STUDENT as $num=>$student_sn) {
							 $RECORD.="<tr><td style='font-size:10pt'>";
							 $RECORD.=$num.get_stud_name($student_sn);
							 $stud_choice_all=get_stud_choice($c_curr_seme,$student_sn);
							 foreach ($stud_choice_all as $K=>$my_club_sn) {
							   $C=get_club_base($my_club_sn);
								  $RECORD.=" ".$K.".".$C['club_name'];  	
								}
							//�s�Z
							$arr_ok=0;  $RAND=0;
							do {
    	    	  //���ü�
    	    	  $R=rand(1,$club_for_this_class); //�ȭ����~�Ū�����
    	    	  $RAND++;
    	    	  
    	    	  //�k�ͦ��ѦW�B
    	    	  if ($arr_ok==0 and $student_choice_not_arrange_sex[$class][$num]==2 and $stud_girl_num[$R]>$club_arranged_girl_num[$R] and $club_student_num[$R]>$club_arranged_stud_num[$R]) {
    	    	  	if (choice_this_stud($c_curr_seme,$club_sn[$R],$club_name[$R],$student_sn,0)) {
    	    	  	  $club_arranged_stud_num[$R]++; //���\�s�Z, �H�ƥ[1  
     	    	  	  if ($student_choice_not_arrange_sex[$class][$num]==1) $club_arranged_boy_num[$R]++;
     	            if ($student_choice_not_arrange_sex[$class][$num]==2) $club_arranged_girl_num[$R]++; 
    	    	  	  $RECORD.="==>�k".$club_arranged_boy_num[$R].",�k".$club_arranged_girl_num[$R].",�s�J(�k) ".$club_name[$R];
    	    	  	  $arr_ok=1;
    	    	  	} // function ���@�T�{�J��
    	    	  } //end if    	    	  
    	    	  
    	    	  //�k�ͦ��ѦW�B
    	    	  if ($arr_ok==0 and $student_choice_not_arrange_sex[$class][$num]==1 and $stud_boy_num[$R]>$club_arranged_boy_num[$R] and $club_student_num[$R]>$club_arranged_stud_num[$R]) {
    	    	  	if (choice_this_stud($c_curr_seme,$club_sn[$R],$club_name[$R],$student_sn,0)) {
    	    	  	  $club_arranged_stud_num[$R]++; //���\�s�Z, �H�ƥ[1  
     	    	  	  if ($student_choice_not_arrange_sex[$class][$num]==1) $club_arranged_boy_num[$R]++;
     	            if ($student_choice_not_arrange_sex[$class][$num]==2) $club_arranged_girl_num[$R]++; 
    	    	  	  $RECORD.="==>�k".$club_arranged_boy_num[$R].",�k".$club_arranged_girl_num[$R].",�s�J(�k) ".$club_name[$R];
    	    	  	  $arr_ok=1;
    	    	  	} // function ���@�T�{�J��
    	    	  } //end if    	    	  
    	    	  
    	    	  //�����k�k , �]�F50��, ���S���ʧO�ŦX�i���J, �h�����k�k, �����w��
    	    	  if ($RAND>50 and $arr_ok==0 and $club_student_num[$R]>$club_arranged_stud_num[$R]) {
    	    	  	if (choice_this_stud($c_curr_seme,$club_sn[$R],$club_name[$R],$student_sn,0)) {
    	    	  	  $club_arranged_stud_num[$R]++; //���\�s�Z, �H�ƥ[1  
     	    	  	  if ($student_choice_not_arrange_sex[$class][$num]==1) $club_arranged_boy_num[$R]++;
     	            if ($student_choice_not_arrange_sex[$class][$num]==2) $club_arranged_girl_num[$R]++; 
    	    	  	  $RECORD.="==>�k".$club_arranged_boy_num[$R].",�k".$club_arranged_girl_num[$R].",�s�J ".$club_name[$R];
    	    	  	  $arr_ok=1;
    	    	  	} // function ���@�T�{�J��
    	    	  } //end if    	    	  
    	    	  
    	    	} while ($arr_ok==0); //end while					
								
							 $RECORD.="</td></tr>";
		 	  	 }
		 	  	 $RECORD.="</table>";	 	  	
		  }

 //�ˬd�Ѿl����
   check_arrange(); //�o������ܼ� $student_not_choice[$seme_class][$seme_num]����ҦW��
      foreach ($student_not_choice as $class=>$STUDENT) {
		 	  $RECORD.="<br><font color='#0000FF'>��".$CLASS_name.sprintf('%d',substr($class,1,2))."�Z ����ҦW��G<br>";
		 	  $RECORD.="<table border='0'><tr><td style='font-size:10pt'>";
		 	  	 foreach ($STUDENT as $num=>$student_sn) {
							 $RECORD.=$num.get_stud_name($student_sn);
							//�s�Z
							$arr_ok=0; $RAND=0;
							do {
    	    	  //���ü�
    	    	  $R=rand(1,$club_for_this_class); //�ȭ����~�Ū�����
    	    	  $RAND++;
    	    	  //�k�ͦ��ѦW�B
    	    	  if ($arr_ok==0 and $student_not_choice_sex[$class][$num]==2 and $stud_girl_num[$R]>$club_arranged_girl_num[$R] and $club_student_num[$R]>$club_arranged_stud_num[$R]) {
    	    	  	if (choice_this_stud($c_curr_seme,$club_sn[$R],$club_name[$R],$student_sn,0)) {
    	    	  	  $club_arranged_stud_num[$R]++; //���\�s�Z, �H�ƥ[1  
     	    	  	  if ($student_not_choice_sex[$class][$num]==1) $club_arranged_boy_num[$R]++;
     	            if ($student_not_choice_sex[$class][$num]==2) $club_arranged_girl_num[$R]++; 
    	    	  	  $RECORD.="==>�k".$club_arranged_boy_num[$R].",�k".$club_arranged_girl_num[$R].",�s�J(�k) ".$club_name[$R]."<br>";
    	    	  	  $arr_ok=1;
    	    	  	} // function ���@�T�{�J��
    	    	  } //end if    	    	  
    	    	  
    	    	  //�k�ͦ��ѦW�B
    	    	  if ($arr_ok==0 and $student_not_choice_sex[$class][$num]==1 and $stud_boy_num[$R]>$club_arranged_boy_num[$R] and $club_student_num[$R]>$club_arranged_stud_num[$R]) {
    	    	  	if (choice_this_stud($c_curr_seme,$club_sn[$R],$club_name[$R],$student_sn,0)) {
    	    	  	  $club_arranged_stud_num[$R]++; //���\�s�Z, �H�ƥ[1  
     	    	  	  if ($student_not_choice_sex[$class][$num]==1) $club_arranged_boy_num[$R]++;
     	            if ($student_not_choice_sex[$class][$num]==2) $club_arranged_girl_num[$R]++; 
    	    	  	  $RECORD.="==>�k".$club_arranged_boy_num[$R].",�k".$club_arranged_girl_num[$R].",�s�J(�k) ".$club_name[$R]."<br>";
    	    	  	  $arr_ok=1;
    	    	  	} // function ���@�T�{�J��
    	    	  } //end if    	    	  
    	    	  
    	    	  //�����k�k, �]�F100��, ���S���ʧO�ŦX�i���J, �h�����k�k, �����w��
    	    	  if ($RAND>100 and $arr_ok==0 and $club_student_num[$R]>$club_arranged_stud_num[$R]) {
    	    	  	if (choice_this_stud($c_curr_seme,$club_sn[$R],$club_name[$R],$student_sn,0)) {
    	    	  	  $club_arranged_stud_num[$R]++; //���\�s�Z, �H�ƥ[1  
     	    	  	  if ($student_not_choice_sex[$class][$num]==1) $club_arranged_boy_num[$R]++;
     	            if ($student_not_choice_sex[$class][$num]==2) $club_arranged_girl_num[$R]++; 
    	    	  	  $RECORD.="==>�k".$club_arranged_boy_num[$R].",�k".$club_arranged_girl_num[$R].",�s�J".$club_name[$R]."<br>";
    	    	  	  $arr_ok=1;
    	    	  	} // function ���@�T�{�J��
    	    	  } //end if    	    	  
    	    	  
    	    	} while ($arr_ok==0); //end while					
	  	  	 } // end foreach
		 	  	$RECORD.="</td></tr></table>";
		 	  	
		  }
  } // end if choice_auto==1
  
  $Write_Record=addslashes($RECORD."<br>".$SETUP['arrange_record']);
  $query="update stud_club_setup set arrange_record='$Write_Record' where year_seme='$c_curr_seme'";
  if (mysql_query($query)) {
  	?>
  	<table border="0" width="100%">
  	 <tr>
  	  <td valign="top" >
  	  <?php
  	  echo $RECORD;
  	  ?>
  	  </td>
  	 </tr>
  	</table>
  	<?php   
  } else {
  	echo "�g�J�s�Z�O������!";
  	exit();
  }
 exit();
}




//�_�l�e��
?>
<form name="myform1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<!-- mode �Ѽ� -->
	<input type="hidden" name="mode" value="">
	<input type="hidden" name="club_class" value="">

<table border="0" width="100%">
<tr>
	<!-- ���e�� -->
  <td colspan="2" >��ܽs�Z�~��
	  	<select name='c_curr_class' onchange="document.myform1.submit()">
	  		<option value="" style="color:#FF00FF">�п��..</option>
	  	<?php
			    $class_year_array=get_class_year_array(sprintf('%d',substr($c_curr_seme,0,3)),sprintf('%d',substr($c_curr_seme,-1)));
                foreach ($class_year_array as $K=>$class_year_name) {
                	if (get_club_num($c_curr_seme,$K)) {
                	?>
                	<option value="<?php echo $K;?>" style="color:#FF00FF;font-size:10pt" <?php if ($_POST['c_curr_class']==$K) echo "selected";?>><?php echo $school_kind_name[$K];?>��(<?php echo get_club_num($c_curr_seme,$K);?>)</option>
                	<?php
                  }
                }	
			?>
		</select>
		
	</td>
  </tr>
	<tr>
		<td width="650" valign="top">
		<?php
		if (isset($_POST['c_curr_class'])) {
			
			?>
			<font color="#0000FF">��<?php echo $CLASS_name;?>�Ū��ΦC��P�ثe��񱡧�</font>
			<?php
		  list_class_club_choice_detail($c_curr_seme,$c_curr_class,1,1); //�C�X�~�Ū��ο�ҩ���
		  ?>
		  <font color="#0000FF">�������~�Ū��ΦC��P�ثe��񱡧�</font>
		  <?php
		  list_class_club_choice_detail($c_curr_seme,'100',1,1); //�C�X�~�Ū��ο�ҩ���
		}
		?>
  </td>
  <!-- �k�e�� -->

  <td valign="top">
  	<?php
  	if (isset($_POST['c_curr_class'])) {
  	?>
  	<font color="#0000FF">��<?php echo $CLASS_name;?>�Ū��ξǥͩ���</font>
  	<?php
  	   //�C�X�ǥ��`�ơA�w��Ҿǥ͡A����Ҿǥ͡]���t�w�s�Z�ǥ͡^�A�w�s�Z�ǥ͡A���s�Z�ǥ�
  	   //�\���G�}�l�s�Z�A�C�X���s�Z�ǥ�
  	   //�}�l�s�Z�ɡA�w�s�Z�ǥͱN���|�A�ʡA�C�X�Ŀﶵ�� club_choice_auto , �O�_�۰ʧ⥼��Ҿǥͽs�J�Z��
  	 
  	 //�˴��~�Žs�Z���ΡA�����Υ����ܼƳB�z
     check_arrange();
     
  	?>
  	<table border="1" style="border-collapse:collapse" bordercolor="#800000" width="250">
  	  <tr>
  	  	<td style="font-size:10pt;color:#0000FF" width="120" bgcolor="#CCFFFF">���~�ŤH��</td><td align="center"><?php echo $CLASS_num;?></td>
  	  </tr>	
  	  <tr>
  	  	<td style="font-size:10pt;color:#0000FF" width="120" bgcolor="#CCFFFF">�w��ҤH��</td><td align="center"><?php echo $CLASS_choiced;?></td>
  	  </tr>
   	  <tr>
  	  	<td style="font-size:10pt;color:#0000FF" width="120" bgcolor="#CCFFFF">�w�s�Z�H��</td><td align="center"><?php echo $CLASS_arranged;?></td>
  	  </tr>	
  	  <tr>
  	  	<td style="font-size:10pt;color:#0000FF" width="120" bgcolor="#CCFFFF">���s�Z�H��</td><td align="center"><?php echo $CLASS_not_arranged;?></td>
  	  </tr>	
  	  <tr>
  	  	<td style="font-size:10pt;color:#0000FF" width="120" bgcolor="#CCFFFF">����ҤH��<br>(���t�w�s�Z��)</td><td style="color:#FF0000" align="center"><?php echo $CLASS_not_choiced;?></td>
  	  </tr>	
  	</table>
  	<?php
  	//�i��Үɬq �ɤ�����~ 2012-06-01 12:12:00
		$StartSec=date("U",mktime(substr($SETUP['choice_sttime'],11,2),substr($SETUP['choice_sttime'],14,2),0,substr($SETUP['choice_sttime'],5,2),substr($SETUP['choice_sttime'],8,2),substr($SETUP['choice_sttime'],0,4)));
		$EndSec=date("U",mktime(substr($SETUP['choice_endtime'],11,2),substr($SETUP['choice_endtime'],14,2),0,substr($SETUP['choice_endtime'],5,2),substr($SETUP['choice_endtime'],8,2),substr($SETUP['choice_endtime'],0,4)));
		$nowsec=date("U",mktime(date("H"),date("i"),0,date("n"),date("j"),date("Y")));
		 if ($EndSec>$nowsec) {
	  		echo "<font color=red>��Ҭ��ʩ|�b�i��A�L�k�i��s�Z!!</font>";
		 } else {
			//���Ѫ��W�B�O�_���H�s�Z
			 if ($CLASS_not_arranged <= $club_for_stud_num) {
		   	?>
		  	<br>
			  <font color="#FF0000"><input type="checkbox" name="choice_auto" value="1"<?php if ($SETUP['choice_auto']==1) echo " checked";?>>�̫Ḩ��̩Υ���Ҫ̦۰ʽs�Z</font><br>
			  <input type="button" value="�}�l�s�Z" onclick="confirm_start()">
			  <?php
		   } else {
		    echo "<font color=red>�ݨD�H��: $CLASS_not_arranged , ��ڥi�ѽs�Z�H�� : $club_for_stud_num , �L�k�s�Z�C</font>";  
		   }
		 
		} 	
		//
		  foreach ($student_not_choice as $class=>$STUDENT) {
		 	  echo "<br><font color='#0000FF'>��".$CLASS_name.sprintf('%d',substr($class,1,2))."�Z ����ҦW��G<br>";
		 	  ?>
		 	  <table border="0" width="250">
		 	  	<?php
		 	  	$i=0;
		 	  	 foreach ($STUDENT as $num=>$student_sn) {
							$i++;
							if ($i%4==1) echo "<tr>";
							 echo "<td style='font-size:10pt'>".get_stud_name($student_sn)."</td>";
							if ($i%4==0) echo "</tr>";
		 	  	 }
		 	  	?>
		 	  </table>
		 	  <?php
		 	
		  }

  	
    } // end if 
  	?>
  </td>
</tr>
</table>
</form>
<form name="myform" method="post" action="club_manage.php">
	<!-- mode �Ѽ� -->
	<input type="hidden" name="mode" value="">
	<input type="hidden" name="club_sn" value="">
</form>


<Script language="JavaScript">
	function confirm_start() {
	 is_arrange=confirm('�z�T�w�n�i��<?php echo $CLASS_name;?>�Ū����νs�Z�H\n\n���`�N�I�нT�w�Ҧ���Ƴ]�w�ҥ��T�L�~�A�s�Z�L�{�u�|�w�良�s�Z���ǥͶi��s�Z�A�Y�w�s�Z���ǥͤ��������ʡC\n\n�s�Z�L�{�̦U�դH��, �i��|���I�[, �Э@�ߵ��ԡC');
	 if (is_arrange) {
	 	document.myform1.mode.value="arrange";
	 	document.myform1.submit();
	 }else{
	  return false;
	 }
	}
</Script>

<?php
//�Ѽ� $query(sql���O),$NEED(�̤j�ݨD�H��),$limit(���󻡩�)
function arrange_run($the_club,$query,$NEED,$limit) {
   //echo "�s�Z�Ѽ�:".$query."<br>";
   global $c_curr_seme,$club_arranged_stud_num,$club_arranged_boy_num,$club_arranged_girl_num,$club_sn,$club_name,$arr;
    
   global $RECORD;
   
     	  $result=mysql_query($query);
    	  $the_choice_stud_num=mysql_num_rows($result); //�����@,�惡���ΤH��
    	  if ($the_choice_stud_num>0) {
    	    
    	  	//�H�}�C�O�U�ǥ� student_sn ,�ܼ� array=> the_choice_stud[]
    	  	$i=0; $arr_assign=0; //�����@�s�J�H��
    	    while ($row=mysql_fetch_array($result)) {
    	     $i++;
    	     $the_choice_stud[$i]=$row['student_sn'];   //���o���~�ť����@�惡���Ϊ��ǥ�
    	     $the_choice_stud_sex[$i]=$row['stud_sex'];    	     
    	    } //end while
    	    
    	    if ($the_choice_stud_num<=$NEED) {
    	    	//�H�Ƥp��Ѿl�W�B�A���ƤJ��A�_�h���ü�
    	       for ($i=1;$i<=$the_choice_stud_num;$i++) {
    	            if (choice_this_stud($c_curr_seme,$club_sn[$the_club],$club_name[$the_club],$the_choice_stud[$i],$arr)) {
     	               $club_arranged_stud_num[$the_club]++; //���\�s�Z, �H�ƥ[1  ,��ǥ͹w��Ҧ����@�� arranged =1 ,�U�@���~���|�Q�s�Z
     	               if ($the_choice_stud_sex[$i]==1) $club_arranged_boy_num[$the_club]++;
     	               if ($the_choice_stud_sex[$i]==2) $club_arranged_girl_num[$the_club]++;
     	               $RECORD.= get_stud_name($the_choice_stud[$i])." ";
     	               $arr_assign++;
    	            }    	           
    	       } // end for
    	    }else{
    	    	//�H�üƨM�w
    	    	for ($i=1;$i<=$the_choice_stud_num;$i++) {
    	    	  $stud_choiced[$i]=0; //�O�_�w�Q�諸����
    	    	}
    	    	$target_num=$NEED;//�ؼФH��
    	    	$count_num=0; //�p�Ƥw��쪺�H��
    	    	do {
    	    	  //���ü�
    	    	  $R=rand(1,$the_choice_stud_num);
    	    	  if ($stud_choiced[$R]==0) {
    	    	  	$stud_choiced[$R]=1;
    	    	  	$count_num++;
    	    	  	if (choice_this_stud($c_curr_seme,$club_sn[$the_club],$club_name[$the_club],$the_choice_stud[$R],$arr)) {
    	    	  	  $club_arranged_stud_num[$the_club]++; //���\�s�Z, �H�ƥ[1 
    	    	  	  if ($the_choice_stud_sex[$R]==1) $club_arranged_boy_num[$the_club]++;
     	            if ($the_choice_stud_sex[$R]==2) $club_arranged_girl_num[$the_club]++; 
    	    	  	  $RECORD.= get_stud_name($the_choice_stud[$R])." ";
    	    	  	  $arr_assign++;
    	    	  	}  // function ���@�T�{�J��
    	    	  } //end if    	    	  
    	    	} while ($count_num<$target_num); //end while
    	    	
    	    } // end if $the_choice_stud_num<=$club_student_num[$the_club]-$club_arranged_stud_num[$the_club]
    	   $RECORD.= "<font color=red>==>����:".$limit.", �s�J".$arr_assign."�H</font><br>";
    	  } // end if $the_choice_stud_num==0 �O�_���ǥͿ�o�Ӫ��� 
}

?>
