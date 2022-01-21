<?php namespace Matat\HappyGift\Models;

use Model;
use Http;
use Db;
use Schema;

/**
 * RequestHandler Model
 */
class RequestHandler extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */

    // public static $api_url = 'https://omer.pai-pay.com/wp-json/';

    /**
     * @var array guarded attributes aren't mass assignable
     */
    protected $guarded = ['*'];

    /**
     * @var array fillable attributes are mass assignable
     */
    protected $fillable = [];

    /**
     * @var array rules for validation
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array jsonable attribute names that are json encoded and decoded from the database
     */
    protected $jsonable = [];

    /**
     * @var array appends attributes to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array hidden attributes removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array dates attributes that should be mutated to dates
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array hasOne and other relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public static function makeRequest ($_method, $_action, $_postData = array(), $_token = '') {
        $api_url = 'https://omer.pai-pay.com/wp-json/';
        if(Schema::hasTable('matat_happygift_fields')) {
            $table_data = Db::table('matat_happygift_fields')->first();
            if(!empty($table_data)) {
                $api_url = $table_data->api_url;
            }
        }
        if($_method == 'post') {
            $response = Http::post($api_url.$_action, function($http) use ($_postData, $_token){
                if(!empty($_token)) {
                    $http->header(['Content-Type', 'Authorization' => 'Bearer '.$_token]);
                } else {
                    $http->header(['Content-Type']);
                }
                $http->data($_postData);
            });
        }
        return $response;
    }
}
