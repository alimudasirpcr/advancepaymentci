<?php $ci=& get_instance();?>

<div class="table-responsive">

	<table class="table table-striped table-bordered">

		<thead>

			<tr>

				<th width="8%">Sr.</th>

				<th width="10%">Transaction Date</th>

                <th width="15%">Title</th>

                <th>Merchand Id</th>

                <th>Customer ID</th>

                <th width="15%">Full Name</th>

                <th>Country</th>

                <th>Amount</th>

                <th>IBAN</th>

                <th>BIC</th>

                <th>Period</th>

                <th>Start of Payment</th>

                <th>Is Cancel Recursion?</th>

                <th>Status</th>

                <th width="10%">Response Message</th>

                <th width="7%">Action</th>

 			</tr>

		</thead>

		<tbody>

			<?php	

			if(!empty($results))

			{

 				$counter = 0;

				foreach($results as $val)

				{

					$counter++;

					$record_number = $counter+$start;

 					$main_row = $ci->get_main_transaction_row($val->main_transaction_id);

					if(!empty($main_row))

					{

						$title = $main_row->title;

						$merchant_id = $main_row->merchant_id;

						$uploaded_file_name = $main_row->uploaded_file_name;

						$transaction_date = $main_row->transaction_date;

						$download_file = base_url("transactions/Download_main_file?key_id=".base64_encode($val->main_transaction_id));

					}

					if($val->transaction_status=='pending')

					{

						$status_class = 'text-warning';

					}

					elseif($val->transaction_status=='approved')

					{

						$status_class = 'text-success';

					}

					elseif($val->transaction_status=='failed')

					{

						$status_class = 'text-danger';

					}

					else

					{

						$status_class = 'text-info';

					}

					

					if($val->is_cancel_recursion=='Yes')

					{

						$cancel_rec_class = 'text-danger';

					}

					elseif($val->is_cancel_recursion=='No')

					{

						$cancel_rec_class = 'text-success';

					}

					else

					{

						$cancel_rec_class = 'text-info';

					}

					if(!empty($val->recursion_start_type))

					{

						$recursion_start_type = ucfirst($val->recursion_start_type);
						

					}

					else

					{

						if(empty($val->custom_logic))
						{
						$recursion_start_type = 'N/A';
						}
						else
						{
						$recursion_start_type="Date: ".gmdate("Y-m-d", $val->customdate)."<br>".$val->custom_logic;
						}

					}

					if($val->total_update>0)

					{

						$title = $val->payment_subject; //overwrite main title

					}

  				?>

					<tr>

						<td><?php echo $record_number;?></td>

                        <td><?php echo date('d-m-Y',$val->sub_transaction_timestamp);?></td>

                        <td><?php echo substr($title,0,100);?>  

                        <td><?php echo $merchant_id;?></td>

                        <td><?php echo $val->customer_id;?></td>

						<td><?php echo substr($val->full_name,0,100);?></td>

                        <td><?php echo substr($val->country,0,100);?></td>

                        <td style="min-width:150px !important;"><?php echo 'CENT '.$val->user_amount;?></td>

                        <td><?php echo $val->iban;?></td>

                        <td><?php echo $val->bic;?></td>

                        <td><?php echo ucfirst($val->period);?></td>

                        <td><?php echo $recursion_start_type;?></td>

                        <td>

                        	<span class="<?php echo $cancel_rec_class;?>"><?php echo $val->is_cancel_recursion;?></span>

                        </td>

                        <td>

                        	<span class="<?php echo $status_class;?>"><?php echo strtoupper($val->transaction_status);?></span>

                        </td>

                         <td><?php echo $val->response_message;?></td>

                        <td>

                        <a href="javascript:;" onclick="call_url_key_modal('transactions/Update','<?php echo base64_encode($val->sub_transaction_id);?>')" title="Update"><i class="la la-edit info"></i></a>

						<?php

						if($val->sub_is_run_cron_job!='Yes' && $val->sub_record_type=='entry' && $val->reference_id==0)

						{

						?>

							 <a href="javascript:;" onclick="record_deletion('<?php echo base64_encode($val->main_transaction_id);?>','<?php echo base64_encode('main transaction');?>')" title="Delete"><i class="la la-trash danger"></i></a>

						<?php

						}

						?>

                        <?php

						$periods_options = array('weekly','monthly','quarterly','yearly');

						if($val->is_cancel_recursion=='No')

						{

							if(in_array($val->period,$periods_options) && $val->is_recursion=='Yes')

							{

							?>

								 <a href="javascript:;" onclick="cancel_sub_transaction_recursion('<?php echo base64_encode($val->sub_transaction_id);?>','<?php echo base64_encode('cancel sub transaction recursion');?>')" title="Cancel Recursion"><i class="la la-ban danger"></i></a>

							<?php

							}

						}

						?>

                        </td>

  					</tr>

				<?php

				}

			}

 			else

			{

				echo '<tr><td colspan="16" class="danger text-center font-weight-bold">No Record Found!</td></tr>';

			}

			?>

		</tbody> 

	</table>

</div>

<?php	

if(!empty($total_pages) && !empty($results))

{

	if($total_pages>1)

	{

	?>

		<nav aria-label="Page navigation">

			<ul class="pagination justify-content-center">

				<li class="page-item">

					<a class="page-link" href="javascript:;" onclick="get_Previous('get_js_sub_transactions_history','0')" aria-label="Previous">&laquo;</a>

				</li>

				<?php

				for($i=1;$i<=$total_pages;$i++)

				{

					if($i== $page_number)

					{

					?>

						<li class="page-item active">

							<a class="page-link" id="pagination-active" href="#<?php echo $i;?>" onclick="get_js_sub_transactions_history('<?php echo $i;?>')"><?php echo $i;?></a>

						</li>

					<?php	

					}

					else

					{

					?>

						<li class="page-item">

							<a class="page-link" href="#<?php echo $i;?>" onclick="get_js_sub_transactions_history('<?php echo $i;?>')"><?php echo $i;?></a>

						</li>

					<?php

					}

				}

				?>

				<li class="page-item">

					<a class="page-link" href="javascript:;" onclick="get_Next('<?php echo $total_pages;?>','get_js_sub_transactions_history','0')" aria-label="Next">&raquo;</a>

				</li>

			</ul>

		</nav>

	<?php

	}

}

?>