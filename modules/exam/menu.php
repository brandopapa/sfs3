<!-- $Id: menu.php 5310 2009-01-10 07:57:56Z hami $ -->
<table border="0" cellPadding="0" cellSpacing="2" width="302" align=center >
  <tbody>
    <tr bgColor="#6666cc">
      <td align="middle">
        <table border="0" cellPadding="3" cellSpacing="1" width="400">
          <tbody>
            <tr bgColor="#fefbc0">
            <?php 
            	//�t�κ޲z�H��
            	if ($man_flag) {	
              		echo "<td align=\"middle\" width=\"70\"><a href=\"ekind.php\">�Z�ź޲z</a></td>";
              		echo "<td align=\"middle\" width=\"70\"><a href=\"esystem.php\">�t�κ޲z</a></td>";
              	}
             ?>
              <td align="middle" width="70"><a href="exam.php">�@�~�޲z</a></td>              
              <td align="middle" width="70"><a href="exam_list.php">�@�~�i��</a></td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>
