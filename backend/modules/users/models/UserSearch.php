<?php

namespace backend\modules\users\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

class UserSearch extends \rs\base\Model
{
	public $search;
	public $status;
	public $attribute = 'created_at';
	public $order = 'asc';
	
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['search', 'attribute', 'order'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        
        $query->andFilterWhere([
        	'or',
			['like', 'first_name', $this->search],
			['like', 'last_name', $this->search],
			['like', 'username', $this->search],
			['like', 'email', $this->search]
		]);
		
        if (!empty($this->status)) {
	        $query->andWhere('status=:status', [':status' => $this->status]);
        }
        
        $order = ($this->order == "asc") ? SORT_ASC : SORT_DESC;
        $query->orderBy([$this->attribute => $order]);
        
        return $dataProvider;
    }
}
