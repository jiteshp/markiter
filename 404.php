<?php
/**
 * 404 template
 *
 * The default template used by the theme to display the page not found error.
 *
 * @package markiter
 */

get_header();
?>

<main id="content" class="site-content" role="main">
	<div class="site-content-wrap">
		<section class="page-not-found">
			<header class="entry-header">
				<h1 class="entry-title"><?php esc_html_e( 'Page not found', 'markiter' ); ?></h1>
			</header>

			<div class="entry-content">
				<p><?php esc_html_e( 'The page you&rsquo;re looking for couldn&rsquo;t be found. It may have been moved or removed. Perhaps try a search?', 'markiter' ); ?></p>

				<?php get_search_form(); ?>
			</div>
		</section>
	</div><!-- .site-content-inner -->
</main>

<?php
get_footer();
