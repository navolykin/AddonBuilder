<?php

declare(strict_types=1);

namespace App\Classes;

class AddonBuilder
{
    const ADDONS_DIR    = '/app/addons/';
    const ICON_DIR      = '/design/backend/media/images/addons/';

    const SCHEMA_VERSION_30 = '3.0';
    const SCHEMA_VERSION_20 = '2.0';

    const STATUS_ACTIVE = 'active';
    const STATUS_DISABLED = 'disabled';

    const RES_FUNC = 'func';
    const RES_INIT = 'init';
    const RES_CONFIG = 'config';

    protected $project_name;

    protected $id;
    protected $scheme;
    protected $edition_type = 'VENDOR';

    protected $addon_dir_name;

    protected $version = '1.0';
    protected $priority = 90000;
    protected $position = 900;
    protected $status = self::STATUS_ACTIVE;
    protected $auto_install = [];
    protected $has_icon = 'Y';
    protected $default_language = 'en';



    public function __construct($project_name, $addon_id, $schema = self::SCHEMA_VERSION_30)
    {
        if (!is_dir($project_name)) {
            throw new \Exception("There is no suitable project", 1);
        }

        if (!$this->isAvailableId($addon_id)) {
            throw new \Exception("Id is not available", 1);
        }

        $this->id = $addon_id;

        $this->project_name = $project_name;
        $this->scheme = $schema;
        $this->addon_dir_name = $this->project_name . self::ADDONS_DIR . $this->id;
    }

    protected function isAvailableId($id)
    {
        if (is_dir(self::ADDONS_DIR . $id)) {
            return false;
        }

        return  true;
    }


    public function build()
    {
        $sceleton = file_get_contents(__DIR__ . '/../Resurces/addon.abres');
        $addon = simplexml_load_string($sceleton);
 
        $addon->addAttribute('scheme', $this->scheme);
        $addon->addAttribute('edition_type', $this->edition_type);

        $addon->id = $this->id;
        $addon->version = $this->version;
        $addon->priority = $this->priority;
        $addon->position = $this->position;
        $addon->status = $this->status;
        $addon->auto_install = implode(',', $this->auto_install);
        $addon->has_icon = $this->has_icon;
        $addon->default_language = $this->default_language;

        if (!file_exists($this->addon_dir_name)) {
            mkdir($this->addon_dir_name);
            chmod($this->addon_dir_name, 0777);
        }

        if (file_exists($this->addon_dir_name . '/addon.xml')) {
            unlink($this->addon_dir_name . '/addon.xml');
        }

        $addon->asXML($this->addon_dir_name . '/addon.xml');
        chmod($this->addon_dir_name . '/addon.xml', 0777);

        $this->createResFile(self::RES_FUNC);
        $this->createResFile(self::RES_INIT);
        $this->createResFile(self::RES_CONFIG);

        $this->addIcon();
    }

    public function createResFile($res)
    {
        if (in_array($res, [self::RES_FUNC, self::RES_INIT, self::RES_CONFIG])) {
            $data = file_get_contents(__DIR__ . '/../Resurces/' . $res . '.abres');
            if (!file_exists($this->addon_dir_name . '/' . $res)) {
                file_put_contents($this->addon_dir_name . '/' . $res . '.php', $data);
                chmod($this->addon_dir_name . '/' . $res . '.php', 0777);
            }
        }
    }

    public function addIcon()
    {
        $data = file_get_contents(__DIR__ . '/../Resurces/icon.abres');

        mkdir($this->project_name . self::ICON_DIR . $this->id);
        chmod($this->project_name . self::ICON_DIR . $this->id, 0777);
        if (!file_exists($this->project_name . self::ICON_DIR . $this->id . '/' . 'icon.png')) {
            file_put_contents($this->project_name . self::ICON_DIR . $this->id . '/' . 'icon.png', $data);
            chmod($this->project_name . self::ICON_DIR . $this->id . '/' . 'icon.png', 0777);
        }
    }


    public function setVersion($version)
    {
        if (in_array($version, [
            self::SCHEMA_VERSION_20,
            self::SCHEMA_VERSION_30
        ])) {
            $this->version = $version;
        }
    }
}
