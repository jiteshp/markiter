<?php
/**
 * Default footer meta template part.
 *
 * @package markiter
 */

$markiter_tags = get_the_tag_list( '', ', ', '' );
?>
<footer class="entry-footer entry-meta">
	<span class="entry-date">
		<?php
		echo wp_kses(
			sprintf(
				// translators: %s is for the author link.
				__( 'Updated on %s', 'markiter' ),
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

	<?php
	if ( $markiter_tags ) {
		echo '<span class="entry-tags">' . wp_kses_post(
			sprintf(
				// translators: %s is for the tag list.
				__( 'Tagged %s', 'markiter' ),
				$markiter_tags
			)
		) . '</span>';
	}
	?>
</footer>
