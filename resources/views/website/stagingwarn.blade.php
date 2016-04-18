<div id="staging" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Welcome to Staging!</h4>
            </div>
            <div class="modal-body">
                <p>Hey there!</p>
                <p>
                    You found our Staging environment, nice! This website will offer you a preview in what the new
                    website currently looks like. There is one thing you should keep ing mind though.
                    <strong>
                        This website runs a copy of the actual database. Although this website will usually display the
                        same content as the old website, changes made to the information on this website will regularly
                        overwritten by the data of the old website.
                    </strong>
                    So no need to keep your info here up-to-date.
                </p>
                <p>Happy browsing!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Ok, then!</button>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function() {
        if (typeof Cookies.get('stagingwarn') === "undefined") {
            $('#staging').modal('show');
            Cookies.set("stagingwarn", "shown");
        }
    });

</script>