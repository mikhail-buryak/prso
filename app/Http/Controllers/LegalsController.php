<?php

namespace App\Http\Controllers;

use App\Models\Legal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

/**
 * @group Legals
 */
class LegalsController extends Controller
{
    /**
     * Index
     * Paginate list of entities
     *
     * @queryParam page integer Page number. Example: 1
     *
     * @return Response
     */
    public function index(): Response
    {
        return response(Legal::simplePaginate(20));
    }

    /**
     * Create
     * Creates an entity
     *
     * @bodyParam tin string required The tin number. Example: 34554363
     * @bodyParam passphrase string The secret word for key file. Example: tect4
     * @bodyParam key file required The .key file.
     * @bodyParam cert file required The .cer file.
     *
     * @response status=201 {
     * "id": 1,
     * "tin": "345333342",
     * "createdAt": "2021-02-08T21:59:43.000000Z",
     * "updatedAt": "2021-02-08T21:59:43.000000Z"
     * }
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function create(Request $request): Response
    {
        $this->validate($request, \App\Requests\Legal\Create::getValidationRules());

        return response(
            (new Legal())->store($request),
            Response::HTTP_CREATED
        );
    }

    /**
     * Get
     * Get entity by ID
     *
     * @urlParam id integer required The ID of the entity. Example: 1
     *
     * @response status=200 {
     * "id": 1,
     * "tin": "345333342",
     * "createdAt": "2021-02-08T21:59:43.000000Z",
     * "updatedAt": "2021-02-08T21:59:43.000000Z"
     * }
     *
     * @param $id
     * @return Response
     */
    public function get($id): Response
    {
        return response(Legal::findOrFail($id));
    }

    /**
     * Update
     * Update existing entity by ID
     *
     * @urlParam id integer required The ID of the entity. Example: 1
     * @bodyParam tin string Unique The tin number. Example: 34554363
     * @bodyParam passphrase string The secret word for key file. Example: tect4
     * @bodyParam key file required The .key file.
     * @bodyParam cert file required The .cer file.
     *
     * @response status=200 {
     *  "message": "OK"
     * }
     *
     * @param $id
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function update($id, Request $request): Response
    {
        $this->validate($request, \App\Requests\Legal\Update::getValidationRules());

        Legal::findOrFail($id)->store($request);

        return response(['message' => Response::$statusTexts[Response::HTTP_OK]]);
    }

    /**
     * Delete
     * Delete existing entity by ID
     *
     * @urlParam id integer required The ID of the entity. Example: 1
     *
     * @response status=200 {
     *  "message": "OK"
     * }
     *
     * @param $id
     * @return Response
     */
    public function delete($id): Response
    {
        Legal::findOrFail($id)->delete();

        return response(['message' => Response::$statusTexts[Response::HTTP_OK]]);
    }
}
