<?php

namespace App\Http\Controllers;

use App\Models\Legal;
use App\Services\Tax\Command;
use Illuminate\Http\Response;

/**
 * @group Commands
 * Actions for processing data from the tax api
 */
class CommandsController extends Controller
{
    /**
     * Get objects
     * Get business units registered for a legal person
     *
     * @urlParam id integer required The ID of the legal person. Example: 1
     * @urlParam max integer The limit of units. Example: 1
     *
     * @param Command $command
     * @param $id
     * @param int $max
     * @return Response
     */
    public function getObjects(Command $command, $id, $max = 100): Response
    {
        /** @var Legal $Legal */
        $Legal = Legal::findOrFail($id);

        $data = $command->setLegal($Legal)->objects();
        $data['TaxObjects'] = array_slice($data['TaxObjects'], 0, $max);

        // new Paginator($items->values(), $perPage, $page, ['path' => $request->getPathInfo()])
        return response($data);
    }
}
