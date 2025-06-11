    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Profile') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <div class="mt-4 flex items-center">
                            @if(auth()->user()->google_refresh_token)
                                <div class="flex items-center space-x-4">
                <span class="text-green-600">
                    <i class="fas fa-check-circle mr-2"></i>Connected
                </span>

                                    <!-- Disconnect Button -->
                                    <form method="POST" action="{{ route('google.disconnect') }}">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 text-sm bg-black text-white hover:bg-gray-800 rounded">
                                            Disconnect
                                        </button>
                                    </form>
                                </div>
                            @else
                                <!-- Connect Button -->
                                <a href="{{ route('google.login') }}"
                                   class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800">
                                    <i class="fab fa-google-drive mr-2"></i>Connect Google Drive
                                </a>
                            @endif
                        </div>
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
