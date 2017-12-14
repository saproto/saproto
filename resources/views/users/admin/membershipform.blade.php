<html>
<head>

    <style type="text/css">
        * {
            box-sizing: border-box;
        }

        body {
            width: 210mm;
            height: 297mm;
            font-family: Arial;
            padding: 60px 40px;
        }

        h2 {
            margin-bottom: 60px;
        }

        p {
            margin: 40px auto;
        }
    </style>

</head>
<body>

<h2>Becoming a member of Study Association Proto</h2>

<p>
    The undersigned ...
</p>

<p>
    <strong>{{ $user->name }}</strong>, born on
    <strong>{{ date('F j, Y', strtotime($user->birthdate)) }}</strong>
</p>

<p>
    ... wishes to become a member of Study Association Proto.
</p>

<p>
    The undersigned is aware of the Bylaws (NL: Statuten) and Rules & Regulations (NL: Huishoudelijk Regelement) of the
    association and promises to follow them.
</p>

<p>
    In addition, the undersigned promises to pay for any cost incurred as member of the association, including the
    membership fee, in a timely manner via any of the payment options made available by the association.
</p>

<p>
    Membership of the association is renewed anually, following a timely notice reminding the member membership is
    renewed. Membership may be terminated, without cost, before the start of the new academic year.
</p>

<p>
    For the administration of the association, the undersigned provided at the time of registration the e-mail address <strong>{{ $user->email }}</strong>
    and phone number <strong>{{ $user->phone }}</strong>, as well as the following physical address:
</p>

<p>
    <strong>
        {{ $user->address->street }} {{ $user->address->number }}<br>
        {{ $user->address->zipcode }}
        <span style="text-transform: uppercase;">{{ $user->address->city }}</span><br>
        {{ $user->address->country }}
    </strong>
</p>

<p>
    For the administration of the association, the undersigned promises to make sure that during their membership, the
    association always has a valid e-mail address and phone number on which the undersigned can be contacted, as well as
    at least one physical address of the undersigned.
</p>

<div style="height: 25mm;">
    <p>Signature:</p>
</div>

<p>
    <strong>{{ $user->name }}</strong><br>
    Enschede, {{ date('F j, Y') }}
</p>

</body>
</html>