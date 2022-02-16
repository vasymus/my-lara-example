<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\HtmlString;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class TestMarkupOrderShippedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * The view factory implementation.
     *
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $viewFactory;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->viewFactory = resolve(\Illuminate\Contracts\View\Factory::class);
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
        $this->viewFactory->flushFinderCache();

        $headerUrl = route('home');
        $headerLine = "Вы оформили заказ в интернет-магазине union.parket-lux";
        $subcopy = new HtmlString("Если не получается кликнуть на кнопку \"Перейти в личный кабинет\", скопируйте и вставьте УРЛ ниже в ваш веб браузер: <span class=\"break-all\">https://example.com</span>");

        $data = compact("headerUrl", "headerLine", "subcopy");

        $contents = $this->viewFactory->make("emails.order-shipped-test-markup", $data)->render();

        $cssInliner = new CssToInlineStyles();
        $css = $this->viewFactory->make("emails.themes.custom", $data)->render();
        $htmlAndCssInline = $cssInliner->convert(
            $contents,
            $css
        );

        return $this
            ->html(new HtmlString($htmlAndCssInline))
            ->subject("market-parket.ru: Ваш заказ номер 9491 от 12.01.2021 обрабатывается")
            ;
    }
}
