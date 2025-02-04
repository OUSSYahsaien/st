 <!DOCTYPE html>
 <html lang="es">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <title>@yield('title', 'Company - Portal')</title>
     <link rel="stylesheet" href="{{ asset('css/Company/layout/company.css') }}">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <lnk rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
 <body>
     <div class="container">
         <!-- Sidebar -->
         <aside class="sidebar">
             <div class="logo" style="display: flex;">
                <img src="{{ asset('images/logo/logo2.png') }}" alt="Talent Select Logo">
                <div class="close-sidebar-btn" style=" margin-left: 63px; margin-top: 9px;">
                    <i class="fa-solid fa-xmark" style=" font-size: 24px; color: #3064FE;"></i>
                </div>
             </div>

             <nav>
                 <ul class="nav-menu">
                     <li class="nav-item">
                         <a draggable="false" href="{{ route('company.dashboard') }}" class="nav-link {{ Request::is('company/dashboard') ? 'active' : '' }}">
                             <i class="fas fa-home"></i>
                             Inicio
                         </a>
                     </li>
                     <li class="nav-item">
                         <a draggable="false" href="{{ route('company.my.offers') }}" class="nav-link {{ Request::is('company/myOffers') || Request::is('company/offers/*') ? 'active' : '' }}">
                             <i class="fas fa-file-alt"></i>
                             Mis solicitudes
                         </a>
                     </li>
                     {{-- <li class="nav-item">
                         <a draggable="false" href="{{ route('candidat.search.offers') }}" class="nav-link {{ Request::is('candidat/ofertas') ? 'active' : '' }}">
                             <i class="fas fa-search"></i>
                             Ver ofertas
                         </a>
                     </li> --}}
                     <li class="nav-item">
                         <a draggable="false" href="{{ route('company.profile') }}" class="nav-link {{ Request::is('company/profile') || Request::is('company/edit-profile') || Request::is('company/add-in-equipe') || Request::is('company/view-team-member/*')  || Request::is('company/edit-team-member/*') ? 'active' : ''}}">
                             <i class="fas fa-user"></i>
                             Mi perfil de empresa
                         </a>
                     </li>
                     <li class="nav-item">
                         <form method="POST" action="{{ route('company.logout') }}" style="margin: 0;">
                             @csrf
                             <button onclick="changeColor(this)" type="submit" class="nav-link logout-button">
                                 <i class="fa fa-power-off" aria-hidden="true"></i>
                                 Logout
                             </button>
                         </form>
                     </li>
                 </ul>
                 <hr>
             </nav>
 
             <!-- Profile Section -->
                <div class="profile-section">
                    @php
                        $personalPicturePath = 'images/companies_images/' . Auth::user()->personel_pic;
                        $personalDefaultPicturePath = 'images/companies_images/100x100.svg';
                    @endphp
                    @if (Auth::user()->personel_pic && file_exists(public_path($personalPicturePath)))
                        <img src="{{ asset($personalPicturePath) }}" alt="Foto de perfil" class="profile-image">
                    @else
                        <img src="{{ asset($personalDefaultPicturePath) }}" alt="Foto de perfil" class="profile-image">
                    @endif
                    <div class="profile-info">
                        <span class="profile-name">
                            @php
                                $responsable = App\Models\TeamMember::where('company_id', Auth::user()->id)
                                                                    ->where('role', 'responsable')
                                                                    ->first();
                            @endphp
                        
                            {{ $responsable ? $responsable->full_name : '' }}
                        </span>
                        
                        <span class="profile-email">{{ Auth::user()->email }}</span>
                    </div>
                </div>
         </aside>
 
            <!-- Main Content -->
            <main class="main-content">
                <header class="header">
                    <button class="toggle-sidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="page-title-c">@yield('page-title', 'Bienvenido')</h1>
                    <div class="right-section">
                        <a href="{{ route('candidat.login') }}" class="web-link">Volver a la página web</a>
                        <div class="dropdown">
                            <i class="fa-regular fa-bell notification-bell" id="notificationBell">
                                @if(Auth::user()->unreadNotifications->count() > 0)
                                    <span class="notification-badge">{{ Auth::user()->unreadNotifications->count() }}</span>
                                @endif
                            </i>
                            <div class="notifications-container">
                                <h2 class="notifications-header">
                                    Notifications
                                    <a href="#" class="mark-all" onclick="event.preventDefault(); markAllAsRead();">
                                        Marcar todo como leído
                                    </a>
                                </h2>
                                <div class="notifications-list">
                                    @forelse(Auth::user()->unreadNotifications as $notification)

                                        @if ($notification->type == "App\Notifications\OfferStatusUpdated")

                                            @php
                                                $offer = \App\Models\offers::find($notification->data['offer_id']);
                                                $admin = \App\Models\Administration::first();
                                            @endphp

                                            <div class="notification-item candidat-notif new">

                                                    <form action="{{ route('company.notifications.markAsRead', $notification->id) }}" 
                                                        method="POST" 
                                                        class="view-details-form" style="display: none;">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="view-details-btn btn-candidat-notif" 
                                                            id="{{$notification->id}}"
                                                            title="Ver detalles">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                                
                                            
                                                @php
                                                    $personalPicturePath = 'images/admin_images/' . $admin->image_name;
                                                @endphp


                                                @if ($admin->image_name && file_exists(public_path($personalPicturePath)))
                                                    <img src="{{ asset($personalPicturePath) }}" 
                                                    alt="Profile" 
                                                    class="profile-pic-notif">
                                                @else
                                                    <img src="{{ asset('images/companies_images/100x100.svg') }}" 
                                                    alt="Profile" 
                                                    class="profile-pic-notif">
                                                @endif

                                                
                                                <div class="notification-content">
                                                    <p class="notification-text">
                                                        <strong>{{ $admin->username }}</strong>
                                                        El estado de su oferta de <strong>{{ $offer->title }}</strong> ha cambiado
                                                    </p>
                                                    <span class="notification-time">
                                                        {{ $notification->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                                @if(!$notification->read_at)
                                                    <span class="status-badge-app status-app-{{$notification->data['status']}}">{{$notification->data['status']}}</span>
                                                @endif
                                            </div>
                                            
                                        @else
                                            @php
                                                $event = \App\Models\Event::find($notification->data['event_id']);
                                                $admin = \App\Models\Administration::first();
                                            @endphp

                                            <div class="notification-item candidat-notif-2 new">

                                                <form action="{{ route('company.notifications.markAsRead', $notification->id) }}" 
                                                        method="POST" 
                                                        class="view-details-form" style="display: none;">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="view-details-btn btn-candidat-notif-2" 
                                                            id="{{$notification->id}}"
                                                            title="Ver detalles">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </button>
                                                </form>


                                                @php
                                                    $personalPicturePath = 'images/admin_images/' . $admin->image_name;

                                                    $startDate = \Carbon\Carbon::parse($event->start);
                                                    
                                                    $day = $startDate->day;
                                                    $month = strtolower($startDate->isoFormat('MMMM')); // "january" -> "enero" si la locale est es
                                                    $year = $startDate->year;
                                                    $time = $startDate->format('H:i');
                                                @endphp


                                                @if ($admin->image_name && file_exists(public_path($personalPicturePath)))
                                                    <img src="{{ asset($personalPicturePath) }}" 
                                                    alt="Profile" 
                                                    class="profile-pic-notif">
                                                @else
                                                    <img src="{{ asset('images/companies_images/100x100.svg') }}" 
                                                    alt="Profile" 
                                                    class="profile-pic-notif">
                                                @endif


                                                <div class="notification-content">
                                                    <p class="notification-text">
                                                        <strong>{{ $admin->username }}</strong>
                                                    {{-- Nuevo evento '{{ $event->title }}' programado: {{ $day }} de {{ $month }} de {{ $year }} a las {{ $time }} horas --}}
                                                    Nuevo evento programado: {{ $day }} de {{ $month }} de {{ $year }} a las {{ $time }} horas
                                                        
                                                    </p>
                                                    <span class="notification-time">
                                                        {{ $notification->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                                @if(!$notification->read_at)
                                                    <span class="status-badge-app">new</span>
                                                @endif
                                            </div>
                                        @endif
                                        
                                    @empty
                                        <p class="no-notifications">No hay nuevas notificaciones</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                
                {{-- <hr style="margin-top: -30px; width: 100%; color: #D6DDEB;"> --}}
            
                <!-- Contenu spécifique à la page -->
                <div class="content">
                    @yield('content')
                </div>
            </main>        
     </div>
 
     <script src="{{ asset('js/candidats.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

     {{-- <script>
        document.addEventListener('DOMContentLoaded', () => {
          const toggleButton = document.querySelector('.toggle-sidebar');
          const sidebar = document.querySelector('.sidebar');
      
          toggleButton.addEventListener('click', () => {
            sidebar.classList.remove('closed');
            sidebar.classList.toggle('open');
          });
        });
      </script>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
        const closeButton = document.querySelector('.close-sidebar-btn'); // Bouton pour fermer
        const sidebar = document.querySelector('.sidebar'); // Élément sidebar
    
        // Fonction pour fermer la sidebar
        closeButton.addEventListener('click', () => {
            sidebar.classList.remove('open');
            sidebar.classList.toggle('closed'); // Basculer la classe 'closed' pour masquer/afficher
        });
        });
    </script>
   --}}



  
  <script>
    document.addEventListener('DOMContentLoaded', () => {
    const toggleButton = document.querySelector('.toggle-sidebar');
    const closeButton = document.querySelector('.close-sidebar-btn');
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    const header = document.querySelector('.header');

    function toggleSidebar() {
        sidebar.classList.toggle('open');
        document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
    }

    toggleButton.addEventListener('click', toggleSidebar);
    closeButton.addEventListener('click', toggleSidebar);

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 1170 &&
            !sidebar.contains(e.target) &&
            !toggleButton.contains(e.target) &&
            sidebar.classList.contains('open')) {
            toggleSidebar();
        }
    });
});
  </script>
  
  
  
      






    
        
    <script>
        document.querySelector('.fa-bell').addEventListener('click', function(e) {
            e.stopPropagation();
            document.querySelector('.notifications-container').classList.toggle('show');
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.notifications-container')) {
                document.querySelector('.notifications-container').classList.remove('show');
            }
        });





        // Fermer les notifications en swipant vers le bas sur mobile
        let touchStarttY = 0;
        let touchEndY = 0;

        document.querySelector('.notifications-container').addEventListener('touchstart', e => {
            touchStarttY = e.touches[0].clientY;
        });

        document.querySelector('.notifications-container').addEventListener('touchmove', e => {
            touchEndY = e.touches[0].clientY;
            
            if (touchEndY - touchStarttY > 50) { // Si swipe vers le bas
                document.querySelector('.notifications-container').classList.remove('show');
            }
        });

        // Empêcher le scroll de la page quand on scroll dans les notifications
        document.querySelector('.notifications-list').addEventListener('touchmove', e => {
            e.stopPropagation();
        });

        
        

        document.querySelectorAll('.view-details-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Récupérer l'URL de redirection du bouton
                const redirectUrl = this.querySelector('button').getAttribute('onclick').match(/'([^']+)'/)[1];
                
                // Envoyer la requête de marquage comme lu
                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                }).then(() => {
                    // Rediriger vers la page des applications
                    window.location.href = redirectUrl;
                });
            });
        });


        // Ajoutez ce script
        document.querySelectorAll('.candidat-notif').forEach(item => {
            item.addEventListener('mouseover', function(e) {
                // Éviter le déclenchement si on clique sur un autre élément cliquable
                if (e.target.closest('.btn-candidat-notif')) return;
                
                // Trouver et déclencher le clic sur le bouton caché
                const button = this.querySelector('.btn-candidat-notif');
                if (button) {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    
                    // Envoyer la requête AJAX
                    fetch(`/company/notifications/${button.id}/read`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Optionnel: Mettre à jour l'UI si nécessaire
                            // console.log('Notification marquée comme lue');
                        }
                    })
                    .catch(error => console.error('Erreur:', error));
                }
            });
        });

        
        
        
        
        // Ajoutez ce script
        document.querySelectorAll('.candidat-notif-2').forEach(item => {
            item.addEventListener('click', function(e) {
                // Éviter le déclenchement si on clique sur un autre élément cliquable
                if (e.target.closest('.btn-candidat-notif-2')) return;
                
                // Trouver et déclencher le clic sur le bouton caché
                const button = this.querySelector('.btn-candidat-notif-2');
                if (button) {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    
                    // Envoyer la requête AJAX
                    fetch(`/company/notifications/${button.id}/read`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Optionnel: Mettre à jour l'UI si nécessaire
                            // console.log('Notification marquée comme lue');
                        }
                    })
                    .catch(error => console.error('Erreur:', error));
                }
            });
        });

        
        
        
        



        const markAllAsRead = () => {
            fetch(`${window.location.origin}/company/notifications/mark-all-as-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
            })
            .then(response => response.json())
            .then(data => {
                    // Create notification container if it doesn't exist
                    let notificationContainer = document.getElementById('notification-container');
                    if (!notificationContainer) {
                        notificationContainer = document.createElement('div');
                        notificationContainer.id = 'notification-container';
                        notificationContainer.style.cssText = `
                            position: fixed;
                            top: 20px;
                            right: 20px;
                            z-index: 1050;
                            min-width: 300px;
                            max-width: 400px;
                        `;
                        document.body.appendChild(notificationContainer);
                    }

                    // Create notification
                    const notification = document.createElement('div');
                    notification.className = 'custom-alert';
                    notification.innerHTML = `
                        <div class="custom-alert-content">
                            <div class="custom-alert-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>
                                    <path d="M9 12l2 2 4-4"/>
                                </svg>
                            </div>
                            <div class="custom-alert-message">${data.message}</div>
                            <button class="custom-alert-close" onclick="this.parentElement.parentElement.remove()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                    `;

                    // Add styles
                    const style = document.createElement('style');
                    style.textContent = `
                        .custom-alert {
                            background: white;
                            border-left: 4px solid #10B981;
                            border-radius: 6px;
                            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                            margin-bottom: 1rem;
                            opacity: 0;
                            transform: translateX(100%);
                            transition: all 0.5s ease-in-out;
                        }
                        
                        .custom-alert-content {
                            display: flex;
                            align-items: center;
                            padding: 1rem;
                            min-height: 60px;
                        }
                        
                        .custom-alert-icon {
                            flex-shrink: 0;
                            margin-right: 12px;
                            color: #10B981;
                        }
                        
                        .custom-alert-message {
                            color: #1F2937;
                            font-size: 0.875rem;
                            line-height: 1.25rem;
                            flex-grow: 1;
                            margin-right: 12px;
                        }
                        
                        .custom-alert-close {
                            background: transparent;
                            border: none;
                            color: #9CA3AF;
                            cursor: pointer;
                            padding: 4px;
                            flex-shrink: 0;
                            border-radius: 4px;
                            transition: all 0.2s;
                        }
                        
                        .custom-alert-close:hover {
                            background-color: #F3F4F6;
                            color: #4B5563;
                        }

                        .show-notification {
                            opacity: 1;
                            transform: translateX(0);
                        }
                    `;
                    document.head.appendChild(style);

                    // Add to container
                    notificationContainer.appendChild(notification);

                    // Trigger animation
                    setTimeout(() => {
                        notification.classList.add('show-notification');
                    }, 100);

                    // Remove after 5 seconds
                    setTimeout(() => {
                        notification.style.opacity = '0';
                        notification.style.transform = 'translateX(100%)';
                        setTimeout(() => {
                            notification.remove();
                        }, 500);
                    }, 5000);

                    location.reload();
            })
            .catch(error => console.error(error));
            };

        
    </script>
    
  
 </body>
 </html>
 