<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $ci=& get_instance();?>
<div class="app-content content">
	<div class="content-wrapper">
		<div class="content-header row"></div>
		<div class="content-body">
        	<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header"><h4 class="card-title">Search</h4></div>
						<hr />
						<div class="card-content" id="search_div">
							<div class="card-body">
								 <form action="" method="post" id="search_form" name="search_form" class="form form-horizontal">
										<div class="form-body">
  											<div class="row">
 												<div class="col-md-4 col-sm-6">
													<div class="form-group row">
 														<div class="col-md-12">
															 <input type="text" id="full_name" name="full_name" placeholder="Full Name" class="form-control"/>
														</div>
													</div>
												</div>
                                                <div class="col-md-4 col-sm-6">
													<div class="form-group row">
 														<div class="col-md-12">
															 <input type="text" id="amount" name="amount" placeholder="Amount" onkeypress="return isNumberKey(event)" class="form-control"/>
														</div>
													</div>
												</div>
   												<div class="col-md-4 col-sm-6">
													<div class="form-group row">
 														<div class="col-md-12">
															<select id="sub_record_type" name="sub_record_type" class="form-control select2">
                                                            	<option value="">Please select transaction type</option>
                                                                <option value="entry">Single Entry</option>
                                                                <option value="file">Import csv file</option>
                                                            </select>
														</div>
													</div>
												</div>
                                                <div class="col-md-4 col-sm-6">
													<div class="form-group row">
 														<div class="col-md-12">
															<select id="transaction_status" name="transaction_status" class="form-control select2">
                                                            	<option value="">Please select transaction status</option>
                                                                <option value="pending">PENDING</option>
                                                                <option value="approved">APPROVED</option>
                                                                <option value="failed">FAILED</option>
                                                            </select>
														</div>
													</div>
												</div>
                                                <div class="col-md-4 col-sm-6">
													<div class="form-group row">
 														<div class="col-md-12">
															<select id="is_cancel_recursion" name="is_cancel_recursion" class="form-control select2">
                                                            	<option value="">Please select is cancel Recursion?</option>
                                                                <option value="No">No</option>
                                                                <option value="Yes">Yes</option>
                                                                <option value="N/A">N/A</option>
                                                            </select>
														</div>
													</div>
												</div>
                                                <div class="col-md-4 col-sm-6">
													<div class="form-group row">
 														<div class="col-md-12">
															<select name="period" id="period" class="form-control select2">
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
                                                <div class="col-md-4 col-sm-6">
													<div class="form-group row">
 														<div class="col-md-12">
															 <input type="text" id="customer_id" name="customer_id" placeholder="Customer ID" class="form-control"/>
														</div>
													</div>
												</div>
                                                <div class="col-md-8 col-sm-12 text-right">
													<div class="form-group row">
 														<div class="col-md-12">
															<button type="button" class="btn btn-success" onclick="get_js_sub_transactions_history(1)"> Search</button>
															<button type="button" class="btn btn-danger" onclick="search_reset();"> Reset</button>
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
 			<section>
 				<div class="row">
					<div class="col-12">
						<div class="card">
                            <div class="card-header p-1">
								<h4 class="card-title pull-left">Transactions History</h4>
                                 <?php
 								 if($ci->count_total_approved_sub_transactions()>0)
								 {
								 ?>
                                 	<a target="_blank" href="<?php echo base_url('transactions/ExportSubTransactions');?>" title="Export" class="btn btn-primary btn-sm common-link-btn pull-right" style="margin:0px 2px;"><i class="la la-file-excel-o" style="font-size:12px;"></i> Export</a>
  								 <?php
								 }
								 ?>
                                 <a href="<?php echo base_url('transactions');?>" class="btn btn-primary btn-sm common-link-btn pull-right"><i class="ft-arrow-left"></i> Go Back</a>
                            </div>
 							<hr />
							<div class="card-content">
 								<div class="card-body card-dashboard p-1" id="data-div"></div>
							</div>
						</div>
					</div>
				</div>
			</section>
	   </div>
	</div>
</div>