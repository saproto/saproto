@php
    use App\Enums\PageEnum;
@endphp

@extends('website.layouts.redesign.dashboard')

@section('page-title')
    @if ($new)
        Create new page
    @else
        Edit page {{ $item->title }}
    @endif
@endsection

@section('container')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form
                method="post"
                action="@if($new) {{ route("page::store") }} @else {{ route("page::update", ['id' => $item->id]) }} @endif"
                enctype="multipart/form-data"
            >
                <div class="card mb-3">
                    <div class="card-header bg-dark text-white">
                        @yield('page-title')
                    </div>

                    <div class="card-body">
                        @csrf

                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input
                                type="text"
                                class="form-control"
                                id="title"
                                name="title"
                                placeholder="About Proto"
                                value="{{ $item->title ?? '' }}"
                                required
                            />
                        </div>

                        <div class="form-group">
                            <label for="slug">URL:</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        {{ str_replace('/_', '', route('page::show', ['slug' => '_'])) }}/
                                    </span>
                                </div>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="slug"
                                    placeholder="about-proto"
                                    value="{{ $item->slug ?? '' }}"
                                    required
                                />
                            </div>
                        </div>

                        @include(
                            'components.forms.checkbox',
                            [
                                'name' => 'is_member_only',
                                'checked' => $item?->is_member_only,
                                'label' => 'Member only',
                            ]
                        )

                        @include(
                            'components.forms.checkbox',
                            [
                                'name' => 'show_attachments',
                                'checked' => $item?->show_attachments,
                                'label' => 'Show attachments next to page',
                            ]
                        )

                        <div class="form-group">
                            <label for="content">Content</label>
                            @include(
                                'components.forms.markdownfield',
                                [
                                    'name' => 'content',
                                    'placeholder' => 'Text goes here.',
                                    'value' => $item ? $item->content : null,
                                ]
                            )
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success float-end">
                            Submit
                        </button>

                        <a
                            href="{{ route('page::list') }}"
                            class="btn btn-default"
                        >
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>

        @if (! $new)
            <div class="col-md-3">
                <form
                    method="post"
                    action="{{ route('page::image', ['id' => $item->id]) }}"
                    enctype="multipart/form-data"
                >
                    @csrf

                    <div class="card mb-3">
                        @if ($item->featuredImage)
                            <img
                                src="{!! $item->featuredImage->generateImagePath(700, null) !!}"
                                width="100%;"
                                class="card-img-top"
                            />
                        @endif

                        <div class="card-header bg-dark text-white">
                            Featured image
                        </div>

                        <div class="card-body">
                            <div class="custom-file">
                                <input
                                    id="image"
                                    type="file"
                                    class="form-control"
                                    name="image"
                                />
                                <label class="form-label" for="image">
                                    Upload featured image
                                </label>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button
                                type="submit"
                                class="btn btn-success btn-block float-end"
                            >
                                Replace featured image
                            </button>
                        </div>
                    </div>
                </form>

                <form
                    method="post"
                    action="{{ route('page::file::create', ['id' => $item->id]) }}"
                    enctype="multipart/form-data"
                >
                    @csrf

                    <div class="card mb-3">
                        <div class="card-header bg-dark mb-1 text-white">
                            Attachments
                        </div>

                        @if ($item->hasMedia('files') || $item->hasMedia('images'))
                            <table class="table-hover table-sm table">
                                <thead>
                                    <tr class="bg-dark text-white">
                                        <td>Filename</td>
                                        <td>Controls</td>
                                    </tr>
                                </thead>

                                @foreach ($item->getMedia('files') as $file)
                                    <tr>
                                        <td class="ellipsis ps-3">
                                            <a
                                                href="{{ $file->getFullUrl() }}"
                                                target="_blank"
                                            >
                                                {{ $file->name }}
                                            </a>
                                        </td>
                                        <td>
                                            <a
                                                class="pageEdit_insertLink"
                                                href="#"
                                                role="button"
                                                rel="{{ $file->getFullUrl() }}"
                                            >
                                                <i
                                                    class="fas fa-link fa-fw me-2"
                                                ></i>
                                            </a>
                                            <a
                                                href="{{ route('page::file::delete', ['id' => $item->id, 'file_id' => $file->id]) }}"
                                            >
                                                <i
                                                    class="fas fa-trash text-danger"
                                                ></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                @foreach ($item->getMedia('images') as $file)
                                    <tr>
                                        <td class="ellipsis ps-3">
                                            <a
                                                href="{{ $file->getFullUrl(PageEnum::LARGE->value) }}"
                                                target="_blank"
                                            >
                                                {{ $file->name }}
                                            </a>
                                        </td>
                                        <td>
                                            <a
                                                class="pageEdit_insertImage"
                                                href="#"
                                                rel="{{ $file->getFullUrl(PageEnum::LARGE->value) }}"
                                            >
                                                <i
                                                    class="fas fa-image fa-fw me-2"
                                                ></i>
                                            </a>
                                            <a
                                                href="{{ route('page::image::delete', ['id' => $item->id, 'file_id' => $file->id]) }}"
                                            >
                                                <i
                                                    class="fas fa-trash text-danger"
                                                ></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif

                        <div class="card-body">
                            <div class="custom-file">
                                <input
                                    id="file"
                                    type="file"
                                    class="form-control"
                                    name="file"
                                />
                                <label class="form-label" for="file">
                                    Upload a file
                                </label>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button
                                type="submit"
                                class="btn btn-success btn-block"
                            >
                                Upload file
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @endif
    </div>
@endsection

@push('javascript')
    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        // Borrowed from https://stackoverflow.com/questions/23733455/inserting-a-new-text-at-given-cursor-position
        function insertLineAtCursor(data) {
            const cm =
                document.getElementsByClassName('.CodeMirror')[0].CodeMirror
            const doc = cm.getDoc()
            const cursor = doc.getCursor() // gets the line number in the cursor position
            const line = doc.getLine(cursor.line) // get the line contents
            const pos = {
                // create a new object to avoid mutation of the original selection
                line: cursor.line,
                ch: line.length - 1, // set the character position to the end of the line
            }
            doc.replaceRange('\n' + data + '\n', pos) // adds a new line
        }

        const insertLinks = document.querySelectorAll(
            '.pageEdit_insertLink, .pageEdit_insertImage'
        )
        insertLinks.forEach((el) => {
            el.addEventListener('click', (e) => {
                e.preventDefault()
                const linkUrl = e.target.getAttribute('rel')
                insertLineAtCursor(`[Link text](${linkUrl})`)
            })
        })
    </script>
@endpush
