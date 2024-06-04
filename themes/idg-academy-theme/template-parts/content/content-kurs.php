<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( ! twentynineteen_can_show_post_thumbnail() ) : ?>
	<header class="entry-header">
		<?php get_template_part( 'template-parts/header/entry', 'header' ); ?>
	</header>
	<?php endif; ?>

	<div class="entry-content kurssida">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentynineteen' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'twentynineteen' ),
				'after'  => '</div>',
			)
		);
		?>	
	</div><!-- .entry-content -->
	
	
	<?php 
	$wysiwyg = get_field('wysiwyg');
	$datum = get_field('datum');
	$slutdatum = get_field('slutdatum');
	$stad = get_field('stad');
	$lank = get_field('lank');
	$slutsalt = get_field('slutsalt');
	$datum2= get_field('datum2');
	$slutdatum2= get_field('slutdatum2');
	$stad2 = get_field('stad2');
	$lank2 = get_field('lank2');
	$slutsalt2 = get_field('slutsalt2');
	$datum3 = get_field('datum3');
	$slutdatum3 = get_field('slutdatum3');
	$stad3 = get_field('stad3');
	$lank3 = get_field('lank3');
	$slutsalt3 = get_field('slutsalt3');
?>

<?php if( $wysiwyg ): ?>		
	<div id="sidebar-mobil" class="sidebar-mobil">
		<h2>Boka nu</h2>
		<div class="knappar">
			<?php if( $datum ): ?>
				<?php if( $slutsalt ): ?>	
					<div class="knapp">	
						<?php echo $stad; ?>, <?php echo $datum; ?>
						<?php if( $slutdatum ): ?>
							– <?php echo $slutdatum; ?>
						<?php endif; ?> <span class="slutsalt">(fullbokat)</span>		
					</div>
				<?php endif; ?>			
				<?php if( !$slutsalt ): ?>
					<a href="<?php echo $lank; ?>">
						<?php echo $stad; ?>, <?php echo $datum; ?>
						<?php if( $slutdatum ): ?>
							– <?php echo $slutdatum; ?>
						<?php endif; ?>			
					</a>
				<?php endif; ?>			
			<?php endif; ?>
			
			<?php if( $datum2 ): ?>
				<?php if( $slutsalt2 ): ?>
					<div class="knapp">	
						<?php echo $stad2; ?>, <?php echo $datum2; ?>
						<?php if( $slutdatum2 ): ?>
							– <?php echo $slutdatum2; ?>
						<?php endif; ?> <span class="slutsalt">(fullbokat)</span>		
					</div>
				<?php endif; ?>			
				<?php if( !$slutsalt2 ): ?>
					<a href="<?php echo $lank2; ?>">
						<?php echo $stad2; ?>, <?php echo $datum2; ?>
						<?php if( $slutdatum2 ): ?>
							– <?php echo $slutdatum2; ?>
						<?php endif; ?>			
					</a>
				<?php endif; ?>					
			<?php endif; ?>					

			<?php if( $datum3 ): ?>
				<?php if( $slutsalt3 ): ?>
					<div class="knapp">	
						<?php echo $stad3; ?>, <?php echo $datum3; ?>
						<?php if( $slutdatum3 ): ?>
							– <?php echo $slutdatum3; ?>
						<?php endif; ?> <span class="slutsalt">(fullbokat)</span>		
					</div>
				<?php endif; ?>			
				<?php if( !$slutsalt3 ): ?>
					<a href="<?php echo $lank2; ?>">
						<?php echo $stad3; ?>, <?php echo $datum3; ?>
						<?php if( $slutdatum3 ): ?>
							– <?php echo $slutdatum3; ?>
						<?php endif; ?>			
					</a>
				<?php endif; ?>					
			<?php endif; ?>				
			
		</div>
		<?php echo $wysiwyg; ?>	
	</div>
<?php endif; ?>	
	
	<footer class="entry-footer">
		<?php twentynineteen_entry_footer(); ?>
	</footer><!-- .entry-footer -->

	<?php if ( ! is_singular( 'attachment' ) ) : ?>
		<?php get_template_part( 'template-parts/post/author', 'bio' ); ?>
	<?php endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->
