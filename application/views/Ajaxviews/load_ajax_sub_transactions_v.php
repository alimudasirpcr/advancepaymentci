<?php $CI=& get_instance();?>
<div class="table-responsive">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th width="8%">Sr.</th>
				<th width="20%">Name</th>
                <th width="15%">Country Code</th>
                <th width="20%">Amount</th>
                <th>Iban</th>
                <th>Bic</th>
                <th>Status</th>
                <th>Transaction Date</th>
                <th width="20%">Response</th>
 			</tr>
		</thead>
		<tbody>
			<?php	
 			if(!empty($sub_transactions))
			{
 				$counter = 0;
				foreach($sub_transactions as $val)
				{
					$counter++;
					$record_number = $counter+$start;
					
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
  				?>
					<tr>
						<td><?php echo $record_number;?></td>
                        <td><?php echo substr($val->full_name,0,100);?></td>
						<td><?php echo substr($val->country,0,50);?></td>
                        <td style="min-width:150px !important;"><?php echo 'CENT '.$val->user_amount;?></td>
                        <td><?php echo $val->iban;?></td>
                        <td><?php echo $val->bic;?></td>
                        <td><span class="<?php echo $status_class;?>"><?php echo strtoupper($val->transaction_status);?></span></td>
                        <td><?php echo date('d-m-Y',$val->sub_transaction_timestamp);?></td>
                        <td><?php echo $val->response_message;?></td>
  					</tr>
				<?php
				}
			}
 			else
			{
				echo '<tr><td colspan="9" class="danger text-center font-weight-bold">No Record Found!</td></tr>';
			}
			?>
		</tbody> 
	</table>
</div>
<?php	
if(!empty($total_pages) && !empty($sub_transactions))
{
	if($total_pages>1)
	{
	?>
		<nav aria-label="Page navigation">
			<ul class="pagination justify-content-center">
				<li class="page-item">
					<a class="page-link" href="javascript:;" onclick="get_Previous('get_js_sub_transactions','<?php echo $get_main_transaction_id;?>')" aria-label="Previous">&laquo;</a>
				</li>
				<?php
				for($i=1;$i<=$total_pages;$i++)
				{
					if($i== $page_number)
					{
					?>
						<li class="page-item active">
							<a class="page-link" id="pagination-active" href="#<?php echo $i;?>" onclick="get_js_sub_transactions('<?php echo $i;?>','<?php echo $get_main_transaction_id;?>')"><?php echo $i;?></a>
						</li>
					<?php	
					}
					else
					{
					?>
						<li class="page-item">
							<a class="page-link" href="#<?php echo $i;?>" onclick="get_js_sub_transactions('<?php echo $i;?>','<?php echo $get_main_transaction_id;?>')"><?php echo $i;?></a>
						</li>
					<?php
					}
				}
				?>
				<li class="page-item">
					<a class="page-link" href="javascript:;" onclick="get_Next('<?php echo $total_pages;?>','get_js_sub_transactions','<?php echo $get_main_transaction_id;?>')" aria-label="Next">&raquo;</a>
				</li>
			</ul>
		</nav>
	<?php
	}
}
?>