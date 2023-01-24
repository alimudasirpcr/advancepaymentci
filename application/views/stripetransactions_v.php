<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $CI=& get_instance();?>
<script src="https://js.stripe.com/v3/"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("template/css/normalize.css");?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("template/css/global.css");?>">


<script src="<?php echo base_url("template/js/script.js");?>" type="text/javascript"></script>

<div class="app-content content">
	<div class="content-wrapper">
		<div class="content-header row mb-3">
			<div class="col-12">
			<a href="<?php echo base_url("transactions/maketrans");?>"  <?php if($days==1){?>   style="border: 3px solid black !important;"  <?php  } ?>   class="btn btn-primary">Today's Transactions</a>
			<a href="<?php echo base_url("transactions/maketrans/3");?>" <?php if($days==3){?>   style="border: 3px solid black !important;"  <?php  } ?> class="btn btn-success">Last 3 days Transactions</a>
			<a href="<?php echo base_url("transactions/maketrans/7");?>" <?php if($days==7){?>   style="border: 3px solid black !important;"  <?php  } ?> class="btn btn-info">Last 7 days Transactions</a>
			<a href="<?php echo base_url("transactions/maketrans/30");?>" <?php if($days==30){?>   style="border: 3px solid black !important;"  <?php  } ?> class="btn btn-warning">Last 30 days Transactions</a>
			</div>
			<div class="col-3">
			
			</div>
			<div class="col-3">
			</div>
		</div>
		<div class="content-body">
        	
 			<section>
 				<div class="row">
					<div class="col-12">
						<div class="card">
                            <div class="card-header p-1">
								<h4 class="card-title pull-left">Stripe Transactions</h4>

  							</div>
 							<hr />
							<div class="card-content">
 								<div class="card-body card-dashboard p-1">
									<table class="table table-striped table-bordered">
										<thead>
											<tr><th>Name</th>
											<th>Date</th>
											<th>Ibn</th>
											<th>Amount</th>
											<th>Status</th>
											<th>Subject of payment</th>
											<th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php 
									if(count($gettodaytrans)>0){
										foreach($gettodaytrans  as $trans){
											?>
											<tr>
												<td><?php echo $trans['firstname'] ." " .$trans['lastname'] ; ?> </td>
												<td><?php echo date('d M Y' , strtotime($trans['sub_transaction_date']))  ; ?></td>
												<td><?php echo $trans['iban']; ?></td>
												<td><?php echo $trans['amount']; ?></td>
												<td><?php echo $trans['transaction_status']; ?></td>
												<td><?php echo $trans['payment_subject']; ?></td>
												<td> 
													
												<?php if($trans['transaction_status']=='pending') { ?>  
													
													<a href="<?php echo base_url('transactions/stripepay')."/".$trans['sub_transaction_id']; ?>" class="btn btn-primary">Pay Now</a>
													
													
													
													<?php } else { echo "Paid" ; } ?></td>
											</tr>
											<?php 

											
										}
									}
								?>
										</tbody>
									</table>
								

								</div>
							</div>
						</div>
					</div>
				</div>
			</section>



			

	   </div>
	</div>
</div>