<?php

namespace App\Http\Controllers\Api;

use App\Entities\Question;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionCreateRequest;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class QuestionController extends Controller
{

    private $repository;


    public function __construct(QuestionRepository $repository)
    {
        $this->repository = $repository;
    }


    public function index(Request $request){
        $list_id = $request->list_id;
        $questions =Question::with(['possibleAnswer', 'answersGiven'])->where(['list_id'=>$list_id]);
        return response()->json(['data'=>$questions]);
    }

    /**
     * @OA\Post (
     *     @OA\Parameter(
     *         name="list_id",
     *         in="query",
     *         description="id da lista",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="descrição da pergunta",
     *         required=true,
     *         @OA\Schema(
     *          type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="mandatory",
     *         in="query",
     *         description="É uma pergunta obrigatória",
     *         required=true,
     *         @OA\Schema(
     *             type="boolean"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="question_status",
     *         in="query",
     *         description="Status da Pergunta",
     *         required=true,
     *         @OA\Schema(
     *             type="boolean"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="question_type",
     *         in="query",
     *         description="Tipo da Pergunta",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="weight_question",
     *         in="query",
     *         description="Peso da pergunta",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="has_action",
     *         in="query",
     *         description="Tem ação",
     *         required=true,
     *         @OA\Schema(
     *             type="boolean"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="link_video",
     *         in="query",
     *         description="Link de um vídeo",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="amount",
     *         in="query",
     *         description="A Quantidade/Preço a ser validada",
     *         required=false,
     *         @OA\Schema(
     *             type="decimal"
     *         )
     *     ),

     *     tags={"Pergunta"},
     *     summary="Cadastro de Pergunta",
     *     description="Cadastra uma pergunta ",
     *     path="/api/v1/questions",
     *     @OA\Response(response="200", description="{}"),
     * )
     */
    public function store(QuestionCreateRequest $request){
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $listing = $this->repository->create($request->all());

            $response = [
                'message' => 'Pergunta cadastrada.',
                'data'    => $listing->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }
}
