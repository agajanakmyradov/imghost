@extends('layouts.app')


@section('content')

    @auth
        <div class="container">
            @if(session()->has('deleted'))
                <div class="alert alert-info alert-dismissible fade show float-start py-1" role="alert" style="max-width: 300px">
                    {{session('deleted')}}
                    <button type="button" class="btn-close mt-1 p-2" data-bs-dismiss="alert" aria-label="Close" style="font-size: 10px"></button>
                </div>
            @endif



            <div class="pagination justify-content-end ">
                <div class="">{{ $images->links() }}</div>
            </div>


            <div class="d-flex justify-content-center flex-wrap " style="clear: both">
                @if(count(Auth::user()->images) > 0)
                    @foreach ($images as $image)
                        <div class="m-1">
                            <a href="{{asset('storage') . '/' . $image->path}}" class="text-center">
                                    <img src="{{asset('storage') . '/' . $image->path}}" alt="image" style="width: 150px; height: 150px">
                            </a>
                            <div class="m-1">
                                <div class="btn btn-secondary imageLink" data-path="{{asset('storage') . '/' . $image->path}}">Copy</div>
                                <div type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{route('images.destroy', ['id' => $image->id])}}" data-path="{{asset('storage') . '/' . $image->path}}" onclick="showDeleteDeatils()">Delete</div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center">
                        <h3>You don't have any image</h3>
                    </div>
                @endif
            </div>

            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header"  style="background-color: #e3f2fd;">
                      <h1 class="modal-title fs-5" id="deleteModalLabel">Delete image</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="text-center">
                        <img id="imageToDelete" src="" alt="image" style='width: 100px; height: 100px'>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <a href="" type="button" class="btn btn-danger" id="modalDeleteBtn">Delete</a>
                    </div>
                  </div>
                </div>
            </div>


        </div>
    @else
        <div class="container">
            <h3>Please sign in to see your books</h3>
        </div>
    @endauth
@endsection

@push('scripts')
    <script>
        window.onload = function() {
            copy();
        }

        function copy() {
            let copyButtons = document.querySelectorAll('.imageLink');
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
                    var originalBackgroundColor = button.style.backgroundColor;
                    button.style.backgroundColor = 'green';

                    setTimeout(function() {
                        button.style.backgroundColor = originalBackgroundColor;
                    }, 500);
                })
            })
        }


        function showDeleteDeatils() {
            let image = document.querySelector('#imageToDelete');
            image.src = event.target.dataset.path;
            document.querySelector('#modalDeleteBtn').href = event.target.dataset.id
            console.log(event.target.dataset.path)
        }
    </script>
@endpush
