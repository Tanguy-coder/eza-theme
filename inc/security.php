<?php
// Sécurité : Masquer les erreurs de connexion
function eza_no_wordpress_errors() {
    return __("Erreur d'authentification", 'eza_architecture');
}
add_filter('login_errors', 'eza_no_wordpress_errors');

// Sécurité : Désactiver la découverte des noms d'utilisateur XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// Sécurité : Limiter les tentatives de connexion
function eza_check_attempted_login($user, $username, $password) {
    if (get_transient('attempted_login')) {
        $datas = get_transient('attempted_login');
        if ($datas['tried'] >= 3) {
            $until = get_option('_transient_timeout_' . 'attempted_login');
            $time = eza_time_to_go($until);
            return new WP_Error('too_many_tried', sprintf(__('<strong>ERREUR</strong>: Trop de tentatives de connexion. Veuillez réessayer dans %1$s.', 'eza_architecture'), $time));
        }
    }
    return $user;
}
add_filter('authenticate', 'eza_check_attempted_login', 30, 3);

function eza_login_failed($username) {
    if (get_transient('attempted_login')) {
        $datas = get_transient('attempted_login');
        $datas['tried']++;
        if ($datas['tried'] <= 3)
            set_transient('attempted_login', $datas, 300);
    } else {
        $datas = array(
            'tried' => 1
        );
        set_transient('attempted_login', $datas, 300);
    }
}
add_action('wp_login_failed', 'eza_login_failed', 10, 1);

function eza_time_to_go($timestamp) {
    $current_time = current_time('timestamp');
    $diff = $timestamp - $current_time;

    if ($diff <= 0) {
        return __('quelques secondes', 'eza_architecture');
    }

    $periods = array(
        array(60 * 60 * 24 * 365, __('année', 'eza_architecture'), __('années', 'eza_architecture')),
        array(60 * 60 * 24 * 30, __('mois', 'eza_architecture'), __('mois', 'eza_architecture')),
        array(60 * 60 * 24 * 7, __('semaine', 'eza_architecture'), __('semaines', 'eza_architecture')),
        array(60 * 60 * 24, __('jour', 'eza_architecture'), __('jours', 'eza_architecture')),
        array(60 * 60, __('heure', 'eza_architecture'), __('heures', 'eza_architecture')),
        array(60, __('minute', 'eza_architecture'), __('minutes', 'eza_architecture')),
        array(1, __('seconde', 'eza_architecture'), __('secondes', 'eza_architecture'))
    );

    foreach ($periods as $period) {
        $count = floor($diff / $period[0]);
        if ($count > 0) {
            return $count . ' ' . _n($period[1], $period[2], $count, 'eza_architecture');
        }
    }
}

// Sécurité : Désactiver l'API REST pour les utilisateurs non connectés
add_filter('rest_authentication_errors', function($result) {
    if (!empty($result)) {
        return $result;
    }
   /* if (!is_user_logged_in()) {
        return new WP_Error('rest_not_logged_in', __('Vous n\'êtes pas connecté.', 'eza_architecture'), array('status' => 401));
    }*/
    return $result;
});

// Sécurité : Ajouter des en-têtes de sécurité
function eza_add_security_headers() {
    header("X-XSS-Protection: 1; mode=block");
    header("X-Frame-Options: SAMEORIGIN");
    header("X-Content-Type-Options: nosniff");
    header("Referrer-Policy: strict-origin-when-cross-origin");
    header("Permissions-Policy: geolocation=(), microphone=()");
}
add_action('send_headers', 'eza_add_security_headers');