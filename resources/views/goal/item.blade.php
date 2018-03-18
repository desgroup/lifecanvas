<div class="card">
    <div class="row">
        <div class="col-lg-3 checkbox-container">
            <form method="POST" action="">
                {{ csrf_field() }}
                <button type="submit" class="btn-circle btn-circle-raised btn-circle-default mr-2 ml-2" data-toggle="tooltip" data-placement="top" title="Complete goal">
                    <i class="fa fa-1x fa-check"></i>
                </button>
            </form>

            @if(is_null($goal->asset_id))
                <img src="/assets/img/logos/goal_logo_off.png" alt="" width="100" height="100">
            @else
                <img src="{{ $goal->thumbnail() }}" alt="" width="100" height="100">
            @endif
        </div>
        <div class="col-lg-9">
            <div class="card-body">
                <h4>{{ $goal->name }}</h4>
            </div>
        </div>
    </div>
</div>