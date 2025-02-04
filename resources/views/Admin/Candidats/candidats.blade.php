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
        <link rel="stylesheet" href="{{ asset('css/Admin/candidats.css') }}">
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
                  <a href="{{route('administration.candidats')}}">
                    <button class="tab {{$status == "todo" ? 'active' : ''}}">Todos</button>
                  </a>
                  <a href="{{route('administration.candidats.open')}}">
                    <button class="tab {{$status == "open" ? 'active' : ''}}">abierto a oportunidades</button>
                  </a>
                  <a href="{{route('administration.candidats.in.progres')}}">
                    <button class="tab {{$status == "process" ? 'active' : ''}}">En proceso</button>
                  </a>
                </div>
                <div class="top-bar">
                    <div class="total">Total Candidatos : {{ $CandidatCount }}</div>
                </div>
            </div>
          
           
            <div class="table-view">
              <table id="candidatesTable" class="display">
                  <thead>
                      <tr>
                          <th>Nombre del Candidato</th>
                          <th>Cargo actual/ultimo</th>
                          <th>Ubicacion</th>
                          <th>Se unio el</th>
                          <th>Estado</th>
                          <th>Detalles</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($candidats as $candidat)
                      <tr>
                          <td>
                              <div class="candidate">
                                  @php
                                      $personalPicturePath = 'images/candidats_images/' . $candidat->personal_picture_path;
                                  @endphp
                                  @if ($candidat->personal_picture_path && file_exists(public_path($personalPicturePath)))
                                      <img style="background: #fff;" src="{{ asset($personalPicturePath) }}" alt="{{ $candidat->first_name }}" class="avatar">
                                  @else
                                      <img id="profile-image" src="{{ asset('images/companies_images/100x100.svg') }}" alt="{{ $candidat->first_name }}" class="avatar">
                                  @endif
                                  <span style="color: #25324B; font-size: 17px; font-weight: 600">{{ $candidat->first_name }} {{ $candidat->last_name }}</span>
                              </div>
                          </td>
                          <td style="color: #25324B; font-size: 17px; font-weight: 600;">{{ $candidat->poste }}</td>
                          <td style="color: #25324B; font-size: 17px; font-weight: 600">{{ $candidat->adresse }}</td>
                          <td style="color: #25324B; font-size: 17px; font-weight: 600" data-order="{{ $candidat->created_at->timestamp }}">
                              {{ $candidat->created_at->format('d/m/Y') }}
                          </td>
                          <td>
                              <span class="badge {{ $candidat->priority === 'yes' ? 'open' : 'process' }}">
                                  {{ $candidat->priority === 'yes' ? 'ABIERTO A OPORTUNIDADES' : 'En proceso' }}
                              </span>
                          </td>
                          <td>
                            <a href="{{route('administration.view.candidat', ['id' => $candidat->id])}}">
                              <button class="view-btn">Ver</button></td>
                            </a>
                      </tr>
                      @endforeach
                  </tbody>
              </table>
          
              <!-- Afficher les liens de pagination -->
              <div class="pagination">
                  {{ $candidats->links('pagination::custom_2') }}
              </div>
            
          </div>
            
            
            <div class="card-view">
                @foreach($candidatsForMobile as $candidat)
                <div class="card">
                  <div class="card-header">
                    @php
                        $personalPicturePath = 'images/candidats_images/' . $candidat->personal_picture_path;
                    @endphp
                    @if ($candidat->personal_picture_path && file_exists(public_path($personalPicturePath)))
                        <img style="background: #fff;" src="{{ asset($personalPicturePath) }}" alt="{{ $candidat->first_name }}" class="avatar">
                    @else
                        <img id="profile-image" src="{{ asset('images/companies_images/100x100.svg') }}" alt="{{ $candidat->first_name }}" class="avatar">
                    @endif
                    <div class="card-title">
                      <h3>{{ $candidat->first_name }} {{ $candidat->last_name }}</h3>
                      <span class="badge {{ $candidat->priority === 'yes' ? 'open' : 'process' }}">
                        {{ $candidat->priority === 'yes' ? 'ABIERTO A OPORTUNIDADES' : 'En proceso' }}
                      </span>
                    </div>
                  </div>
                  <div class="card-content">
                    <div class="info-row">
                      <span class="label">Cargo:</span>
                      <span style="color: #25324B; font-size: 17px; font-weight: 600">{{ $candidat->poste }}</span>
                    </div>
                    <div class="info-row">
                      <span class="label">Ubicacion:</span>
                      <span style="color: #25324B; font-size: 17px; font-weight: 600">{{ $candidat->adresse }}</span>
                    </div>
                    <div class="info-row">
                      <span class="label">Se unio el:</span>
                      <span style="color: #25324B; font-size: 17px; font-weight: 600">{{ $candidat->created_at->format('d/m/Y') }}</span>
                    </div>
                  </div>
                  <div class="card-footer">
                    <a href="{{route('administration.view.candidat', ['id' => $candidat->id])}}">
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