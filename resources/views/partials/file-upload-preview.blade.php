<div class="table table-striped files" id="fileUploaderContainer">
    @if (($editMode ?? true) == true)
        <div id="fileUploaderItem" class="mt-2 row">
            <div class="col-auto">
                <span class="preview"><img src="data:," alt="" data-dz-thumbnail /></span>
            </div>
            <div class="col d-flex align-items-center">
                <p class="mb-0">
                    <span class="lead" data-dz-name></span>
                    (<span data-dz-size></span>)
                </p>
                <strong class="error text-danger" data-dz-errormessage></strong>
            </div>
            <div class="col-4 d-flex align-items-center">
                <div class="progress progress-striped active w-100" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                    <div class="progress-bar bg-success" style="width:0%;" data-dz-uploadprogress></div>
                </div>
            </div>
            <div class="col-auto d-flex align-items-center">
                <div class="btn-group">
                    <button data-dz-remove class="btn btn-danger delete">
                        <i class="fas fa-trash"></i>
                        <span>{{__('Delete')}}</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
    @foreach ($media ?? [] as $item)
        <div id="" class="mt-2 row dz-processing dz-image-preview dz-success dz-complete">
            <input type="hidden" name="media_id[]" value="{{$item->id}}">
            <div class="col-auto">
                <span class="preview">
                    <img src="{{$item->getUrl()}}" alt="" data-dz-thumbnail="" width="100px">
                </span>
            </div>
            <div class="col d-flex align-items-center">
                <p class="mb-0">
                    <span class="lead" data-dz-name="">
                        @if (($editMode ?? true) == true)
                        <a href="{{$item->getUrl()}}" target="_blank">{{$item->file_name}}</a>
                        @else
                        <a href="{{$item->getUrl()}}" target="_blank">{{$item->file_name}}</a>
                        @endif
                        
                    </span> 
                    (<span data-dz-size=""><strong>{{formatBytes($item->size)}}</strong></span>)
                </p>
            </div>
            @if (($editMode ?? true) == true)
                <div class="col-4 d-flex align-items-center">
                    <div class="progress progress-striped active w-100" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                        <div class="progress-bar bg-success" style="width:100%;" data-dz-uploadprogress></div>
                    </div>
                </div>
                <div class="col-auto d-flex align-items-center">
                    <div class="btn-group">
                        <button type="button" data-dz-remove="" class="btn btn-danger delete dz-remove">
                            <i class="fas fa-trash"></i>
                            <span>{{__('Delete')}}</span>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    @endforeach
</div>