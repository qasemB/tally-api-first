<?php
    require('vendor/autoload.php');
    use Rakit\Validation\Validator;

    if (isset($_POST['mobile'])) {
        $authMode = "mobile";
        $authModeValidate = "required|numeric";
    }elseif(isset($_POST['email'])){
        $authMode = "email";
        $authModeValidate = "required|email";  
    }else{
        echo json_encode([
            'message' => 'ایمیل یا موبایل به درستی وارد نشده است',
            'success'=> false,
        ]);
        die;
    }

    $validator = new Validator;
    $validation = $validator->make($_POST, [
        $authMode               => $authModeValidate,
        'password'              => 'required|min:8'
    ],[
        'required' => 'این مورد اجباری است',
        'email:email' => 'الگوی ورودی ایمیل را بررسی کنید',
        'min' => 'حد اقل کارکتر ورودی 8 کارکتر',
        'regex' => 'الگوی ورودی صحیح نیست',
        'numeric' => 'فقط مجاز به ورود اعداد هستید'
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