@if(!is_null($byte->repeat))
    @switch($byte->repeat)
        @case(0)
            I would do it again
            @break
        @case(1)
            I might do it again
            @break
        @case(2)
            I wouldn't do it again
            @break
    @endswitch
@endif