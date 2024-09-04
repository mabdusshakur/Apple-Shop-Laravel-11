<div class="login_register_wrap section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-10">
                <div class="login_wrap">
                    <div class="padding_eight_all bg-white">
                        <div class="heading_s1">
                            <h3>Verification</h3>
                        </div>
                        <div class="form-group mb-3">
                            <input class="form-control" id="code" name="email" type="text" required="" placeholder="Verification Code">
                        </div>
                        <div class="form-group mb-3">
                            <button class="btn btn-fill-out btn-block" name="login" type="submit" onclick="verify()">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function verify() {

        let code = document.getElementById('code').value;
        let email = sessionStorage.getItem('email');
        if (code.length === 0) {
            alert("Code Required!");
        } else {

            $(".preloader").delay(90).fadeIn(100).removeClass('loaded');

            axios.post("/api/auth/verify-otp", {
                email: email,
                otp: code
            }).then(res => {
                if (res.data.success === true) {
                    setLoggedIn();
                    if (sessionStorage.getItem("last_location")) {
                        window.location.href = sessionStorage.getItem("last_location")
                    } else {
                        window.location.href = "{{ route('web.home') }}"
                    }
                } else {
                    $(".preloader").delay(90).fadeOut(100).addClass('loaded');
                    alert("Something Went Wrong");
                }
            }).catch(e => {
                $(".preloader").delay(90).fadeOut(100).addClass('loaded');
                alert(e.response.data.message);
            })
        }
    }
</script>
