<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $


//�ˬd�O�_�}����μҲ�
if ($m_arr["club_enable"]!="1"){
   echo "�ثe���}����ά��ʼҲաI";
   exit;
}


//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();

//�ثe��w�Ǵ�
$c_curr_seme=sprintf('%03d%1d',$curr_year,$curr_seme);

	//���o�Ǵ����γ]�w
  $SETUP=get_club_setup($year_seme);

	$school_kind_name[100]="��~";
	$class_year_array=get_class_year_array(sprintf('%d',substr($c_curr_seme,0,3)),sprintf('%d',substr($c_curr_seme,-1)));
	$class_year_array[100]="100";
	?>
			<?php
			//�̦~�ŦC�X���Τ@���� , �ˬd club_class��
      foreach ($class_year_array as $K=>$class_year_name) {
			  $query="select * from stud_club_base where year_seme='$c_curr_seme' and club_class='$K' order by club_name";
			  $result=mysql_query($query);
			  //�Ӧ~�Ŧ����ΦA�C�X
			  if (mysql_num_rows($result)) {
			?>
 			<table border="0" style="border-collapse:collapse" bordercolor="#000000" width="100%">
			<tr>
			   <td valign="top" style="color:#800000">
			   	<?php echo $school_kind_name[$K];?>�Ū���
			  </td>
			</tr>
			<tr>
				<td>
									<?php
             	      	list_class_club_choice_detail($c_curr_seme,$K,0,0); //�C�X�~�Ū��ο�ҩ���
                	?>
        </td>      	
      </tr>
      </table>
			<?php
			  } // end if
			} // end foreach
			?>

