@extends('layouts.company')

@section('title', 'Dashboard Company')

@section('page-title', 'Dashboard')

@section('content')
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ asset('css/Company/dashboard.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    </head>
    <body>

        
        <div class="head-dash">
            <div class="title-subTitle">
                <div class="dash-title">Buenos días, {{Auth::user()->name}}</div>
                <div class="dash-subTitle">Aquí puede consultar todas las solicitudes enviadas desde 

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
            <div class="dash-filter-btn" id="showDateFilter">
                <div class="text-from-to">
                    <span id="buttonDateRange">
                        @if(request()->has('start_date'))
                            {{ \Carbon\Carbon::parse(request('start_date'))->format('M d') }} - 
                            {{ \Carbon\Carbon::parse(request('end_date'))->format('M d') }}
                        @else
                            {{ \Carbon\Carbon::now()->startOfWeek()->format('M d') }} - 
                            {{ \Carbon\Carbon::now()->endOfWeek()->format('M d') }}
                        @endif
                    </span>
                </div>
                <div class="img-filter">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                        <g clip-path="url(#clip0_458_78827)">
                        <path d="M14.9987 4.66602H4.9987C4.07822 4.66602 3.33203 5.41221 3.33203 6.33268V16.3327C3.33203 17.2532 4.07822 17.9993 4.9987 17.9993H14.9987C15.9192 17.9993 16.6654 17.2532 16.6654 16.3327V6.33268C16.6654 5.41221 15.9192 4.66602 14.9987 4.66602Z" stroke="#4640DE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M13.332 3V6.33333" stroke="#4640DE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M6.66797 3V6.33333" stroke="#4640DE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M3.33203 9.66602H16.6654" stroke="#4640DE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M8.33464 13H6.66797V14.6667H8.33464V13Z" stroke="#4640DE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                        <defs>
                        <clipPath id="clip0_458_78827">
                        <rect width="20" height="20" fill="white" transform="translate(0 0.5)"></rect>
                        </clipPath>
                        </defs>
                    </svg>
                </div>
            </div>
        </div>

        
        <div id="filterOverlay" class="overlay hidden">
            <div class="overlay-content">
                <h3 class="overlay-title">Seleccionar rango de fechas</h3>
                <form id="filterForm" action="{{ route('company.dashboard') }}" method="GET">
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

        
        <div class="cont">    
            <div class="stats-cards">
                <div class="stat-card purple">
                        <div class="stat-number">{{$candidatInterviewedCount}}</div>
                        <div class="stat-label">Nuevos candidatos<br>para examinar</div>
                </div>
                <div onclick="window.location.href='{{ route('company.my.offers')}}'" class="stat-card green">
                    <div class="stat-number">{{$publicOffers}}</div>
                    <div class="stat-label">Solicitudes en revisión</div>
                </div>
                <div onclick="window.location.href='{{ route('company.my.offers')}}'" class="stat-card blue">
                    <div class="stat-number">{{$reviewOffers}}</div>
                    <div class="stat-label">Solicitudes publicadas</div>
                </div>
            </div>
    
            <div class="dashboard-content">
                <div class="chart-section">
                    <div class="section-header">
                        <div>
                            <h2>Estadísticas de empleo</h2>
                            <div class="">
                                <span style="color: #7C8493;">Mostrando estadísticas de empleo </span>
                                <span class="text-muted" style="color: #7C8493;" id="dateRange">
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
                        {{-- <div class="buttons-filter-container">
                            <button class="{{request('period') == "week" ? 'active' : ''}}">Semana</button>
                            <button class="{{request('period') == "month" ? 'active' : ''}}">Mes</button>
                            <button class="{{request('period') == "year" ? 'active' : ''}}">Año</button>
                        </div> --}}
                        
                    </div>
                    <div class="chart-body">
                        <div class="first-division">
                            <div style="width: 100%; height: 500px;">
                                <canvas id="statsChart" style="width: 100%; height: 500px;"></canvas>
                            </div>
                        </div>
                        <div class="second-division">
                            <div class="stat-widget">
                                <div class="stat-header">
                                    <span class="stat-title">Solicitudes enviadas</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="33" viewBox="0 0 32 33" fill="none">
                                        <rect y="0.320312" width="32" height="32" rx="16" fill="#FFB836"/>
                                        <path d="M24.267 15.9876C22.5836 12.0793 19.417 9.6543 16.0003 9.6543C12.5836 9.6543 9.41697 12.0793 7.73363 15.9876C7.68775 16.0928 7.66406 16.2062 7.66406 16.321C7.66406 16.4357 7.68775 16.5492 7.73363 16.6543C9.41697 20.5626 12.5836 22.9876 16.0003 22.9876C19.417 22.9876 22.5836 20.5626 24.267 16.6543C24.3129 16.5492 24.3365 16.4357 24.3365 16.321C24.3365 16.2062 24.3129 16.0928 24.267 15.9876ZM16.0003 21.321C13.3503 21.321 10.8586 19.4126 9.41697 16.321C10.8586 13.2293 13.3503 11.321 16.0003 11.321C18.6503 11.321 21.142 13.2293 22.5836 16.321C21.142 19.4126 18.6503 21.321 16.0003 21.321ZM16.0003 12.9876C15.341 12.9876 14.6966 13.1831 14.1484 13.5494C13.6002 13.9157 13.173 14.4363 12.9207 15.0454C12.6684 15.6544 12.6024 16.3247 12.731 16.9713C12.8596 17.6179 13.1771 18.2118 13.6433 18.678C14.1095 19.1442 14.7034 19.4616 15.35 19.5902C15.9966 19.7189 16.6668 19.6529 17.2759 19.4006C17.885 19.1483 18.4056 18.721 18.7719 18.1729C19.1381 17.6247 19.3336 16.9802 19.3336 16.321C19.3336 15.4369 18.9824 14.5891 18.3573 13.9639C17.7322 13.3388 16.8844 12.9876 16.0003 12.9876ZM16.0003 17.9876C15.6707 17.9876 15.3484 17.8899 15.0743 17.7067C14.8003 17.5236 14.5866 17.2633 14.4605 16.9588C14.3344 16.6542 14.3013 16.3191 14.3657 15.9958C14.43 15.6725 14.5887 15.3755 14.8218 15.1425C15.0549 14.9094 15.3518 14.7506 15.6751 14.6863C15.9985 14.622 16.3336 14.655 16.6381 14.7812C16.9426 14.9073 17.2029 15.1209 17.3861 15.395C17.5692 15.6691 17.667 15.9913 17.667 16.321C17.667 16.763 17.4914 17.1869 17.1788 17.4995C16.8663 17.812 16.4423 17.9876 16.0003 17.9876Z" fill="white"/>
                                    </svg>
                                </div>
                                <div class="stat-value">{{$offersSendedCount ?? ''}}</div>
                                {{-- <div class="stat-change positive">
                                    Esta semana <span>6.4%</span>
                                    <i class="fas fa-arrow-up"></i>
                                </div> --}}
                            </div>
                    
                            <!-- Widget Candidatos confirmados -->
                            <div class="stat-widget">
                                <div class="stat-header">
                                    <span class="stat-title">Candidatos recibidos</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="33" viewBox="0 0 32 33" fill="none">
                                        <rect y="0.320312" width="32" height="32" rx="16" fill="#0D72FF"/>
                                        <g clip-path="url(#clip0_407_57187)">
                                        <path d="M13.5013 10.4863H11.8346C11.3926 10.4863 10.9687 10.6619 10.6561 10.9745C10.3436 11.287 10.168 11.711 10.168 12.153V22.153C10.168 22.595 10.3436 23.0189 10.6561 23.3315C10.9687 23.6441 11.3926 23.8197 11.8346 23.8197H20.168C20.61 23.8197 21.0339 23.6441 21.3465 23.3315C21.659 23.0189 21.8346 22.595 21.8346 22.153V12.153C21.8346 11.711 21.659 11.287 21.3465 10.9745C21.0339 10.6619 20.61 10.4863 20.168 10.4863H18.5013" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16.8333 8.82031H15.1667C14.2462 8.82031 13.5 9.5665 13.5 10.487C13.5 11.4075 14.2462 12.1536 15.1667 12.1536H16.8333C17.7538 12.1536 18.5 11.4075 18.5 10.487C18.5 9.5665 17.7538 8.82031 16.8333 8.82031Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M13.5 16.3203H13.5083" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16.832 16.3203H18.4987" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M13.5 19.6543H13.5083" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16.832 19.6543H18.4987" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_407_57187">
                                        <rect width="20" height="20" fill="white" transform="translate(6 6.32031)"/>
                                        </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                                <div class="stat-value">{{$apps ?? ''}}</div>
                                {{-- <div class="stat-change negative">
                                    Esta semana <span>0.5%</span>
                                    <i class="fas fa-arrow-down"></i>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="applications-section">
                    <h2>Últimas solicitudes enviadas</h2>
                    <span style="color: #7C8493;">Mostrando las 4 ultimas solicitudes enviadas </span>
                    <div class="applications-list">
                        @foreach($recentApplications as $application)
                            <div class="application-item">
                                <div class="application-info">
                                    <h3>{{$application->title}}</h3>
                                    <p>{{Auth::user()->name}} • {{$application->place}} • {{$application->work_type}}</p>
                                </div>
                                <div class="dropdown-container">
                                    <button class="more-btn" onclick="toggleDropdown({{$application->id}})">•••</button>
                                    <div id="dropdown-{{$application->id}}" class="dropdown-menu">
                                        <a href="{{ route('company.my.offers.view.offer', ['id' => $application->id_offer]) }}" class="dropdown-item">
                                            Ver solicitud
                                        </a>
                                        <a href="#" onclick="requestReview({{ $application->id_offer }})" class="dropdown-item">Solicitar actualizacion</a>
                                        <a href="#" 
                                                class="dropdown-item text-danger delete-offer" 
                                                data-offer-id="{{ $application->id_offer }}">
                                                    Cerrar oferta
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>


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
            function toggleDropdown(id) {
                // Ferme tous les autres dropdowns
                document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                    if(menu.id !== `dropdown-${id}`) {
                        menu.classList.remove('show');
                    }
                });
                
                // Toggle le dropdown actuel
                const dropdown = document.getElementById(`dropdown-${id}`);
                dropdown.classList.toggle('show');
                
                // Ferme le dropdown si on clique ailleurs sur la page
                window.onclick = function(event) {
                    if (!event.target.matches('.more-btn')) {
                        const dropdowns = document.getElementsByClassName('dropdown-menu');
                        for (let i = 0; i < dropdowns.length; i++) {
                            const openDropdown = dropdowns[i];
                            if (openDropdown.classList.contains('show')) {
                                openDropdown.classList.remove('show');
                            }
                        }
                    }
                }
            }
        </script>
        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
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




    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('statsChart').getContext('2d');
            
            // Récupérer les données PHP et les convertir en format pour Chart.js
            const data = {
                labels: [
                    @foreach($candidateStats as $date => $count)
                        '{{ Carbon\Carbon::parse($date)->format('D') }}',
                    @endforeach
                ],
                datasets: [
                    {
                        label: 'Candidatos confirmados',
                        data: [
                            @foreach($candidateStats as $count)
                                {{ $count }},
                            @endforeach
                        ],
                        backgroundColor: '#4F94FF',
                        borderWidth: 0
                    },
                    {
                        label: 'Nuevos candidatos',
                        data: [
                            @foreach($confirmedAppsStats as $count)
                                {{ $count }},
                            @endforeach
                        ],
                        backgroundColor: '#2563EB',
                        borderWidth: 0
                    }
                ]
            };
        
            new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true,
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            grid: {
                                color: '#E5E7EB'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'start',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'rect',
                                padding: 20
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1F2937',
                            padding: 12,
                            usePointStyle: true,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.raw;
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });
        });
        </script> --}}

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const initStatsChart = (data, period = 'week') => {
                const ctx = document.getElementById('statsChart').getContext('2d');
                
                // Fonction pour obtenir les dates de la semaine
                const getDatesInRange = (startDate, endDate) => {
                    const dates = [];
                    let currentDate = new Date(startDate);
                    const lastDate = new Date(endDate);
                    
                    while (currentDate <= lastDate) {
                        dates.push(new Date(currentDate));
                        currentDate.setDate(currentDate.getDate() + 1);
                    }
                    
                    return dates;
                };

                // Fonction pour formater la date selon la période
                const formatLabel = (date) => {
                    const days = ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom'];
                    const dayOfWeek = date.getDay();
                    return days[dayOfWeek === 0 ? 6 : dayOfWeek - 1];
                };

                // Créer les données pour le graphique
                const dates = getDatesInRange(startDate, endDate);
                
                const chartData = {
                    labels: dates.map(date => formatLabel(date)),
                    datasets: [
                        {
                            label: 'Candidatos recibidos',
                            data: dates.map(date => {
                                // Filtrer les applications pour cette date
                                return appsCount.filter(app => 
                                    new Date(app.created_at).toDateString() === date.toDateString()
                                ).length;
                            }),
                            backgroundColor: 'rgb(54, 162, 235)',
                            order: 2
                        },
                        {
                            label: 'Solicitudes enviadas',
                            data: dates.map(date => {
                                // Filtrer les offres pour cette date
                                return offersSended.filter(offer => 
                                    new Date(offer.created_at).toDateString() === date.toDateString()
                                ).length;
                            }),
                            backgroundColor: 'rgb(54, 162, 235, 0.5)',
                            order: 1
                        }
                    ]
                };

                const config = {
                    type: 'bar',
                    data: chartData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                stacked: true,
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                stacked: true,
                                beginAtZero: true,
                                grid: {
                                    drawBorder: false
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                };

                // Création du graphique
                const myChart = new Chart(ctx, config);

                // Ajout du scrolling horizontal si nécessaire
                const chartContainer = document.querySelector('#statsChart').parentElement;
                if (period === 'week' && dates.length > 7) {
                    chartContainer.style.overflowX = 'auto';
                    chartContainer.style.overflowY = 'hidden';
                    document.getElementById('statsChart').style.minWidth = `${dates.length * 100}px`;
                }

                return myChart;
            };
        </script>
        

        
        <script>
            // Convertir les données PHP en JSON pour JavaScript
            const offersSended = @json($offersSended);
            const appsCount = @json($appsCount);
            const startDate = @json($startDate);
            const endDate = @json($endDate);
            const period = @json($period);

            // Initialiser le graphique
            document.addEventListener('DOMContentLoaded', function() {
                initStatsChart(offersSended, appsCount, startDate, endDate, period);
            });
        </script>
        
    </body>
    </html>
@endsection













































































{{-- 

@extends('layouts.company')

@section('title', 'Dashboard Company')

@section('page-title', 'Dashboard')

@section('content')
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ asset('css/Company/dashboard.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    </head>
    <body>

        
        <div class="head-dash">
            <div class="title-subTitle">
                <div class="dash-title">Buenos días, {{Auth::user()->name}}</div>
                <div class="dash-subTitle">Aquí puede consultar todas las solicitudes enviadas desde 

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
            <div class="dash-filter-btn" id="showDateFilter">
                <div class="text-from-to">
                    <span id="buttonDateRange">
                        @if(request()->has('start_date'))
                            {{ \Carbon\Carbon::parse(request('start_date'))->format('M d') }} - 
                            {{ \Carbon\Carbon::parse(request('end_date'))->format('M d') }}
                        @else
                            {{ \Carbon\Carbon::now()->startOfWeek()->format('M d') }} - 
                            {{ \Carbon\Carbon::now()->endOfWeek()->format('M d') }}
                        @endif
                    </span>
                </div>
                <div class="img-filter">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                        <g clip-path="url(#clip0_458_78827)">
                        <path d="M14.9987 4.66602H4.9987C4.07822 4.66602 3.33203 5.41221 3.33203 6.33268V16.3327C3.33203 17.2532 4.07822 17.9993 4.9987 17.9993H14.9987C15.9192 17.9993 16.6654 17.2532 16.6654 16.3327V6.33268C16.6654 5.41221 15.9192 4.66602 14.9987 4.66602Z" stroke="#4640DE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M13.332 3V6.33333" stroke="#4640DE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M6.66797 3V6.33333" stroke="#4640DE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M3.33203 9.66602H16.6654" stroke="#4640DE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M8.33464 13H6.66797V14.6667H8.33464V13Z" stroke="#4640DE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                        <defs>
                        <clipPath id="clip0_458_78827">
                        <rect width="20" height="20" fill="white" transform="translate(0 0.5)"></rect>
                        </clipPath>
                        </defs>
                    </svg>
                </div>
            </div>
        </div>

        
        <div id="filterOverlay" class="overlay hidden">
            <div class="overlay-content">
                <h3 class="overlay-title">Seleccionar rango de fechas</h3>
                <form id="filterForm" action="{{ route('company.dashboard') }}" method="GET">
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

        
        <div class="cont">    
            <div class="stats-cards">
                <div class="stat-card purple">
                        <div class="stat-number">{{$candidatInterviewedCount}}</div>
                        <div class="stat-label">Nuevos candidatos<br>para examinar</div>
                </div>
                <div onclick="window.location.href='{{ route('company.my.offers')}}'" class="stat-card green">
                    <div class="stat-number">{{$publicOffers}}</div>
                    <div class="stat-label">Solicitudes en revisión</div>
                </div>
                <div onclick="window.location.href='{{ route('company.my.offers')}}'" class="stat-card blue">
                    <div class="stat-number">{{$reviewOffers}}</div>
                    <div class="stat-label">Solicitudes publicadas</div>
                </div>
            </div>
    
            <div class="dashboard-content">
                <div class="chart-section">
                    <div class="section-header">
                        <div>
                            <h2>Estadísticas de empleo</h2>
                            <div class="">
                                <span style="color: #7C8493;">Mostrando estadísticas de empleo </span>
                                <span class="text-muted" style="color: #7C8493;" id="dateRange">
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
                        <div class="buttons-filter-container">
                            <button class="{{request('period') == "week" ? 'active' : ''}}">Semana</button>
                            <button class="{{request('period') == "month" ? 'active' : ''}}">Mes</button>
                            <button class="{{request('period') == "year" ? 'active' : ''}}">Año</button>
                        </div>
                        
                    </div>
                    <div class="chart-body">
                        <div class="first-division">
                            <div class="chart-container">
                                <canvas id="statsChart"></canvas>
                            </div>
                        </div>
                        <div class="second-division">
                            <div class="stat-widget">
                                <div class="stat-header">
                                    <span class="stat-title">Solicitudes enviadas</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="33" viewBox="0 0 32 33" fill="none">
                                        <rect y="0.320312" width="32" height="32" rx="16" fill="#FFB836"/>
                                        <path d="M24.267 15.9876C22.5836 12.0793 19.417 9.6543 16.0003 9.6543C12.5836 9.6543 9.41697 12.0793 7.73363 15.9876C7.68775 16.0928 7.66406 16.2062 7.66406 16.321C7.66406 16.4357 7.68775 16.5492 7.73363 16.6543C9.41697 20.5626 12.5836 22.9876 16.0003 22.9876C19.417 22.9876 22.5836 20.5626 24.267 16.6543C24.3129 16.5492 24.3365 16.4357 24.3365 16.321C24.3365 16.2062 24.3129 16.0928 24.267 15.9876ZM16.0003 21.321C13.3503 21.321 10.8586 19.4126 9.41697 16.321C10.8586 13.2293 13.3503 11.321 16.0003 11.321C18.6503 11.321 21.142 13.2293 22.5836 16.321C21.142 19.4126 18.6503 21.321 16.0003 21.321ZM16.0003 12.9876C15.341 12.9876 14.6966 13.1831 14.1484 13.5494C13.6002 13.9157 13.173 14.4363 12.9207 15.0454C12.6684 15.6544 12.6024 16.3247 12.731 16.9713C12.8596 17.6179 13.1771 18.2118 13.6433 18.678C14.1095 19.1442 14.7034 19.4616 15.35 19.5902C15.9966 19.7189 16.6668 19.6529 17.2759 19.4006C17.885 19.1483 18.4056 18.721 18.7719 18.1729C19.1381 17.6247 19.3336 16.9802 19.3336 16.321C19.3336 15.4369 18.9824 14.5891 18.3573 13.9639C17.7322 13.3388 16.8844 12.9876 16.0003 12.9876ZM16.0003 17.9876C15.6707 17.9876 15.3484 17.8899 15.0743 17.7067C14.8003 17.5236 14.5866 17.2633 14.4605 16.9588C14.3344 16.6542 14.3013 16.3191 14.3657 15.9958C14.43 15.6725 14.5887 15.3755 14.8218 15.1425C15.0549 14.9094 15.3518 14.7506 15.6751 14.6863C15.9985 14.622 16.3336 14.655 16.6381 14.7812C16.9426 14.9073 17.2029 15.1209 17.3861 15.395C17.5692 15.6691 17.667 15.9913 17.667 16.321C17.667 16.763 17.4914 17.1869 17.1788 17.4995C16.8663 17.812 16.4423 17.9876 16.0003 17.9876Z" fill="white"/>
                                    </svg>
                                </div>
                                <div class="stat-value">{{$offersSendedCount ?? ''}}</div>
                                <div class="stat-change positive">
                                    Esta semana <span>6.4%</span>
                                    <i class="fas fa-arrow-up"></i>
                                </div>
                            </div>
                    
                            <!-- Widget Candidatos confirmados -->
                            <div class="stat-widget">
                                <div class="stat-header">
                                    <span class="stat-title">Candidatos recibidos</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="33" viewBox="0 0 32 33" fill="none">
                                        <rect y="0.320312" width="32" height="32" rx="16" fill="#0D72FF"/>
                                        <g clip-path="url(#clip0_407_57187)">
                                        <path d="M13.5013 10.4863H11.8346C11.3926 10.4863 10.9687 10.6619 10.6561 10.9745C10.3436 11.287 10.168 11.711 10.168 12.153V22.153C10.168 22.595 10.3436 23.0189 10.6561 23.3315C10.9687 23.6441 11.3926 23.8197 11.8346 23.8197H20.168C20.61 23.8197 21.0339 23.6441 21.3465 23.3315C21.659 23.0189 21.8346 22.595 21.8346 22.153V12.153C21.8346 11.711 21.659 11.287 21.3465 10.9745C21.0339 10.6619 20.61 10.4863 20.168 10.4863H18.5013" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16.8333 8.82031H15.1667C14.2462 8.82031 13.5 9.5665 13.5 10.487C13.5 11.4075 14.2462 12.1536 15.1667 12.1536H16.8333C17.7538 12.1536 18.5 11.4075 18.5 10.487C18.5 9.5665 17.7538 8.82031 16.8333 8.82031Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M13.5 16.3203H13.5083" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16.832 16.3203H18.4987" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M13.5 19.6543H13.5083" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M16.832 19.6543H18.4987" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_407_57187">
                                        <rect width="20" height="20" fill="white" transform="translate(6 6.32031)"/>
                                        </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                                <div class="stat-value">{{$apps ?? ''}}</div>
                                <div class="stat-change negative">
                                    Esta semana <span>0.5%</span>
                                    <i class="fas fa-arrow-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="applications-section">
                    <h2>Últimas solicitudes enviadas</h2>
                    <span style="color: #7C8493;">Mostrando las 4 ultimas solicitudes enviadas </span>
                    <div class="applications-list">
                        @foreach($recentApplications as $application)
                            <div class="application-item">
                                <div class="application-info">
                                    <h3>{{$application->title}}</h3>
                                    <p>{{Auth::user()->name}} • {{$application->place}} • {{$application->work_type}}</p>
                                </div>
                                <div class="dropdown-container">
                                    <button class="more-btn" onclick="toggleDropdown({{$application->id}})">•••</button>
                                    <div id="dropdown-{{$application->id}}" class="dropdown-menu">
                                        <a href="{{ route('company.my.offers.view.offer', ['id' => $application->id_offer]) }}" class="dropdown-item">
                                            Ver solicitud
                                        </a>
                                        <a href="#" onclick="requestReview({{ $application->id_offer }})" class="dropdown-item">Solicitar actualizacion</a>
                                        <a href="#" 
                                                class="dropdown-item text-danger delete-offer" 
                                                data-offer-id="{{ $application->id_offer }}">
                                                    Cerrar oferta
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>


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
            function toggleDropdown(id) {
                // Ferme tous les autres dropdowns
                document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                    if(menu.id !== `dropdown-${id}`) {
                        menu.classList.remove('show');
                    }
                });
                
                // Toggle le dropdown actuel
                const dropdown = document.getElementById(`dropdown-${id}`);
                dropdown.classList.toggle('show');
                
                // Ferme le dropdown si on clique ailleurs sur la page
                window.onclick = function(event) {
                    if (!event.target.matches('.more-btn')) {
                        const dropdowns = document.getElementsByClassName('dropdown-menu');
                        for (let i = 0; i < dropdowns.length; i++) {
                            const openDropdown = dropdowns[i];
                            if (openDropdown.classList.contains('show')) {
                                openDropdown.classList.remove('show');
                            }
                        }
                    }
                }
            }
        </script>
        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
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
        

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const initStatsChart = (offersSended, appsCount, startDate, endDate, period = 'week') => {
                const ctx = document.getElementById('statsChart').getContext('2d');
                
                // Fonction pour obtenir toutes les dates entre deux dates
                const getDatesInRange = (start, end) => {
                    const dates = [];
                    let curr = new Date(start);
                    const last = new Date(end);
                    
                    while (curr <= last) {
                        dates.push(new Date(curr));
                        curr.setDate(curr.getDate() + 1);
                    }
                    
                    return dates;
                };

                // Fonction pour obtenir le numéro de la semaine
                const getWeekNumber = (date) => {
                    const firstDayOfYear = new Date(date.getFullYear(), 0, 1);
                    const pastDaysOfYear = (date - firstDayOfYear) / 86400000;
                    return Math.ceil((pastDaysOfYear + firstDayOfYear.getDay() + 1) / 7);
                };

                // Fonction pour grouper les données selon la période
                const groupDataByPeriod = (data, dates, period) => {
                    const groupedData = {};
                    
                    dates.forEach(date => {
                        let key;
                        switch(period) {
                            case 'week':
                                key = date.toISOString().split('T')[0];
                                break;
                            case 'month':
                                key = `Semana ${getWeekNumber(date)}`;
                                break;
                            case 'year':
                                const months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                                            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                                key = months[date.getMonth()];
                                break;
                        }
                        
                        if (!groupedData[key]) {
                            groupedData[key] = {
                                offers: 0,
                                apps: 0
                            };
                        }
                    });

                    // Compter les offres
                    data.offers.forEach(offer => {
                        const offerDate = new Date(offer.created_at);
                        let key;
                        
                        switch(period) {
                            case 'week':
                                key = offerDate.toISOString().split('T')[0];
                                break;
                            case 'month':
                                key = `Semana ${getWeekNumber(offerDate)}`;
                                break;
                            case 'year':
                                const months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                                            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                                key = months[offerDate.getMonth()];
                                break;
                        }
                        
                        if (groupedData[key]) {
                            groupedData[key].offers++;
                        }
                    });

                    // Compter les applications
                    data.apps.forEach(app => {
                        const appDate = new Date(app.created_at);
                        let key;
                        
                        switch(period) {
                            case 'week':
                                key = appDate.toISOString().split('T')[0];
                                break;
                            case 'month':
                                key = `Semana ${getWeekNumber(appDate)}`;
                                break;
                            case 'year':
                                const months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                                            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                                key = months[appDate.getMonth()];
                                break;
                        }
                        
                        if (groupedData[key]) {
                            groupedData[key].apps++;
                        }
                    });

                    return groupedData;
                };

                // Obtenir toutes les dates de la plage
                const allDates = getDatesInRange(new Date(startDate), new Date(endDate));
                
                // Grouper les données
                const groupedData = groupDataByPeriod({
                    offers: offersSended,
                    apps: appsCount
                }, allDates, period);

                // Préparer les données pour le graphique
                const labels = Object.keys(groupedData);
                const chartData = {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Candidatos recibidos',
                            data: labels.map(label => groupedData[label].apps),
                            backgroundColor: 'rgb(54, 162, 235)',
                            order: 2
                        },
                        {
                            label: 'Solicitudes enviadas',
                            data: labels.map(label => groupedData[label].offers),
                            backgroundColor: 'rgb(54, 162, 235, 0.5)',
                            order: 1
                        }
                    ]
                };


                 // Configuration du graphique avec une largeur fixe par barre
                const barWidth = 60; // Largeur fixe pour chaque barre en pixels
                const containerWidth = document.querySelector('#statsChart').parentElement.offsetWidth;
                const totalBarsWidth = labels.length * barWidth;
                
                // Calculer la largeur minimale nécessaire pour toutes les barres
                const minWidth = Math.max(containerWidth, totalBarsWidth);
                
                
                

                // Configuration du graphique
                // Configuration du graphique
                const config = {
                    type: 'bar',
                    data: chartData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                stacked: true,
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    maxRotation: 0, // Empêcher la rotation des labels
                                    minRotation: 0
                                }
                            },
                            y: {
                                stacked: true,
                                beginAtZero: true,
                                grid: {
                                    drawBorder: false
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        },
                        layout: {
                            padding: {
                                left: 10,
                                right: 10
                            }
                        }
                    }
                };
                // Création du graphique
                const myChart = new Chart(ctx, config);

                const chartContainer = document.querySelector('#statsChart').parentElement;
                chartContainer.style.cssText = `
                    width: 100%;
                    height: 500px;
                    position: relative;
                    overflow-x: auto;
                    overflow-y: hidden;
                `;

                // Configuration du canvas
                const canvas = document.getElementById('statsChart');
                canvas.style.cssText = `
                    height: 500px !important;
                    width: ${minWidth}px !important;
                `;

                // Si le contenu dépasse la largeur du conteneur, activer le défilement
                if (totalBarsWidth > containerWidth) {
                    // Ajuster la largeur du canvas pour accommoder toutes les barres
                    canvas.style.minWidth = `${totalBarsWidth + 100}px`; // +100px pour la marge
                }

                return myChart;
            };
        </script>
        

        
        <script>
            // Convertir les données PHP en JSON pour JavaScript
            const offersSended = @json($offersSended);
            const appsCount = @json($appsCount);
            const startDate = @json($startDate);
            const endDate = @json($endDate);
            const period = @json($period);

            // Initialiser le graphique
            document.addEventListener('DOMContentLoaded', function() {
                initStatsChart(offersSended, appsCount, startDate, endDate, period);
            });
        </script>
        
    </body>
    </html>
@endsection --}}