<?php
/*  Copyright 2010-2024 Renzo Johnson (email: renzo.johnson at gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
defined( 'ABSPATH' ) || exit;

require_once( SPARTAN_MCE_PLUGIN_DIR . '/lib/activate.php' );
require_once( SPARTAN_MCE_PLUGIN_DIR . '/lib/oauth.php' );
require_once( SPARTAN_MCE_PLUGIN_DIR . '/lib/service.php' );
require_once( SPARTAN_MCE_PLUGIN_DIR . '/lib/meta.php' );
require_once( SPARTAN_MCE_PLUGIN_DIR . '/lib/enqueue.php' );
require_once( SPARTAN_MCE_PLUGIN_DIR . '/lib/tools.php' );
require_once( SPARTAN_MCE_PLUGIN_DIR . '/lib/logger.php' );
require_once( SPARTAN_MCE_PLUGIN_DIR . '/lib/helper.php' );
require_once( SPARTAN_MCE_PLUGIN_DIR . '/lib/handler.php' );
require_once( SPARTAN_MCE_PLUGIN_DIR . '/lib/wp.php' );
require_once( SPARTAN_MCE_PLUGIN_DIR . '/lib/deactivate.php' );
require_once( SPARTAN_MCE_PLUGIN_DIR . '/lib/find.php' );
require_once( SPARTAN_MCE_PLUGIN_DIR . '/lib/events.php' );
require_once( SPARTAN_MCE_PLUGIN_DIR . '/lib/jobs.php' );

//require_once( SPARTAN_MCE_PLUGIN_DIR . '/lib/install-wp-plugins.php' );
