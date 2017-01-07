<?php

namespace App;

use App;
use Cache;
use Illuminate\Database\Eloquent\Model;

class Options extends Model {

    /**
     * The database table used to store options/settings for the awards application.
     *
     * @var string
     */
    protected $table = 'options';

    public $timestamps = false;

    private static $cacheExpireTime = 180;

    /**
     * --------------Table Fields----------------
     *
     * @param int options_id unique id for the row
     * @param string name name of the option/setting
     * @param text value the current setting for the option/setting
     * @param text comment description of what the option/setting does
     */

    /**
     * Updates the current option/setting with the new value
     *
     * @param string name what option/setting to update
     * @param string value new value for the option/setting
     */
    public static function updateSetting($name, $value) {
        Options::where("name", "LIKE", $name)
            ->update(["value" => $value]);

        //Update cache
        Cache::put($name, $value, Options::$cacheExpireTime);
    }

    /**
     * Gets the current value for the given option/setting
     *
     * @param string name what option/setting to retrieve
     * @param boolean to treat the result as an json array or not
     *
     * @return mixed string the current value of the option/setting given
     *               null if the option/setting was not found
     */
    public static function getSetting($name, $json_decode = false) {
        //Cache lookup
        if (Cache::has($name)) {
            return Cache::get($name);
        }

        $values = Options::where("name", "=", $name)
            ->select("value", "comment")
            ->get()->toArray();

        //We got nothing
        if (count($values) == 0) {
            return null;
        }

        $result = $json_decode ? (array) json_decode($values[0]["value"]) : $values[0];
        Cache::put($name, $result, Options::$cacheExpireTime);
        return $result;
    }

    /**
     * Gets the current webservices/intranet URLS
     *
     * @return array(string, string, string) an array of string with the first one being the webservivces URL and second
     *                               		 one being intranet URL, with the third being the calendar webservivces URL
     */
    public static function getServicesURL() {
        if (App::environment('local', 'beta')) {
            $webservices = "WEBSRV_BETA_URL";
            $intranet = "INTRANET_BETA";
        } else {
            $webservices = "WEBSRV_URL";
            $intranet = "INTRANET";
        }

        //Check if we already have that result
        if (Cache::has($webservices) && Cache::has($intranet)) {
            return array(Cache::get($webservices), Cache::get($intranet));
        }

        $webservicesR = Options::where("name", "=", $webservices)->select("value")->get()->toArray();
        $intranetR = Options::where("name", "=", $intranet)->select("value")->get()->toArray();

        Cache::put($webservices, $webservicesR[0]["value"], Options::$cacheExpireTime);
        Cache::put($intranet, $intranetR[0]["value"], Options::$cacheExpireTime);

        $rV = array($webservicesR[0]["value"], $intranetR[0]["value"]);
        return $rV;
    }
  

    /**
     * Gets the current session timeout values
     *
     * WARNING: WE CAN NOT STORE THESE VALUES IN THE DATABASE BECAUSE WHEN WE NEED THEM IN SESSION.PHP THE CONNECTION
     * HAS NOT YET BEEN ESTABLISHED, INSTEAD WE "PRETEND" TO FETCH THEM
     *
     * @return array(int, int) an array with the first one being session timeout and second one being time left warning
     */
    public static function getSessionTimeoutValues() {
        return array(120, 5);
    }

    /**
     * Gets the current save path
     *
     * @return string the current save path
     */
    public static function getSavePath() {
        if (App::environment('local')) {
            $key_name = "savePathLocal";
        } else if (App::environment('beta')) {
            $key_name = "savePathBeta";
        } else {
            $key_name = "savePathProduction";
        }

        //Check if we already have that result
        if (Cache::has($key_name)) {
            return Cache::get($key_name);
        }

        $results = Options::where("name", "=", $key_name)
            ->select("value")
            ->get()->toArray()[0]["value"];
        Cache::put($key_name, $results, Options::$cacheExpireTime);
        return $results;
    }

    /**
     * Gets the current log path
     *
     * @return string the current log path
     */
    public static function getLogPath() {
        if (App::environment('local')) {
            $key_name = "logPathLocal";
        } else if (App::environment('beta')) {
            $key_name = "logPathBeta";
        } else {
            $key_name = "logPathProduction";
        }

        //Check if we already have that result
        if (Cache::has($key_name)) {
            return Cache::get($key_name);
        }

        $results = Options::where("name", "=", $key_name)
            ->select("value")
            ->get()->toArray()[0]["value"];
        Cache::put($key_name, $results, Options::$cacheExpireTime);
        return $results;
    }
}
