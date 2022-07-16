<?php

namespace Proto\Models;

use Carbon;
use Eloquent;
use File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Photo model.
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $file_id
 * @property int $large_file_id
 * @property int $medium_file_id
 * @property int $small_file_id
 * @property int $tiny_file_id
 * @property int $album_id
 * @property int $date_taken
 * @property int $private
 * @property-read PhotoAlbum $album
 * @property-read StorageEntry $file
 * @property-read StorageEntry $large_file
 * @property-read StorageEntry $medium_file
 * @property-read StorageEntry $small_file
 * @property-read StorageEntry $tiny_file
 * @property-read File $url
 * @property-read PhotoLikes[] $likes
 * @method static Builder|Photo whereAlbumId($value)
 * @method static Builder|Photo whereCreatedAt($value)
 * @method static Builder|Photo whereDateTaken($value)
 * @method static Builder|Photo whereFileId($value)
 * @method static Builder|Photo whereId($value)
 * @method static Builder|Photo wherePrivate($value)
 * @method static Builder|Photo whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Photo extends Model
{
    protected $table = 'photos';

    protected $guarded = ['id'];

    /** @return BelongsTo|PhotoAlbum[] */
    public function album()
    {
        return $this->belongsTo('Proto\Models\PhotoAlbum', 'album_id');
    }

    /** @return HasMany */
    public function likes()
    {
        return $this->hasMany('Proto\Models\PhotoLikes');
    }

    /** @return HasOne|StorageEntry */
    private function file()
    {
        return $this->hasOne('Proto\Models\StorageEntry', 'id', 'file_id')->first();
    }

    public function fileRelation(){
        return $this->hasOne('Proto\Models\StorageEntry', 'id', 'file_id');
    }

    /** @return HasOne|StorageEntry */
    private function large_file()
    {
        return $this->hasOne('Proto\Models\StorageEntry', 'id', 'large_file_id')->first();
    }

    /** @return HasOne|StorageEntry */
    private function medium_file()
    {
        return $this->hasOne('Proto\Models\StorageEntry', 'id', 'medium_file_id')->first();
    }

    /** @return HasOne|StorageEntry */
    private function small_file()
    {
        return $this->hasOne('Proto\Models\StorageEntry', 'id', 'small_file_id')->first();
    }

    /** @return HasOne|StorageEntry */
    private function tiny_file()
    {
        return $this->hasOne('Proto\Models\StorageEntry', 'id', 'tiny_file_id')->first();
    }

    /**
     * @param bool $next
     * @return Photo
     */
    private function getAdjacentPhoto($next = true)
    {
        if ($next) {
            $ord = 'ASC';
            $comp = '>';
        } else {
            $ord = 'DESC';
            $comp = '<';
        }

        $result = self::where('album_id', $this->album_id)->where('date_taken', $comp.'=', $this->date_taken)->orderBy('date_taken', $ord)->orderBy('id', $ord);
        if ($result->count() > 1) {
            return $result->where('id', $comp, $this->id)->first();
        }

        return $result->first();
    }

    /** @return Photo */
    public function getNextPhoto()
    {
        return $this->getAdjacentPhoto();
    }

    /** @return Photo */
    public function getPreviousPhoto()
    {
        return $this->getAdjacentPhoto(false);
    }

    /** @return int */
    public function getAlbumPageNumber($paginateLimit)
    {
        $photoIndex = 1;
        $photos = self::where('album_id', $this->album_id)->orderBy('date_taken', 'ASC')->orderBy('id', 'ASC')->get();
        foreach($photos as $photoItem){
            if($this->id == $photoItem->id){
                return ceil($photoIndex / $paginateLimit);
            }
            $photoIndex++;
        }
        return 1;
    }

    /** @return int */
    public function getLikes()
    {
        return $this->likes()->count();
    }

    public function likedByUser($user_id){
        return $this->likes()->where('user_id', $user_id)->count() > 0;
    }

    /** @return string */
    public function getOriginalUrl()
    {
        return $this->file()->generatePath();
    }
    /** @return string */
    public function getLargeUrl()
    {
        return $this->large_file()->generatePath();
    }
    /** @return string */
    public function getMediumUrl()
    {
        return $this->medium_file()->generatePath();
    }
    /** @return string */
    public function getSmallUrl()
    {
        return $this->small_file()->generatePath();
    }
    /** @return string */
    public function getTinyUrl()
    {
        return $this->tiny_file()->generatePath();
    }

    public function mayViewPhoto($user){
        if(!$this->private)return True;
        if($user){
            return $user->member() !== null;
        }
        return false;
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($photo) {
            $photo->file()->delete();
            $photo->large_file()->delete();
            $photo->medium_file()->delete();
            $photo->small_file()->delete();
            $photo->tiny_file()->delete();
            if ($photo->id == $photo->album->thumb_id) {
                $album = $photo->album;
                $album->thumb_id = null;
                $album->save();
            }
        });
    }
}
