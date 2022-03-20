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

	add_theme_support(
		'custom-logo',
		array(
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => array( 'brand-text' ),
			'height'      => 68,
			'width'       => 150,
		)
	);

	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 630, true );

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
 * Registers the sidebars used in the theme.
 *
 * @return void
 */
function markiter_sidebars() {
	// Footer widgets
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer', 'markiter' ),
			'id'            => 'footer',
			'description'   => esc_html__( 'Displayed everywhere other than squeeze pages.', 'markiter' ),
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
			'before_widget' => '<div class="widget %2$s" id="%1$s">',
			'after_widget'  => '</div>',
		)
	);

	// Home widgets
	register_sidebar(
		array(
			'name'          => esc_html__( 'Blog Hero', 'markiter' ),
			'id'            => 'blog-hero',
			'description'   => esc_html__( 'Displayed on the blog page.', 'markiter' ),
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
			'before_widget' => '<div class="widget %2$s" id="%1$s">',
			'after_widget'  => '</div>',
		)
	);
}

add_action( 'widgets_init', 'markiter_sidebars' );

/**
 * Enqueues the theme styles & scripts.
 *
 * @return void
 */
function markiter_enqueue_scripts() {
	$dependancies = array();
	$version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style( 'markiter-style', get_stylesheet_uri(), $dependancies, $version );
	wp_enqueue_style( 'markiter-fonts', markiter_get_fonts_uri(), $dependancies, null );

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

	wp_enqueue_style( 'markiter-block-editor-fonts', markiter_get_fonts_uri(), array(), null, 'all' );
	wp_enqueue_style( 'markiter-block-editor-style', get_theme_file_uri( 'style-editor.css' ), array(), $version, 'all' );
}

add_action( 'enqueue_block_editor_assets', 'markiter_block_editor_styles' );

/**
 * Adds options to customize theme colors.
 *
 * @param  WP_Customize_Manager $wp_customize The customizer manager object.
 * @return void
 */
function markiter_custom_colors( $wp_customize ) {
	$colors = markiter_get_default_color_palette();

	foreach ( $colors as $color ) {
		$wp_customize->add_setting(
			$color['slug'] . '-color',
			array(
				'default'           => $color['color'],
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$color['slug'] . '-color',
				array(
					'label'   => $color[ 'name' ] . esc_html__( ' Color', 'markiter' ),
					'section' => 'colors',
				)
			)
		);
	}
}

add_action( 'customize_register', 'markiter_custom_colors' );

/**
 * Adds the custom styles for the theme.
 *
 * @return void
 */
function markiter_custom_styles() {
	$custom_style = '';
	$colors = markiter_get_default_color_palette();

	foreach ( $colors as $color ) {
		$slug  = $color['slug'];
		$value = get_theme_mod( $slug . '-color', $color['color'] );

		$custom_style .= "
			--markiter-$slug-color: $value;";
	}

	if ( ! empty( $custom_style ) ) {
		$custom_style = "
			:root {
				$custom_style
			}
		";
	}

	wp_add_inline_style( 'markiter-style', $custom_style );
	wp_add_inline_style( 'markiter-block-editor-style', $custom_style );
}

add_action( 'wp_enqueue_scripts', 'markiter_custom_styles' );
add_action( 'admin_enqueue_scripts', 'markiter_custom_styles' );

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
 * Returns the editor color palette.
 *
 * @param  array $colors The default editor color palette
 * @return array
 */
function markiter_get_editor_color_palette() {
	$colors = markiter_get_default_color_palette();

	for ( $i = 0; $i < count( $colors ); $i++ ) {
		$colors[ $i ]['color'] = get_theme_mod( $colors[ $i ]['slug'] . '-color', $colors[ $i ]['color'] );
	}

	return $colors;
}

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
	return esc_url_raw(
		apply_filters(
			'markiter_font_source_url',
			'https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Francois+One&display=swap'
		)
	);
}

/**
 * Returns the default editor color palette.
 *
 * @return array
 */
function markiter_get_default_color_palette() {
	return apply_filters(
		'markiter_default_color_palette',
		array(
			array(
				'name'  => esc_html__( 'Background', 'markiter' ),
				'slug'  => 'bg',
				'color' => '#FFFFFF',
			),
			array(
				'name'  => esc_html__( 'Alternate Background', 'markiter' ),
				'slug'  => 'alt-bg',
				'color' => '#E4E1FF',
			),
			array(
				'name'  => esc_html__( 'Text', 'markiter' ),
				'slug'  => 'fg',
				'color' => '#190248',
			),
			array(
				'name'  => esc_html__( 'Accent', 'markiter' ),
				'slug'  => 'accent',
				'color' => '#722EF9',
			),
			array(
				'name'  => esc_html__( 'Border', 'markiter' ),
				'slug'  => 'border',
				'color' => '#DDDDDD',
			),
			array(
				'name'  => esc_html__( 'Input', 'markiter' ),
				'slug'  => 'input',
				'color' => '#999999',
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
