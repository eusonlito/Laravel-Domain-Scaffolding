<?php declare(strict_types=1);

namespace App\Domains\IpLock\Action;

use App\Domains\IpLock\Model\IpLock as Model;

class Create extends ActionAbstract
{
    /**
     * @return \App\Domains\IpLock\Model\IpLock
     */
    public function handle(): Model
    {
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row = Model::current()->updateOrCreate(
            ['ip' => $this->request->ip()],
            ['end_at' => date('c', strtotime('+'.(int)config('auth.lock.check').' seconds'))]
        );
    }
}
