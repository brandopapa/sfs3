{{* $Id: stud_query_stud_kind_explode.tpl 5310 2009-01-10 07:57:56Z hami $ *}}

<style type="text/css">
<!--
table.formdata {
	border: 1px solid #5F6F7E;
	border-collapse:collapse ;
}

table.formdata th {
	border: 1px solid #5F6F7E;
	background-color:#E2E2E2;
	color:#000000 ;
	text-align:left;
	font-weight:normal;
	padding:2px 4px 2px 4px ;
	margin:0;
}

table.formdata td {
	border: 1px solid #5F6F7E;
	padding:2px 4px 2px 4px ;
	margin:0;
	font-size:11pt;
}

table.formdata tr.altrow {
	background-color: #DFE7F2;
	color: #000000;
}

table.formdata  tr:hover {
	background-color: #CCCCCC;
	color: #000000;
}

table.formdata tr.altrow:hover {
	background-color: #CCCCCC;
	color: #000000;
}

table.formdata th.out {
	background-color:#99CCCC;
}
-->
</style>

<form name ="base_form" action="{{$smarty.server.PHP_SELF}}" method="post" >
<input type="submit" name="csv_out" value="�ץXCSV��">
<input type="hidden" name="stud_kind" value="{{$curr_kind}}">
<table class="formdata" >
	<tr> 
		<th>�����O</th>
		<th>�Ǹ�</th>
		<th>�Z��</th>
		<th>�y��</th>
		<th>�m�W</th>
		<th>�ʧO</th>
		<th>�����Ҹ�</th>
		<th>�ͤ�</th>
		<th>�a�}</th>
		<th>�q��</th>
		<th>����</th>
		<th>����</th>
		<th>���@�H</th>
	</tr>
	{{section loop=$data_arr name=arr_key}}
		<tr>
			<td>{{$stud_kind}}
			<td>{{$data_arr[arr_key].stud_id}}
			{{assign var=cid value=$data_arr[arr_key].stud_class}}
			<td>{{$class_arr[$cid]}}
			<td>{{$data_arr[arr_key].stud_site}}
			<td>{{$data_arr[arr_key].stud_name}}
			{{assign var=sex value=$data_arr[arr_key].stud_sex}}
			<td>{{$sex_arr[$sex]}}
			<td>{{$data_arr[arr_key].stud_person_id}}
			<td>{{$data_arr[arr_key].stud_birthday}}
			<td>{{$data_arr[arr_key].stud_addr_2}}
			<td>{{$data_arr[arr_key].stud_tel_2}}
			<td>{{$data_arr[arr_key].fath_name}}
			<td>{{$data_arr[arr_key].moth_name}}
			<td>{{$data_arr[arr_key].guardian_name}}
		</tr>
	{{/section}}
</table>
</form>