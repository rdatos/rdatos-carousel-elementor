<?php
/**
 * @var array  $item
 * @var string $field_prefix
 */

if ( ! $settings[$field_prefix . 'image_hide'] ) { ?>
	<div class="owl-thumb">
		<?php
		$settings['item_image_temp'] = $item['item_image'];

		echo owce_get_img_with_size_simple($settings, $field_prefix . 'thumbnail', 'item_image_temp');
		?>
	</div>

<?php }
