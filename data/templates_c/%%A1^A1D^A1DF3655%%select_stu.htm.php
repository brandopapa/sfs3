<?php /* Smarty version 2.6.26, created on 2016-01-27 20:23:43
         compiled from /home/sfs6/dev3.sfs3.bwsh.kindn.es/modules/chc_mend/templates/select_stu.htm */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'string_format', '/home/sfs6/dev3.sfs3.bwsh.kindn.es/modules/chc_mend/templates/select_stu.htm', 60, false),)), $this); ?>
<script type="text/javascript">
function check_all_select(obj,cName)
{
    
    var checkboxs = document.getElementsByName(cName);
    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;}
    //alert(cName);
}
</script>
<TABLE border=0 width=100% cellspacing='1' cellpadding=1>

<TR bgcolor=#9EBCDD>


<td width=100%  style="vertical-align: top;" colspan=2>
<!-- ��1�椺�e -->

<?php echo $this->_tpl_vars['this']->sel_year; ?>
<?php echo $this->_tpl_vars['this']->sel_grade; ?>
 <FONT  COLOR="#FFFFFF"><B>�ҵ{�]�w�C��</B></FONT>
</td>
</tr>
<TR bgcolor=#9EBCDD>
<td colspan=2>
<!-- �Z�Ÿ�ưϬq --�}�l-->
<?php if ($_GET['Y'] != '' && $_GET['G'] != ''): ?>

<TABLE  border=0 width=100% style='font-size:10pt;' cellspacing='1' cellpadding=1  >
<TR bgcolor=white>
<?php $_from = $this->_tpl_vars['this']->scope; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['KK'] => $this->_tpl_vars['ii']):
?>
<?php if ($_GET['S'] == $this->_tpl_vars['KK']): ?>
<td bgcolor="#9EBCDD"><label><input type="checkbox" value="<?php echo $this->_tpl_vars['KK']; ?>
" onclick="location.href='<?php echo $_SERVER['PHP_SELF']; ?>
?Y=<?php echo $this->_tpl_vars['this']->Y; ?>
&G=<?php echo $this->_tpl_vars['this']->G; ?>
&S=<?php echo $this->_tpl_vars['KK']; ?>
'"   checked="checked"><?php echo $this->_tpl_vars['KK']; ?>
.<?php echo $this->_tpl_vars['ii']; ?>
</label></td>
<?php else: ?>  
<td ><label><input type="checkbox" value="<?php echo $this->_tpl_vars['KK']; ?>
" 
onclick="location.href='<?php echo $_SERVER['PHP_SELF']; ?>
?Y=<?php echo $this->_tpl_vars['this']->Y; ?>
&G=<?php echo $this->_tpl_vars['this']->G; ?>
&S=<?php echo $this->_tpl_vars['KK']; ?>
'" ><?php echo $this->_tpl_vars['KK']; ?>
.<?php echo $this->_tpl_vars['ii']; ?>
</label></td>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</TR>
</TABLE>
<?php endif; ?>

<TABLE  border="0" cellspacing="1" cellpadding="4" width="100%" bgcolor="#cccccc" class="main_body" >

<tr bgcolor="#E1ECFF" align="center">
<td>����<input type="checkbox" name="all" onclick="check_all_select(this,'sel[]')"</td>
<td>�Z��</td><td>�y��</td><td>�Ǹ�</td><td>�m�W</td></td><?php $_from = $this->_tpl_vars['this']->link_ss; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ssn'] => $this->_tpl_vars['sn']):
?><td><?php echo $this->_tpl_vars['sn']; ?>
</td><?php endforeach; endif; unset($_from); ?><td>����</td></tr>

<form action=<?php echo $_SERVER['PHP_SELF']; ?>
 method="post">

<?php $_from = $this->_tpl_vars['this']->all_ary; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ssn'] => $this->_tpl_vars['sn']):
?>
<TR bgcolor=white>
<td><input type="checkbox" id="" name="sel[]" value="<?php echo $this->_tpl_vars['sn']['student_sn']; ?>
_n_<?php echo $this->_tpl_vars['sn']['average']; ?>
" <?php if ($this->_tpl_vars['sn']['average'] < 60): ?>  checked="checked"<?php endif; ?>></td>
<td><?php echo $this->_tpl_vars['sn']['seme_class']; ?>
</td>
<td><?php echo $this->_tpl_vars['sn']['seme_num']; ?>
</td>
<td><?php echo $this->_tpl_vars['sn']['stud_id']; ?>
</td>
<td><?php echo $this->_tpl_vars['sn']['stud_name']; ?>
</td>

<?php $_from = $this->_tpl_vars['this']->link_ss; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['link_ssn'] => $this->_tpl_vars['link_sn']):
?>
<td><font <?php if ($this->_tpl_vars['sn'][$this->_tpl_vars['link_ssn']] < 60): ?>color=#EE5566<?php endif; ?>><?php echo $this->_tpl_vars['sn'][$this->_tpl_vars['link_ssn']]; ?>
</font></td>
<?php endforeach; endif; unset($_from); ?>

<td><font <?php if ($this->_tpl_vars['sn']['average'] < 60): ?>color=#EE5566<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['sn']['average'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
</font></td>
</TR>
<?php endforeach; endif; unset($_from); ?>
</TABLE>

<TABLE  border="0" cellspacing="1" cellpadding="4" width="100%" bgcolor="#cccccc" class="main_body" >
<TR bgcolor=white>
<TD align=center>
<INPUT TYPE="reset"  value='���]' class=bur2 >

<INPUT TYPE=button  value='�N�_��̦C�J�ɦҦW�U' onclick="if( window.confirm('�T�w�C�J�ɦҦW�U�H�T�w�H')){this.form.form_act.value='saveData';this.form.submit()}" class=bur2>
<INPUT TYPE='hidden' NAME='form_act'  value=''>
<INPUT TYPE="hidden" name='S' value='<?php echo $this->_tpl_vars['this']->S; ?>
'>
<INPUT TYPE="hidden" name='Y' value='<?php echo $this->_tpl_vars['this']->Y; ?>
'>
<INPUT TYPE="hidden" name='G' value='<?php echo $this->_tpl_vars['this']->G; ?>
'>

</tr>
</form>
</TABLE>
</TABLE>







<BR><BR>

���G<div style="font-size:9pt;color:blue">


<FONT SIZE="2" >
<DIV style="color:blue" onclick="alert('�}�o�p�աG\n���� ���K�e ��n �\�ʳ�\n�G�L ������ �M�� ���۶v\n�j�� ���T�� �M�F ���Q�I\n���� �L�ئ� ���� ��@��\n\n�N�����ѡG\n�u�� �\�ݭs �_�� �C�Q��\n���Y �x�Qã �G�� �����\n��� �I�ӥ� �ª� �}�d�f');">
��By ���ƿ��ǰȨt�ζ}�o�p��  �� 103.10 </DIV></FONT>


