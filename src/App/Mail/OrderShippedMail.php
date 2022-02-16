<?php

namespace App\Mail;

use Domain\Orders\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\HtmlString;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class OrderShippedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * The view factory implementation.
     *
     * @var \Illuminate\Contracts\View\Factory|null
     */
    protected $viewFactory;

    /** @var \Domain\Orders\Models\Order */
    protected $order;

    /** @var int */
    protected $id;

    /** @var string */
    protected $email;

    /** @var string|null */
    protected $password;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     * @param int $id
     * @param string $email
     * @param string|null $password
     *
     * @return void
     */
    public function __construct(Order $order, int $id, string $email, string $password = null)
    {
        $this->order = $order;
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function build()
    {
        $this->viewFactory = resolve(Factory::class);
        $this->viewFactory->flushFinderCache();

        $actionUrl = $this->verificationUrl();

        $headerUrl = route('home');
        $headerLine = "Вы оформили заказ в интернет-магазине union.parket-lux";
        $subcopy = new HtmlString('Если не получается кликнуть на кнопку "Перейти в личный кабинет", скопируйте и вставьте УРЛ ниже в ваш веб браузер: <span class="break-all">' . $actionUrl . '</span>');
        $order = $this->order;
        $password = $this->password;

        $data = compact("headerUrl", "headerLine", "subcopy", "order", "password", "actionUrl");

        $contents = $this->viewFactory->make("emails.order-shipped", $data)->render();

        $cssInliner = new CssToInlineStyles();
        $css = $this->viewFactory->make("emails.themes.custom", $data)->render();
        $htmlAndCssInline = $cssInliner->convert(
            $contents,
            $css
        );

        return $this
                ->to($this->email)
                ->html(new HtmlString($htmlAndCssInline))
                ->subject("union.parket-lux: Ваш заказ номер {$order->id} обрабатывается")
            ;
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @return string
     */
    protected function verificationUrl(): string
    {
        return URL::signedRoute(
            'profile.identify',
            [
                'id' => $this->id,
                'email' => $this->email,
                'hash' => sha1($this->email),
            ]
        );
    }
}
