<?php

// $Id: header.php 5762 2009-11-16 07:44:02Z hami $


$book_path= updir($_SERVER[PHP_SELF]);
if( $_POST[sortq] !=""){
	header("Location: $book_path/".$_POST[sortq]);
}
else if($_POST[sortq2] !=""){
	header("Location: $book_path/".$_POST[sortq2]);
}
else if($_POST[qbook] !=""){
header("Location: $book_path/".$_POST[qbook]);
}
else if($_POST[bookadm] !=""){
	if ($_POST[bookadm]=="check")
		header("Location: $SFS_PATH_HTML"."include/sfs_case_studauth.php?chkpath=$_SERVER[SCRIPT_FILENAME]");
	else
		header("Location: $book_path/".$_POST[bookadm]);
}

head("�ϮѺ޲z");
?>
<center>

<table bgColor="#619360" border="0" cellPadding="2" cellSpacing="0" width="608">
  <tbody>
    <tr>
      <td vAlign="center" width="10">�@</td>
      <td vAlign="center" width="70%"><font color="#ffffff" size="4"><b><a style="text-decoration: none"><?php echo $school_sshort_name?>�Ϯѫ�</a></b></font>
      </td>
      <td align="right" vAlign="center" nowrap><font color="#ffffc1" size=2><a href="qbook.php" target="_top">�㭶�s��</a>&nbsp;
        </font></td>
    </tr>
  </tbody>
</table>
<FORM NAME="myform" action="<?php echo $_SERVER[PHP_SELF] ?>" method="post">

<table border="0" cellspacing="2" cellpadding="0" width="610">

  <tr bgcolor="green">

    <td align="center"><table border="0" cellspacing="1" cellpadding="3" width="100%">

      <tr bgcolor="#FEFBC0">

<td align="CENTER">
<SELECT NAME="qbook" SIZE=1 style="BACKGROUND-COLOR: #FEFBC0; font-family: �s�ө���; font-size: 12pt" onchange="document.myform.submit()">
<OPTION SELECTED VALUE="">--- �ϮѬd�� ---
<OPTION VALUE="qbook.php">�Ϯѥؿ�

<OPTION VALUE="qbooktol.php">�ѥزέp
<OPTION VALUE="qbookstud.php">Ū�̭ɾ\�d��
<OPTION VALUE="qbooktea.php">�Юv�ɾ\�d��
</SELECT>
</td>
<td align="CENTER">
<SELECT NAME="sortq" SIZE=1 style="BACKGROUND-COLOR: #FEFBC0; font-family: �s�ө���; font-size: 12pt" onchange="document.myform.submit()">
<OPTION SELECTED VALUE="">--- �Ʀ�] ---
<OPTION VALUE="booksort.php">�������ǱƦ�

<OPTION VALUE="classsort.php">�Z�ŭɾ\�Ʀ�
<OPTION VALUE="studsort.php">Ū�̭ɾ\�Ʀ�
</SELECT>
</td>
<td align="CENTER">
<SELECT NAME="bookadm" SIZE=1 style="BACKGROUND-COLOR: #FEFBC0; font-family: �s�ө���; font-size: 12pt" onchange="document.myform.submit()">
<OPTION SELECTED VALUE="">--- �ϮѺ޲z ---
<OPTION VALUE="yetreturn.php">�O���d��
<OPTION VALUE="qbookout.php">�ǥͭɾ\���p��
<OPTION VALUE="bookcode.php">���X�C�L
<OPTION VALUE="bro_book.php">�ǥͭ��ٮѧ@�~*
<OPTION VALUE="bro_tea_book.php">�Юv���ٮѧ@�~*
<OPTION VALUE="class_code.php">�Z�ű��X�C�L*
<OPTION VALUE="add_book.php">�妸�s�W�Ϯ�*
<OPTION VALUE="book_new.php">�Ϯѷs�W�@�~*
<OPTION VALUE="book_input.php">�Ϯѭק�@�~*
<OPTION VALUE="qbookout_tea.php">�Юv�ɾ\���p��*
<OPTION VALUE="book_dump.php">�ϮѶץX�@�~*
<OPTION VALUE="check">���v�ǥͺ޲z*
</SELECT>
</td>

<td align="CENTER">
<SELECT NAME="sortq2" SIZE=1 style="BACKGROUND-COLOR: #FEFBC0; font-family: �s�ө���; font-size: 12pt" onchange="document.myform.submit()">
<OPTION SELECTED VALUE="">--- �ϮѫǤ��� ---
<?php echo get_booksay_option() ?>
<OPTION VALUE="booksay_edit.php">�ﶵ�s��(�޲z��)*
</SELECT>
</td>
      </tr>

    </table>

    </td>

  </tr>
</table>

</center><div align="center"><center>
  <table  class=module_body border="0" cellPadding="0" cellSpacing="0" width="608">
</FORM>
    <tbody>
      <tr>
        <td>
