{{* $Id: score_nor_disgrad2.tpl 8492 2015-08-19 12:53:57Z brucelyc $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
{{assign var=semeday2 value=$smarty.post.semeday2}}
<table border="0" cellspacing="1" cellpadding="2" width="100%" bgcolor="#cccccc">
<tr><td bgcolor='#FFFFFF'>
<form name="menu_form" method="post" action="{{$smarty.server.PHP_SELF}}">
<table width="100%">
<tr>
<td>{{$year_seme_menu}} {{$class_year_menu}}
<select name="years" size="1" style="background-color:#FFFFFF;font-size:13px" onchange="this.form.submit()";><option value="5" {{if $smarty.post.years==5}}selected{{/if}}>���Ǵ�</option><option value="6" {{if $smarty.post.years==6}}selected{{/if}}>���Ǵ�</option></select>
<select name="item" size="1" style="background-color:#FFFFFF;font-size:13px" onchange="this.form.submit()";><option value="0" {{if !$smarty.post.item}}selected{{/if}}>�Դk</option><option value="1" {{if $smarty.post.item}}selected{{/if}}>���g</option></select><br>
{{if $smarty.post.item}}
<input type="checkbox" name="chk3" checked OnClick="this.form.submit();">�b�Ǵ����O���T�j�L(�t)�H�W��<span style="color:blue;"> (�t���֭p�G�T��ĵ�i���@���p�L�A�T���p�L���@���j�L)</span><br>
<input type="checkbox" name="neu" {{if $smarty.post.neu}}checked{{/if}} OnClick="this.form.submit();" value="1">�\�L���۩�<span style="color:blue;">(�Ȳέp�g��)</span><br>
{{else}}
<input type="checkbox" name="chk1" {{if $smarty.post.chk1}}checked{{/if}} OnClick="this.form.submit();">���@�Ǵ��m�ҡB�ư��W�L<input type="text" name="semeday" value="{{$smarty.post.semeday}}" style="width:20pt" OnChange="this.form.submit();">�`<br>
<input type="checkbox" name="chk3" {{if $smarty.post.chk3}}checked{{/if}} OnClick="this.form.submit();">���X�u���F2/3(67%)�A�U�Ǵ����X�u�`�`�Ƭ�<input type="text" name="tdays" value="{{$smarty.post.tdays}}" style="width: 30pt;">�`<br>
{{/if}}
<span style="color:red;">(�Ш̦U�����W�w���)</span><br>
{{if $smarty.post.item}}
���G1.���έp��K�A�p��ɥ������⦨ĵ�i�P�ż����ơA���ƥN��ż��A�t�ƥN��ĵ�i�A�̫�z��X�`�Ƥj��ε���G�Q�C��ĵ�i�̡C<br>
�@�@2.�Y���g�ĳv�������̡A�Х��N�U�Ǵ������g�������s�έp�A�_�h�w�P�L���������i��Q�έp�b���C<br>
�@�@3.�Y���g�ľǴ������`�ƪ̡A�Цۦ榩���P�L�����A�_�h�z��X���ǥͥi�঳�~�C
{{/if}}
</td>
</tr>
{{if $smarty.post.year_name}}
<tr><td>
<table border="0" cellspacing="1" cellpadding="4" width="100%" bgcolor="#cccccc" class="main_body">
<tr bgcolor="#E1ECFF" align="center">
<td>�Z��</td>
<td>�y��</td>
<td>�Ǹ�</td>
<td>�m�W</td>
{{foreach from=$show_year item=i key=j}}
<td>{{$i}}�Ǧ~��<br>��{{$show_seme[$j]}}�Ǵ�
{{if !$smarty.post.item}}
<br>
{{if $smarty.post.chk1}}���m�`��{{/if}}
{{if $smarty.post.chk1 && $smarty.post.chk2}} | {{/if}}
{{if $smarty.post.chk2}}��L�`��{{/if}}
{{/if}}
</td>
{{/foreach}}
{{if $smarty.post.item}}
<td>�X�p</td>
{{/if}}
{{if $smarty.post.chk3}}
<td>���m<br>�`�`��</td>
<td>���X�u<br>�`�`��</td>
<td>�X�u�v</td>
{{/if}}
</tr>
{{foreach from=$show_sn item=sc key=sn}}
{{assign var=dall value=0}}
{{assign var=sall value=0}}
<tr bgcolor="#ddddff" align="center">
<td>{{$sclass[$sn]}}</td>
<td>{{$snum[$sn]}}</td>
<td>{{$stud_id[$sn]}}</td>
<td>{{$stud_name[$sn]}}</td>
{{foreach from=$semes item=si key=sj}}
{{if $smarty.post.item}}
<td>{{$fin_score.$sn.$si.rew.all|intval}}</td>
{{else}}
{{assign var=c value=$fin_score.$sn.$si.abs.all|intval}}
<td>
{{if $smarty.post.chk1}}<span {{if $fin_score.$sn.$si.abs.3 >= $smarty.post.semeday}}style="color:red;"{{/if}}>{{$fin_score.$sn.$si.abs.3|intval}}</span>{{/if}}
{{if $smarty.post.chk1 && $smarty.post.chk2}} | {{/if}}
{{if $smarty.post.chk2}}{{$fin_score.$sn.$si.abs.all-$fin_score.$sn.$si.abs.3|intval}}{{/if}}
</td>
{{assign var=dall value=$dall+$fin_score.$sn.$si.abs.3}}
{{assign var=sall value=$sall+$fin_score.$sn.$si.abs.all-$fin_score.$sn.$si.abs.3}}
{{/if}}
{{/foreach}}
{{if $smarty.post.item}}
<td>{{$fin_score.$sn.all.rew.all}}</td>
{{/if}}
{{if $smarty.post.chk3}}
<td>{{$dall}}</td>
{{assign var=stotal value=$smarty.post.tdays-$sall}}
<td>{{$stotal}}</td>
{{assign var=rtotal value=$stotal-$dall}}
{{php}}
$this->_tpl_vars['rr'] = round($this->_tpl_vars['rtotal'] * 100 / $this->_tpl_vars['stotal']); 
{{/php}}
<td><span style="color: {{if $rr<67}}red{{else}}black{{/if}};">{{$rr}}%</span></td>
{{/if}}
</tr>
{{/foreach}}
</table>
</td></tr>
{{/if}}
</tr>
</table>
</td></tr>
</table>
{{include file="$SFS_TEMPLATE/footer.tpl"}}
