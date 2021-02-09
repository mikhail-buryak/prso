<?php

namespace App\Http\Controllers;

use App\Models\Registrar;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

/**
 * @group Registrar
 */
class RegistrarsController extends Controller
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
        return response(Registrar::simplePaginate(20));
    }

    /**
     * Create
     * Creates an entity
     *
     * @bodyParam unitId integer required The ID of business-unit. Example: 1
     * @bodyParam numberLocal string required The local number of registrar. Example: 123441
     * @bodyParam numberFiscal string required The fiscal number of registrar. Example: 4000051101
     * @bodyParam name string required The name of the cashier that will be indicated on the receipts. Example: Nesterenko Volodymyr Borysovych (Test)
     * @bodyParam on boolean Registrar state. Example: true
     * @bodyParam closed boolean Shift state. Example: true
     *
     * @response status=201 {
     * "id": 1,
     * "unitId": 1,
     * "numberLocal": 1,
     * "numberFiscal": "23",
     * "name": "Nesterenko Volodymyr Borysovych (Test)",
     * "on": true,
     * "closed": true,
     * "updatedAt": "2020-12-23T13:35:12.000000Z",
     * "createdAt": "2020-12-23T13:35:12.000000Z"
     * }
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function create(Request $request): Response
    {
        $this->validate($request, \App\Requests\Registrar\Create::getValidationRules());

        $registrar = new Registrar($request->all());
        /** @var Unit $unit */
        $unit = Unit::find($request->get('unit_id'));
        $unit->registrars()->save($registrar);

        return response($registrar, Response::HTTP_CREATED);
    }

    /**
     * Get
     * Get entity by ID
     *
     * @urlParam id integer required The ID of the entity. Example: 1
     *
     * @response status=200 {
     * "id": 1,
     * "unitId": 1,
     * "numberLocal": 1,
     * "numberFiscal": "23",
     * "name": "Nesterenko Volodymyr Borysovych (Test)",
     * "on": true,
     * "closed": true,
     * "updatedAt": "2020-12-23T13:35:12.000000Z",
     * "createdAt": "2020-12-23T13:35:12.000000Z"
     * }
     *
     * @param $id
     * @return Response
     */
    public function get($id): Response
    {
        return response(Registrar::findOrFail($id));
    }

    /**
     * Update
     * Update existing entity by ID
     *
     * @urlParam id integer required The ID of the entity. Example: 1
     * @bodyParam unitId integer required The ID of business-unit. Example: 1
     * @bodyParam numberLocal string required The local number of registrar. Example: 123441
     * @bodyParam numberFiscal string required The fiscal number of registrar. Example: 4000051101
     * @bodyParam name string required The name of the cashier that will be indicated on the receipts. Example: Nesterenko Volodymyr Borysovych (Test)
     * @bodyParam on boolean Registrar state. Example: true
     * @bodyParam closed boolean Shift state. Example: true
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
        $this->validate($request, \App\Requests\Registrar\Update::getValidationRules());

        /** @var Registrar $registrar */
        $registrar = Registrar::findOrFail($id)->fill($request->all());

        if ($request->has('unit_id')) {
            /** @var Unit $unit */
            $unit = Unit::find($request->get('unit_id'));
            $registrar->unit()->associate($unit);
        }

        $registrar->save();

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
        Registrar::findOrFail($id)->delete();

        return response(['message' => Response::$statusTexts[Response::HTTP_OK]]);
    }
}
