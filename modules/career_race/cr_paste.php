<?php
//���o�]�w��
include_once "config.php";

sfs_check();

//���o�t�Τ��Ҧ��Ǵ����, �C�@�Ǧ~���G�ӾǴ�
$class_seme_p = get_class_seme(); 

//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();

//�ثe��w�Ǵ� , �Y����w�h�H��w���Ǵ��@�����ǥͯZ�Ůy�����̾�, �_�h�H�̷s�Ǵ����Ӹꬰ��
$c_curr_seme=($_POST['c_curr_seme']!="")?$_POST['c_curr_seme']:sprintf('%03d%1d',$curr_year,$curr_seme);

 //�p��ӾǴ�������϶�
 $year=sprintf("%d",substr($c_curr_seme,0,3));
 $seme=substr($c_curr_seme,-1);
 //�_�l��
 $sql="select day from school_day where year='$year' and seme='$seme' and day_kind='start'";
 $res=mysql_query($sql);
 list($st_date)=mysql_fetch_row($res);
 
 //������
 $sql="select day from school_day where year='$year' and seme='$seme' and day_kind='end'";
 $res=mysql_query($sql);
 list($end_date)=mysql_fetch_row($res);



//�s�@��� ( $school_menu_p�}�C�]�w�� module-cfg.php )
$tool_bar=&make_menu($school_menu_p);

//Ū���ثe�ާ@���Ѯv���S���޲z�v
$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);

/**************** ��ƳB�z **********************/
//�x�s
if ($_POST['act']=='save') {
 $data_array=explode("\n",$_POST['data_array']);
 $save_ok=0; 
 foreach ($data_array as $a) {
 	$data_arr=explode("\t",$a);
   
  switch ($_POST['data_mode']) {	
   
   //�Ĥ@�� �Ǧ~�Ǵ�	�Z��	�y��	�m�W {�~�� �v�����O}	�v�ɽd��	�v�ɩʽ�	�v�ɦW��	�o���W��	�ҮѤ��	�D����	�Ƶ�
   case '1':
   	$year_seme=$data_arr[0];
   	$seme_class=$data_arr[1];
   	$seme_num=$data_arr[2];
   	$stud_name=$data_arr[3];
   	$sql="select a.student_sn from stud_seme a,stud_base b where a.seme_year_seme='$year_seme' and a.student_sn=b.student_sn and a.seme_class='$seme_class' and a.seme_num=$seme_num and  b.stud_name='$stud_name'";
   	$res=mysql_query($sql);
   	list($student_sn)=mysql_fetch_row($res);
   	if ($student_sn) {
   	//�ҮѤ�� , �ˬd�U���öi��ץ�, �Y�榡����, ��W���Ѥ��
   	$c_date=explode("-",$data_arr[10]);
   	 if (count($c_date)!=3) {
        	$c_date=explode("/",$data_arr[10]);
   				if (count($c_date)!=3) {
        			$c_date=explode(".",$data_arr[10]);
  	   				if (count($c_date)!=3) {
  	   					$data_arr[10]=sprintf("%d",$c_date[0])."-".sprintf("%02d",$c_date[1])."-".sprintf("%02d",$c_date[2]);
	        	  } else {
	        	   $data_arr[10]=date("Y-m-d");
	        	  }       	  		
   				} else {
   					$data_arr[10]=sprintf("%d",$c_date[0])."-".sprintf("%02d",$c_date[1])."-".sprintf("%02d",$c_date[2]);   				  
   				}
   	 } else {
			$data_arr[10]=sprintf("%d",$c_date[0])."-".sprintf("%02d",$c_date[1])."-".sprintf("%02d",$c_date[2]); 
   	 }
   	
   	//�g�J�@�����
   		//$query="insert into career_race set student_sn='$student_sn',level=".$data_arr[4].",squad=".$data_arr[5].",name='".$data_arr[6]."',rank='".$data_arr[7]."',certificate_date='".$data_arr[8]."',sponsor='".$data_arr[9]."',memo='".$data_arr[10]."',update_sn='".$_SESSION['session_tea_sn']."'";
   		$query="insert into career_race set student_sn='{$student_sn}',year='{$data_arr[4]}',nature='{$data_arr[5]}',level='{$data_arr[6]}',
   		squad='{$data_arr[7]}' ,`name`='{$data_arr[8]}', rank='{$data_arr[9]}',	certificate_date='{$data_arr[10]}',sponsor='{$data_arr[11]}',memo='{$data_arr[12]}', update_sn='{$_SESSION['session_tea_sn']}', `word`='{$data_arr[13]}', `weight`='{$data_arr[14]}' ";
   		if (mysql_query($query)) {
   		 $save_ok+=1;
   		} else {
   		 echo "Error! query=$query";
   		 exit();
   		}
    } else {
    	if (trim($a)!="") $Err_info.="<font color=blue>�L�k���Ѹ�ƦC:</font><font size=2>".$a."</font><br>";    
    }// end if $student_sn
    break;

    //�ĤG�� �Ǹ� �m�W {�~�� �v�����O} �v�ɽd��	�v�ɩʽ�	�v�ɦW��	�o���W��	�ҮѤ��	�D����	�Ƶ�
    case '2': 
   	$stud_id=$data_arr[0];
   	$stud_name=$data_arr[1];
   	$sql="select student_sn from stud_base where stud_study_cond='0' and stud_id='$stud_id' and stud_name='$stud_name'";
   	$res=mysql_query($sql);
   	list($student_sn)=mysql_fetch_row($res);
   	if ($student_sn) {
   	//�ҮѤ�� , �ˬd�U���öi��ץ�, �Y�榡����, ��W���Ѥ��
   	$c_date=explode("-",$data_arr[8]);
   	 if (count($c_date)!=3) {
        	$c_date=explode("/",$data_arr[8]);
   				if (count($c_date)!=3) {
        			$c_date=explode(".",$data_arr[8]);
  	   				if (count($c_date)!=3) {
  	   					$data_arr[8]=sprintf("%d",$c_date[0])."-".sprintf("%02d",$c_date[1])."-".sprintf("%02d",$c_date[2]);
	        	  } else {
	        	   $data_arr[8]=date("Y-m-d");
	        	  }       	  		
   				} else {
   					$data_arr[8]=sprintf("%d",$c_date[0])."-".sprintf("%02d",$c_date[1])."-".sprintf("%02d",$c_date[2]);   				  
   				}
   	 } else {
			$data_arr[8]=sprintf("%d",$c_date[0])."-".sprintf("%02d",$c_date[1])."-".sprintf("%02d",$c_date[2]); 
   	 }
   	
   	//�g�J�@�����
   		//$query="insert into career_race set student_sn='$student_sn',level=".$data_arr[2].",squad=".$data_arr[3].",name='".$data_arr[4]."',rank='".$data_arr[5]."',certificate_date='".$data_arr[6]."',sponsor='".$data_arr[7]."',memo='".$data_arr[8]."',update_sn='".$_SESSION['session_tea_sn']."'";
   		$query="insert into career_race set student_sn='{$student_sn}',year='{$data_arr[2]}',nature='{$data_arr[3]}',level='{$data_arr[4]}',
   		squad='{$data_arr[5]}',name='{$data_arr[6]}',rank='{$data_arr[7]}',
   		certificate_date='{$data_arr[8]}',sponsor='{$data_arr[9]}',memo='{$data_arr[10]}' ,
   		update_sn='{$_SESSION['session_tea_sn']}' , `word`='{$data_arr[11]}', `weight`='{$data_arr[12]}' ";
   		if (mysql_query($query)) {
   		 $save_ok+=1;
   		} else {
   		 echo "Error! query=$query";
   		 exit();
   		}
    } else {
    	if (trim($a)!="") $Err_info.="<font color=blue>�L�k���Ѹ�ƦC=></font><font size=2 color=red>".$a."</font><br>";    
    }// end if $student_sn


    
    break;
  }
  
  
 } // end foreach

} // end if $_POST['save']
//�R��
if ($_POST['act']=='delete') {
 foreach ($_POST['check_it'] as $v) {
 	$query="delete from career_race where sn='$v'";
 	mysql_query($query); 
 }
} // end if delete

//�R���浧
if ($_POST['act']=='DeleteOne') {
	$sn=$_POST['option1'];
	$query="delete from career_race where sn='$sn'";
	mysql_query($query);
}

//Ū�����Ǧ~�רϥΪ̤w�n�����Ҧ��v��
if ($c_curr_seme!="") $race_record=get_race_record($c_curr_seme,$_SESSION['session_tea_sn']);	



/**************** �}�l�q�X���� ******************/
//�q�X SFS3 ���D
head();


//�C�X���
echo $tool_bar;


?>
<form name="myform" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<input type="hidden" name="act" value="">
	<input type="hidden" name="option1" value="<?php echo $_POST['option1'];?>">
   <font color="#800000"><u><b>���жK�W�n�n�������</b></u></font>
   <input type="button" value="�ϥλ���" onclick="readme();">
   <table border="0" id="readme_show" style="display:none">
     <tr>
      <td style="font-size:10pt;color:#0000dd">
   			�����G�ФU��Excel��g�d�ҡ�<a href="demo1.xls" style="color:#FF0000">�d��1</a>����<a href="demo2.xls" style="color:#FF0000">�d��2</a>���A�̹ϥܶȿ�ܤ��e�ƻs/�K�W�Y�i(��Ƥ��e���]�A���D�C)�C
      </td>
     </tr>	
		<tr>
		 <td><img src="images/paste_demo.png" border="0"></td>
		</tr>
   </table>
   <table border="0">
   	<tr>
   		<td>
   	<textarea cols="80" rows="10" name="data_array"></textarea>
   	<br>
   	<font color="#800000">��춶�Ǯ榡�G</font><br>
   	<input type="radio" name="data_mode" value="1" checked>[�d��1]�Ǵ��Ǧ~�B�Z�šB�y���B�m�W....<br>
   	<input type="radio" name="data_mode" value="2">[�d��2]�Ǹ��B�m�W....
   	<br><br>
   	<input type="button" value="�e�X���" onclick="document.myform.act.value='save';document.myform.submit()">
   	</td>
   	</tr>
   </table>
   <?php
 //�T������
  if ($_POST['act']=="save") {
   ?>
    <table border="0" width="100%">
      <tr>
        <td style="color:#FF0000"><?php echo "�����@�s�J".$save_ok."�����!";?></td>
      </tr>
      <tr><td><?php echo $Err_info;?></td></tr>
    </table>
  <?php 
  } 
  ?>
   <table border="0" width="100%">
     <tr>
      <td style="color:#800000">
      	<u><b>��������</b></u>
				<select name="c_curr_seme" onchange="this.form.submit()">
					<?php
					foreach ($class_seme_p as $tid=>$tname) {
    			?>
    				<option style="color:#FF00FF" value="<?php echo $tid;?>" <?php if ($c_curr_seme==$tid) echo "selected";?>><?php echo $tname;?></option>
   				<?php
    			} // end while
    			?>
    		</select>    
      	<font size=2>����G<?php echo $st_date;?>~<?php echo $end_date;?></font>(�ȦC�X�z�n�������)</td>
     </tr>
   </table>
<?php
	list_race_record($race_record,1,1,'cr_input.php'); 
 ?>
 <table border="0">
 	<tr>
 	      <td><input type="button" value="�R���Ŀ諸���" onclick="if (confirm('�z�T�w�n�R���Ŀ諸���?')) { document.myform.act.value='delete';document.myform.submit(); } "></td>
 	</tr>
 </table>
</form>
<Script Language="JavaScript">
function readme() {
	var dis=readme_show.style.display;	
	if (dis=='none') {
		readme_show.style.display="block";
	} else {
		readme_show.style.display="none";
	}
}
</Script>

