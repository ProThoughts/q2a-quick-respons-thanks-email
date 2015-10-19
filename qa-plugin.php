<?php
/*
	Plugin Name: quick respons thanks mail
	Plugin URI: 
	Plugin Description: send thanks mail to users who responded within X hour
	Plugin Version: 0.3
	Plugin Date: 2015-10-17
	Plugin Author:
	Plugin Author URI:
	Plugin License: GPLv2
	Plugin Minimum Question2Answer Version: 1.7
	Plugin Update Check URI: 
*/
if (!defined('QA_VERSION')) {
	header('Location: ../../');
	exit;
}

qa_register_plugin_module('module', 'admin.php', 'q2a_quick_respons_thanks_admin', 'quick respons thanks');
qa_register_plugin_module('event', 'q2a-quick-respons-thanks-email-event.php', 'q2a_quick_respons_thanks_email_event', 'Quick Respons Thanks');

/*
	Omit PHP closing tag to help avoid accidental output
*/
