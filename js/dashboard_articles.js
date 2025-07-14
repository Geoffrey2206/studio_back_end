// 🔧 1. Fonction déclarée en premier
function initTinyMCE() {
    tinymce.init({
        selector: '#contenu',
        plugins: 'image link media table lists',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | image media link',
        language: 'fr_FR',
        language_url: 'js/langs/fr_FR.js',
        branding: false,
        paste_data_images: true,
        automatic_uploads: true,
        images_upload_url: 'functions/upload_image_tinymce.php',
        paste_as_text: false,
        license_key: 'gpl',
        file_picker_types: 'image',
        file_picker_callback: function (callback, value, meta) {
            if (meta.filetype === 'image') {
                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = function () {
                    const file = this.files[0];
                    const reader = new FileReader();
                    reader.onload = function () {
                        callback(reader.result, { alt: file.name });
                    };
                    reader.readAsDataURL(file);
                };
                input.click();
            }
        },
        images_upload_handler: function (blobInfo, success, failure) {
            console.log("📥 Image glissée :", blobInfo.filename(), blobInfo.blob().type);
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
        },
        setup: function (editor) {
        editor.on('drop', function (e) {
            console.log("📦 Drop détecté dans TinyMCE");

            const dataTransfer = e.dataTransfer;
            if (dataTransfer && dataTransfer.files.length > 0) {
                const file = dataTransfer.files[0];

                if (file.type.startsWith('image/')) {
                    e.preventDefault(); // ⚠️ obligatoire pour empêcher le comportement par défaut

                    const formData = new FormData();
                    formData.append('file', file, file.name);

                    fetch('functions/upload_image_tinymce.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            editor.insertContent(`<img src="${data.location}" alt="${file.name}" />`);
                        } else {
                            alert('❌ Échec du téléversement');
                        }
                    })
                    .catch(() => {
                        alert('❌ Erreur réseau pendant l\'upload');
                    });
                }
            }
        });
    }
    });
}

// ✅ 2. Quand le DOM est prêt, on initialise tout le reste
document.addEventListener('DOMContentLoaded', function () {
    const articleForm = document.getElementById('articleForm');
    if (!articleForm) {
        console.error("❌ PROBLÈME : Formulaire #articleForm introuvable !");
        alert("❌ Erreur : Formulaire non trouvé !");
        return;
    }

    const modal = document.getElementById('articleModal');

    modal.addEventListener('shown.bs.modal', function () {
        if (!tinymce.get('contenu')) {
            initTinyMCE();
        }
    });

    modal.addEventListener('hidden.bs.modal', function () {
        if (tinymce.get('contenu')) {
            tinymce.get('contenu').remove();
        }
    });

    articleForm.addEventListener('submit', function (e) {
        console.log("✅ Formulaire intercepté !");
        e.preventDefault();
        tinymce.triggerSave();
        const formData = new FormData(articleForm);
        fetch('traitement_article.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(text => {
            console.log("📦 Réponse brute:", text);
            try {
                const data = JSON.parse(text);
                if (data.success) {
                    alert("✅ " + data.message);
                    location.reload();
                } else {
                    alert("❌ " + data.message);
                    console.error("Erreur retournée:", data);
                }
            } catch (e) {
                console.error("❌ Réponse non-JSON:", text);
                alert("❌ Erreur de format de réponse");
            }
        })
        .catch(error => {
            alert("❌ Une erreur réseau est survenue");
            console.error("Erreur AJAX :", error);
        });
    });

    const form = document.getElementById('articleForm');
    const editButtons = document.querySelectorAll('.edit-article-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;

            // 🔄 Récupération de l'article via fetch
            fetch('functions/get_article.php?id=' + id)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const article = data.article;

                        // Pré-remplissage des champs
                        form.querySelector('#article_id').value = article.id_article;
                        form.querySelector('#titre').value = article.title_article;
                        form.querySelector('#statut').value = article.statut;
                        form.querySelector('#img_alt').value = article.img_alt ?? '';

                        const preview = document.getElementById('current-image-preview');
                        if (article.img_large) {
                            preview.innerHTML = `
                                <p class="mb-1"><strong>Image actuelle :</strong></p>
                                <img src="${article.img_large}" alt="${article.img_alt ?? ''}" 
                                    class="img-fluid rounded border" style="max-height: 150px;">
                            `;
                        } else {
                            preview.innerHTML = "<em>Aucune image actuelle</em>";
                        }
                        // Assure-toi que TinyMCE est prêt AVANT de charger le contenu
                        const initContent = () => {
                            if (tinymce.get('contenu')) {
                                tinymce.get('contenu').setContent(article.content_article);
                            } else {
                                // Si l'éditeur n'est pas prêt, on attend
                                setTimeout(initContent, 100);
                            }
                        };

                        // Déclenche l'ouverture de la modale
                        const modal = new bootstrap.Modal(document.getElementById('articleModal'));
                        modal.show();

                        // Une fois la modale affichée, TinyMCE sera initialisé
                        document.getElementById('articleModal').addEventListener('shown.bs.modal', () => {
                            setTimeout(() => {
                                if (tinymce.get('contenu')) {
                                    tinymce.get('contenu').setContent(article.content_article);
                                } else {
                                    console.warn("TinyMCE pas encore prêt");
                                }
                            }, 300); // petit délai
                        }, { once: true });

                        // Titre de la modale
                        document.getElementById('articleModalLabel').textContent = "Modifier l'article";

                    } else {
                        alert("❌ Erreur : " + data.message);
                    }
                })
                .catch(error => {
                    console.error("❌ AJAX ERROR :", error);
                    alert("❌ Une erreur s'est produite en récupérant l'article.");
                });
        });
    });
    const newArticleBtn = document.querySelector('[data-bs-target="#articleModal"]');
    if (newArticleBtn) {
        newArticleBtn.addEventListener('click', function () {
            form.reset();
            form.querySelector('#article_id').value = '';
            form.querySelector('#statut').value = 'brouillon';
            if (tinymce.get('contenu')) {
                tinymce.get('contenu').setContent('');
            }
            document.getElementById('articleModalLabel').textContent = "Créer un article";
        });
    }

    const deleteButtons = document.querySelectorAll('.delete-article-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.id;
            const metaTag = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = metaTag ? metaTag.getAttribute('content') : null;
            if (!confirm("⚠️ Voulez-vous vraiment supprimer cet article ?")) return;
            fetch('./functions/delete_article.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${encodeURIComponent(id)}&csrf_token=${encodeURIComponent(csrfToken)}`
            })
            .then(res => res.json())
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
