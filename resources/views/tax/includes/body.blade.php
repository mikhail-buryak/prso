<!--Продажі-->
<CHECKBODY>
    @foreach ($receipt->data['body'] as $items)
        <ROW ROWNUM="{{$loop->iteration}}">
            @foreach ($items as $key => $value)
                <{{strtoupper($key)}}>{{$value}}</{{strtoupper($key)}}>
            @endforeach
        </ROW>
    @endforeach
</CHECKBODY>
