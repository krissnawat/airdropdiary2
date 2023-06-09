@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.activity.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Activity">
                            <thead>
                                <tr>
                                
                                    <th>
                                        {{ trans('cruds.activity.fields.task') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.activity.fields.total_interact') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.activity.fields.total_amount') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.activity.fields.total_gas_spend') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.activity.fields.done') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activities as $key => $activity)
                                    <tr data-entry-id="{{ $activity->id }}">
                                      
                                        <td>
                                            {{ $activity->task->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $activity->total_interact ?? '' }}
                                        </td>
                                        <td>
                                            {{ $activity->total_amount ?? '' }}
                                        </td>
                                        <td>
                                            {{ $activity->total_gas_spend ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\Models\Activity::DONE_RADIO[$activity->done] ?? '' }}
                                        </td>
                                        <td>
                                            @can('activity_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.activities.show', $activity->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('activity_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.activities.edit', $activity->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('activity_delete')
                                                <form action="{{ route('frontend.activities.destroy', $activity->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                </form>
                                            @endcan

                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('activity_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.activities.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Activity:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection