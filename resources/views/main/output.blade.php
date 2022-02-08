@extends('main.layout')

@section('content')
  {{-- container output --}}
  <div class="rounded-lg shadow-lg overflow-hidden bg-white">
    <h1 class="py-4 px-8 text-lg font-semibold mb-4 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white">Output</h1>

    {{-- flash message when success --}}
    @if(session('message'))
    <p class="bg-green-200 text-green-600 p-1 text-center font-semibold">{{ session('message') }}</p>
    @endif

    {{-- flash message when error --}}
    @if(session('error'))
    <p class="bg-red-200 text-red-600 p-1 text-center font-semibold">{{ session('error') }}</p>
    @endif

    {{-- Data Odd & Even --}}
    <div class="p-2 flex justify-center">
      <div id="ganjil" class="border-r-4 border-gray-200 pr-4">
        <h1 class="py-4 px-8 text-center text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 font-bold">Ganjil</h1>
        <table class="table-auto overflow-hidden">
          <thead>
            <tr class="text-bold">
              <th class="p-2">No</th>
              <th class="p-2">Provider</th>
            </tr>
          </thead>
          <tbody id="dataOdd">
          </tbody>
        </table>
      </div>
      <div id="genap" class="pl-4">
        <h1 class="py-4 px-8 text-center text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 font-bold">Genap</h1>
        <table class="table-auto overflow-hidden">
          <thead>
            <tr class="text-bold">
              <th class="p-2">No</th>
              <th class="p-2">Provider</th>
            </tr>
          </thead>
          <tbody id="dataEven">
          </tbody>
        </table>
      </div>
    </div>

    {{-- Modified Trigger container --}}
    <div class="flex gap-4 justify-end p-4">
      <button type="button" onclick="toggleEditForm()" class="p-2 rounded-lg scale-90 hover:scale-100 shadow-lg transition ease-in-out bg-blue-500 text-white hover:bg-blue-600">Modify Data</button>
    </div>
  </div>

  {{-- container form edit/delete --}}
  <div id="edit" class="hidden rounded-lg shadow-lg overflow-hidden bg-white">
    <h1 class="py-4 px-8 text-lg font-semibold mb-4 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white">Edit</h1>
    
    {{-- searching number form --}}
    <form action="" method="GET" id="searchEdit">
      <div class="flex flex-col gap-2 p-2">
        <label for="searchphone">Search Number</label>
        <input type="search" name="searchphone" id="searchphone" placeholder="Ex.08######" class="placeholder:italic outline-none py-2 px-4 rounded-lg border-2 border-gray-400">
      </div>
    </form>

    <div class="flex flex-col gap-2 p-2">
      <p class="text-gray-600 italic" id="notifEdit"></p>

      {{-- form edit data --}}
      <form action="" method="POST" class="hidden" id="formEdit">
        @csrf
        <input type="hidden" name="id" id="id_phone">
        <div class="flex flex-col gap-2">
          <label for="phone">No Handphone</label>
          <input type="tel" name="phone" id="phone" pattern="[0-9]*" class="placeholder:italic outline-none py-1 px-2 rounded-lg border-2 border-gray-400">
        </div>
        <div class="flex flex-col gap-2">
          <label for="provider">Provider</label>
          <select name="provider" id="provider" class="placeholder:italic outline-none py-1 px-2 rounded-lg border-2 border-gray-400 bg-white">
            <option value="xl">XL</option>
            <option value="telkomsel">Telkomsel</option>
            <option value="tri">TRI</option>
          </select>
        </div>
        <div class="flex justify-end mt-3">
          <button type="submit" class="p-2 text-white transition ease-in-out rounded-lg scale-90 hover:scale-100 bg-blue-400 hover:bg-blue-600">Save</button>
          <button type="button" onclick="toggleModal()" class="p-2 text-white transition ease-in-out rounded-lg scale-90 hover:scale-100 bg-red-400 hover:bg-red-600">Delete</button>
        </div>
      </form>

      {{-- Modal pop up for delete decision --}}
      <div class="hidden justify-center items-center fixed inset-0 bg-black bg-opacity-20" id="modal1">
        <div class=" bg-gray-700 rounded-lg px-10 py-5 flex flex-col justify-center items-center">
          <img src="{{ asset('images/warning-white.png') }}" alt="Warning (Delete)" class="h-14 w-14">
          <h1 class="text-gray-400 text text-center">Are you sure you want to delete<br>this Phone Number ?</h1>
          <form action="{{ route('delete.phone') }}" method="POST">
            @csrf
            @method('delete')
            <input type="hidden" name="id_phone" id="id_phone_delete">
            <div class="flex gap-4 justify-center items-center mt-4">
              <button type="submit" class="scale-90 hover:scale-100 text-white bg-red-400 hover:bg-red-600 rounded-lg shadow-lg transition ease-in-out px-4 py-2 text-lg">Yes, I'm sure</button>
              <button type="button" onclick="toggleModal()" class="scale-90 hover:scale-100 text-white bg-transparent border-2 border-gray-200 hover:bg-gray-600 rounded-lg shadow-lg transition ease-in-out px-4 py-2 text-lg">No, Cancel</button>
            </div>
          </form>
        </div>
      </div>

      {{-- Modal pop up for success update data --}}
      <div class="hidden justify-center items-center fixed inset-0 bg-black bg-opacity-10" id="modal2">
        <div class="shadow-lg bg-white rounded-lg  flex flex-col justify-center items-center">
          <div class="px-4 py-5">
            <img src="{{ asset('images/green-check.png') }}" alt="Succes Update Sign" class="h-14 w-14">
          </div>
          <h1 class="text-white text text-center mt-2 p-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">SUCCESS UPDATED DATA</h1>
        </div>
      </div>
    </div>
  </div>

  <script>

    // DOM data odd&even
    const dataOddEl = document.getElementById('dataOdd');
    const dataEvenEl = document.getElementById('dataEven');

    // DOM edit/delete container
    const editFormEl = document.getElementById('edit');

    // DOM Edit & elemen input
    const searchEditFormEl = document.getElementById('searchEdit');
    const searchPhoneEl = document.getElementById('searchphone');

    // Variable Edit Form
    const formEditEl = document.getElementById('formEdit');
    const phoneEditEl = document.getElementById('phone');
    const providerEditEl = document.getElementById('provider');
    const idEditEl = document.getElementById('id_phone');

    // variable for deleting data
    const idDeleteEl = document.getElementById('id_phone_delete');

    // variable notification for edit
    const notifEditEl = document.getElementById('notifEdit');

    // modal element
    const modalEl = document.getElementById('modal1');
    const modal2El = document.getElementById('modal2');
    
    // get data odd&even from api
    function getDataOddEven()
    {
      axios.get('http://127.0.0.1:8000/api/oddevenphone')
      .then(response => {
        dataOddEl.innerHTML = "";
        dataEvenEl.innerHTML = "";
        response.data.oddNumbers.forEach(function(number){
          let parent = document.createElement('tr');
          let i = `
              <td class="p-2">${number[0]}</td>
              <td class="p-2">${number[1]}</td>
          `;
          parent.innerHTML = i;
          dataOddEl.appendChild(parent);
        })
        response.data.evenNumbers.forEach(function(number){
          let parent = document.createElement('tr');
          let i = `
              <td class="p-2">${number[0]}</td>
              <td class="p-2">${number[1]}</td>
          `;
          parent.innerHTML = i;
          dataEvenEl.appendChild(parent);
        })
      })
    }

    // toggle modal1 (Delete Modal)
    function toggleModal()
    {
      modalEl.classList.toggle('hidden');
      modalEl.classList.toggle('flex');
    }

    // toggle modal2 (Success Modal)
    function toggleModal2()
    {
      modal2El.classList.toggle('hidden');
      modal2El.classList.toggle('flex');
      setTimeout(function(){
        modal2El.classList.toggle('hidden');
        modal2El.classList.toggle('flex');
      }, 2000);

    }

    // toggle Form Edit
    function toggleEditForm()
    {
      editFormEl.classList.toggle('hidden');
    }


    // searching phone number API
    searchEditFormEl.addEventListener('submit', function(e){
      e.preventDefault();
      notifEditEl.innerText = "";
      formEditEl.classList.add('hidden');
      //get phone data
      axios.get('http://127.0.0.1:8000/api/phonenumber?searchphone=' + searchPhoneEl.value)
      .then(response => {
        // console.log(response);
        if(Object.keys(response.data).length > 0){
          formEditEl.classList.remove('hidden');
          idEditEl.value = response.data.id;
          idDeleteEl.value = response.data.id;
          phoneEditEl.value = response.data.nohandphone;
          providerEditEl.value = response.data.provider;
        }else{
          notifEditEl.innerText = "Data Not Found";
        }
      }).catch(error => {
        notifEditEl.innerText = "Sorry, can't fecth data ..."
      })

    })
    
    // update phone number API
    formEditEl.addEventListener('submit', function(e){
      e.preventDefault();
      axios.post('http://127.0.0.1:8000/api/update', {
        id: idEditEl.value,
        phone: phoneEditEl.value,
        provider: providerEditEl.value,
      })
      .then(response => {
        toggleModal2();
      })
      .catch(error => {

      })
    })

    //refresh when there is data update
    // load data
    getDataOddEven();

    // push notification with fetching new data
    function popOutNotification(msg) {
      stopAudio();
      let p = document.createElement('p');
      p.classList.add('animate-bounce', 'bg-green-400', 'bg-opacity-50', 'text-green-800', 'p-4');
      p.innerText = msg;
      notifEl.appendChild(p);
      getDataOddEven();
      playAudio();
    }
  </script>
@endsection