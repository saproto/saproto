@if (Session::has('flash_message'))

    <div class="modal fade" id="flashModal" tabindex="-1" role="dialog" aria-labelledby="flashModalLabel">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-body text-center">
                    {!! Session::get('flash_message') !!}
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        $('#flashModal').modal('show');
    </script>

@endif