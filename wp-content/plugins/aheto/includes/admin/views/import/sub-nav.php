<?php
/**
 * Sidebar navigation.
 *
 * @package Aheto
 */

use Aheto\Helper;

$current    = Helper::param_get( 'view', 'pages' );

$current = isset($current) && !empty($current) ? $current : '';

$navigation = [
	'pages'   => esc_html__( 'Pages', 'aheto' ),
	'headers' => esc_html__( 'Headers', 'aheto' ),
	'footers' => esc_html__( 'Footers', 'aheto' ),
	'skins'   => esc_html__( 'Skins', 'aheto' ),
];
?>
<div class="aheto-option-page-nav aheto-template-kits-<?php echo esc_attr( $current ); ?>">

    <nav class="aheto-option-nav-wrap">

		<?php foreach ( $navigation as $id => $label ) : ?>
            <a<?php echo $id === $current ? ' class="nav-active"' : ''; ?>
                    href="<?php echo esc_url( Helper::get_admin_url( 'templates', 'view=' . $id ) ); ?>"
                    title="<?php echo $label; ?>"><?php echo $label; ?></a>
		<?php endforeach; ?>

    </nav>

</div>
