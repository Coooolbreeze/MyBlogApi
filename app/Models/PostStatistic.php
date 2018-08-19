<?php
/**
 * Created by PhpStorm.
 * User: 392113643
 * Date: 2018/8/6
 * Time: 1:20
 */

namespace App\Models;


/**
 * App\Models\PostStatisticCache
 *
 * @property int $id
 * @property int $post_id
 * @property int $watch
 * @property int $like
 * @property int $dislike
 * @property int $comment
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostStatistic whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostStatistic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostStatistic whereDislike($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostStatistic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostStatistic whereLike($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostStatistic wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostStatistic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PostStatistic whereWatch($value)
 * @mixin \Eloquent
 */
class PostStatistic extends Model
{
    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }
}