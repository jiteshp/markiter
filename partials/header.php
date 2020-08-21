<?php
/**
 * Default page header template part.
 *
 * @package markiter
 */

$markiter_page_title = false;

if ( is_archive() ) {
	$markiter_page_title = get_the_archive_title();
} elseif ( is_search() ) {
	// translators: %s is for the search query.
	$markiter_page_title = sprintf( __( 'Search results for: %s', 'markiter' ), get_search_query() );
}

if ( $markiter_page_title ) :
	?>
	<header class="page-header">
		<h1 class="page-title"><?php echo esc_html( $markiter_page_title ); ?></h1>
	</header>
	<?php
endif;
