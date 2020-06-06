<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body>
<div id="app" class="d-flex w-100 h-100 mx-auto flex-column">
    <header class="mb-auto">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <div class="position-relative">
                    <a href="{{ url('/') }}">
                        <img src="{{ \App\Config::getValue('image_url') }}" alt="{{ config('app.name', 'Laravel') }}" height="30">
                        @if(\App\Config::getValue('is_open'))
                            <span class="badge badge-success position-absolute" style="top: -8px; left: 0">{{\App\Config::getValue('waiting_time')}}</span>
                        @else
                            <span class="badge badge-danger position-absolute" style="top: -8px; left: 0">-</span>
                        @endif
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link{{ Route::is('login') ? ' active' : '' }}"
                                   href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item{{ Route::is('register') ? ' active' : '' }}">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link{{ Route::is('orders*') ? ' active' : '' }}"
                                   href="{{ route('orders.index') }}">{{ __('Orders') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ Route::is('config*') ? ' active' : '' }}"
                                   href="{{ route('configs.update', 1) }}">{{ __('Config') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ Route::is('reports*') ? ' active' : '' }}"
                                   href="{{ route('reports.index', 1) }}">{{ __('Reports') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ Route::is('categories*') ? ' active' : '' }}"
                                   href="{{ route('categories.index') }}">{{ __('Categories') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ Route::is('variations*') ? ' active' : '' }}"
                                   href="{{ route('variations.index') }}">{{ __('Variations') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ Route::is('items*') ? ' active' : '' }}"
                                   href="{{ route('items.index') }}">{{ __('Items') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ Route::is('products*') ? ' active' : '' }}"
                                   href="{{ route('products.index') }}">{{ __('Products') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ Route::is('users*') ? ' active' : '' }}"
                                   href="{{ route('users.index') }}">{{ __('Users') }}</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown"
                                   class="nav-link dropdown-toggle{{ Route::is('profile*') ? ' active' : '' }}" href="#"
                                   role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                   v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.show') }}">
                                        {{ __('Profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <nav aria-label="breadcrumb">
            <div class="container">
                @yield('breadcrumb')
            </div>
        </nav>
    </header>
    <main role="main" class="inner cover">
        @yield('content')
    </main>
    <footer class="mt-auto">
        <div class="inner">
            <p>Desenvolvido por <a href="https://gg2.com.br/" target="_blank" rel="external">GG2</a>.</p>
        </div>
    </footer>
</div>
<div class="toast" id="my-alert" data-delay="3000" role="alert" aria-live="polite" aria-atomic="true">
    <div class="toast-header">
        <strong class="mr-auto"><i class="far fa-comment"></i> <span id="toast-title"></span></strong>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body" id="toast-content"></div>
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script>
    function myAlert(content, title) {
        if (typeof(title) === 'undefined') {
            title = '{{__('Attention')}}';
        }

        $('#toast-title').html(title);
        $('#toast-content').html(content);
        $('#my-alert').toast('show');
    }
    function whatsAppUrl(telephone) {
        var whatsAppApi = '{{App\Config::WHATSAPP_API}}';
        return whatsAppApi + '+55' + telephone.replace(/[^\d]/g, '');
    }
    function mapsUrl(zipcode) {
        var mapsApi = '{{App\Config::MAPS_API}}{{App\Config::getValue('zipcode')}}/'
        return mapsApi + zipcode;
    }
    function whatsAppLink(telephone) {

        if (telephone.replace(/[^\d]/g, '').length !== 11) {
            return telephone;
        }
        return '<a href="' + whatsAppUrl(telephone) + '" target="_blank"><i class="fab fa-whatsapp"></i> ' + telephone + '</a>';
    }

    function showModalErrors(responseError) {
        var errors = JSON.parse(responseError.responseText);
        if (!errors || !errors.hasOwnProperty('errors')) {
            return '';
        }
        for (var error in errors.errors) {
            $('.input-' + error).addClass('is-invalid');
            $('.invalid-' + error).find('strong')
                .html(errors.errors[error]);
        }
    }

    function showModal($modal, title) {
        $('.is-invalid')
            .removeClass('is-invalid');
        $('.invalid-feedback')
            .find('strong')
            .html('');
        $modal
            .find('.modal-title')
            .html(title);
        $modal.modal('show');
    }

    function formFieldsToObject($form) {
        if (!$form.is('form')) {
            return {};
        }
        var item = {};
        var formValues = $form.serializeArray();
        for (var key in formValues) {
            var name = formValues[key].name;
            var value = formValues[key].value
            if (name.indexOf('[]') < 0) {
                item[name] = value;
            } else {
                name = name.replace('[]', '');
                if (typeof item[name] === 'undefined') {
                    item[name] = [];
                }
                item[name].push(value);
            }
        }
        return item;
    }
</script>
@yield('scripts')
</body>
</html>
