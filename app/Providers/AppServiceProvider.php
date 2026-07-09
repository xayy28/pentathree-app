<?php

namespace App\Providers;

use App\Models\Pembayaran;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $unreadTransactionCount = 0;
            $unreadTransactions = collect();

            if (
                Auth::check()
                && Auth::user()->role === 'admin'
                && Schema::hasTable('pemesanans')
                && Schema::hasColumn('pemesanans', 'admin_dilihat_pada')
            ) {
                $baseQuery = Pemesanan::query()
                    ->where(function ($query) {
                        $query->whereHas('pembayaran', function ($paymentQuery) {
                            $paymentQuery->where('status_pembayaran', Pembayaran::STATUS_MENUNGGU_VERIFIKASI);
                        })->orWhere(function ($unreadQuery) {
                            $unreadQuery
                                ->whereNull('admin_dilihat_pada')
                                ->whereNotIn('status_pemesanan', [
                                    Pemesanan::STATUS_SELESAI,
                                    Pemesanan::STATUS_DIBATALKAN,
                                    Pemesanan::STATUS_KEDALUWARSA,
                                ])
                                ->where(function ($transactionQuery) {
                                    $transactionQuery
                                        ->where('jenis_pemesanan', Pemesanan::JENIS_HOMESTAY)
                                        ->orWhereHas('pembayaran');
                                });
                        });
                    });

                $unreadTransactionCount = (clone $baseQuery)->count();
                $unreadTransactions = $baseQuery
                    ->with('user', 'pembayaran')
                    ->latest('tanggal_pemesanan')
                    ->limit(5)
                    ->get();
            }

            $view->with(compact('unreadTransactionCount', 'unreadTransactions'));
        });
    }
}
