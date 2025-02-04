@extends('layouts.admin')

@section('title', 'Company Apps')

@section('page-title', 'Portal de los administradores')

@section('content')
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Document</title>
        <link rel="stylesheet" href="{{ asset('css/Admin/company/offer-applications-pipeline.css') }}">
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
        
            
            <div class="mpage-header" style="margin-top: -33px">

                <div class="" style=" display: flex; justify-content: space-between;">
                    <div class="">
                        <h1 class="b-d-u">{{ $offer->title }}</h1>
                        <p class="subtitle">{{ $offer->category . " • " . $offer->work_type . " • " . $offer->nbr_candidat_confermed .  " / " .  $offer->nbr_candidat_max . " Puestos cubiertos" }}</p>
                    </div>
                </div>

                <div class="search-container">
                    <label for="searchTable">Total de aplicaciones : {{$applicationsCount}}</label>
                    <div class="" style="display: flex; gap: 9px;"> 
                        <div class="buttons-container">
                            <a href="{{route('administration.companies.offers.view.applications', ['id' => $offer->id])}}">
                                <button>Tabla</button>
                            </a>
                            <button class="active">Pipeline</button>
                        </div>
                        {{-- <input type="text" id="searchTable" placeholder="Buscar..."> --}}
                    </div>
                </div>
            </div>
    

            <div class="board">
                @foreach(['Evaluacion', 'En proceso', 'Entrevista', 'Confirmada', 'Descartado', 'Seleccionado'] as $status)
                <div class="column" data-status="{{ $status }}">
                    <h2>{{ ucfirst(str_replace('-', ' ', $status)) }} 
                        <span class="counter">{{ $applications->where('status', $status)->count() }}</span>
                    </h2>
                    <div class="cards-container">
                        @foreach($applications->where('status', $status) as $application)
                        <div class="card" draggable="true" id="card-{{ $application->id }}">
                            <span class="switch" style="position: absolute; top: 9px; right: 9px; padding: 4px; border: 2px solid #d5dcea; cursor: pointer;">
                                <i class="fa-solid fa-repeat"></i>

                                    <div class="status-menu">
                                        <div class="status-menu-item" data-status="Evaluacion" >
                                            Evaluacion
                                        </div>
                                        <div class="status-menu-item" data-status="En proceso" >
                                            En proceso
                                        </div>
                                        <div class="status-menu-item" data-status="Entrevista" >
                                            Entrevista
                                        </div>
                                        <div class="status-menu-item" data-status="Confirmada" >
                                            Confirmada
                                        </div>
                                        <div class="status-menu-item" data-status="Descartado" >
                                            Descartado
                                        </div>
                                        <div class="status-menu-item" data-status="Seleccionado" >
                                            Seleccionado
                                        </div>
                                    </div>
                            </span>
                            <div class="card-header">
                                @php
                                    $personalPicturePath = 'images/candidats_images/' . $application->personal_picture_path;
                                @endphp
                                
                                @if ($application->personal_picture_path && file_exists(public_path($personalPicturePath)))    
                                    <img src="{{ asset($personalPicturePath) }}" alt="Avatar">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($application->first_name . ' ' . $application->last_name) }}" alt="Avatar">
                                @endif
                                
                                <div class="card-header-text">
                                    <h3>{{ $application->first_name }} {{ $application->last_name }}</h3>
                                    <a draggable="false" href="{{ route('administration.view.candidat', ['id' => $application->id_candidat]) }}" class="profile-link">Ver Perfil</a>
                                </div>
                            </div>
                            
                            <div class="f sb c">
                                <div class="">
                                    <p>Applied on:</p>
                                    <p style="font-size: 14px; color: #444; font-weight: 600">{{ $application->created_at->format('d F, Y') }}</p>
                                </div>
                                <div class="">
                                    <p>Valoración</p>
                                    <div class="">
                                        <span class="rating">
                                            <i class="fa fa-star {{ $application->rating > 0 ? 'rated' : '' }}"></i>
                                            <span style="font-size: 14px; color: #444; font-weight: 600">
                                                {{ number_format($application->rating, 1) }}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>  
                        
                            <div class="status-menu">
                                <div class="status-menu-item" data-status="Evaluacion" >
                                    Evaluacion
                                </div>
                                <div class="status-menu-item" data-status="En proceso" >
                                    En proceso
                                </div>
                                <div class="status-menu-item" data-status="Entrevista" >
                                    Entrevista
                                </div>
                                <div class="status-menu-item" data-status="Confirmada" >
                                    Confirmada
                                </div>
                                <div class="status-menu-item" data-status="Descartado" >
                                    Descartado
                                </div>
                                <div class="status-menu-item" data-status="Seleccionado" >
                                    Seleccionado
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            document.querySelectorAll('.status-menu-item').forEach(item => {
                item.addEventListener('click', handleStatusChange);
            });


            const updateStatusRoute = "{{ route('administration.companies.application.updateStatus', ['id' => '__PLACEHOLDER__']) }}";
            
            function handleStatusChange(e) {
                const newStatus = e.target.dataset.status;
                const card = e.target.closest('.card');
                if (!card || !newStatus) return;
                
                const cardId = card.id.replace('card-', '');
                
                // Replace placeholder with actual ID
                const route = updateStatusRoute.replace('__PLACEHOLDER__', cardId);
                
                // Send AJAX request to update application status
                fetch(route, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(response => {
                    if (response.ok) {
                        const targetColumn = document.querySelector(`[data-status="${newStatus}"] .cards-container`);
                        if (targetColumn) {
                            // Update the card's column
                            targetColumn.appendChild(card);
                            
                            // Update the column counters
                            updateCounters();
                        }
                    }
                })
                .catch(error => console.error('Error updating status:', error));
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Remove hardcoded initial cards initialization
                initializeDragAndDrop();
                updateCounters();
            });

            // Enhanced drag and drop functionality
            function initializeDragAndDrop() {
                const cards = document.querySelectorAll('.card');
                const containers = document.querySelectorAll('.cards-container');

                cards.forEach(card => {
                    card.addEventListener('dragstart', handleDragStart);
                    card.addEventListener('dragend', handleDragEnd);
                    card.addEventListener('touchstart', handleTouchStart, { passive: true });
                    card.addEventListener('touchmove', handleTouchMove);
                    card.addEventListener('touchend', handleTouchEnd);
                });

                containers.forEach(container => {
                    container.addEventListener('dragover', handleDragOver);
                    container.addEventListener('dragleave', handleDragLeave);
                    container.addEventListener('drop', handleDrop);
                });
            }

            // Drag and drop handlers
            function handleDragStart(e) {
                if (!e.target.classList) return;
                
                e.dataTransfer.setData('text/plain', e.target.id);
                e.target.classList.add('dragging');
                
                // Create a custom ghost image
                const ghost = e.target.cloneNode(true);
                ghost.style.opacity = '0.5';
                ghost.style.position = 'absolute';
                ghost.style.top = '-1000px';
                document.body.appendChild(ghost);
                e.dataTransfer.setDragImage(ghost, 0, 0);
                
                setTimeout(() => {
                    document.body.removeChild(ghost);
                }, 0);
            }

            function handleDragEnd(e) {
                if (e.target.classList) {
                    e.target.classList.remove('dragging');
                }
                removeDropzoneHighlights();
            }

            function handleDragOver(e) {
                e.preventDefault();
                const container = e.target.closest('.cards-container');
                if (container && !container.classList.contains('drag-over')) {
                    removeDropzoneHighlights();
                    container.classList.add('drag-over');
                }
            }

            function handleDragLeave(e) {
                const container = e.target.closest('.cards-container');
                if (container) {
                    container.classList.remove('drag-over');
                }
            }

            function handleDrop(e) {
                e.preventDefault();
                const cardId = e.dataTransfer.getData('text/plain');
                const card = document.getElementById(cardId);
                const dropZone = e.target.closest('.cards-container');
                
                if (dropZone && card) {
                    const newStatus = dropZone.closest('.column').dataset.status;
                    const closestCard = getClosestCard(dropZone, e.clientY);
                    


                    if (closestCard) {
                        dropZone.insertBefore(card, closestCard);
                    } else {
                        dropZone.appendChild(card);
                    }
                    
                    
                    // Send AJAX request to update application status
                    fetch(updateStatusRoute.replace('__PLACEHOLDER__', cardId.replace('card-', '')), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ status: newStatus })
                    })
                    .then(response => {
                        if (response.ok) {
                            updateCounters();
                        }
                    })
                    .catch(error => console.error('Error updating status:', error));
                }
                
                removeDropzoneHighlights();
            }

            // Touch event handlers
            let touchStartY;
            let draggedCard;

            function handleTouchStart(e) {
                const touch = e.touches[0];
                touchStartY = touch.clientY;
                draggedCard = e.target.closest('.card');
                if (draggedCard && draggedCard.classList) {
                    draggedCard.classList.add('dragging');
                }
            }

            function handleTouchMove(e) {
                if (!draggedCard) return;
                e.preventDefault();
                
                const touch = e.touches[0];
                const dropZone = getDropZoneAtPoint(touch.clientX, touch.clientY);
                
                if (dropZone) {
                    removeDropzoneHighlights();
                    dropZone.classList.add('drag-over');
                }
            }

            function handleTouchEnd(e) {
                if (!draggedCard) return;

                let cardID = draggedCard.id
                
                const touch = e.changedTouches[0];
                const dropZone = getDropZoneAtPoint(touch.clientX, touch.clientY);
                
                if (dropZone) {
                    const newStatus = dropZone.closest('.column').dataset.status;
                    
                    const closestCard = getClosestCard(dropZone, touch.clientY);
                    if (closestCard) {
                        dropZone.insertBefore(draggedCard, closestCard);
                    } else {
                        dropZone.appendChild(draggedCard);
                    }

                    // Send AJAX request to update application status
                        fetch(updateStatusRoute.replace('__PLACEHOLDER__', cardID.replace('card-', '')), {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ status: newStatus })
                        })
                        .then(response => {
                            if (response.ok) {
                                updateCounters();
                            }
                        })
                        .catch(error => console.error('Error updating status:', error));
                    
                }
                
                if (draggedCard.classList) {
                    draggedCard.classList.remove('dragging');
                }
                removeDropzoneHighlights();
                draggedCard = null;
            }

            // Helper functions
            function getDropZoneAtPoint(x, y) {
                const elements = document.elementsFromPoint(x, y);
                return elements.find(el => el.classList.contains('cards-container'));
            }

            function getClosestCard(container, y) {
                const cards = [...container.querySelectorAll('.card:not(.dragging)')];
                
                return cards.reduce((closest, child) => {
                    const box = child.getBoundingClientRect();
                    const offset = y - box.top - box.height / 2;
                    
                    if (offset < 0 && offset > closest.offset) {
                        return { offset: offset, element: child };
                    } else {
                        return closest;
                    }
                }, { offset: Number.NEGATIVE_INFINITY }).element;
            }

            function removeDropzoneHighlights() {
                document.querySelectorAll('.cards-container').forEach(container => {
                    container.classList.remove('drag-over');
                });
            }

            // Update counters in column headers
            function updateCounters() {
                document.querySelectorAll('.column').forEach(column => {
                    const counter = column.querySelector('.counter');
                    const cardsCount = column.querySelectorAll('.card').length;
                    counter.textContent = cardsCount;
                });
            }

        </script>
    </body>
    </html>
@endsection