<?php
/**
 * Wizard: Plugin template.
 *
 * @package Aheto
 */

$plugins           = [
	'elementor'       => [
		'name'    => 'Elementor',
		'premium' => false,
		'file'    => 'elementor/elementor.php',
	],
	'visual-composer' => [
		'name'    => 'WPBakery',
		'premium' => true,
		'file'    => 'js_composer/js_composer.php',
	],
];
$installed_plugins = get_plugins();
?>

<form action="" method="post" class="aheto-wizard-form-wrap">
    <div class="headings-wrap">
        <h3 class="step-heading">
		    <?php esc_html_e( 'Select plugin for install', 'aheto' ); ?>
        </h3>
        <div class="active-buttons">
		    <?php $this->plugins_next_step_buttons(); ?>
        </div>
    </div>
    <hr>
    <div class="description-wrap">
        <p>
            <i>
	            <?php esc_html_e( 'Choosing the “right” font for your design determines how well your designs are perceived. Please, make sure that moods of your font choices match the purpose of your design.', 'aheto' ); ?>
            </i>
        </p>
    </div>

    <div>

        <div class="two-col step-plugins-box-wrap">

		    <?php
		    foreach ( $plugins as $slug => $plugin ) :
			    $status = 'active';

			    if ( ! isset( $installed_plugins[ $plugin['file'] ] ) ) { // Install.
				    $status = 'not-installed';
			    } elseif ( is_plugin_inactive( $plugin['file'] ) ) { // Activate.
				    $status = 'installed';
			    }

			    $disabled = '';
			    if ( $slug ==  'visual-composer' ) $disabled = 'disabled';
			    ?>

                <div class="col col-m">
                    <div class="plugin-box plugin-card-<?php echo $slug; ?> <?php echo $status; ?>">
                        <input type="radio" id="plugin-<?php echo $slug; ?>" name="plugin-select" value="<?php echo $slug; ?>" <?php echo  $disabled;?> >
                        <label for="plugin-<?php echo $slug; ?>">
                            <div class="checked">
                                <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13 26C20.1797 26 26 20.1797 26 13C26 5.8203 20.1797 0 13 0C5.8203 0 0 5.8203 0 13C0 20.1797 5.8203 26 13 26Z" fill="#2ab9a5"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M17.0548 9.69224L16.8167 9.45434C16.5552 9.1923 16.1268 9.1923 15.8645 9.45434L11.8206 13.4988L10.3856 12.0644C10.1242 11.8026 9.69549 11.8026 9.43402 12.0647L9.19611 12.3023C8.93463 12.5641 8.93463 12.9925 9.19611 13.2542L11.3434 15.4037C11.6051 15.6652 12.0335 15.6652 12.2953 15.4037L17.0548 10.6442C17.316 10.3824 17.316 9.954 17.0548 9.69224Z" fill="white"/>
                                </svg>
                            </div>
                            <div class="img">
                                <img src="<?php echo aheto()->assets() . 'admin/img/builder/' . $slug . '.png'; ?>" class="img-responsive">
                            </div>

						    <?php  if ( $slug  != 'visual-composer' ) {
								$this->tgmpa_plugin_action( $slug, $plugin, $status );
							} else { ?>
								<span class="aheto-plugin-button"><?php esc_html_e( 'Coming soon.', 'aheto' ); ?></span>
							<?php } ?>
                        </label>
                    </div>

                </div>
		    <?php endforeach; ?>

        </div>

        <div class="active-buttons bottom-buttons">
		    <?php $this->plugins_next_step_buttons(); ?>
        </div>
    </div>

</form>
