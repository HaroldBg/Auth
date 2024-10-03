@php use Carbon\Carbon; @endphp
@vite('resources/css/app.css')
<section class="max-w-2xl px-6 py-8 mx-auto bg-white dark:bg-gray-900 mt-8">
    <header>
        <a href="#">
            <img class="w-auto h-7 sm:h-8" src="https://cdn.rareblocks.xyz/collection/celebration/images/logo.svg"
                 alt="">
        </a>
    </header>

    <main class="mt-8">
        <h2 class="text-black">Hi <span class=" font-semibold">{{$name}}</span>,</h2>

        <p class="mt-2 leading-loose text-gray-600 dark:text-gray-300">
            Your account is sucessfully created on <span class="font-semibold ">Postcrafts</span>.
        </p>

        <a href="{{$link}}"
            class="px-6 py-2 mt-2 text-sm font-medium tracking-wider text-white capitalize transition-colors duration-300 transform bg-blue-600  border border-transparent rounded-md hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
            Accept the invite
        </a>

        <p class="mt-8 text-gray-600 dark:text-gray-300">
            Thanks, <br>
            Meraki UI team
        </p>
    </main>


    <footer class="mt-8">
        <p class="text-gray-500 dark:text-gray-400">
            This email was sent to <a href="#" class="text-blue-600 hover:underline dark:text-blue-400" target="_blank">contact@merakiui.com</a>.
            If you'd rather not receive this kind of email, you can <a href="#"
                                                                       class="text-blue-600 hover:underline dark:text-blue-400">unsubscribe</a>
            or <a href="#" class="text-blue-600 hover:underline dark:text-blue-400">manage your email preferences</a>.
        </p>

        <p class="mt-3 text-gray-500 dark:text-gray-400">© {{ Carbon::now()->format('Y')}} Meraki UI. All Rights
            Reserved.</p>
    </footer>
</section>
