<?php
$term_id = '';
$term_tags = wp_get_post_terms( get_the_ID(), 'property_tag', array("fields" => "all"));

$label_id = '';
$term_label = wp_get_post_terms( get_the_ID(), 'property_label', array("fields" => "all"));

$enable_label = houzez_option('disable_label', 1);

if( $enable_label ) {
?>
<div class="labels-wrap labels-right"> 

	<?php 
	if( !empty($term_tags) ) {
		foreach( $term_tags as $tag ) {
	        $tag_id = $tag->term_id;
	        $tag_name = $tag->name;
	        echo '<a href="'.get_term_link($tag_id).'" class="label-tag label tag-color-'.intval($tag_id).'">
					'.esc_attr($tag_name).'
				</a>';
	    }
	}

	if( !empty($term_label) ) {
	    foreach( $term_label as $label ) {
	        $label_id = $label->term_id;
	        $label_name = $label->name;
	        echo '<a href="'.get_term_link($label_id).'" class="hz-label label label-color-'.intval($label_id).'">
					'.esc_attr($label_name).'
				</a>';
	    }
	}
	?>       

</div>
<?php } ?>