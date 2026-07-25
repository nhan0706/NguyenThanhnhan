<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'customer_id',
        'total_amount',
        'status_id',
        'payment_method',
        'payment_status',
        'note',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function statusRelation()
    {
        return $this->belongsTo(OrderStatus::class, 'status_id');
    }

    public static function getStatusesList()
    {
        return OrderStatus::pluck('name', 'id')->toArray();
    }

    public static function getPaymentStatusesList()
    {
        return [
            'unpaid' => 'Chưa thanh toán',
            'paid' => 'Đã thanh toán',
        ];
    }

    public function getStatusLabelAttribute()
    {
        return $this->statusRelation?->name ?? 'Chờ xử lý';
    }

    public function getStatusBadgeAttribute()
    {
        return $this->statusRelation?->class ?? 'bg-secondary text-white';
    }

    public function getPaymentStatusLabelAttribute()
    {
        $statuses = self::getPaymentStatusesList();
        return $statuses[$this->payment_status] ?? $this->payment_status;
    }

    public function getPaymentStatusBadgeAttribute()
    {
        $badges = [
            'unpaid' => 'bg-secondary text-white',
            'paid' => 'bg-success text-white',
        ];
        return $badges[$this->payment_status] ?? 'bg-secondary text-white';
    }
}
