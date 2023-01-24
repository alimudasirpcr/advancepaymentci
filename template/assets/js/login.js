/*============================ Login validation=========================*/
$('#login_btn').click(function(event)
{
  	$.LoadingOverlay("show");
 	$('#login_btn').hide();
	$('#error_div').hide();
    $('#form_data').submit(function(e) 
	{
		e.preventDefault();
 		$('#form_data').removeAttr('onsubmit').submit(e);
 		var form = $(this);
		var formdata = false;
		if(window.FormData)
		{
			formdata = new FormData(form[0]);
		}
	
		var formAction = form.attr('action');
	
		$.ajax({
			type : 'POST',
			url : js_base_path+'login/Check',
  			cache : false,
			data : formdata ? formdata : form.serialize(),
			contentType : false,
			processData : false,
	
			success: function(data) 
			{
				$('html, body').animate({scrollTop:0}, 'slow');
 				if(data.search('done') != -1)
				{
 					$('#error_div').html('');
					$('#error_div').hide();
 					$('#form_data').each(function(){
						this.reset();
					});
   					 window.location.href = js_base_path+'dashboard';
				} 
				else 
				{
 					$("#login_btn").show();
  					$('#error_div').fadeIn("slow");
 					$('#error_div').html('');
					$('#error_div').html(data);
					$('#form_data').removeAttr('onsubmit').submit(e);
				}
			}
		});
 	});
	$.LoadingOverlay("hide"); 
 }); 
/*============================ Forgot Password validation=========================*/
$('#forgot_password_btn').click(function()
{
 	$.LoadingOverlay("show");
 	$('#forgot_password_btn').hide();
	$('#error_div').hide();
    $('#form_data').submit(function(e) 
	{
		e.preventDefault();
		$('#form_data').removeAttr('onsubmit').submit(e);
 		var form = $(this);
		var formdata = false;
		if(window.FormData)
		{
			formdata = new FormData(form[0]);
		}
 		var formAction = form.attr('action');
 		$.ajax({
			type : 'POST',
			url : js_base_path+'login/forgot_password_validation',
  			cache : false,
			data : formdata ? formdata : form.serialize(),
			contentType : false,
			processData : false,
	
			success: function(data) 
			{
				$('html, body').animate({scrollTop:0}, 'slow');
 				if(data.search('done') != -1)
				{
 					$('#error_div').html('');
					$('#error_div').hide();
  					$('#form_data').each(function(){
						this.reset();
					});
					$('#form_data').remove();
					$('#success_div').fadeIn("slow");
 					$('#success_div').html('Please check your email to reset password!');
					setTimeout(function(){ window.location.href = js_base_path+'login'; }, 5000);
				} 
				else 
				{
 					$("#forgot_password_btn").show();
  					$('#error_div').fadeIn("slow");
					$('#success_div').hide();
					$('#error_div').html('');
					$('#error_div').html(data);
					$('#form_data').removeAttr('onsubmit').submit(e);
				}
			}
		});
		e.preventDefault();
	});
	$.LoadingOverlay("hide"); 
 })
/*============================ Reset Password validation=========================*/
$('#reset_password_btn').click(function()
{
  	$.LoadingOverlay("show");
 	$('#reset_password_btn').hide();
	$('#error_div').hide();
    $('#form_data').submit(function(e) 
	{
 		e.preventDefault();
		$('#form_data').removeAttr('onsubmit').submit(e);
 		var form = $(this);
		var formdata = false;
		if(window.FormData)
		{
			formdata = new FormData(form[0]);
		}
	
		var formAction = form.attr('action');
	
		$.ajax({
			type : 'POST',
			url : js_base_path+'login/reset_password_validation',
  			cache : false,
			data : formdata ? formdata : form.serialize(),
			contentType : false,
			processData : false,
	
			success: function(data) 
			{
				$('html, body').animate({scrollTop:0}, 'slow');
 				if(data.search('done') != -1)
				{
					$('#success_div').fadeIn("slow");
					$('#error_div').html('');
					$('#error_div').hide();
 					$('#form_data').each(function(){
						this.reset();
					});
					$('#form_data').remove();
 					$('#success_div').html('Password reset successfully!');
 					setTimeout(function(){ window.location.href = js_base_path+'login'; }, 5000);
				} 
				else 
				{
 					$("#reset_password_btn").show();
  					$('#error_div').fadeIn("slow");
					$('#success_div').hide();
					$('#error_div').html('');
					$('#error_div').html(data);
					$('#form_data').removeAttr('onsubmit').submit(e);
				}
			}
		});
		e.preventDefault();
	});
	$.LoadingOverlay("hide"); 
 })

