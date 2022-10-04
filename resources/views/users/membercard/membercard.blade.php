<page>

    <style>
        html, body {
            margin: 0;
            padding: 0;
        }

        #card {
            position: relative;
            width: 100%;
            height: 99%;
            font-family: Arial, sans-serif;
        }

        #name {
            font-size: 17px;
            font-weight: bold;
        }

        #photo {
            position: absolute;
            width: 25mm;
            height: 25mm;
            top: 8mm;
            right: 5mm;
        }

        #power-icons {
            position: absolute;
            top: 8mm;
            width: 4.1%;
            background-color: white;
        }

        #details {
            position: absolute;
            top: 9mm;
            left: 3mm;
            color: #000;
            font-size: 13px;
        }

        #details .heading {
            color: #aaa;
            margin-top: 1.5mm;
            text-transform: uppercase;
            font-size: 10px;
        }

        #barcode {
            width: 35mm;
            height: 5mm;
            margin-top: 2mm;
        }
    </style>
    <div id="card">
        @if(!$overlayonly)
            <div id="details">
                <div id="name">{{ $user->name }}</div>
                <div class="heading">Member since</div>
                <div>{{ ($user->member->created_at->timestamp < 0 ? 'Before we kept track!' : date('F j, Y', strtotime($user->member->created_at))) }}</div>
                <div class="heading">Card validity</div>
                <div>{{ date('M Y') }} - {{ date('M Y', strtotime('+3 years')) }}</div>
                <barcode id="barcode" label="none" value="{{ $user->id }}"></barcode>
            </div>

            @if($user->photo)
                <img id="photo" src="data:{{ $user->photo->mime }};base64,{{ $user->photo->getBase64(450,450) }}">
            @else
                <img id="photo" src="{{ public_path('images/default-avatars/other.png') }}">
            @endif
        @endif

        <div id="power-icons">
            @if($user->isInCommitteeBySlug('protopeners'))
                <img width="15px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAB4CAYAAAA5ZDbSAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAB3RJTUUH4wgPFQ0TH+rGEwAAAAZiS0dEAP8A/wD/oL2nkwAACTBJREFUeNrtXVmIW1UY/k/2yUxnOrVSXECqdrGKuFBQEUEFrQgqiAhSrSIuD4rSh7a4oOKDtVBrxRURnbbQN/XBlxZUkOJCVUTcuqhoqWIdHaedfZIc/+/eczJ3pskk096be5L8P3zNTTI0J/93vn85J/deIjExMTExR00124D7+vrsYY5xCuNUxgJGtlQqJbTWJ/0ZiUSipJQq8OEg4wjjH8YQQ69Zs0YIjohUZci8lHEV4xLGYkNunpEK+WNLjFFD8iHGt4w9jM/M82IzkK2agNgEYwXjNsZNjOVGvXEYVP07YzdjJ+MLxjjecJVs5TCxsLMZDzDuYJwRHC+HUEomk2XgORCGIcwDHPKpWCx6wPEM+4/xAeMlxldQvIskK0fJzRnFbmCcZ8cJAjOZDOVyOe8xlUohX4ZGbDWiC4UCTU5O0tjYGI2Pj88k+0/GK4zXGP+6pmbloGoXMR5n3Gtyq0ciSO3s7PSIjYrQeggH0aOjozQyMuIp21jRqBkT8ieXSFaOkXsO40XGjXZsIHbevHmUzWadijQg+tixYx7ZgcodofohxueukKwcIvdcxhuMa6xqu7q6PODYRQOxUPLRo0eDav6ecZ+ptmMn2RXPnWaKFY9cFE3z58+n7u5uZ8m1NQHSxoIFCyidTtuXz2e8yrhgxgRuP4LNl+9gPM24wZLb29tL+Xy+aRYTkD4w5gDJFzE2mb69PQkOzOy7DDy1QrnIu81mKP4wdkxQY6sYj2LOxqliFTPBCGPvmfxLPT09XkFVryHvoYUBcBzGMqWdaADaMKhyLmkCOXlgYMCOpZ9xO+OjuPJxKkZyU6bi9Mjt6OjwCqp6K1g4En0pyA2L2Eo5FiRjbEgZOK5l+Fv0ysPDw3i6kPEI+Stew+2Wg1cybrV5F8qt1d9igQGtSX9/v/cIoqMiN9j3okrGZw4NDdX8PHwHfJfAZLjWIJaCKxWTejGx7jQz3Jv1yGG1wvHg4KCn3IANML40/edvRiU6hEmPPLHYTMKL8RyRAp+Px1rVPchFdY2/Z+tkrGbsIrNu3fIh2jhvlc13cEYt5c4gd4zxPvlLhF8j9YWZ4wJKA9GXMx5mXM/qTVsVo6CaLeJg0iJMY0KQv/uFJddvWrrICjjubsZb4Be5DS3GbM5CiAQCqn2G8WbYxM4y3m5TEa8ziqyrIESxZXIxbC1jS6OLrTgUjNh2tc3/aIlmIxcFC1Rji1TGE4zXqQG7N/b/Z6Ixu54jf7vwKXRFGBPGHuh9jzO8j6hj8vZVJuJMtHqRhQ36C21xVSv3QgGB3ZsdRvkN3ZoznzVpVtvetTVBQJ0VDeQH+uIVcSx8xEEw9nXPtMVIwAHHGfIXFGzsMPlLgONx9JPmMxFKtjL+9goB06ZVM3y3QDW9yHz3lif4TJPTyhv11WxiYiK4iP8x+Qv5cRuKuk/sBEQbNVvLFJjA+XYhGDM5YwmutaARsE9NDozbkEP3VBljRRXbiG3bwpYkeEbrQbZFqtX72lqL8WujK9BqRRfbQVssBcZY2cHTv+O8Ri94xKHgXDCE1WlFimmpr4oN2mgy28pWhe+XaYcQrWo4oZVNtwPBmsRammAxIVhMCBYTgsWEYCFYTAg+4T64zXrgWCyO/eDy9hA2EwK7RdObZXPSV6B3LgpdzUHwd+Rvu3VhPxXn9lQjOLAMeMhAzNUQHViox07MNjJrudjMr4QAufg1xVYhuAkUDJL7+vog2cfI31fFz0k7qfLyJRI0fjiOH8bvmjFJxFwN0YZk7MbgpzfvMJJUfX0aebckxDZXDg4qsSjFk/TBYkKwmBAsBIsJwWJCsJgQLCYEN4fput6vtGPWuF20SBc69u3IUJo/oaQpUSxSshVIXZpdU9w58nKqQHmlmEKlC8xkgSrufGrFVPJ7Zi2Hj5OrO+5P7J/IJH/Yli1qrUqpZImWrY7uhEMVBanG8AP3y8hfb15K8V0hNmzd6kmav3BIn8XfTSVxakq6yhmScO7U+UuKsurIj3k6vJ/86YA1+QOMD8m/Mh5Oag+dbBURubiwypOMW8icaNZqwVl5AVjPHqo1TVO29jLicS7HbhmuVvAs+afEhEpyFCEa5L7NuLI8ixRRa/14Q00jSp2AmrAbanZEIQBcJwyXTr7Hkuycgvdt99SLq9bhepO4wArhxLqePFE+pygh5dw0wzntI2OaBkdwAlv55e3kXx97dNmdE04q+ArGzZbcRb2KunJCZjXLZxXlskR/DWhLMnzXZ/KyO23Svm1pP+FofQ2jG7EHyu3Kafu6oBLYN/ARfGVe6/Z8yK/7PnWpD9ZeG7TE5tx81lQfcqrZ7I2y9n0VqFGWGF86FKJ1ebJkLMGJelcD2t2MrxSVi66M8WXRLQWfyFKPWOQ+SkUyyGBoFpJr9zE6unQmChYFi4JFwaLgNlWwEDyndikKf6VEqq0t5VTk4xXu68vBEVlCyHVEuBH5KpocrCQHu0JytAoWi91nomBRsChYFCwKbiMFC7FO+S0kBWsh+qQVrCNRseRgycGSgyUHS2hu9RwsRIfmP+0iwZKPT9wiPuMjESmxQm7sfopuw18UPDcFN9VPduQXHc74Kro2KaLGvaVzsChYFOyQgiUHi4LFRMGiYFGwKDg2BQvBJ+dHZxUs5Drjq1SzDlysoQTrynlFbG55WHKwhGq3qmgxUbCYKFgULAoWBYuCRcGiYFHwXGajkOuEz6I7dUUU7ISK5TpZcVtTXidLyHXGV3KVHVcUHJHJle5asHJuTJskCp67giUHSw4WBYuCG6NgLeQ64avwFIyb9Gk9YJ8WCvxPWkiuR8HwlZ7qgwdIqUJYfgtHwf4tYTCkvWSOjo5Ou+GTWBWDj+ArPXWXvL2eB7V2h+Bl68uHu3mIBzDM4TGi/mNEkwWavlIjKAO+gY/gK/MafLcLxwGfurPQoUp0UCt6gQ+3MDpw27bRcaIsh+qU3NpumhVKROOTRBNTUQ53I93M3P4c5kn/4d599HnvIcczcC0/rmP0SK1Vl/MHGZvYT5v5cXz5BkcJhv200XtI8398HT8+yFjJ6KVG3va6eTrgAVO3vKEUh2aO2kvXRzaJQlTyxvIh7sqH26aeXigl0qLkKaenEiXcNfoPxi+MEa+W2SC+ERMTE2sj+x98waw1SrCmywAAACV0RVh0ZGF0ZTpjcmVhdGUAMjAxOS0wOC0xNVQyMToxMzowOSswMDowMKOVKucAAAAldEVYdGRhdGU6bW9kaWZ5ADIwMTktMDgtMTVUMjE6MTM6MDkrMDA6MDDSyJJbAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAABJRU5ErkJggg==">
            @endif
        </div>
    </div>

</page>