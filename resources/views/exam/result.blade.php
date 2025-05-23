@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Exam Results</h2>

    <div class="alert alert-success">
        <strong>Your Score:</strong> {{ $score }} / {{ $total }}
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Question</th>
                <th>Your Answer</th>
                <th>Correct Answer</th>
                <th>Result</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($questions as $index => $q)
                @php
                    $userAnswer = $answers[$q->id]->selected_option ?? null;
                    $isCorrect = $userAnswer === $q->correct_option;
                    $userOptionText = $userAnswer ? $q['option_' . $userAnswer] : 'Not Answered';
                    $correctOptionText = $q['option_' . $q->correct_option];
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $q->question }}</td>
                    <td>{{ $userAnswer ? strtoupper($userAnswer) . '. ' . $userOptionText : 'Not Answered' }}</td>
                    <td>{{ strtoupper($q->correct_option) . '. ' . $correctOptionText }}</td>
                    <td>
                        @if ($userAnswer)
                            @if ($isCorrect)
                                <span class="text-success">Correct</span>
                            @else
                                <span class="text-danger">Incorrect</span>
                            @endif
                        @else
                            <span class="text-warning">Not Answered</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ url('/thank-you') }}" class="btn btn-primary mt-4">Finish</a>
</div>
@endsection
