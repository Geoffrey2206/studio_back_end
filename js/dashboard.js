
//AJAX mise a jour des filtres gestions utilisateurs.

const filterBtn = document.getElementById('filterBtn');
const filterDropdown = document.getElementById('filterDropdown');
const filterForm = document.getElementById('filterForm');

console.log("➡️ Vérification DOM");
console.log("filterBtn :", filterBtn);
console.log("filterDropdown :", filterDropdown);
console.log("filterForm :", filterForm);

if (filterBtn && filterDropdown && filterForm) {
    filterBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        filterDropdown.classList.toggle('d-none');
    });

    document.addEventListener('click', function (e) {
        if (!filterDropdown.contains(e.target) && !filterBtn.contains(e.target)) {
            filterDropdown.classList.add('d-none');
        }
    });

    filterForm.addEventListener('submit', function (e) {
        e.preventDefault();
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
            console.error('❌ Erreur lors du filtrage :', error);
        });
    });
} else {
    console.warn("⚠️ Un ou plusieurs éléments n'ont pas été trouvés !");
}

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

// AJAX pour update les utilisateurs
document.addEventListener('DOMContentLoaded', () => {
    const editForm = document.getElementById('edit-user-form');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(editForm);

            fetch('update_ajax.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Utilisateur mis à jour avec succès !');
                    const currentPage = new URLSearchParams(window.location.search).get('page') || 'users';
                    window.location.href = `dashboardv2.php?page=${currentPage}`;
                } else {
                    alert('Erreur : ' + (data.message || 'modification échouée'));
                }
            })
            .catch(error => {
                console.error('Erreur AJAX :', error);
                alert('Erreur technique lors de l’envoi.');
            });
        });
    } else {
        console.warn("❗ Le formulaire #edit-user-form n'a pas été trouvé dans le DOM !");
    }
});

// création d'un mot de passe aléatoire pour la modal nouvel utilisateur
document.getElementById('generate-password').addEventListener('click', function () {
    const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
    let password = "";
    for (let i = 0; i < 10; i++) {
        password += charset.charAt(Math.floor(Math.random() * charset.length));
    }

    document.getElementById('create-password').value = password;
});

// Envoi du formulaire via AJAX
filterForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(filterForm);

    fetch('functions/filtrer_utilisateurs.php', {
    method: 'POST',
    body: formData
    })
    .then(res => res.text())
    .then(html => {
    document.getElementById('userTableBody').innerHTML = html;
    filterDropdown.classList.add('d-none'); // Ferme le menu après filtrage
    })
    .catch(error => {
    console.error('Erreur lors du filtrage :', error);
    });
});






// JavaScript pour les interactions
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des onglets de navigation
    const navLinks = document.querySelectorAll('.sidebar .nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Retirer la classe active de tous les liens
            navLinks.forEach(nl => nl.classList.remove('active'));
            // Ajouter la classe active au lien cliqué
            this.classList.add('active');
        });
    });
});
            
// Gestion des boutons d'action
const actionButtons = document.querySelectorAll('.btn-action');
actionButtons.forEach(button => {
    button.addEventListener('click', function(e) {

        const icon = this.querySelector('i');
        
        if (icon.classList.contains('fa-trash')) {
            // Ouvrir modal de confirmation de suppression
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        } else if (icon.classList.contains('fa-eye')) {
            // Ouvrir modal de visualisation
            const viewModal = new bootstrap.Modal(document.getElementById('viewMessageModal'));
            viewModal.show();
        } else if (icon.classList.contains('fa-edit')) {
            // Ouvrir modal d'édition
            const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
            editModal.show();
        }
    });
});

// Animation des cartes statistiques
const statsCards = document.querySelectorAll('.stats-card');
statsCards.forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-10px) scale(1.02)';
    });
    
    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
    });
});

// Fonction de recherche en temps réel
const searchInputs = document.querySelectorAll('.search-box input');
searchInputs.forEach(input => {
    input.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const table = this.closest('.table-container').querySelector('table tbody');
        const rows = table.querySelectorAll('tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});

// Effets de notification (simulation)
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(notification);

    // Auto-remove après 3 secondes
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 3000);
}

// Simulation d'actions
document.querySelectorAll('button[type="submit"]').forEach(button => {
    button.addEventListener('click', function(e) {
    
        showNotification('Paramètres sauvegardés avec succès !', 'success');
    });
});

// Gestion responsive du sidebar
function handleResize() {
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    
    if (window.innerWidth <= 768) {
        sidebar.style.transform = 'translateX(-100%)';
        mainContent.style.marginLeft = '0';
    } else {
        sidebar.style.transform = 'translateX(0)';
        mainContent.style.marginLeft = '250px';
    }
}

window.addEventListener('resize', handleResize);
handleResize(); // Appel initial

// Bouton pour toggle sidebar sur mobile
const toggleButton = document.createElement('button');
toggleButton.className = 'btn btn-primary position-fixed d-md-none';
toggleButton.style.cssText = 'top: 20px; left: 20px; z-index: 1001;';
toggleButton.innerHTML = '<i class="fas fa-bars"></i>';
document.body.appendChild(toggleButton);

toggleButton.addEventListener('click', function() {
    const sidebar = document.querySelector('.sidebar');
    const isHidden = sidebar.style.transform === 'translateX(-100%)';
    
    if (isHidden) {
        sidebar.style.transform = 'translateX(0)';
    } else {
        sidebar.style.transform = 'translateX(-100%)';
    }
});





// appelle AJAX pour marquer le "lu" lors de la visualisation de la modale - contact message
  
document.querySelectorAll('.open-modal').forEach(button => {
    button.addEventListener('click', function () {
        const messageId = this.getAttribute('data-id');

        fetch('functions/marquer_lu.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id=${messageId}`
        })
        .then(response => response.text())
        .then(data => {
            console.log('Message marqué comme lu :', data);

            // 🌟 Mise à jour visuelle du badge dans la ligne du tableau
            const badge = button.closest('tr').querySelector('.status-badge');
            if (badge && badge.classList.contains('status-new')) {
                badge.textContent = 'Lu';
                badge.classList.remove('status-new');
                badge.classList.add('status-read');
            }
        })
        .catch(error => console.error('Erreur:', error));
    });
});
 

// Cacher le menu si on clique en dehors
document.addEventListener('click', function (e) {
    if (!filterDropdown.contains(e.target) && !filterBtn.contains(e.target)) {
    filterDropdown.classList.add('d-none');
    }
});


 
// mise en place de TinyMCE

tinymce.init({
    selector: '#contenu',
    plugins: 'link image code lists',
    toolbar: 'undo redo | bold italic | bullist numlist | link image | code',
    height: 400
}); 

// ✅ Soumission AJAX du formulaire de réponse (modal de réponse message contact)
document.addEventListener('DOMContentLoaded', function () {
    const replyForm = document.querySelector('#replyModal form');

    if (replyForm) {
        replyForm.addEventListener('submit', function (e) {
            e.preventDefault(); // Empêche le reload

            const formData = new FormData(replyForm);

            fetch('traitement_reponse.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Fermer la modal après succès
                    const replyModal = bootstrap.Modal.getInstance(document.getElementById('replyModal'));
                    if (replyModal) replyModal.hide();

                    showNotification('Réponse envoyée avec succès !', 'success');

                    // Recharger dynamiquement la bonne page
                    const currentPage = new URLSearchParams(window.location.search).get('page') || 'contacts';
                    window.location.href = `dashboardv2.php?page=${currentPage}`;
                } else {
                    showNotification('Erreur : ' + data.message, 'danger');
                }
            })
            .catch(error => {
                console.error('Erreur AJAX :', error);
                showNotification('Une erreur est survenue.', 'danger');
            });
        });
    }
});