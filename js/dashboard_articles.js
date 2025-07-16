const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
function initTinyMCE() {
    tinymce.init({
        selector: '#contenu',
        plugins: 'image link media table lists',
        toolbar: 'undo redo | bold italic | insertTag | alignleft aligncenter alignright | bullist numlist | image media link',
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
                    const formData = new FormData();
                    formData.append('file', file);

                    const metaTag = document.querySelector('meta[name="csrf-token"]');
                    const csrfToken = metaTag ? metaTag.getAttribute('content') : '';
                    formData.append('csrf_token', csrfToken);

                    fetch('functions/upload_image_tinymce.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success && data.location) {
                            callback(data.location, { alt: file.name });
                        } else {
                            alert('❌ Échec du téléversement : ' + data.message);
                        }
                    })
                    .catch(() => alert('❌ Erreur réseau pendant l’upload'));
                };
                input.click();
            }
        },
        images_upload_handler: function (blobInfo, success, failure) {
            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            // ✅ CSRF token récupéré proprement (test : mettre 'truc-faux' ici si besoin)
            const metaTag = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = metaTag ? metaTag.getAttribute('content') : '';
            formData.append('csrf_token', csrfToken);

            fetch('functions/upload_image_tinymce.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.location) {
                    success(data.location);
                } else {
                    failure(data.message || 'Upload failed');
                }
            })
            .catch(() => failure('Erreur réseau lors de l\'upload'));
        },

        setup: function (editor) {
             editor.ui.registry.addButton('insertTag', {
                text: '#Tag',
                tooltip: 'Insérer un tag',
                onAction: function () {
                    const tag = prompt("Entrez votre tag (ex: muscu, cardio...)");
                    if (tag) {
                        editor.insertContent(`<span class="badge bg-info">#${tag}</span>&nbsp;`);
                    }
                }  
            });
            editor.on('drop', function (e) {
                const dataTransfer = e.dataTransfer;
                if (dataTransfer && dataTransfer.files.length > 0) {
                    const file = dataTransfer.files[0];
                    if (file.type.startsWith('image/')) {
                        e.preventDefault();
                        const formData = new FormData();
                        formData.append('file', file, file.name);

                         // ✅ Ajout du CSRF token ici aussi
                        const metaTag = document.querySelector('meta[name="csrf-token"]');
                        const csrfToken = metaTag ? metaTag.getAttribute('content') : '';
                        formData.append('csrf_token', csrfToken);

                        fetch('functions/upload_image_tinymce.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                editor.insertContent(`<img src="${data.location}" alt="${file.name}" class="img-fluid article-img" />`);
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

document.addEventListener('DOMContentLoaded', function () {
    const articleForm = document.getElementById('articleForm');
    if (!articleForm) {
        alert("❌ Formulaire non trouvé !");
        return;
    }
    const searchInput = document.getElementById('search-article');
    const tableRows = document.querySelectorAll('#articlesTableBody tr');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase();

            tableRows.forEach(row => {
                const title = row.querySelector('.article-title')?.textContent.toLowerCase() || '';
                if (title.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
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
         const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(el => el.remove());

        document.body.classList.remove('modal-open'); // empêche le scroll bloqué
        document.body.style.paddingRight = ''; // évite le décalage de scrollbar
    });

    articleForm.addEventListener('submit', function (e) {
        e.preventDefault();
        tinymce.triggerSave();
        const formData = new FormData(articleForm);
        fetch('traitement_article.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                if (data.success) {
                    alert("✅ " + data.message);
                    location.reload();

                    const articleId = formData.get('article_id');
                    const row = document.querySelector(`tr[data-id="${articleId}"]`);

                    // Met à jour la date
                    if (row && data.updated_at) {
                        const dateCell = row.querySelector('.date-cell');
                        if (dateCell) {
                            dateCell.textContent = data.updated_at;
                        }
                    }

                    // Fermer la modale proprement
                    const modalElement = document.getElementById('articleModal');
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    if (modalInstance) {
                        modalInstance.hide();
                    }

                    // Nettoyer le formulaire et TinyMCE
                    articleForm.reset();
                    document.getElementById('current-image-preview').innerHTML = '';
                    if (tinymce.get('contenu')) {
                        tinymce.get('contenu').setContent('');
                    }

                    // Tu peux aussi mettre à jour le DOM ici si tu veux éviter complètement location.reload()

                } else {
                    alert("❌ " + data.message);
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
            fetch('functions/get_article.php?id=' + id)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const article = data.article;
                        form.querySelector('#article_id').value = article.id_article;
                        form.querySelector('#titre').value = article.title_article;
                        form.querySelector('#statut').value = article.statut;
                        form.querySelector('#img_alt').value = article.img_alt ?? '';

                        const preview = document.getElementById('current-image-preview');
                        const hiddenInputs = `
                            <input type="hidden" name="current_img_thumb" value="${article.img_thumbnail ?? ''}">
                            <input type="hidden" name="current_img_medium" value="${article.img_medium ?? ''}">
                            <input type="hidden" name="current_img_large" value="${article.img_large ?? ''}">
                            <input type="hidden" name="current_img_small" value="${article.img_small ?? ''}">
                        `;

                        if (article.img_large) {
                            preview.innerHTML = `
                                <p class="mb-1"><strong>Image actuelle :</strong></p>
                                <img src="${article.img_large}" alt="${article.img_alt ?? ''}" 
                                    class="img-fluid rounded border" style="max-height: 150px;">
                                ${hiddenInputs}
                            `;
                        } else {
                            preview.innerHTML = `<em>Aucune image actuelle</em>${hiddenInputs}`;
                        }

                        const modal = new bootstrap.Modal(document.getElementById('articleModal'));
                        modal.show();

                        document.getElementById('articleModal').addEventListener('shown.bs.modal', () => {
                            setTimeout(() => {
                                if (tinymce.get('contenu')) {
                                    tinymce.get('contenu').setContent(article.content_article);
                                }
                            }, 300);
                        }, { once: true });

                        document.getElementById('articleModalLabel').textContent = "Modifier l'article";
                    } else {
                        alert("❌ Erreur : " + data.message);
                    }
                })
                .catch(error => {
                    alert("❌ Une erreur s'est produite en récupérant l'article.");
                    console.error(error);
                });
        });
    });

    const newArticleBtn = document.querySelector('[data-bs-target="#articleModal"]');
    if (newArticleBtn) {
        newArticleBtn.addEventListener('click', function () {
            document.getElementById('current-image-preview').innerHTML = '';
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
                alert("❌ Erreur : " + err.message);
                console.error(err);
            });
        });
    });
    // affichage bloc filtre dashboard articles
   document.getElementById('applyFilterBtn').addEventListener('click', function () {
        const status = document.getElementById('filterStatus').value.toLowerCase();
        const author = document.getElementById('filterAuthor').value.toLowerCase();
        const date = document.getElementById('filterDate').value;

        const rows = document.querySelectorAll('#articlesTableBody tr');

        rows.forEach(row => {
            const rowStatus = row.querySelector('.badge')?.textContent.toLowerCase() || '';
            const rowAuthor = row.cells[2]?.textContent.toLowerCase() || '';
            const rowDate = row.querySelector('.date-cell')?.textContent || '';

            const matchStatus = !status || rowStatus.includes(status);
            const matchAuthor = !author || rowAuthor.includes(author);
            const matchDate = !date || rowDate === formatDate(date); // à adapter au format affiché

            if (matchStatus && matchAuthor && matchDate) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    function formatDate(dateString) {
        const [year, month, day] = dateString.split("-");
        return `${day}/${month}/${year}`;
    }

});