CKEDITOR.editorConfig = function( config ) {
	config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];

	config.removeButtons = 'HorizontalRule,Font,SpecialChar,Flash,Smiley,PageBreak,Iframe,About,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,Save,Preview,Print,BidiLtr,Language,BidiRtl,HiddenField,NewPage,Source,Templates,Undo,Redo,Replace,Find,SelectAll,Scayt,Blockquote,Anchor,Table,Format,Maximize,ShowBlocks,Subscript,Superscript,CreateDiv,PasteFromWord,PasteText,Paste,Copy,Cut,FontSize';
	config.format_tags = 'p;h1;h2;h3;pre';
	config.autoParagraph = false;
	config.filebrowserUploadUrl = 'ckupload.php';
	config.language = 'es';
	config.enterMode = CKEDITOR.ENTER_BR;
	config.image_previewText = ' ';
};
