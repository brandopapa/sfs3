{{* $Id: health_input_inject2.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
{{assign var=id value=$smarty.post.work_id2}}

<input type="submit" name="save" value="�T�w�x�s">
<input type="reset" value="����x�s">
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="2" class="small">
<tr bgcolor="#c4d9ff">
{{if $id==0}}
<td rowspan="2" align="center">�y��</td>
<td rowspan="2" align="center">�m�W</td>
<td colspan="2" align="center">ú�檬�p</td>
<td rowspan="2" align="center">�y��</td>
<td rowspan="2" align="center">�m�W</td>
<td colspan="2" align="center">ú�檬�p</td>
</tr>
<tr bgcolor="#c4d9ff">
<td align="center">��ú</td>
<td align="center">�wú</td>
<td align="center">��ú</td>
<td align="center">�wú</td>
</tr>
{{else}}
<td rowspan="2" align="center">�y��</td>
<td rowspan="2" align="center">�m�W</td>
<td rowspan="2" align="center">�J�ǫe<br>���ؾ���</td>
<td colspan="{{$inject_arr.times.$id}}" align="center">�ɺؤ��</td>
<td rowspan="2" align="center">�y��</td>
<td rowspan="2" align="center">�m�W</td>
<td rowspan="2" align="center">�J�ǫe<br>���ؾ���</td>
<td colspan="{{$inject_arr.times.$id}}" align="center">�ɺؤ��</td>
</tr>
<tr bgcolor="#c4d9ff">
<td align="center">�Ĥ@��</td>
{{if $inject_arr.show.$id>1}}
<td align="center">�ĤG��</td>
{{/if}}
{{if $inject_arr.show.$id>2}}
<td align="center">�ĤT��</td>
{{/if}}
{{if $inject_arr.show.$id>3}}
<td align="center">�ĥ|��</td>
{{/if}}
<td align="center">�Ĥ@��</td>
{{if $inject_arr.show.$id>1}}
<td align="center">�ĤG��</td>
{{/if}}
{{if $inject_arr.show.$id>2}}
<td align="center">�ĤT��</td>
{{/if}}
{{if $inject_arr.show.$id>3}}
<td align="center">�ĥ|��</td>
{{/if}}
</tr>
{{/if}}
{{assign var=year_seme value=$smarty.post.year_seme}}
{{assign var=seme_class value=$smarty.post.class_name}}
{{assign var=kid value=1}}
{{foreach from=$health_data->stud_data.$seme_class item=d key=seme_num name=rows}}
{{assign var=sn value=$d.student_sn}}
{{assign var=dd value=$health_data->stud_data.$sn.$year_seme}}
{{assign var=ddd value=$health_data->health_data.$sn}}
{{assign var=times value=$ddd.inject.0.$id.times}}
{{assign var=maxlen value=6}}
{{if $smarty.foreach.rows.iteration % 2==1}}
<tr style="background-color:white;">
{{/if}}
{{counter assign=d}}
<td style="background-color:#f4feff;">{{$seme_num}}</td>
<td style="color:{{if $health_data->stud_base.$sn.stud_sex==1}}blue{{elseif $health_data->stud_base.$sn.stud_sex==2}}red{{else}}black{{/if}};background-color:#fbf8b9;">{{$health_data->stud_base.$sn.stud_name}}</td>
<td align="center">
{{$times}}
</td>
{{php}}
if (!in_array(1,$this->_tpl_vars['inject_arr']['lack'][$this->_tpl_vars['id']][$this->_tpl_vars['inject_arr']['times'][$this->_tpl_vars['id']]-$this->_tpl_vars['ddd']['inject'][0][$this->_tpl_vars['id']]['times']]))
	$this->_tpl_vars['lack1']=1;
else
	$this->_tpl_vars['lack1']=0;
{{/php}}
<td align="center">
{{if $lack1 || $times==""}}-----{{else}}
<input type="text" name="update[new][{{$sn}}][inject][{{$kid}}][{{$id}}][date1]" size="{{$maxlen}}" maxlength="{{$maxlen}}" value="{{if $ddd.inject.$kid.$id.date1!="0000-00-00"}}{{$ddd.inject.$kid.$id.date1|replace:"-":""}}{{/if}}">
{{/if}}
</td>
{{if $inject_arr.show.$id>1}}
{{php}}
if (!in_array(2,$this->_tpl_vars['inject_arr']['lack'][$this->_tpl_vars['id']][$this->_tpl_vars['inject_arr']['times'][$this->_tpl_vars['id']]-$this->_tpl_vars['ddd']['inject'][0][$this->_tpl_vars['id']]['times']]))
	$this->_tpl_vars['lack2']=1;
else
	$this->_tpl_vars['lack2']=0;
{{/php}}
<td align="center">
{{if $lack2 || $times==""}}-----{{else}}
<input type="text" name="update[new][{{$sn}}][inject][{{$kid}}][{{$id}}][date2]" size="{{$maxlen}}" maxlength="{{$maxlen}}" value="{{if $ddd.inject.$kid.$id.date1!="0000-00-00"}}{{$ddd.inject.$kid.$id.date2|replace:"-":""}}{{/if}}">
{{/if}}
</td>
{{/if}}
{{if $inject_arr.show.$id>2}}
{{php}}
if (!in_array(3,$this->_tpl_vars['inject_arr']['lack'][$this->_tpl_vars['id']][$this->_tpl_vars['inject_arr']['times'][$this->_tpl_vars['id']]-$this->_tpl_vars['ddd']['inject'][0][$this->_tpl_vars['id']]['times']]))
	$this->_tpl_vars['lack3']=1;
else
	$this->_tpl_vars['lack3']=0;
{{/php}}
<td align="center">
{{if $lack3 || $times==""}}-----{{else}}
<input type="text" name="update[new][{{$sn}}][inject][{{$kid}}][{{$id}}][date3]" size="{{$maxlen}}" maxlength="{{$maxlen}}" value="{{if $ddd.inject.$kid.$id.date1!="0000-00-00"}}{{$ddd.inject.$kid.$id.date3|replace:"-":""}}{{/if}}">
{{/if}}
</td>
{{/if}}
{{if $inject_arr.show.$id>3}}
{{php}}
if (!in_array(4,$this->_tpl_vars['inject_arr']['lack'][$this->_tpl_vars['id']][$this->_tpl_vars['inject_arr']['times'][$this->_tpl_vars['id']]-$this->_tpl_vars['ddd']['inject'][0][$this->_tpl_vars['id']]['times']]))
	$this->_tpl_vars['lack4']=1;
else
	$this->_tpl_vars['lack4']=0;
{{/php}}
<td align="center">
{{if $lack4 || $times==""}}-----{{else}}
<input type="text" name="update[new][{{$sn}}][inject][{{$kid}}][{{$id}}][date4]" size="{{$maxlen}}" maxlength="{{$maxlen}}" value="{{if $ddd.inject.$kid.$id.date1!="0000-00-00"}}{{$ddd.inject.$kid.$id.date4|replace:"-":""}}{{/if}}">
{{/if}}
</td>
{{/if}}
{{if $smarty.foreach.rows.iteration % 2==0}}
</tr>
{{/if}}
{{/foreach}}
</table>
<input type="submit" name="save" value="�T�w�x�s">
<input type="reset" value="����x�s">
