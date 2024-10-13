// Fonction pour échapper les chaînes de caractères afin d'éviter les XSS
function sanitizeHTML(str) {
    var temp = document.createElement('div');
    temp.textContent = str;
    return temp.innerHTML;
}

// Exemple d'utilisation lors de l'injection de contenu
document.addEventListener('DOMContentLoaded', function() {
    var userContent = '<script>alert("XSS")</script>'; // Exemple de contenu potentiellement dangereux
    var sanitizedContent = sanitizeHTML(userContent); // Assainir le contenu
    document.getElementById('safe-container').innerHTML = sanitizedContent; // Affichage sûr
});
