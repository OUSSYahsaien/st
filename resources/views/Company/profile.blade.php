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
        <link rel="stylesheet" href="{{ asset('css/Company/profile.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <body>
        
        
        <main class="company-profile">
            @if (session('success'))
                <div id="success-alert" style="margin-bottom: 42px;" class="alert alert-success">
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
            <section class="profile-header">
                <div class="company-logo">
                    <img src="{{ Auth::user()->personel_pic && file_exists(public_path('images/companies_images/' . Auth::user()->personel_pic)) 
                    ? asset('images/companies_images/' . Auth::user()->personel_pic) 
                    : asset('images/companies_images/100x100.svg') }}" 
                     alt="Company Logo" id="companyLogo">
                </div>
                
                <div class="company-info">
                    <div class="company-info-header">
                        <h1 class="company-name">{{Auth::user()->name}}</h1>
                        <div class="settings-button">
                            <a href="{{ route('company.edit.profile') }}" style="text-decoration: none;">
                                <button class="edit-button" id="profileSettings">
                                    <i class="fa fa-cog"></i>
                                    <span>Ajustes del perfil</span>
                                </button>
                            </a>
                        </div>
                    </div>
                    
                    @if (Auth::user()->website)
                        <a href="{{Auth::user()->website }}" class="company-website" id="websiteLink">{{Auth::user()->website }}</a>
                    @else
                        <a class="company-website" id="websiteLink">Negocio sin sitio web</a>
                    @endif                    
                    <div class="company-stats">
                        <div class="stat-item">
                            <i class="fa-solid fa-fire"></i>
                            <span>Founded</span>
                            {{-- <p id="foundedDate">{{Auth::user()->date_de_fondation ? Auth::user()->date_de_fondation : "" }} 31 de julio de 2011</p> --}}
                            <p id="foundedDate">
                                @if(Auth::user()->date_de_fondation)
                                    {{ \Carbon\Carbon::parse(Auth::user()->date_de_fondation)->translatedFormat('d \d\e F \d\e Y') }}
                                @else
                                    <span>La fecha de fundación no está disponible</span>
                                @endif
                            </p>
                            
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-users"></i>
                            <span>Employees</span>
                            <p id="employeeCount">
                                @if($employeeCount)
                                    {{ $employeeCount }}+
                                @else
                                    <span>El número de empleados no está disponible</span>
                                @endif
                            </p>
                            
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Location</span>
                            <p id="location">
                                @if(Auth::user()->city)
                                    {{ Auth::user()->city }}
                                @else
                                    <span>La ubicación no está disponible</span>
                                @endif
                            </p>
                            
                        </div>
                        <div class="stat-item">
                            <i class="fa-regular fa-building"></i>
                            <span>Sector</span>
                            <p id="sector">
                                @if($secteurName)
                                    {{ $secteurName }}
                                @else
                                    <span>El sector no está disponible</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </section>
    
            <hr style="color: #D6DDEB; margin-top: 21px">

            <section class="company-description">
                <div class="description-header">
                    <h2>Descripción de la empresa</h2>
                    <button class="edit-btn" id="editDescription">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </button>
                </div>
                <p id="companyDescription">
                    @if (@isset($aboutCompany) && $aboutCompany->description)
                        {{$aboutCompany->description }}  
                        
                    @else
                        No hay descripción
                    @endif
                </p>
            </section>

            <!-- Modal Edit Description -->
            <div id="editModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <form method="post" action="{{route('company.edit.description')}}">
                        @csrf
                        <h3>Editar descripción de la empresa</h3>
                        <textarea name="description" id="descriptionInput" rows="5"></textarea>
                        <button type="submit" id="saveDescription" class="save-btn">Guardar</button>
                    </form>
                </div>
            </div>


           <!-- Add Contact Modal -->
            <div id="add-modal" class="modal-add-contact">
                <div class="modal-add-contact-content">
                    <h2>Agregar nuevo contacto</h2>
                    <form id="add-contact-form" method="post" action="{{route('company.add.contact')}}">
                        @csrf
                        <div class="form-group">
                            <label for="contact-type">Tipo de contacto:</label>
                            <select name="type" id="contact-type" required>
                                <option value="" disabled selected>Seleccione el tipo de contacto</option>
                                <option value="phone">Teléfono</option>
                                <option value="email">Correo electrónico</option>
                                <option value="facebook">Facebook</option>
                                <option value="linkedin">Linkedin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="contact-value">Valor de contacto:</label>
                            <input name="value" type="text" id="contact-value" placeholder="Enter value" required>
                        </div>
                        <div class="modal-add-contact-buttons">
                            <button type="submit" class="btn-save">Ahorrar</button>
                            <button type="button" class="btn-cancel" onclick="closeAddModal()">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>


            <!-- Edit Social Media Links Modal -->
            <div id="edit-modal" class="modal-edit-contact">
                <div class="modal-edit-contact-content">
                    <h2>Editar enlaces sociales</h2>
                    <form id="edit-social-links-form" method="POST" action="{{ route('company.update.social.links') }}">
                        @csrf
                        @foreach($socialLinks as $link)
                        <div class="form-group">
                            <label for="edit-{{ $link->type }}">{{ ucfirst($link->type) }}:</label>
                            <input 
                                type="text" 
                                name="links[{{ $link->type }}]" 
                                id="edit-{{ $link->type }}" 
                                value="{{ $link->value }}" 
                                required
                            >
                        </div>
                        @endforeach
                        <div class="modal-edit-contact-buttons">
                            <button type="submit" class="btn-save">Guardar</button>
                            <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>


            <hr style="color: #D6DDEB; margin-top: 27px">


            <section class="contact-section">
                <div class="section-header">
                    <h2>Contacto</h2>
                    <div class="action-buttons">
                        <button class="add-btn" id="addContact" onclick="openAddModal()">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button class="edit-btn" id="editContact" onclick="openEditModal()">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                    </div>
                </div>
                
                <div class="contact-links" id="contactLinks">
                    @foreach($socialLinks as $link)
                        @if($link->type == 'phone')
                            <a href="tel:{{ $link->value }}" class="contact-link phone">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                <span>{{ $link->value }}</span>
                            </a>
                        @elseif($link->type == 'twitter')
                            <a href="{{ $link->value }}" class="contact-link twitter" target="_blank">
                                <i class="fab fa-twitter"></i>
                                <span>{{ $link->value }}</span>
                            </a>
                        @elseif($link->type == 'facebook')
                            <a href="{{ $link->value }}" class="contact-link facebook" target="_blank">
                                <i class="fab fa-facebook"></i>
                                <span>{{ $link->value }}</span>
                            </a>
                        @elseif($link->type == 'linkedin')
                            <a href="{{ $link->value }}" class="contact-link linkedin" target="_blank">
                                <i class="fab fa-linkedin"></i>
                                <span>{{ $link->value }}</span>
                            </a>
                        @elseif($link->type == 'email')
                            <a href="mailto:{{ $link->value }}" class="contact-link email">
                                <i class="fas fa-envelope"></i>
                                <span>{{ $link->value }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
                
                
            </section>

            <hr style="color: #D6DDEB; margin-top: 27px">


            <section class="team-section">
                <div class="team-header">
                  <h2 class="team-title">Nuestro equipo</h2>
                  <div class="team-actions">
                    <a href="/company/add-in-equipe">
                        <button class="add-btn">
                            <i class="fas fa-plus"></i>
                        </button>
                    </a>
                    <a href="/company/edit-profile?o=t">
                        <button class="edit-btn">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                    </a>
                  </div>
                </div>
                
                <div class="team-grid">
                    @foreach($teamMembers as $teamMember)
                        <div class="team-card">
                            <div class="card-icons">
                                <a href="{{ route('company.view.team.member', ['id' => $teamMember->id]) }}" class="social-link">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                                <a href="{{ route('company.edit.in.equipe', ['id' => $teamMember->id]) }}" href="#" class="social-link">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                            </div>
                            <img draggable="false" src="{{ $teamMember->personel_pic ? asset('images/team_images/' . $teamMember->personel_pic) : 'https://placehold.co/96x96' }}" alt="{{ $teamMember->full_name }}" class="team-member-image">
                            <h3 class="team-member-name">
                                {{ $teamMember->full_name }}
                                @if($teamMember->role == 'responsable')
                                    (YO)
                                @endif
                            </h3>
                            <p class="team-member-role">{{ $teamMember->poste }}</p>
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
                
            </section>
        </main>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
        <link rel="stylesheet" href="{{ asset('css/Company/profile.css') }}">
        <script src="{{ asset('js/company/profile-1.js') }}"></script>
    </body>
    </html>
@endsection