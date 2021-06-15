<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * @var QuestionRepository
     */
    private $repository;

    /**
     * QuestionController constructor.
     * @param QuestionRepository $repository
     */
    public function __construct(QuestionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index($list_id){
        if(\request()->awnser_given=='false'){
            $questions = $this->repository->findWhere(['list_id'=>$list_id, 'status'=>false]);
        }else{
            $questions = $this->repository->findWhere(['list_id'=>$list_id]);
        }


        return response()->json($questions);
    }
}
