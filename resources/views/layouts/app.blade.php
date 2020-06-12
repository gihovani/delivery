<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

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
                    <a href="{{ url('/home') }}">
                        <img src="{{ \App\Config::getValue('image_url') }}" alt="{{ config('app.name', 'Laravel') }}"
                             height="30">
                        @if(\App\Config::getValue('is_open'))
                            <span class="badge badge-success position-absolute"
                                  style="top: -8px; left: 0">{{\App\Config::getValue('waiting_time')}}</span>
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
                                <a class="nav-link{{ Route::is('reports*') ? ' active' : '' }}"
                                   href="{{ route('reports.index', 1) }}">{{ __('Reports') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ Route::is('config*') ? ' active' : '' }}"
                                   href="{{ route('configs.update', 1) }}">{{ __('Config') }}</a>
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
<div class="toast hide" id="my-alert" data-delay="3000" role="alert" aria-live="polite" aria-atomic="true">
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
    /** Classes */
    function Address() {
        var args = arguments[0];
        if (!args.hasOwnProperty('id') &&
            !args.hasOwnProperty('zipcode') &&
            !args.hasOwnProperty('street') &&
            !args.hasOwnProperty('number') &&
            !args.hasOwnProperty('city') &&
            !args.hasOwnProperty('state') &&
            !args.hasOwnProperty('neighborhood')) {
            this.valid = false;
            return;
        }
        this.id = parseInt(args.id);
        this.zipcode = args.zipcode;
        this.street = args.street;
        this.number = args.number;
        this.city = args.city;
        this.state = args.state;
        this.neighborhood = args.neighborhood;
        this.complement = (args.complement != undefined) ? args.complement : '';
        this.distance = (args.distance != undefined) ? parseInt(args.distance) : 0;
        this.duration = (args.duration != undefined) ? parseInt(args.duration) : 0;
        this.valid = true;
        var self = this;
        this.toString = function () {
            return self.street +  ' - ' + self.neighborhood + ', '
                + self.city + ' - ' + self.state + ', ' + self.zipcode;
        };
    }

    function Customer() {
        var args = arguments[0];
        if (!args.hasOwnProperty('id') &&
            !args.hasOwnProperty('name') &&
            !args.hasOwnProperty('telephone')) {
            this.valid = false;
            return;
        }
        var _self = this;
        this.id = parseInt(args.id);
        this.name = args.name;
        this.telephone = args.telephone;
        this.addresses = [];
        if (args.hasOwnProperty('addresses') && jQuery.isArray(args.addresses)) {
            args.addresses.forEach(function (addr) {
                _self.addresses.push(new Address(addr))
            });
        }
        this.valid = true;
        var self = this;
        this.toString = function () {
            return self.name + ' - ' + self.telephone;
        };
    }

    function CartItem() {
        var args = arguments[0];
        if (!args.hasOwnProperty('id') &&
            !args.hasOwnProperty('name') &&
            !args.hasOwnProperty('price') &&
            !args.hasOwnProperty('quantity') &&
            !args.hasOwnProperty('image_url')) {
            this.valid = false;
            return;
        }
        this.id = parseInt(args.id);
        this.name = args.name;
        this.price = parseFloat(args.price);
        this.quantity = parseInt(args.quantity);
        this.image_url = args.image_url;
        this.description = (args.description != undefined) ? args.description : '';
        this.observation = (args.observation != undefined) ? args.observation : '';
        this.valid = true;
        var self = this;
        this.getTotal = function () {
            return self.quantity * self.price;
        };
        this.toString = function () {
            return '<a name="item' + self.id + '"></a>\n' +
                '<div class="card mt-3">\n' +
                '  <div class="card-body p-2">\n' +
                '    <div class="row">\n' +
                // '      <div class="col-md-4">\n' +
                // '        <img src="' + self.image_url + '" class="card-img" alt="' + self.name + '">\n' +
                // '      </div>\n' +
                '      <div class="col-md-12">\n' +
                '        <h5 class="card-title mb-1">' + self.name + '</h5>\n' +
                '      </div>\n' +
                '    </div>\n' +
                '    <div class="row">\n' +
                '      <div class="col-md-12">\n' +
                '        <p class="card-text mb-0"><small class="text-muted">' + self.description + '</small></p>\n' +
                '        <p class="card-text mb-1"><small class="text-muted">' + self.observation + '</small></p>\n' +
                '        <p class="card-text">' + self.quantity + 'x' + formatCurrency(self.price) + '</p>\n' +
                '      </div>\n' +
                '    </div>\n' +
                '  </div>\n' +
                '</div>\n';
        }
    }

    /** helpers */
    function formatCurrency(value) {
        value = parseFloat(value).toFixed(2)
        return $('<input>').val(value)
            .mask('#.##0,00', {reverse: true})
            .val();
    };

    function myAlert(content, title) {
        if (typeof (title) === 'undefined') {
            title = '{{__('Attention')}}';
        }

        $('#toast-title').html(title);
        $('#toast-content').html(content);
        $('#my-alert').toast('show');
    }

    function whatsAppUrl(telephone) {
        var whatsAppApi = '{{App\Config::getWhatsappApi()}}';
        return whatsAppApi + telephone.replace(/[^\d]/g, '');
    }

    function mapsUrl(uri) {
        var mapsApi = '{{App\Config::getMapsApi()}}'
        return mapsApi + uri;
    }

    function whatsAppLink(telephone, message) {

        if (telephone.replace(/[^\d]/g, '').length !== 11) {
            return telephone;
        }
        if (typeof (message) === 'undefined') {
            message = '';
        }
        return '<a href="' + whatsAppUrl(telephone) + '&text=' + encodeURIComponent(message) + '" target="_blank"><i class="fab fa-whatsapp"></i> ' + telephone + '</a>';
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

    function findInArrayById(arr, id) {
        id = parseInt(id);
        for (var key in arr) {
            var currentObject = arr[key];
            if (currentObject.id === id) {
                return currentObject;
            }
        }
        return null;
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
