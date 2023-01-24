<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="app-content content">
	<div class="content-wrapper">
		<div class="content-header row"></div>
		<div class="content-body">
			<section id="horizontal-form-layouts">
 				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header p-1">
								<h4 class="card-title pull-left">Update Merchant</h4>
								<a href="<?php echo base_url('merchants');?>" class="btn btn-primary btn-sm common-link-btn pull-right"><i class="ft-arrow-left"></i> Go Back</a>
  							</div>
							<hr />
 							<div class="card-content">
								<div class="card-body p-1">
                                	<?php
                                    if(empty($error_message))
                                    {
                                        if(!empty($row))
                                        {
                                        ?>
                                          <form action="" method="post" id="form_data" name="form_data" class="form form-horizontal">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <ul class="alert alert-danger pl-2 pr-2" id="error_div" style="display:none;"></ul>
                                                        <div class="clearfix"></div>
                                                        <ul class="alert alert-success pl-2 pr-2" id="success_div" style="display:none;"></ul>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="form-group row">
                                                            <label class="col-md-2">Merchant Name <span class="text-danger">*</span></label>
                                                            <div class="col-md-10">
                                                                <input type="text" id="merchant_name" name="merchant_name" placeholder="Merchant Name" value="<?php echo $row->merchant_name;?>" class="form-control"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="form-group row">
                                                            <label class="col-md-2">AID <span class="text-danger">*</span></label>
                                                            <div class="col-md-10">
                                                                <input type="text" id="aid" name="aid" placeholder="AID" value="<?php echo $row->aid;?>" class="form-control"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="form-group row">
                                                            <label class="col-md-2">Merchant Id(MID) <span class="text-danger">*</span></label>
                                                            <div class="col-md-10">
                                                                <input type="text" id="mid" name="mid" placeholder="Merchant Id" value="<?php echo $row->mid;?>" class="form-control"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="form-group row">
                                                            <label class="col-md-2">Key <span class="text-danger">*</span></label>
                                                            <div class="col-md-10">
                                                                <input type="text" id="md5_key" name="md5_key" placeholder="Key" value="<?php echo $row->md5_key;?>" class="form-control"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="form-group row">
                                                            <label class="col-md-2">Portal Id <span class="text-danger">*</span></label>
                                                            <div class="col-md-10">
                                                                <input type="text" id="portalid" name="portalid" placeholder="Portal Id" value="<?php echo $row->portalid;?>" class="form-control"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                 </div>
                                                 <div class="row">
                                                    <div class="col-md-12">
                                                    	  <input type="hidden" id="update_id" name="update_id" value="<?php echo base64_encode($row->merchant_id);?>" class="form-control"/> 
                                                         <button type="submit" id="form_btn" name="form_btn" class="btn btn-primary btn-sm common-action-btn pull-right" onclick="form_common_data_validation('<?php echo base64_encode(7);?>')"> Save</button>
                                                    </div>
                                                </div>
                                             </div>
                                        </form>
                                        <?php
                                        }
										else
										{
											echo '<div class="row"><div class="col-md-12"><span class="text-danger">Please select valid record</span></div></div>';		
										}
                                        ?>
                                    <?php
                                    }
									else
									{
										echo '<div class="row"><div class="col-md-12"><span class="text-danger">'.$error_message.'</span></div></div>';	
									}
                                    ?>
   								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
 	   </div>
	</div>
</div>