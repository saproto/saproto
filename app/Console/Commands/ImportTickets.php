<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

use Proto\Models\Product;
use Proto\Models\StorageEntry;
use Proto\Models\Ticket;
use Proto\Models\TicketPurchase;
use Proto\Models\User;
use Proto\Models\OrderLine;

use Mail;

class ImportTickets extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:importtickets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ticket import.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $database_name = $this->ask('From which database would you like to read ticket data?');

        $mysql = mysqli_connect('127.0.0.1', getenv('DB_USERNAME'), getenv('DB_PASSWORD'), $database_name);

        if (!$mysql) {
            $this->error(mysqli_connect_error());
            return;
        }

        $tickets = $mysql->query('SELECT * FROM tickets');

        $this->info('Found ' . $tickets->num_rows . ' tickets to import.');

        $event2eventmap = [
            1 => 291,
            2 => 257,
            3 => 527,
            4 => 380,
            5 => 472,
            6 => 521,
            8 => 482,
            9 => 527,
            10 => 472
        ];

        while ($old_ticket = $tickets->fetch_assoc()) {
            $product = Product::create([
                'account_id' => 37,
                'name' => $old_ticket['ticket_name'],
                'nicename' => 'imported-ticket-' . $old_ticket['ticket_id'],
                'price' => $old_ticket['ticket_price']
            ]);
            $product->save();
            $ticket = Ticket::create([
                'id' => $old_ticket['ticket_id'],
                'event_id' => $event2eventmap[$old_ticket['event_id']],
                'product_id' => $product->id,
                'members_only' => ($old_ticket['available_external'] == 'Y' ? true : false),
                'available_from' => strtotime($old_ticket['available_from']),
                'available_to' => strtotime($old_ticket['available_to'])
            ]);
            $ticket->save();
        }

        $buys = $mysql->query('SELECT * FROM purchases');

        $this->info('Found ' . $buys->num_rows . ' purchases to import.');

        while ($old_buy = $buys->fetch_assoc()) {

            if ($old_buy['member_id']) {
                $user = User::withTrashed()->find($old_buy['member_id']);
                if (!$user) {
                    $this->error('Could not find existing user ' . $old_buy['member_id']);
                }
            } else {
                $user = User::withTrashed()->where('email', $old_buy['email'])->first();
                if (!$user) {
                    $user = User::withTrashed()->where('name', $old_buy['name'])->first();
                    if (!$user) {
                        $user = User::create([
                            'name' => $old_buy['name'],
                            'calling_name' => explode(' ', $old_buy['name'])[0],
                            'email' => $old_buy['email'],
                            'created_at' => $old_buy['date'],
                            'deleted_at' => $old_buy['date']
                        ]);
                        $user->save();
                        $this->info('Created user for ' . $old_buy['name']);
                    }
                }

            }

            $ticket = Ticket::findOrFail($old_buy['ticket_id']);

            $orderline = OrderLine::create([
                'user_id' => $user->id,
                'product_id' => $ticket->product->id,
                'original_unit_price' => $ticket->product->price,
                'units' => 1,
                'total_price' => $ticket->product->price,
                'payed_with_withdrawal' => 1,
                'created_at' => $old_buy['date']
            ]);
            $orderline->save();

            $buy = TicketPurchase::create([
                'ticket_id' => $ticket->id,
                'orderline_id' => $orderline->id,
                'user_id' => $user->id,
                'barcode' => $old_buy['secret'],
                'scanned' => $old_buy['scanned']
            ]);
            $buy->save();

        }
    }

}
