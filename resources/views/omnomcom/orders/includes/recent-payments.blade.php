@php
    use App\Enums\MollieEnum;
    use App\Models\MollieTransaction;
    use App\Models\Withdrawal;
    /** @var \Illuminate\Support\Collection<Withdrawal> $withdrawals */
    /** @var \Illuminate\Support\Collection<MollieTransaction> $molliePayments */
@endphp

<div class="card mb-3">
    <div class="card-header bg-dark text-white">Recent withdrawals</div>

    @if ($withdrawals->isNotEmpty())
        <ul class="list-group list-group-flush">
            @foreach ($withdrawals as $withdrawal)
                <div class="list-group-item d-flex justify-content-between">
                    <div>
                        <a
                            href="{{ route('omnomcom::mywithdrawal', ['id' => $withdrawal->id]) }}"
                        >
                            {{ date('d-m-Y', strtotime($withdrawal->date)) }}
                        </a>
                    </div>
                    @if ($withdrawal->failedWithdrawals->contains('user_id', Auth::user()->id) || $withdrawal->id == 'temp')
                        <i class="fas fa-times text-danger mt-1"></i>
                    @else
                        <div>
                            {{ $withdrawal->closed ? 'Closed' : 'Pending' }}
                        </div>
                    @endif
                    <div>
                        &euro;{{ number_format($withdrawal->orderlines_sum_total_price, 2) }}
                    </div>
                </div>
            @endforeach
        </ul>
    @else
        <div class="card-body">
            <p class="card-text text-center">None available yet.</p>
        </div>
    @endif
</div>

@if ($molliePayments->isNotEmpty())
    <div class="card mb-3">
        <div class="card-header bg-dark text-white">Recent payments</div>

        <ul class="list-group list-group-flush">
            @foreach ($molliePayments as $transaction)
                <li class="list-group-item">
                    @if ($transaction->mollie_id != 'temp')
                        @php
                            $status = $transaction->translatedStatus();
                        @endphp

                        <a
                            href="{{ route('omnomcom::mollie::status', ['id' => $transaction->id]) }}"
                        >
                            {{ date('d-m-Y H:i', strtotime($transaction->created_at)) }}
                            <i
                                class="fas {{ $status === MollieEnum::OPEN ? ' fa-spinner text-normal' : '' }} {{ $status === MollieEnum::FAILED ? 'fa-times text-danger' : '' }} {{ $status === MollieEnum::PAID ? 'fa-check text-success' : '' }} {{ $status === MollieEnum::UNKNOWN ? 'fa-question text-normal' : '' }} ms-2"
                            ></i>
                        </a>
                    @else
                        <span>
                            This payment is corrupt, please contact board
                        </span>
                    @endif
                    <span class="float-right">
                        &euro;{{ number_format($transaction->amount, 2) }}
                    </span>
                </li>
            @endforeach
        </ul>
    </div>
@endif
