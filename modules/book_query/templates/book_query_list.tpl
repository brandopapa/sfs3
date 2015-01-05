{{* $Id: book_query_list.tpl 5310 2009-01-10 07:57:56Z hami $ *}}
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
	height:20px;
}

table.formdata tr:hover {
	background-color: #F0F0F0;
	color: #000000;
	height:20px;
}

table.formdata tr.altrow {
	background-color: #DFE7F2;
	color: #000000;
	height:20px;
}

table.formdata tr.altrow:hover {
	background-color: #F8F8F8;
	color: #000000;
	height:20px;
}
-->
</style>
<script>
<!--
function query_act(a)
{
	document.query_form.query.value=a;
	document.query_form.submit();
}
-->
</script>

<table width="100%" style="border: 1px solid #5F6F7E; border-collapse:collapse;"><tr><td align="center" bgcolor='#DDFF78'>
<form name ="query_form" action="{{$smarty.server.PHP_SELF}}" method="post">
<table width="90%" class="formdata">
  <caption style="color:blue;font-size:20px;">
  <br>�d�ߵ��G<br>&nbsp;
  </caption>
  <tr>
    <th scope="row" width="5%">�ǧO</th>
    <th scope="row">�ѦW</th>
    <th scope="row" width="20%">�@��</th>
    <th scope="row" width="20%">�X����</th>
    <th scope="row" width="10%">�X�����</th>
    <th scope="row" width="5%">���A</th>
  </tr>
{{foreach from=$data_arr name=data item=v key=i}}
{{if $i>=$smarty.post.start_num && $i<($smarty.post.start_num+$smarty.post.num)}}
  <tr {{if $i mod 2 == 1}}class="altrow"{{/if}}>
    <td>{{$i+1}}</td>
    <td><a href="{{$smarty.server.PHP_SELF}}?act=display&book_id={{$data_arr.$i.book_id}}">{{$data_arr.$i.book_name}}</a></td>
    <td>{{$data_arr.$i.book_author}}</td>
    <td>{{$data_arr.$i.book_maker}}</td>
    <td>{{$data_arr.$i.book_myear}}</td>
{{assign var=s value=$data_arr.$i.book_isout}}
    <td>{{$book_status_arr.$s}}</td>
  </tr>
{{/if}}
{{foreachelse}}
  <tr>
    <td colspan="6" align="center">�䤣��ŦX�d�߱��󪺸��</td>
  </tr>
{{/foreach}}
</table>
<br>
�� {{$data_num}} �� / �@ {{$data_nums}} ��&nbsp;&nbsp;
{{if $smarty.post.start_num != 0}}
<input type="button" OnClick="query_act('pre_est')" value="�Ĥ@��">
<input type="button" OnClick="query_act('pre')" value="�W{{$smarty.post.num}}��">
{{/if}}
<input type="submit" value="���s�d��">
{{if $smarty.post.start_num+$smarty.post.num < $smarty.foreach.data.total}}
<input type="button" OnClick="query_act('next')" value="�U{{$smarty.post.num}}��">
<input type="button" OnClick="query_act('next_est')" value="�̥���">
{{/if}}
<input type="hidden" name="num" value="{{$smarty.post.num}}">
<input type="hidden" name="start_num" value="{{$smarty.post.start_num}}">
<input type="hidden" name="query" value="">
<br>&nbsp;
</td></tr>
</form></table>

{{include file="$SFS_TEMPLATE/book_footer.tpl"}}