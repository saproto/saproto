<div class="card mb-3">

    <div class="card-header bg-dark text-white">
        <i class="fas fa-search fa-fw mr-3"></i> Search
    </div>

    <div class="card-body">

        <form id="searchForm">
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                <span id="showVideo" class="input-group-text" style="cursor: pointer;">
                    <i class="fab fa-youtube fa-fw"></i>
                </span>
                </div>
                <input type="text" class="form-control" id="searchBox" placeholder="Search on YouTube (or YouTube ID)">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-default input-group-text">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
                <div class="input-group-append" id="clearSearch">
                    <span class="input-group-text"><i class="fas fa-times fa-fw"></i></span>
                </div>
            </div>
        </form>

        <div id="searchResults" style="max-height: 400px; overflow-y: auto; overflow-x: hidden;">
            <p id="searchResultsDefault" class="text-center mt-3">
                Search for your favorite video!
            </p>
            <div>
                <!-- Filled by Javascript //-->
            </div>
        </div>

    </div>

    <div class="card-footer text-center">

        Developed with
        <span class="text-danger"><i class="fab fa-youtube fa-fw"></i> YouTube</span>

    </div>

</div>

<div class="card mb-3">

    <div class="card-header bg-dark text-white">
        <i class="fas fa-list fa-fw mr-3"></i> Queue
    </div>

    <div id="queue" class="card-body">
        <!-- Filled by Javascript //-->
    </div>

    <div id="queueDefault" class="card-body">
        <p class="card-text text-center">
            There is nothing in the queue right now.
        </p>
    </div>

</div>