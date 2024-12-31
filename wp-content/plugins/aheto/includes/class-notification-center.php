<?php
/**
 * The Notification center handles notifications storage and display.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto;

use Aheto\Helper;
use Aheto\Traits\Ajax;
use Aheto\Traits\Hooker;

defined( 'ABSPATH' ) || exit;

/**
 * Notification_Center class.
 */
class Notification_Center {

	use Ajax;
	use Hooker;

	/**
	 * Option name to store notifications on.
	 *
	 * @var string
	 */
	const STORAGE_KEY = 'aheto_notifications';

	/**
	 * Notifications.
	 *
	 * @var array
	 */
	private $notifications = [];

	/**
	 * Internal flag for whether notifications have been retrieved from storage.
	 *
	 * @var boolean
	 */
	private $retrieved = false;

	/**
	 * Construct
	 */
	public function __construct() {
		$this->action( 'init', 'get_from_storage' );
		$this->action( 'all_admin_notices', 'display' );
		$this->action( 'shutdown', 'update_storage' );

		$this->ajax( 'notice_dismissible', 'notice_dismissible' );
	}

	/**
	 * Retrieve the notifications from storage
	 *
	 * @return array Notification[] Notifications
	 */
	public function get_from_storage() {
		if ( $this->retrieved ) {
			return;
		}

		$this->retrieved = true;
		$notifications   = get_option( self::STORAGE_KEY );

		// Check if notifications are stored.
		if ( empty( $notifications ) ) {
			return;
		}

		if ( is_array( $notifications ) ) {
			foreach ( $notifications as $notification ) {
				$this->notifications[] = new Notification(
					$notification['message'],
					$notification['options']
				);
			}
		}
	}

	/**
	 * Display the notifications.
	 */
	public function display() {

		// Never display notifications for network admin.
		if ( function_exists( 'is_network_admin' ) && is_network_admin() ) {
			return;
		}

		$notifications = $this->get_sorted_notifications();
		if ( empty( $notifications ) ) {
			return;
		}

		foreach ( $notifications as $notification ) {
			if ( ! $notification->can_display() ) {
				continue;
			}

			echo $notification;
		}
	}

	/**
	 * Save persistent or transactional notifications to storage.
	 *
	 * We need to be able to retrieve these so they can be dismissed at any time during the execution.
	 */
	public function update_storage() {
		$notifications = $this->get_notifications();
		$notifications = array_filter( $notifications, [ $this, 'remove_notification' ] );

		/**
		 * Filter: 'aheto_notifications_before_storage' - Allows developer to filter notifications before saving them.
		 *
		 * @param Notification[] $notifications
		 */
		$notifications = $this->do_filter( 'notifications_before_storage', $notifications );

		// No notifications to store, clear storage.
		if ( empty( $notifications ) ) {
			delete_option( self::STORAGE_KEY );

			return;
		}

		$notifications = array_map( [ $this, 'notification_to_array' ], $notifications );

		// Save the notifications to the storage.
		update_option( self::STORAGE_KEY, $notifications );
	}

	/**
	 * Dismiss persistent notice.
	 */
	public function notice_dismissible() {
		$notification_id  = filter_input( INPUT_POST, 'notificationId' );
		$notification_key = filter_input( INPUT_POST, 'notificationKey' );

		$this->verify_nonce( $notification_id );

		$notification = $this->get_notification_by_id( $notification_id );
		if ( ! is_null( $notification ) ) {
			$notification->dismiss();
		}
	}

	/**
	 * Add notification
	 *
	 * @param string $message Message string.
	 * @param array  $options Set of options.
	 */
	public function add( $message, $options = [] ) {
		$this->notifications[] = new Notification(
			$message,
			$options
		);
	}

	/**
	 * Remove notification after it has been displayed.
	 *
	 * @param Notification $notification Notification to remove.
	 */
	public function remove_notification( Notification $notification ) {
		if ( ! $notification->is_displayed() ) {
			return true;
		}

		if ( $notification->is_persistent() ) {
			return true;
		}

		return false;
	}

	/**
	 * Provide a way to verify present notifications
	 *
	 * @return array|Notification[] Registered notifications.
	 */
	private function get_notifications() {
		return $this->notifications;
	}

	/**
	 * Return the notifications sorted on type and priority
	 *
	 * @return array|Notification[] Sorted Notifications
	 */
	private function get_sorted_notifications() {
		$notifications = $this->get_notifications();
		if ( empty( $notifications ) ) {
			return [];
		}

		// Sort by severity, error first.
		usort( $notifications, [ $this, 'sort_notifications' ] );

		return $notifications;
	}

	/**
	 * Get the notification by ID
	 *
	 * @param  string $notification_id The ID of the notification to search for.
	 * @return null|Notification
	 */
	private function get_notification_by_id( $notification_id ) {
		foreach ( $this->notifications as &$notification ) {
			if ( $notification_id === $notification->args( 'id' ) ) {
				return $notification;
			}
		}
		return null;
	}

	/**
	 * Sort on type then priority
	 *
	 * @param  Notification $a Compare with B.
	 * @param  Notification $b Compare with A.
	 * @return int 1, 0 or -1 for sorting offset.
	 */
	private function sort_notifications( Notification $a, Notification $b ) {

		if ( 'error' === $a->args( 'type' ) ) {
			return -1;
		}

		if ( 'error' === $b->args( 'type' ) ) {
			return 1;
		}

		return 0;
	}

	/**
	 * Convert Notification to array representation
	 *
	 * @param  Notification $notification Notification to convert.
	 * @return array
	 */
	private function notification_to_array( Notification $notification ) {
		return $notification->to_array();
	}
}
