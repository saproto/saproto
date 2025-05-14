@include(
    'users.includes.usercard',
    [
        'user' => $membership->user,
        'subtitle' => sprintf(
            '<em>%s</em><br>%s',
            $membership->role ?? 'General Member',
            $membership->deleted_at
                ? sprintf(
                    'Between %s and %s',
                    $membership->created_at->format('M \'y'),
                    $membership->deleted_at->format('M \'y'),
                )
                : sprintf(
                    'Since %s',
                    $membership->created_at->format('j F Y')
                ),
        ),
        'footer' =>
            Route::current()->getName() == 'committee::edit'
                ? sprintf(
                    '<a class="btn btn-primary float-end" href="%s"><i class="fas fa-pencil-alt fa-fw"></i></a>',
                    route('committee::membership::edit', [
                        'id' => $membership->id,
                    ]),
                )
                : null,
    ]
)
