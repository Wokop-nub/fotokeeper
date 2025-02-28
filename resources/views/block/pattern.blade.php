<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>@yield('title')</title>
        {{-- <script defer type="module" src="/js/auth/modal.js"></script> --}}
        <link rel="stylesheet" href="/css/album.css">
		@yield('links')
	</head>
    <body>
        @yield('mainContent')
    </body>
</html>
