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
                    <form action="/jobs/{{ $job->id }}" method="POST">
                        @method('PUT')
                        @csrf
                        
                        <div class="form-control">
                            <label class="block" for="title">Title:</label>
                            <input type="text" name="title" value="{{ $job->title }}" class="block mt-1 w-full">
                        </div>
                        <div class="form-control mt-4">
                            <label class="block" for="description">Description:</label>
                            <input type="text" rows="10" name="description" value="{{ $job->description }}" class="block mt-1 w-full">
                        </div>
                        <div class="form-control mt-4">
                            <label class="block" for="state">State:</label>
                            <select name="state" id="state" class="block mt-1 w-full">
                                @foreach ($states as $key => $value)
                                    <option value="{!! $key !!}" @if ($job->state == $key) selected="selected"  @endif>{!! $value !!}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-control mt-4">
                            <label class="block" for="user_id">Assign to:</label>
                            <select name="user_id" id="user_id" class="block mt-1 w-full">
                                @foreach ($users as $user)
                                    <option value="{!! $user["id"] !!}" @if ($job->user_id == $user["id"]) selected="selected" @endif>{!! $user["name"] !!}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button class="bg-blue hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Save Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>