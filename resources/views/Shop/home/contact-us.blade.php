<section class="book-section layout-padding layout-margin">
    <div class="container">
        <div class="heading_container">
            <h2>
                تماس با ما
            </h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form_container">
                    <form action="{{ route('contact-us.store') }}" method="POST">
                        @csrf
                        <div>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                placeholder="نام و نام خانوادگی" />
                            <div class="form-text text-danger">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                placeholder="ایمیل" />
                            <div class="form-text text-danger">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div>
                            <input type="text" name="subject" class="form-control" value="{{ old('subject') }}"
                                placeholder="موضوع پیام" />
                            <div class="form-text text-danger">
                                @error('subject')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div>
                            <textarea rows="10" name="body" style="height: 100px" class="form-control" placeholder="متن پیام">
                              {{ old('body') }}
                            </textarea>
                            <div class="form-text text-danger">
                                @error('body')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="btn_box">
                            <button type="submit">
                                ارسال پیام
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="map_container ">
                    <div id="map" style="height: 345px;"></div>
                </div>
            </div>
        </div>
    </div>
</section>
