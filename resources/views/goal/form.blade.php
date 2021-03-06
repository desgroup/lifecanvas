<!-- Modal -->
<div class="modal modal-primary" id="myModal7" tabindex="-1" role="dialog" aria-labelledby="myModalLabel7">
    <div class="modal-dialog modal-lg animated zoomIn animated-3x" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel7">Add a Goal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                      <i class="zmdi zmdi-close"></i>
                    </span>
                </button>
            </div>
            <div class="modal-body">
                @if(count($errors))
                    <ul class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                <form method="POST" action="/goals" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="lifelist_id" id="lifelist_id" value="{{ $list->id }}">

                    <div class="row form-group">
                        <!-- Image File -->
                        <div class="col-md-12">
                            <label class="control-label" for="image">Image</label>
                            @if($agent->isMobile() || $agent->isTablet())
                                <input type="file" name="image" id="image" accept="image/*;capture=camera">
                            @else
                                <input type="text" readonly="" class="form-control" placeholder="Browse...">
                                <input type="file" class="form-control-file" name="image" id="image">
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="control-label" for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Goal name" required autofocus>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-4">
                            <label class="control-label" for="place_id">Place</label>
                            <select class="form-control selectpicker" name="place_id" id="place_id">
                                <option value="00" {{ !old('place_id') ? 'selected' : '' }}>Select a place</option>
                                @foreach($places as $key => $value)
                                    <option value="{{ $key }}" {{ (collect(old('place_id'))->contains($key)) ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="control-label" for="person">Person</label>
                            <select class="form-control selectpicker" name="person_id" id="person_id">
                                <option value="00" {{ !old('place_id') ? 'selected' : '' }}>Select a person</option>
                                @foreach($people as $key => $value)
                                    <option value="{{ $key }}" {{ (collect(old('people'))->contains($key)) ? 'selected':'' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="control-label" for="privacy">Privacy</label>
                            <div class="radio radio-primary">
                                <label>
                                    <input class="form-check-input" type="radio" name="privacy" id="privacy1" value="0" {{ old("privacy", Auth::user()->privacy) == 0 ? "checked":"" }}>
                                    Myself only
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input class="form-check-input" type="radio" name="privacy" id="privacy2" value="1" {{ old("privacy", Auth::user()->privacy) == 1 ? "checked":"" }}>
                                    My Friends
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input class="form-check-input" type="radio" name="privacy" id="privacy3" value="2" {{ old("privacy", Auth::user()->privacy) == 2 ? "checked":"" }}>
                                    The World
                                </label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-raised" data-toggle="tooltip" data-placement="top" title="Add a goal"> Add Goal </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>