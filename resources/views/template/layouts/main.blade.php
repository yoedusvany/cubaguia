<!DOCTYPE html>

<html lang="en">

<head>

    @include('template.partials.1head')

</head>

<body>


@include('template.partials.2nav')

@include('template.partials.3intro')

<div id="app">
    @include('template.partials.4main')


    @yield('content')


    @include('template.partials.5footer')
</div>

@include('template.partials.6scripts')
</body>

</html>
