<?php
include "config.php";

sfs_check();

$SEX[1]="�k";
$SEX[2]="�k";

//�q�X����
head("��A��޲z - �ֳt�K�W�����魫");
$tool_bar=&make_menu($menu_p);
//�C�X���
echo $tool_bar;

//�{���}�l
$seme_class=$_POST['seme_class'];
$stud_data=$_POST['stud_data'];

//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();

//�ثe��w�Ǵ�
$c_curr_seme=sprintf('%03d%1d',$curr_year,$curr_seme);

$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);
if ($module_manager!=1) {
 echo "��p , �z�S���L�޲z�v��!";
 exit();
}
?>

<form name="myform" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
<table border="0" width="100%">
 <tr>
  <td><br>���{���O���F��N���d���ߪ���Ư�ֳt�פJ�t�Φӳ]�p�A�Y�K�W����Ʈ榡���~�A�פJ����ƫh���O�Ҧʤ����ʥ��T�A���O�I����k�٬O�@���@���C�C��J�C</td>
 </tr>	
 <tr>
  <td><br>�פJ����Ʒ|�s�J<font color="#FF0000"><?php echo curr_year()."�Ǧ~��".curr_seme()."�Ǵ�</font> ���ǥ͸��";?><br></td>
 </tr>
 <tr>
 	 <td style="color:#800000">
 	 	�п�ܸ�ƭn�s�J���Z�šG
 	 	<select name="seme_class" size="1" onchange="javascript:document.myform.submit()">
 	 		<option value="">�п�ܯZ��</option>
 	 		<?php
 	 	
 	 		$query="select distinct seme_class from stud_seme where seme_year_seme='$c_curr_seme' order by seme_class";
 	 		$res=mysql_query($query);
 	 		while ($row=mysql_fetch_row($res)) {
 	 		 list($SEME_CLASS)=$row;
 	 		 $class_id=sprintf("%03d_%d_%02d_%02d",curr_year(),curr_seme(),substr($SEME_CLASS,0,1),substr($SEME_CLASS,1,2));
 	 		 $query="select c_year,c_name,c_kind from school_class where class_id='$class_id'";
 	 		 $res_class=mysql_query($query);
 	 		 if (mysql_num_rows($res_class)) {
 	 		 list($c_year,$c_name,$c_kind)=mysql_fetch_row($res_class);
 	 		 ?>
 	 		  <option value="<?php echo $SEME_CLASS;?>"<?php if ($SEME_CLASS==$seme_class) echo " selected";?>><?php echo $school_kind_name[$c_year]."".$c_name."�Z";?></option>
 	 		 <?php
 	 		 } // end if
 	 		}
 	 		
 	 		?>
 	 </td>
 	</tr>
</table>
</form>	
	<?php
	if ($seme_class and $c_curr_seme) {
	?>
<form name="myform1" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">	
	<input type="hidden" name="seme_class" value="<?php echo $seme_class;?>">
	  <table border="0">
    <tr>
    	<td style="font-size:10pt">�N��ƥ� EXCEL���ƻs/�K�W�A�M����e�X�Y�i�A�`�N������(�bEXCEL�ݪ��榡���p�U�ҥܡA��6��(�t)�ᤣ�p)�G<br>
    		<table border="1" style="border-collapse:collapse" bordercolor="#000000">
    		 <tr>
    		  <td>�y��</td>
    		  <td>�m�W</td>
    		  <td>�ʧO</td>
    		  <td>����</td>
    		  <td>�魫</td>
    		 </tr> 
    		 <tr>
    		  <td>1</td>
    		  <td>�Lxx</td>
    		  <td>�k</td>
    		  <td>164.5</td>
    		  <td>53.6</td>
    		 </tr> 
    		 <tr>
    		  <td>1</td>
    		  <td>�dxx</td>
    		  <td>�k</td>
    		  <td>148.4</td>
    		  <td>37.8</td>
    		 </tr> 
    		</table>
    �t�Υu�|�I���C�e������,�ä���1�β�2��,�M��N��4�β�5������������魫.<br>
    		<textarea name="stud_data" cols="80" rows="10"></textarea>
    	</td>
    </tr>
    </table>
    <input type="submit" value="�e�X���">(�ˬd�y�O�m�W�����L�~�Y�i�e�X)
<table border="1" style="border-collapse:collapse" bordercolor="#CCCCCC">
	<tr  bgcolor="#FFCCFF">
		<!--
		<td width="40" style="font-size:10pt" align="center">����</td>
		-->
		<td width="30" style="font-size:10pt" align="center">�y��</td>
		<td width="50" style="font-size:10pt" align="center">�m�W</td>
		<td width="30" style="font-size:10pt" align="center">�m�O</td>
		<td width="50" style="font-size:10pt" align="center">����</td>
		<td width="50" style="font-size:10pt" align="center">�魫</td>
		
		<td width="80" style="font-size:10pt" align="center">��s����</td>
		<td width="80" style="font-size:10pt" align="center">��s�魫</td>

		<td width="120" style="font-size:10pt" align="center">���A</td>
	</tr>
	
<?php
//����ƪ��ܥ����R�����魫
if ($stud_data) {
	$data_arr=explode("\n",$stud_data);
	for ($i = 0 ; $i < count($data_arr); $i++ ) {
		//�h���e��ť�
	 $data_arr[$i] = trim($data_arr[$i]);
	 //�h�����H�O�����b�@�����ť�
   $data_arr[$i] = preg_replace('/\s(?=\s)/','', $data_arr[$i]);
   $data_arr[$i] = preg_replace('/[\n\r\t]/', ' ', $data_arr[$i]);

   //�ܦ��G���}�C
   $stud_arr_my[$i]=explode(" ",$data_arr[$i]); 
   //echo $stud_arr_my[$i][0].",".$stud_arr_my[$i][1].",".$stud_arr_my[$i][3].",".$stud_arr_my[$i][4]."<br>"; 
	}

}


		$query="select a.student_sn,a.stud_name,a.stud_sex,b.seme_num from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$c_curr_seme' and b.seme_class='$seme_class' and a.stud_study_cond in ($in_study) order by seme_num";
    $result=mysql_query($query);
    while ($row=mysql_fetch_row($result)) {
    	list($student_sn,$stud_name,$stud_sex,$seme_num)=$row;
    	?>
		<tr>
    	<!--
    	<td style="font-size:10pt" align="center"><?php echo $student_sn;?></td>
    	-->
    	<td style="font-size:10pt" align="center"><?php echo $seme_num;?></td>
    	<td style="font-size:10pt" align="center"><?php echo $stud_name;?></td>
    	<td style="font-size:10pt" align="center"><?php echo $SEX[$stud_sex];?></td>
    	<?php
     //�ˬd fitness_data table �̦��S�����Ǵ����
   			$query="select count(student_sn),tall,weigh from fitness_data where student_sn='".$student_sn."' and c_curr_seme='$c_curr_seme'";
   			$result_chk=mysql_query($query);
   			list($ok,$tall,$weigh)=mysql_fetch_row($result_chk);
   			//�p�G�S�����, �۰�insert �s��
   			if ($ok==0) {
   				if (mysql_query("insert into fitness_data (c_curr_seme,student_sn) values ('$c_curr_seme','".$student_sn."')")) {
					  $INFO= "=>�|�L�������魫���";
					}else{
					  echo "<font color=#FF000>���Ǵ���A���ƫإߥ��ѡA�Ь��t�κ޲z��!</font>";
						exit();					  
					}
        }// end if $ok==0 ���S���إ߸��
   			?>
   			<td style="font-size:10pt" align="center"><?php echo $tall;?></td>
   			<td style="font-size:10pt" align="center"><?php echo $weigh;?></td>
   			<?php

         if ($stud_data) {
					//�ˬd���S���ŦX�����
					$chk=0;
					for ($i=0;$i < count($data_arr); $i++ ) {
					 if ($stud_arr_my[$i][0]==$seme_num and $stud_arr_my[$i][1]==trim($stud_name)) {
					 	 $Newtall=$stud_arr_my[$i][3];
					 	 $Newweigh=$stud_arr_my[$i][4];
					 	  $chk=1;
					 	  $query_up="update fitness_data set tall='".$stud_arr_my[$i][3]."',weigh='".$stud_arr_my[$i][4]."' where student_sn='".$student_sn."' and c_curr_seme='".$c_curr_seme."'";
					 	  if (mysql_query($query_up)) {
					      $INFO="��s����";
					    } else {
					      $INFO="��s����!";
					    }
					 	  break;
					 } 
         }// end for
         if ($chk==0) {
            $INFO="�S������y���Ωm�W���! ����s!";
         }

        }//end if ���K�W���
        ?>
		 	 <td align="center"><?php echo $Newtall;?> </td>
		 	 <td align="center"><?php echo $Newweigh;?> </td>
       <td><?php echo $INFO;?></td>
      </tr>
        <?php    	
    } // end while
    
    ?>
  </table>

    <?php
} // end if 
?>


</form>