<?php
/*Template name: Portadilla general*/
get_header();
?>

<main id="main-content">

<?php
$display = 10;
$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
$offset = ( $page - 1 ) * $display;
$argsnews = array(
            'post_type' => 'post',
            'posts_per_page' => $display,
            'orderby' => 'date',
			'order' => 'DESC',
            'page' => $page,
            'offset' => $offset
            );
$noticias = new WP_Query($argsnews);

$current = $post->ID;
$parent = $post->post_parent;
?>

    <section class="container">

        <h1 class="page-content__title page-content__title--cont">
            <?php
            if($parent){
                echo $parent->post_title . '<span class="page-content__title--subtitle">'.get_the_title().'</span>';
            }else{
                echo get_the_title();
            }
            ?>
        </h1>
        <!--<h1 class="page-title"><?php // the_title(); ?></h2>-->
        <div class="grid-9 grid-smalltablet-12 no-gutter-left">
            <div class="archive-list">
                <?php
                if($noticias->have_posts()){
                    while($noticias->have_posts()):
                    $noticias->the_post();
                        $cat = get_the_category();
                        $cat = $cat[0]->name;
                        $print .= '<article class="featured-box--regular">';
                        $print .=     '<div class="grid-4 grid-smalltablet-12">';
                        $print .=         '<figure class="featured-box__figure"> <a href="'.get_permalink($news->ID).'">';
                        $print .=         get_the_post_thumbnail($post);
                        $print .=         '</a></figure>';
                        $print .=     '</div>';
                        $print .=     '<div class="grid-8 grid-smalltablet-12">';
                        $print .=         '<div class="featured-box__body">';
                        $print .=             '<p class="featured-box__cat">'.$cat.'</p>';
                        $print .=             '<h2 class="featured-box__title featured-box__title--feature">';
                        $print .=                 '<a href="'.get_permalink($post->ID).'" class="simple-link">'.$post->post_title.'</a>';
                        $print .=             '</h2>';
                        $print .=             '<p class="featured-box__excerpt">'.$post->post_excerpt.'</p>';
                        $print .=             '<p class="featured-box__date">Publicado el '.get_long_date($post->post_date).'</p>';
                        $print .=         '</div>';
                        $print .=     '</div>';
                        $print .= '</article>';
                    endwhile;
                    echo $print;
                }
                wp_reset_query();
                ?>
            </div>
            <!--<div class="page-content">
                <?php //echo get_pagination(); ?>
            </div>-->
        </div>
        <div class="grid-3 grid-smalltablet-12 no-gutter-right">
            <?php get_template_part('sidebar-actualidad'); ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>