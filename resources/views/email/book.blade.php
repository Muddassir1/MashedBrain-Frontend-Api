<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>



<h1 style="margin: 0px">{{ $data->name }}</h1>
<p style="margin-top: 5px;margin-bottom:20px"><em>By {{ $data->author }}</em></p>
<h3 style="text-decoration: underline">About the Author</h3>
<p>{{ $data->about_author }}</p>
<h3 style="text-decoration: underline">About Book</h3>
<p>{{ $data->about_book }}</p>
<h3 style="text-decoration: underline">Who is it for?</h3>
<p>{{ $data->about_audience }}</p>
<hr>
<ol>
    @foreach ($data->pages as $page)
        <li>
            <h2 style="text-decoration: underline">{{ $page->title }}</h2>
            <p>{{ $page->description }}</p>
            <br>
        </li>
    @endforeach
</ol>

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
