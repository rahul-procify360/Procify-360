<?php
/**
 * Wizard: Plugin template.
 *
 * @package Aheto
 */

$this->set_finish();
?>

<div class="container step-thank-you-wrap">
	<h3 class="step-heading"><?php esc_html_e('Thank you!', 'aheto'); ?></h3>
	<p><?php esc_html_e('You did a great job! Now you can import pages from our demo. We have prepared the best ideas for you!', 'aheto'); ?></p>
    <a href="<?php echo admin_url( 'admin.php?page=aheto-templates' ); ?>" class="custom-btn"><?php esc_html_e('Go to Ready Demos', 'aheto'); ?></a>
</div>

