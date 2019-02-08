@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.courses.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.courses.fields.teacher')</th>
                            <td field-key='teacher'>
                                @foreach ($course->teacher as $singleTeacher)
                                    <span class="label label-info label-many">{{ $singleTeacher->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.courses.fields.title')</th>
                            <td field-key='title'>{{ $course->title }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.courses.fields.slug')</th>
                            <td field-key='slug'>{{ $course->slug }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.courses.fields.description')</th>
                            <td field-key='description'>{!! $course->description !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.courses.fields.price')</th>
                            <td field-key='price'>{{ $course->price }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.courses.fields.start-date')</th>
                            <td field-key='start_date'>{{ $course->start_date }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.courses.fields.published')</th>
                            <td field-key='published'>{{ Form::checkbox("published", 1, $course->published == 1 ? true : false, ["disabled"]) }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    
<li role="presentation" class="active"><a href="#topics" aria-controls="topics" role="tab" data-toggle="tab">Topics</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    
<div role="tabpanel" class="tab-pane active" id="topics">
<table class="table table-bordered table-striped {{ count($topics) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.topics.fields.course')</th>
                        <th>@lang('quickadmin.topics.fields.title')</th>
                        <th>@lang('quickadmin.topics.fields.slug')</th>
                        <th>@lang('quickadmin.topics.fields.description')</th>
                        <th>@lang('quickadmin.topics.fields.possition')</th>
                        <th>@lang('quickadmin.topics.fields.free-lesson')</th>
                        <th>@lang('quickadmin.topics.fields.published')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($topics) > 0)
            @foreach ($topics as $topic)
                <tr data-entry-id="{{ $topic->id }}">
                    <td field-key='course'>{{ $topic->course->title ?? '' }}</td>
                                <td field-key='title'>{{ $topic->title }}</td>
                                <td field-key='slug'>{{ $topic->slug }}</td>
                                <td field-key='description'>{!! $topic->description !!}</td>
                                <td field-key='possition'>{{ $topic->possition }}</td>
                                <td field-key='free_lesson'>{{ Form::checkbox("free_lesson", 1, $topic->free_lesson == 1 ? true : false, ["disabled"]) }}</td>
                                <td field-key='published'>{{ Form::checkbox("published", 1, $topic->published == 1 ? true : false, ["disabled"]) }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    @can('topic_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.topics.restore', $topic->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                    @can('topic_delete')
                                                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.topics.perma_del', $topic->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                @endcan
                                </td>
                                @else
                                <td>
                                    @can('topic_view')
                                    <a href="{{ route('admin.topics.show',[$topic->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('topic_edit')
                                    <a href="{{ route('admin.topics.edit',[$topic->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('topic_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.topics.destroy', $topic->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="12">@lang('quickadmin.qa_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
</div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.courses.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop

@section('javascript')
    @parent

    <script src="{{ url('adminlte/plugins/datetimepicker/moment-with-locales.min.js') }}"></script>
    <script src="{{ url('adminlte/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $(function(){
            moment.updateLocale('{{ App::getLocale() }}', {
                week: { dow: 1 } // Monday is the first day of the week
            });
            
            $('.date').datetimepicker({
                format: "{{ config('app.date_format_moment') }}",
                locale: "{{ App::getLocale() }}",
            });
            
        });
    </script>
            
@stop
