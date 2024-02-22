@extends('layout')
@section('page-title', $page->seo_title ?? '')
@section('description', $page->seo_description ?? '')
@section( 'keywords', $page->seo_keywords ?? '')

@section('content')
    <section class="stati stati-page">
        <div class="container">
            <div class="container">
                <div class="stati-cont">
                    <div class="title">{{$page->title}}</div>
                </div>
                <div class="stati-img">
                    <div class="stati-img_cont"
                         style="background-image: url('{{$page->attachment[0]->relativeUrl ?? 'no_image.jpg'}}');"></div>
                </div>
                <div class="stati-text">{!! $page->text !!}</div>
            </div>
        </div>
    </section>
@endsection
