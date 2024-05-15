<x-app-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
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
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">Add Question</div>

                                    <div class="card-body">
                                        <form method="POST" action="{{ route('questions.store') }}">
                                            @csrf

                                            <div class="form-group">
                                                <label for="subject">Subject:</label>
                                                <select class="form-control" id="subject" name="subject" required>
                                                    <option value="">Select Subject</option>
                                                    <option value="php">PHP</option>
                                                    <option value="html">Html</option>
                                                    <option value="css">CSS</option>
                                                    <option value="ajax">Ajax</option>
                                                    <option value="jquery">JQuery</option>
                                                </select>
                                            </div>


                                            <div class="form-group">
                                                <label for="question_text">Question:</label>
                                                <input type="text" class="form-control" id="question_text"
                                                    name="questions[question_text]" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="options">Options:</label>
                                                @for ($i = 0; $i < 4; $i++)
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                            name="questions[options][]"
                                                            placeholder="Option {{ $i + 1 }}">
                                                    </div>
                                                @endfor
                                                <!-- Add more options as needed -->
                                            </div>

                                            <div class="form-group">
                                                <label for="correct_option">Correct Option:</label>
                                                <select class="form-control" id="correct_option"
                                                    name="questions[correct_option_id]" required>
                                                    <option value="">Select Correct Option</option>
                                                    @for ($i = 0; $i < 4; $i++)
                                                        <option value="{{ $i }}">Option {{ $i + 1 }}
                                                        </option>
                                                    @endfor
                                                    <!-- Add more options as needed -->
                                                </select>
                                            </div>


                                            <button type="submit" class="btn btn-primary">Add Question</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
