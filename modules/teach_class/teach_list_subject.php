<?php

// ���J�]�w��
include "teach_config.php";

// �{���ˬd
sfs_check();

//�L�X���Y
head("�Юv�򥻸��-���Ф@����");

//¾�����O
$POST_KIND = post_kind();
$display_color = array("1"=>"$gridBoy_color","2"=>"$gridGirl_color");
//�L�X���
$tool_bar=&make_menu($teach_menu_p);
//�C�X���
echo $tool_bar;

echo "���ձЮv�̥��Ь�ر��C�@����:<br>
<hr size='1'>";
//�C�X��¾��id
// ====================================================================
$subject_list=($subject_list!="")?$subject_list:"�y��,�ƾ�,�۵M�P�ͬ����,���|,���d�P��|,���N�P�H��,��X,�S��";
$Subject_KIND=explode(",",$subject_list);

//$Subject_KIND=array("�y��_���","�y��_�^��","�ƾ�","�۵M�P�ͬ����_�z��","�۵M�P�ͬ����_�ͪ�","�۵M�P�ͬ����_�a�y���","�۵M�P�ͬ����_��T","���|_�a�z","���|_���v","���|_����","���d�P��|_���d","���d�P��|_��|","���N�P�H��_ťı���N","���N�P�H��_��ı���N","���N�P�H��_��t���N","��X","�S��");
foreach ($Subject_KIND as $k=>$master_subjects) {
 $i=0; //���������O�H��
 
 $query="select a.teacher_sn,a.teach_id,a.name,a.sex,b.post_kind,b.class_num,c.rank,c.title_name from teacher_base a,teacher_post b,teacher_title c where a.teacher_sn=b.teacher_sn and a.master_subjects like '%".$master_subjects."%' and a.teach_condition=0 and b.teach_title_id=c.teach_title_id order by c.rank,b.class_num";
 
 $result=$CONN->Execute($query) or die($query);
 ?>
 <table border="0" width="700">
   <tr>
     <td style="color:#800000">���-��O�G<?php echo $master_subjects;?></td>
   </tr>
 </table>
 <table border="1" style="border-collapse:collapse;border-color:#000000">
 	<?php
  while ($row=$result->fetchRow()) {
  	$teacher_sn=$row['teacher_sn'];
  	$selfweb="";
  	$sql_web="select selfweb from teacher_connect where teacher_sn='$teacher_sn'";
  	$res_web=$CONN->Execute($sql_web) or die ("Error! ".$sql_web);
  	$post_kind=$row['post_kind'];
		$title_name=$row['title_name'];
  	$sex=$row['sex'];
  	$selfweb=$res_web->fields['selfweb'];
  	
  	if ($selfweb=="") {
  	  $D=$row['name']."<br><font size=2>".$title_name."</font>";
  	} else {
  		if (substr($selfweb,0,7)=="http://" or substr($selfweb,0,8)=="https://" ) {
  			$D="<a href=\"".$selfweb."\" style='color:".$display_color[$sex]."' target=\"_blank\"><u>".$row['name']."</u></a><br><font size=2>".$title_name."</font>";
  		} else { 
  	   $D="<a href=\"http://".$selfweb."/\" style='color:".$display_color[$sex]."' target=\"_blank\"><u>".$row['name']."</u></a><br><font size=2>".$title_name."</font>";
  	  }
  	}
  	
  	if (false !== ($rst = strpos($title_name,"�N��"))) { 
			$D="<font color=red>".$D."</font>";
    } elseif (false !== ($rst = strpos($title_name,"�N�z"))) { 
			$D="<font color=red>".$D."</font>";
    } elseif (false !== ($rst = strpos($title_name,"�ݥ�"))) {
			$D="<font color=red>".$D."</font>";
    }
 	
  	//$f_color=($selfweb=="")?"#CCCCCC":"#000000";
  			$i++;  if ($i%10==1) echo "<tr>";
       ?>
        
        <td style="font-size:9pt" align="center" width="80">
        	<table border="0"  style="border-collapse:collapse">
           		<tr>
        			<td align="center" style="font-size:11pt;color:<?php echo $f_color;?>">
        				
        				<?php
        					echo $D;
        				?>
        				
        			</td>
        		</tr>
        	</table>
         </td>
        	<?php
      		if ($i%10==0) echo "</tr>";
 	}// end while
 ?>
</table>
�@�p <?php echo $i;?> ��Юv<br><br>
 <?php 
} // end foreach

?>  	
<hr size="1">
����: <br>
1.���{���̡u�Юv�޲z/�򥻸�ơv���m�ǲ߻����бM����ءn���ҵ��O����ƥ[�H��������C�Юv�W��C<br>
2.�ХѼҲ��ܼƽվ�n���C�����ޱ���C<br>
3.�Хѡu�Ǯճ]�w/<a href='/school_setup/school_title.php'>¾�ٸ��</a>�v�վ�C���U¾�٦C�X�����ǡC<br>