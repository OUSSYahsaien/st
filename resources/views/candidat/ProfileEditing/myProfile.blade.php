@extends('layouts.candidat')

@section('title', 'Edición de perfil')

@section('page-title', 'Edición de perfil')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('css/profile-edit/my-profile.css') }}">
</head>
<body>
    
    <div class="container">
        <nav class="nav-bar">
            <div class="nav-items">
                <button class="item active" data-section="profile">Mon profil</button>
                <button class="item" data-section="cv">Curriculum vitae</button>
                <button id="notificationsButton" class="item" data-section="notifications">Notification y Cuenta</button>
                
            </div>
        </nav>


        <main class="profile-content">

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
                            @php
                                $personalPicturePath = 'images/candidats_images/' . Auth::user()->personal_picture_path;
                            @endphp
                            @if (Auth::user()->personal_picture_path && file_exists(public_path($personalPicturePath)))
                                <img id="profile-image" src="{{ asset($personalPicturePath) }}" alt="Foto de perfil" class="profile-img">
                            @else
                                <img id="profile-image" src="{{ asset('images/companies_images/100x100.svg') }}" alt="Foto de perfil" class="profile-img">
                            @endif
                        </div>
                        <form action="{{ route('candidat.upload.profile.picture') }}" method="POST" enctype="multipart/form-data">
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
                                    <input type="file" onchange="document.getElementById('btn-submit-new-profile-image').click()" name="profile_picture" id="profile-upload-input" class="upload-input" accept=".png, .jpg, .jpeg">
                            </div>
                            <button type="submit" class="btn-save" id="btn-submit-new-profile-image" style="display: none;">Guardar</button>
                        </form>
                    </div>
                </div>
                <hr class="w-100 mt-18 " style="">

                <div class="unique-form-container">
                    <h2 class="unique-form-title">Información personal</h2>
                    <form action="{{ route('candidat.update.first.infos') }}" method="post" id="unique-personal-form">
                        @csrf
                        <div class="unique-form-row">
                            <div class="unique-form-group">
                                <label class="unique-label" for="unique-firstname">Nombre<span>*</span></label>
                                <input type="text" id="unique-firstname" name="unique-firstname" placeholder="Jake" value="{{Auth::user()->first_name}}">
                            </div>
                            <div class="unique-form-group">
                                <label class="unique-label" for="unique-lastname">Apellido<span>*</span></label>
                                <input type="text" id="unique-lastname" name="unique-lastname" placeholder="Gyll" value="{{Auth::user()->last_name}}">
                            </div>
                        </div>
                        <div class="unique-form-row">
                            <div class="unique-form-group">
                                <label class="unique-label" for="unique-phone">Teléfono <span>*</span></label>
                                <input type="tel" id="unique-phone" name="unique-phone" placeholder="+44 1245 572 135" value="{{Auth::user()->tel}}" required>
                            </div>
                            <div class="unique-form-group">
                                <label class="unique-label" for="unique-email">Correo <span>*</span></label>
                                <input type="email" id="unique-email" name="unique-email" placeholder="Jakegyll@gmail.com" value="{{Auth::user()->email}}">
                            </div>
                        </div>
                        <div class="unique-form-row">
                            <div class="unique-form-group">
                                <label class="unique-label" for="unique-birthdate">Fecha de nacimiento <span>*</span></label>
                                <input type="date"  value="{{ Auth::user()->date_of_birth ? \Illuminate\Support\Carbon::parse(Auth::user()->date_of_birth)->format('Y-m-d') : '' }}" id="unique-birthdate" name="unique-birthdate">
                            </div>
                            <div class="unique-form-group">
                                <label class="unique-label" for="unique-gender">Género <span>*</span></label>
                                <select id="unique-gender" name="unique-gender">
                                    <option {{ Auth::user()->gender == 'male' ? "selected" : ''  }} value="male">Hombre</option>
                                    <option {{ Auth::user()->gender == 'female' ? "selected" : ''  }} value="female">Mujer</option>
                                </select>
                            </div>
                        </div>

                        <div class="unique-form-row">
                            <div class="unique-form-group">
                                <label class="unique-label" for="unique-cargo">Cargo actual <span>*</span></label>
                                <input type="text" id="unique-cargo" name="unique-cargo" placeholder="" value="{{Auth::user()->poste}}" required>
                            </div>
                            <div class="unique-form-group">
                                <label class="unique-label" for="unique-location">Ubicación <span>*</span></label>
                                <input type="text" id="unique-location" name="unique-location" placeholder="" value="{{Auth::user()->adresse}}" required>
                            </div>
                        </div>

                        </div>
                        <hr class="w-100 mt-18 " style="">


                        <div class="job-search-container">
                            <h3 class="job-search-title">Búsqueda de empleo</h3>
                            <p class="job-search-description">Puede actualizar su tipo de cuenta</p>
                            <div class="job-search-options">
                                <label class="job-search-option">
                                    <input type="radio" name="job-search" value="active" {{ Auth::user()->priority == 'no' ? "checked" : '' }}>
                                    <div class="job-search-content">
                                        <span class="job-search-option-title">Estoy en búsqueda activa de empleo</span>
                                        <span class="job-search-option-description">Prioridad a la hora de contacto</span>
                                    </div>
                                </label>
                                <label class="job-search-option">
                                    <input type="radio" name="job-search" value="open" {{ Auth::user()->priority == 'yes' ? "checked" : '' }}>
                                    <div class="job-search-content">
                                        <span class="job-search-option-title">Valoro nuevas oportunidades</span>
                                        <span class="job-search-option-description">Se considerarán tus postulaciones como no urgentes</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <hr class="w-100 mt-18 " style="">
                        
                        <div class="validation-part">
                                <button type="submit" class="update-button">Guardar información</button>
                        </div>

                    </form>
            </section>



            <section id="cv" class="content-section">                 
                <h2 class="text-15">Adjuntar CV</h2>                 
                <p class="subtitle mt-6 text-14">Adjunta tu cv y déjanos descubrir lo que te diferencia</p>                             
                <div class="cv-upload">                     
                    <label for="cv-file" class="cv-upload-box">                         
                        <span>Haga clic para subir su curriculum o arrastre y suelte</span>                     
                    </label>                     
                    <input type="file" id="cv-file" class="cv-input" accept=".pdf">                 
                </div>                             
                <div class="uploaded-file">                     
                    <span class="file-name">
                        <?php echo Auth::user()->cv_file_path ? basename(Auth::user()->cv_file_path) : ''; ?>
                    </span>
                    <a 
                        class="remove-file" 
                        style="<?php echo Auth::user()->cv_file_path ? '' : 'display: none;'; ?>"
                        onclick="event.preventDefault(); document.getElementById('delete-document-form').submit();">eliminar</a>                 
                </div>                             
                <div id="pdf-preview-container" style="margin-top: 20px; max-width: 100%; <?php echo Auth::user()->cv_file_path ? '' : 'display: none;'; ?>"></div>
                <!-- Formulaire pour envoyer la requête DELETE -->
                <form id="delete-document-form" action="{{ route('candidat.delete.document') }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </section>
            
            
            
            
            <section id="notifications" class="content-section">
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
                
                <div class="">
                    <h2 class="text-18">Información básica</h2>
                    <p class="subtitle mt-6 text-14">Esto es preferencias de notificaciones y inicio de session que puede actualizar en cualquier momento.</p>
                    <hr class="w-100 mt-18 " style="margin-top: 27px">
                </div>
                
                <div class="refresh-email-section">
                    <!-- Informations de la section -->
                    <div class="refrech-email-infos">
                        <h3>Actualizar el correo.</h3>
                        <p class="text-14">
                            Actualice su dirección de correo electrónico para asegurarse de que es seguro
                        </p>
                    </div>
                
                    <!-- Champs de mise à jour -->
                    <div class="refresh-fields">
                        <div class="current-email">
                                <p class="email-address">{{ Auth::user()->email }} 
                                    <span class="verified-icon">
                                        <i class="fa-regular fa-circle-check"></i>
                                    </span>
                                </p>
                            <p class="verification-status">Su dirección de correo electrónico está verificada.</p>
                        </div>
                        <div class="update-email-form">
                            <label for="new-email" class="sr-only">Correo electrónico de actualización</label>
                            <form style="max-width: 400px;" method="post" action="{{ route('candidat.edit.email') }}">
                                @csrf
                                <input
                                style="width: 100%;"
                                    type="email"
                                    id="new-email"
                                    name="email"
                                    class="email-input"
                                    placeholder="Introduzca su nuevo correo electrónico"
                                />
                                <button style="display: block; margin-top: 12px;" type="submit" class="update-button">Actualizar email</button>
                            </form>
                        </div>
                    </div>
                    <hr class="w-100 hu" style="margin-top: -9px;">
                </div>

                <div class="change-password-section">
                    <div class="password-info">
                        <h3>Nueva contraseña</h3>
                        <p>Administrar su contraseña para proteger su información</p>
                    </div>
                    <div class="password-fields">
                        <form style="" method="post" action="{{ route('candidat.edit.password') }}">
                            @csrf
                            <div class="field-group" style="margin-bottom: 1.2rem;">
                                <label for="old-password">Contraseña antigua</label>
                                <input type="password" id="old-password" name="old-password" placeholder="Introduzca su contraseña antigua">
                                <small>Mínimo 8 caracteres</small>
                            </div>
                            <div class="field-group">
                                <label for="new-password">Nueva contraseña</label>
                                <input type="password" id="new-password" name="new-password" placeholder="Introduzca su nueva contraseña">
                                <small>Mínimo 8 caracteres</small>
                            </div>
                                <button type="submit" class="btn-primary">Cambiar la contraseña</button>
                        </form>

                            <div class="add-info">
                                <form action="{{ route('candidat.password.email') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                                    <i class="fa-solid fa-circle-info"></i>
                                    <a style="cursor: pointer;" onclick="document.getElementById('submit-reset-pass').click()" class="forgot-password-link">He olvidado mi contraseña actual</a>
                                    <input type="submit" id="submit-reset-pass" style="display: none">
                                </form>                                
                            </div>
                    </div>
                </div>
                <hr class="w-100 " style="margin-top: -15px;">
                
                
                <div class="notification-settings">
                    <div class="settings-info">
                        <h3>Configuración de Notificaciones</h3>
                        <p>Personalice sus preferencias de notificación.</p>
                    </div>
                    <div class="settings-options">
                        <form method="POST" action="{{ route('candidat.update.preferences') }}">
                            @csrf
                            <div class="option">
                                <label>
                                    <input type="checkbox" name="job_opportunities" value="yes" {{ isset($preferences) && $preferences->job_opportunities === 'yes' ? 'checked' : '' }}>
                                    <span>Comunicaciones de Oportunidades Laborales</span>
                                </label>
                                <p>Autorizo el uso de mi información para recibir notificaciones sobre nuevas ofertas y empleos a través de correo electrónico o llamadas telefónicas.</p>
                            </div>
                            
                            <div class="option">
                                <label>
                                    <input type="checkbox" name="newsletter" value="yes" {{ isset($preferences) && $preferences->newsletter === 'yes' ? 'checked' : '' }}>
                                    <span>Boletín Informativo</span>
                                </label>
                                <p>Deseo recibir correos electrónicos con actualizaciones e información relevante del sector laboral.</p>
                            </div>
                            
                            <div class="option">
                                <label>
                                    <input type="checkbox" name="privacy_consent" value="yes" {{ isset($preferences) && $preferences->privacy_consent === 'yes' ? 'checked' : '' }}>
                                    <span>Privacidad de la Información</span>
                                </label>
                                <p>
                                    Consiento el uso de mis datos personales para servicios de reclutamiento y selección, acepto que mis datos serán tratados de forma confidencial y almacenados conforme a las obligaciones legales, y tengo derecho a acceder, modificar o solicitar la eliminación de mis datos a través de la web 
                                    <a href="https://selectalent.es" target="_blank" rel="noopener noreferrer">selectalent.es</a>.
                                </p>
                            </div>
                            
                            <button type="submit" class="btn-primary2">Guardar preferencias</button>
                        </form>
                        <div class="close-account">
                            <a style="font-weight: 700" href="#" class="close-account-link" onclick="confirmarDesactivacion(); return false;">Desactivar cuenta</a>
                            <i style="margin-top: 6px;" class="fa-solid fa-circle-info"></i>
                        </div>
                    </div>
                </div>
                
                
            </section>
        </main>

    </div>
    <script src="{{ asset('js/profile-edit/my-profile.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    
    <script>
        const fileInput = document.getElementById("cv-file");
        const fileNameElement = document.querySelector(".file-name");
        const removeFileLink = document.querySelector(".remove-file");
        const pdfPreviewContainer = document.getElementById("pdf-preview-container");
        const existingFilePath = "<?php echo asset('storage/uploads/candidats_documents/' . Auth::user()->cv_file_path); ?>";
    
        // Charger un aperçu si un fichier existe
        async function loadExistingPdf() {
            if (existingFilePath) {
                pdfPreviewContainer.style.display = "block";
                pdfPreviewContainer.innerHTML = ""; // Clear container
    
                const response = await fetch(existingFilePath);
                const pdfData = new Uint8Array(await response.arrayBuffer());
                const pdf = await pdfjsLib.getDocument({ data: pdfData }).promise;
    
                for (let pageNumber = 1; pageNumber <= pdf.numPages; pageNumber++) {
                    const page = await pdf.getPage(pageNumber);
    
                    const canvas = document.createElement("canvas");
                    canvas.style.marginBottom = "20px";
                    pdfPreviewContainer.appendChild(canvas);
    
                    const viewport = page.getViewport({ scale: 1.2 });
                    canvas.width = viewport.width;
                    canvas.height = viewport.height;
    
                    const renderContext = {
                        canvasContext: canvas.getContext("2d"),
                        viewport,
                    };
                    await page.render(renderContext).promise;
                }
            }
        }
    
        // Appeler la fonction de chargement
        loadExistingPdf();
    
        // Gestion des nouveaux fichiers
        fileInput.addEventListener("change", async (event) => {
        const file = event.target.files[0];

        if (file && file.type === "application/pdf") {
            const formData = new FormData();
            formData.append("cv_file", file);

            try {
                const response = await fetch("{{ route('candidat.upload.cv') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}", // Token CSRF Laravel
                    },
                    body: formData,
                });

                const result = await response.json();

                if (result.success) {
                    // Afficher le nom du fichier
                    fileNameElement.textContent = result.fileName;
                    removeFileLink.style.display = "inline";

                    // Générer l'aperçu PDF
                    pdfPreviewContainer.style.display = "block";
                    pdfPreviewContainer.innerHTML = "";

                    const responsePDF = await fetch(result.filePath);
                    const pdfData = new Uint8Array(await responsePDF.arrayBuffer());
                    const pdf = await pdfjsLib.getDocument({ data: pdfData }).promise;

                    for (let pageNumber = 1; pageNumber <= pdf.numPages; pageNumber++) {
                        const page = await pdf.getPage(pageNumber);

                        const canvas = document.createElement("canvas");
                        canvas.style.marginBottom = "20px";
                        pdfPreviewContainer.appendChild(canvas);

                        const viewport = page.getViewport({ scale: 1.2 });
                        canvas.width = viewport.width;
                        canvas.height = viewport.height;

                        const renderContext = {
                            canvasContext: canvas.getContext("2d"),
                            viewport,
                        };
                        await page.render(renderContext).promise;
                    }
                } else {
                    alert("Erreur lors du téléchargement du fichier.");
                }
            } catch (error) {
                console.error("Erreur :", error);
                alert("Une erreur est survenue lors du téléchargement du fichier.");
            }
        } else {
            alert("Por favor, selecciona un archivo PDF válido.");
        }
    });

    
        // Suppression des fichiers
        removeFileLink.addEventListener("click", (event) => {
            event.preventDefault();
            fileInput.value = "";
            fileNameElement.textContent = "";
            removeFileLink.style.display = "none";
            pdfPreviewContainer.style.display = "none";
            pdfPreviewContainer.innerHTML = "";
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


        function confirmarDesactivacion() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas desactivar esta cuenta de candidato?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, desactivar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Créer et soumettre le formulaire
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{route("candidat.disactive.compte")}}';
                    
                    // Ajouter le token CSRF
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>


</body>
</html>
@endsection