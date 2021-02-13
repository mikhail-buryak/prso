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
    <ORDERNUM>{{$transaction->registrar->refresh()->next_number_local}}</ORDERNUM>
    <CASHDESKNUM>{{$transaction->registrar->number_local}}</CASHDESKNUM>
    <CASHREGISTERNUM>{{$transaction->registrar->number_fiscal}}</CASHREGISTERNUM>
    @if ($transaction->relativeNumberFiscal))
    @if(is_a($transaction, App\Models\Transaction\Sub\Refund::class))
        <ORDERRETNUM>{{$transaction->numberFiscalRelative}}</ORDERRETNUM>
    @elseif(is_a($transaction, App\Models\Transaction\Sub\Cancel::class))
        <ORDERSTORNUM>{{$transaction->numberFiscalRelative}}</ORDERSTORNUM>
    @endif
    @endif
    <CASHIER>{{$transaction->registrar->name}}</CASHIER>
    <VER>1</VER>
    <ORDERTAXNUM>{{$transaction->registrar->last_number_fiscal}}</ORDERTAXNUM>
</CHECKHEAD>
