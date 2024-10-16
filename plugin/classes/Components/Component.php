<?php


namespace Palasthotel\WordPress\StartPoll\Components;

abstract class Component {


	public function __construct(
		public \Palasthotel\WordPress\StartPoll\Plugin $plugin
	) {
		$this->onCreate();
	}

	/**
	 * overwrite this method in component implementations
	 */
	public function onCreate(): void {
		// init your hooks and stuff
	}
}
