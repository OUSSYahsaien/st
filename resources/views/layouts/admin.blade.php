 <!DOCTYPE html>
 <html lang="es">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <title>@yield('title', 'Admin - Portal')</title>
     <link rel="stylesheet" href="{{ asset('css/Admin/adminstration.css') }}">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
 </head>
 <body>
     <div class="container">
         <!-- Sidebar -->
         <aside class="sidebar">
             <div class="logo" style="display: flex;">
                <img src="{{ asset('images/logo/logo2.png') }}" alt="Talent Select Logo">
                <div class="close-sidebar-btn" style="margin-left: 63px; margin-top: 9px;">
                    <i class="fa-solid fa-xmark" style="font-size: 24px; color: #3064FE;"></i>
                </div>
             </div>

             <nav>
                 <ul class="nav-menu">
                     <li class="nav-item">
                         <a draggable="false" href="{{ route('administration.dashboard') }}" class="nav-link {{ Request::is('administration/dashboard') ? 'active' : '' }}">
                             <i class="fas fa-home"></i>
                             Inicio
                         </a>
                     </li>
                     <li class="nav-item">
                         <a draggable="false" href="{{ route('administration.companies') }}" class="nav-link {{ Request::is('administration/company') || Request::is('administration/companies/*') ? 'active' : '' }}">
                            @if (Request::is('administration/company') || Request::is('administration/companies/*'))
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <g clip-path="url(#clip0_988_64305)">
                                    <path d="M3 21H21" stroke="#0066FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M5 21V7L13 3V21" stroke="#0066FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M19 21V11L13 7" stroke="#0066FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9 9V9.01" stroke="#0066FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9 12V12.01" stroke="#0066FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9 15V15.01" stroke="#0066FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9 18V18.01" stroke="#0066FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_988_64305">
                                    <rect width="24" height="24" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <g clip-path="url(#clip0_988_64305)">
                                    <path d="M3 21H21" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M5 21V7L13 3V21" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M19 21V11L13 7" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9 9V9.01" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9 12V12.01" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9 15V15.01" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9 18V18.01" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_988_64305">
                                    <rect width="24" height="24" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                            @endif
                            

                                <span style="margin-left: 9px">
                                    Empresas
                                </span>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a draggable="false" href="{{ route('administration.candidats') }}" class="nav-link {{Request::is('administration/candidats') || Request::is('administration/candidats/*') ? 'active' : '' }}">
                            @if (Request::is('administration/candidats') || Request::is('administration/candidats/*'))
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 5C11.4696 5 10.9609 5.21071 10.5858 5.58579C10.2107 5.96086 10 6.46957 10 7C10 7.53043 10.2107 8.03914 10.5858 8.41421C10.9609 8.78929 11.4696 9 12 9C12.5304 9 13.0391 8.78929 13.4142 8.41421C13.7893 8.03914 14 7.53043 14 7C14 6.46957 13.7893 5.96086 13.4142 5.58579C13.0391 5.21071 12.5304 5 12 5ZM9.17157 4.17157C9.92172 3.42143 10.9391 3 12 3C13.0609 3 14.0783 3.42143 14.8284 4.17157C15.5786 4.92172 16 5.93913 16 7C16 8.06087 15.5786 9.07828 14.8284 9.82843C14.0783 10.5786 13.0609 11 12 11C10.9391 11 9.92172 10.5786 9.17157 9.82843C8.42143 9.07828 8 8.06087 8 7C8 5.93913 8.42143 4.92172 9.17157 4.17157ZM5 9C4.73478 9 4.48043 9.10536 4.29289 9.29289C4.10536 9.48043 4 9.73478 4 10C4 10.2652 4.10536 10.5196 4.29289 10.7071C4.48043 10.8946 4.73478 11 5 11C5.26522 11 5.51957 10.8946 5.70711 10.7071C5.89464 10.5196 6 10.2652 6 10C6 9.73478 5.89464 9.48043 5.70711 9.29289C5.51957 9.10536 5.26522 9 5 9ZM2.87868 7.87868C3.44129 7.31607 4.20435 7 5 7C5.79565 7 6.55871 7.31607 7.12132 7.87868C7.68393 8.44129 8 9.20435 8 10C8 10.7956 7.68393 11.5587 7.12132 12.1213C6.55871 12.6839 5.79565 13 5 13C4.20435 13 3.44129 12.6839 2.87868 12.1213C2.31607 11.5587 2 10.7956 2 10C2 9.20435 2.31607 8.44129 2.87868 7.87868ZM19 9C18.7348 9 18.4804 9.10536 18.2929 9.29289C18.1054 9.48043 18 9.73478 18 10C18 10.2652 18.1054 10.5196 18.2929 10.7071C18.4804 10.8946 18.7348 11 19 11C19.2652 11 19.5196 10.8946 19.7071 10.7071C19.8946 10.5196 20 10.2652 20 10C20 9.73478 19.8946 9.48043 19.7071 9.29289C19.5196 9.10536 19.2652 9 19 9ZM16.8787 7.87868C17.4413 7.31607 18.2043 7 19 7C19.7957 7 20.5587 7.31607 21.1213 7.87868C21.6839 8.44129 22 9.20435 22 10C22 10.7957 21.6839 11.5587 21.1213 12.1213C20.5587 12.6839 19.7957 13 19 13C18.2043 13 17.4413 12.6839 16.8787 12.1213C16.3161 11.5587 16 10.7957 16 10C16 9.20435 16.3161 8.44129 16.8787 7.87868ZM12 13.9993C11.2003 13.9993 10.4189 14.2389 9.75658 14.6872C9.13228 15.1098 8.64084 15.6996 8.33765 16.3878L8.09655 19H15.9034L15.6623 16.3878C15.3592 15.6996 14.8677 15.1098 14.2434 14.6872C13.5811 14.2389 12.7997 13.9993 12 13.9993ZM18 19H21V18.0001C21 18 21 18.0001 21 18.0001C21 17.5845 20.8704 17.1791 20.6294 16.8405C20.3884 16.5019 20.0479 16.2467 19.6552 16.1106C19.2625 15.9744 18.8371 15.964 18.4382 16.0808C18.2014 16.1501 17.981 16.2621 17.7871 16.41C17.9262 16.9175 18 17.451 18 18V19ZM16.9298 14.5776C16.51 13.9732 15.9804 13.4479 15.3646 13.031C14.3713 12.3587 13.1994 11.9993 12 11.9993C10.8006 11.9993 9.62867 12.3587 8.63543 13.031C8.01963 13.4479 7.49002 13.9732 7.07024 14.5776C6.77575 14.3995 6.45782 14.2591 6.12365 14.1613C5.32584 13.9278 4.47509 13.9486 3.68967 14.2209C2.90425 14.4932 2.22318 15.0035 1.74115 15.6808C1.25911 16.358 1.00006 17.1686 1 17.9999V20C1 20.5523 1.44772 21 2 21H22C22.5523 21 23 20.5523 23 20V18C22.9999 17.1687 22.7409 16.358 22.2589 15.6808C21.7768 15.0035 21.0958 14.4932 20.3103 14.2209C19.5249 13.9486 18.6742 13.9278 17.8763 14.1613C17.5422 14.2591 17.2242 14.3995 16.9298 14.5776ZM6.21295 16.41C6.01904 16.2621 5.79859 16.1501 5.56183 16.0808C5.16292 15.964 4.73754 15.9744 4.34483 16.1106C3.95212 16.2467 3.61159 16.5019 3.37057 16.8405C3.12957 17.1791 3.00005 17.5844 3 18C3 18 3 18 3 18V19H6V18C6 17.451 6.07383 16.9175 6.21295 16.41Z" fill="#0066FF"/>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 5C11.4696 5 10.9609 5.21071 10.5858 5.58579C10.2107 5.96086 10 6.46957 10 7C10 7.53043 10.2107 8.03914 10.5858 8.41421C10.9609 8.78929 11.4696 9 12 9C12.5304 9 13.0391 8.78929 13.4142 8.41421C13.7893 8.03914 14 7.53043 14 7C14 6.46957 13.7893 5.96086 13.4142 5.58579C13.0391 5.21071 12.5304 5 12 5ZM9.17157 4.17157C9.92172 3.42143 10.9391 3 12 3C13.0609 3 14.0783 3.42143 14.8284 4.17157C15.5786 4.92172 16 5.93913 16 7C16 8.06087 15.5786 9.07828 14.8284 9.82843C14.0783 10.5786 13.0609 11 12 11C10.9391 11 9.92172 10.5786 9.17157 9.82843C8.42143 9.07828 8 8.06087 8 7C8 5.93913 8.42143 4.92172 9.17157 4.17157ZM5 9C4.73478 9 4.48043 9.10536 4.29289 9.29289C4.10536 9.48043 4 9.73478 4 10C4 10.2652 4.10536 10.5196 4.29289 10.7071C4.48043 10.8946 4.73478 11 5 11C5.26522 11 5.51957 10.8946 5.70711 10.7071C5.89464 10.5196 6 10.2652 6 10C6 9.73478 5.89464 9.48043 5.70711 9.29289C5.51957 9.10536 5.26522 9 5 9ZM2.87868 7.87868C3.44129 7.31607 4.20435 7 5 7C5.79565 7 6.55871 7.31607 7.12132 7.87868C7.68393 8.44129 8 9.20435 8 10C8 10.7956 7.68393 11.5587 7.12132 12.1213C6.55871 12.6839 5.79565 13 5 13C4.20435 13 3.44129 12.6839 2.87868 12.1213C2.31607 11.5587 2 10.7956 2 10C2 9.20435 2.31607 8.44129 2.87868 7.87868ZM19 9C18.7348 9 18.4804 9.10536 18.2929 9.29289C18.1054 9.48043 18 9.73478 18 10C18 10.2652 18.1054 10.5196 18.2929 10.7071C18.4804 10.8946 18.7348 11 19 11C19.2652 11 19.5196 10.8946 19.7071 10.7071C19.8946 10.5196 20 10.2652 20 10C20 9.73478 19.8946 9.48043 19.7071 9.29289C19.5196 9.10536 19.2652 9 19 9ZM16.8787 7.87868C17.4413 7.31607 18.2043 7 19 7C19.7957 7 20.5587 7.31607 21.1213 7.87868C21.6839 8.44129 22 9.20435 22 10C22 10.7957 21.6839 11.5587 21.1213 12.1213C20.5587 12.6839 19.7957 13 19 13C18.2043 13 17.4413 12.6839 16.8787 12.1213C16.3161 11.5587 16 10.7957 16 10C16 9.20435 16.3161 8.44129 16.8787 7.87868ZM12 13.9993C11.2003 13.9993 10.4189 14.2389 9.75658 14.6872C9.13228 15.1098 8.64084 15.6996 8.33765 16.3878L8.09655 19H15.9034L15.6623 16.3878C15.3592 15.6996 14.8677 15.1098 14.2434 14.6872C13.5811 14.2389 12.7997 13.9993 12 13.9993ZM18 19H21V18.0001C21 18 21 18.0001 21 18.0001C21 17.5845 20.8704 17.1791 20.6294 16.8405C20.3884 16.5019 20.0479 16.2467 19.6552 16.1106C19.2625 15.9744 18.8371 15.964 18.4382 16.0808C18.2014 16.1501 17.981 16.2621 17.7871 16.41C17.9262 16.9175 18 17.451 18 18V19ZM16.9298 14.5776C16.51 13.9732 15.9804 13.4479 15.3646 13.031C14.3713 12.3587 13.1994 11.9993 12 11.9993C10.8006 11.9993 9.62867 12.3587 8.63543 13.031C8.01963 13.4479 7.49002 13.9732 7.07024 14.5776C6.77575 14.3995 6.45782 14.2591 6.12365 14.1613C5.32584 13.9278 4.47509 13.9486 3.68967 14.2209C2.90425 14.4932 2.22318 15.0035 1.74115 15.6808C1.25911 16.358 1.00006 17.1686 1 17.9999V20C1 20.5523 1.44772 21 2 21H22C22.5523 21 23 20.5523 23 20V18C22.9999 17.1687 22.7409 16.358 22.2589 15.6808C21.7768 15.0035 21.0958 14.4932 20.3103 14.2209C19.5249 13.9486 18.6742 13.9278 17.8763 14.1613C17.5422 14.2591 17.2242 14.3995 16.9298 14.5776ZM6.21295 16.41C6.01904 16.2621 5.79859 16.1501 5.56183 16.0808C5.16292 15.964 4.73754 15.9744 4.34483 16.1106C3.95212 16.2467 3.61159 16.5019 3.37057 16.8405C3.12957 17.1791 3.00005 17.5844 3 18C3 18 3 18 3 18V19H6V18C6 17.451 6.07383 16.9175 6.21295 16.41Z" fill="#666666"/>
                                </svg>
                            @endif
                            <span style="margin-left: 9px">
                                Candidatos
                            </span>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a draggable="false" href="{{ route('administration.offers') }}" class="nav-link {{  Request::is('administration/offers') || Request::is('administration/create-offer/*') || Request::is('administration/offers/*') ? 'active' : '' }}">
                            @if (Request::is('administration/offers') || Request::is('administration/create-offer/*') || Request::is('administration/offers/*'))
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <g clip-path="url(#clip0_988_64320)">
                                    <path d="M9 5H7C6.46957 5 5.96086 5.21071 5.58579 5.58579C5.21071 5.96086 5 6.46957 5 7V19C5 19.5304 5.21071 20.0391 5.58579 20.4142C5.96086 20.7893 6.46957 21 7 21H17C17.5304 21 18.0391 20.7893 18.4142 20.4142C18.7893 20.0391 19 19.5304 19 19V7C19 6.46957 18.7893 5.96086 18.4142 5.58579C18.0391 5.21071 17.5304 5 17 5H15" stroke="#0066FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M13 3H11C9.89543 3 9 3.89543 9 5C9 6.10457 9.89543 7 11 7H13C14.1046 7 15 6.10457 15 5C15 3.89543 14.1046 3 13 3Z" stroke="#0066FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9 12H9.01" stroke="#0066FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M13 12H15" stroke="#0066FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9 16H9.01" stroke="#0066FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M13 16H15" stroke="#0066FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_988_64320">
                                    <rect width="24" height="24" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <g clip-path="url(#clip0_988_64320)">
                                    <path d="M9 5H7C6.46957 5 5.96086 5.21071 5.58579 5.58579C5.21071 5.96086 5 6.46957 5 7V19C5 19.5304 5.21071 20.0391 5.58579 20.4142C5.96086 20.7893 6.46957 21 7 21H17C17.5304 21 18.0391 20.7893 18.4142 20.4142C18.7893 20.0391 19 19.5304 19 19V7C19 6.46957 18.7893 5.96086 18.4142 5.58579C18.0391 5.21071 17.5304 5 17 5H15" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M13 3H11C9.89543 3 9 3.89543 9 5C9 6.10457 9.89543 7 11 7H13C14.1046 7 15 6.10457 15 5C15 3.89543 14.1046 3 13 3Z" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9 12H9.01" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M13 12H15" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9 16H9.01" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M13 16H15" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_988_64320">
                                    <rect width="24" height="24" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                            @endif
                            <span style="margin-left: 9px">
                             Ofertas 
                            </span>
                         </a>
                     </li>



                     <li class="nav-item">
                        <a draggable="false" href="{{ route('administration.calendar.index') }}" class="nav-link {{ Request::is('administration/calendar') ? 'active' : '' }}">
                            @if (Request::is('administration/calendar'))
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <g clip-path="url(#clip0_988_64330)">
                                    <path d="M18 5H6C4.89543 5 4 5.89543 4 7V19C4 20.1046 4.89543 21 6 21H18C19.1046 21 20 20.1046 20 19V7C20 5.89543 19.1046 5 18 5Z" stroke="#0066FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M16 3V7" stroke="#0066FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M8 3V7" stroke="#0066FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M4 11H20" stroke="#0066FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M10 15H8V17H10V15Z" stroke="#0066FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_988_64330">
                                    <rect width="24" height="24" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <g clip-path="url(#clip0_988_64330)">
                                    <path d="M18 5H6C4.89543 5 4 5.89543 4 7V19C4 20.1046 4.89543 21 6 21H18C19.1046 21 20 20.1046 20 19V7C20 5.89543 19.1046 5 18 5Z" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M16 3V7" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M8 3V7" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M4 11H20" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M10 15H8V17H10V15Z" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_988_64330">
                                    <rect width="24" height="24" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                            @endif
                           <span style="margin-left: 9px">
                            Calendario  
                           </span>
                        </a>
                    </li>


                    <li class="nav-item web">
                        <a draggable="false" href="{{ route('candidat.profile') }}" class="nav-link {{ Request::is('candidat/profile') || Request::is('candidat/edit/profile') ? 'active' : '' }}">
                            <i class="fa fa-globe" aria-hidden="true"></i>
                           <span style="margin-left: 9px">
                            Web
                           </span>
                        </a>
                    </li>
                     

                    <li class="nav-item settings-item">
                        <a draggable="false" href="#" class="nav-link settings-toggle {{Request::is('administration/languages') || Request::is('administration/categories') || Request::is('administration/sectors') ? 'active' : ''}}">
                            <i class="fa-solid fa-gear"></i>
                            <span style="margin-left: 9px">
                                Ajustes
                            </span>
                            <i style="font-size: 15px;" class="fas fa-chevron-down arrow"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="{{ route('administration.languages') }}" class="nav-link {{ Request::is('administration/languages*') ? 'active' : '' }}">
                                    Idiomas
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('administration.categories') }}" class="nav-link {{ Request::is('administration/categories*') ? 'active' : '' }}">
                                    Categorías
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('administration.sectors') }}" class="nav-link {{ Request::is('administration/secteurs*') ? 'active' : '' }}">
                                    Sectores
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                     
                     <li class="nav-item">
                         <form method="POST" action="{{ route('administration.logout') }}" style="margin: 0;">
                             @csrf
                             <button onclick="changeColor(this)" type="submit" class="nav-link logout-button">
                                 <i class="fa fa-power-off" aria-hidden="true"></i>
                                 Logout
                             </button>
                         </form>
                     </li>
                 </ul>
                 <hr>
                 {{-- <a href="{{ route('candidat.login') }}" class="web-link-2">Volver a la página web</a> --}}

             </nav>
 
             <!-- Profile Section -->
                <div class="profile-section">
                    @php
                        $personalPicturePath = 'images/admin_images/' . Auth::user()->image_name;
                    @endphp
                    @if (Auth::user()->personal_picture_path && file_exists(public_path($personalPicturePath)))
                        <img src="{{ asset($personalPicturePath) }}" alt="Foto de perfil" class="profile-image">
                    @else
                        <img src="{{ asset('images/companies_images/100x100.svg') }}" alt="Foto de perfil" class="profile-image">
                    @endif
                    {{-- <img src="https://via.placeholder.com/40" alt="Profile" class="profile-image"> --}}
                    <div class="profile-info">
                        <span class="profile-name">{{ Auth::user()->username  }}</span>
                        <span class="profile-email">{{ Auth::user()->email }}</span>
                    </div>
                </div>
         </aside>
 
            <!-- Main Content -->
            <main class="main-content">
                <header class="header">
                    <button class="toggle-sidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 style="margin-top: 6px" class="page-title-c">@yield('page-title', 'Bienvenido')</h1>
                    {{-- <div class="right-section">
                        <a href="{{ route('candidat.login') }}" class="web-link">Volver a la página web</a>
                        <i class="fa-regular fa-bell"></i>
                    </div> --}}

                    <div class="right-section">
                        <a href="{{ route('candidat.login') }}" class="web-link">Volver a la página web</a>
                        <div class="dropdown">
                            <i class="fa-regular fa-bell notification-bell" id="notificationBell">
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="notification-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
                                @endif
                            </i>
                            <div class="notifications-container">
                                <h2 class="notifications-header">
                                    Notifications
                                    <a href="#" class="mark-all" onclick="event.preventDefault(); markAllAsRead();">
                                        Marcar todo como leído
                                    </a>
                                </h2>
                                <div class="notifications-list">
                                    @forelse(auth()->user()->unreadNotifications as $notification)

                                        @if ($notification->type == "App\Notifications\RevisionRequestNotification")

                                            @php
                                                $candidat = \App\Models\Candidat::find($notification->data['candidate_id']);
                                                $offer = \App\Models\Offers::find($notification->data['offer_id']);
                                            @endphp

                                            <div class="notification-item candidat-notif new">

                                                    <form action="{{ route('administration.notifications.markAsRead', $notification->id) }}" 
                                                        method="POST" 
                                                        class="view-details-form" style="display: none;">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="view-details-btn btn-candidat-notif" 
                                                            onclick="window.location.href='{{ route('administration.companies.offers.view.applications.pipeline', $offer->id) }}'"
                                                            title="Ver detalles">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                                
                                            
                                                @php
                                                    $personalPicturePath = 'images/candidats_images/' . $candidat->personal_picture_path;
                                                @endphp


                                                @if ($candidat->personal_picture_path && file_exists(public_path($personalPicturePath)))
                                                    <img src="{{ asset($personalPicturePath) }}" 
                                                    alt="Profile" 
                                                    class="profile-pic-notif">
                                                @else
                                                    <img src="{{ asset('images/companies_images/100x100.svg') }}" 
                                                    alt="Profile" 
                                                    class="profile-pic-notif">
                                                @endif

                                                
                                                <div class="notification-content">
                                                    <p class="notification-text">
                                                        <strong>{{ $candidat->first_name }} {{ $candidat->last_name }}</strong>
                                                        Solicitar una revisión de la aplicación de
                                                        <strong>{{ $offer->title }}</strong>
                                                    </p>
                                                    <span class="notification-time">
                                                        {{ $notification->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                                @if(!$notification->read_at)
                                                    <span class="status-badge-app">New</span>
                                                @endif
                                            </div>
                                            
                                        @else
                                            @php
                                                $company = \App\Models\Company::find($notification->data['company_id']);
                                                $offer = \App\Models\Offers::find($notification->data['offer_id']);
                                            @endphp

                                            <div class="notification-item company-notif new">

                                                    <form action="{{ route('administration.notifications.markAsRead', $notification->id) }}" 
                                                        method="POST" 
                                                        class="view-details-form" style="display: none;">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="view-details-btn btn-company-notif" 
                                                            onclick="window.location.href='{{ route('administration.view.offer', $offer->id) }}'"
                                                            title="Ver detalles">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                                
                                            
                                                @php
                                                    $personalPicturePath = 'images/companies_images/' . $company->personel_pic;
                                                @endphp


                                                @if ($company->personel_pic && file_exists(public_path($personalPicturePath)))
                                                    <img src="{{ asset($personalPicturePath) }}" 
                                                    alt="Profile" 
                                                    class="profile-pic-notif">
                                                @else
                                                    <img src="{{ asset('images/companies_images/100x100.svg') }}" 
                                                    alt="Profile" 
                                                    class="profile-pic-notif">
                                                @endif

                                                
                                                <div class="notification-content">
                                                    <p class="notification-text">
                                                        <strong>{{ $company->name }}</strong>
                                                        Solicitar revisión de oferta
                                                        <strong>{{ $offer->title }}</strong>
                                                    </p>
                                                    <span class="notification-time">
                                                        {{ $notification->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                                @if(!$notification->read_at)
                                                    <span class="status-badge-app">New</span>
                                                @endif
                                            </div>
                                        @endif
                                        
                                    @empty
                                        <p class="no-notifications">No hay nuevas notificaciones</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </header>
                            
                <!-- Contenu spécifique à la page -->
                <div class="content" style="margin-top: 45px">
                    @yield('content')
                </div>
            </main>        
     </div>
 
     <script src="{{ asset('js/candidats.js') }}"></script>
     <script>
        document.addEventListener('DOMContentLoaded', () => {
          const toggleButton = document.querySelector('.toggle-sidebar');
          const sidebar = document.querySelector('.sidebar');
      
          toggleButton.addEventListener('click', () => {
            sidebar.classList.remove('closed');
            sidebar.classList.toggle('open');
          });
        });
      </script>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
        const closeButton = document.querySelector('.close-sidebar-btn'); // Bouton pour fermer
        const sidebar = document.querySelector('.sidebar'); // Élément sidebar
    
        // Fonction pour fermer la sidebar
        closeButton.addEventListener('click', () => {
            sidebar.classList.remove('open');
            sidebar.classList.toggle('closed'); // Basculer la classe 'closed' pour masquer/afficher
        });
        });








        document.querySelectorAll('.settings-toggle').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const parent = this.closest('.settings-item');
                parent.classList.toggle('active');
                
                // Fermer les autres menus ouverts
                document.querySelectorAll('.settings-item').forEach(otherItem => {
                    if (otherItem !== parent) {
                        otherItem.classList.remove('active');
                    }
                });
            });
        });
    </script>
  



    <script>
        // document.getElementById('notificationBell').addEventListener('click', function() {
        //     document.getElementById('notificationDropdown').style.display = 
        //         document.getElementById('notificationDropdown').style.display === 'block' ? 'none' : 'block';
        // });

        // // Fermer le dropdown en cliquant ailleurs
        // document.addEventListener('click', function(e) {
        //     if (!e.target.matches('.notification-bell')) {
        //         document.getElementById('notificationDropdown').style.display = 'none';
        //     }
        // });





        document.querySelector('.fa-bell').addEventListener('click', function(e) {
            e.stopPropagation();
            document.querySelector('.notifications-container').classList.toggle('show');
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.notifications-container')) {
                document.querySelector('.notifications-container').classList.remove('show');
            }
        });





        // Fermer les notifications en swipant vers le bas sur mobile
        let touchStarttY = 0;
        let touchEndY = 0;

        document.querySelector('.notifications-container').addEventListener('touchstart', e => {
            touchStarttY = e.touches[0].clientY;
        });

        document.querySelector('.notifications-container').addEventListener('touchmove', e => {
            touchEndY = e.touches[0].clientY;
            
            if (touchEndY - touchStarttY > 50) { // Si swipe vers le bas
                document.querySelector('.notifications-container').classList.remove('show');
            }
        });

        // Empêcher le scroll de la page quand on scroll dans les notifications
        document.querySelector('.notifications-list').addEventListener('touchmove', e => {
            e.stopPropagation();
        });

        
        

        document.querySelectorAll('.view-details-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Récupérer l'URL de redirection du bouton
                const redirectUrl = this.querySelector('button').getAttribute('onclick').match(/'([^']+)'/)[1];
                
                // Envoyer la requête de marquage comme lu
                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                }).then(() => {
                    // Rediriger vers la page des applications
                    window.location.href = redirectUrl;
                });
            });
        });


        // Ajoutez ce script
        document.querySelectorAll('.candidat-notif').forEach(item => {
            item.addEventListener('click', function(e) {
                // Éviter le déclenchement si on clique sur un autre élément cliquable
                if (e.target.closest('.btn-candidat-notif')) return;
                
                // Trouver et déclencher le clic sur le bouton caché
                const button = this.querySelector('.btn-candidat-notif');
                if (button) {
                    button.click();
                }
            });
        });

        
        document.querySelectorAll('.company-notif').forEach(item => {
            item.addEventListener('click', function(e) {
                // Éviter le déclenchement si on clique sur un autre élément cliquable
                if (e.target.closest('.btn-company-notif')) return;
                
                // Trouver et déclencher le clic sur le bouton caché
                const button = this.querySelector('.btn-company-notif');
                if (button) {
                    button.click();
                }
            });
        });
        
        



        const markAllAsRead = () => {
            fetch(`${window.location.origin}/administration/notifications/mark-all-as-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
            })
            .then(response => response.json())
            .then(data => {
                    // Create notification container if it doesn't exist
                    let notificationContainer = document.getElementById('notification-container');
                    if (!notificationContainer) {
                        notificationContainer = document.createElement('div');
                        notificationContainer.id = 'notification-container';
                        notificationContainer.style.cssText = `
                            position: fixed;
                            top: 20px;
                            right: 20px;
                            z-index: 1050;
                            min-width: 300px;
                            max-width: 400px;
                        `;
                        document.body.appendChild(notificationContainer);
                    }

                    // Create notification
                    const notification = document.createElement('div');
                    notification.className = 'custom-alert-3';
                    notification.innerHTML = `
                        <div class="custom-alert-content">
                            <div class="custom-alert-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>
                                    <path d="M9 12l2 2 4-4"/>
                                </svg>
                            </div>
                            <div class="custom-alert-message">${data.message}</div>
                            <button class="custom-alert-close" onclick="this.parentElement.parentElement.remove()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                    `;

                    // Add styles
                    const style = document.createElement('style');
                    style.textContent = `
                        .custom-alert-3 {
                            background: white;
                            border-left: 4px solid #10B981;
                            border-radius: 6px;
                            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                            margin-bottom: 1rem;
                            opacity: 0;
                            transform: translateX(100%);
                            transition: all 0.5s ease-in-out;
                        }
                        
                        .custom-alert-content {
                            display: flex;
                            align-items: center;
                            padding: 1rem;
                            min-height: 60px;
                        }
                        
                        .custom-alert-icon {
                            flex-shrink: 0;
                            margin-right: 12px;
                            color: #10B981;
                        }
                        
                        .custom-alert-message {
                            color: #1F2937;
                            font-size: 0.875rem;
                            line-height: 1.25rem;
                            flex-grow: 1;
                            margin-right: 12px;
                        }
                        
                        .custom-alert-close {
                            background: transparent;
                            border: none;
                            color: #9CA3AF;
                            cursor: pointer;
                            padding: 4px;
                            flex-shrink: 0;
                            border-radius: 4px;
                            transition: all 0.2s;
                        }
                        
                        .custom-alert-close:hover {
                            background-color: #F3F4F6;
                            color: #4B5563;
                        }

                        .show-notification {
                            opacity: 1;
                            transform: translateX(0);
                        }
                    `;
                    document.head.appendChild(style);

                    // Add to container
                    notificationContainer.appendChild(notification);

                    // Trigger animation
                    setTimeout(() => {
                        notification.classList.add('show-notification');
                    }, 100);

                    // Remove after 5 seconds
                    setTimeout(() => {
                        notification.style.opacity = '0';
                        notification.style.transform = 'translateX(100%)';
                        setTimeout(() => {
                            notification.remove();
                        }, 500);
                    }, 5000);

                    setTimeout(function() {
                        location.reload();
                    }, 1500); // 4000 millisecondes = 4 secondes
            })
            .catch(error => console.error(error));
            };

        
    </script>
      
 </body>
 </html>
 