<p>
    Hey there!
</p>

<p>
    So sorry to hear you lost your password. Via this e-mail you can set it again.
</p>

<p>
    Click here (or copy/paste the URL in your browser) to reset your password:
    <br>
    <a href="{{ route("login::resetpass::token",['token' => $token]) }}">{{ route("login::resetpass::token",['token' => $token]) }}</a>
</p>

<p>
    Kind regards,
    <br>
    The Have You Tried Turning It Off And On Again committee
</p>