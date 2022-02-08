<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ $page }} | SIMPLEWEB</title>

  {{-- TAILWINDCSS/JS --}}
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <script src="{{ asset('js/app.js') }}"></script>
</head>
<body class="bg-gray-100">

  {{-- navigation --}}
  @include('templates.nav')
  {{-- navigation --}}

  {{-- live notification --}}
  <div id="notification" class="fixed top-40 left-0 w-48"></div>

  {{-- audio notification --}}
  <audio src="{{ asset('music/notif.mp3') }}" id="myAudio" class="hidden" preload="none"></audio>
  {{-- end of notification --}}

  {{-- Main Content --}}
  <div class="min-h-screen flex justify-center items-center gap-4 pt-36">
    @yield('content')
  </div>
  {{-- End of Main Content --}}


  <script>
    // variable notification
    const notifEl = document.getElementById('notification');
    const audioEl = document.getElementById('myAudio');
  
    //laravel echo listening to notification by pusher
    Echo.channel('global-notif')
    .listen('SendGlobalNotification', function(data) {
        popOutNotification(data.message);
    });

    // utilities audio
    function playAudio() 
    {
      audioEl.play();
    }

    function stopAudio()
    {
      audioEl.pause();
      audioEl.src = audioEl.src;
    }

    //interval to remove first child to prevent massive notification stuck
    setInterval(function(){
        notifEl.removeChild(notifEl.childNodes[0])
      },10000);
  </script>
</body>
</html>