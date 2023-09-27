@extends('layouts.app')

@section('content')
    <div class="container">
        @auth
            @if (Auth::user()->hasVerifiedEmail())
                <div class="fw-bold">
                    Your api key:
                </div>
                <div>
                    <div class="d-flex justify-content-between p-2 " style="background-color: rgb(244, 236, 236); max-width: 800px" onmouseover="showCopyBtn()" onmouseout="hideCopyBtn()">
                        <div class=" me-5">
                            {{ Auth::user()->api_token }}
                        </div>
                        <button id="copyBtn" class="copyBtn"  data-path=" {{ Auth::user()->api_token }}">
                            Copy
                        </button>
                    </div>
                </div>
                <div class="m-2">
                    <a href="{{route('user.api.change')}}" class="btn btn-primary">Change key</a>
                </div>
            @else
                Please <a href="{{route('verification.notice')}}">verify</a> your email to get your api key.
            @endif
        @else
            <div>
                Please <a href="{{route('login')}}">login</a> to get your api key.
            </div>

        @endauth

        <div>
            <h3>Request method</h3>
            <p>
                API calls can be done using the POST request method.
            </p>
            <h4>Image Upload</h4>
            <div class="p-2 " style="background-color: rgb(244, 236, 236); max-width: 800px">
                <div class=" me-5">
                    {{ config('app.url') . 'api/v1/images/store' }}
                </div>
            </div>
            <h3 class="mt-4">Parameters</h3>

            <table class="table table-bordered">
                <tr>
                    <td>key</td>
                    <td>Required. Your api key.</td>
                </tr>
                <tr>
                    <td>type</td>
                    <td>Required. It can take one of two values: file or link.</td>
                </tr>
                <tr>
                    <td>file</td>
                    <td>Required if "type" parameter is "file". JPG, GIF and PNG images up to 10MB each.</td>
                </tr>
                <tr>
                    <td>url</td>
                    <td>Required if "type" parameter is "url". It must be a valid url.</td>
                </tr>
            </table>

        </div>

    </div>
@endsection

@push('scripts')
    <script>
        window.onload = function() {
            copyToBuffer();
        }

        function showCopyBtn() {
            document.getElementById('copyBtn').style.background = 'silver';
            document.getElementById('copyBtn').style.color = 'black';
        }

        function hideCopyBtn() {
            document.getElementById('copyBtn').style.background = 'rgb(244, 236, 236)';
            document.getElementById('copyBtn').style.color = 'rgb(244, 236, 236)';
        }

        function copyToBuffer() {
            let copyButtons = document.querySelectorAll('.copyBtn');
            console.log('tak')
            copyButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    let textToCopy = event.target.dataset.path;

                    // Создаем временный элемент textarea для копирования текста
                    let textarea = document.createElement('textarea');
                    textarea.value = textToCopy;
                    document.body.appendChild(textarea);

                    // Выделяем текст в textarea и копируем его
                    textarea.select();
                    document.execCommand('copy');

                    // Удаляем временный элемент textarea
                    document.body.removeChild(textarea);

                    // Визуальное обозначение успешного копирования
                    document.getElementById('copyBtn').style.background = 'green';
                    document.getElementById('copyBtn').style.color = 'white';
                })
            })
        }

    </script>
@endpush
