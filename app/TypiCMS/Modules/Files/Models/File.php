<?php
namespace TypiCMS\Modules\Files\Models;

use Dimsav\Translatable\Translatable;
use Croppa;
use TypiCMS\Models\Base;
use TypiCMS\Presenters\PresentableTrait;

class File extends Base
{

    use Translatable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Files\Presenters\ModulePresenter';

    protected $fillable = array(
        'gallery_id',
        'folder_id',
        'user_id',
        'type',
        'name',
        'filename',
        'path',
        'extension',
        'mimetype',
        'width',
        'height',
        'filesize',
        'download_count',
        'position',
        // Translatable fields
        'keywords',
        'description',
        'alt_attribute',
    );

    /**
     * Translatable model configs.
     *
     * @var array
     */
    public $translatedAttributes = array(
        'keywords',
        'description',
        'alt_attribute',
    );

    protected $appends = ['alt_attribute', 'description'];

    /**
     * The default route for admin side.
     *
     * @var string
     */
    public $route = 'files';

    /**
     * lists
     */
    public $order = 'position';
    public $direction = 'asc';

    /**
     * One file belongs to one gallery.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function gallery()
    {
        return $this->belongsTo('TypiCMS\Modules\Galleries\Models\Gallery');
    }

    /**
     * Observers
     */
    public static function boot()
    {
        parent::boot();

        static::deleted(function (File $model) {
            Croppa::delete($model->path . '/' . $model->filename);
        });

    }

    /**
     * get translated title
     * @todo add title field for image
     */
    public function getTitleAttribute($value)
    {
        return $value;
    }

    /**
     * get translated alt attribute
     * @return string alt attribute
     */
    public function getAltAttributeAttribute()
    {
        return $this->alt_attribute;
    }

    /**
     * get translated description
     * @return string description
     */
    public function getDescriptionAttribute()
    {
        return $this->description;
    }
}
