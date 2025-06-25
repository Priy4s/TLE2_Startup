<x-nav>
    <h1 class="text-6xl font-bold">Profile</h1>
    <div class="flex max-w-[78vw]">
        <div>
            @include('profile.partials.update-profile-information-form')
            @include('profile.partials.delete-user-form')
        </div>
        <div class="pl-[5vw] mt-10">
            <h2 class="text-xl font-medium text-viridian dark:text-greenLight">Connect with Google/Microsoft</h2>
            <div class="mt-4 flex items-center">
                @if(auth()->user()->google_refresh_token)
                    <div class="flex items-center space-x-4">
                        <span class="text-accentGreen">
                            <i class="fas fa-check-circle mr-2"></i>Google Connected
                        </span>
                        <!-- Disconnect Button -->
                        <form method="POST" action="{{ route('google.disconnect') }}">
                            @csrf
                            <button type="submit" class="px-3 py-1 text-sm text-red-600 hover:underline rounded">
                                Disconnect
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Connect Button -->
                    <a href="{{ route('google.login') }}"
                       class="px-4 py-2 bg-articleBlue text-viridian dark:bg-accentBlue dark:text-greenLight rounded-md hover:text-accentBlue dark:hover:text-articleBlue">
                        <i class="fab fa-google-drive mr-2"></i>Connect Google Drive
                    </a>
                @endif
            </div>
            <div class="mt-4 flex items-center">
                @if(auth()->user()->microsoft_refresh_token)
                    <div class="flex items-center space-x-4">
                        <span class="text-accentGreen">
                            <i class="fab fa-microsoft mr-2"></i>Microsoft Connected
                        </span>
                        <form method="POST" action="{{ route('microsoft.disconnect') }}">
                            @csrf
                            <button type="submit" class="px-3 py-1 text-sm text-red-600 hover:underline rounded">
                                Disconnect
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('microsoft.login') }}"
                       class="px-4 py-2 bg-articleBlue text-viridian dark:bg-accentBlue dark:text-greenLight rounded-md hover:text-accentBlue dark:hover:text-articleBlue">
                        <i class="fab fa-microsoft mr-2"></i>Connect to Microsoft
                    </a>
                @endif
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-12">
                @csrf
                <button type="submit" class="text-red-500 hover:text-red-700">
                    Logout
                </button>
            </form>
        </div>
    </div>
</x-nav>