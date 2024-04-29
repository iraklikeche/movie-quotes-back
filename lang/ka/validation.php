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

    'accepted' => ':attribute უნდა იყოს მიღებული.',
    'accepted_if' => ':attribute უნდა იყოს მიღებული, როდესაც :other არის :value.',
    'active_url' => ':attribute უნდა იყოს მართებული URL.',
    'after' => ':attribute უნდა იყოს თარიღი :date-ის შემდეგ.',
    'after_or_equal' => ':attribute უნდა იყოს თარიღი :date-ის შემდეგ ან ტოლი.',
    'alpha' => ':attribute უნდა შეიცავდეს მხოლოდ ასოებს.',
    'alpha_dash' => ':attribute უნდა შეიცავდეს მხოლოდ ასოებს, ციფრებს, ტირეებს და ქვედა ტირეებს.',
    'alpha_num' => ':attribute უნდა შეიცავდეს მხოლოდ ასოებსა და ციფრებს.',
    'array' => ':attribute უნდა იყოს მასივი.',
    'ascii' => ':attribute უნდა შეიცავდეს მხოლოდ ერთბაიტიანი ლათინური სიმბოლოები.',
    'before' => ':attribute უნდა იყოს თარიღი :date-მდე.',
    'before_or_equal' => ':attribute უნდა იყოს თარიღი :date-მდე ან ტოლი.',
    'between' => [
        'array' => ':attribute უნდა იყოს :min-დან :max-მდე ელემენტი.',
        'file' => ':attribute უნდა იყოს :min-დან :max-მდე კილობაიტი.',
        'numeric' => ':attribute უნდა იყოს :min-დან :max-მდე.',
        'string' => ':attribute უნდა იყოს :min-დან :max-მდე სიმბოლო.',
    ],
    'boolean' => ':attribute უნდა იყოს true ან false.',
    'can' => ':attribute შეიცავს არაავტორიზებულ ღირებულებას.',
    'confirmed' => ':attribute დადასტურება არ მეთხოვება.',
    'current_password' => 'პაროლი არასწორია.',
    'date' => ':attribute უნდა იყოს მართებული თარიღი.',
    'date_equals' => ':attribute უნდა იყოს თარიღი ტოლი :date.',
    'date_format' => ':attribute უნდა მოერგება ფორმატს :format.',
    'decimal' => ':attribute უნდა იყოს :decimal მთელი წევრი.',
    'declined' => ':attribute უნდა იყოს უარყოფილი.',
    'declined_if' => ':attribute უნდა იყოს უარყოფილი, როდესაც :other არის :value.',
    'different' => ':attribute და :other უნდა იყოს განსხვავებული.',
    'digits' => ':attribute უნდა იყოს :digits ციფრი.',
    'digits_between' => ':attribute უნდა იყოს :min-დან :max-მდე ციფრი.',
    'dimensions' => ':attribute აქვს არამართებული სურათის ზომები.',
    'distinct' => ':attribute აქვს დუპლიკატი ღირებულება.',
    'doesnt_end_with' => ':attribute არ უნდა დამთავრდეს შემდეგით: :values.',
    'doesnt_start_with' => ':attribute არ უნდა დაიწყოს შემდეგით: :values.',
    'email' => ':attribute უნდა იყოს მართებული ელფოსტის მისამართი.',
    'ends_with' => ':attribute უნდა დამთავრდეს ერთ-ერთით: :values.',
    'enum' => 'არჩეული :attribute არის არასწორი.',
    'exists' => 'არჩეული :attribute არის არასწორი.',
    'extensions' => ':attribute უნდა იყოს შემდეგი გაფართოებებით: :values.',
    'file' => ':attribute უნდა იყოს ფაილი.',
    'filled' => ':attribute უნდა შეიცავდეს ღირებულებას.',
    'gt' => [
        'array' => ':attribute უნდა იყოს მეტი, ვიდრე :value ელემენტი.',
        'file' => ':attribute უნდა იყოს მეტი, ვიდრე :value კილობაიტი.',
        'numeric' => ':attribute უნდა იყოს მეტი, ვიდრე :value.',
        'string' => ':attribute უნდა იყოს მეტი, ვიდრე :value სიმბოლო.',
    ],
    'gte' => [
        'array' => ':attribute უნდა იყოს :value ელემენტი ან მეტი.',
        'file' => ':attribute უნდა იყოს მეტი ან ტოლი :value კილობაიტი.',
        'numeric' => ':attribute უნდა იყოს მეტი ან ტოლი :value.',
        'string' => ':attribute უნდა იყოს მეტი ან ტოლი :value სიმბოლო.',
    ],
    'hex_color' => ':attribute უნდა იყოს მართებული შესაღები ფერის კოდი.',
    'image' => ':attribute უნდა იყოს სურათი.',
    'in' => 'არჩეული :attribute არის არასწორი.',
    'in_array' => ':attribute უნდა იყოს :other მასივში.',
    'integer' => ':attribute უნდა იყოს მთელი რიცხვი.',
    'ip' => ':attribute უნდა იყოს მართებული IP მისამართი.',
    'ipv4' => ':attribute უნდა იყოს მართებული IPv4 მისამართი.',
    'ipv6' => ':attribute უნდა იყოს მართებული IPv6 მისამართი.',
    'json' => ':attribute უნდა იყოს მართებული JSON სტრიქონი.',
    'list' => ':attribute უნდა იყოს სია.',
    'lowercase' => ':attribute უნდა იყოს პატარა ასოებით.',
    'lt' => [
        'array' => ':attribute უნდა იყოს ნაკლები, ვიდრე :value ელემენტი.',
        'file' => ':attribute უნდა იყოს ნაკლები, ვიდრე :value კილობაიტი.',
        'numeric' => ':attribute უნდა იყოს ნაკლები, ვიდრე :value.',
        'string' => ':attribute უნდა იყოს ნაკლები, ვიდრე :value სიმბოლო.',
    ],
    'lte' => [
        'array' => ':attribute არ უნდა იყოს მეტი, ვიდრე :value ელემენტი.',
        'file' => ':attribute უნდა იყოს ნაკლები ან ტოლი :value კილობაიტი.',
        'numeric' => ':attribute უნდა იყოს ნაკლები ან ტოლი :value.',
        'string' => ':attribute უნდა იყოს ნაკლები ან ტოლი :value სიმბოლო.',
    ],
    'mac_address' => ':attribute უნდა იყოს მართებული MAC მისამართი.',
    'max' => [
        'array' => ':attribute არ უნდა იყოს მეტი, ვიდრე :max ელემენტი.',
        'file' => ':attribute არ უნდა იყოს მეტი, ვიდრე :max კილობაიტი.',
        'numeric' => ':attribute არ უნდა იყოს მეტი, ვიდრე :max.',
        'string' => ':attribute არ უნდა იყოს მეტი, ვიდრე :max სიმბოლო.',
    ],
    'max_digits' => ':attribute არ უნდა იყოს მეტი, ვიდრე :max ციფრი.',
    'mimes' => ':attribute უნდა იყოს ფაილი ტიპით: :values.',
    'mimetypes' => ':attribute უნდა იყოს ფაილი ტიპით: :values.',
    'min' => [
        'array' => ':attribute უნდა იყოს მინიმუმ :min ელემენტი.',
        'file' => ':attribute უნდა იყოს მინიმუმ :min კილობაიტი.',
        'numeric' => ':attribute უნდა იყოს მინიმუმ :min.',
        'string' => ':attribute უნდა იყოს მინიმუმ :min სიმბოლო.',
    ],
    'min_digits' => ':attribute უნდა იყოს მინიმუმ :min ციფრი.',
    'missing' => ':attribute უნდა აკლდეს.',
    'missing_if' => ':attribute უნდა აკლდეს, როდესაც :other არის :value.',
    'missing_unless' => ':attribute უნდა აკლდეს, გარდა თუ :other არის :value.',
    'missing_with' => ':attribute უნდა აკლდეს, როდესაც :values არის მასივში.',
    'missing_with_all' => ':attribute უნდა აკლდეს, როდესაც :values არის მასივში.',
    'multiple_of' => ':attribute უნდა იყოს :value-ის ჯერადი.',
    'not_in' => 'არჩეული :attribute არის არასწორი.',
    'not_regex' => ':attribute ფორმატი არასწორია.',
    'numeric' => ':attribute უნდა იყოს რიცხვი.',
    'password' => [
        'letters' => ':attribute უნდა შეიცავდეს მინიმუმ ერთ ასოს.',
        'mixed' => ':attribute უნდა შეიცავდეს მინიმუმ ერთ დიდ და ერთ პატარა ასოს.',
        'numbers' => ':attribute უნდა შეიცავდეს მინიმუმ ერთ ციფრს.',
        'symbols' => ':attribute უნდა შეიცავდეს მინიმუმ ერთ სიმბოლოს.',
        'uncompromised' => 'მოცემული :attribute მოხვდა მონაცემთა გატაცებაში. გთხოვთ, აირჩიეთ სხვა :attribute.',
    ],
    'present' => ':attribute უნდა იყოს მყოფი.',
    'present_if' => ':attribute უნდა იყოს მყოფი, როდესაც :other არის :value.',
    'present_unless' => ':attribute უნდა იყოს მყოფი, გარდა თუ :other არის :value.',
    'present_with' => ':attribute უნდა იყოს მყოფი, როდესაც :values არის მასივში.',
    'present_with_all' => ':attribute უნდა იყოს მყოფი, როდესაც :values არის მასივში.',
    'prohibited' => ':attribute არის აკრძალული.',
    'prohibited_if' => ':attribute არის აკრძალული, როდესაც :other არის :value.',
    'prohibited_unless' => ':attribute არის აკრძალული, გარდა თუ :other არის :value.',
    'prohibits' => ':attribute აკრძალავს :other-ის ყოფნას.',
    'regex' => ':attribute ფორმატი არასწორია.',
    'required' => ':attribute არის საჭირო.',
    'required_array_keys' => ':attribute უნდა შეიცავდეს გასაღებებს: :values.',
    'required_if' => ':attribute არის საჭირო, როდესაც :other არის :value.',
    'required_if_accepted' => ':attribute არის საჭირო, როდესაც :other არის მიღებული.',
    'required_if_declined' => ':attribute არის საჭირო, როდესაც :other არის უარყოფილი.',
    'required_unless' => ':attribute არის საჭირო, გარდა თუ :other არის :values.',
    'required_with' => ':attribute არის საჭირო, როდესაც :values არის მასივში.',
    'required_with_all' => ':attribute არის საჭირო, როდესაც :values არის მასივში.',
    'required_without' => ':attribute არის საჭირო, როდესაც :values არაა მასივში.',
    'required_without_all' => ':attribute არის საჭირო, როდესაც :values არაა მასივში.',
    'same' => ':attribute და :other უნდა იყოს იგივე.',
    'size' => [
        'array' => ':attribute უნდა შეიცავდეს :size ელემენტს.',
        'file' => ':attribute უნდა იყოს :size კილობაიტი.',
        'numeric' => ':attribute უნდა იყოს :size.',
        'string' => ':attribute უნდა იყოს :size სიმბოლო.',
    ],
    'starts_with' => ':attribute უნდა იწყებოდეს ერთ-ერთით: :values.',
    'string' => ':attribute უნდა იყოს სტრიქონი.',
    'timezone' => ':attribute უნდა იყოს მართებული საათის ზონა.',
    'unique' => ':attribute უკვე არის აღებული.',
    'uploaded' => ':attribute არ აიტვირთა.',
    'uppercase' => ':attribute უნდა იყოს დიდი ასოებით.',
    'url' => ':attribute უნდა იყოს მართებული URL.',
    'ulid' => ':attribute უნდა იყოს მართებული ULID.',
    'uuid' => ':attribute უნდა იყოს მართებული UUID.',

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
