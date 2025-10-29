@php
    use App\Models\Sticker;
    use Illuminate\Support\Collection;
@endphp

@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Sticker admin
@endsection

@php
    /** @var Collection<Sticker>$reported */
@endphp

@section('container')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header bg-dark mb-1 text-white">
                    @yield('page-title')
                </div>

                <div class="table-responsive">
                    <table class="table-hover table-sm table">
                        <thead>
                            <tr class="bg-dark text-white">
                                <th scope="col" class="col-1">Placed by</th>
                                <th scope="col" class="col-1">Reported by</th>
                                <th scope="col" class="col-1">City</th>
                                <th scope="col" class="col-1">Country</th>
                                <th scope="col" class="col-1">Report reason</th>
                                <th scope="col" class="col-1">Image</th>
                                <th scope="col" class="col-1">Controls</th>
                            </tr>
                        </thead>

                        @foreach ($reported as $sticker)
                            <tr>
                                <td>
                                    {{ $sticker->user?->name ?? 'Unknown' }}
                                </td>
                                <td>
                                    {{ $sticker->reporter->name ?? 'Unknown' }}
                                </td>
                                <td>
                                    {{ $sticker->city }}
                                </td>
                                <td>
                                    {{ $sticker->country }}
                                </td>
                                <td>
                                    {{ $sticker->report_reason }}
                                </td>
                                <td>
                                    <img
                                        src="{{ $sticker->getImageUrl() }}"
                                        class="img-fluid"
                                    />
                                </td>
                                <td>
                                    <div class="mb-1">
                                        @include(
                                            'components.modals.confirm-modal',
                                            [
                                                'method' => 'POST',
                                                'action' => route('stickers.unreport', ['sticker' => $sticker]),
                                                'classes' => 'btn btn-sm btn-success',
                                                'text' => 'Restore',
                                                'title' => 'Confirm restoring this sticker',
                                                'message' => "Are you sure you want to restore this sticker? <img src='{$sticker->getImageUrl()}' class='img-fluid' />",
                                                'confirm' => 'Restore',
                                                'identifier' => 'restore',
                                                'confirmButtonVariant' => 'btn-info',
                                            ]
                                        )
                                    </div>

                                    @include(
                                        'components.modals.confirm-modal',
                                        [
                                            'action' => route('stickers.destroy', ['sticker' => $sticker]),
                                            'method' => 'DELETE',
                                            'classes' => 'btn btn-sm btn-danger',
                                            'text' => 'Delete',
                                            'title' => 'Confirm deleting this sticker',
                                            'message' => "Are you sure you want to permanently delete this sticker? <img src='{$sticker->getImageUrl()}' class='img-fluid'>",
                                            'confirm' => 'Delete',
                                        ]
                                    )
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header bg-dark mb-1 text-white">
                    Sticker Types
                </div>

                <div class="table-responsive">
                    <table class="table-hover table-sm table">
                        <thead>
                            <tr class="bg-dark text-white">
                                <th scope="col" class="col-1">Title</th>
                                <th scope="col" class="col-1">Image</th>
                                <th scope="col" class="col-1">Controls</th>
                            </tr>
                        </thead>

                        @foreach ($stickerTypes as $stickerType)
                            <tr>
                                <form
                                    method="post"
                                    enctype="multipart/form-data"
                                    action="{{ route('stickerType.update', ['stickerType' => $stickerType]) }}"
                                >
                                    {{ csrf_field() }}
                                    <input
                                        type="hidden"
                                        name="_method"
                                        value="PATCH"
                                    />
                                    <td>
                                        <input
                                            id="title"
                                            type="text"
                                            class="form-control-sm"
                                            name="title"
                                            value="{{ $stickerType->title }}"
                                        />
                                    </td>
                                    <td>
                                        <img
                                            src="{{ $stickerType->getImageUrl() }}"
                                            class="img-fluid"
                                            alt="The image for {{ $stickerType->title }}"
                                            width="100"
                                        />
                                    </td>
                                    <td>
                                        <input
                                            id="image"
                                            type="file"
                                            class="form-control-sm"
                                            name="image"
                                            accept="image/*"
                                        />
                                        <button
                                            class="btn btn-warning badge m-1"
                                            type="submit"
                                            @disabled($stickerType->id === 1)
                                        >
                                            Update
                                        </button>
                                    </td>
                                </form>
                            </tr>
                        @endforeach

                        <tr>
                            <form
                                method="post"
                                enctype="multipart/form-data"
                                action="{{ route('stickerType.store') }}"
                            >
                                {{ csrf_field() }}
                                <td>
                                    <input
                                        id="title"
                                        type="text"
                                        class="form-control-sm"
                                        name="title"
                                        value=""
                                        placeholder="A new sticker type"
                                    />
                                </td>
                                <td>Upload an image</td>
                                <td>
                                    <input
                                        id="image"
                                        type="file"
                                        class="form-control-sm"
                                        name="image"
                                        accept="image/jpg, image/jpeg, image/png"
                                    />
                                    <button
                                        class="btn btn-success badge m-1"
                                        type="submit"
                                    >
                                        Create!
                                    </button>
                                </td>
                            </form>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
