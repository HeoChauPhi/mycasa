<div class="col-lg-6 col-md-6 block-category-search blog-post-item-wrap">
  <h3 class="block-title"><?php echo __('All Blog Posts', 'houzez_child'); ?></h3>
  <div class="block-content">
    <div class="block-search-form">
      <?php 
      $unique_id = esc_attr( uniqid( 'search-form-' ) );
      $placeholder = isset( $houzez_local['blog_search'] ) ? $houzez_local['blog_search'] : '';
      ?>

      <form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( $wp->request ) ); ?>">
        <div class="form-row">
          <div class="col-sm-12 col-md-8">        
            <div class="form-group">
              <input value="<?php if (isset($_GET['search_keyword']) && $_GET['search_keyword'] != '') {echo $_GET['search_keyword']; } ?>" name="search_keyword" id="<?php echo $unique_id; ?>" type="text" placeholder="<?php echo $placeholder; ?>" class="form-control">
            </div>
          </div>
          <div class="col-sm-12 col-md-4">        
            <div class="form-group">
              <button type="submit" class="btn btn-primary btn-full-width"><?php esc_html_e('Search', 'houzez'); ?></button>
            </div>
          </div>
        </div>
      </form>
    </div>


    <?php
    if (isset($_GET['category']) && $_GET['category'] != null) {

    }

    $category_term_query = new WP_Term_Query( array(
      'taxonomy'    => 'category',
      'hide_empty'  => false
    ) );

    if (!empty($category_term_query->terms) && is_array($category_term_query->terms)):
    ?>
    <div class="block-category">
      <ul class="list-category">
        <li class="category-term <?php if ((!isset($_GET['search_keyword']) || $_GET['search_keyword'] == null) && (!isset($_GET['category']) || $_GET['category'] == null)) {echo 'category-term-active';} ?>">
          <a href="<?php echo esc_url( home_url( $wp->request ) . '/?category=' ); ?>">
            <span class="term-name"><?php echo __('All Posts', 'houzez_child'); ?></span>
            <span class="dashed-line"></span>
            <span class="term-count"><?php echo wp_count_posts('post')->publish; ?></span>
          </a>
        </li>
        <?php foreach ($category_term_query->terms as $term): ?>
        <li class="category-term <?php if (isset($_GET['category']) && $_GET['category'] == $term->slug) {echo 'category-term-active';} ?>">
          <a href="<?php echo esc_url( home_url( $wp->request ) . '/?category=' . $term->slug ); ?>">
            <span class="term-name"><?php echo $term->name; ?></span>
            <span class="dashed-line"></span>
            <span class="term-count"><?php echo $term->count; ?></span>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>
  </div>
</div>