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
								<h4 class="card-title pull-left">Import Transaction Records</h4>
								<a href="<?php echo base_url('transactions');?>" class="btn btn-primary btn-sm common-link-btn pull-right"><i class="ft-arrow-left"></i> Go Back</a>
  							</div>
							<hr />
 							<div class="card-content">
								<div class="card-body p-1">
									<?php
                                    if(!empty($merchant_list))
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
                                                            <label class="col-md-2">Subject of Payment</label>
                                                            <div class="col-md-10">
                                                                <input type="text" id="title" name="title" placeholder="Subject of Payment" class="form-control"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <label class="col-md-2">Merchant <span class="text-danger">*</span></label> 
                                                            <div class="col-md-10">
                                                                <select name="merchant_id" id="merchant_id" class="form-control select2">
                                                                    <option value="">Please select merchant id</option>
                                                                    <?php
                                                                    foreach($merchant_list as $merchant_val)
                                                                    {
                                                                    ?>
                                                                        <option value="<?php echo $merchant_val->mid;?>"><?php echo $merchant_val->merchant_name." (".$merchant_val->mid.") ";?></option>    
                                                                    <?php	
                                                                    }
                                                                    ?>
                                                                </select>
                                                             </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="form-group row">
                                                            <label class="col-md-2">Upload excel file <span class="text-danger">*</span></label>
                                                            <div class="col-md-10">
                                                            	<input type="file" id="file" name="file"/>
                                                                 <span class="text-danger p-1">Please upload only csv, xls, xlsx file</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                         <button type="submit" id="form_btn" name="form_btn" class="btn btn-primary btn-sm common-action-btn pull-right" onclick="form_common_data_validation('<?php echo base64_encode(1);?>')"> Save</button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="form-group row">
                                                             <div class="col-md-12">
                                                                 <label class="col-md-12 font-weight-bold">Instruction for import file</label>
                                                                <p class="col-md-12 text-danger p-2">
                                                                    * We have format with columns name as shown below. Please do not import excel file with column name as shown below
                                                                </p>
                                                                <div class="col-md-12">
                                                                    <img src="<?php echo base_url("template/app-assets/images/common/Excel-format.png");?>" style="width:100%;" />
                                                                </div>
                                                                <p class="col-md-12 text-danger p-2">* Please Import excel file as shown below without column name.</p>
                                                                <div class="col-md-12">
                                                                    <img src="<?php echo base_url("template/app-assets/images/common/Excel-format-import.png");?>" style="width:100%;" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                              </div>
                                        </form>
                                    <?php
                                    }
									else
									{
										echo '<div class="row"><div class="col-md-12"><span class="text-danger">Please add merchant first to continue!</span></div></div>';	
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