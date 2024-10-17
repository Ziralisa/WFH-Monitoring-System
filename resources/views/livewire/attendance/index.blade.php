<!-- resources/views/attendance/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Attendance Tracking</h1>

        <form action="{{ route('attendance.clock-in') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Clock In</button>
        </form>

        <form action="{{ route('attendance.clock-out') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Clock Out</button>
        </form>

        <a href="{{ route('attendance.calculate-points') }}" class="btn btn-primary">Calculate Points</a>
    </div>
@endsection
