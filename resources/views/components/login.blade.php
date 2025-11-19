<div id="loading">
    <div id="loading-center">
    </div>
</div>
<!-- loader END -->

<div class="wrapper">
    <section class="login-content">
        <div class="container h-100">
            <div class="row align-items-center justify-content-center h-100">
                <div class="col-md-5">
                    <div class="card p-3">
                        <div class="card-body">
                            <div class="auth-logo">
                                <img src="../assets/images/logo.png " class="img-fluid  rounded-normal  darkmode-logo"
                                    alt="logo">
                                <img src="../assets/images/logo-dark.png" class="img-fluid rounded-normal light-logo"
                                    alt="logo">
                            </div>
                            <h3 class="mb-3 font-weight-bold text-center">Sign In</h3>
                            <p class="text-center text-secondary mb-4">Log in to your account to continue</p>
                            <form>
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="text-secondary">Email</label>
                                            <input class="form-control" name="email" type="email" placeholder="Enter Email">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mt-2">
                                        <div class="form-group">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <label class="text-secondary">Password</label>
                                                {{-- <label><a href="auth-recover-pwd.html">Forgot Password?</a></label> --}}
                                            </div>
                                            <input class="form-control" name="password" type="password" placeholder="Enter Password">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="loginButton btn btn-primary btn-block mt-2">Log In</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="{{ asset('resources/js/login.js') }}"></script>
