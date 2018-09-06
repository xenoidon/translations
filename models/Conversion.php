<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "conversion".
 *
 * @property int $id
 * @property int $user_id
 * @property int $user_id_to_translate
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $time_transaction
 * @property int $translation
 *
 * @property User $user
 */
class Conversion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'conversion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id','translation','time_transaction'], 'required'],
            [['user_id', 'status', 'translation','user_id_to_translate'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'time_transaction' => 'last Time translation',
            'user_id_to_translate' => "The user's ides for the translation",
            'translation' => 'last Translation',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
