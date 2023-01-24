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

								<h4 class="card-title pull-left">Add Single Transaction</h4>

								<a href="<?php echo base_url('merchants');?>" class="btn btn-primary btn-sm common-link-btn pull-right"><i class="ft-arrow-left"></i> Go Back</a>

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

                                                            <input type="text" id="payment_subject" name="payment_subject" placeholder="Subject of Payment" class="form-control"/>

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

                                                        <label class="col-md-2">Customer ID</label>

                                                        <div class="col-md-10">

                                                            <input type="text" id="customer_id" name="customer_id" placeholder="Customer ID" class="form-control"/>

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="col-md-12 col-sm-12">

                                                    <div class="form-group row">

                                                        <label class="col-md-2">First Name</label>

                                                        <div class="col-md-10">

                                                            <input type="text" id="firstname" name="firstname" placeholder="First Name" class="form-control"/>

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="col-md-12 col-sm-12">

                                                    <div class="form-group row">

                                                        <label class="col-md-2">Last Name <span class="text-danger">*</span></label>

                                                        <div class="col-md-10">

                                                            <input type="text" id="lastname" name="lastname" placeholder="Last Name" class="form-control"/>

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="col-md-12 col-sm-12">

                                                    <div class="form-group row">

                                                        <label class="col-md-2">Amount <span class="text-danger">*</span></label>

                                                        <div class="col-md-10">

                                                            <input type="text" id="amount" name="amount" placeholder="Amount" onkeypress="return isNumberKey(event)" class="form-control"/>

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="col-md-12 col-sm-12">

                                                    <div class="form-group row">

                                                        <label class="col-md-2">IBAN <span class="text-danger">*</span></label>

                                                        <div class="col-md-10">

                                                            <input type="text" id="iban" name="iban" placeholder="IBAN" class="form-control"/>

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="col-md-12 col-sm-12">

                                                    <div class="form-group row">

                                                        <label class="col-md-2">BIC</label>

                                                        <div class="col-md-10">

                                                            <input type="text" id="bic" name="bic" placeholder="BIC" class="form-control"/>

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="col-12">

                                                    <div class="form-group row">

                                                        <label class="col-md-2">Period <span class="text-danger">*</span></label> 

                                                        <div class="col-md-10">

                                                            <select name="period" id="period" onchange="load_recursion_start_type(this.value)" class="form-control select2">

                                                                <option value="">Please select period</option>

                                                                <option value="one time">One time</option>

                                                                <option value="weekly">Weekly</option>

                                                                 <option value="monthly">Monthly</option>

                                                                <option value="quarterly">Quarterly</option>

                                                                <option value="yearly">Yearly</option>

                                                             </select>

                                                         </div>

                                                    </div>

                                                </div>


                                                <div class="col-12">

                                                    <div class="form-group row">

                                                        <label class="col-md-2">Payment Method <span class="text-danger">*</span></label> 

                                                        <div class="col-md-10">

                                                            <select name="type" id="type"  class="form-control" onchange="load_single_transaction_email(this.value)">

                                                            ]

                                                                <option>PAYONE</option>

                                                                <option>STRIPE</option>

                                                            </select>

                                                        </div>

                                                    </div>

                                                    </div>
                                                    <div class="col-12" id="load-email-single" style="display:none">
                                                    <div class="form-group row">

                                                            <label class="col-md-2">Email </label>

                                                            <div class="col-md-10">

                                                                <input  type="email" id="load-email-single-email" name="email" placeholder="Email" class="form-control"/>

                                                            </div>

                                                            </div>
                                                    </div>
                                                <div class="col-12" id="load-start-payment"></div>
                                                <div class="col-12" id="load-custom-date"></div>

                                             </div>

                                              <div class="row">

                                                <div class="col-md-12">

                                                     <button type="submit" id="form_btn" name="form_btn" class="btn btn-primary btn-sm common-action-btn pull-right" onclick="form_common_data_validation('<?php echo base64_encode(8);?>')"> Save</button>

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