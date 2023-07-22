<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-black">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">

        <style>
            [x-cloak] { display: none; }
        </style>

    </head>
    <body class="h-full">
        <div class="min-h-full">
        <!-- App Navigation -->
        <nav class="bg-black border-b border-lime-500/20">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
              <div class="flex justify-between h-16">
                <div class="flex">
                  <!-- Logo -->
                  <div class="flex items-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29.4985"
                        viewBox="0 0 163.173 165.978">
                        <path id="glazed-avatar" data-name="glazed-avatar"
                            d="M0,84.157C0,38.806,34.833,0,80.418,0c30.623,0,61.015,15.662,73.171,46.053L92.574,82.989h70.6v82.99S133.952,144,133.717,144c-14.961,12.39-32.728,21.506-53.534,21.506C34.13,165.51,0,127.171,0,84.157"
                            fill="#db2777" />
                    </svg>
                  </div>
                  <!-- Desktop Nav -->
                  <div class="hidden sm:-my-px sm:ml-6 sm:flex sm:space-x-8">
                    <!-- Current: "border-indigo-500 text-gray-900", Default: "border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700" -->
                    <a href="/trainer" class="inline-flex items-center px-1 pt-1 text-sm font-medium border-b-2 border-transparent text-white/50 hover:text-white">Manage Workouts</a>
                  </div>
                </div>
                <!-- Profile Nav -->
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                  <!-- Profile dropdown -->
                  <div class="relative ml-3">
                    <div>
                      <button type="button" class="flex items-center max-w-xs text-sm bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                        <span class="sr-only">Open user menu</span>
                        <img class="w-8 h-8 rounded-full" src="https://placehold.co/256x256" alt="">
                      </button>
                    </div>

                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 z-10 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                      <!-- Active: "bg-gray-100", Not Active: "" -->
                      <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Account Settings</a>
                      <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a>
                    </div>
                  </div>
                </div>
                <!-- Mobile Hamburger -->
                <div class="flex items-center -mr-2 sm:hidden">
                  <!-- Mobile menu button -->
                  <button type="button" class="inline-flex items-center justify-center p-2 text-gray-400 bg-white rounded-md hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Menu open: "hidden", Menu closed: "block" -->
                    <svg class="block w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <!-- Menu open: "block", Menu closed: "hidden" -->
                    <svg class="hidden w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="sm:hidden" id="mobile-menu">
              <div class="pt-2 pb-3 space-y-1">
                <!-- Current: "border-indigo-500 bg-indigo-50 text-indigo-700", Default: "border-transparent text-gray-600 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-800" -->
              </div>
              <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="flex items-center px-4">
                  <div class="flex-shrink-0">
                    <img class="w-10 h-10 rounded-full" src="https://placehold.co/256x256" alt="">
                  </div>
                  <div class="ml-3">
                    <div class="text-base font-medium text-gray-800">Trainer</div>
                    <div class="text-sm font-medium text-gray-500">trainer@fitco.com</div>
                  </div>
                  <button type="button" class="flex-shrink-0 p-1 ml-auto text-gray-400 bg-white rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <span class="sr-only">View notifications</span>
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                  </button>
                </div>
                <div class="mt-3 space-y-1">
                  <a href="#" class="block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800">Account Settings</a>
                  <a href="#" class="block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800">Sign out</a>
                </div>
              </div>
            </div>
        </nav>
            {{ $slot }}
        </div>
        @livewireCalendarScripts
        <script src="https://unpkg.com/moment"></script>
        <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>

    </body>
</html>
