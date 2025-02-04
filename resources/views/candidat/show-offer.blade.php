<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TalentSelect - Find Your Ideal Job</title>
    <link rel="stylesheet" href="{{ asset('css/search-offers/SecondPage.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=678b4cf99b23f50012715385&product=inline-share-buttons&services=facebook,email,linkedin" async="async"></script>
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <div class="logo">
                <a href="/">
                    <img src="{{ asset('images/logo/logo2.png') }}" alt="TalentSelect" class="logo-img">
                </a>
            </div>
            <button class="mobile-menu-toggle" aria-label="Toggle menu" id="menuToggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <div class="nav-links" id="navLinks">
                <a href="/" class="nav-link">Inicio</a>
                <a href="{{route('candidat.search.offers')}}" style="color: #2A7FFF" class="nav-link active">Ofertas de empleo</a>
                <a href="/seleccion" class="nav-link">Selección 2.0</a>
                <a href="/nosotros" class="nav-link">Sobre Nosotros</a>
                <a href="/contacto" class="nav-link">Contacto</a>
                <div class="auth-buttons">
                    @auth
                        <a href="{{ route('candidat.dashboard') }}" class="btn btn-logout">
                            Mi cuenta
                        </a>
                    @else
                        <a href="{{ route('candidat.login') }}" class="btn btn-login">Iniciar de Sesión</a>
                        <a href="{{ route('candidat.register') }}" class="btn btn-register">Registrarse</a>
                    @endauth
                </div>
            </div>
        </nav>


        @if(session('success'))
            <div id="success-notification" class="notification">
                {{ session('success') }}
            </div>
        @endif
        
        
        <div class="job-header">
            <div class="job-title-section">
                @if (isset($application))
                    <h1 style="display: inline-block;">{{$offer->title}}</h1>
                    <span class="app_status">{{$application->status}}</span>
                    <p class="location">{{$offer->place}} • {{$offer->work_type}}</p>
                @else
                    <h1>{{$offer->title}}</h1>
                    <p class="location">{{$offer->place}} • {{$offer->work_type}}</p>
                @endif
            </div>
            <div class="action-buttons">
                <div style="z-index: 200" class="sharethis-inline-share-buttons"></div>

                {{-- <button class="share-btn" id="shareBtn">
                    <i class="fa fa-share-alt" aria-hidden="true"></i>
                </button>
               
                
                {{-- <button class="share-btn" id="shareBtn">
                    <i class="fa fa-share-alt" aria-hidden="true"></i>
                </button> --}}
                
                

                @if (isset($application))
                    <button disabled class="apply-btn">Ya aplicado</button>
                    <button class="cancel-btn" onclick="confirmCancelApplication({{ $application->id }})">
                        Cancelar candidatura
                    </button>
                @else
                    <button class="apply-btn">Enviar solicitud</button>
                @endif
            </div>
        </div>
        
    </header>

    <main class="job-content">
        <div class="job-details">
            <section class="description">
                <h2>Descripción</h2>
                <p>{{ $aboutOffer ? htmlspecialchars($aboutOffer->description) : 'No hay descripción disponible para esta oferta.' }}</p>
            </section>

            <section class="responsibilities">
                <h2>Responsabilidades</h2>
                @if ($responsibilities->isEmpty())
                    <p>No hay responsabilidades disponibles para esta oferta.</p>
                @else
                    <ul>
                        @foreach ($responsibilities as $responsibility)
                            <li> <i class="fa-regular fa-circle-check"></i>  {{ $responsibility->responsibility }} </li>
                        @endforeach
                    </ul>
                @endif
            </section>
            
            <section class="knowledge">
                <h2>Conocimientos y Habilidades Requeridos</h2>
                @if ($knowledges->isEmpty())
                    <p>No hay conocimientos disponibles para esta oferta.</p>
                @else
                    <ul>
                        @foreach ($knowledges as $knowledge)
                            <li><i class="fa-regular fa-circle-check"></i> {{ $knowledge->knowledge }}</li>
                        @endforeach
                    </ul>
                @endif
            </section>

            <section class="nice-to-have">
                <h2>Se valora </h2>
                @if ($niceToHaves->isEmpty())
                    <p>No hay requisitos adicionales para esta oferta.</p>
                @else
                    <ul>
                        @foreach ($niceToHaves as $niceToHave)
                            <li><i class="fa-regular fa-circle-check"></i> {{ $niceToHave->nice_to_have }}</li>
                        @endforeach
                    </ul>
                @endif
            </section>
        </div>

        
        <aside class="job-sidebar">
            <div class="job-info-card">
                <h3>Sobre este rol</h3>
                <div class="info-item">
                    <span class="label">Solicitudes enviadas</span>
                    <span class="value"> {{$applicationCount }} para una vacante</span>
                </div>
                <div class="info-item">
                    <span class="label">Aplicar antes de</span>
                    <span class="value">
                        {{ $offer->postulation_deadline ? $offer->postulation_deadline->translatedFormat('j \d\e F \d\e Y') : 'Fecha no disponible' }}
                    </span>
                    
                </div>
                <div class="info-item">
                    <span class="label">Empleo publicado en</span>
                    <span class="value">{{ $offer->created_at->translatedFormat('j \d\e F \d\e Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Tipo de empleo</span>
                    <span class="value">{{$offer->work_type}}</span>
                </div>
                <div class="info-item">
                    <span class="label">Salario</span>
                    <span class="value">{{$offer->starting_salary}} - {{$offer->final_salary}} Euros</span>
                </div>
            </div>

            <div class="categories-section">
                <h3>Categoría</h3>
                <div class="tags">
                    {{-- @if ($categories && $categories->isNotEmpty()) --}}
                        {{-- @foreach ($categories as $category) --}}
                        <span class="tag">{{ $offer->category }}</span>
                        {{-- @endforeach --}}
                    {{-- @else --}}
                        {{-- <span class="error-message">No hay categorías disponibles para esta oferta.</span> --}}
                    {{-- @endif --}}
                </div>
                
            </div>

            <div class="skills-section">
                <h3>Idiomas y Skills</h3>
                <div class="tags">
                    @if ($skills && $skills->isNotEmpty())
                        @foreach ($skills as $skill)
                            <span class="tag">{{$skill->skill_name}}</span>
                        @endforeach
                    @else
                        <span class="error-message">No hay competencias ni idiomas disponibles para esta oferta.</span>
                    @endif

                    {{-- @if ($languages->isEmpty())
                        <span class="error-message">No se encontraron idiomas disponibles para esta oferta.</span>
                    @else
                        @foreach ($languages as $language)
                            <span class="tag">{{ $language->language }}</span>
                        @endforeach
                    @endif --}}
                </div>
            </div>
        </aside>

        <div class="job-details">
            <section class="benefice">
                <h2>Beneficios y ventajas</h2>
                <p>Este trabajo viene con varias ventajas y beneficios</p>
                <div class="benefits-container" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 20px;">

                    @if ($benefits->isEmpty())
                        <p>No se ofrecen beneficios adicionales para esta oferta.</p>
                    @else
                        @foreach ($benefits as $benefit)
                            <div class="benefit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none" style="width: 40px; height: 40px;">
                                    <!-- Cercle -->
                                    <circle cx="24" cy="24" r="24" fill="#0D72FF"/>
                                    <!-- Icône (positionnée au centre) -->
                                    <svg x="14.5" y="17" width="19" height="14" viewBox="0 0 19 14" fill="none">
                                    <path d="M5.94631 13.2346C5.59988 13.2344 5.26421 13.1142 4.99631 12.8946L0.516307 9.22459C-0.0962757 8.69243 -0.174597 7.7696 0.33954 7.14181C0.853678 6.51402 1.77384 6.40892 2.41631 6.90459L5.88631 9.74459L15.8863 0.534592C16.2622 0.0876644 16.8633 -0.100495 17.4269 0.0523425C17.9905 0.20518 18.4142 0.671229 18.5128 1.24682C18.6114 1.82241 18.3669 2.40289 17.8863 2.73459L6.96631 12.8346C6.69 13.0935 6.32496 13.2367 5.94631 13.2346Z" fill="white"/>
                                    </svg>
                                </svg>                          
                                <h3 style="margin-top: 9px"><strong>{{$benefit->title}}</strong></h3>
                                <p>{{$benefit->benefit}}</p>
                            </div>
                        @endforeach
                    @endif
                </div>
            </section>
        </div>


    
        
    </main>


    <div class="job-section">
        <h2>Trabajos similares</h2>
        <div class="view-all">
            <a href="{{route('candidat.search.offers')}}">Mostrar todos los trabajos <i class="fa fa-arrow-right" aria-hidden="true"></i> </a>
        </div>
        <div class="job-grid">

            @if ($relatedOffers && $relatedOffers->isNotEmpty())
                @foreach ($relatedOffers as $relatedOffer)
                    <a href="{{ route('candidat.show.offer', ['id' => $relatedOffer->id]) }}" style="text-decoration: none; color: #333;;">
                        <div class="job-card" style="cursor: pointer;">
                            <h3>{{ $relatedOffer->title }}</h3>
                            <p>{{ $relatedOffer->place }} • {{ $relatedOffer->work_type }}</p>
                            <div class="tags">
                                <span class="tag work-t">{{ $relatedOffer->work_type }}</span>
                                @php
                                    $categories = \App\Models\OfferCategory::where('offer_id', $relatedOffer->id)->take(2)->pluck('name');
                                @endphp
                                @foreach ($categories as $category)
                                    <span class="tag">{{ $category }}</span>
                                @endforeach
                                
                            </div>
                        </div> 
                    </a> 
                @endforeach
            @else
                <span>No se encontraron ofertas relacionadas con esta categoría.</span>
            @endif     

        </div>
        
    </div>



    <div class="popup-container">
        <div class="popup">
            <!-- Bouton pour fermer la popup -->
            <button class="close-btn">&times;</button>
    
            <!-- Titre -->
            <h2>{{$offer->title}}</h2>
            <p>{{$offer->place}} &bull; {{$offer->work_type}}</p>
    
            <!-- Formulaire -->
            <form method="POST" action="{{ route('candidat.offer.normale.application') }}">
                @csrf
                <!-- Inputs cachés -->
                <input type="hidden" name="candidat_id" value="{{ Auth::user()->id }}">
                <input type="hidden" name="offer_id" value="{{ $offer->id }}">
    
                <!-- Bouton d'action -->
                <button type="submit" class="btn">Aplicar con mi perfil actual</button>
            </form>
    
            <!-- Lien pour actualiser le profil -->
            <a href="{{ route('candidat.profile') }}" style="cursor: pointer;">
                <button class="text-actualize" style="cursor: pointer;">Actualizar perfil y volver a la oferta</button>
            </a>
            
            <hr style="margin-top: 12px">
    
            <h3 style="margin-top: 12px; color: #0D72FF; font-weight: bold;">Crear solicitud sencilla</h3>
                <form  method="POST" enctype="multipart/form-data" action="{{ route('candidat.offer.custom.application') }}" >
                    @csrf
                    <input type="hidden" name="candidat_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="offer_id" value="{{ $offer->id }}">

                    <div class="attach-section" style="margin-top: 12px">
                        <label class="attach-label">Adjuntar CV detallado</label>
                        
                        <label class="attach-input" id="attach-label">
                            <input type="file" name="cv_file" id="cv-upload" accept=".pdf, .docx" style="display: none;">
                            <span id="file-label">Attach Resume/CV</span>
                        </label>
                    </div>
            
                    <label style="font-weight: 500;">Información adicional</label>
                    <textarea name="add_infos" placeholder="Añadir una carta de presentación o otra información" maxlength="1000"></textarea>

                    <button type="submit" class="btn">Enviar solicitud personalizada</button>
                </form>    
    
            <!-- Pied de page -->
            <p class="footer">
                Al enviar la solicitud, puede confirmar que acepta nuestros 
                <a href="#">Términos de servicio</a> y 
                <a href="#">Política de privacidad</a>.
            </p>
        </div>
    </div>
    
 
    
    <script>
        // Initialisation du menu mobile
        function initMobileMenu() {
            const menuToggle = document.querySelector('.mobile-menu-toggle');
            const navLinks = document.querySelector('.nav-links');
            
            if (!menuToggle || !navLinks) return;
            
            menuToggle.addEventListener('click', () => {
                navLinks.classList.toggle('active');
                document.body.style.overflow = navLinks.classList.contains('active') ? 'hidden' : '';
            });
            
            document.addEventListener('click', (e) => {
                if (!navLinks.contains(e.target) && !menuToggle.contains(e.target)) {
                    navLinks.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        } 

        // initMobileMenu();
    </script>



    <script>
        // Afficher la popup
        document.querySelector('.apply-btn').addEventListener('click', function () {
            document.querySelector('.popup-container').style.display = "flex";
            document.body.style.overflow = 'hidden';
        });

        // Fermer la popup avec le bouton close
        document.querySelector('.close-btn').addEventListener('click', function () {
            document.querySelector('.popup-container').style.display = "none";
            document.body.style.overflow = '';
        });

        // Fermer la popup en cliquant à l'extérieur
        document.querySelector('.popup-container').addEventListener('click', function (e) {
            // Vérifier si le clic cible le conteneur et non la popup elle-même
            if (e.target.classList.contains('popup-container')) {
                document.querySelector('.popup-container').style.display = "none";
                document.body.style.overflow = '';
            }
        });
    </script>

    

    <script>
        document.getElementById('menuToggle').addEventListener('click', function() {
            this.classList.toggle('active');
            document.getElementById('navLinks').classList.toggle('active');
        });
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const fileInput = document.getElementById("cv-upload");
            const fileLabel = document.getElementById("file-label");

            fileInput.addEventListener("change", function () {
                if (fileInput.files.length > 0) {
                    // Mettre à jour le texte avec le nom du fichier
                    fileLabel.textContent = fileInput.files[0].name;
                } else {
                    // Si aucun fichier sélectionné, réinitialiser le texte
                    fileLabel.textContent = "Attach Resume/CV";
                }
            });

        });
    </script>

    
    <script>
        // Afficher la notification et la cacher après 2 secondes
        document.addEventListener("DOMContentLoaded", function () {
            const notification = document.getElementById("success-notification");
            if (notification) {
                notification.classList.add("show");
                setTimeout(() => {
                    notification.classList.remove("show");
                }, 2000); // 2 secondes
            }
        });
    </script>
   


   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script>
        function confirmCancelApplication(applicationId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas cancelar tu candidatura? Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, cancelar',
                cancelButtonText: 'No, mantener'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Envoi d'une requête DELETE via fetch
                    fetch(`{{ route('candidat.application.delete', '') }}/${applicationId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            Swal.fire(
                                'Candidatura Cancelada',
                                'Tu candidatura ha sido cancelada exitosamente.',
                                'success'
                            ).then(() => {
                                // Recharge la page ou redirige
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error',
                                'Hubo un problema al cancelar tu candidatura. Por favor, intenta nuevamente.',
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire(
                            'Error',
                            'Hubo un problema al cancelar tu candidatura. Por favor, intenta nuevamente.',
                            'error'
                        );
                    });
                }
            });
        }
    </script>






        <script>
            document.getElementById('shareBtn').addEventListener('click', async () => {
                const currentUrl = window.location.href; // URL actuelle à partager
                try {
                    if (navigator.share) {
                        await navigator.share({
                            title: document.title, // Titre de la page
                            text: 'Découvrez cette page intéressante !',
                            url: currentUrl // URL actuelle
                        });
                        console.log('Partage réussi');
                    } else {
                        alert('La fonctionnalité de partage n\'est pas prise en charge par votre navigateur.');
                    }
                } catch (error) {
                    console.error('Erreur lors du partage:', error);
                }
            });
        </script>


        <script>
            // Écouteur de clic pour le bouton principal
            document.getElementById('mainShareButton').addEventListener('click', () => {
                const shareOptions = document.getElementById('shareOptions');
                // Afficher/Masquer les options de partage
                if (shareOptions.style.display === 'none') {
                    shareOptions.style.display = 'block';
                } else {
                    shareOptions.style.display = 'none';
                }
            });
        </script>








</body>
</html>
