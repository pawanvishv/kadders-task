<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/app.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/backend.css?v=1.0.0') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>
    <script>
        // Get CSRF token from meta tag
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Set default headers for Axios
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
    </script>

<body>
    @if (request()->routeIs('login') || request()->routeIs('register'))
        <x-login />
    @else
        {{-- Dashboard Layout --}}
        <div class="wrapper">
            <x-header />
            <x-sidebar />

            <main class="content">
                <div class="content-page">
                    {{ $slot }}
                </div>
            </main>
        </div>
    @endif
    <script>
        // Configure Axios defaults for Laravel
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    </script>
    <script src="{{ asset('assets/js/backend-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/customizer.js') }}"></script>
    <script src="{{ asset('assets/js/sidebar.js') }}"></script>
    <script src="{{ asset('assets/js/flex-tree.min.js') }}"></script>
    <script src="{{ asset('assets/js/tree.js') }}"></script>

    <!-- Table Treeview JavaScript -->
    <script src="{{ asset('assets/js/table-treeview.js') }}"></script>

    <!-- SweetAlert JavaScript -->
    <script src="{{ asset('assets/js/sweetalert.js') }}"></script>

    <!-- Vector Map JavaScript -->
    <script src="{{ asset('assets/js/vector-map-custom.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script src="{{ asset('assets/js/chart-custom.js') }}"></script>
    <script src="{{ asset('assets/js/charts/01.js') }}"></script>
    <script src="{{ asset('assets/js/charts/02.js') }}"></script>

    <!-- Slider JavaScript -->
    <script src="{{ asset('assets/js/slider.js') }}"></script>

    <!-- Emoji Picker -->
    <script type="module" src="{{ asset('assets/vendor/emoji-picker-element/index.js') }}"></script>
    <!-- App JavaScript -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script>
        function showToast(message, type = 'success') {
            let toastContainer = document.querySelector('.toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.className = 'toast-container';
                document.body.appendChild(toastContainer);
            }

            const toast = document.createElement('div');
            toast.className = `toast-message toast-${type}`;
            toast.textContent = message;

            toastContainer.appendChild(toast);
            const header = document.querySelector('header'); // adjust selector if needed
            const headerHeight = header ? header.offsetHeight : 0;
            const scrollY = window.scrollY || window.pageYOffset;
            toastContainer.style.top = scrollY + headerHeight + 10 + 'px';
            setTimeout(() => toast.classList.add('show'), 10);

            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    </script>
</body>

</html>
