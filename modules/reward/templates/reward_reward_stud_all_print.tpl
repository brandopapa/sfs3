{{* $Id: reward_reward_stud_all_print.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
<table border="0">
<tr>
<td colspan="6"><font size="4">{{$school_base.sch_cname}}�ǥͭӤH���g���Ӫ�</font></td>
</tr>
<tr>
<td colspan="6">�ǥ;Ǹ��G{{$smarty.post.stud_id}}</td>
</tr>
<tr>
<td colspan="2">�ǥͩm�W�G{{$stud_base.stud_name}}</td>
</tr>
<tr>
<td colspan="6">�C�����G{{$smarty.now|date_format:"%Y-%m-%d"}}</td>
</tr>
<tr>
<td colspan="7"><hr size="2"></td>
</tr>
<tr class="title_sbody2">
<td align="center"><span style="font-size:10pt;">�Ǧ~</span></td>
<td align="center"><span style="font-size:10pt;">�Ǵ�</span></td>
<td align="center"><span style="font-size:10pt;">���g�ƥ�</span></td>
<td align="center"><span style="font-size:10pt;">���g���O</span></td>
<td align="center"><span style="font-size:10pt;">���g�̾�</span></td>
<td align="center" width="80"><span style="font-size:10pt;">���g�ͮĤ��</span></td>
<td align="center" width="80"><span style="font-size:10pt;">�P�L���</span></td>
</tr>
<tr><td colspan="7"><hr size="2"></tr>
{{foreach from=$reward_rows item=d}}
{{assign var=r_id value=$d.reward_kind}}
{{assign var=sel_year value=$d.reward_year_seme|@substr:0:-1}}
{{assign var=sel_seme value=$d.reward_year_seme|@substr:-1:1}}
{{assign var=k value=$d.reward_kind|@abs}}
{{if $d.reward_kind>0}}{{assign var=j value=0}}{{else}}{{assign var=j value=3}}{{/if}}
{{if $k==1}}{{php}}$this->_tpl_vars['t'][$this->_tpl_vars['j']+3]++;{{/php}}{{/if}}
{{if $k==2}}{{php}}$this->_tpl_vars['t'][$this->_tpl_vars['j']+3]+=2;{{/php}}{{/if}}
{{if $k==3}}{{php}}$this->_tpl_vars['t'][$this->_tpl_vars['j']+2]++;{{/php}}{{/if}}
{{if $k==4}}{{php}}$this->_tpl_vars['t'][$this->_tpl_vars['j']+2]+=2;{{/php}}{{/if}}
{{if $k==5}}{{php}}$this->_tpl_vars['t'][$this->_tpl_vars['j']+1]++;{{/php}}{{/if}}
{{if $k==6}}{{php}}$this->_tpl_vars['t'][$this->_tpl_vars['j']+1]+=2;{{/php}}{{/if}}
{{if $k==7}}{{php}}$this->_tpl_vars['t'][$this->_tpl_vars['j']+1]+=3;{{/php}}{{/if}}
<tr class="title_sbody1">
<td align="center"><span style="font-size:10pt;">{{$sel_year}}</span></td>
<td align="center"><span style="font-size:10pt;">{{$sel_seme}}</span></td>
<td align="left"><span style="font-size:10pt;">{{$d.reward_reason}}</span></td>
<td align="center"><span style="font-size:10pt;">{{$reward_kind.$r_id}}</span></td>
<td align="left"><span style="font-size:10pt;">{{$d.reward_base}}</span></td>
<td align="center"><span style="font-size:10pt;">{{$d.reward_date}}</span></td>
<td align="center"><span style="font-size:10pt;">{{if $r_id>0}}---{{elseif $d.reward_cancel_date=="0000-00-00"}}���P�L{{else}}{{$d.reward_cancel_date}}{{/if}}</span></td>
</tr>
{{/foreach}}
<tr>
<td colspan="7"><hr size="2"></td>
</tr>
<tr>
<td colspan="7">
<table width="100%">
<tr>
<td align="center">�j�\</td>
<td align="center">�p�\</td>
<td align="center">�ż�</td>
<td align="center">�j�L</td>
<td align="center">�p�L</td>
<td align="center">ĵ�i</td>
</tr>
<tr>
{{foreach from=$f item=d key=i}}
{{assign var=tt value=$t.$i}}
<td align="center">{{$tt|@intval}}��</td>
{{/foreach}}
</tr>
</table>
</td>
</tr>
<tr>
<td colspan="7"><hr size="2"></td>
</tr>
</table>
