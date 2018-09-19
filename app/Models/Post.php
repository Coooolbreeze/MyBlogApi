<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/7/21
 * Time: 18:44
 */

namespace App\Models;


/**
 * App\Models\Post
 *
 * @property-read \App\Models\Image $image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read \App\Models\User $user
 * @mixin \Eloquent
 * @property \Carbon\Carbon|null $created_at
 * @property string $detail
 * @property int $dislike
 * @property int $id
 * @property int $image_id
 * @property int $like
 * @property string $outline
 * @property string $title
 * @property \Carbon\Carbon|null $updated_at
 * @property int $user_id
 * @property int $watch
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereDislike($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereLike($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereOutline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereWatch($value)
 * @property-read \App\Models\PostStatistic $statistic
 */
class Post extends Model
{
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }

    public function statistic()
    {
        return $this->hasOne('App\Models\PostStatistic');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function image()
    {
        return $this->belongsTo('App\Models\Image');
    }

    public function toESArray()
    {
        $arr = array_only($this->toArray(), [
            'id',
            'title',
            'user_id',
            'outline',
            'detail'
        ]);

        $arr['author'] = $this->user->nickname;

        $arr['tags'] = $this->tags()->pluck('name')->toArray();

        return  $arr;
    }
}