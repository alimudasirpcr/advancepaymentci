<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $CI=& get_instance();?>
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
															 <input type="text" id="payment_subject" name="payment_subject" placeholder="Subject of Payment" class="form-control"/>
														</div>
													</div>
												</div>
												 
 												<div class="col-md-4 col-sm-6">
													<div class="form-group row">
 														<div class="col-md-12">
															<select id="main_record_type" name="main_record_type" class="form-control select2">
                                                            	<option value="">Please select transaction type</option>
                                                                <option value="entry">Single Entry</option>
                                                                <option value="file">Import csv file</option>
                                                            </select>
														</div>
													</div>
												</div>
                                                <div class="col-md-4 col-sm-6 text-right">
													<div class="form-group row">
 														<div class="col-md-12">
															<button type="button" class="btn btn-success" onclick="get_js_transactions(1)"> Search</button>
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
								<h4 class="card-title pull-left">Transactions</h4>
								<a href="<?php echo base_url('transactions/AddTransaction');?>" class="btn btn-primary btn-sm common-link-btn pull-right"><i class="ft-plus"></i> Import Transaction Records</a>
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