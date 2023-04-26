<?php
/**
 * Default single post content template part.
 *
 * @package markiter
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		the_title( '<h1 class="entry-title">', '</h1>' );
		get_template_part( 'partials/meta' );
		?>
	</header>

	<?php if ( has_excerpt() ) : ?>
		<div class="entry-content entry-summary">
			<?php the_excerpt(); ?>
		</div>
	<?php endif; ?>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumbnail">
			<?php
			the_post_thumbnail(
				'post-thumbnail',
				array(
					'alt' => esc_attr( get_the_title() ),
				)
			);
			?>
		</div>
	<?php endif; ?>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before'      => '<nav class="post-nav-links" aria-label="' . esc_attr__( 'Page', 'markiter' ) . '"><span class="label">' . esc_html__( 'Pages: ', 'markiter' ) . '</span>',
				'after'       => '</nav>',
				'before_link' => '<span class="page-numbers">',
				'after_link'  => '</span>',
			)
		);
		?>
	</div>

	<?php get_template_part( 'partials/meta', 'footer' ); ?>
</article>

<?php
the_post_navigation(
	array(
		'prev_text' => '<span class="rel">' . esc_html__( 'Previous post', 'markiter' ) . '</span> %title',
		'next_text' => '<span class="rel">' . esc_html__( 'Next post', 'markiter' ) . '</span> %title',
	)
);
