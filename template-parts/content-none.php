<section class="no-results not-found">
    <header class="page-header">
        <h1 class="page-title"><?php esc_html_e('Rien trouvé', 'eza_architecture'); ?></h1>
    </header>

    <div class="page-content">
        <?php
        if (is_home() && current_user_can('publish_posts')) :
            printf(
                '<p>' . wp_kses(
                    __('Prêt à publier votre premier article ? <a href="%1$s">Commencez ici</a>.', 'eza_architecture'),
                    array(
                        'a' => array(
                            'href' => array(),
                        ),
                    )
                ) . '</p>',
                esc_url(admin_url('post-new.php'))
            );
        elseif (is_search()) :
            ?>
            <p><?php esc_html_e('Désolé, mais rien ne correspond à vos termes de recherche. Veuillez réessayer avec des mots-clés différents.', 'eza_architecture'); ?></p>
            <?php
            get_search_form();
        else :
            ?>
            <p><?php esc_html_e('Il semble que nous ne puissions pas trouver ce que vous cherchez. Peut-être que la recherche peut aider.', 'eza_architecture'); ?></p>
            <?php
            get_search_form();
        endif;
        ?>
    </div>
</section>