@extends('layouts.company')

@section('title', 'Add-Offer-1')

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
        <link rel="stylesheet" href="{{ asset('css/Company/edit-offer.css') }}">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body>
        
        <div class="conta" style=" padding: 12px 2px;">
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
            
            
            <header class="h">
                <div class="job-header">
                    <div class="job-title-section">
                        <h1>{{$offer->title}}</h1>
                        <p class="location">{{$offer->place}} • {{$offer->work_type}}</p>
                    </div>
                    <div class="action-buttons">
                        {{-- <button class="share-btn" id="shareBtn">
                            <i class="fa fa-share-alt" aria-hidden="true"></i>
                        </button> --}}
                        <button onclick="document.getElementById('jobForm').submit()" class="apply-btn">Guardar informacion</button>
                    </div>
                </div>
            </header>
    
            <main class="form-container">
                
                <form id="jobForm" class="form" method="post" action="{{ route('company.edit.offer', ['id' => $offer->id]) }}">
                    @csrf
                    <input type="hidden" name="offer_id" value="{{$offer->id}}">
                    <div class="form-group">
                        <label class="form-label" for="jobTitle">Título</label>
                        <span class="form-subtitle">Los títulos de trabajo deben describir un puesto</span>
                        <input class="form-input c-no-p" type="text" id="jobTitle" name="jobTitle" value="{{$offer->title}}" placeholder="Solution Architect" maxlength="20">
                        <span class="form-hint">Máximo 20 caracteres</span>
                    </div>
    
                    <div class="form-group" class="position: relative;">
                        <label class="form-label" for="candidates">Número de candidatos solicitados</label>
                        <span class="form-subtitle">Elige el numero de candidatos que buscas incorporar</span>
                        <select class="form-select" id="candidates" name="candidates">
                            <option {{$offer->nbr_candidat_max == '1' ? 'selected' : ''  }} value="1">1</option>
                            <option {{$offer->nbr_candidat_max == '2' ? 'selected' : ''  }} value="2">2</option>
                            <option {{$offer->nbr_candidat_max == '3' ? 'selected' : ''  }} value="3">3</option>
                            <option {{$offer->nbr_candidat_max == '4' ? 'selected' : ''  }} value="4">4</option>
                            <option {{$offer->nbr_candidat_max == '5' ? 'selected' : ''  }} value="5">5</option>
                            <option {{$offer->nbr_candidat_max == '6' ? 'selected' : ''  }} value="6">6</option>
                            <option {{$offer->nbr_candidat_max == '7' ? 'selected' : ''  }} value="7">7</option>
                            <option {{$offer->nbr_candidat_max == '8' ? 'selected' : ''  }} value="8">8</option>
                            <option {{$offer->nbr_candidat_max == '9' ? 'selected' : ''  }} value="9">9</option>
                            <option {{$offer->nbr_candidat_max == '10' ? 'selected' : ''  }} value="10">10</option>
                        </select>
                        <span class="form-hint">Mínimo 1</span>
                    </div>
    
                    <div class="form-group">
                        <label class="form-label" for="location">Ubicacion</label>
                        <span class="form-subtitle">En caso de que la oferta sea en presencial o hibrida</span>
                        <input class="form-input c-no-p" type="text" id="location" name="location" value="{{$offer->place}}" placeholder="Navarra" maxlength="20">
                        <span class="form-hint">Máximo 20 caracteres</span>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="deadline">Fecha límite de postulación</label>
                        <span class="form-subtitle">Indique la última fecha en la que los candidatos pueden postularse a esta oferta</span>
                        <input 
                            class="form-input c-no-p" 
                            style="cursor: pointer;" 
                            type="date" 
                            id="deadline" 
                            name="deadline" 
                            value="{{$offer->getRawOriginal('postulation_deadline')}}"
                            placeholder="DD/MM/YYYY" required>
                        <span class="form-hint">Seleccione una fecha válida</span>
                    </div>
                    
                    {{-- <div class="form-group">
                        <label class="form-label" for="deadline">Fecha límite de postulación</label>
                        <span class="form-subtitle">Indique la última fecha en la que los candidatos pueden postularse a esta oferta</span>
                        <input 
                            class="form-input c-no-p" 
                            style="cursor: pointer;" 
                            type="date" 
                            id="deadline" 
                            name="deadline" 
                            placeholder="DD/MM/YYYY" 
                            value="{{ $offer->postulation_deadline ?? '2025-02-13' }}"
                            required>
                        <span class="form-hint">Seleccione una fecha válida</span>
                    </div> --}}
                    
    
                    <div class="form-group">
                        <label class="form-label">Tipo de empleo</label>
                        <span class="form-subtitle">Puede seleccionar un tipo de empleo</span>
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input {{$offer->work_type == "Tiempo completo" ? 'checked' : '' }} class="checkbox-input" value="Tiempo completo" type="checkbox" name="jobType" value="fullTime">
                                Tiempo completo
                            </label>
                            <label class="checkbox-label">
                                <input {{$offer->work_type == "Media jornada" ? 'checked' : '' }} class="checkbox-input" value="Media jornada" type="checkbox" name="jobType" value="partTime">
                                Media jornada
                            </label>
                            <label class="checkbox-label">
                                <input {{$offer->work_type == "Remoto" ? 'checked' : '' }} class="checkbox-input" value="Remoto" type="checkbox" name="jobType" value="remote">
                                Remoto
                            </label>
                            <label class="checkbox-label">
                                <input {{$offer->work_type == "Hibrido" ? 'checked' : '' }} class="checkbox-input" value="Hibrido" type="checkbox" name="jobType" value="hybrid">
                                Híbrido
                            </label>
                            <label class="checkbox-label">
                                <input {{$offer->work_type == "Jornada intensiva" ? 'checked' : '' }} class="checkbox-input" value="Jornada intensiva" type="checkbox" name="jobType" value="intensive">
                                Jornada intensiva
                            </label>
                        </div>
                    </div>

                    <div class="s1-form-section">
                        <label>Salario anual</label>
                        <p class="s1-form-description">Por favor, especifique la escala salarial estimada para el puesto.</p>
                        <div class="s1-salary-section">
                            <div class="s1-salary-input-container">
                                <div class="s1-salary-input-group">
                                    <span>€</span>
                                    <input type="number" id="s1-minSalary" name="s1-minSalary" value="{{$offer->starting_salary}}" max="200000">
                                    <span>a</span>
                                </div>
                                <div class="s1-salary-input-group">
                                    <span>€</span>
                                    <input type="number" id="s1-maxSalary" name="s1-maxSalary" value="{{$offer->final_salary}}" max="200000">
                                </div>
                            </div>
                            <div id="s1-salarySlider" class="s1-slider-section"></div>
                        </div>
                    </div>
            
                    <div class="s1-form-section">
                        <label>Categorías</label>
                        <p class="s1-form-description">Puede seleccionar varias categorías de trabajo</p>
                        <div class="s1-dropdown-wrapper">
                            <select id="s1-jobCategories" name="job_category">
                                @foreach($categories as $category)
                                    <option value="{{ $category->name }}" {{$offer->category == $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>                            
                        </div>
                    </div>
            
                    <div class="s1-form-section">
                        <label>Idiomas y Skills</label>
                        <p class="s1-form-description">Añadir los idiomas y cualificaciones necesarias para el puesto</p>
                        <div class="s1-skills-section">
                            <input type="text" id="s1-skillInput" placeholder="Add a skill">
                            <button type="button" id="s1-addSkill" class="s1-button-add">añadir</button>
                        </div>
                        <div class="skills-hidden-inputs" style="display: ;" id="skills-hidden-inputs"></div>
                        <div id="s1-skillTags" class="s1-tags-container"></div>
                    </div>

                    <div class="form-section">
                        <h2 class="s2-h2">Descripción</h2>
                        <p class="section-subtitle">Una breve descripcion del cargo</p>
                        <div class="editor-container">
                            <textarea class="s2-textarea" id="description" name="description" placeholder="Introducir descripción del puesto" maxlength="500">{{$aboutOffer->description ?? ''}}</textarea>
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

                    <div class="benefits-header">
                        <h2>Beneficios y ventajas</h2>
                        <p class="subtitle">Animar a más personas a que se presenten compartiendo las atractivas recompensas y beneficios que ofrece a sus empleados</p>
                    </div>
                    
                    <button type="button" class="add-benefit-btn" data-add-benefit>
                        <span class="plus-icon">+</span>
                        <span class="btn-text">Añadir beneficios</span>
                    </button>
            
                    <div class="benefits-grid" data-benefits-container>
                    </div>
            
                    <button style="display: none;" type="submit" class="s1-button-submit">Siguiente</button>
                </form>

            </main>
            
            <div class="modal-overlay-edit">
                <div class="modal-edit">
                    <div class="modal-header-edit">
                        <h2 class="modal-title-edit">Beneficios y ventajas</h2>
                        <button class="modal-close-edit" aria-label="Close modal">×</button>
                    </div>
                    <form class="modal-form-edit">
                        <div class="modal-body-edit">
                            <div class="form-group-edit">
                                <label class="form-label-edit" for="benefit-title">Título</label>
                                <input 
                                    type="text" 
                                    id="benefit-title" 
                                    class="form-input-edit" 
                                    placeholder="Ingrese el título del beneficio"
                                    required
                                >
                            </div>
                            <div class="form-group-edit">
                                <label class="form-label-edit" for="benefit-description">Descripción</label>
                                <textarea 
                                    id="benefit-description" 
                                    class="form-input-edit form-textarea-edit"
                                    placeholder="Introducir Conocimientos y Habilidades" 
                                    maxlength="100" 
                                    required
                                ></textarea>
                                <div class="character-count-edit">0 / 100</div>
                            </div>
                        </div>
                        <div class="modal-footer-edit">
                            <button type="submit" class="save-btn-edit">Guardar información</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>          
        
        <script>
            const checkboxes = document.querySelectorAll('.checkbox-input');

            checkboxes.forEach((checkbox) => {
              checkbox.addEventListener('click', () => {
                
                checkboxes.forEach((otherCheckbox) => {
                  if (otherCheckbox !== checkbox) {
                    otherCheckbox.checked = false;
                  }
                });
              });
            });
          </script>   
          
          <script>
            class RangeSlider {
                constructor(container, options) {
                    this.container = container;
                    this.options = {
                        min: options.min || 0,
                        max: options.max || 100,
                        minInput: options.minInput,
                        maxInput: options.maxInput,
                        onChange: options.onChange || (() => {})
                    };

                    this.init();
                }

                init() {
                    // Create slider elements
                    this.track = document.createElement('div');
                    this.track.className = 's1-slider-track';
                    
                    this.minHandle = document.createElement('div');
                    this.minHandle.className = 's1-slider-handle';
                    
                    this.maxHandle = document.createElement('div');
                    this.maxHandle.className = 's1-slider-handle';

                    this.container.appendChild(this.track);
                    this.container.appendChild(this.minHandle);
                    this.container.appendChild(this.maxHandle);

                    // Initialize positions
                    this.updateHandlePosition(this.minHandle, this.options.minInput.value);
                    this.updateHandlePosition(this.maxHandle, this.options.maxInput.value);
                    this.updateTrack();

                    // Setup event listeners
                    this.setupDragHandling(this.minHandle, this.options.minInput);
                    this.setupDragHandling(this.maxHandle, this.options.maxInput);
                    
                    // Listen for input changes
                    this.options.minInput.addEventListener('change', () => {
                        this.updateHandlePosition(this.minHandle, this.options.minInput.value);
                        this.updateTrack();
                    });

                    this.options.maxInput.addEventListener('change', () => {
                        this.updateHandlePosition(this.maxHandle, this.options.maxInput.value);
                        this.updateTrack();
                    });
                }

                setupDragHandling(handle, input) {
                    let isDragging = false;
                    let startX, startLeft;

                    handle.addEventListener('mousedown', (e) => {
                        isDragging = true;
                        startX = e.clientX;
                        startLeft = handle.offsetLeft;
                        document.addEventListener('mousemove', onMouseMove);
                        document.addEventListener('mouseup', onMouseUp);
                    });

                    const onMouseMove = (e) => {
                        if (!isDragging) return;
                        
                        const delta = e.clientX - startX;
                        const newLeft = Math.max(0, Math.min(this.container.offsetWidth, startLeft + delta));
                        const percentage = newLeft / this.container.offsetWidth;
                        const value = Math.round(this.options.min + percentage * (this.options.max - this.options.min));
                        
                        input.value = value;
                        this.updateHandlePosition(handle, value);
                        this.updateTrack();
                        this.options.onChange();
                    };

                    const onMouseUp = () => {
                        isDragging = false;
                        document.removeEventListener('mousemove', onMouseMove);
                        document.removeEventListener('mouseup', onMouseUp);
                    };
                }

                updateHandlePosition(handle, value) {
                    const percentage = (value - this.options.min) / (this.options.max - this.options.min);
                    handle.style.left = `${percentage * 100}%`;
                }

                updateTrack() {
                    const minPercentage = (this.options.minInput.value - this.options.min) / (this.options.max - this.options.min);
                    const maxPercentage = (this.options.maxInput.value - this.options.min) / (this.options.max - this.options.min);
                    
                    this.track.style.left = `${minPercentage * 100}%`;
                    this.track.style.width = `${(maxPercentage - minPercentage) * 100}%`;
                }
            }

            document.addEventListener('DOMContentLoaded', () => {
                const skillInput = document.getElementById('s1-skillInput');
                const addSkillBtn = document.getElementById('s1-addSkill');
                const skillTags = document.getElementById('s1-skillTags');
                const skillsHiddenInputs = document.getElementById('skills-hidden-inputs');
                const form = document.getElementById('s1-jobForm');
                const minSalary = document.getElementById('s1-minSalary');
                const maxSalary = document.getElementById('s1-maxSalary');

                // Initialize range slider
                const slider = new RangeSlider(document.getElementById('s1-salarySlider'), {
                    min: 0,
                    max: 200000,
                    minInput: minSalary,
                    maxInput: maxSalary,
                    onChange: () => {
                        // Additional handling if needed
                    }
                });

                // Rest of your existing code...
                addSkillBtn.addEventListener('click', () => {
                    const skill = skillInput.value.trim();
                    if (skill) {
                        addSkillTag(skill);
                        skillInput.value = '';
                    }
                });

                skillInput.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const skill = skillInput.value.trim();
                        if (skill) {
                            addSkillTag(skill);
                            skillInput.value = '';
                        }
                    }
                });

                function addSkillTag(skill) {
                    const tag = document.createElement('div');
                    tag.className = 's1-skill-tag';
                    tag.innerHTML = `
                        ${skill}
                        <button type="button" class="s1-remove-tag">×</button>
                    `;


                    const hiddenTag = document.createElement('input');
                    hiddenTag.type = 'hidden';
                    hiddenTag.name = 'skills[]';
                    hiddenTag.value = skill
                    skillsHiddenInputs.appendChild(hiddenTag);
                    
                    tag.querySelector('.s1-remove-tag').addEventListener('click', () => {
                        tag.remove();
                        hiddenTag.remove();
                    });

                    skillTags.appendChild(tag);
                }



                    @foreach($skills as $skill)
                        addSkillTag("{{ $skill->skill_name }}");
                    @endforeach
                
                

                // form.addEventListener('submit', (e) => {
                //     e.preventDefault();
                //     const formData = {
                //         minSalary: minSalary.value,
                //         maxSalary: maxSalary.value,
                //         category: document.getElementById('s1-jobCategories').value,
                //         skills: Array.from(skillTags.querySelectorAll('.s1-skill-tag'))
                //             .map(tag => tag.textContent.trim().slice(0, -1))
                //     };
                //     console.log('Form Data:', formData);
                // });

            });  
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


                    @foreach($responsibilities as $responsability)
                        addResponsibilityItem("{{ $responsability->responsibility }}");
                    @endforeach
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

                    @foreach($knowledges as $knowledge)
                        addKnowledgeItem("{{ $knowledge->knowledge }}");
                    @endforeach
                    
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

                    @foreach($niceToHaves as $niceToHave)
                        addSeValoraItem("{{ $niceToHave->nice_to_have }}");
                    @endforeach
                });
            </script>


            <script>
                const existingBenefits = @json($benefits);

                let i = 0;
                document.addEventListener('DOMContentLoaded', () => {
                    // Vérifier si des avantages existent et les afficher
                    if (existingBenefits && Array.isArray(existingBenefits)) {
                        existingBenefits.forEach(b => {
                            const { title, benefit } = b;

                            if (title && benefit) {
                                // Créer une nouvelle carte d'avantage
                                const benefitCard = document.createElement('div');
                                benefitCard.classList.add('benefit-card');
                                benefitCard.innerHTML = `
                                    <div class="checkmark-circle">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M20 6L9 17L4 12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <div class="benefit-content">
                                        <h3>${title}</h3>
                                        <p>${benefit}</p>
                                    </div>
                                    <button class="remove-btn" aria-label="Remove benefit">×</button>
                                `;

                                // Ajouter un champ caché pour le titre
                                const hiddenTitle = document.createElement('input');
                                hiddenTitle.type = 'hidden';
                                hiddenTitle.name = 'benefits_titles[]';
                                hiddenTitle.value = title;

                                // Ajouter un champ caché pour la description
                                const hiddenDescription = document.createElement('input');
                                hiddenDescription.type = 'hidden';
                                hiddenDescription.name = 'benefits_descriptions[]';
                                hiddenDescription.value = benefit;
                                    
                                hiddenTitle.dataset.benefitId = Date.now() + i;
                                hiddenDescription.dataset.benefitId = hiddenTitle.dataset.benefitId;
                                benefitCard.dataset.benefitId = hiddenTitle.dataset.benefitId;
                                
                                i = i + 1;
                                // Ajouter la carte au conteneur
                                benefitsContainer.appendChild(benefitCard);
                                jobForm.appendChild(hiddenTitle);
                                jobForm.appendChild(hiddenDescription);
                            }
                        });
                    }
                });

                
            </script>


            <script>
                // Récupérer les éléments du DOM
                    const addBenefitButton = document.querySelector('.add-benefit-btn');
                    const modalOverlay = document.querySelector('.modal-overlay-edit');
                    const modalCloseButton = document.querySelector('.modal-close-edit');

                    const textarea = document.querySelector('#benefit-description');
                    const charCount = document.querySelector('.character-count-edit');


                    textarea.addEventListener('input', () => {
                            const current = textarea.value.length;
                            charCount.textContent = `${current} / 100`;
                        });


                    // Fonction pour ouvrir le modal
                    addBenefitButton.addEventListener('click', () => {
                    modalOverlay.classList.add('active');
                    });

                    // Fonction pour fermer le modal
                    modalCloseButton.addEventListener('click', () => {
                    modalOverlay.classList.remove('active');
                    });

                    // Fermer le modal en cliquant à l'extérieur
                    modalOverlay.addEventListener('click', (event) => {
                    if (event.target === modalOverlay) {
                        modalOverlay.classList.remove('active');
                    }
                    });

                    // Récupérer les éléments du DOM
                    const modalForm = document.querySelector('.modal-form-edit');
                    const benefitsContainer = document.querySelector('[data-benefits-container]');
                    const jobForm = document.getElementById('jobForm');

                    // Fonction pour ajouter un nouvel élément
                    modalForm.addEventListener('submit', (event) => {
                        event.preventDefault(); // Empêcher le rechargement de la page

                        // Récupérer les valeurs des champs
                        const title = document.querySelector('#benefit-title').value.trim();
                        const description = document.querySelector('#benefit-description').value.trim();

                        if (title && description) {
                            // Créer une nouvelle carte d'avantage
                            const benefitCard = document.createElement('div');
                            benefitCard.classList.add('benefit-card');
                            benefitCard.innerHTML = `
                            <div class="checkmark-circle">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 6L9 17L4 12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="benefit-content">
                                <h3>${title}</h3>
                                <p>${description}</p>
                            </div>
                            <button class="remove-btn" aria-label="Remove benefit">×</button>
                            `;

                            // Ajouter un champ caché pour le titre
                            const hiddenTitle = document.createElement('input');
                            hiddenTitle.type = 'hidden';
                            hiddenTitle.name = 'benefits_titles[]';
                            hiddenTitle.value = title;
                            hiddenTitle.dataset.benefitId = Date.now(); // Identifiant unique pour cet avantage
                            jobForm.appendChild(hiddenTitle);

                            // Ajouter un champ caché pour la description
                            const hiddenDescription = document.createElement('input');
                            hiddenDescription.type = 'hidden';
                            hiddenDescription.name = 'benefits_descriptions[]';
                            hiddenDescription.value = description;
                            hiddenDescription.dataset.benefitId = hiddenTitle.dataset.benefitId;
                            jobForm.appendChild(hiddenDescription);

                            // Associer l'identifiant unique à la carte pour suppression future
                            benefitCard.dataset.benefitId = hiddenTitle.dataset.benefitId;

                            // Ajouter la carte au conteneur
                            benefitsContainer.appendChild(benefitCard);

                            // Réinitialiser le formulaire et fermer le modal
                            modalForm.reset();
                            modalOverlay.classList.remove('active');
                        } else {
                                alert('Veuillez remplir tous les champs avant de soumettre.');
                        }
                    });

                    // Gestion de la suppression des éléments
                    benefitsContainer.addEventListener('click', (event) => {
                    if (event.target.classList.contains('remove-btn')) {
                        const benefitCard = event.target.closest('.benefit-card');
                        if (benefitCard) {
                        const benefitId = benefitCard.dataset.benefitId;

                        // Supprimer les champs cachés associés
                        const hiddenInputs = jobForm.querySelectorAll(`[data-benefit-id="${benefitId}"]`);
                        hiddenInputs.forEach((input) => input.remove());

                        // Supprimer la carte
                        benefitCard.remove();
                        hiddenTitle.remove();
                        hiddenDescription.remove();
                        }
                    }
                    });
            </script>

            <script>
                const salaryInputs = document.querySelectorAll('#s1-minSalary, #s1-maxSalary');

                salaryInputs.forEach(input => {
                    input.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter' || e.keyCode === 13) {
                            e.preventDefault();
                            // Optionnel : retirer le focus du champ
                            input.blur();
                        }
                    });
                });
            </script>


    </body>
    </html>
@endsection