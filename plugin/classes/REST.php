<?php

namespace Palasthotel\WordPress\StartPoll;

class REST extends Components\Component {

	public function onCreate(): void {
		parent::onCreate();
		add_action('rest_api_init', [$this, 'rest_api_init']);
	}

	public function getOptionsMetaKey() {
		return apply_filters(Plugin::FILTER_META_KEY_OPTIONS, Plugin::META_KEY_OPTIONS);
	}

	public function getSubmitButtonLabelMetaKey() {
		return apply_filters(Plugin::FILTER_META_KEY_SUBMIT_BUTTON_LABEL, Plugin::META_KEY_SUBMIT_BUTTON_LABEL);
	}

	public function rest_api_init(): void {

		register_post_meta(
			$this->plugin->postType->getSlug(),
			$this->getOptionsMetaKey(),
			[
				'type' => 'array',
				'show_in_rest' => array(
					'schema' => array(
						'type' => 'array',
						'items' => array(
							'type' => 'object',
							'properties' => array(
								'label' => array(
									'type' => 'string',
								),
								'counter' => array(
									'type' => 'integer',
								),
							),
						),
					),
				),
				'default' => [
					["label" => "", "counter" => 0],
					["label" => "", "counter" => 0],
				],
				'single' => true,
			]
		);

		register_post_meta(
			$this->plugin->postType->getSlug(),
			$this->getSubmitButtonLabelMetaKey(),
			[
				'show_in_rest' => true,
				'single' => true,
				'type' => 'string',
			]
		);

		register_rest_route(
			Plugin::REST_NAMESPACE_V1,
			"polls/(?P<id>\d+)",
			[
				'methods' => \WP_REST_Server::CREATABLE,
				'permission_callback' => '__return_true',
				'args' => array(
					'id' => array(
						'required' => true,
						'validate_callback' => function ($param, $request, $key) {
							return is_numeric($param);
						},
					),
					'option_index' => array(
						'required' => true,
						'validate_callback' => function ($param, $request, $key) {
							return is_numeric($param);
						},
					),
				),
				'callback' => function (\WP_REST_Request $request) {

					$post = get_post($request->get_param("id"));
					if (!$post || $post->post_type !== $this->plugin->postType->getSlug()) {
						return new \WP_Error('no_data', 'Poll not found', array('status' => 404));
					}

					$voteForOptionIndex = intval($request->get_query_params()['option_index']);
					$options = start_poll_get_options($post->ID);
					if($voteForOptionIndex < 0 || count($options) <= $voteForOptionIndex){
						return new \WP_Error('no_data', 'Invalid option index', array('status' => 400));
					}

					$options[$voteForOptionIndex]["counter"] = $options[$voteForOptionIndex]["counter"] + 1;

					update_post_meta($post->ID, $this->getOptionsMetaKey(), $options);

					return $options;
				},
			]
		);

	}

}
