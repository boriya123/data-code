<?php
/**
 *
 * 
 * 
 * Template Name: Fullwidth Template 
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package gute
 */

get_header();

?>
<?php if(!is_front_page()): ?>
<div class="page-head">
	 <?php
	  if (has_post_thumbnail()) {
	 	the_post_thumbnail('large');
	 	}else{ 
	 	the_header_image_tag();	
	 }
	 ?>
	 <div class="overlay-text"></div>
	<header class="img-header">
		<?php the_title( '<h1 class="img-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

</div>
<?php endif; ?>
<div class="container space-padding">
	<div class="row">
		<div class="col-md-lg-12">
			<div id="primary" class="content-area">
				<main id="main" class="site-main">

				<?php
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
			
				?>

				</main><!-- #main -->
			</div><!-- #primary -->
		</div>
	</div>
</div>
<?php
get_footer();