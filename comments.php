<?php
if (post_password_required()) {
    return;
}
if (have_comments()) : ?>
    <h3><?php comments_number('Aucun commentaire', 'Un commentaire', '% commentaires'); ?></h3>
    <ul>
        <?php wp_list_comments(); ?>
    </ul>
<?php endif; ?>
<?php comment_form(); ?>
