<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";

//���J���ά��ʼҲժ����Ψ禡
include_once "../stud_club/my_functions.php";


	//���^�t�α����ܼ�
	$MSETUP =get_module_setup("stud_club");
	//�ǥͥi�����@��
	$choice_num=$MSETUP['choice_num'];
	//�w�]�}����ɶ�
	$choice_sttime=$MSETUP['choice_sttime'];
	//�w�]�������ɶ�
	$choice_endtime=$MSETUP['choice_endtime'];

sfs_check();

// ���O�d�d��
switch ($ha_checkary){
        case 2:
                ha_check();
                break;
        case 1:
                if (!check_home_ip()){
                        ha_check();
                }
                break;
}


//�q�X����
head("���ά��� - ���ά���");

//�Ҳտ��
print_menu($menu_p);


//�ˬd�O�_�}����μҲ�
if ($m_arr["club_enable"]!="1"){
   echo "�ثe���}����ά��ʼҲաI";
   exit;
}

$_POST['club_menu']=($_POST['club_menu']=='')?"club_list.php":$_POST['club_menu'];

?>
 <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" name="menu_form">
  <table border="0">
    <tr>
    	<td style="color:#0000FF">�п�ܧA�n���\��G</td>
      <td><input type="radio" name="club_menu" value="club_list.php" <?php if ($_POST['club_menu']=='club_list.php') echo "checked";?> onclick='document.menu_form.submit()'>���Ǵ����Τ@����</td>
      <td><input type="radio" name="club_menu" value="club_choice.php" <?php if ($_POST['club_menu']=='club_choice.php') echo "checked";?> onclick='document.menu_form.submit()'>���ο��</td>
      <td><input type="radio" name="club_menu" value="club_feedback.php" <?php if ($_POST['club_menu']=='club_feedback.php') echo "checked";?> onclick='document.menu_form.submit()'>��g�ۧڬ٫�</td>
    </tr>
  </table>
 </form>
 
<?php

if ($_POST['club_menu']!="") {
 include_once($_POST['club_menu']);
}

?>
