<?php /* Smarty version 2.6.26, created on 2015-02-26 10:20:55
         compiled from prn_move.tpl */ ?>
<?php echo '<TABLE width=100% valign="top"><TR><TD>日期</TD><TD>類別</TD><TD>核准機關</TD><TD>核准日期</TD><TD '; ?><?php if ($_POST['type'] == 1): ?><?php echo 'class="empty_right"'; ?><?php endif; ?><?php echo '>核准文號</TD></TR>'; ?><?php $_from = $this->_tpl_vars['move_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['move_data']):
?><?php echo '<TR><TD>'; ?><?php echo $this->_tpl_vars['move_data']['move_date']; ?><?php echo '</TD>'; ?><?php $this->assign('mid', $this->_tpl_vars['move_data']['move_kind']); ?><?php echo '<TD>'; ?><?php echo $this->_tpl_vars['move_kind'][$this->_tpl_vars['mid']]; ?><?php echo '</TD><TD>'; ?><?php echo $this->_tpl_vars['move_data']['move_c_unit']; ?><?php echo '</TD><TD>'; ?><?php echo $this->_tpl_vars['move_data']['move_c_date']; ?><?php echo '</TD><TD '; ?><?php if ($_POST['type'] == 1): ?><?php echo 'class="empty_right"'; ?><?php endif; ?><?php echo '>'; ?><?php echo $this->_tpl_vars['move_data']['move_c_word']; ?><?php echo '字<br>'; ?><?php if ($_POST['type'] == 1): ?><?php echo '<br>'; ?><?php else: ?><?php echo ' '; ?><?php endif; ?><?php echo '第'; ?><?php echo $this->_tpl_vars['move_data']['move_c_num']; ?><?php echo '號</TD></TR>'; ?><?php endforeach; endif; unset($_from); ?><?php echo '</TABLE>'; ?>
