<?php
/**
 * @var string $item_hover_animation_class
 */
if ( ! empty( $settings ) ) :
	if ( $settings['items_list'] ) :
		foreach ( $settings['items_list'] as $item ) : ?>
			<div class="item carousel-item-<?php echo esc_attr( $item['_id'] . ' ' . $item_hover_animation_class ); ?>">
				<?php
				require OWCE_PLUGIN_PATH . '/includes/widgets/views/thumbnail.php';
				?>
				<div class="owl-rdatos-footer">
						<a class="owl-category category-<?php echo $item['item_category_id']; ?>" href="<?= esc_attr($item['item_category_link']) ?>"><span><?php echo $item['item_category_name']; ?></span></a>
						<a href='<?php echo $item['item_link'] ?>' style="z-index: 2;">
							<?php
							require OWCE_PLUGIN_PATH . '/includes/widgets/views/title.php';
							?>
						</a>
						<?php
						require OWCE_PLUGIN_PATH . '/includes/widgets/views/subtitle.php';
						?>
					<a class="owl-link" href='<?php echo $item['item_link'] ?>'></a>
				</div>
			</div>
		<?php
		endforeach;
	endif;
endif;
