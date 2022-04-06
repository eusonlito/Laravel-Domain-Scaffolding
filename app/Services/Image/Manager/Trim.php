<?php declare(strict_types=1);

namespace App\Services\Image\Manager;

class Trim extends ManagerAbstract
{
    /**
     * @param int $percent
     *
     * @return self
     */
    public function handle(int $percent): self
    {
        $this->image->trimImage(($percent / 100) * $this->image->getQuantumRange()['quantumRangeLong']);
        $this->image->setImagePage(0, 0, 0, 0);

        return $this;
    }
}
