<!--Заголовок-->
<CHECKHEAD>
    <DOCTYPE>{{$transaction->type}}</DOCTYPE>
    @if (is_a($transaction, App\Models\Transaction\Receipt::class))
        <DOCSUBTYPE>{{$transaction->sub_type}}</DOCSUBTYPE>
    @endif
    <UID>{{$transaction->uuid}}</UID>
    <TIN>{{$transaction->registrar->unit->tin}}</TIN>
    <IPN>{{$transaction->registrar->unit->ipn}}</IPN>
    <ORGNM>{{$transaction->registrar->unit->org_name}}</ORGNM>
    <POINTNM>{{$transaction->registrar->unit->name}}</POINTNM>
    <POINTADDR>{{$transaction->registrar->unit->address}}</POINTADDR>
    <ORDERDATE>{{Carbon\Carbon::now(config('tax.timezone'))->format('dmY')}}</ORDERDATE>
    <ORDERTIME>{{Carbon\Carbon::now(config('tax.timezone'))->format('His')}}</ORDERTIME>
    <ORDERNUM>{{$transaction->registrar->next_number_local}}</ORDERNUM>
    <CASHDESKNUM>{{$transaction->registrar->number_local}}</CASHDESKNUM>
    <CASHREGISTERNUM>{{$transaction->registrar->number_fiscal}}</CASHREGISTERNUM>
    @if ($transaction->refundNumberFiscal)
        <ORDERRETNUM>{{$transaction->refundNumberFiscal}}</ORDERRETNUM>
    @endif
    @if($transaction->cancelNumberFiscal)
        <ORDERSTORNUM>{{$transaction->cancelNumberFiscal}}</ORDERSTORNUM>
    @endif
    <CASHIER>{{$transaction->registrar->name}}</CASHIER>
    <VER>1</VER>
    <ORDERTAXNUM>{{$transaction->registrar->last_number_fiscal}}</ORDERTAXNUM>
</CHECKHEAD>
