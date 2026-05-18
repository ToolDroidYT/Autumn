<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Product;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        return view('home', [
            'products' => Product::query()->with('images', 'batches')->where('is_active', true)->take(4)->get(),
            'announcements' => Announcement::query()->where('is_published', true)->latest('published_at')->take(3)->get(),
        ]);
    }

    public function products(Request $request)
    {
        $products = Product::query()
            ->with('images', 'batches')
            ->where('is_active', true)
            ->when($request->filled('program'), fn ($query) => $query->where('program', $request->program))
            ->when($request->filled('q'), fn ($query) => $query->where(fn ($inner) => $inner->where('name', 'like', '%'.$request->q.'%')->orWhere('description', 'like', '%'.$request->q.'%')))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('products.index', compact('products'));
    }

    public function product(Product $product)
    {
        $product->load('images', 'batches.orderItems');

        return view('products.show', compact('product'));
    }

    public function announcements()
    {
        return view('announcements.index', [
            'announcements' => Announcement::query()->where('is_published', true)->latest('published_at')->paginate(9),
        ]);
    }

    public function announcement(Announcement $announcement)
    {
        abort_unless($announcement->is_published, 404);

        return view('announcements.show', compact('announcement'));
    }

    public function faq()
    {
        return view('faq');
    }
}
