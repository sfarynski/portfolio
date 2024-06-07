<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

<?php if ( astra_page_layout() == 'left-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

	<div id="primary" <?php astra_primary_class(); ?>>
		<?php echo "IN THE SINGLE.PHP"; ?>
		<img src="<?php echo get_stylesheet_directory_uri().'/assets/images/icons8-wordpress-240.png'?>" alt="icon wordpress">
		<main id="main" class="site-main">
				<?php
				if ( have_posts() ) :
					do_action( 'astra_template_parts_content_top' );

					while ( have_posts() ) :
						the_post();
						the_title();
						//get_template_part( 'template-parts/categories_list' );
						//echo get_the_category_list();
						$fruitsArray=get_the_category(the_ID());
						foreach ($fruitsArray as $fruit) {
							if($fruit->name === "wordpress"){
								echo '<img src="'. get_stylesheet_directory_uri() .'/assets/images/icons8-wordpress-240.png" alt="Pas de photo" width="77px" >';
							}
							if($fruit->name === "php"){
								echo '<img src="'. get_stylesheet_directory_uri() .'/assets/images/icons8-php-160.png" alt="Pas de photo" width="77px" >';
							}
						}
						//get_template_part( 'template-parts/post_categories' );

						do_action( 'astra_page_template_parts_content' );

					endwhile;
					do_action( 'astra_template_parts_content_bottom' );
					else :
						do_action( 'astra_template_parts_content_none' );
					endif;
					?>
			</main>

	</div><!-- #primary -->

<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>
