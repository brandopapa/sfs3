<!-- $Id: ustep0.php 5310 2009-01-10 07:57:56Z hami $ -->
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%"><b> �Х��إ߸�Ʈw sfs2 �A���U�C�B�J�G</b>  
      <ol> 
        <li> �ƥ��� sfs ��Ʈw<br>  
          <br> 
          <span style="background-color: #CCCCFF">mysqldump sfs > sfsdump.sql -uroot -p<br>  
          <br> 
          </span></li> 
        <li>�إ� sfs2 ��Ʈw&nbsp;<br> 
          <br>
          <span style="background-color: #CCCCFF">mysqladmin create sfs2 -uroot -p<br>  
          <br> 
          </span></li> 
        <li>�N sfs ����Ʀ^�s�� sfs2&nbsp;<br> 
          <br>
          <span style="background-color: #CCCCFF">mysql sfs2 &lt; sfsdump.sql -uroot -p</span></li> 	 
      </ol> 
      
    </td> 
  </tr> 
  <tr>
    <td width="100%">��s�{������ɶ��A�]��ƶq�ΥD���t�סA�Ӧ����P�A<br>
      �Y�]��s�ɶ��L�[�A�y�����~�p�U�G<b><br>
      Fatal error</b>: Maximum execution time of 30 seconds exceeded
      <p>�Эק� php.ini�]�w�A�N�ɶ��]���@�ǡA�p�U</p>
      <p><span style="background-color: #CCCCFF">max_execution_time = <font color="#FF0000"><b>60</b></font></span></p>
      <p>�ק��A���� apache <br>
      
    </td> 
  </tr> 
</table> 

<hr>