<footer class="<?php echo is_front_page() ? 'footer-fixed' : 'footer-normal'; ?>">
    <a>&copy; <?php echo date('Y'); ?> Ezaachitectures. Tous droits réservés</a>
    <div class="footer-links">
        <a href="<?php echo site_url('/'); ?>">Glossaire</a>
        <a href="<?php echo site_url('/'); ?>">Mentions légales</a>
        <a href="<?php echo site_url('/'); ?>">Politique de confidentialité</a>
        <a href="<?php echo site_url('/'); ?>">Cookies</a>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
