<?php
/**
 * Default meta template part.
 *
 * @package markiter
 */

?>
<div class="entry-meta">
	<span class="entry-categories">
		<?php
		echo wp_kses_post(
			sprintf(
				// translators: %s is for the category list.
				__( 'In %s', 'markiter' ),
				get_the_category_list( ', ' )
			)
		);
		?>
	</span>

	<span class="entry-author">
		<?php
		echo wp_kses_post(
			sprintf(
				// translators: %s is for the author link.
				__( 'By %s', 'markiter' ),
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
				__( 'On %s', 'markiter' ),
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
