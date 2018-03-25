<li class="card item">
    <div class="row">
        <div class="col-lg-3 checkbox-container">
            @if(!$goal->bytes()->count())
                <form method="GET" action="/goals/complete/{{ $goal->id }}">
                    <button type="submit" class="btn-circle btn-circle-raised btn-circle-default mr-2 ml-2" data-toggle="tooltip" data-placement="top" title="Complete goal">
                        <i class="fa fa-1x fa-check"></i>
                    </button>
                </form>
            @else
                <form method="GET" action="#">
                    <button type="submit" class="btn-circle btn-circle-raised btn-circle-success mr-2 ml-2" data-toggle="tooltip" data-placement="top" title="Completed goal">
                        <i class="fa fa-1x fa-check"></i>
                    </button>
                </form>
            @endif

            @if(is_null($goal->asset_id))
                <img src="/assets/img/logos/goal_logo_off.png" alt="" width="100" height="100">
            @else
                <img src="{{ $goal->thumbnail() }}" alt="" width="100" height="100">
            @endif
        </div>
        <div class="col-lg-9">
            <div class="card-body">
                <h4><a href="/goals/{{ $goal->id }}">{{ $goal->name }}</a></h4>
            </div>
        </div>
    </div>
</li>