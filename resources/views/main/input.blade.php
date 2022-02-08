@extends("main.layout")

@section('content')
  <div class="rounded-lg shadow-lg overflow-hidden bg-white">
    <h1 class="py-4 px-8 text-lg font-semibold mb-4 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white">Data No Handphone</h1>

    {{-- error message when fetching data from API failed --}}
    <p class="text-red-900 bg-red-500" id="notification"></p>

    {{-- flash message for success message --}}
    @if(session('message'))
    <p class="bg-green-100 text-green-800 m-1 text-center">{{ session('message') }}</p>
    @endif

    {{-- flash message for error message --}}
    @if(session('error'))
    <p class="bg-red-100 text-red-800 m-1 text-center">{{ session('error') }}</p>
    @endif

    {{-- form to add new phone number --}}
    <form action="{{ route('add.phone') }}" method="POST" class="p-4">
      @csrf
      {{-- phone number input --}}
      <div class="mb-1 flex flex-col items-stretch gap-2 px-3 py-1">
        <label for="nohandphone" class="font-semibold">No Handphone</label>
        <input type="tel" name="nohandphone" id="nohandphone" pattern="[0-9]*" class="outline-none border-2 p-2 rounded placeholder:italic" placeholder="Ex:0812.....">
      </div>
      @error('nohandphone')
      <span class="text-red-600 text-sm">* {{ $message }}</span>
      @enderror

      {{-- provider selection input --}}
      <div class="mb-1 flex flex-col items-stretch gap-2 px-3 py-1">
        <label for="provider" class="font-semibold">Provider</label>
        <select name="provider" id="provider" class="outline-none border-2 p-2 rounded bg-white">
          <option value="xl">XL</option>
          <option value="telkomsel">Telkomsel</option>
          <option value="tri">TRI</option>
        </select>
      </div>

      {{-- action (Save/Generate random number) --}}
      <div class="mt-3 flex justify-end px-3 py-1 gap-4">
        <button type="submit" class="transition ease-in-out p-2 rounded bg-green-400 hover:bg-green-600 text-white ">Save</button>
        <button type="button" onclick="getRandomPhone()"  class="transition ease-in-out p-2 rounded bg-blue-400 hover:bg-blue-600 text-white ">Auto</button>
      </div>
    </form>
    {{-- end of form --}}
  </div>

  <script>
    // variable DOM
    const phoneEl = document.getElementById('nohandphone')
    const providerEl = document.getElementById('provider')
    const notificationEl = document.getElementById('notification')
  
    // fetching generate random phone number from .../api/phone
    function getRandomPhone() {
      axios.get('http://127.0.0.1:8000/api/phone')
      .then(response => {
        phoneEl.value = response.data.nohandphone
        providerEl.value = response.data.provider
      }).catch(error => {
        notificationEl.innerText = "Sorry, can't fecth data ..."
      })
    }

    // pop up notification from pusher
    function popOutNotification(msg) {
      stopAudio();
      let p = document.createElement('p');
      p.classList.add('animate-bounce', 'bg-green-400', 'bg-opacity-50', 'text-green-800', 'p-4');
      p.innerText = msg;
      notifEl.appendChild(p);
      playAudio();
    }
  </script>
@endsection