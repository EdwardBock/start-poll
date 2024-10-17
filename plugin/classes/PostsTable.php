<?php

namespace Palasthotel\WordPress\StartPoll;

use Palasthotel\WordPress\StartPoll\Components\Component;

class PostsTable extends Component {

	public function onCreate(): void {
		parent::onCreate();

		add_action('init', [$this, 'init']);
	}

	public function init(): void {
		add_action("manage_pages_custom_column", [$this, 'custom_columns'], 10, 2);
		add_filter('manage_pages_columns', [$this, 'add_column']);

		$type = $this->plugin->postType->getSlug();

		add_filter("manage_{$type}_posts_columns", [$this, 'add_column']);
		add_action("manage_{$type}_posts_custom_column", [$this, 'custom_columns'], 10, 2);
	}

	public function add_column(array $columns): array {

		$newColumns = [];
		foreach ($columns as $key => $value) {
			$newColumns[$key] = $value;
			if($key == "title"){
				$newColumns["poll_votes"] = __('Votes', Plugin::DOMAIN);
			}
		}

		return $newColumns;
	}


	public function custom_columns($column, $post_id): void {
		if ($column != "poll_votes") {
			return;
		}
		$options = start_poll_get_options($post_id);
		if(!is_array($options)) {
			var_dump($options);
			return;
		}

		$overall = array_reduce($options, function ($result, $option) {
			return $result + $option["counter"];
		}, 0);

		echo $overall;
	}


}
