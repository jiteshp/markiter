<?php
/**
 * Default single post/page template.
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
		while ( have_posts() ) {
			the_post();
			get_template_part( 'partials/content', get_post_type() );

			if ( ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
				comments_template();
			}
		}
		?>
	</div>
</main>

<?php
get_footer();
