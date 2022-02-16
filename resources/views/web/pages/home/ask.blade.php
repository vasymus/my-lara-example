@extends('web.pages.page-layout')

@section('page-content')
    <div class="content-header">
        <div class="content-header__line">
            <h1 class="content-header__title">
                <span>Добавить вопрос</span>
            </h1>
        </div>
    </div>

    <div class="row-line row-line__right">
        <div class="column-back">
            <a href="#" title="вернуться на предыдущую страницу" class="btn-back js-back">
                <img src="{{asset("images/general/backarow.svg")}}" width="97" alt="">
            </a>
        </div>
    </div>
    <div class="content__white-block">
        <form class="form-horizontal" action="#" enctype="multipart/form-data">
            <div class="form-group">
                <label for="form-ask-question">Ваш вопрос *</label>
                <textarea id="form-ask-question" name="question" cols="40" rows="5" class="form-control textarea-question"></textarea>
            </div>

            <div class="form-group">
                <label for="form-ask-name">Ваше имя</label>
                <input id="form-ask-name" type="text" class="form-control" name="name" />
            </div>
            <div class="form-group">
                <label for="form-ask-email">Электронная почта *</label>
                <input id="form-ask-email" type="text" class="form-control" name="email" />
            </div>
            <div class="form-group">
                <label for="form-ask-files">Файлы</label>
                <div class="block-file">
                    <div class="bg_img">
                        <input class="form-control-file" id="form-ask-files" type="file" name="files" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12 col-xs-12">
                    <div>Введите код с картинки:</div>
                    <div class="row-line row-line__center">
                        <input type="text" name="captcha_word" size="30" maxlength="50" value="" class="form-control small">
                        <img src="{{asset("images/captcha.jpeg")}}" width="180" height="40">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label><em>*</em> - обязательные для заполнения поля</label>
                <input type="submit" value="Отправить вопрос" class="btn-submit">
                <p class="form-group__text">Нажимая на кнопку "Отправить вопрос", я даю <a href="#" data-fancybox="consent-processing-personal-data" data-src="#consent-processing-personal-data">согласие на обработку своих персональных данных</a></p>
            </div>
            <div class="form-group result" style="display: none;">
                <div class="col-xs-12" style="color: green;">
                    Ваше сообщение успешно отправлено
                </div>
            </div>
        </form>
        <div class="form-group__item">
            <p><a href="{{route("faq.index")}}">Перейти в список вопросов</a></p>
        </div>
    </div>
@endsection
