<?php
/**
 * Elementor templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Elementor
 * @author     UPQODE <info@upqode.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<script type="text/template" id="tmpl-aheto-template-library-templates">
    <#
    var activeType = elementor.templates.getFilter('type');
    #>
    <div id="elementor-template-library-toolbar">
        <div id="elementor-template-library-filter-toolbar-remote" class="elementor-template-library-filter-toolbar">
            <# if ( 'page' === activeType ) { #>
            <div id="elementor-template-library-order">
                <input type="radio" id="elementor-template-library-order-new" class="elementor-template-library-order-input" name="elementor-template-library-order" value="date">
                <label for="elementor-template-library-order-new" class="elementor-template-library-order-label"><?php echo __( 'New', 'aheto' ); ?></label>
                <input type="radio" id="elementor-template-library-order-trend" class="elementor-template-library-order-input" name="elementor-template-library-order" value="trendIndex">
                <label for="elementor-template-library-order-trend" class="elementor-template-library-order-label"><?php echo __( 'Trend', 'aheto' ); ?></label>
                <input type="radio" id="elementor-template-library-order-popular" class="elementor-template-library-order-input" name="elementor-template-library-order" value="popularityIndex">
                <label for="elementor-template-library-order-popular" class="elementor-template-library-order-label"><?php echo __( 'Popular', 'aheto' ); ?></label>
            </div>
            <# } else {
            var config = elementor.templates.getConfig( activeType );

            var ahetoCategories = ['404 page', 'about', 'awards', 'banner', 'blog', 'call-to-action', 'careers', 'clients', 'contact', 'content', 'ecommerce', 'faq', 'features', 'portfolio', 'price', 'progress-bar', 'team', 'testimonials', 'coming-soon', 'maps', 'instagram'];

            if ( ahetoCategories ) { #>
            <div id="elementor-template-library-filter">
                <select id="elementor-template-library-filter-subtype" class="elementor-template-library-filter-select" data-elementor-filter="subtype">
                    <option></option>
                    <# ahetoCategories.forEach( function( category ) {
                    var selected = category === elementor.templates.getFilter( 'subtype' ) ? ' selected' : '';
                    #>
                    <option value="{{ category }}"{{{ selected }}}>{{{ category }}}</option>
                    <# } ); #>
                </select>
            </div>
            <# }
            } #>
            <div id="elementor-template-library-my-favorites">
                <# var checked = elementor.templates.getFilter( 'favorite' ) ? ' checked' : ''; #>
                <input id="elementor-template-library-filter-my-favorites" type="checkbox"{{{ checked }}}>
                <label id="elementor-template-library-filter-my-favorites-label" for="elementor-template-library-filter-my-favorites">
                    <i class="eicon" aria-hidden="true"></i>
					<?php echo __( 'My Favorites', 'aheto' ); ?>
                </label>
            </div>
        </div>

        <div id="elementor-template-library-filter-text-wrapper">
            <label for="elementor-template-library-filter-text" class="elementor-screen-only"><?php echo __( 'Search Templates:', 'aheto' ); ?></label>
            <input id="elementor-template-library-filter-text" placeholder="<?php echo esc_attr__( 'Search', 'aheto' ); ?>">
            <i class="eicon-search"></i>
        </div>
    </div>

    <div id="elementor-template-library-templates-container"></div>

</script>
