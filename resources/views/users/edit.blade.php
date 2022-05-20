<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-back-button />
            {{ __('Edit Job') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @if(Session::has('message'))
                        <div class="alert alert-success" role="alert">
                            <strong>{!! session('message') !!}</strong>
                        </div>
                    @endif
                    @if($errors->any() )
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li> {{ $error }} </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="/users/{{ $user->id }}" method="POST">
                        @method('PUT')
                        @csrf

                        <div class="form-control">
                            <label class="block" for="name">Name:</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="block mt-1 w-full">
                        </div>
                        <div class="form-control mt-4">
                            <label class="block" for="email">Email:</label>
                            <input type="text" rows="10" name="email" value="{{ $user->email }}" class="block mt-1 w-full">
                        </div>
                        <div class="form-control mt-4">
                            <label class="block" for="role">User Permissions:</label>
                            <select name="role" id="role" class="block mt-1 w-full">
                                @foreach ($userRoles as $userRole)
                                    <option value="{!! $userRole['name'] !!}" @if ($role == $userRole['name']) selected="selected"  @endif>{!! Str::ucfirst($userRole['name']) !!}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-control mt-4">
                            <label class="block" for="password">Password:</label>
                            <input type="password" rows="10" name="password" class="block mt-1 w-full">
                        </div>
                        <div class="form-control mt-4">
                            <label class="block" for="password_confirmation">Confirm Password:</label>
                            <input type="password" rows="10" name="password_confirmation" class="block mt-1 w-full">
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button style="background: blue" class="bg-blue hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Save Edit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>