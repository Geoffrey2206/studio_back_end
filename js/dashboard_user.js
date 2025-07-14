document.addEventListener('DOMContentLoaded', function () {
    const generateBtn = document.getElementById('generate-password');
    const passwordInput = document.getElementById('create-password');
    const createForm = document.getElementById('create-user-form');
    const filterForm = document.getElementById('filterForm');
    const filterDropdown = document.getElementById('filterDropdown');
    const filterBtn = document.getElementById('filterBtn');

    // Génération de mot de passe
    if (generateBtn && passwordInput) {
        generateBtn.addEventListener('click', function () {
            const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
            let password = "";
            for (let i = 0; i < 10; i++) {
                password += charset.charAt(Math.floor(Math.random() * charset.length));
            }
            passwordInput.value = password;
        });
    } else {
        console.warn("❌ Élément de génération de mot de passe introuvable");
    }

    // Formulaire de création d'utilisateur
    if (createForm) {
        createForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(createForm);
            formData.append('create_user', 1);

            fetch('functions/traitement_user.php', {
                method: 'POST',
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert('✅ Utilisateur créé avec succès');
                        window.location.reload();
                    } else {
                        alert('❌ Erreur : ' + (data.message || 'Une erreur inconnue est survenue'));
                    }
                })
                .catch(err => {
                    console.error("Erreur AJAX :", err);
                    alert('❌ Une erreur technique est survenue (vérifie la console)');
                });
        });
    }

    // 🔽 Affichage/Masquage du menu filtre
    if (filterBtn && filterDropdown) {
        filterBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            filterDropdown.classList.toggle('d-none');
        });

        document.addEventListener('click', function (e) {
            if (!filterDropdown.contains(e.target) && !filterBtn.contains(e.target)) {
                filterDropdown.classList.add('d-none');
            }
        });
    }

    // 📩 Envoi AJAX du filtre
    if (filterForm) {
        filterForm.addEventListener('submit', function (e) {
            e.preventDefault();
            console.log("🟢 Formulaire de filtre soumis !");
            const formData = new FormData(filterForm);

            fetch('functions/filtrer_utilisateurs.php', {
                method: 'POST',
                body: formData
            })
                .then(res => res.text())
                .then(html => {
                    const tbody = document.getElementById('userTableBody');
                    if (tbody) {
                        tbody.innerHTML = html;
                    } else {
                        console.error("❌ Élément #userTableBody introuvable.");
                    }
                    filterDropdown.classList.add('d-none');
                })
                .catch(error => {
                    console.error("❌ Erreur lors du filtrage :", error);
                });
        });
    }
    // pré-remplir la modale de modification avec les données déja existante 
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('edit-id').value = this.dataset.id;
            document.getElementById('edit-name').value = this.dataset.name;
            document.getElementById('edit-surname').value = this.dataset.surname;
            document.getElementById('edit-email').value = this.dataset.email;
            document.getElementById('edit-role').value = this.dataset.role;
            document.getElementById('edit-status').value = this.dataset.status;
        });
    });
    // Géré l'envoi AJAX du formulaire d'édition
    const editForm = document.getElementById('edit-user-form');
    if (editForm) {
        editForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(editForm);
            formData.append('update_user', 1);

            fetch('functions/traitement_user.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("✅ Utilisateur modifié avec succès !");
                    window.location.reload();
                } else {
                    alert("❌ Erreur : " + (data.message || "Une erreur inconnue est survenue"));
                }
            })
            .catch(err => {
                console.error("❌ Erreur AJAX :", err);
                alert("❌ Erreur technique");
            });
        });
    }
    
    document.querySelectorAll('.delete-user-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const userId = this.dataset.id;

            if (!confirm("❗ Supprimer cet utilisateur ?")) return;

            fetch('functions/traitement_user.php', {
                method: 'POST',
                body: new URLSearchParams({
                    delete_user_id: userId
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("✅ Utilisateur supprimé !");
                    // Actualisation douce
                    window.location.href = window.location.pathname + window.location.search;
                } else {
                    alert("❌ " + (data.message || "Erreur de suppression"));
                }
            })
            .catch(error => {
                console.error("❌ Erreur AJAX :", error);
                alert("❌ Une erreur technique est survenue");
            });
        });
    });






});