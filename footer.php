<footer class="<?php echo is_front_page() ? 'footer-fixed' : 'footer-normal footer-black'; ?>">
    <p>&copy; <?php echo date('Y'); ?> Eaachitectures. Tous droits réservés</p>
    <div class="footer-links">
        <a href="<?php echo site_url('/glossaire'); ?>">Glossaire</a>
        <a href="<?php echo site_url('/mentions-legales'); ?>">Mentions légales</a>
        <a href="<?php echo site_url('/politique-de-confidentialite'); ?>">Politique de confidentialité</a>
        <a href="<?php echo site_url('/cookies'); ?>">Cookies</a>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
