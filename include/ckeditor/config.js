/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.language = 'zh';
	config.skin='kama';
	config.filebrowserBrowseUrl = 'include/ckfinder/ckfinder.html';
  config.filebrowserImageBrowseUrl = 'include/ckfinder/ckfinder.html?Type=Images';
  config.filebrowserFlashBrowseUrl = 'include/ckfinder/ckfinder.html?Type=Flash';
  config.filebrowserImageUploadUrl = 'include/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';//�i�W�ǹ���
  config.filebrowserFlashUploadUrl = 'include/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';//�i�W��Flash�ɮ� 
	
	config.font_names ='Arial/Arial, Helvetica, sans-serif;	Comic Sans MS/Comic Sans MS, cursive;	Courier New/Courier New, Courier, monospace;	Georgia/Georgia, serif;	Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif;	Tahoma/Tahoma, Geneva, sans-serif;	Times New Roman/Times New Roman, Times, serif;	Trebuchet MS/Trebuchet MS, Helvetica, sans-serif;	Verdana/Verdana, Geneva, sans-serif;	�s�ө���;	�з���;	�L�n������' ;
	config.extraPlugins += (config.extraPlugins ?',lineheight' :'lineheight');
};

