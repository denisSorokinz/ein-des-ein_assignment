<?= get_header(); ?>

<body>
    <main>
        <section class="section section__news">
            <div class="container">
                <h2 class="section__heading">News</h2>
                <!-- <ul class="section__categories categories--list">
                    <li class="categories__item">All</li>
                    <li class="categories__item">Category 1</li>
                    <li class="categories__item">Category 2</li>
                </ul> -->
                <?php
                $taxonomy = 'news_category';

                $terms = get_terms($taxonomy, array());
                echo '<ul class="section__categories categories--list">';

                echo '<li class="categories__item" data-slug="all"><a href="' . get_home_url() . '">All</a></li>';
                foreach ($terms as $term) {
                    $term_link = get_term_link($term, $taxonomy);
                    if (is_wp_error($term_link))
                        continue;
                    echo '<li class="categories__item" data-slug=' . $term->slug . '><a href="' . $term_link . '">' . $term->name . '</a></li>';
                }
                echo '</ul>';
                ?>
                <ul class="section__cards">
                    <?php
                        foreach ($terms as $term) :
                            $args = array(
                                'post_type' => 'news',
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => $taxonomy,
                                        'field' => 'slug',
                                        'terms' => $term->slug
                                    )
                                )
                            );

                            global $wp_query;
                            $wp_query = new WP_Query($args);
                    ?>
                        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                                <?php get_template_part('template-parts/news-list-item'); ?>

                            <?php endwhile;
                        else : ?>
                            <p><?php esc_html_e('Sorry, no posts matched your criteria.'); ?></p>
                        <?php endif; ?>
                    <?php
                        endforeach;
                    ?>
                </ul>
            </div>
        </section>
        <section class="section section__events">
            <div class="container">
                <h2 class="section__heading" id="target">Events</h2>
                <div class="section__categories categories--select">
                    <select>
                        <?php
                            echo '<option data-slug="all">all</option>';
                            foreach ($terms as $term) {
                                $term_link = get_term_link($term, $taxonomy);
                                if (is_wp_error($term_link))
                                    continue;
                                echo '<option value="' . $term->slug . '" data-slug=' . $term->slug . '>' . $term->name . '</option>';
                            }
                        ?>
                    </select>
                </div>
                <ul class="section__cards">
                    <?php
                        foreach ($terms as $term) :
                            $args = array(
                                'post_type' => 'news',
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => $taxonomy,
                                        'field' => 'slug',
                                        'terms' => $term->slug
                                    )
                                )
                            );

                            global $wp_query;
                            $wp_query = new WP_Query($args);
                    ?>
                        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                                <?php get_template_part('template-parts/news-list-item'); ?>

                            <?php endwhile;
                        else : ?>
                            <p><?php esc_html_e('Sorry, no posts matched your criteria.'); ?></p>
                        <?php endif; ?>
                    <?php
                        endforeach;
                    ?>
                </ul>
            </div>
        </section>
    </main><img class="bubbles__left" src="<?= get_template_directory_uri(); ?>/assets/images/9c5c1c4ef6150be289c523fa01efafb0.svg"><img class="bubbles__right" src="<?= get_template_directory_uri(); ?>/assets/images/6bd67798ec3616861ac7f2cd8f0e5bc9.svg">
</body>

</html>