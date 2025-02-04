<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Tournament;
use App\Http\Requests\StoreTournamentRequest;
use App\Services\TournamentServiceFactory;
use App\Events\TournamentPlayed;
use App\Http\Resources\TournamentResource;
use App\Filters\TournamentFilter;


/**
 * Class TournamentController.
 * 
 * @author  Esteban Isaias Campos <estebanicamp@hotmail.com> <estebanicamp@gmail.com>
 *
 * @OA\Tag(
 *     name="Tournament",
 *     description="API Endpoints of handling tournaments"
 * )
 * 
 * @OA\Info(
 *     title="API Documentation",
 *     version="1.0.0",
 *     description="API Documentation for handling tournaments"
 * )
 *
 * @OA\Schema(
 *     schema="Tournament",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="gender", type="string"),
 *     @OA\Property(property="winner_name", type="string"),
 *     @OA\Property(property="winner_skill", type="integer"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 * 
 */

class TournamentController extends Controller 
{
	public function __construct(
		protected TournamentFilter $filter
	)
    {
		# logic for constructor, middleware, etc.
    }

	/**
     * @OA\Get(
     *     path="/tournaments",
     *     summary="Show all tournaments",
     *     tags={"Tournament"},
	 *     @OA\Parameter(
     *         name="name[operator]",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         description="Filter tournaments by name (like, eq) : name[eq|like]=value",
	 * 		   @OA\Examples(example="eq", value="eq", summary="Filter tournaments by exact name"),
     *         @OA\Examples(example="like", value="like", summary="Filter tournaments by partial name")
     *     ),
	 *     @OA\Parameter(
     *         name="gender[operator]",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         description="Filter tournaments by gender (eq, in) : gender[eq|in]=value|value1,value2",
	 * 		   @OA\Examples(example="eq", value="eq", summary="Filter tournaments by exact gender"),
     *         @OA\Examples(example="in", value="in", summary="Filter tournaments based on a list by gender.")
     *     ),
	 * 	   @OA\Parameter(
     *         name="type[operator]",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         description="Filter tournaments by type (eq, in) : type[eq|in]=value|value1,value2",
	 * 		   @OA\Examples(example="eq", value="eq", summary="Filter tournaments by exact type"),
     *         @OA\Examples(example="in", value="in", summary="Filter tournaments based on a list by type.")
     *     ),
	 * 	   @OA\Parameter(
     *         name="winner_name[operator]",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         description="Filter tournaments by type (eq, like) : type[eq|like]=value",
	 * 		   @OA\Examples(example="eq", value="eq", summary="Filter tournaments by exact type"),
     *         @OA\Examples(example="like", value="like", summary="Filter tournaments by partial type")
     *     ),
	 * 	   @OA\Parameter(
     *         name="winner_skill[operator]",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         description="Filter tournaments by winner_skill (eq, gt, lt, gte, lte) : winner_skill[eq|gt|lt|gte|lte]=value",
	 * 		   @OA\Examples(example="eq", value="eq", summary="Filter tournaments by exact winner_skill"),
	 * 		   @OA\Examples(example="gt", value="gt", summary="Filter tournaments by winner_skill greater than value"),
	 * 		   @OA\Examples(example="lt", value="lt", summary="Filter tournaments by winner_skill less than value"),
	 * 		   @OA\Examples(example="gte", value="gte", summary="Filter tournaments by winner_skill greater than or equal to value"),
	 * 		   @OA\Examples(example="lte", value="lte", summary="Filter tournaments by winner_skill less than or equal to value")
     *     ),
	 * 	   @OA\Parameter(
     *         name="created_at[operator]",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         description="Filter tournaments by created_at (like, eq, gt, lt, gte, lte) : created_at[like|eq|gt|lt|gte|lte]=value",
	 * 		   @OA\Examples(example="like", value="like", summary="Filter tournaments by partial created_at"),
	 * 		   @OA\Examples(example="eq", value="eq", summary="Filter tournaments by exact created_at"),
	 * 		   @OA\Examples(example="gt", value="gt", summary="Filter tournaments by created_at greater than value"),
	 * 		   @OA\Examples(example="lt", value="lt", summary="Filter tournaments by created_at less than value"),
	 * 		   @OA\Examples(example="gte", value="gte", summary="Filter tournaments by created_at greater than or equal to value"),
	 * 		   @OA\Examples(example="lte", value="lte", summary="Filter tournaments by created_at less than or equal to value")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A list of tournaments",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Tournament"))
     *     )
     * )
     */
	public function index(Request $request) 
	{
		try{
			$wheres = $this->filter->where($request);
            $orderBy = $this->filter->orderBy($request);
            $perPage = $this->filter->paginate($request);

			return TournamentResource::collection(
				Tournament::where($wheres['where'])
						->whereIns($wheres['where_in'])
						->orderBy($orderBy[0], $orderBy[1])
						->paginate($perPage)
						->appends($request->query()),
				200
			);
		} catch (\Exception $e) {
			return response()->json(["error" => $e->getMessage()], 500);
		}
	}

	/**
     * @OA\Get(
     *     path="/tournaments/{id}",
     *     summary="Show a tournament",
     *     tags={"Tournament"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A single tournament",
     *         @OA\JsonContent(ref="#/components/schemas/Tournament")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource not found"
     *     )
     * )
     */
	public function show($id) 
	{
		try {
			$tournament = Tournament::findOrFail($id);
			return new TournamentResource($tournament);
		} catch (\Exception $e) {
			return response()->json(["error" => 'Resource not found'], 404);
		}
	}

	/**
     * @OA\Post(
     *     path="/tournaments",
     *     summary="Store a tournament",
     *     tags={"Tournament"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreTournamentRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tournament played",
     *         @OA\JsonContent(ref="#/components/schemas/Tournament")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
	public function playTournament(StoreTournamentRequest $request) 
	{
		try {
			$payload = $request->validated();

			$tournamentService = TournamentServiceFactory::create($payload['type']);

			$winner = $tournamentService->playTournament($payload['gender'], $payload['players']);	
			
            event(new TournamentPlayed($payload, $winner));
		
			return response()->json(["winner" => $winner->getName(), "skill" => $winner->getSkill()]);
		} catch (\Exception $e) {
			return response()->json(["error" => $e->getMessage()], 500);
		}
    }
}
