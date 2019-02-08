<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Topic
 *
 * @package App
 * @property string $course
 * @property string $title
 * @property string $slug
 * @property text $description
 * @property integer $possition
 * @property tinyInteger $free_lesson
 * @property tinyInteger $published
*/
class Topic extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'slug', 'description', 'possition', 'free_lesson', 'published', 'course_id'];
    protected $hidden = [];
    
    

    /**
     * Set to null if empty
     * @param $input
     */
    public function setCourseIdAttribute($input)
    {
        $this->attributes['course_id'] = $input ? $input : null;
    }

    /**
     * Set attribute to money format
     * @param $input
     */
    public function setPossitionAttribute($input)
    {
        $this->attributes['possition'] = $input ? $input : null;
    }
    
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id')->withTrashed();
    }
    
}
