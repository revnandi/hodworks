    </main>

    <footer class="c-footer">
        <div class="c-footer__inner">
            <div class="c-footer__supporters">
                <?php the_field('text', 'option'); ?>
            </div>
            <div class="c-footer__bottom">
                <div class="c-footer__link">
                    <a href="<?php the_field('off', 'option'); ?>" class="c-footer__link" target="_blank">Off Alapítvány</a>
                </div>
                <ul class="c-footer__list">
                    <li class="c-footer__list-item">
                        <a href="<?php the_field('facebook', 'option'); ?>" class="c-footer__link" target="_blank">FACEBOOK</a>
                    </li>
                    <li class="c-footer__list-item">
                        <a href="<?php the_field('instagram', 'option'); ?>" class="c-footer__link" target="_blank">INSTAGRAM</a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>

<?php wp_footer() ?>
</body>
</html>