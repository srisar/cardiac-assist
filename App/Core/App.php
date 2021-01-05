<?php


namespace App\Core;


use App\Core\Requests\Request;

class App
{

    private static string $pageTitle;


    /**
     * Returns the site base URL (http://localhost)
     * @return string
     */
    public static function siteURL(): string
    {
        return sprintf("%s://%s", Request::scheme(), Request::host());
    }

    /**
     * Build a new url based on the path passed
     * @param string $path
     * @param array $parameters
     * @return string
     */
    public static function url(string $path = '/', array $parameters = []): string
    {
        if ( empty($parameters) ) {
            return self::siteURL() . $path;
        } else {
            $query = http_build_query($parameters);
            return self::siteURL() . $path . '?' . $query;
        }
    }

    /**
     * Redirect to given url path
     * @param string $path
     * @param array $params
     */
    public static function redirect($path = '/', $params = [])
    {

        if ( empty($params) ) {
            header('Location:' . self::siteURL() . $path);
        } else {
            $query = http_build_query($params);
            header('Location:' . $path . '?' . $query);
        }


    }

    /**
     * Returns app's name
     * @return string
     */
    public static function appName(): string
    {
        return APP_NAME;
    }

    /**
     * @param string $title
     */
    public static function setTitle(string $title)
    {
        self::$pageTitle = $title;
    }

    /**
     *
     * @return string
     */
    public static function getTitle()
    {
        return sprintf('%s — %s', self::$pageTitle, self::appName());
    }

}