<div id="system">

	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		
		<div class="item">
		
			<h1 class="title"><?php the_title(); ?></h1>

			<p class="meta"><?php printf(__('Published by %s on %s', 'warp'), '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" title="'.get_the_author().'">'.get_the_author().'</a>', get_the_date()); ?>.

				<?php 
					if (wp_attachment_is_image()) {
						$metadata = wp_get_attachment_metadata();
						printf(__('Full size is %s pixels.', 'warp'),
							sprintf('<a href="%1$s" title="%2$s">%3$s&times;%4$s</a>',
								wp_get_attachment_url(),
								esc_attr(__('Link to full-size image', 'warp')),
								$metadata['width'],
								$metadata['height']
							)
						);
					}
				?>
			
			</p>
			
			<div class="content">
				<a class="fluid-image" href="<?php echo wp_get_attachment_url(); ?>" title="<?php the_title_attribute(); ?>"><?php echo wp_get_attachment_image($post->ID, 'full-size'); ?></a>
			</div>
			
			<?php edit_post_link(__('Edit this attachment.', 'warp'), '<p class="edit">','</p>'); ?>

		</div>
		
		<?php comments_template(); ?>

		<?php endwhile; ?>
	<?php endif; ?>

</div>