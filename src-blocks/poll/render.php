<?php
/**
 * @var array $attributes
 * @var string $content
 * @var WP_Block $block
 */

$options = start_poll_get_options($attributes["pollId"]);
if(!is_array($options)){
	$options = [];
}
$label = start_poll_get_submit_button_label($attributes["pollId"]);

$attrs = get_block_wrapper_attributes();

$overall = array_reduce($options, function($result, $option) {
	return $result + $option["counter"];
}, 0);
?>

<div <?= $attrs?>>
	<p><strong><?= start_poll_get_title($attributes["pollId"]); ?></strong></p>

	<ul>
		<?php
		foreach ($options as $option) {
			$percent = ($overall > 0) ? round(($option["counter"] / $overall) * 100) : 0;
			echo "<li>";
			echo "<div data-title>{$option["label"]}</div>";
			echo "<div data-chart>";
			echo "<div data-bar style='width: $percent%'></div>";
			echo "</div>";
			echo "</li>";
		}
		?>
	</ul>

</div>
