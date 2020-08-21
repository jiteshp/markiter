<?php
/**
 * Default meta template part.
 *
 * @package markiter
 */

?>
<div class="entry-meta">
	<span class="entry-author">
		<?php
		echo wp_kses_post(
			sprintf(
				// translators: %s is for the author link.
				__( 'Authored by %s', 'markiter' ),
				get_the_author_link()
			)
		);
		?>
	</span>

	<span class="entry-date">
		<?php
		echo wp_kses(
			sprintf(
				// translators: %s is for the author link.
				__( 'updated %s', 'markiter' ),
				markiter_get_the_date()
			),
			array(
				'a' => array(
					'href' => array(),
					'rel'  => array(),
				),
				'time' => array(
					'datetime' => array(),
					'class'    => array(),
				),
			)
		);
		?>
	</span>
</div>
