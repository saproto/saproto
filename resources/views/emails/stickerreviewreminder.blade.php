@extends('emails.template')

@section('body')
    <p>Hey!</p>

    <p>
        There are {{$reported->count()}} reported stickers that are awaiting your review.
        <br />
        Make sure to review them
        <a href="{{ route('stickers.admin') }}">here.</a>
    </p>

    <p>
        They are reported for the following reasons:

        @foreach ($reported as $report)
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
                            {{ $report->report_reason }}
                        </p>

                        <hr />
                        <p>
                            <sub>
                                {{ $report->reporter->name }} --
                                {{ $report->updated_at->format('j M Y, H:i') }}
                            </sub>
                        </p>
                    </td>
                </tr>
            </table>
        @endforeach

    <p>Kind regards, The Sticker Clerk</p>
@endsection
