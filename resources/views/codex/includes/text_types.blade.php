<div class="card mb-3">
    <div class="card-header d-inline-flex justify-content-between">
        Text types
        @if(!isset($edit))
            <div>
                <a href="{{ route('codex::add-text') }}" class="btn btn-info badge">
                    New Text
                </a>
                <a href="{{ route('codex::add-text-type') }}" class="btn btn-info badge">
                    New Text Type
                </a>
            </div>
        @endif
    </div>
    <div class="card-body">
            @foreach($textTypes as $textType)

                <div class="card border">
                    <div class="card-header border-bottom-0">
                            <span class="w-100 d-inline-flex justify-content-between">
                                <span class=" cursor-pointer" data-bs-toggle="collapse" data-bs-target="#collapse-text{{ $textType->id }}">
                                    <b><i class="fas fa-sm fa-fw fa-caret-down"></i> {{ $textType->type }} ({{$textType->texts_count }})</b>
                                </span>
                                @if(!isset($edit))
                                    <div>
                                        <a href="{{ route('codex::edit-text-type', ['id' => $textType->id]) }}" class="btn btn-info badge m-1">Edit</a>
                                        <a href="{{ route('codex::delete-text-type', ['id' => $textType->id]) }}" class="btn btn-danger badge m-1">Delete</a>
                                    </div>
                                @endif
                            </span>

                        <div id="collapse-text{{ $textType->id }}" class="collapse">
                            <div class="card-body cursor-default">

                                @foreach($textType->texts as $text)
                                    <span class="w-100 d-inline-flex justify-content-between">
                                        @if(isset($edit) && $edit)
                                            <div class="form-check">
                                                 @include('components.forms.checkbox', [
                                                    'input_class_name'=>'',
                                                    'name' => 'textids[]',
                                                    'checked' => in_array($text->id, $myTextTypes),
                                                    'value'=>$text->id,
                                                    'label' => 'Include'
                                                    ])
                                            </div>
                                        @endif

                                        {{ $text->name}}
                                        @if(!isset($edit))
                                             <div>
                                                <a href="{{ route('codex::edit-text', ['id' => $text->id]) }}" class="btn btn-info badge m-1">Edit</a>
                                                 <a href="{{ route('codex::delete-text', ['id' => $text->id]) }}" class="btn btn-danger badge m-1">Delete</a>
                                             </div>
                                        @endif
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
    </div>
</div>