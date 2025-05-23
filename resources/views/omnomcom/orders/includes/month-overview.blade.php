<div class="card mb-3">
    <div class="card-header bg-dark text-white">See previous months</div>

    <ul class="list-group list-group-flush" id="omnomcom-years-accordion">
        @foreach ($available_months as $year => $months)
            <li
                class="list-group-item cursor-pointer"
                data-bs-toggle="collapse"
                data-bs-target="#omnomcom-years-{{ $year }}"
            >
                <strong>{{ $year }}</strong>
            </li>
            <div
                id="omnomcom-years-{{ $year }}"
                class="{{ $year == date('Y') ? 'show' : null }} collapse"
                data-parent="#omnomcom-years-accordion"
            >
                @foreach ($months as $month)
                    <a
                        href="{{ route('omnomcom::orders::index', ['date' =>$year .'-' .\Illuminate\Support\Carbon::create()->month($month)->format('m'),]) }}"
                        class="list-group-item"
                    >
                        {{ \Illuminate\Support\Carbon::create()->month($month)->format('F') .' ' .$year }}
                    </a>
                @endforeach
            </div>
        @endforeach
    </ul>
</div>
