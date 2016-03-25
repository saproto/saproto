@extends('website.layouts.default')

@section('page-title')
    Member Administration
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
                <p>Choose a member</p>
            </div>
        </div>
    </div>

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
@endsection
