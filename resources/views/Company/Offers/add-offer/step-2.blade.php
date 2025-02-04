@extends('layouts.company')

@section('title', 'Add-Offer-2')

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
        <link rel="stylesheet" href="{{ asset('css/Company/add-offer-2.css') }}">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            
            <header class="s-1-header">
                <button class="back-button" style="color: #25324B;"> 
                    {{-- <a style="color: #000;" href="{{ route('company.my.offers.steep.one') }}">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> 
                    </a> --}}
                    Publicar un empleo
                </button>
            </header>
            
            <div class="steps-container">
                <div class="step">
                    <div class="step-icon-active">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                          </svg>                          
                    </div>
                    <div class="step-info">
                        <span class="step-number-active">paso 1/3</span>
                        <span class="step-title">Información Básica</span>
                    </div>
                </div>
                <div class="step active">
                    <div class="step-icon-active">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                            <path d="M9.5 5.01825L7.5 5.01694C6.96957 5.01659 6.46072 5.22697 6.0854 5.6018C5.71008 5.97662 5.49904 6.48519 5.49869 7.01562L5.49081 19.0156C5.49046 19.5461 5.70084 20.0549 6.07567 20.4302C6.4505 20.8055 6.95907 21.0166 7.4895 21.0169L17.4895 21.0235C18.0199 21.0238 18.5288 20.8135 18.9041 20.4386C19.2794 20.0638 19.4905 19.5552 19.4908 19.0248L19.4987 7.02481C19.499 6.49438 19.2887 5.98553 18.9138 5.61021C18.539 5.2349 18.0304 5.02385 17.5 5.0235L15.5 5.02219" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13.5 3.02216L11.5 3.02084C10.3954 3.02012 9.49941 3.91496 9.49869 5.01953C9.49796 6.1241 10.3928 7.02012 11.4974 7.02084L13.4974 7.02216C14.6019 7.02288 15.498 6.12804 15.4987 5.02347C15.4994 3.9189 14.6046 3.02288 13.5 3.02216Z" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9.49609 12.0195L9.50609 12.0195" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13.4961 12.0195L15.4961 12.0208" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9.49219 16.0195L9.50219 16.0195" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13.4922 16.0195L15.4922 16.0208" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="step-info">
                        <span class="step-number">paso 2/3</span>
                        <span class="step-title">descripción</span>
                    </div>
                </div>
                <div class="step">
                    <div class="step-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                            <path d="M20.5391 8.02678L4.53906 8.01628C3.98678 8.01592 3.53877 8.46334 3.53841 9.01562L3.53709 11.0156C3.53673 11.5679 3.98415 12.0159 4.53644 12.0163L20.5364 12.0268C21.0887 12.0271 21.5367 11.5797 21.5371 11.0274L21.5384 9.02744C21.5388 8.47515 21.0913 8.02714 20.5391 8.02678Z" stroke="#7C8493" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12.5391 8.01953L12.5305 21.0195" stroke="#7C8493" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M19.5352 12.0248L19.5306 19.0248C19.5302 19.5552 19.3192 20.0638 18.9438 20.4386C18.5685 20.8135 18.0597 21.0238 17.5292 21.0235L7.52925 21.0169C6.99882 21.0166 6.49025 20.8055 6.11542 20.4302C5.74059 20.0549 5.53021 19.5461 5.53056 19.0156L5.53516 12.0156" stroke="#7C8493" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8.03578 8.0177C7.37274 8.01727 6.73703 7.75346 6.26849 7.28431C5.79996 6.81516 5.53699 6.1791 5.53742 5.51606C5.53786 4.85302 5.80167 4.21731 6.27081 3.74878C6.73996 3.28024 7.37602 3.01727 8.03906 3.0177C9.00376 3.00153 9.94879 3.47022 10.7509 4.36264C11.553 5.25507 12.175 6.52982 12.5358 8.02066C12.8985 6.5303 13.5221 5.25636 14.3254 4.36499C15.1287 3.47362 16.0744 3.00617 17.0391 3.02361C17.7021 3.02404 18.3378 3.28785 18.8063 3.757C19.2749 4.22615 19.5379 4.86221 19.5374 5.52525C19.537 6.18829 19.2732 6.824 18.804 7.29254C18.3349 7.76107 17.6988 8.02404 17.0358 8.02361" stroke="#7C8493" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="step-info">
                        <span class="step-number">paso 3/3</span>
                        <span class="step-title">Beneficios</span>
                    </div>
                </div>
            </div>


            <main class="form-container">
                <form method="post" action="{{ route('company.post.job.step.twoo') }}">
                    @csrf
                    <h1 class="s2-title">Detalles</h1>
                    <p class="s2-subtitle">Añada la descripción de la oferta, las responsabilidades, conocimientos y habilidades, y lo Se valora</p>
            
                    <div class="form-section">
                        <h2 class="s2-h2">Descripción</h2>
                        <p class="section-subtitle">Una breve descripcion del cargo</p>
                        <div class="editor-container">
                            <textarea class="s2-textarea" id="description" name="description" placeholder="Introducir descripción del puesto" maxlength="500"></textarea>
                            <div class="char-count">
                                <span id="descriptionCount">0</span>/500 caracteres
                            </div>
                        </div>
                    </div>
            
                    <div class="form-section">
                        <h2 class="s2-h2">Responsabilidades</h2>
                        <p class="section-subtitle">Definir las principales responsabilidades del puesto.</p>
                        <div class="responsibilities-container">
                            <div class="editor-container">
                                <textarea class="s2-textarea" id="responsibility" placeholder="Introducir responsabilidades profesionales"></textarea>
                                <button type="button" id="addResponsibility" class="s2-add-btn">Añadir Responsabilidad</button>
                            </div>
                            <div id="responsibilitiesList" class="responsibilities-list"></div>
                            <div id="responsibilitiesListHidden" style="display: none;" class="responsibilities-list-hidden"></div>
                        </div>
                    </div>


                    <div class="form-section">
                        <h2 class="s2-h2">Conocimientos y Habilidades </h2>
                        <p class="section-subtitle">Definir las principales conocimientos y habilidades  del puesto.</p>
                        <div class="responsibilities-container">
                            <div class="editor-container">
                                <textarea class="s2-textarea" id="knowledge" placeholder="Introducir conocimientos y habilidades"></textarea>
                                <button type="button" id="addKnowledge" class="s2-add-btn">Añadir Conocimiento o Habilidad</button>
                            </div>
                            <div id="knowledgesList" class="knowledges-list"></div>
                            <div id="knowledgesListHidden" style="display: none;" class="knowledges-list-hidden"></div>
                        </div>
                    </div>


                    <div class="form-section">
                        <h2 class="s2-h2">Se valora</h2>
                        <p class="section-subtitle">Definir las habilidades que no son necesarias pero se valora que el candidato las tenga.</p>
                        <div class="se-valora-container">
                            <div class="editor-container">
                                <textarea class="s2-textarea" id="se-valora" placeholder="Introducir aspectos valorados"></textarea>
                                <button type="button" id="add-se-valora" class="s2-add-btn">Añadir Valoración</button>
                            </div>
                            <div id="se-valoraList" class="knowledges-list"></div>
                            <div id="se-valoraListHidden" style="display: none;" class="knowledges-hidden"></div>
                        </div>
                    </div>
            
                    <div id="modal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <p id="modalText"></p>
                        </div>
                    </div>
                    <button type="submit" class="s1-button-submit">Siguiente</button>
                </form>
            </main>
            
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
    document.addEventListener('DOMContentLoaded', () => {
        const description = document.getElementById('description');
        const descriptionCount = document.getElementById('descriptionCount');
        const responsibility = document.getElementById('responsibility');
        const addResponsibilityBtn = document.getElementById('addResponsibility');
        const responsibilitiesList = document.getElementById('responsibilitiesList');
        const responsibilitiesListHidden = document.getElementById('responsibilitiesListHidden');
        const modal = document.getElementById('modal');
        const modalText = document.getElementById('modalText');
        const closeModal = document.querySelector('.close');

        // Update description character count
        description.addEventListener('input', () => {
            descriptionCount.textContent = description.value.length;
        });

        // Add responsibility
        addResponsibilityBtn.addEventListener('click', () => {
            const text = responsibility.value.trim();
            if (text) {
                addResponsibilityItem(text);
                responsibility.value = '';
            }
        });

        // Close modal
        closeModal.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });

        function addResponsibilityItem(text) {
            const item = document.createElement('div');
            const hiddenItem = document.createElement('input');
            hiddenItem.type = 'text';
            hiddenItem.name ='responsibilities[]';
            hiddenItem.value = text;

            item.className = 'responsibility-item';

            const truncatedText = text.length > 100 ? text.substring(0, 100) + '...' : text;
            
            const textSpan = document.createElement('span');
            textSpan.className = 'responsibility-text';
            textSpan.textContent = truncatedText;
            textSpan.addEventListener('click', () => {
                modalText.textContent = text;
                modal.style.display = 'block';
            });

            const deleteBtn = document.createElement('button');
            deleteBtn.className = 'delete-btn';
            deleteBtn.textContent = 'Borrar';
            deleteBtn.addEventListener('click', () => {
                item.remove();
                hiddenItem.remove();
            });

            item.appendChild(textSpan);
            item.appendChild(deleteBtn);
            responsibilitiesList.appendChild(item);
            responsibilitiesListHidden.appendChild(hiddenItem)
        }
    });
</script>






<script>
    document.addEventListener('DOMContentLoaded', () => {
        const knowledge = document.getElementById('knowledge');
        const addKnowledgeBtn = document.getElementById('addKnowledge');
        const knowledgesList = document.getElementById('knowledgesList');
        const knowledgesListHidden = document.getElementById('knowledgesListHidden');
        const modal = document.getElementById('modal');
        const modalText = document.getElementById('modalText');
        const closeModal = document.querySelector('.close');

        // Add responsibility
        addKnowledgeBtn.addEventListener('click', () => {
            const text = knowledge.value.trim();
            if (text) {
                addKnowledgeItem(text);
                knowledge.value = '';
            }
        });

        function addKnowledgeItem(text) {
            const item = document.createElement('div');
            item.className = 'knowledge-item';
        
            const hiddenItem = document.createElement('input');
            hiddenItem.type = 'text';
            hiddenItem.name ='knowledges[]';
            hiddenItem.value = text;


            const truncatedText = text.length > 100 ? text.substring(0, 100) + '...' : text;
            
            const textSpan = document.createElement('span');
            textSpan.className = 'knowledge-text';
            textSpan.textContent = truncatedText;
            textSpan.addEventListener('click', () => {
                modalText.textContent = text;
                modal.style.display = 'block';
            });

            const deleteBtn = document.createElement('button');
            deleteBtn.className = 'delete-btn';
            deleteBtn.textContent = 'Borrar';
            deleteBtn.addEventListener('click', () => {
                item.remove();
                hiddenItem.remove();
            });

            item.appendChild(textSpan);
            item.appendChild(deleteBtn);
            knowledgesList.appendChild(item);
            knowledgesListHidden.appendChild(hiddenItem);
        }
    });
</script>







<script>
    document.addEventListener('DOMContentLoaded', () => {
        const seValora = document.getElementById('se-valora');
        const addSeValoraBtn = document.getElementById('add-se-valora');
        const SeValoraList = document.getElementById('se-valoraList');
        const SeValoraListHidden = document.getElementById('se-valoraListHidden');
        const modal = document.getElementById('modal');
        const modalText = document.getElementById('modalText');
        const closeModal = document.querySelector('.close');

        // Add responsibility
        addSeValoraBtn.addEventListener('click', () => {
            const text = seValora.value.trim();
            if (text) {
                addSeValoraItem(text);
                seValora.value = '';
            }
        });

        function addSeValoraItem(text) {
            const item = document.createElement('div');
            item.className = 'se-valora-item';

            const hiddenItem = document.createElement('input');
            hiddenItem.type = 'text';
            hiddenItem.name ='se-valora[]';
            hiddenItem.value = text;

            const truncatedText = text.length > 100 ? text.substring(0, 100) + '...' : text;
            
            const textSpan = document.createElement('span');
            textSpan.className = 'add-se-valora-text';
            textSpan.textContent = truncatedText;
            textSpan.addEventListener('click', () => {
                modalText.textContent = text;
                modal.style.display = 'block';
            });

            const deleteBtn = document.createElement('button');
            deleteBtn.className = 'delete-btn';
            deleteBtn.textContent = 'Borrar';
            deleteBtn.addEventListener('click', () => {
                item.remove();
                hiddenItem.remove();
            });

            item.appendChild(textSpan);
            item.appendChild(deleteBtn);
            SeValoraList.appendChild(item);
            SeValoraListHidden.appendChild(hiddenItem);
        }
    });
</script>
    </body>
    </html>
@endsection