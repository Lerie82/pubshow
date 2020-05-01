<?php
/**
 * The template for displaying single posts and pages.
 *
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>

<main id="site-content" role="main">

<?php
if(have_posts())
{
	while(have_posts())
	{
	    if(is_single())
	    {
            the_post();
		    include(plugin_dir_path(__FILE__).'templates/release.php');
	    }
	}
}
?>

</main><!-- #site-content -->

<?php get_footer(); ?>
