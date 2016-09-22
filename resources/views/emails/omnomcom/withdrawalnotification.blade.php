@extends('emails.template')

@section('body')

    <p>
        Dear {{ $user->name_first }},
    </p>

    <p>
        Around {{ date('d-m-Y', strtotime($withdrawal->date)) }} an automatic withdrawal for S.A. Proto will take place
        to settle your purchases at our association. This withdrawal concerns an amount
        of &euro;{{ number_format($withdrawal->totalForUser($user), 2, ',', '') }} and will be withdrawn
        from {{ $user->bank->iban }}. Furthermore, this withdrawal has to following details:
    </p>

    <p>
        Our creditor ID: {{ config('proto.incassant-id') }}<br>
        Your authorization ID: {{ $user->bank->machtigingid }}<br>
        Withdrawal reference: {{ $withdrawal->withdrawalId() }}
    </p>

    <p>
        I hope to have informed you well via this e-mail, but should you have any questions left you can always send me
        an e-mail.
    </p>

    <p>
        Kind regards,<br>
        {{ config('proto.treasurer') }}<br>
        <i>On behalf of the board of Study Association Proto</i>
    </p>

@endsection