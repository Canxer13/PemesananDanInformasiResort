<?php

namespace App\Jobs;

use App\Models\Booking; // Import model Booking
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail; // Import Mail

class SendBookingConfirmationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $booking; // Properti untuk menyimpan data booking

    /**
     * Kita menerima data Booking saat job ini dipanggil.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Jalankan Job.
     * Di sinilah logika pengiriman email terjadi.
     */
    public function handle(): void
    {
        // Ambil email pelanggan dari relasi
        $customerEmail = $this->booking->user->email;
        $customerName = $this->booking->user->full_name;

        // Logika pengiriman email (Anda perlu setup Mail di Laravel)
        // Mail::to($customerEmail)->send(new BookingConfirmedMail($this->booking));

        // Untuk sekarang, kita buat log palsu sebagai bukti
        \Log::info('MENGIRIM EMAIL ke: ' . $customerEmail);
        \Log::info('Booking #' . $this->booking->booking_code . ' telah dikonfirmasi.');
        // (Simulasi butuh 3 detik)
        sleep(3); 
        \Log::info('EMAIL TERKIRIM ke: ' . $customerEmail);
    }
}