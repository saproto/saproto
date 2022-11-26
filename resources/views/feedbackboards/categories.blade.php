@extends('website.layouts.redesign.generic')

@section('page-title')
    Event Category Admin
@endsection

@section('container')

    <div class="row">

        <div class="col-5">
            <div class="card">
                <div class="card-header">
                    {{ $cur_category == null ? 'Add new category' : 'Edit category: '.$cur_category->name }}
                </div>
                <div class="card-body">
                    <form method="POST"
                          action="{{ ($cur_category == null ? route('feedback::category::add') : route('feedback::category::edit', ['id' => $cur_category])) }}"
                          enctype="multipart/form-data">
                        {!! csrf_field() !!}

                        <label for="name">Category Name:</label>
                        <input type="text" class="form-control mb-3" id="name" name="name"
                               placeholder="Exciting feedback!" value="{{ $cur_category->title ?? '' }}" required>

                        Check feedback from the category before publishing?
                        <input class="form-check-input" type="checkbox" id="reviewed" name="reviewed" {{ $cur_category&&$cur_category->review ? 'checked' : '' }}>
                        <br>
                        <label for="user_id">Reviewer Name:</label>
                        <div class="form-group autocomplete">
                            <input class="form-control user-search" value="{{$cur_category->reviewer_id??''}}" id="user_id" name="user_id"/>
                        </div>

                        <button type="submit" class="btn btn-success float-end">Submit</button>
                        @if($cur_category)
                            <a class="btn btn-warning float-end me-1" href="{{ route('feedback::category::admin') }}">Cancel</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="col-5">
            <div class="card">
                <div class="card-header">
                    Categories
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        @php($categories = \Proto\Models\FeedbackCategory::all())
                        @if(count($categories) > 0)
                            @foreach($categories as $category)
                                <div class="col-5 row m-1 w-100">
                                    <div class="px-4 py-2 my-2 w-75 rounded-start overflow-hidden ellipsis {{ $category == $cur_category ? 'bg-warning' : 'bg-info' }}">
                                        {{ $category->title }} {{$category->reviewer?$category->reviewer->calling_name:""}}
                                    </div>
                                    <div class="bg-white px-2 py-2 my-2 w-25 rounded-end">
                                        <a href="{{ route('feedback::category::admin', ['id' => $category]) }}">
                                            <i class="fas fa-edit me-2 ms-1 mt-1 float-end"></i>
                                        </a>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#delete-category-modal" data-id="{{ $category->id }}">
                                            <i class="fas fa-trash mt-1 text-danger float-end"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center text-muted mb-0">
                                There are no feedback categories yet.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="delete-category-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog model-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this category. All feedback that currently has this category will become <b>uncategorised</b>.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                    <a id="delete-category" class="btn btn-danger" href="#">Delete Category</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('javascript')
    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        document.getElementById('delete-category-modal').addEventListener('show.bs.modal', e => {
            let categoryId = e.relatedTarget.getAttribute('data-id')
            document.getElementById('delete-category').href = '{{ route('event::category::delete', ['id' => ':id']) }}'.replace(':id', categoryId)
        })
    </script>
@endpush