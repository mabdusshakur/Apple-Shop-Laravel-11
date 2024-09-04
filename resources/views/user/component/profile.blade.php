<div class="container-fluid">

    <div class="row">
        <div class="col-md-3 p-2">
            <label class="form-label">Customer Name</label>
            <input class="form-control form-control-sm" id="cus_name" type="text" />
        </div>

        <div class="col-md-3 p-2">
            <label class="form-label">Customer Address</label>
            <input class="form-control form-control-sm" id="cus_add" type="text" />
        </div>

        <div class="col-md-3 p-2">
            <label class="form-label">Customer City</label>
            <input class="form-control form-control-sm" id="cus_city" type="text" />
        </div>

        <div class="col-md-3 p-2">
            <label class="form-label">Customer State</label>
            <input class="form-control form-control-sm" id="cus_state" type="text" />
        </div>

        <div class="col-md-3 p-2">
            <label class="form-label">Customer Post Code</label>
            <input class="form-control form-control-sm" id="cus_postcode" type="text" />
        </div>

        <div class="col-md-3 p-2">
            <label class="form-label">Customer Country</label>
            <input class="form-control form-control-sm" id="cus_country" type="text" />
        </div>

        <div class="col-md-3 p-2">
            <label class="form-label">Customer Phone</label>
            <input class="form-control form-control-sm" id="cus_phone" type="text" />
        </div>

        <div class="col-md-3 p-2">
            <label class="form-label">Customer Fax</label>
            <input class="form-control form-control-sm" id="cus_fax" type="text" />
        </div>

    </div>

    <hr />

    <div class="row">

        <div class="col-md-3 p-2">
            <label class="form-label">Shipping Name</label>
            <input class="form-control form-control-sm" id="ship_name" type="text" />
        </div>

        <div class="col-md-3 p-2">
            <label class="form-label">Shipping Address</label>
            <input class="form-control form-control-sm" id="ship_add" type="text" />
        </div>

        <div class="col-md-3 p-2">
            <label class="form-label">Shipping City</label>
            <input class="form-control form-control-sm" id="ship_city" type="text" />
        </div>

        <div class="col-md-3 p-2">
            <label class="form-label">Shipping State</label>
            <input class="form-control form-control-sm" id="ship_state" type="text" />
        </div>

        <div class="col-md-3 p-2">
            <label class="form-label">Shipping Post Code</label>
            <input class="form-control form-control-sm" id="ship_postcode" type="text" />
        </div>

        <div class="col-md-3 p-2">
            <label class="form-label">Shipping Country</label>
            <input class="form-control form-control-sm" id="ship_country" type="text" />
        </div>

        <div class="col-md-3 p-2">
            <label class="form-label">Shipping Phone</label>
            <input class="form-control form-control-sm" id="ship_phone" type="text" />
        </div>

    </div>

    <hr />

    <div class="row">
        <div class="col-md-3">
            <button class="btn btn-danger" onclick="ProfileCreate()">Save Change</button>
        </div>
    </div>

</div>

<script>
    async function ProfileCreate() {

        let cus_name = document.getElementById('cus_name').value;
        let cus_add = document.getElementById('cus_add').value;
        let cus_city = document.getElementById('cus_city').value;
        let cus_state = document.getElementById('cus_state').value;
        let cus_postcode = document.getElementById('cus_postcode').value;
        let cus_phone = document.getElementById('cus_phone').value;
        let cus_country = document.getElementById('cus_country').value;
        let cus_fax = document.getElementById('cus_fax').value;
        let ship_name = document.getElementById('ship_name').value;
        let ship_add = document.getElementById('ship_add').value;
        let ship_city = document.getElementById('ship_city').value;
        let ship_state = document.getElementById('ship_state').value;
        let ship_postcode = document.getElementById('ship_postcode').value;
        let ship_country = document.getElementById('ship_country').value;
        let ship_phone = document.getElementById('ship_phone').value;

        let postBody = {
            "cus_name": cus_name,
            "cus_add": cus_add,
            "cus_city": cus_city,
            "cus_state": cus_state,
            "cus_postcode": cus_postcode,
            "cus_country": cus_country,
            "cus_phone": cus_phone,
            "cus_fax": cus_fax,
            "ship_name": ship_name,
            "ship_add": ship_add,
            "ship_city": ship_city,
            "ship_state": ship_state,
            "ship_postcode": ship_postcode,
            "ship_country": ship_country,
            "ship_phone": ship_phone
        }

        $(".preloader").delay(90).fadeIn(100).removeClass('loaded');
        let res = await axios.put("/api/user/profiles/0", postBody); // this 0 is explained on ProfileDetails() function, read there
        $(".preloader").delay(90).fadeOut(100).addClass('loaded');
        if (res.status === 200) {
            alert("Request Successful")
        } else {
            alert("Request Fail")
        }

    }

    async function ProfileDetails() {

        // passing 0 as id to get the current user profile, 
        // you can use any number here, i am using this to get the current user profile,
        // it does not matter what you pass here, it will return the current user profile
        // same for the update function

        let res = await axios.get("/api/user/profiles/0");
        res = res.data[0];
        if (res !== null) {
            document.getElementById('cus_name').value = res['cus_name']
            document.getElementById('cus_add').value = res['cus_add']
            document.getElementById('cus_city').value = res['cus_city']
            document.getElementById('cus_state').value = res['cus_state']
            document.getElementById('cus_postcode').value = res['cus_postcode']
            document.getElementById('cus_phone').value = res['cus_phone']
            document.getElementById('cus_country').value = res['cus_country']
            document.getElementById('cus_fax').value = res['cus_fax']
            document.getElementById('ship_name').value = res['ship_name']
            document.getElementById('ship_add').value = res['ship_add']
            document.getElementById('ship_city').value = res['ship_city']
            document.getElementById('ship_state').value = res['ship_state']
            document.getElementById('ship_postcode').value = res['ship_postcode']
            document.getElementById('ship_country').value = res['ship_country']
            document.getElementById('ship_phone').value = res['ship_phone']
        }
    }
</script>
