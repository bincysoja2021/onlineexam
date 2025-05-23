@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Review Your Answers</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Question</th>
                <th>Your Answer</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($questions as $index => $q)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $q->question }}</td>
                    <td>
                        @php
                            $selected = $answers[$q->id] ?? null;
                            $optionText = $selected ? $q['option_' . $selected] : 'Not Answered';
                        @endphp
                        {{ $selected ? strtoupper($selected) . '. ' . $optionText : 'Not Answered' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        <a href="{{ url('/exam') }}" class="btn btn-primary">Back to Exam</a>
        <a href="{{ url('/exam/submit') }}" class="btn btn-success">Submit Exam</a>
    </div>
</div>
@endsection
