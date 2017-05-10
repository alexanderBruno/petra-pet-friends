 <!-- Vista provisional -->
 <h2>Puntos</h2>
    <ul>
        @foreach ($points as $point)
        <li>
            <a href="{{ url('points/'.$point->id ) }}">{{ $point->name }}</a>{{ $point->id }}
        </li>
        @endforeach
    </ul>