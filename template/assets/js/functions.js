/*============================ call Modal=========================*/

function call_url_modal(url)

{

 	path = js_base_path+url;

 	$('#load_modal_data').html('');

    $('#default').on('show.bs.modal', function (e) {

        $(this).removeData('bs.modal');

    });

    $('#default').modal({

       show: true,

       data:'',

       remote: path,

    });

	$.ajax({

		   type: "POST",

		   url: path,

		   data: '',

		

		   beforeSend: function(){

		   },

		

		   success: function(data){

				$("#load_modal_data").append(data);

			},

			error: function() {

			}

	});

}

function call_url_key_modal(url,key_id)

{

	path = js_base_path+url+'?key_id='+key_id;

  	$('#load_modal_data').html('');

    $('#default').on('show.bs.modal', function (e) {

        $(this).removeData('bs.modal');

    });

    $('#default').modal({

       show: true,

       data:'',

       remote: path,

    });

	$.ajax({

		   type: "POST",

		   url: path,

		   data: '',

		

		   beforeSend: function(){

		   },

		

		   success: function(data){

				$("#load_modal_data").append(data);

			},

			error: function() {

			}

	});

}

/*============================ Forgot Password validation=========================*/

$('#forgot_password_btn').click(function()

{

 	$.LoadingOverlay("show");

 	$('#forgot_password_btn').hide();

	$('#fg_error_div').hide();

    $('#fg_form_data').submit(function(e) 

	{

		e.preventDefault();

		$('#fg_form_data').removeAttr('onsubmit').submit(e);

 		var form = $(this);

		var formdata = false;

		if(window.FormData)

		{

			formdata = new FormData(form[0]);

		}

	

		var formAction = form.attr('action');

	

		$.ajax({

			type : 'POST',

			url : js_base_path+'login/Checkfg',

  			cache : false,

			data : formdata ? formdata : form.serialize(),

			contentType : false,

			processData : false,

	

			success: function(data) 

			{

  				myarray = new Array();

				myarray = data.split('-SEPARATOR-');	

				if(data.search('done') != -1)

				{

 					$("#fg_form_data").remove();

					$("#user_email").remove();

 					$('#fg_success_div').show();

					$('#fg_error_div').html('');

					$('#fg_error_div').hide();

 					$('#fg_form_data').each(function(){

						this.reset();

					});

					$('html, body').animate({scrollTop:0}, 'slow');

					alert('Please check your email to reset password!');

					setTimeout('gotolink(\''+myarray[1]+'\')', 1000);

 				} 

				else 

				{

					$('html, body').animate({scrollTop:0}, 'slow');

					$("#forgot_password_btn").show();

  					$('#fg_error_div').fadeIn("slow");

					$('#fg_success_div').hide();

					$('#fg_error_div').html('');

					$('#fg_error_div').html(data);

					$('#fg_form_data').removeAttr('onsubmit').submit(e);

				}

			}

		});

		e.preventDefault();

	});

	$.LoadingOverlay("hide"); 

 });

/*============================ form Record validation=========================*/

function form_data_validation(id,scf,sctype)

{
	alert("hey");

	if(id!='' && scf!='' && sctype!='')

	{

  		var form = "#"+scf+"_form_data";

		var btn = "#"+scf+"_form_btn";  

		var error_div = "#"+scf+"_error_div";  

		var success_div = "#"+scf+"_success_div";  

		 

		$.LoadingOverlay("show");

 		$(btn).hide();

		$(error_div).hide();

		$(success_div).hide();

 		$(form).submit(function(e) 

		{

			var form = $(this);

			var formdata = false;

			if(window.FormData)

			{

				formdata = new FormData(form[0]);

			}

		

			var formAction = form.attr('action');

		

			$.ajax({

				type : 'POST',

				url : js_base_path+'validation?id='+id,

				cache : false,

				data : formdata ? formdata : form.serialize(),

				contentType : false,

				processData : false,

		

				success: function(data) 

				{

					$.LoadingOverlay("hide");

					myarray = new Array();

					myarray = data.split('-SEPARATOR-');		

					if(data.search('done') != -1)

					{

						$(error_div).html('');

						$(error_div).hide();

						$(success_div).fadeIn("slow");

						$(form).each(function(){

							this.reset();

						});

 						$('html, body').animate({scrollTop:0}, 'slow');

						if(myarray[1]=='update')

						{

							$(success_div).html('Record updated successfully!');

						}

						else if(myarray[1]=='import')

						{

							$(success_div).html('Excel records imported successfully!');

						}

						else

						{

							$(success_div).html('Record added successfully!');

						}

 						setTimeout('gotolink(\''+myarray[2]+'\')', 1500);

					} 

					else 

					{

						$('html, body').animate({scrollTop:0}, 'slow');

						$(success_div).hide();

						$(btn).show();

						$(error_div).fadeIn("slow");

						$(error_div).html('');

						$(error_div).html(data);

						$(form).removeAttr('onsubmit').submit(e);

					}

				}

			});

			e.preventDefault();

		});

	}

	else

	{

		alert('Please refresh your page');	

	}

}

function form_common_data_validation(id)

{

 	$.LoadingOverlay("show");

  	$('#form_btn').hide();

	$('#error_div').hide();

	$('#success_div').hide();

    $('#form_data').submit(function(e) 

	{

  		var form = $(this);

		var formdata = false;

		if(window.FormData)

		{

			formdata = new FormData(form[0]);

		}

	

		var formAction = form.attr('action');

 		$.ajax({

			type : 'POST',

			url : js_base_path+'validation?id='+id,

  			cache : false,

			data : formdata ? formdata : form.serialize(),

			contentType : false,

			processData : false,

	

			success: function(data) 

			{

				$.LoadingOverlay("hide");

  				myarray = new Array();

				myarray = data.split('-SEPARATOR-');

				$('html, body').animate({scrollTop:0}, 'slow');		

				if(data.search('done') != -1)

				{

					$('#error_div').html('');

					$('#error_div').hide();

					$('#success_div').fadeIn("slow");

 					$('#form_data').each(function(){

						this.reset();

					});

  					if(myarray[1]=='update')

					{

						$('#success_div').html('Record updated successfully!');

					}

					else if(myarray[1]=='upload')

					{

						$('#success_div').html('Image uploaded successfully!');

					}

  					else

					{

						$('#success_div').html('Record added successfully!');

					}

					setTimeout('gotolink(\''+myarray[2]+'\')', 1000);

 				} 

				else 

				{

 					$('#success_div').hide();

					$("#form_btn").show();

  					$('#error_div').fadeIn("slow");

					$('#error_div').html('');

					$('#error_div').html(data);

					$('#form_data').removeAttr('onsubmit').submit(e);

				}

			}

		});

		e.preventDefault();

	});

}

function record_deletion(id,type)

{

	swal({

		title: "Are you sure?",

		text: "You want to delete this record?",

		icon: "error",

 		buttons: {

 			confirm: {

				text: "Delete",

				value: true,

				visible: true,

				className: "btn-danger",

				closeModal: true

			},

			cancel: {

				text: "cancel",

				value: null,

				visible: true,

				className: "btn-info",

				closeModal: true,

			}

		}

	})

	.then(isConfirm => 

	{

		if (isConfirm) 

		{

			$.ajax({

					method: 'POST',

					data: {'ids': id, 'type' : type},

					url: js_base_path+'validation?type='+type,

					success: function(data){

					if(data.search('done')!=-1)

					{

						swal({

						  title: "Deleted",

						  text: "Record deleted successfully!",

						  type: "success",

						  timer: 2000,

						  closeModal: true

						});

						location.reload();

					}

					else

					{

						swal({

						  title: "Error",

						  text: data,

						  type: "error",

						  timer: 2000,

						  closeModal: true,

						});

					}

				},

				error: function() 

				{

					swal({

					  title: "Error",

					  text: 'An Error occurred, please refresh the page and try again!',

					  type: "error",

					  timer: 2000,

					  closeModal: true

					});

					location.reload();

				}

			});

		} 

		else 

		{

			

		}

	});

}

function cancel_sub_transaction_recursion(id,type)

{

	swal({

		title: "Are you sure?",

		text: "You want to cancel recursion for this record?",

		icon: "error",

 		buttons: {

 			confirm: {

				text: "Remove Recursion",

				value: true,

				visible: true,

				className: "btn-danger",

				closeModal: true

			},

			cancel: {

				text: "cancel",

				value: null,

				visible: true,

				className: "btn-info",

				closeModal: true,

			}

		}

	})

	.then(isConfirm => 

	{

		if (isConfirm) 

		{

			$.ajax({

					method: 'POST',

					data: {'ids': id, 'type' : type},

					url: js_base_path+'validation?type='+type,

					success: function(data){

					if(data.search('done')!=-1)

					{

						swal({

						  title: "Deleted",

						  text: "Recursion cancel successfully!",

						  type: "success",

						  timer: 2000,

						  closeModal: true

						});

						location.reload();

					}

					else

					{

						swal({

						  title: "Error",

						  text: data,

						  type: "error",

						  timer: 2000,

						  closeModal: true,

						});

					}

				},

				error: function() 

				{

					swal({

					  title: "Error",

					  text: 'An Error occurred, please refresh the page and try again!',

					  type: "error",

					  timer: 2000,

					  closeModal: true

					});

					location.reload();

				}

			});

		} 

		else 

		{

			

		}

	});

}

/*============================ Search Reset=========================*/

function search_reset()

{

	$('#search_form').each(function(){this.reset();});

	window.location.reload();

}

/*============================ Load Data=========================*/

function get_js_transactions(page)

{

	var payment_subject = $("#payment_subject").val();

	var main_record_type = $("#main_record_type").val();

    $.ajax({

		type:'POST',

		url:js_base_path+'transactions/load_ajax_transactions_list',

 		data : {payment_subject:payment_subject,main_record_type:main_record_type,page_number:page},

		success:function(data)

		{

 			$("#data-div").html("");

			$('#data-div').html(data);

 		}

	}); 

}

function get_js_sub_transactions_history(page)

{

	var full_name = $("#full_name").val();

 	var amount = $("#amount").val();

	var sub_record_type = $("#sub_record_type").val();

	var transaction_status = $("#transaction_status").val();

	var is_cancel_recursion = $("#is_cancel_recursion").val();

	var period = $("#period").val();

	var customer_id = $("#customer_id").val();

    $.ajax({

		type:'POST',

		url:js_base_path+'transactions/load_ajax_sub_transactions_history_list',

 		data : {full_name:full_name,amount:amount,sub_record_type:sub_record_type,transaction_status:transaction_status,is_cancel_recursion:is_cancel_recursion,period:period,customer_id:customer_id,page_number:page},

		success:function(data)

		{

 			$("#data-div").html("");

			$('#data-div').html(data);

 		}

	}); 

}

function get_js_sub_transactions(page,main_id)

{

     $.ajax({

		type:'POST',

		url:js_base_path+'transactions/load_ajax_sub_transactions_list',

 		data : {page_number:page,main_id:main_id},

		success:function(data)

		{

 			$("#load_sub_ransaction_data").html("");

			$('#load_sub_ransaction_data').html(data);

 		}

	}); 

}

function get_js_merchants(page)

{

     $.ajax({

		type:'POST',

		url:js_base_path+'merchants/load_ajax_merchants_list',

 		data : {page_number:page},

		success:function(data)

		{

 			$("#data-div").html("");

			$('#data-div').html(data);

 		}

	}); 

}

function get_Previous(fun_name,record_id)

{ 

	var me = this;

    var hrefValue = document.getElementById("pagination-active").href;

    var split = hrefValue.split("#");

    var page = parseInt(split[1]);

	if(page>1)

	{

		if(record_id==0)

		{

			me[fun_name](page-1);

 		}

		else if(record_id!='')

		{

			me[fun_name](page-1,record_id);

		}

	}

}

function get_Next(total,fun_name,record_id)

{

 	var me = this;

    var hrefValue = document.getElementById("pagination-active").href;

    var split = hrefValue.split("#");

    var page = parseInt(split[1]);

	if(total>page)

	{

		if(record_id==0)

		{

			me[fun_name](page+1);

 		}

		else if(record_id!='')

		{

			me[fun_name](page+1,record_id);

		}

 	}

}



function load_recursion_start_type(type)

{

	if(type=='monthly' || type=='quarterly' || type=='yearly')

	{

		 $.ajax({

			type:'POST',

			url:js_base_path+'transactions/load_recursion_start_type',

			data : {type:type},

			success:function(data)

			{

				$("#load-start-payment").show();

				$("#load-start-payment").html("");

				$('#load-start-payment').html(data);

			}

		}); 

	}

	else

	{

		$("#load-start-payment").hide();
		$("#load-start-payment").html("");
		$("#load-custom-date").hide();
		$("#load-custom-date").html("");
	}
	

}


function load_single_transaction_email(type){
	if(type!='STRIPE')

	{
		$("#load-email-single").hide();
		$("#load-email-single-email").val("");
	}else{
		$("#load-email-single").show();
		$("#load-email-single-email").val("");
	}
}


function load_customdate(type)

{

	if(type=='customdate')

	{

		 $.ajax({

			type:'POST',

			url:js_base_path+'transactions/load_custom_date',

			data : {type:type},

			success:function(data)

			{

				$("#load-custom-date").show();

				$("#load-custom-date").html("");

				$('#load-custom-date').html(data);

			}

		}); 

	}

	else

	{

		$("#load-custom-date").hide();

		$("#load-custom-date").html("");

	}


}

function myFunction() {
	// Get the text field
	var copyText = document.getElementById("myInput");
  
	// Select the text field
	copyText.select();
	copyText.setSelectionRange(0, 99999); // For mobile devices
  
	 // Copy the text inside the text field
	navigator.clipboard.writeText(copyText.value);
  
	// Alert the copied text
	//alert("Copied the text: " + copyText.value);
  }