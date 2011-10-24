;
var xed;
(function(){
    jQuery.fn.extend({
        flush: function(){
            this.html(xed.getCurrentContent());
        },
        editable: function(options){
        	
            var $this = this;
			$.extend(true, jQuery.fn.xquaredOption, options);
            var contextId = this.attr('id');
            xed = new xq.Editor(contextId);

			try {
				xed.config.imagePathForDefaultToolbar = jQuery.fn.xquaredOption.baseUrl+'images/toolbar/ko/';
        	}catch (e) {
				alert('xquared script is not installed');
				return false;
			}
            
            if (jQuery.fn.xquaredOption.isSingleFileUpload) {
            	xed.isSingleFileUpload = true;
            	xed.addPlugin('FileUpload');
            	xed.fileUploadFieldName = jQuery.fn.xquaredOption.fileUploadFieldName;
            	xed.setFileUploadTarget(jQuery.fn.xquaredOption.fileUploadTarget1, null);
            }
            xed.setEditMode(jQuery.fn.xquaredOption.editMode);
            if (jQuery.fn.xquaredOption.resizeHeader) {
                $('.source_editor, .wysiwyg_editor').css('height', function(i, v){
                    return $(this).height() - jQuery.fn.xquaredOption.heightHeader - jQuery.fn.xquaredOption.heightHeaderWrapper;
                });
            }
            
                    },
        xquaredOption: {
            isSingleFileUpload: false, 
            resizeHeader: true,
            fileUploadFieldName: 'fileData',
            heightHeaderWrapper: 5, /* adjust this value */
            heightHeader: 60,
            width: '100%',
            editMode: 'wysiwyg',
            autoFocusOnInit: true,
            urlValidationMode: 'host_relative',
            changeCursorOnLink: true,
            enablePreventExit: true,
            enableLinkClick: true,
            fileUploadTarget1: '/adm/common/upload/put.load',
            fileUploadTarget2: '/adm/common/upload/put.json',
            baseUrl: '/adm/xquared/'
        }
    });
})();
