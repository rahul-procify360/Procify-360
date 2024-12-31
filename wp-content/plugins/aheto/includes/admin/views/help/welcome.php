<?php
	/**
	 * Help welcome template.
	 * @package Aheto
	 */

	use Aheto\Helper;

	$registered = false;
	$class = false !== $registered ? 'status-green' : 'status-red';
	$aheto_dashboard_pages = aheto () -> plugin_dashboard_pages ();
	$img = aheto () -> assets () . 'admin/img/';
?>

<div class="aheto-option-main-content">

    <div class="aheto-dashboard-page">

        <!--div class="aheto-dashboard-page__popup">
            <div class="popup__info">
                <span><i class="fas fa-exclamation" aria-hidden="true"></i></span>
                <p>Welcome to Aheto/p>
            </div>
            <a class="btn-light custom-btn" href="#">Take Action</a>
        </div -->

        <div class="aheto-dashboard-page__information">
            <h3>Welcome to Aheto</h3>
            <h6>Aheto is the most Powerful WordPress Design System. You can do anything, from Edit Color Scheme, to change typography, buttons and way more.</h6>

            <img src="<?php echo esc_url ( aheto () -> plugin_dashboard_img () ); ?>"
                 alt="<?php aheto () -> plugin_name (); ?>">
            <p><span>Pro Tip:</span> You can always edit your brand elements (logo, color, etc)</p>
        </div>

        <ul class="aheto-dashboard-page__download-steps">
                <li>
                    <div class="download-steps__info">
                        <span class="check checked"><i class="fas fa-check" aria-hidden="true"></i></span>
                        <h6>Create your own Skin/Style Guide </h6>
                        <p>Set Typography, Colors, Buttons Forms or import ready demos.</p>
                    </div>
                    <a class="btn-light custom-btn" href="<?php echo admin_url( 'admin.php?page=aheto-skin-generator' ); ?>">DO IT NOW</a>
                </li>
                <li>
                    <div class="download-steps__info">
                        <span class="check checked"><i class="fas fa-check" aria-hidden="true"></i></span>
                        <h6>Import Ready Pages</h6>
                        <p>We have built more than 100 homepages and more than 500 inner pages </p>
                    </div>
                    <a class="btn-light custom-btn" href="<?php echo admin_url( 'admin.php?page=aheto-templates' ); ?>">IMPORT NOW</a>
                </li>
                <li>
                    <div class="download-steps__info">
                        <span class="check checked"><i class="fas fa-check" aria-hidden="true"></i></span>
                        <h6>Setup Your own header and footer </h6>
                        <p>Aheto is built with more than 30 headers and footers</p>
                    </div>
                    <a class="btn-light custom-btn" href="<?php echo admin_url( 'admin.php?page=aheto-templates&view=headers' ); ?>">CHECK NOW</a>
                </li>
                <li>
                    <div class="download-steps__info">
                        <span class="check checked"><i class="fas fa-check" aria-hidden="true"></i></span>
                        <h6>Enjoy Working with Aheto</h6>
                        <p></p>
                    </div>
                    <a class="btn-light custom-btn" href="#">RELAX</a>
                </li>
              
            </ul>
    </div>
</div>
