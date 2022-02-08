<nav class="fixed top-0 left-0 right-0 py-4 px-10 flex text-white justify-between items-center bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 shadow-lg">
  <a href="/" class="text-2xl font-semibold text-white">SIMPLE WEB</a>
  <div class="flex gap-5 items-center">
    <a href="{{ route('index.input') }}" class="transition ease-in-ou duration-100 p-2 rounded hover:bg-gray-400  @if($page == 'INPUT') bg-white text-blue-400 @endif">Input</a>
    <a href="{{ route('index.output') }}" class="transition ease-in-ou duration-100 p-2 rounded hover:bg-gray-400 @if($page == 'OUTPUT') bg-white text-blue-400 @endif">Output</a>
    <form action="{{ route('auth.logout') }}" method="POST">
      @csrf
      <button type="submit" class="text-gray-400 underline hover:text-white">Logout</button>
    </form>
  </div>
</nav>