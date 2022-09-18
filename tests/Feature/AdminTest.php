<?php

namespace Tests\Feature;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Address;
use App\Models\Content;
use App\Models\File;
use App\Models\Page;
use App\Models\Payment;
use App\Models\PaymentSystem;
use App\Models\PaymentType;
use App\Models\User;
use App\Models\UserReferral;
use App\Models\UserUserAgent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Check content list page
     */
    public function test_check_content_list_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        /** @var Content $content */
        $content = Content::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('admin.content.index'));

        $response->assertStatus(200);
        $response->assertSeeText('Contents');
        $response->assertSeeText($content->title);
        $response->assertSeeText($content->preview);
    }

    /**
     * Check content create page
     */
    public function test_check_content_create_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('admin.content.create'));

        $response->assertStatus(200);
        $response->assertSeeText('Content');
        $response->assertSeeText('Add new content');
        $response->assertSeeText('Title');
        $response->assertSeeText('Preview');
        $response->assertSeeText('Text');
        $response->assertSeeText('File (width 300, height 200 only)');
        $response->assertSeeText('File description');
        $response->assertSeeText('Delayed publication');
        $response->assertSeeText('Create');
    }

    /**
     * Create content
     */
    public function test_content_create()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        Storage::fake('local');
        $file = UploadedFile::fake()->create('image.jpg');

        $this->actingAs($user);

        $params = [
            'title' => $this->faker->title,
            'preview' => $this->faker->title,
            'text' => $this->faker->text,
            'file' => $file,
            'delayed_time_publication' => '2022-01-29 10:46:00',
            'description' => 'File description',
        ];

        $response = $this->post(route('admin.content.store'), $params);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.content.index'));
        $this->assertDatabaseHas(Content::class, [
            'title' => $params['title'],
            'preview' => $params['preview'],
            'text' => $params['text'],
            'delayed_time_publication' => $params['delayed_time_publication'],
        ]);
        $this->assertDatabaseHas(File::class, [
            'description' => $params['description'],
            'user_id' => $user->id,
            'fileable_type' => Content::class
        ]);
    }

    /**
     * Check edit content page
     */
    public function test_check_content_edit_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $content = Content::factory()->create();

        $response = $this->get(route('admin.content.edit', $content));

        $response->assertStatus(200);
        $response->assertSeeText('Update content');
        $response->assertSeeText('Return');
        $response->assertSeeText('Title');
        $response->assertSeeText('Preview');
        $response->assertSeeText('Text');
        $response->assertSeeText('Files');
        $response->assertSeeText('Delayed publication');
        $response->assertSeeText('Update');
        $response->assertSeeText($content->text);
        $response->assertSeeText($content->preview);
    }

    /**
     * Update content
     */
    public function test_content_update()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $content = Content::factory()->create();

        $params = [
            'title' => $this->faker->title,
            'preview' => $this->faker->title,
            'text' => $this->faker->text,
            'delayed_time_publication' => '2023-01-29 10:46:00',
        ];

        $response = $this->put(route('admin.content.update', $content), $params);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.content.edit', $content));
        $response->assertSessionHas([
            'success-message' => 'Success!',
        ]);
        $this->assertDatabaseHas(Content::class, [
            'id' => $content->id,
            'title' => $params['title'],
            'preview' => $params['preview'],
            'text' => $params['text'],
            'delayed_time_publication' => $params['delayed_time_publication'],
        ]);
    }

    /**
     * Delete content
     */
    public function test_content_delete()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $content = Content::factory()->create();

        $this->assertDatabaseHas(Content::class, [
            'id' => $content->id,
            'title' => $content->title,
            'preview' => $content->preview,
            'text' => $content->text,
            'delayed_time_publication' => $content->delayed_time_publication,
        ]);

        $response = $this->delete(route('admin.content.destroy', $content));

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.content.index'));
        $response->assertSessionHas([
            'success-message' => 'Success!',
        ]);

        $this->assertSoftDeleted(Content::class, [
            'id' => $content->id,
        ]);
    }

    /**
     * Check pages list page
     */
    public function test_check_pages_list_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        /** @var Page $page */
        $page = Page::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('admin.page.index'));

        $response->assertStatus(200);
        $response->assertSeeText('Pages');
        $response->assertSeeText('Create');
        $response->assertSeeText($page->title);
    }

    /**
     * Check create page
     */
    public function test_check_page_create_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('admin.page.create'));

        $response->assertStatus(200);
        $response->assertSeeText('Return');
        $response->assertSeeText('Pages');
        $response->assertSeeText('Create new page');
        $response->assertSeeText('Title');
        $response->assertSeeText('Text');
        $response->assertSeeText('Create');
    }

    /**
     * Check edit page
     */
    public function test_check_page_edit_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $page = Page::factory()->create();

        $response = $this->get(route('admin.page.edit', $page));

        $response->assertStatus(200);
        $response->assertSeeText('Pages');
        $response->assertSeeText('Update');
        $response->assertSeeText('Return');
        $response->assertSeeText('Title');
        $response->assertSeeText('Text');
        $response->assertSeeText($page->text);
    }

    /**
     * Create page
     */
    public function test_page_create()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $params = [
            'title' => $this->faker->title,
            'text' => $this->faker->text,
        ];

        $response = $this->post(route('admin.page.store'), $params);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.page.index'));
        $this->assertDatabaseHas(Page::class, [
            'title' => $params['title'],
            'text' => $params['text'],
        ]);
    }

    /**
     * Update page
     */
    public function test_page_update()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $page = Page::factory()->create();

        $params = [
            'title' => $this->faker->title,
            'text' => $this->faker->text,
        ];

        $response = $this->put(route('admin.page.update', $page), $params);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.page.edit', $page));
        $response->assertSessionHas([
            'success-message' => 'Success!',
        ]);
        $this->assertDatabaseHas(Page::class, [
            'id' => $page->id,
            'title' => $params['title'],
            'text' => $params['text'],
        ]);
    }

    /**
     * Delete page
     */
    public function test_page_delete()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $page = Page::factory()->create();

        $this->assertDatabaseHas(Page::class, [
            'id' => $page->id,
            'title' => $page->title,
            'text' => $page->text,
        ]);

        $response = $this->delete(route('admin.page.destroy', $page));

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.page.index'));
        $response->assertSessionHas([
            'success-message' => 'Success!',
        ]);

        $this->assertSoftDeleted(Page::class, [
            'id' => $page->id,
        ]);
    }

    /**
     * Check address list page
     */
    public function test_check_addresses_list_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        /** @var Address $address */
        $address = Address::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('admin.address.index'));

        $response->assertStatus(200);
        $response->assertSeeText('Addresses');
        $response->assertSeeText('Create');
        $response->assertSeeText($address->address);
    }

    /**
     * Search address
     */
    public function test_search_address()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        /** @var Address $firstAddress */
        $firstAddress = Address::factory()->create();

        /** @var Address $secondAddress */
        $secondAddress = Address::factory()->create();

        $this->actingAs($user);

        $firstResponse = $this->get(route('admin.address.index') . '?address=' . $firstAddress->address);

        $firstResponse->assertStatus(200);
        $firstResponse->assertSeeText('Addresses');
        $firstResponse->assertSeeText('Create');
        $firstResponse->assertSeeText($firstAddress->address);
        $firstResponse->assertDontSeeText($secondAddress->address);

        $secondResponse = $this->get(route('admin.address.index'));

        $secondResponse->assertStatus(200);
        $secondResponse->assertSeeText('Addresses');
        $secondResponse->assertSeeText('Create');
        $secondResponse->assertSeeText($firstAddress->address);
        $secondResponse->assertSeeText($secondAddress->address);
    }

    /**
     * Check create address
     */
    public function test_check_address_create_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('admin.address.create'));

        $response->assertStatus(200);
        $response->assertSeeText('Address');
        $response->assertSeeText('Add new address');
        $response->assertSeeText('Return');
        $response->assertSeeText('Payment system');
        $response->assertSeeText('Create');
    }

    /**
     * Create address
     */
    public function test_address_create()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $paymentSystems = PaymentSystem::all();

        $params = [
            'address' => $this->faker->text(20),
            'payment_system_id' => $paymentSystems->first()->id,
        ];

        $response = $this->post(route('admin.address.store'), $params);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.address.index'));
        $this->assertDatabaseHas(Address::class, [
            'address' => $params['address'],
            'payment_system_id' => $params['payment_system_id'],
        ]);
    }

    /**
     * Check user list page
     */
    public function test_check_user_list_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('admin.user.index'));

        $response->assertStatus(200);
        $response->assertSeeText('Users');
        $response->assertSeeText('Create');
        $response->assertSeeText($user->email);
    }

    /**
     * Search user
     */
    public function test_search_user()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $firstUser */
        $firstUser = User::factory()->create();
        $firstUser->roles()->sync($role->id);
        $firstUser->save();
        $firstUser->refresh();

        /** @var User $secondUser */
        $secondUser = User::factory()->create();
        $secondUser->roles()->sync($role->id);
        $secondUser->save();
        $secondUser->refresh();

        $this->actingAs($firstUser);

        $firstResponse = $this->get(route('admin.user.index'));

        $firstResponse->assertStatus(200);
        $firstResponse->assertSeeText('Users');
        $firstResponse->assertSeeText('Create');
        $firstResponse->assertSeeText($firstUser->email);
        $firstResponse->assertSeeText($secondUser->email);

        $secondResponse = $this->get(route('admin.user.index') . '?email=' . $firstUser->email);

        $secondResponse->assertStatus(200);
        $secondResponse->assertSeeText('Users');
        $secondResponse->assertSeeText('Create');
        $secondResponse->assertSeeText($firstUser->email);
        $secondResponse->assertDontSeeText($secondUser->email);
    }

    /**
     * Check user create page
     */
    public function test_check_user_create_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('admin.user.create'));

        $response->assertStatus(200);
        $response->assertSeeText('Creating new user');
        $response->assertSeeText('Return');
        $response->assertSeeText('Add new user');
        $response->assertSeeText('Email address');
        $response->assertSeeText('Password');
        $response->assertSeeText('Repeat password');
        $response->assertSeeText('Telegram');
        $response->assertSeeText('Referrer');
        $response->assertSeeText('Comment');
        $response->assertSeeText('Create');
    }

    /**
     * Create user
     */
    public function test_user_create()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $params = [
            'email' => $this->faker->email,
            'telegram' => $this->faker->text(15),
            'comment' => $this->faker->text(50),
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post(route('admin.user.store'), $params);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.user.index'));
        $this->assertDatabaseHas(User::class, ['email' => $params['email']]);
    }

    /**
     * Check user edit page
     */
    public function test_check_user_edit_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('admin.user.edit', $user));

        $response->assertStatus(200);
        $response->assertSeeText('Information about user');
        $response->assertSeeText('Return');
        $response->assertSeeText('Payment information');
        $response->assertSeeText('Update user form');
        $response->assertSeeText('Payments');
        $response->assertSeeText('Files');
        $response->assertSeeText('User logs');
        $response->assertSeeText('Referrals');
    }

    /**
     * Check user logs list page
     */
    public function test_check_user_logs_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $firstUser */
        $firstUser = User::factory()->create();
        $firstUser->roles()->sync($role->id);
        $firstUser->save();
        $firstUser->refresh();

        /** @var User $secondUser */
        $secondUser = User::factory()->create();
        $secondUser->roles()->sync($role->id);
        $secondUser->save();
        $secondUser->refresh();

        UserUserAgent::factory()->create(['user_id' => $firstUser->id]);
        UserUserAgent::factory()->create(['user_id' => $secondUser->id]);

        $this->actingAs($firstUser);

        $firstResponse = $this->get(route('admin.user.log'));

        $firstResponse->assertStatus(200);
        $firstResponse->assertSeeText('User logs');
        $firstResponse->assertSeeText($firstUser->email);
        $firstResponse->assertSeeText($secondUser->email);

        $secondResponse = $this->get(route('admin.user.log') . '?email=' . $firstUser->email);

        $secondResponse->assertStatus(200);
        $secondResponse->assertSeeText('User logs');
        $secondResponse->assertSeeText($firstUser->email);
        $secondResponse->assertDontSeeText($secondUser->email);
    }

    /**
     * Check user referrals list page
     */
    public function test_check_user_referrals_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $firstUser */
        $firstUser = User::factory()->create();
        $firstUser->roles()->sync($role->id);
        $firstUser->save();
        $firstUser->refresh();

        /** @var User $secondUser */
        $secondUser = User::factory()->create();
        $secondUser->roles()->sync($role->id);
        $secondUser->save();
        $secondUser->refresh();

        UserReferral::factory()->create([
            'user_id' => $firstUser->id,
            'referral_id' => 1
        ]);
        UserReferral::factory()->create([
            'user_id' => $secondUser->id,
            'referral_id' => 1
        ]);

        $this->actingAs($firstUser);

        $firstResponse = $this->get(route('admin.referral'));

        $firstResponse->assertStatus(200);
        $firstResponse->assertSeeText('Referrals');
        $firstResponse->assertSeeText($firstUser->email);
        $firstResponse->assertSeeText($secondUser->email);

        $secondResponse = $this->get(route('admin.referral') . '?email=' . $firstUser->email);

        $secondResponse->assertStatus(200);
        $secondResponse->assertSeeText('Referrals');
        $secondResponse->assertSeeText($firstUser->email);
        $secondResponse->assertDontSeeText($secondUser->email);
    }

    /**
     * Check payments list page
     */
    public function test_check_payments_list_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $firstUser */
        $firstUser = User::factory()->create();
        $firstUser->roles()->sync($role->id);
        $firstUser->save();
        $firstUser->refresh();

        /** @var User $secondUser */
        $secondUser = User::factory()->create();
        $secondUser->roles()->sync($role->id);
        $secondUser->save();
        $secondUser->refresh();

        Payment::factory()->create([
            'user_id' => $firstUser->id
        ]);
        Payment::factory()->create([
            'user_id' => $secondUser->id
        ]);

        $this->actingAs($firstUser);

        $firstResponse = $this->get(route('admin.payment.index'));

        $firstResponse->assertStatus(200);
        $firstResponse->assertSeeText('Payments');
        $firstResponse->assertSeeText('Create');
        $firstResponse->assertSeeText($firstUser->id);
        $firstResponse->assertSeeText($secondUser->id);

        $secondResponse = $this->get(route('admin.payment.index') . '?user=' . $firstUser->id);

        $secondResponse->assertStatus(200);
        $firstResponse->assertSeeText('Payments');
        $firstResponse->assertSeeText('Create');
        $secondResponse->assertSeeText($firstUser->id);
        $secondResponse->assertDontSeeText($secondUser->id);
    }

    /**
     * Check create payment
     */
    public function test_check_payment_create_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('admin.payment.create'));

        $response->assertStatus(200);
        $response->assertSeeText('Payment');
        $response->assertSeeText('Return');
        $response->assertSeeText('Create new payment');
        $response->assertSeeText('User ID');
        $response->assertSeeText('Full amount');
        $response->assertSeeText('Type');
        $response->assertSeeText('Method');
        $response->assertSeeText('Create');
    }

    /**
     * Check edit payment
     */
    public function test_check_payment_edit_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $payment = Payment::factory()->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user);

        $response = $this->get(route('admin.payment.edit', $payment));

        $response->assertStatus(200);
        $response->assertSeeText('Payments');
        $response->assertSeeText('Return');
        $response->assertSeeText('Payment information');
        $response->assertSeeText('Update payment');
    }

    /**
     * Create payment top up positive
     */
    public function test_payment_top_up_create()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $params = [
            'user_id' => $user->id,
            'type' => (string)PaymentType::whereName('real_money')->first()->id,
            'method' => (string)PaymentMethod::TOP_UP,
            'full_amount' => '900',
        ];

        $response = $this->post(route('admin.payment.store'), $params);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.payment.index'));
        $this->assertDatabaseHas(Payment::class, [
            'user_id' => $params['user_id'],
            'status' => PaymentStatus::CREATE,
            'payment_type_id' => PaymentType::whereName('real_money')->first()->id,
            'method' => PaymentMethod::TOP_UP,
            'full_amount' => '900',
            'amount' => '891',
            'commission_amount' => '9',
            'description' => 'User top up balance',
        ]);
    }

    /**
     * Create payment withdraw positive
     */
    public function test_payment_withdraw_create()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create([
            'balance' => 1000
        ]);
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $params = [
            'user_id' => $user->id,
            'type' => (string)PaymentType::whereName('real_money')->first()->id,
            'method' => (string)PaymentMethod::WITHDRAW,
            'full_amount' => '900',
        ];

        $response = $this->post(route('admin.payment.store'), $params);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.payment.index'));
        $this->assertDatabaseHas(Payment::class, [
            'user_id' => $params['user_id'],
            'status' => PaymentStatus::CREATE,
            'payment_type_id' => PaymentType::whereName('real_money')->first()->id,
            'method' => PaymentMethod::WITHDRAW,
            'full_amount' => '-900',
            'amount' => '-891',
            'commission_amount' => '-9',
            'description' => 'User withdraw balance',
        ]);
    }

    /**
     * Create payment withdraw negative
     */
    public function test_payment_withdraw_create_negative()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $params = [
            'user_id' => $user->id,
            'type' => (string)PaymentType::whereName('real_money')->first()->id,
            'method' => (string)PaymentMethod::WITHDRAW,
            'full_amount' => '900',
        ];

        $response = $this->post(route('admin.payment.store'), $params);

        $response->assertStatus(302);
        $response->assertSessionHas([
            'error-message' => 'Can\'t create payment',
        ]);
    }

    /**
     * Check update payment page
     */
    public function test_check_payment_update_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $payment = Payment::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->get(route('admin.payment.edit', [
            'payment' => $payment
        ]));

        $response->assertStatus(200);
        $response->assertSeeText('Payments');
        $response->assertSeeText('Return');
        $response->assertSeeText('Payment information');
        $response->assertSeeText('Update payment');
    }

    /**
     * Update payment (confirm)
     */
    public function test_payment_confirm()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $payment = Payment::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->put(route('admin.payment.update', ['payment' => $payment]), [
            'confirm' => 'Confirm'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas([
            'success-message' => 'Success!',
        ]);
        $response->assertRedirect(route('admin.payment.edit', ['payment' => $payment]));
        $this->assertDatabaseHas(Payment::class, [
            'id' => $payment->id,
            'user_id' => $payment['user_id'],
            'status' => PaymentStatus::PAID,
        ]);
        $this->assertDatabaseHas(User::class, [
            'id' => $payment['user_id'],
            'balance' => $payment['amount'],
        ]);
    }

    /**
     * Update payment (cansel)
     */
    public function test_payment_cansel()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create([
            'balance' => 1000
        ]);
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $payment = Payment::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->put(route('admin.payment.update', ['payment' => $payment]), [
            'cancel' => 'Cancel'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas([
            'success-message' => 'Success!',
        ]);
        $response->assertRedirect(route('admin.payment.edit', ['payment' => $payment]));
        $this->assertDatabaseHas(Payment::class, [
            'id' => $payment->id,
            'user_id' => $payment['user_id'],
            'status' => PaymentStatus::CANCEL,
        ]);
    }

    /**
     * Check transactions list page
     */

    /**
     * Check user statistics list page
     */

    /**
     * Check user statistics finance page
     */

    /**
     * Check file page
     */

    /**
     * Check system notice page
     */

    /**
     * Check settings general page
     */

    /**
     * Update settings general
     */

    /**
     * Check settings notification list page
     */

    /**
     * Create new notification
     */

    /**
     * Edit notification
     */

    /**
     * Destroy notification
     */
}
