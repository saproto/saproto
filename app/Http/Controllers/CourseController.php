<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\Course;
use Proto\Models\Page;
use Proto\Models\Study;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mainCourses = Course::where('study_id', config('proto.mainstudy'))->orderBy('quartile')->get()->groupBy('quartile');
        $otherCourses = Course::where('study_id', '!=', config('proto.mainstudy'))->get();
        
        return view('courses.list', ['mainCourses' => $mainCourses, 'otherCourses' => $otherCourses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages = Page::all();
        $studies = Study::all();

        return view('courses.add', ['pages' => $pages, 'studies' => $studies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $course = new Course();

        $page = Page::findOrFail($request->page);
        $study = Study::findOrFail($request->study);

        $course->study()->associate($study);
        $course->page()->associate($page);
        $course->quartile = $request->quartile;

        $course->save();

        return redirect(route("course::list"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::findOrfail($id);

        $course->delete();

        return redirect(route("course::list"));
    }
}
