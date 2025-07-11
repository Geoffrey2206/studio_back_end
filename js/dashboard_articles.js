document.addEventListener('DOMContentLoaded', function () {
 
    // <!-- TinyMCE -->
    tinymce.init({
    selector: '#contenu',
    plugins: 'image link media table lists',
    toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | image media link',
    language: 'fr_FR',
    language_url: 'js/langs/fr_FR.js',
    branding: false,
    // 🔥 Options pour réduire la taille
    paste_data_images: false, // Empêche les images collées en base64
    images_upload_url: 'functions/upload_image_tinymce.php', // Upload séparé
    automatic_uploads: true,
    paste_as_text: false,
    // Compression des images
    images_upload_handler: function (blobInfo, success, failure) {
        // Upload séparé des images au lieu de les intégrer en base64
        const formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        
        fetch('functions/upload_image_tinymce.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                success(data.location);
            } else {
                failure('Upload failed');
            }
        });
    }
});
    // Mise en place de l' AJAX pour envoie du formulaire article.
    articleForm.addEventListener('submit', function (e) {
        console.log("✅ Formulaire intercepté !");
        e.preventDefault();

        tinymce.triggerSave();

        // 🔥 Vérifiez d'abord le champ file
        const fileInput = document.querySelector('input[name="image"]');
        console.log("Champ file trouvé:", fileInput);
        console.log("Fichier sélectionné:", fileInput ? fileInput.files[0] : "AUCUN");

        const formData = new FormData(articleForm);
        
        // Debug complet
        console.log("=== DONNÉES ENVOYÉES ===");
        for (let [key, value] of formData.entries()) {
            if (value instanceof File) {
                console.log(`${key}: [FILE] ${value.name} (${value.size} bytes, ${value.type})`);
            } else {
                console.log(`${key}: ${value}`);
            }
        }
        
        // 🔥 Test spécifique pour l'image
        const imageFile = formData.get('image');
        console.log("Image dans FormData:", imageFile);
        
        console.log("======================");

        fetch('traitement_article.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("✅ " + data.message);
                location.reload();
            } else {
                alert("❌ " + data.message);
                console.error("Erreur retournée:", data);
            }
        })
        .catch(error => {
            alert("❌ Une erreur réseau est survenue");
            console.error("Erreur AJAX :", error);
        });
    });

    const editButtons = document.querySelectorAll('.edit-article-btn');
    const form = document.getElementById('articleForm');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;
            const title = this.dataset.title;
            const content = this.dataset.content;
            const statut = this.dataset.statut;

            // Injecte les valeurs dans les champs
            form.querySelector('#article_id').value = id;
            form.querySelector('#titre').value = title;
            form.querySelector('#statut').value = statut;

            // Injecte dans TinyMCE
            if (tinymce.get('contenu')) {
                tinymce.get('contenu').setContent(content);
            }

            // Change le titre de la modale
            document.getElementById('articleModalLabel').textContent = "Modifier l'article";
        });
    });

    // remettre la modale en mode création si on clique sur nouvel article.
    const newArticleBtn = document.querySelector('[data-bs-target="#articleModal"]');
    if (newArticleBtn) {
        newArticleBtn.addEventListener('click', function () {
            form.reset();
            form.querySelector('#article_id').value = '';
            form.querySelector('#statut').value = 'brouillon';
            tinymce.get('contenu').setContent('');
            document.getElementById('articleModalLabel').textContent = "Créer un article";
        });
    }
    // suppression articles via le bouton delete
    const deleteButtons = document.querySelectorAll('.delete-article-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.id;
            const metaTag = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = metaTag ? metaTag.getAttribute('content') : null;

            if (!confirm("⚠️ Voulez-vous vraiment supprimer cet article ?")) return;

            // Chemin corrigé - ajustez selon votre structure
            fetch('./functions/delete_article.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${encodeURIComponent(id)}&csrf_token=${encodeURIComponent(csrfToken)}`
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    alert("✅ " + data.message);
                    button.closest('tr').remove();
                } else {
                    alert("❌ " + data.message);
                }
            })
            .catch(err => {
                console.error("Erreur AJAX :", err);
                alert("❌ Erreur : " + err.message);
            });
        });
    });
    
});