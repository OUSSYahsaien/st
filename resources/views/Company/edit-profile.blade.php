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
        <link rel="stylesheet" href="{{ asset('css/Company/edit-profile.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <body>
        
        <div class="EC-container">
            <h1>Ajustes</h1>
            
            <nav class="EC-tabs">
                <a href="#vision" class="EC-tab-link EC-active" data-tab="vision">visión general</a>
                <a href="#social" class="EC-tab-link" data-tab="social">Social Links</a>
                <a href="#team" id="team-section" class="EC-tab-link" data-tab="team">Equipo</a>
                <a href="#account" class="EC-tab-link" data-tab="account">Cuenta</a>
            </nav>
        
            <div class="EC-tab-content" id="vision" style="display: block;">
                <div class="EC-content">
                    <h2>Información básica</h2>
                    <p class="EC-subtitle">Esta es información de la empresa que puede actualizar en cualquier momento.</p>
        
                    <hr style="color: #D6DDEB; margin-top: -10px; margin-bottom: 18px;">

                    <div class="EC-logo-section">
                        <div class="EC-logo-info">
                            <h2>Logotipo de la empresa</h3>
                            <p>Esta imagen solo la verán los <br>
                                 administradores y su pagina nunca
                                 <br> se figurara en la web</p>
                        </div>
                        
                        <div class="EC-logo-upload-container">
                            <div class="EC-current-logo">
                                <img 
                                    src="{{ Auth::user()->personel_pic && file_exists(public_path('images/companies_images/' . Auth::user()->personel_pic)) 
                                            ? asset('images/companies_images/' . Auth::user()->personel_pic) 
                                            : asset('images/companies_images/100x100.svg') }}" 

                                    alt="Current logo" 
                                    id="currentLogo">
                            </div>                            
                            
                            <div class="EC-upload-area" id="uploadArea">
                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'%3E%3Cpath fill='%234F46E5' d='M4 5h13v7h2V5c0-1.103-.897-2-2-2H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h8v-2H4V5z'/%3E%3Cpath fill='%234F46E5' d='M8 11l-3 4h11l-4-6-3 4z'/%3E%3C/svg%3E" alt="Upload icon">
                                <span>Haga clic para reemplazar</span>
                                <span class="EC-upload-hint">o arrastrar y soltar</span>
                                <span class="EC-file-types">SVG, PNG, o JPG (max. 400 x 400px)</span>
                                <input type="file" id="fileInput" accept="image/*" hidden>
                            </div>
                        </div>
                    </div>
                    <hr style="color: #D6DDEB; margin-top: 15px; margin-bottom: 12px;">
                </div>

                <section class="company-details">
                    <h2>Detalles de la empresa</h2>
                    <p class="subtitle">Introduce la información básica de tu empresa</p>
    
                    <form class="company-form" style="margin-top: 15px">
                        <div class="form-group">
                            <label for="company-name">Nombre de la empresa</label>
                            <input type="text" id="company-name" name="company_name" value="{{Auth::user()->name ? Auth::user()->name : '' }}" placeholder="Nombre de la empresa">
                        </div>
    
                        <div class="form-group">
                            <label for="website">Pagina web</label>
                            <input type="url" id="website"  name="website" value="{{Auth::user()->website ? Auth::user()->website : '' }}" placeholder="https://">
                        </div>
    
                        <div class="form-group">
                            <label>Ubicación</label>
                            <div class="location-tags" id="locationTags">
                                @if (Auth::user()->city)
                                    <span class="tag" id="cityTag">
                                        {{ Auth::user()->city }}
                                        <button type="button" class="tag-remove" id="removeCity">×</button>
                                    </span>
                                    <input type="hidden" name="city_name" id="city_name" value="{{Auth::user()->city}}">
                                @else
                                    <input type="text" class="form-control" id="cityInput" name="city" placeholder="Ingrese la ubicación">
                                @endif
                            </div>
                        </div>
                        
    
                        <div class="form-row">
                            <div class="form-group">
                                <label for="employees">Empleados</label>
                                <select id="employees" name="nbr-emps" class="form-control">
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="1" {{ Auth::user()->staf_nbr == 1 ? 'selected' : '' }}>1 - 50</option>
                                    <option value="2" {{ Auth::user()->staf_nbr == 2 ? 'selected' : '' }}>51 - 200</option>
                                    <option value="3" {{ Auth::user()->staf_nbr == 3 ? 'selected' : '' }}>201 - 500</option>
                                    <option value="4" {{ Auth::user()->staf_nbr == 4 ? 'selected' : '' }}>500+</option>
                                </select>
                            </div>                            
    
                            {{-- <script>
                                function lsls (){
                                    alert(document.getElementById('employees').value)
                                }
                            </script> --}}
                            <div class="form-group">
                                <label for="sector">Sector de actividad</label>
                                <select id="sector" name="sector" class="form-control">
                                    <option value="" disabled selected>Seleccione un sector</option>
                                    @foreach ($sectors as $sector)
                                        <option value="{{ $sector->id }}"
                                                       {{ $sector->id == Auth::user()->secteur_id ? 'selected' : '' }}>
                                                       {{ $sector->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                        </div>
    
                        <div class="form-group date-group">
                            <label for="creation-date">Fecha de creación</label>
                            <div class="date-inputs">
                                <!-- Sélection des jours -->
                                <select id="day-select" name="day" class="date-select">
                                    @foreach ($daysOptions as $day)
                                        <option value="{{ $day }}" {{ $day == $selectedDay ? 'selected' : '' }}>
                                            {{ $day }}
                                        </option>
                                    @endforeach
                                </select>
                        
                                <!-- Sélection des mois -->
                                <select id="month-select" name="month" class="date-select" onchange="updateDays()">
                                    @foreach ($monthsOptions as $monthNumber => $monthName)
                                        <option value="{{ $monthNumber }}" {{ $monthNumber == $selectedMonth ? 'selected' : '' }}>
                                            {{ $monthName }}
                                        </option>
                                    @endforeach
                                </select>
                        
                                <!-- Sélection des années -->
                                <select id="year-select" name="year" class="date-select" onchange="updateDays()">
                                    @for ($year = date('Y') - 50; $year <= date('Y'); $year++)
                                        <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        
                        
                    </form>
                    <hr style="color: #D6DDEB; margin-top: 3px; margin-bottom: 0px;">
                </section>


                <section class="company-description">
                    <div class="form-container">
                        <label for="description" class="form-label">Descripción de la empresa</label>
                        <p class="form-subtext">Breve descripción de su empresa. URLs están hipervinculados.</p>
                        <label class="form-label" style="margin-top: 10px">Descripción</label>
                        <textarea id="description" name="description" class="form-textarea" maxlength="500" placeholder="Escriba aquí...">@if (@isset($aboutCompany) && $aboutCompany->description){{$aboutCompany->description }}@else No hay descripción @endif</textarea>
                        <div class="character-count">0 / 500</div>
                        <button class="save-button" id="saveButton">Guardar información</button>
                    </div>
                </section>

            </div>
        
            <div class="EC-tab-content" id="social">
                <div class="EC-content w-2-b" style="display: flex; width: 100%; justify-content: space-between;">
                    <div class="" style="flex: 1;">
                        <h2>Redes sociales corporate</h2>
                        <p class="EC-subtitle">Añadir enlaces a su perfil de la empresa. <br>
                            Puede agregar solo nombre de usuario <br> sin enlaces https completos.</p>
                    </div>
                    <div class="EC-social-links" style="flex: 2;">

                        <form action="{{route('company.update.social.links')}}" method="post">
                            @csrf
                            @foreach($socialLinks as $link)
                                @if($link->type == 'email')
                                    <div class="EC-input-group">
                                        <label> Correo electrónico </label>
                                        <input value="{{ $link->value }}"  name="links[{{ $link->type }}]"  value="{{$link->value}}" type="email" placeholder="xyz.contact@gmail.com">
                                    </div>
                                @elseif ($link->type == 'phone')
                                    <div class="EC-input-group">
                                        <label> Teléfono </label>
                                        <input value="{{ $link->value }}"  name="links[{{ $link->type }}]"  value="{{$link->value}}" type="text" placeholder="023424234">
                                    </div>
                                @elseif ($link->type == 'linkedin')
                                    <div class="EC-input-group">
                                        <label>LinkedIn</label>
                                        <input value="{{ $link->value }}"  name="links[{{ $link->type }}]"  value="{{$link->value}}" type="url" placeholder="https://linkedin.com/in/xyz">
                                    </div>
                                @elseif ($link->type == 'facebook')
                                    <div class="EC-input-group">
                                        <label>Facebook</label>
                                        <input value="{{ $link->value }}"  name="links[{{ $link->type }}]"  value="{{$link->value}}" type="url" placeholder="https://facebook.com/xyz">
                                    </div>
                                @endif
                                @endforeach
                                <div class="EC-input-group">
                                    <button type="submit" style="padding: 12px 18px; float: right; margin-top: 12px; background-color: #4F26DD; color: white; font-weight: 700; border: none; cursor: pointer;">
                                        Guardar información
                                    </button>
                                </div>
                        </form>

                    </div>
                </div>
            </div>
        
            <div class="EC-tab-content" id="team">
                <div class="EC-content w-3-d-f">
                    <div style="flex: 1;">
                        <h2 style="font-size: 14px">Nuestro equipo</h2>
                        <p class="EC-subtitle">Añadir miembros del equipo de  <br> su  empresa</p>
                    </div>
                    <div style="flex: 2;" class="EC-team-members">
                        <div style="display: flex; justify-content: space-between;">
                            <div class="text-700-black">{{$count}} miembros</div>
                            <a href="{{ route('company.add.in.equipe') }}" style="text-decoration: none;">
                                <button class="EC-add-member"><i class="fa fa-plus" aria-hidden="true"></i> Añadir miembros</button>
                            </a>
                        </div>
                        <div class="EC-member-list" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
                            @foreach($teamMembers as $teamMember)
                                <div class="EC-member-card">
                                    <div class="card-icons">
                                        <a href="{{ route('company.view.team.member', ['id' => $teamMember->id]) }}" class="social-link">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>                                        
                                        <a href="{{ route('company.edit.in.equipe', ['id' => $teamMember->id]) }}" href="#" class="social-link">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    <img src="{{ $teamMember->personel_pic ? asset('images/team_images/' . $teamMember->personel_pic) : 'https://placehold.co/96x96' }}" alt="Team member   ">
                                    <div class="EC-member-info">
                                        {{ $teamMember->full_name }}
                                        @if($teamMember->role == 'responsable')
                                            (YO)
                                        @endif
                                        <p>{{ $teamMember->poste }}</p>
                                    </div>
                                    <div class="team-member-social">
                                        <a  class="social-link">
                                            <i class="fas fa-phone"></i>
                                        </a>
                                        <a class="social-link">
                                            <i class="fab fa-linkedin"></i>
                                        </a>
                                        <a class="social-link">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
        
            <div class="EC-tab-content" id="account">
                <div class="EC-content">
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
                            <h2 class="text-18">Información de cuenta</h2>
                            <p class="subtitle mt-6 text-14">Esto es la informacion para iniciar session como empresa.</p>
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
                                    <p class="email-address" style="font-size: 14px; margin-top: 12px; margin-bottom: 0px; font-weight: 600">Correo electrónico de actualización</p>
                                </div>
                                <div class="update-email-form">
                                    <label for="new-email" class="sr-only">Correo electrónico de actualización</label>
                                    <form style="max-width: 400px;" method="post" action="{{ route('company.edit.email') }}">
                                        @csrf
                                        <input
                                        style="width: 100%;"
                                            type="email"
                                            id="new-email"
                                            name="email"
                                            class="email-input"
                                            placeholder="Introduzca su nuevo correo electrónico"
                                        />
                                        <button style="display: block; margin-top: 12px;" type="submit" class="update-button">Cambiar el correo</button>
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
                                <form style="" method="post" action="{{ route('company.edit.password') }}">
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
                                        <form action="{{ route('company.password.email') }}" method="POST">
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
                                <form method="POST" action="{{ route('company.update.preferences') }}">
                                    @csrf
                                    <div class="option">
                                        <label>
                                            <input type="checkbox" name="first" value="yes" {{ isset($preferences) && $preferences->first === 'yes' ? 'checked' : '' }}>
                                            <span>Estos son permisos que el clientre tiene que dar</span>
                                        </label>
                                        <p>Autorizo el uso de mi información para recibir notificaciones sobre nuevas ofertas y empleos a través de correo electrónico o llamadas telefónicas.</p>
                                    </div>
                                    
                                    <div class="option">
                                        <label>
                                            <input type="checkbox" name="second" value="yes" {{ isset($preferences) && $preferences->second === 'yes' ? 'checked' : '' }}>
                                            <span>Estos son permisos que el clientre tiene que dar</span>
                                        </label>
                                        <p>Deseo recibir correos electrónicos con actualizaciones e información relevante del sector laboral.</p>
                                    </div>
                                    
                                    <div class="option">
                                        <label>
                                            <input type="checkbox" name="third" value="yes" {{ isset($preferences) && $preferences->third === 'yes' ? 'checked' : '' }}>
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
                                    <i class="fa-solid fa-circle-info"></i>
                                </div>
                            </div>
                        </div>
                        
                        
                    </section>
                </div>
            </div>
        </div>
        

        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
        <script src="{{ asset('js/company/profile-2.js') }}"></script>
        
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Vérifier si l'URL contient le paramètre 'o=t'
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.get('o') === 't') {
                    // Trouver le bouton et déclencher un clic
                    const button = document.getElementById("team-section");
                    if (button) {
                        button.click();
                    }
                }
            });
        </script>

        <script>
            function updateDays() {
                // Obtenir les sélections du mois et de l'année
                const month = parseInt(document.getElementById('month-select').value);
                const year = parseInt(document.getElementById('year-select').value);
                const daySelect = document.getElementById('day-select');

                // Calculer le nombre de jours dans le mois sélectionné
                const daysInMonth = new Date(year, month, 0).getDate();

                // Vider les options actuelles
                daySelect.innerHTML = '';

                // Ajouter les nouveaux jours
                for (let day = 1; day <= daysInMonth; day++) {
                    const option = document.createElement('option');
                    option.value = day;
                    option.textContent = day;

                    // Rétablir la sélection si le jour actuel est déjà sélectionné
                    if (day == {{ $selectedDay ?? 'null' }}) {
                        option.selected = true;
                    }

                    daySelect.appendChild(option);
                }
            }

            // Appeler updateDays() une fois pour s'assurer que tout est synchronisé
            document.addEventListener('DOMContentLoaded', updateDays);

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
                        form.action = '{{route("company.disactive.compte")}}';
                        
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