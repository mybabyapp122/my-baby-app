<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Student;

/**
 * StudentSearch represents the model behind the search form of `common\models\Student`.
 */
class StudentSearch extends Student
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'grade_id'], 'integer'],
            [['name', 'name_ar', 'dob', 'gender', 'health', 'allergies', 'status', 'status_ex', 'create_time', 'update_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $school_id = null)
    {
        $school = User::findById();
        $students = $school->getAssociatedPeople(false, false, true);
        $query = Student::find();
        $query = $query->andWhere(['IN', 'id', $students]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'grade_id' => $this->grade_id,
            'dob' => $this->dob,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        if (!empty($school_id)) $query->andFilterWhere(['grade.school_id' => $school_id]);


        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'name_ar', $this->name_ar])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'health', $this->health])
            ->andFilterWhere(['like', 'allergies', $this->allergies])
//            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'status_ex', $this->status_ex]);

        return $dataProvider;
    }
}
