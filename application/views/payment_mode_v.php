<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
if(empty($payment_mode))
{
	$payment_mode = 'test';
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
								<h4 class="card-title pull-left">Mode of Payment</h4>
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
												<div class="col-md-8 col-sm-12">
													<div class="form-group row">
														<label class="col-md-4">Mode of Payment <span class="text-danger">*</span></label>
														<div class="col-md-8">
                                                        	<select id="payment_mode" name="payment_mode" class="form-control select2">
                                                            	<option value="">Please select mode of payment</option>
                                                                <option value="test" <?php if($payment_mode=='test'){ echo 'selected="selected"';}?>>Test</option>
                                                                <option value="live" <?php if($payment_mode=='live'){ echo 'selected="selected"';}?>>Live</option>
                                                            </select>
 														</div>
													</div>
												</div>
                                                <div class="col-md-4 col-sm-12">
													<div class="form-group row">
 														<div class="col-md-12">
                                                        	<button type="submit" id="form_btn" name="form_btn" class="btn btn-primary btn-sm common-action-btn pull-right" onclick="form_common_data_validation('<?php echo base64_encode(10);?>')"> Save</button>
 														</div>
													</div>
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