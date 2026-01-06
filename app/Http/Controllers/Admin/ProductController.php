<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * 🔐 PROTEKSI ADMIN (INI YANG KAMU KURANG)
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Menampilkan daftar produk
     */
    public function index(Request $request): View
    {
        $products = Product::query()
            ->with(['category', 'primaryImage'])
            ->when($request->search, fn ($q, $search) => $q->search($search))
            ->when($request->category, fn ($q, $cat) => $q->where('category_id', $cat))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $categories = Category::active()->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::active()->orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $product = Product::create($request->validated());

            if ($request->hasFile('images')) {
                $this->uploadImages($request->file('images'), $product);
            }

            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Produk berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(Product $product): View
    {
        $product->load(['category', 'images', 'orderItems']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $categories = Category::active()->orderBy('name')->get();
        $product->load('images');

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $product->update($request->validated());

            if ($request->hasFile('images')) {
                $this->uploadImages($request->file('images'), $product);
            }

            if ($request->filled('delete_images')) {
                $this->deleteImages($request->delete_images);
            }

            if ($request->filled('primary_image')) {
                $this->setPrimaryImage($product, (int) $request->primary_image);
            }

            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Produk berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(Product $product): RedirectResponse
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus');
    }

    /* ================= HELPER ================= */

    protected function uploadImages(array $files, Product $product): void
    {
        $isFirst = $product->images()->count() === 0;

        foreach ($files as $index => $file) {
            $filename = "product-{$product->id}-" . time() . "-{$index}." . $file->extension();
            $path = $file->storeAs('products', $filename, 'public');

            $product->images()->create([
                'image_path' => $path,
                'is_primary' => $isFirst && $index === 0,
                'sort_order' => $product->images()->count() + $index,
            ]);
        }
    }

    protected function deleteImages(array $ids): void
    {
        $images = ProductImage::whereIn('id', $ids)->get();

        foreach ($images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
    }

    protected function setPrimaryImage(Product $product, int $imageId): void
    {
        $product->images()->update(['is_primary' => false]);
        $product->images()->where('id', $imageId)->update(['is_primary' => true]);
    }
}
