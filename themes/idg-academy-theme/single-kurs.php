<?php
/**
 * The template for displaying all 'kurs' custom post
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">
			<?php

/* Start the Loop */
while (have_posts()):
    the_post();
    
    get_template_part('template-parts/content/content', 'kurs');
    
    if (is_singular('attachment')) {
        // Parent post navigation.
        the_post_navigation(array(
            /* translators: %s: parent post link */
            'prev_text' => sprintf(__('<span class="meta-nav">Published in</span><span class="post-title">%s</span>', 'twentynineteen'), '%title')
        ));
    } elseif (is_singular('post')) {
        // Previous/next post navigation.
        the_post_navigation(array(
            'next_text' => '<span class="meta-nav" aria-hidden="true">' . __('Next Post', 'twentynineteen') . '</span> ' . '<span class="screen-reader-text">' . __('Next post:', 'twentynineteen') . '</span> <br/>' . '<span class="post-title">%title</span>',
            'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __('Previous Post', 'twentynineteen') . '</span> ' . '<span class="screen-reader-text">' . __('Previous post:', 'twentynineteen') . '</span> <br/>' . '<span class="post-title">%title</span>'
        ));
    }
    
    // If comments are open or we have at least one comment, load up the comment template.
    if (comments_open() || get_comments_number()) {
        comments_template();
    }
endwhile; // End of the loop.
?>

		</main><!-- #main -->
	</section><!-- #primary -->


<!-- lista kurserna här utanför stajlade .entry-content -->

<div class="kurslista-container" id="kurser">
	<h3>Upptäck våra andra utbildningar:</h3>	
<div class="kurslista">
<?php
setlocale(LC_TIME, 'sv_SE');

// Set the arguments for the query

$args = array(
    'numberposts' => -1, // -1 is for all
    'post_type' => 'kurs', // or 'post', 'page'
    'orderby' => 'title', // or 'date', 'rand'
    'order' => 'ASC' // or 'DESC'
    //'category' 		=> $category_id,
    //'exclude'		=> get_the_ID()
    // ...
    // http://codex.wordpress.org/Template_Tags/get_posts#Usage
);

// Get the posts
$myposts = get_posts($args);

// If there are posts
if ($myposts):
// Loop the posts
    foreach ($myposts as $mypost):
	    $check= get_the_title($mypost->ID);
    if ($check!="Skräddarsydda kurser") {
?>
  <div class="kurskort-wrapper">
	<a href="<?php
        echo get_permalink($mypost->ID);
?>">
	<div class="kurskort">
    <!-- Image -->   
    <?php
        echo get_the_post_thumbnail($mypost->ID);
?>

    <!-- Content -->
      <h4><?php
        echo get_the_title($mypost->ID);
?></h4>
<div class="utdrag"><p><?php
        echo get_the_excerpt($mypost->ID);
	?></p></div>

	<!-- kurstillfälle 1 -->
<div class="datum">
	<p>
<?php
        $custom_fields   = get_post_custom($mypost->ID);
        $my_custom_field = $custom_fields['datum'];
        foreach ($my_custom_field as $key => $value) {
            if (!empty($value)) {
?>
		<span class="plats">
<?php
                $stad = $custom_fields['stad'];
                echo implode($stad);
                echo ":";
?>
</span>
<?php
                echo strftime("%e %B", strtotime("$value"));
				$my_custom_field = $custom_fields['slutdatum'];
                foreach ($my_custom_field as $key => $value) {
                    if (!empty($value)) {
                        echo " –";
                        echo strftime("%e %B", strtotime("$value"));
                    }
                }
                echo "<br />";
            }
        }
?>
<!-- kurstillfälle 2 -->
<?php
        $custom_fields   = get_post_custom($mypost->ID);
        $my_custom_field = $custom_fields['datum2'];
        foreach ($my_custom_field as $key => $value) {
            if (!empty($value)) {
?>
		<span class="plats">
<?php
                $stad = $custom_fields['stad2'];
                echo implode($stad);
                echo ":";
?>
</span>
<?php
                echo strftime("%e %B", strtotime("$value"));
                $my_custom_field = $custom_fields['slutdatum2'];
                foreach ($my_custom_field as $key => $value) {
                    if (!empty($value)) {
                        echo " –";
                        echo strftime("%e %B", strtotime("$value"));
                    }
                }
                echo "<br />";
            }
        }
?>
<!-- kurstillfälle 3 -->
<?php
        $custom_fields   = get_post_custom($mypost->ID);
        $my_custom_field = $custom_fields['datum3'];
        foreach ($my_custom_field as $key => $value) {
            if (!empty($value)) {
?>
		<span class="plats">
<?php
                $stad = $custom_fields['stad3'];
                echo implode($stad);
                echo ":";
?>
</span>
<?php
                echo strftime("%e %B", strtotime("$value"));
				$my_custom_field = $custom_fields['slutdatum3'];
                foreach ($my_custom_field as $key => $value) {
                    if (!empty($value)) {
                        echo " –";
                        echo strftime("%e %B", strtotime("$value"));
                    }
                }
                echo "<br />";
            }
        }
?>
	</p>

    </div> <!-- datum -->   
  </div> <!-- kurskort -->
		</a>
</div> <!-- kurskort-wrapper --> 
  <?php }
    endforeach;
    wp_reset_postdata();
?>
<?php
endif;
?>
	
<?php
// Get the posts
$myposts = get_posts($args);

// If there are posts, ONLY ”Skräddarsydda kurser”
if ($myposts):
// Loop the posts
    foreach ($myposts as $mypost):
    $check= get_the_title($mypost->ID);
    if ($check=="Skräddarsydda kurser") {
?>
  <div class="kurskort-wrapper">
	<a href="<?php
        echo get_permalink($mypost->ID);
?>">
	<div class="kurskort">
    <!-- Image -->   
    <?php
        echo get_the_post_thumbnail($mypost->ID);
?>

    <!-- Content -->
      <h4><?php
        echo get_the_title($mypost->ID);
?></h4>
<div class="utdrag"><p><?php
        echo get_the_excerpt($mypost->ID);
	?></p></div>

	<!-- kurstillfälle 1 -->
<div class="datum">
	<p>
<?php
        $custom_fields   = get_post_custom($mypost->ID);
        $my_custom_field = $custom_fields['datum'];
        foreach ($my_custom_field as $key => $value) {
            if (!empty($value)) {
?>
		<span class="plats">
<?php
                $stad = $custom_fields['stad'];
                echo implode($stad);
                echo ":";
?>
</span>
<?php
                echo strftime("%e %B", strtotime("$value"));
				$my_custom_field = $custom_fields['slutdatum'];
                foreach ($my_custom_field as $key => $value) {
                    if (!empty($value)) {
                        echo " –";
                        echo strftime("%e %B", strtotime("$value"));
                    }
                }
                echo "<br />";
            }
        }
?>
<!-- kurstillfälle 2 -->
<?php
        $custom_fields   = get_post_custom($mypost->ID);
        $my_custom_field = $custom_fields['datum2'];
        foreach ($my_custom_field as $key => $value) {
            if (!empty($value)) {
?>
		<span class="plats">
<?php
                $stad = $custom_fields['stad2'];
                echo implode($stad);
                echo ":";
?>
</span>
<?php
                echo strftime("%e %B", strtotime("$value"));
                $my_custom_field = $custom_fields['slutdatum2'];
                foreach ($my_custom_field as $key => $value) {
                    if (!empty($value)) {
                        echo " –";
                        echo strftime("%e %B", strtotime("$value"));
                    }
                }
                echo "<br />";
            }
        }
?>
<!-- kurstillfälle 3 -->
<?php
        $custom_fields   = get_post_custom($mypost->ID);
        $my_custom_field = $custom_fields['datum3'];
        foreach ($my_custom_field as $key => $value) {
            if (!empty($value)) {
?>
		<span class="plats">
<?php
                $stad = $custom_fields['stad3'];
                echo implode($stad);
                echo ":";
?>
</span>
<?php
                echo strftime("%e %B", strtotime("$value"));
				$my_custom_field = $custom_fields['slutdatum3'];
                foreach ($my_custom_field as $key => $value) {
                    if (!empty($value)) {
                        echo " –";
                        echo strftime("%e %B", strtotime("$value"));
                    }
                }
                echo "<br />";
            }
        }
?>
	</p>

    </div> <!-- datum -->   
  </div> <!-- kurskort -->
		</a>
</div> <!-- kurskort-wrapper --> 
  <?php
    }
    endforeach;
    wp_reset_postdata();
?>
<?php
endif;
?>	
	
</div> <!-- kurslista -->  
</div> <!-- kurslista-container -->  


<?php
get_footer();
