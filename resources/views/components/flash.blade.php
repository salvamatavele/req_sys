@if (Session::has('success'))
<p
    x-data="{ show: true }"
    x-show="show"
    x-transition
    x-init="setTimeout(() => show = false, 4000)"
    class="text-sm text-green-800 dark:text-green-400"
>{{ Session::get('success') }}</p>
@endif
@if (Session::has('error')))
<p
    x-data="{ show: true }"
    x-show="show"
    x-transition
    x-init="setTimeout(() => show = false, 4000)"
    class="text-sm text-red-600 dark:text-red-400"
>{{ Session::get('error') }}</p>
@endif
