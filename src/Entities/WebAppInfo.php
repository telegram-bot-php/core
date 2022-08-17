<?php

namespace TelegramBot\Entities;

use TelegramBot\Entity;

/**
 * WebAppInfo
 *
 * Contains information about a Web App.
 *
 * @link https://core.telegram.org/bots/api#webappinfo
 *
 * @property string $url    An HTTPS URL of a Web App to be opened with additional data as specified in Initializing Web Apps
 *
 * @method string getUrl()              An HTTPS URL of a Web App to be opened with additional data as specified in Initializing Web Apps
 * @method $this setUrl(string $url)    An HTTPS URL of a Web App to be opened with additional data as specified in Initializing Web Apps
 */
class WebAppInfo extends Entity
{

    public function __construct($data)
    {
        if (is_string($data)) {
            $data = ['url' => $data];
        }

        parent::__construct($data);
    }

}