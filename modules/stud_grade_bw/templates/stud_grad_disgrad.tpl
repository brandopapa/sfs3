{{* $Id: stud_grad_disgrad.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
<script>
var rd=0;
function tagall(name,status) {
  var i =0;

  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].id==name) {
      document.myform.elements[i].checked=status;
    }
    i++;
  }
}
function check(name) {
  var i=0,j=0;

  if (rd!=1) return true;
  while (i < document.myform.elements.length) {
    if (document.myform.elements[i].id==name) {
      if (document.myform.elements[i].checked==1) {
        j=1;
      }
    }
    i++;
  }
  if (j==0) {
  	alert('����ǥ�');
  	return false;
  }
  return true;
}
</script>
<table border="0" cellspacing="1" cellpadding="2" width="100%" bgcolor="#cccccc">
<form name="myform" method="post" action="{{$smarty.server.PHP_SELF}}" OnSubmit="return check('sel[]')">
<tr><td bgcolor='#FFFFFF'>
<table width="100%">
<tr>
<td>{{$year_seme_menu}} {{$class_year_menu}} <select name="years" size="1" style="background-color:#FFFFFF;font-size:13px" onchange="this.form.submit()";><option value="5" {{if $smarty.post.years==5}}selected{{/if}}>���Ǵ�</option><option value="6" {{if $smarty.post.years==6}}selected{{/if}}>���Ǵ�</option></select>{{if $smarty.post.year_name}} <input type="submit" name="friendly_print" value="�͵��C�L">{{/if}}{{if $smarty.post.year_name && $smarty.post.years==6}} <input type="submit" name="disgrade" value="�O���׷~�W��" OnClick="rd=1">{{/if}}<br>
<input type="checkbox" checked>�ǲ߻�쥭�����Z�b60���H�W�̥��F<input type="text" name="fail_num" size="1" value="{{if $smarty.post.fail_num == ""}}3{{else}}{{$smarty.post.fail_num}}{{/if}}">�� <font color="red">(����)</font><br>
{{if $smarty.post.years==6}}<input type="checkbox" name="chk_last"{{if $smarty.post.chk_last}}checked{{/if}} OnChange="this.form.submit();">�B�Ĥ��Ǵ��ǲ߻�쥭�����Z�b60���H�W�̥��F<input type="text" name="last_fail_num" size="1" value="{{if $smarty.post.last_fail_num == ""}}3{{else}}{{$smarty.post.last_fail_num}}{{/if}}">��{{/if}}</td>
</tr>
{{if $smarty.post.year_name}}
<tr><td>
<table border="0" cellspacing="1" cellpadding="4" width="100%" bgcolor="#cccccc" class="main_body">
<tr bgcolor="#E1ECFF" align="center">
<td><input type="checkbox" name="sel_all" onClick="javascript:tagall('sel[]',document.myform.sel_all.checked);"></td>
<td>�Z��</td>
<td>�y��</td>
<td>�Ǹ�</td>
<td>�m�W</td>
<td>�y��</td>
<td>�ƾ�</td>
<td>�۵M�P�ͬ����</td>
<td>���|</td>
<td>���d�P��|</td>
<td>���N�P�H��</td>
<td>��X</td>
<td>�έp</td>
</tr>
{{foreach from=$show_sn item=sc key=sn}}
<tr bgcolor="#ddddff" align="center">
<td {{if $smarty.post.chk_last}}rowspan="2"{{/if}}><input type="checkbox" id="sel[]" name="sel[{{$sn}}]" value="{{$sclass[$sn]}}" {{if $smarty.post.sel.$sn}}checked{{/if}}></td>
<td {{if $smarty.post.chk_last}}rowspan="2"{{/if}}>{{$sclass[$sn]}}</td>
<td {{if $smarty.post.chk_last}}rowspan="2"{{/if}}>{{$snum[$sn]}}</td>
<td {{if $smarty.post.chk_last}}rowspan="2"{{/if}}>{{$stud_id[$sn]}}</td>
<td {{if $smarty.post.chk_last}}rowspan="2"{{/if}}>{{$stud_name[$sn]}}</td>
{{foreach from=$show_ss item=ssn key=ss}}
<td>{{if $fin_score.$sn.$ss.avg.score < 60}}<font color="red">{{/if}}{{$fin_score.$sn.$ss.avg.score}}{{if $fin_score.$sn.$ss.avg.score < 60}}</font>{{/if}}</td>
{{/foreach}}
<td>{{$fin_score.$sn.ng}}</td>
</tr>
{{if $smarty.post.chk_last}}
<tr bgcolor="#ddddff" align="center">
{{foreach from=$show_ss item=ssn key=ss}}
<td>{{if $fin_score.$sn.$ss.$si.score < 60}}<font color="red">{{/if}}{{$fin_score.$sn.$ss.$si.score}}{{if $fin_score.$sn.$ss.$si.score < 60}}</font>{{/if}}</td>
{{/foreach}}
</tr>
{{/if}}
{{/foreach}}
</table>
</td></tr>
{{/if}}
</tr>
</table>
</td></tr>
</form>
</table>
{{include file="$SFS_TEMPLATE/footer.tpl"}}