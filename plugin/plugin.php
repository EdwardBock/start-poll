<?php

/**
 * Plugin Name:         Start Poll
 * Description:         Start with polls on your page
 * Version:             1.0.0
 * Requires at least:   6.0
 * Tested up to:        6.5.5
 * Author:              Edward Bock <edward.bock@palasthotel.de>
 * Author URI:          http://www.palasthotel.de
 * Requires PHP:        8.1
 * Text Domain:         polls
 * Domain Path:         /languages
 * License:             GPLv3 or later
 * License URI:         https://www.gnu.org/licenses/gpl-3.0.html
 *
 */

namespace Palasthotel\WordPress\StartPoll;

use Palasthotel\WordPress\StartPoll\Components\Assets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once __DIR__ . "/vendor/autoload.php";

class Plugin extends Components\Plugin {

	const DOMAIN = "start-poll";

	const POST_TYPE_SLUG = "polls";

	/**
	 * FILTER and ACTION
	 */
	const FILTER_POST_TYPE_SLUG = "start_poll_post_type_slug";
	const FILTER_META_KEY_OPTIONS = "start_poll_meta_key_options";
	const FILTER_META_KEY_SUBMIT_BUTTON_LABEL = "start_poll_meta_key_label";

	/*
	 * METAS and OPTIONS
	 */
	const META_KEY_OPTIONS = "poll_options";
	const META_KEY_SUBMIT_BUTTON_LABEL = "poll_submit_button_label";

	/*
	 * SCRIPTS and STYLES
	 */
	const HANDLE_SCRIPT_GUTENBERG = "start-poll-gutenberg";

	/*
	 * REST
	 */
	const REST_NAMESPACE_V1 = "start-poll/v1";

	/*
	 * Properties
	 */
	public Assets $assets;
	public PostType $postType;
	public REST $rest;

	function onCreate(): void {

		$this->loadTextdomain( Plugin::DOMAIN, "languages" );

		$this->assets = new Assets($this);
		$this->postType = new PostType($this);
		$this->rest = new REST($this);

		new Gutenberg($this);
		new PostsTable($this);
	}
}

Plugin::instance();

require_once __DIR__. "/public-functions.php";
