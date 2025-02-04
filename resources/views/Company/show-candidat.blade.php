@extends('layouts.company')

@section('title', 'Profile Candidat')

@section('page-title', 'Mis solicitudes')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=translate" />
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <link rel="stylesheet" href="{{ asset('css/CandidatProfile.css') }}">

    
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
                <div class="cover-photo" id="currentBanner" style="{{ $candidat->avatar_path ? 'background: url(' . asset('images/candidats_baners/' . $candidat->avatar_path) . ') no-repeat; background-size: cover;' : '' }}">
                    <div class="status-app">
                        <span class="status-badge-app {{$application->status}}">
                            {{$application->status}}
                        </span>
                    </div>
                </div>
                
                @php
                    $personalPicturePath = 'images/candidats_images/' . $candidat->personal_picture_path;
                @endphp

                <div class="profile-content">    
                    @if($application->status == "Seleccionado")
                        <img style="filter: blur(4px);" id="profile-image" src="{{ asset('images/companies_images/100x100.svg') }}" alt="Foto de perfil" class="profile-pic">
                    @else
                        @if ($candidat->personal_picture_path && file_exists(public_path($personalPicturePath)))
                            <img style="background: #fff;" src="{{ asset($personalPicturePath) }}" alt="Foto de perfil" class="profile-pic">
                        @else
                            <img id="profile-image" src="{{ asset('images/companies_images/100x100.svg') }}" alt="Foto de perfil" class="profile-pic">
                        @endif
                    @endif
                    
                    <div class="profile-info">
                        <div class="cont" style="margin-top: 60px; margin-left: 99px; display: flex; flex-direction: column;">
                            <div class="name-button" style="display: flex; justify-content: space-between; align-items: center;">

                                @if ($application->status == "Evaluacion")
                                    <h1 class="profile-Fname">{{ $candidat->first_name . " " . $candidat->last_name }}</h1>
                                    <div class="app-options">
                                        <button id="showConfermationModal">
                                            Confirmar
                                        </button>

                                        <button id="showRefusModal">
                                            <i class="fa-solid fa-x"></i>
                                        </button>
                                        
                                    </div>

                                @else
                                    <div class="name-stars">
                                        @if ($application->status == "Seleccionado")
                                            <h1 style="filter: blur(5px);" class="profile-Fname">{{ $candidat->first_name . " " . $candidat->last_name }}</h1>
                                        @else
                                            <h1 class="profile-Fname">{{ $candidat->first_name . " " . $candidat->last_name }}</h1>
                                        @endif
                                        <div class="stars">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= floor($candidat->rating))
                                                    <i class="star fas fa-star" data-index="{{ $i }}"></i>
                                                @elseif ($i == ceil($candidat->rating) && $candidat->rating - floor($candidat->rating) != 0)
                                                    <i class="star fas fa-star-half-alt" data-index="{{ $i }}"></i>
                                                @else
                                                    <i class="star far fa-star" data-index="{{ $i }}"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <p class="profile-role">
                                <strong>
                                    @if ($application->status == "Seleccionado")
                                        <span style="filter: blur(5px);">
                                            {{ $candidat->poste}} 
                                        </span>
                                    @else
                                        <span>
                                            {{ $candidat->poste}} 
                                        </span>
                                    @endif
                                </strong>
                            </p>
                        </div>

                        
                        <form id="submit-confermation" style="display: none;" action="{{route('company.conferm.app')}}" method="post">
                            @csrf
                            <input type="hidden" name="id_app" value="{{$application->id}}">
                        </form>
                        
                        <form id="submit-refus" style="display: none;" action="{{route('company.refus.app')}}" method="post">
                            @csrf
                            <input type="hidden" name="id_app" value="{{$application->id}}">
                        </form>
                        
                        <div class="profile-location">

                            @if ($application->status == "Seleccionado")
                               <div style="filter: blur(5px);">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                                        <circle cx="12" cy="10" r="3"/>
                                    </svg>
                                    {{ $candidat->adresse}}
                               </div>
                            @else
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                                {{ $candidat->adresse}}
                            @endif
                        </div>
                        

                        @if ( $candidat->priority == 'yes')
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
                    {{-- <div id="btn-edit-about" class="icon-container">
                        <i class="fa-regular fa-pen-to-square edit-icon"></i>
                    </div> --}}
                </div>
                <div class="card-body mt-21">
                    <div class="about-content" style="">
                        @if(@isset($about) && $about->description)
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
                    {{-- <div id="openModalUnique" class="icon-container" style="padding: 0.58rem;">
                        <i class="fa fa-plus edit-icon" aria-hidden="true"></i>
                    </div> --}}
                </div>
                <div class="card-body mt-21">
                    @if (@isset($experiences))                        
                        @foreach ($experiences as $index => $experience)
                            <div class="experience-item mt-21 {{ $index >= 2 ? 'hidden' : '' }}">
                                <div class="experience-title-btn-edit">
                                    <h3>{{ $experience->post }}</h3>
                                    {{-- <button class="btn-edit-experience" 
                                        data-id="{{ $experience->id }}" 
                                        data-company-name="{{ $experience->company_name }}" 
                                        data-post="{{ $experience->post }}" 
                                        data-location="{{ $experience->location }}" 
                                        data-begin-date="{{ $experience->begin_date }}" 
                                        data-end-date="{{ $experience->end_date }}" 
                                        data-description="{{ $experience->description }}" 
                                        data-work-type="{{ $experience->work_type }}">
                                    <i class="fa-regular fa-pen-to-square edit-icon"></i>
                                </button> --}}

                                </div>
                                <div class="experience-info">
                                    @if ($application->status == "Seleccionado")
                                        <div style="filter: blur(5px);" class="company-name dot-after">
                                            {{ $experience->company_name }}
                                        </div>
                                    @else
                                        <div class="company-name dot-after">
                                            {{ $experience->company_name }}
                                        </div>
                                    @endif
                                    <div class="type-employement dot-after ml-10">
                                        {{ $experience->work_type }}
                                    </div>
                                    <div class="date-employement ml-10">
                                        {{ $experience->begin_date }} -
                                        {{ $experience->end_date ? $experience->end_date : 'Present' }}
                                    </div>
                                </div>
                                <div class="employement-place">
                                    @if ($application->status == "Seleccionado")
                                        <span style="filter: blur(5px);">
                                            {{ $experience->location }}
                                        </span>
                                    @else
                                        <span>
                                            {{ $experience->location }}
                                        </span>
                                    @endif                                    
                                </div>
                                <div class="employement-description">
                                    {{ $experience->description }}
                                </div>
                                @if ($index < count($experiences) - 1)
                                    <hr style="color: #D7DCEB; margin-top: 21px; height: 1px;">
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="card-footer">
                    <span id="show-all-experiences">Mostrar todas las experiencias</span>
                </div>
            </div>

            <div class="card" style="padding: 24px;">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <h2 class="card-title">Educación</h2>
                    {{-- <div class="icon-container" style="padding: 0.58rem;">
                        <i class="fa fa-plus  edit-icon" aria-hidden="true"></i>
                    </div> --}}
                </div>
                <div class="card-body">
                    @if (@isset($educations))                        
                        @foreach ($educations as $index => $education)

                            @php
                                $personalPicturePath = 'images/education_logos/' . $education->education_logo_path;
                            @endphp
                        
                            <div class="education-item mt-21 {{ $index >= 2 ? 'hidden' : '' }}">
                                <!-- Affichage du logo de l'éducation -->
                                
                                
                                @if ($education->education_logo_path && file_exists(public_path($personalPicturePath)))
                                    <img src="{{ asset('images/education_logos/' . $education->education_logo_path) }}" class="education-place-logo" alt="Logo de l'université">
                                @else
                                    <img src="{{ asset('images/companies_images/100x100.svg') }}" class="education-place-logo" alt="Logo de l'université">
                                @endif
                                
                
                                <div>
                                    <!-- Nom de l'université -->
                                    <h3 class="education-place">{{ $education->university_name }}</h3>
                
                                    <!-- Sujet et dates -->
                                    <p class="education-branch">
                                        {{ $education->subject }}<br>
                                        @if ($education->begin_date && \Carbon\Carbon::hasFormat($education->begin_date, 'Y-m-d'))
                                            {{ \Carbon\Carbon::parse($education->begin_date)->format('Y') }}
                                        @else 
                                            {{ $education->begin_date }}
                                        @endif
                                        - 
                                        @if ($education->end_date)
                                            @if (\Carbon\Carbon::hasFormat($education->end_date, 'Y-m-d'))
                                                {{ \Carbon\Carbon::parse($education->end_date)->format('Y') }}
                                            @else
                                                {{ $education->end_date }}
                                            @endif
                                        @else 
                                            Present
                                        @endif
                                    </p>
                
                                    <!-- Description de l'éducation -->
                                    <p class="education-description">
                                        {{ $education->description }}
                                    </p>
                                </div>
                
                                {{-- <button class="btn-edit-education">
                                    <i class="fa-regular fa-pen-to-square edit-icon"></i>
                                </button> --}}
                            </div>
                            @if ($index < count($educations) - 1)
                                <hr style="color: #D7DCEB; margin-top: 21px; height: 1px;">
                            @endif
                        @endforeach
                    @endif
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
                    {{-- <div id="addSkillBtn" class="icon-container" style="padding: 0.58rem;">
                      <i class="fa fa-plus edit-icon" aria-hidden="true"></i>
                    </div>
                    <div id="editSkillBtn" class="icon-container" style="padding: 0.58rem;">
                      <i class="fa-regular fa-pen-to-square edit-icon"></i>
                    </div> --}}
                  </div>
                </div>
                <div class="card-body" style="display: flex; gap: 15px; width: 87%; flex-wrap: wrap;">
                    @if (@isset($skills))                        
                        @foreach ($skills as $index => $skill)
                            <div class="skill-item" style="padding: 6px;">
                                {{ $skill->description }}
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
              
        </div>

        <div class="right">
            <!-- Card 1 -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Detalles adicionales</h2>
                    {{-- <i id="btn-edit-da" onclick="openEditPopup() " class="fa-regular fa-pen-to-square edit-icon"></i> --}}
                </div>
                <div class="card-body mt-21">
                    <div class="email-section">
                        <i class="fa-regular fa-envelope email-icon"></i>
                        <span class="email-label">Correo</span>
                    </div>
                    @if ($candidat->email)
                        <p style="{{$application->status == "Seleccionado" ? 'filter: blur(4px)' : ''}}" class="email-text">
                                   {{ $candidat->email }}
                        </p>
                    @else
                        <p class="email-text">No tienes un correo electrónico</p>
                    @endif
                    
                    <div class="tel-section mt-21">
                        <i class="fa fa-phone tel-icon" aria-hidden="true"></i>
                        <span class="tel-label">Teléfono</span>
                    </div>

                    
                    @if ($candidat->tel)
                        <p style="{{$application->status == "Seleccionado" ? 'filter: blur(4px)' : ''}}" class="tel-text">{{ $candidat->tel }}</p>
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
                    @if (@isset($languagesString))                        
                        <p class="language-text">{{ $languagesString }}</p>
                    @endif
                </div>
            </div>
        
            <!-- Card 2 -->
            <div class="card ">
                <div class="card-header">
                    <h2 class="card-title">Social Links</h2>
                    {{-- <i  id="openPopup" class="fa-regular fa-pen-to-square edit-icon"></i> --}}
                    {{-- <i class="fas fa-edit edit-icon"></i> --}}
                </div>
                <div class="card-body mt-21">

                    @if(@isset($linkedinLink))    
                        <div class="linkedin-section">
                            <i class="fa-brands fa-linkedin linkedin-icon"></i>
                            <span class="linkedin-label">LinkedIn</span>
                        </div>
                        <a style="{{$application->status == "Seleccionado" ? 'filter: blur(4px); cursor: not-allowed;' : ''}}" href="#" class="linkedin-text">{{ $linkedinLink->link }}</a>
                    @else
                        <div class="linkedin-section">
                            <i class="fa-brands fa-linkedin linkedin-icon"></i>
                            <span class="linkedin-label">LinkedIn</span>
                        </div>
                        <a style="{{$application->status == "Seleccionado" ? 'filter: blur(4px); cursor: not-allowed;' : ''}}" href="#" class="linkedin-text">No tienes un enlace</a>
                    @endif

                    @if(@isset($xLink))
                        <div class="X-section mt-21">
                            <svg class="X-icon" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="svg5" x="0px" y="0px" viewBox="0 0 1668.56 1221.19" style="enable-background:new 0 0 1668.56 1221.19;" xml:space="preserve">
                                <g id="layer1" transform="translate(52.390088,-25.058597)">
                                    <path id="path1009" d="M283.94,167.31l386.39,516.64L281.5,1104h87.51l340.42-367.76L984.48,1104h297.8L874.15,558.3l361.92-390.99   h-87.51l-313.51,338.7l-253.31-338.7H283.94z M412.63,231.77h136.81l604.13,807.76h-136.81L412.63,231.77z"/>
                                </g>
                            </svg>
                            <span class="X-label">X</span>
                        </div>
                        <a style="{{$application->status == "Seleccionado" ? 'filter: blur(4px); cursor: not-allowed;' : ''}}" href="#" class="X-text"> {{ $xLink->link }}</a>
                    @else
                        <div class="X-section mt-21">
                            <svg class="X-icon" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="svg5" x="0px" y="0px" viewBox="0 0 1668.56 1221.19" style="enable-background:new 0 0 1668.56 1221.19;" xml:space="preserve">
                                <g id="layer1" transform="translate(52.390088,-25.058597)">
                                    <path id="path1009" d="M283.94,167.31l386.39,516.64L281.5,1104h87.51l340.42-367.76L984.48,1104h297.8L874.15,558.3l361.92-390.99   h-87.51l-313.51,338.7l-253.31-338.7H283.94z M412.63,231.77h136.81l604.13,807.76h-136.81L412.63,231.77z"/>
                                </g>
                            </svg>
                            <span class="X-label">X</span>
                        </div>
                        <a style="{{$application->status == "Seleccionado" ? 'filter: blur(4px); cursor: not-allowed;' : ''}}" href="#" class="X-text">No tienes un enlace</a>
                    @endif

                    @if(@isset($websiteLink))
                        <div class="web-section mt-21">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 web-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                            </svg>                          
                            <span class="web-label">Website</span>
                        </div>
                        <a style="{{$application->status == "Seleccionado" ? 'filter: blur(4px); cursor: not-allowed;' : ''}}" href="#" class="web-text">{{ $websiteLink->link }}</a>
                    @else
                        <div class="web-section mt-21">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 web-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                            </svg>                          
                            <span class="web-label">Website</span>
                        </div>
                        <a style="{{$application->status == "Seleccionado" ? 'filter: blur(4px); cursor: not-allowed;' : ''}}" href="#" class="web-text">No tienes un enlace</a>
                    @endif
                </div>
            </div>






            @if ($application->cv_name || $application->motivation_letter)                
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Solicitud personalizada</h2>
                    </div>
                    <div class="card-body mt-21">
                        <div class="cv-section">
                            <h4 class="section-title">CV detallado :</h4>
                            @if ($application->cv_name)
                                <a href="{{ asset('storage/uploads/application_document/' . $application->cv_name) }}" download class="btn-download">
                                    <i class="fas fa-paperclip"></i> Descargar
                                </a>
                            @else
                                <p class="error-message">No se ha proporcionado un CV.</p>
                            @endif
                        </div>
                        <div class="additional-info">
                            <h4 class="section-title">Información adicional :</h4>
                            @if ($application->motivation_letter)
                                <p style="{{$application->status == "Seleccionado" ? 'filter: blur(4px)' : ''}}">
                                    {{$application->motivation_letter}}
                                <p>
                            @else
                                <p class="error-message">No se proporcionó información adicional.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            
            
        </div>
        
    </div>

    <div id="bannerModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Elija Banner</h2>
                <button class="close-button" onclick="closeModal()">&times;</button>
            </div>
            <div class="preset-banners" id="presetBanners"></div>
            {{-- <div class="upload-section">
                <h3>Upload Custom Banner</h3>
                <input type="file" id="bannerUpload" accept="image/*" style="display: none">
                <button class="upload-button" onclick="document.getElementById('bannerUpload').click()">
                    Upload Image
                </button>
            </div> --}}
        </div>
    </div>


    <div id="popup" class="popup hdn">
        <div class="popup-content">
            <div class="popup-header">
                <h2>Social Links</h2>
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
                    <label for="website">Website</label>
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
                    <button type="submit" id="saveSkillBtn" class="btn-save-add-skill">Save</button>
                    <button type="button" id="cancelSkillBtn" class="btn-cancel-add-skill">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    
    <!-- Popup -->
    <div id="popupEditSkills" class="popupEditSkills hdn">
        <div class="popup-edit-skills-content">
            <h3>Modifier ou supprimer des compétences</h3>
            <!-- Liste des compétences existantes -->
            <div class="skill-to-edit" style="">
                <input type="hidden" id="inp-skill-id" name="">
                        <input 
                            id="inp-skill-name"
                            type="text"
                            class="skill-input-edit" 
                        />
            </div>
            <div class="skill-to-edit-actions">  
                <button class="btn btn-edit-skil">Modifier</button>
                <button class="btn btn-delete-skil">Supprimer</button>
            </div>
            <div class="existing-skills" style="height: fit-content;">
                @if (@isset($skills))                        
                    @foreach ($skills as $skill)
                        <div class="skill-item" style="width: fit-content; padding: 10px; " data-id="{{ $skill->id }}">
                            {{ $skill->description }}
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Bouton de fermeture -->
            <button id="closeEditSkillsPopup" class="btn-close-popup">Fermer</button>
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
                <!-- Modifier le téléphone -->
                <div class="popup-field">
                    <label for="phone" class="popup-label">Téléphone</label>
                    <input 
                        type="text" 
                        id="phone" 
                        name="phone" 
                        class="popup-input" 
                        placeholder="Entrez le nouveau numéro de téléphone"
                        value="{{ $candidat->tel }}"
                    />
                </div>

                <!-- Modifier les langues -->
                <div class="popup-field">
                    <label for="languages" class="popup-label">Langues</label>
                    <select name="languages[]" id="languages" class="popup-input" multiple required>
                        <!-- Les options seront ajoutées dynamiquement via JavaScript -->
                    </select>
                </div>

                <!-- Conteneur pour afficher les langues sélectionnées -->
                <div class="selected-languages">
                    <h4 class="selected-languages-title">Langues sélectionnées :</h4>
                    <div id="languageContainer" class="language-container">
                        <!-- Les langues précédentes et nouvelles apparaîtront ici -->
                    </div>
                </div>

                <!-- Information pour l'email -->
                <div class="popup-info">
                    <label for="email" class="popup-label">E-mail</label>
                    <p class="popup-description">
                        Para cambiar la dirección de correo electrónico, visite la página
                        <a href="/candidat/edit/profile?o=t" class="popup-link">
                            Edición de perfil (Notifications y Cuenta)
                        </a>.
                    </p>
                </div>

                <!-- Boutons d'action -->
                <div class="popup-buttons">
                    <button type="submit" id="saveDetails" class="btnn btnn-primary">Enregistrer</button>
                    <button type="button" onclick="closeEditPopup()" id="closePopup" class="btnn btnn-secondary">Annuler</button>
                </div>
            </form>
        </div>
    </div>



    <div class="popup-sobre-mi-container hidden">
        <div class="popup-sobre-mi-header">Sobre mí</div>
        <div class="popup-sobre-mi-description">Cuéntanos sobre ti y cómo puedes marcar la diferencia.</div>
        <form id="" action="{{ route('candidat.edit.about') }}" method="POST">
            @csrf
            <textarea name="ta_about" class="popup-sobre-mi-textarea" maxlength="3000" placeholder="Escribe aquí...">No hay descripción disponible en este momento.</textarea>
            <div class="popup-sobre-mi-actions">
            <button id="popup-sobre-mi-btn-delete" type="button" class="popup-sobre-mi-btn-delete">Cancel</button>
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
                        <label><input onclick="hideNewWorkType()" type="radio" name="work_type" value="Híbrido"> Híbrido</label>
                        <label><input onclick="hideNewWorkType()" type="radio" name="work_type" value="Jornada intensiva"> Jornada intensiva</label>
                        <label><input onclick="showNewWorkType()" type="radio" name="work_type" value="Otro"> Otro</label>
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
                    <button type="button" id="btn-cancel-add-exp" class="btn-delete-unique">Eliminar</button>
                    <button type="submit" class="btn-save-unique">Guardar información</button>
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
                        <label><input onclick="EhideNewWorkType()" type="radio" name="Ework_type" id="Ework_type" value="Híbrido"> Híbrido</label>
                        <label><input onclick="EhideNewWorkType()" type="radio" name="Ework_type" id="Ework_type" value="Jornada intensiva"> Jornada intensiva</label>
                        <label><input onclick="EshowNewWorkType()" type="radio" name="Ework_type" id="Ework_type" value="Otro"> Otro</label>
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
                    <button type="button" id="btn-cancel-add-exp" class="btn-delete-unique">Eliminar</button>
                    <button type="submit" class="btn-save-unique">Guardar información</button>
                </div>
            </form>            
        </div>
    </div>


    <div id="confirmationModal" class="ConfermationModal">
        <div class="ConfermationModal-content">
            <div class="icon-close-confermation-modal">
                <div class="svg-icon-confermation">
                    <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 56 56" fill="none">
                        <rect x="4" y="4" width="48" height="48" rx="24" fill="#D1FADF"/>
                        <rect x="4" y="4" width="48" height="48" rx="24" stroke="#ECFDF3" stroke-width="8"/>
                        <path d="M23.5 28L26.5 31L32.5 25M38 28C38 33.5228 33.5228 38 28 38C22.4772 38 18 33.5228 18 28C18 22.4772 22.4772 18 28 18C33.5228 18 38 22.4772 38 28Z" stroke="#039855" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <span class="ConfermationModal-close">&times;</span>
            </div>
            <h2>Candidato confirmado</h2>
            <p>El candidato pasa a la fase de proceso y un comercial le contactara para mas información en las proximas 24 horas.</p>
            <div class="button-container">
                <button id="cancelBtn" class="btnc btnc-cancel">Cancelar</button>
                <button id="confirmBtn" class="btnc btnc-confirm">Confirmar</button>
            </div>
        </div>
    </div>
    
    <div id="refusModal" class="RefusModal">
        <div class="RefusModal-content">
            <div class="icon-close-refus-modal">
                <div class="svg-icon-refus">
                    <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 56 56" fill="none">
                        <rect x="4" y="4" width="48" height="48" rx="24" fill="#FEE4E2"/>
                        <rect x="4" y="4" width="48" height="48" rx="24" stroke="#FEF3F2" stroke-width="8"/>
                        <path d="M32 22V21.2C32 20.0799 32 19.5198 31.782 19.092C31.5903 18.7157 31.2843 18.4097 30.908 18.218C30.4802 18 29.9201 18 28.8 18H27.2C26.0799 18 25.5198 18 25.092 18.218C24.7157 18.4097 24.4097 18.7157 24.218 19.092C24 19.5198 24 20.0799 24 21.2V22M26 27.5V32.5M30 27.5V32.5M19 22H37M35 22V33.2C35 34.8802 35 35.7202 34.673 36.362C34.3854 36.9265 33.9265 37.3854 33.362 37.673C32.7202 38 31.8802 38 30.2 38H25.8C24.1198 38 23.2798 38 22.638 37.673C22.0735 37.3854 21.6146 36.9265 21.327 36.362C21 35.7202 21 34.8802 21 33.2V22" stroke="#D92D20" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <span class="RefusModal-close">&times;</span>
            </div>
            <h2>Descartar candidato</h2>
            <p>Estas seguro que quieres descartar este candidato ? Al descartarlo saldrá del proceso pero quedara en su historial durante 30 dias.</p>
            <div class="button-container">
                <button id="cancelBtn-Refus" class="btnc btnc-cancel">Cancelar</button>
                <button id="refusBtn" class="btnc btnc-refus">Descartar</button>
            </div>
        </div>
    </div>







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
        }

        function closeModal() {
            document.getElementById('bannerModal').classList.remove('active');
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

            // Afficher tous les éléments masqués
            hiddenFormations.forEach(function (item) {
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
        });

        // Close popup
        closeButton.addEventListener('click', () => {
            popup.classList.remove('active');
        });

        // Close popup when clicking outside
        popup.addEventListener('click', (e) => {
            if (e.target === popup) {
                popup.classList.remove('active');
            }
        });
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
    </script>




    <script>
        // Show the popup
        document.getElementById('addSkillBtn').addEventListener('click', function () {
        document.getElementById('popupAddSkill').classList.remove('hdn');
        });

        document.getElementById('editSkillBtn').addEventListener('click', function () {
            document.getElementById('popupEditSkills').classList.remove('hdn');

        });

        document.getElementById('btn-edit-da').addEventListener('click', function () {
            document.getElementById('popupEditDetails').classList.remove('hdn');

        });



        // Hide the popup on cancel
        document.getElementById('cancelSkillBtn').addEventListener('click', function () {
            document.getElementById('popupAddSkill').classList.add('hdn');
        });

        document.getElementById('closeEditSkillsPopup').addEventListener('click', function () {
            document.getElementById('popupEditSkills').classList.add('hdn');
        });
        
    </script>


    

    <script>
        function removeSkill(skillId) {

        alert('deleted !!!')
            
          
        }

        function updateSkill(inputElement, skillId) {
            const newValue = inputElement.value.trim();
            if (newValue === "") {
                alert("Le champ de compétence ne peut pas être vide !");
                return;
            }


            alert("Skill name updated to " + newValue );    

          
        }

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
    
    @if (@isset($languages))                        
    
        <script>
            const userLanguages = @json($languages); // Convertir les langues en JSON pour le JS
        </script>
    
        <script>

        // Ajoutez cette fonction à l'endroit où vous voulez ouvrir le popup
        function openEditPopup() {
            document.getElementById('editDetailsPopup').classList.remove('hidden'); // Afficher le popup
        }
        function closeEditPopup() {
            document.getElementById('editDetailsPopup').classList.add('hidden'); // Fermer le popup
        }




        // Exemple d'API simulée pour récupérer les langues disponibles
        const fetchLanguages = () => {
            return [
                "francés",
                "inglés",
                "Español",
                "Allemand",
                "Chinois",
                "Arabe",
                "Portugais",
            ]; // Ces données peuvent provenir d'une vraie API
        };

        // Les langues déjà sélectionnées par l'utilisateur
        let selectedLanguages = userLanguages || [];

        // Fonction pour charger les langues dans le <select>
        const loadLanguages = () => {
            const languageSelect = document.getElementById("languages");
            const languages = fetchLanguages();

            languages.forEach((lang) => {
                const option = document.createElement("option");
                option.value = lang;
                option.textContent = lang;

                // Si la langue est déjà sélectionnée, la marquer comme sélectionnée
                if (selectedLanguages.includes(lang)) {
                    option.selected = true;
                }

                languageSelect.appendChild(option);
            });

            updateLanguageContainer();
        };

        // Fonction pour mettre à jour l'affichage des langues sélectionnées
        const updateLanguageContainer = () => {
            const languageContainer = document.getElementById("languageContainer");
            languageContainer.innerHTML = ""; // Réinitialiser le conteneur

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

        // Ajouter une langue lors de la sélection dans le <select>
        document.getElementById("languages").addEventListener("change", (event) => {
            const selectedOption = event.target.value;

            // Vérifier si la langue est déjà sélectionnée
            if (!selectedLanguages.includes(selectedOption)) {
                selectedLanguages.push(selectedOption);
            }

            updateLanguageContainer();
            // Mettre à jour le <select> pour refléter toutes les langues sélectionnées
            syncSelectWithSelectedLanguages();
        });

        // Synchroniser l'état des langues sélectionnées avec le <select>
        const syncSelectWithSelectedLanguages = () => {
            const options = document.getElementById("languages").options;
            for (let i = 0; i < options.length; i++) {
                options[i].selected = selectedLanguages.includes(options[i].value);
            }
        };

        // Supprimer une langue sélectionnée
        const removeLanguage = (lang) => {
            selectedLanguages = selectedLanguages.filter((l) => l !== lang);
            updateLanguageContainer();
            syncSelectWithSelectedLanguages();
        };

        // Charger les langues au démarrage
        loadLanguages();

        </script>
    @endif
    <script>
        // Get the button, popup container, and overlay
        const btnEditAbout = document.getElementById('btn-edit-about');
        const popupContainer = document.querySelector('.popup-sobre-mi-container');
        const popupOverlay = document.querySelector('.popup-overlay');
    
        // Event listener for showing the popup
        btnEditAbout.addEventListener('click', () => {
        popupContainer.style.display = 'block'; // Show the popup
        popupOverlay.style.display = 'block'; // Show the overlay
        document.body.style.backgroundColor = '#d3d3d3'; // Change the background color of the body
        });
    
        // Event listener for closing the popup when clicking on the overlay
        document.getElementById("popup-sobre-mi-btn-delete").addEventListener('click', () => {
        popupContainer.style.display = 'none'; // Hide the popup
        popupOverlay.style.display = 'none'; // Hide the overlay
        document.body.style.backgroundColor = '#f4f4f4'; // Reset the body background color
        });
    </script>
    

    <script>
        const modalUnique = document.getElementById('experienceModalUnique');
        const openModalUnique = document.getElementById('openModalUnique');
        const closeModalUnique = document.getElementById('closeModalUnique');
    
        openModalUnique.addEventListener('click', () => {
            modalUnique.style.display = 'flex';
        });
    
        closeModalUnique.addEventListener('click', () => {
            modalUnique.style.display = 'none';
        });

        document.getElementById("btn-cancel-add-exp").addEventListener('click', () => {
            modalUnique.style.display = 'none';
        });
    
        window.addEventListener('click', (event) => {
            if (event.target === modalUnique) {
                modalUnique.style.display = 'none';
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

    
        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                modal.style.display = 'flex';

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
                experienceIdInput.value = button.getAttribute('data-id');
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

                // Afficher le modal
            });
        });

        // Bouton pour fermer le modal
        const closeModalButton = document.getElementById('closeModalEditExperience');
        closeModalButton.addEventListener('click', () => {
            modal.style.display = 'none';
        });
    });

    </script>
    
    



    <script>
        const modal = document.getElementById('confirmationModal');
        const showModalBtn = document.getElementById('showConfermationModal');
        const closeBtn = document.getElementsByClassName('ConfermationModal-close')[0];
        const cancelBtn = document.getElementById('cancelBtn');
        const confirmBtn = document.getElementById('confirmBtn');
        
        showModalBtn.onclick = () => {
            modal.style.display = "block";
            document.body.style.overflow = 'hidden';
        } 

        closeBtn.onclick = () => {
            modal.style.display = "none";
            document.body.style.overflow = '';
        }
        cancelBtn.onclick = () => {
            modal.style.display = "none";
            document.body.style.overflow = '';
        }
        confirmBtn.onclick = () => {
            // Add your confirmation logic here
            document.getElementById('submit-confermation').submit()
            modal.style.display = "none";
            document.body.style.overflow = '';
        };
        
        window.onclick = (event) => {
            if (event.target == modal) {
                modal.style.display = "none";
                document.body.style.overflow = '';
            }
        }
    </script>

    
    
    <script>
        const modal2 = document.getElementById('refusModal');
        const showModalBtn2 = document.getElementById('showRefusModal');
        const closeBtn2 = document.getElementsByClassName('RefusModal-close')[0];
        const cancelBtn2 = document.getElementById('cancelBtn-Refus');
        const confirmBtn2 = document.getElementById('refusBtn');
        
        showModalBtn2.onclick = () => {

            modal2.style.display = "block";
            document.body.style.overflow = 'hidden';
        } 

        closeBtn2.onclick = () => {
            modal2.style.display = "none";
            document.body.style.overflow = '';
        }
        cancelBtn2.onclick = () => {
            modal2.style.display = "none";
            document.body.style.overflow = '';
        }
        confirmBtn2.onclick = () => {
            document.getElementById('submit-refus').submit()
            modal2.style.display = "none";
            document.body.style.overflow = '';
        };
        
        window.onclick = (event) => {
            if (event.target == modal2) {
                modal2.style.display = "none";
                document.body.style.overflow = '';
            }
        }
    </script>

    
    
</body>
</html>

@endsection

