@extends('website.layouts.default-nobg')

@section('page-title')
    Menu Admin
@endsection

@section('content')

    <div class="row">

        <div class="col-md-8">

            <div class="panel panel-default">

                <div class="panel-heading">

                    Menu items

                </div>

                <div class="panel-body">

                    @if (count($menuItems) > 0)

                        <table class="table">

                            <thead>

                            <tr>

                                <th>Menuname</th>
                                <th>URL</th>
                                <th>Visibility</th>
                                <th>Controls</th>

                            </tr>

                            </thead>

                        @foreach($menuItems as $menuItem)

                            <tr>
                                <td>{{ $menuItem->menuname }}</td>
                                <td>@if($menuItem->page) {{ $menuItem->page->getUrl() }} @else {{ $menuItem->url }} @endif</td>
                                <td>@if($menuItem->is_member_only) Member only @else Public @endif</td>
                                <td>&nbsp;</td>
                            </tr>
                            @if($menuItem->children->count() > 0)

                                @foreach($menuItem->children()->orderBy('order')->get() as $childItem)
                                        <tr>
                                            <td>&mdash;{{ $menuItem->menuname }}</td>
                                            <td>@if($menuItem->page) {{ $menuItem->page->getUrl() }} @else {{ $menuItem->url }} @endif</td>
                                            <td>@if($menuItem->is_member_only) Member only @else Public @endif</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                @endforeach

                            @endif

                        @endforeach

                            </table>

                    @else

                        <p style="text-align: center;">There are no menu items.</p>

                    @endif

                </div>
            </div>
        </div>

        <div class="col-md-4">

            <div class="panel panel-default">

                <div class="panel-heading">

                    Add menu item

                </div>

                <div class="panel-body">

                    @foreach($pages as $page)
                        <p>{{ $page->title }}</p>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

@endsection