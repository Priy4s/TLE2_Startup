<x-nav>
    <div class="flex flex-col items-center justify-center text-center h-full">

        <h1 class="text-9xl font-extrabold text-viridian dark:text-greenLight tracking-widest">404</h1>

        <div class="bg-accentBlue dark:bg-articleBlue px-2 text-sm text-white rounded rotate-12 absolute">
            Pagina Niet Gevonden
        </div>

        <div class="mt-8">
            <p class="text-2xl font-light mb-6">
                Oeps! We konden de pagina die je zoekt niet vinden.
            </p>
            <a href="{{ url('/') }}"
               class="px-8 py-3 bg-accentBlue text-white rounded-lg font-semibold hover:bg-opacity-90 transition-colors duration-200">
                Terug naar de Homepage
            </a>
        </div>

    </div>
</x-nav>