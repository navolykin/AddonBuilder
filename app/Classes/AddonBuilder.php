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
    protected $addon_data;

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

    protected $result = [];



    public function __construct($project_name, $addon_id, $addon_data = [], $schema = self::SCHEMA_VERSION_30)
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

        if (!empty($addon_data) && is_array($addon_data)) {
            $this->setAddonData($addon_data);
        }
    }

    protected function isAvailableId($id)
    {
        if (is_dir(self::ADDONS_DIR . $id)) {
            return false;
        }

        return  true;
    }

    protected function setAddonData($addon_data)
    {
        $this->addon_data = $addon_data;

        if (!empty($addon_data['version'])) {
            $this->version = $addon_data['version'];
        }

        if (!empty($addon_data['priority'])) {
            $this->priority = intval($addon_data['priority']);
        }

        if (!empty($addon_data['position'])) {
            $this->position = intval($addon_data['position']);
        }

        if (!empty($addon_data['status']) && in_array($addon_data['status'], [self::STATUS_ACTIVE, self::STATUS_DISABLED])) {
            $this->status = $addon_data['status'];
        }
    }


    public function build()
    {
        $sceleton = file_get_contents(__DIR__ . '/../Resurces/addon.abres');
        $addon = simplexml_load_string($sceleton);
 
        $addon->addAttribute('scheme', $this->scheme);
        $addon->addAttribute('edition_type', $this->edition_type);

        $addon->id       = $this->id;

        $addon->version  = $this->version;
        $addon->priority = $this->priority;
        $addon->position = $this->position;
        $addon->status   = $this->status;

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
        $this->result[$this->addon_dir_name . '/addon.xml'] = true;

        if (isset($this->addon_data['func']) && $this->addon_data['func'] == 'Y') {
            $this->createResFile(self::RES_FUNC);
        }

        if (isset($this->addon_data['init']) && $this->addon_data['init'] == 'Y') {
            $this->createResFile(self::RES_INIT);
        }

        if (isset($this->addon_data['config']) && $this->addon_data['config'] == 'Y') {
            $this->createResFile(self::RES_CONFIG);
        }

        $this->addIcon();

        return $this->result;
    }

    public function createResFile($res)
    {
        if (in_array($res, [self::RES_FUNC, self::RES_INIT, self::RES_CONFIG])) {
            $data = file_get_contents(__DIR__ . '/../Resurces/' . $res . '.abres');
            $f_path = $this->addon_dir_name . '/' . $res . '.php';

            if (!file_exists($f_path)) {
                $result = file_put_contents($f_path, $data);
                chmod($f_path, 0777);

                if ($result !== false) {
                    $this->result[$f_path] = true;
                } else {
                    $this->result[$f_path] = false;
                }
            }
        }
    }

    public function addIcon()
    {
        $data = file_get_contents(__DIR__ . '/../Resurces/icon.abres');
        $dir_path = $this->project_name . self::ICON_DIR . $this->id;
        $f_path = $dir_path . '/' . 'icon.png';

        mkdir($dir_path);
        chmod($dir_path, 0777);
        if (!file_exists($f_path)) {
            $result = file_put_contents($f_path, $data);
            chmod($f_path, 0777);

            if ($result !== false) {
                $this->result[$f_path] = true;
            } else {
                $this->result[$f_path] = false;
            }
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
