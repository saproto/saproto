<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Mail\ProductBulkUpdateNotification;
use Proto\Models\Account;
use Proto\Models\Product;
use Proto\Models\ProductCategory;
use Proto\Models\ProductCategoryEntry;
use Proto\Models\StorageEntry;

use Redirect;
use Auth;
use Mail;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $paginate = false;
        if ($request->has('search')) {
            $search = $request->get('search');
            $products = Product::where('name', 'like', "%$search%")->orWhere('nicename', 'like', "%$search%")->orderBy('is_visible', 'desc')->orderBy('name', 'asc')->get();
        } elseif ($request->has('filter')) {
            switch ($request->get('filter')) {

                case 'invisible':
                    $products = Product::where('is_visible', false)->orderBy('name', 'asc')->get();
                    break;

                default:
                    $paginate = true;
                    $products = Product::orderBy('is_visible', 'desc')->orderBy('name', 'asc')->paginate(15);
                    break;

            }
        } else {
            $paginate = true;
            $products = Product::orderBy('is_visible', 'desc')->orderBy('name', 'asc')->paginate(15);
        }

        return view('omnomcom.products.index', ['products' => $products, 'paginate' => $paginate]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('omnomcom.products.edit', [
            'product' => null,
            'accounts' => Account::orderBy('account_number', 'asc')->get(),
            'categories' => ProductCategory::all()
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $product = Product::create($request->except('image', 'product_categories'));
        $product->is_visible = $request->has('is_visible');
        $product->is_alcoholic = $request->has('is_alcoholic');
        $product->is_visible_when_no_stock = $request->has('is_visible_when_no_stock');
        $product->price = str_replace(',', '.', $request->price);

        if ($request->file('image')) {
            $file = new StorageEntry();
            $file->createFromFile($request->file('image'));

            $product->image()->associate($file);
        }

        $categories = [];
        if ($request->has('product_categories') && count($request->input('product_categories')) > 0) {
            foreach ($request->input('product_categories') as $category) {
                $category = ProductCategory::find($category);
                if ($category != null) {
                    $categories[] = $category->id;
                }
            }
        }
        $product->categories()->sync($categories);

        $this->setRanks();

        $product->save();

        $request->session()->flash('flash_message', 'The new product has been created!');

        return Redirect::route('omnomcom::products::list', ['search' => $product->nicename]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $orderlines = $product->orderlines()->orderBy('created_at', "DESC")->paginate(15);
        return view('omnomcom.products.show', ['product' => $product, 'orderlines' => $orderlines]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        return view('omnomcom.products.edit', [
            'product' => Product::findOrFail($id),
            'accounts' => Account::orderBy('account_number', 'asc')->get(),
            'categories' => ProductCategory::all()
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $product = Product::findOrFail($id);
        $product->fill($request->except('image', 'product_categories'));
        $product->is_visible = $request->has('is_visible');
        $product->is_alcoholic = $request->has('is_alcoholic');
        $product->is_visible_when_no_stock = $request->has('is_visible_when_no_stock');
        $product->price = str_replace(',', '.', $request->price);

        if ($request->file('image')) {
            $file = new StorageEntry();
            $file->createFromFile($request->file('image'));

            $product->image()->associate($file);
        }

        $product->account()->associate(Account::findOrFail($request->input('account_id')));

        $categories = [];
        if ($request->has('product_categories') && count($request->input('product_categories')) > 0) {
            foreach ($request->input('product_categories') as $category) {
                $category = ProductCategory::find($category);
                if ($category != null) {
                    $categories[] = $category->id;
                }
            }
        }
        $product->categories()->sync($categories);

        $this->setRanks();

        $product->save();

        $request->session()->flash('flash_message', 'The product has been updated.');

        return Redirect::route('omnomcom::products::edit', ['id' => $product->id]);

    }

    public function bulkUpdate(Request $request)
    {

        $input = preg_split('/\r\n|\r|\n/', $request->input('update'));

        $log = "";
        $errors = "";

        $products = [];
        $deltas = [];

        foreach ($input as $lineRaw) {

            $line = explode(',', $lineRaw);

            if (count($line) == 2) {

                $product = Product::find($line[0]);

                if ($product) {

                    $delta = intval($line[1]);

                    $oldstock = $product->stock;
                    $newstock = $oldstock + $delta;

                    $log .= "<strong>" . $product->name . "</strong> updated with delta <strong>" . $line[1] . "</strong>. Stock changed from $oldstock to <strong>$newstock</strong>.<br>";

                    $products[] = $product->id;
                    $deltas[] = $delta;

                } else {

                    $errors .= "<span style='color: red;'>Product ID <strong>" . $line[0] . "</strong> not recognized.</span><br>";

                }

            } else {

                $errors .= "<span style='color: red;'>Incorrect format for line <strong>" . $lineRaw . "</strong>.</span><br>";

            }

        }

        foreach ($products as $i => $product_id) {
            $product = Product::find($product_id);
            $product->stock += $deltas[$i];
            $product->save();
        }

        $request->session()->flash('flash_message', 'Done. Errors:<br>' . $errors);

        Mail::queue((new ProductBulkUpdateNotification(Auth::user(), $errors . $log))->onQueue('low'));

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {

        $product = Product::findOrFail($id);

        if ($product->orderlines->count() > 0) {
            $request->session()->flash('flash_message', "You cannot delete this product because there are orderlines associated with it.");
            return Redirect::back();
        }

        $product->delete();

        $request->session()->flash('flash_message', "The product has been deleted.");
        return Redirect::route('omnomcom::products::list');

    }

    /**
     * Return a CSV file with all product info.
     */
    public function generateCsv()
    {

        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=products.csv',
            'Expires' => '0',
            'Pragma' => 'public'
        ];

        $data = Product::all()->toArray();
        array_unshift($data, array_keys($data[0]));

        $callback = function () use ($data) {
            $f = fopen('php://output', 'w');
            foreach ($data as $row) {
                fputcsv($f, $row);
            }
            fclose($f);
        };

        return response()->stream($callback, 200, $headers);

    }

    public function rank($category_id, $product_id, $direction)
    {
        $relation = ProductCategoryEntry::where('product_id', $product_id)->where('category_id', $category_id)->first();
        if (!$relation) return Redirect::route('omnomcom::categories', ['id' => $category_id]);
        $rank = $relation->rank;
        $rows = ProductCategoryEntry::where('category_id', $category_id)->orderBy('rank')->get();
        foreach ($rows as $key => $row) {
            if ($row->rank == $rank) {
                if ($direction == 'up') {
                    if ($key < count($rows) - 1) {
                        $relation->rank = $rows[$key + 1]->rank;
                        $relation->save();
                        $rows[$key + 1]->rank = $rank;
                        $rows[$key + 1]->save();
                        return Redirect::back();
                    }
                } else {
                    if ($key > 0) {
                        $relation->rank = $rows[$key - 1]->rank;
                        $relation->save();
                        $rows[$key - 1]->rank = $rank;
                        $rows[$key - 1]->save();
                        return Redirect::back();
                    }
                }
            }
        }
        return Redirect::back();
    }

    private function setRanks()
    {
        $newEntries = ProductCategoryEntry::where('rank', 0)->get();
        foreach ($newEntries as $entry) {
            $entry->rank = $entry->id;
            $entry->save();
        }
    }
}
