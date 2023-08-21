@if (Session::has('success'))
    <div class="flex justify-between text-green-200 shadow-inner rounded p-3 bg-green-600">
        <p class="self-center">
            {{ Session::get('success') }}
        </p>
        <strong class="text-xl align-center cursor-pointer alert-del">&times;</strong>
    </div>
@endif
@if (Session::has('error'))
    )
    <div class="flex justify-between text-red-200 shadow-inner rounded p-3 bg-red-600">
        <p class="self-center">{{ Session::get('error') }}</p>
        <strong class="text-xl align-center cursor-pointer alert-del">&times;</strong>
    </div>
@endif
