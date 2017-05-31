<?php
    /*
    Template Name: Archivo de noticias
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
                        if( !!$post->post_content ){
                            echo '<div class="page-content">';
                            the_content();
                            echo '</div>';
                        }

										?>
							<div class="container full-container" data-equalize="target" data-mq="vertical-tablet-down" data-eq-target=".mas-reciente">
								<div class="grid-12 no-gutter-left no-gutter-mobile no-gutter-smalltablet">
									<!--//switch_to_blog(2); //enlinea-->
									<div class="content-box gris-regular">
										<div class="content-box-body parent">
											<div class="grid-12">
												<?php
																						$tax_query = array(array(
																										'taxonomy' => 'institutcion',
																										'field' => 'slug',
																										'terms' => 'admision'
																						));

																						$args = array(
																								'post_type' => 'post',
																								'posts_per_page' => 25,
																								'tax_query'=>$tax_query,
																								'orderby' => 'date',
																								'order' => 'DESC'
																						);

																						$noticias = new WP_Query($args);
																						if ($noticias->have_posts()) {
																								while ($noticias->have_posts()) :
																										$noticias->the_post();

																										$category = get_the_category();
																										$category = $category[0]->name;
																										$title = $post->post_title;
																										$attr_img = array('class' => 'elastic-img', 'alt' => $title);
																										$img = get_the_post_thumbnail($post->ID, 'regular-medium-tiny', $attr_img);
																										$link = get_permalink($post->ID);
																										$content = cut_string_to($post->post_content, 150);
																										$user = get_user_by('id', $post->post_author);
																										$user = $user->data->user_nicename;
																								   $date = get_format_date($post->post_date);
																										?>
													<article class="article news" style="overflow:hidden; margin-bottom:40px;">
														<div class="grid-4 no-gutter-left">
															<?php echo $img; ?>
														</div>
														<div class="grid-8 no-gutter-right">
															<em><?php echo $category; ?></em>
															<h3>
																<a class="external-link link-rollover-corporativo" href="<?php echo $link; ?>" title="<?php echo $title; ?>">
																	<?php echo $title; ?>
																</a>
															</h3>
															<p>
																<?php echo $content; ?>
															</p>
															<em>Por DEC Santo Tomás <?php echo $date; ?></em>
														</div>
													</article>

													<?php
														endwhile;
													}
													wp_reset_query();
													?>
											</div>
										</div>
										<!--restore_current_blog();-->
									</div>
								</div>
							</div>
					</div>
				</section>
			</div>
		</section>
	</main>

	<?php get_footer(); ?>