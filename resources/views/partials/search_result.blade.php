<!-- resources/views/partials/search_results.blade.php -->

<h2>Doctors</h2>
@foreach($doctors as $doctor)
    <p>{{ $doctor->firstname }} {{ $doctor->lastname }}, {{ $doctor->specialization }}</p>
@endforeach

<h2>Chambers</h2>
@foreach($chambers as $chamber)
    <p>{{ $chamber->chamber_name }}, {{ $chamber->location }}</p>
@endforeach
