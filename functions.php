<?php
/**
 * Theme functions
 *
 * Contains the theme functions and hooks.
 *
 * @package markiter
 */

/**
 * Adds support for various theme features.
 *
 * @return void
 */
function markiter_setup() {
	load_theme_textdomain( 'markiter' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );

	add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-color-palette', markiter_get_editor_color_palette() );
	add_theme_support( 'editor-font-sizes', markiter_get_editor_font_sizes() );
	add_theme_support( 'wp-block-styles' );

	add_theme_support(
		'custom-logo',
		array(
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => array( 'site-title', 'site-description' ),
			'height'      => 68,
			'width'       => 150,
		)
	);

	register_nav_menus(
		array(
			'primary'   => esc_html__( 'Primary Menu', 'markiter' ),
			'secondary' => esc_html__( 'Secondary Menu', 'markiter' ),
		)
	);
}

add_action( 'after_setup_theme', 'markiter_setup' );

/**
 * Sets the default content width for the theme.
 *
 * @return void
 */
function markiter_content_width() {
	if ( ! isset( $content_width ) ) {
		$content_width = apply_filters( 'markiter_content_width', 720 );
	}
}

add_action( 'template_redirect', 'markiter_content_width' );

/**
 * Enqueues the theme styles & scripts.
 *
 * @return void
 */
function markiter_enqueue_scripts() {
	$dependancies = array();
	$version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style( 'markiter-style', get_stylesheet_uri(), $dependancies, $version );
	wp_enqueue_style( 'markiter-fonts', markiter_get_fonts_uri(), $dependancies, $version );

	if ( has_nav_menu( 'primary' ) ) {
		wp_enqueue_script( 'markiter-navigation-menu', get_template_directory_uri() . '/js/navigation.js', array(), $version, true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'markiter_enqueue_scripts' );

/**
 * Enqueue block editor styles.
 *
 * @return void
 */
function markiter_block_editor_styles() {
	$version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style( 'markiter-block-editor-fonts', markiter_get_fonts_uri(), array(), $version, 'all' );
	wp_enqueue_style( 'markiter-block-editor-style', get_theme_file_uri( 'style-editor.css' ), array(), $version, 'all' );
}

add_action( 'enqueue_block_editor_assets', 'markiter_block_editor_styles' );

/**
 * Adds preconnect for Google Fonts.
 *
 * @param  array  $urls           URLs to print for resource hints.
 * @param  string $relation_type  The relation type the URLs are printed.
 * @return array
 */
function markiter_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'markiter-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}

add_filter( 'wp_resource_hints', 'markiter_resource_hints', 10, 2 );

/**
 * Modifies the default excerpt length.
 *
 * @param  int $length The default excerpt length.
 * @return int
 */
function markiter_excerpt_length( $length ) {
	if ( ! is_admin() ) {
		$length = 35;
	}

	return $length;
}

add_filter( 'excerpt_length', 'markiter_excerpt_length' );

/**
 * Modifies the default excerpt more markup.
 *
 * @param  string $more The default excerpt more markup.
 * @return string       The modified excerpt more markup.
 */
function markiter_excerpt_more( $more ) {
	if ( ! is_admin() ) {
		$more = sprintf(
			// translators: %1$s is for the permalink, %2$s is for the title.
			__( '&hellip;<p><a href="%1$s" class="more-link">Read more<span class="screen-reader-text"> of %2$s</span><span aria-hidden="true"> &rarr;</span></a></p>', 'markiter' ),
			esc_url( get_permalink() ),
			get_the_title()
		);
	}

	return wp_kses_post( $more );
}

add_filter( 'excerpt_more', 'markiter_excerpt_more' );

/**
 * Outputs the entry published and/or modified date.
 *
 * @return void
 */
function markiter_the_date() {
	echo markiter_get_the_date(); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Returns the entry published and/or modified date.
 *
 * @return string
 */
function markiter_get_the_date() {
	$time_string = '<time class="entry-time published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-time published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf(
		'<a href="%5$s" rel="bookmark">' . $time_string . '</a>',
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_html( get_the_modified_date() ),
		esc_url( get_the_permalink() )
	);

	return $time_string;
}


/**
 * Returns the Google fonts URL for the theme.
 *
 * @return string
 */
function markiter_get_fonts_uri() {
	$font_families = apply_filters(
		'markiter_fonts_uri',
		array(
			'Quattrocento Sans:ital,wght@0,400;0,700;1,400;1,700',
		)
	);

	$query_args = array(
		'family' => urlencode( implode( '|', $font_families ) ),
		'subset' => urlencode( 'latin,latin-ext' ),
	);

	$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css2' );

	return esc_url_raw( $fonts_url );
}

/**
 * Returns the default editor color palette.
 *
 * @return array
 */
function markiter_get_editor_color_palette() {
	return apply_filters(
		'markiter_editor_color_palette',
		array(
			array(
				'name'  => esc_html__( 'Background', 'markiter' ),
				'slug'  => 'bg',
				'color' => '#FFFFFF',
			),
			array(
				'name'  => esc_html__( 'Alternate Background', 'markiter' ),
				'slug'  => 'alt-bg',
				'color' => '#E6E6EF',
			),
			array(
				'name'  => esc_html__( 'Text', 'markiter' ),
				'slug'  => 'text',
				'color' => '#33334F',
			),
			array(
				'name'  => esc_html__( 'Accent', 'markiter' ),
				'slug'  => 'accent',
				'color' => '#884FFA',
			),
		)
	);
}

/**
 * Returns the default font sizes for the editor.
 *
 * @return array
 */
function markiter_get_editor_font_sizes() {
	return apply_filters(
		'markiter_editor_font_sizes',
		array(
			array(
				'name' => esc_html__( 'Small', 'markiter' ),
				'size' => 16,
				'slug' => 'small',
			),
			array(
				'name' => esc_html__( 'Normal', 'markiter' ),
				'size' => 20,
				'slug' => 'normal',
			),
			array(
				'name' => esc_html__( 'Medium', 'markiter' ),
				'size' => 25,
				'slug' => 'medium',
			),
			array(
				'name' => esc_html__( 'Large', 'markiter' ),
				'size' => 32,
				'slug' => 'large',
			),
			array(
				'name' => esc_html__( 'Extra Large', 'markiter' ),
				'size' => 41,
				'slug' => 'extra-large',
			),
		)
	);
}

/**
 * Checks if wp_body_open() exists.
 */
if ( ! function_exists( 'wp_body_open' ) ) {
	/**
	 * Implements a fallback for wp_body_open.
	 *
	 * @return void
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}
