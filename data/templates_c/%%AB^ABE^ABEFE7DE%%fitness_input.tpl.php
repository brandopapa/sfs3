<?php /* Smarty version 2.6.26, created on 2016-01-15 15:29:29
         compiled from fitness_input.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['SFS_TEMPLATE'])."/header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['SFS_TEMPLATE'])."/menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<script language="JavaScript">
function openwindow(t){
	window.open ("quick_input.php?t="+t+"&class_num=<?php echo $this->_tpl_vars['class_num']; ?>
&c_curr_seme=<?php echo $_POST['year_seme']; ?>
","���Z�B�z","toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no,copyhistory=no,width=600,height=420");
}
</script>

<table bgcolor="#DFDFDF" cellspacing="1" cellpadding="4">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>
" method="post">
<input type="hidden" name="act" value="">
<tr>
<td bgcolor="#FFFFFF" valign="top">
<p><?php echo $this->_tpl_vars['seme_menu']; ?>
 <?php echo $this->_tpl_vars['class_menu']; ?>
 <font size="3" color="blue">���U���ئW�٧Y�i��J���Z</font> <?php if ($this->_tpl_vars['admin']): ?><input type='submit' value='������Ǵ����վǥͨ����魫���' name='copy_wh' onclick='return confirm("�ǥͤH�Ʀh���ܥi��|�Ӯɫܤ[�A�T�w�n�o�˰��ܡH")'><?php else: ?><input type='submit' value='������Ǵ������魫���' name='copy_wh'><?php endif; ?></p>
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="4" width="100%">
<tr bgcolor="#c4d9ff">
<td align="center">�y��</td>
<td align="center">�m�W</td>
<td align="center">�Ǹ�</td>
<td align="center"><a onclick="openwindow('0');"><img src="./images/wedit.png" border="0" title="��ƿ�J">����</a><br>(cm)</td>
<td align="center"><a onclick="openwindow('1');"><img src="./images/wedit.png" border="0" title="��ƿ�J">�魫</a><br>(kg)</td>
<td align="center"><a onclick="openwindow('2');"><img src="./images/wedit.png" border="0" title="��ƿ�J">�����e�s</a><br>(cm)</td>
<td align="center"><a onclick="openwindow('4');"><img src="./images/wedit.png" border="0" title="��ƿ�J">�ߩw����</a><br>(cm)</td>
<td align="center"><a onclick="openwindow('3');"><img src="./images/wedit.png" border="0" title="��ƿ�J">���װ_��</a><br>(��)</td>
<td align="center"><a onclick="openwindow('5');"><img src="./images/wedit.png" border="0" title="��ƿ�J">�ߪ;A��</a><br>(��)</td>
<td align="center"><a onclick="openwindow('6');"><img src="./images/wedit.png" border="0" title="��ƿ�J">�˴����</a></td>
<td align="center"><a onclick="openwindow('7');"><img src="./images/wedit.png" border="0" title="��ƿ�J">�˴��~��</a><br>( �~-�� )</td>
</tr>
<?php $_from = $this->_tpl_vars['rowdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['d']):
?>
<?php $this->assign('sn', $this->_tpl_vars['d']['student_sn']); ?>
<tr bgcolor="white">
<td class="small"><?php echo $this->_tpl_vars['d']['seme_num']; ?>
</td>
<td class="small"><font color="<?php if ($this->_tpl_vars['d']['stud_sex'] == 1): ?>blue<?php elseif ($this->_tpl_vars['d']['stud_sex'] == 2): ?>red<?php else: ?>black<?php endif; ?>"><?php echo $this->_tpl_vars['d']['stud_name']; ?>
</font></td>
<td style="text-align:right;"><?php echo $this->_tpl_vars['d']['stud_id']; ?>
</td>
<td style="text-align:right;"><?php echo $this->_tpl_vars['fd'][$this->_tpl_vars['sn']]['tall']; ?>
</td>
<td style="text-align:right;"><?php echo $this->_tpl_vars['fd'][$this->_tpl_vars['sn']]['weigh']; ?>
</td>
<td style="text-align:right;"><?php echo $this->_tpl_vars['fd'][$this->_tpl_vars['sn']]['test1']; ?>
</td>
<td style="text-align:right;"><?php echo $this->_tpl_vars['fd'][$this->_tpl_vars['sn']]['test3']; ?>
</td>
<td style="text-align:right;"><?php echo $this->_tpl_vars['fd'][$this->_tpl_vars['sn']]['test2']; ?>
</td>
<td style="text-align:right;"><?php echo $this->_tpl_vars['fd'][$this->_tpl_vars['sn']]['test4']; ?>
</td>
<td style="text-align:left;"><?php echo $this->_tpl_vars['fd'][$this->_tpl_vars['sn']]['organization']; ?>
</td>
<td style="text-align:center;"><?php echo $this->_tpl_vars['fd'][$this->_tpl_vars['sn']]['test_y']; ?>
-<?php echo $this->_tpl_vars['fd'][$this->_tpl_vars['sn']]['test_m']; ?>
</td>
</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
</td></tr></table>
<?php if ($this->_tpl_vars['admin']): ?>
<table border="2" cellpadding="3" cellspacing="0" style="border-collapse: collapse; font-size=9px;" bordercolor="#119911" width="100%">
		<tr><td align="center" bgcolor="#ccffff">���絲�G�妸�פJ</td></tr>
		<tr><td><font size=2>
			<li>���\��i�פJ��w�Ǵ��N�Ǿǥͪ���A���������A<a href='./xls_sample.xls'><img src='./images/pen.png' border=0 height=11>�榡�U��</a>�C</li>
			<li>�פJ����ƱıШ|����Ʈ榡�A��춷���T�w�����ǡG�������B�Ǯ����O�B�~�šB�Z�ŦW�١B�Ǹ��B�ʧO�B�����Ҧr���B�ͤ�B�����B�魫�B������e�s�B�ߩw�����B���װ_���B�ߪ;A��B<font color='red'>�˴����</font>�C</li>
			<li>�פJ�ɧK�n�������G�Ǯ����O�B�~�šB�ʧO�B�����Ҧr���B�ͤ�F<font color='red'>���������G�Z�ŦW�١B�Ǹ��F�Z�ŦW�ٽХΧǦC�N����ܡA�p���~�үZ�ж�601�B�E�~�G�Z�ж�902�C</font></li>
			<li>�פJ��A�{���|�N��Ƥ����ľǥͫ��w�Ǵ��즳�������R���A�A�̾ڱz�K�W����ƭ��s�O���A���ԷV�ϥΡC</li>
			<li>�ƻs�K�W����ƵL���]�t���W�٩λ����A�ȻݶK�W�ǥͬ����C�Y�i�I</li>
			</font></td></tr>
		<tr><td>
		<textarea name="content" style="border-width:1px; color:blue; background:#ffeeee; font-size:11px;" cols=120 rows=5></textarea></td></tr>
		<tr><td align="center" bgcolor="#ccffff"><input type="submit" name="go" value="�פJ"></td></tr>
		</table><font color="red"><?php echo $this->_tpl_vars['msg']; ?>
</font>
<?php endif; ?>
</form>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['SFS_TEMPLATE'])."/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>