/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	 config.language = 'zh';
	// config.uiColor = '#AADC6E';
config.filebrowserBrowseUrl = 'include/ckfinder/ckfinder.html';
config.filebrowserImageBrowseUrl = 'include/ckfinder/ckfinder.html?Type=Images';
config.filebrowserFlashBrowseUrl = 'include/ckfinder/ckfinder.html?Type=Flash';
//config.filebrowserUploadUrl = 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'; //�i�W�Ǥ@���ɮ�
config.filebrowserImageUploadUrl = 'include/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';//�i�W�ǹ���
config.filebrowserFlashUploadUrl = 'include/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';//�i�W��Flash�ɮ� 

config.skin='kama';

};
