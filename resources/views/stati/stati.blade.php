@extends('layout')
@section('page-title', $statja->seo_title ?? '')
@section('description', $statja->seo_description ?? '')
@section( 'keywords', $statja->seo_keywords ?? '')

@section('content')
<section class="stati">
    <div class="container">
        <div class="container">
            <div class="stati-cont">
                <div class="row">
                    @foreach($stati as $item)
                        <div class="col-md-3 col-sm-4 col-6">
                            <div class="stati-item">
                                <div class="stati-item_img">
                                    <a href="{{url()->current() . '/' . $item->alias}}">
                                        <div class="stati-item_img__cont"
                                             style="background-image: url('{{$item->attachment[0]->relativeUrl ?? 'no_image.jpg'}}');">
                                        </div>
                                    </a>
                                </div>
                                <div class="stati-item_title">
                                    <a href="{{url()->current() . '/' . $item->alias}}">{{$item->title}}</a>
                                </div>
                                <div class="stati-item_text">{{$item->subtitle}}</div>
                                <span>{{$item->created_at->toDateString()}}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center">{{ $stati->links() }}</div>
            </div>
        </div>
    </div>
</section>
@endsection
