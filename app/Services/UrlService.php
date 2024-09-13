<?php

namespace App\Services;

class UrlService
{
    function getLink()
    {
        if ($this->getCtrl() == '') {
            return '#';
        }
        $link = Settings::get('baseurl') . $this->getCtrl().'/';
        if ($this->getAction() != '') {
            $link .= $this->getAction().'/';
        }
        if ($this->getParams() != '') {
            $link .= '?'.$this->getParams();
        }
        return $link;
    }
    function getBreadcrumbs($lang = null)
    {
        $breadcrumbs['title'] = $par->getName($lang);
        $breadcrumbs['url'] = $par->getLink();
        return $breadcrumbs;
    }
}
