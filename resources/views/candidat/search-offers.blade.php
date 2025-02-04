<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TalentSelect - Find Your Ideal Job</title>
    <link rel="stylesheet" href="{{ asset('css/search-offers/firstPage.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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

        <div class="hero-section">
            <h1 class="hero-title">
                Encuentra tu <span class="highlight">Trabajo ideal</span>
            </h1>
            <p class="hero-subtitle">
                Filtra y encuentra el trabajo que mas se adapte a tus necesidades
            </p>
            <div class="search-container">
                <div class="search-box">
                    <input type="text" placeholder="Título o palabra clave" class="search-input" autocomplete="off">
                    <div class="location-input" style="z-index: 200">
                        <div class="autocomplete-container">
                            <input type="text" id="city-input" class="location-field" placeholder="Buscar ciudad..." autocomplete="off">
                            <div id="city-suggestions" class="suggestions-dropdown"></div>
                        </div>
                    </div>
                    <a style="margin-top: 6px" href="#ert">
                        <button class="search-button">Search</button>
                    </a>
                </div>
                <div class="popular-searches">
                    Popular : <span class="tags">UI Designer, UX Researcher, Android, Admin</span>
                </div>
            </div>
        </div>
        
    </header>


    <div class="page-header-offers">
        <div class="header-offers-content">
            <h1 id="ert" class="header-offers-title">Todos los empleos</h1>
            <div class="header-offers-controls">
                {{-- <select class="sort-select" id="jobSort">
                    <option value="relevant">Más relevantes</option>
                    <option value="recent">Más recientes</option>
                </select> --}}
                <button class="view-toggle">⊞</button>
                <button class="view-toggle">≣</button>
            </div>
        </div>
    </div>


    <button id="filterToggle" class="filter-toggle-btn">
        <i class="fa-solid fa-filter"></i> Filtros
    </button>
    
    
    
    <div class="main-offers-container">
        <aside class="sidebar">
            <div class="filter-section">
                <div class="filter-header">
                    <h3 class="filter-title">Tipo de Empleo</h3>
                    <span class="filter-toggle"> <i class="fa-solid fa-chevron-down"></i> </span>
                </div>
                <div class="filter-content">
                    <div class="filter-option">
                        <input type="checkbox" id="fullTime" class="filter-checkbox">
                        <label class="checkbox-label" for="fullTime">Tiempo completo (3)</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="partTime" class="filter-checkbox">
                        <label class="checkbox-label" for="partTime">Media jornada (5)</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="remote" class="filter-checkbox">
                        <label class="checkbox-label" for="remote">Remoto (2)</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="hybrid" class="filter-checkbox">
                        <label class="checkbox-label" for="hybrid">Hibrido (24)</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="ji" class="filter-checkbox">
                        <label class="checkbox-label" for="ji">Jornada intensiva (3)</label>
                    </div>
                </div>
            </div>

            <div class="filter-section">
                <div class="filter-header">
                    <h3 class="filter-title">Categorías</h3>
                    <span class="filter-toggle"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="filter-content">
                    @foreach ($categories as $categorie)    
                    <div class="filter-option">
                        <input type="checkbox" id="{{ $categorie->name }}" class="filter-checkbox">
                        <label class="checkbox-label" for="{{ $categorie->name }}">{{ $categorie->name }}</label>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="filter-section">
                <div class="filter-header">
                    <h3 class="filter-title">Experiencia (años) </h3>
                    <span class="filter-toggle"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="filter-content">
                    <div class="filter-option">
                        <input type="checkbox" id="without-experience" class="filter-checkbox">
                        <label class="checkbox-label" for="without-experience">Sin experiencia </label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="one-twoo-years" class="filter-checkbox">
                        <label class="checkbox-label" for="one-twoo-years">Entre 1 a 2 años </label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="twoo-three-years" class="filter-checkbox">
                        <label class="checkbox-label" for="twoo-three-years">Entre 2 a 3 años  </label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="three-four-years" class="filter-checkbox">
                        <label class="checkbox-label" for="three-four-years">Entre 3 a 4 años   </label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="more-than-four" class="filter-checkbox">
                        <label class="checkbox-label" for="more-than-four">Mas de 4 años   </label>
                    </div>
                </div>
            </div>

            <div class="filter-section">
                <div class="filter-header">
                    <h3 class="filter-title">Rango salarial Anual/hr</h3>
                    <span class="filter-toggle"><i class="fa-solid fa-chevron-down"></i></span>
                </div>
                <div class="filter-content">
                    <div class="filter-option">
                        <input type="checkbox" id="zero-ten-salary" class="filter-checkbox">
                        <label class="checkbox-label" for="zero-ten-salary">0 - 10k (4)</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="eleven-twenty-five-salary" class="filter-checkbox">
                        <label class="checkbox-label" for="eleven-twenty-five-salary">11k- 25k (6)</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="twenty-sixe-fourty-salary" class="filter-checkbox">
                        <label class="checkbox-label" for="twenty-sixe-fourty-salary">26k - 40k (10)</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="salary40k" class="filter-checkbox">
                        <label class="checkbox-label" for="salary40k">mas de 40k (4)</label>
                    </div>
                </div>
            </div>
        </aside>

        <main class="job-listings">
            @foreach ($offers as $offer)
                <article class="job-card">
                    <h2 class="job-title">{{ $offer->title }}</h2>
                    <p class="job-location">{{ $offer->place }}</p>
                    <div class="job-tags">
                        <span class="job-tag-1">{{ $offer->work_type }}</span>
                        <span class="job-tag">{{ $offer->category }}</span>
                        {{-- @php
                            $category = $categories->firstWhere('offer_id', $offer->id);
                        @endphp

                        @if ($category)
                        @else
                            <span class="job-tag">No hay categorías disponibles</span>
                        @endif --}}
                        <span class="job-tag">{{ $offer->starting_salary . "-" . $offer->final_salary }}</span>
                    </div>
                    <button onclick="document.getElementById('form-get-offer-{{ $offer->id }}').submit();" class="apply-button">Postular</button>
                    <form method="GET" id="form-get-offer-{{ $offer->id }}" action="{{ route('candidat.show.offer', ['id' => $offer->id]) }}">
                    </form>


                </article>
            @endforeach
        </main>
    </div>

    <script>
            const geoNamesUsername = "mahdi";
            let cities = []; // Store all cities

            // Function to load cities
            async function loadCities() {
                const cityInput = document.getElementById("city-input");
                const suggestionsDiv = document.getElementById("city-suggestions");
                
                try {
                    const response = await fetch(`http://api.geonames.org/searchJSON?continent=Europe&featureClass=P&maxRows=1000&username=${geoNamesUsername}`);
                    const data = await response.json();
                    cities = data.geonames.map(city => city.name);
                    
                    // Add event listeners
                    cityInput.addEventListener('input', handleInput);
                    cityInput.addEventListener('focus', () => {
                        if (cityInput.value) handleInput();
                    });
                    
                    // Close suggestions when clicking outside
                    document.addEventListener('click', (e) => {
                        if (!e.target.closest('.autocomplete-container')) {
                            suggestionsDiv.style.display = 'none';
                        }
                    });
                } catch (error) {
                    console.error("Error loading cities:", error);
                }
            }

            // Function to handle input changes
            function handleInput() {
                const cityInput = document.getElementById("city-input");
                const suggestionsDiv = document.getElementById("city-suggestions");
                const inputValue = cityInput.value.toLowerCase();
                
                // Filter cities based on input
                const filteredCities = cities.filter(city => 
                    city.toLowerCase().includes(inputValue)
                ).slice(0, 10); // Limit to 10 suggestions
                
                // Display suggestions
                if (inputValue && filteredCities.length > 0) {
                    suggestionsDiv.innerHTML = '';
                    filteredCities.forEach(city => {
                        const div = document.createElement('div');
                        div.className = 'suggestion-item';
                        div.textContent = city;
                        div.onclick = () => {
                            cityInput.value = city;
                            suggestionsDiv.style.display = 'none';
                        };
                        suggestionsDiv.appendChild(div);
                    });
                    suggestionsDiv.style.display = 'block';
                } else {
                    suggestionsDiv.style.display = 'none';
                }
            }

            // Load cities when page loads
            loadCities();
    </script>

    
    
    
    
    <script>
        function initializeFilters() {
            const filterSections = document.querySelectorAll('.filter-section');
            
            filterSections.forEach(section => {
                const header = section.querySelector('.filter-header');
                const content = section.querySelector('.filter-content');
                const toggle = section.querySelector('.filter-toggle');
                
                header.addEventListener('click', () => {
                    content.classList.toggle('collapsed');
                    toggle.classList.toggle('collapsed');
                });
            });
        }

        function initializeViewToggle() {
            const [gridButton, listButton] = document.querySelectorAll('.view-toggle');
            const jobListings = document.querySelector('.job-listings');

            gridButton.innerHTML = '⊞';
            listButton.innerHTML = '≣';

            gridButton.addEventListener('click', () => {
                jobListings.classList.add('grid-view');
                jobListings.classList.remove('list-view');
                gridButton.classList.add('active');
                listButton.classList.remove('active');
            });

            listButton.addEventListener('click', () => {
                jobListings.classList.remove('grid-view');
                jobListings.classList.add('list-view');
                listButton.classList.add('active');
                gridButton.classList.remove('active');
            });

            // Set default view
            listButton.click();
        }

        document.addEventListener('DOMContentLoaded', () => {
            initializeFilters();
            initializeViewToggle();
        });
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            if (window.innerWidth > 768) {
                // Gestion du header
                const header = document.querySelector(".page-header-offers");
                const offers = document.querySelector(".job-listings");
                const headerOffset = header.offsetTop;

                window.addEventListener("scroll", function () {
                    if (window.pageYOffset > headerOffset) {
                        header.classList.add("fixed");
                    } else {
                        header.classList.remove("fixed");
                    }
                });

                // Gestion du sidebar
                const sidebar = document.querySelector(".sidebar");
                const sidebarOffset = sidebar.offsetTop; // Position initiale du sidebar

                window.addEventListener("scroll", function () {
                    if (window.pageYOffset > sidebarOffset - 75) {
                        sidebar.classList.add("fixed");
                    } else {
                        sidebar.classList.remove("fixed");
                    }
                });
            }
        });
    </script>

    

@auth
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll('.filter-checkbox');
            const jobListings = document.querySelector('.job-listings');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // Récupérer les valeurs des cases cochées
                    let selectedFilters = [];
                    checkboxes.forEach(box => {
                        if (box.checked) {
                            selectedFilters.push(box.id);
                        }
                    });

                    // Envoyer les filtres via AJAX
                    fetch('{{ route("candidat.filter.offers") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ filters: selectedFilters })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Mise à jour des offres dans le DOM
                        jobListings.innerHTML = data.html;
                    })
                    .catch(error => console.error('Erreur:', error));
                });
            });
        });
    </script>

    <script>
        document.querySelector('.search-button').addEventListener('click', function () {
            // Récupérer les valeurs de l'input et du select
            const keyword = document.querySelector('.search-input').value;
            const city = document.querySelector('#city-input').value;

            // Envoyer les données avec les autres filtres
            const filters = [];
            document.querySelectorAll('.filter-checkbox:checked').forEach((checkbox) => {
                filters.push(checkbox.id);
            });

            // Requête AJAX pour envoyer les données
            fetch('{{ route("candidat.filter.offers") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ 
                    filters: filters, 
                    keyword: keyword, 
                    city: city 
                })
            })
            .then(response => response.json())
            .then(data => {
                // Insérer le HTML dans votre conteneur des offres
                document.querySelector('.job-listings').innerHTML = data.html;
            })
            .catch(error => console.error('Erreur:', error));
        });
    </script>

@else
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll('.filter-checkbox');
            const jobListings = document.querySelector('.job-listings');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // Récupérer les valeurs des cases cochées
                    let selectedFilters = [];
                    checkboxes.forEach(box => {
                        if (box.checked) {
                            selectedFilters.push(box.id);
                        }
                    });

                    // Envoyer les filtres via AJAX
                    fetch('{{ route("candidat.filter.offers.g") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ filters: selectedFilters })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Mise à jour des offres dans le DOM
                        jobListings.innerHTML = data.html;
                    })
                    .catch(error => console.error('Erreur:', error));
                });
            });
        });
    </script>     
@endauth
    


    <script>
        document.getElementById('menuToggle').addEventListener('click', function() {
            this.classList.toggle('active');
            document.getElementById('navLinks').classList.toggle('active');
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.innerWidth <= 768) {
                const filterToggle = document.createElement('button');
                filterToggle.id = 'filterToggle';
                filterToggle.className = 'filter-toggle-btn';
                filterToggle.innerHTML = '<i class="fa-solid fa-filter"></i> Filtros';
                document.body.appendChild(filterToggle);
        
                const sidebar = document.querySelector('.sidebar');
                
                filterToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
        
                document.addEventListener('click', function(e) {
                    if (!sidebar.contains(e.target) && !filterToggle.contains(e.target)) {
                        sidebar.classList.remove('active');
                    }
                });
            }
        });
    </script>

</body>
</html>
