<?php namespace Matat\HappyGift;

use Backend;
use Event;
use Matat\Happygift\Classes\Controller;
use Cms\Classes\Theme;
use Cms\Classes\Controller as CmsController;
use System\Classes\PluginBase;

/**
 * HappyGift Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'HappyGift',
            'description' => 'No description provided yet...',
            'author'      => 'ManjinderSingh',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        // Event::listen('cms.router.beforeRoute', function($url) {
        //     return Controller::instance()->initCmsPage($url);
        // });
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        // return []; // Remove this line to activate

        return [
            'Matat\HappyGift\Components\PendingOrders' => 'Waiting-Orders',
            'Matat\HappyGift\Components\Authentication' => 'Authentication',
            'Matat\HappyGift\Components\Logout' => 'Logout',
            'Matat\HappyGift\Components\FutureOrders' => 'Future-Orders',
            'Matat\HappyGift\Components\Profile' => 'Profile',
            'Matat\HappyGift\Components\Middleware' => 'Middleware',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'matat.happygift.some_permission' => [
                'tab' => 'HappyGift',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        // return []; // Remove this line to activate

        return [
            'happygift' => [
                'label'       => 'HappyGift',
                'url'         => Backend::url('matat/happygift/index'),
                'icon'        => 'icon-leaf',
                'permissions' => ['matat.happygift.*'],
                'order'       => 500,
                'sideMenu' => [
                    'pages' => [
                        'label'       => 'Pages',
                        'icon'        => 'icon-files-o',
                        'url'         => 'javascript:;',
                        'attributes'  => ['data-menu-item'=>'pages'],
                    ],
                ],
            ],
        ];
    }
}
