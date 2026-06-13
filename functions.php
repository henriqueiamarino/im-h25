<?php
/**
 * H25 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package H25
 * @since H25 1.0
 */

if ( ! function_exists( 'h25_support' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since H25 1.0
	 *
	 * @return void
	 */
	function h25_support() {

		// Enqueue editor styles.
		add_editor_style( 'style.css' );

		// Make theme available for translation.
		load_theme_textdomain( 'h25' );
	}

endif;

add_action( 'after_setup_theme', 'h25_support' );

if ( ! function_exists( 'h25_styles' ) ) :

	/**
	 * Enqueue styles.
	 *
	 * @since H25 1.0
	 *
	 * @return void
	 */
	function h25_styles() {

		// Register theme stylesheet.
		wp_register_style(
			'h25-style',
			get_stylesheet_directory_uri() . '/style.css',
			array(),
			wp_get_theme()->get( 'Version' )
		);

		// Enqueue theme stylesheet.
		wp_enqueue_style( 'h25-style' );

	}

endif;

add_action( 'wp_enqueue_scripts', 'h25_styles' );

/**
 * Randomize the Contrast accent on every visit.
 *
 * The palette is defined once in theme.json; only the contrast preset
 * rotates, by setting its custom property client-side at wp_body_open so
 * full-page caching can't pin one accent. Without JavaScript the default
 * (orange) applies.
 *
 * @since H25 1.0.5
 *
 * @return void
 */
function h25_random_accent_script() {
	?>
	<script>
	( function () {
		var accents = [ '#ff4a1a', '#FFDD33', '#FF4AB5', '#4DB6FF', '#d2b579', '#9580ff' ];
		var last = null;
		try { last = localStorage.getItem( 'h25-accent' ); } catch ( e ) {}
		var pool = accents.filter( function ( c ) { return c !== last; } );
		var pick = pool[ Math.floor( Math.random() * pool.length ) ];
		try { localStorage.setItem( 'h25-accent', pick ); } catch ( e ) {}
		document.body.style.setProperty( '--wp--preset--color--contrast', pick );
	} )();
	</script>
	<?php
}
add_action( 'wp_body_open', 'h25_random_accent_script' );

/**
 * Relabel the Categories dropdown placeholder, server-side and translatable.
 *
 * @since H25 1.0.2
 *
 * @param string $block_content Rendered block HTML.
 * @return string
 */
function h25_categories_dropdown_label( $block_content ) {
	return str_replace(
		'>' . esc_html__( 'Select Category' ) . '<',
		'>' . esc_html__( 'Read by Category', 'h25' ) . '<',
		$block_content
	);
}
add_filter( 'render_block_core/categories', 'h25_categories_dropdown_label' );
