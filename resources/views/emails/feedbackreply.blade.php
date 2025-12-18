@extends('emails.template')

@section('body')
    <p>Hey there {{ $user->calling_name }},</p>

    <p>
        The board saw your feedback and replied! If you have any questions or
        remarks simply reply to this email.
    </p>

    <p>
        You posted the following feedback to the
        {{ $feedback->category->title }} board:
    </p>

    <table
        style="
            margin: 0;
            padding: 0;
            border: none;
            background-color: #f0f0f0;
            width: 100%;
        "
    >
        <tr style="margin: 0; padding: 0; border: none">
            <td style="margin: 0; padding: 10px 20px; border: none">
                <p>
                    <strong>Votes {{ $feedback->votes_sum_vote }}</strong>
                    <i class="fa-solid fa-thumbs-up"></i>
                </p>

                <p>
                    {{ $feedback->feedback }}
                </p>

                <hr />
                <p>
                    <sub>
                        {{ $user->name }} --
                        {{ $feedback->created_at->format('j M Y, H:i') }}
                    </sub>
                </p>
            </td>
        </tr>
    </table>

    <p>And the board {{ $accepted ? 'liked it!' : 'replied with:' }}</p>

    <table
        style="
            margin: 0;
            padding: 0;
            border: none;
            background-color: #f0f0f0;
            width: 100%;
        "
    >
        <tr style="margin: 0; padding: 0; border: none">
            <td style="margin: 0; padding: 10px 20px; border: none">
                <p>
                    {{ $reply }}
                </p>

                <hr />
                <p>
                    <sub>Board of S.A. Proto -- {{ date('j M Y, H:i') }}</sub>
                </p>
            </td>
        </tr>
    </table>

    <p>
        <sup style="line-height: 1.5">
            You receive this e-mail because you posted something on the
            <a
                href="{{ route('feedback::index', ['category' => $feedback->category->url]) }}"
            >
                {{ $feedback->category->title }} board
            </a>
            .
        </sup>
    </p>
@endsection
