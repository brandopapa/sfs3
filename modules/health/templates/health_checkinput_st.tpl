{{* $Id: health_checkinput_st.tpl 6440 2011-05-16 05:57:02Z brucelyc $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
<link href="js/DropDownControl.css"rel="stylesheet" type="text/css"/>
<script src="js/DropDownControl.js" language="javascript"></script>
<script type="text/javascript" src="{{$SFS_PATH_HTML}}javascripts/jquery.min.js"></script>
<script type="text/javascript" src="{{$SFS_PATH_HTML}}javascripts/setinnerhtml.js"></script>
<script>
<!--
function fillall() {
	var i =0;

	while (i < document.myform.elements.length)  {
		a=document.myform.elements[i].id.substring(0,1);
		if (a=='v') {
			document.myform.elements[i].value='0';
		}
		i++;
	}
}
function renew(num) {
	$.post('{{$smarty.server.SCRIPT_NAME}}',{ sub_menu_id: 12, year_seme: "{{$smarty.post.year_seme}}", class_name: "{{$smarty.post.class_name}}", student_sn: "{{$smarty.post.student_sn}}", ajax: "ajax", colnum: num, act: "checkinput_st"},function(data){
		if (data!=''){
			$("#Oral").val(data);
			$("#inputForm").removeAttr('target');
			$("#act").val('checkinput_st');
		}
	});
}
-->
</script>

<table border="0" cellspacing="1" cellpadding="2" width="100%" bgcolor="#cccccc">
<tr><td bgcolor="white">
<table border="0"><tr><td valign="top">
{{*���*}}
<table class="tableBg" cellspacing="1" cellpadding="1">
<tr><td align="center" class="leftmenu">
{{$stud_menu}}
</td>
</tr>
</table>
</td><td valign="top">

{{if $smarty.post.student_sn}}
{{assign var=sn value=$smarty.post.student_sn}}
{{assign var=year_seme value=$smarty.post.year_seme}}
{{assign var=d value=$health_data->health_data.$sn.$year_seme}}
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="4" width="100%" class="small">
<form name="myform" id="inputForm" action="{{$smarty.post.PHP_SELF}}" method="post">
<tr style="color:white;background-color:#aecced;">
<td>����</td>
<td>
�νs�G<span style="color:blue;">{{$health_data->stud_base.$sn.stud_person_id}}</span> &nbsp; 
<input type="button" value="���]���L����" OnClick="fillall();">
</td>
</tr>

<tr bgcolor="white">
<td>��</td>
<td>
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Oph][1]" id="v01" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Oph.1}}"> ���O���}
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Oph][1]" value="{{$d.checks.Oph.1}}">
<input type="checkbox" disabled="true" {{if $d.r.My || $d.l.My}}checked{{/if}}>���
<input type="checkbox" disabled="true" {{if $d.r.Hy || $d.l.Hy}}checked{{/if}}>����
<input type="checkbox" disabled="true" {{if $d.r.Ast || $d.l.Ast}}checked{{/if}}>����
<input type="checkbox" disabled="true" {{if $d.r.Amb || $d.l.Amb}}checked{{/if}}>�z��
<input type="checkbox" disabled="true" {{if $d.r.other || $d.l.other}}checked{{/if}}>��L<input type="text" style="width:75px;" disabled>
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Oph][2]" id="v02" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Oph.2}}"> ���O���`
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Oph][2]" value="{{$d.checks.Oph.2}}">
<br>
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Oph][3]" id="v03" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Oph.3}}"> �׵�<select name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Oph][PS3]">{{html_options options=$squint_kind_arr selected=$d.PSOph3}}</select>
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Oph][3]" value="{{$d.checks.Oph.3}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Oph][4]" id="v04" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Oph.4}}"> ����˴�
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Oph][4]" value="{{$d.checks.Oph.4}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Oph][5]" id="v05" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Oph.5}}"> ���y�_Ÿ
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Oph][5]" value="{{$d.checks.Oph.5}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Oph][6]" id="v06" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Oph.6}}"> ��¥�U��
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Oph][6]" value="{{$d.checks.Oph.6}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Oph][99]" id="v07" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;"> ��L <input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Oph][PS99]" style="width:75px;">
</td>
</tr>
<tr bgcolor="#f4feff">
<td>��ƤH��</td>
<td>
���G<input type="text" style="width:104px;" value="{{$d.checks.Oph.hospital}}"> &nbsp;
��v�G<input type="text" style="width:120px;" value="{{$d.checks.Oph.doctor}}">
</td>
</tr>

<tr bgcolor="white">
<td>�ջ��</td>
<td>
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Ent][1]" id="v08" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Ent.1}}"> ť�O���`<select name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Ent][PS1]">{{html_options options=$audition_kind_arr selected=$d.PSEnt1}}</select>
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Ent][1]" value="{{$d.checks.Ent.1}}">
<br>
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Ent][2]" id="v09" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Ent.2}}"> �æ����ժ�
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Ent][2]" value="{{$d.checks.Ent.2}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Ent][3]" id="v10" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Ent.3}}"> �չD�
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Ent][3]" value="{{$d.checks.Ent.3}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Ent][4]" id="v11" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Ent.4}}"> �B�E��
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Ent][4]" value="{{$d.checks.Ent.4}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Ent][5]" id="v12" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Ent.5}}"> �c�����`
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Ent][5]" value="{{$d.checks.Ent.5}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Ent][6]" id="v13" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Ent.6}}"> �իe����
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Ent][6]" value="{{$d.checks.Ent.6}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Ent][7]" id="v14" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Ent.7}}"> ͪ�����
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Ent][7]" value="{{$d.checks.Ent.7}}">
<br>
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Ent][8]" id="v15" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Ent.8}}"> �C�ʻ�
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Ent][8]" value="{{$d.checks.Ent.8}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Ent][9]" id="v16" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Ent.9}}"> �L�өʻ�
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Ent][9]" value="{{$d.checks.Ent.9}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Ent][10]" id="v17" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Ent.10}}"> ��縢�~�j
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Ent][10]" value="{{$d.checks.Ent.10}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Ent][99]" id="v18" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;"> ��L <input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][O99State]" style="width:75px;">
</td>
</tr>
<tr bgcolor="#f4feff">
<td>��ƤH��</td>
<td>
���G<input type="text" style="width:104px;" value="{{$d.checks.Ent.hospital}}"> &nbsp;
��v�G<input type="text" style="width:120px;" value="{{$d.checks.Ent.doctor}}">
</td>
</tr>

<tr bgcolor="white">
<td>�Y�V</td>
<td>
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Hea][1]" id="v19" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Hea.1}}"> ���V
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Hea][1]" value="{{$d.checks.Hea.1}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Hea][2]" id="v20" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Hea.2}}"> �Ҫ����~
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Hea][2]" value="{{$d.checks.Hea.2}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Hea][3]" id="v21" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Hea.3}}"> �O�ڸ��~�j
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Hea][3]" value="{{$d.checks.Hea.3}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Hea][4]" id="v22" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;"> ��L <input type="text" style="width:75px;">
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Hea][4]" value="{{$d.checks.Hea.4}}">
</td>
</tr>

<tr bgcolor="white">
<td>�ݳ�</td>
<td>
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Pul][1]" id="v23" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Pul.1}}"> �ݹ����`
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Pul][1]" value="{{$d.checks.Pul.1}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Pul][2]" id="v24" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Pul.2}}"> ������
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Pul][2]" value="{{$d.checks.Pul.2}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Pul][3]" id="v25" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Pul.3}}"> �߫ߤ���
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Pul][3]" value="{{$d.checks.Pul.3}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Pul][4]" id="v26" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Pul.4}}"> �I�l�n���`
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Pul][4]" value="{{$d.checks.Pul.4}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Pul][99]" id="v27" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;"> ��L <input type="text" style="width:75px;">
</td>
</tr>

<tr bgcolor="white">
<td>����</td>
<td>
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Dig][1]" id="v28" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Dig.1}}"> �x�ʸ~�j
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Dig][1]" value="{{$d.checks.Dig.1}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Dig][2]" id="v29" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Dig.2}}"> ����
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Dig][2]" value="{{$d.checks.Dig.2}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Dig][99]" id="v30" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;"> ��L <input type="text" style="width:75px;">
</td>
</tr>

<tr bgcolor="white">
<td>��W�|��</td>
<td>
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Spi][1]" id="v31" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Spi.1}}"> ��W���s
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Spi][1]" value="{{$d.checks.Spi.1}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Spi][2]" id="v32" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Spi.2}}"> �h�֫�
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Spi][2]" value="{{$d.checks.Spi.2}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Spi][3]" id="v33" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Spi.3}}"> �C���
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Spi][3]" value="{{$d.checks.Spi.3}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Spi][4]" id="v34" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Spi.4}}"> ���`�ܧ�
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Spi][4]" value="{{$d.checks.Spi.4}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Spi][5]" id="v35" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Spi.5}}"> ���~
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Spi][5]" value="{{$d.checks.Spi.5}}">
<br>
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Spi][99]" id="v36" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;"> ��L <input type="text" style="width:75px;">
</td>
</tr>
<tr bgcolor="#f4feff">
<td>��ƤH��</td>
<td>
���G<input type="text" style="width:104px;" value="{{$d.checks.Hea.hospital}}"> &nbsp;
��v�G<input type="text" style="width:120px;" value="{{$d.checks.Hea.doctor}}">
</td>
</tr>

<tr bgcolor="white">
<td>�c���ʹ�</td>
<td>
{{if $health_data->stud_base.$sn.stud_sex==1}}
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Uro][1]" id="v37" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Uro.1}}"> ���A
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Uro][1]" value="{{$d.checks.Uro.1}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Uro][2]" id="v37" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Uro.2}}"> ���n�~�j
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Uro][2]" value="{{$d.checks.Uro.2}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Uro][3]" id="v38" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Uro.3}}"> �]�ֲ��`
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Uro][3]" value="{{$d.checks.Uro.3}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Uro][4]" id="v39" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Uro.4}}"> ����R�ߦ��i
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Uro][4]" value="{{$d.checks.Uro.4}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Uro][99]" id="v40" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;"> ��L <input type="text" style="width:75px;">
{{else}}
<span style="color:red;">�k�ʧK��</span>
{{/if}}
</td>
</tr>
<tr bgcolor="#f4feff">
<td>��ƤH��</td>
<td>
���G<input type="text" style="width:104px;" value="{{$d.checks.Uro.hospital}}"> &nbsp;
��v�G<input type="text" style="width:120px;" value="{{$d.checks.Uro.doctor}}">
</td>
</tr>

<tr bgcolor="white">
<td>�ֽ�</td>
<td>
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Der][1]" id="v41" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Der.1}}"> �~
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Der][1]" value="{{$d.checks.Der.1}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Der][2]" id="v42" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Der.2}}"> ��
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Der][2]" value="{{$d.checks.Der.2}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Der][3]" id="v43" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Der.3}}"> ����
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Der][3]" value="{{$d.checks.Der.3}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Der][4]" id="v44" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Der.4}}"> �νH
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Der][4]" value="{{$d.checks.Der.4}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Der][5]" id="v45" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Der.5}}"> �ïl
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Der][5]" value="{{$d.checks.Der.5}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Der][6]" id="v46" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Der.6}}"> ����ʥֽ���
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Der][6]" value="{{$d.checks.Der.6}}">
<br>
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Der][99]" id="v47" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;"> ��L <input type="text" style="width:75px;">
</td>
</tr>
<tr bgcolor="#f4feff">
<td>��ƤH��</td>
<td>
���G<input type="text" style="width:104px;" value="{{$d.checks.Der.hospital}}"> &nbsp;
��v�G<input type="text" style="width:120px;" value="{{$d.checks.Der.doctor}}">
</td>
</tr>

<tr bgcolor="white">
<td>�f��</td>
<td>
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Ora][7]" id="v48" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Ora.7}}"> �T��
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Ora][7]" value="{{$d.checks.Ora.7}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Ora][8]" id="v49" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Ora.8}}"> �ʤ�
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Ora][8]" value="{{$d.checks.Ora.8}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Ora][1]" id="v50" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Ora.1}}"> �f�Ľåͤ��}
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Ora][1]" value="{{$d.checks.Ora.1}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Ora][2]" id="v51" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Ora.2}}"> ������
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Ora][2]" value="{{$d.checks.Ora.2}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Ora][5]" id="v52" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Ora.5}}"> ���i��
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Ora][5]" value="{{$d.checks.Ora.5}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Ora][3]" id="v53" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Ora.3}}"> ���P��
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Ora][3]" value="{{$d.checks.Ora.3}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Ora][4]" id="v54" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Ora.4}}"> ���C�r�X����
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Ora][4]" value="{{$d.checks.Ora.4}}">
<br>
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Ora][6]" id="v55" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;" value="{{$d.checks.Ora.6}}"> �f���H�����`
<input type="hidden" name="update[old][{{$sn}}][{{$year_seme}}][health_checks_record][Ora][6]" value="{{$d.checks.Ora.6}}">
<input type="text" name="update[new][{{$sn}}][{{$year_seme}}][health_checks_record][Ora][99]" id="v56" OnDblClick="showDropDownItem(this,'{{$diag_str}}',1,0,1);" style="background-color:#FFFFC0;width:16px;"> ��L <input type="text" style="width:75px;">
<input type="image" src="images/mouth3.gif" style="vertical-align:middle;" OnClick="this.form.target='_blank';this.form.act.value='tee_st';"><input type="text" size="1" style="width:170px;color:red;font-size:9pt;" disabled id="Oral" value="{{foreach from=$d item=dd key=k}}{{if ($k|@substr:0:1)=="T"}}{{$k|@substr:1:2}}{{$teesb.$dd}}{{/if}}{{/foreach}}"> �f�˪�
</td>
</tr>
<tr bgcolor="#f4feff">
<td>��ƤH��</td>
<td>
���G<input type="text" style="width:104px;" value="{{$d.checks.Ora.hospital}}"> &nbsp;
��v�G<input type="text" style="width:120px;" value="{{$d.checks.Ora.doctor}}">
</td>
</tr>

</table>
<input type="submit" name="sure" value="�T�w"> <input type="submit" value="����"> <input type="button" OnClick="window.opener.renew(2);window.opener.renew(3);window.close();" value="����������">
<table class="small" style="width:100%;">
<tr style="background-color:#FBFBC4;"><td><img src="../../images/filefind.png" width="16" height="16" hspace="3" border="0">����</td></tr>
<tr><td style="line-height:150%;width:100%;">
	<ol>
	<li>���ӧO�ˬd���ǥͥ~�A��ƤH������ĳ�ѡu�t�οﶵ�]�w�v���u���˸�Ƴ]�w�v�i���J�C</li>
	</ol>
</td></tr>
</table>
</td><td valign="top">
{{*�N�X��*}}
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="4" width="100%" class="small">
<tr style="color:white;background-color:#aecced;">
<td>�N�X��</td>
</tr>
<tr bgcolor="#f4feff">
<td>0.�L����</td>
</tr>
<tr bgcolor="white">
<td>1.���˲��`</td>
</tr>
<tr bgcolor="#f4feff">
<td>2.���˥��`</td>
</tr>
<tr bgcolor="white">
<td>4.���˲��`</td>
</tr>
<tr bgcolor="#f4feff">
<td>9.������</td>
</tr>
</table>
</td>
</tr>
<input type="hidden" name="sub_menu_id" value="{{$smarty.post.sub_menu_id}}">
<input type="hidden" name="year_seme" value="{{$smarty.post.year_seme}}">
<input type="hidden" name="class_name" value="{{$smarty.post.class_name}}">
<input type="hidden" name="student_sn" value="{{$smarty.post.student_sn}}">
<input type="hidden" name="nav_prior" value="{{$smarty.post.nav_prior}}">
<input type="hidden" name="nav_next" value="{{$smarty.post.nav_next}}">
<input type="hidden" id="act" name="act" value="{{$smarty.post.act}}">
</form></table>
{{/if}}
</td></tr></table>
</td></tr></table>
</td>
</tr>
</form>
</table>

{{include file="$SFS_TEMPLATE/footer.tpl"}}
