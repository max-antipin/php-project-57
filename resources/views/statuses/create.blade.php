@extends('layouts.app')
@section('content')

@auth()
    <div class="grid col-span-full">
        <h1 class="max-w-2xl mb-4 text-4xl leading-none tracking-tight md:text-5xl xl:text-6xl dark:text-white">@lang('layouts.task.status_create')</h1>

        <form action="{{ route('statuses.store') }}" method="POST" class="w-50">
            @csrf

            <div class="flex flex-col">
                <div>
                    <label for="name">@lang('layouts.table.name')</label>
                </div>

                <div class="mt-2">
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="form-control rounded border-gray-300 w-1/3"
                    >
                </div>

                <div>
                    @error('name')
                        {{ $message }}
                    @enderror
                </div>

                <div class="mt-2">
                    <button
                        type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    >
                        {{ __('layout.create_button') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endauth

@endsection
