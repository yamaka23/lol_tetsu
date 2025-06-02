<!DOCTYPE html>
<!--
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
    <head>
        <meta charset="utf-8">
        <title>Blog</title>
        
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1>Blog Name</h1>
        <a href='/posts/create'>create</a>
        <div class='posts'>
            @foreach ($posts as $post)
                <div class='post'>
                    <h2 class='title'>
                        <a href="/posts/{{ $post->id }}">{{ $post->title }}</a>
                    </h2>
                    <a href="/categories/{{ $post->category->id }}">{{ $post->category->name }}</a>

                    <p class='body'>{{ $post->body }}</p>

                    <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="deletePost({{ $post->id }})">delete</button> 
                    </form>
                </div>
            @endforeach
            {{ Auth::user()->name }}
        </div>

        <div class='paginate'>
            {{ $posts->links() }}    
        </div>

        <script>
            function deletePost(id) {
                'use strict'

                if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                    document.getElementById(`form_${id}`).submit();
                }
            }
        </script>    
    </body>
</html>
-->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Blog一覧
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href='/posts/create' class="text-blue-600 underline">create</a>

        <div class='posts mt-4'>
            @foreach ($posts as $post)
                <div class='post border p-4 mb-4'>
                    <h2 class='title text-xl font-bold'>
                        <a href="/posts/{{ $post->id }}">{{ $post->title }}</a>
                    </h2>
                    <a href="/categories/{{ $post->category->id }}" class="text-sm text-gray-600">
                        {{ $post->category->name }}
                    </a>

                    <p class='body mt-2'>{{ $post->body }}</p>

                    <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="deletePost({{ $post->id }})" class="text-red-500">delete</button>
                    </form>
                </div>
            @endforeach

            <p class="text-gray-500">ログインユーザー：{{ Auth::user()->name }}</p>
        </div>

        <div class='paginate mt-8'>
            {{ $posts->links() }}    
        </div>

        <div>
            @foreach($questions as $question)
                <div>
                    <a href="https://teratail.com/questions/{{ $question['id'] }}">
                        {{ $question['title'] }}
                    </a>
                </div>
            @endforeach
        </div>

        <script>
            function deletePost(id) {
                'use strict';
                if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                    document.getElementById(`form_${id}`).submit();
                }
            }
        </script>
    </div>
</x-app-layout>

