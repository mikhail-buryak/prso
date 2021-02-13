<!--Податки/Збори-->
<CHECKTAX>
    @foreach ($receipt->data['tax'] as $items)
        <ROW ROWNUM="{{$loop->iteration}}">
            @foreach ($items as $key => $value)
                <{{strtoupper($key)}}>{{$value}}</{{strtoupper($key)}}>
            @endforeach
        </ROW>
    @endforeach
</CHECKTAX>
