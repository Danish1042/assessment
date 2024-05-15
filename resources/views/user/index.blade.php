@extends('user.layouts.app')

@section('content')
    <x-app-layout>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                 <h3>Hello! {{ Auth::user()->name }}</h3>
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div id="questions-container">
                                        @foreach ($questions as $index => $question)
                                            <div class="card mb-3 question-card" data-question-id="{{ $question->id }}" @if ($index !== 0) style="display: none;" @endif>
                                                {{-- show first --}}
                                                <div class="card-header">Question: {{ $question->question_text }}</div>
                                                <div class="card-body">
                                                    <form class="answer-form">
                                                        @csrf
                                                        <input type="hidden" name="question_id" value="{{ $question->id }}">
                                                        @foreach ($question->options as $option)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="selected_option_{{ $question->id }}" value="{{ $option }}" id="option_{{ $question->id }}_{{ $loop->index }}">
                                                                <label class="form-check-label" for="option_{{ $question->id }}_{{ $loop->index }}">{{ $option }}</label>
                                                            </div>
                                                        @endforeach
                                                        @if ($index !== count($questions) - 1)
                                                            <button type="button" class="btn btn-primary mt-3 next-question">Next</button>
                                                        @else
                                                            <button type="button" class="btn btn-success mt-3 submit-answers">Submit</button>
                                                        @endif
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div id="result-container"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
    @push('js')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            jQuery(document).ready(function($) {
                let answers = {};

                $('.next-question').click(function() {
                    let currentCard = $(this).closest('.question-card');
                    let questionId = currentCard.data('question-id');
                    let selectedOption = $('input[name="selected_option_' + questionId + '"]:checked').val();

                    if (selectedOption) {
                        answers[questionId] = selectedOption;
                        currentCard.hide();
                        currentCard.next('.question-card').show();
                    } else {
                        alert('Please select an option');
                    }
                });

                $('.submit-answers').click(function() {
                    let currentCard = $(this).closest('.question-card');
                    let questionId = currentCard.data('question-id');
                    let selectedOption = $('input[name="selected_option_' + questionId + '"]:checked').val();

                    if (selectedOption) {
                        answers[questionId] = selectedOption;
                        $.ajax({
                            type: "POST",
                            url: "{{ route('submit.answers') }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                answers: answers
                            },
                            success: function(response) {
                                $('#questions-container').hide();
                                $('#result-container').html(
                                    `<p>Total Questions: ${response.totalQuestions}</p>
                                     <p>Correct Answers: ${response.correctAnswers}</p>
                                     <p>Incorrect Answers: ${response.incorrectAnswers}</p>
                                     <p>Percentage Correct: ${response.percentageCorrect}%</p>`
                                );
                            }
                        });
                    } else {
                        alert('Please select an option');
                    }
                });
            });
        </script>
    @endpush
@endsection
