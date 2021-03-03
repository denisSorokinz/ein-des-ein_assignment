<li class="cards__item" id="card">
    <article class="article">
        <figure class="article__card"><?php the_post_thumbnail('full', array('class' => 'card__image')); ?>
            <figcaption class="card__description">
                <span class="description__span"><?= get_the_date(); ?></span>
                <span class="description__span">
                    <?php
                        $terms = wp_get_post_terms(get_the_ID(), 'news_category');
                        foreach ($terms as $term) {
                            echo $term->name . ' ';
                        }
                    ?>
                </span>
                <h3 class="card__heading"><?= get_field("event_content") ?></h3><a class="card__reference" href="<?php the_permalink(get_the_ID()); ?>">Learn more</a>
            </figcaption>
        </figure>
    </article>
</li>