<!--begin::Body-->
<div class="container-fluid p-0 m-0">
    @include('layouts._default.backend.components.nav._navbar')

    @yield('content')

    @yield('modals')

    {{-- allows you to 'stack' or append scripts to a named stack from various child views or components. --}}
    @stack('scripts')

    {{-- used to define a section in the layout that can be overridden by child views. --}}
    @yield('scripts')

    @stack('post-scripts')
</div>
<!--end::Body-->
