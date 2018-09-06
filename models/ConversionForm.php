<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ConversionForm extends Model
{
    public $id;
    public $user_id;
    public $user_id_to_translate;
    public $status;
    public $created_at;
    public $updated_at;
    public $time_transaction;
    public $translation;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['translation', 'time_transaction', 'user_id_to_translate'], 'required'],
            [['translation'], 'integer'],

            ['translation', function ($attribute, $params) {

                    if($this->translation <=0) {
                        $this->addError($attribute, "Amount of transfer doesn't wash to be less or is equal to 0!" );
                    }

                    if($this->user_id_to_translate == Yii::$app->user->identity->id) {
                        $this->addError($attribute, "Itself can't transfer money!" );
                    }

                    $user = $this->getCurrentuser();
                    $userTranslations = $this->getCurrentuserTranslatesSumma();
                    if( $user->balance-$this->translation-$userTranslations<0 ) {
                        $this->addError($attribute, "There isn't enough means on balance!");
                    }
            }],


        ];
    }


    /**
     * @return model User
     */
    public function getCurrentuser()
    {
        return User::findOne(Yii::$app->user->identity->id);
    }

    /**
     * @return model User
     */
    public function getCurrentuserTranslatesSumma()
    {
         return  Conversion::find()
             ->where('user_id = :id', [':id' =>  Yii::$app->user->identity->id])
             ->andWhere('status = :status', [':status' => 2])
             ->sum('translation');

    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'time_transaction' => 'Time translation',
            'user_id_to_translate' => "The user's ides for the translation",
            'translation' => 'Translation summa',
        ];
    }


    /**
     * Addition of the new translation.
     *
     * @return Conversion
     */
    public function save()
    {
        $model = new Conversion();
        $model->attributes = $this->attributes;
        if($model->save()) {
            return $model;
        }
        return $model->getErrors();
    }

}
