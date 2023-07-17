<?php

return [
    // response messages
    'LOGIN' => 'تم تسجيل الدخول بنجاح',
    'LOGIN_FAILED' => 'البيانات المدخلة غير صحيحة',
    'REGISTER' => 'تم تسجيل الحساب بنجاح',
    'USER_CREATED_SUCCESSFULLY' => 'تم إنشاء المستخدم بنجاح',
    'USER_UPDATED_SUCCESSFULLY' => 'تم تحديث المستخدم بنجاح',
    'USER_DELETED_SUCCESSFULLY' => 'تم حذف المستخدم بنجاح',
    'SETTINGS_UPDATED_SUCCESSFULLY' => 'تم تحديث الإعدادات بنجاح',
    'USER_NOT_FOUND' => 'المستخدم غير موجود',
    'ACCOUNT_NOT_ACTIVE' => 'الحساب غير مفعل',
    'LANGUAGE_CHANGED_SUCCESSFULLY' => 'تم تغيير اللغة بنجاح',


    // Constants
    'ID' => 'الرقم التسلسلي',
    'LOGIN_TITLE' => 'تسجيل الدخول',
    'REGISTER_TITLE' => 'تسجيل حساب جديد',
    'LOGIN_WELCOME_MESSAGE' => 'مرحبا بك في لوحة التحكم 👋',
    'REMEMBER_ME' => ' تذكرني',
    'LOGIN_BUTTON' => 'تسجيل الدخول',
    'PASSWORD' => 'كلمة المرور',
    'EMAIL' => 'البريد الإلكتروني',
    'EMAIL_PLACEHOLDER' => 'john@example.com',
    'EMAIL_OR_USERNAME' => 'البريد الإلكتروني أو اسم المستخدم',
    'USERNMAE' => 'اسم المستخدم',
    'WELCOME_BACK' => 'مرحبا بعودتك! 👋',
    'WEBSITE_TITLE' => 'نظام إدارة المشاريع',
    'LATEST_STATUS_DATE' => 'تاريخ-آخر-تحديث',
    'CHOOSE_DEPARTMENT' => 'اختر-القسم',
    'SOMETHING_WENT_WRONG' => 'حدث خطأ ما',
    'DEPARTMENT' => 'القسم',
    'ADDITIONAL_INFORMATION' => 'معلومات إضافية',
    'LANGUAGE' => 'اللغة',
    'ENGLISH' => 'الإنجليزية',
    'ARABIC' => 'العربية',

    //SideBar
    'TITLE' => 'لوحة التحكم',
    'DASHBOARD' => 'الرئيسية',
    'USERS' => 'المستخدمين',
    'SETTINGS' => 'الإعدادات',
    'LOGOUT' => 'تسجيل الخروج',

    // Users roles
    config('settings.roles.names.adminRole') => 'مدير',
    config('settings.roles.names.department1Role') => 'قسم العقود',
    config('settings.roles.names.department2Role') => ' لجنة تحليل والتدقيق 1',
    config('settings.roles.names.department3Role') => 'لجنة تحليل والتدقيق 2',
    config('settings.roles.names.department4Role') => 'لجنة تحليل والتدقيق 3',
    config('settings.roles.names.department5Role') => 'لجنة العقود المركزية',
    config('settings.roles.names.department6Role') => ' قسم العقود المركزية',
    config('settings.roles.names.subAdminRole') => 'مسؤول النظام',


    // STATUS
    'ACTIVE' => ' مفعل ',
    'UNACTIVE' => 'غير مفعل',

    //Dashboard
    'ACTIVE_USERS' => 'المستخدمين المفعلين',
    'UNACTIVE_USERS' => 'المستخدمين غير المفعلين',
    'USERS_TOTAL' => 'إجمالي المستخدمين',
    'ADD_USER' => 'إضافة مستخدم',
    'UPDATE_USER' => 'تحديث مستخدم',
    'ACTIVE_PROJECTS' => 'المشاريع المفعلة',
    'UNACTIVE_PROJECTS' => 'المشاريع غير المفعلة',
    'PROJECTS' => 'المشاريع',
    'PROJECT_DONE' => 'المشاريع المنتهية',
    'PROJECT_IN_CREATED_CASE' => 'المشاريع في مرحلة الإنشاء',
    'PROJECT_IN_CAS1' => 'المشاريع في مرحلة 2',
    'PROJECT_IN_CAS2' => 'المشاريع في مرحلة 3',
    'PROJECT_IN_CAS3' => 'المشاريع في مرحلة 4',
    'PROJECT_IN_CAS4' => 'المشاريع في مرحلة 5',
    'PROJECTS_IN_DEPARTMENT2' => 'المشاريع في لجنة تحليل والتدقيق 1',
    'PROJECTS_IN_DEPARTMENT3' => 'المشاريع في لجنة تحليل والتدقيق 2',
    'PROJECTS_IN_DEPARTMENT4' => 'المشاريع في لجنة تحليل والتدقيق 3',
    'NUMBER_OF_PROJECT_POSITIONS' => 'اعداد حسب موقف المشروع',
    'NUMBER_OF_ASSIGNMENTS_BOOK' => 'عدد كتب الاحالة',
    'NUMBER_OF_ASSIGNMENTS_BOOK_DATE' => 'عدد كتب الاحالة المسلمة',
    'NUMBER_OF_CONTRACTS' => 'عدد العقود',
    'NUMBER_OF_SIGNINGS_RECEIVED' => 'عدد استلام الموقع',
    'NUMBER_OF_WORK_STARTED' => 'عدد المباشرة بالعمل',
    'NUMBER_OF_ASSIGNMENTS_BOOK_SUBMITED_DATE' => 'عدد تسليم كتب الاحالة',





    // Buttons
    'CREATE' => 'إنشاء',
    'EDIT' => 'تعديل',
    'DELETE' => 'حذف',
    'SAVE' => 'حفظ',
    'CANCEL' => 'إلغاء',

    // user inputs
    'FIRST_NAME' => 'الاسم الأول',
    'LAST_NAME' => 'الاسم الأخير',
    'USERNAME' => 'اسم المستخدم',
    'EMAIL' => 'البريد الإلكتروني',
    'PASSWORD' => 'كلمة المرور',
    'PASSWORD_CONFIRMATION' => 'تأكيد كلمة المرور',
    'PHONE' => 'رقم الهاتف',
    'STATUS' => 'الحالة',
    'ROLE' => 'المنصب',
    'PERMISSIONS' => 'الصلاحيات',
    'SELECT_ROLE' => 'اختر المنصب',

    // Projects
    'PROJECTS' => 'المشاريع',
    'PROJECT' => 'المشروع',
    'ADD_PROJECT' => 'إضافة مشروع',
    'UPDATE_PROJECT' => 'تحديث مشروع',
    'PROJECT_CREATED_SUCCESSFULLY' => 'تم إنشاء المشروع بنجاح',
    'PROJECT_UPDATED_SUCCESSFULLY' => 'تم تحديث المشروع بنجاح',
    'PROJECT_DELETED_SUCCESSFULLY' => 'تم حذف المشروع بنجاح',
    'PROJECT_DAYS_NUMBER' => 'عدد-أيام-المشروع',
    'PROCCESSES' => 'المراحل',
    'ADDITIONAL_INFO_MISSING' => 'المعلومات الإضافية ناقصة الرجاء تعبئة جميع الحقول و المحاولة مرة أخرى',

    // Project inputs
    'PROJECT_NAME' => 'اسم-المشروع',
    'COMPANY' => 'الشركة-التي-تحول-اليها-المشروع',
    'NUMBER_OF_BOOK' => 'عدد-كتاب-اصدار',
    'DATE_OF_BOOK' => 'تاريخ-كتاب-اصدار',
    'STATUS' => 'الحالة',
    'PROCESS' => 'المرحلة',
    'PROJECT_CREATED_DATE' => 'تاريخ-القيد',
    'NOTE' => 'ملاحظة',
    'STATUS_DATE' => 'تاريخ-الحالة',
    'BUDGET' => 'الكلفة',
    'INVITATION_DATE' => 'تاريخ استلام الدعوة',
    'PROJECT_POSITION' => 'موقف المشروع',
    'ASSIGNMENT_BOOK_NUMBER' => 'رقم كتاب الاحالة',
    'ASSIGNMENT_BOOK_DATE' => 'تاريخ كتاب الاحالة',
    'ASSIGNMENT_BOOK_SUBMITION_DATE' => 'تاريخ تسليم كتاب الاحالة',
    'CONTRACT_BOOK_NUMBER' => 'رقم كتاب العقد',
    'CONTRACT_BOOK_DATE' => 'تاريخ كتاب العقد',
    'SIGNATURE_RECEIPT_DATE' => 'تاريخ استلام الموقع',
    'WORK_STARTING_DATE' => 'تاريخ المباشرة بالعمل',



    // project status
    'CREATED' => 'تم الإنشاء',
    'ONE_INPROGRESS' => 'مرحلة 2 قيد الإنجاز',
    'ONE_DONE' => 'مرحلة 2 تم الإنجاز',
    'TWO_INPROGRESS' => 'مرحلة 3 قيد الإنجاز',
    'TWO_DONE' => 'مرحلة 3 تم الإنجاز',
    'THREE_INPROGRESS' => 'مرحلة 4 قيد الإنجاز',
    'THREE_DONE' => 'مرحلة 4 تم الإنجاز',
    'FOUR_INPROGRESS' => 'مرحلة 5 قيد الإنجاز',
    'FOUR_DONE' => ' تم إنجاز المشروع',

];
