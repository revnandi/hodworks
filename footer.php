    </main>

    <footer class="c-footer">
        <div class="c-footer__inner">
            <?php if(is_page(101)): ?>
                <div class="c-footer__supporters c-footer__supporters--alt">
                    <?php the_field('company_page_text', 'option'); ?>
                </div>
            <?php else: ?>
                <div class="c-footer__supporters">
                    <?php the_field('text', 'option'); ?>
                </div>
            <?php endif; ?>
            <div class="c-footer__bottom">
                <div class="c-footer__link">
                    <a href="<?php the_field('off', 'option'); ?>" class="c-footer__link" target="_blank">Off
                        Alapítvány</a>
                </div>
                <ul class="c-footer__list">
                    <li class="c-footer__list-item">
                        <a href="<?php the_field('facebook', 'option'); ?>" class="c-footer__link"
                            target="_blank">FACEBOOK</a>
                    </li>
                    <li class="c-footer__list-item">
                        <a href="<?php the_field('instagram', 'option'); ?>" class="c-footer__link"
                            target="_blank">INSTAGRAM</a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>

    <?php wp_footer() ?>
    </body>

    </html>