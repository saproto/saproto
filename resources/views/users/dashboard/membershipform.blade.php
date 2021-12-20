@extends('website.layouts.redesign.generic')

@section('page-title')
    Sign membership contract
@endsection

@push('javascript')
    <script type="text/javascript" nonce="{{ csp_nonce() }}">

        const signatureAlert = document.getElementById('signature-alert')
        const canvas = document.getElementById('signature-pad')
        const signaturePad = new SignaturePad.default(canvas)

        window.onresize = resizeCanvas
        resizeCanvas()

        function resizeCanvas() {
            // When zoomed out to less than 100%, for some very strange reason,
            // some browsers report devicePixelRatio as less than 1
            // and only part of the canvas is cleared then.
            const ratio = Math.max(window.devicePixelRatio || 1, 1)
            canvas.width = canvas.offsetWidth * ratio
            canvas.height = canvas.offsetHeight * ratio
            canvas.getContext("2d").scale(ratio, ratio)
            signaturePad.clear()
        }

        document.getElementById('clear').addEventListener('click', e => {
            signaturePad.clear()
        })

        document.getElementById('signature-form').addEventListener('submit', e => {
            if (signaturePad.isEmpty()) {
                e.preventDefault()
                signatureAlert.classList.remove('d-none')
            } else {
                document.getElementById('signature').value = signaturePad.toDataURL('image/png')
            }
        })

    </script>
@endpush

@section('container')

    <div id="membership-contract" class="row justify-content-center">

        <div class="col-lg-6 col-md-7">

                <div class="card mb-3">

                    <div class="card-header bg-dark text-white">@yield('page-title')</div>

                    <div class="card-body">
                        <p>
                            The undersigned ...
                        </p>
                        <p>
                            <b><?= $user->name ?></b>, born on <b><?php $date = new DateTime($user->birthdate); echo $date->format('M, d, Y') ?></b>,
                        </p>
                        <p>
                            ... wishes to become a member of Study Association Proto.
                        </p>
                        <p>
                            The undersigned is aware of the
                            <a href="https://wiki.proto.utwente.nl/_media/proto/statues_v3_eng_censor.pdf" target="_blank">Bylaws</a>
                            (NL: <a href="https://wiki.proto.utwente.nl/_media/proto/statuten_v3_nl_censor.pdf" target="_blank">Statuten)</a> and
                            <a href="https://wiki.proto.utwente.nl/_media/proto/rules_and_regulations_s.a._proto_en_.pdf" target="_blank">Rules & Regulations</a>
                            (NL: <a href="https://wiki.proto.utwente.nl/_media/proto/rules_and_regulations_s.a._proto_nl_.pdf" target="_blank">Huishoudelijk Regelement)</a>
                            of the association and promises to follow them.
                        </p>
                        <p>
                            Membership of the association is renewed annually, following a timely notice reminding the member their membership will be renewed. Membership may be terminated, without cost, before the start of the new academic year.
                        </p>
                        <p>
                            For the administration of the association, the undersigned provided at the time of registration the e-mail address <b><?= $user->email ?></b> and phone number <b><?= $user->phone ?></b>, as well as the following physical address:
                        </p>
                        <?php $address = $user->address ?>
                        <ul class="list-unstyled">
                            <li><b><?= $address->street ?> <?= $address->number ?></b></li>
                            <li><b><?= $address->zipcode ?> <?= $address->city ?></b></li>
                            <li><b><?= $address->country ?></b></li>
                        </ul>
                        <p>
                            For the administration of the association, the undersigned promises to make sure that during their membership, the association always has a valid e-mail address and phone number on which the undersigned can be contacted, as well as at least one physical address of the undersigned.
                        </p>

                        <b>Signature:</b>
                        <div class="wrapper">
                            <canvas id="signature-pad"></canvas>
                            <button id="clear" class="btn btn-danger position-absolute m-2 px-2 py-1">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div id="signature-alert" class="alert alert-danger text-center d-none p-1 my-2 mx-4" role="alert">
                            We need your signature for the membership contract to be valid!
                        </div>

                        <p>
                            <?= $user->name ?> <br>
                            Enschede, <?= date('M, d, Y', strtotime('today')) ?>
                        </p>

                        <form id="signature-form" method="POST" action="{{ route('memberform::sign') }}">
                            @csrf
                            <input type="hidden" id="signature" name="signature"/>
                            <input type="submit" class="btn btn-info">
                        </form>
                    </div>

                </div>

        </div>

    </div>

@endsection
