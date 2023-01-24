<?php defined('BASEPATH') OR exit('No direct script access allowed');?> 
<?php 
$ci=&get_instance();
$total_transactions = 0;
$total_pending = 0;
$total_approved = 0;
$total_failed = 0;
if(!empty($statistics_row))
{
	$total_transactions = $statistics_row->total_transactions;
	$total_pending = $statistics_row->total_pending;
	$total_approved = $statistics_row->total_approved;
	$total_failed = $statistics_row->total_failed;
}
?>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="card pull-up">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h6 class="text-muted">Total Transactions</h6>
                                        <h3><?php echo $total_transactions;?></h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="la la-money info font-large-2 float-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="card pull-up">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h6 class="text-muted">Total Successful Transactions</h6>
                                        <h3><?php echo $total_approved;?></h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="la la-thumbs-o-up success font-large-2 float-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="card pull-up">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h6 class="text-muted">Total Failed Transactions</h6>
                                        <h3><?php echo $total_failed;?></h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="la la-thumbs-o-down danger font-large-2 float-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="card pull-up">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h6 class="text-muted">Total Pending Transactions</h6>
                                        <h3><?php echo $total_pending;?></h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="la la-warning warning font-large-2 float-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
