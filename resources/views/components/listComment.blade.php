@if (!empty($comments))
    @foreach ($comments as $parent)
        <div class="product-rating d-flex">
            <div class="avatar">
                <img style="width:34px" src="https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_960_720.png"
                    alt="">
            </div>
            <div class="product-rating__main px-4" style="flex-basis: 100%">
                <h4>{{ $parent->client->name }}</h4>
                <span>{{ $parent->created_at }}</span>
                <p>{{ $parent->contents }}</p>
                @if (Auth::guard('client')->check())
                    <span class="badge badge-primary reply">Trả lời</span>
                @else
                    <a href="{{ url('login\client') }}" class="btn btn-danger">Đăng nhập để trả lời</a>
                @endif
                <div class="form-reply ">
                    <form>
                        <div class="form-group">
                            <label for="comment">Nội dung bình luận</label>
                            <textarea placeholder="Nhập nội dung(*)" class="form-control reply-comment-{{ $parent->id }}" rows="3"></textarea>
                        </div>
                        <div id="comment-error-{{ $parent->id }}" class="text text-danger"></div>
                        <button data-id="{{ $parent->id }}" data-product-id="{{ $parent->product_id }}"
                            class="btn btn-primary btn-reply" type="button">Gửi bình
                            luận</button>
                    </form>
                </div>
                {{-- child comments --}}
                @if (!empty($parent->child_comment))
                    @foreach ($parent->child_comment as $child)
                        <div class="product-rating d-flex">
                            <div class="avatar">
                                <img style="width:34px"
                                    src="https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_960_720.png"
                                    alt="">
                            </div>
                            <div class="product-rating__main px-4" style="flex-basis: 100%">
                                <h4>{{ $child->client->name }}</h4>
                                <span>{{ $child->created_at }}</span>
                                <p>{{ $child->contents }}</p>
                                @if (Auth::guard('client')->check())
                                    <span class="badge badge-primary reply">Trả lời</span>
                                @else
                                    <a href="{{ url('login\client') }}" class="btn btn-danger">Đăng nhập để trả lời</a>
                                @endif
                                <div class="form-reply ">
                                    <form>
                                        <div class="form-group">
                                            <label for="comment">Nội dung bình luận</label>
                                            <textarea placeholder="Nhập nội dung(*)" class="form-control reply-comment-{{ $child->id }}" rows="3"></textarea>
                                        </div>
                                        <div id="comment-error-{{ $child->id }}" class="text text-danger"></div>
                                        <button data-id="{{ $child->id }}"
                                            data-product-id="{{ $child->product_id }}"
                                            class="btn btn-primary btn-reply" type="button">Gửi bình
                                            luận</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    @endforeach
    <script>
        $(".reply").click(function() {
            $(".form-reply").slideUp();
            $(this).parent().find(".form-reply").slideToggle();
        });
        $('.btn-reply').click(function() {
            let id = $(this).attr('data-product-id');
            let parent_id = $(this).attr('data-id');
            let content = $(`.reply-comment-${parent_id}`).val();
            let data = {
                id: id,
                parent_id: parent_id,
                comment: content,
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('ajaxComment') }}",
                method: "POST",
                data: data,
                // dataType: "text",
                success: function(data) {
                    console.log(data);
                    if (data.error) {
                        $(`#comment-error-${parent_id}`).text(data.error);
                    } else {
                        $(`#comment-error-${parent_id}`).text(" ");
                        $(`.reply-comment-${parent_id}`).val(" ");
                        $("#comment-client").html(data);
                    }
                },
                error: function(xhr, ajaxOptions, throwError) {
                    alert(xhr.status);
                    alert(throwError);
                },
            });
        });
    </script>
@endif
