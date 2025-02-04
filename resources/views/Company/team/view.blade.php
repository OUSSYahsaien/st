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
        <link rel="stylesheet" href="{{ asset('css/Company/view-team-member.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <body style="background: #fff;">
        
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
                    <div class="cover-photo" id="currentBanner" style="{{ $teamMember->avatar_pic ? 'background: url(' . asset('images/team_banners/' . $teamMember->avatar_pic) . ') no-repeat; background-size: cover;' : '' }}">
                        <button class="edit-button" onclick="openModal()">
                            <i class="fa-regular fa-pen-to-square edit-banner-icon"></i>
                        </button>
                    </div>
                    
                    @php
                        $personalPicturePath = 'images/team_images/' . $teamMember->personel_pic;
                    @endphp
    
                    <div class="profile-content">    
    
                        @if ($teamMember->personel_pic && file_exists(public_path($personalPicturePath)))
                            <img style="background: #fff;" src="{{ asset($personalPicturePath) }}" alt="Foto de perfil" class="profile-pic">
                        @else
                            <img id="profile-image" src="https://placehold.co/99x99" alt="Foto de perfil" class="profile-pic">
                        @endif
                        
                        <div class="profile-info">
                            <div class="cont" style="margin-top: 60px; margin-left: 99px; display: flex; flex-direction: column;">
                                <div class="name-button" style="display: flex; justify-content: space-between; align-items: center;">
                                    <h1 class="profile-Fname">{{ $teamMember->full_name  }}</h1>
                                    <a href="{{ route('company.edit.in.equipe', ['id' => $teamMember->id]) }}" style="text-decoration: none;">
                                        <button class="btn-edit-perfil" style="align-self: flex-end;">Editar perfil</button>
                                    </a>
                                </div>
                                <p class="profile-role">{{ $teamMember->poste  }}</p>
                            </div>
                            
                            <div class="profile-location">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                                {{ $teamMember->location  }}
                            </div>
                            


                            <div class="opportunities-badge-no" style="background: #D4EDFF; color: #0D72FF;">
                                <div class="flag-icon">
                                    <i class="fa-regular fa-flag"></i>
                                </div>
                                <div class="text-into-badge" style="margin-left: 36px; font-size: 17px">
                                    En busca de personal
                                </div>
                            </div>
                                                        
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
                            @if(isset($aboutTeamMember) && $aboutTeamMember->description)
                                {{ $aboutTeamMember->description }}
                            @else
                                <p>No hay descripción disponible en este momento.</p>
                            @endif
                        </div>
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
                        @if ($teamMember->email)
                            <p class="email-text">{{ $teamMember->email }}</p>
                        @else
                            <p class="email-text">No tienes un correo electrónico</p>
                        @endif
                        
                        <div class="tel-section mt-21">
                            <i class="fa fa-phone tel-icon" aria-hidden="true"></i>
                            <span class="tel-label">Teléfono</span>
                        </div>
    
                        @if ($teamMember->tel_1)
                            <p class="tel-text">{{ $teamMember->tel_1 }}</p>
                        @else
                            <p class="tel-text">no tienes tel</p>
                        @endif
    
                        <div class="tel-section mt-21">
                            <i class="fa fa-phone tel-icon" aria-hidden="true"></i>
                            <span class="tel-label">Teléfono 2</span>
                        </div>
    
                        @if ($teamMember->tel_2)
                            <p class="tel-text">{{ $teamMember->tel_2 }}</p>
                        @else
                            <p class="tel-text">no tienes tel</p>
                        @endif    
                    </div>
                </div>
            
                <!-- Card 2 -->
                <div class="card ">
                    <div class="card-header">
                        <h2 class="card-title">Social Links</h2>
                        <i  id="openPopup" class="fa-regular fa-pen-to-square edit-icon"></i>
                    </div>
                    <div class="card-body mt-21">
    
                            <div class="linkedin-section">
                                <i class="fa-brands fa-linkedin linkedin-icon"></i>
                                <span class="linkedin-label">LinkedIn</span>
                            </div>
                            <a class="linkedin-text">{{ isset($linkedin->value) ? $linkedin->value : 'No hay un valor disponible para LinkedIn.'}}</a>
    
                            <div class="X-section mt-21">
                                <svg class="X-icon" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="svg5" x="0px" y="0px" viewBox="0 0 1668.56 1221.19" style="enable-background:new 0 0 1668.56 1221.19;" xml:space="preserve">
                                    <g id="layer1" transform="translate(52.390088,-25.058597)">
                                        <path id="path1009" d="M283.94,167.31l386.39,516.64L281.5,1104h87.51l340.42-367.76L984.48,1104h297.8L874.15,558.3l361.92-390.99   h-87.51l-313.51,338.7l-253.31-338.7H283.94z M412.63,231.77h136.81l604.13,807.76h-136.81L412.63,231.77z"/>
                                    </g>
                                </svg>
                                <span class="X-label">X</span>
                            </div>
                            <a class="X-text"> {{ isset($xLink->value) ? $xLink->value: "No hay un valor disponible para X." }}</a>
                        
    
                            <div class="web-section mt-21">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 web-icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                                </svg>                          
                                <span class="web-label">Website</span>
                            </div>
                            <a class="web-text">{{ isset($website->value) ? $website->value : 'No hay un valor disponible para el sitio web' }}</a>
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
            <div class="preset-banners" id="presetBanners">
            </div>
            <div class="upload-section">
                <input type="file" id="bannerUpload" accept="image/*" style="display: none">
            </div>
        </div>
    </div>


    <div id="popup" class="popup hdn">
        <div class="popup-content">
            <div class="popup-header">
                <h2>Social Links</h2>
                <button id="closePopup" class="close-button2">&times;</button>
            </div>
            
            <form action="{{ route('company.update.team.member.social.links') }}" method="post" id="socialForm">
                @csrf
                <input type="hidden" name="id_member" value="{{$teamMember->id}}">
                <div class="form-group">
                    <label for="linkedin">LinkedIn</label>
                    <input type="url" name="linkedin" id="linkedin" placeholder="Enter your LinkedIn profile" value="{{ $linkedin->value ?? '' }}">
                </div>
    
                <div class="form-group">
                    <label for="X">X</label>
                    <input type="text" name="x_handle" id="X" placeholder="Enter your X handle" value="{{ $xLink->value ?? '' }}">
                </div>
    
                <div class="form-group">
                    <label for="website">Website</label>
                    <input type="url" name="website" id="website" placeholder="Enter your website URL" value="{{ $website->value ?? '' }}">
                </div>
    
                <button type="submit" class="submit-button">Guardar información</button>
            </form>
        </div>
    </div>
        
        

    <!-- Popup -->
    <div id="editDetailsPopup" class="popup-container hidden">
        <div class="popup-box">
            <h3 class="popup-title">Editar detalles</h3>

            <form id="updateDetailsForm" action="{{route('company.update.team.members.details')}}" method="POST">
                @csrf
                <input type="hidden" name="id_member" value="{{$teamMember->id}}">
                <div class="popup-field">
                    <label for="phone" class="popup-label">Correo</label>
                    <input 
                        type="email" 
                        name="email" 
                        class="popup-input" 
                        placeholder="Ingrese la nueva dirección de correo electrónico"
                        value="{{ $teamMember->email ?? '' }}"
                    />
                </div>
                <div class="popup-field">
                    <label for="phone-1" class="popup-label">Teléfono</label>
                    <input 
                        type="text" 
                        id="phone" 
                        name="phone-1" 
                        class="popup-input" 
                        placeholder="Ingrese el nuevo número de teléfono 1"
                        value="{{ $teamMember->tel_1 ?? '' }}"
                    />
                </div>
                <div class="popup-field">
                    <label for="phone-2" class="popup-label">Teléfono 2</label>
                    <input 
                        type="text" 
                        id="phone" 
                        name="phone-2" 
                        class="popup-input" 
                        placeholder="Ingrese el nuevo número de teléfono 2"
                        value="{{ $teamMember->tel_2 ?? '' }}"
                    />
                </div>

                

                <!-- Boutons d'action -->
                <div class="popup-buttons">
                    <button type="submit" id="saveDetails" class="btnn btnn-primary">Ahorrar</button>
                    <button type="button" onclick="closeEditPopup()" id="" class="btnn btnn-secondary">Cancelar</button>
                </div>
            </form>
        </div>
    </div>



    <div class="popup-sobre-mi-container hidden">
        <div class="popup-sobre-mi-header">Sobre mí</div>
        <div class="popup-sobre-mi-description">Cuéntanos sobre ti y cómo puedes marcar la diferencia.</div>
        <form id="" action="{{ route('company.edit.about.team.member') }}" method="POST">
            @csrf
            <input type="hidden" name="id_member" value="{{$teamMember->id}}">
            <textarea name="ta_about" class="popup-sobre-mi-textarea" maxlength="3000" placeholder="Escribe aquí...">{{ isset($aboutTeamMember) && $aboutTeamMember->description ?  $aboutTeamMember->description : ''  }}</textarea>
            <div class="popup-sobre-mi-actions">
            <button id="popup-sobre-mi-btn-delete" type="button" class="popup-sobre-mi-btn-delete">Cancel</button>
            <button type="submit" class="popup-sobre-mi-btn-save">Guardar información</button>
            </div>
        </form>
    </div>
    <!-- Overlay -->
    <div class="popup-overlay fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>

   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    {{-- <script src="{{ asset('js/company/profile-2.js') }}"></script> --}}

    <script>
        const memberId = {{ $teamMember->id }};
        console.log("tm-id : "+memberId);
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
           document.body.style.overflow = 'hidden';
       }

       function closeModal() {
           document.getElementById('bannerModal').classList.remove('active');
           document.body.style.backgroundColor = '#fff';
           document.body.style.overflow = '';
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
            fetch("{{ route('company.update.team.member.avatar') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    avatar: imageName, // Passer le nom de l'image
                    memberId: memberId // Passer l'ID du membre
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
           const idMember = {{$teamMember->id}}

           // Envoi de la requête AJAX pour mettre à jour la base de données
           fetch("{{ route('company.update.member.avatar') }}", {
               method: "POST",
               headers: {
                   'Content-Type': 'application/json',
                   'X-CSRF-TOKEN': "{{ csrf_token() }}"
               },
               body: JSON.stringify({
                   avatar: imageName,
                   memberID: idMember
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
       document.addEventListener('DOMContentLoaded', () => {
       const popup = document.getElementById('popup');
       const openButton = document.getElementById('openPopup');
       const closeButton = document.getElementById('closePopup');
       const socialForm = document.getElementById('socialForm');

       // Open popup
       openButton.addEventListener('click', () => {
           popup.classList.add('active');
           document.body.style.overflow = 'hidden';
       });

       // Close popup
       closeButton.addEventListener('click', () => {
           popup.classList.remove('active');
           document.body.style.overflow = '';
       });

       // Close popup when clicking outside
       popup.addEventListener('click', (e) => {
           if (e.target === popup) {
               popup.classList.remove('active');
               document.body.style.overflow = '';
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
       // Get the button, popup container, and overlay
       const btnEditAbout = document.getElementById('btn-edit-about');
       const popupContainer = document.querySelector('.popup-sobre-mi-container');
       const popupOverlay = document.querySelector('.popup-overlay');
   
       // Event listener for showing the popup
       btnEditAbout.addEventListener('click', () => {
       popupContainer.style.display = 'block'; // Show the popup
       popupOverlay.style.display = 'block'; // Show the overlay
       document.body.style.backgroundColor = '#d3d3d3'; // Change the background color of the body

       document.body.style.overflow = 'hidden';
       });
   
       // Event listener for closing the popup when clicking on the overlay
       document.getElementById("popup-sobre-mi-btn-delete").addEventListener('click', () => {
       popupContainer.style.display = 'none'; // Hide the popup
       popupOverlay.style.display = 'none'; // Hide the overlay
       document.body.style.backgroundColor = '#fff'; // Reset the body background color

       document.body.style.overflow = '';
       });
   </script>
   

   <script>
        function openEditPopup() {
            document.getElementById('editDetailsPopup').classList.remove('hidden'); // Afficher le popup
            document.body.style.overflow = 'hidden';
        }
        function closeEditPopup() {
            document.getElementById('editDetailsPopup').classList.add('hidden'); // Fermer le popup
            document.body.style.overflow = '';
        }

   </script>
   
   
    </body>
    </html>
@endsection