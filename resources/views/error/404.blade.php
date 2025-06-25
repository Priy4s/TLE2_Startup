<x-nav>
    <div class="flex flex-col items-center justify-center text-center h-full">

        <h1 class="text-9xl font-extrabold text-viridian dark:text-greenLight tracking-widest">404</h1>

            <div class="px-4 py-2 bg-accentBlue text-white rounded-lg font-semibold rotate-12 absolute ">

            Page not found
        </div>

        <div class="mt-8">
            <p class="text-2xl font-light mb-6">
                Oops! we couldn't find the page your looking for!
            </p>
            <a href="{{ url('/') }}"
               class="px-8 py-3 bg-accentBlue text-white rounded-lg font-semibold hover:bg-opacity-90 transition-colors duration-200">
                Back
            </a>
        </div>

    </div>
</x-nav>