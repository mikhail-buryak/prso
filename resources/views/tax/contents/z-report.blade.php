<ZREP>
    <!--Заголовок-->
    <ZREPHEAD>
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
        <CASHIER>{{$transaction->registrar->name}}</CASHIER>
        <VER>1</VER>
        <ORDERTAXNUM>{{$transaction->registrar->last_number_fiscal}}</ORDERTAXNUM>
    </ZREPHEAD>

@if(!empty($totals['Totals']['Real']))
    <!--Підсумки реалізації-->
        <ZREPREALIZ>
            <SUM>{{Str::money($totals['Totals']['Real']['Sum'])}}</SUM>
            <ORDERSCNT>{{$totals['Totals']['Real']['OrdersCount']}}</ORDERSCNT>

            @if($totals['Totals']['Real']['PayForm'])
                <PAYFORMS>
                    @foreach ($totals['Totals']['Real']['PayForm'] as $item)
                        <ROW ROWNUM="{{$loop->iteration}}">
                            <PAYFORMCD>{{$item['PayFormCode']}}</PAYFORMCD>
                            <PAYFORMNM>{{$item['PayFormName']}}</PAYFORMNM>
                            <SUM>{{Str::money($item['Sum'])}}</SUM>
                        </ROW>
                    @endforeach
                </PAYFORMS>
            @endif

            @if($totals['Totals']['Real']['Tax'])
                <TAXES>
                    @foreach ($totals['Totals']['Real']['Tax'] as $item)
                        <ROW ROWNUM="{{$loop->iteration}}">
                            <TYPE>{{$item['Type']}}</TYPE>
                            <NAME>{{$item['Name']}}</NAME>
                            <LETTER>{{$item['Letter']}}</LETTER>
                            <PRC>{{Str::money($item['Prc'])}}</PRC>
                            <SIGN>{{$item['Sign'] ? 'true' : 'false'}}</SIGN>
                            <TURNOVER>{{Str::money($item['Turnover'])}}</TURNOVER>
                            @if($item['SourceSum'])
                                <SOURCESUM>{{Str::money($item['SourceSum'])}}</SOURCESUM>
                            @endif
                            <SUM>{{Str::money($item['Sum'])}}</SUM>
                        </ROW>
                    @endforeach
                </TAXES>
            @endif
        </ZREPREALIZ>
@endif

@if(!empty($totals['Totals']['Ret']))
    <!--Підсумки повернення-->
        <ZREPRETURN>
            <SUM>{{Str::money($totals['Totals']['Ret']['Sum'])}}</SUM>
            <ORDERSCNT>{{$totals['Totals']['Ret']['OrdersCount']}}</ORDERSCNT>

            @if($totals['Totals']['Ret']['PayForm'])
                <PAYFORMS>
                    @foreach ($totals['Totals']['Ret']['PayForm'] as $item)
                        <ROW ROWNUM="{{$loop->iteration}}">
                            <PAYFORMCD>{{$item['PayFormCode']}}</PAYFORMCD>
                            <PAYFORMNM>{{$item['PayFormName']}}</PAYFORMNM>
                            <SUM>{{Str::money($item['Sum'])}}</SUM>
                        </ROW>
                    @endforeach
                </PAYFORMS>
            @endif
            @if($totals['Totals']['Ret']['Tax'])
                <TAXES>
                    @foreach ($totals['Totals']['Ret']['Tax'] as $item)
                        <ROW ROWNUM="{{$loop->iteration}}">
                            <TYPE>{{$item['Type']}}</TYPE>
                            <NAME>{{$item['Name']}}</NAME>
                            <LETTER>{{$item['Letter']}}</LETTER>
                            <PRC>{{Str::money($item['Prc'])}}</PRC>
                            <SIGN>{{$item['Sign'] ? 'true' : 'false'}}</SIGN>
                            <TURNOVER>{{Str::money($item['Turnover'])}}</TURNOVER>
                            @if($item['SourceSum'])
                                <SOURCESUM>{{Str::money($item['SourceSum'])}}</SOURCESUM>
                            @endif
                            <SUM>{{Str::money($item['Sum'])}}</SUM>
                        </ROW>
                    @endforeach
                </TAXES>
            @endif
        </ZREPRETURN>
@endif

<!--Підсумки-->
    <ZREPBODY>
        <SERVICEINPUT>{{Str::money($totals['Totals']['ServiceInput'])}}</SERVICEINPUT>
        <SERVICEOUTPUT>{{Str::money($totals['Totals']['ServiceOutput'])}}</SERVICEOUTPUT>
    </ZREPBODY>
</ZREP>
