<?php 
// $Id: ustep3.php 5310 2009-01-10 07:57:56Z hami $
	if ( !@mysql_connect ("$session_mysql_host","$session_mysql_user","$session_mysql_password")) {
		echo "�����{�Ҷi�J!!";
		exit;
	}
	
	if ($step!= 3 )
		$dis = " disabled ";
	else
		$dis ="";
	echo "<form method=\"POST\" $dis >";	
?>
<a name="this_step3">
<!- �ĤT�B���B�Ǹ�Ƥξ��y������� --->	
        <table cellspacing="0" cellpadding="0" width=450>
          <tr bgColor="#999999">
            <td align="right"><b>�ĤT�B�G</b></td>
            <td><b>�t�θ�ơB�Юv�������</b></td>
          </tr>
          
            <td bgColor="#999999" colSpan="2" align="right"></td>
          </tr>
          
            <td bgColor="#999999" colSpan="2" align="right"></td>
          </tr>
          <tr  bgColor="#cccccc">
            <td align="right"> </td>
            <td></td>
          </tr> 
          
        
          <tr  bgColor="#cccccc">
            <td align="right"> </td>
            <td></td>
          </tr>
          <tr  bgColor="#cccccc">
          	<td  colspan=2>          	
		<input type="hidden" value="3" name="dostep" >
		
          	<p><span style="background-color: #FFFF00"><input type="submit" value="�T�w" name="B1" onclick="blankWin()" <?php echo $dis ?>> &nbsp;&nbsp; �� ���ɮɶ�����Ƶ��Ʀh��Ӧ����P�A�i��ݼƤ��� ��</span></p>

          	 </td>
          </tr>
        </table>
  	
	</form>
<hr>