@switch($byte->repeat)
    @case(NULL)
        @break
    @case(0)
        I wouldn't do it again
        @break
    @case(1)
        I might do it again
        @break
    @case(2)
        I would do it again
        @break
@endswitch