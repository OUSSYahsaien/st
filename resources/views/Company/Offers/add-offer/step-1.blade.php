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
        <link rel="stylesheet" href="{{ asset('css/Company/add-offer-1.css') }}">
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
                <button class="back-button"> 
                    {{-- <i class="fa fa-arrow-left" aria-hidden="true"></i>  --}}
                    Publicar un empleo</button>
            </header>
            
            <div class="steps-container">
                <div class="step active">
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
                <div class="step">
                    <div class="step-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                            <path d="M9.5 5.01825L7.5 5.01694C6.96957 5.01659 6.46072 5.22697 6.0854 5.6018C5.71008 5.97662 5.49904 6.48519 5.49869 7.01562L5.49081 19.0156C5.49046 19.5461 5.70084 20.0549 6.07567 20.4302C6.4505 20.8055 6.95907 21.0166 7.4895 21.0169L17.4895 21.0235C18.0199 21.0238 18.5288 20.8135 18.9041 20.4386C19.2794 20.0638 19.4905 19.5552 19.4908 19.0248L19.4987 7.02481C19.499 6.49438 19.2887 5.98553 18.9138 5.61021C18.539 5.2349 18.0304 5.02385 17.5 5.0235L15.5 5.02219" stroke="#7C8493" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13.5 3.02216L11.5 3.02084C10.3954 3.02012 9.49941 3.91496 9.49869 5.01953C9.49796 6.1241 10.3928 7.02012 11.4974 7.02084L13.4974 7.02216C14.6019 7.02288 15.498 6.12804 15.4987 5.02347C15.4994 3.9189 14.6046 3.02288 13.5 3.02216Z" stroke="#7C8493" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9.49609 12.0195L9.50609 12.0195" stroke="#7C8493" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13.4961 12.0195L15.4961 12.0208" stroke="#7C8493" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9.49219 16.0195L9.50219 16.0195" stroke="#7C8493" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13.4922 16.0195L15.4922 16.0208" stroke="#7C8493" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
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
                <div class="form-header">
                    <h1 class="form-title">Información básica</h1>
                    <p class="form-subtitle">Esta información no se mostrará públicamente</p>
                </div>

                <form id="jobForm" class="form" method="post" action="{{ route('company.post.job.step.one') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="jobTitle">Título</label>
                        <span class="form-subtitle">Los títulos de trabajo deben describir un puesto</span>
                        <input required class="form-input c-no-p" type="text" id="jobTitle" name="jobTitle" placeholder="Solution Architect" maxlength="20">
                        <span class="form-hint">Máximo 20 caracteres</span>
                    </div>
    
                    <div class="form-group" class="position: relative;">
                        <label class="form-label" for="candidates">Número de candidatos solicitados</label>
                        <span class="form-subtitle">Elige el numero de candidatos que buscas incorporar</span>
                        <select required class="form-select" id="candidates" name="candidates">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                        <span class="form-hint">Mínimo 1</span>
                    </div>
    
                    <div class="form-group">
                        <label class="form-label" for="location">Ubicacion</label>
                        <span class="form-subtitle">En caso de que la oferta sea en presencial o hibrida</span>
                        <input required class="form-input c-no-p" type="text" id="location" name="location" placeholder="Navarra" maxlength="20">
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
                            placeholder="DD/MM/YYYY" required>
                        <span class="form-hint">Seleccione una fecha válida</span>
                    </div>
    
                    <div class="form-group">
                        <label class="form-label">Tipo de empleo</label>
                        <span class="form-subtitle">Puede seleccionar un tipo de empleo</span>
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input class="checkbox-input" value="Tiempo completo" type="checkbox" name="jobType" value="fullTime">
                                Tiempo completo
                            </label>
                            <label class="checkbox-label">
                                <input class="checkbox-input" value="Media jornada" type="checkbox" name="jobType" value="partTime">
                                Media jornada
                            </label>
                            <label class="checkbox-label">
                                <input class="checkbox-input" value="Remoto" type="checkbox" name="jobType" value="remote">
                                Remoto
                            </label>
                            <label class="checkbox-label">
                                <input class="checkbox-input" value="Hibrido" type="checkbox" name="jobType" value="hybrid">
                                Híbrido
                            </label>
                            <label class="checkbox-label">
                                <input class="checkbox-input" value="Jornada intensiva" type="checkbox" name="jobType" value="intensive">
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
                                    <input type="number" id="s1-minSalary" name="s1-minSalary" value="5000" max="200000">
                                    <span>a</span>
                                </div>
                                <div class="s1-salary-input-group">
                                    <span>€</span>
                                    <input type="number" id="s1-maxSalary" name="s1-maxSalary" value="22000" max="200000">
                                </div>
                            </div>
                            <div id="s1-salarySlider" class="s1-slider-section"></div>
                        </div>
                    </div>
            
                    <div class="s1-form-section">
                        <label>Categorías</label>
                        <p class="s1-form-description">Puede seleccionar varias categorías de trabajo</p>
                        <div class="s1-dropdown-wrapper">
                            <select required id="s1-jobCategories" name="job_category">
                                <option disabled selected value="">Select Job Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->name }}">{{ $category->name }}</option>
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
            
                    <button type="submit" class="s1-button-submit">Siguiente</button>
                </form>

            </main>
            
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

                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const formData = {
                        minSalary: minSalary.value,
                        maxSalary: maxSalary.value,
                        category: document.getElementById('s1-jobCategories').value,
                        skills: Array.from(skillTags.querySelectorAll('.s1-skill-tag'))
                            .map(tag => tag.textContent.trim().slice(0, -1))
                    };
                    console.log('Form Data:', formData);
                });

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