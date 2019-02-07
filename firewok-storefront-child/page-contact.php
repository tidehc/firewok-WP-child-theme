<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post();

				// do_action( 'storefront_page_before' );

				// get_template_part( 'content', 'page' );

				/*
				* ACF - Georges additions
				*/
				?> <div class="feature-row contact-page"> <?php
				// vars
				$contact = get_field('contact_details');
				$mailing_list = get_field('mailing_list');	

				if( $contact ): ?>
 					<div class="feature col-2"> 
						<?php echo $contact['contact_info']; ?>
						<ul>
							<li>Email: <span class="red";> <a href="mailto:<?php echo $contact['email']; ?>"> <?php echo $contact['email']; ?> </a></span></li>
							<li>Phone: <span class="red";><a href="tel:<?php echo $contact['phone'];?>"> <?php echo $contact['phone'];?> </a></span></li>
							<li>Address: <span class="red";> <?php echo $contact['address']; ?></span></li>
						</ul>
					</div>
				<?php endif; 

				if( $mailing_list ): ?>
					<div class="feature col-2"> 
						<?php echo $mailing_list['subscribe_info']; ?>
						<div class="firewok-btn">
							<a href="<?php echo $mailing_list['subscriber_btn'];?>">
								 Subscribe 
							</a>
						</div>
					</div>
				<?php endif; 

				?> </div> <?php

				/**
				 * Functions hooked in to storefront_page_after action
				 *
				 * @hooked storefront_display_comments - 10
				 */
				do_action( 'storefront_page_after' );

			endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
get_footer();
