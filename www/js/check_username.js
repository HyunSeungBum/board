$(document).ready(function() {
	$("#UserUsername").focusout(function() {
		$(".ajax_status").css('display','inline');
		$("#username_ajax_result").css('display','none');
		var $username = $("#UserUsername").val();
		$.post("/ajax/users/check_username/", {data:{User:{username:$username}}}, function(data) {
			$(".ajax_status").css('display', 'none');
			if (data == 1) {
				$("#username_ajax_result").attr('class','ajax_success');
				$("#username_ajax_result").text('Username is available');
			} else {
				$("#username_ajax_result").attr('class', 'ajax_error');
				$("#username_ajax_result").text('Username is already in use');
			}
			$("#username_ajax_result").css('display','inline');
                });
        });
});