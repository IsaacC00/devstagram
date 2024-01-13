<div>
    <!-- Be present above all else. - Naval Ravikant -->
    <@if ($posts->count())

    
    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach ($posts as $post)
        
            <div>
                <a href="{{route('post.show', ['post'=>$post,'user'=>$post->user])}}">
                    <img src="{{ asset('uploads').'/'. $post->imagen}}" alt="imagen del post 
                    {{$post->titulo}}">
                </a>
            </div>
        @endforeach
    </div>
    
    <div class="my-10">
        {{$posts->links()}}
    </div>
    
    @else
    
    <h3 class="text-center">No hay post para mostrar, sigue a alguien para tener post</h3>
    
    @endif
</div>