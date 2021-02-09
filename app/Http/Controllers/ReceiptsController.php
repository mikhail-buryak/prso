<?php

namespace App\Http\Controllers;

use App\Models\Legal;
use App\Models\Receipt;
use App\Models\Registrar;
use App\Requests\Receipt\Validate;
use App\Services\Tax\Document;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

/**
 * @group Receipts
 */
class ReceiptsController extends Controller
{
    /**
     * Validate
     * Sends a check for fiscalization, returns an object containing information about the check, local and fiscal numbers.
     * Automatically opens a shift if it is closed.
     *
     * @param Document $document
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function postValidate(Document $document, Request $request): Response
    {
        $this->validate($request, Validate::getValidationRules());

        $meta = $request->get('meta');

        $receipt = new Receipt(Validate::map($request));
        $legal = Legal::where('tin', $meta['person_tin'])
            ->firstOrFail();

        $registrar = Registrar::where('number_fiscal', $meta['registrar_fiscal'])
            ->firstOrFail();

        $receipt->legal()->associate($legal);

        $transaction = $document->validate($receipt, $registrar);

        return response($transaction->makeHidden([
            'receipt',
            'juridicalPerson',
            'registrar'
        ]));
    }

    /**
     * Return
     * Sends a check with items for return with specify the original check fiscal number,
     * returns an object containing information about the return check, local and fiscal number.
     * Automatically opens a shift if it is closed.
     *
     * @param Document $document
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function postRefund(Document $document, Request $request): Response
    {
        $this->validate($request, Validate::getValidationRules());

        return response([]);
    }

    /**
     * Cancel
     * Sends a document containing the fiscal number of the sent previously document for which need to cancel,
     * aka "Storno" operation.
     * Automatically opens a shift if it is closed.
     *
     * @param Document $document
     * @param Request $request
     * @return Response
     */
    public function postCancel(Document $document, Request $request): Response
    {
        return response([]);
    }
}
