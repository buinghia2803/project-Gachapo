<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use App\Models\OrderDetail;
use App\Models\Gacha;
use App\Models\Product;
use App\Models\User;
use App\Models\GachaImage;
use App\Models\Order;
use App\Models\Review;
use App\Models\Page;
use App\Models\Admin;
use App\Models\Banner;
use App\Models\Notification;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }

    public function truncate()
    {
        Schema::disableForeignKeyConstraints();
        DB::truncate('notifies');
        DB::truncate('products');
        DB::truncate('categories');
        DB::truncate('companies');
        DB::truncate('gachas');
        DB::truncate('gacha_images');
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('------------ START DUMMY DATA ------------');
        $this->command->getOutput()->progressStart(50);
        for ($i = 0; $i < 50; $i++) {

            $this->createNotification();
            $this->createProduct();
            $this->createCategory();
            $this->createCompany();
            $this->createGacha();
            $this->createGachaImage();
            $this->createUser();
            $this->createOrders();
            $this->createReview();
            $this->createOrderDetail();
            $this->createCompany();
            $this->createCategory();
            // $this->createPage();

            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();
    }

    /**
     * Create dummy data Gacha.
     */
    public function createGacha()
    {
        $startDate = Carbon::now()->subDays($this->faker->numberBetween(1, 30));
        Gacha::create([
            'name' => $this->faker->name,
            'category_id' => $this->faker->numberBetween(1, 20),
            'company_id' => $this->faker->numberBetween(1, 20),
            'selling_price' => $this->faker->numberBetween(3000, 20000),
            'discounted_price' => $this->faker->numberBetween(100, 1000),
            'discounted_percent' => $this->faker->numberBetween(1, 30),
            'postage' => $this->faker->numberBetween(100, 1000),
            'status_apply_discounts' => $this->faker->numberBetween(1, 2),
            'status_operation' => $this->faker->numberBetween(0, 1),
            'status' => $this->faker->numberBetween(1, 3),
            'period_start' => $startDate,
            'period_end' => $startDate->addDays($this->faker->numberBetween(1, 30)),
            'description' => $this->faker->paragraph(),
        ]);
    }

    // public function createPage()
    // {
    //     $startDate = Carbon::now()->subDays($this->faker->numberBetween(1, 30));
    //     Page::create([
    //         'name' => $this->faker->name,
    //         'category_id' => $this->faker->numberBetween(1, 20),
    //         'company_id' => $this->faker->numberBetween(1, 20),
    //         'selling_price' => $this->faker->numberBetween(3000, 20000),
    //         'discounted_price' => $this->faker->numberBetween(100, 1000),
    //         'discounted_percent' => $this->faker->numberBetween(1, 30),
    //         'postage' => $this->faker->numberBetween(100, 1000),
    //         'status_apply_discounts' => $this->faker->numberBetween(1, 2),
    //         'status_operation' => $this->faker->numberBetween(0, 1),
    //         'status' => $this->faker->numberBetween(1, 3),
    //         'period_start' => $startDate,
    //         'period_end' => $startDate->addDays($this->faker->numberBetween(1, 30)),
    //         'description' => $this->faker->paragraph(),
    //     ]);
    // }

    public function createUser()
    {
        User::create([
            'name' => $this->faker->firstName,
            'name_furigana' => $this->faker->name,
            'email' => $this->faker->unique()->email,
            'password' => bcrypt('Gachapo123'),
            'customer_id' => $this->faker->numberBetween(1, 30),
            'birthday' => Carbon::now()->subDays($this->faker->numberBetween(1, 30))->format('Y-m-d'),
            'phone' => $this->faker->phoneNumber,
            'category_id' => $this->faker->numberBetween(1, 30),
            'gender' => $this->faker->numberBetween(1, 3),
            'profession' => $this->faker->name,
            'address_first' => $this->faker->address,
            'address_second' => $this->faker->address,
            'address_type' => $this->faker->numberBetween(1, 2),
            'status' => $this->faker->numberBetween(1, 3),
            'status_two_step_verification' => $this->faker->numberBetween(0, 1),
            'status_notifice' => $this->faker->numberBetween(0, 1)
        ]);
    }

    public function createAdmin()
    {
        Admin::create([
            'name' => $this->faker->name,
            'name_furigana' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => bcrypt('Gachapo123'),
            'role_id' => $this->faker->numberBetween(0, 5),
            'status' => $this->faker->numberBetween(0, 3),
        ]);
    }

    public function createBanner()
    {
        Banner::create([
            'title' => $this->faker->title,
            'link' => 'https://picsum.photos/seed/picsum/200/300',
            'attachment' => 'https://picsum.photos/seed/picsum/200/300',
            'type' => $this->faker->numberBetween(1, 2),
        ]);
    }

    public function createProduct()
    {
        Product::create([
            'name' => $this->faker->name,
            'gacha_id' => $this->faker->numberBetween(1, 50),
            'quantity' => $this->faker->numberBetween(1, 100),
            'attachment' => 'https://picsum.photos/seed/picsum/200/300',
            'reward_percent' => $this->faker->numberBetween(100, 1000),
            'reward_type' => collect(['A賞', 'B賞', 'C賞', 'D賞'])->random(),
            'reward_status' => $this->faker->numberBetween(1, 3),
            'status' => $this->faker->numberBetween(1, 2),
        ]);
    }

    public function createOrders()
    {
        Order::create([
            'gacha_id' => $this->faker->numberBetween(1, 50),
            'user_id' => $this->faker->numberBetween(1, 50),
            'coupon_id' => $this->faker->numberBetween(1, 10),
            'coupon_price' => $this->faker->numberBetween(100, 500),
            'quantity' => $this->faker->numberBetween(1, 100),
            'gacha_price' => $this->faker->numberBetween(1000, 10000),
            'address_delivery' => $this->faker->address(),
            'status_deliver' => $this->faker->numberBetween(1, 2),
            'date_of_shipment' => Carbon::now()->subDays($this->faker->numberBetween(1, 30))->format('Y-m-d'),
            'created_at' => Carbon::now()->subMonth($this->faker->numberBetween(0, 11))->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->subMonth($this->faker->numberBetween(0, 11))->format('Y-m-d H:i:s'),
        ]);
    }

    public function createReview()
    {
        Review::create([
            'order_id' => $this->faker->numberBetween(1, 50),
            'content' => $this->faker->paragraph(),
            'rating' => $this->faker->numberBetween(1, 5),
            'content_reply' => $this->faker->paragraph(),
            'date_reply' => Carbon::now()->subMonth($this->faker->numberBetween(0, 11))->format('Y-m-d H:i:s'),
            'status' => $this->faker->numberBetween(1, 3),
            'created_at' => Carbon::now()->subMonth($this->faker->numberBetween(0, 11))->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->subMonth($this->faker->numberBetween(0, 11))->format('Y-m-d H:i:s'),
        ]);
    }

    public function createOrderDetail()
    {
        OrderDetail::create([
            'order_id' => $this->faker->numberBetween(1, 50),
            'product_id' => $this->faker->numberBetween(1, 50),
            'quantity' => $this->faker->numberBetween(1, 10),
            'status_receiving' => $this->faker->numberBetween(1, 2),
            'created_at' => Carbon::now()->subMonth($this->faker->numberBetween(0, 11))->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->subMonth($this->faker->numberBetween(0, 11))->format('Y-m-d H:i:s'),
        ]);
    }

    public function createNotification()
    {
        Notification::create([
            'title' => $this->faker->title(),
            'content' => $this->faker->paragraph(),
            'start_time' => Carbon::now()->subDays($this->faker->numberBetween(1, 30))->format('Y-m-d'),
            'end_time' => Carbon::now()->addDays($this->faker->numberBetween(1, 30))->format('Y-m-d'),
            'type' => $this->faker->numberBetween(1, 2),
            'status' => $this->faker->numberBetween(1, 2),
        ]);
    }

    public function createGachaImage()
    {
        GachaImage::create([
            'gacha_id' => $this->faker->numberBetween(1, 50),
            'attachment' => 'https://picsum.photos/seed/picsum/200/300',
        ]);
    }

    public function createCategory()
    {
        Category::create([
            'name' => $this->faker->unique()->name,
            'slug' => Str::random(30),
        ]);
    }

    public function createCompany()
    {
        Company::create([
            'company' => $this->faker->name,
            'company_furigana' => $this->faker->name,
            'person_manager' => $this->faker->firstName(),
            'person_manager_furigana' => $this->faker->firstName(),
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'password' => bcrypt('Gachapo123'),
            'company_information' => $this->faker->paragraph(),
            'site_url' => $this->faker->url(),
            'company_address' => $this->faker->address(),
            'registered_copy_attachment' => 'https://picsum.photos/seed/picsum/200/300',
            'consent_document' => $this->faker->paragraph(),
            'bank_name' => collect(['BIDV', 'Techcombank', 'TPBank', 'Vietcombank', 'MSB', 'MB'])->random(),
            'branch_name' => collect(['Hà Nội', 'Hồ Chí Minh', 'Thanh Hóa', 'Ninh Bình', 'Hải Phòng', 'Nam Định'])->random(),
            'bank_code' => collect(['01203001', '01204009', '01310001', '79307001', '01201001', '01202001'])->random(),
            'branch_code' => collect(['01203003', '31203001', '79201001', '37101001', '36201001'])->random(),
            'bank_type' => $this->faker->numberBetween(1, 10),
            'bank_number' => $this->faker->numberBetween(452389, 8483384),
            'bank_holder' => $this->faker->titleMale,
            'commission' => $this->faker->numberBetween(100, 1000),
            'status_two_step_verification' => $this->faker->numberBetween(0, 1),
            'status_notifice' => $this->faker->numberBetween(0, 1),
            'status' => $this->faker->numberBetween(0, 3),
            'status_approve' => $this->faker->numberBetween(1, 3),
        ]);
    }
}
