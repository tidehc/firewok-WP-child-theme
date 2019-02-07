<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package storefront
 */

?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php

		// check if the flexible content field has rows of data
	if( have_rows('section') ):
	     // loop through the rows of data
	    while ( have_rows('section') ) : the_row();
	    	?> <section> <?php
	        if( get_row_layout() == 'text_section' ):
	        	?>
	        	<h2> <?php echo the_sub_field('title'); ?> </h2> 
        		<?php
	        	echo the_sub_field('text');

	        elseif( get_row_layout() == 'image_section' ): 

	        	$img = get_sub_field('image');
	        	echo wp_get_attachment_image( $img['id'], 'full'); 

	        endif;
	        ?> </section> <?php
	    endwhile;

	else :

	    /**
		 * Functions hooked in to storefront_page add_action
		 *
		 * @hooked storefront_page_header          - 10
		 * @hooked storefront_page_content         - 20
		 */
		do_action( 'storefront_page' );

	endif;


	
	?>
</div><!-- #post-## -->
