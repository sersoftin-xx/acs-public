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
    public $_logs;

    protected $_defaultConfig = [
        'model' => 'Logs',
        'scopes' => []
    ];

    /**
     * Construct the model class
     *
     * @param array $config
     */
    public function __construct($config = []) {
        
        parent::__construct($config);

        if (!empty($this->_config['model'])) {
            $this->_logs = TableRegistry::get($this->_config['model']);
        }
    }

    public function log($level, $message, array $context = [])
    {
        $log = new Log([
            'level' => $level,
            'message' => $message,
            'date' => Time::now()
        ]);
        $this->_logs->save($log);
    }
}