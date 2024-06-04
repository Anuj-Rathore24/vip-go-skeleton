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

<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
    <?php wp_head(); ?>
	<?php if( $datum OR $datum2 OR $datum3):
echo "<style>.sidebar .felixform, .blockbar .felixform, .sidebar .gform_wrapper, .blockbar .gform_wrapper, .sidebar .webpower-email-form, .blockbar .webpower-email-form {display: none!important;}</style>"; 
endif; ?>
	
<script>
    if (typeof window.newsletterScript === 'undefined') {
        window.newsletterScript = document.createElement('script');
        window.newsletterScript.src = 'https://www.idg.se/combine/1.714604';
        window.newsletterScript.async = 'async';
        document.head.appendChild(window.newsletterScript);
    }
</script>
	
	
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MHN3BWZ');</script>
<!-- End Google Tag Manager -->
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MHN3BWZ"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentynineteen' ); ?></a>

<?php if( $wysiwyg ): ?>
	<div id="sidebar" class="sidebar">
		
<?php if( $datum OR $datum2 OR $datum3):
echo "<h2>Boka nu</h2>"; 
endif; ?>		
		
		<div class="knappar">
			<?php if( $datum ): ?>
				<?php if( $slutsalt ): ?>	
					<div class="knapp">	
						<?php echo $datum; ?>
						<?php if( $slutdatum ): ?>
							– <?php echo $slutdatum; ?>
						<?php endif; ?>&bull; <?php echo $stad; ?> <span class="slutsalt">(fullbokat)</span>		
					</div>
				<?php endif; ?>			
				<?php if( !$slutsalt ): ?>
					<a target="_blank" href="<?php echo $lank; ?>">
						<?php echo $datum; ?>
						<?php if( $slutdatum ): ?>
							– <?php echo $slutdatum; ?>
						<?php endif; ?>&bull; <?php echo $stad; ?> 			
					</a>
				<?php endif; ?>			
			<?php endif; ?>
			
			<?php if( $datum2 ): ?>
				<?php if( $slutsalt2 ): ?>
					<div class="knapp">	
						<?php echo $datum2; ?>
						<?php if( $slutdatum2 ): ?>
							– <?php echo $slutdatum2; ?>
						<?php endif; ?>&bull; <?php echo $stad2; ?> <span class="slutsalt">(fullbokat)</span>		
					</div>
				<?php endif; ?>			
				<?php if( !$slutsalt2 ): ?>
					<a target="_blank" href="<?php echo $lank2; ?>">
						<?php echo $datum2; ?>
						<?php if( $slutdatum2 ): ?>
							– <?php echo $slutdatum2; ?>
						<?php endif; ?>&bull; <?php echo $stad2; ?> 			
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
					<a target="_blank" href="<?php echo $lank3; ?>">
						<?php echo $datum3; ?>
						<?php if( $slutdatum3 ): ?>
							– <?php echo $slutdatum3; ?>
						<?php endif; ?>&bull; <?php echo $stad3; ?>
					</a>
				<?php endif; ?>					
			<?php endif; ?>				
			
		</div>
		<?php echo $wysiwyg; ?>	
	</div>
<?php endif; ?>				

	<header id="masthead" class="<?php echo is_singular() && twentynineteen_can_show_post_thumbnail() ? 'site-header featured-image' : 'site-header'; ?>" style="background-image: url('<?php the_field('bild'); ?>');">

			<div class="site-branding-container">
				<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>
			</div><!-- .site-branding-container -->

			<?php if ( is_singular() && twentynineteen_can_show_post_thumbnail() ) : ?>
				<div class="site-featured-image">
					<?php
						twentynineteen_post_thumbnail();
						the_post();
						$discussion = ! is_page() && twentynineteen_can_show_post_thumbnail() ? twentynineteen_get_discussion_data() : null;

						$classes = 'entry-header';
					if ( ! empty( $discussion ) && absint( $discussion->responses ) > 0 ) {
						$classes = 'entry-header has-discussion';
					}
					?>
					<div class="<?php echo $classes; ?>">
						<?php get_template_part( 'template-parts/header/entry', 'header' ); ?>
						<div class="beskrivning"><p><?php the_excerpt();?></p></div>
					</div><!-- .entry-header -->
					
					<?php rewind_posts(); ?>
				</div>
			<?php endif; ?>
			
<?php /**
<?php if( get_field('bild') ): ?>
    <img src="<?php the_field('bild'); ?>" />
<?php endif; ?>		
	*/	?>
		
		
		</header><!-- #masthead -->

	
	
	<div id="content" class="site-content">
