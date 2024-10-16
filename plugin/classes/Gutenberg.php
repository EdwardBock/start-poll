<?php

namespace Palasthotel\WordPress\StartPoll;

use Palasthotel\WordPress\StartPoll\Components\Component;

class Gutenberg extends Component {
	public function onCreate(): void {
		parent::onCreate();

		add_action('init', [$this, 'init']);
		add_action('enqueue_block_editor_assets', [$this, 'enqueue_block_editor_assets']);
		add_action('enqueue_block_assets', [$this, 'enqueue_block_assets']);
		add_filter('block_categories_all', [$this, 'block_categories_all']);
		add_filter( 'block_type_metadata', [$this, 'block_type_metadata' ]);
	}

	public function init(): void {
		$this->plugin->assets->registerScript(
			Plugin::HANDLE_SCRIPT_GUTENBERG,
			"dist/gutenberg.ts.js",
		);
		wp_localize_script(
			Plugin::HANDLE_SCRIPT_GUTENBERG,
			"StartPoll",
			[
				"post_type" => $this->plugin->postType->getSlug(),
				"meta_keys" => [
					"options" => $this->plugin->rest->getOptionsMetaKey(),
					"button_label" => $this->plugin->rest->getSubmitButtonLabelMetaKey(),
				]
			]
		);

		$path = $this->plugin->path;
		$dirs = glob("$path/blocks/*", GLOB_ONLYDIR);

		foreach ($dirs as $dir) {
			register_block_type($dir);
		}
	}

	public function enqueue_block_editor_assets(): void {
		// EDITOR
		wp_enqueue_script(Plugin::HANDLE_SCRIPT_GUTENBERG);
	}

	public function enqueue_block_assets(): void {
		// EDITOR & FRONTEND
	}

	public function block_categories_all($categories): array {

		$categories[] = [
			"slug" => "start-poll",
			"title" => "Start Poll",
		];

		return $categories;
	}

	function block_type_metadata($metadata): array {
		if($metadata["name"] == "start-poll/poll"){

			$posts = get_posts([
				'post_type' => $this->plugin->postType->getSlug(),
				"posts_per_page" => 50,
			]);

			$metadata["variations"] =  array_map(function($post){
				return array(
					'name'       => 'start-poll-'.$post->ID,
					'title'      => $post->post_title,
					'attributes' => array(
						'pollId' => $post->ID,
					),
				);
			}, $posts);

		}
		return $metadata;
	}
}
