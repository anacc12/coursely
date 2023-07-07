<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Coursely</title>
  <script>
    (function() {
      window.Laravel = {
        csrfToken: '{{ csrf_token() }}'
      };
    })();
  </script>
</head>

<body>
  <div id="app">
    @if (Auth::check())
    <App :user="{{ Auth::user() }}"></App>
    @else
    <App :user="false"></App>
    @endif
  </div>
</body>
<script src="{{ mix('js/app.js') }}"></script>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Inter", sans-serif;
  }
</style>

</html>



<!-- <!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Courses</title>
        <link href="http://fonts.cdnfonts.com/css/sofia-pro" rel="stylesheet">
       <script>
         (function(){
           window.Laravel = {
             csrfToken: '{{ csrf_token() }}'
           };
         })();
       </script>
    </head>
  <body>
    <h1>Page title</h1>
      <section class="c-section--primary">
        <h2 class="c-title">Section title</h2>
         <div class="c-card">
            <h3 class="c-card__title">Title</h3>
            <p class="c-card__description">Description</p>
         </div>
         <div class="c-card">
            <h3 class="c-card__title">Title</h3>
            <p class="c-card__description">Description</p>
         </div>
      </section> 
      <section class="c-section--primary">
        <h2 class="c-title">Section title</h2>
        <div class="c-card c-card--filled">
            <h3 class="c-card__title">Title</h3>
            <p class="c-card__description">Description</p>
         </div>
      </section> 
  </body>
</html> -->