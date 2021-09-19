<?php

namespace Kolgaev\Users;

use Illuminate\Http\Request;

class Device
{

    /**
     * Определение устройства
     * 
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public static function getDevice(Request $request) {

        $data = [] ;

        $agent = new \Jenssegers\Agent\Agent();

        if ($agent->isDesktop())
            $data[] = "Desktop";
        elseif ($agent->isPhone())
            $data[] = "Phone";
        elseif ($agent->isTablet())
            $data[] = "Tablet";
        elseif ($agent->isMobile())
            $data[] = "Mobile";

        if ($agent->isRobot())
            $data[] = "Robot";

        if ($robot = $agent->robot()) {
            $version = $agent->version($robot);
            $data[] = $robot . ($version ? " $version" : "");;
        }

        if ($device = $agent->device()) {
            $version = $agent->version($device);
            $data[] = $device . ($version ? " $version" : "");
        }

        if ($platform = $agent->platform()) {
            $version = $agent->version($platform);
            $data[] = $platform . ($version ? " $version" : "");
        }

        if ($browser = $agent->browser()) {
            $version = $agent->version($browser);
            $data[] = $browser . ($version ? " $version" : "");
        }

        if (!count($data))
            return $request->header('User-Agent');

        return implode(", ", $data);

    }

}