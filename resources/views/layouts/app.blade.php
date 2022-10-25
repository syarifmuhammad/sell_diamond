<!DOCTYPE html>
<html>    
	<head>        
		<title>@yield('title')</title>  
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @include('layouts.meta')
	</head>    
	<body class="d-flex flex-column min-vh-100 text-white">
        @include('layouts.header')
		<div class="container" style="margin-top:100px;">            
			@yield('content')        
		</div>    
        @include('layouts.footer')
		<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
		@yield('scripts')
	</body>
</html>
