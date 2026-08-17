  @php
      $footer = App\Models\Footer::first();
  @endphp

  <footer class="footer_section">
      <div class="container">
          <div class="row">
              <div class="col-md-4 footer-col">
                  <div class="footer_contact">
                      <h4>
                          {{ $footer->col_1_title }}
                      </h4>
                      <div class="contact_link_box">
                          <a href="">
                              <div class="d-flex justify-content-center">
                                  <i class="bi bi-telephone-fill" aria-hidden="true"></i>
                                  <p class="my-0" style="direction: ltr;">
                                      {{ $footer->col_1_body_1 }}
                                  </p>
                              </div>
                          </a>
                          @if ($footer->col_1_body_2 !== null)
                              <a href="">
                                  <span>
                                      {{ $footer->col_1_body_2 }}
                                  </span>
                              </a>
                          @endif

                      </div>
                  </div>
              </div>
              <div class="col-md-4 footer-col">
                  <div class="footer_detail">
                      <a href="" class="footer-logo">
                          {{ $footer->col_2_title }}
                      </a>
                      <p> {{ $footer->col_2_body }} </p>

                       <div class="footer_social">
                        @if($footer->telegram_link !== null)
                        <a href="{{ $footer->telegram_link }}">
                            <i class="bi bi-telegram"></i>
                        </a>
                        @endif
                        @if($footer->whatsapp_link !== null)
                        <a href="{{ $footer->whatsapp_link }}">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        @endif
                        @if($footer->instagram_link !== null)
                        <a href="{{ $footer->instagram_link }}">
                            <i class="bi bi-instagram"></i>
                        </a>
                        @endif
                        @if($footer->youtube_link !== null)
                        <a href="{{ $footer->youtube_link }}">
                            <i class="bi bi-youtube"></i>
                        </a>
                        @endif
                    </div>
                  </div>
              </div>
              <div class="col-md-4 footer-col">
                  <h4>
                      {{ $footer->col_3_title }}
                  </h4>
                  <p>
                      {{ $footer->col_3_body }}
                  </p>
              </div>
          </div>
          <div class="footer-info">
              <p>
                  {{ $footer->copyright }}
              </p>
          </div>
      </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
      integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
      const Toast = Swal.mixin({
          toast: true,
          position: 'top-right',
          iconColor: 'white',
          customClass: {
              popup: 'colored-toast',
          },
          showConfirmButton: false,
          timer: 5000,
          timerProgressBar: true,
      })

      @if (session('success'))
          Toast.fire({
              icon: 'success',
              title: "{{ session('success') }}"
          })
      @elseif (session('error'))
          Toast.fire({
              icon: 'error',
              title: "{{ session('error') }}"
          })
      @elseif (session('warning'))
          Toast.fire({
              icon: 'warning',
              title: "{{ session('warning') }}"
          })
      @endif
  </script>
  @yield('script')
  </body>

  </html>
