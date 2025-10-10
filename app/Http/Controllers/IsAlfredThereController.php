<?php

namespace App\Http\Controllers;

use App\Enums\IsAlfredThereEnum;
use App\Events\IsAlfredThereEvent;
use App\Models\HashMapItem;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class IsAlfredThereController extends Controller
{
    public static string $HashMapItemKey = 'is_alfred_there';

    public static string $HashMapUnixKey = 'is_alfred_there_unix';

    public static string $HashMapTextKey = 'is_alfred_there_text';

    public function index(): View
    {
        return view('isalfredthere.minisite', $this->getStatus());
    }

    public function edit(): View
    {
        return view('isalfredthere.admin',
            $this->getStatus()
        );
    }

    public function update(Request $request): RedirectResponse
    {
        $text = $request->input('is_alfred_there_text');
        $status = $request->input('where_is_alfred');
        $unix = $request->input('back');
        switch ($status) {
            case IsAlfredThereEnum::UNKNOWN->value:
            case IsAlfredThereEnum::JUR->value:
                $text = '';
                $unix = '';
                break;
            case IsAlfredThereEnum::THERE->value:
            case IsAlfredThereEnum::TEXT_ONLY->value:
                $unix = '';
                break;
        }

        $text = HashMapItem::query()->updateOrCreate(['key' => self::$HashMapTextKey], ['value' => $text]);

        $status = HashMapItem::query()->updateOrCreate(['key' => self::$HashMapItemKey], ['value' => $status]);

        $unix = HashMapItem::query()->updateOrCreate(['key' => self::$HashMapUnixKey], ['value' => $unix]);

        try {
            IsAlfredThereEvent::dispatch($status->value, $text->value, $unix->value);
        } catch (Exception) {
            // if the websocket server is not running, we don't care about the error
            // the webpage will then revert to polling anyway
        }

        Cache::forget('isalfredthere.status');

        return Redirect::back();
    }

    /** @return array{
     *     text: string,
     *     status: string,
     *     unix: string
    } */
    private function getStatus(): array
    {
        return Cache::rememberForever('isalfredthere.status', fn (): array => [
            'text' => HashMapItem::query()->firstOrCreate(['key' => self::$HashMapTextKey], ['value' => ''])->value,
            'status' => HashMapItem::query()->firstOrCreate(['key' => self::$HashMapItemKey], ['value' => IsAlfredThereEnum::UNKNOWN])->value,
            'unix' => HashMapItem::query()->firstOrCreate(['key' => self::$HashMapUnixKey], ['value' => ''])->value,
        ]);
    }
}
