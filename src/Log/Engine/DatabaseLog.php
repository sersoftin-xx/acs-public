<?php
/**
 * Created by PhpStorm.
 * User: Sergo
 * Date: 10.05.2016
 * Time: 19:11
 */

namespace App\Log\Engine;
use App\Model\Entity\Log;
use Cake\I18n\Time;
use Cake\Log\Engine\BaseLog;
use Cake\ORM\TableRegistry;

class DatabaseLog extends BaseLog
{
    public $Logs;

    /**
     * Construct the model class
     *
     * @param array $config
     */
    public function __construct($config = []) {
        parent::__construct($config);
        $model = !empty($config['model']) ? $config['model'] : 'Logs';
        $this->Logs = TableRegistry::get($model);
    }

    public function log($level, $message, array $context = [])
    {
        $log = new Log([
            'level' => $level,
            'message' => $message,
            'date' => Time::now()
        ]);
        $this->Logs->save($log);
    }
}