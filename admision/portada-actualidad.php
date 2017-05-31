<?php
/*Template name: Portadilla Actualidad*/
get_header();
?>

<main id="main-content">
    <section class="container featured-content-holder">
        <h1 class="page-content__title">Actualidad</h1>
        <?php 
            $portada = get_field('incluidos_portada');
            $cont = 0;
            if($portada){
                foreach($portada as $news){
                    $cont++;
                    $cat = get_the_category($news->ID);
                    $cat = $cat[0]->name;
                    $exclude[] = $news->ID;
                    if($cont==1){
                        $out .=     '<div class="featured-box">';
                        $out .=         '<div class="grid-6 grid-smalltablet-12 no-gutter-smalltablet no-gutter-mobile">';
                        $out .=             '<article class="featured-box--feature">';
                        $out .=                 '<figure class="featured-box__figure"> <a href="'.get_permalink($news->ID).'">';
                        $out .=                     get_the_post_thumbnail( $news);
                        $out .=                 '</a></figure>';
                        $out .=                 '<div class="featured-box__body">';
                        $out .=                     '<p class="featured-box__cat">'.$cat.'</p>';
                        $out .=                     '<h2 class="featured-box__title featured-box__title--feature"><a href="'.get_permalink($news->ID).'" class="simple-link">'.$news->post_title.'</a></h2>';
                        $out .=                     '<p class="featured-box__excerpt">'.$news->post_excerpt.'</p>';
                        $out .=                     '<p class="featured-box__date">'.$news->post_date.'</p>';
                        $out .=                 '</div>';   
                        $out .=             '</article>';
                        $out .=         '</div>';
                    }else{
                        $second .=             '<article class="featured-box--regular">';
                        $second .=                 '<div class="grid-4 grid-smalltablet-12">';
                        $second .=                     '<figure class="featured-box__figure"> <a href="'.get_permalink($news->ID).'">'.get_the_post_thumbnail($news).'</a></figure>';
                        $second .=                 '</div>';
                        $second .=                 '<div class="grid-8 grid-smalltablet-12">';
                        $second .=                         '<div class="featured-box__body">';
                        $second .=                             '<p class="featured-box__cat">'.$cat.'</p>';
                        $second .=                             '<h2 class="featured-box__title featured-box__title--feature"><a href="'.get_permalink($news->ID).'" class="simple-link">'.$news->post_title.'</a></h2>';
                        $second .=                             '<p class="featured-box__excerpt">'.$news->post_excerpt.'</p>';
                        $second .=                             '<p class="featured-box__date">Publicado el'.get_long_date($news->post_date).'</p>';
                        $second .=                         '</div>';
                        $second .=                 '</div>';
                        $second .=             '</article>';
                    }
                }
                $end .=         '<div class="grid-6 grid-smalltablet-12 no-gutter-smalltablet no-gutter-mobile">';
                $end .=             $second;
                $end .=         '</div>';
                $end .=     '</div>';
                echo $out . $end;
            }
         ?>
    </section>

    <?php
    $display = 5;
    $page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
    $offset = ( $page - 1 ) * $display;
    $argsnews = array(
            'post_type' => 'post',
            'number' => $display,
            'orderby' => 'date',
			'order' => 'DESC',
            'page' => $page,
            'offset' => $offset,
            'post__not_in' => $exclude
            );
    $noticias = new WP_Query($argsnews);
    ?>

    <section class="container">
        <h2 class="regular-content-box-title">Lo más reciente</h2>
        <div class="grid-9 grid-smalltablet-12 no-gutter-left">
            <div class="archive-list">
                <?php
                if($noticias->have_posts()){
                    while($noticias->have_posts()):
                        $noticias -> the_post();
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