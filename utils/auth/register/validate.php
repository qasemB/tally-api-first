<?php
    require('vendor/autoload.php');
    use Rakit\Validation\Validator;

    if (isset($_POST['auth_mode']) && $_POST['auth_mode'] == "mobile") {
        $mobileValidation = "|required";
        $emailValidation = "";
    }elseif(isset($_POST['auth_mode']) && $_POST['auth_mode'] == "email") {
        $mobileValidation = "";
        $emailValidation = "|required";
    }else{
        echo json_encode([
            'message' => 'نحوه اعتبارسنجی به درستی انتخاب نشده است',
            'success'=> false,
        ]);
        die;
    }

    $validator = new Validator;
    $validation = $validator->make($_POST, [
        'user_name'             => 'required|alpha_dash',
        'email'                 => "email$emailValidation",
        'password'              => 'required|min:8',
        'confirm_password'      => 'required|same:password',
        'first_name' => 'regex:/^[ابپتثجچهخدذرزسشصظطضعغفقک@-_.:گلمنوهیژئي\s0-9a-zA-Z]+$/ ',
        'last_name' => 'regex:/^[ابپتثجچهخدذرزسشصظطضعغفقک@-_.:گلمنوهیژئي\s0-9a-zA-Z]+$/',
        'mobile' => "numeric$mobileValidation",
        'gender' => 'numeric|max:2',
        'avatar' => 'uploaded_file:0,500K,png,jpeg',
    ],[
        'required' => 'این مورد اجباری است',
        'email:email' => 'الگوی ورودی ایمیل را بررسی کنید',
        'min' => 'حد اقل کارکتر ورودی 8 کارکتر',
        'max' => 'حد اکثر کارکتر ورودی 2 عدد',
        'same' => 'باید مشابه رمز عببور باشد',
        'alpha_dash' => 'فقط حروف لاتین و اعداد و خط تیره ',
        'regex' => 'الگوی ورودی صحیح نیست',
        'numeric' => 'فقط مجاز به ورود اعداد هستید',
        'uploaded_file' => 'فایل ورودی مجاز نیست'
    ]);

    $validation->validate();

    if ($validation->fails()) {
        $errors = $validation->errors();
        echo json_encode([
            'message' => $errors->firstOfAll(':message' , true),
            'success'=> false,
        ]);
        die;
    }