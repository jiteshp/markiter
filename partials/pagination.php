<?php
/**
 * Default pagination template part.
 *
 * @package markiter
 */

the_posts_pagination(
	array(
		'before_page_number' => '<span class="screen-reader-text">' . esc_html__( 'Page ', 'markiter' ) . '</span>',
		'prev_text'          => '<span aria-hidden="true">&larr;</span><span class="screen-reader-text">' . esc_html__( 'Previous page', 'markiter' ) . '</span>',
		'next_text'          => '<span class="screen-reader-text">' . esc_html__( 'Next page', 'markiter' ) . '</span><span aria-hidden="true">&rarr;</span>',
	)
);
