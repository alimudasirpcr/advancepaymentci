<?php defined('BASEPATH') OR exit('No direct script access allowed');?> 
<?php
if(empty($error_message))
{
	if(!empty($main_row))
	{
	?>
    	<div class="card">
            <div class="card-header p-1">
                <h4 class="card-title pull-left">Transaction Details:</h4>
            </div>
            <hr />
            <div class="card-content">
                <div class="card-body p-1">
                    <div class="form-body" id="load_sub_ransaction_data"></div>
                </div>
            </div>
        </div>
     <?php
	}
}
?>