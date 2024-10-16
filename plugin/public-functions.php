<?php

use Palasthotel\WordPress\StartPoll\Plugin;

function start_poll_plugin() {
	return Plugin::instance();
}

function start_poll_get_title($pollId) {
	return get_the_title($pollId);
}

function start_poll_get_options( $pollId) {
	return get_post_meta($pollId, start_poll_plugin()->rest->getOptionsMetaKey(), true);
}

function start_poll_get_submit_button_label( $pollId) {
	return get_post_meta($pollId, start_poll_plugin()->rest->getOptionsMetaKey(), true);
}
