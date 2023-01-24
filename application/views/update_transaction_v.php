<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="modal-body">
    <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel1">Update Transaction</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <br />
	<?php
    if(empty($error_message))
    {
        if(!empty($row))
        {
        ?>
              <form class="form" action="" name="form_data" id="form_data" method="post" novalidate>
                <div class="form-body">
                    <div class="row">
                        <div class="col-12">
                        	<div class="form-group">
                                <div class="alert alert-danger" id="error_div" style="display:none;"></div>
                                <div class="clearfix"></div>
                                <div class="alert alert-success" id="success_div" style="display:none;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group row">
                            	<label class="col-lg-3 col-md-3 col-sm-12 col-xs-12">Subject of Payment: <span class="text-danger">*</span></label>	
                                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                     <input type="text" id="payment_subject" name="payment_subject" placeholder="Subject of Payment" class="form-control" value="<?php echo $row->payment_subject;?>"/>
                               </div>
                             </div>
                         </div>
                         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group row">
                            	<label class="col-lg-3 col-md-3 col-sm-12 col-xs-12">Amount: <span class="text-danger">*</span></label>	
                                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                     <input type="text" id="amount" name="amount" placeholder="Amount" onkeypress="return isNumberKey(event)" class="form-control" value="<?php echo $row->amount;?>"/>
                               </div>
                             </div>
                         </div> 
                          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group row">
                            	<label class="col-lg-3 col-md-3 col-sm-12 col-xs-12">Customer ID: <span class="text-danger">*</span></label>	
                                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                     <input type="text" id="c_id" name="c_id" placeholder="Customer ID"  class="form-control" value="<?php echo $row->customer_id;?>"/>
                               </div>
                             </div>
                         </div> 
                     </div>
                     
                     
                    <div class="form-group">
                    	 <input type="hidden" id="update_id" name="update_id" value="<?php if(!empty($row->sub_transaction_id)){ echo base64_encode($row->sub_transaction_id);}?>">
                         <button type="submit" id="form_btn" name="form_btn" class="btn btn-primary btn-sm common-action-btn pull-right" onclick="form_common_data_validation('<?php echo base64_encode(12);?>')"> Save</button>
                    </div>
                 </div>
             </form>
          <?php
        }
        else
        {
            echo '<div class="row"><div class="col-md-12"><span class="text-danger">Please select valid record to continue!</span></div></div>';	
        }
    }
    else
    {
        echo '<div class="row"><div class="col-md-12"><span class="text-danger">'.$error_message.'</span></div></div>';	
    }
    ?>
</div>