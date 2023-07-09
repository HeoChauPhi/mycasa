<?php
global $post;
$mcal_down_payment = '';
$currency_symbol = currency_maker();
$currency_symbol = $currency_symbol['currency'];
$mcal_terms = houzez_option('mcal_terms', 12);
$mcal_down_payment = houzez_option('mcal_down_payment', 15);
$mcal_interest_rate = houzez_option('mcal_interest_rate', 3.5);
$mcal_prop_tax_enable = houzez_option('mcal_prop_tax_enable', 1);
$mcal_prop_tax = houzez_option('mcal_prop_tax', 3000);
$mcal_hi_enable = houzez_option('mcal_hi_enable', 1);
$mcal_hi = houzez_option('mcal_hi', 1000);
$mcal_pmi_enable = houzez_option('mcal_pmi_enable', 1);
$mcal_pmi = houzez_option('mcal_pmi', 1000);

// $property_price = 0;

if ($post->post_type == 'property') {
  $property_price = get_post_meta($post->ID, 'fave_resale-usd', true);
} elseif ($post->post_type == 'project') {
  $property_price = get_field( 'avg_unit_price_sqm_usd', $post->ID);
} 
if ( !empty($_COOKIE['googtrans']) ) {
	$current_lang = $_COOKIE['googtrans'];
	if ($current_lang == '/en/vi' || $current_lang == '/en/vn') {
		$currency_symbol = 'đ';

		if ($post->post_type == 'property') {
      $property_price = get_post_meta($post->ID, 'fave_resale-vnd', true);
    } elseif ($post->post_type == 'project') {
      $property_price = get_field( 'avg_unit_price_sqm_vnd', $post->ID);
    } 
	}
}

$property_price = intval($property_price);

if($property_price == 0) {
	$mcal_terms = $mcal_down_payment = $mcal_interest_rate = $mcal_prop_tax = $mcal_hi = $mcal_pmi = $property_price = '';
}

?>
<div class="d-flex align-items-center sm-column">
	<div class="mortgage-calculator-chart flex-fill">
		<div class="mortgage-calculator-monthly-payment-wrap">
			<div id="m_monthly_val" class="mortgage-calculator-monthly-payment"></div>
			<div class="mortgage-calculator-monthly-requency"><?php echo houzez_option('spc_monthly', 'Monthly'); ?></div>
		</div>

		<canvas id="mortgage-calculator-chart" width="200" height="200"></canvas>


	</div><!-- mortgage-calculator-chart -->
	<div class="mortgage-calculator-data flex-fill">
		<ul class="list-unstyled">
			<li class="mortgage-calculator-data-1 stats-data-1">
				<i class="houzez-icon icon-sign-badge-circle mr-1"></i> 
				<strong><?php echo __('Advance payment', 'houzez_child'); ?></strong>
				<span id="advance_payment"></span>
			</li>

			<li class="mortgage-calculator-data-2 stats-data-2">
				<i class="houzez-icon icon-sign-badge-circle mr-1"></i> 
				<strong><?php echo __('Bank loan', 'houzez_child'); ?></strong> 
				<span id="bank_loan"></span>
			</li>

			<li class="mortgage-calculator-data-3 stats-data-3">
				<i class="houzez-icon icon-sign-badge-circle mr-1"></i> 
				<strong><?php echo __('Total loan interest', 'houzez_child'); ?></strong> 
				<span id="loan_interest"></span>
			</li>

			<li class="mortgage-calculator-data-4 stats-data-4">
				<i class="houzez-icon icon-sign-badge-circle mr-1"></i> 
				<strong><?php echo __('Total amount', 'houzez_child'); ?></strong> 
				<span id="total_amount"></span>
			</li>
		</ul>
	</div><!-- mortgage-calculator-data -->
</div><!-- d-flex -->

<form method="post">
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label><?php echo houzez_option('spc_total_amt', 'Total Amount'); ?></label>
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text"><?php echo esc_attr($currency_symbol);?></div>
					</div><!-- input-group-prepend -->
					<input id="total_price" type="text" class="form-control" placeholder="<?php echo houzez_option('spc_total_amt', 'Total Amount'); ?>" value="<?php echo intval($property_price); ?>">
				</div><!-- input-group -->
			</div><!-- form-group -->
		</div><!-- col-md-4 -->
		<div class="col-md-4">
			<div class="form-group">
				<label><?php echo houzez_option('spc_down_payment', 'Down Payment'); ?></label>
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text">%</div>
					</div><!-- input-group-prepend -->
					<input id="down_payment" type="text" class="form-control" placeholder="<?php echo houzez_option('spc_down_payment', 'Down Payment'); ?>" value="<?php echo esc_attr($mcal_down_payment); ?>">
				</div><!-- input-group -->
			</div><!-- form-group -->
		</div><!-- col-md-4 -->
		<div class="col-md-4">
			<div class="form-group">
				<label><?php echo houzez_option('spc_ir', 'Interest Rate'); ?></label>
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text">%</div>
					</div><!-- input-group-prepend -->
					<input id="interest_rate" type="text" class="form-control" placeholder="<?php echo houzez_option('spc_ir', 'Interest Rate'); ?>" value="<?php echo esc_attr($mcal_interest_rate); ?>">
				</div><!-- input-group -->
			</div><!-- form-group -->
		</div><!-- col-md-4 -->
		<div class="col-md-4">
			<div class="form-group">
				<label><?php echo houzez_option('spc_load_term', 'Loan Terms (Years)'); ?></label>
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text">
							<i class="houzez-icon icon-calendar-3"></i>
						</div>
					</div><!-- input-group-prepend -->
					<input id="loan_term" type="text" class="form-control" placeholder="<?php echo houzez_option('spc_load_term', 'Loan Terms (Years)'); ?>" value="<?php echo esc_attr($mcal_terms); ?>">
				</div><!-- input-group -->
			</div><!-- form-group -->
		</div><!-- col-md-4 -->
		<input id="currency_symbol" type="text" class="form-control hidden" value="<?php echo $currency_symbol; ?>">

		<div class="col-md-12">
			<button id="calculate_loan_custom" type="submit" class="btn btn-search btn-primary" data-target="#loan-calculator" data-toggle="modal"><?php echo houzez_option('spc_btn_cal', 'Calculate'); ?></button>
		</div><!-- col-md-12 -->
	</div><!-- row -->
</form>

<div id="loan-calculator" class="loan-calculator">
	<div class="loan-calculator-inner">
		<i class="fas fa-times popup-close"></i>
		<div class="loan-calculator-table">
			<table class="table">
				<thead>
					<tr>
						<th><?php echo __('Month', 'houzez_child'); ?></th>
						<th><?php echo __('Remain', 'houzez_child') . ' (' . $currency_symbol . ')'; ?></th>
						<th><?php echo __('Principal Monthly', 'houzez_child') . ' (' . $currency_symbol . ')'; ?></th>
						<th><?php echo __('Interest Monthly') . ' (' . $currency_symbol . ')'; ?></th>
						<th><?php echo __('Total Monthly', 'houzez_child') . ' (' . $currency_symbol . ')'; ?></th>
					</tr>
				</thead>
				<tbody></tbody>
				<tfoot></tfoot>
			</table>
		</div>
	</div>
</div>