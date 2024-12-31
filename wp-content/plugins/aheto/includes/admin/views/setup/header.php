<?php
/**
 * Wizard: Headers template.
 *
 * @package Aheto
 */

?>

<form action="" method="post" class="aheto-wizard-form-wrap">

    <div class="headings-wrap">
        <h3 class="step-heading">
		    <?php esc_html_e( 'Choose the header', 'aheto' ); ?>
        </h3>
        <div class="active-buttons">
		    <?php $this->prev_step_buttons(); ?>
		    <?php $this->next_step_buttons(); ?>
        </div>
    </div>
    <hr>
    <div class="description-wrap">
        <p>
            <i><?php echo aheto()->plugin_name() .  __( ' brings an important and exciting change: a new way of doing headings. The updated headings style should make 
        headings easier to understand, implement, and see in your finished paper. ', 'aheto' ); ?></i>
        </p>
    </div>
	<div class="twelve-col">

		<?php foreach ( $this->get_header_set() as $slug => $header ) : ?>
		<div class="col">

			<div class="header-box">

				<input type="radio" id="header-<?php echo $slug; ?>" name="header-select" value="<?php echo $slug; ?>"<?php checked( $slug, 'header_1' ); ?>>
				<label for="header-<?php echo $slug; ?>">
					<div class="checked">
						<svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M13 26C20.1797 26 26 20.1797 26 13C26 5.8203 20.1797 0 13 0C5.8203 0 0 5.8203 0 13C0 20.1797 5.8203 26 13 26Z" fill="#2ab9a5"/>
						<path fill-rule="evenodd" clip-rule="evenodd" d="M17.0548 9.69224L16.8167 9.45434C16.5552 9.1923 16.1268 9.1923 15.8645 9.45434L11.8206 13.4988L10.3856 12.0644C10.1242 11.8026 9.69549 11.8026 9.43402 12.0647L9.19611 12.3023C8.93463 12.5641 8.93463 12.9925 9.19611 13.2542L11.3434 15.4037C11.6051 15.6652 12.0335 15.6652 12.2953 15.4037L17.0548 10.6442C17.316 10.3824 17.316 9.954 17.0548 9.69224Z" fill="white"/>
						</svg>
					</div>

					<img src="<?php echo $header['image']; ?>" class="img-responsive">
				</label>

			</div>

		</div>
		<?php endforeach; ?>

	</div>

    <div class="bottom-buttons">
		<?php $this->prev_step_buttons(); ?>
		<?php $this->next_step_buttons(); ?>
    </div>

</form>
