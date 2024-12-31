<?php


$title          = Aheto\Helper::get_settings( 'theme-options.snapster_pricing_title' );
$text           = Aheto\Helper::get_settings( 'theme-options.snapster_pricing_subtitle' );
$packages_title = Aheto\Helper::get_settings( 'theme-options.snapster_packages_title' );

$name        = isset( $params['snapster_name'] ) && ! empty( $params['snapster_name'] ) ? $params['snapster_name'] : '';
$email       = isset( $params['snapster_email'] ) && ! empty( $params['snapster_email'] ) ? $params['snapster_email'] : '';
$date        = isset( $params['snapster_date'] ) && ! empty( $params['snapster_date'] ) ? $params['snapster_date'] : '';
$location    = isset( $params['snapster_location'] ) && ! empty( $params['snapster_location'] ) ? $params['snapster_location'] : '';
$message     = isset( $params['snapster_message'] ) && ! empty( $params['snapster_message'] ) ? $params['snapster_message'] : '';
$total_price = isset( $price ) && ! empty( $price ) ? $price : '';
$packages    = isset( $packages ) && ! empty( $packages ) ? $packages : '';
$copyright   = esc_html__( ' &copy;', 'snapster' ) . date( 'Y' ) . ' ' . get_bloginfo( 'name' );


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php esc_html_e( 'Price List', 'snapster' ); ?></title>
    <link href="https://fonts.googleapis.com/css?family=Muli:200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400" rel="stylesheet">
</head>
<body>
<style>
    .aheto-pricing-tables__pricelist-pdf-wrap {
        border: 1px solid #111;
        border-bottom: none;
        padding: 60px;
        color: rgba(17, 17, 17, 0.7);
        font-family: 'Muli', sans-serif;
    }

    .aheto-pricing-tables__logo {
        font-family: 'Playfair Display', sans-serif;
        font-size: 50px;
        font-weight: 400;
        text-align: center;
        color: #111;
        display: inline-block;
        margin-bottom: 30px;
    }

    .aheto-pricing-tables__logo-wrap {
        display: block;
        width: 100%;
        clear: both;
        float: none;
        text-align: center;
    }

    hr {
        width: 70px;
        height: 1px;
        color: rgba(17, 17, 17, 0.2);
        border: none;
        background-color: rgba(17, 17, 17, 0.2);
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 30px;
        clear: both;
        display: block;
    }

    .aheto-pricing-tables__copyright {
        padding: 30px 15px;
        text-align: center;
        background-color: #111;
        color: #fff;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 3.3px;
    }

    .aheto-pricing-tables__subtitle {
        font-family: 'Playfair Display', sans-serif;
        font-size: 27px;
        font-weight: 400;
        width: 100%;
        color: #111;
        margin-bottom: 20px;
        position: relative;
        text-align: center;
    }

    .aheto-pricing-tables__text {
        font-family: 'Muli', sans-serif;
        font-weight: 400;
        font-size: 14px;
        line-height: 1.86;
        text-align: center;
        max-width: 500px;
        margin-right: auto;
        margin-left: auto;
        margin-bottom: 40px;
        color: rgba(17, 17, 17, 0.7);
    }

    .aheto-pricing-tables__top-wrap {
        padding: 30px 15px;
    }

    .aheto-pricing-tables__packages-title {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 2.8px;
        font-weight: 700;
        color: #111111;
        margin-top: 15px;
        margin-bottom: 20px;
    }

    .aheto-pricing-tables__form-item {
        margin-bottom: 25px;
        text-align: left;
        width: 100%;
    }

    .aheto-pricing-tables__form-item .icon {
        width: 30px;
    }

    .aheto-pricing-tables__form-item .aheto-pricing-tables__wrap {
        padding-left: 20px;
        text-align: left;
    }

    .aheto-pricing-tables__form-item .title {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 2.8px;
        font-weight: 700;
        margin-bottom: 0;
        color: #111111;
    }

    .aheto-pricing-tables__form-item .text {
        font-family: 'Muli', sans-serif;
        font-weight: 400;
        font-size: 14px;
        line-height: 1.86;
        color: rgba(17, 17, 17, 0.7);
    }

    .aheto-pricing-tables__packages-wrap table {
        width: 100%;
    }

    .aheto-pricing-tables__packages-wrap table tr {
        margin-bottom: 15px;
    }

    .aheto-pricing-tables__packages-wrap table td {
        width: 50%;
        font-family: 'Muli', sans-serif;
        font-weight: 400;
        font-size: 14px;
    }

    .aheto-pricing-tables__packages-wrap table tr td:first-child {
        color: rgba(17, 17, 17, 0.7);
        width: 40%;
        padding-right: 15px;
    }

    .aheto-pricing-tables__packages-wrap table tr td:nth-of-type(2) span {
        display: inline-block;
        width: 100%;
        height: 1px;
        border-bottom: 1px dashed rgba(17, 17, 17, 0.2);
    }

    .aheto-pricing-tables__packages-wrap table tr td:nth-of-type(3) {
        font-family: "Playfair Display", sans-serif;
        font-weight: 400;
        width: 20%;
        padding-left: 15px;
        text-align: right;
        font-size: 17px;
    }

    .aheto-pricing-tables__total-price {
        color: #111;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 2.8px;
        font-weight: 700;
        margin-top: 30px;
        text-align: right;
    }

    .aheto-pricing-tables__total-price span {
        font-family: "Playfair Display", sans-serif;
        font-weight: 400;
        font-size: 29px;
    }
</style>

<div class="aheto-pricing-tables__pricelist-pdf-wrap">
    <div class="aheto-pricing-tables__top-wrap">
        <div class="aheto-pricing-tables__logo-wrap">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="aheto-pricing-tables__logo">
				<?php echo '<span>' . get_option( 'blogname' ) . '</span>'; ?>
            </a>
        </div>
        <hr>
		<?php if ( ! empty( $title ) ) { ?>
            <div class="aheto-pricing-tables__subtitle">
				<?php echo wp_kses_post( $title ); ?>
            </div>
		<?php }
		if ( ! empty( $text ) ) { ?>
            <div class="aheto-pricing-tables__text">
				<?php echo wp_kses_post( $text ); ?>
            </div>
		<?php } ?>
        <hr>
    </div>
    <div class="aheto-pricing-tables__form-wrap">
		<?php if ( ! empty( $name ) ) { ?>
            <table class="aheto-pricing-tables__form-item">
                <td class="icon">
                    <img src="<?php echo SNAPSTER_T_URI . '/aheto/pricing-tables/assets/images/user.svg' ?>" alt="icon">
                </td>
                <td class="aheto-pricing-tables__wrap">
                    <div class="title">
						<?php esc_html_e( 'Name', 'snapster' ); ?>
                    </div>
                    <div class="text">
						<?php echo esc_html( $name ); ?>
                    </div>
                </td>
            </table>
		<?php } ?>
		<?php if ( ! empty( $email ) ) { ?>
            <table class="aheto-pricing-tables__form-item">
                <td class="icon">
                    <img src="<?php echo SNAPSTER_T_URI . '/aheto/pricing-tables/assets/images/email.svg' ?>" alt="icon">
                </td>
                <td class="aheto-pricing-tables__wrap">
                    <div class="title">
						<?php esc_html_e( 'Email', 'snapster' ); ?>
                    </div>
                    <div class="text">
						<?php echo esc_html( $email ); ?>
                    </div>
                </td>
            </table>
		<?php } ?>
		<?php if ( ! empty( $date ) ) { ?>
            <table class="aheto-pricing-tables__form-item">
                <td class="icon">
                    <img src="<?php echo SNAPSTER_T_URI . '/aheto/pricing-tables/assets/images/date.svg' ?>" alt="date">
                </td>
                <td class="aheto-pricing-tables__wrap">
                    <div class="title">
						<?php esc_html_e( 'Date', 'snapster' ); ?>
                    </div>
                    <div class="text">
						<?php echo esc_html( $date ); ?>
                    </div>
                </td>
            </table>
		<?php } ?>
		<?php if ( ! empty( $location ) ) { ?>
            <table class="aheto-pricing-tables__form-item">
                <td class="icon">
                    <img src="<?php echo SNAPSTER_T_URI . '/aheto/pricing-tables/assets/images/location.svg' ?>" alt="icon">
                </td>
                <td class="aheto-pricing-tables__wrap">
                    <div class="title">
						<?php esc_html_e( 'Location', 'snapster' ); ?>
                    </div>
                    <div class="text">
						<?php echo esc_html( $location ); ?>
                    </div>
                </td>
            </table>
		<?php } ?>
		<?php if ( ! empty( $message ) ) { ?>
            <table class="aheto-pricing-tables__form-item">
                <td class="icon">
                    <img src="<?php echo SNAPSTER_T_URI . '/aheto/pricing-tables/assets/images/message.svg' ?>" alt="icon">
                </td>
                <td class="aheto-pricing-tables__wrap">
                    <div class="title">
						<?php esc_html_e( 'Your 3 things I should know', 'snapster' ); ?>
                    </div>
                    <div class="text">
						<?php echo esc_html( $message ); ?>
                    </div>
                </td>
            </table>
		<?php } ?>
    </div>
    <div class="aheto-pricing-tables__packages-wrap">
		<?php if ( ! empty( $packages_title ) ) { ?>
            <div class="aheto-pricing-tables__packages-title">
				<?php echo wp_kses_post( $packages_title ); ?>
            </div>
		<?php } ?>
		<?php if ( ! empty( $packages ) ) { ?>
            <table>
				<?php foreach ( $packages as $package ) {
					$pack = explode( '=', $package ); ?>
                    <tr>
						<?php if ( ! empty( $pack[0] ) ) { ?>
                            <td><?php echo wp_kses($pack[0], 'post'); ?></td>
						<?php } ?>
                        <td><span></span></td>
						<?php if ( ! empty( $pack[1] ) ) { ?>
                            <td><?php echo wp_kses($pack[1], 'post' ); ?></td>
						<?php } ?>
                    </tr>
				<?php } ?>
            </table>
		<?php } ?>
		<?php if ( ! empty( $total_price ) ) { ?>
            <div class="aheto-pricing-tables__total-price">
				<?php esc_html_e( 'Total price: ', 'snapster' ); ?><span><?php echo esc_html( $total_price ); ?></span>
            </div>
		<?php } ?>
    </div>
</div>
<?php if ( ! empty( $copyright ) ) { ?>
    <div class="aheto-pricing-tables__copyright">
		<?php echo wp_kses_post( $copyright ); ?>
    </div>
<?php } ?>
</body>
</html>
