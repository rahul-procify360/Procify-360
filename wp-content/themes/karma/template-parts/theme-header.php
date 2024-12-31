<div class="karma-preloader"></div>

<div class="karma-main-wrapper">
    <header class="karma-header--wrap">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <!-- HEADER -->
                    <div class="karma-header">

                        <!-- NAVIGATION -->
                        <nav id="topmenu" class="karma-header--topmenu">

                            <div class="karma-header--logo-wrap">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="karma-header--logo">
                                    <span><?php echo get_option( 'blogname' ); ?></span>
                                </a>
                            </div>

                            <div class="karma-header--menu-wrapper">
								<?php if ( has_nav_menu( 'primary-menu' ) ) {

									$args                   = array( 'container' => '' );
									$args['theme_location'] = 'primary-menu';
									wp_nav_menu( $args );

								} else {

									echo '<span class="no-menu primary-no-menu">' . esc_html__( 'Please register Top Navigation from', 'karma' ) . ' <a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" target="_blank">' . esc_html__( 'Appearance &gt; Menus', 'karma' ) . '</a></span>';

								} ?>

                            </div>

                            <!-- SEARCH -->
                            <div class="karma-header--search-wrap">
								<?php do_action( 'karma_search' ); ?>
                            </div>

                            <!-- MOB MENU ICON -->
                            <div class="karma-header--mob-nav">
                                <a href="#" class="karma-header--mob-nav__hamburger">
                                    <span></span>
                                </a>
                            </div>
                        </nav>

                    </div>
                </div>
            </div>
        </div>
    </header>

