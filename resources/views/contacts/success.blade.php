@extends('layout')
@section('page-title', $page->seo_title ?? '')
@section('description', $page->seo_description ?? '')
@section( 'keywords', $page->seo_keywords ?? '')

@section('content')
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 style="font-size: 36px;
                    text-align: center;
                    line-height: 1.2;
                    margin: 0px 0 20px;
                    text-transform: uppercase;
                    color: #2cbf00;
                    position: relative;">Ваша заявка принята</h1>
                    <p style="text-align:center"><img style="width: 100%;max-width: 650px" alt="" src="./img/thanks.png" width="650"></p>
                    <p>&nbsp;</p>
                </div>
            </div>
        </div>
    </section>
@endsection
