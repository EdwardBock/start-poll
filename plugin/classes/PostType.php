<?php

namespace Palasthotel\WordPress\StartPoll;

use Palasthotel\WordPress\StartPoll\Components\Component;

class PostType extends Component {

	public function onCreate(): void {
		parent::onCreate();

		add_action( 'init', array($this,'init') );
	}

	function getSlug(): string {
		$slug = apply_filters( Plugin::FILTER_POST_TYPE_SLUG, Plugin::POST_TYPE_SLUG );
		return (is_string($slug) && !empty($slug))? $slug: Plugin::POST_TYPE_SLUG;
	}

	function init(){
		$labels  = array(
			'name'                  => _x( 'Polls', 'Post Type General Name', Plugin::DOMAIN ),
			'singular_name'         => _x( 'Poll', 'Post Type Singular Name', Plugin::DOMAIN ),
			'menu_name'             => __( 'Polls', Plugin::DOMAIN ),
			'name_admin_bar'        => __( 'Poll', Plugin::DOMAIN ),
			'archives'              => __( 'Poll', Plugin::DOMAIN ),
			'all_items'             => __( 'Polls', Plugin::DOMAIN ),
			'add_new_item'          => __( 'Add Poll', Plugin::DOMAIN ),
			'add_new'               => __( 'New Poll', Plugin::DOMAIN ),
		);

		$args    = array(
			'label'               => __( 'Polls', Plugin::DOMAIN ),
			'description'         => __( 'Manage polls', Plugin::DOMAIN ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'custom-fields' ),
			'hierarchical'        => false,
			'public'              => false,
			'show_in_rest'        => true,
			'show_ui'             => true,
			'menu_position'       => 25,
			'menu_icon'           => "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2ZXJzaW9uPSIxLjEiIHg9IjBweCIgeT0iMHB4IiB2aWV3Qm94PSIwIDAgMTAwIDEwMCIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgMTAwIDEwMCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+PHBhdGggZmlsbD0id2hpdGUiIGQ9Ik03MC42LDU2LjFoOC4ydjguMmgtOC4yVjU2LjF6IE05Ny44LDYwLjJjMCw3LTIuNSwxMy44LTcsMTkuNGMwLjgsMS42LDIsMi44LDMuNCwzLjdjMS41LDEsMi4yLDIuNywxLjgsNC40ICBjLTAuNCwxLjctMS43LDIuOS0zLjUsMy4yYy0xLjIsMC4yLTIuNCwwLjMtMy42LDAuM2MtMy42LDAtNi45LTAuNy05LjktMi4yYy01LjYsMi45LTEyLDQuNC0xOC42LDQuNGMtMjAuNiwwLTM3LjQtMTQuOS0zNy40LTMzLjIgIFMzOS43LDI3LDYwLjMsMjdTOTcuOCw0MS45LDk3LjgsNjAuMnogTTkxLjMsNjAuMmMwLTE0LjgtMTMuOS0yNi44LTMxLTI2LjhjLTE3LjEsMC0zMSwxMi0zMSwyNi44YzAsMTQuOCwxMy45LDI2LjgsMzEsMjYuOCAgYzYuMSwwLDExLjktMS41LDE3LTQuNGwxLjYtMC45bDEuNiwxYzEuNywxLDMuNiwxLjcsNS43LDJjLTEtMS4zLTEuNy0yLjgtMi4zLTQuNGwtMC43LTEuOGwxLjMtMS40Qzg5LDcyLjEsOTEuMyw2Ni4zLDkxLjMsNjAuMnogICBNNTYuMyw2NC4zaDguMnYtOC4yaC04LjJWNjQuM3ogTTQyLDY0LjNoOC4ydi04LjJINDJWNjQuM3ogTTQuMiw1Ny41Yy0wLjcsMC40LTAuNSwxLjUsMC4zLDEuNmMyLjgsMC40LDcuNSwwLjUsMTEuOS0yLjIgIGMwLDAsMCwwLDAsMGMxLjktMjAuMywyMC45LTM2LjMsNDQuMS0zNi4zYzAsMCwwLDAsMCwwYy01LjMtOC4zLTE1LjUtMTQtMjcuMi0xNEMxNi4yLDYuNiwyLjIsMTguOCwyLjIsMzMuOSAgYzAsNi41LDIuNiwxMi41LDYuOSwxNy4yQzguNCw1My4zLDYuOSw1NS43LDQuMiw1Ny41eiI+PC9wYXRoPjwvc3ZnPg==",
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'capability_type'     => 'page',
			'template' => [
				['start-poll/poll-editor'],
			],
			'template_lock' => 'all',
		);
		register_post_type( $this->getSlug(), $args );

	}
}
