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
        <link rel="stylesheet" href="{{ asset('css/Admin/companies.css') }}">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
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
            <div class="mpage-header">
                <div class="tab-controls">
                  <a href="{{route('administration.companies')}}">
                    <button class="tab {{$status == "todo" ? 'active' : ''}}">Todas</button>
                  </a>
                  <a href="{{route('administration.companies.new')}}">
                    <button class="tab {{$status == "open" ? 'active' : ''}}">Nuevas</button>
                  </a>
                  <a href="{{route('administration.companies.in.progres')}}">
                    <button class="tab {{$status == "process" ? 'active' : ''}}">En proceso</button>
                  </a>
                  <a href="{{route('administration.companies.homo')}}">
                    <button class="tab {{$status == "homo" ? 'active' : ''}}">Homologadas</button>
                  </a>
                </div>
                <div class="top-bar">
                    <div class="total">Total de empresas : {{ $companyCount }}</div>
                </div>
            </div>
          
           
            <div class="table-view">
              <table id="candidatesTable" class="display">
                  <thead>
                      <tr>
                          <th>Nombre de la empresa</th>
                          <th>Localización</th>
                          <th>Sector</th>
                          <th>Se unio el</th>
                          <th>Estado</th>
                          <th>está activo</th>
                          <th>Detalles</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($companies as $company)
                      <tr>
                          <td>
                              <div class="candidate">
                                  @php
                                      $personalPicturePath = 'images/companies_images/' . $company->personel_pic;
                                  @endphp
                                  @if ($company->personel_pic && file_exists(public_path($personalPicturePath)))
                                      <img style="background: #fff;" src="{{ asset($personalPicturePath) }}" alt="{{ $company->name }}" class="avatar">
                                  @else
                                      <img id="profile-image" src="{{ asset('images/companies_images/100x100.svg') }}" alt="{{ $company->name }}" class="avatar">
                                  @endif
                                  <span style="color: #25324B; font-size: 17px; font-weight: 600">{{ $company->name }}</span>
                              </div>
                          </td>
                          <td style="color: #25324B; font-size: 17px; font-weight: 600;">{{ $company->adress }}</td>
                          <td style="color: #25324B; font-size: 17px; font-weight: 600">
                                {{ DB::table('company_sectors')->where('id', $company->secteur_id)->value('name') }}
                            </td>
                          <td style="color: #25324B; font-size: 17px; font-weight: 600" data-order="{{ $company->created_at->timestamp }}">
                              {{ $company->created_at->format('d/m/Y') }}
                          </td>
                          <td>
                              <span class="badge {{ $company->status === 'Nueva' ? 'Nueva' : ''}} {{ $company->status === 'En proceso' ? 'proceso' : ''}} {{ $company->status === 'Homologada' ? 'Homologada' : ''}}">
                                  {{ $company->status}}
                              </span>
                          </td>
                          <td>
                              <span class="badge {{ $company->is_active === 'yes' ? 'actif' : ''}} {{ $company->is_active === 'no' ? 'inactif' : ''}}">
                                  {{ $company->is_active == 'yes' ? 'ACTIVO' : 'INACTIVO' }}
                              </span>
                          </td>
                          <td>
                            <a href="{{route('administration.companies.profile', ['id' => $company->id])}}">
                              <button class="view-btn">Ver</button></td>
                            </a>
                      </tr>
                      @endforeach
                  </tbody>
              </table>
          
              <!-- Afficher les liens de pagination -->
              <div class="pagination">
                  {{ $companies->links('pagination::custom_2') }}
              </div>
            
          </div>
            
            
          <div class="card-view">
            @foreach($companiesForMobile as $company)
            <div class="card">
                <div class="card-header">
                    @php
                        $personalPicturePath = 'images/companies_images/' . $company->personel_pic;
                    @endphp
                    @if ($company->personel_pic && file_exists(public_path($personalPicturePath)))
                        <img style="background: #fff;" src="{{ asset($personalPicturePath) }}" alt="{{ $company->name }}" class="avatar">
                    @else
                        <img id="profile-image" src="{{ asset('images/companies_images/100x100.svg') }}" alt="{{ $company->name }}" class="avatar">
                    @endif
                    <div class="card-title">
                        <h3>{{ $company->name }}</h3>
                        <span class="badge {{ $company->status === 'Nueva' ? 'Nueva' : ''}} {{ $company->status === 'En proceso' ? 'proceso' : ''}} {{ $company->status === 'Homologada' ? 'Homologada' : ''}}">
                            {{ $company->status }}
                        </span>
                    </div>
                </div>
                <div class="card-content">
                    <div class="info-row">
                        <span class="label">Localización:</span>
                        <span style="color: #25324B; font-size: 17px; font-weight: 600">{{ $company->adress }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Sector:</span>
                        <span style="color: #25324B; font-size: 17px; font-weight: 600">
                            {{ strtoupper(DB::table('company_sectors')->where('id', $company->secteur_id)->value('name')) }}
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="label">Se unio el:</span>
                        <span style="color: #25324B; font-size: 17px; font-weight: 600">{{ $company->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Está activo:</span>
                        <span class="badge {{ $company->is_active === 'yes' ? 'actif' : ''}} {{ $company->is_active === 'no' ? 'inactif' : ''}}">
                            {{ $company->is_active == 'yes' ? 'ACTIVO' : 'INACTIVO' }}
                        </span>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{route('administration.companies.profile', ['id' => $company->id])}}">
                        <button class="view-btn">Ver</button>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        </div>
          
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


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
                $(document).ready(function() {
                  $('#candidatesTable').DataTable({
                      language: {
                          url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
                          search: "Buscar:"
                      },
                      order: [[3, 'desc']],
                      columnDefs: [
                          { orderable: false, targets: [5] }
                      ],
                      responsive: true,
                      dom: 'frt',
                      initComplete: function(settings, json) {
                          $('.dataTables_filter').insertAfter('.total');
                      }
                  });
              });
            </script>


    </body>
    </html>
@endsection