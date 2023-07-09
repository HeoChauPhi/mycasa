<ul class="item-price-wrap hide-on-list">
	<?php
	if ( !empty($_COOKIE['googtrans']) ) {
		$current_lang = $_COOKIE['googtrans'];
		$price_data = houzez_child_price_by_pll($current_lang);

		if ( !empty($price_data['rent_price']) && !empty($price_data['total_sale_price']) ) {
			echo '<li class="item-price">' . $price_data['rent_price'] . '/' . $price_data['after_rent_price'] . '</li>';
			echo '<li class="item-sub-price">' . $price_data['total_sale_price'] . '</li>';
		} elseif ( !empty($price_data['rent_price']) && empty($price_data['total_sale_price']) ) {
			echo '<li class="item-price">' . $price_data['rent_price'] . '/' . $price_data['after_rent_price'] . '</li>';
		} elseif ( empty($price_data['rent_price']) && !empty($price_data['total_sale_price']) ) {
			echo '<li class="item-price">' . $price_data['total_sale_price'] . '</li>';
		} elseif ( !empty($price_data['project_price']) ) {
			echo '<li class="item-price">' . $price_data['project_price'] . '</li>';
		} else {
			echo '<li class="item-price">' . __('contact', 'houzez_child') . '</li>';
		}
	} else {
		if ($post->post_type == 'project') {
			$project_price = get_field( 'avg_unit_price_sqm_usd', $post->ID) != 0 ? '$' . number_format((int)get_field( 'avg_unit_price_sqm_usd', $post->ID), 0, '.', ',') : __('Contact', 'houzez_child');
			echo '<li class="item-price">' . $project_price . '</li>';
		} elseif ($post->post_type == 'property' && empty(get_post_meta($post->ID, 'fave_property_price', true))) {
			$property_sale_price = !empty(get_post_meta($post->ID, 'fave_resale-usd', true)) ? '$' . number_format((int)get_post_meta($post->ID, 'fave_resale-usd', true), 0, '.', ',') : __('Contact', 'houzez_child');
			echo '<li class="item-price">' . $property_sale_price . '</li>';
		} else {
			$property_sale_price = !empty(get_post_meta($post->ID, 'fave_resale-usd', true)) ? '$' . number_format((int)get_post_meta($post->ID, 'fave_resale-usd', true), 0, '.', ',') : null;
			echo houzez_listing_price_v1();
			if ($property_sale_price) {
				echo '<li class="item-sub-price">' . $property_sale_price . '</li>';
			}
		}
	}
	?>
</ul>