<div id="contact-with-technologist" class="modal-call-us">
    <div class="popup-container">
        <form class="form-horizontal" action="#" enctype="multipart/form-data">
            <p>Консультация по телефону:<br><a href="tel:+74953638799">+7(495) 363-87-99</a></p>
            <h4>Связаться с технологом</h4>
            <div class="form-group">
                <input placeholder="Ваше имя" type="text" class="form-control" name="form_text_1" value="" size="0">
            </div>
            <div class="form-group">
                <input placeholder="Электронная почта" type="text" class="form-control" name="form_text_2" value=""
                       size="0">
            </div>
            <div class="form-group">
                <textarea placeholder="Ваш вопрос" name="form_textarea_3" cols="40" rows="5" class="form-control textarea-question"></textarea>
            </div>
            <div class="form-group">
                <input placeholder="Телефон" type="text" class="form-control" name="form_text_9" value="" size="0">
            </div>
            <div class="form-group">
                <div class="col-sm-12 col-xs-12">
                    <div>Введите код с картинки:</div>
                    <img src="{{asset("images//captcha.jpeg")}}" width="180" height="40">
                    <input type="text" name="captcha_word" size="30" maxlength="50" value="" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <input type="submit" name="web_form_submit" value="Отправить" class="pull-right btn-blue fixsize">
                <input type="hidden" name="web_form_apply" value="Y">
            </div>
            <div class="form-group result" style="display: none;">
                <div class="col-xs-12" style="color: green;">
                    Ваше сообщение успешно отправлено
                </div>
            </div>
        </form>
    </div>
</div>
