<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
$ci=& get_instance();
?> 
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
      <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
          <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="javascript:;"><i class="ft-menu font-large-1"></i></a></li>
          <li class="nav-item mr-auto">
            <a class="navbar-brand" href="<?php echo base_url();?>">
               <h3 class="brand-text menu-logo">Payone</h3>
             </a>
          </li>
          <li class="nav-item d-md-none">
            <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a>
          </li>
        </ul>
      </div>
      <div class="navbar-container content">
        <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="nav navbar-nav mr-auto float-left">
            <li class="nav-item">Mode of Payment : <span class="badge badge-info"><?php echo ucfirst($ci->get_payment_mode());?></span></li>
        </ul>
          <ul class="nav navbar-nav float-right">
            <li class="dropdown dropdown-user nav-item">
              <a class="dropdown-toggle nav-link dropdown-user-link" href="javascript:;" data-toggle="dropdown">
                <?php
				if(!empty($top_menu_user_arr))
				{
 					if(!empty($top_menu_user_arr->user_picture))
					{
						$top_menu_user_pic_path = base_url("uploads/profile/".$top_menu_user_arr->user_picture);
					}
					else
					{
						$top_menu_user_pic_path = base_url("template/app-assets/images/common/no-profile-pic.png");
					}
 					?>
                     <span class="mr-1">Hello,	<span class="user-name text-bold-700"><?php echo $top_menu_user_arr->user_full_name;?></span></span>
                     <!--<span class="avatar"><img src="<?php echo $top_menu_user_pic_path;?>"></span>-->
                <?php
				}
				?>
              </a>
              <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="<?php echo base_url("setting/profile");?>"><i class="ft-user"></i> Edit Profile</a>
                <div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo base_url("logout");?>"><i class="ft-power"></i> Logout</a>
              </div>
            </li>
           </ul>
        </div>
      </div>
    </div>
  </nav>