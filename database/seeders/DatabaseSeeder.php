<?php

namespace Database\Seeders;

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
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $roles = collect([
            ['name' => 'student', 'display_name' => 'Student'],
            ['name' => 'admin', 'display_name' => 'Admin'],
            ['name' => 'super_admin', 'display_name' => 'Super Admin'],
            ['name' => 'payments_admin', 'display_name' => 'Payments Admin'],
            ['name' => 'inventory_admin', 'display_name' => 'Inventory Admin'],
            ['name' => 'operations_admin', 'display_name' => 'Operations Admin'],
        ])->mapWithKeys(fn ($role) => [$role['name'] => Role::query()->updateOrCreate(['name' => $role['name']], $role)]);

        $student = User::query()->updateOrCreate(
            ['email' => 'student@umindanao.edu.ph'],
            ['name' => 'Demo Student', 'program' => 'IT', 'password' => Hash::make('password'), 'role_id' => $roles['student']->id, 'is_active' => true]
        );

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@umindanao.edu.ph'],
            ['name' => 'Demo Admin', 'program' => 'DCE', 'password' => Hash::make('password'), 'role_id' => $roles['admin']->id, 'is_active' => true]
        );

        $super = User::query()->updateOrCreate(
            ['email' => 'superadmin@umindanao.edu.ph'],
            ['name' => 'Demo Super Admin', 'program' => 'DCE', 'password' => Hash::make('password'), 'role_id' => $roles['super_admin']->id, 'is_active' => true]
        );

        $products = collect([
            ['name' => 'IT Department Polo Shirt', 'program' => 'IT', 'category' => 'IT', 'price' => 650, 'image' => 'images/products/it-polo.svg', 'description' => 'Structured IT polo shirt with department mark, clean collar, and presentation-ready silhouette.'],
            ['name' => 'CS Department Cap', 'program' => 'CS', 'category' => 'CS', 'price' => 280, 'image' => 'images/products/cs-cap.svg', 'description' => 'Minimal CS cap for organization events, project demos, and field activities.'],
            ['name' => 'CSIT/DCE Jacket', 'program' => 'CSIT/DCE', 'category' => 'CSIT/DCE', 'price' => 1150, 'image' => 'images/products/dce-jacket.svg', 'description' => 'Batch-produced DCE jacket with autumn-inspired details and program-safe branding.'],
            ['name' => 'CODES Exclusive Tee', 'program' => 'CODES', 'category' => 'CODES', 'price' => 520, 'image' => 'images/products/codes-tee.svg', 'description' => 'Exclusive CODES tee for verified organization members and official organization events.'],
            ['name' => 'DCE Lanyard Pack', 'program' => 'DCE', 'category' => 'DCE', 'price' => 150, 'image' => 'images/products/dce-lanyard.svg', 'description' => 'Department lanyard pack with ID-ready strap and durable clip.'],
            ['name' => 'IT Sticker Pack', 'program' => 'IT', 'category' => 'IT', 'price' => 85, 'image' => 'images/products/it-sticker-pack.svg', 'description' => 'Small-format sticker pack for laptops, notebooks, and project boards.'],
            ['name' => 'CS Event Jersey', 'program' => 'CS', 'category' => 'CS', 'price' => 780, 'image' => 'images/products/cs-jersey.svg', 'description' => 'CS event jersey for intramurals, booth events, and department contests.'],
            ['name' => 'CODES Starter Pack', 'program' => 'CODES', 'category' => 'CODES', 'price' => 960, 'image' => 'images/products/codes-pack.svg', 'description' => 'Bundled tee, lanyard, and sticker pack for CODES organization members.'],
        ])->map(function ($data) {
            $product = Product::query()->updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'program' => $data['program'],
                    'category' => $data['category'],
                    'price' => $data['price'],
                    'sizes' => in_array($data['category'], ['DCE'], true) && str_contains($data['name'], 'Lanyard') ? ['One Size'] : ['XS', 'S', 'M', 'L', 'XL', '2XL'],
                    'is_active' => true,
                ]
            );

            $product->images()->updateOrCreate(
                ['sort_order' => 0],
                ['path' => $data['image'], 'alt_text' => $data['name']]
            );

            Batch::query()->updateOrCreate(
                ['product_id' => $product->id, 'name' => 'Batch 01'],
                ['status' => 'open', 'starts_at' => now()->subDays(4), 'deadline' => now()->addDays(10), 'slot_limit' => 60, 'price_override' => null, 'min_downpayment_percent' => 50]
            );

            Batch::query()->updateOrCreate(
                ['product_id' => $product->id, 'name' => 'Pilot Batch'],
                ['status' => 'closed', 'starts_at' => now()->subMonth(), 'deadline' => now()->subDays(8), 'slot_limit' => 25, 'price_override' => null, 'min_downpayment_percent' => 50]
            );

            return $product;
        });

        $announcements = [
            ['title' => 'Batch 01 Ordering Now Open', 'category' => 'batch order', 'body' => 'The first batch of DCE merchandise is now open for orders. Limited slots are available per product and size.'],
            ['title' => 'Design Voting Ends in 24 Hours', 'category' => 'voting', 'body' => 'The design voting period for the CSIT/DCE hoodie closes soon. Make sure to cast your vote before the deadline.'],
            ['title' => 'System Launch Announcement', 'category' => 'system', 'body' => 'AUTUMN is officially live for demo use. Register using a university email to start browsing and ordering merchandise.'],
        ];

        foreach ($announcements as $announcement) {
            Announcement::query()->updateOrCreate(
                ['slug' => Str::slug($announcement['title'])],
                $announcement + ['is_published' => true, 'published_at' => now()->subDays(rand(1, 12))]
            );
        }

        $vote = Vote::query()->updateOrCreate(
            ['title' => 'CSIT/DCE Hoodie Design Vote'],
            ['description' => 'Select the official design direction for the next CSIT/DCE hoodie batch.', 'program' => 'CSIT/DCE', 'status' => 'open', 'closes_at' => now()->addDays(2)]
        );
        foreach (['Minimal Front Mark', 'Autumn Back Print', 'Department Crest'] as $index => $label) {
            $vote->options()->updateOrCreate(['label' => $label], ['image_path' => 'images/products/dce-jacket.svg', 'votes_count' => 12 + ($index * 7)]);
        }

        $product = $products->first();
        $batch = $product->batches()->where('status', 'open')->first();
        $order = Order::query()->updateOrCreate(
            ['order_code' => 'AUT-DEMO-001'],
            ['user_id' => $student->id, 'status' => 'confirmed', 'payment_status' => 'downpayment_confirmed', 'total_amount' => 650, 'downpayment_amount' => 325, 'balance_amount' => 325, 'notes' => 'Demo seeded order.']
        );
        $order->items()->updateOrCreate(
            ['product_id' => $product->id, 'batch_id' => $batch->id, 'size' => 'M'],
            ['quantity' => 1, 'unit_price' => 650, 'line_total' => 650]
        );
        Payment::query()->updateOrCreate(
            ['order_id' => $order->id, 'reference_number' => 'GCASH-DEMO-0001'],
            ['user_id' => $student->id, 'amount' => 325, 'method' => 'GCash', 'status' => 'verified', 'verified_by' => $admin->id, 'verified_at' => now()]
        );
        Receipt::query()->updateOrCreate(
            ['order_id' => $order->id],
            ['receipt_number' => 'RCT-AUT-DEMO-001', 'qr_code' => 'AUT-DEMO-001', 'verification_hash' => hash('sha256', 'AUT-DEMO-001'), 'issued_at' => now()]
        );

        ActivityLog::query()->create(['user_id' => $super->id, 'action' => 'seeded', 'description' => 'Demo AUTUMN database seeded for final presentation.']);
    }
}
