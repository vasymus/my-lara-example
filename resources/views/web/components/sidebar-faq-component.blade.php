<div class="sidebar-faq-block">
    <h4 class="sidebar-faq-block__title">Вопросы и ответы:</h4>
    <?php /** @var \Domain\FAQs\Models\FAQ $sidebarFaq */ ?>
    @foreach($sidebarFaqs as $sidebarFaq)
        <div class="sidebar-faq-block__row">
            <div class="sidebar-faq-block__content">
                {!! strip_tags(\Support\TruncateHTML\TruncateHTML::handleTruncate($sidebarFaq->question, 15), implode(",", ["p", "div", "img", "span", "strong", "b", "u", "ul", "ol", "li", "a", "br"])) !!}
                <p>...</p>
            </div>
            <div class="sidebar-faq-block__more">
                <a href="{{route("faq.show", [$sidebarFaq->slug])}}">Читать полностью</a>
            </div>
        </div>
    @endforeach
    <div class="sidebar-faq-block__apply-question">
        <a href="{{route("ask")}}">Задать свой вопрос</a>
    </div>
</div>
