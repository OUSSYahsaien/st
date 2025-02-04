@extends('layouts.candidat')

@section('title', 'Profile Candidat')

@section('page-title', 'Mi perfil')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Page divisée</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=translate" />
    <link rel="stylesheet" href="{{ asset('css/CandidatProfile.css') }}">
    <!-- jQuery (nécessaire pour Select2) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Select2 CSS et JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="left">

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
            
            <!-- Card 1 -->
            <div class="Fcard">
                <div class="cover-photo" id="currentBanner" style="{{ Auth::user()->avatar_path ? 'background: url(' . asset('images/candidats_baners/' . Auth::user()->avatar_path) . ') no-repeat; background-size: cover;' : '' }}">
                    <button class="edit-button" onclick="openModal()">
                        <i class="fa-regular fa-pen-to-square edit-banner-icon"></i>
                    </button>
                </div>
                
                @php
                    $personalPicturePath = 'images/candidats_images/' . Auth::user()->personal_picture_path;
                @endphp

                <div class="profile-content">    

                    @if (Auth::user()->personal_picture_path && file_exists(public_path($personalPicturePath)))
                        <img style="background: #fff;" src="{{ asset($personalPicturePath) }}" alt="Foto de perfil" class="profile-pic">
                    @else
                        <img id="profile-image" src="{{ asset('images/Avatar.png') }}" alt="Foto de perfil" class="profile-pic">
                    @endif
                    
                    <div class="profile-info">
                        <div class="cont" style="margin-top: 60px; margin-left: 99px; display: flex; flex-direction: column;">
                            <div class="name-button" style="display: flex; justify-content: space-between; align-items: center;">
                                <h1 class="profile-Fname">{{ Auth::user()->first_name . " " . Auth::user()->last_name  }}</h1>
                                <a href="{{ route('candidat.edit.profile') }}" style="text-decoration: none;">
                                    <button class="btn-edit-perfil" style="align-self: flex-end;">Editar perfil</button>
                                </a>
                            </div>
                            <p class="profile-role">
                                <strong>
                                    {{ Auth::user()->poste}} 
                                </strong>
                             </p>

                        </div>
                        
                        <div class="profile-location">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            {{ Auth::user()->adresse}}
                        </div>
                        

                        @if ( Auth::user()->priority == 'yes')
                            <div class="opportunities-badge">
                                <div class="flag-icon">
                                    <i class="fa-regular fa-flag"></i>
                                </div>
                                <div class="text-into-badge">
                                    ABIERTO A OPORTUNIDADES
                                </div>
                            </div>
                        @else
                            <div class="opportunities-badge-no">
                                <div class="flag-icon-no">
                                    <i class="fa-regular fa-flag"></i>
                                </div>
                                <div class="text-into-badge-no">
                                    CERRADO A OPORTUNIDADES
                                </div>
                            </div>
                        @endif
                                                    
                    </div>
                </div>
            </div>

            <div class="card" style="padding: 24px;">
                <div class="card-header">
                    <h2 class="card-title">Sobre mí</h2>
                    <div id="btn-edit-about" class="icon-container">
                        <i class="fa-regular fa-pen-to-square edit-icon"></i>
                    </div>
                </div>
                <div class="card-body mt-21">
                    <div class="about-content" style="">
                        @if($about && $about->description)
                            {{ $about->description }}
                        @else
                            <p>No hay descripción disponible en este momento.</p>
                        @endif
                    </div>
                </div>
            </div>



            <div class="card" style="padding: 24px;">
                <div class="card-header">
                    <h2 class="card-title">Experiencia</h2>
                    <div id="openModalUnique" class="icon-container" style="padding: 0.58rem;">
                        <i class="fa fa-plus edit-icon" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="card-body mt-21">
                    @foreach ($experiences as $index => $experience)
                        <div class="experience-item mt-21 {{ $index >= 2 ? 'hidden' : '' }}">
                            <div class="experience-title-btn-edit">
                                <h3>{{ $experience->post }}</h3>
                                <button class="btn-edit-experience" 
                                    data-id="{{ $experience->id }}" 
                                    data-company-name="{{ $experience->company_name }}" 
                                    data-post="{{ $experience->post }}" 
                                    data-location="{{ $experience->location }}" 
                                    data-begin-date="{{ $experience->begin_date }}" 
                                    data-end-date="{{ $experience->end_date }}" 
                                    data-description="{{ $experience->description }}" 
                                    data-work-type="{{ $experience->work_type }}">
                                <i class="fa-regular fa-pen-to-square edit-icon"></i>
                                </button>

                            </div>
                            <div class="experience-info">
                                <div class="company-name dot-after">
                                    {{ $experience->company_name }}
                                </div>
                                <div class="type-employement dot-after ml-10">
                                    {{ $experience->work_type }}
                                </div>
                                <div class="date-employement ml-10">
                                    {{ $experience->begin_date }} -
                                    {{ $experience->end_date ? $experience->end_date : 'Present' }}
                                </div>
                            </div>
                            <div class="employement-place">
                                {{ $experience->location }}
                            </div>
                            <div class="employement-description">
                                {{ $experience->description }}
                            </div>
                            @if ($index < count($experiences) - 1)
                                <hr style="color: #D7DCEB; margin-top: 21px; height: 1px;">
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="card-footer">
                    <span id="show-all-experiences">Mostrar todas las experiencias</span>
                </div>
            </div>

            <div class="card" style="padding: 24px;">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <h2 class="card-title">Educación</h2>
                    <div class="icon-container" id="AED-openPopup" style="padding: 0.58rem;">
                        <i class="fa fa-plus  edit-icon" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="card-body">
                    @foreach ($educations as $index => $education)
                            {{-- <div class="education-item mt-21 {{ $index >= 2 ? 'hidden' : '' }}"> --}}
                            <div class="education-item mt-21 {{ $index >= 2 ? 'hidden' : '' }}" data-education-id="{{ $education->id }}">
                                <!-- Affichage du logo de l'éducation -->
                                @if (isset($education) && $education->education_logo_path)
                                    <img src="{{ asset('images/education_logos/' . $education->education_logo_path) }}" class="education-place-logo" alt="Logo de l'université">
                                @else
                                    <img src="{{asset('images/companies_images/100x100.svg') }}" class="education-place-logo" alt="Logo de l'université">
                                @endif
                
                                <div>
                                    <!-- Nom de l'université -->
                                    <h3 class="education-place">{{ $education->university_name }}</h3>
                
                                    <!-- Sujet et dates -->
                                    <p class="education-branch">
                                        {{ $education->subject }}<br>
                                        {{ \Carbon\Carbon::parse($education->begin_date)->format('Y') }} - 
                                        {{ $education->end_date ? \Carbon\Carbon::parse($education->end_date)->format('Y') : 'Present' }}
                                    </p>
                
                                    <!-- Description de l'éducation -->
                                </div>
            
                                <button class="btn-edit-education">
                                    <i class="fa-regular fa-pen-to-square edit-icon"></i>
                                </button>
                            </div>

                            <p class="education-description  {{ $index >= 2 ? 'hidden' : '' }}">
                                {{ $education->description }}
                            </p>


                        @if ($index < count($educations) - 1)
                            <hr style="color: #D7DCEB; margin-top: 21px; height: 1px;">
                        @endif
                    @endforeach
                </div>
            
                    <div class="card-footer">
                        <span id="show-all-formations">
                            Mostrar todas las formaciones
                        </span>
                    </div>
            </div>
            
            
            
            
            <div class="card" style="padding: 24px;">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                  <h2 class="card-title">Skills</h2>
                  <div style="display: flex; gap: 8px; margin-left: auto;"> <!-- Conteneur pour les icônes -->
                    <div id="addSkillBtn" class="icon-container" style="padding: 0.58rem;">
                      <i class="fa fa-plus edit-icon" aria-hidden="true"></i>
                    </div>
                    <div id="editSkillBtn" class="icon-container" style="padding: 0.58rem;">
                      <i class="fa-regular fa-pen-to-square edit-icon"></i>
                    </div>
                  </div>
                </div>
                <div class="card-body" style="display: flex; gap: 15px; width: 87%; flex-wrap: wrap;">
                    @foreach ($skills as $index => $skill)
                        <div class="skill-item" style="padding: 6px;">
                            {{ $skill->description }}
                        </div>
                    @endforeach
                </div>
            </div>
              
        </div>

        <div class="right">
            <!-- Card 1 -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Detalles adicionales</h2>
                    <i id="btn-edit-da" onclick="openEditPopup() " class="fa-regular fa-pen-to-square edit-icon"></i>
                </div>
                <div class="card-body mt-21">
                    <div class="email-section">
                        <i class="fa-regular fa-envelope email-icon"></i>
                        <span class="email-label">Correo</span>
                    </div>
                    @if (Auth::user()->email)
                        <p class="email-text">{{ Auth::user()->email }}</p>
                    @else
                        <p class="email-text">No tienes un correo electrónico</p>
                    @endif
                    
                    <div class="tel-section mt-21">
                        <i class="fa fa-phone tel-icon" aria-hidden="true"></i>
                        <span class="tel-label">Teléfono</span>
                    </div>

                    
                    @if (Auth::user()->tel)
                        <p class="tel-text">{{ Auth::user()->tel }}</p>
                    @else
                        <p class="tel-text">no tienes tel</p>
                    @endif

                    
                    <div class="language-section mt-21">
                        {{-- <i class="fa fa-language language-icon" aria-hidden="true"></i> --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="language-icon size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m10.5 21 5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 0 1 6-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.785.147 2.666.257m-4.589 8.495a18.023 18.023 0 0 1-3.827-5.802" />
                          </svg>
                          
                        <span class="language-label">idiomas</span>
                    </div>
                    <p class="language-text">{{ $languagesString }}</p>
                </div>
            </div>
        
            <!-- Card 2 -->
            <div class="card ">
                <div class="card-header">
                    <h2 class="card-title">Enlaces sociales</h2>
                    <i  id="openPopup" class="fa-regular fa-pen-to-square edit-icon"></i>
                    {{-- <i class="fas fa-edit edit-icon"></i> --}}
                </div>
                <div class="card-body mt-21">

                    @if($linkedinLink)    
                        <div class="linkedin-section">
                            <i class="fa-brands fa-linkedin linkedin-icon"></i>
                            <span class="linkedin-label">LinkedIn</span>
                        </div>
                        <a href="#" class="linkedin-text">{{ $linkedinLink->link }}</a>
                    @else
                        <div class="linkedin-section">
                            <i class="fa-brands fa-linkedin linkedin-icon"></i>
                            <span class="linkedin-label">LinkedIn</span>
                        </div>
                        <a href="#" class="linkedin-text">No tienes un enlace</a>
                    @endif

                    @if($xLink)
                        <div class="X-section mt-21">
                            <svg class="X-icon" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="svg5" x="0px" y="0px" viewBox="0 0 1668.56 1221.19" style="enable-background:new 0 0 1668.56 1221.19;" xml:space="preserve">
                                <g id="layer1" transform="translate(52.390088,-25.058597)">
                                    <path id="path1009" d="M283.94,167.31l386.39,516.64L281.5,1104h87.51l340.42-367.76L984.48,1104h297.8L874.15,558.3l361.92-390.99   h-87.51l-313.51,338.7l-253.31-338.7H283.94z M412.63,231.77h136.81l604.13,807.76h-136.81L412.63,231.77z"/>
                                </g>
                            </svg>
                            <span class="X-label">X</span>
                        </div>
                        <a href="#" class="X-text"> {{ $xLink->link }}</a>
                    @else
                        <div class="X-section mt-21">
                            <svg class="X-icon" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="svg5" x="0px" y="0px" viewBox="0 0 1668.56 1221.19" style="enable-background:new 0 0 1668.56 1221.19;" xml:space="preserve">
                                <g id="layer1" transform="translate(52.390088,-25.058597)">
                                    <path id="path1009" d="M283.94,167.31l386.39,516.64L281.5,1104h87.51l340.42-367.76L984.48,1104h297.8L874.15,558.3l361.92-390.99   h-87.51l-313.51,338.7l-253.31-338.7H283.94z M412.63,231.77h136.81l604.13,807.76h-136.81L412.63,231.77z"/>
                                </g>
                            </svg>
                            <span class="X-label">X</span>
                        </div>
                        <a href="#" class="X-text">No tienes un enlace</a>
                    @endif

                    @if($websiteLink)
                        <div class="web-section mt-21">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 web-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                            </svg>                          
                            <span class="web-label">Sitio web</span>
                        </div>
                        <a href="#" class="web-text">{{ $websiteLink->link }}</a>
                    @else
                        <div class="web-section mt-21">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 web-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                            </svg>                          
                            <span class="web-label">Website</span>
                        </div>
                        <a href="#" class="web-text">No tienes un enlace</a>
                    @endif
                </div>
            </div>
        </div>
        
    </div>

    <div id="bannerModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Elija Banner</h2>
                <button class="close-button" onclick="closeModal()">&times;</button>
            </div>
            <div class="preset-banners" id="presetBanners"></div>
            <div class="upload-section">
                {{-- <h3>Upload Custom Banner</h3> --}}
                <input type="file" id="bannerUpload" accept="image/*" style="display: none">
                {{-- <button class="upload-button" onclick="document.getElementById('bannerUpload').click()">
                    Upload Image
                </button> --}}
            </div>
        </div>
    </div>


    <div id="popup" class="popup hdn">
        <div class="popup-content">
            <div class="popup-header">
                <h2>Enlaces sociales</h2>
                <button id="closePopup" class="close-button2">&times;</button>
            </div>
            
            <form action="{{ route('candidat.update.social.links') }}" method="post" id="socialForm">
                @csrf
                <div class="form-group">
                    <label for="linkedin">LinkedIn</label>
                    <input type="url" name="linkedin" id="linkedin" placeholder="Enter your LinkedIn profile" value="{{ $linkedinLink->link ?? '' }}">
                </div>
    
                <div class="form-group">
                    <label for="X">X</label>
                    <input type="text" name="x_handle" id="X" placeholder="Enter your X handle" value="{{ $xLink->link ?? '' }}">
                </div>
    
                <div class="form-group">
                    <label for="website">Sitio web</label>
                    <input type="url" name="website" id="website" placeholder="Enter your website URL" value="{{ $websiteLink->link ?? '' }}">
                </div>
    
                <button type="submit" class="submit-button">Guardar información</button>
            </form>
        </div>
    </div>


    <!-- Popup -->
    <div id="popupAddSkill" class="popupAddSkill hdn">
        <div class="popup-add-skill-content">
            <h3>Agregar una habilidad</h3>
            <form action="{{ route('candidat.add.skill') }}" method="post">
                @csrf
                <input type="text" id="newSkillInput" name="newSkillInput" class="skill-input" placeholder="Ingrese el nombre de la habilidad" />
                <div class="popup-add-skill-actions">
                    <button type="submit" id="saveSkillBtn" class="btn-save-add-skill">Mantener</button>
                    <button type="button" id="cancelSkillBtn" class="btn-cancel-add-skill">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    
    <!-- Popup -->
    <div id="popupEditSkills" class="popupEditSkills hdn">
        <div class="popup-edit-skills-content">
            <h3>Editar o eliminar habilidades</h3>
            <!-- Liste des compétences existantes -->
            <div class="skill-to-edit" style="">
                <input type="hidden" id="inp-skill-id" name="">
                        <input 
                            id="inp-skill-name"
                            type="text"
                            class="skill-input-edit" 
                        />
            </div>
            
            <div class="existing-skills" style="height: fit-content;">
                @foreach ($skills as $skill)
                    <div class="skill-item" style="width: fit-content; padding: 10px; " data-id="{{ $skill->id }}">
                        {{ $skill->description }}
                    </div>
                @endforeach
            </div>

            <div class="skill-to-edit-actions">  
                <button class="btn btn-edit-skil">Modificar</button>
                <button class="btn btn-delete-skil">Borrar</button>
            </div>

            <!-- Bouton de fermeture -->
            <button id="closeEditSkillsPopup" class="btn-close-popup">×</button>
        
        </div>
    </div>
    
    

    <!-- Formulaire de modification -->
    <form id="formEditSkill" action="{{ route('candidat.edit.skill') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="skill_id" id="form-skill-id-edit">
        <input type="hidden" name="skill_name" id="form-skill-name-edit">
    </form>

    <!-- Formulaire de suppression -->
    <form id="formDeleteSkill" action="{{ route('candidat.delete.skill') }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
        <input type="hidden" name="skill_id" id="form-skill-id-delete">
    </form>

   

    <!-- Popup -->
    <div id="editDetailsPopup" class="popup-container hidden">
        <div class="popup-box">
            <h3 class="popup-title">Editar detalles</h3>

            <form id="updateDetailsForm" action="/candidat/update-details" method="POST">
                @csrf
                <div class="popup-field">
                    <label for="phone" class="popup-label">Teléfono</label>
                    <input 
                        type="text" 
                        id="phone" 
                        name="phone" 
                        class="popup-input" 
                        placeholder="Introduzca el nuevo número de teléfono"
                        value="{{ Auth::user()->tel }}"
                    />
                </div>

                <!-- Modifier les langues -->
                <div class="popup-field">
                    <label for="languages" class="popup-label">Idiomas</label>
                    <select name="languages[]" id="languages" class="popup-input" multiple required>
                        <!-- Les options seront ajoutées dynamiquement via JavaScript -->
                    </select>
                </div>

                <!-- Conteneur pour afficher les langues sélectionnées -->
                <div class="selected-languages hdn">
                    <h4 class="selected-languages-title">Idiomas seleccionados :</h4>
                    <div id="languageContainer" class="language-container">
                        <!-- Les langues précédentes et nouvelles apparaîtront ici -->
                    </div>
                </div>

                <!-- Information pour l'email -->
                <div class="popup-info">
                    <label for="email" class="popup-label">Correo electrónico</label>
                    <p class="popup-description">
                        Para cambiar la dirección de correo electrónico, visite la página 
                        <a href="/candidat/edit/profile?o=t" class="popup-link">
                            Edición de perfil (Notifications y Cuenta)
                        </a>.
                    </p>
                </div>

                <!-- Boutons d'action -->
                <div class="popup-buttons">
                    <button type="submit" id="saveDetails" class="btnn btnn-primary">Guardar</button>
                    <button type="button" onclick="closeEditPopup()" id="closePopup" class="btnn btnn-secondary">Cancelar</button>
                </div>
            </form>
        </div>
    </div>



    <div class="popup-sobre-mi-container hidden">
        <div class="popup-sobre-mi-header">Sobre mí</div>
        <div class="popup-sobre-mi-description">Cuéntanos sobre ti y cómo puedes marcar la diferencia.</div>
        <form id="" action="{{ route('candidat.edit.about') }}" method="POST">
            @csrf
            <textarea name="ta_about" class="popup-sobre-mi-textarea" maxlength="3000" placeholder="Escribe aquí...">{{ isset($about) && $about->description ? $about->description : '' }}</textarea>
            <div class="popup-sobre-mi-actions">
            <button id="popup-sobre-mi-btn-delete" type="button" class="popup-sobre-mi-btn-delete">Cancelar</button>
            <button type="submit" class="popup-sobre-mi-btn-save">Guardar información</button>
            </div>
        </form>
    </div>
    <!-- Overlay -->
    <div class="popup-overlay fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>


    <div class="modal-unique" id="experienceModalUnique">
        <div class="modal-content-unique">
            <div class="modal-header-unique">
                <h2>Experiencia</h2>
                <button class="close-unique" id="closeModalUnique">&times;</button>
            </div>
            <form id="experienceForm" action="{{ route('candidat.add.experience') }}" method="POST">
                @csrf
                <div class="cnt-1">
                    <div class="form-group-unique">
                        <label for="companyNameUnique">Nombre de la empresa *</label>
                        <input type="text" id="companyNameUnique" name="company_name" required>
                    </div>
                    <div class="form-group-unique">
                        <label for="positionUnique">Cargo *</label>
                        <input type="text" id="positionUnique" name="post" required>
                    </div>
                </div>
                <div class="form-group-unique">
                    <label for="locationUnique">Ubicación de la empresa *</label>
                    <input type="text" id="locationUnique" name="location" required>
                </div>
                <div class="form-group-unique">
                    <label>Fecha de inicio *</label>
                    <input type="date" name="begin_date" required>
                </div>
                <div class="form-group-unique">
                    <label>Fecha de Finalización *</label>
                    <input type="date" name="end_date">
                    <label style="margin-top: 12px">
                        <input type="checkbox" name="current_job" value="1" style="margin-top: 6px"> Hasta la actualidad
                    </label>
                </div>
                <div class="form-group-unique">
                    <label>Tipo de empleo</label>
                    <div class="checkbox-group-unique">
                        <label><input onclick="hideNewWorkType()" type="radio" name="work_type" value="Tiempo completo" checked> Tiempo completo</label>
                        <label><input onclick="hideNewWorkType()" type="radio" name="work_type" value="Media jornada"> Media jornada</label>
                        <label><input onclick="hideNewWorkType()" type="radio" name="work_type" value="Remoto"> Remoto</label>
                        <label><input onclick="hideNewWorkType()" type="radio" name="work_type" value="Hibrido"> Híbrido</label>
                        <label><input onclick="hideNewWorkType()" type="radio" name="work_type" value="Jornada intensiva"> Jornada intensiva</label>
                        {{-- <label><input onclick="showNewWorkType()" type="radio" name="work_type" value="Otro"> Otro</label> --}}
                    </div>
                    <div id="new-work-type-section" class="new-work-type-section hidden">
                        <label style="margin-top: 12px;" for="newWorkType">Nuevo tipo de trabajo</label>
                        <input id="newWorkType" type="text" name="new_work_type">
                    </div>
                </div>
                <div class="form-group-unique">
                    <label for="detailsUnique">Detalles del empleo</label>
                    <textarea id="detailsUnique" name="description" maxlength="3000"></textarea>
                    <small>Máximo 3000 caracteres</small>
                </div>
                <div class="form-footer-unique">
                    <button type="submit" class="btn-save-unique">Guardar información</button>
                </div>
            </form>            
        </div>
    </div>










    <div class="AED-popup-overlay" id="AED-popupOverlay">
        <div class="AED-popup">
            <div class="AED-popup-header">
                <h2>Educación</h2>
                <button class="AED-close-btn" id="AED-closePopup">&times;</button>
            </div>
            <p class="AED-subtitle">Destaca tu sabiduría</p>
            
            <form id="AED-educationForm" action="{{ route('candidat.add.education') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="AED-form-row">
                    <div class="AED-form-group">
                        <label class="AED-label">Nombre de la Universidad <span class="AED-required">*</span></label>
                        <input class="AED-input" name="university_name" type="text" required>
                    </div>
                    <div class="AED-form-group">
                        <label class="AED-label">titulación <span class="AED-required">*</span></label>
                        <input class="AED-input" name="titulacion" type="text" required>
                    </div>
                </div>
    
                <div class="AED-form-row">
                    <div class="AED-form-group">
                        <label class="AED-label">Logo de la universidad</label>
                        <div class="AED-upload-box">
                            <input type="file" name="education_image" accept="image/*" style="display: none;" id="education_image">
                            <div class="AED-upload-preview">
                                <span class="AED-upload-icon">📎</span>
                                <span>Adjuntar logo</span>
                            </div>
                        </div>
                    </div>
                    <div class="AED-form-group">
                        <label class="AED-label">Fecha de inicio <span class="AED-required">*</span></label>
                        <input class="AED-input" name="begin_date" type="date" required>
                    </div>
                    <div class="AED-form-group">
                        <label class="AED-label">Fecha de Finalizacion <span class="AED-required">*</span></label>
                        <div class="AED-date-group">
                            <input name="end_date" class="AED-input" type="date" >
                            <label class="AED-checkbox-label">
                                <input name="current_job" value="1" type="checkbox">
                                <span>Hasta la actualidad</span>
                            </label>
                        </div>
                    </div>
                </div>
    
                <div class="AED-form-group">
                    <label class="AED-label">Detalles de la formación</label>
                    <div class="AED-rich-text-editor">
                        <textarea maxlength="500" name="description" placeholder="Máximo 500 caracteres"></textarea>
                        <div class="AED-char-count">0 / 500</div>
                    </div>
                </div>
    
                <div class="AED-form-actions">
                    <button type="submit" class="AED-btn-save">Guardar información</button>
                </div>
            </form>
        </div>
    </div>
    
    

    <div class="modal-unique" id="ModalEditExperience">
        <div class="modal-content-unique">
            <div class="modal-header-unique">
                <h2>Experiencia</h2>
                <button class="close-unique" id="closeModalEditExperience">&times;</button>
            </div>
            <form action="{{ route('candidat.edit.experience') }}" method="POST">
                @csrf
                <input type="hidden" name="experience_id" id="experienceIdUnique">

                <div class="cnt-1">
                    <div class="form-group-unique">
                        <label for="companyNameUnique">Nombre de la empresa *</label>
                        <input type="text" id="EcompanyNameUnique" name="company_name" required>
                    </div>
                    <div class="form-group-unique">
                        <label for="positionUnique">Cargo *</label>
                        <input type="text" id="EpositionUnique" name="post" required>
                    </div>
                </div>
                <div class="form-group-unique">
                    <label for="locationUnique">Ubicación de la empresa *</label>
                    <input type="text" id="ElocationUnique" name="location" required>
                </div>
                <div class="form-group-unique">
                    <label>Fecha de inicio *</label>
                    <input type="date" name="begin_date" id="Ebegin_date" required>
                </div>
                <div class="form-group-unique">
                    <label>Fecha de Finalización *</label>
                    <input type="date" name="end_date" id="Eend_date">
                    <label style="margin-top: 12px">
                        <input type="checkbox" name="current_job" value="1" style="margin-top: 6px"> Hasta la actualidad
                    </label>
                </div>
                <div class="form-group-unique">
                    <label>Tipo de empleo</label>
                    <div class="checkbox-group-unique">
                        <label><input onclick="EhideNewWorkType()" type="radio" name="Ework_type" id="Ework_type" value="Tiempo completo" checked> Tiempo completo</label>
                        <label><input onclick="EhideNewWorkType()" type="radio" name="Ework_type" id="Ework_type" value="Media jornada"> Media jornada</label>
                        <label><input onclick="EhideNewWorkType()" type="radio" name="Ework_type" id="Ework_type" value="Remoto"> Remoto</label>
                        <label><input onclick="EhideNewWorkType()" type="radio" name="Ework_type" id="Ework_type" value="Hibrido"> Híbrido</label>
                        <label><input onclick="EhideNewWorkType()" type="radio" name="Ework_type" id="Ework_type" value="Jornada intensiva"> Jornada intensiva</label>
                        {{-- <label><input onclick="EshowNewWorkType()" type="radio" name="Ework_type" id="Ework_type" value="Otro"> Otro</label> --}}
                    </div>
                    <div id="Enew-work-type-section" class="new-work-type-section hidden">
                        <label style="margin-top: 12px;" for="newWorkType">Nuevo tipo de trabajo</label>
                        <input id="EnewWorkType" type="text" name="Enew_work_type">
                    </div>
                </div>
                <div class="form-group-unique">
                    <label for="detailsUnique">Detalles del empleo</label>
                    <textarea name="description" id="EdetailsUnique" maxlength="3000"></textarea>
                    <small>Máximo 3000 caracteres</small>
                </div>
                <div class="form-footer-unique">
                    <button type="button" id="deleteExperiencee" onclick="deleteExperience()" class="btn-delete-unique">Eliminar</button>
                    <button type="submit" class="btn-save-unique">Guardar información</button>
                </div>
            </form>            
        </div>
    </div>




















    <div class="AED-popup-overlay" id="AED-editPopupOverlay">
        <div class="AED-popup">
            <div class="AED-popup-header">
                <h2>Modificar Educación</h2>
                <button class="AED-close-btn" id="AED-closeEditPopup">&times;</button>
            </div>
            <p class="AED-subtitle">Actualiza tu formación académica</p>
            
            <form id="AED-editEducationForm" action="{{ route('candidat.update.education') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="education_id" id="edit_education_id">
                
                <div class="AED-form-row">
                    <div class="AED-form-group">
                        <label class="AED-label">Nombre de la Universidad <span class="AED-required">*</span></label>
                        <input class="AED-input" name="university_name" id="edit_university_name" type="text" required>
                    </div>
                    <div class="AED-form-group">
                        <label class="AED-label">titulación <span class="AED-required">*</span></label>
                        <input class="AED-input" name="titulacion" id="edit_titulacion" type="text" required>
                    </div>
                </div>
    
                <div class="AED-form-row">
                    <div class="AED-form-group">
                        <label class="AED-label">Logo de la universidad</label>
                        <div class="AED-upload-box">
                            <input type="file" name="education_image" accept="image/*" style="display: none;" id="edit_education_image">
                            <div class="AED-upload-preview" id="edit_image_preview">
                                <span class="AED-upload-icon">📎</span>
                                <span>Adjuntar logo</span>
                            </div>
                        </div>
                    </div>
                    <div class="AED-form-group">
                        <label class="AED-label">Fecha de inicio <span class="AED-required">*</span></label>
                        <input class="AED-input" name="begin_date" id="edit_begin_date" type="date" required>
                    </div>
                    <div class="AED-form-group">
                        <label class="AED-label">Fecha de Finalizacion <span class="AED-required">*</span></label>
                        <div class="AED-date-group">
                            <input name="end_date" id="edit_end_date" class="AED-input" type="date">
                            <label class="AED-checkbox-label">
                                <input name="current_job" id="edit_current_job" value="1" type="checkbox">
                                <span>Hasta la actualidad</span>
                            </label>
                        </div>
                    </div>
                </div>
    
                <div class="AED-form-group">
                    <label class="AED-label">Detalles de la formación</label>
                    <div class="AED-rich-text-editor">
                        <textarea maxlength="500" name="description" id="edit_description" placeholder="Máximo 500 caracteres"></textarea>
                        <div class="AED-char-count">0 / 500</div>
                    </div>
                </div>
    
                <div class="AED-form-actions">
                    <button type="button" class="AED-btn-delete" id="delete-education">
                        <span class="AED-delete-icon">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </span>
                        Eliminar
                    </button>
                    <button type="submit" class="AED-btn-save">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
    
    
    
    
    
    
    
    

















    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
         const presetBanners = [
        '{{ asset('images/candidats_baners/baner-1.jpg') }}',
        '{{ asset('images/candidats_baners/baner-2.jpg') }}',
        '{{ asset('images/candidats_baners/baner-3.jpg') }}',
        '{{ asset('images/candidats_baners/baner-4.jpg') }}',
        '{{ asset('images/candidats_baners/baner-5.jpg') }}',
        '{{ asset('images/candidats_baners/baner-6.jpg') }}'
              ]


              function openModal() {
                    document.getElementById('bannerModal').classList.add('active');
                    document.body.classList.add('modal-open');
                }

                function closeModal() {
                    document.getElementById('bannerModal').classList.remove('active');
                    document.body.classList.remove('modal-open');
                }
        function selectUploadedBanner(url, imageName) {
            document.getElementById('currentBanner').style.background = "url("+url+")";
            document.getElementById('currentBanner').style.backgroundSize = "cover";

            // Modifier la valeur de avatar_path dans la base de données
            updateAvatarPath(url, imageName);
            
            closeModal();
        }


        function updateAvatarPath(imageUrl, imageName) {
            // Envoi de la requête AJAX pour mettre à jour la base de données
            fetch("{{ route('candidat.update.avatar') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    avatar: imageName // Passer le nom de l'image
                })
            })
            .then(response => response.json())
            .then(data => {
                // Vous pouvez ajouter un retour de succès ou d'erreur si nécessaire
                if (data.success) {
                    console.log("Avatar updated successfully");
                } else {
                    console.log("Error updating avatar");
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
        }

        function updateAvatarPath(imageUrl) {
            // Extraire le nom de l'image de l'URL
            const imageName = imageUrl.split('/').pop();

            // Envoi de la requête AJAX pour mettre à jour la base de données
            fetch("{{ route('candidat.update.avatar') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    avatar: imageName
                })
            })
            .then(response => response.json())
            .then(data => {
                // Vous pouvez ajouter un retour de succès ou d'erreur si nécessaire
                if (data.success) {
                    console.log("Avatar updated successfully");
                } else {
                    console.log("Error updating avatar");
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
        }

    
        // Handle custom upload
        document.getElementById('bannerUpload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageUrl = e.target.result;
                    const imageName = file.name; // Extraire le nom du fichier
                    selectUploadedBanner(imageUrl, imageName); // Passer l'URL et le nom de l'image à selectBanner
                };
                reader.readAsDataURL(file);
            }
        });
        
        // Close modal when clicking outside
        document.getElementById('bannerModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
        
        
        // Initialize preset banners
        const presetContainer = document.getElementById('presetBanners');
        presetBanners.forEach(url => {
            const div = document.createElement('div');
            div.className = 'preset-banner';
            div.innerHTML = `<img src="${url}" alt="Preset banner">`;
            div.onclick = () => selectBanner(url);
            presetContainer.appendChild(div);
        });
        
        function selectBanner(url) {
            document.getElementById('currentBanner').style.background = "url("+url+")";
            document.getElementById('currentBanner').style.backgroundSize = "cover";

            // Modifier la valeur de avatar_path dans la base de données
            updateAvatarPath(url);
            
            closeModal();
        }
    </script>



    <script>
        document.getElementById('show-all-experiences').addEventListener('click', function () {
            // Récupérer tous les éléments avec la classe "hidden"
            const hiddenExperiences = document.querySelectorAll('.experience-item.hidden');

            // Afficher tous les éléments masqués
            hiddenExperiences.forEach(function (item) {
                item.classList.remove('hidden');
            });

            // Cacher le bouton "Mostrar todas las experiencias"
            this.style.display = 'none';
        });
    </script>


    <script>
        document.getElementById('show-all-formations').addEventListener('click', function () {
            // Récupérer tous les éléments avec la classe "hidden"
            const hiddenFormations = document.querySelectorAll('.education-item.hidden');
            const hiddenDescreptions = document.querySelectorAll('.education-description.hidden');

            // Afficher tous les éléments masqués
            hiddenFormations.forEach(function (item) {
                item.classList.remove('hidden');
            });

            // Afficher tous les éléments masqués
            hiddenDescreptions.forEach(function (item) {
                item.classList.remove('hidden');
            });

            // Cacher le bouton "Mostrar todas las formaciones"
            this.style.display = 'none';
        });
    </script>
    

    <script>
        document.addEventListener('DOMContentLoaded', () => {
        const popup = document.getElementById('popup');
        const openButton = document.getElementById('openPopup');
        const closeButton = document.getElementById('closePopup');
        const socialForm = document.getElementById('socialForm');

        // Open popup
        openButton.addEventListener('click', () => {
            popup.classList.add('active');
            document.body.classList.add('modal-open');
        });

        // Close popup
        closeButton.addEventListener('click', () => {
            popup.classList.remove('active');
            document.body.classList.remove('modal-open');
        });

        // Close popup when clicking outside
        popup.addEventListener('click', (e) => {
            if (e.target === popup) {
                popup.classList.remove('active');
                document.body.classList.remove('modal-open');
            }
        });
    });
    document.addEventListener('DOMContentLoaded', () => {
            const alert = document.getElementById('success-alert');
            if (alert) {
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 3000); // L'alerte disparaîtra après 5 secondes
            }
        });
    document.addEventListener('DOMContentLoaded', () => {
        const alert2 = document.getElementById('custom-alert');
        if (alert2) {
            setTimeout(() => {
                alert2.style.display = 'none';
            }, 3000); // L'alerte disparaîtra après 5 secondes
        }
    });
    </script>




    <script>
        // Show the popup
        document.getElementById('addSkillBtn').addEventListener('click', function () {
            document.getElementById('popupAddSkill').classList.remove('hdn');
            document.body.classList.add('modal-open');
        });

        document.getElementById('editSkillBtn').addEventListener('click', function () {
            document.getElementById('popupEditSkills').classList.remove('hdn');
            document.body.classList.add('modal-open');
        });

        document.getElementById('btn-edit-da').addEventListener('click', function () {
            document.getElementById('popupEditDetails').classList.remove('hdn');

        });



        // Hide the popup on cancel
        document.getElementById('cancelSkillBtn').addEventListener('click', function () {
            document.getElementById('popupAddSkill').classList.add('hdn');
            document.body.classList.remove('modal-open');
        });

        document.getElementById('closeEditSkillsPopup').addEventListener('click', function () {
            document.getElementById('popupEditSkills').classList.add('hdn');
            document.body.classList.remove('modal-open');
        });
        
    </script>

    


    <script>
        // Variables pour les éléments du DOM
        const skillItems = document.querySelectorAll('.skill-item');
        const skillNameInput = document.getElementById('inp-skill-name');
        const skillIdInput = document.getElementById('inp-skill-id');
        const btnEditSkill = document.querySelector('.btn-edit-skil');
        const btnDeleteSkill = document.querySelector('.btn-delete-skil');
    
        // Désactiver les boutons au départ
        btnEditSkill.disabled = true;
        btnDeleteSkill.disabled = true;
    
        // Gestion des clics sur les compétences
        skillItems.forEach(skill => {
            skill.addEventListener('click', () => {
                // Récupération des données de la compétence cliquée
                const skillId = skill.getAttribute('data-id');
                const skillName = skill.textContent.trim();
    
                // Mise à jour des inputs
                skillIdInput.value = skillId;
                skillNameInput.value = skillName;
    
                // Activer les boutons
                btnEditSkill.disabled = false;
                btnDeleteSkill.disabled = false;
    
                // Mettre en surbrillance la compétence sélectionnée
                skillItems.forEach(item => item.style.backgroundColor = '');
                skill.style.backgroundColor = '#f0f0f0';
            });
        });
    
        // Fermer la popup
        document.getElementById('closeEditSkillsPopup').addEventListener('click', () => {
            document.getElementById('popupEditSkills').classList.add('hdn');
            document.body.classList.remove('modal-open');
        });
    </script>

<script>
    // Bouton Modifier
    btnEditSkill.addEventListener('click', () => {
        const skillId = skillIdInput.value;
        const skillName = skillNameInput.value;

        // Vérifier les données
        if (skillId && skillName) {
            document.getElementById('form-skill-id-edit').value = skillId;
            document.getElementById('form-skill-name-edit').value = skillName;
            document.getElementById('formEditSkill').submit();
        }
    });

    // Bouton Supprimer
    btnDeleteSkill.addEventListener('click', () => {
        const skillId = skillIdInput.value;

        // Vérifier les données
        if (skillId) {
            document.getElementById('form-skill-id-delete').value = skillId;
            document.getElementById('formDeleteSkill').submit();
        }
    });
</script>
    
    
    <script>
        // Gardez vos variables existantes
        const userLanguages = @json($languages);

        // Exemple d'API simulée pour récupérer les langues disponibles
        const fetchLanguages = () => {
            return @json($availableLanguages);
        };

        // Les langues déjà sélectionnées par l'utilisateur
        let selectedLanguages = userLanguages || [];

        // Fonction pour initialiser Select2
        const initializeSelect2 = () => {
            $('#languages').select2({
                width: '100%',
                multiple: true,
                placeholder: "Sélectionnez vos langues",
                language: {
                    noResults: () => "Aucune langue trouvée"
                }
            });

            // Écouteur d'événements pour la sélection/désélection
            $('#languages').on('change', function(e) {
                selectedLanguages = $(this).val() || [];
                updateLanguageContainer();
            });
        };

        // Fonction pour charger les langues dans le select
        const loadLanguages = () => {
            const languageSelect = document.getElementById("languages");
            const languages = fetchLanguages();

            languages.forEach((lang) => {
                const option = document.createElement("option");
                option.value = lang;
                option.textContent = lang;

                if (selectedLanguages.includes(lang)) {
                    option.selected = true;
                }

                languageSelect.appendChild(option);
            });

            // Initialiser Select2 après avoir chargé les options
            initializeSelect2();
            updateLanguageContainer();
        };

        // Fonction pour mettre à jour l'affichage des langues sélectionnées
        const updateLanguageContainer = () => {
            const languageContainer = document.getElementById("languageContainer");
            languageContainer.innerHTML = "";

            selectedLanguages.forEach((lang) => {
                const badge = document.createElement("div");
                badge.className = "language-badge";
                badge.innerHTML = `
                    ${lang} 
                    <span onclick="removeLanguage('${lang}')">&times;</span>
                `;
                languageContainer.appendChild(badge);
            });
        };

        // Fonction pour supprimer une langue
        const removeLanguage = (lang) => {
            selectedLanguages = selectedLanguages.filter((l) => l !== lang);
            // Mettre à jour Select2
            $('#languages').val(selectedLanguages).trigger('change');
            updateLanguageContainer();
        };

        // Fonctions pour le popup
        function openEditPopup() {
            document.getElementById('editDetailsPopup').classList.remove('hidden');
            document.body.classList.add('modal-open');
        }

        function closeEditPopup() {
            document.getElementById('editDetailsPopup').classList.add('hidden');
            document.body.classList.remove('modal-open');
        }

        // Charger les langues au démarrage
        $(document).ready(function() {
            loadLanguages();
        });
    </script>

    <script>
        // Get the button, popup container, and overlay
        const btnEditAbout = document.getElementById('btn-edit-about');
        const popupContainer = document.querySelector('.popup-sobre-mi-container');
        const popupOverlay = document.querySelector('.popup-overlay');
    
        // Event listener for showing the popup
        btnEditAbout.addEventListener('click', () => {
        popupContainer.style.display = 'block'; // Show the popup
        popupOverlay.style.display = 'block'; // Show the overlay
        document.body.classList.add('modal-open');
        document.body.style.backgroundColor = '#d3d3d3'; // Change the background color of the body
        });
    
        // Event listener for closing the popup when clicking on the overlay
        document.getElementById("popup-sobre-mi-btn-delete").addEventListener('click', () => {
        popupContainer.style.display = 'none'; // Hide the popup
        popupOverlay.style.display = 'none'; // Hide the overlay
        document.body.classList.remove('modal-open');
        document.body.style.backgroundColor = '#fff'; // Reset the body background color
        });
    </script>
    

    <script>
        const modalUnique = document.getElementById('experienceModalUnique');
        const openModalUnique = document.getElementById('openModalUnique');
        const closeModalUnique = document.getElementById('closeModalUnique');
    
        openModalUnique.addEventListener('click', () => {
            modalUnique.style.display = 'flex';
            document.body.classList.add('modal-open');
        });
    
        closeModalUnique.addEventListener('click', () => {
            modalUnique.style.display = 'none';
            document.body.classList.remove('modal-open');
        });
    
        window.addEventListener('click', (event) => {
            if (event.target === modalUnique) {
                modalUnique.style.display = 'none';
                document.body.classList.remove('modal-open');
            }
        });


        const showNewWorkType = () => {
            document.getElementById("new-work-type-section").style.display = 'block';
        };

        const EshowNewWorkType = () => {
            document.getElementById("Enew-work-type-section").style.display = 'block';
        };

        const hideNewWorkType = () => {
            document.getElementById("new-work-type-section").style.display = 'none';
        };

        const EhideNewWorkType = () => {
            document.getElementById("Enew-work-type-section").style.display = 'none';
        };

        
        
    </script>
    
    
    
    


    {{-- edit expirience script --}}

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editButtons = document.querySelectorAll('.btn-edit-experience');
            const modal = document.getElementById('ModalEditExperience');

            // Inputs du formulaire
            const companyNameInput = document.getElementById('EcompanyNameUnique');
            const positionInput = document.getElementById('EpositionUnique');
            const locationInput = document.getElementById('ElocationUnique');
            const beginDateInput = document.getElementById('Ebegin_date');
            const endDateInput = document.getElementById('Eend_date');
            const descriptionTextarea = document.getElementById('EdetailsUnique');
            const workTypeRadios = modal.querySelectorAll('input[name="Ework_type"]');

            let currentExperienceId = null;

            editButtons.forEach(button => {
                button.addEventListener('click', () => {
                    modal.style.display = 'flex';
                    document.body.classList.add('modal-open');
                    currentExperienceId = button.getAttribute('data-id');

                    // Récupérer les données de l'expérience depuis les attributs du bouton
                    const experienceIdInput = document.getElementById('experienceIdUnique');
                    const companyName = button.getAttribute('data-company-name');
                    const post = button.getAttribute('data-post');
                    const location = button.getAttribute('data-location');
                    const beginDate = button.getAttribute('data-begin-date');
                    const endDate = button.getAttribute('data-end-date');
                    const description = button.getAttribute('data-description');
                    const workType = button.getAttribute('data-work-type');

                    // Remplir les champs du formulaire
                    experienceIdInput.value = currentExperienceId;
                    companyNameInput.value = companyName;
                    positionInput.value = post;
                    locationInput.value = location;
                    beginDateInput.value = beginDate;
                    endDateInput.value = endDate || '';
                    descriptionTextarea.textContent = description;

                    // Sélectionner le bon type d'emploi
                    workTypeRadios.forEach(radio => {
                        if (radio.value === workType) {
                            radio.checked = true;
                        }
                    });
                });
            });

            // Fonction de suppression
            window.deleteExperience = async function() {
                if (!currentExperienceId) return;
                
                Swal.fire({
                    title: '¿Está seguro?',
                    text: "¡Esta acción es irreversible!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, borrar!',
                    cancelButtonText: 'Cancelar'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        try {
                            const response = await fetch(`/candidat/experience/${currentExperienceId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                }
                            });

                            if (response.ok) {
                                Swal.fire(
                                    '¡Eliminado!',
                                    'El experimento fue eliminado exitosamente.',
                                    'success'
                                ).then(() => {
                                    modal.style.display = 'none';
                                    document.body.classList.remove('modal-open');
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Erreur!',
                                    'Une erreur est survenue lors de la suppression.',
                                    'error'
                                );
                            }
                        } catch (error) {
                            console.error('Erreur:', error);
                            Swal.fire(
                                'Erreur!',
                                'Une erreur est survenue lors de la suppression.',
                                'error'
                            );
                        }
                    }
                });
            };

                    // Bouton pour fermer le modal
                    const closeModalButton = document.getElementById('closeModalEditExperience');
                    closeModalButton.addEventListener('click', () => {
                        modal.style.display = 'none';
                        document.body.classList.remove('modal-open');
                    });

                    // Fermer le modal si on clique en dehors
                    window.addEventListener('click', (event) => {
                        if (event.target === modal) {
                            modal.style.display = 'none';
                            document.body.classList.remove('modal-open');
                        }
                    });
                });
    </script>
    
    





    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const openPopupBtn = document.getElementById('AED-openPopup');
            const closePopupBtn = document.getElementById('AED-closePopup');
            const popupOverlay = document.getElementById('AED-popupOverlay');
            const form = document.getElementById('AED-educationForm');
            const textarea = form.querySelector('textarea');
            const charCount = form.querySelector('.AED-char-count');
            const uploadBox = form.querySelector('.AED-upload-box');
            const fileInput = document.getElementById('education_image');
            const uploadPreview = form.querySelector('.AED-upload-preview');

            // Gestion de l'ouverture/fermeture du popup
            openPopupBtn.addEventListener('click', () => {
                popupOverlay.style.display = 'flex';
                document.body.style.overflow = 'hidden'; // Empêche le défilement du body

            });

            closePopupBtn.addEventListener('click', () => {
                popupOverlay.style.display = 'none';
                document.body.style.overflow = '';
            });

            popupOverlay.addEventListener('click', (e) => {
                if (e.target === popupOverlay) {
                    popupOverlay.style.display = 'none';
                    document.body.style.overflow = '';
                }
            });

            // Gestion du compteur de caractères
            textarea.addEventListener('input', () => {
                const length = textarea.value.length;
                charCount.textContent = `${length} / 500`;
            });

            // Gestion du upload
            uploadBox.addEventListener('click', () => {
                fileInput.click();
            });

            uploadBox.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadBox.style.borderColor = getComputedStyle(document.documentElement).getPropertyValue('--primary-color');
            });

            uploadBox.addEventListener('dragleave', () => {
                uploadBox.style.borderColor = getComputedStyle(document.documentElement).getPropertyValue('--border-color');
            });

            uploadBox.addEventListener('drop', (e) => {
                e.preventDefault();
                const file = e.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    handleFile(file);
                }
            });

            fileInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    handleFile(file);
                }
            });

            function handleFile(file) {
                // Mise à jour de l'affichage
                uploadPreview.innerHTML = `
                    <span class="AED-upload-icon">✓</span>
                    <span>${file.name}</span>
                `;
                uploadBox.classList.add('success');

               
            }
        });

    </script>
    
    

















    <script>
        document.addEventListener('DOMContentLoaded', () => {
    const editPopupOverlay = document.getElementById('AED-editPopupOverlay');
    const closeEditPopupBtn = document.getElementById('AED-closeEditPopup');
    const editForm = document.getElementById('AED-editEducationForm');
    const editButtons = document.querySelectorAll('.btn-edit-education');
    const deleteButton = document.getElementById('delete-education');


    // Configuration des alertes SweetAlert2
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });

    // Fonction pour les notifications de succès
    const showSuccess = (message) => {
        Toast.fire({
            icon: 'success',
            title: message
        });
    };

    // Fonction pour les notifications d'erreur
    const showError = (message) => {
        Toast.fire({
            icon: 'error',
            title: message
        });
    };



    // Gestionnaires d'événements pour fermer le modal
    closeEditPopupBtn.addEventListener('click', () => {
        editPopupOverlay.style.display = 'none';
        document.body.style.overflow = '';
    });

    editPopupOverlay.addEventListener('click', (e) => {
        if (e.target === editPopupOverlay) {
            editPopupOverlay.style.display = 'none';
            document.body.style.overflow = '';
        }
    });

    // Gestion du compteur de caractères pour la description
    const editTextarea = editForm.querySelector('textarea');
    const editCharCount = editForm.querySelector('.AED-char-count');
    editTextarea.addEventListener('input', () => {
        const length = editTextarea.value.length;
        editCharCount.textContent = `${length} / 500`;
    });

    // Gestion du upload d'image
    const editUploadBox = editForm.querySelector('.AED-upload-box');
    const editFileInput = document.getElementById('edit_education_image');
    const editImagePreview = document.getElementById('edit_image_preview');

    editUploadBox.addEventListener('click', () => {
        editFileInput.click();
    });

    editFileInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            handleEditFile(file);
        }
    });

    function handleEditFile(file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            editImagePreview.innerHTML = `
                <img src="${e.target.result}" alt="Preview" style="max-width: 100px; max-height: 100px;">
                <span>${file.name}</span>
            `;
        };
        reader.readAsDataURL(file);
    }

    // Gestion du bouton "Hasta la actualidad"
    const currentJobCheckbox = document.getElementById('edit_current_job');
    const endDateInput = document.getElementById('edit_end_date');

    currentJobCheckbox.addEventListener('change', () => {
        endDateInput.disabled = currentJobCheckbox.checked;
        if (currentJobCheckbox.checked) {
            endDateInput.value = '';
        }
    });

    // Gestion des boutons d'édition
    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            const educationItem = button.closest('.education-item');
            const educationId = educationItem.dataset.educationId;
            
            // Récupération des données
            fetch(`education/${educationId}/edit`)
                .then(response => response.json())
                .then(data => {
                    // Remplissage du formulaire
                    document.getElementById('edit_education_id').value = data.id;
                    document.getElementById('edit_university_name').value = data.university_name;
                    document.getElementById('edit_titulacion').value = data.subject;
                    document.getElementById('edit_begin_date').value = data.begin_date;
                    document.getElementById('edit_end_date').value = data.end_date || '';
                    document.getElementById('edit_current_job').checked = !data.end_date;
                    document.getElementById('edit_description').value = data.description || '';
                    
                    // Mise à jour du compteur de caractères
                    const length = data.description ? data.description.length : 0;
                    editCharCount.textContent = `${length} / 500`;

                    // Affichage de l'image existante si présente
                    if (data.education_logo_path) {
                        editImagePreview.innerHTML = `
                            <img src="/images/education_logos/${data.education_logo_path}" 
                                 alt="Logo actuel" 
                                 style="max-width: 100px; max-height: 100px;">
                            <span>Logo actuel</span>
                        `;
                    }

                    // Afficher le modal
                    editPopupOverlay.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                });
        });
    });





    deleteButton.addEventListener('click', () => {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4339F2',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'btn btn-primary me-3',
                cancelButton: 'btn btn-danger'
            },
        }).then((result) => {
            if (result.isConfirmed) {
                const educationId = document.getElementById('edit_education_id').value;
                fetch(`/candidat/education/${educationId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: '¡Eliminado!',
                            text: 'La formación ha sido eliminada.',
                            icon: 'success',
                            confirmButtonColor: '#4339F2'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        showError('Error al eliminar la formación');
                    }
                })
                .catch(error => {
                    showError('Error de conexión');
                    console.error('Error:', error);
                });
            }
        });
    });
});
    </script>
    
</body>
</html>

@endsection

