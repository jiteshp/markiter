<?php
/**
 * Default footer meta template part.
 *
 * @package markiter
 */

$markiter_tags = get_the_tag_list( '', ', ', '' );
?>
<footer class="entry-footer entry-meta">
	<span class="entry-categories">
		<?php
		echo wp_kses_post(
			sprintf(
				// translators: %s is for the category list.
				__( 'Posted in %s', 'markiter' ),
				get_the_category_list( ', ' )
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
