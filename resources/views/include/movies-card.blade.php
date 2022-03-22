@if($boolFromDB)
    @php
        $movieAttributes = $movie->getAttributes();
        $id = $movieAttributes["id"];
        $poster = $movieAttributes["poster"];
        $title = $movieAttributes["title"];
        $year = $movieAttributes["year"];
        $imdbID = $movieAttributes["imdbID"];
    @endphp
@else 
    @php
        $poster = $movie->Poster;
        $title = $movie->Title;
        $year = $movie->Year;
        $imdbID = $movie->imdbID;
    @endphp 
@endif

<article class="flex flex-col justify-center bg-gray-400 shadow shadow-lg rounded-lg justify-between">
    <figure class="p-4">
        <img src="{{ $poster != "N/A" && $poster != ""? $poster : url('/images/noposter.png') }}" width="100%" alt="{{ $title }}">
        <figcaption>
            <h3 class="text-lg font-bold text-center m-3">{{ $title }}</h3>
            <h4 class="text-md text-center m-1">📅 Año: {{ $year }}</h4>
        </figcaption>
    </figure>
    @auth
        @if($boolFromDB || array_key_exists($imdbID, session()->get('favoriteIDs')))
            @if(!$boolFromDB)
                @php
                    $arrTMP = session()->get('favoriteIDs');
                    $id = $arrTMP[$imdbID];
                @endphp
            @endif
            <button data-id="{{ $id }}"
                class="button-delete w-full bg-red-500 hover:bg-red-500 text-white font-bold py-2 px-4 rounded self-end inline-flex items-center justify-center">
                <span><i class="fa-solid fa-trash"></i> Eliminar</span>
            </button>
        @else 
            <button data-id="{{ $imdbID }}" data-title="{{ $title }}" data-year="{{ $year }}" data-poster="{{ $poster != "N/A"? $poster : "" }}"
                class="button-favorite w-full bg-amber-400 hover:bg-amber-300 text-gray-800 font-bold py-2 px-4 rounded self-end inline-flex items-center justify-center">
                <span><i class="fa-solid fa-star"></i> Marcar como favorita</span>
            </button>
        @endif
    @endauth
</article>