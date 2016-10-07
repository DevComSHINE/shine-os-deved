<!DOCTYPE html>
<html>
  <head>
      @include('partials.head')
  </head>
  <body class="skin-blue">
    <div class="wrapper">
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
         @yield('page-header')

        <section class="content">
          @yield('content')
        </section>
      </div>
    </div>

    @include('partials.footer')
  </body>
</html>
