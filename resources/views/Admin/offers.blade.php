@extends('layouts.admin')

@section('title', 'Portal de los administradores')

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
        <link rel="stylesheet" href="{{ asset('css/Admin/offers.css') }}">
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
                        <h1 class="b-d-u">Total Ofertas  : {{$offersCount}}</h1>
                        {{-- <p class="subtitle">Aquí puede consultar todas las solicitudes enviadas desde 19 de julio - 25 de julio.</p> --}}
                    </div>
                    {{-- <div style="height: 51px; display: flex; justify-content: center; align-items: center; cursor: pointer;" class="date-picker">Jul 19 - Jul 25</div> --}}
                    <div class="actions">
                        <div class=""></div>
                        <div class="header-buttons">
                            <a href="{{route('administration.create.offer.steep.one')}}" style="text-decoration: none">
                                <button class="btn primary" style="padding: 14px 18px; display: flex; justify-content: center; align-items: center; gap: 15px;">
                                    <i class="fa fa-plus" aria-hidden="true"></i>    
                                    Publicar nueva oferta
                                </button>
                            </a>
    
                            {{-- <button class="btn secondary">Filtros</button> --}}
                        </div>
                    </div>
                </div>
            </header>
    
            <main class="table-container">
                <table id="myTable">
                    <thead>
                        <div class="search-container">
                            <label for="searchTable">Rechercher:</label>
                            <input type="text" id="searchTable" placeholder="Rechercher dans toutes les colonnes...">
                        </div>
                        <tr>
                            <th>Roles</th>
                            <th>Solicitado por</th>
                            <th>Estado</th>
                            <th>Fecha de envío</th>
                            <th>Fecha de publ.</th>
                            <th>Tipo de empleo</th>
                            {{-- <th>Candidatos</th> --}}
                            {{-- <th>Puestos cubiertos</th> --}}
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

                                $company = DB::table('companies')
                                                ->where('id', $offer->id_company)
                                                ->value('name');
                            @endphp
                            <tr>
                                <td>{{ $offer->title }}</td>
                                <td>
                                    {{ $offer->id_company == 0 ? 'Admin' : $company}}
                                </td>
                                <td>
                                    <span class="badge {{ $offerStatus == 'Revision' ? 'Revision' : '' }} {{ $offerStatus == 'Publicada' ? 'Publicada' : '' }} {{ $offerStatus == 'Cerrada' ? 'Cerrada' : '' }}">
                                         {{ $offerStatus ?? 'Sin estado' }} 
                                    </span>
                                </td>
                                <td>{{ $offer->created_at->format('Y-m-d') }}</td>
                                <td>{{ $offer->publication_date ? $offer->publication_date->format('Y-m-d') :'Sin fecha' }}</td>
                                <td style="height: 69px;" class="work-type-badge-container"><span class="work-type-badge">{{ $offer->work_type }}</span></td>
                                <td class="action-column">
                                    <div class="dropdown-container">
                                        <i class="fa-solid fa-ellipsis dropdown-trigger"></i>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('administration.view.offer', ['id' => $offer->id]) }}" class="dropdown-item">
                                                Ver solicitud
                                            </a>
                                            <a href="{{ route('administration.companies.offers.view.applications', ['id' => $offer->id]) }}" class="dropdown-item">Ver aplicantes</a>
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
                    <div class="card" data-offer-id="{{ $offer->id }}">

                        <!-- Titre positionné en haut à gauche -->
                        <p class="mob-status">
                            <span class="badge {{ $offerStatus == 'Revision' ? 'Revision' : '' }} {{ $offerStatus == 'Publicada' ? 'Publicada' : '' }} {{ $offerStatus == 'Cerrada' ? 'Cerrada' : '' }}">
                                {{ $offerStatus ?? 'Sin estado' }} 
                            </span>
                        </p>
                        
                        <h4>{{ $offer->title }}</h4>
            
                        <p class="p-candidatures" style="text-align: left; margin-top: 52px; margin-bottom: 52px"> </p>
            
                        <!-- Positionner le work-type-badge en haut à droite -->
                        <span class="work-type-badge-2">{{ $offer->work_type }}</span>
            
                        <!-- Date "Fecha de Envío" en bas à droite -->
                        <p class="fecha-envio"><strong>Fecha de Envío:</strong> {{ $offer->created_at->format('Y-m-d') }}</p>
            
                        <!-- Date "Fecha de Publicación" en bas à gauche -->
                        <p class="fecha-publicacion"><strong>Fecha de Publicación:</strong> {{$offer->publication_date ? $offer->publication_date->format('Y-m-d')  : 'Sin fecha'}}</p>
                                        
                        <button class="view-details" data-offer-id="{{ $offer->id }}">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <!-- Menu contextuel intégré dans chaque carte -->
                        <div class="context-menu">
                            <a style="text-decoration: none;" href="{{ route('administration.view.offer', ['id' => $offer->id]) }}">
                                <button class="menu-item view">Ver solicitud</button>
                            </a>
                            <a style="text-decoration: none; padding: 0;" href="{{ route('administration.companies.offers.view.applications', ['id' => $offer->id]) }}" class="menu-item" data-offer-id="{{ $offer->id }}">
                                <button style="" class="menu-item view">Ver aplicantes</button>
                            </a>
                        </div>
                    </div>
                    <div style="height: 10px"></div>
                @endforeach
            </div>


            {{-- @if (@isset($offer))
                <template id="contextMenu">
                    <div class="context-menu">
                        <button class="menu-item view">
                            <a href="{{ route('administration.view.offer', ['id' => $offer->id]) }}" class="dropdown-item">
                                Ver solicitud
                            </a>
                        </button>
                        <button class="menu-item update">Ver solicitud</button>
                        <a href="#" 
                            class="dropdown-item text-danger delete-offer" 
                            data-offer-id="{{ $offer->id }}">
                            <button class="menu-item close">Ver aplicantes</button>
                        </a>
                    </div>
                </template>       
            @else
                 
            @endif --}}
                 
            
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
                    document.querySelectorAll('.view-details').forEach(button => {
                        button.addEventListener('click', function(e) {
                            e.stopPropagation();
                            
                            // Trouve le menu contextuel dans la même carte
                            const contextMenu = this.closest('.card').querySelector('.context-menu');
                            
                            // Ferme tous les autres menus ouverts
                            document.querySelectorAll('.context-menu.active').forEach(menu => {
                                if (menu !== contextMenu) {
                                    menu.classList.remove('active');
                                }
                            });
                            
                            // Toggle le menu actuel
                            contextMenu.classList.toggle('active');
                            
                            // Position du menu
                            contextMenu.style.top = '40px';
                            contextMenu.style.right = '0';
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