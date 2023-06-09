@extends('layouts.admin')

@section('content')




<div class="card">

    <div class="card-header">

        {{ trans('global.show') }} {{ trans('cruds.todo.title') }}

    </div>




    <div class="card-body">

        <div class="form-group">

            <div class="form-group">

                <a class="btn btn-default" href="{{ route('admin.todos.index') }}">

                    {{ trans('global.back_to_list') }}

                </a>

            </div>

            <table class="table table-bordered table-striped">

                <tbody>

                    <tr>

                        <th>

                            {{ trans('cruds.todo.fields.id') }}

                        </th>

                        <td>

                            {{ $todo->id }}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            {{ trans('cruds.todo.fields.task') }}

                        </th>

                        <td>

                            {{ $todo->task->name ?? '' }}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            {{ trans('cruds.todo.fields.due_date') }}

                        </th>

                        <td>

                            {{ $todo->due_date }}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            {{ trans('cruds.todo.fields.notes') }}

                        </th>

                        <td>

                            {!! $todo->notes !!}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            {{ trans('cruds.todo.fields.status') }}

                        </th>

                        <td>

                            {{ App\Models\Todo::STATUS_RADIO[$todo->status] ?? '' }}

                        </td>

                    </tr>

                </tbody>

            </table>

            <div class="form-group">

                <a class="btn btn-default" href="{{ route('admin.todos.index') }}">

                    {{ trans('global.back_to_list') }}

                </a>

            </div>

        </div>

    </div>

</div>










@endsection