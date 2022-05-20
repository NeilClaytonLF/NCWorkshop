<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-back-button />
            {{ __('User Details') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-xl"><strong> {{ $user->name }} </strong></h1>
                    <strong>Email: </strong> {{$user->email}} <br>
                    <strong>Permissions: </strong> {{ Str::ucfirst($role) }} <br>
                    <div class="mt-4">
                        <a style="background: blue;" class="hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="/users/{{ $user->id }}/edit">Edit</a>
                    </div>
                    <form class="mt-4" action="/users/{{$user->id}}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button 
                            style="background: red"
                            class="bg-blue hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" 
                            type="submit"
                            onclick="return confirm('Are you sure you want to delete this User?');">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>