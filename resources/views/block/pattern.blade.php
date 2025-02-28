<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>@yield('title')</title>
        <script defer type="module" src="/js/modal.js"></script>
		@yield('links')
	</head>
    <body>
        @yield('mainContent')
    </body>
</html>
