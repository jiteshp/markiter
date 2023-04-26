<?php
/**
 * Default footer meta template part.
 *
 * @package markiter
 */

$markiter_tags = get_the_tag_list( '', ', ', '' );
if ( $markiter_tags ) :
	?>
	<footer class="entry-footer entry-meta">
		<div class="entry-footer-wrap">
			<?php
				echo '<span class="entry-tags">' . wp_kses_post(
					sprintf(
						// translators: %s is for the tag list.
						__( 'Tagged %s', 'markiter' ),
						$markiter_tags
					)
				) . '</span>';
			?>
		</div>
	</footer>
	<?php
endif;
