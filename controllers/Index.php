<?php namespace Matat\Happygift\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Db;

/**
 * Index Backend Controller
 */
class Index extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class
    ];

    /**
     * @var string formConfig file
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string listConfig file
     */
    public $listConfig = 'config_list.yaml';

    /**
     * __construct the controller
     */
    public function __construct()
    {
        $api_count = Db::table('matat_happygift_fields')->count();

        $this->vars['api_count'] = $api_count;

        parent::__construct();

        BackendMenu::setContext('Matat.Happygift', 'happygift', 'index');
    }
}
