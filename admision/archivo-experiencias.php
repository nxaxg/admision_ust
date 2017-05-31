<?php
    /*
    Template Name: Experiencia Santo Tomás
    */

    get_header();
    the_post();
?>

<main id="main-content" class="main-content" role="main">
    <?php echo generate_breadcrumbs(); ?>
    <section class="page-holder">
        <div class="container">            
            <section class="page-body parent">
                <aside class="regular-sidebar grid-3 no-gutter-left hide-on-vertical-tablet-down">
                    <?php get_sidebar(); ?>
                </aside>
                <div class="grid-9 grid-smalltablet-12 no-gutter-right no-gutter-smalltablet">
                    <h1 class="single-page-title">
                        <?php the_title(); ?>
                    </h1>

                    <?php
                        the_post_thumbnail('regular-big', array(
                            'class' => 'elastic-img cover'
                        ));


                        if( !!$post->post_content ){
                            echo '<div class="page-content">';
                            the_content();
                            echo '</div>';
                        }
                    ?>

                    <div class="parent" data-masonry-grid>
                        <?php
                            $exp = new WP_Query(array(
                                'posts_per_page' => -1,
                                'post_type' => 'experiencia'
                            ));

                            if( $exp->have_posts() ){
                                while( $exp->have_posts() ){
                                    $exp->the_post();
                                    echo generate_testimonial_module( $post );
                                }
                            }
                        ?>
                    </div>
                </div>
            </section>
        </div>
    </section>
</main>

<?php get_footer(); ?>