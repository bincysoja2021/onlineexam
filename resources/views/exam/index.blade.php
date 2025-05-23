@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Question {{ $currentIndex + 1 }} of 10</h4>
    
    <div id="timer" class="alert alert-info">Time Left: <span id="time">10:00</span></div>

    <form method="POST" action="{{ url('/exam/answer') }}">
        @csrf
        <input type="hidden" name="question_id" value="{{ $question->id }}">

        <p><strong>{{ $question->question }}</strong></p>

        @foreach (['a', 'b', 'c', 'd'] as $opt)
            <div class="form-check">
                <input type="radio" class="form-check-input" id="opt{{ $opt }}" name="answer" value="{{ $opt }}" 
                    {{ $userAnswer == $opt ? 'checked' : '' }}>
                <label class="form-check-label" for="opt{{ $opt }}">
                    {{ $question['option_' . $opt] }}
                </label>
            </div>

        @endforeach


            <!-- Mark for Review checkbox inside the form -->
        <div class="form-check mt-2">
            <input type="checkbox" class="form-check-input" id="markForReview" name="mark_for_review" value="1"
                {{ session('marked_questions')[$question->id] ?? false ? 'checked' : '' }}>
            <label class="form-check-label" for="markForReview">Mark for Review</label>
        </div>

        <div class="mt-3">
            @if ($currentIndex > 0)
                <button type="submit" name="action" value="previous" class="btn btn-secondary">Previous</button>
            @endif

            <button type="submit" name="action" value="save" class="btn btn-info">Save</button>

            @if ($currentIndex < 9)
                <button type="submit" name="action" value="next" class="btn btn-primary">Next</button>
            @endif

            <button type="submit" name="action" value="review" class="btn btn-warning">Review</button>
            <button type="submit" name="action" value="submit" class="btn btn-success">Submit</button>

        </div>
    </form>
</div>

<script>
    // Prevent refresh or back - but disable on form submit
    let isSubmitting = false;

    window.onbeforeunload = function () {
        if (!isSubmitting) {
            return "Refreshing or leaving the page will disqualify your test!";
        }
    };

    // When the form submits, set the flag so warning is disabled
    const form = document.querySelector('form');
    form.addEventListener('submit', function () {
        isSubmitting = true;
    });

    

    let timeLeft = {{ $timeLeft }}; // from server

    const timeDisplay = document.getElementById('time');

    const timer = setInterval(function () {
        if (timeLeft <= 0) {
            clearInterval(timer);
            alert('Time is up! Submitting your exam.');
            window.location.href = "{{ url('/exam/submit') }}";
        } else {
            let minutes = Math.floor(timeLeft / 60);
            let seconds = timeLeft % 60;
            timeDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            timeLeft--;
        }
    }, 1000);

</script>
@endsection
