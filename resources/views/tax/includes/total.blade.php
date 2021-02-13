<!--Підсумок по чеку-->
<CHECKTOTAL>
    @foreach ($receipt->data['total'] as $key => $value)
        <{{strtoupper($key)}}>{{$value}}</{{strtoupper($key)}}>
    @endforeach
</CHECKTOTAL>
