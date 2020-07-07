<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
			<v-app>
				<v-app-bar
					app
					>

					<v-toolbar-title >
						<a href="{{ url('/') }}"><img src="/img/logo.png" height="48"  contain alt=""></a>
					</v-toolbar-title>
					<v-spacer></v-spacer>
					<!-- <ul class="navbar-nav ml-auto"> -->
							<!-- Authentication Links -->
							<!-- @guest
									<li class="nav-item">
											<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
									</li>
									@if (Route::has('register'))
											<li class="nav-item">
													<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
											</li>
									@endif
							@else
									<li class="nav-item dropdown">
											<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
													{{ Auth::user()->name }} <span class="caret"></span>
											</a>

											<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
													<a class="dropdown-item" href="{{ route('logout') }}"
															onclick="event.preventDefault();
																						document.getElementById('logout-form').submit();">
															{{ __('Logout') }}
													</a>

													<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
															@csrf
													</form>
											</div>
									</li>
							@endguest
					</ul> -->
					<profile-menu></profile-menu>
					<v-app-bar-nav-icon
						@click="rightdrawer=!rightdrawer"
						
						>
						<v-badge
								color="green"
								:value="numItems"
								:content="numItems"
								overlap
							>
							<v-icon>mdi-cart</v-icon>
						</v-badge>
					</v-app-bar-nav-icon>
				</v-app-bar>
				<v-main>
						@yield('content')
				</v-main>
			</v-app>
    </div>
</body>
</html>
