@extends('layouts.company')

@section('title', 'my offers')

@section('page-title', 'Mis solicitudes')

@section('content')
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Document</title>
        <link rel="stylesheet" href="{{ asset('css/Company/my-offers.css') }}">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    </head>
    <body>
        
        <div class="conta">
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
            <header class="mpage-header">

                <div class="" style=" display: flex; justify-content: space-between;">
                    <div class="">
                        <h1 class="b-d-u">Buenos días, {{Auth::user()->name}}</h1>
                        <p class="subtitle">Aquí puede consultar todas las solicitudes enviadas desde 
                            <span id="dateRange">
                                @if(request()->has('start_date') && request()->has('end_date'))
                                    {{ \Carbon\Carbon::parse(request('start_date'))->format('d M') }} - 
                                    {{ \Carbon\Carbon::parse(request('end_date'))->format('d M') }}
                                @else
                                    {{ \Carbon\Carbon::now()->startOfWeek()->format('d M') }} - 
                                    {{ \Carbon\Carbon::now()->endOfWeek()->format('d M') }}
                                @endif
                            </span>
                        </p>
                    </div>
                    <div style="height: 51px; display: flex; justify-content: center; align-items: center; cursor: pointer;" class="date-picker" id="date-picker">
                        <span>
                            @if(request()->has('start_date'))
                                {{ \Carbon\Carbon::parse(request('start_date'))->format('M d') }} - 
                                {{ \Carbon\Carbon::parse(request('end_date'))->format('M d') }}
                            @else
                                {{ \Carbon\Carbon::now()->startOfWeek()->format('M d') }} - 
                                {{ \Carbon\Carbon::now()->endOfWeek()->format('M d') }}
                            @endif
                        </span>
                    </div>
                </div>
                


                <div class="actions">
                    <div class=""></div>
                    <div class="header-buttons">
                        <a href="{{route('company.my.offers.steep.one')}}">
                            <button class="btn primary">Nueva solicitud</button>
                        </a>

                        {{-- <button class="btn secondary">Filtros</button> --}}
                    </div>
                </div>
            </header>
    


            
            <!-- Overlay et formulaire de dates -->
            <div id="filterOverlay" class="overlay hidden">
                <div class="overlay-content">
                    <h3 class="overlay-title">Seleccionar rango de fechas</h3>
                    <form id="filterForm" action="{{ route('company.my.offers') }}" method="GET">
                        <div class="form-group">
                            <div class="form-item">
                                <label class="label">Fecha de inicio</label>
                                <input type="date" name="start_date" id="start_date" class="input" 
                                    value="{{ request('start_date', \Carbon\Carbon::now()->startOfWeek()->format('Y-m-d')) }}">
                            </div>
                            <div class="form-item">
                                <label class="label">Fecha de fin</label>
                                <input type="date" name="end_date" id="end_date" class="input" 
                                    value="{{ request('end_date', \Carbon\Carbon::now()->endOfWeek()->format('Y-m-d')) }}">
                            </div>
                            <div class="form-actions">
                                <button type="button" id="closeFilter" class="btn btn-cancel">
                                    Cancelar
                                </button>
                                <button type="submit" class="btn btn-apply">
                                    Aplicar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            
            
            
            
            <main class="table-container">
                <table id="myTable">
                    <thead>
                        <div class="search-container">
                            <label for="searchTable">Rechercher:</label>
                            <input type="text" id="searchTable" placeholder="Rechercher dans toutes les colonnes...">
                        </div>
                        <tr>
                            <th>Roles</th>
                            <th>Estado</th>
                            <th>Fecha de envío</th>
                            <th>Fecha de publ.</th>
                            <th>Tipo de empleo</th>
                            <th>Candidatos</th>
                            <th>Puestos cubiertos</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($offers as $offer)
                            @php
                                $offerStatus = DB::table('offer_statuses')
                                                ->where('id_offer', $offer->id)
                                                ->value('status');

                                $applicationsCount = DB::table('applications')
                                                ->where('id_offer', $offer->id)
                                                ->count();
                            @endphp
                            <tr>
                                <td>{{ $offer->title }}</td>
                                <td>
                                    <span class="badge {{ $offerStatus == 'Revision' ? 'Revision' : '' }} {{ $offerStatus == 'Publicada' ? 'Publicada' : '' }} {{ $offerStatus == 'Cerrada' ? 'Cerrada' : '' }}">
                                         {{ $offerStatus ?? 'Sin estado' }} 
                                    </span>
                                </td>
                                <td>{{ $offer->created_at->format('Y-m-d') }}</td>
                                <td>{{ $offer->publication_date ?? 'Sin fecha' }}</td>
                                <td style="height: 69px;" class="work-type-badge-container"><span class="work-type-badge">{{ $offer->work_type }}</span></td>
                                <td> 
                                    <a style="display: flex; justify-content: center; align-items: center; color: #444; font-weight: 600; text-decoration: underline;" href="{{ route('company.my.offers.view.applications', ['id' => $offer->id]) }}">    
                                        {{ $applicationsCount }}</td>
                                    </a>
                                <td>
                                    <div class="positions">
                                        <a style="text-decoration: underline; color: #444;" href="{{ route('company.my.offers.view.applications', ['id' => $offer->id]) }}">
                                            {{ $offer->nbr_candidat_confermed }} <span>/ {{ $offer->nbr_candidat_max }}</span>
                                        </a>
                                    </div>
                                </td>
                                <td class="action-column">
                                    <div class="dropdown-container">
                                        <i class="fa-solid fa-ellipsis dropdown-trigger"></i>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('company.my.offers.view.offer', ['id' => $offer->id]) }}" class="dropdown-item">
                                                Ver solicitud
                                            </a>
                                            <a href="#" onclick="requestReview({{ $offer->id }})" class="dropdown-item">Solicitar actualizacion</a>
                                            <a href="#" 
                                                class="dropdown-item text-danger delete-offer" 
                                                data-offer-id="{{ $offer->id }}">
                                                    Cerrar oferta
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination-controls" style="width: fit-content; margin-top: 20px;">
                    <div class="rows-per-page">
                        <label for="rowsPerPage">Lignes par page:</label>
                        <select id="rowsPerPage" onchange="changeRowsPerPage(this)">
                            <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('perPage') == 20 ? 'selected' : '' }}>20</option>
                            <option value="30" {{ request('perPage') == 30 ? 'selected' : '' }}>30</option>
                        </select>
                    </div>
                </div>
                


                <!-- Pagination -->
                <div class="pagination" style="margin-top: -20px;">
                    {{ $offers->links('vendor.pagination.default') }}
                </div>
                
            </main>
            

            <!-- Affichage en cartes pour les petits écrans -->
            <div class="card-container">
                @foreach ($offersForMobile as $offer)
                    @php
                        $offerStatus = DB::table('offer_statuses')
                            ->where('id_offer', $offer->id)
                            ->value('status');
                    @endphp
                    <div class="card">
                        <!-- Titre positionné en haut à gauche -->
                        <p class="mob-status">
                            <span class="badge {{ $offerStatus == 'Revision' ? 'Revision' : '' }} {{ $offerStatus == 'Publicada' ? 'Publicada' : '' }} {{ $offerStatus == 'Cerrada' ? 'Cerrada' : '' }}">
                                {{ $offerStatus ?? 'Sin estado' }} 
                            </span>
                        </p>
                        
                        <h4>{{ $offer->title }}</h4>
            
                        <p class="p-candidatures" style="text-align: left; margin-top: 42px; margin-bottom: 42px">
                            <strong>Candidatos:</strong> 
                            <a style="text-decoration: underline; color: #0058D2;" href="{{ route('company.my.offers.view.applications', ['id' => $offer->id]) }}">
                                {{$offer->nbr_candidat_confermed}}/{{$offer->nbr_candidat_max}}
                            </a>
                        </p>
            
                        <!-- Positionner le work-type-badge en haut à droite -->
                        <span class="work-type-badge-2">{{ $offer->work_type }}</span>
            
                        <!-- Date "Fecha de Envío" en bas à droite -->
                        <p class="fecha-envio"><strong>Fecha de Envío:</strong> {{ $offer->created_at->format('Y-m-d') }}</p>
            
                        <!-- Date "Fecha de Publicación" en bas à gauche -->
                        <p class="fecha-publicacion"><strong>Fecha de Publicación:</strong> {{$offer->publication_date ?? 'Sin fecha'}}</p>
            
                        <button class="view-details">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                    </div>
                    <div style="height: 10px"></div>

                    <template id="contextMenu">
                        <div class="context-menu">
                            <button class="menu-item view">
                                <a href="{{ route('company.my.offers.view.offer', ['id' => $offer->id]) }}" class="dropdown-item">
                                    Ver solicitud
                                </a>
                            </button>
                            <button onclick="requestReview({{ $offer->id }})" class="menu-item update">Solicitar actualizacion</button>
                            <a href="#" 
                                class="dropdown-item text-danger delete-offer" 
                                data-offer-id="{{ $offer->id }}">
                                <button class="menu-item close">Cerrar oferta</button>
                            </a>
                        </div>
                    </template>       
    
                    
                @endforeach
            </div>

                 
            
        </div>
        
        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script>
            function changeRowsPerPage(select) {
                const url = new URL(window.location.href);
                url.searchParams.set('perPage', select.value);
                window.location.href = url.toString();
            }
            // function changeRowsPerPage(select) {
            //     const url = new URL(window.location.href);
            //     const startDate = document.getElementById('start_date').value || '';
            //     const endDate = document.getElementById('end_date').value || '';
                
            //     // Maintenir le perPage
            //     url.searchParams.set('perPage', select.value);
                
            //     // Ajouter ou mettre à jour les dates
            //     url.searchParams.set('start_date', startDate);
            //     url.searchParams.set('end_date', endDate);
                
            //     window.location.href = url.toString();
            // }
        </script>


        <script>
            $(document).ready(function () {
                const table = $('#myTable').DataTable({
                    // Configurer les options de DataTables
                    paging: true,
                    searching: true,
                    autoWidth: false,
                    language: {
                        search: "Rechercher:",
                        lengthMenu: "Afficher _MENU_ enregistrements par page",
                        info: "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                        paginate: {
                            next: "Suivant",
                            previous: "Précédent"
                        }
                    },
                });

                // Appliquer la recherche dynamique
                $('#searchTable').on('keyup', function () {
                    table.search(this.value).draw();
                });
            });
        </script>

        

        <script>
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1000) {
                    document.querySelector('.table-container').style.display = 'block';
                    document.querySelector('.card-container').style.display = 'none';
                } else {
                    document.querySelector('.table-container').style.display = 'none';
                    document.querySelector('.card-container').style.display = 'block';
                }
            });

            // Initial check on page load
            if (window.innerWidth >= 1000) {
                document.querySelector('.table-container').style.display = 'block';
                document.querySelector('.card-container').style.display = 'none';
            } else {
                document.querySelector('.table-container').style.display = 'none';
                document.querySelector('.card-container').style.display = 'block';


            }
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
                document.addEventListener('DOMContentLoaded', function() {
                    // Gestionnaire pour les clics sur les déclencheurs de dropdown
                    document.querySelectorAll('.dropdown-trigger').forEach(trigger => {
                        trigger.addEventListener('click', function(e) {
                            e.stopPropagation();
                            // Ferme tous les autres dropdowns
                            document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                                if (menu !== this.nextElementSibling) {
                                    menu.classList.remove('show');
                                }
                            });
                            // Bascule l'état du dropdown actuel
                            const dropdownMenu = this.closest('.dropdown-container').querySelector('.dropdown-menu');
                            dropdownMenu.classList.toggle('show');
                        });
                    });
                
                    // Ferme tous les dropdowns lors d'un clic à l'extérieur
                    document.addEventListener('click', function(e) {
                        if (!e.target.closest('.dropdown-container')) {
                            document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                                menu.classList.remove('show');
                            });
                        }
                    });
                });
            </script>


            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.querySelectorAll('.view-details').forEach((button, index) => {
                        // Clone the template for each card
                        const template = document.querySelectorAll('#contextMenu')[index];
                        const menu = template.content.cloneNode(true).querySelector('.context-menu');
                        button.parentElement.appendChild(menu);
                        
                        button.addEventListener('click', function(e) {
                            e.stopPropagation();
                            
                            // Close all other open menus
                            document.querySelectorAll('.context-menu.active').forEach(m => {
                                if (m !== menu) m.classList.remove('active');
                            });
                            
                            // Toggle the current menu
                            menu.classList.toggle('active');
                            
                            // Position the menu
                            menu.style.top = '40px';
                            menu.style.right = '0';
                        });
                    });
                    
                    // Close menu if clicked outside
                    document.addEventListener('click', function(e) {
                        if (!e.target.closest('.context-menu') && !e.target.closest('.view-details')) {
                            document.querySelectorAll('.context-menu.active').forEach(menu => {
                                menu.classList.remove('active');
                            });
                        }
                    });
                });
            </script>


            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const deleteButtons = document.querySelectorAll('.delete-offer');
                    
                    deleteButtons.forEach(button => {
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            const offerId = this.dataset.offerId;
                            
                            Swal.fire({
                                title: '¿Estás seguro?',
                                text: "¿Deseas eliminar esta oferta?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Sí, eliminar',
                                cancelButtonText: 'Cancelar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Envoi de la requête de suppression
                                    fetch(`/company/offers/${offerId}`, {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                            'Accept': 'application/json'
                                        }
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            Swal.fire(
                                                '¡Eliminado!',
                                                'La oferta ha sido eliminada.',
                                                'success'
                                            ).then(() => {
                                                // Recharger la page ou supprimer la ligne du tableau
                                                location.reload();
                                            });
                                        } else {
                                            Swal.fire(
                                                'Error',
                                                'Hubo un problema al eliminar la oferta.',
                                                'error'
                                            );
                                        }
                                    })
                                    .catch(error => {
                                        Swal.fire(
                                            'Error',
                                            'Hubo un problema al eliminar la oferta.',
                                            'error'
                                        );
                                    });
                                }
                            });
                        });
                    });
                });
            </script>
            
            
            
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const overlay = document.getElementById('filterOverlay');
                    const showButton = document.getElementById('date-picker');
                    const closeButton = document.getElementById('closeFilter');
                
                    showButton.addEventListener('click', function() {
                        overlay.classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                    });
                
                    closeButton.addEventListener('click', function() {
                        overlay.classList.add('hidden');
                        document.body.style.overflow = '';
                    });
                
                    // Fermer l'overlay en cliquant en dehors du formulaire
                    overlay.addEventListener('click', function(e) {
                        if (e.target === overlay) {
                            overlay.classList.add('hidden');
                            document.body.style.overflow = '';
                        }
                    });
                });
            </script>

            
            
            
            <script>
                // resources/js/app.js
                function requestReview(appId) {
                    const formData = new FormData();
                    formData.append('offer_id', appId);

                    fetch('/company/request-review', {
                        method: 'POST',
                        body: formData,
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
                        notification.className = 'custom-alert-2';
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
                            .custom-alert-2 {
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
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            </script>


    </body>
    </html>
@endsection