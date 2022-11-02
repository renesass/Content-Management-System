<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
        
        $rule = new \backend\rbac\AdminRule;
		$auth->add($rule);
		
		$admin = $auth->createRole('admin');
		$admin->ruleName = $rule->name;
		$auth->add($admin);
        
        $blub = $auth->createPermission('super-admin');
        $blub->label = 'Super-Administration';
        $auth->add($blub);

        $blub = $auth->createPermission('access');
        $blub->label = 'Zugang';
        $auth->add($blub);
        
        $blub = $auth->createPermission('overview');
        $blub->label = 'Übersicht';
        $auth->add($blub);
        
        $blub = $auth->createPermission('settings');
        $blub->label = 'Einstellungen';
        $auth->add($blub);
        
        $blub = $auth->createPermission('globals');
        $blub->label = 'Globale Variablen';
        $auth->add($blub);
        
        $blub = $auth->createPermission('users');
        $blub->label = 'Benutzer';
        $auth->add($blub);
        
        $blub2 = $auth->createPermission('createUser');
        $blub2->label = 'erstellen';
        $auth->add($blub2);
        $auth->addChild($blub, $blub2);
        
        $blub2 = $auth->createPermission('editUser');
        $blub2->label = 'bearbeiten';
        $auth->add($blub2);
        $auth->addChild($blub, $blub2);
        
        $blub2 = $auth->createPermission('deleteUser');
        $blub2->label = 'löschen';
        $auth->add($blub2);
        $auth->addChild($blub, $blub2);

        
        /*
        

        // add "createPost" permission
        $createPost = $auth->createPermission('createPost');
        $createPost->label = '';
        $auth->add($createPost);

        // add "updatePost" permission
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
        $auth->add($updatePost);

        // add "author" role and give this role the "createPost" permission
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $createPost);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $author);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        // $auth->assign($author, 2);
        $auth->assign($admin, 1); 
        */
    }
}