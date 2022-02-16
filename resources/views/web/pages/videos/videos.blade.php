@extends('web.pages.page-layout')

@section('page-content')
    <x-h1 :entity="'Видеогалерея'"></x-h1>
    <article class="article-content ">
        <h3>Укладка Ламината и Паркетной доски</h3>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/TMaANkQxezU" frameborder="0" allowfullscreen></iframe>
        <br>
        <br>
        <h3>Основание из ГВЛ-элементов пола KNAUF с минеральной ватой</h3>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/8iqdWGUqeYU" frameborder="0" allowfullscreen></iframe>
        <br>
        <h3>Основание из ГВЛ-элементов пола KNAUF с пенополистеролом</h3>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/5SLVLtjbK4s" frameborder="0" allowfullscreen></iframe>
        <br>
        <h3>Основание из ГВЛ-элементов пола KNAUF с сухой засыпкой</h3>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/AZMkcN6ASyg" frameborder="0" allowfullscreen></iframe>
        <br>
    </article>
@endsection
