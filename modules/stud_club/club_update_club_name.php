<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";

sfs_check();


//�q�X����
head("���ά��� - �ץ��ǥͪ��Φ��Z�椤�����ΦW��");

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


$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);
if ($module_manager!=1) {
 echo "��p , �z�S���L�޲z�v��!";
 exit();
}
//POST�ᤧ�ʧ@ ================================================================
if ($_POST['mode']=="start") {
	    $N=0;
      $query="select * from association where seme_year_seme='$c_curr_seme' and club_sn!=''";
      $res=mysql_query($query);
      while ($row=mysql_fetch_array($res)) {
      	$query="select club_name from stud_club_base where club_sn='".$row['club_sn']."'";
				$result=mysql_query($query);
				list($club_name)=mysql_fetch_row($result);
				$query="update association set association_name='".SafeAddSlashes($club_name)."' where sn='".$row['sn']."'";
				if (mysql_query($query)) {
					$N++;
				} else {
				  echo "���~�o�ͤF�Iquery=$query";
				  exit();
				}	      	
      	
      } // end while
      $INFO="�`�@���s���J(�n��)�F $N ��ǥͪ����Φ��Z�������ΦW�١C";
}  


     $query="select * from association where seme_year_seme='$c_curr_seme' and club_sn!=''";
     $res=mysql_query($query);
     $N=mysql_num_rows($res);
?>
<form name="myform" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  <input type="hidden" name="mode" value="">
 <table border="0" width="100%">
 	<tr>
 	 <td>
 	  	<select name="c_curr_seme" onchange="this.form.submit()">
			<?php
			while (list($tid,$tname)=each($class_seme_p)){
    	?>
    		<option value="<?php echo $tid;?>" <?php if ($c_curr_seme==$tid) echo "selected";?>><?php echo $tname;?></option>
   		<?php
    	} // end while
    	?>
    </select> 
 	 </td>
 	</tr>
  <tr>
    <td>
     ���Ǵ��� <?php echo substr($c_curr_seme,0,3);?>�Ǧ~�ײ� <?php echo substr($c_curr_seme,3,1);?> �Ǵ�<br>
     ���Φ��Z��ƪ�, �@�t�� <?php echo $N;?> ��ǥ͸��, �䦨�Z�O���O�g�� SFS3 ���ά��ʼҲթҫإ�.<br>
     �z�n���s���J(��)�ǥͰѥ[�����ΦW�ٶ�? <input type="button" value="�O, �Э��s���J" onclick="document.myform.mode.value='start';document.myform.submit();"><br>
     <br>
     <font color=blue>���G�p�G�z���g��ʹL���ΦW�١A�εo�{���Z�椤�����ΦW�٦��ýX�A�������楻�{���i��󥿡C</font>
     <br>
    </td>
  </tr>
  <tr>
    <td style="color:#FF0000">
     <?php echo $INFO;?>
    </td>
  </tr>
 </table>
</form>     
