@extends('layouts.company')

@section('title', 'view offer')

@section('page-title', 'Mis solicitudes')

@section('content')


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TalentSelect - Find Your Ideal Job</title>
    <link rel="stylesheet" href="{{ asset('css/Company/view-offer.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>

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
    
    
    <header class="h">
        <div class="job-header">
            <div class="job-title-section">
                <h1>{{$offer->title}}</h1>
                <p class="location">{{$offer->place}} • {{$offer->work_type}}</p>
            </div>
            <div class="action-buttons">
                <button class="share-btn" id="shareBtn">
                    <i class="fa fa-share-alt" aria-hidden="true"></i>
                </button>
                <button class="apply-btn" onclick="window.location.href='{{ route('company.my.offers.edit.offer', ['id' => $offer->id]) }}'">
                    <a style="color: white; text-decoration: none;" href="{{route('company.my.offers.edit.offer', ['id' => $offer->id])}}">
                        Editar
                    </a>
                </button>
            </div>
        </div>
    </header>

    <main class="job-content" >
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
                    <span class="value">{{$applicationCount}} para una vacante</span>
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
                <h3>Categorías</h3>
                <div class="tags">
                    {{-- @if ($categories && $categories->isNotEmpty())
                        @foreach ($categories as $category) --}}
                            {{-- <span class="tag">{{ $category->name }}</span> --}}
                            <span class="tag">{{ $offer->category }}</span>
                        {{-- @endforeach
                    @else
                        <span class="error-message">No hay categorías disponibles para esta oferta.</span>
                    @endif --}}
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    
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
        document.addEventListener('DOMContentLoaded', () => {
            const alert = document.getElementById('success-alert');
            if (alert) {
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 5000);
            }
        });
        document.addEventListener('DOMContentLoaded', () => {
            const alert2 = document.getElementById('custom-alert');
            if (alert2) {
                setTimeout(() => {
                    alert2.style.display = 'none';
                }, 5000); 
            }
        });
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





</body>
</html>
@endsection