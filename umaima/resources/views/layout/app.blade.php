
    









<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact " dir="ltr" data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template" data-style="light">
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title', 'Default Title')</title>
    @include('partials.header')
  <body>
<div class="layout-wrapper layout-content-navbar  ">
  <div class="layout-container">

  <div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer" style="color:#fff !important"></div>
    
  <x-sidebar/>
     <div class="layout-page">
      @include('partials.nav')
      @yield('content')
      @include('partials.footer')
      @yield('files') 
  </body>
</html>


