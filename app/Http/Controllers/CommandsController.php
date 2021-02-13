<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Legal;
use App\Models\Registrar;
use App\Services\Tax\Command;
use Illuminate\Http\Request;
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

    /**
     * Post objects
     * Create/restore business units, registrars registered for a legal person
     *
     * @urlParam id integer required The ID of the legal person. Example: 1
     * @urlParam max integer The limit of units. Example: 1
     *
     * @param Command $command
     * @param $id
     * @param int $max
     * @return Response
     */
    public function postObjects(Command $command, $id, $max = 100): Response
    {
        /** @var Legal $legal */
        $legal = Legal::findOrFail($id);
        $countUnits = $countRegistrars = 0;
        $data = $command->setLegal($legal)->objects();
        $data['TaxObjects'] = array_slice($data['TaxObjects'], $countUnits, $max);

        $units = collect();
        foreach ($data['TaxObjects'] as $object) {
            /** @var Unit $unit */
            $unit = Unit::firstOrNew([
                'tax_id' => $object['Entity'],
            ]);

            $unit->fill([
                'tin' => $object['Tin'],
                'ipn' => $object['Ipn'],
                'name' => $object['Name'],
                'org_name' => $object['OrgName'],
                'address' => $object['Address']
            ]);

            $unit->legal()->associate($legal);

            if ($unit->isDirty()) {
                $countUnits++;

                $units->add($unit);
                if ($unit->getKey()) {
                    $units->add($unit);
                } else {
                    $unit->save();
                }
            }

            $registrars = collect();
            foreach ($object['TransactionsRegistrars'] as $objectRegistrar) {
                /** @var Registrar $registrar */
                $registrar = Registrar::firstOrNew([
                    'number_local' => $objectRegistrar['NumLocal'],
                    'number_fiscal' => $objectRegistrar['NumFiscal'],
                ]);

                $registrar->fill([
                    'name' => $objectRegistrar['Name'],
                    'closed' => $objectRegistrar['Closed']
                ]);

                if ($registrar->isDirty()) {
                    $countRegistrars++;
                    $registrars->add($registrar);
                }
            }

            if (!$registrars->isEmpty()) {
                $unit->registrars()->saveMany($registrars);
            }
        }

        if (!$units->isEmpty()) {
            $legal->units()->saveMany($units);
        }

        return response([
            'message' => Response::$statusTexts[Response::HTTP_OK],
            'touched_units' => $countUnits,
            'touched_registrars' => $countRegistrars,
        ]);
    }

    /**
     * Get registrar state
     * Return the current state of the registrar
     *
     * @urlParam id integer required The ID of the registrar. Example: 1
     *
     * @param Command $command
     * @param $id
     * @return Response
     */
    public function getTransactionsRegistrarState(Command $command, $id): Response
    {
        /** @var Registrar $registrar */
        $registrar = Registrar::with('legal')->findOrFail($id);

        return response($command->setLegal($registrar->legal)->transactionsRegistrarState($registrar));
    }

    /**
     * Post registrar state
     * Sync the current state of the registrar
     *
     * @urlParam id integer required The ID of the registrar. Example: 1
     *
     * @param Command $command
     * @param $id
     * @return Response
     */
    public function postTransactionsRegistrarState(Command $command, $id): Response
    {
        /** @var Registrar $registrar */
        $registrar = Registrar::with('legal')->findOrFail($id);

        $registrarState = $command->setLegal($registrar->legal)
            ->transactionsRegistrarState($registrar);

        $registrar->fill([
            'closed' => $registrarState['Closed'],
            'next_number_local' => $registrarState['NextLocalNum'],
            'last_number_fiscal' => $registrarState['LastFiscalNum'],
        ])->save();

        return response(['message' => Response::$statusTexts[Response::HTTP_OK]]);
    }

    /**
     * Get shifts
     * Returns shift history objects for the specified registrar
     *
     * @urlParam id integer required The ID of the registrar. Example: 1
     * @queryParam from string Start datetime(ISO-8601) of period. Example: 2020-12-24 20:20:20.000000
     * @queryParam to string End datetime of period. Example: 2020-12-25 20:20:20.000000
     *
     * @param Command $command
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function getShifts(Command $command, Request $request, $id): Response
    {
        $from = $request->query('from');
        $to = $request->query('to');

        /** @var Registrar $registrar */
        $registrar = Registrar::with('legal')->findOrFail($id);

        return response($command->setLegal($registrar->legal)->shifts($registrar, $from, $to));
    }

    /**
     * Get documents
     * Return the list of documents for the specified registrar shift
     *
     * @urlParam id integer required The ID of the registrar. Example: 1
     * @urlParam shift integer required The ID of the shift. Example: 68842
     *
     * @param Command $command
     * @param $id
     * @param $shift
     * @return Response
     */
    public function getDocuments(Command $command, $id, $shift): Response
    {
        /** @var Registrar $registrar */
        $registrar = Registrar::with('legal')->findOrFail($id);

        return response($command->setLegal($registrar->legal)->documents($registrar, $shift));
    }

    /**
     * Get last shift totals
     * Return the data of last shift for the specified registrar
     *
     * @urlParam id integer required The ID of the registrar. Example: 1
     *
     * @param Command $command
     * @param $id
     * @return Response
     */
    public function getLastShiftTotals(Command $command, $id): Response
    {
        /** @var Registrar $registrar */
        $registrar = Registrar::with('legal')->findOrFail($id);

        return response($command->setLegal($registrar->legal)->lastShiftTotals($registrar));
    }
}
