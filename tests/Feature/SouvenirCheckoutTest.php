<?php

use App\Models\Keranjang;
use App\Models\KeranjangItem;
use App\Models\Pemesanan;
use App\Models\Souvenir;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
    $this->user = User::where('role', 'user')->first();
    $this->souvenir = Souvenir::where('status', 'Tersedia')->where('stok', '>', 0)->first();
});

function addSouvenirToCart(User $user, Souvenir $souvenir, int $quantity = 1): KeranjangItem
{
    $keranjang = Keranjang::firstOrCreate([
        'user_id' => $user->user_id,
    ]);

    return KeranjangItem::create([
        'id_keranjang' => $keranjang->id,
        'souvenir_id' => $souvenir->souvenir_id,
        'quantity' => $quantity,
    ]);
}

test('user can checkout cart into pemesanan and detail pemesanan', function () {
    addSouvenirToCart($this->user, $this->souvenir, 2);
    $initialStock = $this->souvenir->stok;
    $expectedTotal = ($this->souvenir->harga * 2) + 5000;

    $response = $this->actingAs($this->user)->post(route('checkout.store'), [
        'pengiriman' => 'pickup',
    ]);

    $pemesanan = Pemesanan::with('detailPemesanans')->first();

    $response->assertRedirect(route('user.pesanan.show', $pemesanan->pemesanan_id));
    $response->assertSessionHas('success');

    expect($pemesanan->user_id)->toBe($this->user->user_id);
    expect($pemesanan->jenis_pemesanan)->toBe(Pemesanan::JENIS_SOUVENIR);
    expect($pemesanan->status_pemesanan)->toBe(Pemesanan::STATUS_MENUNGGU_PEMBAYARAN);
    expect((float) $pemesanan->total_harga)->toBe((float) $expectedTotal);
    expect($pemesanan->detailPemesanans)->toHaveCount(1);

    $detail = $pemesanan->detailPemesanans->first();
    expect($detail->souvenir_id)->toBe($this->souvenir->souvenir_id);
    expect($detail->nama_item)->toBe($this->souvenir->nama_souvenir);
    expect($detail->jumlah)->toBe(2);
    expect((float) $detail->subtotal)->toBe((float) ($this->souvenir->harga * 2));

    expect(KeranjangItem::count())->toBe(0);
    expect($this->souvenir->fresh()->stok)->toBe($initialStock);
});

test('checkout redirects back when cart is empty', function () {
    $response = $this->actingAs($this->user)->post(route('checkout.store'), [
        'pengiriman' => 'pickup',
    ]);

    $response->assertRedirect(route('cart.index'));
    $response->assertSessionHas('error');
    expect(Pemesanan::count())->toBe(0);
});

test('checkout validates stock before creating pemesanan', function () {
    addSouvenirToCart($this->user, $this->souvenir, $this->souvenir->stok + 1);

    $response = $this->actingAs($this->user)->post(route('checkout.store'), [
        'pengiriman' => 'pickup',
    ]);

    $response->assertRedirect(route('cart.index'));
    $response->assertSessionHas('error');
    expect(Pemesanan::count())->toBe(0);
    expect(KeranjangItem::count())->toBe(1);
});

test('user can view own order history and detail', function () {
    addSouvenirToCart($this->user, $this->souvenir, 1);

    $this->actingAs($this->user)->post(route('checkout.store'), [
        'pengiriman' => 'pickup',
    ]);

    $pemesanan = Pemesanan::first();

    $this->actingAs($this->user)
        ->get(route('user.pesanan.index'))
        ->assertStatus(200)
        ->assertSee($pemesanan->kode_pemesanan);

    $this->actingAs($this->user)
        ->get(route('user.pesanan.show', $pemesanan->pemesanan_id))
        ->assertStatus(200)
        ->assertSee($pemesanan->kode_pemesanan)
        ->assertSee($this->souvenir->nama_souvenir);
});

test('user cannot view another users order detail', function () {
    addSouvenirToCart($this->user, $this->souvenir, 1);

    $this->actingAs($this->user)->post(route('checkout.store'), [
        'pengiriman' => 'pickup',
    ]);

    $otherUser = User::create([
        'nama' => 'Customer Lain',
        'email' => 'customerlain@example.com',
        'password' => 'password123',
        'no_hp' => '081111111111',
        'alamat' => 'Padang',
        'role' => 'user',
    ]);

    $pemesanan = Pemesanan::first();

    $this->actingAs($otherUser)
        ->get(route('user.pesanan.show', $pemesanan->pemesanan_id))
        ->assertNotFound();
});
