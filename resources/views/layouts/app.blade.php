<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Layout &rsaquo; Default &mdash; Stisla</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <style>
        /* auto fill */
        .img-fill {
            object-fit: cover;
            /* gambar penuh tanpa distorsi */
            object-position: center;
            /* posisi tengah */

        }

        /* lingkaran */
        .lingkaran {
            border-radius: 50%;
        }
    </style>

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>

<body>

    <div class="main-wrapper main-wrapper-1">
        @include('layouts.navbar')
        @include('layouts.sidebar')
        @yield('content')
        @include('layouts.footer')
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>


    <!-- JS Libraies -->

    <!-- Page Specific JS File -->


    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    {{-- script buat dropdown --}}
    <script>
        window.addEventListener('load', function() {
            const dropdown = document.querySelector('#menu-layout');
            const dropdownToggle = dropdown.querySelector('a.has-dropdown');
            const dropdownMenu = $(dropdown).find('.dropdown-menu');
            const key = 'dropdown-layout-open';

            const isChildPage =
                {{ request()->is('user*') || request()->is('laptop*') || request()->is('serviceitem*') ? 'true' : 'false' }};

            setTimeout(() => {
                const savedState = localStorage.getItem(key);
                const isOpen = savedState === 'true';

                if (isOpen || isChildPage) {
                    dropdown.classList.add('active', 'dropdown-show');
                    dropdownMenu.show(); // tampilkan dulu tanpa animasi

                    // 🔹 Paksa jQuery menghitung ulang tinggi dropdown (biar nanti animasi close lancar)
                    dropdownMenu.height(); // ini trigger reflow
                    localStorage.setItem(key, 'true');
                } else {
                    dropdown.classList.remove('active', 'dropdown-show');
                    dropdownMenu.hide();
                }

                // 🔹 Event klik toggle dropdown
                dropdownToggle.addEventListener('click', function(e) {
                    e.preventDefault();

                    const isCurrentlyOpen = dropdown.classList.contains('dropdown-show');

                    if (isCurrentlyOpen) {
                        dropdownMenu.stop(true, true).slideUp(150);
                        dropdown.classList.remove('dropdown-show', 'active');
                        localStorage.setItem(key, 'false');
                    } else {
                        dropdownMenu.stop(true, true).slideDown(150);
                        dropdown.classList.add('dropdown-show', 'active');
                        localStorage.setItem(key, 'true');
                    }
                });
            }, 200);
        });
    </script>


    {{-- <script>
        window.addEventListener('load', function() {
            const dropdown = document.querySelector('#menu-layout');
            const dropdownToggle = dropdown.querySelector('a.has-dropdown');
            const dropdownMenu = $(dropdown).find('.dropdown-menu');
            const key = 'dropdown-layout-open';

            const isChildPage =
                {{ request()->is('user*') || request()->is('laptop*') || request()->is('serviceitem*') ? 'true' : 'false' }};

            // 🔹 Tambahkan icon panah kalau belum ada
            let arrowIcon = dropdownToggle.querySelector('.dropdown-arrow');
            if (!arrowIcon) {
                const icon = document.createElement('i');
                icon.className = 'fas fa-chevron-right dropdown-arrow';
                icon.style.transition = 'transform 0.3s ease';
                icon.style.marginLeft = '8px';
                dropdownToggle.appendChild(icon);
                arrowIcon = icon;
            }

            setTimeout(() => {
                const savedState = localStorage.getItem(key);

                // 🔹 Kalau belum ada nilai tersimpan dan halaman anak, buka otomatis
                if (savedState === null && isChildPage) {
                    localStorage.setItem(key, 'true');
                }

                const isOpen = localStorage.getItem(key) === 'true';

                // 🔹 Set kondisi awal dropdown
                if (isOpen) {
                    dropdown.classList.add('active', 'dropdown-show');
                    dropdownMenu.show();
                    dropdownMenu.height(); // reflow biar animasi close nanti jalan
                    arrowIcon.style.transform = 'rotate(90deg)';
                } else {
                    dropdown.classList.remove('active', 'dropdown-show');
                    dropdownMenu.hide();
                    arrowIcon.style.transform = 'rotate(0deg)';
                }

                // 🔹 Klik toggle dropdown
                dropdownToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const isCurrentlyOpen = dropdown.classList.contains('dropdown-show');

                    if (isCurrentlyOpen) {
                        dropdownMenu.stop(true, true).slideUp(150);
                        dropdown.classList.remove('dropdown-show', 'active');
                        arrowIcon.style.transform = 'rotate(0deg)';
                        localStorage.setItem(key, 'false');
                    } else {
                        dropdownMenu.stop(true, true).slideDown(150);
                        dropdown.classList.add('dropdown-show', 'active');
                        arrowIcon.style.transform = 'rotate(90deg)';
                        localStorage.setItem(key, 'true');
                    }
                });
            }, 200);
        });
    </script> --}}





    {{-- ajakskskskssk --}}
    @stack('costom.js')
</body>

</html>
