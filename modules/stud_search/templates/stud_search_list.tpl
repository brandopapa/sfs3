<!-- $Id: stud_search_list.tpl 5934 2010-04-28 02:42:30Z brucelyc $ -->
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
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
	background-color:#FFFFFF;
	padding:2px 4px 2px 4px ;
	margin:0;
}



table.formdata tr.altrow {
	background-color: #DFE7F2;
	color: #000000;
}

table.formdata tr:hover {
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
<table width="100%" style="border: 1px solid #5F6F7E; border-collapse:collapse;"><tr><td align="center" bgcolor='#FFF158'>
<table width="90%" class="formdata">
  <caption>
  �Ǹ��G{{$data.stud_id}} -- {{$data.stud_name}} 
  </caption>
  <tr>
    <th scope="row">�Z��</th>
    <td>{{$class_arr[$data.class_num]}}</td>
    <th>�y��</td>
    <td>{{$data.site_num}}</td>
    <th>�N�Ǫ��A</td>
    <td>{{if $data.stud_study_cond==5}}{{$grad_arr.$grad_kind}}{{else}}{{$study_cond[$data.stud_study_cond]}}{{/if}}</td>

  </tr>
  <tr>
    <th scope="row">�����Ҹ��X</th>
    <td>{{$data.stud_person_id}}</td>
    <th>�ͤ�</td>
    <td>{{$data.stud_birthday}}</td>
    <th>�ʧO</td>
    <td>{{$sex_arr[$data.stud_sex]}}</td>
  </tr>
  <tr>
    <th scope="row">�J�ǫe{{if $is_jhores==0}}���X��{{else}}��p{{/if}}</th>
    <td colspan="5">{{if $is_jhores==0}}{{$data.stud_preschool_name}}{{else}}{{$data.stud_mschool_name}}{{/if}}</td>
  </tr>
  <tr>
    <th scope="row">�J�Ǯ֭�r��</th>
    <td colspan="5">{{$cword.13}}</td>
  </tr>
{{if $grad_word_str!=""}}
  <tr>
    <th scope="row">���׷~�֭�r��</th>
    <td colspan="5">{{$cword.5}}</td>
  </tr>
  <tr>
    <th scope="row">���~��r��</th>
    <td colspan="5">{{$grad_word_str}}</td>
  </tr>
{{/if}}
  <tr>
    <th scope="row">���y�a�}</th>
    <td colspan="5">{{$data.stud_addr_1}}</td>
  </tr>
  <tr>
    <th scope="row">�p���a�}</th>
    <td colspan="5">{{$data.stud_addr_2}}</td>
  </tr>  
  <tr>
    <th scope="row">���y�q��</th>
    <td>{{$data.stud_tel_1}}</td>
    <th>�s���q��</th>
    <td>{{$data.stud_tel_2}}</td>
    <th>��ʹq��</th>
    <td>{{$data.stud_tel_3}}</td>
  </tr>
  <tr>
    <th scope="row">����</th>
    <td>{{$data_d.fath_name}}</td>
    <th>�A�ȳ��</th>
    <td>{{$data_d.fath_unit}}</td>    
    <th>¾��</th>
    <td>{{$data_d.fath_work_name}}</td> 
  </tr>
  <tr>    
    <th>�q��(��)</th>
    <td>{{$data_d.fath_phone}}</td>
    <th>�q��(�v)</th>
    <td>{{$data_d.fath_home_phone}}</td>
    <th>��ʹq��</th>
    <td>{{$data_d.fath_hand_phone}}</td>        
  </tr>
  <tr>
    <th scope="row">����</th>
    <td>{{$data_d.moth_name}}</td>
    <th> �A�ȳ�� </td>
    <td>{{$data_d.moth_unit}}</td>    
    <th> ¾�� </td>
    <td>{{$data_d.moth_work_name}}</td> 
  </tr>
  <tr>    
    <th> �q��(��) </td>
    <td>{{$data_d.moth_phone}}</td>
    <th> �q��(�v)</td>
    <td>{{$data_d.moth_home_phone}}</td>
    <th> ��ʹq�� </td>
    <td>{{$data_d.moth_hand_phone}}</td>        
  </tr>  
</table>
<p>&nbsp;</p>
</td></tr></table>
{{include file="$SFS_TEMPLATE/footer.tpl"}}
