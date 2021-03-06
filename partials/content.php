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

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumbnail">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php
				the_post_thumbnail(
					'post-thumbnail',
					array(
						'alt' => esc_attr( get_the_title() ),
					)
				);
			?></a>
		</div>
	<?php endif; ?>

	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div>

	<?php get_template_part( 'partials/meta', 'footer' ); ?>
</article>
