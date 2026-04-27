@extends('layouts.app')
@section('content')

<div class="grid col-span-full">
    <h1 class="max-w-2xl mb-4 text-4xl leading-none tracking-tight md:text-5xl xl:text-6xl dark:text-white">
        @lang('layouts.app.labels')</h1>
    @auth()
    <div>
        @csrf
        <a href="{{ route('labels.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            {{ __('layout.create_button_label') }}</a>
    </div>
    @endauth
    <table class="mt-4">
        <thead class="border-b-2 border-solid border-black text-left" style="text-align: left">
        <tr>
            <th>@lang('layouts.table.id')</th>
            <th>@lang('layouts.table.name')</th>
            <th>@lang('layouts.table.description')</th>
            <th>@lang('layouts.table.date_of_creation')</th>
            @auth()
            <th>@lang('layouts.table.actions')</th>
            @endauth
        </tr>
        </thead>
        <tbody>
        @foreach($labels as $label)
        <tr class="border-b border-dashed text-left">
            <td>{{ $label->id }}</td>
            <td>{{ $label->name }}</td>
            <td>{{ $label->description }}</td>
            <td>{{ $label->created_at }}</td>
            @auth()
            <td>
                <a
                    class="text-red-600 hover:text-red-900"
                    rel="nofollow"
                    data-method="delete"
                    data-confirm="{{ __('layout.table_delete_question') }}"
                    href="{{ route('labels.destroy', $label) }}"
                >
                    @lang('layouts.table.delete')
                </a>
                <a class="text-blue-600 hover:text-blue-900" href="{{ route("labels.edit", $label) }}">
                    @lang('layouts.table.edit')
                </a>
            </td>
            @endauth
        </tr>
            @endforeach
        </tbody>
    </table>
</div>
@auth()
    <div class="mt-4 grid col-span-full">{{ $labels->links() }}</div>
@endauth
@endsection
