@extends('web.pages.page-home-layout')

@section('page-home-content')
    <section class="section-home-page">
        <div class="container">
            <div class="row-line">
                <div class="column">
                    <article class="article-content">
                        <h1 class="title">Паркетные работы</h1>
                        <div class="slider-home">
                            <div>
                                <img src="{{asset("images//pic.jpg")}}" alt="" title="">
                            </div>
                            <div>
                                <img src="{{asset("images//pic1.jpg")}}" alt="" title="">
                            </div>
                            <div>
                                <img src="{{asset("images//pic2.jpg")}}" alt="" title="">
                            </div>
                            <div>
                                <img src="{{asset("images//pic3.jpg")}}" alt="" title="">
                            </div>
                        </div>
                        <p>
                            Как выбрать подрядчика для работы с паркетом?
                        </p>
                        <p>
                            1. Довериться частным мастерам на все руки. <br>
                            2. Нанять компанию, специализированную по паркетным работам под ключ.
                        </p>
                        <p>
                            Плюсы есть у каждого варианта, всё зависит от ваших целей, возможностей и ожиданий. На сайте мы
                            «по кусочкам» разобрали специфику паркетных работ&nbsp;на всех этапах. Особенностей очень много:
                            от разнообразия материалов, которые подходят в одних условиях и губительны в других, до самого
                            главного – подготовки основания.
                        </p>
                        <p>
                            Вам выбирать, кто лучше выполнит паркетные работы - универсальные мастера или специализированная
                            компания. Наша цель – дать объективную информацию, чтобы ваш выбор был лёгким, и правильным. От
                            него зависит – прослужит паркет 2 года или 25 лет!
                        </p>
                        <p>
                            Проходите на страницы с интересующими вас услугами.
                        </p>
                    </article>
                    <div class="row-line">
                        <div class="column-sm-6 col-sm-6">
                            <article class="article-content">
                                <h2>Укладка паркета</h2>
                                <p>Существует несколько видов технологии укладки паркета. Какую технологию использовать и
                                    почему?</p>
                                <p>Все зависит от вида напольного покрытия и условий его эксплуатации. Например, для офисных помещений подходит бюджетная паркетная доска. В этом случае идеальный вариант <a href="{{route("services.show", "ukladka-parketnoy-doski")}}">«плавающая» укладка паркетой доски</a>, потому что не так важен срок службы, главное – низкая цена, а через несколько лет покрытие можно заменить полностью.</p>
                                <p>Если вы планируете <a href="{{route("services.show", "ukladka-massivnoy-doski")}}">укладывать массивную доску</a> или <a href="{{route("services.show", "ukladka-shtuchnogo-parketa")}}">штучный паркет</a>, то лучше использовать европейскую технологию.</p>
                                <p>Перейдите на страницу с укладкой для выбранного вами паркета.</p>
                            </article>
                        </div>
                        <div class="column-sm-6 col-sm-6">
                            <article class="image-content" style="background-image: url({{asset("images//banner1.png")}}); display: block;">
                                <a href="{{route("services.show", "ukladka-shtuchnogo-parketa")}}"><span>укладка<br> штучного паркета</span></a>
                            </article>
                            <article class="image-content" style="background-image: url({{asset("images//banner2.png")}}); display: block;">
                                <a href="{{route("services.show", "ukladka-massivnoy-doski")}}"><span>укладка<br> массивной доски</span></a>
                            </article>
                            <article class="image-content" style="background-image: url({{asset("images//banner3.jpg")}}); display: block;">
                                <a href="{{route("services.show", "ukladka-parketnoy-doski")}}"><span>укладка<br> паркетной доски</span></a>
                            </article>
                        </div>
                    </div>
                    <div class="row-line hidden-lg">
                        <div class="full-width">
                            <div class="article-content">
                                <h3>Реставрация паркета</h3>
                                <div class="slider-home">
                                    <div>
                                        <img src="{{asset("images//pic4.jpg")}}" alt="" title="">
                                    </div>
                                    <div>
                                        <img src="{{asset("images//pic5.jpg")}}" alt="" title="">
                                    </div>
                                    <div>
                                        <img src="{{asset("images//pic6.jpg")}}" alt="" title="">
                                    </div>
                                    <div>
                                        <img src="{{asset("images//pic7.jpg")}}" alt="" title="">
                                    </div>
                                </div>
                                <p>
                                    Для таких паркетных работ хорошо подходят рекламные слоганы - <em>«Ваш паркет потерял привлекательный вид?», «Через 3 дня ваш старый, изношенный паркет засияет как новый»</em>.
                                </p>
                                <p>
                                    Это тот редкий случай, когда реклама не преувеличивает.
                                </p>
                                <p>
                                    При наличии профессионального немецкого оборудования (стоимостью более 500 000 рублей) и
                                    практического опыта работы с паркетом, напольное покрытие восстанавливается до состояния
                                    &nbsp;«как из магазина» даже в самых сложных и запущенных случаях.
                                </p>
                                <p>
                                    <a href="{{route("services.show", "remont-parketa")}}">Ремонт паркета</a> – необходимость, а не приговор, и в арсенале наших мастеров есть мощное оружие для ремонта любого паркета.&nbsp;
                                </p>
                            </div>
                        </div>
                        <div class="full-width">
                            <div class="row-line">
                                <div class="column-sm-6 col-sm-6">
                                    <article class="image-content"
                                             style="background-image: url({{asset("images//banner7.png")}}); display: block;">
                                        <a href="{{route("services.show", "remont-parketa")}}">
                                            <span>ремонт паркета</span>
                                        </a>
                                    </article>
                                </div>
                                <div class="column-sm-6 col-sm-6">
                                    <article class="image-content"
                                             style="background-image: url({{asset("images//banner8.png")}}); display: block;">
                                        <a href="{{route("services.show", "tonirovanie-parketa")}}">
                                            <span>тонировка паркета</span>
                                        </a>
                                    </article>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="row-line">
                        <div class="column-sm-6">
                            <article class="article-content">
                                <h2>Подготовка основания</h2>
                                <p>Основание для укладки паркета – это как фундамент для дома. Ровное, прочное и сухое основание = долгий срок службы паркетного пола. Малейшее нарушение технологии подготовки основания приводит к скрипу, вспучиванию и короблению паркета.</p>
                                <p>Основания для&nbsp;<a href="{{route("services.show", "ukladka-shtuchnogo-parketa")}}">укладки паркета</a> отличается от основания для других напольных покрытий. К нему предъявляются особые требования по влажности и прочности. И чтобы достичь их – нужны знания, опыт и профессиональное оборудование.</p>
                                <p>Мы предлагаем вам 3 варианта основания для укладки паркета: <a href="{{route("services.show", "styazhka-pola")}}">цементно-песчаная стяжка</a>, <a href="{{route("services.show", "pol-na-lagakh")}}">пол на лагах</a> и <a href="{{route("services.show", "sukhaya-styazhka-knauf")}}">сухая стяжка Knauf</a>. Проходите на страницы с описанием и узнайте, какое основание подходит вам.</p>
                            </article>
                        </div>
                        <div class="column-sm-6">
                            <article class="image-content"
                                     style="background-image: url({{asset("images//banner4.png")}}); display: block;">
                                <a href="{{route("services.show", "styazhka-pola")}}"><span>цементная стяжка</span></a>
                            </article>
                            <article class="image-content"
                                     style="background-image: url({{asset("images//banner5.jpg")}}); display: block;">
                                <a href="{{route("services.show", "pol-na-lagakh")}}"><span>пол на лагах</span></a>
                            </article>
                            <article class="image-content"
                                     style="background-image: url({{asset("images//banner6.jpg")}}); display: block;">
                                <a href="{{route("services.show", "sukhaya-styazhka-knauf")}}"><span>ремонт стяжки</span></a>
                            </article>
                        </div>
                        <div class="full-width hidden-lg">
                            <article class="article-content">
                                <h3>Циклевка паркета</h3>
                                <p><a href="{{route("services.show", "tsiklevka-parketa")}}">Циклевка паркета</a>&nbsp;– это комплекс восстановительных
                                    работ, который включает в себя снятие изношенного лака, шпаклевание щелей, шлифовку
                                    поверхности, и нанесении новых слоёв лака или масла.</p>
                                <p>После циклевки паркет становится буквально «как новый». Но, для достижения подобных
                                    результатов нужно <a href="{{route("services.show", "parketnoe-oborudovanie")}}">профессиональное оборудование</a>,
                                    с помощью которого циклевка проходит без пыли и с высочайшим качеством.</p>
                                <p>Мы обновили уже больше 3000 м<sup>2</sup> паркета. Сделаем новым и ваш!</p>
                            </article>
                        </div>
                        <div class="full-width hidden-xs hidden-sm hidden-md">
                            <div class="article-content">
                                <h3>Реставрация паркета</h3>
                                <div class="slider-home">
                                    <div>
                                        <img src="{{asset("images//pic4.jpg")}}" alt="" title="">
                                    </div>
                                    <div>
                                        <img src="{{asset("images//pic5.jpg")}}" alt="" title="">
                                    </div>
                                    <div>
                                        <img src="{{asset("images//pic6.jpg")}}" alt="" title="">
                                    </div>
                                    <div>
                                        <img src="{{asset("images//pic7.jpg")}}" alt="" title="">
                                    </div>
                                </div>
                                <p>
                                    Для таких паркетных работ хорошо подходят рекламные слоганы - <em>«Ваш паркет потерял
                                        привлекательный вид?», «Через 3 дня ваш старый, изношенный паркет засияет как
                                        новый»</em>.
                                </p>
                                <p>
                                    Это тот редкий случай, когда реклама не преувеличивает.
                                </p>
                                <p>
                                    При наличии профессионального немецкого оборудования (стоимостью более 500 000 рублей) и
                                    практического опыта работы с паркетом, напольное покрытие восстанавливается до состояния
                                    &nbsp;«как из магазина» даже в самых сложных и запущенных случаях.
                                </p>
                                <p>
                                    <a href="{{route("services.show", "remont-parketa")}}">Ремонт паркета</a> – необходимость, а не приговор, и в арсенале наших мастеров есть мощное оружие для ремонта любого паркета.&nbsp;
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-line hidden-xs hidden-sm hidden-md">
                <div class="column">
                    <article class="article-content">
                        <h3>Циклевка паркета</h3>
                        <p><a href="{{route("services.show", "tsiklevka-parketa")}}">Циклевка паркета</a>&nbsp;– это комплекс восстановительных работ, который включает в себя снятие изношенного лака, шпаклевание щелей, шлифовку поверхности, и нанесении новых слоёв лака или масла.</p>
                        <p>После циклевки паркет становится буквально «как новый». Но, для достижения подобных результатов нужно <a href="{{route("services.show", "parketnoe-oborudovanie")}}">профессиональное оборудование</a>, с помощью которого циклевка проходит без пыли и с высочайшим качеством.</p>
                        <p>Мы обновили уже больше 3000 м<sup>2</sup> паркета. Сделаем новым и ваш!</p>
                    </article>
                </div>
                <div class="column-half">
                    <article class="image-content" style="background-image: url({{asset("images//banner7.png")}}); display: block;">
                        <a href="{{route("services.show", "remont-parketa")}}">
                            <span>ремонт паркета</span>
                        </a>
                    </article>
                </div>
                <div class="column-half">
                    <article class="image-content" style="background-image: url({{asset("images//banner8.png")}}); display: block;">
                        <a href="{{route("services.show", "tonirovanie-parketa")}}">
                            <span>тонировка паркета</span>
                        </a>
                    </article>
                </div>
            </div>
            <div class="row-line">
                <div class="full-width">
                    <article class="article-content">
                        <h3>Компания «Современные Технологии Паркета» паркетные работы в Москве</h3>
                        <p><em><u>Работаем без предоплаты,&nbsp;официальный&nbsp;договор и гарантия на работы</u></em></p>
                        <p>Выбирая, с какой компанией работать, вы сравниваете все за и против! Сравниваете оборудование,
                            цены, сроки проведения работ и ещё с десяток факторов. И после этого делаете выбор.</p>
                        <p>И это правильно!</p>
                        <p>Чтобы облегчить вам выбор, сразу приступим к делу. Обращаясь в компанию «СТП», вы получаете
                            следующие преимущества:</p>
                        <ol>
                            <li>Работаем БЕЗ предоплаты. Вы не покупаете «кота в мешке». Оплата происходит поэтапно: сначала
                                вы оцениваете результат – потом расчёт.
                            </li>
                            <li>Гарантия от 3-х лет (официальная!) на паркетные работы.</li>
                            <li>15 лет на паркетном рынке.&nbsp;Ежегодно мы посещаем паркетные семинары, что бы освоить
                                последнии тенденции в&nbsp;паркетной промышленности, наши мастера повышают квалификацию и
                                проходят стажировку.
                            </li>
                            <li>Профессиональное оборудование из Германии. В умелых руках оно творит чудеса: паркет
                                укладывается быстро, чисто и надёжно.
                            </li>
                            <li>Индивидуальные разработки. Даже в сложных ситуациях, когда другие фирмы не хотят «заморачиваться» и отказывают, мы разработаем проект и найдём выход. Компания «СТП» имеет опыт реставрации паркета в старинном здании 18 века. Применялись сложные инженерные решения: где-то оптимальна конструкция&nbsp;<a href="{{route("services.show", "pol-na-lagakh")}}">пола на лагах</a>, где-то –&nbsp;<a href="{{route("services.show", "styazhka-pola")}}">стяжка</a>, а иногда приходилось комбинировать.
                            </li>
                            <li>Официальный договор со сроками, сметой и гарантией. Что бы ни случилось с курсом доллара,
                                смета, указанная в договоре, НЕ увеличивается.
                            </li>
                        </ol>
                        <p>Позвоните <strong>+7 (495) 363-87-99</strong> и компания «СТП» выполнит работы в оговоренные
                            сроки и по утверждённой смете.</p>
                        <p>После нас – кристальная чистота и восхищение гостей вашим паркетом.</p>
                    </article>
                </div>
            </div>
        </div>
    </section>
@endsection
