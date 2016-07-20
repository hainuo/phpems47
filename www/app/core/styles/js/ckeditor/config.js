/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */
CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.filebrowserUploadUrl = 'index.php?document-api-uploadfile';
	config.filebrowserImageUploadUrl = 'index.php?document-api-upload';
    config.filebrowserFlashUploadUrl = 'index.php?document-api-upload';
    config.filebrowserMusicUploadUrl = 'index.php?document-api-upload&action=music';
    config.allowedContent = true;
	config.height = '250px';
	//config.extraPlugins = 'music';
	config.extraPlugins = 'music';
	config.toolbar = [
		['Source','Preview','-','Templates'],
		['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print'],
		['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
		'/',
		['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
		['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		['Link','Unlink','Anchor'],
		['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
		'/',
		['Styles','Format','Font','FontSize'],
		['TextColor','MathJax','BGColor','music']
	];
	CKEDITOR.config.contentsCss = ['app/core/styles/js/ckeditor/contents.css','app/core/styles/css/bootstrap.css', 'app/exam/styles/css/mathquill.css'];
};
