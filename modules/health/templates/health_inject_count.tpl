{{* $Id: health_inject_count.tpl 5690 2009-10-19 06:20:51Z brucelyc $ *}}

{{if $smarty.post.class_name}}<input type="submit" name="print" value="�͵��C�L">{{/if}}

<table cellspacing="0" cellpadding="0"><tr>
<td style="vertical-align:top;">
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="5" class="small" style="text-align:center;">
<tr style="background-color:#c4d9ff;text-align:center;">
<td rowspan="2">�Z�O</td>
<td colspan="2">�d�d���G</td>
<td colspan="1" nowrap>�d���]</td>
<td colspan="3">B���x���̭]</td>
<td colspan="4">�p��·��f�A�̭]</td>
<td colspan="4">�ճ�}�˭��ʤ�y<br>�V�X�̭]</td>
<td colspan="1">�¯l<br>�̭]</td>
<td colspan="1" nowrap>�¯l�|<br>�����w<br>��¯l<br>�V�X��<br>�]</td>
<td colspan="3">�饻�����l�]</td>
</tr>
{{php}}$this->_tpl_vars['v'][9][9]=$this->_tpl_vars['v'][1][9]+$this->_tpl_vars['v'][2][9];{{/php}}
<tr style="background-color:#c4d9ff;text-align:center;">
<td nowrap>�ǥ�<br>�H��</td>
<td nowrap>���d<br>�H��</td>
<td nowrap>�@��</td>
<td nowrap>�Ĥ@��</td>
<td nowrap>�ĤG��</td>
<td nowrap>�ĤT��</td>
<td nowrap>�Ĥ@��</td>
<td nowrap>�ĤG��</td>
<td nowrap>�ĤT��</td>
<td nowrap>�ĥ|��</td>
<td nowrap>�Ĥ@��</td>
<td nowrap>�ĤG��</td>
<td nowrap>�ĤT��</td>
<td nowrap>�ĥ|��</td>
<td nowrap>�@��</td>
<td nowrap>�@��</td>
<td nowrap>�Ĥ@��</td>
<td nowrap>�ĤG��</td>
<td nowrap>�ĤT��</td>
</tr>
{{foreach from=$rowdata item=d key=i}}
{{if $i!="total"}}
<tr style="background-color:{{cycle values="white,#f4feff"}};">
<td>{{$i}}</td>
<td>{{$d.total}}</td>
<td>{{$d.y|intval}}</td>
<td>{{$d.1.1|intval}}</td>
<td>{{$d.2.1|intval}}</td>
<td>{{$d.2.2|intval}}</td>
<td>{{$d.2.3|intval}}</td>
<td>{{$d.3.1|intval}}</td>
<td>{{$d.3.2|intval}}</td>
<td>{{$d.3.3|intval}}</td>
<td>{{$d.3.4|intval}}</td>
<td>{{$d.4.1|intval}}</td>
<td>{{$d.4.2|intval}}</td>
<td>{{$d.4.3|intval}}</td>
<td>{{$d.4.4|intval}}</td>
<td>{{$d.6.1|intval}}</td>
<td>{{$d.7.1|intval}}</td>
<td>{{$d.5.1|intval}}</td>
<td>{{$d.5.2|intval}}</td>
<td>{{$d.5.3|intval}}</td>
</tr>
{{/if}}
{{/foreach}}
<tr style="background-color:#c4d9ff;text-align:center;">
<td nowrap>�X�p</td>
<td>{{$rowdata.total.total}}</td>
<td>{{$rowdata.total.y|intval}}</td>
<td>{{$rowdata.total.1.1|intval}}</td>
<td>{{$rowdata.total.2.1|intval}}</td>
<td>{{$rowdata.total.2.2|intval}}</td>
<td>{{$rowdata.total.2.3|intval}}</td>
<td>{{$rowdata.total.3.1|intval}}</td>
<td>{{$rowdata.total.3.2|intval}}</td>
<td>{{$rowdata.total.3.3|intval}}</td>
<td>{{$rowdata.total.3.4|intval}}</td>
<td>{{$rowdata.total.4.1|intval}}</td>
<td>{{$rowdata.total.4.2|intval}}</td>
<td>{{$rowdata.total.4.3|intval}}</td>
<td>{{$rowdata.total.4.4|intval}}</td>
<td>{{$rowdata.total.6.1|intval}}</td>
<td>{{$rowdata.total.7.1|intval}}</td>
<td>{{$rowdata.total.5.1|intval}}</td>
<td>{{$rowdata.total.5.2|intval}}</td>
<td>{{$rowdata.total.5.3|intval}}</td>
</tr>
<tr style="background-color:#c4d9ff;text-align:center;">
<td nowrap>���d�v<br>��<br>���زv</td>
<td>{{$rowdata.total.total}}</td>
<td>{{$rowdata.total.y/$rowdata.total.total*100|round:2}}%</td>
<td>{{$rowdata.total.1.1/$rowdata.total.total*100|round:2}}%</td>
<td>{{$rowdata.total.2.1/$rowdata.total.total*100|round:2}}%</td>
<td>{{$rowdata.total.2.2/$rowdata.total.total*100|round:2}}%</td>
<td>{{$rowdata.total.2.3/$rowdata.total.total*100|round:2}}%</td>
<td>{{$rowdata.total.3.1/$rowdata.total.total*100|round:2}}%</td>
<td>{{$rowdata.total.3.2/$rowdata.total.total*100|round:2}}%</td>
<td>{{$rowdata.total.3.3/$rowdata.total.total*100|round:2}}%</td>
<td>{{$rowdata.total.3.4/$rowdata.total.total*100|round:2}}%</td>
<td>{{$rowdata.total.4.1/$rowdata.total.total*100|round:2}}%</td>
<td>{{$rowdata.total.4.2/$rowdata.total.total*100|round:2}}%</td>
<td>{{$rowdata.total.4.3/$rowdata.total.total*100|round:2}}%</td>
<td>{{$rowdata.total.4.4/$rowdata.total.total*100|round:2}}%</td>
<td>{{$rowdata.total.6.1/$rowdata.total.total*100|round:2}}%</td>
<td>{{$rowdata.total.7.1/$rowdata.total.total*100|round:2}}%</td>
<td>{{$rowdata.total.5.1/$rowdata.total.total*100|round:2}}%</td>
<td>{{$rowdata.total.5.2/$rowdata.total.total*100|round:2}}%</td>
<td>{{$rowdata.total.5.3/$rowdata.total.total*100|round:2}}%</td>
</tr>
</table>
</td></tr></table>
