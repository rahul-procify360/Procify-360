<?php
declare( strict_types=1 );

namespace Automattic\WooCommerce\Internal\DependencyManagement\ServiceProviders;

use Automattic\WooCommerce\Internal\DependencyManagement\AbstractServiceProvider;
use Automattic\WooCommerce\Internal\Admin\EmailPreview;

/**
 * Service provider for the EmailPreview namespace.
 */
class EmailPreviewServiceProvider extends AbstractServiceProvider {

	/**
	 * The classes/interfaces that are serviced by this service provider.
	 *
	 * @var array
	 */
	protected $provides = array(
		EmailPreview::class,
	);

	/**
	 * Register the classes.
	 */
	public function register() {
		$this->share( EmailPreview::class );
	}
}
