{{* $Id: book_query_borrow_data.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
{{include file="$SFS_TEMPLATE/book_header.tpl"}}

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
	height:40px;
	text-align:center;
	font-weight:normal;
	padding:2px 4px 2px 4px ;
	margin:0;
}

table.formdata td {
	border: 1px solid #5F6F7E;
	text-align:center;
	padding:2px 4px 2px 4px ;
	margin:0;
}

table.formdata td.out {
	border: 1px solid #5F6F7E;
	text-align:center;
	color: #FF0000;
	padding:2px 4px 2px 4px ;
	margin:0;
}

table.formdata tr {
	background-color: #FFFFFF;
	color: #000000;
	height:40px;
}

table.formdata tr:hover {
	background-color: #F0F0F0;
	color: #000000;
	height:40px;
}

table.formdata tr.altrow {
	background-color: #DFE7F2;
	color: #000000;
	height:40px;
}

table.formdata tr.altrow:hover {
	background-color: #F8F8F8;
	color: #000000;
	height:40px;
}
-->
</style>

<table width="100%" style="border: 1px solid #5F6F7E; border-collapse:collapse;"><tr><td align="center" bgcolor='#DDFF78'>
<table width="90%" class="formdata">
  <caption style="color:blue;font-size:20px;">
  <br>���ٹϮ�<br>&nbsp;
  </caption>
  <tr>
    <th scope="row" width="15%">����ϮѤ�����</th>
    <th scope="row" width="10%">���X��</th>
    <th scope="row">�ѦW</th>
    <th scope="row" width="15%">�ɾ\���</th>
    <th scope="row" width="15%">���٤��</th>
  </tr>
{{foreach from=$data_arr item=v key=i}}
  <tr>
    <td{{if $data_arr.$i.yet > 0}} class="out"{{/if}}>{{$data_arr.$i.bookch1_id}}</td>
    <td{{if $data_arr.$i.yet > 0}} class="out"{{/if}}>{{$data_arr.$i.book_id}}</td>
    <td{{if $data_arr.$i.yet > 0}} class="out"{{/if}}>{{$data_arr.$i.book_name}}</td>
    <td{{if $data_arr.$i.yet > 0}} class="out"{{/if}}>{{$data_arr.$i.out_d}}</td>
    <td{{if $data_arr.$i.yet > 0}} class="out"{{/if}}>{{$data_arr.$i.re_d}}</td>
  </tr>
{{foreachelse}}
  <tr>
    <td colspan="5" align="center">�z�ثe�L�ɾ\���</td>
  </tr>
{{/foreach}}
</table>
<table width="90%" class="formdata">
  <caption style="color:blue;font-size:20px;">
  <br>�w���Ϯ�<br>&nbsp;
  </caption>
  <tr>
    <th scope="row" width="15%">����ϮѤ�����</th>
    <th scope="row" width="10%">���X��</th>
    <th scope="row">�ѦW</th>
    <th scope="row" width="15%"></th>
  </tr>
  <tr>
    <td colspan="4" align="center">�z�ثe�L�w�����</td>
  </tr>
</table>
<p>&nbsp;</p>
</td></tr></table>

{{include file="$SFS_TEMPLATE/book_footer.tpl"}}