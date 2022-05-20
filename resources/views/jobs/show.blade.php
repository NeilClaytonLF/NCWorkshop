<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-back-button />
            {{ __('Job Details') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-xl"><strong> {{ $job->title }} </strong></h1>
                    <strong>Description: </strong> {{$job->description}} <br>
                    <strong>Status: </strong> {{ $job->state }} <br>
                    <strong>Assigned to: </strong> {{$job->user->name}} <br>
                    <div class="mt-4">
                        <a style="background: blue;" class="hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="/jobs/{{ $job->id }}/edit">Edit</a>
                    </div>
                    <form class="mt-4" action="/jobs/{{$job->id}}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button 
                            style="background: red"
                            class="bg-blue hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" 
                            type="submit"
                            onclick="return confirm('Are you sure you want to delete this job?');">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>