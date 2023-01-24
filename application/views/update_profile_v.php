<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
$user_full_name = '';
$user_email = '';
if(!empty($row))
{
	$user_full_name = $row->user_full_name;
	$user_email = $row->user_email;
}
?>
<div class="app-content content">
	<div class="content-wrapper">
		<div class="content-header row"></div>
		<div class="content-body">
			<section id="horizontal-form-layouts">
 				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header p-1">
								<h4 class="card-title pull-left">Update Profile</h4>
								<a href="<?php echo base_url();?>" class="btn btn-primary btn-sm common-link-btn pull-right"><i class="ft-arrow-left"></i> Go Back</a>
  							</div>
							<hr />
							<div class="card-content">
								<div class="card-body p-1">
  									<form action="" method="post" id="form_data" name="form_data" class="form form-horizontal">
										<div class="form-body">
  											<div class="row">
												<div class="col-12">
                                                    <ul class="alert alert-danger pl-2 pr-2" id="error_div" style="display:none;"></ul>
                                                    <div class="clearfix"></div>
                                                    <ul class="alert alert-success pl-2 pr-2" id="success_div" style="display:none;"></ul>
                                                </div>
												<div class="col-md-6 col-sm-12">
													<div class="form-group row">
														<label class="col-md-4">Name <span class="text-danger">*</span></label>
														<div class="col-md-8">
                                                        	<input type="text" name="user_full_name" id="user_full_name" placeholder="Name" class="form-control" value="<?php echo $user_full_name;?>"/>
 														</div>
													</div>
												</div>
												<div class="col-md-6 col-sm-12">
													<div class="form-group row">
														<label class="col-md-4">Email <span class="text-danger">*</span></label>
														<div class="col-md-8">
															<input type="text" name="user_email" id="user_email" placeholder="Email" class="form-control" value="<?php echo $user_email;?>"/>
														</div>
													</div>
												</div>
    										</div>
     										<div class="row">
												<div class="col-md-12">
 													<button type="submit" id="form_btn" name="form_btn" class="btn btn-primary btn-sm common-action-btn pull-right" onclick="form_common_data_validation('<?php echo base64_encode(4);?>')"> Update</button>
												</div>
											</div>
   										</div>
 									</form>
 								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
 	   </div>
	</div>
</div>