<?php

namespace App\Controller\Panel;

use \App\Utils\View;

class Page
{
    private static $modules = [
        'home' => [
            'label' => 'Home',
            'link'  => URL.'/'
        ],
        'simol' => [
            'label' => 'Terminais',
            'link'  => URL.'/equipaments'
        ]
    ];

    public static function getPage($title, $content)
    {
        return View::render('painel/page',[
            'title' => $title,
            'content' => $content
        ]);
    }

    private static function getMenu($currentModule)
    {
        $links = '';

        foreach(self::$modules as $hash=>$module) {
            $links .= View::render('painel/menu/link',[
                'label' => $module['label'],
                'link'  => $module['link'],
                'current' => $hash == $currentModule ? 'text-danger' : ''
            ]);
        }

        return View::render('painel/menu/box',[
            'links' => $links
        ]);
    }

    public static function getPanel($title, $content, $currentModule)
    {
        $contentPanel = View::render('painel/panel',[
            'menu' => self::getMenu($currentModule),
            'content' => $content
        ]);

        return self::getPage($title, $contentPanel);
    }
}