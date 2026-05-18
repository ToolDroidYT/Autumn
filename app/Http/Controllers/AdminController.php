<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Announcement;
use App\Models\Batch;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Receipt;
use App\Models\Role;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'stats' => [
                'Products' => Product::query()->count(),
                'Open Batches' => Batch::query()->where('status', 'open')->count(),
                'Orders' => Order::query()->count(),
                'Pending Payments' => Payment::query()->where('status', 'pending_verification')->count(),
            ],
            'logs' => ActivityLog::query()->with('user')->latest()->take(8)->get(),
        ]);
    }

    public function products()
    {
        return view('admin.products', ['products' => Product::query()->with('batches')->latest()->paginate(12)]);
    }

    public function storeProduct(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'description' => ['required', 'string'],
            'program' => ['required', Rule::in(['DCE', 'IT', 'CS', 'CSIT/DCE', 'CODES'])],
            'category' => ['required', 'string', 'max:40'],
            'price' => ['required', 'numeric', 'min:1'],
        ]);

        $product = Product::query()->create($data + ['slug' => Str::slug($data['name']), 'sizes' => ['XS', 'S', 'M', 'L', 'XL', '2XL'], 'is_active' => true]);
        $product->images()->create(['path' => 'images/products/default.svg', 'alt_text' => $product->name, 'sort_order' => 0]);
        $this->log('created_product', "Created product {$product->name}", $product);

        return back()->with('toast', 'Product created.');
    }

    public function toggleProduct(Product $product)
    {
        $product->update(['is_active' => ! $product->is_active]);
        $this->log('toggled_product', "Toggled product {$product->name}", $product);

        return back()->with('toast', 'Product visibility updated.');
    }

    public function batches()
    {
        return view('admin.batches', [
            'batches' => Batch::query()->with('product')->latest()->paginate(12),
            'products' => Product::query()->orderBy('name')->get(),
        ]);
    }

    public function storeBatch(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'name' => ['required', 'string', 'max:100'],
            'deadline' => ['required', 'date'],
            'slot_limit' => ['required', 'integer', 'min:1'],
        ]);

        $batch = Batch::query()->create($data + ['status' => 'open', 'starts_at' => now(), 'min_downpayment_percent' => 50]);
        $this->log('created_batch', "Created batch {$batch->name}", $batch);

        return back()->with('toast', 'Batch created.');
    }

    public function updateBatchStatus(Request $request, Batch $batch)
    {
        $data = $request->validate(['status' => ['required', Rule::in(['open', 'closed', 'sent_to_printer', 'completed'])]]);
        $batch->update($data);
        $this->log('updated_batch_status', "Updated batch status to {$data['status']}", $batch);

        return back()->with('toast', 'Batch status updated.');
    }

    public function orders()
    {
        return view('admin.orders', ['orders' => Order::query()->with('user', 'items.product')->latest()->paginate(15)]);
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $data = $request->validate(['status' => ['required', Rule::in(['pending', 'confirmed', 'in_production', 'ready_for_pickup', 'claimed', 'cancelled'])]]);
        $order->update($data);
        $this->log('updated_order_status', "Updated {$order->order_code} to {$data['status']}", $order);

        return back()->with('toast', 'Order status updated.');
    }

    public function payments()
    {
        return view('admin.payments', ['payments' => Payment::query()->with('order.user')->latest()->paginate(15)]);
    }

    public function verifyPayment(Payment $payment)
    {
        DB::transaction(function () use ($payment) {
            $payment->update(['status' => 'verified', 'verified_by' => Auth::id(), 'verified_at' => now(), 'rejection_reason' => null]);
            $order = $payment->order;
            $paid = $order->payments()->where('status', 'verified')->sum('amount');
            $order->update([
                'payment_status' => $paid >= $order->total_amount ? 'fully_paid' : 'downpayment_confirmed',
                'status' => $order->status === 'pending' ? 'confirmed' : $order->status,
                'balance_amount' => max(0, $order->total_amount - $paid),
            ]);
            Receipt::query()->firstOrCreate(
                ['order_id' => $order->id],
                ['receipt_number' => 'RCT-'.$order->order_code, 'qr_code' => $order->order_code, 'verification_hash' => hash('sha256', $order->order_code), 'issued_at' => now()]
            );
        });

        $this->log('verified_payment', "Verified payment for {$payment->order->order_code}", $payment);

        return back()->with('toast', 'Payment verified and receipt generated.');
    }

    public function rejectPayment(Request $request, Payment $payment)
    {
        $data = $request->validate(['rejection_reason' => ['nullable', 'string', 'max:160']]);
        $payment->update(['status' => 'rejected', 'rejection_reason' => $data['rejection_reason'] ?? 'Proof was not accepted.']);
        $payment->order->update(['payment_status' => 'rejected']);
        $this->log('rejected_payment', "Rejected payment for {$payment->order->order_code}", $payment);

        return back()->with('toast', 'Payment rejected.');
    }

    public function announcements()
    {
        return view('admin.announcements', ['announcements' => Announcement::query()->latest()->paginate(12)]);
    }

    public function storeAnnouncement(Request $request)
    {
        $data = $request->validate(['title' => ['required', 'string', 'max:160'], 'category' => ['required', 'string', 'max:40'], 'body' => ['required', 'string']]);
        $announcement = Announcement::query()->create($data + ['slug' => Str::slug($data['title']), 'is_published' => true, 'published_at' => now()]);
        $this->log('created_announcement', "Created announcement {$announcement->title}", $announcement);

        return back()->with('toast', 'Announcement published.');
    }

    public function toggleAnnouncement(Announcement $announcement)
    {
        $announcement->update(['is_published' => ! $announcement->is_published]);
        return back()->with('toast', 'Announcement visibility updated.');
    }

    public function voting()
    {
        return view('admin.voting', ['votes' => Vote::query()->with('options')->latest()->paginate(10)]);
    }

    public function storeVote(Request $request)
    {
        $data = $request->validate(['title' => ['required', 'string', 'max:160'], 'description' => ['required', 'string'], 'program' => ['required', 'string'], 'closes_at' => ['required', 'date']]);
        $vote = Vote::query()->create($data + ['status' => 'open']);
        $this->log('created_vote', "Created vote {$vote->title}", $vote);

        return back()->with('toast', 'Vote created.');
    }

    public function storeVoteOption(Request $request, Vote $vote)
    {
        $data = $request->validate(['label' => ['required', 'string', 'max:120']]);
        $vote->options()->create($data + ['votes_count' => 0]);

        return back()->with('toast', 'Vote option added.');
    }

    public function users()
    {
        return view('admin.users', [
            'users' => User::query()->with('role')->latest()->paginate(15),
            'roles' => Role::query()->orderBy('display_name')->get(),
        ]);
    }

    public function updateUserRole(Request $request, User $user)
    {
        $data = $request->validate(['role_id' => ['required', 'exists:roles,id']]);
        $user->update($data);
        $this->log('updated_user_role', "Updated role for {$user->email}", $user);

        return back()->with('toast', 'User role updated.');
    }

    private function log(string $action, string $description, object $subject): void
    {
        ActivityLog::query()->create([
            'user_id' => Auth::id(),
            'action' => $action,
            'subject_type' => $subject::class,
            'subject_id' => $subject->id ?? null,
            'description' => $description,
        ]);
    }
}
