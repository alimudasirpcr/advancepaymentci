<?php defined('BASEPATH') OR exit('No direct script access allowed');?> 

<script src="<?php echo base_url("template/app-assets/vendors/js/vendors.min.js");?>" type="text/javascript"></script>

<script src="<?php echo base_url('template/app-assets/vendors/js/extensions/moment.min.js');?>" type="text/javascript"></script>

<script src="<?php echo base_url('template/assets/js/jsconfig.js');?>" type="text/javascript"></script>

<script src="<?php echo base_url('template/assets/js/loadingoverlay.min.js');?>" type="text/javascript" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php

if($this->router->class=='login')

{

?>	

	<script src="<?php echo base_url('template/assets/js/login.js');?>" type="text/javascript" ></script>

<?php

}

else

{

?>

	<script src="<?php echo base_url('template/app-assets/js/core/app-menu.min.js');?>" type="text/javascript"></script>

    <script src="<?php echo base_url('template/app-assets/js/core/app.min.js');?>" type="text/javascript"></script>

    <?php

	if($this->router->class=='dashboard')

	{

	?>	

 	<?php	

	}

	else

	{

	?>	

		<script src="<?php echo base_url('template/app-assets/vendors/js/tables/datatable/datatables.min.js');?>" type="text/javascript"></script>

        <script src="<?php echo base_url('template/app-assets/vendors/js/extensions/sweetalert.min.js');?>" type="text/javascript" ></script>

        <script src="<?php echo base_url('template/app-assets/js/scripts/customizer.min.js');?>" type="text/javascript"></script>

        <script src="<?php echo base_url('template/app-assets/js/scripts/tables/datatables/datatable-basic.js');?>" type="text/javascript"></script>

 	<?php	

	}

	?>

	<script src="<?php echo base_url('template/app-assets/vendors/js/forms/select/select2.full.min.js');?>" type="text/javascript"></script>

    <script src="<?php echo base_url('template/app-assets/js/scripts/forms/select/form-select2.min.js');?>" type="text/javascript"></script>

    <script src="<?php echo base_url('template/assets/js/functions.js');?>" type="text/javascript" ></script>

<?php	   

}



if($this->router->class=='Transactions' || $this->router->class=='transactions')

{

	if($this->router->method=='index')

	{

		echo "<script>get_js_transactions(1);</script>";	

	}

	if($this->router->method=='TransactionsHistory')

	{

		echo "<script>get_js_sub_transactions_history(1);</script>";	

	}

	if($this->router->method=='ViewTransaction')

	{

		$get_main_transaction_id = '';

		if(!empty($_GET['key_id']))

		{

			$get_main_transaction_id = $this->input->get('key_id');

 		}

 		echo "<script>get_js_sub_transactions('1','".$get_main_transaction_id."');</script>";

	}

	if($this->router->method=='AddSingleTransaction')

	{

	?>

    	<script>

		 var period = document.getElementById("period");

  		 if(period.options[period.selectedIndex].value!='')

		 {

 			 load_recursion_start_type(period.options[period.selectedIndex].value);

		 }

 		</script>

    <?php	

	}

}

if($this->router->class=='Merchants' || $this->router->class=='merchants')

{

	if($this->router->method=='index')

	{

		echo "<script>get_js_merchants(1);</script>";	

	}

}

?>