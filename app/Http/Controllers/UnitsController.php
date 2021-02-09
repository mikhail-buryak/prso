<?php

namespace App\Http\Controllers;

use App\Models\Legal;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

/**
 * @group Units
 */
class UnitsController extends Controller
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
        return response(Unit::simplePaginate(20));
    }

    /**
     * Create
     * Creates an entity
     *
     * @bodyParam personId integer required The ID of j-person. Example: 1
     * @bodyParam taxId string required The unit id in tax aka "Господарська одиниця". Example: 12344512
     * @bodyParam tin string required The tin number. Example: 34554363
     * @bodyParam ipn string required The ipn number. Example: 123456789018
     * @bodyParam name string required The name of the store that will be indicated on the receipts. Example: Store#1
     * @bodyParam orgName string required The name of organization. Example: Company#1
     * @bodyParam address string required The address of the store that will be indicated on the receipts. Example: Ukraine, Kiev, Lugova, 2
     *
     * @response status=201 {
     * "id": 1,
     * "personId": 1,
     * "taxId": "12324514",
     * "tin": "34554355",
     * "ipn": "123456789012",
     * "name": "Store#1",
     * "orgName": "Company#1",
     * "address": "Ukraine, Kiev, Lugova, 2",
     * "updatedAt": "2020-12-23T13:57:07.000000Z",
     * "createdAt": "2020-12-23T13:57:07.000000Z"
     * }
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function create(Request $request): Response
    {
        $this->validate($request, \App\Requests\Unit\Create::getValidationRules());

        $unit = new Unit($request->all());
        /** @var Legal $legal */
        $legal = Legal::find($request->get('legal_id'));
        $legal->units()->save($unit);

        return response($unit, Response::HTTP_CREATED);
    }

    /**
     * Get
     * Get entity by ID
     *
     * @urlParam id integer required The ID of the entity.
     *
     * @response status=200 {
     * "id": 1,
     * "personId": 1,
     * "taxId": "12324514",
     * "tin": "34554355",
     * "ipn": "123456789012",
     * "name": "Store#1",
     * "orgName": "Company#1",
     * "address": "Ukraine, Kiev, Lugova, 2",
     * "updatedAt": "2020-12-23T13:57:07.000000Z",
     * "createdAt": "2020-12-23T13:57:07.000000Z"
     * }
     *
     * @param $id
     * @return Response
     */
    public function get($id): Response
    {
        return response(Unit::findOrFail($id));
    }

    /**
     * Update
     * Update existing entity by ID
     *
     * @urlParam id integer required The ID of the entity. Example: 1
     * @bodyParam personId integer required The ID of j-person. Example: 1
     * @bodyParam taxId string required The unit id in tax aka "Господарська одиниця". Example: 12344512
     * @bodyParam tin string required The tin number. Example: 34554363
     * @bodyParam ipn string required The ipn number. Example: 123456789018
     * @bodyParam name string required The name of the store that will be indicated on the receipts. Example: Store#1
     * @bodyParam orgName string required The name of organization. Example: Company#1
     * @bodyParam address string required The address of the store that will be indicated on the receipts. Example: Ukraine, Kiev, Lugova, 2
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
        $this->validate($request, \App\Requests\Unit\Update::getValidationRules());

        /** @var Unit $unit */
        $unit = Unit::findOrFail($id)->fill($request->all());

        if ($request->has('legal_id')) {
            /** @var Legal $legal */
            $legal = Legal::find($request->get('legal_id'));
            $unit->legal()->associate($legal);
        }

        $unit->save();

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
        Unit::findOrFail($id)->delete();

        return response(['message' => Response::$statusTexts[Response::HTTP_OK]]);
    }
}
