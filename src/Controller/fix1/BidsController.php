<?php
namespace App\Controller\Api;

use App\Model\Entity\Bid;
use App\Model\Entity\Pc;
use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\Network\Exception\BadRequestException;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Security;

/**
 * Bids Controller
 *
 * @property \App\Model\Table\BidsTable $Bids
 */
class BidsController extends AppController
{
    public function add()
    {
        $this->request->allowMethod('post');

        $key = Configure::read('App.encryptionKey');
        $data = json_decode(Security::decrypt(base64_decode($this->request->data('data')), $key));

        $pc_unique_key = $data->pc_unique_key;
        $product_id = $data->product_id;
        $random_string = $data->random_string;
        $pc_name = $data->pc_name;

//        $pc_unique_key = $this->request->data('pc_unique_key');
//        $pc_name = $this->request->data('pc_name');
//        $product_id = $this->request->data('product_id');
//        $random_string = $this->request->data('random_string');

        $pc = $this->Bids->Pcs->findOrCreate(['unique_key' => $pc_unique_key],
            function (Pc $pc) use ($pc_unique_key, $pc_name) {
                $pc->client_id = 0;
                $pc->name = $pc_name;
                $pc->addition_date = Time::now();
                $pc->comment = '';
            });

        $bid = $this->Bids->findOrCreate([
            'product_id' => $product_id,
            'pc_id' => $pc->id
        ], function (Bid $bid) {
            $bid->application_date = Time::now();
            $bid->is_active = false;
        });

        if (!$bid->has('id')) {
            throw new BadRequestException('BadRequest. Invalid data accepted');
        }
        $response = new \stdClass();
        $response->bid = $bid;
        $response->random_string = $random_string;
        $data = Security::encrypt(json_encode($response), $key);
        $data = base64_encode($data);
        $this->set(compact('data'));
//        $this->set(compact('bid', 'random_string'));
    }

    public function check()
    {
        $this->request->allowMethod('post');

        $key = Configure::read('App.encryptionKey');
        $data = json_decode(Security::decrypt(base64_decode($this->request->data('data')), $key));

        $pc_unique_key = $data->pc_unique_key;
        $product_id = $data->product_id;
        $random_string = $data->random_string;
        $bid = $this->Bids->find('all', [
            'conditions' => [
                'Pcs.unique_key' => $pc_unique_key,
                'product_id' => $product_id
            ],
            'contain' => ['Pcs']
        ])->first();
        if (empty($bid)) {
            throw new NotFoundException('Bid not found.');
        } else {
            $bid->unsetProperty('pc');
        }
        $response = new \stdClass();
        $response->bid = $bid;
        $response->random_string = $random_string;
        $data = Security::encrypt(json_encode($response), $key);
        $data = base64_encode($data);
        $this->set(compact('data'));
//        $this->set(compact('bid'));
    }
}