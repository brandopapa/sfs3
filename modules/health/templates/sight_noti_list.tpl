<html>
<head>
<meta http-equiv="Content-Type" content="text/html; Charset=Big5">
<title>{{$school_data.sch_cname_s}}�ǥ͵��O���}�M�U</title>
<script type="text/javascript" src="{{$SFS_PATH_HTML}}/javascripts/jquery.min.js"></script>
<style>
table { border:#000 2px solid; border-collapse:collapse; border-spacing:4; margin:auto; width:96% }
tr {background: #F7F7F7; margin:5px; text-align:center}
td ,th{border:#005 thin solid; padding:3px}
caption{font-size:18pt}
</style>
<script>
$(document).ready(function(){
	var manage_item = {"1":"���O�O��","2":"�I�Īv��","3":"�t���B�v","4":"�a�����B�z","5":"�����","6":"�w���ˬd","7":"�B���v��","8":"�t���v��","9":"�t����������","N":"�䥦"}

});
</script>
</head>
<body >
<table>
<caption>{{$school_data.sch_cname_s}}�ǥ͵��O���}�M�U</caption>
<thead>
<tr>
<th rowspan="2">�~��</th>
<th rowspan="2">�Z��</th>
<th rowspan="2">�y��</th>
<th rowspan="2">�m�W</th>
<th colspan="2">�r��</th>
<th colspan="2">�B��</th>
<th colspan="5">�E�_�P�v���]�k���^</th>
<th colspan="5">�E�_�P�v���]�����^</th>
<th rowspan="2">�B�m</th>
<th rowspan="2">�N�E�����|��</th>
</tr>
<tr>
<th>�k��</th>
<th>����</th>
<th>�k��</th>
<th>����</th>
<th>���</th>
<th>����</th>
<th>�z��</th>
<th>����</th>
<th>��L</th>
<th>���</th>
<th>����</th>
<th>�z��</th>
<th>����</th>
<th>��L</th>
</tr>
</thead>
<tbody>
{{foreach from=$data key=class_sn  item=row}}
<tr>
<td>{{$row.l.grade}}</td>
<td>{{$row.l.class}}</td>
<td>{{$row.l.number}}</td>
<td>{{$row.l.stud_name}}</td>
<td>{{$row.r.sight_o}}</td>
<td>{{$row.l.sight_o}}</td>
<td>{{$row.r.sight_r}}</td>
<td>{{$row.l.sight_r}}</td>
<td>{{if $row.r.My}}V{{/if}}</td>
<td>{{if $row.r.Hy}}V{{/if}}</td>
<td>{{if $row.r.Ast}}V{{/if}}</td>
<td>{{if $row.r.Amb}}V{{/if}}</td>
<td>{{if $row.r.other}}V{{/if}}</td>
<td>{{if $row.l.My}}V{{/if}}</td>
<td>{{if $row.l.Hy}}V{{/if}}</td>
<td>{{if $row.l.Ast}}V{{/if}}</td>
<td>{{if $row.l.Amb}}V{{/if}}</td>
<td>{{if $row.l.other}}V{{/if}}</td>
<td>
{{if $row.l.manage_id eq 'N'}}
N.{{$row.l.diag}}
{{else}}
{{if $row.l.manage_id}}{{$row.l.manage_id}}.{{$manage_item[$row.l.manage_id]}}{{/if}}
{{/if}}
</td>
<td>{{if $row.l.hospital}}{{$row.l.hospital}}{{/if}}</td>
</tr>
{{/foreach}}

</tbody>
</table>
<br />
<TABLE WIDTH=100% style="margin:auto;">
<TR style="font-size: 10pt;">
		  <TD WIDTH=25%>�ӿ�H</TD>
		  <TD WIDTH=25%>�ժ�</TD>
		  <TD WIDTH=25%>�D��</TD>
		  <TD WIDTH=25%>�ժ�</TD>
		  </TR>
<tr style="height:60px">
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
</TABLE>
<div style="float:right ;margin:20px;">
�C�L�ɶ� : {{$smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}}
</div>
</body>
</html>