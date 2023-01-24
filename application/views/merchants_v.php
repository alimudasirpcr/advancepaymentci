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
								<h4 class="card-title pull-left">Merchants</h4>
								<a href="<?php echo base_url('merchants/AddMerchant');?>" class="btn btn-primary btn-sm common-link-btn pull-right"><i class="ft-plus"></i> Add New Merchant</a>
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