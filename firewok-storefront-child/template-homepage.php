<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Homepage
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			
			
			<?php

			if( have_rows('rows') ): 

				// $rows = get_field('rows');

				while ( have_rows('rows') ) : the_row();

					// check if the repeater field has rows of data
					if( have_rows('feature_row') ): ?>

						<div class="feature-row">

							<?php

								$colsSize = 0;
								while ( have_rows('feature_row') ) : the_row(); 
									$colsSize++;
								endwhile; 	

							 	// loop through the rows of data

							    while ( have_rows('feature_row') ) : the_row();

							    	$link = 		get_sub_field('feature_link');
							        $title = 		get_sub_field('feature_title');
							        $description = 	get_sub_field('feature_description');
							        $type = 		get_sub_field('feature_type'); 
							        $mobiletext= 	get_sub_field('mobile_button_text'); 

							        if ($type == 'image'):
							        	$image = get_sub_field('image');
							        else:
							        	$video = get_sub_field('feature_video');
							        endif;

							    	?>

							    	<div class="feature <?php echo 'col-'.$colsSize?>">
							    		<?php if ($type == 'image'): ?>
									  		<a class="hover-image" href="<?php echo $link['url']; ?>">
									  			<?php echo wp_get_attachment_image( $image['id'], 'full'); ?>
									  		</a>
									  	<?php elseif ($type == 'video'): ?>
									  		<div class="embed-container">
									  			<?php echo $video; ?>
									  		</div>
									  	<?php endif; ?>
								       	<a href="<?php echo $link['url']; ?>">
								       		<h2><?php echo $title; ?></h2>
								       	</a>
								       	<p><?php echo $description; ?></p>
								       	<div class="mobile-btn">
								       		<a href="<?php echo $link['url']; ?>"> <?php echo $mobiletext; ?></a>
								       	</div>
								    </div>
							    
							    <?php endwhile; ?>

						</div>
					
					<?php endif; ?>

				 <?php endwhile; ?>

		 	<?php endif; ?>

		 	<?php

		 	$post_objects = get_field('featured_reviews');

			if( $post_objects ): 
				    foreach( $post_objects as $post): // variable must be called $post (IMPORTANT) 
				    	 
				    	 $_permalink  = get_permalink($post->ID);
				    	 $_product	  = wc_get_product( $post->ID );
				    	 $_title 	  = get_the_title($post->ID);
				    	 $_reviews	  = get_comments( array( 'number' => 3, 'post_id' => $post->ID) ); 
				    	 $_thumbnail  = get_the_post_thumbnail($post->ID);
				    	 $_price  	  = $_product->get_price_html();
				    	 $_avg_rating = $_product->get_average_rating();
				    	 ?> 
				        <div class="feature feature-row">	

				        	<div class="col-66">
					            <a href="<?php echo $_permalink; ?>">
					            	<h3><?php echo $_title; ?> Reviews</h3>
					            </a>
					            <?php 

					            foreach ( (array) $_reviews as $review ) {
					            	//echo $review;
	    							$_rating  = intval( get_comment_meta( $review->comment_ID, 'rating', true ) );
	    							$_content = $review->comment_content;
	    							$_author  = $review->comment_author;
	    							?> 

	    							<div class="star-rating">
	    								<span> Rated <strong class="rating"> <?php echo $_rating; ?> </strong> out of 5 </span>
	    							</div>
	    							<p>"<?php echo $_content; ?>"</p> 
	    							<p class="author"> - <?php echo $_author; ?></p>

	    							<?php
	    						} ?>
    						
    						</div>
    						<div class="col-33 featured-review-product">
    							<ul class="products">
    								<li class="product review-product">
    								<a 	href="<?php echo $_permalink; ?>" 
    									class="woocommerce-LoopProduct-link woocommerce-loop-product__link featured-reviews">
	    								<?php echo $_thumbnail; ?>
	    								<h2 class="woocommerce-loop-product__title">
	    									<?php echo $_title; ?>
	    								</h2>
	    								<div class="star-rating">
	    									<?php $_rating_width = $_avg_rating*2*10; ?>
	    									<span style="width: <?php echo $_rating_width;?>%"> Rating
											<strong class="rating">
	   											<?php echo $_avg_rating ?>
											</strong> out of 5
											</span>
										</div>
										<span class="price">
											<?php echo $_price; ?> 
										</span>
										</a>
										<div class="mobile-btn">
											<a href="<?php echo $_permalink; ?>" class="cta" >Take a look</a>
										</div>
    								
    								
    								</li>
    							</ul>
				        	</div>
    						
				        </div>
				    <?php endforeach; ?>
			    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
			<?php endif; ?>
						
		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
