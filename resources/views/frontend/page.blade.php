@extends('layouts.frontend')

@section('title', $page->title . ' - ' . $company_name)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="text-center mb-5">
                @if($page->featured_image)
                    <img src="{{ route('media.pages', ['file' => basename($page->featured_image)]) }}" class="img-fluid rounded mb-4" alt="{{ $page->title }}">
                @endif
                <h1 class="fw-bold mb-3">{{ $page->title }}</h1>
            </div>
            
            <div class="page-content">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</div>

<style>
    .page-content h2, .page-content h3, .page-content h4 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }
    .page-content p {
        margin-bottom: 1rem;
        line-height: 1.8;
    }
    .page-content ul, .page-content ol {
        margin-bottom: 1rem;
        padding-left: 1.5rem;
    }
</style>
@endsection