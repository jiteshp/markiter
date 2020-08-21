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
