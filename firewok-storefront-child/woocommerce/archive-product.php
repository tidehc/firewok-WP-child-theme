<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>
<header class="woocommerce-products-header">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
	<?php endif; ?>

	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
	?>
</header>
	
<?php

if ( have_posts() ) {

	// Get from ACF
	// Check its shop page
	if(is_shop()){
    	$page_id = get_option( 'woocommerce_shop_page_id' );
  	
  	
	  	// The Description
		if(get_field('shop_description', $page_id)){
			$description = get_field('shop_description', $page_id);
		}

		// Shop menu
		if(get_field('shop_menu', $page_id)){
			$items = array();
			while (the_repeater_field('shop_menu', $page_id)) {
				$items[] = get_sub_field('item_link');
			}
		}

		// Shop catagories
		if(have_rows('product_catagories', $page_id)){
			$catagories = array();
			while (have_rows('product_catagories', $page_id)) : the_row();
				$title 	= get_sub_field('catagory', $page_id)->name;
				$column = get_sub_field('columns' , $page_id);
				$shortcode = "[products category=\"$title\" columns=\"$column\"]"; 
				$catagories[] = array(
					'title' => $title,
					'shortcode' => $shortcode 
				);
			endwhile;
		}

		// Output html
		?> 
		<div class="feature-row"> 
			<div class="col-2"> 
				<?php echo $description; ?> 
			</div>
			<div class="col-2">	
				<ul class="shop-menu">
					<?php 
					if ($items) {
						foreach ($items as $item):
						 ?> 
						 <li class="">
							<a href="<?php echo $item['url']; ?>" target="<?php echo $item['target']; ?>">
								<?php echo $item['title']; ?>
							</a>
						</li>
						 <?php
					  endforeach;
					}
					?>
				</ul> 
			</div>
		</div>
		<?php 
		foreach ($catagories as $catagorie): ?>
				<h2 id="<?php echo strtolower ($catagorie["title"]); ?>">
					<?php echo $catagorie["title"]; ?>
				</h2>
				<?php echo do_shortcode($catagorie["shortcode"]); 	
		endforeach; 
	}
	else{
	    	/**
		 * Hook: woocommerce_before_shop_loop.
		 *
		 * @hooked wc_print_notices - 10
		 * @hooked woocommerce_result_count - 20
		 * @hooked woocommerce_catalog_ordering - 30
		 */
		// do_action( 'woocommerce_before_shop_loop' );

		woocommerce_product_loop_start();

		if ( wc_get_loop_prop( 'total' ) ) {
			while ( have_posts() ) {
				the_post();

				/**
				 * Hook: woocommerce_shop_loop.
				 *
				 * @hooked WC_Structured_Data::generate_product_data() - 10
				 */
				do_action( 'woocommerce_shop_loop' );

				wc_get_template_part( 'content', 'product' );
			}
		}

		woocommerce_product_loop_end();

		/**
		 * Hook: woocommerce_after_shop_loop.
		 *
		 * @hooked woocommerce_pagination - 10
		 */
		// do_action( 'woocommerce_after_shop_loop' );
  	}

} else {
	/**

	$catagory = get_sub_field('catagory', $page_id)->name;
			$column = get_sub_field('columns', $page_id);
			$catagories[] = do_shortcode( "[products category=\"$catagory\" columns=\"$column\"]" ); 
	
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
