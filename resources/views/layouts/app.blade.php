<!DOCTYPE html>
<html lang="{{ str_replace(" _", "-" , app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config("app.name", "Laravel") }}</title>

	<!-- Fonts -->
	<link rel="preconnect" href="https://fonts.bunny.net">
	<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

	<!-- Scripts -->
	@vite(["resources/css/app.css", "resources/js/app.js"])
	<script src="{{ asset(" js/lang.js") }}" defer></script>
	<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v3.x.x/dist/alpine.min.js"></script>

	<!-- Styles -->
	@livewireStyles
</head>

<body class="font-sans antialiased">
	<div class="min-h-screen bg-gray-100">
		<livewire:layout.navigation />

		<!-- Page Heading -->
		@if (isset($header))
		<header class="bg-white shadow">
			<div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
				{{ $header }}
			</div>
		</header>
		@endif

		<!-- Page Content -->
		<main>
			{{ $slot }}
			<script>
				document.addEventListener('livewire:init', () => {
				  Livewire.on('log', (event) => {
					try{
					  console[event[0].level](event[0].obj);
					}
					catch{
					  console.log(event[0]);
					}
				  });
				});
			</script>
		</main>
	</div>
	@livewire("wire-elements-modal")
	@livewireScripts
	{{-- <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v1.x.2x/dist/livewire-sortable.js"></script> --}}
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<x-livewire-alert::scripts />

</body>

</html>