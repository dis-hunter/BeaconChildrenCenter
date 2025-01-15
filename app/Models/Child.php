<?php
<<<<<<< HEAD

// app/Models/Child.php
=======
>>>>>>> 4ffaa8539790faf3134ff89a602e71fb7eeac372
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
<<<<<<< HEAD
    use HasFactory;

    protected $table = 'children';

    protected $fillable = [
        'registration_number',
        'fullname',  // JSON field for child's full name
        'gender_id',
        // other attributes...
    ];

    // Relationship to the Parent model
    public function parent()
    {
        return $this->belongsTo(Parents::class, 'parent_id'); // Adjust the foreign key if needed
    }

    // Accessor for fullname (stored as JSON)
    public function getFullnameAttribute($value)
    {
        return json_decode($value, true);  // Decode JSON to array
    }
}


=======
    use HasFactory;  
    protected $table = 'children'; // Assuming the table name is 'children'

    protected $fillable = [
        'registration_number',
        'fullname', 
        'gender_id',
        // ... other attributes ...
    ];

    // Define the relationship to the Triage model
    public function triage()
    {
        return $this->hasOne(Triage::class);
    }

    // Define the relationship to the Gender model
    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    // Accessor for fullname (assuming it's stored as JSON)
    public function getFullnameAttribute($value)
    {
        return json_decode($value);
    }
}
>>>>>>> 4ffaa8539790faf3134ff89a602e71fb7eeac372
