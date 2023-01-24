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
								<h4 class="card-title pull-left">View Transaction</h4>
								<a href="<?php echo base_url('transactions');?>" class="btn btn-primary btn-sm common-link-btn pull-right"><i class="ft-arrow-left"></i> Go Back</a>
  							</div>
							<hr />
 							<div class="card-content">
								<div class="card-body p-1">
									<?php
                                    if(empty($error_message))
                                    {
                                    ?>
                                        <div class="form-body">
                                        <?php
                                        if(!empty($main_row))
                                        {
                                         ?>
                                            <div class="row">
                                               <div class="col-12">
                                                    <div class="form-group row">
                                                        <label class="col-md-4">Date:</label> 
                                                        <div class="col-md-8"><?php echo date("d-m-Y",$main_row->transaction_date);?></div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        <label class="col-md-4">Subject of Payment:</label> 
                                                        <div class="col-md-8"><?php echo $main_row->title;?></div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        <label class="col-md-4">Merchant Id:</label> 
                                                        <div class="col-md-8"><?php echo $main_row->merchant_id;?></div>
                                                    </div>
                                                </div>
                                                <?php
												if($main_row->main_record_type=='file')
												{
													$download_file = base_url("transactions/Download_main_file?key_id=".base64_encode($main_row->main_transaction_id));
												?>
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            <label class="col-md-4">Click to download file:</label> 
                                                            <div class="col-md-8"><a href="<?php echo $download_file;?>" target="_blank"><i class="la la-download"></i></a></div>
                                                        </div>
                                                    </div>
                                                <?php
												}
												?>
                                              </div>
                                        <?php
                                        }
                                        else
                                        {
                                        echo '<sapn class="text-danger">No Record Found!</span>';
                                        }
                                        ?>
                                        </div>
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
                <?php $this->load->view("view_sub_transactions_v");?>
			</section>
 	   </div>
	</div>
</div>