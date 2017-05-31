<div class="container full-container" data-equalize="target" data-mq="vertical-tablet-down" data-eq-target=".mas-reciente">
		<div class="grid-12 grid-smalltablet-12 no-gutter no-gutter-mobile no-gutter-smalltablet">
				
				<div class="content-box gris-regular">
                <h2 class="content-box-title newbermuda">
					<a class="tag full icon globe" href="/noticias/" rel="section" title="Ir a noticias">Actualidad</a>
				</h2>
					<!--<a href="<?php echo home_url(); ?>" title="Ver más noticias en Santo Tomás en Línea" class="external-link archive-link text-bold link-rollover-complementario">Ver más noticias</a>-->
						<div class="content-box-body parent">
								<div class="grid-6 grid-smalltablet-12">
								<?php
								// $tax_query = array(array(
								// 				'taxonomy' => 'institutcion',
								// 				'field' => 'slug',
								// 				'terms' => 'admision'
								// ));
								$args = array(
									'post_type' => 'post',
									'posts_per_page' => 4,
									// 'tax_query'=>$tax_query,
									'orderby' => 'date',
									'order' => 'DESC',
									'post_status' => 'publish'
								);

								$noticias = new WP_Query($args);
								//printMe($noticias);
								$cont = 1;

								if ($noticias->have_posts()) {
									while ($noticias->have_posts()) :
										$noticias->the_post();

										$category = get_the_category();
										$catid = $category[0]->cat_ID;
										$category = $category[0]->name;
										$title = $post->post_title;
										$attr_img = array('class' => 'elastic-img', 'alt' => $title);
										$img = get_the_post_thumbnail($post->ID, 'regular-medium-tiny', $attr_img);
										$link = get_permalink($post->ID);
										$content = cut_string_to($post->post_excerpt, 150);
										$user = get_user_by('id', $post->post_author);
										$user = $user->data->user_nicename;
									   $date = get_format_date($post->post_date);
										?>
										<article class="article mas-reciente">
											<div class="grid-4 grid-smalltablet-6 grid-mobile-4 no-gutter-left no-gutter-mobile">
												<?php echo $img; ?>
											</div>
											<div class="grid-8 grid-smalltablet-6 grid-mobile-4 no-gutter-right no-gutter-mobile">
												<a href="<?php echo get_permalink($catid); ?>" class="simple-category"><?php echo $category ?></a>
												<h3><a class="simple-link" href="<?php echo $link; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></h3>
												<p><?php echo $content; ?></p>
												<em>Publicado el <?php echo $date; ?></em>
											</div>
										</article>
										<?php
											if ($cont % 2 == 0) {
												echo '</div><div class="grid-6 grid-smalltablet-12">';
												$cont = 1;
											} else {
												$cont++;
											}
										endwhile;
										}
										wp_reset_query();
										?>
								</div>
						</div>
					<div class="see-more">
						<a href="<?php echo home_url(); ?>" title="Ver más noticias" class="mobile-archive-link">Ver más noticias</a>
					</div>
						
				</div>
		</div>
</div>
