<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
  <div class="min-h-screen flex justify-center items-center bg-gray-50">
    <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded p-5 shadow-lg shadow-gray-400 text-center">
      <h1 class="text-white text-2xl font-semibold p-3 border-b-4 w-96 mb-4">LOGIN</h1>
      <a href="{{ '/auth/redirect' }}" class="bg-white flex items-center gap-2 justify-center p-2 shadow-lg rounded transition ease-in-out delay-150 scale-90 hover:-translate-y-1 hover:scale-100">
        <img 
        src="{{ asset('images/google-icon.png') }}"
        class="w-12 h-12 object-cover"
        alt="Google Signin">
        Sign In with Google
      </a>
    </div>
  </div>
</body>
</html>