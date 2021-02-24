<?php declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Message extends Component
{
    /**
     * @var string
     */
    public string $message = '';

    /**
     * @var string
     */
    public string $type;

    /**
     * @var string
     */
    public string $class;

    /**
     * @param string $type = 'error'
     * @param string $bag = ''
     * @param string $message = ''
     *
     * @return self
     */
    public function __construct(string $type = 'error', string $bag = '', string $message = '')
    {
        $this->type($type);
        $this->class();
        $this->message($bag, $message);
    }

    /**
     * @param string $type
     *
     * @return void
     */
    protected function type(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return void
     */
    protected function class(): void
    {
        $this->class = 'alert-dismissible show flex items-center mb-2 alert alert-';

        if ($this->type === 'error') {
            $this->class .= 'danger-soft';
        } else {
            $this->class .= $this->type;
        }
    }

    /**
     * @param string $bag
     * @param string $message
     *
     * @return void
     */
    protected function message(string $bag, string $message): void
    {
        if ($message) {
            $this->message = $message;
        } elseif ($this->type && $bag) {
            $this->message = service()->message()->get($this->type, $bag)->first();
        }
    }

    /**
     * @return ?\Illuminate\View\View
     */
    public function render(): ?View
    {
        if (empty($this->message)) {
            return null;
        }

        return view('components.message');
    }
}
