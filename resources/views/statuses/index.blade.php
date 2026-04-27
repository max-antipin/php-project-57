@extends('layouts.app')
@section('content')

<div class="grid col-span-full">
    <h1 class="max-w-2xl mb-4 text-4xl leading-none tracking-tight md:text-5xl xl:text-6xl dark:text-white">
        @lang('layouts.app.statuses')</h1>
    @auth()
    <div>
        @csrf
        <a href="{{ route('statuses.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            @lang('layouts.task.status_create')</a>
    </div>
    @endauth
    <table class="mt-4">
        <thead class="border-b-2 border-solid border-black text-left" style="text-align: left">
        <tr>
            <th>@lang('layouts.table.id')</th>
            <th>@lang('layouts.table.name')</th>
            <th>@lang('layouts.table.date_of_creation')</th>
            @auth()
            <th>@lang('layouts.table.actions')</th>
            @endauth
        </tr>
        </thead>
        <tbody>
        @foreach($taskStatuses as $taskStatus)
        <tr class="border-b border-dashed text-left">
            <td>{{ $taskStatus->id }}</td>
            <td>{{ $taskStatus->name }}</td>
            <td>{{ $taskStatus->created_at }}</td>
            @auth()
            <td>
                <a
                    class="text-red-600 hover:text-red-900"
                    rel="nofollow"
                    data-method="delete"
                    data-confirm="@lang('layout.table_delete_question')"
                    href="{{ route('statuses.destroy', $taskStatus) }}"
                >
                    @lang('layouts.table.delete')
                </a>
                <a class="text-blue-600 hover:text-blue-900" href="{{ route("statuses.edit", $taskStatus) }}">
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
    <div class="mt-4 grid col-span-full">{{ $taskStatuses->links() }}</div>
@endauth
@endsection
