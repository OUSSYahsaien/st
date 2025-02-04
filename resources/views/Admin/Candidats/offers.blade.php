@extends('layouts.admin')

@section('title', 'Candidat Offers')

@section('page-title', 'Portal de los administradores')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=translate">
    <link rel="stylesheet" href="{{ asset('css/Admin/candidats/myOffers.css') }}">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    
    <div class="infos-btnFilter" style="margin-top: -30px">
        <div class="textsInfo">
            <div class="FtextInfo">Consulta el estado de las solicitudes</div>
            <div class="StextsInfo">Aquí está el estado de las solicitudes de empleo del
                <span id="dateRange">
                    @if(request()->has('start_date') && request()->has('end_date'))
                        {{ \Carbon\Carbon::parse(request('start_date'))->format('d M') }} - 
                        {{ \Carbon\Carbon::parse(request('end_date'))->format('d M') }}
                    @else
                        {{ \Carbon\Carbon::now()->startOfWeek()->format('d M') }} - 
                        {{ \Carbon\Carbon::now()->endOfWeek()->format('d M') }}
                    @endif
                </span>
            </div>
        </div>
        <div class="btnFilter">
            <button id="showDateFilter">
                <span id="buttonDateRange">
                    @if(request()->has('start_date'))
                        {{ \Carbon\Carbon::parse(request('start_date'))->format('M d') }} - 
                        {{ \Carbon\Carbon::parse(request('end_date'))->format('M d') }}
                    @else
                        {{ \Carbon\Carbon::now()->startOfWeek()->format('M d') }} - 
                        {{ \Carbon\Carbon::now()->endOfWeek()->format('M d') }}
                    @endif
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 21" fill="none">
                    <g clip-path="url(#clip0_458_78827)">
                    <path d="M14.9987 4.66602H4.9987C4.07822 4.66602 3.33203 5.41221 3.33203 6.33268V16.3327C3.33203 17.2532 4.07822 17.9993 4.9987 17.9993H14.9987C15.9192 17.9993 16.6654 17.2532 16.6654 16.3327V6.33268C16.6654 5.41221 15.9192 4.66602 14.9987 4.66602Z" stroke="#4640DE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M13.332 3V6.33333" stroke="#4640DE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6.66797 3V6.33333" stroke="#4640DE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M3.33203 9.66602H16.6654" stroke="#4640DE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M8.33464 13H6.66797V14.6667H8.33464V13Z" stroke="#4640DE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_458_78827">
                    <rect width="20" height="20" fill="white" transform="translate(0 0.5)"/>
                    </clipPath>
                    </defs>
                </svg>
            </button>
        </div>
    </div>
    
 



    <!-- Overlay et formulaire de dates -->
    <div id="filterOverlay" class="overlay hidden">
        <div class="overlay-content">
            <h3 class="overlay-title">Seleccionar rango de fechas</h3>
            <form id="filterForm" action="{{ route('administration.candidats.apps', ['id' => $candidat->id]) }}" method="GET">
                <input type="hidden" name="status" value="{{ request('status', 'todo') }}">
                <div class="form-group">
                    <div class="form-item">
                        <label class="label">Fecha de inicio</label>
                        <input type="date" name="start_date" class="input" 
                            value="{{ request('start_date', \Carbon\Carbon::now()->startOfWeek()->format('Y-m-d')) }}">
                    </div>
                    <div class="form-item">
                        <label class="label">Fecha de fin</label>
                        <input type="date" name="end_date" class="input" 
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

    
    
    






    <div class="tabs-container">
        <div class="tabs-list">
            <button data-status="todo" class="tab-item active" data-count="{{$statusCounts['total']}}">Todo</button>
            <button data-status="evaluación" class="tab-item" data-count="{{$statusCounts['evaluacion']}}">Evaluación</button>
            <button data-status="en proceso" class="tab-item" data-count="{{$statusCounts['proceso']}}">En proceso</button>
            <button data-status="entrevista" class="tab-item" data-count="{{$statusCounts['entrevista']}}">Entrevista</button>
            <button data-status="confirmada" class="tab-item" data-count="{{$statusCounts['confirmada']}}">Confirmada</button>
            <button data-status="descartado" class="tab-item" data-count="{{$statusCounts['descartada']}}">Descartado</button>
        </div>

        
    
        <div class="table-header">
            <h2>Historial de las solicitudes</h2>
            <div class="table-actions">
            </div>
        </div>
    
        <div class="applications-table">
            <table id="applicationsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ofertas</th>
                        <th>Fecha de aplicación</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($myApplications as $index => $app)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>
                                @php
                                    $offer = App\Models\Offers::find($app->id_offer);
                                @endphp
                                {{ $offer->title ?? 'Título no disponible' }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($app->created_at)->format('d F Y') }}</td>
                            <td>
                                @php
                                    $statusClass = '';
                                    switch($app->status) {
                                        case 'Evaluacion':
                                            $statusClass = 'status-evaluacion';
                                            break;
                                        case 'Confirmada':
                                            $statusClass = 'status-confirmada';
                                            break;
                                        case 'Entrevista':
                                            $statusClass = 'status-entrevista';
                                            break;
                                        case 'En proceso':
                                            $statusClass = 'status-proceso';
                                            break;
                                        case 'Descartado':
                                            $statusClass = 'status-descartada';
                                            break;
                                        case 'Seleccionado':
                                            $statusClass = 'status-seleccionado';
                                            break;
                                    }
                                @endphp
                                <span class="status-badge {{ $statusClass }}">
                                    {{ $app->status }}
                                </span>
                            </td>
                            <td>
                                <div class="actions-dropdown">
                                    <button class="actions-btn" onclick="toggleDropdown({{ $index }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12C11 12.5523 11.4477 13 12 13Z" stroke="#7C8493" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M19 13C19.5523 13 20 12.5523 20 12C20 11.4477 19.5523 11 19 11C18.4477 11 18 11.4477 18 12C18 12.5523 18.4477 13 19 13Z" stroke="#7C8493" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M5 13C5.55228 13 6 12.5523 6 12C6 11.4477 5.55228 11 5 11C4.44772 11 4 11.4477 4 12C4 12.5523 4.44772 13 5 13Z" stroke="#7C8493" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                    <div id="dropdown-{{ $index }}" class="dropdown-content">
                                        <a href="{{route('administration.companies.offers.view.application', ['id' => $app->id])}}" onclick="" class="dropdown-item">Ver solicitud</a>
                                        <a href="{{route('administration.view.offer', ['id' => $app->id_offer ])}}" class="dropdown-item">Ver Oferta</a>
                                        <a href="{{route('administration.companies.offers.view.applications.pipeline',['id' => $app->id_offer])}}"  class="dropdown-item">Cambiar estado</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($myApplications->hasPages())
                <div class="pagination-container">
                    <ul class="pagination">
                        {{-- Bouton précédent --}}
                        @if ($myApplications->onFirstPage())
                            <li class="disabled">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M15 18l-6-6 6-6"/>
                                    </svg>
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $myApplications->previousPageUrl() }}" rel="prev">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M15 18l-6-6 6-6"/>
                                    </svg>
                                </a>
                            </li>
                        @endif

                        {{-- Numéros de page --}}
                        @foreach ($myApplications->getUrlRange(1, $myApplications->lastPage()) as $page => $url)
                            @if ($page == $myApplications->currentPage())
                                <li class="active"><span>{{ $page }}</span></li>
                            @else
                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        {{-- Bouton suivant --}}
                        @if ($myApplications->hasMorePages())
                            <li>
                                <a href="{{ $myApplications->nextPageUrl() }}" rel="next">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 18l6-6-6-6"/>
                                    </svg>
                                </a>
                            </li>
                        @else
                            <li class="disabled">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 18l6-6-6-6"/>
                                    </svg>
                                </span>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif
        </div>
    </div>



    <div class="mobile-view">

        <div class="mobile-tabs">
            <div class="mobile-tabs-scroll">
                <button data-status="todo" class="mobile-tab {{ !request('status') || request('status') === 'todo' ? 'active' : '' }}">
                    <span class="tab-text">Todo</span>
                    <span class="tab-badge">{{$statusCounts['total']}}</span>
                </button>
                
                <button data-status="evaluación" class="mobile-tab {{ request('status') === 'evaluación' ? 'active' : '' }}">
                    <span class="tab-text">Evaluación</span>
                    <span class="tab-badge">{{$statusCounts['evaluacion']}}</span>
                </button>
                
                <button data-status="en proceso" class="mobile-tab {{ request('status') === 'en proceso' ? 'active' : '' }}">
                    <span class="tab-text">En proceso</span>
                    <span class="tab-badge">{{$statusCounts['proceso']}}</span>
                </button>
                
                <button data-status="entrevista" class="mobile-tab {{ request('status') === 'entrevista' ? 'active' : '' }}">
                    <span class="tab-text">Entrevista</span>
                    <span class="tab-badge">{{$statusCounts['entrevista']}}</span>
                </button>
                
                <button data-status="confirmada" class="mobile-tab {{ request('status') === 'confirmada' ? 'active' : '' }}">
                    <span class="tab-text">Confirmada</span>
                    <span class="tab-badge">{{$statusCounts['confirmada']}}</span>
                </button>
                
                <button data-status="descartado" class="mobile-tab {{ request('status') === 'descartado' ? 'active' : '' }}">
                    <span class="tab-text">Descartado</span>
                    <span class="tab-badge">{{$statusCounts['descartada']}}</span>
                </button>
            </div>
        </div>


        
        
        
        
        
        <div class="applications-grid">
            @foreach ($myApplications as $index => $app)
                <div class="application-card">
                    <div class="card-header">
                        @php
                            $offer = App\Models\Offers::find($app->id_offer);
                        @endphp
                        <h3 class="card-title">{{ $offer->title ?? 'Título no disponible' }}</h3>
                        @php
                            $statusClass = '';
                            switch($app->status) {
                                case 'Evaluacion':
                                    $statusClass = 'status-evaluacion';
                                    break;
                                case 'Confirmada':
                                    $statusClass = 'status-confirmada';
                                    break;
                                case 'Entrevista':
                                    $statusClass = 'status-entrevista';
                                    break;
                                case 'En proceso':
                                    $statusClass = 'status-proceso';
                                    break;
                                case 'Descartado':
                                    $statusClass = 'status-descartada';
                                    break;
                                case 'Seleccionado':
                                        $statusClass = 'status-seleccionado';
                                        break;
                            }
                        @endphp
                        <span class="status-badge {{ $statusClass }}">{{ $app->status }}</span>
                    </div>
                    
                    <div class="card-body">
                        <div class="card-info">
                            <div class="info-item">
                                <span class="info-label">Fecha:</span>
                                <span class="info-value">{{ \Carbon\Carbon::parse($app->created_at)->format('d F Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{route('administration.companies.offers.view.application', ['id' => $app->id])}}">
                            <button class="action-button review-1">Ver solicitud</button>
                        </a>
                        <a href="{{route('administration.view.offer', ['id' => $app->id_offer ])}}">
                            <button class="action-button review-2">
                                Ver Oferta
                            </button>
                        </a>
                        <a href="{{route('administration.companies.offers.view.applications.pipeline',['id' => $app->id_offer])}}">
                            <button class="action-button review-3">
                                Cambiar estado
                            </button>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($myApplications->hasPages())
            <div class="mobile-pagination">
                {{ $myApplications->links('pagination::custom_3') }}
            </div>
        @endif
    </div>





    <script>
        function toggleDropdown(index) {
            const dropdowns = document.querySelectorAll('.dropdown-content');
            dropdowns.forEach((dropdown, i) => {
                if (i !== index) {
                    dropdown.classList.remove('show');
                }
            });
            
            const dropdown = document.getElementById(`dropdown-${index}`);
            dropdown.classList.toggle('show');
        }
        
        // Fermer le dropdown quand on clique ailleurs sur la page
        window.onclick = function(event) {
            if (!event.target.matches('.actions-btn') && !event.target.matches('.actions-btn svg') && !event.target.matches('.actions-btn path')) {
                const dropdowns = document.querySelectorAll('.dropdown-content');
                dropdowns.forEach(dropdown => {
                    if (dropdown.classList.contains('show')) {
                        dropdown.classList.remove('show');
                    }
                });
            }
        }
    </script>








    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-item');
            
            // Gestionnaire de clic pour les onglets
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Ajouter le paramètre de statut à l'URL
                    const status = this.textContent.toLowerCase();
                    const url = new URL(window.location);
                    url.searchParams.set('status', status);
                    url.searchParams.set('page', '1'); // Réinitialiser à la première page
                    window.location = url;
                });
            });
        });
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileTabs = document.querySelectorAll('.mobile-tab');
            
            mobileTabs.forEach(tab => {
                tab.addEventListener('click', function() {

                    
                    const status = this.dataset.status;
                    const url = new URL(window.location);
                    url.searchParams.set('status', status);
                    url.searchParams.set('page', '1'); // Réinitialiser à la première page
                    window.location = url;
                });
            });

            // Scroll automatique vers le tab actif
            const activeTab = document.querySelector('.mobile-tab.active');
            if (activeTab) {
                activeTab.scrollIntoView({
                    behavior: 'smooth',
                    inline: 'center',
                    block: 'nearest'
                });
            }
        });
    </script>





    <script>
        $(document).ready(function() {
            $('#applicationsTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                },
                pageLength: 10,
                order: [[0, 'asc']],
                columnDefs: [
                    {
                        targets: -1,  // La dernière colonne (actions)
                        orderable: false  // Désactive le tri pour la colonne actions
                    }
                ]
            });
        });
    </script>





    <script>
        function confirmDelete(applicationId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Realmente deseas salir de este proceso de selección?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, salir',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/candidat/application/${applicationId}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if(response.success) {
                                Swal.fire(
                                    '¡Eliminado!',
                                    'Has salido exitosamente del proceso.',
                                    'success'
                                ).then(() => {
                                    // Recharger la table
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error',
                                    'Hubo un problema al procesar tu solicitud.',
                                    'error'
                                );
                            }
                        },
                        error: function() {
                            Swal.fire(
                                'Error',
                                'Hubo un problema al procesar tu solicitud.',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>





    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Récupérer le paramètre status de l'URL
            const urlParams = new URLSearchParams(window.location.search);
            const currentStatus = urlParams.get('status') || 'todo';

            // Trouver tous les onglets
            const tabs = document.querySelectorAll('.tab-item');
            
            // Retirer la classe active de tous les onglets
            tabs.forEach(tab => {
                tab.classList.remove('active');
                // Si le data-status correspond au status de l'URL, ajouter la classe active
                if(tab.dataset.status == currentStatus) {
                    tab.classList.add('active');
                }
            });
        })
    </script>





    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('filterOverlay');
            const showButton = document.getElementById('showDateFilter');
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
            formData.append('app_id', appId);

            fetch('/candidat/request-review', {
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
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>

</body>
</html>
@endsection