<?php namespace ShineOS\Core\Reminders\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reminders extends Model {
    use SoftDeletes;
    protected $fillable = [];
    protected $dates = ['deleted_at'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reminders';
    protected static $static_table = 'reminders';
    /**
     * Override primary key used by model
     *
     * @var string
     */
    protected $primaryKey = 'reminder_id';

    public function ReminderMessage() {
        return $this->belongsTo('ShineOS\Core\Reminders\Entities\ReminderMessage', 'reminder_id');
    }
}
