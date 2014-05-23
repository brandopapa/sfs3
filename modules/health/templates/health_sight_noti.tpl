{{* $Id: health_sight_noti.tpl 5963 2010-06-15 02:06:54Z hami $ *}}
<style>
#dialog {font-size:12px}
#dialog h1 {font-size:15px}
#dialog li {cursor: pointer; list-style: none;}
.li-selected {border:thin #e00 solid;}
#show_student_name{color:blue; border:#ccc thin double; padding:1px; margin:2px;}
#show_side{color:blue; border:#ccc thin double; padding:1px; margin:2px;}

</style>
<script type="text/javascript" src="{{$SFS_PATH_HTML}}javascripts/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="{{$SFS_PATH_HTML}}javascripts/ui/jquery.ui.position.js"></script>
<script type="text/javascript" src="{{$SFS_PATH_HTML}}javascripts/ui/jquery.ui.resizable.js"></script>
<script type="text/javascript" src="{{$SFS_PATH_HTML}}javascripts/ui/jquery.ui.dialog.js"></script>
<script type="text/javascript" src="{{$SFS_PATH_HTML}}javascripts/external/bgiframe/jquery.bgiframe.js"></script>
<script>

var manage_item = {"1":"���O�O��","2":"�I�Īv��","3":"�t���B�v","4":"�a�����B�z","5":"�����","6":"�w���ˬd","7":"�B���v��","8":"�t���v��","9":"�t����������","N":"�䥦"}
var curr_student_sn = '';
var curr_side ='';
var curr_button = '';
$(document).ready(function(){

 $(".checkAll").click(function(){
	      $.each($(".snCheck"),function(){
	          $(this).attr('checked', !$(this).is(':checked'));
	      });
	 });


	$("#dialog").dialog({bgiframe: true, autoOpen: false, height: 530, modal: true});

	$(".manage_id").click(function(){
		curr_button = $(this);
		var id = $(this).attr('id');
	 	var exploded = id.split('-');
	 	curr_student_sn = exploded[2];
	 	curr_year_seme = exploded[1];
	 	curr_side = exploded[0];
	 	var student_name = $("#student_name-"+curr_student_sn).text();

	 	if (exploded[0]=='l') var side='����'; else var side='�k��';
	 	$("#show_student_name").html(student_name);
	 	$("#show_side").html(side);
		$("#dialog").dialog('open');

	});

	$(".sign").click(function(){
		var id =$(this).attr('id');
		var arr = id.split('_');
		if (arr[0]=='My' && $('#Hy_'+arr[1]+'_'+arr[2]).attr('checked'))
			$('#Hy_'+arr[1]+'_'+arr[2]).attr('checked','');
		else if (arr[0]=='Hy' && $('#My_'+arr[1]+'_'+arr[2]).attr('checked'))
			$('#My_'+arr[1]+'_'+arr[2]).attr('checked','');

		var value = $(this).attr('checked');
		var year_seme = $("select[name='year_seme']").val();

		$.post('ajax-sight-noti.php',{
			type : 'update_sight_noti',
			year_seme : year_seme,
			id : id,
			value: value
			},function(data){});

	});

	$("#save-manage-diag").click(function(){
		updateValue('N');
	});

	$("#manage_item li").click(function(){
		var id = $(this).attr('id').substr(5);
		if (id == 'N') {
			$("#diagDiv").show();
			return;
		}

		updateValue(id);
	});
	// ��s�N�E��|
	$(".hospital").change(function(){
		var id = $(this).attr('id').substr(9);
		var val = $(this).attr('value');
		$.post('ajax-input-sight-status.php',{
			type : 'update_health_sight_hospital',
			id : id,
			val: val
		},function(data){

		});

	});

	// ��s�B�m
	function updateValue(id){
		var year_seme = $("select[name='year_seme']").val();
		var diag = $("#diag").attr('value');
		$.post('ajax-input-sight-status.php',{
			type : 'update_health_sight_manage_id',
			year_seme : year_seme,
			student_sn : curr_student_sn,
			side	: curr_side,
			id: id,
			diag: diag
		},function(data){
			if (data) {
				if (data.length==1)
				$(curr_button).attr('value', data+'.'+manage_item[data]);
				else
				$(curr_button).attr('value', 'N.'+data);
			}
			else
			$(curr_button).attr('value', '..');
			$("#diag").attr('value','');
			$("#diagDiv").hide();
			$("#dialog").dialog('close');
		});
	}

	// �C�L�M��
	$(".printListBtn").click(function(){

		var action = $("form[name='myform']").attr('action');
		$("form[name='myform']").attr('target','_blank');
		$("form[name='myform']").attr('action','sight_noti_list.php');
		$("form[name='myform']").submit();
		$("form[name='myform']").attr('target','');
		$("form[name='myform']").attr('action',action);
	});

	$("#dialog li").hover(
			function(){$(this).addClass('li-selected')},
			function(){$(this).removeClass('li-selected')}
			);
});
</script>

<input type="submit" name="print" value="�C�L�q����">
<input type="button"  class="printListBtn" name="print_list" value="�C�L�M��">
<input type="button"  class="checkAll" value="����/�Ͽ�" >
<span class="small">�^��ú����<input type="text" name="rmonth" size="2">��<input type="text" name="rday" size="2">��</span>
<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="2" class="small">
<tr style="background-color:#c4d9ff;text-align:center;">
<td rowspan="2">��</td>
<td rowspan="2">�~��</td>
<td rowspan="2">�Z��</td>
<td rowspan="2">�y��</td>
<td rowspan="2">�m�W</td>
<td colspan="2">�r��</td>
<td colspan="2">�B��</td>
<td colspan="5">�E�_�P�v���]�k���^</td>
<td colspan="5">�E�_�P�v���]�����^</td>
<td rowspan="2">�B�m</td>
<td rowspan="2">�N�E�����|��</td>
</tr>
<tr style="background-color:#c4d9ff;text-align:center;">
<td>�k��</td>
<td>����</td>
<td>�k��</td>
<td>����</td>
<td>���</td>
<td>����</td>
<td>�z��</td>
<td>����</td>
<td>��L</td>
<td>���</td>
<td>����</td>
<td>�z��</td>
<td>����</td>
<td>��L</td>
</tr>
{{assign var=year_seme value=$smarty.post.year_seme}}
{{assign var=seme_class value=$smarty.post.class_name}}
{{foreach from=$health_data->stud_data item=seme_class key=i}}
{{assign var=year_name value=$i|@substr:0:-2}}
{{assign var=class_name value=$i|@substr:-2:2}}
{{foreach from=$seme_class item=d key=seme_num name=rows}}
{{assign var=j value=$j+1}}
{{assign var=sn value=$d.student_sn}}
{{assign var=dd value=$health_data->health_data.$sn.$year_seme}}
<tr style="background-color:white;">
<td style="background-color:#ce6"><input type="checkbox"  class="snCheck" name="student_sn[]"  value="{{$sn}}"></td>
<td style="background-color:#f4feff;">{{$year_name}}</td>
<td style="background-color:#f4feff;">{{$class_name}}</td>
<td style="background-color:#f4feff;">{{$seme_num}}</td>
<td id="student_name-{{$sn}}" style="color:{{if $health_data->stud_base.$sn.stud_sex==1}}blue{{elseif $health_data->stud_base.$sn.stud_sex==2}}red{{else}}black{{/if}};background-color:#fbf8b9;">{{$health_data->stud_base.$sn.stud_name}}</td>
<td style="text-align:center;color:{{if $dd.r.sight_o<=0.8}}red{{else}}blue{{/if}};">{{$dd.r.sight_o}}</td>
<td style="text-align:center;color:{{if $dd.l.sight_o<=0.8}}red{{else}}blue{{/if}};">{{$dd.l.sight_o}}</td>
<td style="text-align:center;color:{{if $dd.r.sight_r<=0.8}}red{{else}}blue{{/if}};">{{$dd.r.sight_r}}</td>
<td style="text-align:center;color:{{if $dd.l.sight_r<=0.8}}red{{else}}blue{{/if}};">{{$dd.l.sight_r}}</td>
<td><input type="checkbox"  class="sign My" id="My_r_{{$sn}}"  {{if $dd.r.My}}checked{{/if}} /></td>
<td><input type="checkbox"  class="sign Hy" id="Hy_r_{{$sn}}"  {{if $dd.r.Hy}}checked{{/if}} /></td>
<td><input type="checkbox"  class="sign Ast" id="Ast_r_{{$sn}}"  {{if $dd.r.Ast}}checked{{/if}}/></td>
<td><input type="checkbox"  class="sign Amb" id="Amb_r_{{$sn}}" {{if $dd.r.Amb}}checked{{/if}} /></td>
<td><input type="checkbox"  class="sign other" id="other_r_{{$sn}}" {{if $dd.r.other}}checked{{/if}} /></td>

<td><input type="checkbox"  class="sign My" id="My_l_{{$sn}}" {{if $dd.l.My}}checked{{/if}} /></td>
<td><input type="checkbox"  class="sign Hy" id="Hy_l_{{$sn}}" {{if $dd.l.Hy}}checked{{/if}}/></td>
<td><input type="checkbox"  class="sign Ast" id="Ast_l_{{$sn}}" {{if $dd.l.Ast}}checked{{/if}}/></td>
<td><input type="checkbox"  class="sign Amb" id="Amb_l_{{$sn}}" {{if $dd.l.Amb}}checked{{/if}} /></td>
<td><input type="checkbox"  class="sign other" id="other_l_{{$sn}}" {{if $dd.l.other}}checked{{/if}}/></td>
<td>
{{if $dd.l.manage_id eq 'N'}}
<input type="button" id="r-{{$year_seme}}-{{$sn}}" class="manage_id" value="N.{{$dd.l.diag}}" />
{{else}}
<input type="button"  id="l-{{$year_seme}}-{{$sn}}"  class="manage_id" value="{{if $dd.l.manage_id}}{{$dd.l.manage_id}}.{{$manage_item[$dd.l.manage_id]}}{{else}}..{{/if}}" />
{{/if}}
</td>
<td><input type="text" size="6"  id="hospital-{{$year_seme}}-{{$sn}}" class="hospital" value="{{if $dd.l.hospital}}{{$dd.l.hospital}}{{/if}}" />
</td>
</tr>
{{/foreach}}
{{foreachelse}}
<tr><td colspan="27" style="background-color:white;text-align:center;color:red;">�L���</td></tr>
{{/foreach}}
</table>
<input type="submit" name="print" value="�C�L�q����">
<input type="button"  class="printListBtn" name="print_list" value="�C�L�M��">
<input type="button"  class="checkAll" value="����/�Ͽ�" >
</td></tr></table>
</td>
</tr>
</table>

<div id="dialog"  title="�B�m���p�n��">
<p><span id="show_student_name"></span> <span id="show_side"></span> �B�m�n��</p>
<div id="manage_item">
<ul>
{{foreach from=$manage_item key=key item=item}}
<li id="item-{{$key}}">{{$key}}.{{$item}}</li>
{{/foreach}}
<li  id="item-">X ����</li>
</ul>
<div id="diagDiv" style="display:none;">
��L�B�m: <input type="text"  id="diag" size="20" /> <input type="button" id="save-manage-diag" value="�x�s" />
</div>
</div>
</div>