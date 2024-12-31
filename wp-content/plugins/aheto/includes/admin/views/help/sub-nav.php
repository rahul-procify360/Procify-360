<?php
/**
 * Sidebar navigation.
 *
 * @package Aheto
 */

use Aheto\Helper;

$current    = Helper::param_get( 'view', 'welcome' );
$navigation = [
	'welcome'   => esc_html__( 'Dashboard', 'aheto' ),
	'system'    => esc_html__( 'System Information', 'aheto' ),
	'manual'    => esc_html__( 'Manual &amp; Support', 'aheto' ),
	'changelog' => esc_html__( 'Changelog', 'aheto' ),
];
?>
<div class="aheto-option-page-nav">

	<nav class="aheto-option-nav-wrap">

		<?php foreach ( $navigation as $id => $label ) : ?>
		<a<?php echo $id === $current ? ' class="nav-active"' : ''; ?> href="<?php echo esc_url( Helper::get_admin_url( 'setting-up', 'view=' . $id ) ); ?>" title="<?php echo $label; ?>"><?php echo $label; ?></a>
		<?php endforeach; ?>

	</nav>

</div>
