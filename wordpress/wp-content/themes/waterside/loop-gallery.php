<?php 
$args = array(
	'order'          => 'ASC',
	'orderby'          => 'menu_order',
	'post_type'      => 'attachment',
	'post_parent'    => $post->ID,
	'post_mime_type' => 'image',
	'post_status'    => null,
	'numberposts'    => -1
);
$attachments = get_posts($args);

$i = 0;

if (count($attachments) > 0) { ?>

<ul class="hermes-gallery-list">

<?php foreach ($attachments as $attachment) { 
	$i++;
	$image_data = wp_get_attachment_image_src( $attachment->ID, 'large' ); 
	?>
	<li class="hermes-gallery-item gallery-item-<?php echo $i; if ($i % 3 == 1) { echo ' gallery-item-first';} ?>">

		<div class="gallery-item-wrapper">
			<div class="post-cover">
				<a href="<?php echo $image_data[0]; ?>" class="thickbox" title="<?php echo apply_filters( 'the_title', $attachment->post_title ); ?>" rel="hermes-gallery"><?php echo wp_get_attachment_image( $attachment->ID, 'thumb-loop-gallery' ); ?></a>
			</div><!-- end .post-cover -->
			
			<div class="post-excerpt">
				<p><?php echo apply_filters( 'the_title', $attachment->post_title ); ?></p>
			</div><!-- end .post-excerpt -->
			<div class="cleaner">&nbsp;</div>
		</div><!-- .hermes-gallery-wrapper -->
		
	</li><!-- end .hermes-gallery-item -->
<?php 
	if ($i == 3) { $i = 0; } // reset the counter to zero
} // foreach ?>

</ul><!-- end .hermes-gallery-list -->

<div class="cleaner">&nbsp;</div>

<?php 
wp_reset_query();
} // if there are attachments
?>