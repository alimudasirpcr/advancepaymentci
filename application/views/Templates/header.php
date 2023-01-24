<?php defined('BASEPATH') OR exit('No direct script access allowed');?> 
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<title><?php echo $page_title;?></title>
<?php $this->load->view("Templates/css-files");?></head>
<?php
if($this->router->class=='login')
{
	$body_class = 'vertical-layout vertical-menu-modern 1-column bg-full-screen-image menu-expanded blank-page blank-page';
	$data_col = '1-column';
}
else
{
	$body_class = 'vertical-layout vertical-menu-modern 2-columns menu-expanded fixed-navbar';
	$data_col = '2-columns';
}
?>
<body class="<?php echo $body_class;?>" data-open="click" data-menu="vertical-menu-modern" data-col="<?php echo $data_col;?>">