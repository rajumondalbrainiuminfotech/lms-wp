<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if(isset($_GET['pdf'])){
    ?>
  <!DOCTYPE html>
  <html <?php language_attributes(); ?>>
  <head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <?php
      wp_head();
  ?>
  </head>
  <body <?php body_class(); ?>>
  <?php
}else{
    get_header(vibe_get_header());    
}

if ( have_posts() ) : while ( have_posts() ) : the_post();

$print = get_post_meta($post->ID,'vibe_print',true);


$class = get_post_meta($post->ID,'vibe_custom_class',true);
$css = get_post_meta($post->ID,'vibe_custom_css',true);

$bgimg_id = apply_filters('wplms_certificate_template_style',get_post_meta($post->ID,'vibe_background_image',true),$post->ID);


if(!empty($bgimg_id)){
  $bgimg = wp_get_attachment_info( $bgimg_id );
}


$width = get_post_meta(get_the_ID(),'vibe_certificate_width',true);
$height = get_post_meta(get_the_ID(),'vibe_certificate_height',true);

$certificate_class = apply_filters('wplms_certificate_class','');

$style = (is_numeric($width)?'width:'.$width.'px;':'').''.(is_numeric($height)?'height:'.$height.'px':'');
do_action('wplms_certificate_before_full_content');
?>
<section id="certificate" <?php echo 'style="'.apply_filters('wplms_certificate_template_style',$style).'"'; ?> <?php echo (empty($certificate_class)?'':'class="'.$certificate_class.'"'); ?>>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <?php do_action('wplms_certificate_before_content'); ?>
                    <div class="extra_buttons">
                        <?php do_action('wplms_certificate_extra_buttons');
                        if(vibe_validate($print)){
                            echo '<a href="#" class="certificate_close"><i class="fa fa-times"></i></a>';
                            echo '<a href="#" class="certificate_print"><i class="fa fa-print"></i></a>';
                            echo '<a href="#" class="certificate_pdf"><i class="fa fa-file-pdf-o"></i></a>';
                            echo '<a href="#" class="certificate_download"><i class="fa fa-download"></i></a>';
                        }
                        ?>
                    </div>
                    <div class="certificate_content <?php echo vibe_sanitizer($class,'text');?>" style="<?php
                            if(isset($bgimg_id) && $bgimg_id && isset($bgimg['src']))
                                echo 'background:url('.$bgimg['src'].');';
                        ?>" <?php 
                        
                        if(is_numeric($width))
                            echo 'data-width="'.$width.'" ';
                        
                        if(is_numeric($height))
                            echo 'data-height="'.$height.'" ';
                        ?>>
                        <?php echo (isset($css)?'<style>'.$css.'</style>':'');?>
                        <?php
                            the_content(); 
                        ?>
                         <?php do_action('wplms_certificate_after_content'); ?>
                    </div>
                </div>
                <?php
                
                endwhile;
                endif;
                ?>
            </div>
        </div>
    </div>
</section>
<?php
do_action('wplms_certificate_after_full_content');

if(isset($_GET['pdf'])){
    wp_footer();
  ?>   
  </body>
  </html>
  <?php
}else{
    get_footer(vibe_get_footer());
}


?>