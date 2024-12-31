<?php
/**
 * Wizard: Introduction template.
 *
 * @package Aheto
 */
?>

<div class="aheto-wizard-introduction">

	<h1><?php echo esc_html__( 'Welcome to ', 'aheto' ) . aheto()->plugin_name() . '!'; ?></h1>

	<p><?php esc_html_e( 'Creating a site has never been so easy and if you see this message, you are on the right path to your dream!.', 'aheto' ); ?></p>

    <p><?php echo esc_html__( 'Here is only the short list of all stunning posibilities that you will get once start creating with ', 'aheto' ) . aheto()->plugin_name() . '.'; ?></p>

    <ul>
        <li><?php esc_html_e( '- Direct import into your dashboard;', 'aheto' ); ?></li>
        <li><?php esc_html_e( '- Use within Elementor, Elementor Pro and WPBakery;', 'aheto' ); ?></li>
        <li><?php esc_html_e( '- Blocks for headers, footers, pop-ups and more;', 'aheto' ); ?></li>
        <li><?php esc_html_e( '- Access to multiply of quality layouts and templates and much more..', 'aheto' ); ?></li>
    </ul>

	<p><?php esc_html_e( 'So, fasten your seatbelts, make some coffee and click "Let\'s Go!"', 'aheto' ); ?></p>

	<p class="aheto-setup-actions step wp-core-ui">
		<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="custom-btn"><?php esc_html_e( 'Let\'s Go!', 'aheto' ); ?></a>
	</p>

</div>
