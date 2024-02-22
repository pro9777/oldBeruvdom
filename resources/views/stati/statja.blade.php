@extends('layout')
@section('page-title', $statja->seo_title ?? '')
@section('description', $statja->seo_description ?? '')
@section( 'keywords', $statja->seo_keywords ?? '')

@section('content')
    <section class="stati">
        <div class="container">
            <div class="container">
                <div class="stati-cont">
                    <div class="title">{{$statja->title}}</div>
                </div>
                <div class="stati-img">
                    <div class="stati-img_cont"
                         style="background-image: url('{{$statja->attachment[0]->relativeUrl ?? 'no_image.jpg'}}');"></div>
                </div>
                <div class="stati-text">{!! $statja->text !!}</div>
            </div>
        </div>
    </section>
@endsection
