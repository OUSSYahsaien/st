@extends('layouts.company')

@section('title', 'Profile Company')

@section('page-title', 'Mi perfil de empresa')

@section('content')
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/profile-edit/my-profile.css') }}">

        {{-- <link rel="stylesheet" href="{{ asset('css/Company/edit-profile.css') }}"> --}}
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <body>
        

        <main class="profile-content" style="margin-top: 0;">

            @if (session('success'))
                <div id="success-alert" class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="custom-alert" id="custom-alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <section id="profile" class="content-section active">
                <div class="">
                    <h2 class="text-18">Información básica</h2>
                    <p class="subtitle mt-6 text-14">Esta es su información personal que puede actualizar en cualquier momento.</p>
                    <hr class="w-100 mt-18 " style="">
                </div>
                <div class="profile-picture-section">
                    <div class="profile-infos">
                        <h3 style="font-size: 16px;">Foto de perfil</h3>
                        <p class="text-14">Esta imagen no se mostrará públicamente, solo los reclutadores la pueden ver</p>
                    </div>
                    <div class="profile-upload">
                        <div class="current-picture">
                                <img id="profile-image" src="{{ asset('images/Avatar.png') }}" alt="Foto de perfil" class="profile-img">
                        </div>
                        <form id="profile-upload-form" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="upload-area">
                                <label for="profile-upload-input" class="upload-label">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="33" height="32" viewBox="0 0 33 32" fill="none">
                                        <g clip-path="url(#clip0_375_31458)">
                                        <path d="M20.5 10.666H20.5133" stroke="#4640DE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M23.1668 5.33398H9.8335C7.62436 5.33398 5.8335 7.12485 5.8335 9.33398V22.6673C5.8335 24.8765 7.62436 26.6673 9.8335 26.6673H23.1668C25.376 26.6673 27.1668 24.8765 27.1668 22.6673V9.33398C27.1668 7.12485 25.376 5.33398 23.1668 5.33398Z" stroke="#4640DE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5.8335 19.9999L11.1668 14.6666C11.7749 14.0815 12.4647 13.7734 13.1668 13.7734C13.869 13.7734 14.5588 14.0815 15.1668 14.6666L21.8335 21.3333" stroke="#4640DE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M19.1665 18.666L20.4998 17.3326C21.1079 16.7475 21.7977 16.4395 22.4998 16.4395C23.202 16.4395 23.8918 16.7475 24.4998 17.3326L27.1665 19.9993" stroke="#4640DE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_375_31458">
                                        <rect width="32" height="32" fill="white" transform="translate(0.5)"/>
                                        </clipPath>
                                        </defs>
                                    </svg>
                                    <span>Haga clic para sustituir o arrastre y suelte</span>
                                    <p>PNG o JPG (max. 0,5 MB)</p>
                                </label>
                                    <input type="file" name="profile_picture" id="profile-upload-input" class="upload-input" accept=".png, .jpg, .jpeg">
                            </div>
                            {{-- <button type="submit" class="btn-save" id="btn-submit-new-profile-image" style="display: none;">Guardar</button> --}}
                        </form>
                    </div>
                </div>
                <hr class="w-100 mt-18 " style="">
                
                <div class="unique-form-container">
                    <h2 class="unique-form-title">Información personal</h2>
                    <form action="{{ route('company.update.first.infos') }}" method="post" id="unique-personal-form">
                        @csrf
                        <input type="hidden" id="uploaded-profile-picture" name="uploaded_profile_picture">
                        <div class="unique-form-row">
                            <div class="unique-form-group">
                                <label class="unique-label" for="unique-firstname">Nombre completo<span>*</span></label>
                                <input type="text" id="unique-firstname" name="unique-full-name" placeholder="Jake" required>
                            </div>
                        </div>
                        <div class="unique-form-row">
                            <div class="unique-form-group">
                                <label class="unique-label" for="unique-phone">Teléfono <span>*</span></label>
                                <input type="tel" id="unique-phone" name="unique-phone-1" placeholder="+44 1245 572 135" required>
                            </div>
                            <div class="unique-form-group">
                                <label class="unique-label" for="unique-email">Correo <span>*</span></label>
                                <input type="email" id="unique-email" name="unique-email" placeholder="Jakegyll@gmail.com">
                            </div>
                        </div>
                        <div class="unique-form-row">
                            <div class="unique-form-group">
                                <label class="unique-label" for="unique-phone">Teléfono 2 (opcional) </label>
                                <input type="tel" id="unique-phone" name="unique-phone-2" placeholder="+44 1245 572 135">
                            </div>
                            <div class="unique-form-group">
                                <label class="unique-label" for="unique-email">Cargo <span>*</span></label>
                                <input type="text" id="unique-email" name="unique-cargo" placeholder="Cargo">
                            </div>
                        </div>
                        </div>
                        <hr class="w-100 mt-18 " style="">


                        <div class="job-search-container">
                            <h3 class="job-search-title">Informacion adicional </h3>
                            <p class="job-search-description">Puede actualizar su tipo de cuenta</p>
                            <div class="job-search-options">
                                <label class="job-search-option">
                                    <input type="radio" name="job-search" value="active">
                                    <div class="job-search-content">
                                        <span class="job-search-option-title">Estoy en búsqueda de personal</span>
                                        <span class="job-search-option-description">Prioridad a la hora de contacto</span>
                                    </div>
                                </label>
                                <label class="job-search-option">
                                    <input type="radio" name="job-search" value="open">
                                    <div class="job-search-content">
                                        <span class="job-search-option-title">No estoy en búsqueda de personal</span>
                                        <span class="job-search-option-description">Se considerarán tus postulaciones como no urgentes</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <hr class="w-100 mt-18 " style="">


                        <div class="job-search-container">
                            <h3 class="job-search-title">Ubicacion </h3>
                            <p class="job-search-description">Puede actualizar su ubicacion</p>
                            <div class="job-search-options">
                                <label class="job-search-option">
                                    <input type="radio" name="job-search-2" value="active" id="same-location">
                                    <div class="job-search-content">
                                        <span class="job-search-option-title">Trabajo en la misma ubicacion que la empresa</span>
                                        <span class="job-search-option-description">Se considera que trabaja en la sede principal de la empresa</span>
                                    </div>
                                </label>
                                <label class="job-search-option">
                                    <input type="radio" name="job-search-2" value="open" id="different-location">
                                    <div class="job-search-content">
                                        <span class="job-search-option-title">Trabajo en una ubicación distinta a la sede principal</span>
                                        <span class="job-search-option-description">Se considera la localización indicada en el campo de texto de abajo</span>
                                    </div>
                                </label>
                            </div>
                            <!-- Champ pour la nouvelle localisation -->
                            <div id="location-input-container" style="display: none; margin-top: 10px;">
                                <label for="new-location">Nueva ubicación:</label>
                                <input type="text" id="new-location" name="new-location" placeholder="Ingrese la nueva ubicación">
                            </div>
                        </div>
                        <hr class="w-100 mt-18" style="">
                        
                        <div class="validation-part">
                                <button type="submit" class="update-button">Guardar información</button>
                        </div>

                    </form>
            </section>

          </main>

        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
        <script src="{{ asset('js/company/profile-2.js') }}"></script>
        <script>
                        
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
        </script>


        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Vérifier si l'URL contient le paramètre 'o=t'
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.get('o') === 't') {
                    // Trouver le bouton et déclencher un clic
                    const button = document.getElementById("notificationsButton");
                    if (button) {
                        button.click();
                    }
                }
            });
        </script>

        <script>
            document.getElementById('profile-upload-input').addEventListener('change', function () {
                const formData = new FormData(document.getElementById('profile-upload-form'));
                fetch('{{ route("company.upload.profile.picture") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: formData,
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('profile-image').src = `{{ asset('images/team_images') }}/${data.filename}`;
                            document.getElementById('uploaded-profile-picture').value = data.filename;
                        } else {
                            alert('Erreur lors du téléversement de l’image : ' + data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        </script>


        <script>
            // Références aux éléments
            const sameLocationRadio = document.getElementById('same-location');
            const differentLocationRadio = document.getElementById('different-location');
            const locationInputContainer = document.getElementById('location-input-container');

            // Ajout des écouteurs d'événements
            sameLocationRadio.addEventListener('change', () => {
                if (sameLocationRadio.checked) {
                    locationInputContainer.style.display = 'none';
                }
            });

            differentLocationRadio.addEventListener('change', () => {
                if (differentLocationRadio.checked) {
                    locationInputContainer.style.display = 'block';
                }
            });
        </script>
    </body>
    </html>
@endsection