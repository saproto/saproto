@extends('website.layouts.default')

@section('page-title')
    User Administration
@endsection

@section('content')
    <div class="col-md-5 col-xs-12">
        <div class="row">


            <div class="col-md-12" style="margin-bottom: 15px">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    <input type="text" name="search" class="form-control" id="search" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" id="goSearch">Go!</button>
                    </span>
                </div>
            </div>


            <div class="col-md-12" id="results">
                Loading...
            </div>


        </div>
    </div>

    <div class="col-md-7 col-xs-12">
        <div class="panel panel-default" id="memberDetail">
            <div class="panel-body">
                <p>Choose a user</p>
            </div>
        </div>
    </div>
@endsection

@section('javascript')

    @parent

    <script>
        var currentQuery = "";

        /**
         * Make elements in list clickable to show nested detail view.
         */
        function makeClickable() {
            $(".member").click(function (e) {
                e.preventDefault();
                $("#memberDetail").load("/user/" + $(this).attr('user_id') + "/member/nested");
            });
        }

        /**
         * Perform a search operation. Query and page number have to be included.
         *
         * @param query
         * @param page
         */
        function doSearch(query, page) {
            $.post("{{ URL::action('MemberAdminController@showSearch') }}", {
                query: query,
                page: page,
                _token: "{!! csrf_token() !!}"
            }, function (data) {
                $("#results").html(data);
                currentQuery = query;
                makeClickable();
                handlePagination();
            });
        }

        /**
         * Handle the generated pagination, and convert them to variables that can be used for AJAX search.
         */
        function handlePagination() {
            $(".pagination a").click(function (e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                var query = currentQuery;
                doSearch(query, page);
            });
        }

        /**
         * Initialize search button and handle enter in search field.
         */
        function initSearch() {
            $("#goSearch").click(function (e) {
                e.preventDefault();
                var query = $("#search").val();
                doSearch(query, 0);
            });

            $("#search").keyup(function (e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                    var query = $(this).val();
                    doSearch(query, 0);
                }
            });
        }

        initSearch();
        doSearch("", 0); // Start with an empty search, so list will be loaded with all members.
    </script>

    <script type="text/javascript">

        $('body').delegate('#print-card', 'click', function () {

            if (confirm("Please confirm you want to print a membership card.")) {
                $.ajax({
                    url: '{{ route('membercard::print') }}',
                    data: {
                        '_token': '{!! csrf_token() !!}',
                        'id': $(this).attr('data-id')
                    },
                    method: 'post',
                    dataType: 'html',
                    success: function (data) {
                        alert(data);
                    },
                    error: function (data) {
                        alert("Something went wrong while requesting the print.");
                    }
                });
            }

        });

        $('body').delegate('#print-card-overlay', 'click', function () {

            if (confirm("Please confirm you have the right member card loaded.")) {
                $.ajax({
                    url: '{{ route('membercard::printoverlay') }}',
                    data: {
                        '_token': '{!! csrf_token() !!}',
                        'id': $(this).attr('data-id')
                    },
                    method: 'post',
                    dataType: 'html',
                    success: function (data) {
                        alert(data);
                    },
                    error: function (data) {
                        alert("Something went wrong while requesting the print.");
                    }
                });
            }

        });

        $('body').delegate('#print-form', 'click', function () {

            if (confirm("Please confirm you want to print a membership document.")) {
                $.ajax({
                    url: '{{ route('memberform::print') }}',
                    data: {
                        '_token': '{!! csrf_token() !!}',
                        'id': $(this).attr('data-id')
                    },
                    method: 'post',
                    dataType: 'html',
                    success: function (data) {
                        alert(data);
                    },
                    error: function (data) {
                        alert("Something went wrong while requesting the print.");
                    }
                });
            }

        });

    </script>

@endsection
