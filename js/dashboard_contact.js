document.addEventListener('DOMContentLoaded', function () {
    console.log("🏁 Script dashboard_contact.js bien chargé !");

    // 📨 Affichage modal + mise à jour statut
    const modal = document.getElementById('viewMessageModal');
    const buttons = document.querySelectorAll('.open-modal');

    buttons.forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const surname = this.getAttribute('data-surname');
            const date = this.getAttribute('data-date');
            const subject = this.getAttribute('data-subject');
            const message = this.getAttribute('data-message');
            const reponse = this.getAttribute('data-reponse');

            console.log("▶ Données bouton cliqué :", { id, name, surname, date, subject, message, reponse });

            // Injection dans la modale
            document.getElementById('modalFullName').textContent = `${name} ${surname}`;
            document.getElementById('modalDate').textContent = date;
            document.getElementById('modalSubject').textContent = subject;
            document.getElementById('modalContent').textContent = message;

            const reponseContainer = document.getElementById('replyMessage');
            if (reponse && reponse.trim() !== '') {
                reponseContainer.removeAttribute('disabled');
                reponseContainer.value = reponse;
            } else {
                reponseContainer.setAttribute('disabled', true);
                reponseContainer.value = "Aucune réponse enregistrée.";
            }

            fetch('update_status.php?id=' + id)
                .then(reponse => reponse.json())
                .then(data => {
                    if (data.success) {
                        console.log('Statut mis à jour ✅');
                        const currentPage = new URLSearchParams(window.location.search).get('page') || 'contacts';
                        window.location.href = `dashboardv2.php?page=${currentPage}`;
                    }
                });
        });
    });

    // 🔄 Nettoyage modal
    const modalElement = document.getElementById('viewMessageModal');
    if (modalElement) {
        modalElement.addEventListener('hidden.bs.modal', function () {
            document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
            document.body.classList.remove('modal-open');
            document.body.style = '';
        });
    }

    // 📩 Injection ID dans la modale réponse
    document.querySelectorAll('.open-reply-modal').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            document.getElementById('replyId').value = id;
        });
    });

    // 🧩 Formulaire de filtre
    const filterBtn = document.getElementById('filterBtn');
    const filterDropdown = document.getElementById('filterDropdown');
    const filterForm = document.getElementById('filterForm');

    if (filterBtn && filterDropdown && filterForm) {
        filterBtn.addEventListener('click', () => {
            filterDropdown.classList.toggle('d-none');
        });

        filterForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(filterForm);

            console.log("status:", formData.get("status"));
            console.log("date:", formData.get("date"));
            console.log("sort:", formData.get("sort"));

            fetch('functions/filter_contacts.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                console.log("Réponse AJAX :", data);
                    if (data.success) {
                    const tbody = document.querySelector('#contacts tbody');
                    tbody.innerHTML = '';

                    data.data.forEach(contact => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${contact.full_name}</td>
                            <td>${contact.email_contact}</td>
                            <td>${contact.subject_contact}</td>
                            <td>${new Date(contact.creationdate_contact).toLocaleDateString()}</td>
                            <td><span class="status-badge status-${contact.status_contact}">${contact.status_contact}</span></td>
                            <td>... Boutons actions ...</td>
                        `;
                        tbody.appendChild(tr);
                    });
                } else {
                    alert("Erreur lors du filtrage.");
                }
            })
            .catch(err => {
                console.error("Erreur AJAX :", err);
                alert("Erreur technique.");
            });
        });
    }
});