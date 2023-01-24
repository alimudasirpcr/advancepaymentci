<?php defined('BASEPATH') OR exit('No direct script access allowed');?> 
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <section class="flexbox-container">
          <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-md-4 col-10 box-shadow-2 p-0">
              <div class="card border-grey border-lighten-3 m-0">
                <div class="card-header border-0">
                  <div class="card-title text-center info font-weight-bold">Payone</div>
                  <h6 class="card-subtitle line-on-side text-muted text-center font-weight-bold pt-2"><span>Forgot Password</span></h6>
                  
                </div>
                <div class="card-content">
                  <div class="card-body">
                    <ul class="col-12 alert alert-danger" id="error_div" style="display:none;"></ul>
                    <ul class="col-12 alert alert-success" id="success_div" style="display:none;"></ul>
                    <form class="form-horizontal" name="form_data" id="form_data" action=""  method="post" novalidate>
                      <fieldset class="form-group position-relative has-icon-left">
                        <input type="text" class="form-control input-lg" name="user_email" id="user_email" placeholder="Your Email" tabindex="1">
                        <div class="form-control-position"><i class="ft-mail"></i></div>
                        <div class="help-block font-small-3"></div>
                      </fieldset>
                      <button type="submit" name="forgot_password_btn" id="forgot_password_btn" class="btn btn-info btn-block btn-lg mt-3"><i class="ft-unlock"></i>  Recover Password</button>
                      <div class="clearfix"></div>
                      <div class="form-group row mt-1">
                        <div class="col-md-6 col-12 text-center text-md-left">&nbsp;</div>
                        <div class="col-md-6 col-12 text-center text-md-right"><a href="<?php echo base_url("login");?>" class="card-link">Back to Login</a></div>
                      </div>
                    </form>
                  </div>
                </div>
               </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
