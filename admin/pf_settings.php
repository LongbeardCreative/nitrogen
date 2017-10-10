<?php

function pf_settings_callback() {

    $args = array(
        'post_type'              => 'page',
        'orderby'                => 'menu_order',
        'order'                  => 'ASC',
        'no_found_rows'          => true,
        'update_post_term_cache' => false
    );

    $list = new WP_Query( $args );
    ?>

    <div id="profectus_wrap">
        <?php if ( $list->have_posts() ) : ?>
            <ul id="post_loop">
                <?php while ( $list->have_posts() ) : $list->the_post(); ?>
                    <li id="<?php the_id(); ?>"><?php the_title(); ?></li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>
    </div>
    <?php
}
