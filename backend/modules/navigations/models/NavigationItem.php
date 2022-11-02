<?php

namespace backend\modules\navigations\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use rs\extensions\Extension;

class NavigationItem extends \rs\navigations\NavigationItem
{
    public $groups = [];
    public $updateGroups = true;
    public $updateContentType = true;
    
    // content types
    public $page;
    public $module;
    public $extension;
    public $forwarding;
    
	public function rules() {
        return [
            [['label', 'name', 'content_type'], 'required'],
            [['label', 'name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['name'], 'isReservedName'],
            [['parent', 'content_type', 'sidebar_template'], 'string', 'max' => 64],
            [['home', 'sidebar', 'user_only'], 'integer'],
            [['groups', 'assignment'], 'safe'],
            // content types
            [['page', 'module', 'extension', 'forwarding'], 'safe'],
        ];
    }

    public function isReservedName($attribute, $params, $validator)
    {
        if (in_array($this->$attribute, self::RESERVED_NAMES)) {
            $this->addError($attribute, 'Dieser Name ist bereits für eine Standardfunktion reserviert.');
        }
    }
    
    public static function getTemplatePath() {
        return Yii::getAlias('@frontend').'/views/sidebar';
    }
    
    public static function listTemplates() {
        $files = FileHelper::findFiles(self::getTemplatePath(), ['only' => ['*.php'], 'recursive' => false]);
        $templates = [];
        if (!empty($files)) {
            foreach ($files as $index => $file) {
                $name = substr($file, strrpos($file, '/') + 1);
                $name = substr($name, 0, -4); // remove .php
                $templates[$name] = $name;
            }
        }
        return $templates;
    }

    public static function listModules() {
        $modules = [];
        foreach(glob(Yii::getAlias('@frontend').'/modules/*', GLOB_ONLYDIR) as $dir) {
            $dirName = basename($dir);
            $modules[$dirName] = $dirName;
        }
        return $modules;
    }
    
    public static function listExtensions() {
        $extensions = Extension::find()->all();
        $result = [];
        foreach ($extensions as $extension) {
            $result[$extension->name] = $extension->label;
        }
        return $result;
    }

    public function attributeLabels() {
        return [
            'label' => 'Bezeichnung',
            'name' => 'Name',
            'parent' => 'Untergeordnet',
            'home' => 'Als Startseite festlegen',
            'content_type' => 'Typ',
            
            // content types
            'page' => '(Statische) Seite',
            'module' => 'Modul',
            'extension' => 'Erweiterung',
            'forwarding' => 'Weiterleitung',
            
            'sidebar' => 'Aktiviert',
            'sidebar_template' => 'Template',
            'user_only' => 'Sichtbar und Aufrufbar nur für angemeldete Benutzer',
        ];
    }
    
    public function attributeHints() {
        return [
            'name' => 'Name wird für das Routing benutzt. Dieser Name ist also in der Browserzeile sichtbar.',
            'home' => 'Hinweis: Es kann immer nur eine Startseite gleichzeitig ausgewählt sein.',
            'user_only' => 'Hinweis: Die Einschränkung bezieht sich hierarchisch auf alle Folgeglieder.',
        ];
    }
    
    public function beforeSave($insert) {
	    if (!parent::beforeSave($insert)) {
	        return false;
	    }
        
        if ($this->isNewRecord) {
            // get last order number
            $lastOrder = self::find()->orderBy('order desc')->limit(1)->one();
            if (empty($lastOrder)) {
                $lastOrder = 0;
            } else {
                $lastOrder = $lastOrder->order;
            }
            $this->order = $lastOrder + 1;
        }
	    
	    $this->label = ucfirst($this->label);
        
        if ($this->updateContentType) {
            if ($this->content_type == "page") {
                $this->assignment = $this->page;
            } else if ($this->content_type == "module") {
                $this->assignment = $this->module;
            } else if ($this->content_type == "extension") {
                $this->assignment = $this->extension;
            } else if ($this->content_type == "forwarding") {
                $this->assignment = $this->forwading;
            }
        }
        
        if ($this->updateGroups) {
            if ($this->user_only) {
                $group_ids = [];
                foreach ($this->groups as $name => $checked) {
                    if ($checked) {
                        $group = Yii::$app->userGroupManager->getGroup($name);
                        $group_ids[] = $group->id;
                    }
                }
                $this->group_ids = implode(", ", $group_ids);
            } else {
                $this->group_ids = null;
            }
        }

	    return true;
	}
    
    public function afterSave($insert, $changedAttributes)
	{
        
        // update parents when name has changed
        if (!empty($changedAttributes['name'])) {
            $oldName = $changedAttributes['name'];
            $newName = $this->name;
            
            $items = self::find()->where(['parent' => $oldName])->all();
            foreach ($items as $item) {
                $item->parent = $newName;
                $item->updateGroups = false;
                $item->updateContentType = false;
                $item->save();
            }
        } 
		
		return parent::afterSave($insert, $changedAttributes);
	}
    
    public function load($data, $formName = null) {
        if ($this->content_type == "page") {
             $this->page = $this->assignment;
        } else if ($this->content_type == "module") {
             $this->module = $this->assignment;
        } else if ($this->content_type == "extension") {
             $this->extension = $this->assignment;
        } else if ($this->content_type == "forwarding") {
             $this->forwarding = $this->assignment;
        }
        
	    if (!empty($this->group_ids)) {
            $groupIds = explode(", ", $this->group_ids);
            $groups = [];
            foreach ($groupIds as $groupId) {
                $group = Yii::$app->userGroupManager->getGroup($groupId);
                $groups[$group->name] = true;
            }
            $this->groups = $groups;
		}
	    
		return parent::load($data, $formName);
    }
    
    public function clearHome() {
        // reset home
        if ($this->home != 1) {
            return;
        }
        
        $items = self::find()->where(['!=', 'name', $this->name])->andWhere(['home' => 1])->all();
        foreach ($items as $item) {
            $item->home = 0;
            $item->save();
        }
    }
}