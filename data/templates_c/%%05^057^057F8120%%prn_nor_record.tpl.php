<?php /* Smarty version 2.6.26, created on 2015-02-13 12:09:26
         compiled from prn_nor_record.tpl */ ?>
<!-- $Id: prn_nor_record.tpl 7690 2013-10-23 07:39:00Z smallduh $  -->

<?php if ($this->_tpl_vars['break_page'] != ''): ?><?php echo $this->_tpl_vars['break_page']; ?>
<?php endif; ?>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="610">
<tr>
<td class="empty" rowspan="2" style="font-size: 18pt; line-height: 20pt; font-family: �з���;" align="center"><?php echo $this->_tpl_vars['school_name']; ?>
 �ǥͺ�X��{�O����</td>
<td class="empty" style="font-size: 12pt; line-height: 14pt;" align="left">�Ǹ��G<?php echo $this->_tpl_vars['base']['stud_id']; ?>
</td>
</tr>
<tr>
<td class="empty" style="font-size: 12pt; line-height: 14pt;" align="left">�m�W�G<?php echo $this->_tpl_vars['base']['stud_name']; ?>
</td>
</tr>
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="610">
	<tbody><tr>
		<td class="top_left">�����Ҧr��</td>
		<td class="top"><?php echo $this->_tpl_vars['base']['stud_person_id']; ?>
</td>
		<td class="top">�X�ͦ~���</td>
		<td class="top"><?php echo $this->_tpl_vars['base']['stud_birthday']; ?>
</td>
<?php $this->assign('sex', $this->_tpl_vars['base']['stud_sex']); ?>
		<td class="top">�ʧO</td>
		<td class="top"><?php echo $this->_tpl_vars['sex_kind'][$this->_tpl_vars['sex']]; ?>
</td>
		<td class="top_right" rowspan="5" style="width: 3.6cm; height: 4.6cm;"><?php echo $this->_tpl_vars['base']['stud_photo_src']; ?>
</td>
	</tr>
	<tr>
		<td class="left_left">�s���q��</td>
		<td><?php echo $this->_tpl_vars['base']['stud_tel_2']; ?>
</td>
		<td>�s���H</td>
		<td><?php echo $this->_tpl_vars['base']['guardian_name']; ?>
</td>
		<td>���Y</td>
		<td><?php echo $this->_tpl_vars['guar_kind'][$this->_tpl_vars['base']['guardian_relation']]; ?>
</td>
	</tr>
	<tr>
		<td class="left_left">�s����}</td>
		<td colspan="5" align="left">&nbsp;&nbsp;<?php echo $this->_tpl_vars['base']['stud_addr_2']; ?>
</td>
	</tr>
	<tr>
		<td class="left_left">�J�Ǹ��</td>
		<td><?php echo $this->_tpl_vars['base']['stud_mschool_name']; ?>
</td>
		<td>��(��)�~�ҮѦr��</td>
		<td colspan="3"><?php echo $this->_tpl_vars['base']['grade_word_num']; ?>
</td>
	</tr>
	<tr>
		<td class="left_left">���ʱ���</td>
		<td colspan="5" style="vertical-align: top;"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "prn_move.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
	</tr>
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="610">
	<tbody>
	<tr style="height: 16pt;">
		<td class="both_top" width="50">�Ǵ��O</td><td class="middle_top" width="50">�Ǧ~��</td><td class="middle_top" width="70">�Z�Ůy��</td><td class="middle_right">���`�ͬ���{</td>
	</tr>
<?php $_from = $this->_tpl_vars['seme_ary']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['semes'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['semes']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['grade_seme'] => $this->_tpl_vars['data']):
        $this->_foreach['semes']['iteration']++;
?>
	<tr style="height: 16pt;">
		<td class="both" width="50"><?php echo $this->_tpl_vars['data']['cseme']; ?>
</td><td class="middle_top" width="50"><?php echo $this->_tpl_vars['data']['year']; ?>
</td><td class="middle_top" width="70"><?php if ($this->_tpl_vars['data']['num']): ?><?php echo $this->_tpl_vars['data']['num']; ?>
<?php else: ?>---<?php endif; ?></td><td class="middle_right" style="text-align:left;">&nbsp;&nbsp;<?php if ($this->_tpl_vars['data']['memo']): ?><?php echo $this->_tpl_vars['data']['memo']; ?>
<?php else: ?>---<?php endif; ?></td>
	</tr>
<?php endforeach; endif; unset($_from); ?>
	</tbody>
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="610">
	<tbody>
	<tr style="height: 16pt;">
		<td class="both_top" width="50" rowspan="2">�Ǵ��O</td>
		<td class="middle_right" colspan="6">���g���� (��)</td>
		<td class="middle_right" colspan="6">�X�ʮu���� (�`)</td>
	</tr>
	<tr style="height: 16pt;">
		<td class="middle_top">�j�\</td>
		<td class="middle_top">�p�\</td>
		<td class="middle_top">�ż�</td>
		<td class="middle_top">�j�L</td>
		<td class="middle_top">�p�L</td>
		<td class="middle_right">ĵ�i</td>
		<td class="middle_top">�ư�</td>
		<td class="middle_top">�f��</td>
		<td class="middle_top">�m��</td>
		<td class="middle_top">���|</td>
		<td class="middle_top">����</td>
		<td class="middle_right">��L</td>
	</tr>
<?php $_from = $this->_tpl_vars['seme_ary']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['semes'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['semes']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['grade_seme'] => $this->_tpl_vars['data']):
        $this->_foreach['semes']['iteration']++;
?>
	<tr style="height: 16pt;">
		<td class="both"><?php echo $this->_tpl_vars['data']['cseme']; ?>
</td>
<?php $_from = $this->_tpl_vars['rew_data'][$this->_tpl_vars['grade_seme']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['rew'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['rew']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['d']):
        $this->_foreach['rew']['iteration']++;
?>
		<td class="<?php if ($this->_foreach['rew']['iteration'] == 6): ?>middle_right<?php else: ?>middle_top<?php endif; ?>"><?php if ($this->_tpl_vars['d']): ?><?php echo $this->_tpl_vars['d']; ?>
<?php else: ?>0<?php endif; ?></td>
<?php endforeach; endif; unset($_from); ?>
<?php $_from = $this->_tpl_vars['abs_data'][$this->_tpl_vars['grade_seme']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['abs'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['abs']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['d']):
        $this->_foreach['abs']['iteration']++;
?>
		<td class="<?php if ($this->_foreach['abs']['iteration'] == 6): ?>middle_right<?php else: ?>middle_top<?php endif; ?>"><?php if ($this->_tpl_vars['d']): ?><?php echo $this->_tpl_vars['d']; ?>
<?php else: ?>0<?php endif; ?></td>
<?php endforeach; endif; unset($_from); ?>
	</tr>
<?php endforeach; endif; unset($_from); ?>
<tr style="height: 16pt;">
  <td class="both_top">�p�p</td>
	<?php $_from = $this->_tpl_vars['rew_data_total']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['rew_total'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['rew_total']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['d']):
        $this->_foreach['rew_total']['iteration']++;
?>
			<td class="<?php if ($this->_foreach['rew_total']['iteration'] == 6): ?>middle_right<?php else: ?>middle_top<?php endif; ?>"><?php if ($this->_tpl_vars['d']): ?><?php echo $this->_tpl_vars['d']; ?>
<?php else: ?>0<?php endif; ?></td>
	<?php endforeach; endif; unset($_from); ?>
	<?php $_from = $this->_tpl_vars['abs_data_total']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['abs_total'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['abs_total']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['d']):
        $this->_foreach['abs_total']['iteration']++;
?>
			<td class="<?php if ($this->_foreach['abs_total']['iteration'] == 6): ?>middle_right<?php else: ?>middle_top<?php endif; ?>"><?php if ($this->_tpl_vars['d']): ?><?php echo $this->_tpl_vars['d']; ?>
<?php else: ?>0<?php endif; ?></td>
	<?php endforeach; endif; unset($_from); ?>  
</tr>

	</tbody>
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="610">
	<tbody>
	<tr style="height: 16pt;">
		<td class="left_left" width="70">���g���</td>
		<td class="middle_top" width="50">�Ǵ��O</td>
		<td class="middle_top" width="70">���g���O</td>
		<td class="middle_top">���g�ƥ�</td>
		<td class="middle_right" width="50">�P�L</td>
	</tr>
<?php $_from = $this->_tpl_vars['rew_record']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['d']):
?>
	<tr style="height: 16pt;">
		<td class="left_left"><?php echo $this->_tpl_vars['d']['reward_date']; ?>
</td>
<?php $this->assign('sid', $this->_tpl_vars['d']['reward_year_seme']); ?>
		<td class="middle_top"><?php echo $this->_tpl_vars['seme_arr2'][$this->_tpl_vars['sid']]; ?>
</td>
<?php $this->assign('rid', $this->_tpl_vars['d']['reward_kind']); ?>
		<td class="middle_top"><?php echo $this->_tpl_vars['reward_arr'][$this->_tpl_vars['rid']]; ?>
</td>
		<td class="middle_top" style="text-align:left">&nbsp;<?php echo $this->_tpl_vars['d']['reward_reason']; ?>
</td>
		<td class="middle_right"><?php if ($this->_tpl_vars['d']['reward_div'] == 1): ?>---<?php else: ?><?php if ($this->_tpl_vars['d']['reward_cancel_date'] == "0000-00-00"): ?>�_<?php else: ?>�O<?php endif; ?><?php endif; ?></td>
	</tr>
<?php endforeach; endif; unset($_from); ?>
	</tbody>
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="610">
	<tbody>
	<tr style="height: 16pt;">
		<td class="left_left" width="50">�Ǵ��O</td>
		<td class="middle_top" width="100">���ΦW��</td>
		<td class="middle_top" width="50">�ˮ�</td>
		<td class="middle_top" width="125">���ηF��</td>
		<td class="middle_right" width="285">�Z�ŷF��</td>
	</tr>
	<?php $_from = $this->_tpl_vars['club']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['d']):
?>
	<tr style="height: 16pt;">
	<?php $this->assign('sid', $this->_tpl_vars['d']['seme_year_seme']); ?>
		<td class="left_left"><?php echo $this->_tpl_vars['seme_arr2'][$this->_tpl_vars['sid']]; ?>
</td>
		<td class="middle_top"><?php echo $this->_tpl_vars['d']['association_name']; ?>
</td>
		<td class="middle_top"><?php echo $this->_tpl_vars['d']['pass_txt']; ?>
</td>
		<td class="middle_top" width="125"><?php if ($this->_tpl_vars['title_arr'][$this->_tpl_vars['sid']]['club_title'] == ''): ?>---<?php else: ?><?php echo $this->_tpl_vars['title_arr'][$this->_tpl_vars['sid']]['club_title']; ?>
<?php endif; ?></td>
		<td class="middle_right" width="285"><?php if ($this->_tpl_vars['title_arr'][$this->_tpl_vars['sid']]['class_title'] == ''): ?>---<?php else: ?><?php echo $this->_tpl_vars['title_arr'][$this->_tpl_vars['sid']]['class_title']; ?>
<?php endif; ?></td>
	</tr>	
	<?php endforeach; endif; unset($_from); ?>
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="610">
	<tbody>
	<tr style="height: 16pt;">
		<td class="left_left" width="50">�Ǵ��O</td>
		<td class="middle_top" width="100">���</td>
		<td class="middle_top" width="290">�ѥ[�դ��~���@�A�Ⱦǲߨƶ��ά��ʶ���</td>
		<td class="middle_top" width="70">�ɶ�(��)</td>
		<td class="middle_right" width="100">�D����</td>
	</tr>
	<?php $_from = $this->_tpl_vars['service']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['d']):
?>
	<tr style="height: 16pt;">
	<?php $this->assign('sid', $this->_tpl_vars['d']['year_seme']); ?>
		<td class="left_left"><?php echo $this->_tpl_vars['seme_arr2'][$this->_tpl_vars['sid']]; ?>
</td>
		<td class="middle_top"><?php echo $this->_tpl_vars['d']['service_date']; ?>
</td>
		<td class="middle_top" style="text-align:left;font-size:10pt"><?php echo $this->_tpl_vars['d']['item']; ?>
�G<?php echo $this->_tpl_vars['d']['memo']; ?>
</td>
		<td class="middle_top"><?php echo $this->_tpl_vars['d']['hours']; ?>
</td>
		<td class="middle_right" ><?php echo $this->_tpl_vars['d']['sponsor']; ?>
</td>
	</tr>	
	<?php endforeach; endif; unset($_from); ?>	
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="610">
	<tbody>
<?php if ($this->_tpl_vars['room_sign'] == 1): ?>	
	<tr style="height: 32pt;">
		<td class="left_left" width="20%">�B��ñ��</td>
		<td class="middle_top">�ӿ�H</td>
	</tr>
<?php else: ?>
		<tr style="height: 16pt;">
		<td class="left_left">�s �� �H</td>
		<td class="middle_top">�ǰȥD��</td>
		<td class="middle_right">�ա@�@��</td>
	</tr>
	<tr style="height: 16pt;">
		<td class="bottom_left">&nbsp;</td>
		<td class="bottom_middle">
    <?php if ($this->_tpl_vars['title_img_3']): ?>	
     <img src="<?php echo $this->_tpl_vars['title_img_3']; ?>
" height="120">
    <?php else: ?>
		&nbsp;
		<?php endif; ?>
	  </td>
		<td class="bottom_right">
    <?php if ($this->_tpl_vars['title_img_1']): ?>	
     <img src="<?php echo $this->_tpl_vars['title_img_1']; ?>
" height="120">
    <?php else: ?>
		&nbsp;
		<?php endif; ?>
		</td>	
	</tr>
<?php endif; ?>	
	</tbody>
</table>