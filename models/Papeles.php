<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "papeles".
 *
 * @property int $id
 * @property string $papel
 */
class Papeles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'papeles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['papel'], 'required'],
            [['papel'], 'string', 'max' => 50],
            [['papel'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'papel' => 'Papel',
        ];
    }
}
