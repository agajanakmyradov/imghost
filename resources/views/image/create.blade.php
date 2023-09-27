@extends('layouts.app')

@section('content')
    <div class="container">

        @auth
                @if(session()->has('image_path'))
                    <div class="d-flex justify-content-center">
                        <div>
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="green" class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                </svg>
                            </div>
                            <div class="my-1 text-center">
                                <img src="{{asset('storage/') . '/' .  session('image_path')}}" alt="image" style="width: 100px; height: 100px">
                            </div>
                            <div class="text-center">
                                File successfully uploaded
                            </div>
                            <div class="my-1" onmouseover="showCopyBtn()" onmouseout="hideCopyBtn()">
                                <div class="d-flex justify-content-between p-2 " style="background-color: rgb(244, 236, 236)">
                                    <div class=" me-5">
                                        {{ asset('storage') . '/' . session('image_path') }}
                                    </div>
                                    <button id="copyBtn"  class="copyBtn" data-path=" {{ asset('storage') . '/' . session('image_path') }}">
                                        Copy
                                    </button>
                                </div>
                            </div>
                            <div class="text-center">
                                <a href="{{route('images.create')}}" class="btn btn-primary">Upload more</a>
                            </div>
                        </div>
                    </div>
                @else

                    <form action="{{route('images.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="test d-flex justify-content-center  flex-wrap ">
                            <div class="d-flex flex-column justify-content-center text-center p-2">
                                <div class="testImage_error" style="color: red">@error('output')  {{$message}}    @enderror</div>

                                <div id="choosenFile" style="display:none">
                                    <div class="d-flex justify-content-center">
                                        <input type="submit" value="Upload" class="btn btn-primary m-1" >
                                        <div class="btn btn-danger m-1" onclick="cancelUpload()">Cancel</div>
                                    </div>
                                    <div>
                                        <img  id="output" class="output" style="width: 100px; height: 100px">
                                    </div>
                                </div>

                                <div class="form__input-file text-center mt-2" id="selectBtn">
                                    <input class="visually-hidden input" type="file" name="output" id="image" onchange="loadFile(event, this)">
                                    <label for="image">
                                        <span class="btn btn-primary">Choose a file</span>
                                        <div>Host JPG, GIF and PNG images up to 10MB</div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif
        @else
            <div class="d-flex justify-content-center mt-5" >
                <div class="row justify-content-center alert text-center " style="max-width: 500px; " >
                    <h3>Please sign in to upload images</h3>
                </div>
            </div>
        @endauth
    </div>
@endsection

@push('scripts')
    <script>
        window.onload = function() {
            var imageElement = document.getElementById('image');

            if (imageElement !== null) {
                imageElement.value = '';
            }

            copyToBuffer();
        }

        let loadFile = function(event, obj) {
            let output = document.getElementById(obj.name);
            output.src = URL.createObjectURL(event.target.files[0]);

            document.getElementById('choosenFile').style.display = 'inline-block';
            document.getElementById('selectBtn').style.display = 'none';
        }

        function cancelUpload() {
            document.getElementById('image').value = '';
            document.getElementById('selectBtn').style.display = 'inline-block';
            document.getElementById('choosenFile').style.display = 'none';
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

