<?php
// $Id: ustep1.php 5310 2009-01-10 07:57:56Z hami $
	if ($step !=1 )
		$dis = " disabled ";	
		
	echo "<form method=\"POST\" $dis >";	
?>
<!- �Ĥ@�B�ˬd�K�X --->	
<a name="this_step1">
       <table cellspacing="0" cellpadding="0" width=450>        
          <tr bgColor="#999999">
            <td align="right">�Ĥ@�B�G</td>
            <td>sfs1.1 �]�w�ˬd</td>
          </tr>
          <tr  bgColor="#cccccc">
            <td align="right"> sfs1.1����ؿ��G</td>
            <td><input type="text" name="sfs_path" size="20" <?php echo $dis ?>><BR>(�ҡG/home/httpd/htdocs/html/sfs)</td>
          </tr>
          <tr>
            <td bgColor="#999999" colSpan="2" align=center>
            <table border=0 bgcolor=yellow width=98%>
		<tr>
			<td colspan=2 align=center>MySQL�]�w��</td>
		</tr>
		<tr>
			<td>Host</td>
			<td><input type="text" name="host" value="localhost" <?php echo $dis ?> ></td>
		</tr>
		<tr>
			<td>database</td>
			<td><input type="text" name="database" value="sfs" <?php echo $dis ?>></td>
		</tr>
		<tr>
			<td>User</td>
			<td><input type="text" name="user" value="root" <?php echo $dis ?>></td>
		</tr>

		<tr>
			<td>Password</td>
			<td><input type="password" name="password"></td>
		</tr>

		
		</table>
	  </td>
          </tr>
          <tr>
            <td bgColor="#999999" colSpan="2" align="right"></td>
          </tr>
          <tr  bgColor="#cccccc">
          	<td  colspan=2>
          	<input type="hidden" name=dostep value="1">
          	<input type="submit" value="�T�w" name="B1" <?php echo $dis ?> >
          	 </td>
          </tr>
        </table> 	
	</form>
<hr>