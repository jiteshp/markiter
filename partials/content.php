<?php
/**
 * Default content template part.
 *
 * @package markiter
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_the_permalink() ) ), '</a></h2>' );
		get_template_part( 'partials/meta' );
		?>
	</header>

	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div>

	<?php get_template_part( 'partials/meta', 'footer' ); ?>
</article>
