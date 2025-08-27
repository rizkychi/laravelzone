@include('partials/main')

<head>
    {{-- Title Meta --}}
    @include("partials/title-meta")

    {{-- Vite assets --}}
    @vite(['resources/css/app.css','resources/js/app.js'])

    {{-- Head CSS --}}
    @include("partials/head-css")

    {{-- Slot page-level CSS --}}
    @stack('styles')
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        {{-- Menu --}}
        @include("partials/menu")

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    {{-- Page Title --}}
                    @include("partials/page-title")

                    {{-- Content --}}
                    {{ $slot }}

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            {{-- Footer --}}
            @include("partials/footer")
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    {{-- Customizer --}}
    @include("partials/customizer")

    {{-- Vendor Scripts --}}
    @include("partials/vendor-scripts")

    {{-- Page Specific Scripts --}}
    @stack('scripts')
</body>

</html>