<script>
$(function() {

	$("#start_date").datepicker({
		dateFormat: 'yy-mm-dd' ,
		showOn: 'button',
		buttonImage: 'images/calendar.gif',
		buttonImageOnly: true
		 });
	$("#end_date").datepicker({
		dateFormat: 'yy-mm-dd' ,
		showOn: 'button',
		buttonImage: 'images/calendar.gif',
		buttonImageOnly: true
		 });

	$.metadata.setType("attr", "validate");

	$("#signForm").validate();


});
</script>


<form action="" method="post" id="signForm">
<dl>
	<dt>���O:</dt>
	<dd><input type="text" name="title" id="title" size="24" value="<?php if($res->fields['title'])echo $res->fields['title'];else echo date('Y�~m��');?>"  validate="required:true" /></dd>
	<dt>��Z�}�l�ɶ�:</dt>
	<dd><input type="text" name="start_date" id="start_date" size="12"
		value="<?php echo $res->fields['start_date']?>"  validate="required:true" /></dd>
	<dt>��Z�����ɶ�:</dt>
	<dd><input type="text" name="end_date" id="end_date" size="12" value="<?php echo $res->fields['end_date']?>" validate="required:true" /></dd>
	<dt>�O�_�o��:</dt>
	<dd><input type="checkbox" name="is_publish" id="is_publish" value="1" <?php if ($res->fields['is_publish']):?>checked=checked<?php endif?> /></dd>
	<dt></dt>
	<dd><input type="submit" name="act" id="act" value="�T�w" /></dd>
</dl>
<input type="hidden" name="id"  value="<?php echo $res->fields['id']?>" />
</form>
