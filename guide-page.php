<?php
/**
 * Template name: Guide Page
 *
 * Default topic page template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/
 *
 * @package markiter
 */

get_header();
?>

<main id="content" class="site-content" role="main">
	<div class="site-content-wrap">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php markiter_the_guide_title(); ?>

				<div class="entry-content-wrap">
					<div class="entry-content">
						<?php the_content(); ?>
					</div>

					<?php markiter_the_guide_nav_menu(); ?>
				</div>
			</article>
			<?php
		endwhile;
		?>
	</div>
</main>

<?php
get_footer();
