window.addEvent('domready',function(){
	
	var CKEditor = jQuery('textarea.ckEditor');
	
	// CKEditor
	CKEditor.ckeditor({
		//*
		disableNativeSpellChecker:true,
		scayt_autoStartup:false,
		toolbar:[
			['Bold','Italic','Underline','Strike'],
			['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
			['Undo','Redo'],
			['Paste','PasteText','PasteFromWord'],
			['Find','Replace','-','SelectAll','RemoveFormat','-','Subscript','Superscript'],
			'/',
			['FontSize'],
			['TextColor','BGColor'],
			['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
			['Link','Unlink'],
			['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar'],
			['Templates','Preview','Maximize', 'ShowBlocks','-','Source']
		],
		
		on :{
			instanceReady : function( ev ){
				// Output paragraphs as <p>Text</p>.
				this.dataProcessor.writer.setRules( 'p',
				    {
				        indent : false,
				        breakBeforeOpen : false,
				        breakAfterOpen : false,
				        breakBeforeClose : false,
				        breakAfterClose : true
				    }
				);
				//
				this.dataProcessor.writer.setRules( 'ul',
				    {
				        indent : false,
				        breakBeforeOpen : false,
				        breakAfterOpen : false,
				        breakBeforeClose : false,
				        breakAfterClose : true
				    }
				);
				//
				this.dataProcessor.writer.setRules( 'ol',
				    {
				        indent : false,
				        breakBeforeOpen : false,
				        breakAfterOpen : false,
				        breakBeforeClose : false,
				        breakAfterClose : true
				    }
				);
				//
				this.dataProcessor.writer.setRules( 'li',
				    {
				        indent : false,
				        breakBeforeOpen : false,
				        breakAfterOpen : false,
				        breakBeforeClose : false,
				        breakAfterClose : true
				    }
				);
				//
				this.dataProcessor.writer.setRules( 'img',
				    {
				        indent : false,
				        breakBeforeOpen : false,
				        breakAfterOpen : false,
				        breakBeforeClose : false,
				        breakAfterClose : true
				    }
				);
				//
				this.dataProcessor.writer.setRules( 'h1',
				    {
				        indent : false,
				        breakBeforeOpen : false,
				        breakAfterOpen : false,
				        breakBeforeClose : false,
				        breakAfterClose : true
				    }
				);
				//
				this.dataProcessor.writer.setRules( 'h2',
				    {
				        indent : false,
				        breakBeforeOpen : false,
				        breakAfterOpen : false,
				        breakBeforeClose : false,
				        breakAfterClose : true
				    }
				);
				//
				this.dataProcessor.writer.setRules( 'h3',
				    {
				        indent : false,
				        breakBeforeOpen : false,
				        breakAfterOpen : false,
				        breakBeforeClose : false,
				        breakAfterClose : true
				    }
				);
				//
				//
				this.dataProcessor.writer.setRules( 'a',
				    {
				        indent : false,
				        breakBeforeOpen : false,
				        breakAfterOpen : false,
				        breakBeforeClose : false,
				        breakAfterClose : true
				    }
				);
				//
				this.dataProcessor.writer.setRules( 'table',
				    {
				        indent : false,
				        breakBeforeOpen : false,
				        breakAfterOpen : false,
				        breakBeforeClose : false,
				        breakAfterClose : true
				    }
				);
				//
				this.dataProcessor.writer.setRules( 'tr',
				    {
				        indent : false,
				        breakBeforeOpen : false,
				        breakAfterOpen : false,
				        breakBeforeClose : false,
				        breakAfterClose : true
				    }
				);
				//
				this.dataProcessor.writer.setRules( 'td',
				    {
				        indent : false,
				        breakBeforeOpen : false,
				        breakAfterOpen : false,
				        breakBeforeClose : false,
				        breakAfterClose : true
				    }
				);
				//
				this.dataProcessor.writer.setRules( 'span',
				    {
				        indent : false,
				        breakBeforeOpen : false,
				        breakAfterOpen : false,
				        breakBeforeClose : false,
				        breakAfterClose : true
				    }
				);
			}
		}
	});
	
	CKFinder.SetupCKEditor( CKEditor.ckeditorGet() , { BasePath : CKFinderUrl, RememberLastFolder : false } ) ;
	
});