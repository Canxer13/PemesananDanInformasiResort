<?php

namespace App\Observers;

use App\Models\Booking;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class BookingObserver
{
    /**
     * Handle the Booking "created" event.
     */
    public function created(Booking $booking): void
    {
        $this->logActivity('booking_created', 'Booking baru #' . $booking->booking_code . ' telah dibuat.', $booking);
    }

    /**
     * Handle the Booking "updated" event.
     */
    public function updated(Booking $booking): void
    {
        // Kita hanya ingin log jika ada perubahan PENTING (seperti status)
        if ($booking->wasChanged('booking_status') || $booking->wasChanged('payment_status')) {
            $actor = Auth::user() ? Auth::user()->full_name : 'Sistem';
            $description = "Status booking #" . $booking->booking_code . " diubah. Status: " . $booking->booking_status . ", Pembayaran: " . $booking->payment_status . ". (Oleh: " . $actor . ")";
            
            $this->logActivity('booking_updated', $description, $booking);
        }
    }

    /**
     * Handle the Booking "deleted" event.
     */
    public function deleted(Booking $booking): void
    {
        $actor = Auth::user() ? Auth::user()->full_name : 'Sistem';
        $this->logActivity('booking_deleted', 'Booking #' . $booking->booking_code . ' telah dihapus. (Oleh: ' . $actor . ')', $booking);
    }

    /**
     * Fungsi helper untuk mencatat log
     */
    private function logActivity(string $action, string $description, Model $model): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(), // ID user yang sedang login (bisa null jika dari sistem)
            'action' => $action,
            'description' => $description,
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
            'ip_address' => request()->ip(),
        ]);
    }
}