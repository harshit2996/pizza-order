<!DOCTYPE html>
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
					<v-app-bar-nav-icon
						@click="drawer=!drawer"
						>
					</v-app-bar-nav-icon>
					<v-toolbar-title>
					<a href="{{ url('/') }}"><img src="/img/logo.png" height="48"  contain alt=""></a>
					</v-toolbar-title>
					<v-spacer></v-spacer>
				</v-app-bar>
				<v-main>
						<v-navigation-drawer
							v-model="drawer"
							fixed
							absolute
							>

						</v-navigation-drawer>
						<!-- <v-navigation-drawer
							v-model="rightdrawer"
							fixed
							absolute
							right
							>

						</v-navigation-drawer> -->
						@yield('content')
				</v-main>
			</v-app>
    </div>
		
</body>
</html>