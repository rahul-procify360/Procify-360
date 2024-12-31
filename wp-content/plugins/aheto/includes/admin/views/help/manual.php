<?php
/**
 * Help manual template.
 *
 * @package Aheto
 */

use Aheto\Helper;

$iframe_url = '//truethemes.helpscoutdocs.com/collection/2471-aheto';
$iframe_url = apply_filters( "aheto_manual_iframe",  $iframe_url ); ?>

<div class="aheto-option-main-content manual-support-section-wrap">
    <div class="one-col manual-support-section">

        <div class="col">

            <iframe id="aheto-documentation" name="Framename" src="<?php echo esc_url($iframe_url); ?>"
                    width="100%" height="550" frameborder="0" scrolling="auto" class="frame-area">
            </iframe>
        </div>
    </div>
</div>