<?php
get_header();
the_post();

    $out = $printer = '';
    $date = get_format_date($post->post_date);
    $category = get_the_category();
	$catid = $category[0]->cat_ID;
	$category = $category[0]->name;
    $bajada = get_field('bajada');
    $colapsables = get_field('colapsables');
?>
<main id="main-content" class="main-content" role="main">
    <?php echo generate_breadcrumbs(); ?>
    <section class="page-holder">
        <div class="container">
            <section class="page-body page-body--single parent">
                <div class="grid-9 grid-smalltablet-12 no-gutter-left no-gutter-smalltablet">
                    <h1 class="page-title page-title--oswald"><?php the_title(); ?></h1>
                    <div class="page-body__meta-holder">
                        <p class="page-body__date">Publicado el <?php echo $date; ?></p>
                    </div>
                    <figure class="page-body__figure" data-area-name="desktop-page-thumb">
                        <?php
                            the_post_thumbnail('regular-big', array(
                                'class' => 'elastic-img cover',
                                'data-mutable' => 'vertical-tablet-down',
                                'data-desktop-area' => 'desktop-page-thumb',
                                'data-mobile-area' => 'mobile-page-thumb',
                                'data-order' => '1'
                            ));
                        ?>
                    </figure>
                    
                    <div class="page-body__content">
                        <?php
                            echo generate_actions_box_holder( $post);
                            if($bajada){
                        ?>
                            <div class="page-body__excerpt">
                                <?php echo $bajada;?>
                            </div>
                        <?php
                            }
                            the_content();
                        ?>
                        <figure>
                        <?php
                            if( !isset($gallery_shown) || !$gallery_shown ){
                                $galeria = get_field('galeria', $post->ID);
                                if( !empty($galeria) ){
                                    echo generate_regular_gallery_slider( $galeria[0] );
                                }
                            }
                            
                            if($colapsables){
                                $printer = '<div class="page-body__collapse">';
                                foreach($colapsables as $colapse){
                                    $out .= '<div class="page-body__collapse__box">';
                                    $out .=     '<button class="page-body__collapse__button">';
                                    $out .=         $colapse['titulo_colapsable'];
                                    $out .=         '<span class="page-body__collapse__caret">v</span>';
                                    $out .=      '</button>';
                                    $out .=      '<div class="page-body__collapse__body">';
                                    $out .=      $colapse['contenido_colapsable'];
                                    $out .=      '</div>';
                                    $out .= '</div>';
                                }

                                $printer  = '<div class="page-body__collapse">';
                                $printer .= $out;
                                $printer .= '</div>';
                            }
                            echo $printer;
                        ?>
                    </div>
                    <!--more-news-->
                    <div class="continuous-access-box">
                        <div class="grid-6 grid-smalltablet-12 grid-mobile-4 no-gutter always-col">
                            <?php
                                $prev_post = get_adjacent_post( true, '', true );
                                if( !!$prev_post ):
                            ?>
                            <article class="continuous-access prev">
                                <a class="continuous-access-link" href="<?php echo get_permalink($prev_post->ID); ?>" title="Ver  <?php echo get_the_title($prev_post->ID); ?>" rel="prev">
                                 <?php echo get_the_title($prev_post->ID); ?>
                                </a>
                            </article>
                            <?php endif; ?>
                        </div>
                        <div class="grid-6 grid-smalltablet-*12 grid-mobile-4 no-gutter always-col">
                            <?php 
                                $next_post = get_adjacent_post( true, '', false ); 
                                if( !!$next_post ) :
                            ?>
                            <article class="continuous-access next">
                                <a class="continuous-access-link" href="<?php echo get_permalink($next_post->ID); ?>" title="Ver <?php echo get_the_title($next_post->ID); ?>" rel="prev">
                                <?php echo get_the_title($next_post->ID); ?>
                                </a>
                            </article>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <aside class="regular-sidebar grid-3 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">
                    <?php get_sidebar('carreras'); ?>
                </aside>
            </section>
        </div>
    </section>
</main>
<?php get_footer(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('.page-body__collapse__body').hide();
        $('.page-body__collapse__button').click(function(){
            $(this).siblings('.page-body__collapse__body').slideToggle(400);
        });
    });
</script>