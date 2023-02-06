<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\UnitType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(30);
        $categories = Category::all();
        $unit_types = UnitType::all();

        return view('master.product.index', [
            'products' => $products,
            'categories' => $categories,
            'unit_types' => $unit_types,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $disk = 'public')
    {
        try {
            $product_image = $this->storeImage($request);

            $product = Product::create($request->all());
            $product->product_image = $product_image;
            $product->save();

            return redirect('product')->with('success', 'Data berhasil diinput !');
        } catch (Exception $e) {
            return redirect('product')->with(['error' => $e->getMessage()]);
        }
    }

    public function storeImage(Request $request, $disk = 'public')
    {
        try {
            $this->validate($request, [
                'product_image' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
            ]);
    
            $file = $request->file('product_image');
            $date = Carbon::now()->format('Y-m-d');
            $product_name = $request->product;
            $extension = $file->getClientOriginalExtension();
            $path = 'product';
            if (! Storage::disk($disk)->exists($path)) {
                Storage::disk($disk)->makeDirectory($path);
            }
    
            $filename = "Product - ".$product_name." ".$date."_". time() .".".$extension;
    
            $file->storeAs($path, $filename, $disk);
    
            return $filename;

        } catch (Exception $e) {
            return redirect('product')->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        $unit_types = UnitType::all();

        return view('master.product.edit', [
            'product' => $product,
            'categories' => $categories,
            'unit_types' => $unit_types,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try { 
            $product = Product::find($id);
            $product->update($request->all());

            if($request->product_image == null){
                $product->product_image = 'no_image.jpeg';
                $product->save();
            } else {
                $product_image = $this->storeImage($request);
                
                $product->product_image = $product_image;
                $product->save();
            }

            return redirect('product')->with('success', 'Data berhasil diupdate !');
        } catch (Exception $e) {
            return redirect('product')->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = Product::find($id);

            $this->deleteAssets($product);

            $product->delete($product);

            return redirect('product')->with('success', 'Data dan foto berhasil dihapus !');
        } catch (Exception $e) {
            return redirect('product')->with(['error' => $e->getMessage()]);
        }
    }

    public function checkAssets($path)
    {
        if ($path == null) {
            return false;
        }

        return (file_exists(storage_path('public/product/' . $path)));
    }

    public function deleteAssets($product)
    {
        //Asset belum terhapus
        if ($this->checkAssets($product->product_image)) {
            unlink(storage_path('public/product/'.$product->product_image));
            //Storage::delete('public/storage/product/' . $product->product_image);
            //Storage::disk('local')->delete('public/product/Product - Stabilos 2023-02-04_1675528390.jpg');
            
        }
    }

    public function download()
    {
        try {
            return Storage::disk('local')->download('public/product/Product - Stabilos 2023-02-04_1675528390.jpg');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
