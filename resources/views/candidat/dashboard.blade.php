@extends('layouts.candidat')

@section('title', 'Dashboard Candidat')

@section('page-title', 'Tableau de Bord')

@section('content')
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Document</title>
        <link rel="stylesheet" href="{{ asset('css/dashboard/dash.css') }}">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>


        <div class="head-dash">
            <div class="title-subTitle">
                <div class="dash-title">Buenos días, {{Auth::user()->first_name}}</div>
                <div class="dash-subTitle">Aquí está lo que está sucediendo con sus aplicaciones de búsqueda de empleo del 

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
                <form id="filterForm" action="{{ route('candidat.dashboard') }}" method="GET">
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

        
        
        
        
        
        
        
        <div class="container-dash">
            <div class="dashboard">
                <div class="stats-container">
                    <div class="cards-container">
                        <div class="stat-box">  
                            <h4>Total de solicitudes</h4>
                            <div class="stat-value-img">
                                <div class="stat-value">{{isset($applicationsCount) ? $applicationsCount : ''  }}</div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="88" height="68" viewBox="0 0 88 68" fill="none">
                                    <g opacity="0.3">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M25.668 14.6673C24.6955 14.6673 23.7629 15.0536 23.0752 15.7413C22.3876 16.4289 22.0013 17.3615 22.0013 18.334V69.6673C22.0013 70.6398 22.3876 71.5724 23.0752 72.26C23.7629 72.9477 24.6955 73.334 25.668 73.334H62.3346C63.3071 73.334 64.2397 72.9477 64.9274 72.26C65.615 71.5724 66.0013 70.6398 66.0013 69.6673L66.0013 34.5194L46.1496 14.6677L25.668 14.6673ZM17.8898 10.5558C19.9527 8.49291 22.7506 7.33398 25.668 7.33398H46.15C48.0946 7.3344 49.9601 8.10714 51.335 9.48226M51.335 9.48226L71.186 29.3332C71.1858 29.3331 71.1861 29.3333 71.186 29.3332C72.5611 30.7081 73.3342 32.5733 73.3346 34.5179V69.6673C73.3346 72.5847 72.1757 75.3826 70.1128 77.4455C68.0499 79.5084 65.252 80.6673 62.3346 80.6673H25.668C22.7506 80.6673 19.9527 79.5084 17.8898 77.4455C15.8269 75.3826 14.668 72.5847 14.668 69.6673V18.334C14.668 15.4166 15.8269 12.6187 17.8898 10.5558M29.3346 44.0007C29.3346 41.9756 30.9763 40.334 33.0013 40.334H55.0013C57.0264 40.334 58.668 41.9756 58.668 44.0007C58.668 46.0257 57.0264 47.6673 55.0013 47.6673H33.0013C30.9763 47.6673 29.3346 46.0257 29.3346 44.0007ZM29.3346 58.6673C29.3346 56.6423 30.9763 55.0007 33.0013 55.0007H55.0013C57.0264 55.0007 58.668 56.6423 58.668 58.6673C58.668 60.6924 57.0264 62.334 55.0013 62.334H33.0013C30.9763 62.334 29.3346 60.6924 29.3346 58.6673Z" fill="#515B6F"/>
                                    <rect x="29.332" y="40.334" width="29.3333" height="7.33333" rx="3.66667" fill="#26A4FF"/>
                                    <rect x="29.332" y="55" width="29.3333" height="7.33333" rx="3.66667" fill="#26A4FF"/>
                                    </g>
                                </svg>
                            </div>
                        </div>
                        <div class="stat-box">
                            <h4>Entrevistas</h4>
                            <div class="stat-value-img-2">
                                <div class="stat-value">{{isset($interviewedApplicationsCount) ? $interviewedApplicationsCount : ''  }}</div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="88" height="68" viewBox="0 0 88 68" fill="none">
                                    <g opacity="0.3">
                                    <path d="M80.1399 51.0434L75.5081 45.7039C78.8465 41.5277 80.6654 36.3642 80.6654 30.9668C80.6654 17.9357 70.0639 7.33398 57.0326 7.33398C44.0013 7.33398 33.3998 17.9357 33.3998 30.9668C33.3998 31.8378 33.4486 32.6974 33.5409 33.5442C32.6866 33.4513 31.8265 33.4017 30.9649 33.4017C17.9337 33.4017 7.33207 44.0034 7.33207 57.0345C7.33207 62.432 9.15094 67.5952 12.4893 71.7716L7.85758 77.1111C7.30629 77.7467 7.17666 78.6455 7.526 79.4109C7.87534 80.1762 8.63918 80.6673 9.48051 80.6673H30.9649C43.996 80.6673 54.5977 70.0656 54.5977 57.0345C54.5977 56.1728 54.5481 55.3128 54.4552 54.4585C55.302 54.5508 56.1616 54.5996 57.0326 54.5996H78.517C79.3583 54.5996 80.1223 54.1085 80.4715 53.3432C80.8208 52.5778 80.6912 51.679 80.1399 51.0434ZM30.9649 76.3704H14.1883L16.9562 73.1797C17.6792 72.3463 17.6533 71.1005 16.8962 70.2978C13.4997 66.6963 11.6289 61.9859 11.6289 57.0345C11.6289 46.3727 20.303 37.6986 30.9649 37.6986C32.1442 37.6986 33.3199 37.806 34.4741 38.0177C36.7827 45.3881 42.6113 51.2167 49.9817 53.5252C50.1934 54.6795 50.3008 55.8552 50.3008 57.0345C50.3008 67.6965 41.6269 76.3704 30.9649 76.3704ZM57.0326 50.3027C46.3708 50.3027 37.6967 41.6286 37.6967 30.9668C37.6967 20.305 46.3708 11.6309 57.0326 11.6309C67.6944 11.6309 76.3685 20.305 76.3685 30.9668C76.3685 35.9182 74.4978 40.6286 71.1013 44.2301C70.3442 45.0328 70.3182 46.2786 71.0413 47.112L73.8092 50.3027H57.0326Z" fill="#515B6F" stroke="#515B6F" stroke-width="2"/>
                                    <path d="M57.0352 45.5762C58.2217 45.5762 59.1836 44.6143 59.1836 43.4277C59.1836 42.2412 58.2217 41.2793 57.0352 41.2793C55.8486 41.2793 54.8867 42.2412 54.8867 43.4277C54.8867 44.6143 55.8486 45.5762 57.0352 45.5762Z" fill="#26A4FF" stroke="#26A4FF" stroke-width="0.668098"/>
                                    <path d="M57.2044 16.2146C53.0351 16.1291 49.4485 19.1803 48.8723 23.3086C48.8196 23.6862 48.793 24.0719 48.793 24.4555C48.793 25.642 49.7549 26.6039 50.9414 26.6039C52.1279 26.6039 53.0898 25.642 53.0898 24.4555C53.0898 24.2699 53.1026 24.0837 53.1279 23.9025C53.3997 21.9551 55.0727 20.5098 57.0371 20.5098C57.064 20.5098 57.0908 20.5101 57.1179 20.5107C59.1745 20.5521 60.8691 22.1913 60.9755 24.2426C61.0323 25.3382 60.6492 26.378 59.8967 27.1707C59.1434 27.964 58.1272 28.401 57.0354 28.401C55.8489 28.401 54.8869 29.3629 54.8869 30.5495V36.9219C54.8869 38.1084 55.8489 39.0703 57.0354 39.0703C58.2219 39.0703 59.1838 38.1084 59.1838 36.9219V32.4101C60.6322 32.0168 61.9659 31.2318 63.0126 30.1292C64.5847 28.4735 65.3851 26.3039 65.2665 24.0199C65.0439 19.7298 61.5026 16.3013 57.2044 16.2146Z" fill="#26A4FF" stroke="#26A4FF" stroke-width="0.668098"/>
                                    <path d="M38.1276 50.5879H23.8047C22.6182 50.5879 21.6562 51.5498 21.6562 52.7363C21.6562 53.9228 22.6182 54.8848 23.8047 54.8848H38.1276C39.3141 54.8848 40.276 53.9228 40.276 52.7363C40.276 51.5498 39.3141 50.5879 38.1276 50.5879Z" fill="#26A4FF" stroke="#26A4FF" stroke-width="0.668098"/>
                                    <path d="M38.1276 59.1816H23.8047C22.6182 59.1816 21.6562 60.1436 21.6562 61.3301C21.6562 62.5166 22.6182 63.4785 23.8047 63.4785H38.1276C39.3141 63.4785 40.276 62.5166 40.276 61.3301C40.276 60.1436 39.3141 59.1816 38.1276 59.1816Z" fill="#26A4FF" stroke="#26A4FF" stroke-width="0.668098"/>
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="chart-container">
                        <div class="chart-title">Estado de las solicitudes</div>
                            <canvas id="donutChart"></canvas>
                            <div class="legend">
                                <div class="legend-item">
                                    <div class="color-box blue"></div>
                                    <span style="color: #25324B; font-weight: bold;">{{$interviewedPercentage}}% Entrevistas</span>
                                </div>
                                <div class="legend-item">
                                    <div class="color-box light-blue"></div>
                                    <span style="color: #25324B; font-weight: bold;">{{$notMatchingPercentage}}% No encaja</span>
                                </div>
                            </div>
                        <div class="footer-link">
                            <a href="{{route('candidat.offers')}}">Ver todas las solicitudes 
                                <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                    <div class="schedule-box">
                        <div class="schedule-header">
                            <div class="title-section">
                                <h2 class="schedule-title">próximas entrevistas</h2>
                                <button class="today-btn">Día actual</button>
                            </div>
                            
                            <form method="GET" action="{{ route('candidat.dashboard') }}">
                                @csrf
                                <div class="schedule-date">
                                    <span>Hoy, {{ $today->isoFormat('D [de] MMMM') }}</span>
                                    <input type="date" style="display: none;" name="start_date" class="input" value="{{ request('start_date', \Carbon\Carbon::now()->startOfWeek()->format('Y-m-d')) }}">
                                    <input type="date" style="display: none;" name="end_date" class="input" value="{{ request('end_date', \Carbon\Carbon::now()->endOfWeek()->format('Y-m-d')) }}">
                                    <input type="date" style="display: none;" name="currentDate" value="{{ $today->format('Y-m-d') }}" id="currentDate">
                                    <div class="schedule-nav">
                                        <button type="button" class="nav-btn prev">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <button type="button" class="nav-btn next">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                                                
                        

                        
                        
                    
                        <div class="schedule-content">
                            <div class="schedule-timeline">
                                @if($events->count() > 0)
                                    @foreach($events as $event)
                                        <div class="timeline-slot">
                                            <div class="time-label">
                                                {{ Carbon\Carbon::parse($event->start)->format('h:i A') }}
                                            </div>
                                            <div class="event-card">
                                                <h3 class="event-title">{{ $event->title }}</h3>
                                                <p class="event-details">
                                                    Entrevistador: {{ $admin->username }}, 
                                                    Duración: {{ number_format(Carbon\Carbon::parse($event->start)->diffInHours(Carbon\Carbon::parse($event->end)), 2) }}h
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="empty-state">
                                        <p class="text-center text-gray-500 py-4">
                                            No hay entrevistas programadas para hoy
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>




        <div class="application-history">
            <div class="history-container">
                <h2 class="history-title">Historial de aplicaciones recientes</h2>
                <div class="history-table">
                    @if (isset($applicationsWithDetails))
                    @foreach ($applicationsWithDetails as $data)
                        @php
                            $application = $data['application'];
                            $offer = $data['offer'];
                            $company = $data['company'];
                        @endphp
                        <div class="history-row">
                            <div class="job-info">
                                <h3>{{ $offer ? $offer->title : 'Non spécifié' }}</h3>
                                <div class="company-info">
                                    <span>{{ $company ? $company->name : 'Non spécifié' }}</span>
                                    <span class="dot">•</span>
                                    <span>{{ $offer ? $offer->place : 'Non spécifié' }}</span>
                                    <span class="dot">•</span>
                                    <span>{{ $offer ? $offer->work_type : 'Non spécifié' }}</span>
                                </div>
                            </div>
                            <div class="application-info">
                                <div class="date-info">
                                    <span class="label">Fecha de aplicación</span>
                                    <span class="date">{{ $application->created_at->format('d M Y') }}</span>
                                </div>
                                <div class="status-menu">
                                    <span class="status status-{{ strtolower($application->status) }}">
                                        {{ $application->status }}
                                    </span>
                                    <div class="dropdown">
                                        <button class="menu-dots">•••</button>
                                        <div class="dropdown-menu">
                                            <a href="#" onclick="requestReview({{ $application->id }})" class="dropdown-item review">Solicitar revisión</a>
                                            <a href="#" onclick="confirmDelete({{ $application->id }})" class="dropdown-item exit danger">Salir del proceso</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                
                </div>
                <div class="view-all">
                    <a href="{{route('candidat.offers')}}">Ver todo el historial de aplicaciones 
                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
        
        

        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha384-oMbiyQlXEzIWZiukEpo1LuRFXUkCbIcSJQ8OG1+2KigCB06ns2+9zSrSbi4jKLk2" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            let interviewedApps = {{$interviewedPercentage}}
            let otherApps = {{$notMatchingPercentage}}
            
            const ctx = document.getElementById('donutChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [interviewedApps, otherApps],
                        backgroundColor: ['#007bff', '#d6e5ff'],
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: false,
                    maintainAspectRatio: false,
                    cutout: '70%', 
                }
            });
        </script>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                    // Get all dropdown buttons
                    const dropdownButtons = document.querySelectorAll('.menu-dots');
                    
                    // Add click event to each button
                    dropdownButtons.forEach(button => {
                        button.addEventListener('click', function(e) {
                            e.stopPropagation();
                            
                            // Close all other dropdowns
                            dropdownButtons.forEach(btn => {
                                if (btn !== button) {
                                    btn.parentElement.classList.remove('active');
                                }
                            });
                            
                            // Toggle current dropdown
                            this.parentElement.classList.toggle('active');
                        });
                    });
                    
                    // Close dropdown when clicking outside
                    document.addEventListener('click', function(e) {
                        dropdownButtons.forEach(button => {
                            if (!button.parentElement.contains(e.target)) {
                                button.parentElement.classList.remove('active');
                            }
                        });
                    });
                });

        </script>

        <script>
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
            document.querySelectorAll('.dropdown-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const dropdown = this.closest('.dropdown');
                    if (dropdown) {
                        dropdown.classList.remove('active');
                    }

                    if (this.classList.contains('review')) {
                    } else if (this.classList.contains('exit')) {
                    }
                });
            });
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



        {{-- <script>
            $(document).on('click', '.nav-btn', function () {
                let action = $(this).hasClass('prev') ? 'prev' : 'next';
                // let dateActuel = document.getElementById('dateActuelle');


                $.ajax({
                    url: '/candidat/update-schedule', // URL de l'endpoint Laravel
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        action: action
                        // dateActuell: dateActuel
                    },
                    success: function (response) {
                        // Mettre à jour la date affichée
                        $('.schedule-date span').text(response.date);
                        // $('#dateActuelle').value(response.da);

                        // Mettre à jour les événements
                        let timeline = $('.schedule-timeline');
                        timeline.empty();

                        if (response.events.length > 0) {
                            response.events.forEach(event => {
                                let slot = `
                                    <div class="timeline-slot">
                                        <div class="time-label">
                                            ${event.start_formatted}
                                        </div>
                                        <div class="event-card">
                                            <h3 class="event-title">${event.title}</h3>
                                            <p class="event-details">
                                                Entrevistador: ${event.admin_username}, 
                                                Duración: ${event.duration}h
                                            </p>
                                        </div>
                                    </div>`;
                                timeline.append(slot);
                            });
                        } else {
                            timeline.append(`
                                <div class="empty-state">
                                    <p class="text-center text-gray-500 py-4">
                                        No hay entrevistas programadas para hoy
                                    </p>
                                </div>
                            `);
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });

        </script> --}}


        <script>
            document.querySelector('.nav-btn.prev').addEventListener('click', function () {
                adjustDate(-1);
            });
        
            document.querySelector('.nav-btn.next').addEventListener('click', function () {
                adjustDate(1);
            });

            document.querySelector('.today-btn').addEventListener('click', function () {
                todayEvents();
            });
        
            function adjustDate(days) {
                const input = document.getElementById('currentDate');
                const currentDate = new Date(input.value);
                currentDate.setDate(currentDate.getDate() + days);
                input.value = currentDate.toISOString().split('T')[0]; // Formate en YYYY-MM-DD
                input.form.submit(); // Soumet le formulaire
            }

            function todayEvents() {
                const input = document.getElementById('currentDate');
                const today = new Date();
                input.value = today.toISOString().split('T')[0]; // Formate la date d'aujourd'hui en YYYY-MM-DD
                input.form.submit(); // Soumet le formulaire
            }

        </script>


    </body>
    </html>
@endsection
