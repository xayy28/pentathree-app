<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailPemesanan;
use App\Models\Fasilitas;
use App\Models\Homestay;
use App\Models\KategoriHomestay;
use App\Models\Pemesanan;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomestayController extends Controller
{
    /**
     * Tampilkan daftar homestay.
     */
    public function index(Request $request)
    {
        $kategori = $request->query('kategori');
        $status = $request->query('status');
        $statuses = ['Tersedia', 'Tidak Tersedia'];
        $categories = KategoriHomestay::orderBy('nama_kategori')->get();

        $homestays = Homestay::with('kategori')
            ->when($kategori, fn ($query) => $query->where('kategori_id', $kategori))
            ->when(in_array($status, $statuses, true), fn ($query) => $query->where('status', $status))
            ->latest()
            ->get();

        $availabilityMonth = $request->query('availability_month', now()->format('Y-m'));
        $monthStart = $this->parseAvailabilityMonth($availabilityMonth);
        $availabilityMonth = $monthStart->format('Y-m');
        $monthEnd = $monthStart->copy()->endOfMonth();
        $calendarDays = collect(range(1, $monthStart->daysInMonth))
            ->map(fn (int $day) => $monthStart->copy()->day($day));
        $previousMonth = $monthStart->copy()->subMonth()->format('Y-m');
        $nextMonth = $monthStart->copy()->addMonth()->format('Y-m');

        $bookingDetails = DetailPemesanan::with('pemesanan.user')
            ->whereIn('homestay_id', $homestays->pluck('homestay_id'))
            ->whereDate('check_in', '<=', $monthEnd->toDateString())
            ->whereDate('check_out', '>', $monthStart->toDateString())
            ->whereHas('pemesanan', function ($query) {
                $query->where('jenis_pemesanan', Pemesanan::JENIS_HOMESTAY)
                    ->whereNotIn('status_pemesanan', Pemesanan::inactiveHomestayStatuses());
            })
            ->get();

        $bookedDates = $this->bookedDatesByHomestay($bookingDetails, $monthStart, $monthEnd);
        $availabilityRows = $homestays->sortBy('nama_homestay')->values()->map(function (Homestay $homestay) use ($calendarDays, $bookedDates) {
            $days = $calendarDays->map(function (Carbon $day) use ($homestay, $bookedDates) {
                $dateKey = $day->toDateString();
                $bookedDetail = $bookedDates[$homestay->homestay_id][$dateKey] ?? null;

                if ($bookedDetail) {
                    return [
                        'date' => $dateKey,
                        'day' => $day->copy(),
                        'state' => 'booked',
                        'label' => 'Berisi',
                        'detail' => $bookedDetail,
                    ];
                }

                if ($homestay->status !== 'Tersedia') {
                    return [
                        'date' => $dateKey,
                        'day' => $day->copy(),
                        'state' => 'unavailable',
                        'label' => 'Tidak tersedia',
                        'detail' => null,
                    ];
                }

                return [
                    'date' => $dateKey,
                    'day' => $day->copy(),
                    'state' => 'available',
                    'label' => 'Kosong',
                    'detail' => null,
                ];
            });

            return [
                'homestay' => $homestay,
                'days' => $days,
                'available_count' => $days->where('state', 'available')->count(),
                'booked_count' => $days->where('state', 'booked')->count(),
                'unavailable_count' => $days->where('state', 'unavailable')->count(),
            ];
        });

        $availabilitySummary = [
            'available' => $availabilityRows->sum('available_count'),
            'booked' => $availabilityRows->sum('booked_count'),
            'unavailable' => $availabilityRows->sum('unavailable_count'),
            'total' => $homestays->count() * $calendarDays->count(),
        ];

        return view('admin.homestay.index', compact(
            'homestays',
            'categories',
            'kategori',
            'status',
            'statuses',
            'availabilityMonth',
            'monthStart',
            'calendarDays',
            'previousMonth',
            'nextMonth',
            'availabilityRows',
            'availabilitySummary',
        ));
    }

    /**
     * Tampilkan form tambah homestay.
     */
    public function create()
    {
        $categories = KategoriHomestay::all();
        $fasilitas = Fasilitas::orderBy('nama_fasilitas')->get();

        return view('admin.homestay.tambah', compact('categories', 'fasilitas'));
    }

    /**
     * Simpan homestay baru.
     */
    public function store(Request $request, ImageUploadService $imageUploadService)
    {
        $request->validate([
            'kategori_id' => 'nullable|exists:kategori_homestays,kategori_id',
            'nama_homestay' => 'required|string|max:255',
            'harga_permalam' => 'required|numeric|min:0',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:Tersedia,Tidak Tersedia',
            'detail' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'exists:fasilitas,fasilitas_id',
        ]);

        $data = $request->only(['kategori_id', 'nama_homestay', 'harga_permalam', 'kapasitas', 'status', 'detail']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $imageUploadService->storePublic(
                $request->file('foto'),
                'uploads/homestays',
                maxWidth: 1600,
                maxHeight: 1000
            );
        }

        $homestay = Homestay::create($data);

        $homestay->fasilitas()->sync($request->input('fasilitas', []));

        return redirect()->route('admin.homestay')->with('success', 'Homestay berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit homestay.
     */
    public function edit($homestay_id)
    {
        $homestay = Homestay::with('fasilitas')->findOrFail($homestay_id);
        $categories = KategoriHomestay::all();
        $fasilitas = Fasilitas::orderBy('nama_fasilitas')->get();
        $selectedFasilitas = $homestay->fasilitas->pluck('fasilitas_id')->toArray();

        return view('admin.homestay.edit', compact('homestay', 'categories', 'fasilitas', 'selectedFasilitas'));
    }

    /**
     * Update data homestay.
     */
    public function update(Request $request, $homestay_id, ImageUploadService $imageUploadService)
    {
        $homestay = Homestay::findOrFail($homestay_id);

        $request->validate([
            'kategori_id' => 'nullable|exists:kategori_homestays,kategori_id',
            'nama_homestay' => 'required|string|max:255',
            'harga_permalam' => 'required|numeric|min:0',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:Tersedia,Tidak Tersedia',
            'detail' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'exists:fasilitas,fasilitas_id',
        ]);

        $homestay->kategori_id = $request->kategori_id;
        $homestay->nama_homestay = $request->nama_homestay;
        $homestay->harga_permalam = $request->harga_permalam;
        $homestay->kapasitas = $request->kapasitas;
        $homestay->status = $request->status;
        $homestay->detail = $request->detail;

        if ($request->hasFile('foto')) {
            if ($homestay->foto && file_exists(public_path($homestay->foto))) {
                @unlink(public_path($homestay->foto));
            }
            $homestay->foto = $imageUploadService->storePublic(
                $request->file('foto'),
                'uploads/homestays',
                maxWidth: 1600,
                maxHeight: 1000
            );
        }

        $homestay->save();

        $homestay->fasilitas()->sync($request->input('fasilitas', []));

        return redirect()->route('admin.homestay')->with('success', 'Homestay berhasil diperbarui.');
    }

    /**
     * Hapus homestay.
     */
    public function destroy($homestay_id)
    {
        $homestay = Homestay::with('detailPemesanans.pemesanan')->findOrFail($homestay_id);

        $hasActiveReservation = $homestay->detailPemesanans
            ->contains(fn ($detail) => $detail->pemesanan
                && $detail->pemesanan->jenis_pemesanan === Pemesanan::JENIS_HOMESTAY
                && ! in_array($detail->pemesanan->status_pemesanan, [
                    ...Pemesanan::inactiveHomestayStatuses(),
                    Pemesanan::STATUS_SELESAI,
                ], true));

        if ($hasActiveReservation) {
            return redirect()->route('admin.homestay')
                ->with('error', 'Homestay tidak dapat dihapus karena masih memiliki reservasi aktif.');
        }

        if ($homestay->foto && file_exists(public_path($homestay->foto))) {
            @unlink(public_path($homestay->foto));
        }

        $homestay->delete();

        return redirect()->route('admin.homestay')->with('success', 'Homestay berhasil dihapus.');
    }

    private function parseAvailabilityMonth(string $availabilityMonth): Carbon
    {
        try {
            return Carbon::createFromFormat('Y-m-d', $availabilityMonth.'-01')->startOfMonth();
        } catch (\Throwable) {
            return now()->startOfMonth();
        }
    }

    private function bookedDatesByHomestay($bookingDetails, Carbon $monthStart, Carbon $monthEnd): array
    {
        $bookedDates = [];

        foreach ($bookingDetails as $detail) {
            if (! $detail->check_in || ! $detail->check_out || ! $detail->pemesanan) {
                continue;
            }

            $start = Carbon::parse($detail->check_in)->max($monthStart);
            $end = Carbon::parse($detail->check_out)->subDay()->min($monthEnd);

            if ($start->greaterThan($end)) {
                continue;
            }

            for ($date = $start->copy(); $date->lessThanOrEqualTo($end); $date->addDay()) {
                $dateKey = $date->toDateString();
                $bookedDates[$detail->homestay_id][$dateKey] = [
                    'pemesanan_id' => $detail->pemesanan->pemesanan_id,
                    'pelanggan' => $detail->pemesanan->user?->nama ?? '-',
                    'check_in' => Carbon::parse($detail->check_in)->format('d M Y'),
                    'check_out' => Carbon::parse($detail->check_out)->format('d M Y'),
                    'status' => $detail->pemesanan->status_pemesanan,
                ];
            }
        }

        return $bookedDates;
    }
}
