<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $CI=& get_instance();?>
<div class="app-content content">
	<div class="content-wrapper">
		<div class="content-header row"></div>
		<div class="content-body">
 			<section>
 				<div class="row">
					<div class="col-12">
						<div class="card">
                            <div class="card-header p-1">
								<h4 class="card-title pull-left">Export Transactions</h4>
								<a href="<?php echo base_url('transactions');?>" class="btn btn-primary btn-sm common-link-btn pull-right"><i class="ft-arrow-left"></i> Go Back</a>
  							</div>
 							<hr />
							<div class="card-content">
 								<div class="card-body card-dashboard p-1">
                                	<div class='col-md-12 mb-20'>
                                    	<span class='dx-ticket-item dx-block-decorated text-danger'>
                                    		Transactions not available. Please check details. 
 										</span>
									</div>
                                </div>
							</div>
						</div>
					</div>
				</div>
			</section>
	   </div>
	</div>
</div>