@extends('website.layouts.redesign.generic')

@section('page-title')
    Sign membership contract
@endsection


@push('javascript')
{{--    <script>--}}
{{--        let signatureAlert = $('#signature-alert');--}}
{{--        let signatureForm = $('#signature-form');--}}
{{--        let signatureField = $('#signature');--}}
{{--        let signatureDrawn = false--}}

{{--        signatureAlert.hide();--}}

{{--        signatureField.jqSignature({--}}
{{--            width: 350,--}}
{{--            height: 300,--}}
{{--            lineWidth: 3--}}
{{--        });--}}

{{--        signatureField.on('jq.signature.changed', function() {--}}
{{--            signatureDrawn = true;--}}
{{--            signatureAlert.hide();--}}
{{--            $("input[name='signature']").val(signatureField.jqSignature('getDataURL'));--}}
{{--        });--}}

{{--        function clearCanvas() {--}}
{{--            signatureField.jqSignature('clearCanvas');--}}
{{--            signatureDrawn = false;--}}
{{--        }--}}

{{--        signatureForm.submit(function(e) {--}}
{{--            if (!signatureDrawn) {--}}
{{--                e.preventDefault();--}}
{{--                signatureAlert.show();--}}
{{--            }--}}
{{--        })--}}
{{--    </script>--}}
    <script>
        let signatureAlert = $('#signature-alert');
        signatureAlert.hide()

        let canvas = $('#signature')
        let signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(255, 255, 255)' // necessary for saving image as JPEG; can be removed is only saving as PNG or SVG
        });

        $('submit-png').addEventListener('click', function() {
            if (signaturePad.isEmpty()) {
                signatureAlert.show()
            }

            let data = signaturePad.toDataURL('image/png');
            console.log(data);
            window.open(data);
        });

        document.getElementById('erase').addEventListener('click', function() {
            var ctx = canvas.getContext('2d');
            ctx.globalCompositeOperation = 'destination-out';
        });
    </script>
@endpush

@section('container')

    <div class="row justify-content-center">

        <div class="col-lg-6 col-md-7" style="max-width: 600px">

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
                        <div id="signature-alert" class="alert alert-danger text-center" role="alert">
                            We need your signature for the membership contract to be valid!
                        </div>
                        <div id='signature'>
                            <button class="btn btn-danger round position-absolute m-2 px-2 py-1" onclick="clearCanvas();">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <p>
                            <?= $user->name ?> <br>
                            Enschede, <?= date('M, d, Y', strtotime('today')) ?>
                        </p>

                        <form id="signature-form" method="POST" action="{{ route('memberform::sign') }}">
                            <input type="hidden" id="signature" name="signature" value=""/>
                            <div class="wrapper">
                                <canvas id="signature-pad" class="signature-pad" width=400 height=200></canvas>
                            </div>
                        </form>
                    </div>

                </div>

        </div>

    </div>

@endsection
