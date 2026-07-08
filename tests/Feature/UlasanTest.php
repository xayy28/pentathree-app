<?php

use App\Models\DetailPemesanan;
use App\Models\Homestay;
use App\Models\Pembayaran;
use App\Models\Pemesanan;
use App\Models\Souvenir;
use App\Models\Ulasan;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
    $this->user = User::where('role', 'user')->first();
    $this->admin = User::where('role', 'admin')->first();
    $this->souvenir = Souvenir::where('status', 'Tersedia')->where('stok', '>', 0)->first();
    $this->homestay = Homestay::where('status', 'Tersedia')->first();
});

function createSouvenirOrderForUlasanTest(User $user, Souvenir $souvenir, string $status = Pemesanan::STATUS_SELESAI): array
{
    $pemesanan = Pemesanan::create([
        'user_id' => $user->user_id,
        'jenis_pemesanan' => Pemesanan::JENIS_SOUVENIR,
        'total_harga' => $souvenir->harga * 2,
        'status_pemesanan' => $status,
    ]);

    $detail = DetailPemesanan::create([
        'pemesanan_id' => $pemesanan->pemesanan_id,
        'souvenir_id' => $souvenir->souvenir_id,
        'nama_item' => $souvenir->nama_souvenir,
        'harga' => $souvenir->harga,
        'jumlah' => 2,
        'subtotal' => $souvenir->harga * 2,
    ]);

    return [$pemesanan, $detail];
}

function createHomestayOrderForUlasanTest(User $user, Homestay $homestay): array
{
    $pemesanan = Pemesanan::create([
        'user_id' => $user->user_id,
        'jenis_pemesanan' => Pemesanan::JENIS_HOMESTAY,
        'total_harga' => $homestay->harga_permalam * 2,
        'status_pemesanan' => Pemesanan::STATUS_SELESAI,
    ]);

    $detail = DetailPemesanan::create([
        'pemesanan_id' => $pemesanan->pemesanan_id,
        'homestay_id' => $homestay->homestay_id,
        'nama_item' => $homestay->nama_homestay,
        'harga' => $homestay->harga_permalam,
        'jumlah' => 1,
        'check_in' => now()->subDays(3)->toDateString(),
        'check_out' => now()->subDay()->toDateString(),
        'jumlah_malam' => 2,
        'subtotal' => $homestay->harga_permalam * 2,
    ]);

    return [$pemesanan, $detail];
}

test('guest cannot submit ulasan', function () {
    [$pemesanan, $detail] = createSouvenirOrderForUlasanTest($this->user, $this->souvenir);

    $this->post(route('user.ulasan.store', [$pemesanan->pemesanan_id, $detail->detail_pemesanan_id]), [
        'rating' => 5,
        'komentar' => 'Produk bagus.',
    ])->assertRedirect(route('login'));
});

test('user can submit ulasan for completed souvenir order item', function () {
    [$pemesanan, $detail] = createSouvenirOrderForUlasanTest($this->user, $this->souvenir);

    $this->actingAs($this->user)
        ->post(route('user.ulasan.store', [$pemesanan->pemesanan_id, $detail->detail_pemesanan_id]), [
            'rating' => 5,
            'komentar' => 'Produk rapi dan sesuai pesanan.',
        ])
        ->assertRedirect(route('user.pesanan.show', $pemesanan->pemesanan_id))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('ulasans', [
        'user_id' => $this->user->user_id,
        'detail_pemesanan_id' => $detail->detail_pemesanan_id,
        'souvenir_id' => $this->souvenir->souvenir_id,
        'rating' => 5,
        'komentar' => 'Produk rapi dan sesuai pesanan.',
    ]);

    $this->actingAs($this->user)
        ->get(route('user.souvenir.show', $this->souvenir->souvenir_id))
        ->assertStatus(200)
        ->assertSee('Ulasan Pelanggan')
        ->assertSee('Produk rapi dan sesuai pesanan.')
        ->assertSee('5 dari 5');
});

test('user cannot submit ulasan before order is completed', function () {
    [$pemesanan, $detail] = createSouvenirOrderForUlasanTest($this->user, $this->souvenir, Pemesanan::STATUS_DIPROSES);

    $this->actingAs($this->user)
        ->from(route('user.pesanan.show', $pemesanan->pemesanan_id))
        ->post(route('user.ulasan.store', [$pemesanan->pemesanan_id, $detail->detail_pemesanan_id]), [
            'rating' => 4,
            'komentar' => 'Belum selesai.',
        ])
        ->assertRedirect(route('user.pesanan.show', $pemesanan->pemesanan_id))
        ->assertSessionHas('error');

    expect(Ulasan::count())->toBe(0);
});

test('admin can mark verified souvenir order as completed for review', function () {
    [$pemesanan] = createSouvenirOrderForUlasanTest($this->user, $this->souvenir, Pemesanan::STATUS_DIPROSES);

    $pembayaran = Pembayaran::create([
        'pemesanan_id' => $pemesanan->pemesanan_id,
        'metode_pembayaran' => 'transfer_bank',
        'jumlah_bayar' => $pemesanan->total_harga,
        'status_pembayaran' => Pembayaran::STATUS_TERVERIFIKASI,
        'tanggal_pembayaran' => now(),
        'verified_at' => now(),
        'verified_by' => $this->admin->user_id,
    ]);

    $this->actingAs($this->admin)
        ->post(route('admin.pembayaran.complete', $pembayaran->pembayaran_id))
        ->assertRedirect(route('admin.pembayaran.show', $pembayaran->pembayaran_id))
        ->assertSessionHas('success');

    expect($pemesanan->refresh()->status_pemesanan)->toBe(Pemesanan::STATUS_SELESAI);

    $this->actingAs($this->user)
        ->get(route('user.pesanan.show', $pemesanan->pemesanan_id))
        ->assertStatus(200)
        ->assertSee('Ulasan Pesanan');
});
test('user cannot submit ulasan for another customers order', function () {
    [$pemesanan, $detail] = createSouvenirOrderForUlasanTest($this->user, $this->souvenir);

    $otherUser = User::create([
        'nama' => 'Customer Review Lain',
        'email' => 'review-other@example.com',
        'password' => bcrypt('password'),
        'no_hp' => '081222222222',
        'alamat' => 'Padang',
        'role' => 'user',
    ]);

    $this->actingAs($otherUser)
        ->post(route('user.ulasan.store', [$pemesanan->pemesanan_id, $detail->detail_pemesanan_id]), [
            'rating' => 5,
            'komentar' => 'Tidak boleh.',
        ])
        ->assertNotFound();

    expect(Ulasan::count())->toBe(0);
});

test('submitting ulasan twice updates existing review', function () {
    [$pemesanan, $detail] = createSouvenirOrderForUlasanTest($this->user, $this->souvenir);

    $this->actingAs($this->user)
        ->post(route('user.ulasan.store', [$pemesanan->pemesanan_id, $detail->detail_pemesanan_id]), [
            'rating' => 5,
            'komentar' => 'Pertama.',
        ]);

    $this->actingAs($this->user)
        ->post(route('user.ulasan.store', [$pemesanan->pemesanan_id, $detail->detail_pemesanan_id]), [
            'rating' => 3,
            'komentar' => 'Diperbarui.',
        ]);

    expect(Ulasan::count())->toBe(1);
    $this->assertDatabaseHas('ulasans', [
        'detail_pemesanan_id' => $detail->detail_pemesanan_id,
        'rating' => 3,
        'komentar' => 'Diperbarui.',
    ]);
});

test('homestay ulasan appears on homestay detail page', function () {
    [$pemesanan, $detail] = createHomestayOrderForUlasanTest($this->user, $this->homestay);

    $this->actingAs($this->user)
        ->post(route('user.ulasan.store', [$pemesanan->pemesanan_id, $detail->detail_pemesanan_id]), [
            'rating' => 4,
            'komentar' => 'Homestay nyaman untuk keluarga.',
        ]);

    $this->actingAs($this->user)
        ->get(route('user.homestay.show', $this->homestay->homestay_id))
        ->assertStatus(200)
        ->assertSee('Ulasan Pelanggan')
        ->assertSee('Homestay nyaman untuk keluarga.')
        ->assertSee('4 dari 5');
});
