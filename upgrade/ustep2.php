<?php 
// $Id: ustep2.php 5310 2009-01-10 07:57:56Z hami $
	if ( !@mysql_connect ("$session_mysql_host","$session_mysql_user","$session_mysql_password")) {
		echo "�����{�Ҷi�J!!";
		exit;
	}
	
	if ($step!= 2 )
		$dis = " disabled ";
	else
		$dis ="";
	echo "<form method=\"POST\" $dis >";	
?>
<a name="this_step2">
<!- �ĤG�B���B�Ǹ�Ƥξ��y������� --->	
        <table cellspacing="0" cellpadding="0" width=450>
          <tr bgColor="#999999">
            <td align="right"><b>�ĤG�B�G</b></td>
            <td><b>�ǥ͸������</b></td>
          </tr>
          
            <td bgColor="#999999" colSpan="2" align="right"></td>
          </tr>
          <tr  bgColor="#cccccc">
            <td align="right">��}��J�G</td>
            <td>�w�]�����G<input type="text" name="default_sheng" size="10" value="�x����" <?php echo $dis ?>>&nbsp;&nbsp; 
              �w�]�m��G<input type="text" name="default_coun" size="10" value="�~�H�m" <?php echo $dis ?>></td>
          </tr>
          <tr>
            <td bgColor="#999999" colSpan="2" align="right"></td>
          </tr>
          <tr  bgColor="#cccccc">
            <td align="right"> </td>
            <td></td>
          </tr> 
          <tr  bgColor="#cccccc">
            <td  colspan=2>�N�إ�sfs2 ��Ʈw�A�ñN��sfs1.1 ��ƽƻs�ܷs��Ʈw</td>
            
          </tr> 
          <tr>
	<td colspan=2>	
	<?php 
		/*if (check_db("$Mysql_db") and $step==2) {
			echo "������ sfs2 ��Ʈw�w�s�b�A<font color=red>sfs2 ��Ʈw�N�Q�M���A���إ�!!</font><br>";
		}			
		*/
          ?>
          </td></tr>
          <tr  bgColor="#cccccc">
            <td align="right"> </td>
            <td></td>
          </tr>
          <tr  bgColor="#cccccc">
          	<td  colspan=2>          	
		<input type="hidden" value="2" name="dostep" >
		
          	<p><span style="background-color: #FFFF00"><input type="submit" value="�T�w" name="B1" onclick="blankWin()" <?php echo $dis ?>> &nbsp;&nbsp; �� ���ɮɶ�����Ƶ��Ʀh��Ӧ����P�A�i��ݼƤ��� ��</span></p>

          	 </td>
          </tr>
        </table>
  	
	</form>
<hr>