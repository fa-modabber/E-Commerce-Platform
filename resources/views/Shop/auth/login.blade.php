@extends('Store.layout.master')
@section('title', 'Login Page')

@section('script')
    <script type="text/javascript">
        document.addEventListener('alpine:init', () => {
            Alpine.data('loginForm', () => ({
                cellphone: '',
                otp: '',
                loginToken: '',
                error: '',
                loading: false,
                checkOtpForm: false,
                seconds: 5,
                minutes: 0,
                resendLoading: false,
                async login() {
                    this.loading = true;
                    const res = await fetch('{{ url('/login') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            '_token': '{{ csrf_token() }}',
                            'cellphone': this.cellphone
                        })
                    })

                    const data = await res.json();
                    this.loading = false;
                    if (res.ok) {
                        this.loginToken = data.login_token;
                        this.checkOtpForm = true;
                        this.timer();
                        this.error = '';
                    } else {
                        this.error = data.message;
                    }
                    console.log(data);
                },
                async check_otp() {
                    this.loading = true;
                    const res = await fetch('{{ url('/check-otp') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            '_token': '{{ csrf_token() }}',
                            'otp': this.otp,
                            'login_token': this.loginToken
                        })
                    })

                    const data = await res.json();
                    this.loading = false;
                    if (res.ok) {
                        this.checkOtpForm = true;
                        this.error = '';
                        document.location.href = "{{ route('home') }}";
                    } else {
                        this.error = data.message;
                    }
                    console.log(data);
                },
                timer() {
                    const interval = setInterval(() => {
                        // console.log(this.seconds);
                        if (this.seconds > 0) {
                            this.seconds = this.seconds - 1;
                        }

                        if (this.seconds === 0) {
                            if (this.minutes === 0) {
                                clearInterval(interval);
                            } else {
                                this.seconds = 59;
                                this.minutes = this.minutes - 1;
                            }
                        }
                    }, 1000);
                },
                async resend_otp() {
                    this.resendLoading = true;
                    const res = await fetch('{{ url('/resend-otp') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            '_token': '{{ csrf_token() }}',
                            'otp': this.otp,
                            'login_token': this.loginToken
                        })
                    })

                    const data = await res.json();
                    this.resendLoading = false;
                    if (res.ok) {
                        this.error = '';
                        this.loginToken = data.login_token;
                        this.seconds = 5;
                        this.minutes = 0;
                        this.timer();
                    } else {
                        this.error = data.message;
                    }
                    console.log(data);
                }

            }))
        });
    </script>
@endsection

@section('content')
    <section class="auth_section book_section">
        <div class="container">
            <div class="row mt-5">
                <div class="col-md-4 offset-md-4">
                    <div x-data="loginForm" class="card">
                        <div class="card-body">
                            <div class="form_container">
                                {{-- cellphone input --}}
                                <template id="cellphone-form" x-if="!checkOtpForm">
                                    <div>
                                        <div class="mb-3">
                                            <label class="form-label">شماره موبایل</label>
                                            <input type="text" x-model="cellphone" class="form-control mb-2" />
                                            <div class="form-text text-danger" x-text="error"></div>
                                        </div>
                                        <button @click="login()" type="button" class="btn btn-primary btn-auth">ورود
                                            <div x-show="loading" class="spinner-border spinner-border-sm ms-2"></div>
                                        </button>
                                    </div>

                                </template>

                                {{-- otp input --}}
                                <template id="otp-form" x-if="checkOtpForm">
                                    <div>
                                        <div class="mb-3">
                                            <label class="form-label">کد ورود</label>
                                            <input type="text" x-model="otp" class="form-control mb-2" />
                                            <div class="form-text text-danger" x-text="error"></div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <button @click="check_otp()" type="button"
                                                class="btn btn-primary btn-auth">ارسال
                                                <div x-show="loading" class="spinner-border spinner-border-sm ms-2"></div>
                                            </button>
                                            <template x-if="minutes > 0 || seconds > 0">
                                                <div class="mb-1 me-3">
                                                    <span x-text="seconds < 10 ? `0${seconds}` : seconds"></span>:
                                                    <span x-text="minutes < 10 ? `0${minutes}` : minutes"></span>
                                                </div>
                                            </template>

                                            <template x-if="minutes == 0 && seconds == 0">
                                                <button @click="resend_otp()" type="button"
                                                    class="btn btn-dark btn-dark">ارسال
                                                    دوباره
                                                    <div x-show="resendLoading"
                                                        class="spinner-border spinner-border-sm ms-2"></div>
                                                </button>
                                            </template>

                                        </div>
                                    </div>

                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
