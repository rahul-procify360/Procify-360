<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit;
}

delete_option('ip2location_redirection_api_key');
delete_option('ip2location_redirection_database');
delete_option('ip2location_redirection_debug_log_enabled');
delete_option('ip2location_redirection_enable_region_redirect');
delete_option('ip2location_redirection_enabled');
delete_option('ip2location_redirection_first_redirect');
delete_option('ip2location_redirection_ignore_query_string');
delete_option('ip2location_redirection_ip_whitelist');
delete_option('ip2location_redirection_lookup_mode');
delete_option('ip2location_redirection_noredirect_enabled');
delete_option('ip2location_redirection_rules');
delete_option('ip2location_redirection_skip_bots');
delete_option('ip2location_redirection_token');

wp_cache_flush();
