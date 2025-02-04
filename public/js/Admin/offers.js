function changeRowsPerPage(select) {
    const url = new URL(window.location.href);
    url.searchParams.set('perPage', select.value);
    window.location.href = url.toString();
}


$(document).ready(function () {
    const table = $('#myTable').DataTable({
        // Configurer les options de DataTables
        paging: true,
        searching: true,
        autoWidth: false,
        language: {
            search: "Rechercher:",
            lengthMenu: "Afficher _MENU_ enregistrements par page",
            info: "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
            paginate: {
                next: "Suivant",
                previous: "Précédent"
            }
        },
    });

    // Appliquer la recherche dynamique
    $('#searchTable').on('keyup', function () {
        table.search(this.value).draw();
    });
});



window.addEventListener('resize', function() {
    if (window.innerWidth >= 1000) {
        document.querySelector('.table-container').style.display = 'block';
        document.querySelector('.card-container').style.display = 'none';
    } else {
        document.querySelector('.table-container').style.display = 'none';
        document.querySelector('.card-container').style.display = 'block';
    }
});

// Initial check on page load
if (window.innerWidth >= 1000) {
    document.querySelector('.table-container').style.display = 'block';
    document.querySelector('.card-container').style.display = 'none';
} else {
    document.querySelector('.table-container').style.display = 'none';
    document.querySelector('.card-container').style.display = 'block';


}



document.addEventListener('DOMContentLoaded', () => {
    const alert = document.getElementById('success-alert');
    if (alert) {
        setTimeout(() => {
            alert.style.display = 'none';
        }, 5000);
    }
});
document.addEventListener('DOMContentLoaded', () => {
    const alert2 = document.getElementById('custom-alert');
    if (alert2) {
        setTimeout(() => {
            alert2.style.display = 'none';
        }, 5000); 
    }
});






document.addEventListener('DOMContentLoaded', function() {
    // Gestionnaire pour les clics sur les déclencheurs de dropdown
    document.querySelectorAll('.dropdown-trigger').forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.stopPropagation();
            // Ferme tous les autres dropdowns
            document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                if (menu !== this.nextElementSibling) {
                    menu.classList.remove('show');
                }
            });
            // Bascule l'état du dropdown actuel
            const dropdownMenu = this.closest('.dropdown-container').querySelector('.dropdown-menu');
            dropdownMenu.classList.toggle('show');
        });
    });

    // Ferme tous les dropdowns lors d'un clic à l'extérieur
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown-container')) {
            document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                menu.classList.remove('show');
            });
        }
    });
});




document.addEventListener('DOMContentLoaded', function() {
    const template = document.querySelector('#contextMenu');
    
    document.querySelectorAll('.view-details').forEach(button => {
        const menu = template.content.cloneNode(true).querySelector('.context-menu');
        button.parentElement.appendChild(menu);
        
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            
            // Ferme tous les autres menus ouverts
            document.querySelectorAll('.context-menu.active').forEach(m => {
                if (m !== menu) m.classList.remove('active');
            });
            
            // Toggle le menu actuel
            menu.classList.toggle('active');
            
            // Positionne le menu
            const rect = button.getBoundingClientRect();
            menu.style.top = '40px';
            menu.style.right = '0';
        });
    });
    
    // Ferme le menu si on clique ailleurs
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.context-menu') && !e.target.closest('.view-details')) {
            document.querySelectorAll('.context-menu.active').forEach(menu => {
                menu.classList.remove('active');
            });
        }
    });
});




document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-offer');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const offerId = this.dataset.offerId;
            
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas eliminar esta oferta?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Envoi de la requête de suppression
                    fetch(`/company/offers/${offerId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                '¡Eliminado!',
                                'La oferta ha sido eliminada.',
                                'success'
                            ).then(() => {
                                // Recharger la page ou supprimer la ligne du tableau
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error',
                                'Hubo un problema al eliminar la oferta.',
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        Swal.fire(
                            'Error',
                            'Hubo un problema al eliminar la oferta.',
                            'error'
                        );
                    });
                }
            });
        });
    });
});
