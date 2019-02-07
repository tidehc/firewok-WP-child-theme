<?php

/**
 * Storefront automatically loads the core CSS even if using a child theme as it is more efficient
 * than @importing it in the child theme style.css file.
 *
 * Uncomment the line below if you'd like to disable the Storefront Core CSS.
 *
 * If you don't plan to dequeue the Storefront Core CSS you can remove the subsequent line and as well
 * as the sf_child_theme_dequeue_style() function declaration.
 */
//add_action( 'wp_enqueue_scripts', 'sf_child_theme_dequeue_style', 999 );

/**
 * Dequeue the Storefront Parent theme core CSS
 */
function sf_child_theme_dequeue_style() {
	wp_dequeue_style( 'storefront-style' );
	wp_dequeue_style( 'storefront-woocommerce-style' );
}

/**
 * Note: DO NOT! alter or remove the code above this text and only add your custom PHP functions below this text.
 */

/* Enqueue Styles with version control */
// function my_theme_enqueue_styles() {
//     wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css');
// }

//add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

/* Add ACF options page */
if( function_exists('acf_add_options_page') ) {	
	acf_add_options_page();	
}

/* Add SVG uploads */
function add_file_types_to_uploads($file_types){
	$new_filetypes = array();
	$new_filetypes['svg'] = 'image/svg+xml';
	$file_types = array_merge($file_types, $new_filetypes );
	return $file_types;
}

add_action('upload_mimes', 'add_file_types_to_uploads');

/* Add custom script*/
function firewok_script() {
	wp_enqueue_script(
		'custom-script',
		get_stylesheet_directory_uri() . '/assets/js/script.js'
	);
}

add_action( 'wp_enqueue_scripts', 'firewok_script' );

/**
 * Firewok Header 
 */

/*Firewok notification banner */
if( ! function_exists( 'firewok_banner' ) ) {
	function firewok_banner() {
		if( function_exists('acf_add_options_page') ){
			?>
			<div class="banner flex-item"> 
				<h4>
					<?php the_field('banner_notification', 'option'); ?>	
				</h4>
			</div>	
			<?php
		}
	}	
}

/*Header */
if( ! function_exists( 'firewok_site_branding' ) ) {
	function firewok_site_branding() {
		/* ACF vars */		
		$logo 		= 	get_field('logo', 		'option');
		$logo_link 	= 	get_field('logo_link', 	'option');
		$site_title =   get_field('site_title', 'option');
		$tagline 	= 	get_field('tagline', 	'option');		
		?>
		<div class="site-branding flex-item">	
			<div class="site-logo" id="firewok-logo">
				<a class="custom-logo-link" href="<?php echo $logo_link; ?>">
					<?php echo wp_get_attachment_image( $logo['id'], 'full'); ?>
				</a>
			</div>
			<div class="site-title flex-item">
				<h1><?php echo $site_title; ?></h1>
				<h2><?php echo $tagline; ?></h2>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'firewok_primary_navigation' ) ) {
	
	function firewok_primary_navigation() {
		?>
		<nav id="site-navigation" class="main-navigation flex-item" role="navigation" aria-label="<?php esc_html_e( 'Primary Navigation', 'storefront' ); ?>">
			<button class="menu-toggle" aria-controls="site-navigation" aria-expanded="false"><span><?php echo esc_attr( apply_filters( 'storefront_menu_toggle_text', __( 'Menu', 'storefront' ) ) ); ?></span></button>
			<?php
			wp_nav_menu(
				array(
					'theme_location'	=> 'primary',
					'container_class'	=> 'primary-navigation',
				)
			);

			wp_nav_menu(
				array(
					'theme_location'	=> 'handheld',
					'container_class'	=> 'handheld-navigation',
				)
			);
			?>
		</nav><!-- #site-navigation -->
		<?php
	}
}

/*Header Contact Info */
if( ! function_exists( 'firewok_contact_info' ) ) {
	function firewok_contact_info() {
		/* ACF vars */
		$email 		= 	get_field('email', 	'option');
		$phone 		= 	get_field('phone', 	'option');				
		?>
		<div class="flex-spacer flex-item"></div>
		<div class="contact-info flex-item">

			<div class="contact-email">
				<a class="email" href="mailto:<?php echo $email; ?>"> 
					<?php echo $email; ?>
				</a>
			</div>

			<div class="contact-phone">
				<a class="phone" href="tel:+44-<?php echo $phone; ?>"> 
					<?php echo $phone; ?>
				</a>
			</div>

			<?php if( have_rows('social_media', 'option') ): ?>
				<div class="social-icons">
					
					<?php while( have_rows('social_media', 'option') ): the_row(); 
						$icon = get_sub_field('social_icon');
						$link = get_sub_field('social_link');
					?>

					<a href="<?php echo $link['url']; ?>" class="<?php echo $icon; ?>">
					</a>

					<?php endwhile; ?>
					
				</div>
			<?php endif; ?>
			
		</div>
		<?php
	}
}

if ( ! function_exists( 'firewok_navigation_wrapper' ) ) {
	/**
	 * The primary navigation wrapper
	 */
	function firewok_navigation_wrapper() {
		echo '<div class="firewok-primary-navigation">';
	}
}

if ( ! function_exists( 'firewok_navigation_wrapper_close' ) ) {
	/**
	 * The primary navigation wrapper close
	 */
	function firewok_navigation_wrapper_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'storefront_header_cart' ) ) {
	/**
	 * Display Header Cart
	 *
	 * @since  1.0.0
	 * @uses  storefront_is_woocommerce_activated() check if WooCommerce is activated
	 * @return void
	 */
	function storefront_header_cart() {
		if ( storefront_is_woocommerce_activated() ) {
			if ( is_cart() ) {
				$class = 'current-menu-item';
			} else {
				$class = '';
			}
			?>
			<ul id="site-header-cart" class="site-header-cart menu flex-item">
				<li class="<?php echo esc_attr( $class ); ?>">
					<?php storefront_cart_link(); ?>
				</li>
				<li>
					<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
				</li>
			</ul>
			<?php
		}
	}
}

/*
* Product Page
*/

if (! function_exists( 'firewok_product_images' )) {
	
	function firewok_product_images(){

		?> <div class="product-images"> <?php

			if( have_rows('rows') ): 

				// $rows = get_field('rows');

				while ( have_rows('rows') ) : the_row();

					// check if the repeater field has rows of data
					if( have_rows('feature_row') ): 

						?><div class="feature-row"><?php
							$colsSize = 0;
							while ( have_rows('feature_row') ) : the_row(); 
								$colsSize++;
							endwhile; 	

						    while ( have_rows('feature_row') ) : the_row();

						        $type = 		get_sub_field('feature_type');  

						        if ($type == 'image'):
						        	$image = get_sub_field('image');
						        else:
						        	$video = get_sub_field('feature_video');
						        endif;

						    	?>
						    	<div class="feature <?php echo 'col-'.$colsSize?>">
						    	<?php
					    		 if ($type == 'image'): 
					    		 	?>

							  		<?php echo wp_get_attachment_image( $image['id'], 'full'); ?>
							  		
							  	<?php elseif ($type == 'video'): ?>
							  		<div class="embed-container">
							  			<?php echo $video; ?>
							  		</div>
							  	<?php endif; ?>
						    </div>
						    
						    <?php endwhile; ?>
						</div>
					<?php endif; 
				endwhile; 
		 	endif;
		?> </div> <?php
	}
}

/**
 * Reorder product data tabs
 */
add_filter( 'woocommerce_product_tabs', 'woo_reorder_tabs', 98 );
function woo_reorder_tabs( $tabs ) {

	$tabs['reviews']['priority'] = 5;	// Reviews first
	$tabs['description']['priority'] = 10;			// Description second
	$tabs['additional_information']['priority'] = 15;	// Additional information third

	return $tabs;
}


/**
 * Storefront Removals 
 */

/* Remove search */
function storefront_product_search() {
	/*
	* Leave blank
	* Delete this function to bring back search
	*/
}

/* Remove storefront credit */
function storefront_credit() {
	/*
	* Leave blank
	* Delete this function to bring back storefront credit
	*/
}


/** 
 *  Hooks
 */

/*Add firewok banner to header*/
add_action( 'firewok_header_info', 'firewok_banner', 					10);
add_action( 'firewok_header_info', 'firewok_contact_info', 				20);


add_action(	'firewok_header', 'firewok_primary_navigation',				30);
add_action( 'firewok_header', 'firewok_site_branding', 					40);
add_action( 'firewok_header', 'storefront_header_cart', 				50);

/*Single Product Page */

remove_action(	'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 	30 );
add_action(		'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart',	15 );

add_action ( 	'woocommerce_after_single_product_summary', 'firewok_product_images',				 5);

/* Remove additional infomation  from Single Product Page */

/*remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );*/

remove_action( 	'woocommerce_product_additional_information', 'wc_display_product_attributes',		10 );




