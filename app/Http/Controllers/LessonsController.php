<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Lesson;
use App\Transformers\LessonTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class LessonsController extends ApiController
{

    /**
     * @var LessonTransformer
     *
     */
    protected $lessonTransformer;

    /**
     * LessonsController constructor.
     * @param \App\Transformers\LessonTransformer $lessonTransformer
     */
    public function __construct(LessonTransformer $lessonTransformer)
    {
        $this->lessonTransformer = $lessonTransformer;

        $this->middleware('auth.basic', ['only' => 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 1. All is bad
        // 2. No way to attach meta data
        // 3. Linking db structure to the API output

        $limit = Input::get('limit', 3);

        $lessons = Lesson::paginate($limit);

        return $this->respondWithPagination($lessons, [
            'data' => $this->lessonTransformer->transformCollection($lessons->items())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->input('title') || !$request->input('body')){
            return $this->setStatusCode(422)->respondWithError('Parameters failed validation for a lesson.');
        }

        Lesson::create($request->all());

        return $this->respondCreated('Lesson successfully created.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lesson = Lesson::find($id);

        if (!$lesson){
            return $this->respondNotFound('Lesson does not exist.');
        }

        return $this->respond([
            'data' => $this->lessonTransformer->transform($lesson)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
