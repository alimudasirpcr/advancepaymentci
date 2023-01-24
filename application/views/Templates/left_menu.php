<?php defined('BASEPATH') OR exit('No direct script access allowed');?> 
<?php
$dashboard_active = '';
$transactions_active = '';
$merchants_active = '';
$setting_active = '';
$transactions_main_open = '';
$setting_main_open = '';
if($this->router->class=='dashboard')
{
	$dashboard_active = 'active';
}
elseif($this->router->class=='transactions')
{
	$transactions_active = 'active';
	$transactions_main_open = 'open';
}
elseif($this->router->class=='merchants')
{
	$merchants_active = 'active';
}
elseif($this->router->class=='setting')
{
	$setting_active = 'active';
	$setting_main_open = 'open';
}
else
{
	$dashboard_active = 'active';
}
?>
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item <?php echo $dashboard_active;?>"><a href="<?php echo base_url();?>"><i class="la la-home"></i><span class="menu-title">Dashboard</span></a></li>
            <li class="nav-item <?php echo $transactions_active;?> <?php echo $transactions_main_open;?>"><a href="javascript:;"><i class="la la-money"></i><span class="menu-title">Transactions</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="<?php echo base_url("transactions");?>">Transactions</a></li>
                    <li><a class="menu-item" href="<?php echo base_url("transactions/TransactionsHistory");?>">Transactions History</a></li>
                    <li><a class="menu-item" href="<?php echo base_url("transactions/AddSingleTransaction");?>">Add Single Transaction</a></li>
                    <li><a class="menu-item" href="<?php echo base_url("transactions/AddTransaction");?>">Import Transaction Records</a></li>
                    <li><a class="menu-item" href="<?php echo base_url("transactions/maketrans");?>">Today's Transactions</a></li>
                 </ul>
            </li>
            <li class="nav-item <?php echo $merchants_active;?>"><a href="<?php echo base_url("merchants");?>"><i class="la la-users"></i><span class="menu-title">Merchants</span></a></li>
            <li class="nav-item <?php echo $setting_active;?> <?php echo $setting_main_open;?>"><a href="javascript:;"><i class="la la-cog"></i><span class="menu-title">Settings</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="<?php echo base_url("setting/profile");?>">Update Profile</a></li>
                    <li><a class="menu-item" href="<?php echo base_url("setting/Changepassword");?>">Change Password</a></li>
                    <li><a class="menu-item" href="<?php echo base_url("setting/PaymentMode");?>">Mode of Payment</a></li>
                 </ul>
            </li>
            <li class="nav-item"><a href="<?php echo base_url("logout");?>"><i class="ft-power"></i><span class="menu-title" data-i18n="nav.animation.main">Logout</span></a></li>
        </ul>
    </div>
</div>