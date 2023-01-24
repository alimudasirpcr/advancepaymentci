<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
$ci=& get_instance();
?>
<div class="table-responsive">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th width="8%">Sr.</th>
				<th width="10%">Date</th>
                <th width="30%">Subject of Payment</th>
                <th width="25%">Merchant Id</th>
                <th width="20%">Uploaded File</th>
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
   				?>
					<tr>
						<td><?php echo $record_number;?></td>
                        <td><?php echo date('d-m-Y',$val->transaction_date);?></td>
						<td><?php echo substr($val->title,0,50);?></td>
                        <td><?php echo substr($val->merchant_id,0,50);?></td>
                        <td>
                        	<?php
							if($val->main_record_type=='file')
							{
								$download_file = base_url("transactions/Download_main_file?key_id=".base64_encode($val->main_transaction_id));
							?>
                        		<a href="<?php echo $download_file;?>" target="_blank"><i class="la la-download"></i></a>
                            <?php
							}
							else
							{
								echo "N/A";	
							}
							$total_processed_transacton = $ci->count_processed_sub_transactions($val->main_transaction_id);
							?>
                       	</td>
                        <td class="text-center">
                        	<a href="<?php echo base_url('transactions/ViewTransaction?key_id='.base64_encode($val->main_transaction_id));?>" title="View"><i class="la la-eye warning"></i></a>
                           	<?php
							if($total_processed_transacton>0)
							{
							?>
                            	<a target="_blank" href="<?php echo base_url('transactions/ExportTransactions?key_id='.base64_encode($val->main_transaction_id));?>" title="Export"><i class="la la-file-excel-o success" style="font-size:12px;"></i></a>
 							<?php
							}
							?>
                            <?php
							if($val->main_is_run_cron_job!='Yes')
							{
							?>
                                 <a href="javascript:;" onclick="record_deletion('<?php echo base64_encode($val->main_transaction_id);?>','<?php echo base64_encode('main transaction');?>')" title="Delete"><i class="la la-trash danger"></i></a>
 							<?php
							}
							?>
                         </td>
 					</tr>
				<?php
				}
			}
 			else
			{
				echo '<tr><td colspan="6" class="danger text-center font-weight-bold">No Record Found!</td></tr>';
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
					<a class="page-link" href="javascript:;" onclick="get_Previous('get_js_transactions','0')" aria-label="Previous">&laquo;</a>
				</li>
				<?php
				for($i=1;$i<=$total_pages;$i++)
				{
					if($i== $page_number)
					{
					?>
						<li class="page-item active">
							<a class="page-link" id="pagination-active" href="#<?php echo $i;?>" onclick="get_js_transactions('<?php echo $i;?>')"><?php echo $i;?></a>
						</li>
					<?php	
					}
					else
					{
					?>
						<li class="page-item">
							<a class="page-link" href="#<?php echo $i;?>" onclick="get_js_transactions('<?php echo $i;?>')"><?php echo $i;?></a>
						</li>
					<?php
					}
				}
				?>
				<li class="page-item">
					<a class="page-link" href="javascript:;" onclick="get_Next('<?php echo $total_pages;?>','get_js_transactions','0')" aria-label="Next">&raquo;</a>
				</li>
			</ul>
		</nav>
	<?php
	}
}
?>