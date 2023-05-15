<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Proto\Models\StockMutation;

class StockMutationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function filterMutations(Request $rq, array $selection = null)
    {
        $mutations = StockMutation::orderBy('stock_mutations.created_at', 'desc');

        // Find mutations by Pwoduct
        if ($rq->has('product_name') && strlen($rq->get('product_name')) > 2) {
            $search = $rq->get('product_name');
            $mutations = $mutations
                ->join('products','products.id', '=','stock_mutations.product_id','inner')
                ->where('products.name', 'like', "%$search%");
        }

        // Find mutations by authoring User
        if ($rq->has('author_name') && strlen($rq->input('author_name')) > 2) {
            $search = $rq->get('author_name');
            $mutations = $mutations
                ->join('users','users.id', '=','stock_mutations.user_id','inner')
                ->where('users.name', 'like', "%$search%");
        }

        // Find mutations before given date
        if ($rq->has('before')) {
            $before = Carbon::parse($rq->input('before'));
            $mutations = $mutations->where('stock_mutations.created_at', '<=', $before);
        }

        // Find mutations made after given date
        if ($rq->has('after')) {
            $after = Carbon::parse($rq->input('after'));
            $mutations = $mutations->where('stock_mutations.created_at', '>', $after);
        }

        // Filter mwutations by them being a loss
        if ($rq->has('only_loss')) {
            $mutations = $mutations->whereColumn('stock_mutations.before','>','stock_mutations.after');
        }

        // variables for SELECT statement
        // We need this to filter out the data from joins
        // Also prevents shadowing/disappearance of the created_at field
        if($selection == null) {
            $selection = ['stock_mutations.product_id', 'stock_mutations.user_id', 'stock_mutations.created_at', 'stock_mutations.before', 'stock_mutations.after'];
        }

        return $mutations->select($selection);
    }

    public function index(Request $rq)
    {
        return view('omnomcom.products.mutations', ['mutations' => $this->filterMutations($rq)->paginate(25)]);
    }

    public function generateCsv(Request $rq)
    {
        // Exclude the userid, which we don't need for reports
        $selection = ['stock_mutations.product_id', 'stock_mutations.before', 'stock_mutations.after', 'stock_mutations.created_at'];
        $mutations = $this->filterMutations($rq, $selection)->get()->toArray();

        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=mutations.csv',
            'Expires' => '0',
            'Pragma' => 'public',
        ];

        $callback = function () use ($mutations) {
            $f = fopen('php://output', 'w');

            $csv_header = ['Product ID', 'Change', 'Old stock', 'Updated stock', 'Creation time'];
            fputcsv($f, $csv_header);

            foreach ($mutations as $row) {
                fputcsv($f,[$row['product_id'], $row['after'] - $row['before'], $row['before'], $row['after'], $row['created_at']]);
            }
            fclose($f);
        };

        return response()->stream($callback, 200, $headers);
    }
}
