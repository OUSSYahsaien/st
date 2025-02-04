@extends('layouts.admin')

@section('title', 'Calender Admin')

@section('page-title', 'Portal de los administradores')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/Admin/calender/calender.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    
    
    <div class="calendar-page">
        <div class="calendar-container">
            <button class="create-event-btn" onclick="openEventModal()">+ Crear Evento</button>
            <div id="calendar"></div>
        </div>


        <div class="event-modal" id="eventModal">
            <div class="event-modal-content">
                <span class="close-modal" onclick="closeEventModal()">&times;</span>
                <h3>Informacion del evento</h3>
                <form id="eventForm">
                    <label for="title">Titulo</label>
                    <input type="text" id="title" name="title" placeholder="Ingrese el título" required>
                    
                    <label for="description">Descripción</label>
                    <textarea id="description" name="description" placeholder="Introducir Conocimientos y Habilidades" rows="5"></textarea>
                    
                    <div class="date-time">
                        <div>
                            <label for="date">Fecha de inicio</label>
                            <input type="date" id="date" name="date" required>
                        </div>
                        <div>
                            <label for="time">Hora</label>
                            <input type="time" id="time" name="time" required>
                        </div>
                    </div>

                    <div class="date-time">
                        <div>
                            <label for="date">fecha de finalización</label>
                            <input type="date" id="date_2" name="date">
                        </div>
                        <div>
                            <label for="time">Hora</label>
                            <input type="time" id="time_2" name="time">
                        </div>
                    </div>
                    
                    <label for="participants">Participantes</label>
                    <div class="participant-buttons">
                        <button type="button" class="btn-select" onclick="openCandidatesPopup()">Elección de un candidato</button>
                        <button type="button" class="btn-select" onclick="openCompaniesPopup()">Elección de una empresa</button>
                    </div>
                    
                    <label for="participants">Participantes seleccionados:</label>
                    <div class="selected-participants-display">
                        <div class="participant" id="selectedCandidateDisplay">
                            <span class="participant-label">Candidato:</span>
                            <span class="participant-name">Ningún candidato seleccionado</span>
                            <button type="button" class="remove-participant" onclick="removeCandidate()" style="display: none;">&times;</button>
                        </div>
                        <div class="participant" id="selectedCompanyDisplay">
                            <span class="participant-label">Empresa:</span>
                            <span class="participant-name">Ninguna empresa seleccionada</span>
                            <button type="button" class="remove-participant" onclick="removeCompany()" style="display: none;">&times;</button>
                        </div>
                    </div>
                    <button type="submit" class="create-event-submit">Crear</button>
                </form>
            </div>
        </div>
    </div>
    
    
    <!-- Popup pour les candidats -->
    <div class="popup" id="candidatesPopup">
        <div class="popup-content">
            <span class="close-popup" onclick="closeCandidatesPopup()">&times;</span>
            <h3>Lista de candidatos</h3>
            <ul class="list">
                @foreach($candidats as $candidat)
                    @php
                        $personalPicturePath = 'images/candidats_images/' . $candidat->personal_picture_path;
                    @endphp
                <li class="list-item" onclick="selectCandidat('{{ $candidat->id }}', '{{ $candidat->first_name }} {{ $candidat->last_name }}')">
                    @if ($candidat->personal_picture_path && file_exists(public_path($personalPicturePath)))
                        <img src="{{ asset('images/candidats_images/'.$candidat->personal_picture_path) }}" alt="Image Candidat">
                    @else
                        <img id="profile-image" src="{{ asset('images/companies_images/100x100.svg') }}" alt="Foto de perfil" class="profile-pic">
                    @endif
                    <div class="info">
                        <p class="name">{{ $candidat->first_name }} {{ $candidat->last_name }}</p>
                        <p class="email">{{ $candidat->email }}</p>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    
       <!-- Popup pour les entreprises -->
       <div class="popup" id="companiesPopup">
            <div class="popup-content-2">
                <span class="close-popup" onclick="closeCompaniesPopup()">&times;</span>
                <h3>Liste des Entreprises</h3>
                <ul class="list">
                    @foreach($companies as $company)
                        @php
                            $personalPicturePath = 'images/companies_images/' . $company->personel_pic;
                        @endphp
                    <li class="list-item" onclick="selectCompany('{{ $company->id }}', '{{ $company->name }}')">
                        @if ($company->personel_pic && file_exists(public_path($personalPicturePath)))
                            <img src="{{ asset('images/companies_images/'.$company->personel_pic) }}" alt="Foto de perfil">
                        @else
                            <img id="profile-image" src="{{ asset('images/companies_images/100x100.svg') }}" alt="Foto de perfil" class="profile-pic">
                        @endif
                        <div class="info">
                            <p class="name">{{ $company->name }}</p>
                            <p class="email">{{ $company->email }}</p>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>








        <!-- Popup pour les candidats -->
        <div class="popup" id="candidatesPopup2">
            <div class="popup-content">
                <span class="close-popup" onclick="closeCandidatesPopup2()">&times;</span>
                <h3>Lista de candidatos</h3>
                <ul class="list">
                    @foreach($candidats as $candidat)
                        @php
                            $personalPicturePath = 'images/candidats_images/' . $candidat->personal_picture_path;
                        @endphp
                    <li class="list-item" onclick="selectCandidat2('{{ $candidat->id }}', '{{ $candidat->first_name }} {{ $candidat->last_name }}')">
                        @if ($candidat->personal_picture_path && file_exists(public_path($personalPicturePath)))
                            <img src="{{ asset('images/candidats_images/'.$candidat->personal_picture_path) }}" alt="Image Candidat">
                        @else
                            <img id="profile-image" src="{{ asset('images/companies_images/100x100.svg') }}" alt="Foto de perfil" class="profile-pic">
                        @endif
                        <div class="info">
                            <p class="name">{{ $candidat->first_name }} {{ $candidat->last_name }}</p>
                            <p class="email">{{ $candidat->email }}</p>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        
        <!-- Popup pour les entreprises -->
        <div class="popup" id="companiesPopup2">
            <div class="popup-content-2">
                <span class="close-popup" onclick="closeCompaniesPopup2()">&times;</span>
                <h3>Liste des Entreprises</h3>
                <ul class="list">
                    @foreach($companies as $company)
                        @php
                            $personalPicturePath = 'images/companies_images/' . $company->personel_pic;
                        @endphp
                    <li class="list-item" onclick="selectCompany2('{{ $company->id }}', '{{ $company->name }}')">
                        @if ($company->personel_pic && file_exists(public_path($personalPicturePath)))
                            <img src="{{ asset('images/companies_images/'.$company->personel_pic) }}" alt="Foto de perfil">
                        @else
                            <img id="profile-image" src="{{ asset('images/companies_images/100x100.svg') }}" alt="Foto de perfil" class="profile-pic">
                        @endif
                        <div class="info">
                            <p class="name">{{ $company->name }}</p>
                            <p class="email">{{ $company->email }}</p>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    <!-- Zone pour afficher le candidat et l'entreprise sélectionnés -->
    <div class="selected-participants">
        <input type="hidden" id="selectedIdCandidat">
        <input type="hidden" id="selectedIdCompany">
        <br>
        <input type="hidden" id="selectedIdCandidat2">
        <input type="hidden" id="selectedIdCompany2">
    </div>

    <div class="edit-event-modal" id="editEventModal">
        <div class="edit-event-modal-content">
            <span class="close-modal" onclick="closeEditEventModal()">&times;</span>
            <h3>Modificar evento</h3>
            <form id="editEventForm">
                <input type="hidden" id="editEventId">
                
                <label for="editTitle">Titulo</label>
                <input type="text" id="editTitle" name="title" required>
                
                <label for="editDescription">Descripción</label>
                <textarea id="editDescription" name="description" rows="5"></textarea>
                
                <div class="date-time">
                    <div>
                        <label for="editDate">Fecha de inicio</label>
                        <input type="date" id="editDate" name="date" required>
                    </div>
                    <div>
                        <label for="editTime">Hora</label>
                        <input type="time" id="editTime" name="time" required>
                    </div>
                </div>
    
                <div class="date-time">
                    <div>
                        <label for="editDate2">fecha de finalización</label>
                        <input type="date" id="editDate2" name="date_2">
                    </div>
                    <div>
                        <label for="editTime2">Hora</label>
                        <input type="time" id="editTime2" name="time_2">
                    </div>
                </div>
                
                <label for="participants">Participantes</label>
                <div class="participant-buttons">
                    <button type="button" class="btn-select" onclick="openCandidatesPopup2()">Elección de un candidato</button>
                    <button type="button" class="btn-select" onclick="openCompaniesPopup2()">Elección de una empresa</button>
                </div>
                
                <div class="selected-participants-display">
                    <div class="participant" id="editSelectedCandidateDisplay">
                        <span class="participant-label">Candidato:</span>
                        <span class="participant-name">Ningún candidato seleccionado</span>
                        <button type="button" class="remove-participant" style="display: none;" onclick="removeCandidate2()">&times;</button>
                    </div>
                    <div class="participant" id="editSelectedCompanyDisplay">
                        <span class="participant-label">Empresa:</span>
                        <span class="participant-name">Ninguna empresa seleccionada</span>
                        <button type="button" class="remove-participant" style="display: none;" onclick="removeCompany2()">&times;</button>
                    </div>
                </div>
    
                <div class="edit-event-actions">
                    <button type="submit" class="save-event-btn">Guardar cambios</button>
                    <button type="button" class="delete-event-btn" onclick="deleteEvent()">Eliminar evento</button>
                </div>
            </form>
        </div>
    </div>
    

    <script>
        // Convertir les collections PHP en objets JavaScript
        const candidatsData = @json($candidats);
        const companiesData = @json($companies);
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                locale: 'es',
                events: '/administration/events',
                editable: true,  // Permet l'édition (drag & drop)
                eventResizableFromStart: true, // Permet le redimensionnement depuis le début
                eventDurationEditable: true,   // Permet le redimensionnement
                // selectable: true,
                
                // Gestion du drag & drop
                eventDrop: function(info) {
                    let event = info.event;
                    
                    // Préparer les données de l'événement
                    const eventData = {
                        title: event.title,
                        description: event.extendedProps.description,
                        start: event.start.toISOString(),
                        end: event.end ? event.end.toISOString() : null,
                        id_candidat: event.extendedProps.id_candidat,
                        id_company: event.extendedProps.id_company
                    };

                    // Envoyer la mise à jour au serveur
                    fetch(`/administration/events/${event.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(eventData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(!data.success) {
                            info.revert(); // Annuler le déplacement si erreur
                            alert('Error al actualizar el evento');
                        }
                    })
                    .catch(error => {
                        info.revert(); // Annuler le déplacement si erreur
                        console.error('Error:', error);
                        alert('Error al actualizar el evento');
                    });
                },
                
                // Gestion du redimensionnement
                eventResize: function(info) {
                    let event = info.event;
                    
                    // Préparer les données de l'événement
                    const eventData = {
                        title: event.title,
                        description: event.extendedProps.description,
                        start: event.start.toISOString(),
                        end: event.end ? event.end.toISOString() : null,
                        id_candidat: event.extendedProps.id_candidat,
                        id_company: event.extendedProps.id_company
                    };

                    // Envoyer la mise à jour au serveur
                    fetch(`/administration/events/${event.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(eventData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(!data.success) {
                            info.revert(); // Annuler le redimensionnement si erreur
                            alert('Error al actualizar el evento');
                        }
                    })
                    .catch(error => {
                        info.revert(); // Annuler le redimensionnement si erreur
                        console.error('Error:', error);
                        alert('Error al actualizar el evento');
                    });
                },
                
                // Pour afficher plus d'informations lors du clic
                eventClick: function(info) {
                    // Vous pouvez ajouter ici la logique pour afficher/éditer les détails de l'événement
                    // console.log('Event clicked:', info.event);
                    openEditEventModal(info.event);
                },
                
                // Pour la sélection de plage de dates
                select: function(info) {
                    console.log('Date range selected:', info.startStr, 'to', info.endStr);
                }
            });
            
            calendar.render();
        });
        

        function openEventModal() {
            document.getElementById('eventModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeEventModal() {
            document.getElementById('eventModal').style.display = 'none';
            document.body.style.overflow = '';
        }

        document.getElementById('eventModal').addEventListener('click', function (e) {
            const modalContent = document.querySelector('.event-modal-content');
            if (!modalContent.contains(e.target)) {
                closeEventModal();
            }
        });



        
    </script>


    <script>
        function selectCandidat(candidatID, name) {
            document.getElementById('selectedIdCandidat').value = candidatID;
            document.querySelector('#selectedCandidateDisplay .participant-name').textContent = name;
            // Afficher le bouton de suppression
            document.querySelector('#selectedCandidateDisplay .remove-participant').style.display = 'block';
            closeCandidatesPopup();
        }

        function selectCandidat2(candidatID, name) {
            document.getElementById('selectedIdCandidat2').value = candidatID;
            document.querySelector('#editSelectedCandidateDisplay .participant-name').textContent = name;
            // Afficher le bouton de suppression
            document.querySelector('#editSelectedCandidateDisplay .remove-participant').style.display = 'block';
            closeCandidatesPopup2();
        }

        function selectCompany(companyID, name) {
            document.getElementById('selectedIdCompany').value = companyID;
            document.querySelector('#selectedCompanyDisplay .participant-name').textContent = name;
            // Afficher le bouton de suppression
            document.querySelector('#selectedCompanyDisplay .remove-participant').style.display = 'block';
            closeCompaniesPopup();
        }

        function selectCompany2(companyID, name) {
            document.getElementById('selectedIdCompany2').value = companyID;
            document.querySelector('#editSelectedCompanyDisplay .participant-name').textContent = name;
            // Afficher le bouton de suppression
            document.querySelector('#editSelectedCompanyDisplay .remove-participant').style.display = 'block';
            closeCompaniesPopup2();
        }

        function removeCandidate() {
            document.getElementById('selectedIdCandidat').value = '';
            document.querySelector('#selectedCandidateDisplay .participant-name').textContent = 'Ningún candidato seleccionado';
            document.querySelector('#selectedCandidateDisplay .remove-participant').style.display = 'none';
        }

        function removeCandidate2() {
            document.getElementById('selectedIdCandidat2').value = '';
            document.querySelector('#editSelectedCandidateDisplay .participant-name').textContent = 'Ningún candidato seleccionado';
            document.querySelector('#editSelectedCandidateDisplay .remove-participant').style.display = 'none';
        }

        function removeCompany() {
            document.getElementById('selectedIdCompany').value = '';
            document.querySelector('#selectedCompanyDisplay .participant-name').textContent = 'Ninguna empresa seleccionada';
            document.querySelector('#selectedCompanyDisplay .remove-participant').style.display = 'none';
        }

        function removeCompany2() {
            document.getElementById('selectedIdCompany2').value = '';
            document.querySelector('#editSelectedCompanyDisplay .participant-name').textContent = 'Ninguna empresa seleccionada';
            document.querySelector('#editSelectedCompanyDisplay .remove-participant').style.display = 'none';
        }

        // Fermeture des popups si on clique à l'extérieur
        document.getElementById('candidatesPopup').addEventListener('click', function (e) {
            const popupContent = document.querySelector('.popup-content');
            if (!popupContent.contains(e.target)) {
                closeCandidatesPopup(); // Fermer la popup des candidats
            }
        });

        // Fermeture des popups si on clique à l'extérieur
        document.getElementById('candidatesPopup2').addEventListener('click', function (e) {
            const popupContent = document.querySelector('.popup-content');
            if (!popupContent.contains(e.target)) {
                closeCandidatesPopup2(); // Fermer la popup des candidats
            }
        });

        document.getElementById('companiesPopup').addEventListener('click', function (e) {
            const popupContent = document.querySelector('.popup-content-2');
            if (!popupContent.contains(e.target)) {
                closeCompaniesPopup(); // Fermer la popup des entreprises
            }
        });

        document.getElementById('companiesPopup2').addEventListener('click', function (e) {
            const popupContent = document.querySelector('.popup-content-2');
            if (!popupContent.contains(e.target)) {
                closeCompaniesPopup2(); // Fermer la popup des entreprises
            }
        });

        function openCandidatesPopup() {
            document.getElementById('candidatesPopup').style.display = 'flex';
        }

        function closeCandidatesPopup() {
            document.getElementById('candidatesPopup').style.display = 'none';
        }

        function openCompaniesPopup() {
            document.getElementById('companiesPopup').style.display = 'flex';
        }

        function closeCompaniesPopup() {
            document.getElementById('companiesPopup').style.display = 'none';
        }




        function openCandidatesPopup2() {
            document.getElementById('candidatesPopup2').style.display = 'flex';
        }

        function closeCandidatesPopup2() {
            document.getElementById('candidatesPopup2').style.display = 'none';
        }

        function openCompaniesPopup2() {
            document.getElementById('companiesPopup2').style.display = 'flex';
        }

        function closeCompaniesPopup2() {
            document.getElementById('companiesPopup2').style.display = 'none';
        }
    </script>





    <script>
        document.getElementById('eventForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Récupération des valeurs du formulaire
            const title = document.getElementById('title').value;
            const description = document.getElementById('description').value;
            const startDate = document.getElementById('date').value;
            const startTime = document.getElementById('time').value;
            const endDate = document.querySelector('#date_2').value;
            const endTime = document.querySelector('#time_2').value;
            
            // Création des dates complètes
            const start = startDate + 'T' + startTime;
            const end = endDate + 'T' + endTime;
            
            // Récupération des IDs des participants
            const id_candidat = document.getElementById('selectedIdCandidat').value;
            const id_company = document.getElementById('selectedIdCompany').value;

            // Création de l'objet de données
            const eventData = {
                title: title,
                description: description,
                start: start,
                end: end,
                id_candidat: id_candidat || null,
                id_company: id_company || null
            };

            // Envoi de la requête AJAX
            fetch('/administration/events', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(eventData)
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Rafraîchir le calendrier
                    location.reload();
                    // Fermer le modal
                    closeEventModal();
                    // Réinitialiser le formulaire
                    document.getElementById('eventForm').reset();
                    // Réinitialiser les participants sélectionnés
                    removeCandidate();
                    removeCompany();
                    
                    // Message de succès optionnel
                    // alert('Evento creado con éxito');
                } else {
                    alert('Error al crear el evento');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al crear el evento');
            });
        });
    </script>

        
    <script>
        // Add these functions to your existing JavaScript
        function openEditEventModal(event) {
            const modal = document.getElementById('editEventModal');
            const form = document.getElementById('editEventForm');
            const eventId = event.id;
            
            // Désactiver le scroll du body
            document.body.style.overflow = 'hidden';
            
            // Set event ID in hidden field
            document.getElementById('editEventId').value = eventId;
            
            // Set form values
            document.getElementById('editTitle').value = event.title;
            document.getElementById('editDescription').value = event.extendedProps.description || '';
            
            // Format dates and times
            const startDate = moment(event.start).format('YYYY-MM-DD');
            const startTime = moment(event.start).format('HH:mm');
            const endDate = event.end ? moment(event.end).format('YYYY-MM-DD') : '';
            const endTime = event.end ? moment(event.end).format('HH:mm') : '';
            
            document.getElementById('editDate').value = startDate;
            document.getElementById('editTime').value = startTime;
            document.getElementById('editDate2').value = endDate;
            document.getElementById('editTime2').value = endTime;
            
            // Update participant displays
            // Pour les candidats
            if (event.extendedProps.id_candidat) {
                const candidat = candidatsData.find(c => c.id == event.extendedProps.id_candidat);
                if (candidat) {
                    document.getElementById('selectedIdCandidat2').value = candidat.id;
                    const candidatName = `${candidat.first_name} ${candidat.last_name}`;
                    document.querySelector('#editSelectedCandidateDisplay .participant-name').textContent = candidatName;
                    document.querySelector('#editSelectedCandidateDisplay .remove-participant').style.display = 'block';
                }
            }

            // Pour les entreprises
            if (event.extendedProps.id_company) {
                const company = companiesData.find(c => c.id == event.extendedProps.id_company);
                if (company) {
                    document.getElementById('selectedIdCompany2').value = company.id;
                    const companyName = company.name;
                    document.querySelector('#editSelectedCompanyDisplay .participant-name').textContent = companyName;
                    document.querySelector('#editSelectedCompanyDisplay .remove-participant').style.display = 'block';
                }
            }
            
            
            
            
            modal.style.display = 'flex';
        }
        

        function closeEditEventModal() {
            const modal = document.getElementById('editEventModal');
            const form = document.getElementById('editEventForm');
            
            // Cacher la modale
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
            
            // Réinitialiser les champs du formulaire
            form.reset();
            
            // Réinitialiser les champs spécifiques
            document.getElementById('editTitle').value = '';
            document.getElementById('editDescription').value = '';
            document.getElementById('editDate').value = '';
            document.getElementById('editTime').value = '';
            document.getElementById('editDate2').value = '';
            document.getElementById('editTime2').value = '';
            
            // Réinitialiser l'affichage des participants
            document.querySelector('#editSelectedCandidateDisplay .participant-name').textContent = 'Ningún candidato seleccionado';
            document.querySelector('#editSelectedCandidateDisplay .remove-participant').style.display = 'none';
            
            document.querySelector('#editSelectedCompanyDisplay .participant-name').textContent = 'Ninguna empresa seleccionada';
            document.querySelector('#editSelectedCompanyDisplay .remove-participant').style.display = 'none';

            document.getElementById('selectedIdCandidat2').value = '';
            document.getElementById('selectedIdCompany2').value = '';
        }
        
        
        
        
        
        function deleteEvent() {
            // Afficher l'alerte de confirmation moderne
            Swal.fire({
                title: '¿Está seguro?',
                text: '¿Desea eliminar este evento? Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const eventId = document.getElementById('editEventId').value;
                    
                    fetch(`/administration/events/${eventId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Alerte de succès
                            Swal.fire({
                                title: '¡Eliminado!',
                                text: 'El evento ha sido eliminado con éxito.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                closeEditEventModal();
                                location.reload();
                            });
                        } else {
                            // Alerte d'erreur
                            Swal.fire({
                                title: 'Error',
                                text: 'No se pudo eliminar el evento.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#3085d6'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Alerte d'erreur pour les exceptions
                        Swal.fire({
                            title: 'Error',
                            text: 'Se produjo un error al eliminar el evento.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#3085d6'
                        });
                    });
                }
            });
        }

        // Fonction utilitaire pour les messages d'erreur
        function showErrorAlert(message) {
            Swal.fire({
                title: 'Error',
                text: message,
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6'
            });
        }

        // Fonction utilitaire pour les messages de succès
        function showSuccessAlert(message) {
            Swal.fire({
                title: '¡Éxito!',
                text: message,
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        }
        
        


        document.getElementById('editEventForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const eventId = document.getElementById('editEventId').value;
            const title = document.getElementById('editTitle').value;
            const description = document.getElementById('editDescription').value;
            const startDate = document.getElementById('editDate').value;
            const startTime = document.getElementById('editTime').value;
            const endDate = document.getElementById('editDate2').value;
            const endTime = document.getElementById('editTime2').value;
            
            // Ajuster l'heure en diminuant d'une heure
            const adjustTime = (time) => {
                if (!time) return null;
                const [hours, minutes] = time.split(':');
                const adjustedHours = parseInt(hours) - 1;
                return `${adjustedHours.toString().padStart(2, '0')}:${minutes}`;
            };
            
            const adjustedStartTime = adjustTime(startTime);
            const adjustedEndTime = adjustTime(endTime);
            
            // Créer les dates finales avec les heures ajustées
            const start = startDate + 'T' + adjustedStartTime;
            const end = endDate && endTime ? endDate + 'T' + adjustedEndTime : null;
            
            const eventData = {
                title: title,
                description: description,
                start: start,
                end: end,
                id_candidat: document.getElementById('selectedIdCandidat2').value || null,
                id_company: document.getElementById('selectedIdCompany2').value || null
            };
            
            fetch(`/administration/events/${eventId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(eventData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error al actualizar el evento');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al actualizar el evento');
            });

            closeEditEventModal();
        });
        




        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('editEventModal');
            const modalContent = modal.querySelector('.edit-event-modal-content');

            modal.addEventListener('click', function(e) {
                // Si le clic est en dehors du contenu du modal
                if (!modalContent.contains(e.target)) {
                    closeEditEventModal();
                }
            });

            // Empêcher la propagation des clics à l'intérieur du modal
            modalContent.addEventListener('click', function(e) {
                e.stopPropagation();
            });

            // Gérer la touche Escape pour fermer le modal
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal.style.display === 'flex') {
                    closeEditEventModal();
                }
            });
        });
        
        
    </script>


    
</body>
</html>

@endsection