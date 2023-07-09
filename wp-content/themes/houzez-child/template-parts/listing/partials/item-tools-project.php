<?php 
global $post;

if(houzez_option('disable_preview', 1) ) { ?>
<ul class="item-tools">

    <?php if(houzez_option('disable_preview', 1)) { ?>
    <li class="item-tool item-preview">
        <span class="hz-show-lightbox-js" data-listid="<?php echo intval($post->ID)?>" data-toggle="tooltip" data-placement="top" title="<?php echo houzez_option('cl_preview', 'Preview'); ?>">
                <i class="houzez-icon icon-expand-3"></i>   
        </span><!-- item-tool-favorite -->
    </li><!-- item-tool -->
    <?php } ?>
</ul><!-- item-tools -->
<?php } ?>