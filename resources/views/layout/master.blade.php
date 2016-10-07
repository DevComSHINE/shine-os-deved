<!DOCTYPE html>
<html>
  <head>
      @include('partials.head')
  </head>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            @include('partials.headernav')
        </header>
        <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        @include('partials.sidebar')
      </aside>
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
