<!--Реалізація-->
<CHECKPAY>
    @foreach ($receipt->data['pay'] as $items)
        <ROW ROWNUM="{{$loop->iteration}}">
            @foreach ($items as $key => $value)
                <{{strtoupper($key)}}>{{$value}}</{{strtoupper($key)}}>
            @endforeach
        </ROW>
    @endforeach
</CHECKPAY>
