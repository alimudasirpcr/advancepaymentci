<?php $CI=& get_instance();?>
<div class="table-responsive">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th width="8%">Sr.</th>
				<th width="15%">Merchant Name</th>
                <th width="15%">AID</th>
                <th width="20%">Merchant Id(MID)</th>
                <th width="20%">Key</th>
                <th width="20%">Portal Id</th>
               <!-- <th width="7%">Action</th>-->
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
                        <td><?php echo substr($val->merchant_name,0,50);?></td>
                        <td><?php echo $val->aid;?></td>
						<td><?php echo $val->mid;?></td>
                        <td><?php echo $val->md5_key;?></td>
                        <td><?php echo $val->portalid;?></td>
                       <!-- <td class="text-center">
                        	<a href="<?php echo base_url('merchants/UpdateMerchant?key_id='.base64_encode($val->merchant_id));?>" title="Update"><i class="la la-pencil success"></i></a>
  						</td>-->
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
					<a class="page-link" href="javascript:;" onclick="get_Previous('get_js_merchants','0')" aria-label="Previous">&laquo;</a>
				</li>
				<?php
				for($i=1;$i<=$total_pages;$i++)
				{
					if($i== $page_number)
					{
					?>
						<li class="page-item active">
							<a class="page-link" id="pagination-active" href="#<?php echo $i;?>" onclick="get_js_merchants('<?php echo $i;?>')"><?php echo $i;?></a>
						</li>
					<?php	
					}
					else
					{
					?>
						<li class="page-item">
							<a class="page-link" href="#<?php echo $i;?>" onclick="get_js_merchants('<?php echo $i;?>')"><?php echo $i;?></a>
						</li>
					<?php
					}
				}
				?>
				<li class="page-item">
					<a class="page-link" href="javascript:;" onclick="get_Next('<?php echo $total_pages;?>','get_js_merchants','0')" aria-label="Next">&raquo;</a>
				</li>
			</ul>
		</nav>
	<?php
	}
}
?>