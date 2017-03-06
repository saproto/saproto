<!-- Modal for deleting automatic withdrawal. //-->
<div id="slack-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">S.A. Proto Slack</h4>
            </div>
            <div class="modal-body">

                <p>
                    S.A. Proto has a Slack team for its members. In this little navigation badge you can see how many
                    people are online at the moment. Would you like to join the S.A. Proto Slack? Click the button
                    below to send an invite to your e-mail address.
                </p>

            </div>
            <div class="modal-footer">
                <a href="https://slack.com/is" class="btn btn-default pull-left" target="_blank">Learn about Slack</a>
                @if (Auth::check())
                    <a href="#" class="btn btn-success" id="slack__invite">
                        Invite me to Slack!
                    </a>
                @else
                    <a href="#" class="btn btn-default" disabled>
                        Our Slack team is only for members!
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>