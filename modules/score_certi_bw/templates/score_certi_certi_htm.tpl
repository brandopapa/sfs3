{{* $Id: score_certi_certi_htm.tpl 6605 2011-10-25 07:47:18Z infodaes $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
<script>
function tagall(name,status) {
  var i =0;

  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].name==name) {
      document.myform.elements[i].checked=status;
    }
    i++;
  }
}
function check() {
  var i=0,j=0,k=0;

  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].name=='sel_stud[]') {
      if (document.myform.elements[i].checked==1) {
        j=1;
      }
    }
    if (document.myform.elements[i].name=='sel_seme[]') {
      if (document.myform.elements[i].checked==1) {
        k=1;
      }
    }
    i++;
  }
  if (j==0) {
  	alert('����ǥ�');
  	return false;
  }
  if (k==0) {
  	alert('����Ǵ�');
  	return false;
  }
  return true;
}
</script>
<table border="0" cellspacing="1" cellpadding="2" width="100%" bgcolor="#cccccc">
<tr><td bgcolor='#FFFFFF'>
<form name="myform" method="post" action="{{$smarty.server.PHP_SELF}}" OnSubmit="return check('sel_stud[]')">
<table width="100%">
<tr>
<td>{{$year_seme_menu}} {{$class_year_menu}} {{if $smarty.post.year_seme}}{{$class_name_menu}}{{/if}}
{{if $smarty.post.me}}
<font size=2 color='red'>�@�@�����Z��ܪ���סG<select name='precision'><option value=0>���</option><option value=1 selected>�p��1��</option><option value=2>�p��2��</option></select></font>
<table>
<tr valign="top"><td>
<fieldset>
<legend><font color="#000088">�ǥͿ��</font></legend>
<table border="1">
{{foreach from=$stud_study_cond item=cond key=i}}
{{if $i mod 5 == 0}}<tr class="title_sbody1">{{/if}}
<td align="left"><input type="checkbox" id="c_{{$stud_id[$i]}}" name="sel_stud[]" value="{{$student_sn[$i]}}">{{$stud_site.$i}}.{{$stud_name[$i]}}{{if $cond != 0 && $cond != 5}}<font color="#ff0000">({{$study_cond.$cond}})</font>{{/if}}</td>
{{if $i mod 5 == 4}}</tr>{{/if}}
{{/foreach}}
</table>
<input type="button" value="����" onClick="javascript:tagall('sel_stud[]',1);"><input type="button" value="��������" onClick="javascript:tagall('sel_stud[]',0);">
</fieldset>
<span class="small"><input type="checkbox" name="include_nor">�t���`���Z <input type="checkbox" name="include_avg" checked>�t����  <input type="checkbox" name="include_no">�t�ҩ��r�C  �_�l���G<input type="text" name="start_no" size=3 value=""></span> <br>
<input type="submit" name="form1" value="�C�L���Z��"><input type="submit" name="form1" value="�C�L�^�妨�Z��">
<input type="hidden" name="stud_study_year" value="{{$stud_study_year}}">
</td><td>
<fieldset>
<legend><font color="#000088">�Ǵ����</font></legend>
<table border="1">
{{foreach from=$show_year item=year key=j}}
<tr class="title_sbody1">
<td><input type="checkbox" id="y_{{$semes.$j}}" name="sel_seme[]" value="{{$year}}_{{$show_seme.$j}}" checked>{{$year}}�Ǧ~�ײ�{{$show_seme.$j}}�Ǵ�</td>
</tr>
{{/foreach}}
</table>
<input type="button" value="����" onClick="javascript:tagall('sel_seme[]',1);"><input type="button" value="��������" onClick="javascript:tagall('sel_seme[]',0);">
</fieldset>
</td><td>
<fieldset>
<legend><font color="#000088">�˦����</font></legend>
<table border="1">
<tr class="title_sbody1">
<td align="left"><input type="radio" name="sel_sty" value="1" checked>²����<br>�@�@<font color="#FF0000">(�л\�аȳB�W��)</font></td>
</tr>
<tr class="title_sbody1">
<td align="left" nowrap><input type="radio" name="sel_sty" value="2">�зǫ�<br>�@�@<font color="#FF0000">(�л\�ժ��B�s��H��)</font></td>
</tr>
<tr class="title_sbody1">
<td align="left" nowrap><input type="radio" name="sel_sty" value="3">������<br>�@�@<font color="#FF0000">(�л\�ժ��B�x����)</font></td>
</tr>
</table>
</fieldset>
<fieldset>
<legend><font color="#000088">�ȱi���</font></legend>
<table border="1" width="100%">
<tr class="title_sbody1">
<td align="left"><input type="radio" name="sel_paper" value="1">A4�C�i�@�H</td>
</tr>
<tr class="title_sbody1">
<td align="left"><input type="radio" name="sel_paper" value="2" checked>A4�C�i��H</td>
</tr>
</table>
</fieldset>
</td></tr>
</table>
{{*����*}}
<table class="small" width="100%">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;">
	<ol>
	<li>�����Z�p��ɱN�H�u�Ǵ���]�w�v���u�p��Ǵ��U����`�����[�v�Ҧ��v�]�w���ѦҡA�p�G�S���]�w�γ]�w���u�ǲ߻���ƥ����v�A�p��ɱN�H�U��ⵥ��ҭp��F�p�G�]�w���u�Ǥ����[�v�����v�A�h�p��ɱN�H�ҵ{�]�w�ɪ��[�v���p��C</li>
	</ol>
</td></tr>
</table>
</td></tr>
{{/if}}
</table>
</form>
</td></tr>
</tr>
</table>
</td></tr>
</table>
{{include file="$SFS_TEMPLATE/footer.tpl"}}
