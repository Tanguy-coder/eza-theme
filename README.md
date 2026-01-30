# Eza Architectures - Thème WordPress

Thème WordPress personnalisé développé pour **Eza Architecture**, une agence d'architecture moderne et professionnelle.

## 📋 Description

Ce thème WordPress sur mesure offre une expérience utilisateur optimale pour présenter les projets d'architecture, l'équipe et les informations de l'agence. Il inclut des fonctionnalités avancées telles qu'une carte interactive des projets, des sliders dynamiques, et une interface d'administration personnalisée.

## ✨ Fonctionnalités

### 🎨 Interface Utilisateur
- **Slider Hero** : Carrousel d'images avec support desktop et mobile (jusqu'à 5 slides)
- **Page d'accueil** : Présentation dynamique avec sections partenaires et réseaux sociaux
- **Archive de projets** : Affichage en grille avec carte interactive Leaflet
- **Page projet individuelle** : Galerie d'images avec slider Swiper
- **Page Agence** : Présentation de l'équipe et des informations de l'agence
- **Design responsive** : Optimisé pour tous les appareils

### 🛠️ Fonctionnalités Techniques
- **Types de contenu personnalisés** :
  - `project` : Gestion des projets d'architecture avec métadonnées (localisation GPS, année, description, etc.)
  - `personnel` : Gestion des membres de l'équipe
- **Taxonomies** : Système de thèmes pour catégoriser les projets
- **Champs personnalisés ACF** : Configuration complète via Advanced Custom Fields
- **Customizer WordPress** : Personnalisation des images hero, logos partenaires, liens réseaux sociaux
- **Carte interactive** : Intégration Leaflet pour visualiser les projets sur une carte
- **Animations** : Animations CSS et JavaScript pour une expérience fluide
- **Sécurité** : Mesures de sécurité intégrées (désactivation de l'éditeur de fichiers, sanitization)

## 🚀 Installation

### Prérequis
- WordPress 5.0 ou supérieur
- PHP 7.4 ou supérieur
- Plugin **Advanced Custom Fields (ACF)** activé

### Étapes d'installation

1. **Télécharger le thème**
   ```bash
   cd wp-content/themes/
   git clone https://gitlab.com/Toor96/eza-theme.git ezaarchitectures
   ```

2. **Activer le thème**
   - Aller dans **Apparence > Thèmes** dans l'administration WordPress
   - Cliquer sur **Activer** pour le thème "ezaarchitectures"

3. **Installer les dépendances**
   - Le thème utilise des bibliothèques externes chargées via CDN :
     - Swiper.js (sliders)
     - Leaflet.js (cartes)

4. **Configurer ACF**
   - Installer et activer le plugin **Advanced Custom Fields**
   - Les groupes de champs sont définis dans `inc/acf-fields.php`

5. **Personnaliser le thème**
   - Aller dans **Apparence > Personnaliser**
   - Configurer les images de bannière hero (desktop et mobile)
   - Ajouter les logos et liens des partenaires
   - Configurer les liens des réseaux sociaux

## 📁 Structure du Projet

```
ezaarchitectures/
├── assets/
│   ├── css/
│   │   └── animate.css          # Animations CSS
│   ├── icons/                   # Icônes SVG (réseaux sociaux, etc.)
│   └── js/
│       ├── animations.js        # Scripts d'animation
│       ├── hero-slider.js       # Slider de la page d'accueil
│       ├── project-archive.js   # Logique de l'archive projets
│       └── script.js            # Scripts principaux
├── css/
│   ├── archive-project.css      # Styles de l'archive projets
│   ├── page-agence.css          # Styles de la page agence
│   └── single-project.css       # Styles de la page projet individuel
├── fonts/
│   └── GalanoGrotesque-*.woff2  # Polices personnalisées
├── img/                         # Images du thème
├── inc/
│   ├── acf-fields.php           # Configuration des champs ACF
│   ├── ajax-handlers.php        # Gestionnaires AJAX
│   ├── customizer.php           # Options du Customizer
│   ├── post-types.php           # Types de contenu personnalisés
│   └── security.php             # Fonctions de sécurité
├── js/
│   ├── animated.js              # Animations JavaScript
│   ├── custom-swiper.js         # Configuration Swiper
│   ├── main.js                  # Script principal
│   ├── projects.js              # Logique des projets
│   └── sanitize.js              # Fonctions de sanitization
├── template-parts/              # Templates partiels
├── archive-project.php          # Template archive projets
├── front-page.php               # Template page d'accueil
├── functions.php                # Fonctions principales du thème
├── header.php                   # En-tête
├── footer.php                   # Pied de page
├── page-agence.php              # Template page agence
├── single-project.php           # Template projet individuel
├── style.css                    # Fichier principal CSS (en-tête du thème)
└── reset.css                    # Reset CSS
```

## 🎯 Utilisation

### Créer un projet

1. Aller dans **Projets > Ajouter un projet**
2. Remplir les informations :
   - Titre du projet
   - Description
   - Images du projet (jusqu'à 5 images)
   - Localisation (coordonnées GPS)
   - Année du projet
   - Thème (taxonomie)
   - Autres métadonnées

### Gérer le personnel

1. Aller dans **Personnel > Ajouter un membre**
2. Ajouter :
   - Nom
   - Photo
   - Fonction
   - Mention
   - Description

### Personnaliser la page d'accueil

1. Aller dans **Apparence > Personnaliser**
2. Section **Images de Bannière** : Ajouter jusqu'à 5 images (desktop et mobile)
3. Section **Partenaires** : Ajouter logos et liens (jusqu'à 10 partenaires)
4. Section **Réseaux Sociaux** : Configurer les liens vers les réseaux sociaux

## 🔧 Personnalisation

### Modifier les styles

Les fichiers CSS principaux sont :
- `style.css` : Styles globaux du thème
- `css/archive-project.css` : Styles de l'archive projets
- `css/single-project.css` : Styles de la page projet
- `css/page-agence.css` : Styles de la page agence

### Modifier les scripts

Les fichiers JavaScript principaux sont dans :
- `assets/js/` : Scripts généraux
- `js/` : Scripts spécifiques aux fonctionnalités

### Ajouter des champs ACF

Modifier le fichier `inc/acf-fields.php` pour ajouter ou modifier les champs personnalisés.

## 🛡️ Sécurité

Le thème inclut plusieurs mesures de sécurité :
- Désactivation de l'éditeur de fichiers WordPress (`DISALLOW_FILE_EDIT`)
- Sanitization des données utilisateur
- Fallbacks pour ACF (évite les erreurs si le plugin est désactivé)
- Échappement des sorties HTML

## 📝 Dépendances

### Plugins WordPress requis
- **Advanced Custom Fields (ACF)** : Gestion des champs personnalisés

### Bibliothèques externes (chargées via CDN)
- **Swiper.js** : Sliders et carrousels
- **Leaflet.js** : Cartes interactives

## 👨‍💻 Développement

### Auteur
**Tanguy MAMBAFEI**
- Site web : https://tanguy-dev.com

### Version
1.0

### Licence
GNU General Public License v2 or later

## 📞 Support

Pour toute question ou problème, veuillez contacter le développeur ou ouvrir une issue sur le dépôt GitLab.

## 🔄 Changelog

### Version 1.0
- Version initiale du thème
- Types de contenu personnalisés (Projets, Personnel)
- Slider hero avec support desktop/mobile
- Archive projets avec carte interactive
- Page agence
- Système de partenaires
- Intégration réseaux sociaux
- Animations et effets visuels

---

**Thème développé avec ❤️ pour Eza Architecture**
