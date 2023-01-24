<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $CI=& get_instance();?>
<script src="https://js.stripe.com/v3/"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("template/css/normalize.css");?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("template/css/global.css");?>">


<script src="<?php echo base_url("template/js/script.js");?>" type="text/javascript"></script>

<div class="app-content content">
	<div class="content-wrapper">
		<div class="content-header row"></div>
		<div class="content-body">
        	
 			



			<section>
 				<div class="row">
					<div class="col-12">
						<div class="card">
                            <div class="card-header p-1">
								<h4 class="card-title pull-left">Stripe Transactions</h4>

  							</div>
 							<hr />
							<div class="card-content">
 								<div class="card-body card-dashboard p-1">
                 <div class="row">
                    <div class="col-4 offset-3">
                      <label> <strong> Subject Of Payment</strong> : <?php  echo $trans[0]['payment_subject'] ?> </label> 
                    </div>
                    <div class="col-3">
                      <label><strong>Customer ID</strong> : <?php  echo $trans[0]['customer_id'] ?> </label> 
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-4 offset-3">
                      <label><strong>BIC </strong>: <?php  echo $trans[0]['bic'] ?> </label> 
                    </div>
                    <div class="col-3">
                      <label><strong>Period </strong>: <?php  echo $trans[0]['period'] ?> </label> 
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-4 offset-3">
                      <label>IBAN : <input type="text"  id="myInput" value="<?php  echo $trans[0]['iban'] ?>" >  </label> 
                    </div>
                    <div class="col-1 ">
                        <button title="Copy to Clipboard" class="btn btn-primary" onclick="myFunction()"><i class="la la-clipboard"></i></button>
                    </div>
                  </div>

    
<input type="hidden" name="id" id="id" value="<?php  echo $id ?>" > 
<input type="hidden" name="description" id="description" value="<?php  echo $trans[0]['payment_subject'] ?>" >


<input type="hidden" name="amount" id="amount" value="<?php  echo  $trans[0]['amount'] ?>" > 
								 <div class="sr-root">
      <div class="sr-main">
        <form id="payment-form" name="payment-form" class="sr-payment-form">
          <div class="sr-combo-inputs-row">
            <div class="col">
              <label for="name">
                Name
              </label>
              <input id="name" name="name" placeholder="Jenny Rosen" required value="<?php echo $trans[0]['firstname']." ".$trans[0]['lastname'] ?>" />
            </div>
            <div class="col">
              <label for="email">
                Email Address
              </label>
              <input
                id="email"
                name="email"
                type="email"
                placeholder="jenny.rosen@example.com"
                value="<?php  echo  $trans[0]['email'] ?>"
                required
              />
              <!-- <input class="InputElement" type="text" name="iban" value="DE89370400440532013000"> -->
            </div>
          </div>

          <div class="sr-combo-inputs-row">
            <div class="col">
              <label for="iban-element">
                IBAN
              </label>
              <div id="iban-element">
                <!-- A Stripe Element will be inserted here. -->
              </div>
            </div>
          </div>

          <!-- Used to display form errors. -->
          <div id="error-message" class="sr-field-error" role="alert"></div>

          <!-- Display mandate acceptance text. -->
          <div class="col" id="mandate-acceptance">
            By providing your IBAN and confirming this payment, you are
            authorizing Rocketship Inc. and Stripe, our payment service
            provider, to send instructions to your bank to debit your account
            and your bank to debit your account in accordance with those
            instructions. You are entitled to a refund from your bank under the
            terms and conditions of your agreement with your bank. A refund must
            be claimed within 8 weeks starting from the date on which your
            account was debited.
          </div>

          <button id="confirm-mandate">
            <div disabled class="spinner hidden" id="spinner"></div>
            <span id="button-text"
              >Confirm mandate and initiate debit for
              <span id="order-amount"></span
            ></span>
          </button>
        </form>
        <div class="sr-result hidden">
          <p>Payment processing<br /></p>
          <pre>
            <code></code>
          </pre>
        </div>
      </div>
    </div>


								 </div>
							</div>
						</div>
					</div>
				</div>
			</section>

	   </div>
	</div>
</div>