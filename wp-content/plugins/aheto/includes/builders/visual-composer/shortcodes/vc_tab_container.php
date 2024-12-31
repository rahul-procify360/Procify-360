<?php
/**
 * Tab template.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

$atts['i_position'] = 'left';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$this->resetVariables( $atts, $content );
extract( $atts );

$this->setGlobalTtaInfo();

// It is required to be before tabs-list-top/left/bottom/right for tabs/tours.
$prepared_content = $this->getTemplateVariable( 'content' );
$prepared_content = str_replace( 'vc_tta-panel-heading', 'vc_hidden', $prepared_content );
$prepared_content = str_replace( 'vc_tta-panel-body', 'aheto-tab__box-inner', $prepared_content );
$prepared_content = str_replace( 'vc_tta-panel', 'aheto-tab__box js-tab-box', $prepared_content );
$first_box_index  = strpos( $prepared_content, 'aheto-tab__box js-tab-box' );
if ( false !== $first_box_index ) {
	$prepared_content = substr_replace( $prepared_content, 'aheto-tab__box js-tab-box active', $first_box_index, strlen( 'aheto-tab__box js-tab-box' ) );
}
?>
<div class="aheto-tab js-tab aheto-tab--simple">

	<div class="aheto-tab__head">
		<ul class="aheto-tab__list">
			<?php
			if ( ! vc_is_page_editable() ) :
				$html = [];
				foreach ( WPBakeryShortCode_VC_Tta_Section::$section_info as $nth => $section ) {
					$classes = [ 'aheto-tab__list-item' ];
					if ( 0 === $nth ) {
						$classes[] = 'active';
					}

					$icon      = Helper::get_icon_attributes( $section, '', true );
					$icon_html = '';
					if ( ! empty( $icon ) ) {
						$style = '';
						if ( ! empty( $icon['color'] ) ) {
							$style .= ' style="color:' . $icon['color'] . ';"';
						}
						$icon_html = sprintf( '<i class="aheto-tab__list-ico %1$s %2$s"%3$s></i>', $icon['icon'], $icon['align'], $style );
					}

					$title  = $icon_html . $section['title'];
					$a_html = '<a class="aheto-tab__list-link js-tab-list" href="#' . $section['tab_id'] . '">' . $title . '</a>';
					$html[] = '<li class="' . implode( ' ', $classes ) . '" data-vc-tab>' . $a_html . '</li>';
				}

				echo implode( '', $html );
			endif;
			?>
		</ul>
	</div>

	<div class="aheto-tab__content ">
		<?php echo $prepared_content; ?>
	</div>
</div>
