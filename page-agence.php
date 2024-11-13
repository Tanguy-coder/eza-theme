<?php
/*
Template Name: Agence
*/
get_header();
?>

<section >
    <div class="social-links-inner">
        <a href="<?php echo esc_url(get_theme_mod('linkedin_url')); ?>"><img src="<?php echo eza_get_icon_url('linkedin.svg'); ?>" alt="LinkedIn"></a>
        <a href="<?php echo esc_url(get_theme_mod('facebook_url')); ?>"><img src="<?php echo eza_get_icon_url('facebook.svg'); ?>" alt="Facebook"></a>
        <a href="<?php echo esc_url(get_theme_mod('instagram_url')); ?>"><img src="<?php echo eza_get_icon_url('instagram.svg'); ?>" alt="Instagram"></a>
        <a href="<?php echo esc_url(get_theme_mod('twitter_url')); ?>"><img src="<?php echo eza_get_icon_url('twitter.svg'); ?>" alt="X"></a>
        <a href="mailto:<?php echo esc_attr(get_theme_mod('email_address')); ?>"><img src="<?php echo eza_get_icon_url('mail.svg'); ?>" alt="Email"></a>
        <a href="<?php echo esc_url(get_theme_mod('video_url')); ?>"><img src="<?php echo eza_get_icon_url('video.svg'); ?>" alt="Video"></a>
    </div>
</section>
<div class="agency-page">
    <?php
    // Contenu avant la section du personnel
    echo '<div class="content-before-personnel">';
    the_content();
    echo '</div>';
    ?>
    <!-- Section Personnel -->
    <div class="agency-personnel">
        <h2>Notre Équipe</h2>
        <div class="personnel-grid">
            <?php
            $personnel = new WP_Query(array('post_type' => 'personnel', 'posts_per_page' => -1));
            while ($personnel->have_posts()) : $personnel->the_post();
                $function = get_field('personnel_function');
                $description = get_field('personnel_description');
                $image = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                ?>
                <div class="personnel-member">
                    <img src="<?php echo esc_url($image); ?>" alt="<?php the_title(); ?>" class="personnel-photo" onclick="openModal('<?php the_ID(); ?>')">
                    <h3><?php the_title(); ?></h3>

                    <!-- Modal Content -->
                    <div id="modal-<?php the_ID(); ?>" class="personnel-modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal('<?php the_ID(); ?>')">&times;</span>
                            <img src="<?php echo esc_url($image); ?>" alt="<?php the_title(); ?>" class="modal-photo">
                            <h3><?php the_title(); ?></h3>
                            <p class="personnel-function"><?php echo esc_html($function); ?></p>
                            <div class="personnel-description"><?php echo wp_kses_post($description); ?></div>
                        </div>
                    </div>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>

    <?php
    // Contenu avant la section du personnel
    echo '<div class="content-before-personnel">';
    the_content();
    echo '</div>';
    ?>

    <!-- Section Slider des Images de l'Agence -->
    <?php
    // Récupération des images de l'agence
    $image_1 = get_field('agency_image_1');
    $image_2 = get_field('agency_image_2');
    $image_3 = get_field('agency_image_3');
    $image_4 = get_field('agency_image_4');
    ?>

    <div class="agency-slider-container">
        <div class="swiper agency-slider">
            <div class="swiper-wrapper">
                <?php if ($image_1): ?>
                    <div class="swiper-slide"><img src="<?php echo esc_url($image_1['url']); ?>" alt="<?php echo esc_attr($image_1['alt']); ?>"></div>
                <?php endif; ?>
                <?php if ($image_2): ?>
                    <div class="swiper-slide"><img src="<?php echo esc_url($image_2['url']); ?>" alt="<?php echo esc_attr($image_2['alt']); ?>"></div>
                <?php endif; ?>
                <?php if ($image_3): ?>
                    <div class="swiper-slide"><img src="<?php echo esc_url($image_3['url']); ?>" alt="<?php echo esc_attr($image_3['alt']); ?>"></div>
                <?php endif; ?>
                <?php if ($image_4): ?>
                    <div class="swiper-slide"><img src="<?php echo esc_url($image_4['url']); ?>" alt="<?php echo esc_attr($image_4['alt']); ?>"></div>
                <?php endif; ?>
            </div>
            <!-- Pagination et navigation -->
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>


    <!-- Initialisation du slider avec Swiper.js -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.agency-slider', {
                slidesPerView: 1,
                loop: true,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                }
            });
        });
    </script>

    <script>
        function openModal(id) {
            document.getElementById('modal-' + id).style.display = 'block';
        }
        function closeModal(id) {
            document.getElementById('modal-' + id).style.display = 'none';
        }
    </script>
</div>

<?php get_footer(); ?>
