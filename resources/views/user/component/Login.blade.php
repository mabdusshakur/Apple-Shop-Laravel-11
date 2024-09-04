<div class="login_register_wrap section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-10">
                <div class="login_wrap">
                    <div class="padding_eight_all bg-white">
                        <div class="heading_s1">
                            <h3>Login</h3>
                        </div>
                        <div class="form-group mb-3">
                            <input class="form-control" id="email" name="email" type="text" required="" placeholder="Your Email">
                        </div>
                        <div class="form-group mb-3">
                            <button class="btn btn-fill-out btn-block" name="login" type="submit" onclick="Login()">Next</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function Login() {
        let email = document.getElementById('email').value;
        if (email.length === 0) {
            alert("Email Required!");
        } else {
            $(".preloader").delay(90).fadeIn(100).removeClass('loaded');
            let res = await axios.post("/api/auth/login", {
                email: email
            });

            if (res.data.success === true) {
                sessionStorage.setItem('email', email);
                window.location.href = "{{ route('web.verify-otp') }}"
            } else {
                $(".preloader").delay(90).fadeOut(100).addClass('loaded');
                alert("Something Went Wrong");
            }
        }

    }
</script>
