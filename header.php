<?php
/**
 * Default header template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/
 *
 * @package markiter
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<link rel="profile" href="https://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a href="#content" class="screen-reader-text skip-link"><?php esc_html_e( 'Skip to content', 'markiter' ); ?></a>

<header id="header" class="site-header" role="banner">
	<div class="site-header-wrap">
		<div class="brand">
			<?php
			the_custom_logo();

			if ( is_home() && is_front_page() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;

			$markiter_description = get_bloginfo( 'description', 'display' );
			if ( $markiter_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo esc_html( $markiter_description ); ?></p>
				<?php
			endif;
			?>
		</div><!-- .brand -->

		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<button class="menu-toggle" aria-expanded="false" aria-controls="site-navigation">&#9776;<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'markiter' ); ?></span></button>

			<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'markiter' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'container'      => false,
						'theme_location' => 'primary',
					)
				);
				?>
			</nav>
		<?php endif; ?>
	</div>
</header>

<?php
if ( is_home() && is_active_sidebar( 'home' ) ) :
	?>
	<section class="home-widgets">
		<?php dynamic_sidebar( 'home' )?>
	</section>
	<?php
endif;
