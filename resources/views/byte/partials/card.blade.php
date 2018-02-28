<li class="item ms-timeline-item wow materialUp">
    <div class="ms-timeline-date">
        <time class="timeline-time" datetime="">{{ Carbon\Carbon::parse($byte->byte_date)->format('D dS') }}
            <span>{{ Carbon\Carbon::parse($byte->byte_date)->format('F') }}</span>
        </time>
        <i class="ms-timeline-point {{ $byte->user_id == Auth::user()->id ? 'bg-success' : 'bg-royal' }}"></i>
        <a href="{{ '/' . $byte->user()->pluck('username')[0] }}">
            <img src="{{ is_null($byte->user()->pluck('avatar')[0]) ? '/assets/img/silhouette.png' : '/usr/' . $byte->user_id . '/avatar/' . $byte->user()->pluck('avatar')[0] . 'avatar.jpg' }}" class="ms-timeline-point-img">
        </a>
    </div>
    <a href="/bytes/{{ $byte->id }}">
        <div class="card {{ $byte->user_id == Auth::user()->id ? 'card-success' : 'card-royal' }}">
            <div class="card-header">
                <h3 class="card-title">{{ $byte->title }}</h3>
            </div>
            <div class="card-block">
                <div class="row" style="color: #212529">
                    @if(is_null($byte->asset_id))
                        <div class="col-sm-12">
                            <p style="color: #212529">{{ $byte->story }}</p>
                            @if ($byte->place_id > 0)
                                {{ $byte->place->name }}<br>
                            @endif
                            <div style="color: #212529">@include('byte.partials.rating')  @include('byte.partials.repeat')</div>
                        </div>
                    @else
                        <div class="col-sm-3">
                            <img src="{{ $byte->thumbnail() }}" alt="" class="img-fluid"></div>
                        <div class="col-sm-9">
                            <p style="color: #212529">{{ $byte->story }}</p>
                            @if ($byte->place_id > 0)
                                {{ $byte->place->name }}<br>
                            @endif
                            <div>@include('byte.partials.rating')  @include('byte.partials.repeat')</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </a>
</li>