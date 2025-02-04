@extends('layouts.admin')

@section('title', 'Offers Company')

@section('page-title', 'Portal de los administradores')

@section('content')
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ asset('css/Admin/company/poublicated-offers.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>
    <body>
        
        
        <main class="company-profile">
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

            
            <div class="mpage-header">
                <div class="tab-controls">
                    <a href="{{route('administration.companies.profile', ['id' => $company->id])}}">
                        <button class="tab">Pagina de la empresa </button>
                    </a>
                    <a href="{{route('administration.companies.offersCompany', ['id' => $company->id ])}}">
                        <button class="tab active">Ofertas Publicadas</button>
                    </a>
                    {{-- <a href="{{route('administration.companies.in.progres')}}">
                        <button class="tab">Solicitudes</button>
                    </a> --}}
                </div>
            </div>





            <div class="table-container">
                <table id="myTable">
                    <thead>
                        {{-- <div class="search-container">
                            <label for="searchTable">Rechercher:</label>
                            <input type="text" id="searchTable" placeholder="Rechercher dans toutes les colonnes...">
                        </div> --}}
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
                                <td>{{ $offer->publication_date ? $offer->publication_date->format('Y-m-d') : 'Sin fecha' }}</td>
                                <td style="height: 69px;" class="work-type-badge-container"><span class="work-type-badge">{{ $offer->work_type }}</span></td>
                                <td> 
                                    <a style="display: flex; justify-content: center; align-items: center; color: #444; font-weight: 600; text-decoration: underline;" href="{{ route('administration.companies.offers.view.applications', ['id' => $offer->id]) }}">    
                                        {{ $applicationsCount }}</td>
                                    </a>
                                <td>
                                    <div class="positions">
                                        <a style="text-decoration: underline; color: #444;" href="{{ route('administration.companies.offers.view.applications', ['id' => $offer->id]) }}?search=Confirmada">
                                            {{ $offer->nbr_candidat_confermed }} <span>/ {{ $offer->nbr_candidat_max }}</span>
                                        </a>
                                    </div>
                                </td>
                                <td class="action-column">
                                    <div class="dropdown-container">
                                        <i class="fa-solid fa-ellipsis dropdown-trigger"></i>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('administration.view.offer', ['id' => $offer->id]) }}" class="dropdown-item">
                                                Ver oferta
                                            </a>
                                            {{-- <a href="#" 
                                                class="dropdown-item text-danger delete-offer" 
                                                data-offer-id="{{ $offer->id }}">
                                                    Cerrar oferta
                                                </a> --}}
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
                            {{-- <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option> --}}
                            <option value="20" {{ request('perPage') == 20 ? 'selected' : '' }}>20</option>
                            <option value="40" {{ request('perPage') == 40 ? 'selected' : '' }}>40</option>
                        </select>
                    </div>
                </div>
    
                <div class="pagination" style="margin-top: -20px;">
                    {{ $offers->links('vendor.pagination.default2') }}
                </div>
            </div>


            

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
                            {{-- <a style="text-decoration: underline; color: #0058D2;" href="{{ route('company.my.offers.view.applications', ['id' => $offer->id]) }}"> --}}
                                <a style="text-decoration: underline; color: #444;" 
                                    href="{{ route('administration.companies.offers.view.applications', ['id' => $offer->id]) }}?search=Confirmada">
                                    {{$offer->nbr_candidat_confermed}}/{{$offer->nbr_candidat_max}}
                                </a>                             
                        </p>
            
                        <!-- Positionner le work-type-badge en haut à droite -->
                        <span class="work-type-badge-2">{{ $offer->work_type }}</span>
            
                        <!-- Date "Fecha de Envío" en bas à droite -->
                        <p class="fecha-envio"><strong>Fecha de Envío:</strong> {{ $offer->created_at->format('Y-m-d') }}</p>
            
                        <!-- Date "Fecha de Publicación" en bas à gauche -->
                        <p class="fecha-publicacion"><strong>Fecha de Publicación:</strong> {{$offer->publication_date ? $offer->publication_date->format('Y-m-d') : 'Sin fecha'}}</p>
            
                        <button class="view-details">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                    </div>
                    <div style="height: 10px"></div>

                    
                    
                    <template id="contextMenu">
                            <div class="context-menu">
                                <a style="padding: 0;" href="{{ route('administration.view.offer', ['id' => $offer->id]) }}" class="dropdown-item">
                                    <button class="menu-item view">
                                        Ver oferta
                                    </button>
                                </a>
                            </div>
                    </template>       
                @endforeach
            </div>

            

        </main>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>



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
            function changeRowsPerPage(select) {
                const url = new URL(window.location.href);
                url.searchParams.set('perPage', select.value);
                window.location.href = url.toString();
            }
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
        {{-- <script>
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
        </script> --}}
        
    </body>
    </html>
@endsection