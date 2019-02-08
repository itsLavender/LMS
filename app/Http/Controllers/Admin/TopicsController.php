<?php

namespace App\Http\Controllers\Admin;

use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTopicsRequest;
use App\Http\Requests\Admin\UpdateTopicsRequest;

class TopicsController extends Controller
{
    /**
     * Display a listing of Topic.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('topic_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('topic_delete')) {
                return abort(401);
            }
            $topics = Topic::onlyTrashed()->get();
        } else {
            $topics = Topic::all();
        }

        return view('admin.topics.index', compact('topics'));
    }

    /**
     * Show the form for creating new Topic.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('topic_create')) {
            return abort(401);
        }
        
        $courses = \App\Course::get()->pluck('title', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        return view('admin.topics.create', compact('courses'));
    }

    /**
     * Store a newly created Topic in storage.
     *
     * @param  \App\Http\Requests\StoreTopicsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTopicsRequest $request)
    {
        if (! Gate::allows('topic_create')) {
            return abort(401);
        }
        $topic = Topic::create($request->all()
        + ['possition' => Topic::where('course_id', $request ->course_id)->max('possition') +1 ]);
    


        return redirect()->route('admin.topics.index');
    }


    /**
     * Show the form for editing Topic.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('topic_edit')) {
            return abort(401);
        }
        
        $courses = \App\Course::get()->pluck('title', 'id')->prepend(trans('quickadmin.qa_please_select'), '');

        $topic = Topic::findOrFail($id);

        return view('admin.topics.edit', compact('topic', 'courses'));
    }

    /**
     * Update Topic in storage.
     *
     * @param  \App\Http\Requests\UpdateTopicsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTopicsRequest $request, $id)
    {
        if (! Gate::allows('topic_edit')) {
            return abort(401);
        }
        $topic = Topic::findOrFail($id);
        $topic->update($request->all());



        return redirect()->route('admin.topics.index');
    }


    /**
     * Display Topic.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('topic_view')) {
            return abort(401);
        }
        $topic = Topic::findOrFail($id);

        return view('admin.topics.show', compact('topic'));
    }


    /**
     * Remove Topic from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('topic_delete')) {
            return abort(401);
        }
        $topic = Topic::findOrFail($id);
        $topic->delete();

        return redirect()->route('admin.topics.index');
    }

    /**
     * Delete all selected Topic at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('topic_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Topic::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Topic from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('topic_delete')) {
            return abort(401);
        }
        $topic = Topic::onlyTrashed()->findOrFail($id);
        $topic->restore();

        return redirect()->route('admin.topics.index');
    }

    /**
     * Permanently delete Topic from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('topic_delete')) {
            return abort(401);
        }
        $topic = Topic::onlyTrashed()->findOrFail($id);
        $topic->forceDelete();

        return redirect()->route('admin.topics.index');
    }
}
