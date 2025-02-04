@extends('layouts.admin')

@section('title', 'Categories Admin')

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
        <link rel="stylesheet" href="{{ asset('css/Admin/settings/categories.css') }}">
    </head>
    <body>
        
        <div class="contai" style="margin-top: -42px;">
    
            <div class="title-h2">Gestión de categorías</div>

            <!-- Formulaire d'ajout -->
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('administration.categories.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" placeholder="Descripción" required>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary" style="display: flex; gap: 9px;">
                                    <i class="fas fa-plus"></i> Añadir
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tableau des langues -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Descripción</th>
                                    <th style="text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr data-language-id="{{ $category->id }}">
                                        <td data-label="Description" style="text-align: center;">{{ $category->name }}</td>
                                        <td data-label="Actions" style="text-align: center;">
                                            {{-- <button type="button" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </button> --}}
                                            <button type="button" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        



        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            document.querySelectorAll('.btn-danger').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Récupérer l'ID depuis l'attribut data-language-id du tr parent
                    const categoryId = this.closest('tr').getAttribute('data-language-id');
                    

                    Swal.fire({
                        title: '¿Está seguro?',
                        text: "¡Esta acción es irreversible!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#EF4444',
                        cancelButtonColor: '#6B7280',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Utiliser l'ID récupéré dans l'URL
                            fetch(`/administration/categories/${categoryId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                    Swal.fire(
                                        '¡Eliminado!',
                                        'La categoría ha sido eliminada.',
                                        'success'
                                    ).then(() => {
                                        location.reload();
                                    });
                            })
                            .catch(error => {
                                Swal.fire(
                                    'Error',
                                    'Hay un problema al eliminar el categoría.',
                                    'error'
                                );
                            });
                        }
                    });
                });
            });
        </script>
        </body>
        </html>
    
    
    
@endsection