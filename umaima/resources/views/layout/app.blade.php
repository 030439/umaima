
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Default Title')</title>

    
@include('partials.header')
@include('partials.aside')
@include('partials.nav')
@yield('content')
@include('partials.footer')
@yield('files')
