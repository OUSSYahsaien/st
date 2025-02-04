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
        <link rel="stylesheet" href="{{ asset('css/Company/offer-applications.css') }}">
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
            
            <div class="logo-btn">
                <div class="logo-infos">
                    <img src="{{ Auth::user()->personel_pic && file_exists(public_path('images/companies_images/' . Auth::user()->personel_pic)) 
                    ? asset('images/companies_images/' . Auth::user()->personel_pic) 
                    : asset('images/companies_images/100x100.svg') }}" 
                     alt="Company Logo" id="companyLogo">
                    <div class="infos-c">
                        <p class="name-c">Empresa</p>
                        <p class="position-c">{{ Auth::user()->name }}</p>
                    </div>
                </div>
                <a style="text-decoration: none;" href="{{ route('company.my.offers.steep.one') }}">
                    <button> 
                        <i style="margin-top: 3px; margin-right: 12px;" class="fa fa-plus" aria-hidden="true"></i> 
                        Publicar nueva oferta 
                    </button>
                </a>
            </div>
            
            {{-- <hr style="margin-top: 9px; color: #D6DDEB;"> --}}
            
            <div class="mpage-header">

                <div class="" style=" display: flex; justify-content: space-between;">
                    <div class="">
                        <h1 class="b-d-u">{{ $offer->title }}</h1>
                        <p class="subtitle">{{ $offer->category . " • " . $offer->work_type . " • " . $offer->nbr_candidat_confermed .  " / " .  $offer->nbr_candidat_max . " Puestos cubiertos" }}</p>
                    </div>
                    {{-- <div style="height: 51px; font-weight: 600; display: flex; justify-content: center; align-items: center; cursor: pointer; color: #4640DE;" class="date-picker">
                        <svg style="margin-top: 4px; margin-right: 5px" xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                            <path d="M15.8307 7.58398L9.9974 13.4173L4.16406 7.58398" stroke="#4640DE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        More Action
                    </div> --}}
                </div>
                


                {{-- <div class="actions">
                    <div class=""></div>
                    <div class="header-buttons">
                        <a href="{{route('company.my.offers.steep.one')}}">
                            <button class="btn primary">Nueva solicitud</button>
                        </a>

                    </div>
                </div> --}}
            </div>
    
            <main class="table-container">
                <div class="search-container">
                    <label for="searchTable">Total de aplicaciones : {{$applicationsCount}}</label>
                    <input type="text" id="searchTable" placeholder="Buscar...">
                </div>
                <table id="myTable">
                    <thead>
                        <tr>
                            <th>Nombre completo</th>
                            <th>Valoración</th>
                            <th>Estado</th>
                            <th>Fecha de aplicación</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($applications as $application)
                            @php
                                $candidat = App\Models\Candidat::findOrFail($application->id_candidat);


                                if($application->status == "Seleccionado"){
                                    $candidat->personal_picture_path = "*********";
                                    $candidat->first_name = "*********";
                                    $candidat->last_name = "*********";
                                }
                                $personalPicturePath = 'images/candidats_images/' . $candidat->personal_picture_path;
                            @endphp
                            <tr>
                                <!-- Nom du candidat -->
                                <td class="candidate-info" style="height: 69px;">
                                    <div class="candidate-profile">
                                        @if($application->status == "Seleccionado")
                                            <img style="filter: blur(4px);" id="profile-image" src="{{ asset('images/companies_images/100x100.svg') }}" alt="Foto de perfil" class="profile-img">
                                        @else
                                            @if ($candidat->personal_picture_path && file_exists(public_path($personalPicturePath)))
                                                <img src="{{ asset($personalPicturePath) }}" alt="Avatar">
                                            @else
                                                <img id="profile-image" src="{{ asset('images/companies_images/100x100.svg') }}" alt="Foto de perfil" class="profile-img">
                                            @endif
                                        
                                        @endif
                                        
                                        @if($application->status == "Seleccionado")
                                            <span style="filter: blur(4px);">{{ $candidat->first_name ?? 'N/A' }} {{ $candidat->last_name ?? 'N/A' }}</span>
                                        @else
                                            <span>{{ $candidat->first_name ?? 'N/A' }} {{ $candidat->last_name ?? 'N/A' }}</span>
                                        @endif
                                    </div>
                                </td>
                
                                <!-- Évaluation -->
                                <td>
                                    <span class="rating">
                                            <i class="fa fa-star {{ $candidat->rating > 0 ? 'rated' : '' }}"></i>
                                            {{ number_format($candidat->rating, 1) }}
                                    </span>
                                </td>
                
                                <!-- État -->
                                <td>
                                    <span class="badge {{ strtolower($application->status) }} {{ $application->status == 'En proceso' ? 'en-proceso' : '' }}">
                                        {{ $application->status }}
                                    </span>
                                </td>
                
                                <!-- Date de candidature -->
                                <td>
                                        {{ $application->created_at->format('d M, Y') }}
                                </td>
                
                                <!-- Actions -->
                                <td style="height: 69px; display: flex; justify-content: center; align-items: center;" class="action-column">
                                    <a class="btn-view" href="{{ route('company.my.offers.view.candidat', ['id' => $application->id]) }}">
                                        Ver solicitud
                                    </a>
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
                    {{ $applications->links('vendor.pagination.default') }}
                </div>
                
            </main>
            

            <!-- Affichage en cartes pour les petits écrans -->
            <div class="card-container">
                @foreach ($applicationsForMobile as $application)
                    @php
                        $candidat = App\Models\Candidat::findOrFail($application->id_candidat);

                        if($application->status == "Seleccionado"){
                            $candidat->personal_picture_path = "*********";
                            $candidat->first_name = "*********";
                            $candidat->last_name = "*********";
                        }
                        $personalPicturePath = 'images/candidats_images/' . $candidat->personal_picture_path;
                    @endphp

                    
                    <div class="card">
                        <!-- Header with Profile -->
                        <div class="card-header">
                            <div class="candidate-profile-2">
                                @if ($candidat->personal_picture_path && file_exists(public_path($personalPicturePath)))
                                    <img src="{{ asset($personalPicturePath) }}" alt="Avatar" class="profile-img-2">
                                @else
                                    <img src="{{ asset('images/companies_images/100x100.svg') }}" alt="Foto de perfil" class="profile-img">
                                @endif
                                <div class="candidate-info-2">
                                    <h4>{{ $candidat->first_name ?? 'N/A' }} {{ $candidat->last_name ?? 'N/A' }}</h4>
                                    <div class="rating-2">
                                            <i class="fa fa-star {{ $candidat->rating > 0 ? 'rated' : '' }}"></i>
                                            {{ number_format($candidat->rating, 1) }}
                                    </div>
                                </div>
                            </div>
                                {{-- <button class="view-details">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button> --}}
                        </div>
            
                        <!-- Status Badge -->
                        <div class="status-section">
                            <span class="badge {{ strtolower($application->status) }} {{ $application->status == 'En proceso' ? 'en-proceso' : '' }}">
                                {{ $application->status }}
                            </span>
                        </div>
            
                        <!-- Application Info -->
                        <div class="application-info">
                            {{-- <div class="info-item">
                                <strong>Candidatos:</strong>
                                <span>{{$offer->nbr_candidat_confermed}}/{{$offer->nbr_candidat_max}}</span>
                            </div> --}}
                            <div class="work-type">
                                <span class="work-type-badge">{{ $offer->work_type }}</span>
                            </div>
                        </div>
            
                        <!-- Dates -->
                        <div class="dates-section">
                            <p class="application-date">
                                <strong>Fecha de aplicación:</strong> 
                                    {{ $application->created_at->format('d M, Y') }}
                            </p>
                            <a class="btn-view" href="{{ route('company.my.offers.view.candidat', ['id' => $application->id]) }}">
                                Ver solicitud
                            </a>
                        </div>
                    </div>
                    <div style="height: 30px"></div>
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
                    const template = document.querySelector('#contextMenu');
                    
                    document.querySelectorAll('.view-details').forEach(button => {
                        const menu = template.content.cloneNode(true).querySelector('.context-menu');
                        button.parentElement.appendChild(menu);
                        
                        button.addEventListener('click', function(e) {
                            e.stopPropagation();
                            
                            // Ferme tous les autres menus ouverts
                            document.querySelectorAll('.context-menu.active').forEach(m => {
                                if (m !== menu) m.classList.remove('active');
                            });
                            
                            // Toggle le menu actuel
                            menu.classList.toggle('active');
                            
                            // Positionne le menu
                            const rect = button.getBoundingClientRect();
                            menu.style.top = '40px';
                            menu.style.right = '0';
                        });
                    });
                    
                    // Ferme le menu si on clique ailleurs
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
                

    </body>
    </html>
@endsection