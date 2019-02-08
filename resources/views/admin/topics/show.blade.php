@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.topics.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.topics.fields.course')</th>
                            <td field-key='course'>{{ $topic->course->title ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.topics.fields.title')</th>
                            <td field-key='title'>{{ $topic->title }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.topics.fields.slug')</th>
                            <td field-key='slug'>{{ $topic->slug }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.topics.fields.description')</th>
                            <td field-key='description'>{!! $topic->description !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.topics.fields.possition')</th>
                            <td field-key='possition'>{{ $topic->possition }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.topics.fields.free-lesson')</th>
                            <td field-key='free_lesson'>{{ Form::checkbox("free_lesson", 1, $topic->free_lesson == 1 ? true : false, ["disabled"]) }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.topics.fields.published')</th>
                            <td field-key='published'>{{ Form::checkbox("published", 1, $topic->published == 1 ? true : false, ["disabled"]) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.topics.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop


