<?php
$twitter_user = '';
global $post;
$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
?>

<a class="dropdown-item" target="_blank" href="<?php if(wp_is_mobile()){echo 'https://api.whatsapp.com/send?text=';} else { echo 'https://api.whatsapp.com/send?text=';} echo  get_the_title() .  '&nbsp;' . get_the_permalink();?>">
	<i class="houzez-icon icon-messaging-whatsapp mr-1"></i> <?php esc_html_e('WhatsApp', 'houzez'); ?>
</a>

<a class="dropdown-item" href="https://www.instagram.com/?url=<?php echo get_the_permalink();?>" target="_blank" rel="noopener">
  <i class="fab fa-instagram"></i> <?php esc_html_e('Instagram', 'houzez'); ?>
</a>

<a class="dropdown-item" href="line://msg/text/<?php echo get_the_permalink();?>" target="_blank" rel="noopener">
  <i class="fab fa-line"></i> <?php esc_html_e('Line', 'houzez'); ?>
</a>

<a class="dropdown-item" href="skype:<?php echo get_the_permalink();?>?chat" target="_blank" rel="noopener">
  <i class="fab fa-skype"></i> <?php esc_html_e('Skype', 'houzez'); ?>
</a>

<?php if (wp_is_mobile()): ?>
<a class="dropdown-item" target="_blank" href="<?php echo 'viber://forward?text=' . get_the_title() .  '&nbsp;' . get_the_permalink();?>">
	<i class="fab fa-viber"></i> <?php esc_html_e('Viber', 'houzez'); ?>
</a>

<a class="dropdown-item" target="_blank" href="<?php echo 'weixin://dl/chat' . get_the_title() .  '&nbsp;' . get_the_permalink();?>">
	<i class="fab fa-weixin"></i> <?php esc_html_e('Wechat', 'houzez'); ?>
</a>

<a class="dropdown-item" target="_blank" href="<?php echo 'kakaolink://send/' . get_the_title() .  '&nbsp;' . get_the_permalink();?>">
	<i class="fab fa-korvue"></i> <?php esc_html_e('KakaoTalk', 'houzez'); ?>
</a>
<?php endif; ?>

<?php
echo '<a class="dropdown-item" href="https://www.facebook.com/sharer.php?u=' . urlencode(get_permalink()) . '&amp;t='.urlencode(get_the_title()).'" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;">
	<i class="houzez-icon icon-social-media-facebook mr-1"></i> '.esc_html__('Facebook', 'houzez').'
</a>
<a class="dropdown-item" href="https://twitter.com/intent/tweet?text=' . urlencode(get_the_title()) . '&url=' .  urlencode(get_permalink()) . '&via=' . urlencode($twitter_user ? $twitter_user : get_bloginfo('name')) .'" onclick="if(!document.getElementById(\'td_social_networks_buttons\')){window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;}">
	<i class="houzez-icon icon-social-media-twitter mr-1"></i> '.esc_html__('Twitter', 'houzez').'
</a>
<a class="dropdown-item" href="https://pinterest.com/pin/create/button/?url='. urlencode( get_permalink() ) .'&amp;media=' . (!empty($image[0]) ? $image[0] : '') . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;">
	<i class="houzez-icon icon-social-pinterest mr-1"></i> '.esc_html__('Pinterest', 'houzez').'
</a>
<a class="dropdown-item" href="https://www.linkedin.com/shareArticle?mini=true&url='. urlencode( get_permalink() ) .'&title=' . urlencode( get_the_title() ) . '&source='.urlencode( home_url( '/' ) ).'" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;">
	<i class="houzez-icon icon-professional-network-linkedin mr-1"></i> '.esc_html__('Linkedin', 'houzez').'
</a>
<a class="dropdown-item" href="mailto:someone@example.com?Subject='.get_the_title().'&body='. urlencode( get_permalink() ) .'">
	<i class="houzez-icon icon-envelope mr-1"></i>'.esc_html__('Email', 'houzez').'
</a>';