<?php get_header() ?>

    <div class="c-staff">
        <div class="c-columns">
            <div class="c-columns__column c-columns__column--green">
                <div class="c-color-box">
                    <div class="c-color-box__inner">
                        <h1>Stáb</h1>
                    </div>
                </div>
            </div>
            <div class="c-columns__column">
                <div class="c-staff__list-container">
                    <ul class="c-staff__list">

                    <?php if ( have_posts() ) : ?>

                        <?php while ( have_posts() ) : the_post(); ?>

                                <li class="c-staff__list-item">
                                    <div class="c-staff__list-item-header">
                                        <h2 class="c-staff__list-item-name"><?php the_title(); ?></h2>

                                        <?php if ( get_field('title') ) : ?>
                                        <div class="c-staff__list-item-title"><?php echo the_field('title')?></div>
                                        <?php endif; ?>

                                    </div>
                                    <div class="c-staff__list-item-description">
                                        <?php the_content(); ?>
                                    </div>
                                </li>

                        <?php endwhile; ?>
                        
                    <?php endif; ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>

<?php get_footer() ?>