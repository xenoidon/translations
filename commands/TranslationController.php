<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use app\models\Conversion;
use app\models\User;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * @author Alexey Timofeev <hotnews@mail.ru>
 * @since 0.1
 */
class TranslationController extends Controller
{
    /**
     * This command starts process of the postponed translations.
     * @param string $hide the flag to be hide messages logs.
     * @return int Exit code
     */
    public function actionIndex($hide = false)
    {
        if (!$hide) {
            echo "Start of processing of the list of the translations" . "\n";
        }

        $workItems = Conversion::find()
            ->where('status = :status', [':status' => Yii::$app->params['STATUS_WORK_WAIT']])
            ->andWhere('time_transaction <= NOW()')
            ->all();
        foreach ($workItems as $key => $item) {
            $userIn = User::findOne($item->user_id);
            $userTo = User::findOne($item->user_id_to_translate);
            $userTo->balance += $item->translation;
            $userIn->balance -= $item->translation;
            if ($userIn->save()) {
                if ($userTo->save()) {
                    $item->status = Yii::$app->params['STATUS_WORK_SUCC'];
                    if ($item->save()) {
                        $messageLog = 0;
                    } else {
                        $messageLog = 1;
                    }
                } else {
                    $messageLog = 1;
                }
            } else {
                $messageLog = 1;
            }

            if (!$hide) {
                switch ($messageLog) {
                    case 0:
                        echo "transfer $item->translation rub. [user id:$item->user_id] -> [user id:$item->user_id_to_translate] = COMPLETE" . "\n";
                        break;
                    case 1:
                        echo "transfer $item->translation rub. [user id:$item->user_id] -> [user id:$item->user_id_to_translate] = ERROR" . "\n";
                        break;;
                }
            }
        }

        if (!$hide) {
            echo "Process is complete." . "\n";
        }

        return ExitCode::OK;
    }
}
