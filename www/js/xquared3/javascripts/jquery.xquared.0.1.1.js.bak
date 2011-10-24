;
var xed;
(function(){
    var plugin = jQuery.sub();
    plugin.fn.extend({
        flush: function(){
            this.html(xed.getCurrentContent());
        },
        editable: function(options){
        	
            var $this = this;
            plugin.fn.context = this;
			$.extend(true, plugin.fn.xquaredOption, options);
            var contextId = this.attr('id');
            xed = new xq.Editor(contextId);

			try {
				xed.config.imagePathForDefaultToolbar = plugin.fn.xquaredOption.baseUrl+'images/toolbar/ko/';
        	}catch (e) {
				alert('xquared script is not installed');
				return false;
			}
            
            if (plugin.fn.xquaredOption.isSingleFileUpload) {
            	xed.isSingleFileUpload = true;
            	xed.addPlugin('FileUpload');
            	xed.fileUploadFieldName = plugin.fn.xquaredOption.fileUploadFieldName;
            	xed.setFileUploadTarget(plugin.fn.xquaredOption.fileUploadTarget1, null);
            }
            xed.setEditMode(plugin.fn.xquaredOption.editMode);
            if (plugin.fn.xquaredOption.resizeHeader) {
                $('.source_editor, .wysiwyg_editor').css('height', function(i, v){
                    return $(this).height() - plugin.fn.xquaredOption.heightHeader - plugin.fn.xquaredOption.heightHeaderWrapper;
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
    jQuery.fn.xquared = function(){
        this.addClass("plugin");
        return plugin(this);
    };
})();
