    // Récupérer les éléments
    const editBtn = document.getElementById('editDescription');
    const modal = document.getElementById('editModal');
    const closeBtn = document.querySelector('.close');
    const saveBtn = document.getElementById('saveDescription');
    const descriptionInput = document.getElementById('descriptionInput');
    const companyDescription = document.getElementById('companyDescription');

    // Ouvrir le modal
    editBtn.addEventListener('click', () => {
        descriptionInput.value = companyDescription.textContent.trim();
        modal.style.display = 'block';
        document.body.classList.add('modal-open');
    });

    // Fermer le modal
    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
        document.body.classList.remove('modal-open');
    });

    // Fermer le modal si on clique à l'extérieur
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
            document.body.classList.remove('modal-open');
        }
    });


    document.addEventListener('DOMContentLoaded', () => {
        const alert = document.getElementById('success-alert');
        if (alert) {
            setTimeout(() => {
                alert.style.display = 'none';
            }, 5000); // L'alerte disparaîtra après 5 secondes
        }
    });
    document.addEventListener('DOMContentLoaded', () => {
        const alert2 = document.getElementById('custom-alert');
        if (alert2) {
            setTimeout(() => {
                alert2.style.display = 'none';
            }, 5000); // L'alerte disparaîtra après 5 secondes
        }
    });


// DOM Elements
const addModal = document.getElementById('add-modal');
const addContactForm = document.getElementById('add-contact-form');

const editModal = document.getElementById('edit-modal');
const editContactForm = document.getElementById('edit-contact-form');

// Add Contact
function openAddModal() {
    addModal.style.display = 'block';
    document.body.classList.add('modal-open');
}

function closeAddModal() {
    addModal.style.display = 'none';
    addContactForm.reset();
    document.body.classList.remove('modal-open');
}

// Edit Contact
function openEditModal(index) {
    editModal.style.display = 'block';
    document.body.classList.add('modal-open');
}

function closeEditModal() {
    document.body.classList.remove('modal-open');
    editModal.style.display = 'none';
    editContactForm.reset();
}