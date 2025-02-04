document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.EC-tab-link');
    const contents = document.querySelectorAll('.EC-tab-content');

    function switchTab(tabId) {
        // Hide all content sections
        contents.forEach(content => {
            content.style.display = 'none';
        });

        // Remove active class from all tabs
        tabs.forEach(tab => {
            tab.classList.remove('EC-active');
        });

        // Show selected content and activate tab
        const selectedTab = document.querySelector(`[data-tab="${tabId}"]`);
        const selectedContent = document.getElementById(tabId);
        
        if (selectedTab && selectedContent) {
            selectedTab.classList.add('EC-active');
            selectedContent.style.display = 'block';
        }
    }

    // Add click handlers to tabs
    tabs.forEach(tab => {
        tab.addEventListener('click', (e) => {
            e.preventDefault();
            const tabId = tab.getAttribute('data-tab');
            switchTab(tabId);
        });
    });
});



document.addEventListener('DOMContentLoaded', () => {
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('fileInput');
    const currentLogo = document.getElementById('currentLogo');

    function handleFile(file) {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                currentLogo.src = e.target.result;
                uploadImage(file);
            };
            reader.readAsDataURL(file);
        } else {
            alert('Please upload an image file');
        }
    }


    function uploadImage(file) {
        const formData = new FormData();
        formData.append('image', file);

        fetch('/company/upload-personal-logo', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // alert('Image uploaded successfully!');
            } else {
                alert('Error uploading image.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    
    // Handle click on upload area
    uploadArea.addEventListener('click', () => {
        fileInput.click();
    });

    // Handle drag and drop
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.style.borderColor = '#4f46e5';
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.style.borderColor = '#e5e7eb';
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.style.borderColor = '#e5e7eb';
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFile(files[0]);
        }
    });

    // Handle file selection
    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            handleFile(e.target.files[0]);
        }
    });
});





const textarea = document.getElementById('description');
const charCount = document.querySelector('.character-count');

textarea.addEventListener('input', () => {
    const currentLength = textarea.value.length;
    charCount.textContent = `${currentLength} / 500`;
});




document.addEventListener('DOMContentLoaded', function () {
    const removeCityButton = document.getElementById('removeCity');
    const locationTags = document.getElementById('locationTags');

    if (removeCityButton) {
        removeCityButton.addEventListener('click', function () {
            // Utiliser SweetAlert2 pour confirmer la suppression
            Swal.fire({
                title: '¿Está seguro?',
                text: 'Esta acción eliminará la ubicación actual.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Effectuer une requête pour supprimer la valeur dans la base de données
                    fetch('/company/remove-city', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({})
                    })
                        .then(response => {
                            if (response.ok) {
                                // Supprimer l'affichage de la ville et ajouter un champ d'entrée
                                locationTags.innerHTML = `
                                    <input type="text" class="form-control" id="cityInput" name="city" placeholder="Ingrese la ubicación">
                                `;
                                // Notification de succès
                                Swal.fire({
                                    title: 'Eliminado',
                                    text: 'La ubicación ha sido eliminada.',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Error al eliminar la ubicación.',
                                    icon: 'error'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error',
                                text: 'Error al procesar la solicitud.',
                                icon: 'error'
                            });
                        });
                }
            });
        });
    }
});










document.addEventListener('DOMContentLoaded', function () {
    const saveButton = document.getElementById('saveButton');

    if (saveButton) {
        saveButton.addEventListener('click', function () {
            // Collecter les données des champs
            const companyName = document.getElementById('company-name').value;
            const website = document.getElementById('website').value;
           
            let city;
            const cityInput = document.getElementById('cityInput');
            if (cityInput) {
                city = cityInput.value;
            } else {
                city = document.getElementById('city_name').value;
            }

            
            const employees = document.getElementById('employees').value;
            const sector = document.getElementById('sector').value;
            const day = document.getElementById('day-select').value;
            const month = document.getElementById('month-select').value;
            const year = document.getElementById('year-select').value;
            const description = document.getElementById('description').value;

            // Validation simple
            if (!companyName || !website || !city || !employees || !sector || !day || !month || !year) {
                Swal.fire({
                    title: 'Error',
                    text: 'Por favor, complete todos los campos obligatorios.',
                    icon: 'error'
                });
                return;
            }

            // Construire les données à envoyer
            const formData = {
                company_name: companyName,
                website: website,
                city: city,
                employees: employees,
                sector: sector,
                creation_date: `${year}-${month}-${day}`,
                description: description
            };

            // Envoyer les données au serveur via fetch
            fetch('/company/update-profile', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(formData)
            })
                .then(response => {
                    if (response.ok) {
                        // Notification de succès
                        Swal.fire({
                            title: 'Éxito',
                            text: 'Los datos se han guardado correctamente.',
                            icon: 'success',
                            timer: 2000, // Afficher pendant 2 secondes
                            showConfirmButton: false
                        })
                            // Actualiser la page après la notification
                            window.location.reload();
                        
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un problema al guardar los datos.',
                            icon: 'error'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'No se pudo procesar la solicitud.',
                        icon: 'error'
                    });
                });
        });
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


