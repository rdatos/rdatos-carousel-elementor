<?php
/**
 * @var string $item_hover_animation_class
 */
if ( ! empty( $settings ) ) :
	if ( $settings['items_list'] ) :
		foreach ( $settings['items_list'] as $item ) : ?>
			<div class="item carousel-item-<?php echo esc_attr( $item['_id'] . ' ' . $item_hover_animation_class );
			?>">
				<?php
				require OWCE_PLUGIN_PATH . '/includes/widgets/views/thumbnail.php';
				?>
				<a href='<?php echo $item['item_link'] ?>' style="z-index: 2;">
					<?php
					require OWCE_PLUGIN_PATH . '/includes/widgets/views/title.php';
					?>
				</a>
				<?php
				require OWCE_PLUGIN_PATH . '/includes/widgets/views/subtitle.php';
				?>
			</div>
		<?php
		endforeach;
	endif;
endif;
