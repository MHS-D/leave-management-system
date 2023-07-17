<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */


    'accepted' => 'يجب قبول :attribute.',
    'accepted_if' => 'يجب قبول :attribute عندما :other يكون :value.',
    'active_url' => ' :attribute ليس عنوان URL صالحًا.',
    'after' => 'يجب أن يكون :attribute تاريخًا بعد :date.',
    'after_or_equal' => 'يجب أن يكون :attribute تاريخًا بعد أو يساوي :date.',
    'alpha' => 'يجب أن يحتوي :attribute على أحرف فقط.',
    'alpha_dash' => 'يجب أن يحتوي :attribute على أحرف وأرقام وشرطات وشرطات سفلية فقط.',
    'alpha_num' => 'يجب أن يحتوي :attribute على أحرف وأرقام فقط.',
    'array' => 'يجب أن يكون :attribute مصفوفة.',
    'before' => 'يجب أن يكون :attribute تاريخًا قبل :date.',
    'before_or_equal' => 'يجب أن يكون :attribute تاريخًا قبل أو يساوي :date.',
    'between' => [
    'array' => 'يجب أن يحتوي :attribute بين :min و :max عناصر.',
    'file' => 'يجب أن يكون حجم :attribute بين :min و :max كيلوبايت.',
    'numeric' => 'يجب أن يكون :attribute بين :min و :max.',
    'string' => 'يجب أن يكون طول :attribute بين :min و :max أحرف.',
    ],
    'boolean' => 'يجب أن يكون حقل :attribute صحيحًا أو خاطئًا.',
    'confirmed' => 'الحقل :attribute غير متطابق.',
    'current_password' => 'كلمة المرور غير صحيحة.',
    'date' => ' :attribute ليس تاريخًا صالحًا.',
    'date_equals' => 'يجب أن يكون :attribute تاريخًا يساوي :date.',
    'date_format' => 'لا يتطابق :attribute مع الشكل :format.',
    'declined' => 'يجب رفض :attribute.',
    'declined_if' => 'يجب رفض :attribute عندما :other يكون :value.',
    'different' => 'يجب أن يكون :attribute و :other مختلفين.',
    'digits' => 'يجب أن يحتوي :attribute على :digits أرقام.',
    'digits_between' => 'يجب أن يكون :attribute بين :min و :max أرقام.',
    'dimensions' => 'لديه :attribute أبعاد صورة غير صالحة.',
    'distinct' => 'للحقل :attribute قيمة مكررة.',
    'doesnt_end_with' => 'قد لا ينتهي :attribute بأحد ما يلي: :values.',
    'doesnt_start_with' => 'قد لا يبدأ :attribute بأحد ما يلي: :values.',
    'email' => 'يجب أن يكون :attribute عنوان بريد إلكتروني صالح.',
    'ends_with' => 'يجب أن ينتهي :attribute بأحد ما يلي: :values.',
    'enum' => 'القيمة المحددة :attribute غير صالحة.',
    'exists' => 'القيمة المحددة :attribute غير صالحة.',
    'file' => 'يجب أن يكون :attribute ملفًا.',
    'filled' => 'يجب أن يحتوي الحقل :attribute على قيمة.',
    'gt' => [
    'array' => 'يجب أن يحتوي :attribute على أكثر من :value عناصر.',
    'file' => 'يجب أن يكون حجم :attribute أكبر من :value كيلوبايت.',
    'numeric' => 'يجب أن يكون :attribute أكبر من :value.',
    'string' => 'يجب أن يكون طول :attribute أكبر من :value أحرف.',
    ],
    'gte' => [
    'array' => 'يجب أن يحتوي :attribute على :value عنصرًا أو أكثر.',
    'file' => 'يجب أن يكون حجم :attribute أكبر من أو يساوي :value كيلوبايت.',
    'numeric' => 'يجب أن يكون :attribute أكبر من أو يساوي :value.',
    'string' => 'يجب أن يكون طول :attribute أكبر من أو يساوي :value أحرف.',
    ],
    'image' => 'يجب أن يكون :attribute صورة.',
    'in' => 'القيمة المحددة :attribute غير صالحة.',
    'in_array' => 'حقل :attribute غير موجود في :other.',
    'integer' => 'يجب أن يكون :attribute عددًا صحيحًا.',
    'ip' => 'يجب أن يكون :attribute عنوان IP صالحًا.',
    'ipv4' => 'يجب أن يكون :attribute عنوان IPv4 صالحًا.',
    'ipv6' => 'يجب أن يكون :attribute عنوان IPv6 صالحًا.',
    'json' => 'يجب أن يكون :attribute سلسلة JSON صالحة.',
    'lowercase' => 'يجب أن يكون :attribute حروفًا صغيرة.',
    'lt' => [
    'array' => 'يجب أن يحتوي :attribute على أقل من :value عناصر.',
    'file' => 'يجب أن يكون حجم :attribute أقل من :value كيلوبايت.',
    'numeric' => 'يجب أن يكون :attribute أقل من :value.',
    'string' => 'يجب أن يكون طول :attribute أقل من :value أحرف.',
    ],
    'lte' => [
    'array' => 'يجب ألا يحتوي :attribute على أكثر من :value عنصر.',
    'file' => 'يجب أن يكون حجم :attribute أقل من أو يساوي :value كيلوبايت.',
    'numeric' => 'يجب أن يكون :attribute أقل من أو يساوي :value.',
    'string' => 'يجب أن يكون طول :attribute أقل من أو يساوي :value أحرف.',
    ],
    'mac_address' => 'يجب أن يكون :attribute عنوان MAC صالحًا.',
    'max' => [
    'array' => 'يجب ألا يحتوي :attribute على أكثر من :max عنصر.',
    'file' => 'يجب ألا يكون حجم :attribute أكبر من :max كيلوبايت.',
    'numeric' => 'يجب ألا يكون :attribute أكبر من :max.',
    'string' => 'يجب ألا يكون طول :attribute أكبر من :max أحرف.',
    ],
    'max_digits' => 'يجب ألا يحتوي :attribute على أكثر من :max أرقام.',
    'mimes' => 'يجب أن يكون :attribute ملفًا من النوع: :values.',
    'mimetypes' => 'يجب أن يكون :attribute ملفًا من النوع: :values.',
    'min' => [
    'array' => 'يجب أن يحتوي :attribute على الأقل على :min عنصر.',
    'file' => 'يجب أن يكون حجم :attribute على الأقل :min كيلوبايت.',
    'numeric' => 'يجب أن يكون :attribute على الأقل :min.',
    'string' => 'يجب أن يكون طول :attribute على الأقل :min أحرف.',
    ],
    'min_digits' => 'يجب أن يحتوي :attribute على الأقل على :min أرقام.',
    'multiple_of' => 'يجب أن يكون :attribute مضاعفًا لـ :value.',
    'not_in' => 'القيمة المحددة :attribute غير صالحة.',
    'not_regex' => 'تنسيق :attribute غير صالح.',
    'numeric' => 'يجب أن يكون :attribute رقمًا.',
    'password' => 'كلمة المرور غير صحيحة.',
    'present' => 'يجب أن يكون حقل :attribute موجودًا.',
    'regex' => 'تنسيق :attribute غير صالح.',
    'required' => 'حقل :attribute مطلوب.',
    'required_if' => 'حقل :attribute مطلوب عندما :other هو :value.',
    'required_unless' => 'حقل :attribute مطلوب ما لم :other يكون في :values.',
    'required_with' => 'حقل :attribute مطلوب عند وجود :values.',
    'required_with_all' => 'حقل :attribute مطلوب عند وجود :values.',
    'required_without' => 'حقل :attribute مطلوب عند عدم وجود :values.',
    'required_without_all' => 'حقل :attribute مطلوب عند عدم وجود أي من :values.',
    'same' => 'يجب أن يتطابق :attribute و :other.',
    'size' => [
    'array' => 'يجب أن يحتوي :attribute على :size عنصرًا.',
    'file' => 'يجب أن يكون حجم :attribute هو :size كيلوبايت.',
    'numeric' => 'يجب أن يكون :attribute هو :size.',
    'string' => 'يجب أن يكون طول :attribute هو :size أحرف.',
    ],
    'starts_with' => 'يجب أن يبدأ :attribute بأحد ما يلي: :values.',
    'string' => 'يجب أن يكون :attribute سلسلة نصية.',
    'timezone' => 'يجب أن يكون :attribute منطقة صحيحة.',
    'unique' => 'تم أخذ :attribute بالفعل.',
    'uploaded' => 'فشل تحميل :attribute.',
    'url' => 'تنسيق :attribute غير صالح.',
    'uuid' => 'يجب أن يكون :attribute UUID صالحًا.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
